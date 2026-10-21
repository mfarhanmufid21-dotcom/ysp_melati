<?php

namespace App\Controllers\Admin;

use App\Models\BarangModel;
use App\Models\PelangganModel;
use App\Models\TransaksiModel;
use App\Models\DetailTransaksiModel;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    public function index()
    {
        // 🔒 Proteksi admin
        if (session()->get('role') != 'admin') {
            return redirect()->to('/login');
        }

        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        try {
            $barangModel = new BarangModel();
            $pelangganModel = new PelangganModel();
            $transaksiModel = new TransaksiModel();
            $detailModel = new DetailTransaksiModel();

            // ===== Cek struktur tabel barang =====
            // CARA YANG BENAR untuk getFieldNames()
            $db = \Config\Database::connect();
            $fields = $db->getFieldNames('barang'); // Perhatikan: pakai $db, bukan model
            
            $hasHargaJual = in_array('harga_jual', $fields);
            $hasHargaBeli = in_array('harga_beli', $fields);
            $hasStok = in_array('stok', $fields);
            $hasNamaBarang = in_array('nama_barang', $fields);

            // ===== DATA STATISTIK DASAR =====
            $totalBarang = $barangModel->countAll();
            $totalPelanggan = $pelangganModel->countAll();
            $totalTransaksi = $transaksiModel->countAll();
            
            $detailResult = $detailModel->selectSum('jumlah')->get()->getRow();
            $totalDetail = $detailResult ? $detailResult->jumlah : 0;

            // ===== STOK =====
            $totalStokTersedia = 0;
            $stokRendah = [];
            
            if ($hasStok) {
                $stokResult = $barangModel->selectSum('stok')->get()->getRow();
                $totalStokTersedia = $stokResult ? $stokResult->stok : 0;
                $stokRendah = $barangModel->where('stok <', 10)->findAll();
            }

            // ===== GRAFIK PENDAPATAN BULANAN =====
            $grafik = [];
            $bulanIni = date('m');
            $tahunIni = date('Y');

            for ($i = 1; $i <= 12; $i++) {
                $total = $transaksiModel
                    ->selectSum('total_akhir')
                    ->where('MONTH(tanggal)', $i)
                    ->where('YEAR(tanggal)', $tahunIni)
                    ->first();

                $grafik[] = $total['total_akhir'] ?? 0;
            }

            // ===== PENJUALAN HARIAN (7 HARI TERAKHIR) =====
            $penjualanHarian = [];
            $labelsHarian = [];
            for ($i = 6; $i >= 0; $i--) {
                $tanggal = date('Y-m-d', strtotime("-$i days"));
                $labelsHarian[] = date('d M', strtotime($tanggal));
                
                $total = $transaksiModel
                    ->selectSum('total_akhir')
                    ->where('DATE(tanggal)', $tanggal)
                    ->first();
                
                $penjualanHarian[] = $total['total_akhir'] ?? 0;
            }

            // ===== PENJUALAN BULANAN (6 BULAN TERAKHIR) =====
            $penjualanBulanan = [];
            $labelsBulanan = [];
            for ($i = 5; $i >= 0; $i--) {
                $bulan = date('m', strtotime("-$i months"));
                $tahun = date('Y', strtotime("-$i months"));
                $labelsBulanan[] = date('M Y', strtotime("-$i months"));
                
                $total = $transaksiModel
                    ->selectSum('total_akhir')
                    ->where('MONTH(tanggal)', $bulan)
                    ->where('YEAR(tanggal)', $tahun)
                    ->first();
                
                $penjualanBulanan[] = $total['total_akhir'] ?? 0;
            }

          // ===== PRODUK TERLARIS (TOP 5) =====
$produkTerlaris = [];

try {
    // Cek dulu status apa yang ada di database
    $statusList = $transaksiModel->select('status')->distinct()->findAll();
    // echo '<pre>'; print_r($statusList); die(); // Uncomment untuk debug
    
    // Query produk terlaris (tanpa filter status dulu untuk testing)
    $produkTerlaris = $detailModel
        ->select('barang.id, barang.nama_barang, barang.harga, barang.harga_diskon, barang.is_promo, SUM(detail_transaksi.jumlah) as total_terjual')
        ->join('barang', 'barang.id = detail_transaksi.barang_id')
        ->join('transaksi', 'transaksi.id = detail_transaksi.transaksi_id')
        // Hapus filter status dulu untuk testing
        // ->where('transaksi.status', 'success')
        ->groupBy('barang.id')
        ->orderBy('total_terjual', 'DESC')
        ->limit(5)
        ->find();
    
    // Hitung harga_jual
    foreach ($produkTerlaris as &$p) {
        if (!empty($p['is_promo']) && !empty($p['harga_diskon']) && $p['harga_diskon'] > 0) {
            $p['harga_jual'] = $p['harga_diskon'];
        } else {
            $p['harga_jual'] = $p['harga'] ?? 0;
        }
    }
    
} catch (\Exception $e) {
    $produkTerlaris = [];
}

$data['produkTerlaris'] = $produkTerlaris;

            // ===== LABA BULANAN =====
            $labaBulanan = [];
            $labelsLaba = [];
            $pendapatanBulanIni = 0;
            $transaksiBulanIni = 0;
            $labaBulanIni = 0;

            try {
                for ($i = 5; $i >= 0; $i--) {
                    $bulan = date('m', strtotime("-$i months"));
                    $tahun = date('Y', strtotime("-$i months"));
                    $labelsLaba[] = date('M Y', strtotime("-$i months"));
                    
                    // Total pendapatan
                    $pendapatan = $transaksiModel
                        ->selectSum('total_akhir')
                        ->where('MONTH(tanggal)', $bulan)
                        ->where('YEAR(tanggal)', $tahun)
                        ->first();
                    
                    $totalPendapatan = $pendapatan['total_akhir'] ?? 0;
                    
                    // Hitung laba
                    if ($hasHargaBeli) {
                        // Total modal
                        $modal = $detailModel
                            ->select('SUM(detail_transaksi.jumlah * barang.harga_beli) as total_modal')
                            ->join('barang', 'barang.id = detail_transaksi.barang_id')
                            ->join('transaksi', 'transaksi.id = detail_transaksi.transaksi_id')
                            ->where('MONTH(transaksi.tanggal)', $bulan)
                            ->where('YEAR(transaksi.tanggal)', $tahun)
                            ->first();
                        
                        $totalModal = $modal['total_modal'] ?? 0;
                        $labaBulanan[] = $totalPendapatan - $totalModal;
                    } else {
                        // Asumsi laba 30% dari pendapatan
                        $labaBulanan[] = $totalPendapatan * 0.3;
                    }
                }

                // Laba bulan ini
                $pendapatanBulanIni = $transaksiModel
                    ->selectSum('total_akhir')
                    ->where('MONTH(tanggal)', $bulanIni)
                    ->where('YEAR(tanggal)', $tahunIni)
                    ->first();
                
                $pendapatanBulanIni = $pendapatanBulanIni['total_akhir'] ?? 0;
                
                $transaksiBulanIni = $transaksiModel
                    ->where('MONTH(tanggal)', $bulanIni)
                    ->where('YEAR(tanggal)', $tahunIni)
                    ->countAllResults();
                
                if ($hasHargaBeli) {
                    $modalBulanIni = $detailModel
                        ->select('SUM(detail_transaksi.jumlah * barang.harga_beli) as total_modal')
                        ->join('barang', 'barang.id = detail_transaksi.barang_id')
                        ->join('transaksi', 'transaksi.id = detail_transaksi.transaksi_id')
                        ->where('MONTH(transaksi.tanggal)', $bulanIni)
                        ->where('YEAR(transaksi.tanggal)', $tahunIni)
                        ->first();
                    
                    $totalModalBulanIni = $modalBulanIni['total_modal'] ?? 0;
                    $labaBulanIni = $pendapatanBulanIni - $totalModalBulanIni;
                } else {
                    $labaBulanIni = $pendapatanBulanIni * 0.3;
                }

            } catch (\Exception $e) {
                $labaBulanan = array_fill(0, 6, 0);
                $labelsLaba = ['B-5', 'B-4', 'B-3', 'B-2', 'B-1', 'Bulan Ini'];
                $labaBulanIni = 0;
            }

            // ===== PREPARE DATA =====
            $data = [
                // Statistik utama
                'totalBarang'       => $totalBarang,
                'totalPelanggan'    => $totalPelanggan,
                'totalTransaksi'    => $totalTransaksi,
                'totalDetail'       => $totalDetail,
                
                // Grafik pendapatan
                'grafikData'        => json_encode($grafik),
                
                // Penjualan harian
                'penjualanHarian'   => json_encode($penjualanHarian),
                'labelsHarian'      => json_encode($labelsHarian),
                
                // Penjualan bulanan
                'penjualanBulanan'  => json_encode($penjualanBulanan),
                'labelsBulanan'     => json_encode($labelsBulanan),
                
                // Stok
                'totalStokTersedia' => $totalStokTersedia,
                'stokRendah'        => $stokRendah,
                
                // Produk terlaris
                'produkTerlaris'    => $produkTerlaris,
                
                // Laba
                'labaBulanan'       => json_encode($labaBulanan),
                'labelsLaba'        => json_encode($labelsLaba),
                'labaBulanIni'      => $labaBulanIni,
                'transaksiBulanIni' => $transaksiBulanIni,
                'pendapatanBulanIni'=> $pendapatanBulanIni,
            ];

            return view('Admin/dashboard/index', $data);

        } catch (\Exception $e) {
            echo "Error: " . $e->getMessage() . "<br>";
            echo "File: " . $e->getFile() . "<br>";
            echo "Line: " . $e->getLine() . "<br>";
            echo "<pre>";
            print_r($e->getTrace());
            echo "</pre>";
            die();
        }
    }
}