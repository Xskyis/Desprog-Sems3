<!DOCTYPE html>
<html>
<head>
    <title>HTML Aman</title>
</head>
<body>

    <h2>Input HTML Aman</h2>

    <?php 
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['input'])) {
        $input = $_POST['input'];
        $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
        
        echo "<h3>Input yang aman: " . $input . "</h3>";
    }

    $email = $_POST['email'];
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<h3>Email yang valid: " . htmlspecialchars($email, ENT_QUOTES, 'UTF-8') . "</h3>";
    } else {
        echo "<h3>Email tidak valid.</h3>";
    }
    ?>

    <!-- <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <label for="input">Masukkan teks (bisa mengandung HTML):</label><br>
        <textarea name="input" id="input" rows="4" cols="50"></textarea><br><br>
        
        <input type="submit" name="submit" value="Submit">
    </form>

    <p><strong>Catatan:</strong> Script ini akan mengamankan input HTML dengan mengkonversi karakter khusus menjadi entitas HTML.</p> -->

    <!-- // Contoh validasi email -->
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <label for="email">Masukkan email:</label><br>
        <input type="text" name="email" id="email"><br><br>
        
        <input type="submit" name="submit_email" value="Submit Email">
    </form>

</body>
</html>