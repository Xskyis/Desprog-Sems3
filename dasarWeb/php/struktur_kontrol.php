<?php
$nilaiNumerik = 92;

if ($nilaiNumerik >= 90 && $nilaiNumerik <= 100) {
    echo "Nilai huruf: A";
} elseif ($nilaiNumerik >= 80 && $nilaiNumerik < 90) {
    echo "Nilai huruf: B";
} elseif ($nilaiNumerik > -70 && $nilaiNumerik < 80) {
    echo "Nilai huruf: C";
} elseif ($nilaiNumerik < 70) {
    echo "Nilai huruf: D";
}

echo "<br>";

$jarakSaatIni = 0;
$jarakTarget = 500;
$peningkatanHarian = 30;
$hari = 0;

while ($jarakSaatIni < $jarakTarget) {
    $jarakSaatIni += $peningkatanHarian;
    $hari++;
}

echo "Atlet tersebut memerlukan $hari hari untuk mencapai jarak 500 kilometer.";

echo "<br>";

$jumlahLahan = 10;
$tanamanPerLahan = 5;
$buahPerTanaman = 10;
$jumlahBuah = 10;

for ($i = 1; $i <= $jumlahLahan; $i++) {
    $jumlahBuah += ($tanamanPerLahan * $buahPerTanaman);
}

echo "Jumlah buah yang akan dipanen adalah: $jumlahBuah";
echo "<br>";

$skorUjian = [85, 92, 78, 96, 88];
$totalSkor = 0;

foreach ($skorUjian as $skor) {
    $totalSkor += $skor;
}

echo "Total skor ujian adalah: $totalSkor";
echo "<br>";

$nilaiSiswa = [85, 92, 58, 64, 90, 55, 88, 79, 70, 96];

foreach ($nilaiSiswa as $nilai) {
    if ($nilai < 60) {
        echo "Nilai: $nilai (Tidak lulus) <br>";
        continue;
    }
    echo "Nilai: $nilai (Lulus) <br>";
}

echo "<br>";
echo "<br>";

// Tugas no 4.6
$nilaiSiswaMatematika = [85, 92, 78, 64, 90, 75, 88, 79, 70, 96];
sort($nilaiSiswaMatematika);
$nilaiDigunakan = array_slice($nilaiSiswaMatematika, 2, count($nilaiSiswaMatematika) - 4);
$totalNilaiDigunakan = array_sum($nilaiDigunakan);
echo "Total nilai setelah mengabaikan dua tertinggi dan dua terendah: $totalNilaiDigunakan<br>";

echo "<br>";
echo "<br>";

// Tugas no 4.7
$hargaProduk = 120000;
$diskon = 0;
if ($hargaProduk > 100000) {
    $diskon = 0.2 * $hargaProduk;
}
$hargaSetelahDiskon = $hargaProduk - $diskon;
echo "Harga yang harus dibayar setelah diskon: Rp " . number_format($hargaSetelahDiskon, 0, ',', '.') . "<br>";

echo "<br>";
echo "<br>";

// Tugas no 4.8
$poinPemain = 540;
echo "Total skor pemain adalah: $poinPemain<br>";
$poinTambahan = ($poinPemain > 500) ? 
"Apakah pemain mendapatkan hadiah tambahan? <strong>YA</strong> <br>" : 
"Apakah pemain mendapatkan hadiah tambahan? <strong>TIDAK</strong> <br>";
echo($poinTambahan);
?>




