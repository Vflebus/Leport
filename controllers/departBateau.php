<?php

require "../model/database.php";
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $sql = "UPDATE `emplacement` SET `bateauId`= NULL WHERE id = ?";
    $stmt = mysqli_prepare($db, $sql);
    mysqli_stmt_bind_param($stmt, "i", $_POST['dockId']);
    mysqli_stmt_execute($stmt);
    $sql_bateau_amarre = "UPDATE `bateau` SET `amarre`= 0 WHERE id = ?";
    $bateau_stmt = mysqli_prepare($db, $sql_bateau_amarre);
    mysqli_stmt_bind_param($bateau_stmt, "i", $_POST['bateauId']);
    mysqli_stmt_execute($bateau_stmt);
    header('Location: ../index.php');
} else {
    echo "erreur !!!!";
}