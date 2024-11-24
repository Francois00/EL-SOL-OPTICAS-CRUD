<?php

include '../funciones.php';

csrf();
if (isset($_POST['submit']) && !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
  die();
}

if (isset($_POST['submit'])) {
  $resultado = [
    'error' => false,
    'mensaje' => 'El catálogo ' . escapar($_POST['codigo_catalogo']) . ' ha sido agregado con éxito'
  ];

  $config = include '../config.php';

  try {
    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

    $catalogo = [
      "codigo_catalogo" => $_POST['codigo_catalogo'],
      "version" => $_POST['version'],
      "tipo_de_productos" => $_POST['tipo_de_productos'],
      "fecha_ultima_modificacion" => $_POST['fecha_ultima_modificacion'],
      "stock" => $_POST['stock'],
      "codigo_empleado" => $_POST['codigo_empleado']
    ];

    $consultaSQL = "INSERT INTO Catalogo (codigo_catalogo, version, tipo_de_productos, fecha_ultima_modificacion, stock, codigo_empleado) 
                    VALUES (:codigo_catalogo, :version, :tipo_de_productos, :fecha_ultima_modificacion, :stock, :codigo_empleado)";

    $sentencia = $conexion->prepare($consultaSQL);
    $sentencia->execute($catalogo);

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
      <h2 class="mt-4">Crea un Catálogo</h2>
      <hr>
      <form method="post">
        <div class="form-group">
          <label for="codigo_catalogo">Código del Catálogo</label>
          <input type="text" name="codigo_catalogo" id="codigo_catalogo" class="form-control" required>
        </div>
        <div class="form-group">
          <label for="version">Versión</label>
          <input type="number" name="version" id="version" class="form-control" required>
        </div>
        <div class="form-group">
          <label for="tipo_de_productos">Tipo de Productos</label>
          <input type="text" name="tipo_de_productos" id="tipo_de_productos" class="form-control" required>
        </div>
        <div class="form-group">
          <label for="fecha_ultima_modificacion">Fecha Última Modificación</label>
          <input type="date" name="fecha_ultima_modificacion" id="fecha_ultima_modificacion" class="form-control" required>
        </div>
        <div class="form-group">
          <label for="stock">Stock</label>
          <input type="number" name="stock" id="stock" class="form-control" required>
        </div>
        <div class="form-group">
          <label for="codigo_empleado">Código del Empleado</label>
          <input type="text" name="codigo_empleado" id="codigo_empleado" class="form-control" required>
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
