<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Server Management Dashboard</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .container { max-width: 800px; margin: auto; padding: 20px; }
        .command-output { background-color: #f4f4f4; padding: 10px; border: 1px solid #ddd; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Server Management Dashboard</h1>
        <form method="post">
            <button name="action" value="disk_usage">Check Disk Usage</button>
            <button name="action" value="restart_service">Restart Apache</button>
            <button name="action" value="update_system">Update System</button>
        </form>
        <div class="command-output">
            <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $action = $_POST['action'] ?? '';
                $output = '';

                switch ($action) {
                    case 'disk_usage':
                        $output = shell_exec('df -h 2>&1');
                        break;
                    case 'restart_service':
                        $output = shell_exec('sudo systemctl restart apache2 2>&1');
                        break;
                    case 'update_system':
                        $output = shell_exec('sudo apt-get update && sudo apt-get upgrade -y 2>&1');
                        break;
                    default:
                        $output = 'Invalid action';
                }

                echo nl2br(htmlspecialchars($output));
            }
            ?>
        </div>
    </div>
</body>
</html>
