<?php
    require_once 'connexion.php';
    
    $id = $_GET['id'];
    
    // Récupérer l'étudiant
    $stmt = $pdo->prepare("SELECT * FROM etudiants WHERE id = ?");
    $stmt->execute([$id]);
    $etudiant = $stmt->fetch();
    
    // Récupérer les filières
    $filieres = $pdo->query("SELECT * FROM filieres")->fetchAll();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'];
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $filiere_id = $_POST['filiere_id'];
    
        $stmt = $pdo->prepare("UPDATE etudiants SET nom = ?, prenom = ?, filiere_id = ? WHERE id = ?");
        $stmt->execute([$nom, $prenom, $filiere_id, $id]);
    
        header('Location: index.php');
    }
?>

<form action="update.php" method="POST">
    <input type="hidden" name="id" value="<?= $etudiant['id'] ?>">
    <input type="text" name="nom" value="<?= $etudiant['nom'] ?>">
    <input type="text" name="prenom" value="<?= $etudiant['prenom'] ?>">
    <select name="filiere_id">
        <?php foreach($filieres as $f): ?>
        <option value="<?= $f['id'] ?>" <?= $f['id'] == $etudiant['filiere_id'] ? 'selected' : '' ?>>
            <?= $f['nom'] ?>
        </option>
        <?php endforeach; ?>
    </select>
    <button type="submit">Modifier</button>
</form>
