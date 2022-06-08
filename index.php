<?php

require "./model/database.php";

// Tous les emplacements
$sql_emplacements = "SELECT e.id as emplacementId, e.numeroPonton, e.pontonId, e.bateauId, b.nom as bateauNom FROM emplacement e LEFT JOIN bateau b ON e.bateauId = b.id";
$emplacements_results = mysqli_query($db, $sql_emplacements);
if ($emplacements_results === false) {
    echo mysqli_error($db);
} else {
    $emplacements = mysqli_fetch_all($emplacements_results, MYSQLI_ASSOC);
}

// Tous les pontons
$sql_pontons = "SELECT * FROM `ponton`";
$pontons_results = mysqli_query($db, $sql_pontons);
if ($pontons_results === false) {
    echo mysqli_error($db);
} else {
    $pontons = mysqli_fetch_all($pontons_results, MYSQLI_ASSOC);
}

// Les bateaux non amarrés
$sql_bateaux_non_amarres = "SELECT nom, id FROM bateau WHERE amarre = 0";
$bateaux_non_amarres_results = mysqli_query($db, $sql_bateaux_non_amarres);
if ($bateaux_non_amarres_results === false) {
    echo mysqli_error($db);
} else {
    $bateaux_non_amarres = mysqli_fetch_all($bateaux_non_amarres_results, MYSQLI_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="reset.css">
    <link rel="stylesheet" href="style.css">
    <title>Le Port</title>
</head>

<body>
    <form action="./controllers/nouveauBateau.php" class="bateauForm" method="post">
        <Fieldset>
            <legend>Nouveau bateau</legend>
            <label>Nom du bateau :
                <input name="nomBateau"></input>
            </label>
            <input type="submit" value="Enregistrer le bateau">
        </Fieldset>
    </form>
    <div class="pontonContainer">
    <?php

    foreach ($pontons as $ponton) :
        $filteredEmplacements = array_filter($emplacements, function ($elem) use ($ponton) {
            return $elem["pontonId"] == $ponton["id"];
        });
    ?>

        <div class="ponton">
            <?php foreach ($filteredEmplacements as $emplacement) : ?>
                <div class="dockContainer">
                    <div class=<?= $emplacement["bateauId"] ? "'emplacement loue'" : "'emplacement'" ?> data-dock-id=<?= $emplacement["emplacementId"] ?>>
                        <?= $emplacement["bateauNom"] ? '<p>' . $emplacement["bateauNom"] . '</p>' : '<p> dock ' . $emplacement["numeroPonton"] . '</p>' ?>
                    </div>
                    <?php if (!$emplacement["bateauId"]) : ?>
                        <div class="formOverlay" id="overlay<?= $emplacement["emplacementId"] ?>" data-dock-id=<?= $emplacement["emplacementId"] ?>></div>
                        <form action="./controllers/amarreBateau.php" class="dockForm" id="dockForm<?= $emplacement["emplacementId"] ?>" method="post">
                            <fieldset>
                                <legend>Quel bateau amarrer à l'emplacement N°<?= $emplacement["numeroPonton"] ?> du ponton <?= $emplacement["pontonId"] ?> ?</legend>
                                <input type="number" name="dockId" class="hiddenInput" value=<?= $emplacement["emplacementId"] ?> readonly="readonly">
                                <select name="bateauSelect">
                                    <?php foreach ($bateaux_non_amarres as $bateau) : ?>
                                        <option value=<?= $bateau["id"] ?>><?= $bateau["nom"] ?></option>
                                    <?php endforeach ?>
                                </select>
                                <input type="submit" value="valider">
                            </fieldset>
                        </form>
                    <?php else : ?>
                        <div class="formOverlay" id="overlay<?= $emplacement["emplacementId"] ?>" data-dock-id=<?= $emplacement["emplacementId"] ?>></div>
                        <form action="./controllers/departBateau.php" class="dockForm" id="dockForm<?= $emplacement["emplacementId"] ?>" method="post">
                            <fieldset>
                                <legend>Voulez-vous retirer ce bateau du ponton ?</legend>
                                <input type="number" name="dockId" class="hiddenInput" value=<?= $emplacement["emplacementId"] ?> readonly="readonly">
                                <input type="number" name="bateauId" class="hiddenInput" value=<?= $emplacement["bateauId"] ?> readonly="readonly">
                                <input type="submit" value="valider">
                            </fieldset>
                        </form>
                    <?php endif ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>
    </div>
    <script src="./script.js"></script>
</body>

</html>