<?php

/**
 * Inlet Installation Script
 * Automatically setup database and initial configuration
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if already installed
if (file_exists('config/.installed')) {
    die('Installation already completed. Delete config/.installed file to reinstall.');
}

$step = isset($_GET['step']) ? (int)$_GET['step'] : 1;
$errors = [];
$success = [];

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($step === 1) {
        // System check
        $step = 2;
    } elseif ($step === 2) {
        // Database setup
        $dbHost = $_POST['db_host'];
        $dbPort = $_POST['db_port'];
        $dbName = $_POST['db_name'];
        $dbUser = $_POST['db_user'];
        $dbPass = $_POST['db_pass'];

        try {
            $dsn = "pgsql:host=$dbHost;port=$dbPort;dbname=$dbName";
            $pdo = new PDO($dsn, $dbUser, $dbPass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Read and execute SQL file
            $sql = file_get_contents('database.sql');
            $pdo->exec($sql);

            // Save config
            $configContent = "<?php
class Database {
    private \$host = \"$dbHost\";
    private \$db_name = \"$dbName\";
    private \$username = \"$dbUser\";
    private \$password = \"$dbPass\";
    private \$port = \"$dbPort\";
    public \$conn;

    public function getConnection() {
        \$this->conn = null;
        try {
            \$this->conn = new PDO(
                \"pgsql:host=\" . \$this->host . 
                \";port=\" . \$this->port . 
                \";dbname=\" . \$this->db_name,
                \$this->username,
                \$this->password
            );
            \$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            \$this->conn->exec(\"set names utf8\");
        } catch(PDOException \$exception) {
            echo \"Connection error: \" . \$exception->getMessage();
        }
        return \$this->conn;
    }
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function isLoggedIn() {
    return isset(\$_SESSION['admin_id']) && \$_SESSION['admin_id'] > 0;
}

function requireLogin() {
    if (!isLoggedIn()) {
        header(\"Location: /admin/login.php\");
        exit();
    }
}

function sanitize(\$data) {
    return htmlspecialchars(strip_tags(trim(\$data)));
}

function redirect(\$url) {
    header(\"Location: \" . \$url);
    exit();
}

function trackVisit(\$db) {
    try {
        \$page_url = \$_SERVER['REQUEST_URI'];
        \$visitor_ip = \$_SERVER['REMOTE_ADDR'];
        \$user_agent = \$_SERVER['HTTP_USER_AGENT'];
        
        \$query = \"INSERT INTO analytics (page_url, visitor_ip, user_agent) VALUES (?, ?, ?)\";
        \$stmt = \$db->prepare(\$query);
        \$stmt->execute([\$page_url, \$visitor_ip, \$user_agent]);
    } catch(PDOException \$e) {
        // Silent fail
    }
}
?>";

            if (!is_dir('config')) {
                mkdir('config', 0755, true);
            }
            file_put_contents('config/database.php', $configContent);

            $success[] = 'Database setup completed successfully!';
            $step = 3;
        } catch (Exception $e) {
            $errors[] = 'Database error: ' . $e->getMessage();
        }
    } elseif ($step === 3) {
        // Admin setup
        $adminUser = $_POST['admin_user'];
        $adminPass = $_POST['admin_pass'];
        $adminEmail = $_POST['admin_email'];

        try {
            require_once 'config/database.php';
            $database = new Database();
            $db = $database->getConnection();

            $hashedPass = password_hash($adminPass, PASSWORD_BCRYPT);
            $stmt = $db->prepare("UPDATE admin SET username = ?, password = ?, email = ? WHERE id = 1");
            $stmt->execute([$adminUser, $hashedPass, $adminEmail]);

            $success[] = 'Admin account configured!';
            $step = 4;
        } catch (Exception $e) {
            $errors[] = 'Admin setup error: ' . $e->getMessage();
        }
    } elseif ($step === 4) {
        // Create directories
        $dirs = [
            'uploads',
            'uploads/carousel',
            'uploads/products',
            'uploads/team',
            'uploads/news',
            'uploads/gallery',
            'uploads/research',
            'uploads/partners'
        ];

        foreach ($dirs as $dir) {
            if (!is_dir($dir)) {
                mkdir($dir, 0777, true);
            }
        }

        // Mark as installed
        file_put_contents('config/.installed', date('Y-m-d H:i:s'));

        $success[] = 'Installation completed successfully!';
        $step = 5;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inlet Installation</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gradient-to-br from-blue-500 to-purple-600 min-h-screen py-12">
    <div class="container mx-auto px-4 max-w-3xl">
        <!-- Header -->
        <div class="text-center mb-8 text-white">
            <div class="w-20 h-20 bg-white rounded-full mx-auto mb-4 flex items-center justify-center">
                <span class="text-blue-600 font-bold text-3xl">IL</span>
            </div>
            <h1 class="text-4xl font-bold mb-2">Inlet Installation</h1>
            <p class="text-xl">Let's get your website up and running!</p>
        </div>

        <!-- Progress Bar -->
        <div class="bg-white rounded-lg shadow-xl p-4 mb-6">
            <div class="flex items-center justify-between mb-2">
                <?php for ($i = 1; $i <= 5; $i++): ?>
                    <div class="flex items-center <?= $i < 5 ? 'flex-1' : '' ?>">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold <?= $step >= $i ? 'bg-blue-600 text-white' : 'bg-gray-300 text-gray-600' ?>">
                            <?= $i ?>
                        </div>
                        <?php if ($i < 5): ?>
                            <div class="flex-1 h-1 mx-2 <?= $step > $i ? 'bg-blue-600' : 'bg-gray-300' ?>"></div>
                        <?php endif; ?>
                    </div>
                <?php endfor; ?>
            </div>
            <div class="flex justify-between text-xs text-gray-600">
                <span>Check</span>
                <span>Database</span>
                <span>Admin</span>
                <span>Files</span>
                <span>Done</span>
            </div>
        </div>

        <!-- Messages -->
        <?php if (!empty($errors)): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <?php foreach ($errors as $error): ?>
                    <p><?= $error ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                <?php foreach ($success as $msg): ?>
                    <p><?= $msg ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- Content -->
        <div class="bg-white rounded-lg shadow-xl p-8">
            <?php if ($step === 1): ?>
                <!-- System Check -->
                <h2 class="text-2xl font-bold mb-6">System Requirements Check</h2>

                <div class="space-y-4">
                    <?php
                    $checks = [
                        'PHP Version >= 7.4' => version_compare(PHP_VERSION, '7.4.0', '>='),
                        'PDO Extension' => extension_loaded('pdo'),
                        'PDO PostgreSQL Driver' => extension_loaded('pdo_pgsql'),
                        'GD Extension' => extension_loaded('gd'),
                        'config/ is writable' => is_writable(dirname(__FILE__)),
                    ];

                    $allPassed = true;
                    foreach ($checks as $check => $passed) {
                        if (!$passed) $allPassed = false;
                        echo '<div class="flex items-center justify-between p-3 ' . ($passed ? 'bg-green-50' : 'bg-red-50') . ' rounded">';
                        echo '<span>' . $check . '</span>';
                        echo '<span class="' . ($passed ? 'text-green-600' : 'text-red-600') . '">';
                        echo $passed ? '<i class="fas fa-check-circle"></i> Passed' : '<i class="fas fa-times-circle"></i> Failed';
                        echo '</span></div>';
                    }
                    ?>
                </div>

                <form method="POST" class="mt-8">
                    <button type="submit" <?= !$allPassed ? 'disabled' : '' ?>
                        class="w-full bg-blue-600 hover:bg-blue-700 disabled:bg-gray-400 text-white font-bold py-3 rounded-lg">
                        Continue to Database Setup <i class="fas fa-arrow-right ml-2"></i>
                    </button>
                </form>

            <?php elseif ($step === 2): ?>
                <!-- Database Setup -->
                <h2 class="text-2xl font-bold mb-6">Database Configuration</h2>

                <form method="POST" class="space-y-4">
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Database Host</label>
                        <input type="text" name="db_host" value="localhost" required
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Database Port</label>
                        <input type="text" name="db_port" value="5432" required
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Database Name</label>
                        <input type="text" name="db_name" value="inlet_db" required
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Database Username</label>
                        <input type="text" name="db_user" value="postgres" required
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Database Password</label>
                        <input type="password" name="db_pass" required
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div class="bg-yellow-50 border border-yellow-200 p-4 rounded">
                        <p class="text-sm text-yellow-800">
                            <i class="fas fa-info-circle"></i> Make sure the database "inlet_db" exists before continuing.
                            Create it using: <code class="bg-white px-2 py-1 rounded">CREATE DATABASE inlet_db;</code>
                        </p>
                    </div>

                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg">
                        Setup Database <i class="fas fa-arrow-right ml-2"></i>
                    </button>
                </form>

            <?php elseif ($step === 3): ?>
                <!-- Admin Setup -->
                <h2 class="text-2xl font-bold mb-6">Admin Account Setup</h2>

                <form method="POST" class="space-y-4">
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Admin Username</label>
                        <input type="text" name="admin_user" value="admin" required
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Admin Email</label>
                        <input type="email" name="admin_email" value="admin@inlet.com" required
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Admin Password</label>
                        <input type="password" name="admin_pass" required minlength="6"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <p class="text-sm text-gray-500 mt-1">Minimum 6 characters</p>
                    </div>

                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg">
                        Create Admin Account <i class="fas fa-arrow-right ml-2"></i>
                    </button>
                </form>

            <?php elseif ($step === 4): ?>
                <!-- Final Setup -->
                <h2 class="text-2xl font-bold mb-6">Final Setup</h2>

                <p class="mb-6">Creating upload directories and finalizing installation...</p>

                <form method="POST">
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg">
                        Complete Installation <i class="fas fa-check ml-2"></i>
                    </button>
                </form>

            <?php elseif ($step === 5): ?>
                <!-- Success -->
                <div class="text-center">
                    <div class="w-20 h-20 bg-green-100 rounded-full mx-auto mb-6 flex items-center justify-center">
                        <i class="fas fa-check text-green-600 text-4xl"></i>
                    </div>

                    <h2 class="text-3xl font-bold mb-4">Installation Complete!</h2>
                    <p class="text-gray-600 mb-8">Your Inlet website is now ready to use.</p>

                    <div class="bg-gray-50 p-6 rounded-lg mb-8">
                        <h3 class="font-bold mb-4">Next Steps:</h3>
                        <ol class="text-left space-y-2 text-gray-700">
                            <li>1. Delete or rename <code class="bg-white px-2 py-1 rounded">install.php</code> for security</li>
                            <li>2. Login to admin panel at <code class="bg-white px-2 py-1 rounded">/admin/login.php</code></li>
                            <li>3. Start adding your content through the CMS</li>
                            <li>4. Customize the design to match your brand</li>
                            <li>5. Configure email settings in <code class="bg-white px-2 py-1 rounded">contact.php</code></li>
                        </ol>
                    </div>

                    <div class="flex gap-4">
                        <a href="index.php" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg inline-block">
                            <i class="fas fa-home"></i> View Website
                        </a>
                        <a href="admin/login.php" class="flex-1 bg-green-600 hover:bg-green-700 text-white font-bold py-3 rounded-lg inline-block">
                            <i class="fas fa-lock"></i> Admin Login
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Footer -->
        <div class="text-center mt-8 text-white text-sm">
            <p>&copy; 2024 Inlet Laboratory. Installation Script v1.0</p>
        </div>
    </div>
</body>

</html>