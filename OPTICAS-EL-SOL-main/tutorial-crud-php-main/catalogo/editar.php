<?php

include '../funciones.php';

csrf();
if (isset($_POST['submit']) && !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
    die();
}

$error = false;
$config = include '../config.php';

$resultado = [
    'error' => false,
    'mensaje' => ''
];

if (!isset($_GET['codigo_catalogo'])) {
    $resultado['error'] = true;
    $resultado['mensaje'] = 'El catálogo no existe';
}

if (isset($_POST['submit'])) {
    try {
        // Configuración de la conexión
        $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
        $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

        // Preparar los datos del catálogo
        $catalogo = [
            "codigo_catalogo" => $_GET['codigo_catalogo'],
            "version" => $_POST['version'],
            "tipo_de_productos" => $_POST['tipo_de_productos'],
            "fecha_ultima_modificacion" => $_POST['fecha_ultima_modificacion'],
            "stock" => $_POST['stock'],
            "codigo_empleado" => $_POST['codigo_empleado']
        ];

        // Llamar al procedimiento almacenado para modificar el catálogo
        $consultaSQL = "CALL modificarCatalogo(:codigo_catalogo, :version, :tipo_de_productos, :fecha_ultima_modificacion, :stock, :codigo_empleado)";
        $sentencia = $conexion->prepare($consultaSQL);

        // Pasar los parámetros al procedimiento
        $sentencia->bindParam(':codigo_catalogo', $catalogo['codigo_catalogo'], PDO::PARAM_STR);
        $sentencia->bindParam(':version', $catalogo['version'], PDO::PARAM_INT);
        $sentencia->bindParam(':tipo_de_productos', $catalogo['tipo_de_productos'], PDO::PARAM_STR);
        $sentencia->bindParam(':fecha_ultima_modificacion', $catalogo['fecha_ultima_modificacion'], PDO::PARAM_STR);
        $sentencia->bindParam(':stock', $catalogo['stock'], PDO::PARAM_INT);
        $sentencia->bindParam(':codigo_empleado', $catalogo['codigo_empleado'], PDO::PARAM_STR);

        // Ejecutar el procedimiento
        $sentencia->execute();

        $resultado['mensaje'] = 'El catálogo ' . escapar($_POST['codigo_catalogo']) . ' ha sido actualizado correctamente';

    } catch (PDOException $error) {
        $resultado['error'] = true;
        $resultado['mensaje'] = $error->getMessage();
    }
}

try {
    // Conexión a la base de datos
    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

    // Obtener los datos del catálogo
    $codigo_catalogo = $_GET['codigo_catalogo'];
    $consultaSQL = "SELECT * FROM Catalogo WHERE codigo_catalogo = :codigo_catalogo";

    $sentencia = $conexion->prepare($consultaSQL);
    $sentencia->bindParam(':codigo_catalogo', $codigo_catalogo, PDO::PARAM_STR);
    $sentencia->execute();

    $catalogo = $sentencia->fetch(PDO::FETCH_ASSOC);

    if (!$catalogo) {
        $resultado['error'] = true;
        $resultado['mensaje'] = 'No se ha encontrado el catálogo';
    }

} catch (PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
}

?>

<?php require "../templates/header.php"; ?>

<?php if ($resultado['error']) { ?>
<div class="container mt-2">
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-danger" role="alert">
                <?= $resultado['mensaje'] ?>
            </div>
        </div>
    </div>
</div>
<?php } ?>

<?php if (isset($_POST['submit']) && !$resultado['error']) { ?>
<div class="container mt-2">
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-success" role="alert">
                El catálogo ha sido actualizado correctamente
            </div>
        </div>
    </div>
</div>
<?php } ?>

<?php if (isset($catalogo) && $catalogo) { ?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2 class="mt-4">Editando el catálogo <?= escapar($catalogo['codigo_catalogo']) ?></h2>
            <hr>
            <form method="post">
                <div class="form-group">
                    <label for="version">Versión</label>
                    <input type="number" name="version" id="version" value="<?= escapar($catalogo['version']) ?>" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="tipo_de_productos">Tipo de Productos</label>
                    <input type="text" name="tipo_de_productos" id="tipo_de_productos" value="<?= escapar($catalogo['tipo_de_productos']) ?>" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="fecha_ultima_modificacion">Fecha Última Modificación</label>
                    <input type="date" name="fecha_ultima_modificacion" id="fecha_ultima_modificacion" value="<?= escapar($catalogo['fecha_ultima_modificacion']) ?>" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="stock">Stock</label>
                    <input type="number" name="stock" id="stock" value="<?= escapar($catalogo['stock']) ?>" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="codigo_empleado">Código del Empleado</label>
                    <input type="text" name="codigo_empleado" id="codigo_empleado" value="<?= escapar($catalogo['codigo_empleado']) ?>" class="form-control" required>
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
<?php } ?>

<?php require "../templates/footer.php"; ?>
