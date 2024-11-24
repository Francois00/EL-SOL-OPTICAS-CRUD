<?php

include '../funciones.php';

csrf();
if (isset($_POST['submit']) && !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
  die();
}

if (isset($_POST['submit'])) {
  $resultado = [
    'error' => false,
    'mensaje' => 'El proveedor ' . escapar($_POST['nombre_proveedor']) . ' ha sido agregado con éxito'
  ];

  $config = include '../config.php';

  try {
    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

    $consultaSQL = "CALL insertarProveedor(:codigo_proveedor, :nombre_proveedor)";
    $sentencia = $conexion->prepare($consultaSQL);

    $sentencia->bindParam(':codigo_proveedor', $_POST['codigo_proveedor'], PDO::PARAM_STR);
    $sentencia->bindParam(':nombre_proveedor', $_POST['nombre_proveedor'], PDO::PARAM_STR);

    $sentencia->execute();

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
      <h2 class="mt-4">Crea un Proveedor</h2>
      <hr>
      <form method="post">
        <div class="form-group">
          <label for="codigo_proveedor">Código del Proveedor</label>
          <input type="text" name="codigo_proveedor" id="codigo_proveedor" class="form-control" required>
        </div>
        <div class="form-group">
          <label for="nombre_proveedor">Nombre del Proveedor</label>
          <input type="text" name="nombre_proveedor" id="nombre_proveedor" class="form-control" required>
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
