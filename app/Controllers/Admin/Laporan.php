<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\TransaksiModel;
use App\Models\DetailTransaksiModel;  
use App\Models\BarangModel;
use App\Models\PelangganModel;
use Dompdf\Dompdf;
use Dompdf\Options;

class Laporan extends BaseController
{
    protected $transaksiModel;
    protected $detailModel;
    protected $barangModel;
    protected $pelangganModel;

    public function __construct()
    {
        $this->transaksiModel = new TransaksiModel();
        $this->detailModel = new DetailTransaksiModel();  
        $this->barangModel = new BarangModel();
        $this->pelangganModel = new PelangganModel();
    }

    public function index()
    {
        if (!session()->get('id_user')) {
            return redirect()->to('/login');
        }
        
        $data['title'] = 'Laporan Penjualan';
        
        $start_date = $this->request->getGet('start_date');
        $end_date = $this->request->getGet('end_date');

        $db = \Config\Database::connect();
        
        // Total Transaksi
        $builderT = $db->table('transaksi');
        if (!empty($start_date) && !empty($end_date)) {
            $builderT->where("DATE(tanggal) >= '{$start_date}' AND DATE(tanggal) <= '{$end_date}'");
        } elseif (!empty($start_date)) {
            $builderT->where("DATE(tanggal) >= '{$start_date}'");
        } elseif (!empty($end_date)) {
            $builderT->where("DATE(tanggal) <= '{$end_date}'");
        }
        $data['total_transaksi'] = $builderT->countAllResults();
        
        // Total Pendapatan
        $builderP = $db->table('transaksi');
        $builderP->selectSum('total_akhir');
        if (!empty($start_date) && !empty($end_date)) {
            $builderP->where("DATE(tanggal) >= '{$start_date}' AND DATE(tanggal) <= '{$end_date}'");
        } elseif (!empty($start_date)) {
            $builderP->where("DATE(tanggal) >= '{$start_date}'");
        } elseif (!empty($end_date)) {
            $builderP->where("DATE(tanggal) <= '{$end_date}'");
        }
        $result = $builderP->get()->getRow();
        $data['total_pendapatan'] = $result->total_akhir ?? 0;
        
        // Total Pelanggan
        $data['total_pelanggan'] = $db->table('pelanggan')->countAllResults();
        
        // Produk Terlaris
        $builderProduk = $db->table('detail_transaksi');
        $builderProduk->select('barang.nama_barang, SUM(detail_transaksi.jumlah) as total_terjual, SUM(detail_transaksi.subtotal) as total_pendapatan')
                      ->join('barang', 'barang.id = detail_transaksi.barang_id')
                      ->join('transaksi', 'transaksi.id = detail_transaksi.transaksi_id');
        
        if (!empty($start_date) && !empty($end_date)) {
            $builderProduk->where("DATE(transaksi.tanggal) >= '{$start_date}' AND DATE(transaksi.tanggal) <= '{$end_date}'");
        } elseif (!empty($start_date)) {
            $builderProduk->where("DATE(transaksi.tanggal) >= '{$start_date}'");
        } elseif (!empty($end_date)) {
            $builderProduk->where("DATE(transaksi.tanggal) <= '{$end_date}'");
        }
        
        $data['produk_terlaris'] = $builderProduk->groupBy('barang.id')
                                                 ->orderBy('total_terjual', 'DESC')
                                                 ->limit(5)
                                                 ->get()->getResultArray();
        
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        
        return view('Admin/laporan/index', $data);
    }

    public function transaksi()
    {
        if (!session()->get('id_user')) {
            return redirect()->to('/login');
        }
        
        $data['title'] = 'Laporan Transaksi';
        
        $start_date = $this->request->getGet('start_date');
        $end_date = $this->request->getGet('end_date');
        
        $builder = $this->transaksiModel->select('transaksi.*, pelanggan.nama as nama_pelanggan')
            ->join('pelanggan', 'pelanggan.id = transaksi.pelanggan_id', 'left');
        
        if (!empty($start_date) && !empty($end_date)) {
            $builder->where('DATE(tanggal) >=', $start_date)
                    ->where('DATE(tanggal) <=', $end_date);
        } elseif (!empty($start_date)) {
            $builder->where('DATE(tanggal) >=', $start_date);
        } elseif (!empty($end_date)) {
            $builder->where('DATE(tanggal) <=', $end_date);
        }
        
        $perPage = 20;
        $currentPage = $this->request->getGet('page') ?? 1;
        $total = $builder->countAllResults(false);
        
        $data['transaksi'] = $builder->orderBy('tanggal', 'DESC')
                                     ->paginate($perPage, 'default', $currentPage);
        
        $data['pager'] = \Config\Services::pager();
        $data['perPage'] = $perPage;
        $data['totalTransaksi'] = $total;
        
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        
        return view('Admin/laporan/transaksi', $data);
    }

    public function barang()
    {
        if (!session()->get('id_user')) {
            return redirect()->to('/login');
        }
        
        $data['title'] = 'Laporan Stok Barang';
        $data['barang'] = $this->barangModel->orderBy('stok', 'ASC')->findAll();
        $data['stok_habis'] = $this->barangModel->where('stok <=', 0)->countAllResults();
        $data['stok_menipis'] = $this->barangModel->where('stok >', 0)->where('stok <=', 10)->countAllResults();
        $data['total_barang'] = $this->barangModel->countAllResults();
        
        return view('Admin/laporan/barang', $data);
    }

