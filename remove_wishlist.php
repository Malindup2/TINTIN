<?php
require 'conn.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['item_id'])) {
    $itemId = intval($_GET['item_id']);
    $uid = $_SESSION['user_id'];

    $stmt = $conn->prepare("DELETE FROM wishlist WHERE item_id = ? AND user_id = ?");
    $stmt->bind_param("ii", $itemId, $uid);
    $stmt->execute();

    header("Location: wishlist.php");
    exit;
}
?>
