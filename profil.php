<?php
// Informations de connexion à la base de données
$host = "localhost"; // Hôte (ex: 127.0.0.1 ou localhost)
$dbname = "cyberedu"; // Nom de la base de données
$username = "root"; // Nom d'utilisateur de la base de données
$password = "root"; // Mot de passe de la base de données

try {
    // Connexion à la base de données
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Requête pour compter le nombre de leçons
    $stmt = $pdo->query("SELECT COUNT(*) AS lesson_count FROM lessons");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // Récupération du nombre de leçons
    $lessonCount = $result['lesson_count'] ?? 0;
} catch (PDOException $e) {
    // Gestion des erreurs de connexion
    die("Erreur de connexion : " . $e->getMessage());
}
?>
