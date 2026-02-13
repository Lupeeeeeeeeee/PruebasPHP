<?php
include("conexion.php");

// INSERTAR
if (isset($_POST['guardar'])) {

    $nombre = $_POST['nombre'];
    $email = $_POST['email'];

    // VULNERABLE
    $sql = "INSERT INTO usuarios (nombre, email)
            VALUES ('$nombre', '$email')";

    mysqli_query($conexion, $sql);
}

// ACTUALIZAR
if (isset($_POST['actualizar'])) {

    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];

    // VULNERABLE
    $sql = "UPDATE usuarios 
            SET nombre='$nombre', email='$email'
            WHERE id=$id";

    mysqli_query($conexion, $sql);
}
?>

<!DOCTYPE html>
<html>
<head>
<title>CRUD Vulnerable</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="container mt-4">

<h2>Añadir Usuario</h2>

<form method="POST">
    <input type="text" name="nombre" placeholder="Nombre" class="form-control mb-2" required>
    <input type="email" name="email" placeholder="Email" class="form-control mb-2" required>
    <button type="submit" name="guardar" class="btn btn-primary">Guardar</button>
</form>

<hr>

<h2>Lista de Usuarios</h2>

<table class="table table-bordered">
<tr>
    <th>ID</th>
    <th>Nombre</th>
    <th>Email</th>
    <th>Acciones</th>
</tr>

<?php
$resultado = mysqli_query($conexion, "SELECT * FROM usuarios");

while ($fila = mysqli_fetch_assoc($resultado)) {
?>

<tr>
<td><?php echo $fila['id']; ?></td>
<td><?php echo $fila['nombre']; ?></td>
<td><?php echo $fila['email']; ?></td>
<td>

<button class="btn btn-warning btn-sm"
data-bs-toggle="modal"
data-bs-target="#editarModal<?php echo $fila['id']; ?>">
Editar
</button>

<a href="eliminar.php?id=<?php echo $fila['id']; ?>" 
class="btn btn-danger btn-sm">Eliminar</a>

</td>
</tr>

<!-- MODAL -->
<div class="modal fade" id="editarModal<?php echo $fila['id']; ?>">
<div class="modal-dialog">
<div class="modal-content">
<form method="POST">
<div class="modal-header">
<h5 class="modal-title">Editar Usuario</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">
<input type="hidden" name="id" value="<?php echo $fila['id']; ?>">

<input type="text" name="nombre" 
class="form-control mb-2"
value="<?php echo $fila['nombre']; ?>">

<input type="email" name="email"
class="form-control"
value="<?php echo $fila['email']; ?>">
</div>

<div class="modal-footer">
<button type="submit" name="actualizar" class="btn btn-success">
Actualizar
</button>
</div>
</form>
</div>
</div>
</div>

<?php } ?>

</table>

</body>
</html>