    public function cetakpdf_penjualan()
{
    if (!session()->get('id_user')) {
        return redirect()->to('/login');
    }

    $start_date = $this->request->getGet('start_date');
    $end_date   = $this->request->getGet('end_date');

    $db = \Config\Database::connect();

    // ==========================
    // Total Transaksi
    // ==========================
    $builderT = $db->table('transaksi');

    if (!empty($start_date)) {
        $builderT->where('DATE(tanggal) >=', $start_date);
    }

    if (!empty($end_date)) {
        $builderT->where('DATE(tanggal) <=', $end_date);
    }

    $data['total_transaksi'] = $builderT->countAllResults();

    // ==========================
    // Total Pendapatan
    // ==========================
    $builderP = $db->table('transaksi');
    $builderP->selectSum('total_akhir');

    if (!empty($start_date)) {
        $builderP->where('DATE(tanggal) >=', $start_date);
    }

    if (!empty($end_date)) {
        $builderP->where('DATE(tanggal) <=', $end_date);
    }

    $pendapatan = $builderP->get()->getRow();

    $data['total_pendapatan'] = $pendapatan->total_akhir ?? 0;

    // ==========================
    // Total Pelanggan
    // ==========================
    $data['total_pelanggan'] = $db->table('pelanggan')->countAllResults();

    // ==========================
    // Produk Terlaris
    // ==========================
    $builder = $db->table('detail_transaksi');

    $builder->select("
        barang.nama_barang,
        SUM(detail_transaksi.jumlah) as total_terjual,
        SUM(detail_transaksi.subtotal) as total_pendapatan
    ");

    $builder->join(
        'barang',
        'barang.id = detail_transaksi.barang_id'
    );

    $builder->join(
        'transaksi',
        'transaksi.id = detail_transaksi.transaksi_id'
    );

    if (!empty($start_date)) {
        $builder->where('DATE(transaksi.tanggal) >=', $start_date);
    }

    if (!empty($end_date)) {
        $builder->where('DATE(transaksi.tanggal) <=', $end_date);
    }

    $data['produk_terlaris'] = $builder
        ->groupBy('barang.id')
        ->orderBy('total_terjual', 'DESC')
        ->get()
        ->getResultArray();

    // ==========================
    // Rata-rata item per transaksi
    // ==========================
    $builderI = $db->table('detail_transaksi');
    $builderI->selectSum('detail_transaksi.jumlah', 'total_item');
    $builderI->join('transaksi', 'transaksi.id = detail_transaksi.transaksi_id');

    if (!empty($start_date)) {
        $builderI->where('DATE(transaksi.tanggal) >=', $start_date);
    }

    if (!empty($end_date)) {
        $builderI->where('DATE(transaksi.tanggal) <=', $end_date);
    }

    $totalItem = (float) ($builderI->get()->getRow()->total_item ?? 0);
    $data['rata_rata_item'] = $data['total_transaksi'] > 0
        ? $totalItem / $data['total_transaksi']
        : 0;

    $data['start_date'] = $start_date;
    $data['end_date']   = $end_date;

    // ==========================
    // DOMPDF
    // ==========================
    $options = new Options();
    $options->setIsRemoteEnabled(true);

    $dompdf = new Dompdf($options);

    $html = view('Admin/laporan/cetakpdf_penjualan', $data);

    $dompdf->loadHtml($html);

    $dompdf->setPaper('A4', 'portrait');

    $dompdf->render();

    $dompdf->stream(
        'Laporan_Penjualan_' . date('Ymd_His') . '.pdf',
        [
            'Attachment' => false
        ]
    );

    exit;
}

    public function cetakpdf_barang()
    {
        if (!session()->get('id_user')) {
            return redirect()->to('/login');
        }

        $data['barang']       = $this->barangModel->orderBy('stok', 'ASC')->findAll();
        $data['stok_habis']   = $this->barangModel->where('stok <=', 0)->countAllResults();
        $data['stok_menipis'] = $this->barangModel->where('stok >', 0)->where('stok <=', 10)->countAllResults();
        $data['total_barang'] = $this->barangModel->countAllResults();

        $options = new Options();
        $options->setIsRemoteEnabled(true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml(view('Admin/laporan/cetakpdf_barang', $data));
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $dompdf->stream(
            'Laporan_Stok_Barang_' . date('Ymd_His') . '.pdf',
            ['Attachment' => false]
        );

        exit;
    }

    public function cetakpdf_transaksi()
    {
        if (!session()->get('id_user')) {
            return redirect()->to('/login');
        }

        $start_date = $this->request->getGet('start_date');
        $end_date   = $this->request->getGet('end_date');

        $builder = $this->transaksiModel
            ->select('transaksi.*, pelanggan.nama as nama_pelanggan')
            ->join('pelanggan', 'pelanggan.id = transaksi.pelanggan_id', 'left');

        if (!empty($start_date)) {
            $builder->where('DATE(transaksi.tanggal) >=', $start_date);
        }
        if (!empty($end_date)) {
            $builder->where('DATE(transaksi.tanggal) <=', $end_date);
        }

        $data['transaksi'] = $builder->orderBy('transaksi.tanggal', 'DESC')->findAll();

        $total = 0;
        foreach ($data['transaksi'] as $t) {
            $total += (float) ($t['total_akhir'] ?? $t['total'] ?? 0);
        }

        $data['total_pendapatan'] = $total;
        $data['start_date']       = $start_date;
        $data['end_date']         = $end_date;

        $options = new Options();
        $options->setIsRemoteEnabled(true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml(view('Admin/laporan/cetakpdf_transaksi', $data));
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $dompdf->stream(
            'Laporan_Transaksi_' . date('Ymd_His') . '.pdf',
            ['Attachment' => false]
        );

        exit;
    }
}