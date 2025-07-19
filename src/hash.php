<?php
$password = 'admin123'; // Ganti dengan password yang kamu mau
$hash = password_hash($password, PASSWORD_BCRYPT);
echo "Password: $password<br>";
echo "Hash: $hash";
?>
