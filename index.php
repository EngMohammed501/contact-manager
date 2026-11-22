<?php
require __DIR__ . '/config/database.php';

$pdo = getConnection();
echo "Connected to database!";