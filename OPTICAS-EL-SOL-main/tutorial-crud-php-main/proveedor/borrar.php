<?php
include '../funciones.php';

// Cargar configuración de la base de datos
$config = include '../config.php';

$resultado = [
    'error' => false,
    'mensaje' => ''
];

try {
    // Configuración de conexión
    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

    // Verificar si se recibió el código del proveedor a eliminar
    if (isset($_GET['codigo_proveedor'])) {
        $codigo_proveedor = $_GET['codigo_proveedor'];

        // Llamar al procedimiento almacenado para eliminar el proveedor
        $consultaSQL = "CALL borrarProveedor(:codigo_proveedor)";

        // Preparar y ejecutar la consulta
        $sentencia = $conexion->prepare($consultaSQL);
        $sentencia->bindParam(':codigo_proveedor', $codigo_proveedor, PDO::PARAM_STR);
        $sentencia->execute();

        // Redirigir al índice después de eliminar
        header('Location: index.php');
        exit;
    } else {
        throw new Exception('No se proporcionó un código de proveedor válido.');
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
