<?php
// Restrict access to logged-in users only
if (!isset($_SESSION['farmer_id'])) {
    header("Location: ../public/login.php");
    exit;
}
?>
