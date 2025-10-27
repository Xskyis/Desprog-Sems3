<?php 

function perkenalan($nama, $salam="Assalamualaikum") {
    echo $salam.", ";
    echo "Perkenalkan, nama saya ".$nama."<br/>";
    echo "Senang berkenalan dengan Anda<br/>";    
}

    //Panggil function
    perkenalan("Hamdana", "Hallo");

    echo "<hr>";

    $saya = "Achmad Nabil Afgareza";
    $ucapanSalam = "Gutten morgen";

    //memanggil lagi
    perkenalan($saya, $ucapanSalam);

    echo "<hr>";
    perkenalan($saya);
?>