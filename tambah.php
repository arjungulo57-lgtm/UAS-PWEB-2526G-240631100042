<?php
$pageTitle = 'Tambah Data';
require 'koneksi.php';

$errors = [];
$input  = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = koneksiDB();

    // Ambil & sanitasi input
    $input['nim']           = trim($_POST['nim'] ?? '');
    $input['nama']          = trim($_POST['nama'] ?? '');
    $input['prodi']         = trim($_POST['prodi'] ?? '');
    $input['angkatan']      = trim($_POST['angkatan'] ?? '');
    $input['jenis_kelamin'] = trim($_POST['jenis_kelamin'] ?? '');
    $input['email']         = trim($_POST['email'] ?? '');
    $input['alamat']        = trim($_POST['alamat'] ?? '');

    // Validasi
    if (empty($input['nim']))           $errors[] = 'NIM wajib diisi.';
    if (empty($input['nama']))          $errors[] = 'Nama wajib diisi.';
    if (empty($input['prodi']))         $errors[] = 'Program Studi wajib diisi.';
    if (empty($input['angkatan']))      $errors[] = 'Angkatan wajib diisi.';
    if (empty($input['jenis_kelamin'])) $errors[] = 'Jenis Kelamin wajib dipilih.';
    if (!empty($input['email']) && !filter_var($input['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Format email tidak valid.';
    }

    // Cek NIM duplikat
    $nimEsc = mysqli_real_escape_string($conn, $input['nim']);
    $cekNim = mysqli_query($conn, "SELECT id FROM mahasiswa WHERE nim='$nimEsc'");
    if (mysqli_num_rows($cekNim) > 0) $errors[] = 'NIM sudah terdaftar.';

    if (empty($errors)) {
        $nim    = mysqli_real_escape_string($conn, $input['nim']);
        $nama   = mysqli_real_escape_string($conn, $input['nama']);
        $prodi  = mysqli_real_escape_string($conn, $input['prodi']);
        $angk   = mysqli_real_escape_string($conn, $input['angkatan']);
        $jk     = mysqli_real_escape_string($conn, $input['jenis_kelamin']);
        $email  = mysqli_real_escape_string($conn, $input['email']);
        $alamat = mysqli_real_escape_string($conn, $input['alamat']);

        $sql = "INSERT INTO mahasiswa (nim, nama, prodi, angkatan, jenis_kelamin, email, alamat)
                VALUES ('$nim','$nama','$prodi','$angk','$jk','$email','$alamat')";

        if (mysqli_query($conn, $sql)) {
            tutupDB($conn);
            header('Location: daftar.php?pesan=tambah');
            exit;
        } else {
            $errors[] = 'Gagal menyimpan data: ' . mysqli_error($conn);
        }
    }
    tutupDB($conn);
}

require 'includes/header.php';

$prodiList = ['Teknik Informatika','Sistem Informasi','Manajemen Informatika','Teknik Komputer','Ilmu Komputer'];
?>

<div class="row justify-content-center">
    <div class="col-lg-8">

        <div class="d-flex align-items-center mb-4 gap-2">
            <a href="daftar.php" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
            <h4 class="fw-bold mb-0 ms-2"><i class="bi bi-person-plus-fill text-primary me-2"></i>Tambah Data Mahasiswa</h4>
        </div>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <strong><i class="bi bi-exclamation-triangle-fill me-1"></i>Terdapat kesalahan:</strong>
                <ul class="mb-0 mt-1">
                    <?php foreach ($errors as $err): ?>
                        <li><?= htmlspecialchars($err) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <div class="card form-card">
            <div class="card-header px-4 py-3">
                <i class="bi bi-person-vcard-fill me-2"></i>Form Data Mahasiswa
            </div>
            <div class="card-body p-4">
                <form method="POST" action="tambah.php">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">NIM <span class="text-danger">*</span></label>
                            <input type="text" name="nim" class="form-control" placeholder="Contoh: 230411100001"
                                   value="<?= htmlspecialchars($input['nim'] ?? '') ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="nama" class="form-control" placeholder="Nama mahasiswa"
                                   value="<?= htmlspecialchars($input['nama'] ?? '') ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Program Studi <span class="text-danger">*</span></label>
                            <select name="prodi" class="form-select" required>
                                <option value="">-- Pilih Prodi --</option>
                                <?php foreach ($prodiList as $p): ?>
                                    <option value="<?= $p ?>" <?= (($input['prodi'] ?? '') == $p) ? 'selected' : '' ?>>
                                        <?= $p ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Angkatan <span class="text-danger">*</span></label>
                            <select name="angkatan" class="form-select" required>
                                <option value="">-- Pilih Angkatan --</option>
                                <?php for ($y = date('Y'); $y >= 2018; $y--): ?>
                                    <option value="<?= $y ?>" <?= (($input['angkatan'] ?? '') == $y) ? 'selected' : '' ?>>
                                        <?= $y ?>
                                    </option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                            <select name="jenis_kelamin" class="form-select" required>
                                <option value="">-- Pilih --</option>
                                <option value="Laki-laki"  <?= (($input['jenis_kelamin'] ?? '') == 'Laki-laki')  ? 'selected' : '' ?>>Laki-laki</option>
                                <option value="Perempuan"  <?= (($input['jenis_kelamin'] ?? '') == 'Perempuan')  ? 'selected' : '' ?>>Perempuan</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="email@contoh.com"
                                   value="<?= htmlspecialchars($input['email'] ?? '') ?>">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Alamat</label>
                            <textarea name="alamat" class="form-control" rows="3"
                                      placeholder="Alamat lengkap..."><?= htmlspecialchars($input['alamat'] ?? '') ?></textarea>
                        </div>
                    </div>

                    <hr class="my-4">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-save-fill me-1"></i>Simpan Data
                        </button>
                        <a href="daftar.php" class="btn btn-outline-secondary px-4">Batal</a>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

<?php require 'includes/footer.php'; ?>
