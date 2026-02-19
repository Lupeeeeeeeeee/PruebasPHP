<?php
include("conexion.php");

if (isset($_GET['id'])) {

    $id = $_GET['id'];

    $stmt = mysqli_prepare($conexion, 
        "DELETE FROM usuarios WHERE id=?");

    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

header("Location: index.php");
exit();
?>
