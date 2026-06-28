# Sistem Pendataan Mahasiswa

> Dibuat menggunakan GenAI (Claude - Anthropic) sebagai alat bantu pengembangan.

---

## Identitas

| | |
|---|---|
| **Nama** | Arjun Joseph Gulo |
| **NIM** | 240631100042 |
| **Judul Aplikasi** | Sistem Pendataan Mahasiswa |

---

## Deskripsi Singkat

Aplikasi web berbasis PHP Native dan MySQL untuk mengelola data mahasiswa secara lengkap. Fitur utama meliputi:
- Menampilkan statistik total mahasiswa, jumlah laki-laki, dan perempuan
- Menambah, mengedit, dan menghapus data mahasiswa (CRUD)
- Pencarian data berdasarkan nama, NIM, atau program studi
- Tampilan responsif menggunakan Bootstrap 5

---

## Screenshot Aplikasi

> *(Tambahkan screenshot di sini setelah aplikasi dijalankan)*

| Halaman | Preview |
|---------|---------|
| Beranda | `img/beranda.png` |
| Daftar Mahasiswa | `img/daftar.png` |
| Tambah Data | `img/tambah.png` |
| Edit Data | `img/edit.png` |

---

## Struktur Database

**Database:** `db_mahasiswa`

**Tabel:** `mahasiswa`

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| `id` | INT AUTO_INCREMENT | Primary Key |
| `nim` | VARCHAR(20) UNIQUE | Nomor Induk Mahasiswa |
| `nama` | VARCHAR(100) | Nama lengkap |
| `prodi` | VARCHAR(60) | Program studi |
| `angkatan` | YEAR | Tahun angkatan |
| `jenis_kelamin` | ENUM | Laki-laki / Perempuan |
| `email` | VARCHAR(100) | Alamat email |
| `alamat` | TEXT | Alamat tempat tinggal |
| `created_at` | TIMESTAMP | Waktu entri data |

---

## Cara Menjalankan Aplikasi

### Prasyarat
- **XAMPP** (atau Laragon / WAMP)
- PHP >= 7.4
- MySQL >= 5.7

### Langkah-langkah

1. **Clone / Download** repository ini ke folder `htdocs` XAMPP:
   ```
   C:\xampp\htdocs\UAS-PWEB-NIM\
   ```

2. **Import database** melalui phpMyAdmin:
   - Buka `http://localhost/phpmyadmin`
   - Klik **Import** → pilih file `database.sql`
   - Klik **Go**

3. **Konfigurasi koneksi** (jika perlu) di file `koneksi.php`:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'root');   // sesuaikan username
   define('DB_PASS', '');       // sesuaikan password
   define('DB_NAME', 'db_mahasiswa');
   ```

4. **Jalankan aplikasi** di browser:
   ```
   http://localhost/UAS-PWEB-NIM/
   ```

---

## Struktur File

```
UAS-PWEB-NIM/
├── index.php          ← Beranda / Dashboard
├── daftar.php         ← Daftar semua mahasiswa
├── tambah.php         ← Form tambah data
├── edit.php           ← Form edit data
├── hapus.php          ← Proses hapus data
├── koneksi.php        ← Konfigurasi database
├── database.sql       ← File SQL database
├── css/
│   └── style.css      ← Stylesheet eksternal
├── includes/
│   ├── header.php     ← Template header & navbar
│   └── footer.php     ← Template footer
├── img/               ← Screenshot aplikasi
└── README.md
```

---

## Teknologi yang Digunakan

- **HTML5** – Struktur halaman
- **CSS3 + Bootstrap 5** – Tampilan responsif
- **PHP Native** – Logic server-side (variabel, percabangan, perulangan, fungsi, include, form processing, CRUD)
- **MySQL** – Penyimpanan data

---

*Dikembangkan dengan bantuan GenAI (Claude - Anthropic)*
