<?php
$pageTitle = 'Edit Data';
require 'koneksi.php';

$conn = koneksiDB();
$errors = [];

// Ambil ID
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Ambil data lama
$dataMhs = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM mahasiswa WHERE id=$id"));
if (!$dataMhs) {
    header('Location: daftar.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = [
        'nim'           => trim($_POST['nim'] ?? ''),
        'nama'          => trim($_POST['nama'] ?? ''),
        'prodi'         => trim($_POST['prodi'] ?? ''),
        'angkatan'      => trim($_POST['angkatan'] ?? ''),
        'jenis_kelamin' => trim($_POST['jenis_kelamin'] ?? ''),
        'email'         => trim($_POST['email'] ?? ''),
        'alamat'        => trim($_POST['alamat'] ?? ''),
    ];

    // Validasi
    if (empty($input['nim']))           $errors[] = 'NIM wajib diisi.';
    if (empty($input['nama']))          $errors[] = 'Nama wajib diisi.';
    if (empty($input['prodi']))         $errors[] = 'Program Studi wajib diisi.';
    if (empty($input['angkatan']))      $errors[] = 'Angkatan wajib diisi.';
    if (empty($input['jenis_kelamin'])) $errors[] = 'Jenis Kelamin wajib dipilih.';
    if (!empty($input['email']) && !filter_var($input['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Format email tidak valid.';
    }

    // Cek NIM duplikat (kecuali milik sendiri)
    $nimEsc = mysqli_real_escape_string($conn, $input['nim']);
    $cekNim = mysqli_query($conn, "SELECT id FROM mahasiswa WHERE nim='$nimEsc' AND id != $id");
    if (mysqli_num_rows($cekNim) > 0) $errors[] = 'NIM sudah digunakan mahasiswa lain.';

    if (empty($errors)) {
        $nim    = mysqli_real_escape_string($conn, $input['nim']);
        $nama   = mysqli_real_escape_string($conn, $input['nama']);
        $prodi  = mysqli_real_escape_string($conn, $input['prodi']);
        $angk   = mysqli_real_escape_string($conn, $input['angkatan']);
        $jk     = mysqli_real_escape_string($conn, $input['jenis_kelamin']);
        $email  = mysqli_real_escape_string($conn, $input['email']);
        $alamat = mysqli_real_escape_string($conn, $input['alamat']);

        $sql = "UPDATE mahasiswa SET
                    nim='$nim', nama='$nama', prodi='$prodi',
                    angkatan='$angk', jenis_kelamin='$jk',
                    email='$email', alamat='$alamat'
                WHERE id=$id";

        if (mysqli_query($conn, $sql)) {
            tutupDB($conn);
            header('Location: daftar.php?pesan=edit');
            exit;
        } else {
            $errors[] = 'Gagal memperbarui data: ' . mysqli_error($conn);
        }
    }
    // Update tampilan form dengan input baru
    $dataMhs = $input;
}

tutupDB($conn);
require 'includes/header.php';

$prodiList = ['Teknik Informatika','Sistem Informasi','Manajemen Informatika','Teknik Komputer','Ilmu Komputer'];
?>

<div class="row justify-content-center">
    <div class="col-lg-8">

        <div class="d-flex align-items-center mb-4 gap-2">
            <a href="daftar.php" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
            <h4 class="fw-bold mb-0 ms-2"><i class="bi bi-pencil-square text-warning me-2"></i>Edit Data Mahasiswa</h4>
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
                <i class="bi bi-person-vcard-fill me-2"></i>Edit Data: <?= htmlspecialchars($dataMhs['nama']) ?>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="edit.php?id=<?= $id ?>">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">NIM <span class="text-danger">*</span></label>
                            <input type="text" name="nim" class="form-control"
                                   value="<?= htmlspecialchars($dataMhs['nim']) ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="nama" class="form-control"
                                   value="<?= htmlspecialchars($dataMhs['nama']) ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Program Studi <span class="text-danger">*</span></label>
                            <select name="prodi" class="form-select" required>
                                <option value="">-- Pilih Prodi --</option>
                                <?php foreach ($prodiList as $p): ?>
                                    <option value="<?= $p ?>" <?= ($dataMhs['prodi'] == $p) ? 'selected' : '' ?>>
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
                                    <option value="<?= $y ?>" <?= ($dataMhs['angkatan'] == $y) ? 'selected' : '' ?>>
                                        <?= $y ?>
                                    </option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                            <select name="jenis_kelamin" class="form-select" required>
                                <option value="">-- Pilih --</option>
                                <option value="Laki-laki"  <?= ($dataMhs['jenis_kelamin'] == 'Laki-laki')  ? 'selected' : '' ?>>Laki-laki</option>
                                <option value="Perempuan"  <?= ($dataMhs['jenis_kelamin'] == 'Perempuan')  ? 'selected' : '' ?>>Perempuan</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control"
                                   value="<?= htmlspecialchars($dataMhs['email']) ?>">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Alamat</label>
                            <textarea name="alamat" class="form-control" rows="3"><?= htmlspecialchars($dataMhs['alamat']) ?></textarea>
                        </div>
                    </div>

                    <hr class="my-4">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-warning px-4">
                            <i class="bi bi-save-fill me-1"></i>Perbarui Data
                        </button>
                        <a href="daftar.php" class="btn btn-outline-secondary px-4">Batal</a>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

<?php require 'includes/footer.php'; ?>
