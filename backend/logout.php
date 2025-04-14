<?php
session_start();
session_unset();
session_destroy();
header("Location: /Kurs/frontend/index.php");
exit;
