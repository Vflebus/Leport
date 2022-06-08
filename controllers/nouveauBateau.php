<?php

require "../model/database.php";
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $sql = "INSERT INTO bateau (nom, amarre) VALUES (?, 0);";
    $stmt = mysqli_prepare($db, $sql);
    mysqli_stmt_bind_param($stmt, "s", $_POST['nomBateau']);
    mysqli_stmt_execute($stmt);
    header('Location: ../index.php');
} else {
    echo "erreur !!!!";
}