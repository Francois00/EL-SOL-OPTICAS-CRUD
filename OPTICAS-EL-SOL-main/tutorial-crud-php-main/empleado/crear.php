<?php

include '../funciones.php';

csrf();
if (isset($_POST['submit']) && !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
  die();
}

if (isset($_POST['submit'])) {
  $resultado = [
    'error' => false,
    'mensaje' => 'El empleado ' . escapar($_POST['nombre_empleado']) . ' ha sido agregado con éxito'
  ];

  $config = include '../config.php';

  try {
    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

    $empleado = [
      "codigo_empleado" => $_POST['codigo_empleado'],
      "nombre_empleado" => $_POST['nombre_empleado'],
      "turno" => $_POST['turno'],
      "estado" => $_POST['estado']
    ];

    $consultaSQL = "INSERT INTO Empleado (codigo_empleado, nombre_empleado, turno, estado) VALUES (:codigo_empleado, :nombre_empleado, :turno, :estado)";

    $sentencia = $conexion->prepare($consultaSQL);
    $sentencia->execute($empleado);

  } catch (PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
  }
}
?>

<?php include '../templates/header.php'; ?>

<?php
if (isset($resultado)) {
  ?>
  <div class="container mt-3">
    <div class="row">
      <div class="col-md-12">
        <div class="alert alert-<?= $resultado['error'] ? 'danger' : 'success' ?>" role="alert">
          <?= $resultado['mensaje'] ?>
        </div>
      </div>
    </div>
  </div>
  <?php
}
?>

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <h2 class="mt-4">Crea un Empleado</h2>
      <hr>
      <form method="post">
        <div class="form-group">
          <label for="codigo_empleado">Código del Empleado</label>
          <input type="text" name="codigo_empleado" id="codigo_empleado" class="form-control" required>
        </div>
        <div class="form-group">
          <label for="nombre_empleado">Nombre del Empleado</label>
          <input type="text" name="nombre_empleado" id="nombre_empleado" class="form-control" required>
        </div>
        <div class="form-group">
          <label for="turno">Turno</label>
          <input type="text" name="turno" id="turno" class="form-control" required>
        </div>
        <div class="form-group">
          <label for="estado">Estado</label>
          <input type="text" name="estado" id="estado" class="form-control" required>
        </div>
        <div class="form-group">
          <input name="csrf" type="hidden" value="<?php echo escapar($_SESSION['csrf']); ?>">
          <input type="submit" name="submit" class="btn btn-primary" value="Enviar">
          <a class="btn btn-primary" href="index.php">Regresar al inicio</a>
        </div>
      </form>
    </div>
  </div>
</div>

<?php include '../templates/footer.php'; ?>
