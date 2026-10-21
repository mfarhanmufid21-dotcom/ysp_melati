-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 20 Okt 2026 pada 16.46
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_ysp`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang`
--

CREATE TABLE `barang` (
  `id` int(11) UNSIGNED NOT NULL,
  `nama_barang` varchar(255) NOT NULL,
  `harga` int(11) NOT NULL,
  `stok` int(11) NOT NULL,
  `terjual` int(11) DEFAULT 0,
  `deskripsi` text NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `create_at` datetime DEFAULT NULL,
  `update_at` datetime DEFAULT NULL,
  `harga_diskon` int(11) DEFAULT NULL,
  `is_promo` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `barang`
--

INSERT INTO `barang` (`id`, `nama_barang`, `harga`, `stok`, `terjual`, `deskripsi`, `gambar`, `create_at`, `update_at`, `harga_diskon`, `is_promo`) VALUES
(17, 'Gelang Ronce Melati \"Kirana Aruna\"', 85000, 24, 0, 'Sempurnakan detail penampilan Anda dengan gelang ronce melati yang didesain khusus untuk pergelangan tangan. Produk ini merupakan pilihan tepat bagi pengantin yang menginginkan keindahan rangkaian bunga tanpa harus terus-menerus menggenggam buket tangan, sehingga lebih bebas bergerak selama prosesi acara.\r\n\r\nKeunggulan Produk:\r\n-Desain Gelang (Wristlet): Lingkaran pas di pergelangan tangan yang kokoh namun tetap nyaman digunakan.\r\n-Aksen Mawar Mewah: Detail mawar merah sebagai pusat perhatian yang memberikan kontras warna yang cantik dan elegan.\r\n-Juntai Simetris: Untaian melati yang lebat memberikan efek jatuh yang anggun saat Anda bersalaman atau berfoto.\r\n\r\n    Kualitas Premium: Menggunakan kuncup melati pilihan yang putih bersih, padat, dan harum alami.\r\n\r\nSpesifikasi & Layanan:\r\n-Kondisi: Segar (Dibuat sesuai pesanan untuk menjaga kualitas bunga).\r\n-Material: 100% Melati Asli.\r\n- Pengemasan: Wadahbox sterofoam + es untuk menjaga kelembapan selama pengiriman.\r\n\r\n💡 Tips Penyimpanan:\r\nSimpanroncean dalam wadah tertutup di dalam lemari pendingin (chiller) agar tetap segar dan harum hingga waktu acara. Hindari sinar matahari langsung agar kelopak tidak cepat layu.\r\n\r\nSiap kirim untuk kebutuhan retail maupun partai besar. Pesan sekarang untuk sentuhan detail pernikahan yang istimewa!', '1792478929_51157625e02d7f131b8c.jpeg', NULL, NULL, NULL, 0),
(18, 'Gelang Ronce Melati \"Sekar Jagad\"', 75000, 10, 0, 'Sentuhan Praktis & Elegan untuk Jemari Pengantin\r\n\r\nSempurnakan penampilan Anda dengan gelang ronce melati yang didesain ergonomis untuk pergelangan tangan. Memadukan fungsi buket tangan dengan kenyamanan aksesori, memungkinkan Anda tetap tampil anggun dan bebas bergerak selama prosesi acara.\r\n\r\nKeunggulan Produk:\r\n- Desain Wristlet: Lingkaran pas di pergelangan tangan, praktis dan tidak perlu digenggam terus-menerus.\r\n- Aksen Mawar Marun: Detail mawar merah sebagai pusat perhatian yang memberikan kesan kontras nan mewah.\r\n- Juntai Estetik: Untaian melati yang lebat memberikan efek jatuh yang cantik saat bersalaman atau berfoto.\r\n-  Kualitas Premium: Menggunakan kuncup melati pilihan yang putih bersih, padat, dan harum alami.\r\n\r\nSpesifikasi & Layanan:\r\n- Kondisi: Segar (Made by Order).\r\n- Material: 100% Melati Asli & Mawar Segar.\r\n- Isi : 1 Pcs \r\n- Pengemasan: Wadah kedap udara untuk menjaga kelembapan selama pengiriman.\r\n\r\n💡 Tips Penyimpanan:\r\nSimpan dalam wadah tertutup di dalam chiller agar tetap segar dan harum hingga waktu acara. Hindari sinar matahari langsung agar kelopak tidak cepat layu.\r\n\r\nPesan sekarang untuk detail pernikahan yang lebih eksklusif dan istimewa!', '1776355091_51d7b0ecc6f23124ea74.png', NULL, NULL, 60000, 1),
(19, 'Set Ronce Melati Jawa (Aksen Mawar)', 300000, 29, 0, 'Keanggunan Tradisi Jawa yang Sakral dan Paripurna\r\n\r\nWujudkan tampilan pengantin Jawa yang berwibawa dan ningrat dengan set ronce melati kualitas terbaik. Dirangkai menggunakan pakem tradisional Jawa (Solo/Yogyakarta) dengan perpaduan kuncup melati putih bersih dan aksen mawar merah segar, memberikan kesan mewah, berani, sekaligus sakral di hari pernikahan Anda.\r\n\r\nIsi Set Lengkap:\r\n- Tibo Dodo: Untaian melati panjang menjuntai hingga ke dada/perut.\r\n- Sariayu / Cadar: Rangkaian jaring melati untuk penutup sanggul.\r\n- Sintingan: Sepasang hiasan melati yang dipasang di telinga/samping sanggul.\r\n- Kalung Pengantin: Rangkaian melati melingkar yang padat dan rapi.\r\n- Aksen Mawar: Bunga mawar merah asli sebagai pemanis di setiap titik simpul ronce.\r\n\r\nKeunggulan Produk:\r\n- Kualitas Grade A: 100% kuncup melati asli dan mawar merah segar pilihan, tanpa cacat atau bercak cokelat.\r\n- Hand-Crafted Presisi: Rajutan jaring yang sangat rapat, simetris, dan kokoh (tidak mudah protol).\r\n- Warna Kontras Menawan: Perpaduan putih melati dan merah mawar yang memberikan efek kontras cantik saat difoto.\r\n- Aroma Wangi Alami: Harum melati yang kuat dan segar, memberikan suasana tenang selama prosesi upacara.\r\n\r\nSpesifikasi & Layanan:\r\n- Kondisi: Segar & Higienis (Dibuat sesuai pesanan).\r\n- Model: Standar Pengantin Jawa (Solo Putri, Basahan, atau Jogja Paes Ageng).\r\n- Pengemasan: Box sterofoam + es kedap udara untuk menjaga suhu dan kesegaran bunga selama pengiriman.\r\n\r\n💡 Tips Penyimpanan:\r\nSimpan set ronce dalam wadah tertutup rapat di lemari pendingin (chiller suhu 5°C-10°C). Jauhkan dari freezer agar kelopak bunga tidak menghitam dan tetap segar saat digunakan.\r\n\r\nHadirkan kemewahan tradisi Jawa di hari bahagia Anda. Pesan sekarang untuk hasil ronce yang sempurna!', '1792478607_8abbc29f5c0e438b14fd.jpeg', NULL, NULL, 285000, 1),
(20, 'Set Ronce Melati Pengantin Sunda Siger', 300000, 30, 0, 'Kemurnian Tradisi untuk Hari Istimewa Anda\r\n\r\nHadirkan keanggunan paripurna pengantin Sunda dengan set ronce melati kualitas premium. Dirangkai secara tradisional dengan ketelitian tinggi, memastikan setiap detail jaring dan juntaian melati tampil simetris, kokoh, dan putih bersih untuk menyempurnakan riasan Siger Anda.\r\n\r\nIsi Set Lengkap:\r\n- Mambo / Cadar: Rangkaian jaring melati penutup sanggul hingga bahu.\r\n- Usus-ususan: Untaian melati panjang yang menjuntai anggun.\r\n- Sariayu: Rangkaian khusus untuk mempercantik area sanggul.\r\n- Patam: Kuncup melati pilihan untuk hiasan dahi/siger.\r\n- Tassel / Rumbai: Juntai bawah yang padat dan rapi.\r\n\r\nKeunggulan Produk:\r\n- Kualitas Grade A: 100% kuncup melati asli yang disortir manual, bebas ulat dan bercak cokelat.\r\n- Rajutan Rapi: Teknik meronce yang kuat, tidak mudah lepas, dan sesuai dengan pakem pengantin Sunda.\r\n- Segar & Harum: Dipetik subuh dan langsung dirangkai untuk menjaga aroma relaksasi yang alami.\r\n- Warna Putih Cemerlang: Memberikan kesan bersih dan mewah saat tertangkap kamera (fotogenik).\r\n\r\nSpesifikasi & Layanan:\r\n- Kondisi: Segar (Dibuat sesuai pesanan).\r\n- Pengerjaan: Oleh pengrajin ronce yang sudah ahli.\r\n- Pengemasan: Wadah box sterofoam dengan penahan kelembapan agar melati tetap fresh sampai lokasi.\r\n\r\n💡 Tips Penyimpanan:\r\nSimpan ronce dalam wadah tertutup di dalam lemari pendingin (chiller) pada suhu 5°C - 10°C. Jangan terkena freezer agar melati tidak menghitam atau layu.\r\n\r\nLengkapi prosesi sakral Anda dengan keaslian Melati Sunda Siger. Pesan sekarang untuk kualitas terbaik!', '1776354199_715b5ab2d0116d26a399.png', NULL, NULL, NULL, 0),
(21, 'Bunga Melati Segar ', 80000, 94, 0, 'Kemurnian Alami untuk Segala Kebutuhan Anda\r\nHadirkan keharuman dari bunga melati segar kualitas terbaik. Produk kami dipetik langsung dari kebun petani lokal. Melati ini telah melalui proses sortir untuk memastikan Anda hanya menerima bunga yang putih bersih, padat, dan bebas dari kotoran.\r\n\r\nKeunggulan Produk Kami:\r\n- 100% Alami & Polos : disortir tanpa daun dan bunga yg sudah mekar.\r\n- Kualitas Higienis: Melati telah dibersihkan secara manual (manual sorting) sehingga bebas dari debu, ulat, maupun sisa pestisida.\r\n- Warna Putih Sempurna: Bunga dipilih yang masih kuncup segar/menjelang mekar tanpa bercak cokelat atau memar.\r\n- Aroma Relaksasi: Memiliki wangi khas melati yang intens, menenangkan, dan tahan lama.\r\n\r\nKegunaan Multiguna:\r\n- Kebutuhan Tradisi: Sangat cocok untuk pelengkap acara siraman, tabur bunga, atau ronce pengantin.\r\n- Kesehatan & Kecantikan: Bahan alami untuk teh melati (jasmine tea), campuran masker wajah, atau terapi uap aroma.\r\n- Hiasan & Dekorasi: Memberikan kesan mewah dan harum alami pada vas bunga atau dekorasi meja tamu.\r\n\r\nSpesifikasi & Pengiriman:\r\n- Kondisi: Fresh (Segar).\r\n- Berat: [1kg]\r\nHarga tersebut merupakan harga melati perkg\r\n\r\n    Pengemasan: Menggunakan wadah box yang menjaga kelembapan suhu selama perjalanan.\r\n\r\n💡 Tips Penyimpanan:\r\nAgar melati tetap segar hingga 2-3 hari, simpanlah di dalam wadah tertutup rapat dan masukkan ke dalam lemari pendingin (chiller), hindari suhu freezer agar bunga tidak layu/menghitam.\r\n\r\nSiap kirim dalam jumlah besar maupun retail. Pesan sekarang untuk mendapatkan kesegaran melati terbaik hari ini!', '1778856768_eb74d522b52fab788287.png', NULL, NULL, 75000, 1),
(22, 'Ronce Melati \"Aruna Suci\"', 85000, 0, 0, 'Sentuhan Keanggunan Tradisional yang Mewah & Sakral\r\n\r\nHadirkan kemurnian di hari istimewa Anda dengan ronce tangan melati kualitas ekspor. Dibuat secara hand-crafted dengan desain lingkaran yang nyaman digenggam serta 5 juntai simetris yang memberikan kesan anggun nan estetik saat dibawa pengantin.\r\n\r\nKeunggulan Produk:\r\n- Kualitas Grade A: 100% kuncup melati asli, putih bersih, dan tanpa bercak cokelat.\r\n- Higienis: Melalui proses sortir manual, bebas dari ulat, debu, dan sisa pestisida.\r\n- Aroma Alami: Keharuman intens yang memberikan efek relaksasi selama prosesi acara.\r\n- Multifungsi: Ideal untuk ronce tangan pengantin, siraman, seserahan, maupun dekorasi hantaran.\r\n\r\nSpesifikasi & Layanan:\r\n- Kondisi: Segar (Freshly Made).\r\n- Isi : 1 Pcs\r\n- Model: Lingkaran pegangan dengan 5 untaian juntai.\r\n- Pengemasan: Wadah box + es  untuk menjaga kelembapan selama pengiriman.\r\n\r\n💡 Tips Penyimpanan:\r\nSimpan dalam wadah tertutup di lemari pendingin (chiller) agar tetap segar dan harum hingga 2 hari. Hindari suhu freezer agar bunga tidak layu/menghitam.\r\n\r\nSiap kirim retail maupun partai besar. Pesan sekarang untuk kualitas ronce terbaik!', '1776355322_944c4124266961a6eff1.png', NULL, NULL, NULL, 0),
(23, 'Bunga Melati Karuk Segar', 95000, 35, 0, 'Kesegaran Alami dengan Kualitas Wangi yang Otentik\r\n\r\nHadirkan keharuman alami langsung dari kebun dengan Melati Karuk pilihan. Berbeda dengan melati polos, melati karuk dipetik bersama tangkai hijaunya untuk menjaga cadangan air alami sehingga bunga tetap segar lebih lama, kencang, dan memiliki aroma yang semakin kuat saat menjelang mekar.\r\n\r\nKeunggulan Produk:\r\n- 100% Segar & Alami\r\n- Kualitas Higienis: Melalui proses sortir manual untuk memastikan bunga bebas dari ulat, debu, dan kotoran.\r\n- Daya Tahan Lebih Lama: Kehadiran tangkai hijau membantu menjaga kelembapan kuncup bunga dibandingkan melati rontok/polos.\r\n- Warna hijau bersih: Kuncup pilihan tanpa bercak cokelat atau memar, memberikan tampilan yang cantik dan bersih.\r\n\r\nKegunaan Multiguna:\r\n- Bahan Baku Ronce: Sangat ideal untuk dirangkai menjadi berbagai hiasan pengantin karena batangnya memudahkan proses penalian.\r\n- Kebutuhan Tradisi: Pilihan utama untuk dekorasi siraman, hiasan sanggul, hingga pelengkap seserahan.\r\n- Industri Teh & Aromaterapi: Memberikan aroma melati yang intens dan menenangkan untuk campuran teh atau terapi uap.\r\n\r\nSpesifikasi & Pengiriman:\r\n- Kondisi: Fresh (Kuncup bertangkai).\r\n- Berat : [1Kg]\r\nHarga tersebut merupakan harga untuk 1 kg\r\n- Kemasan: Menggunakan wadah box sterofoam yang menjaga sirkulasi udara dan kelembapan agar bunga tidak panas selama perjalanan.\r\n\r\n💡 Tips Penyimpanan:\r\nAgar tetap segar hingga 2-3 hari, simpan melati dalam wadah tertutup di dalam lemari pendingin (chiller suhu 5°C - 10°C). Hindari suhu freezer agar bunga tidak menghitam.\r\n\r\nMelayani pembelian retail maupun partai besar untuk kebutuhan vendor pernikahan atau industri. Pesan sekarang untuk mendapatkan kualitas melati terbaik!', '1778856519_3aca90b0e6827f093e98.png', NULL, NULL, NULL, 0),
(24, 'Melati Putih Polos', 55000, 44, 0, 'Kemurnian Alami untuk Segala Kebutuhan Anda\r\n\r\nNikmati keharuman autentik dari kuncup melati pilihan yang telah dibersihkan secara teliti. Melati polos ini dipetik langsung dari kebun pada waktu subuh saat aromanya paling kuat, kemudian dipisahkan dari tangkainya untuk memberikan kemudahan penggunaan bagi Anda yang mengutamakan kepraktisan dan kebersihan untuk ronce.\r\n\r\nKeunggulan Produk:\r\n- 100% Alami & Polos: Tanpa bahan pengawet, pewangi buatan, dan bersih dari campuran tangkai atau daun.\r\n- Kualitas Terjamin: Melalui proses sortir manual (manual sorting) sehingga bebas dari ulat, maupun sisa kotoran.\r\n- Warna Putih Sempurna: Kuncup segar pilihan tanpa bercak cokelat atau memar.\r\n- Aroma Relaksasi: Memiliki wangi khas melati yang intens, menenangkan, dan tahan lama.\r\n\r\nKegunaan Multiguna:\r\n- Kebutuhan Tradisi: Sangat cocok untuk pelengkap acara siraman, tabur bunga, atau bahan utama ronce pengantin.\r\n- Kesehatan & Kecantikan: Bahan alami untuk teh melati, campuran masker wajah, atau terapi uap aroma.\r\n-Hiasan & Dekorasi: Memberikan kesan mewah dan harum alami untuk vas bunga atau dekorasi meja.\r\n\r\nSpesifikasi & Pengiriman:\r\n- Kondisi: Fresh (Segar).\r\n- Berat: [1kg].\r\nHarga tersebut merupakan harga melati perkg\r\n\r\n Pengemasan: Wadah kedap udara khusus untuk menjaga kelembapan suhu selama perjalanan.\r\n\r\n💡 Tips Penyimpanan:\r\nAgar tetap segar hingga 2-3 hari, simpan dalam wadah tertutup rapat di lemari pendingin (chiller). Hindari suhu freezer agar bunga tidak layu atau menghitam.\r\n\r\nMelayani pembelian retail maupun partai besar. Pesan sekarang untuk mendapatkan kesegaran melati terbaik hari ini!', '1778857171_56f2548ca2906b8e0504.png', NULL, NULL, NULL, 0),
(25, 'Bunga Melati Segar Curah', 35000, 60, 0, 'Kesegaran Murni Langsung dari Kebun Petani\r\n\r\nDapatkan keharuman melati autentik dengan kualitas yang paling alami. Produk ini adalah melati yang baru saja dipetik dan langsung dikemas tanpa melalui proses pemilihan (sortir) ulang.\r\n\r\nKarakteristik Produk:\r\n- Baru Dipetik: Menjamin bunga dalam kondisi paling segar dengan kadar air maksimal.\r\n- Kondisi Campuran: Karena tidak melalui proses sortir, produk terdiri dari perpaduan alami antara kuncup segar, bunga yang mulai mekar, dan tangkai hijau.\r\n- Aroma Maksimal: Dipetik pada waktu terbaik untuk memastikan wangi melati yang intens dan menenangkan.\r\n- Ekonomis & Alami: Pilihan tepat bagi Anda yang membutuhkan melati jumlah besar dengan harga yang lebih terjangkau.\r\n\r\nKegunaan Multiguna:\r\n- Upacara Adat: Pilihan utama untuk kebutuhan tabur bunga atau campuran air siraman karena aromanya yang pekat.\r\n- Bahan Baku Alami: Sangat cocok sebagai campuran teh melati (jasmine tea) atau bahan dasar aromaterapi dan masker kecantikan.\r\n- Dekorasi Natural: Memberikan kesan asri dan harum alami untuk hiasan vas atau dekorasi meja dalam jumlah banyak.\r\n\r\nSpesifikasi & Pengiriman:\r\n- Kondisi: Fresh (Campuran kuncup & mekar).\r\n- Kemasan: Menggunakan wadah yang menjaga sirkulasi udara agar bunga tidak panas selama perjalanan.\r\n\r\n💡 Tips Penyimpanan:\r\nSegera pindahkan bunga ke wadah terbuka atau simpan dalam wadah kedap udara di dalam lemari pendingin (chiller) untuk mempertahankan kesegarannya lebih lama.\r\n\r\nSiap melayani pesanan partai besar maupun retail untuk kebutuhan vendor dekorasi, industri, dan pribadi. Pesan sekarang untuk aroma melati asli hari ini!', '1778857498_ea9f5561cbe2215c040c.png', NULL, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `bunga`
--

CREATE TABLE `bunga` (
  `id` int(11) NOT NULL,
  `nama_bunga` varchar(100) NOT NULL,
  `kategori` varchar(50) DEFAULT NULL,
  `stok` int(11) DEFAULT 0,
  `harga` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_transaksi`
--

CREATE TABLE `detail_transaksi` (
  `id` int(11) UNSIGNED NOT NULL,
  `transaksi_id` int(10) UNSIGNED NOT NULL,
  `barang_id` int(10) UNSIGNED NOT NULL,
  `jumlah` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `subtotal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `detail_transaksi`
--

INSERT INTO `detail_transaksi` (`id`, `transaksi_id`, `barang_id`, `jumlah`, `harga`, `subtotal`) VALUES
(52, 35, 18, 1, 60000, 60000),
(53, 35, 20, 2, 300000, 600000),
(54, 36, 21, 1, 65000, 65000),
(55, 37, 20, 1, 300000, 300000),
(56, 38, 18, 1, 60000, 60000),
(57, 39, 21, 1, 65000, 65000),
(58, 40, 24, 1, 55000, 55000),
(59, 41, 19, 1, 285000, 285000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2025-12-12-065201', 'App\\Database\\Migrations\\Barang', 'default', 'App', 1765523478, 1),
(2, '2025-12-12-092936', 'App\\Database\\Migrations\\Pelanggan', 'default', 'App', 1765532139, 2),
(3, '2025-12-12-093219', 'App\\Database\\Migrations\\Transaksi', 'default', 'App', 1765532139, 2),
(4, '2025-12-12-093340', 'App\\Database\\Migrations\\DetailTransaksi', 'default', 'App', 1765532139, 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `alamat` text NOT NULL,
  `telepon` varchar(20) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pelanggan`
--

INSERT INTO `pelanggan` (`id`, `user_id`, `nama`, `alamat`, `telepon`, `email`, `created_at`, `updated_at`) VALUES
(30, 25, 'Suci Ramadhani', 'Ds. Pamutih, Ulujami, Pemalang', '085647695804', 'suci4120@gmail.com', '2026-05-14 12:55:24', '2026-05-16 03:57:31'),
(31, 27, 'Mima Alfasha', 'Jl. Wiradesa, Kec. Wiradesa, Kab Pekalongan', '085647695804', 'mima@gmail.com', '2026-05-16 13:51:42', '2026-05-16 13:51:42'),
(32, 28, 'sugeng rahayu', 'batang', '08816776079', 'sugeng@gmail.com', '2026-10-20 12:55:59', '2026-10-20 12:55:59'),
(33, 29, 'mawar lestari', 'batang', '08816776079', 'mawar@gmail.com', '2026-10-20 13:22:45', '2026-10-20 13:22:45');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi`
--

CREATE TABLE `transaksi` (
  `id` int(11) UNSIGNED NOT NULL,
  `invoice` varchar(50) DEFAULT NULL,
  `pelanggan_id` int(10) UNSIGNED NOT NULL,
  `tanggal` datetime DEFAULT NULL,
  `total` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status` enum('Pending','Diproses','Dikirim','Selesai') DEFAULT 'Pending',
  `metode_pengiriman` enum('ambil','delivery') DEFAULT NULL,
  `metode_pembayaran` varchar(50) DEFAULT NULL,
  `ewallet_type` varchar(50) DEFAULT NULL,
  `bukti_pembayaran` varchar(255) DEFAULT NULL,
  `status_pembayaran` varchar(50) DEFAULT 'pending',
  `ongkir` int(11) DEFAULT 0,
  `biaya_proteksi` int(11) NOT NULL DEFAULT 0,
  `total_akhir` int(11) DEFAULT 0,
  `alamat_tujuan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `transaksi`
--

INSERT INTO `transaksi` (`id`, `invoice`, `pelanggan_id`, `tanggal`, `total`, `created_at`, `updated_at`, `status`, `metode_pengiriman`, `metode_pembayaran`, `ewallet_type`, `bukti_pembayaran`, `status_pembayaran`, `ongkir`, `biaya_proteksi`, `total_akhir`, `alamat_tujuan`) VALUES
(35, 'INV-20260514-0035', 30, '2026-05-14 11:35:23', 660000, '2026-05-14 11:35:23', '2026-05-16 13:30:30', 'Selesai', 'delivery', 'cod', NULL, NULL, 'lunas', 15000, 3000, 678000, 'Ds. Kertosari, Rt 03 Rw 02, Ulujami, Pemalang'),
(36, 'INV-20260514-0036', 30, '2026-05-14 11:45:32', 65000, '2026-05-14 11:45:32', '2026-05-15 11:54:44', 'Selesai', 'delivery', 'cod', NULL, NULL, 'lunas', 15000, 3000, 83000, 'Jl. Pekalongan Timur No.19'),
(37, 'INV-20260514-0037', 30, '2026-05-14 12:00:51', 300000, '2026-05-14 12:00:51', '2026-05-15 11:59:56', 'Selesai', 'delivery', 'cod', NULL, NULL, 'lunas', 15000, 3000, 318000, 'pekalongan barat no 11'),
(38, 'INV-20260514-0038', 30, '2026-05-14 12:12:52', 60000, '2026-05-14 12:12:52', '2026-05-15 11:54:02', 'Selesai', 'delivery', 'cod', NULL, NULL, 'lunas', 15000, 3000, 78000, 'Jl. Pekalongan Timur No.19'),
(39, 'INV-20260514-0001', 30, '2026-05-14 12:55:24', 65000, '2026-05-14 12:55:24', '2026-05-14 14:18:45', 'Selesai', 'delivery', 'transfer', NULL, 'pay_1778763324_243.png', 'lunas', 15000, 3000, 83000, 'Ds. Kertosari, Rt 03 Rw 02, Ulujami, Pemalang'),
(40, 'INV-20260515-0001', 30, '2026-05-15 15:28:49', 55000, '2026-05-15 15:28:49', '2026-05-15 15:28:49', 'Pending', 'delivery', 'cod', NULL, NULL, 'pending', 15000, 3000, 73000, 'Jl. Pemalang Selatan, Kec. Taman, Pemalang'),
(41, 'INV-20260516-0001', 31, '2026-05-16 13:53:13', 285000, '2026-05-16 13:53:13', '2026-05-16 13:54:03', 'Selesai', 'ambil', 'ewallet', 'ovo', 'pay_1778914393_795.png', 'lunas', 0, 0, 285000, '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ulasan`
--

CREATE TABLE `ulasan` (
  `id` int(11) NOT NULL,
  `id_barang` int(11) DEFAULT NULL,
  `transaksi_id` int(11) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `komentar` text DEFAULT NULL,
  `balasan` text DEFAULT NULL,
  `foto_ulasan` varchar(255) DEFAULT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `tanggal_ulasan` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `ulasan`
--

INSERT INTO `ulasan` (`id`, `id_barang`, `transaksi_id`, `id_user`, `rating`, `komentar`, `balasan`, `foto_ulasan`, `status`, `tanggal_ulasan`) VALUES
(1, 21, 39, 25, 5, 'Melatinya fresh dan cocok untuk di ronce', 'Waaahhh terimakasih ya kak sudah berbelanja di ysp jasmine :)', 'review_1778911932_773.png', 'approved', '2026-05-16 13:12:12'),
(2, 20, 37, 25, 5, 'Bunganya seger, ronceannya juga bagus rapih suka bangett', 'Terimakasih sudah berbelanja di toko kami :)', 'review_1778912908_284.png', 'approved', '2026-05-16 13:28:28'),
(3, 19, 41, 27, 5, 'Roncenya bagus sekaliii dan rapi, sangat suka, melatinya juga fresh', 'Terimakasih sudah berbelanja di toko kami, senang sekali jika anda puas :)', 'review_1778914537_532.png', 'approved', '2026-05-16 13:55:37');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('admin','user') DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `created_at`, `updated_at`) VALUES
(5, 'admin', 'admin123@gmail.com', '$2y$10$JNbgqosx5Vm5Ok7OGRKBk.XLiRhaZap8h3TE8TSnmFMjhW2keYuES', 'admin', NULL, NULL),
(25, 'suci_ramadhani', 'suci4120@gmail.com', '$2a$12$Mzy1ns.224VsZdyz7z82U.cbr9h7I8pMBaUKba7oNdiXuF2kQrlAq', 'user', '2026-05-15 19:49:59', NULL),
(27, 'mima123', NULL, '$2y$10$8RDm3aiuWoFRN6.7cxNPZuQs8v.ttaJ4PkZuiOEZl9C/srobRT8em', 'user', '2026-05-16 13:51:42', '2026-05-16 13:51:42'),
(28, 'sugeng', NULL, '$2y$10$s2WK0BX7kWkEGYyD0tfOo.S.ttI34auAqkcKlmuGChGxmkA98JRHO', 'user', '2026-10-20 12:55:59', '2026-10-20 12:55:59'),
(29, 'mawar', NULL, '$2y$10$R2oTqFQofa4.coB9wi6ccONBc.503gw41nWLLRlpX5rTf1VrjpZDa', 'user', '2026-10-20 13:22:45', '2026-10-20 13:22:45');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `bunga`
--
ALTER TABLE `bunga`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `detail_transaksi_transaksi_id_foreign` (`transaksi_id`),
  ADD KEY `detail_transaksi_barang_id_foreign` (`barang_id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_pelanggan_user` (`user_id`);

--
-- Indeks untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaksi_pelanggan_id_foreign` (`pelanggan_id`);

--
-- Indeks untuk tabel `ulasan`
--
ALTER TABLE `ulasan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `barang`
--
ALTER TABLE `barang`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT untuk tabel `bunga`
--
ALTER TABLE `bunga`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT untuk tabel `ulasan`
--
ALTER TABLE `ulasan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD CONSTRAINT `detail_transaksi_barang_id_foreign` FOREIGN KEY (`barang_id`) REFERENCES `barang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detail_transaksi_transaksi_id_foreign` FOREIGN KEY (`transaksi_id`) REFERENCES `transaksi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD CONSTRAINT `fk_pelanggan_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_pelanggan_id_foreign` FOREIGN KEY (`pelanggan_id`) REFERENCES `pelanggan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
