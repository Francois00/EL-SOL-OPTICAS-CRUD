<?php
include '../funciones.php';

csrf();
if (isset($_POST['submit']) && !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
  die();
}

$config = include '../config.php';

$resultado = [
  'error' => false,
  'mensaje' => ''
];

if (!isset($_GET['codigo_proveedor'])) {
  $resultado['error'] = true;
  $resultado['mensaje'] = 'El proveedor no existe';
}

if (isset($_POST['submit'])) {
  try {
    // Configuración de la conexión
    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

    // Datos del proveedor
    $proveedor = [
      "codigo_proveedor" => $_GET['codigo_proveedor'],
      "nombre_proveedor" => $_POST['nombre_proveedor']
    ];

    // Llamada al procedimiento almacenado para modificar el proveedor
    $consultaSQL = "CALL modificarProveedor(:codigo_proveedor, :nombre_proveedor)";
    $consulta = $conexion->prepare($consultaSQL);
    $consulta->bindParam(':codigo_proveedor', $proveedor['codigo_proveedor'], PDO::PARAM_STR);
    $consulta->bindParam(':nombre_proveedor', $proveedor['nombre_proveedor'], PDO::PARAM_STR);
    $consulta->execute();

    $resultado['mensaje'] = 'El proveedor ' . escapar($_POST['nombre_proveedor']) . ' ha sido actualizado correctamente';

  } catch (PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
  }
}

try {
  // Conexión a la base de datos
  $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
  $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

  // Obtener los datos del proveedor
  $codigo_proveedor = $_GET['codigo_proveedor'];
  $consultaSQL = "CALL leerProveedorPorCodigo(:codigo_proveedor)";

  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->bindParam(':codigo_proveedor', $codigo_proveedor, PDO::PARAM_STR);
  $sentencia->execute();

  $proveedor = $sentencia->fetch(PDO::FETCH_ASSOC);

  if (!$proveedor) {
    $resultado['error'] = true;
    $resultado['mensaje'] = 'No se ha encontrado el proveedor';
  }

} catch (PDOException $error) {
  $resultado['error'] = true;
  $resultado['mensaje'] = $error->getMessage();
}
?>

<?php require "../templates/header.php"; ?>

<?php
if ($resultado['error']) {
  ?>
  <div class="container mt-2">
    <div class="row">
      <div class="col-md-12">
        <div class="alert alert-danger" role="alert">
          <?= $resultado['mensaje'] ?>
        </div>
      </div>
    </div>
  </div>
  <?php
}
?>

<?php
if (isset($_POST['submit']) && !$resultado['error']) {
  ?>
  <div class="container mt-2">
    <div class="row">
      <div class="col-md-12">
        <div class="alert alert-success" role="alert">
          El proveedor ha sido actualizado correctamente
        </div>
      </div>
    </div>
  </div>
  <?php
}
?>

<?php
if (isset($proveedor) && $proveedor) {
  ?>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h2 class="mt-4">Editando el proveedor
          <?= escapar($proveedor['codigo_proveedor']) . ' ' . escapar($proveedor['nombre_proveedor']) ?>
        </h2>
        <hr>
        <form method="post">
          <div class="form-group">
            <label for="nombre_proveedor">Nombre del Proveedor</label>
            <input type="text" name="nombre_proveedor" id="nombre_proveedor" value="<?= escapar($proveedor['nombre_proveedor']) ?>" class="form-control" required>
          </div>
          <div class="form-group">
            <input name="csrf" type="hidden" value="<?php echo escapar($_SESSION['csrf']); ?>">
            <input type="submit" name="submit" class="btn btn-primary" value="Actualizar">
            <a class="btn btn-primary" href="index.php">Regresar al inicio</a>
          </div>
        </form>
      </div>
    </div>
  </div>
  <?php
}
?>

<?php require "../templates/footer.php"; ?>
