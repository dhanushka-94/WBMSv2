<?php
/**
 * DN WASSIP System - Web Setup Script
 * Use this file to setup the database when you don't have terminal access
 * 
 * IMPORTANT: Delete this file after setup is complete for security!
 */

// Check if setup should be allowed
$setupAllowed = !file_exists('.setup_completed');

if (!$setupAllowed) {
    die('<h1>🚫 Setup Already Completed</h1><p>For security reasons, setup can only be run once. Delete .setup_completed file if you need to run setup again.</p>');
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DN WASSIP - System Setup</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 50px auto; padding: 20px; background: #f5f5f5; }
        .container { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 0 20px rgba(0,0,0,0.1); }
        .header { text-align: center; margin-bottom: 30px; color: #2563eb; }
        .step { margin: 20px 0; padding: 15px; border-left: 4px solid #2563eb; background: #f8fafc; }
        .success { color: #059669; border-left-color: #059669; background: #ecfdf5; }
        .error { color: #dc2626; border-left-color: #dc2626; background: #fef2f2; }
        .warning { color: #d97706; border-left-color: #d97706; background: #fffbeb; }
        button { background: #2563eb; color: white; padding: 12px 24px; border: none; border-radius: 6px; cursor: pointer; font-size: 16px; }
        button:hover { background: #1d4ed8; }
        .disabled { background: #9ca3af; cursor: not-allowed; }
        .logo { text-align: center; margin-bottom: 20px; }
        pre { background: #1f2937; color: #f9fafb; padding: 15px; border-radius: 6px; overflow-x: auto; }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">
            <h1>🌊 DN WASSIP</h1>
            <h2>Dunsinane Estate Water Supply and Management System</h2>
            <p><strong>System Setup Wizard</strong></p>
        </div>

        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
            echo '<div class="step">';
            
            try {
                // Load Laravel
                require __DIR__.'/vendor/autoload.php';
                $app = require_once __DIR__.'/bootstrap/app.php';
                $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
                
                switch ($_POST['action']) {
                    case 'check_requirements':
                        echo '<h3>🔍 Checking System Requirements...</h3>';
                        
                        // Check PHP version
                        $phpVersion = PHP_VERSION;
                        if (version_compare($phpVersion, '8.1.0', '>=')) {
                            echo "<p class='success'>✅ PHP Version: $phpVersion (OK)</p>";
                        } else {
                            echo "<p class='error'>❌ PHP Version: $phpVersion (Requires 8.1+)</p>";
                        }
                        
                        // Check extensions
                        $requiredExtensions = ['mysql', 'mbstring', 'xml', 'curl', 'zip', 'gd', 'json', 'bcmath', 'tokenizer', 'fileinfo', 'openssl'];
                        foreach ($requiredExtensions as $ext) {
                            if (extension_loaded($ext)) {
                                echo "<p class='success'>✅ PHP Extension: $ext</p>";
                            } else {
                                echo "<p class='error'>❌ PHP Extension: $ext (Missing)</p>";
                            }
                        }
                        
                        // Check directories
                        $dirs = ['storage', 'bootstrap/cache'];
                        foreach ($dirs as $dir) {
                            if (is_writable($dir)) {
                                echo "<p class='success'>✅ Directory Writable: $dir</p>";
                            } else {
                                echo "<p class='error'>❌ Directory Not Writable: $dir (Set to 755/777)</p>";
                            }
                        }
                        
                        // Check .env file
                        if (file_exists('.env')) {
                            echo "<p class='success'>✅ Environment file (.env) exists</p>";
                        } else {
                            echo "<p class='error'>❌ Environment file (.env) missing</p>";
                        }
                        
                        break;
                        
                    case 'test_database':
                        echo '<h3>🗄️ Testing Database Connection...</h3>';
                        
                        try {
                            $pdo = new PDO(
                                "mysql:host=" . env('DB_HOST') . ";port=" . env('DB_PORT') . ";dbname=" . env('DB_DATABASE'),
                                env('DB_USERNAME'),
                                env('DB_PASSWORD')
                            );
                            echo "<p class='success'>✅ Database connection successful!</p>";
                            echo "<p>Database: " . env('DB_DATABASE') . "</p>";
                            echo "<p>Host: " . env('DB_HOST') . "</p>";
                        } catch (Exception $e) {
                            echo "<p class='error'>❌ Database connection failed: " . $e->getMessage() . "</p>";
                        }
                        
                        break;
                        
                    case 'run_migrations':
                        echo '<h3>🏗️ Running Database Migrations...</h3>';
                        
                        ob_start();
                        $exitCode = $kernel->call('migrate', ['--force' => true]);
                        $output = ob_get_clean();
                        
                        if ($exitCode === 0) {
                            echo "<p class='success'>✅ Database migrations completed successfully!</p>";
                            echo "<pre>$output</pre>";
                        } else {
                            echo "<p class='error'>❌ Migration failed!</p>";
                            echo "<pre>$output</pre>";
                        }
                        
                        break;
                        
                    case 'seed_database':
                        echo '<h3>🌱 Seeding Database with Initial Data...</h3>';
                        
                        ob_start();
                        $exitCode = $kernel->call('db:seed', ['--force' => true]);
                        $output = ob_get_clean();
                        
                        if ($exitCode === 0) {
                            echo "<p class='success'>✅ Database seeding completed successfully!</p>";
                            echo "<pre>$output</pre>";
                            
                            // Create completion flag
                            file_put_contents('.setup_completed', date('Y-m-d H:i:s'));
                            
                            echo '<div class="step success">';
                            echo '<h3>🎉 Setup Complete!</h3>';
                            echo '<p><strong>Your DN WASSIP system is now ready!</strong></p>';
                            echo '<p><strong>Default Admin Login:</strong></p>';
                            echo '<p>Email: <code>admin@dunsinane.lk</code></p>';
                            echo '<p>Password: <code>password123</code></p>';
                            echo '<p><a href="/" target="_blank">🚀 Launch Your System</a></p>';
                            echo '<p class="warning"><strong>⚠️ IMPORTANT:</strong> Delete this setup.php file immediately for security!</p>';
                            echo '</div>';
                        } else {
                            echo "<p class='error'>❌ Database seeding failed!</p>";
                            echo "<pre>$output</pre>";
                        }
                        
                        break;
                        
                    case 'generate_key':
                        echo '<h3>🔐 Generating Application Key...</h3>';
                        
                        ob_start();
                        $exitCode = $kernel->call('key:generate', ['--force' => true]);
                        $output = ob_get_clean();
                        
                        if ($exitCode === 0) {
                            echo "<p class='success'>✅ Application key generated successfully!</p>";
                            echo "<pre>$output</pre>";
                        } else {
                            echo "<p class='error'>❌ Key generation failed!</p>";
                            echo "<pre>$output</pre>";
                        }
                        
                        break;
                }
                
            } catch (Exception $e) {
                echo "<p class='error'>❌ Error: " . $e->getMessage() . "</p>";
            }
            
            echo '</div>';
        }
        ?>

        <div class="step">
            <h3>📋 Setup Steps</h3>
            <p>Follow these steps in order to setup your DN WASSIP system:</p>
            
            <form method="POST" style="margin: 10px 0;">
                <button type="submit" name="action" value="check_requirements">1. Check System Requirements</button>
            </form>
            
            <form method="POST" style="margin: 10px 0;">
                <button type="submit" name="action" value="generate_key">2. Generate Application Key</button>
            </form>
            
            <form method="POST" style="margin: 10px 0;">
                <button type="submit" name="action" value="test_database">3. Test Database Connection</button>
            </form>
            
            <form method="POST" style="margin: 10px 0;">
                <button type="submit" name="action" value="run_migrations">4. Create Database Tables</button>
            </form>
            
            <form method="POST" style="margin: 10px 0;">
                <button type="submit" name="action" value="seed_database">5. Setup Initial Data</button>
            </form>
        </div>

        <div class="step warning">
            <h3>⚠️ Before You Start</h3>
            <ul>
                <li>Ensure your <strong>.env</strong> file is configured with correct database credentials</li>
                <li>Make sure <strong>storage/</strong> and <strong>bootstrap/cache/</strong> folders are writable (755/777)</li>
                <li>Your domain should point to the <strong>public/</strong> folder</li>
                <li><strong>Delete this setup.php file</strong> after completing the setup for security</li>
            </ul>
        </div>

        <div class="step">
            <h3>📧 Support</h3>
            <p><strong>System Developed By:</strong> Olexto Digital Solutions (Pvt) Ltd</p>
            <p>For technical support: <strong>info@olexto.com</strong></p>
        </div>
    </div>
</body>
</html> 