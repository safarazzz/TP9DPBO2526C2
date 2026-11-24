-- Database: mvp_kandidat_db
CREATE DATABASE IF NOT EXISTS `mvp_kandidat_db`;
USE `mvp_kandidat_db`;

CREATE TABLE IF NOT EXISTS `kandidat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `posisi` varchar(100) NOT NULL,
  `domisili` varchar(100) NOT NULL,
  `skorTes` int(11) NOT NULL DEFAULT 0,
  `pengalamanTahun` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `kandidat` (`id`, `nama`, `posisi`, `domisili`, `skorTes`, `pengalamanTahun`) VALUES
(1, 'Raka Pratama', 'Backend Developer', 'Bandung', 92, 3),
(2, 'Sinta Maharani', 'UI/UX Designer', 'Jakarta', 88, 2),
(3, 'Dimas Nugroho', 'Data Analyst', 'Yogyakarta', 85, 1),
(4, 'Nadia Kusuma', 'Frontend Developer', 'Surabaya', 90, 2),
(5, 'Bagas Setiawan', 'QA Engineer', 'Bandung', 81, 1);

CREATE TABLE IF NOT EXISTS `pewawancara` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `jabatan` varchar(100) NOT NULL,
  `departemen` varchar(100) NOT NULL,
  `tipe_wawancara` varchar(100) NOT NULL,
  `total_interview` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `pewawancara` (`id`, `nama`, `jabatan`, `departemen`, `tipe_wawancara`, `total_interview`) VALUES
(1, 'Hendro Wijaya', 'Tech Lead', 'IT & Engineering', 'Technical Interview', 18),
(2, 'Citra Lestari', 'Senior HR Specialist', 'Human Capital', 'HR & Culture Fit', 34),
(3, 'Farhan Pratama', 'Principal Designer', 'Product & Design', 'User / Portfolio Review', 12),
(4, 'Dian Safitri', 'Data Science Lead', 'Data & Analytics', 'Technical Interview', 9),
(5, 'Ari Santoso', 'Engineering Manager', 'IT & Engineering', 'Management Interview', 22);

