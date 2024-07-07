<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Server Management Dashboard</title>
  <style>
    body {
      font-family: 'Courier New', Courier, monospace;
      background-color: #1e1e1e;
      color: #ffffff;
      margin: 0;
      padding: 0;
    }

    .container {
      max-width: 800px;
      margin: 50px auto;
      padding: 20px;
      background-color: #2e2e2e;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      border-radius: 8px;
    }

    h1 {
      text-align: center;
      color: #1e90ff;
    }

    form {
      display: flex;
      justify-content: space-around;
      margin-bottom: 20px;
    }

    button {
      padding: 10px 20px;
      background-color: #1e90ff;
      color: #ffffff;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    button:hover {
      background-color: #1c80d6;
    }

    .command-output {
      background-color: #1a1a1a;
      padding: 20px;
      border: 1px solid #333333;
      border-radius: 4px;
      white-space: pre-wrap;
      /* Preserve whitespace and line breaks */
      height: 300px;
      /* Limit height for scrolling */
      overflow-y: auto;
      /* Enable vertical scrolling */
      font-size: 14px;
      line-height: 1.4;
    }

    .terminal-input {
      display: flex;
      align-items: center;
      background-color: #333333;
      padding: 5px;
      border-radius: 4px;
    }

    .terminal-input input {
      flex: 1;
      padding: 8px;
      background-color: transparent;
      border: none;
      color: #ffffff;
      font-family: 'Courier New', Courier, monospace;
      font-size: 14px;
      outline: none;
    }

    .terminal-input button {
      padding: 8px 15px;
      margin-left: 10px;
      background-color: #1e90ff;
      color: #ffffff;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .terminal-input button:hover {
      background-color: #1c80d6;
    }

    .prompt {
      color: #50fa7b;
    }

    .command {
      color: #ffffff;
    }

    .output {
      color: #bd93f9;
    }
  </style>

  <head>

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
          $sudoPassword = 'clYntY2029CONT';
          switch ($action) {
            case 'disk_usage':
              $output = shell_exec('df -h 2>&1');
              break;
            case 'restart_service':
              $output = shell_exec("echo $sudoPassword | sudo -S systemctl restart apache2 2>&1");
              break;
            case 'update_system':
              $output = shell_exec("echo $sudoPassword | sudo -S apt-get update && echo $sudoPassword | sudo -S apt-get upgrade -y 2>&1");
              break;
            default:
              $output = 'Invalid action';
          }

          echo nl2br(htmlspecialchars($output));
        }
        ?>
      </div>

      <h1>File Management</h1>
      <div class="file-cards">
        <?php
        // Scan /var/www/html directory for files
        $htmlDirectory = '/var/www/html';
        $files = scandir($htmlDirectory);

        foreach ($files as $file) {
          if ($file !== '.' && $file !== '..') {
            // Display each file as a card
            echo '<div class="file-card">';
            echo '<h3>' . htmlspecialchars($file) . '</h3>';
            echo '<p>Size: ' . filesize($htmlDirectory . '/' . $file) . ' bytes</p>';
            echo '</div>';
          }
        }
        ?>
      </div>
    </div>
  </body>

</html>