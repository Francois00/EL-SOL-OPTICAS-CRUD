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

if (!isset($_GET['codigo_empleado'])) {
  $resultado['error'] = true;
  $resultado['mensaje'] = 'El empleado no existe';
}

if (isset($_POST['submit'])) {
  try {
    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

    $empleado = [
      "codigo_empleado" => $_GET['codigo_empleado'],
      "nombre_empleado" => $_POST['nombre_empleado'],
      "turno" => $_POST['turno'],
      "estado" => $_POST['estado']
    ];

    $consultaSQL = "UPDATE Empleado SET
        nombre_empleado = :nombre_empleado,
        turno = :turno,
        estado = :estado
        WHERE codigo_empleado = :codigo_empleado";

    $consulta = $conexion->prepare($consultaSQL);
    $consulta->execute($empleado);

  } catch (PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
  }
}

try {
  $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
  $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

  $codigo_empleado = $_GET['codigo_empleado'];
  $consultaSQL = "SELECT * FROM Empleado WHERE codigo_empleado = :codigo_empleado";

  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->bindParam(':codigo_empleado', $codigo_empleado, PDO::PARAM_STR);
  $sentencia->execute();

  $empleado = $sentencia->fetch(PDO::FETCH_ASSOC);

  if (!$empleado) {
    $resultado['error'] = true;
    $resultado['mensaje'] = 'No se ha encontrado el empleado';
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
          El empleado ha sido actualizado correctamente
        </div>
      </div>
    </div>
  </div>
  <?php
}
?>

<?php
if (isset($empleado) && $empleado) {
  ?>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h2 class="mt-4">Editando el empleado
          <?= escapar($empleado['codigo_empleado']) . ' ' . escapar($empleado['nombre_empleado']) ?>
        </h2>
        <hr>
        <form method="post">
          <div class="form-group">
            <label for="nombre_empleado">Nombre del Empleado</label>
            <input type="text" name="nombre_empleado" id="nombre_empleado" value="<?= escapar($empleado['nombre_empleado']) ?>" class="form-control" required>
          </div>
          <div class="form-group">
            <label for="turno">Turno</label>
            <input type="text" name="turno" id="turno" value="<?= escapar($empleado['turno']) ?>" class="form-control" required>
          </div>
          <div class="form-group">
            <label for="estado">Estado</label>
            <input type="text" name="estado" id="estado" value="<?= escapar($empleado['estado']) ?>" class="form-control" required>
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
