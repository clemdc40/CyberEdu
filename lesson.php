<?php
// Informations de connexion à la base de données
$host = "localhost";
$dbname = "cyberedu";
$username = "root";
$password = "root";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Vérification de l'ID de la leçon dans l'URL
    if (isset($_GET['id'])) {
        $lessonId = (int) $_GET['id'];

        // Récupération des informations de la leçon
        $stmt = $pdo->prepare("SELECT * FROM lessons WHERE id = :id");
        $stmt->execute(['id' => $lessonId]);
        $lesson = $stmt->fetch(PDO::FETCH_ASSOC);

        // Si la leçon n'existe pas
        if (!$lesson) {
            die("Leçon introuvable !");
        }
    } else {
        die("Aucun ID de leçon fourni !");
    }
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($lesson['title']); ?> - CyberEdu</title>
    <link rel="stylesheet" href="css/lesson.css">
</head>
<body>
<header>
    <nav>
        <ul>
            <li><a href="index.html">Accueil</a></li>
            <li><a href="explorer.html">Leçons</a></li>
            <li><a href="creer.html">Créer</a></li>
            <li><a href="profil.html">Profil</a></li>
        </ul>
    </nav>
</header>

<main>
    <h1><?php echo htmlspecialchars($lesson['title']); ?></h1>
    <p><strong>Durée :</strong> <?php echo htmlspecialchars($lesson['duration']); ?> minutes</p>
    <p><strong>Niveau :</strong> <?php echo htmlspecialchars($lesson['level']); ?></p>
    <div class="lesson-content">
        <!-- Afficher directement le contenu HTML sans échapper -->
        <?php echo $lesson['content']; ?>
    </div>
</main>

<footer>
    <p>&copy; 2024 CyberEdu - Tous droits réservés</p>
</footer>
</body>
</html>
