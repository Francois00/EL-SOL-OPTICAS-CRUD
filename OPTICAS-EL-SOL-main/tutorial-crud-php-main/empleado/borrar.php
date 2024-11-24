<?php

include '../funciones.php';

$config = include '../config.php';

$resultado = [
    'error' => false,
    'mensaje' => ''
];

try {
    // Configuración de la conexión
    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

    if (isset($_GET['codigo_empleado'])) {
        $codigo_empleado = $_GET['codigo_empleado'];

        // Llamar al procedimiento almacenado para eliminar el empleado
        $consultaSQL = "CALL borrarEmpleado(:codigo_empleado)";
        $sentencia = $conexion->prepare($consultaSQL);
        $sentencia->bindParam(':codigo_empleado', $codigo_empleado, PDO::PARAM_STR);
        $sentencia->execute();

        // Redirigir al índice después de eliminar
        header('Location: index.php');
        exit;
    } else {
        throw new Exception('No se proporcionó un código de empleado válido.');
    }

} catch (PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = 'Error en la base de datos: ' . $error->getMessage();
} catch (Exception $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
}
?>

<?php require "../templates/header.php"; ?>

<div class="container mt-2">
    <?php if ($resultado['error']): ?>
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-danger" role="alert">
                    <?= $resultado['mensaje'] ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php require "../templates/footer.php"; ?>
