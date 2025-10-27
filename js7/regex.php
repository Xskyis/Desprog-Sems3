<?php 
$pattern = '/[a-z]/';
$text = 'This is a Sample Text.';
if (preg_match($pattern, $text)) {
    echo "Huruf kecil ditemukan! <br>"; ;
} else {
    echo "Teks tidak mengandung huruf kecil.<br>";
}

$pattern = '/[0-9]/';
$text = 'There area 123 apples.';
if (preg_match($pattern, $text, $matches)) {
    echo "Cocokkan: " . $matches[0] . "<br>";
} else {
    echo "Tidak ada yang cocok!. <br>";
}

$pattern = '/apple/';
$replacement = 'banana';
$text = 'I like apple pie.';
$newText = preg_replace($pattern, $replacement, $text);
echo $newText . "<br>";

$pattern = '/go*d/';
$text = 'god is good';
if (preg_match($pattern, $text, $matches)) {
    echo "Cocokkan: " . $matches[0] . "<br>";
} else {
    echo "Tidak ada yang cocok!. <br>";
}

$pattern = '/go?d/';
$text = 'gd god good';
if (preg_match($pattern, $text, $matches)) {
    echo "Cocokkan dengan ?: " . $matches[0] . "<br>";
} else {
    echo "Tidak ada yang cocok dengan ?!. <br>";
}

$pattern = '/go{1,3}d/';
$text = 'gd god good goood gooood';
if (preg_match($pattern, $text, $matches)) {
    echo "Cocokkan dengan {1,3}: " . $matches[0] . "<br>";
} else {
    echo "Tidak ada yang cocok dengan {1,3}!. <br>";
}
?>