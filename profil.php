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
    $lessonCount = isset($result['lesson_count']) ? $result['lesson_count'] : 0;
} catch (PDOException $e) {
    // Gestion des erreurs de connexion
    die("Erreur de connexion : " . $e->getMessage());
}
?>


<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Utilisateur</title>
    <link rel="stylesheet" href="css/profil.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.html">Accueil</a></li>
                <li><a href="explorer.html">Leçons</a></li>
                <li><a href="creer.html">Créer</a></li>
                <li><a href="profil.php">Profil</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <div class="profile-container">
            <div class="profile-info">
                <h2>Clément Da Cruz</h2>
                <p class="email">clementdacruz2012@gmail.com</p>
            </div>
            <div class="profile-stats">
                <div class="stat">
                    <h3><?php echo $lessonCount; ?></h3>
                    <p>Leçons</p>
                </div>
            </div>
            <div class="progression">
                <h3>Progression récente</h3>
                <div class="progress-container">
                    <!-- Progression récente sera ajoutée ici -->
                </div>
            </div>
        </div>
    </main>
    <footer>
        <p>&copy; 2024 CyberEdu - Tous droits réservés</p>
    </footer>
</body>
</html>
