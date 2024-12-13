<?php
// Informations de connexion à la base de données
$host = 'localhost';
$dbname = 'cyberedu';
$username = 'root';
$password = 'root';

header('Content-Type: application/json');

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Vérifier que l'ID est fourni
    if (isset($_GET['id'])) {
        $lessonId = (int) $_GET['id'];

        // Supprimer la leçon
        $stmt = $pdo->prepare("DELETE FROM lessons WHERE id = :id");
        $stmt->execute(['id' => $lessonId]);

        echo json_encode(["success" => true, "message" => "Leçon supprimée avec succès."]);
    } else {
        http_response_code(400);
        echo json_encode(["success" => false, "message" => "ID de la leçon manquant."]);
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
?>
