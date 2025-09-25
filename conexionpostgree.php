<?php
$host = "https://vogiflnonecppoogeaoc.supabase.co";
$dbname = "postgres";
$username = "postgres";
$password = "gjoNbpPaz8WQqe1R";

try {
    $pdo = new PDO(
        "pgsql:host=$host;port=5432;dbname=$dbname;sslmode=require", 
        $username, 
        $password
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully";
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}