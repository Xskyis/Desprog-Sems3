<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penghitung Digit Angka</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        
        .container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            width: 400px;
            text-align: center;
        }
        
        h1 {
            color: #333;
            margin-bottom: 20px;
        }
        
        .input-group {
            margin-bottom: 20px;
            text-align: left;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: bold;
        }
        
        input[type="text"] {
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box;
        }
        
        input[type="text"]:focus {
            border-color: #4CAF50;
            outline: none;
        }
        
        .btn {
            width: 100%;
            padding: 12px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 10px;
        }
        
        .btn:hover {
            background-color: #45a049;
        }
        
        .btn:disabled {
            background-color: #cccccc;
            cursor: not-allowed;
        }
        
        .result {
            margin-top: 20px;
            padding: 20px;
            background-color: #e8f5e9;
            border: 2px solid #4CAF50;
            border-radius: 5px;
        }
        
        .result h3 {
            margin: 0 0 10px 0;
            color: #2e7d32;
        }
        
        .digit-count {
            font-size: 32px;
            font-weight: bold;
            color: #1b5e20;
            margin: 10px 0;
        }
        
        .number-display {
            font-size: 18px;
            color: #666;
            word-break: break-all;
            background-color: #f0f0f0;
            padding: 10px;
            border-radius: 5px;
            margin: 10px 0;
        }
        
        .error {
            margin-top: 20px;
            padding: 20px;
            background-color: #ffebee;
            border: 2px solid #f44336;
            border-radius: 5px;
        }
        
        .error h3 {
            margin: 0 0 10px 0;
            color: #d32f2f;
        }
        
        .clear-btn {
            background-color: #ff9800;
            margin-top: 10px;
        }
        
        .clear-btn:hover {
            background-color: #f57c00;
        }
        
        .info {
            margin-top: 15px;
            padding: 10px;
            background-color: #e3f2fd;
            border-radius: 5px;
            font-size: 14px;
            color: #1976d2;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔢 Penghitung Digit Angka</h1>
        
        <form method="POST" id="digitForm">
            <div class="input-group">
                <label for="number">Masukkan Angka:</label>
                <input type="text" id="number" name="number" 
                       placeholder="Contoh: 12345 atau 999.87"
                       value="<?php echo isset($_POST['number']) ? htmlspecialchars($_POST['number']) : ''; ?>"
                       required>
            </div>
            
            <button type="submit" class="btn" id="submitBtn">📊 Hitung Digit</button>
            <button type="button" class="btn clear-btn" onclick="clearForm()">🗑️ Bersihkan</button>
        </form>
        
        <div class="info">
            💡 <strong>Tips:</strong> Masukkan angka apa saja (positif/negatif, desimal/bulat). 
            Program akan menghitung jumlah digit angkanya!
        </div>
        
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['number'])) {
            $input = trim($_POST['number']);
            $hasError = false;
            $errorMessage = '';
            
            // Validasi apakah input kosong
            if (empty($input)) {
                $hasError = true;
                $errorMessage = 'Input tidak boleh kosong!';
            }
            // Validasi apakah input adalah angka yang valid
            elseif (!is_numeric($input)) {
                $hasError = true;
                $errorMessage = 'Input harus berupa angka yang valid!';
            } else {
                // Hitung digit
                $cleanNumber = str_replace(['-', '+', '.'], '', $input); // Hapus tanda negatif, positif, dan titik desimal
                $digitCount = strlen($cleanNumber);
                
                // Informasi tambahan
                $isNegative = strpos($input, '-') === 0;
                $isDecimal = strpos($input, '.') !== false;
                $originalNumber = floatval($input);
                
                echo '<div class="result">';
                echo '<h3>✅ Hasil Perhitungan:</h3>';
                echo '<div class="number-display">Angka: ' . htmlspecialchars($input) . '</div>';
                echo '<div class="digit-count">' . $digitCount . ' digit</div>';
                
                // Informasi detail
                echo '<div style="font-size: 14px; margin-top: 15px; text-align: left;">';
                echo '<strong>Detail:</strong><br>';
                echo '• Digit yang dihitung: ' . htmlspecialchars($cleanNumber) . '<br>';
                echo '• Tipe: ' . ($isDecimal ? 'Bilangan Desimal' : 'Bilangan Bulat') . '<br>';
                echo '• Sifat: ' . ($isNegative ? 'Negatif' : 'Positif') . '<br>';
                echo '• Nilai numerik: ' . number_format($originalNumber, ($isDecimal ? 2 : 0)) . '<br>';
                echo '</div>';
                
                echo '</div>';
            }
            
            if ($hasError) {
                echo '<div class="error">';
                echo '<h3>❌ Error!</h3>';
                echo '<p>' . htmlspecialchars($errorMessage) . '</p>';
                echo '</div>';
            }
        }
        ?>
    </div>
    
    <script>
        // Validasi real-time saat mengetik
        document.getElementById('number').addEventListener('input', function() {
            const value = this.value;
            const submitBtn = document.getElementById('submitBtn');
            
            // Validasi sederhana
            if (value.trim() === '') {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '📊 Hitung Digit';
            } else if (isNaN(value) && value !== '-' && value !== '+') {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '❌ Input Tidak Valid';
                this.style.borderColor = '#f44336';l                                                                                                                                                                                                                                                                                                                                                   
            } else {
                submitBtn.disabled = false;
                submitBtn.innerHTML = '📊 Hitung Digit';
                this.style.borderColor = '#4CAF50';
            }
        });
        
        // Validasi form saat submit
        document.getElementById('digitForm').addEventListener('submit', function(e) {
            const numberInput = document.getElementById('number').value.trim();
            
            if (numberInput === '') {
                alert('⚠️ Mohon masukkan angka terlebih dahulu!');
                e.preventDefault();
                return false;
            }
            
            if (isNaN(numberInput)) {
                alert('⚠️ Input harus berupa angka yang valid!');
                e.preventDefault();
                return false;
            }
            
            // Animasi loading
            const submitBtn = document.getElementById('submitBtn');
            submitBtn.innerHTML = '⏳ Menghitung...';
            submitBtn.disabled = true;
        });
        
        // Fungsi untuk membersihkan form
        function clearForm() {
            document.getElementById('digitForm').reset();
            document.getElementById('number').style.borderColor = '#ddd';
            document.getElementById('submitBtn').disabled = false;
            document.getElementById('submitBtn').innerHTML = '📊 Hitung Digit';
            
            // Hapus hasil jika ada
            const result = document.querySelector('.result');
            const error = document.querySelector('.error');
            
            if (result) result.remove();
            if (error) error.remove();
            
            // Focus ke input
            document.getElementById('number').focus();
        }
        
        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // ESC untuk clear
            if (e.key === 'Escape') {
                clearForm();
            }
            
            // Ctrl+A untuk select all di input
            if (e.ctrlKey && e.key === 'a' && document.activeElement.id === 'number') {
                document.getElementById('number').select();
            }
        });
        
        // Focus pada input saat halaman dimuat
        window.addEventListener('load', function() {
            document.getElementById('number').focus();
        });
        
        // Fungsi untuk menampilkan preview digit saat mengetik
        document.getElementById('number').addEventListener('input', function() {
            const value = this.value;
            if (value && !isNaN(value)) {
                const cleanNumber = value.replace(/[-+.]/g, '');
                const digitCount = cleanNumber.length;
                
                // Update placeholder untuk preview
                if (digitCount > 0) {
                    this.title = `Preview: ${digitCount} digit (${cleanNumber})`;
                } else {
                    this.title = '';
                }
            }
        });
    </script>
</body>
</html>
