<?php
$pageTitle = 'Daftar Mahasiswa';
require 'includes/header.php';
require 'koneksi.php';

$conn = koneksiDB();

// Pesan sukses dari redirect
$pesan = '';
if (isset($_GET['pesan'])) {
    if ($_GET['pesan'] == 'tambah')  $pesan = '<div class="alert alert-success"><i class="bi bi-check-circle-fill me-2"></i>Data mahasiswa berhasil ditambahkan!</div>';
    if ($_GET['pesan'] == 'edit')    $pesan = '<div class="alert alert-info"><i class="bi bi-pencil-fill me-2"></i>Data mahasiswa berhasil diperbarui!</div>';
    if ($_GET['pesan'] == 'hapus')   $pesan = '<div class="alert alert-warning"><i class="bi bi-trash-fill me-2"></i>Data mahasiswa berhasil dihapus!</div>';
}

// Pencarian
$cari = isset($_GET['cari']) ? mysqli_real_escape_string($conn, trim($_GET['cari'])) : '';
$kondisi = $cari ? "WHERE nama LIKE '%$cari%' OR nim LIKE '%$cari%' OR prodi LIKE '%$cari%'" : '';

$query  = "SELECT * FROM mahasiswa $kondisi ORDER BY id DESC";
$result = mysqli_query($conn, $query);
$total  = mysqli_num_rows($result);

tutupDB($conn);
?>

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <h4 class="fw-bold mb-0"><i class="bi bi-table me-2 text-primary"></i>Daftar Mahasiswa</h4>
    <a href="tambah.php" class="btn btn-primary">
        <i class="bi bi-person-plus-fill me-1"></i>Tambah Mahasiswa
    </a>
</div>

<?= $pesan ?>

<!-- Form Pencarian -->
<form method="GET" action="daftar.php" class="mb-3">
    <div class="input-group">
        <span class="input-group-text bg-white"><i class="bi bi-search text-primary"></i></span>
        <input type="text" name="cari" class="form-control search-box" placeholder="Cari nama, NIM, atau prodi..."
               value="<?= htmlspecialchars($cari) ?>">
        <button type="submit" class="btn btn-primary">Cari</button>
        <?php if ($cari): ?>
            <a href="daftar.php" class="btn btn-outline-secondary">Reset</a>
        <?php endif; ?>
    </div>
</form>

<p class="text-muted small mb-2">
    Menampilkan <strong><?= $total ?></strong> data<?= $cari ? " untuk pencarian \"<em>$cari</em>\"" : '' ?>.
</p>

<!-- Tabel -->
<div class="card table-card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>NIM</th>
                        <th>Nama</th>
                        <th>Program Studi</th>
                        <th>Angkatan</th>
                        <th>Jenis Kelamin</th>
                        <th>Email</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($total > 0): ?>
                        <?php $no = 1; while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><code><?= htmlspecialchars($row['nim']) ?></code></td>
                            <td class="fw-semibold"><?= htmlspecialchars($row['nama']) ?></td>
                            <td>
                                <span class="badge bg-primary badge-prodi">
                                    <?= htmlspecialchars($row['prodi']) ?>
                                </span>
                            </td>
                            <td><?= htmlspecialchars($row['angkatan']) ?></td>
                            <td>
                                <?php if ($row['jenis_kelamin'] == 'Laki-laki'): ?>
                                    <span class="badge bg-info"><i class="bi bi-gender-male"></i> Laki-laki</span>
                                <?php else: ?>
                                    <span class="badge bg-danger"><i class="bi bi-gender-female"></i> Perempuan</span>
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($row['email']) ?></td>
                            <td class="text-center">
                                <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-action me-1">
                                    <i class="bi bi-pencil-fill"></i> Edit
                                </a>
                                <a href="hapus.php?id=<?= $row['id'] ?>"
                                   class="btn btn-danger btn-action"
                                   onclick="return confirm('Yakin hapus data <?= htmlspecialchars($row['nama']) ?>?')">
                                    <i class="bi bi-trash-fill"></i> Hapus
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center text-muted py-5">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                <?= $cari ? 'Data tidak ditemukan.' : 'Belum ada data mahasiswa.' ?>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require 'includes/footer.php'; ?>
