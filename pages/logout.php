<?php
session_start();
session_destroy(); // Destroy all sessions

// Redirect to landing page
header("Location:login.php");
exit(); // Ensure script stops executing after redirect
?>
