<?php 
$a = 10;
$b = 5;

$hasilTambah = $a + $b;
$hasilKurang = $a - $b;
$hasilKali = $a * $b;
$hasilBagi = $a / $b;
$sisaBagi = $a % $b;
$pangkat = $a ** $b;

echo "Hasil Tambah: {$hasilTambah} <br>";
echo "Hasil Kurang: {$hasilKurang} <br>";
echo "Hasil Kali: {$hasilKali} <br>";
echo "Hasil Bagi: {$hasilBagi} <br>";
echo "Hasil SisaBagi: {$sisaBagi} <br>";
echo "Hasil Pangkat: {$pangkat} <br>";

$hasilSama = $a == $b;
$hasilTidakSama = $a != $b;
$hasilLebihKecil = $a < $b;
$hasilLebihBesar = $a > $b;
$hasilLebihKecilSama = $a <= $b;
$hasilLebihBesarSama = $a >= $b;

echo "Hasil Sama: {$hasilSama} <br>";
echo "Hasil Tidak Sama: {$hasilTidakSama} <br>";
echo "Hasil Lebih Kecil: {$hasilLebihKecil} <br>";
echo "Hasil Lebih Besar: {$hasilLebihBesar} <br>";
echo "Hasil Lebih Kecil Sama: {$hasilLebihKecilSama} <br>";
echo "Hasil Lebih Besar Sama: {$hasilLebihBesarSama} <br>";

$hasilAnd = $a && $b;
$hasilOr = $a || $b;
$hasilNotA = !$a;
$hasilNotB = !$b;

echo "Hasil And: {$hasilAnd} <br>";
echo "Hasil Or: {$hasilOr} <br>";
echo "Hasil Not A: {$hasilNotA} <br>";
echo "Hasil Not B: {$hasilNotB} <br>";

$plus = $a += $b;
$minus = $a -= $b;
$multiply = $a *= $b;
$divide = $a /= $b;
$modulus = $a %= $b;

echo "Hasil Plus: {$plus} <br>";
echo "Hasil Minus: {$minus} <br>";
echo "Hasil Multiply: {$multiply} <br>";
echo "Hasil Divide: {$divide} <br>";
echo "Hasil Modulus: {$modulus} <br>";

$hasilIdentik = $a === $b;
$hasilTidakIdentik = $a !== $b;

echo "Hasil Identik: {$hasilIdentik} <br>";
echo "Hasil Tidak Identik: {$hasilTidakIdentik} <br>";

// Tugas
$totalKursi = 45;
$kursiTerisi = 28;
$kursiKosong = $totalKursi - $kursiTerisi;
$persenKosong = ($kursiKosong / $totalKursi) * 100;
echo "Persentase kursi yang masih kosong: " . round($persenKosong, 2) . "%<br>";

?>
