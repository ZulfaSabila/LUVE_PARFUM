<?php
include 'includes/auth.php';
include 'includes/db.php';

$id = $_POST['id'];
$username = $_POST['username'];
$role_id = $_POST['role_id'];

if (!empty($_POST['password'])) {
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $stmt = $conn->prepare("UPDATE users SET username = ?, password = ?, role_id = ? WHERE id = ?");
    $stmt->bind_param("ssii", $username, $password, $role_id, $id);
} else {
    $stmt = $conn->prepare("UPDATE users SET username = ?, role_id = ? WHERE id = ?");
    $stmt->bind_param("sii", $username, $role_id, $id);
}

$stmt->execute();
header("Location: users.php");
?>
