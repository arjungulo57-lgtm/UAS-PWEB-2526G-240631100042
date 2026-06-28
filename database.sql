-- ============================================
-- Sistem Pendataan Mahasiswa
-- File   : database.sql
-- ============================================

CREATE DATABASE IF NOT EXISTS db_mahasiswa
    DEFAULT CHARACTER SET utf8
    DEFAULT COLLATE utf8_general_ci;

USE db_mahasiswa;

-- Hapus tabel jika sudah ada
DROP TABLE IF EXISTS mahasiswa;

-- Buat tabel mahasiswa
CREATE TABLE mahasiswa (
    id            INT(11)      NOT NULL AUTO_INCREMENT,
    nim           VARCHAR(20)  NOT NULL UNIQUE,
    nama          VARCHAR(100) NOT NULL,
    prodi         VARCHAR(60)  NOT NULL,
    angkatan      YEAR         NOT NULL,
    jenis_kelamin ENUM('Laki-laki','Perempuan') NOT NULL,
    email         VARCHAR(100) DEFAULT '',
    alamat        TEXT         DEFAULT '',
    created_at    TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data awal (minimal 5 record)
INSERT INTO mahasiswa (nim, nama, prodi, angkatan, jenis_kelamin, email, alamat) VALUES
('230411100001', 'Andi Pratama',        'Teknik Informatika',    2023, 'Laki-laki',  'andi@email.com',    'Jl. Merdeka No. 1, Surabaya'),
('230411100002', 'Siti Rahayu',         'Sistem Informasi',      2023, 'Perempuan',  'siti@email.com',    'Jl. Pahlawan No. 5, Malang'),
('220411100010', 'Budi Santoso',        'Manajemen Informatika', 2022, 'Laki-laki',  'budi@email.com',    'Jl. Ahmad Yani No. 12, Surabaya'),
('220411100011', 'Dewi Lestari',        'Teknik Komputer',       2022, 'Perempuan',  'dewi@email.com',    'Jl. Sudirman No. 8, Sidoarjo'),
('210411100020', 'Rizky Firmansyah',    'Ilmu Komputer',         2021, 'Laki-laki',  'rizky@email.com',   'Jl. Diponegoro No. 3, Gresik'),
('210411100021', 'Nur Aini',            'Teknik Informatika',    2021, 'Perempuan',  'nuraini@email.com', 'Jl. Veteran No. 7, Surabaya'),
('240411100005', 'Fajar Kurniawan',     'Sistem Informasi',      2024, 'Laki-laki',  'fajar@email.com',   'Jl. Raya Darmo No. 15, Surabaya');
