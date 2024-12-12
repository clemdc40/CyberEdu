<?php
// Connexion à la base de données
$host = 'localhost';
$db = 'cyberedu';
$user = 'root';
$pass = 'root';

header('Content-Type: application/json');

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Requête pour récupérer les leçons
    $stmt = $pdo->query("SELECT * FROM lessons ORDER BY id DESC");
    $lessons = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($lessons);
} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
?>
