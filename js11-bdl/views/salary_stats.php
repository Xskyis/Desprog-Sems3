<?php
include 'views/header.php';
?>
<h2>Statistik Gaji</h2>
<p style="margin-bottom: 2rem; color: #666;">
    Data statistik gaji berikut diambil dari VIEW <code>salary_stats_by_department</code> di
    database PostgreSQL.
</p>
<?php if ($salary_stats->rowCount() > 0): ?>
    <!-- Cards Summary -->
    <div class="dashboard-cards">
        <?php
        // Hitung total statistics
        $salary_stats->execute();
        $all_stats = $salary_stats->fetchAll(PDO::FETCH_ASSOC);
        $total_employees = array_sum(array_column($all_stats, 'total_employees'));
        $total_salary_budget = array_sum(array_column(
            $all_stats,
            'total_salary_budget'
        ));
        $avg_salary_all = $total_employees > 0 ? ($total_salary_budget / $total_employees) : 0;
        ?>
        <!-- Tabel Statistik Detail -->
        <table class="data-table">
            <thead>
                <tr>
                    <th>Departemen</th>
                    <th>Jumlah Karyawan</th>
                    <th>Gaji Rata-rata</th>
                    <th>Gaji Terendah</th>
                    <th>Gaji Tertinggi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($stats as $row): ?>
                    <tr>
                        <td><b><?php echo htmlspecialchars($row['department'] ?? ''); ?></b></td>
                        <td><?php echo isset($row['total_employees']) ? $row['total_employees'] : 0; ?></td>
                        <td>Rp <?php echo number_format(
                                    isset($row['avg_salary']) && $row['avg_salary'] !== null ? $row['avg_salary'] : 0,
                                    0,
                                    ',',
                                    '.'
                                ); ?></td>
                        <td>Rp <?php echo number_format(
                                    isset($row['min_salary']) && $row['min_salary'] !== null ? $row['min_salary'] : 0,
                                    0,
                                    ',',
                                    '.'
                                ); ?></td>
                        <td>Rp <?php echo number_format(
                                    isset($row['max_salary']) && $row['max_salary'] !== null ? $row['max_salary'] : 0,
                                    0,
                                    ',',
                                    '.'
                                ); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Tidak ada data statistik gaji tersedia.</p>
    <?php endif; ?>
    <?php include 'views/footer.php'; ?>