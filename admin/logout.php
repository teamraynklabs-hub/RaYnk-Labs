<?php
declare(strict_types=1);

session_start();
session_unset();
session_destroy();

header('Location: /projects/RaYnk-Labs/admin/index.php');
exit;
?>