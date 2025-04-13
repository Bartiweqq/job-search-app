<?php
if (in_array("pgsql", PDO::getAvailableDrivers())) {
    echo "PostgreSQL driver is enabled!";
} else {
    echo "PostgreSQL driver is NOT available.";
}
