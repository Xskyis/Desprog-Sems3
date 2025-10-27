<?php 
$angka = 10;
$angka2 = 5;
$hasil = $angka + $angka2;
echo "Hasil penjumlahan $angka1 dan $angka2 adalah $hasil<br>";

$benar = true;
$salah = false;
echo "Variabel benar: $benar, Variabel salah: $salah<br>";

define("NAMA_SITUS", "WebsiteKu.com");
define("TAHUN_PENDIRIAN", 2025);

echo "Selamat datang di " . NAMA_SITUS . ", situs yang didirakan pada tahun " . TAHUN_PENDIRIAN . ".";
?>