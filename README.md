# Janji

Saya Faridchi Trianda Safaraz dengan NIM 2506827 mengerjakan Tugas Praktikum 9 pada Mata Kuliah Desain dan Pemrograman Berorientasi Objek (DPBO) untuk keberkahan-Nya maka saya tidak melakukan kecurangan seperti yang telah dispesifikasikan. Aamiin

# Proyek MVP - Manajemen Data Rekrutmen

Aplikasi web ini dibangun dengan PHP murni (tanpa framework) dan MySQL, serta menerapkan pola **Model-View-Presenter (MVP)**. Fungsinya untuk mencatat dan mengelola data proses rekrutmen, yaitu **Kandidat** yang melamar dan **Pewawancara** yang menilai mereka.

## Arsitektur Program (MVP)

Kode dipisah menjadi tiga lapisan agar tiap bagian punya satu tanggung jawab yang jelas dan mudah dirawat.

1. **Model (`models/`)**
   - Menyimpan semua urusan data: koneksi database lewat PDO, query SQL, dan pemetaan hasil query menjadi objek.
   - `DB.php` menyediakan koneksi dan eksekusi query dengan prepared statement. `TabelKandidat.php` dan `TabelPewawancara.php` mewarisinya dan menerapkan interface `KontrakModel`.
   - `Kandidat.php` dan `Pewawancara.php` adalah kelas entitas untuk satu baris data.
2. **View (`views/`)**
   - Hanya bertugas menyusun tampilan HTML dari template. View tidak boleh menyentuh model maupun database.
   - `ViewKandidat.php` dan `ViewPewawancara.php` menerapkan interface `KontrakView`.
3. **Presenter (`presenters/`)**
   - Penghubung antara model dan view. Ia meminta data ke model, membuat potongan HTML baris tabel, lalu mengoper hasilnya ke view.
   - `PresenterKandidat.php` dan `PresenterPewawancara.php` menerapkan interface `KontrakPresenter`.

Method yang wajib ada pada tiap interface:

| Interface | Method |
|-----------|--------|
| `KontrakModel` | `getAllData`, `getDataById`, `addData`, `updateData`, `deleteData` |
| `KontrakView` | `renderDaftar`, `renderForm` |
| `KontrakPresenter` | `tampilkanData`, `tampilkanFormData`, `tambahData`, `ubahData`, `hapusData` |

### Alur Program

1. **Request masuk**: semua permintaan diterima oleh `index.php`.
2. **Pemilihan modul**: parameter `page` menentukan modul yang dipakai, yaitu `kandidat` (bawaan) atau `pewawancara`.
3. **Pembuatan objek**: `index.php` membuat satu set Model, View, dan Presenter untuk modul tersebut.
4. **Pemrosesan**:
   - Request **POST**: field `action` (`tambah`, `ubah`, `hapus`) menentukan method presenter yang dijalankan, kemudian browser diarahkan kembali ke halaman daftar.
   - Request **GET**: parameter `screen` memilih tampilan, yaitu daftar, form tambah (`add`), atau form ubah (`edit` beserta `id`).
   - Presenter memanggil model, model mengeksekusi query dan mengubah hasilnya menjadi objek entitas.
5. **Respons**: presenter menyerahkan data ke view, view mengisi `skin.html` (daftar) atau `form.html` (form), dan halaman jadi dikirim ke browser.

Kedua modul memakai template yang sama. `ViewKandidat` cukup mengganti token `{{...}}`, sedangkan `ViewPewawancara` terlebih dahulu mengubah judul, label kolom, dan nama input pada template menggunakan regex.

## Struktur Folder

```
TP9DPBO2526C2/
├── Project/
│   ├── models/
│   │   ├── DB.php
│   │   ├── KontrakModel.php
│   │   ├── Kandidat.php
│   │   ├── Pewawancara.php
│   │   ├── TabelKandidat.php
│   │   └── TabelPewawancara.php
│   │
│   ├── views/
│   │   ├── KontrakView.php
│   │   ├── ViewKandidat.php
│   │   └── ViewPewawancara.php
│   │
│   ├── presenters/
│   │   ├── KontrakPresenter.php
│   │   ├── PresenterKandidat.php
│   │   └── PresenterPewawancara.php
│   │
│   ├── template/
│   │   ├── skin.html
│   │   └── form.html
│   │
│   └── index.php
│
├── Dokumentasi/
│   └── dokumentasitp9.mp4
│
├── mvp_db.sql
└── README.md
```

## Database

```sql
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
```

**Tabel `kandidat`**

| Kolom | Tipe | Catatan |
|-------|------|---------|
| id | int | primary key, auto increment |
| nama | varchar(100) | |
| posisi | varchar(100) | posisi yang dilamar |
| domisili | varchar(100) | |
| skorTes | int | default 0 |
| pengalamanTahun | int | default 0 |

**Tabel `pewawancara`**

| Kolom | Tipe | Catatan |
|-------|------|---------|
| id | int | primary key, auto increment |
| nama | varchar(100) | |
| jabatan | varchar(100) | |
| departemen | varchar(100) | |
| tipe_wawancara | varchar(100) | contoh: Technical Interview |
| total_interview | int | default 0 |

## Fitur CRUD

Dua entitas didukung penuh oleh operasi tambah, lihat, ubah, dan hapus:

1. **Kandidat**
   - Tambah lewat form berisi nama, posisi dilamar, domisili, skor tes (0-100), dan lama pengalaman.
   - Lihat dalam tabel yang diurutkan dari skor tes tertinggi, lengkap dengan jumlah total kandidat.
   - Ubah data melalui form yang sudah terisi nilai lama.
   - Hapus lewat tombol dengan dialog konfirmasi.
2. **Pewawancara**
   - Tambah lewat form berisi nama, jabatan, departemen, tipe wawancara, dan total sesi interview.
   - Lihat dalam tabel yang diurutkan dari jumlah interview terbanyak, lengkap dengan jumlah total pewawancara.
   - Ubah data melalui form yang sudah terisi nilai lama.
   - Hapus lewat tombol dengan dialog konfirmasi.

Perpindahan antar modul dilakukan dengan dua tab di bagian atas halaman.

## Dokumentasi

https://github.com/user-attachments/assets/1708d63f-4d5b-4a37-a216-d1602f43a9b8