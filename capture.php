<?php
// capture.php
$data = json_decode(file_get_contents("php://input"), true);
if (!$data) {
    $data = $_POST;
}
$entry = [
    "timestamp" => date("Y-m-d H:i:s"),
    "ip" => $_SERVER['REMOTE_ADDR'],
    "user_agent" => $_SERVER['HTTP_USER_AGENT'],
    "data" => $data
];
$file = "captured_data.json";
$existing = file_exists($file) ? json_decode(file_get_contents($file), true) : [];
array_unshift($existing, $entry);
file_put_contents($file, json_encode($existing, JSON_PRETTY_PRINT));
http_response_code(200);
echo "ok";
?>