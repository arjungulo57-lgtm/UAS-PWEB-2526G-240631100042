<?php
$pageTitle = 'Beranda';
require 'includes/header.php';
require 'koneksi.php';

$conn = koneksiDB();

// Hitung total mahasiswa
$totalMhs = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM mahasiswa"))['total'];

// Hitung per jenis kelamin
$totalPria  = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM mahasiswa WHERE jenis_kelamin='Laki-laki'"))['total'];
$totalWanita = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM mahasiswa WHERE jenis_kelamin='Perempuan'"))['total'];

// Mahasiswa terbaru (5 data)
$queryTerbaru = "SELECT * FROM mahasiswa ORDER BY id DESC LIMIT 5";
$resTerbaru   = mysqli_query($conn, $queryTerbaru);

tutupDB($conn);
?>

<!-- Hero Section -->
<div class="hero-section d-flex align-items-center justify-content-between flex-wrap gap-3">
    <div>
        <h1><i class="bi bi-mortarboard-fill me-2"></i>Sistem Pendataan Mahasiswa</h1>
        <p class="mb-0 opacity-75">Kelola data mahasiswa dengan mudah, cepat, dan efisien.</p>
    </div>
    <a href="tambah.php" class="btn btn-light btn-lg fw-semibold shadow-sm">
        <i class="bi bi-person-plus-fill me-2"></i>Tambah Mahasiswa
    </a>
</div>

<!-- Statistik Cards -->
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card stat-card text-white bg-primary">
            <div class="card-body d-flex align-items-center gap-3 py-4">
                <div class="stat-icon"><i class="bi bi-people-fill"></i></div>
                <div>
                    <div class="fs-1 fw-bold"><?= $totalMhs ?></div>
                    <div class="opacity-75">Total Mahasiswa</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stat-card text-white bg-info">
            <div class="card-body d-flex align-items-center gap-3 py-4">
                <div class="stat-icon"><i class="bi bi-gender-male"></i></div>
                <div>
                    <div class="fs-1 fw-bold"><?= $totalPria ?></div>
                    <div class="opacity-75">Laki-laki</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stat-card text-white bg-danger">
            <div class="card-body d-flex align-items-center gap-3 py-4">
                <div class="stat-icon"><i class="bi bi-gender-female"></i></div>
                <div>
                    <div class="fs-1 fw-bold"><?= $totalWanita ?></div>
                    <div class="opacity-75">Perempuan</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tabel Mahasiswa Terbaru -->
<div class="card table-card">
    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
        <h5 class="mb-0 fw-bold"><i class="bi bi-clock-history me-2 text-primary"></i>Mahasiswa Terbaru</h5>
        <a href="daftar.php" class="btn btn-primary btn-sm">Lihat Semua</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>NIM</th>
                        <th>Nama</th>
                        <th>Program Studi</th>
                        <th>Angkatan</th>
                        <th>Jenis Kelamin</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($resTerbaru) > 0): ?>
                        <?php while ($row = mysqli_fetch_assoc($resTerbaru)): ?>
                        <tr>
                            <td><code><?= htmlspecialchars($row['nim']) ?></code></td>
                            <td><?= htmlspecialchars($row['nama']) ?></td>
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
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="5" class="text-center text-muted py-4">Belum ada data mahasiswa.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require 'includes/footer.php'; ?>
