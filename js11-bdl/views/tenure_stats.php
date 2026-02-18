<?php
include 'views/header.php';
// Koneksi database dan model
require_once 'config/database.php';
require_once 'models/EmployeeModel.php';

$database = new Database();
$pdo = $database->getConnection();
$employeeModel = new EmployeeModel($pdo);
?>
<h2>Statistik Masa Kerja Karyawan</h2>
<p style="margin-bottom: 2rem; color: #666;">
    Statistik berikut menampilkan jumlah karyawan berdasarkan masa kerja:
<ul style="margin-left: 1rem;">
    <li><strong>Junior:</strong> &lt; 1 tahun</li>
    <li><strong>Middle:</strong> 1-3 tahun</li>
    <li><strong>Senior:</strong> &gt; 3 tahun</li>
</ul>
</p>
<?php
$tenure_stmt = $employeeModel->getTenureStats();
$tenure_stats = $tenure_stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<?php if ($tenure_stats && count($tenure_stats) > 0): ?>
    <table class="data-table">
        <thead>
            <tr>
                <th>Kategori Masa Kerja</th>
                <th>Jumlah Karyawan</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tenure_stats as $row): ?>
                <tr>
                    <td><strong><?php echo htmlspecialchars($row['tenure_group']); ?></strong></td>
                    <td><?php echo $row['total_karyawan']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>Tidak ada data masa kerja karyawan tersedia.</p>
<?php endif; ?>
<?php include 'views/footer.php'; ?>