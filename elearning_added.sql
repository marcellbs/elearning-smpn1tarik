-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 08 Sep 2023 pada 02.47
-- Versi server: 10.4.22-MariaDB
-- Versi PHP: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `elearning`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `kode_admin` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`kode_admin`, `nama`, `foto`, `email`, `password`) VALUES
(1, 'SMP Negeri 1 Tarik', 'spenstar.png', 'smpn1tarik@smpn1tarik.sch.id', '$2a$12$UpnyDBF.WMbTV.kFnYNjL.h0smTBEulo8JKjRgpuOY2qEFOrE1u8S'),
(11, 'Admin', 'avatar-4.png', 'admin@smpn1tarik.sch.id', '$2y$10$fkLt53JZF4umL0EjTYeJluRmlDNCiR28yEGu2aA/E7w7TES4cuqSe');

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `guru`
--

CREATE TABLE `guru` (
  `kode_guru` int(11) NOT NULL,
  `nip` varchar(25) DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `jenis_kelamin` varchar(20) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `telepon` varchar(15) DEFAULT NULL,
  `agama` varchar(30) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `guru`
--

INSERT INTO `guru` (`kode_guru`, `nip`, `username`, `nama`, `jenis_kelamin`, `alamat`, `telepon`, `agama`, `foto`, `email`, `password`) VALUES
(1, '196802261995122002', 'sulih-prihatiningsih', 'Dra. Sulih  Prihatiningsih, M.Pd.', 'Perempuan', NULL, NULL, NULL, 'avatar-1.png', NULL, '$2y$10$hMXXr3IXSDl7.DpWOTxs7.q6iAALQv0niAWxZJ67KgHO4HhWACMxy'),
(2, '196306151985041002', 'suyanto', 'Suyanto, S.Pd.', NULL, NULL, NULL, NULL, 'avatar-1.png', NULL, '$2y$10$/QOO47n82c0AUbYyJZraeOuQgd0F8yYrgNJMoPDaJxTk/fUQYk1Dm'),
(3, '196505141995121004', 'sulaiman', 'Drs. Sulaiman', NULL, NULL, NULL, NULL, 'avatar-8.png', NULL, '$2y$10$1Sq6M0ys9.8Xve.zl2lJfOEt9qREgxvk22r9CO/1Yv3/98TFQ5UsK'),
(4, '196402071990032002', 'susmiati', 'Susmiati, S.Pd.', NULL, NULL, NULL, NULL, 'avatar-10.png', NULL, '$2y$10$zUkD6RwTvefdiv0B5B1X3u2O5RZoEZm4KPFG97oUg1Bs7D0LBKjP6'),
(5, '196605071991031016', 'nurdiono', 'Nurdiono, M.Pd.', NULL, NULL, NULL, NULL, 'avatar-9.png', NULL, '$2y$10$5KR3SrnL7grp3yBdgz7qZ.sRZ0xsewz34HrtwY/tA7rtLft4WAjb2'),
(6, '196311071984122004', 'rahmayati', 'Rahmayati, S.Pd.', NULL, NULL, NULL, NULL, 'avatar-8.png', NULL, '$2y$10$w3o7umnOoET3R1PyJ6BvuOw63GSpzvDhseSKsvDlBhY6KGqNrCeS2'),
(7, '196503141989031012', 'mulyono', 'Mulyono, S.Pd.', NULL, NULL, NULL, NULL, 'avatar-13.png', NULL, '$2y$10$E7Nna4c7.ziJBv3juo/bdujPVdMzO.DnDC3E9wuzz7ENLCmdnlGOu'),
(8, '196606271989031008', 'abdul-wahib', 'Abdul Wahib, S.Pd.', NULL, NULL, NULL, NULL, 'avatar-15.png', NULL, '$2y$10$SgdVWFypAdh1pgWW2kIWteE3lRODEreMe3O4bi7NMR.CdMhSOTjsu'),
(9, '196804011991032011', 'ekes-rin', 'Ekes Rin Arwanti, S.Pd.', NULL, NULL, NULL, NULL, 'avatar-18.png', NULL, '$2y$10$ds2vsNFzaekL1o6QGueut.NM009ngvHm1uouvXf.V3xru1C6b7kxW'),
(10, '196308061985121001', 'agus-sutiono', 'Agus Sutiono, S.Pd.', NULL, NULL, NULL, NULL, 'avatar-17.png', NULL, '$2y$10$OX7ZEkI0JSqhwZJ33EzUie2b2w2HC9iJGfAXh1jxG7h/2r6eqBPOO'),
(11, '196810202005011010', 'sunardi', 'Drs. Sunardi', NULL, NULL, NULL, NULL, 'avatar-19.png', NULL, '$2y$10$cV7t/kS8Ez2lpygkysCNl.i7xhESR7CXRZ.1qABZ.NsFK9LpXc4kS'),
(12, '196902022007011015', 'abdul-muntolib', 'Abdul Muntolib, S.Pd', NULL, NULL, NULL, NULL, 'avatar-3.png', NULL, '$2y$10$DO.wT4aftRp5Pba/l.bh2esL4o5Ugd2t543w9Akj18kjDCEH.vSlm'),
(13, '196902012007012022', 'sri-prabakti', 'Sri Prabakti, S.Pd.', NULL, NULL, NULL, NULL, 'avatar-1.png', NULL, '$2y$10$xIqQUhac.RAst.zxIDT.mejN.z7uX5HARIMhgLK1BFrRs6dZPK0tK'),
(14, '196903162007012016', 'rina-mardiana', 'Rina Mardiana For a, S.Pd.', NULL, NULL, NULL, NULL, 'avatar-7.png', NULL, '$2y$10$bRKhZypMypJuSYLsFHzFmOdmvRfkCyjvFbcrWUht9EoKkPHrIUU4.'),
(15, '196807152008011013', 'amin-sugiono', 'Amin Sugiono, ST.', NULL, NULL, NULL, NULL, 'avatar-8.png', NULL, '$2y$10$qG9tYW2pZ5zUVtCv4rDUfuNG8.0E8bpeq8PPbVtUgwq9MEBEYQify'),
(16, '196805162005011004', 'mohammad-ircham', 'Mohammad Ircham, S.Pd.', NULL, NULL, NULL, NULL, 'avatar-9.png', NULL, '$2y$10$65Ii5uUHyMv7R66PTkPRTOwTxbmWwDweGrzOcHAsRkGzgj.HSepEi'),
(17, '198109212011011007', 'khoirul-badi\'', 'Khoirul Badi\', S.Kom.', NULL, NULL, NULL, NULL, 'avatar-11.png', NULL, '$2y$10$6X/HmCw.ZWZU.etDRJRz2u4Bcj6VyiZ8ARxDKlHgWi63JIjpMF/uy'),
(18, '196603122007012019', 'suliati', 'Suliati, S.Pd., S.Th.', NULL, NULL, NULL, NULL, 'avatar-13.png', NULL, '$2y$10$8xcG.St7yzRdCRpsaVj82Ouvy3Qgm3hBlrXI3i3SmHxzdUg780G5.'),
(19, '199010042019032016', 'devi-rosanita', 'Devi Rosanita, S.Pd.I.', NULL, NULL, NULL, NULL, 'avatar-19.png', NULL, '$2y$10$uqLNNdr6Et3fg.7zbl/PGuRXUDeD0v0XKrxtQISMSmH/kxiVuwYcm'),
(20, '199411122020122013', 'miftahur-rizki', 'Miftahur Rizki Islamie, S.Pd.', NULL, NULL, NULL, NULL, 'avatar-20.png', NULL, '$2y$10$HWXdEioAwARxkQ7mPTh12.E4rSjM0YK5ZxwjQYORDItfPNC88CJ/W'),
(21, '198306162022212039', 'muji-astutik', 'Muji Astutik, S.Pd.', NULL, NULL, NULL, NULL, 'avatar-3.png', NULL, '$2y$10$4lFxLYZ8wLb.58lpO7BJ5e7rTELoLarQAUo7/Y9H06E8TC1duVWbW'),
(22, '199508022022212020', 'retno-dian', 'Retno Dian Lestari, S.Pd.', NULL, NULL, NULL, NULL, 'avatar-2.png', NULL, '$2y$10$Dw.S9YyJdkpPbhCfGVA.7OVbl5fJvLhMuz8iZLY7nq.BUGdMXXTrS'),
(23, '198108262022212020', 'sukemi', 'Sukemi, SH.', NULL, NULL, NULL, NULL, 'avatar-9.png', NULL, '$2y$10$.93UYWr2EOeMW9bhDwqdXOtq.RzY5sDD4Vujg5..QCF70xa3pXOQK'),
(24, '198403082022211019', 'harits-mukhlasin', 'Harits Mukhlasin, S.Pd.', NULL, NULL, NULL, NULL, 'avatar-10.png', NULL, '$2y$10$QDLnAi1/mHcZQ/546wSIJOr9pKE4Fy50keBg0T8lm0aqylNRIPfN2'),
(25, '199301222022212010', 'vitri-andriani', 'Vitri Andriani, S.Pd., Gr.', NULL, NULL, NULL, NULL, 'avatar-8.png', NULL, '$2y$10$L0yAzJdU5pRMsE/I6kDTG.kpH7UXAE0b.YCd1eTkgCadh3QjUH43e'),
(26, '199302122022212028', 'indri-irawati', 'Indri Irawati, S.Pd.', NULL, NULL, NULL, NULL, 'avatar-4.png', NULL, '$2y$10$bvpGZWVdVlfpCloAY4NJneqAKVwQkqXSPTK6Yi6.1JsjFc2bPdP5.'),
(27, '199304242022212027', 'dwi-nur', 'Dwi Nur Jayanti, S.Pd.', NULL, NULL, NULL, NULL, 'avatar-5.png', NULL, '$2y$10$FuO4EzhxD3e0K.NipJFqUeWJc96fToKdtmMGz0MWnVYX0BRSDTqQW'),
(28, '199408042022211009', 'farikhul-islam', 'Farikhul Islam, S.Pd.', NULL, NULL, NULL, NULL, 'avatar-6.png', NULL, '$2y$10$uv80M6HGJzVcL721kNa1Keo0YfepwT.4VBBfXXGWKRHjb0EzQwljm'),
(29, '196505291986031008', 'muhammad-fatoni', 'Muhammad Fatoni', NULL, NULL, NULL, NULL, 'avatar-9.png', NULL, '$2y$10$tdxttOqVGU72K00zNJTsOu4.Pd2v/d2GOWTbGhMb3pgJ6qOspeeHK'),
(30, '198009172009022006', 'mufadillah', 'Mufadilah, A.Md.', NULL, NULL, NULL, NULL, 'avatar-2.png', NULL, '$2y$10$uPLPPnfTdFB6Z.Yzsw7aBOPw5jCJAitejJH3xZSWr5ZzEwllVZPl2'),
(31, '196606082007012013', 'lailil-munailah', 'Lailil Munailah', NULL, NULL, NULL, NULL, 'avatar-1.png', NULL, '$2y$10$19rx8.Wluv7pS/YD7lJxl.3oBP3KpTGiNYjN8./kCT25efTWMedWG'),
(32, '198901312022211010', 'mukhamad-khoironi', 'Mukhamad Khoironi, S.Kom.', NULL, NULL, NULL, NULL, 'avatar-7.png', NULL, '$2y$10$Qbc..7cqEZwbidIX.0mSSOhjwTyWMQIBhrhnLMfzssKAVAVAl/r3q'),
(33, '198910072020121006', 'muhammad-gilang', 'Muhammad Gilang, S.Pd.', NULL, NULL, NULL, NULL, 'avatar-3.png', NULL, '$2y$10$ZDfJg864usSD/5TM9phKf.R5K7Pvyf1bHBj6ql9Qa0FU/WHJC3Kd2'),
(34, '198004042022211012', 'akhmad-kurniawan', 'Akhmad Kurniawan, S.Pd.', NULL, NULL, NULL, NULL, 'avatar-5.png', NULL, '$2y$10$4i9f850kpEBF6W/p51UQMuVrQgaZ27xK.7EZBbBfuWNI5LclFBjkK'),
(35, '198101082010012014', 'eka-sukriswati', 'Eka Sukriswati, S.Kom.', 'Perempuan', NULL, NULL, NULL, 'avatar-12.png', NULL, '$2y$10$92W84lmigR0BJ.bWDste1eW.5HUCJTIyDsZ0B0h.RprNO6oJOLHoS'),
(36, '196804011998022001', 'siti-mutmainnah', 'Siti Mutmainnah, M.Pd.', NULL, NULL, NULL, NULL, 'avatar-8.png', NULL, '$2y$10$lxkmKbxvLvb5C7RT6/ecsec3OAhxiA5WSAu3E6OJzwcdwcoyw1JE.'),
(37, NULL, 'siti-khomariah', 'Siti Khomariah, S.Pd.', NULL, NULL, NULL, NULL, 'avatar-5.png', NULL, '$2y$10$K1sughbJOPV1tedS2u8EI.4HO6gAwPg0cHFXje1R8hbFfPPvr1v6a'),
(38, NULL, 'siti-jauharoh', 'Siti Jauharoh, S.Pd.I', NULL, NULL, NULL, NULL, 'avatar-3.png', NULL, '$2y$10$kMSr0nKkFLLHioWCMbM66eSHZU9EROr/XLbOe1ifV2IG8.AG6UDSO'),
(39, NULL, 'anggoro-adhi', 'Anggoro Adhi Priyo Utomo, S.Pd.', NULL, NULL, NULL, NULL, 'avatar-6.png', NULL, '$2y$10$TkCrWl3UgWX4CitbCmv6weqJx4FL6g2hV5XnhzEiJvn6IDwKNMdv6'),
(40, NULL, 'hadi-ismawanto', 'Hadi Ismawanto, S.Pd.I.', NULL, NULL, NULL, NULL, 'avatar-7.png', NULL, '$2y$10$2Kk/4p/PTYZ6M.ypzeLsieMCkC4eX4r0IAnhMjUjoCSNepce7ZJQG'),
(41, NULL, 'akhmad-bustanul', 'Akhmad Bustanul Arifin, S.Pd.I', NULL, NULL, NULL, NULL, 'avatar-9.png', NULL, '$2y$10$DxzZ5tO95bu4R7sEApiTFuP49klqIDTiAPTiCDmzVBwbhdBo2bNx6'),
(42, NULL, 'indah-ratna', 'Indah Ratna Sari, S.Pd.', NULL, NULL, NULL, NULL, 'avatar-11.png', NULL, '$2y$10$Cjswvr/RdxXiMr2RHJOWX.Ed.hLnFuag.epUhzOFEyk4t2MaCT/Nu'),
(43, NULL, 'prayogya-eko', 'Progya Eko Mulyantoro, S.Pd.', NULL, NULL, NULL, NULL, 'avatar-13.png', NULL, '$2y$10$W5rFXoqFMTpe/FXfM1JREuoClSrsM9Rx5r3BEu669TJyPfp46JpVy'),
(44, NULL, 'tria-juniarti', 'Tria Juniarti, S.Pd.', NULL, NULL, NULL, NULL, 'avatar-12.png', NULL, '$2y$10$StQ5Hxbt5oRhe5xer88i/O8gnSg1Wjfeu/QtHvlAvJwR5Bg7v8O9K'),
(45, NULL, 'hernawati', 'Hernawati, SE.', NULL, NULL, NULL, NULL, 'avatar-1.png', NULL, '$2y$10$CxjLIAjJZxSBvzVM072sLOeLhoigvtVSTXMKca5Z59xc3TjLTjHfO'),
(46, NULL, 'kanida-eka', 'Kanida Eka Putri, S.Pd.', NULL, NULL, NULL, NULL, 'avatar-8.png', NULL, '$2y$10$wDKePh.azr6Mce4pQDXejeZdSfB/VIkYkOGozw3ZabSkPOwozrnK.'),
(47, NULL, 'dodot-tri', 'Dodot Tri Prasetyo', NULL, NULL, NULL, NULL, 'avatar-13.png', NULL, '$2y$10$PI.sygOOGZC/dk9xU18MzeMwqyiWQbhnhHG/Sa0bGNefIRiWTbvZu');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jadwal`
--

CREATE TABLE `jadwal` (
  `id` int(11) NOT NULL,
  `kode_pengampu` int(11) NOT NULL,
  `hari` text NOT NULL,
  `jam_mulai` varchar(10) NOT NULL,
  `jam_berakhir` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `jadwal`
--

INSERT INTO `jadwal` (`id`, `kode_pengampu`, `hari`, `jam_mulai`, `jam_berakhir`) VALUES
(6, 4, 'Senin', '07:00', '08:20'),
(7, 5, 'Selasa', '08:20', '09:40'),
(8, 6, 'Selasa', '09:40', '10:20'),
(9, 7, 'Selasa', '10:20', '11:00'),
(10, 5, 'Kamis', '07:00', '09:00'),
(11, 5, 'Jumat', '10:20', '11:40');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jawaban_tugas`
--

CREATE TABLE `jawaban_tugas` (
  `id` int(11) NOT NULL,
  `berkas` varchar(255) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `tgl_upload` timestamp NOT NULL DEFAULT current_timestamp(),
  `nilai` int(11) DEFAULT NULL,
  `kode_tugas` int(11) NOT NULL,
  `kode_siswa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `jawaban_tugas`
--

INSERT INTO `jawaban_tugas` (`id`, `berkas`, `keterangan`, `tgl_upload`, `nilai`, `kode_tugas`, `kode_siswa`) VALUES
(2, 'CIPTAINOVASI_KMIPN2023_Kagutsuchi_Politeknik Elektronika Negeri Surabaya.pdf', NULL, '2023-09-06 03:43:01', 88, 2, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kelas`
--

CREATE TABLE `kelas` (
  `kode_kelas` int(11) NOT NULL,
  `nama_kelas` varchar(5) NOT NULL,
  `kode_admin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `kelas`
--

INSERT INTO `kelas` (`kode_kelas`, `nama_kelas`, `kode_admin`) VALUES
(1, '7A', 11),
(2, '8A', 11),
(3, '9A', 1),
(4, '7B', 1),
(5, '8B', 1),
(6, '9B', 1),
(7, '7C', 1),
(8, '8C', 1),
(9, '9C', 1),
(10, '7D', 11),
(11, '8D', 1),
(12, '9D', 1),
(13, '7E', 1),
(14, '8E', 1),
(15, '9E', 1),
(16, '7F', 1),
(17, '8F', 1),
(18, '9F', 1),
(19, '7G', 1),
(20, '8G', 1),
(21, '9G', 1),
(22, '7H', 1),
(23, '8H', 1),
(24, '9H', 11);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kelas_siswa`
--

CREATE TABLE `kelas_siswa` (
  `id` int(11) NOT NULL,
  `kode_siswa` int(11) NOT NULL,
  `kode_kelas` int(11) NOT NULL,
  `kode_thajaran` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `kelas_siswa`
--

INSERT INTO `kelas_siswa` (`id`, `kode_siswa`, `kode_kelas`, `kode_thajaran`, `created_at`) VALUES
(35, 1, 2, 1, '2023-08-22 20:48:53'),
(36, 2, 2, 1, '2023-08-22 20:48:54'),
(37, 3, 2, 1, '2023-08-22 20:48:54'),
(38, 4, 2, 1, '2023-08-22 20:48:55'),
(39, 5, 2, 1, '2023-08-22 20:48:56'),
(40, 6, 2, 1, '2023-08-22 20:48:57'),
(41, 7, 2, 1, '2023-08-22 20:48:57'),
(42, 8, 2, 1, '2023-08-22 20:48:59'),
(43, 9, 2, 1, '2023-08-22 20:49:00'),
(44, 10, 2, 1, '2023-08-22 20:49:01'),
(45, 11, 2, 1, '2023-08-22 20:49:03'),
(46, 12, 2, 1, '2023-08-22 20:49:03'),
(47, 13, 2, 1, '2023-08-22 20:49:04'),
(48, 14, 2, 1, '2023-08-22 20:49:06'),
(49, 15, 2, 1, '2023-08-22 20:49:07'),
(50, 16, 2, 1, '2023-08-22 20:49:08'),
(51, 17, 2, 1, '2023-08-22 20:49:08'),
(52, 18, 2, 1, '2023-08-22 20:49:09'),
(53, 19, 2, 1, '2023-08-22 20:49:09'),
(54, 20, 2, 1, '2023-08-22 20:49:10'),
(55, 21, 2, 1, '2023-08-22 20:49:11'),
(56, 22, 2, 1, '2023-08-22 20:49:11'),
(57, 23, 2, 1, '2023-08-22 20:49:11'),
(58, 24, 2, 1, '2023-08-22 20:49:11'),
(59, 25, 2, 1, '2023-08-22 20:49:12'),
(60, 26, 2, 1, '2023-08-22 20:49:12'),
(61, 27, 2, 1, '2023-08-22 20:49:13'),
(62, 28, 2, 1, '2023-08-22 20:49:14'),
(63, 29, 2, 1, '2023-08-22 20:49:14'),
(64, 30, 2, 1, '2023-08-22 20:49:14'),
(65, 31, 2, 1, '2023-08-22 20:49:15'),
(66, 32, 2, 1, '2023-08-22 20:49:15'),
(67, 33, 2, 1, '2023-08-22 20:49:15'),
(68, 34, 2, 1, '2023-08-22 20:49:16'),
(103, 1, 3, 3, '2023-08-22 20:52:56'),
(104, 2, 3, 3, '2023-08-22 20:52:56'),
(105, 3, 3, 3, '2023-08-22 20:52:56'),
(106, 4, 3, 3, '2023-08-22 20:52:56'),
(107, 5, 3, 3, '2023-08-22 20:52:56'),
(108, 6, 3, 3, '2023-08-22 20:52:56'),
(109, 7, 3, 3, '2023-08-22 20:52:56'),
(110, 8, 3, 3, '2023-08-22 20:52:56'),
(111, 9, 3, 3, '2023-08-22 20:52:56'),
(112, 10, 3, 3, '2023-08-22 20:52:56'),
(113, 11, 3, 3, '2023-08-22 20:52:56'),
(114, 12, 3, 3, '2023-08-22 20:52:56'),
(115, 13, 3, 3, '2023-08-22 20:52:56'),
(116, 14, 3, 3, '2023-08-22 20:52:56'),
(117, 15, 3, 3, '2023-08-22 20:52:56'),
(118, 16, 3, 3, '2023-08-22 20:52:57'),
(119, 17, 3, 3, '2023-08-22 20:52:57'),
(120, 18, 3, 3, '2023-08-22 20:52:57'),
(121, 19, 3, 3, '2023-08-22 20:52:57'),
(122, 20, 3, 3, '2023-08-22 20:52:57'),
(123, 21, 3, 3, '2023-08-22 20:52:57'),
(124, 22, 3, 3, '2023-08-22 20:52:57'),
(125, 23, 3, 3, '2023-08-22 20:52:57'),
(126, 24, 3, 3, '2023-08-22 20:52:57'),
(127, 25, 3, 3, '2023-08-22 20:52:57'),
(128, 26, 3, 3, '2023-08-22 20:52:57'),
(129, 27, 3, 3, '2023-08-22 20:52:57'),
(130, 28, 3, 3, '2023-08-22 20:52:57'),
(131, 29, 3, 3, '2023-08-22 20:52:57'),
(132, 30, 3, 3, '2023-08-22 20:52:57'),
(133, 31, 3, 3, '2023-08-22 20:52:57'),
(134, 32, 3, 3, '2023-08-22 20:52:58'),
(135, 33, 3, 3, '2023-08-22 20:52:58'),
(136, 34, 3, 3, '2023-08-22 20:52:59');

-- --------------------------------------------------------

--
-- Struktur dari tabel `materi`
--

CREATE TABLE `materi` (
  `kode_materi` int(11) NOT NULL,
  `judul_materi` varchar(255) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `tingkat` int(4) NOT NULL,
  `berkas` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `kode_pelajaran` int(11) NOT NULL,
  `kode_guru` int(11) DEFAULT NULL,
  `kode_admin` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `materi`
--

INSERT INTO `materi` (`kode_materi`, `judul_materi`, `keterangan`, `tingkat`, `berkas`, `created_at`, `kode_pelajaran`, `kode_guru`, `kode_admin`) VALUES
(1, 'judul percoobaan', 'percobaan', 7, '1693795954_1680323610_728263-1673318112 (1).pdf', '2023-09-04 02:52:34', 2, 1, NULL),
(2, 'Percobaan lagi', 'percobaan upload materi kelas 9', 9, '1694011149_1 Introduction.pdf', '2023-09-07 23:36:19', 2, 1, NULL),
(5, 'TIK', 'deskripsi percobaan', 7, '1694092320_Flash Cards_HIRA_fronts.pdf', '2023-09-07 13:12:00', 17, 35, NULL),
(6, 'Math', 'Deskripsi', 9, '1694129529_133416-1670571611.pdf', '2023-09-07 23:32:10', 2, NULL, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2023_02_27_120424_create_gurus_table', 1),
(6, '2023_03_02_050717_create_aadmins_table', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelajaran`
--

CREATE TABLE `pelajaran` (
  `kode_pelajaran` int(11) NOT NULL,
  `nama_pelajaran` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pelajaran`
--

INSERT INTO `pelajaran` (`kode_pelajaran`, `nama_pelajaran`) VALUES
(1, 'Bahasa Indonesia'),
(2, 'Matematika'),
(3, 'Ilmu Pengetahuan Alam'),
(4, 'Ilmu Pengetahuan Sosial'),
(5, 'Bahasa Inggris'),
(6, 'Pendidikan Agama dan Budi Pekerti'),
(7, 'Pendidikan Pancasila dan Kewarganegaraan'),
(8, 'Seni Budaya'),
(9, 'Bahasa Jawa'),
(10, 'Prakarya'),
(12, 'Pendidikan Jasmani, Olahraga dan Kesehatan'),
(17, 'Teknologi Informasi dan Komunikasi'),
(18, 'Bimbingan Konseling');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengampu`
--

CREATE TABLE `pengampu` (
  `id` int(11) NOT NULL,
  `kode_pelajaran` int(11) NOT NULL,
  `kode_kelas` int(11) NOT NULL,
  `kode_guru` int(11) NOT NULL,
  `link` varchar(250) DEFAULT NULL,
  `kode_thajaran` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pengampu`
--

INSERT INTO `pengampu` (`id`, `kode_pelajaran`, `kode_kelas`, `kode_guru`, `link`, `kode_thajaran`) VALUES
(4, 3, 6, 1, NULL, 1),
(5, 2, 3, 1, NULL, 3),
(6, 17, 1, 35, NULL, 3),
(7, 3, 6, 1, NULL, 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengumuman`
--

CREATE TABLE `pengumuman` (
  `id` int(11) NOT NULL,
  `judul_pengumuman` text NOT NULL,
  `deskripsi` text NOT NULL,
  `tgl_upload` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `kode_admin` int(11) DEFAULT NULL,
  `kode_guru` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pengumuman`
--

INSERT INTO `pengumuman` (`id`, `judul_pengumuman`, `deskripsi`, `tgl_upload`, `kode_admin`, `kode_guru`) VALUES
(1, 'Pengambilan Rapot', '<p><strong>Pengambilan Rapot akan dilaksanakan pada :</strong></p>\r\n<p>Hari, Tanggal&nbsp; : <strong>Sabtu, 23 Agustus 2023</strong></p>\r\n<p>Tempat&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;: <strong>Kelas Masing-masing</strong></p>\r\n<p>Jam&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; : <strong>08:00 - Selesai</strong></p>\r\n<p>Demikian untuk diperhatikan.&nbsp;&nbsp;</p>', '2023-08-22 15:25:34', NULL, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `presensi`
--

CREATE TABLE `presensi` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode_siswa` int(11) NOT NULL,
  `kode_kelas` int(11) NOT NULL,
  `status` enum('S','H','I','A','K') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'H',
  `tanggal_presensi` date NOT NULL,
  `kode_guru` bigint(20) UNSIGNED NOT NULL,
  `kode_pelajaran` int(11) NOT NULL,
  `kode_thajaran` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `presensi`
--

INSERT INTO `presensi` (`id`, `kode_siswa`, `kode_kelas`, `status`, `tanggal_presensi`, `kode_guru`, `kode_pelajaran`, `kode_thajaran`, `created_at`, `updated_at`) VALUES
(2, 2, 2, 'H', '2023-08-22', 1, 3, 1, '2023-08-22 00:53:55', '2023-08-22 00:53:55'),
(3, 3, 2, 'H', '2023-08-22', 1, 3, 1, '2023-08-22 00:53:56', '2023-08-22 00:53:56'),
(4, 4, 2, 'H', '2023-08-22', 1, 3, 1, '2023-08-22 00:53:56', '2023-08-22 00:53:56'),
(5, 5, 2, 'H', '2023-08-22', 1, 3, 1, '2023-08-22 00:53:56', '2023-08-22 00:53:56'),
(6, 6, 2, 'H', '2023-08-22', 1, 3, 1, '2023-08-22 00:53:56', '2023-08-22 00:53:56'),
(7, 7, 2, 'H', '2023-08-22', 1, 3, 1, '2023-08-22 00:53:56', '2023-08-22 00:53:56'),
(8, 8, 2, 'H', '2023-08-22', 1, 3, 1, '2023-08-22 00:53:56', '2023-08-22 00:53:56'),
(9, 9, 2, 'H', '2023-08-22', 1, 3, 1, '2023-08-22 00:53:56', '2023-08-22 00:53:56'),
(10, 10, 2, 'H', '2023-08-22', 1, 3, 1, '2023-08-22 00:53:56', '2023-08-22 00:53:56'),
(11, 11, 2, 'H', '2023-08-22', 1, 3, 1, '2023-08-22 00:53:56', '2023-08-22 00:53:56'),
(12, 12, 2, 'H', '2023-08-22', 1, 3, 1, '2023-08-22 00:53:56', '2023-08-22 00:53:56'),
(13, 13, 2, 'H', '2023-08-22', 1, 3, 1, '2023-08-22 00:53:56', '2023-08-22 00:53:56'),
(14, 14, 2, 'H', '2023-08-22', 1, 3, 1, '2023-08-22 00:53:56', '2023-08-22 00:53:56'),
(15, 15, 2, 'H', '2023-08-22', 1, 3, 1, '2023-08-22 00:53:56', '2023-08-22 00:53:56'),
(16, 16, 2, 'H', '2023-08-22', 1, 3, 1, '2023-08-22 00:53:56', '2023-08-22 00:53:56'),
(17, 17, 2, 'H', '2023-08-22', 1, 3, 1, '2023-08-22 00:53:57', '2023-08-22 00:53:57'),
(18, 18, 2, 'H', '2023-08-22', 1, 3, 1, '2023-08-22 00:53:57', '2023-08-22 00:53:57'),
(19, 19, 2, 'H', '2023-08-22', 1, 3, 1, '2023-08-22 00:53:57', '2023-08-22 00:53:57'),
(20, 20, 2, 'H', '2023-08-22', 1, 3, 1, '2023-08-22 00:53:57', '2023-08-22 00:53:57'),
(21, 21, 2, 'H', '2023-08-22', 1, 3, 1, '2023-08-22 00:53:57', '2023-08-22 00:53:57'),
(22, 22, 2, 'H', '2023-08-22', 1, 3, 1, '2023-08-22 00:53:57', '2023-08-22 00:53:57'),
(23, 23, 2, 'H', '2023-08-22', 1, 3, 1, '2023-08-22 00:53:57', '2023-08-22 00:53:57'),
(24, 24, 2, 'H', '2023-08-22', 1, 3, 1, '2023-08-22 00:53:57', '2023-08-22 00:53:57'),
(25, 25, 2, 'H', '2023-08-22', 1, 3, 1, '2023-08-22 00:53:57', '2023-08-22 00:53:57'),
(26, 26, 2, 'H', '2023-08-22', 1, 3, 1, '2023-08-22 00:53:57', '2023-08-22 00:53:57'),
(27, 27, 2, 'H', '2023-08-22', 1, 3, 1, '2023-08-22 00:53:57', '2023-08-22 00:53:57'),
(28, 28, 2, 'H', '2023-08-22', 1, 3, 1, '2023-08-22 00:53:57', '2023-08-22 00:53:57'),
(29, 29, 2, 'H', '2023-08-22', 1, 3, 1, '2023-08-22 00:53:57', '2023-08-22 00:53:57'),
(30, 30, 2, 'H', '2023-08-22', 1, 3, 1, '2023-08-22 00:53:57', '2023-08-22 00:53:57'),
(31, 31, 2, 'H', '2023-08-22', 1, 3, 1, '2023-08-22 00:53:57', '2023-08-22 00:53:57'),
(32, 32, 2, 'H', '2023-08-22', 1, 3, 1, '2023-08-22 00:53:57', '2023-08-22 00:53:57'),
(33, 33, 2, 'H', '2023-08-22', 1, 3, 1, '2023-08-22 00:53:57', '2023-08-22 00:53:57'),
(34, 34, 2, 'H', '2023-08-22', 1, 3, 1, '2023-08-22 00:53:58', '2023-08-22 00:53:58'),
(35, 1, 3, 'H', '2023-09-07', 1, 2, 3, '2023-09-07 01:21:30', '2023-09-07 01:21:30'),
(36, 2, 3, 'H', '2023-09-07', 1, 2, 3, '2023-09-07 01:21:30', '2023-09-07 01:21:30'),
(37, 3, 3, 'H', '2023-09-07', 1, 2, 3, '2023-09-07 01:21:30', '2023-09-07 01:21:30'),
(38, 4, 3, 'H', '2023-09-07', 1, 2, 3, '2023-09-07 01:21:30', '2023-09-07 01:21:30'),
(39, 5, 3, 'H', '2023-09-07', 1, 2, 3, '2023-09-07 01:21:30', '2023-09-07 01:21:30'),
(40, 6, 3, 'H', '2023-09-07', 1, 2, 3, '2023-09-07 01:21:30', '2023-09-07 01:21:30'),
(41, 7, 3, 'H', '2023-09-07', 1, 2, 3, '2023-09-07 01:21:31', '2023-09-07 01:21:31'),
(42, 8, 3, 'H', '2023-09-07', 1, 2, 3, '2023-09-07 01:21:31', '2023-09-07 01:21:31'),
(43, 9, 3, 'H', '2023-09-07', 1, 2, 3, '2023-09-07 01:21:31', '2023-09-07 01:21:31'),
(44, 10, 3, 'H', '2023-09-07', 1, 2, 3, '2023-09-07 01:21:31', '2023-09-07 01:21:31'),
(45, 11, 3, 'H', '2023-09-07', 1, 2, 3, '2023-09-07 01:21:31', '2023-09-07 01:21:31'),
(46, 12, 3, 'H', '2023-09-07', 1, 2, 3, '2023-09-07 01:21:32', '2023-09-07 01:21:32'),
(47, 13, 3, 'H', '2023-09-07', 1, 2, 3, '2023-09-07 01:21:32', '2023-09-07 01:21:32'),
(48, 14, 3, 'H', '2023-09-07', 1, 2, 3, '2023-09-07 01:21:32', '2023-09-07 01:21:32'),
(49, 15, 3, 'H', '2023-09-07', 1, 2, 3, '2023-09-07 01:21:32', '2023-09-07 01:21:32'),
(50, 16, 3, 'H', '2023-09-07', 1, 2, 3, '2023-09-07 01:21:32', '2023-09-07 01:21:32'),
(51, 17, 3, 'H', '2023-09-07', 1, 2, 3, '2023-09-07 01:21:32', '2023-09-07 01:21:32'),
(52, 18, 3, 'H', '2023-09-07', 1, 2, 3, '2023-09-07 01:21:32', '2023-09-07 01:21:32'),
(53, 19, 3, 'H', '2023-09-07', 1, 2, 3, '2023-09-07 01:21:32', '2023-09-07 01:21:32'),
(54, 20, 3, 'H', '2023-09-07', 1, 2, 3, '2023-09-07 01:21:32', '2023-09-07 01:21:32'),
(55, 21, 3, 'H', '2023-09-07', 1, 2, 3, '2023-09-07 01:21:32', '2023-09-07 01:21:32'),
(56, 22, 3, 'H', '2023-09-07', 1, 2, 3, '2023-09-07 01:21:32', '2023-09-07 01:21:32'),
(57, 23, 3, 'H', '2023-09-07', 1, 2, 3, '2023-09-07 01:21:33', '2023-09-07 01:21:33'),
(58, 24, 3, 'H', '2023-09-07', 1, 2, 3, '2023-09-07 01:21:33', '2023-09-07 01:21:33'),
(59, 25, 3, 'H', '2023-09-07', 1, 2, 3, '2023-09-07 01:21:33', '2023-09-07 01:21:33'),
(60, 26, 3, 'H', '2023-09-07', 1, 2, 3, '2023-09-07 01:21:33', '2023-09-07 01:21:33'),
(61, 27, 3, 'H', '2023-09-07', 1, 2, 3, '2023-09-07 01:21:33', '2023-09-07 01:21:33'),
(62, 28, 3, 'H', '2023-09-07', 1, 2, 3, '2023-09-07 01:21:33', '2023-09-07 01:21:33'),
(63, 29, 3, 'H', '2023-09-07', 1, 2, 3, '2023-09-07 01:21:33', '2023-09-07 01:21:33'),
(64, 30, 3, 'H', '2023-09-07', 1, 2, 3, '2023-09-07 01:21:33', '2023-09-07 01:21:33'),
(65, 31, 3, 'H', '2023-09-07', 1, 2, 3, '2023-09-07 01:21:33', '2023-09-07 01:21:33'),
(66, 32, 3, 'H', '2023-09-07', 1, 2, 3, '2023-09-07 01:21:33', '2023-09-07 01:21:33'),
(67, 33, 3, 'H', '2023-09-07', 1, 2, 3, '2023-09-07 01:21:33', '2023-09-07 01:21:33'),
(68, 34, 3, 'H', '2023-09-07', 1, 2, 3, '2023-09-07 01:21:33', '2023-09-07 01:21:33');

-- --------------------------------------------------------

--
-- Struktur dari tabel `siswa`
--

CREATE TABLE `siswa` (
  `kode_siswa` int(11) NOT NULL,
  `nis` bigint(20) NOT NULL,
  `nama_siswa` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `jenis_kelamin` varchar(20) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `telepon` varchar(15) DEFAULT NULL,
  `agama` varchar(30) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `siswa`
--

INSERT INTO `siswa` (`kode_siswa`, `nis`, `nama_siswa`, `username`, `jenis_kelamin`, `alamat`, `telepon`, `agama`, `foto`, `email`, `password`, `status`) VALUES
(1, 10914, 'ABDUL HANI ASOFARI', 'Abdul-10914', 'laki-laki', NULL, NULL, NULL, 'avatar-1.png', NULL, '$2y$10$ejUHI3mPrmgAE3EYSygKNOIXua0AzFA4yASzfpd03N9myDNp/b58y', 1),
(2, 10915, 'ABDUL ROKHMAN', 'Abdul-10915', NULL, NULL, NULL, NULL, 'avatar-2.png', NULL, '$2y$10$lJEBe38Bog9KMLsvA6Q72uITp9bdLDCLOoeZJ/8Q0dg51I8187Bqi', 1),
(3, 10916, 'ACHMAD KEVIN ANDI CAHYONO', 'Achmad-10916', NULL, NULL, NULL, NULL, 'avatar-3.png', NULL, '$2y$10$bY5TY8XErEMeDhzpfZMJxugZpqIgP5dntAfh6Vfg20xPJ31cLoGQi', 1),
(4, 10917, 'ADAM DUTA RISWANDA', 'Adam-10917', NULL, NULL, NULL, NULL, 'avatar-4.png', NULL, '$2y$10$lUWeaiKBPld.WD0jEWX.0.ZhuHkkOZ6H36DrbIrOpc7.b5X8cAG0S', 1),
(5, 10918, 'AHMAD RAASYID', 'Ahmad-10918', NULL, NULL, NULL, NULL, 'avatar-5.png', NULL, '$2y$10$YazbCBU6GBTx2iSoVBVeK.7QO.yp1qa3t3d6KDvl4YDaFXlDhwz/G', 1),
(6, 10919, 'AISAH NILAMSARI', 'Aisah-10919', NULL, NULL, NULL, NULL, 'avatar-6.png', NULL, '$2y$10$tdVEwcLV57YAgB7VRNGubOrjLU3D9xPWR6EG7leVu.cZDG4RvPFDW', 1),
(7, 10920, 'ARLINDHA JELITA ARUNDINA', 'Arlindha-10920', NULL, NULL, NULL, NULL, 'avatar-7.png', NULL, '$2y$10$G4uVnWwzhvEWX3yb919UC.aSLP458kAW9qWetpHZUzGc6Bki6S4OK', 1),
(8, 10921, 'ASSYIFAH ZAHRA FAUZIYAH', 'Assyifah-10921', NULL, NULL, NULL, NULL, 'avatar-8.png', NULL, '$2y$10$35.st2OBFFP185unZcraEuM7M16ObNhRHffm0LeZJFjsC6z3wogRK', 1),
(9, 10922, 'AUREL NOVIANA ANGGRAINI', 'Aurel-10922', NULL, NULL, NULL, NULL, 'avatar-9.png', NULL, '$2y$10$5nGP3CI4AmX2gJvKyztemuWqTGjvS8VaMposocVIgZ9iJ1asXfeji', 1),
(10, 10923, 'BUNGA OKTALITHA BERLIANA NURDHINI', 'Bunga-10923', NULL, NULL, NULL, NULL, 'avatar-10.png', NULL, '$2y$10$ZpNDh47RlANn3MPJtn0AIeKIl/IrTsnIrOPlwI3VGR6Inqf99RHg.', 1),
(11, 10924, 'DAFFA TEGAR HERMANSYAH', 'Daffa-10924', NULL, NULL, NULL, NULL, 'avatar-11.png', NULL, '$2y$10$L0vEcDC74Gs7cVojvwOD5OZWyVA91QQyMva37vFv9QHfCLRhdDzHC', 1),
(12, 10925, 'DEVANA ALICIA PUTRI', 'Devana-10925', NULL, NULL, NULL, NULL, 'avatar-12.png', NULL, '$2y$10$94wAaf4gpbclbBoYuHSvFeoNpoPV/OaeCDDcHrFAFuZQYeTEzvVtq', 1),
(13, 10926, 'DEVANDRA ARFA VALENTINO', 'Devandra-10926', NULL, NULL, NULL, NULL, 'avatar-13.png', NULL, '$2y$10$MQyKrmHex8lENtftlZBXGuzT7vSJRcL4P0LK8G6sMtijzHjaHVUSe', 1),
(14, 10927, 'DIMAS RAFANDA PRIYANTO', 'Dimas-10927', NULL, NULL, NULL, NULL, 'avatar-14.png', NULL, '$2y$10$nt6TuMHE1B7vtQ1KqwX7fep/qUGaMXWbyQZ7tIJqqbXz1xBkw1btm', 1),
(15, 10928, 'ELANO DAFFA ABQORY', 'Elano-10928', NULL, NULL, NULL, NULL, 'avatar-15.png', NULL, '$2y$10$Wt8jqgKq7yECx9.a0YV3RuAtapz5o6Dg/agVI9PQMwd4Xm27hJf92', 1),
(16, 10929, 'HAJARU ASWADA FAJRINA', 'Hajaru-10929', NULL, NULL, NULL, NULL, 'avatar-16.png', NULL, '$2y$10$bbYCAVDgcMrCy.FBI8ULQ.0Z2VSjcXpEPQG40edwkVCBIILdgvkfq', 1),
(17, 10930, 'IMA ERVINA MAR\'ATUS SHOLIKHAH', 'Ima-10930', NULL, NULL, NULL, NULL, 'avatar-17.png', NULL, '$2y$10$YEWrz68aD3eVVA466QT5/e56ZkDFEJIl.LMZS4GiwoHfII18Ym3xi', 1),
(18, 10931, 'INDIE ANDRIAS KRISTALOKA', 'Indie-10931', NULL, NULL, NULL, NULL, 'avatar-18.png', NULL, '$2y$10$GLzl3MvgkpjrmjXK/FLHmusyT71CgVa1XW7EG9oBVERU4xYn445Be', 1),
(19, 10932, 'INGGIL PUTRI HERMAWAN', 'Inggil-10932', NULL, NULL, NULL, NULL, 'avatar-19.png', NULL, '$2y$10$ewSxXVI1U61KWwc9NZWSBOH0ANaHV89aZ.c/znLRnizD6JCvyaR.C', 1),
(20, 10933, 'LILLAH SIFAAUL AFIAH', 'Lillah-10933', NULL, NULL, NULL, NULL, 'avatar-20.png', NULL, '$2y$10$/4.qdsXp9zmnE66Zvown5OBn4nJTbiNcd1E1zg4oAAy0fAAExofZy', 1),
(21, 10934, 'MARCELL FIRMANSYAH', 'Marcell-10934', NULL, NULL, NULL, NULL, 'avatar-1.png', NULL, '$2y$10$k3ZYCal0ZdlQMpSy/mW1Iua7X2.ulwNukguKdSJ6pdgIKggGSLg8S', 1),
(22, 10935, 'MEUTHIA RAMADHANI', 'Meuthia-10935', NULL, NULL, NULL, NULL, 'avatar-2.png', NULL, '$2y$10$9QMNgnu8z13f0snraRpqhOhMo43RWy0PZ4a7jLK1zfA4Igbyj2o1K', 1),
(23, 10936, 'MOKCO ALFIAN RAMADANI', 'Mokco-10936', NULL, NULL, NULL, NULL, 'avatar-3.png', NULL, '$2y$10$2XMvFdxKHcTvLBioeOa3ie6p75LlyU62Ik7SR.ynNpu6FxZNvlWuS', 1),
(24, 10937, 'MONICA VELYSIA BIAS AURORA', 'Monica-10937', NULL, NULL, NULL, NULL, 'avatar-4.png', NULL, '$2y$10$gTohUbwcimYhwWS/rJwIR.UVaqwl35mrHgtOjvCz8rw8OEUPScKS6', 1),
(25, 10938, 'MUHAMMAD FERDIANTO', 'Muhammad-10938', NULL, NULL, NULL, NULL, 'avatar-5.png', NULL, '$2y$10$8qEx84Gjx.vVdPVPStU8beySQ00eE2InHfts5hvyUhWDcOqC45UTW', 1),
(26, 10939, 'MUHAMMAD NAUFAL AZMIANSYAH', 'Muhammad-10939', NULL, NULL, NULL, NULL, 'avatar-6.png', NULL, '$2y$10$g03ghssSy5NNNDkhtPgcIeerTfDrTaFOzIN0Mrb.pM9k31bwshgEm', 1),
(27, 10940, 'NABILAH BILQIS DINA PURNA', 'Nabilah-10940', NULL, NULL, NULL, NULL, 'avatar-7.png', NULL, '$2y$10$R6BQWMXZA3Aa8rGQ1l56V.2HYayMac/lYpHnxxRhHWQjVFjlOt5BO', 1),
(28, 10941, 'NADINA AULIA MUNTAS', 'Nadina-10941', NULL, NULL, NULL, NULL, 'avatar-8.png', NULL, '$2y$10$.8XB8YO4Hq8mMtJb3ZIZ3ua4tjiwXN9WG4OrN4g9miAXGJCNDeeVu', 1),
(29, 10942, 'NIKEN AYU PRATIWI', 'Niken-10942', NULL, NULL, NULL, NULL, 'avatar-9.png', NULL, '$2y$10$uEQJHHQdPAih4TnDypzsEe7fShI8gu4RIR/Kgyj.XeYhnIiPIpuLi', 1),
(30, 10943, 'PRINATA NUR HIDAYAH', 'Prinata-10943', NULL, NULL, NULL, NULL, 'avatar-10.png', NULL, '$2y$10$0/5Wa7fNwQfbbTQmBwt8g.f4Azo3/N9xcLjH8Xed.QSkBKT7IvrUW', 1),
(31, 10944, 'REFAN ROZIQI', 'Refan-10944', NULL, NULL, NULL, NULL, 'avatar-11.png', NULL, '$2y$10$3Hy7JZDc78V.PZOYqozaSumHOZeNGhVXA.VInnHk0FVOqcI2gF6Cq', 1),
(32, 10945, 'TEGAR MUJIANTORO', 'Tegar-10945', NULL, NULL, NULL, NULL, 'avatar-12.png', NULL, '$2y$10$wOO.OHYWjAjC11kfg2lVsukYIMCVcMiw2EeSotNXWe0htgrD8BGle', 1),
(33, 10946, 'TIARA MELAWATI', 'Tiara-10946', NULL, NULL, NULL, NULL, 'avatar-13.png', NULL, '$2y$10$SEGRudWRv9wsBN467o6o1OO50BhS9CCOBef0A5mRlTUdqtG4Dy5.e', 1),
(34, 10947, 'WISNU MUKTI', 'Wisnu-10947', NULL, NULL, NULL, NULL, 'avatar-14.png', NULL, '$2y$10$LAin6lTUNO94lcFHljdaaeGlZTYmptKltuz5z0BsmcHtcNNpZywcG', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tahun_ajaran`
--

CREATE TABLE `tahun_ajaran` (
  `id` int(11) NOT NULL,
  `tahun_ajaran` varchar(20) NOT NULL,
  `status_aktif` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tahun_ajaran`
--

INSERT INTO `tahun_ajaran` (`id`, `tahun_ajaran`, `status_aktif`) VALUES
(1, '2022/2023', 0),
(3, '2023/2024', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tugas`
--

CREATE TABLE `tugas` (
  `kode_tugas` int(11) NOT NULL,
  `judul_tugas` varchar(255) NOT NULL,
  `keterangan` text NOT NULL,
  `berkas` varchar(255) NOT NULL,
  `kode_guru` int(11) NOT NULL,
  `kode_kelas` int(11) NOT NULL,
  `kode_pelajaran` int(11) NOT NULL,
  `kode_thajaran` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deadline` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tugas`
--

INSERT INTO `tugas` (`kode_tugas`, `judul_tugas`, `keterangan`, `berkas`, `kode_guru`, `kode_kelas`, `kode_pelajaran`, `kode_thajaran`, `created_at`, `deadline`) VALUES
(2, 'Tugas 1', 'Selesaikan Persamaan Linear 2 Variabel berikut ini :\r\n1.) x + y =10; 2x-5y = 11\r\n2.) 3x+4y = 12; 5x-y=9', '', 1, 3, 2, 3, '2023-09-06 03:38:51', '2023-09-07 10:07:00'),
(4, 'Tugas 2', '1. segitiga siku siku abc pada bagian a. panjang sisi AB= 21 cm dan sisi BC= 35 cm. berapa panjang jari jari luar lingkaran segitiga abc adalah…\r\n\r\n2. Luas alas dalam sebuah kubus 25 cm2, berapa volume kubus tersebut…', '', 1, 3, 2, 3, '2023-09-06 12:37:20', '2023-09-07 23:59:00'),
(6, 'Tugas 3', 'deskripsi tugas 3', '', 1, 3, 2, 3, '2023-09-07 12:27:18', '2023-09-08 23:59:00'),
(7, 'Tugas 1 - Dibuat dari ruang kelas', 'jika berhasil, maka akan muncul di halaman tugas', '', 1, 6, 3, 3, '2023-09-07 12:28:39', '2023-09-08 23:59:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `video`
--

CREATE TABLE `video` (
  `id` int(11) NOT NULL,
  `judul` text NOT NULL,
  `link` text NOT NULL,
  `tingkat` int(11) NOT NULL,
  `kode_guru` int(11) DEFAULT NULL,
  `kode_admin` int(11) DEFAULT NULL,
  `kode_pelajaran` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `video`
--

INSERT INTO `video` (`id`, `judul`, `link`, `tingkat`, `kode_guru`, `kode_admin`, `kode_pelajaran`, `created_at`, `updated_at`) VALUES
(1, 'Animation vs Math', 'https://www.youtube.com/watch?v=B1J6Ou4q8vE', 9, 1, NULL, 2, '2023-09-07 08:28:00', '2023-09-07 07:05:28'),
(7, 'Origins of the Universe 101', 'https://www.youtube.com/watch?v=HdPzOWlLrbE', 9, 1, NULL, 3, '2023-09-07 07:16:40', '2023-09-07 14:17:55'),
(8, 'Linear Equations - Algebra', 'https://www.youtube.com/watch?v=Ft2_QtXAnh8', 9, 1, NULL, 2, '2023-09-07 10:26:57', '2023-09-07 10:26:57'),
(9, 'How to use The VLOOKUP function in Excel', 'https://www.youtube.com/watch?v=ODZfwD39gGE', 8, 35, 1, 17, '2023-09-07 10:30:33', '2023-09-08 06:23:53'),
(11, 'Advanced Microsoft Word - Formatting Your Document', 'https://www.youtube.com/watch?v=Fvrtt0h84Mg', 7, 35, NULL, 17, '2023-09-07 10:39:29', '2023-09-07 10:39:29'),
(13, 'Membuat Surat Massal dengan Mail Merge di Microsoft Excel dan Word', 'https://www.youtube.com/watch?v=AEoyaqfkhn8', 8, 35, NULL, 17, '2023-09-07 10:49:42', '2023-09-07 10:49:42'),
(15, 'Pembentukan Bayangan pada Lensa Cembung', 'https://www.youtube.com/watch?v=orPQJE2x_60', 8, NULL, 1, 3, '2023-09-07 22:53:33', '2023-09-07 22:53:33'),
(16, 'Operasi Hitung Bilangan Bulat dan Pecahan', 'https://www.youtube.com/watch?v=h-11JDntAhk', 9, NULL, 1, 2, '2023-09-07 23:08:12', '2023-09-07 23:08:12');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`kode_admin`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `guru`
--
ALTER TABLE `guru`
  ADD PRIMARY KEY (`kode_guru`);

--
-- Indeks untuk tabel `jadwal`
--
ALTER TABLE `jadwal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jadwal_ibfk_1` (`kode_pengampu`);

--
-- Indeks untuk tabel `jawaban_tugas`
--
ALTER TABLE `jawaban_tugas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jawaban_tugas_ibfk_1` (`kode_siswa`),
  ADD KEY `jawaban_tugas_ibfk_2` (`kode_tugas`);

--
-- Indeks untuk tabel `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`kode_kelas`);

--
-- Indeks untuk tabel `kelas_siswa`
--
ALTER TABLE `kelas_siswa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kelas_siswa_ibfk_1` (`kode_thajaran`);

--
-- Indeks untuk tabel `materi`
--
ALTER TABLE `materi`
  ADD PRIMARY KEY (`kode_materi`),
  ADD KEY `kode_tingkat` (`kode_pelajaran`,`kode_guru`),
  ADD KEY `kode_admin` (`kode_admin`),
  ADD KEY `materi_ibfk_1` (`kode_guru`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pelajaran`
--
ALTER TABLE `pelajaran`
  ADD PRIMARY KEY (`kode_pelajaran`);

--
-- Indeks untuk tabel `pengampu`
--
ALTER TABLE `pengampu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kode_pelajaran` (`kode_pelajaran`),
  ADD KEY `pengampu_ibfk_1` (`kode_guru`);

--
-- Indeks untuk tabel `pengumuman`
--
ALTER TABLE `pengumuman`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kode_admin` (`kode_admin`),
  ADD KEY `pengumuman_ibfk_2` (`kode_guru`);

--
-- Indeks untuk tabel `presensi`
--
ALTER TABLE `presensi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kode_siswa` (`kode_siswa`);

--
-- Indeks untuk tabel `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`kode_siswa`);

--
-- Indeks untuk tabel `tahun_ajaran`
--
ALTER TABLE `tahun_ajaran`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tugas`
--
ALTER TABLE `tugas`
  ADD PRIMARY KEY (`kode_tugas`),
  ADD KEY `kode_kelas` (`kode_guru`),
  ADD KEY `tugas_ibfk_1` (`kode_pelajaran`);

--
-- Indeks untuk tabel `video`
--
ALTER TABLE `video`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `kode_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `guru`
--
ALTER TABLE `guru`
  MODIFY `kode_guru` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT untuk tabel `jadwal`
--
ALTER TABLE `jadwal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `jawaban_tugas`
--
ALTER TABLE `jawaban_tugas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `kelas_siswa`
--
ALTER TABLE `kelas_siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=137;

--
-- AUTO_INCREMENT untuk tabel `materi`
--
ALTER TABLE `materi`
  MODIFY `kode_materi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `pelajaran`
--
ALTER TABLE `pelajaran`
  MODIFY `kode_pelajaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `pengampu`
--
ALTER TABLE `pengampu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `pengumuman`
--
ALTER TABLE `pengumuman`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `presensi`
--
ALTER TABLE `presensi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT untuk tabel `siswa`
--
ALTER TABLE `siswa`
  MODIFY `kode_siswa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT untuk tabel `tahun_ajaran`
--
ALTER TABLE `tahun_ajaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `tugas`
--
ALTER TABLE `tugas`
  MODIFY `kode_tugas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `video`
--
ALTER TABLE `video`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `jadwal`
--
ALTER TABLE `jadwal`
  ADD CONSTRAINT `jadwal_ibfk_1` FOREIGN KEY (`kode_pengampu`) REFERENCES `pengampu` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `jawaban_tugas`
--
ALTER TABLE `jawaban_tugas`
  ADD CONSTRAINT `jawaban_tugas_ibfk_1` FOREIGN KEY (`kode_siswa`) REFERENCES `siswa` (`kode_siswa`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `jawaban_tugas_ibfk_2` FOREIGN KEY (`kode_tugas`) REFERENCES `tugas` (`kode_tugas`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `kelas_siswa`
--
ALTER TABLE `kelas_siswa`
  ADD CONSTRAINT `kelas_siswa_ibfk_1` FOREIGN KEY (`kode_thajaran`) REFERENCES `tahun_ajaran` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `materi`
--
ALTER TABLE `materi`
  ADD CONSTRAINT `materi_ibfk_1` FOREIGN KEY (`kode_guru`) REFERENCES `guru` (`kode_guru`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `materi_ibfk_2` FOREIGN KEY (`kode_pelajaran`) REFERENCES `pelajaran` (`kode_pelajaran`),
  ADD CONSTRAINT `materi_ibfk_4` FOREIGN KEY (`kode_admin`) REFERENCES `admin` (`kode_admin`);

--
-- Ketidakleluasaan untuk tabel `pengampu`
--
ALTER TABLE `pengampu`
  ADD CONSTRAINT `pengampu_ibfk_1` FOREIGN KEY (`kode_guru`) REFERENCES `guru` (`kode_guru`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pengampu_ibfk_3` FOREIGN KEY (`kode_pelajaran`) REFERENCES `pelajaran` (`kode_pelajaran`);

--
-- Ketidakleluasaan untuk tabel `pengumuman`
--
ALTER TABLE `pengumuman`
  ADD CONSTRAINT `pengumuman_ibfk_1` FOREIGN KEY (`kode_admin`) REFERENCES `admin` (`kode_admin`),
  ADD CONSTRAINT `pengumuman_ibfk_2` FOREIGN KEY (`kode_guru`) REFERENCES `guru` (`kode_guru`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `presensi`
--
ALTER TABLE `presensi`
  ADD CONSTRAINT `presensi_ibfk_1` FOREIGN KEY (`kode_siswa`) REFERENCES `siswa` (`kode_siswa`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
