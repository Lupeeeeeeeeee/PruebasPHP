<?php
include("conexion.php");

/* INSERTAR */
if (isset($_POST['guardar'])) {

    $nombre = $_POST['nombre'];
    $email  = $_POST['email'];

    $stmt = mysqli_prepare($conexion,
        "INSERT INTO usuarios (nombre, email) VALUES (?, ?)");

    mysqli_stmt_bind_param($stmt, "ss", $nombre, $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

/* ACTUALIZAR */
if (isset($_POST['actualizar'])) {

    $id     = $_POST['id'];
    $nombre = $_POST['nombre'];
    $email  = $_POST['email'];

    $stmt = mysqli_prepare($conexion,
        "UPDATE usuarios SET nombre=?, email=? WHERE id=?");

    mysqli_stmt_bind_param($stmt, "ssi", $nombre, $email, $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html>
<head>
<title>CRUD Seguro</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body style="background: linear-gradient(135deg,#0f2027,#203a43,#2c5364); min-height:100vh;">

<div class="container d-flex justify-content-center align-items-center" style="min-height:100vh;">
<div class="card shadow-lg p-4" style="width: 1000px; border-radius:20px;">

<h2 class="text-center text-primary mb-4 fw-bold">Lista de Usuarios</h2>

<!-- FORM -->
<form method="POST" class="mb-4">
<div class="row g-3">
<div class="col-md-5">
<input type="text" name="nombre" class="form-control" placeholder="Nombre" required>
</div>
<div class="col-md-5">
<input type="email" name="email" class="form-control" placeholder="Email" required>
</div>
<div class="col-md-2">
<button type="submit" name="guardar" class="btn btn-primary w-100">
Guardar
</button>
</div>
</div>
</form>

<hr>



<table class="table table-hover table-striped text-center align-middle">
<thead class="table-primary">
<tr>
<th>ID</th>
<th>Nombre</th>
<th>Email</th>
<th>Acciones</th>
</tr>
</thead>
<tbody>

<?php
$resultado = mysqli_query($conexion, "SELECT * FROM usuarios");

while ($fila = mysqli_fetch_assoc($resultado)) {
?>

<tr>
<td><?php echo $fila['id']; ?></td>
<td><?php echo htmlspecialchars($fila['nombre']); ?></td>
<td><?php echo htmlspecialchars($fila['email']); ?></td>
<td>

<button class="btn btn-outline-primary btn-sm"
data-bs-toggle="modal"
data-bs-target="#editarModal<?php echo $fila['id']; ?>">
Editar
</button>

<a href="eliminar.php?id=<?php echo $fila['id']; ?>"
class="btn btn-outline-danger btn-sm">
Eliminar
</a>

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
value="<?php echo htmlspecialchars($fila['nombre']); ?>">

<input type="email" name="email"
class="form-control"
value="<?php echo htmlspecialchars($fila['email']); ?>">
</div>

<div class="modal-footer">
<button type="submit" name="actualizar"
class="btn btn-success">
Actualizar
</button>
</div>
</form>
</div>
</div>
</div>

<?php } ?>

</tbody>
</table>

</div>
</div>

</body>
</html>

