<?php
session_start();
session_destroy();
header("Location: /Kurs/frontend/index.php");
exit();
