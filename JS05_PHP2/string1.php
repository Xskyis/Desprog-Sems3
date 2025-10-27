<?php 

$loremIpsum = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Voluptatem, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam";

echo "<p>{$loremIpsum}</p>";
echo "Panjang karakter: ". strlen($loremIpsum) ."<br/>";
echo "Panjang Kata: ". str_word_count($loremIpsum) ."<br/>";
echo "<p>" . strtoupper($loremIpsum) . "</p>";
echo "<p>" . strtolower($loremIpsum) . "</p>";

?>