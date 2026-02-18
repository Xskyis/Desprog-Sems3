<?php
include 'views/header.php';

// Koneksi database dan model
require_once 'config/database.php';
require_once 'models/EmployeeModel.php';

$database = new Database();
$db = $database->getConnection();
$employeeModel = new EmployeeModel($db);

// Ambil data overview
$overview = $employeeModel->getEmployeeOverview();
?>
<h2>Ringkasan Gaji Karyawan</h2>
<p style="margin-bottom: 2rem; color: #666;">
    Ringkasan statistik gaji karyawan perusahaan.
</p>

<?php if ($overview): ?>
    <!-- Cards Summary -->
    <div class="dashboard-cards">
        <div class="card">
            <h3>Total Karyawan</h3>
            <div class="number"><?php echo $overview['total_employees']; ?></div>
        </div>
        <div class="card">
            <h3>Total Gaji per Bulan</h3>
            <div class="number">Rp <?php echo number_format(
                                        $overview['total_salary'],
                                        0,
                                        ',',
                                        '.'
                                    ); ?></div>
        </div>
        <div class="card">
            <h3>Rata-rata Masa Kerja</h3>
            <div class="number"><?php echo number_format(
                                        $overview['avg_tenure_years'],
                                        1,
                                        ',',
                                        '.'
                                    ); ?> tahun</div>
        </div>
    </div>
<?php else: ?>
    <p>Tidak ada data karyawan tersedia.</p>
<?php endif; ?>

<?php include 'views/footer.php'; ?>
