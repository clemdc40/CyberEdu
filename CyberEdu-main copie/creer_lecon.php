<?php
// Connexion à la base de données
$host = 'localhost';
$db = 'cyberedu';
$user = 'root';
$pass = 'root';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $level = $_POST['level'];
        $duration = $_POST['duration'];
        $content = $_POST['content'];

        // Dimensions souhaitées
        $desiredWidth = 400; // Largeur fixe
        $desiredHeight = 200; // Hauteur fixe

        $coverImage = null;

        // Gestion de l'upload de l'image
        if (isset($_FILES['coverImage']) && $_FILES['coverImage']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/images/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $imageTmpPath = $_FILES['coverImage']['tmp_name'];
            $imageName = uniqid() . '.jpg'; // Générer un nom unique
            $imagePath = $uploadDir . $imageName;

            // Redimensionner et rogner l'image
            list($originalWidth, $originalHeight) = getimagesize($imageTmpPath);
            $srcImage = imagecreatefromstring(file_get_contents($imageTmpPath));
            $dstImage = imagecreatetruecolor($desiredWidth, $desiredHeight);

            // Calcul pour rogner et centrer l'image
            $srcX = ($originalWidth > $originalHeight) ? ($originalWidth - $originalHeight) / 2 : 0;
            $srcY = ($originalHeight > $originalWidth) ? ($originalHeight - $originalWidth) / 2 : 0;
            $srcSize = min($originalWidth, $originalHeight);

            imagecopyresampled($dstImage, $srcImage, 0, 0, $srcX, $srcY, $desiredWidth, $desiredHeight, $srcSize, $srcSize);

            // Sauvegarder l'image redimensionnée
            if (imagejpeg($dstImage, $imagePath)) {
                $coverImage = 'images/' . $imageName;
            }

            imagedestroy($srcImage);
            imagedestroy($dstImage);
        }

        // Insérer dans la base de données
        $stmt = $pdo->prepare("INSERT INTO lessons (title, description, level, duration, content, cover_image) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$title, $description, $level, $duration, $content, $coverImage]);
        echo "Leçon créée avec succès !";
    }
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>
