<?php
include '../funciones.php';

$config = include '../config.php';

$resultado = [
    'error' => false,
    'mensaje' => ''
];

try {
    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

    if (isset($_GET['codigo_producto'])) {
        $codigo_producto = $_GET['codigo_producto'];
        $consultaSQL = "DELETE FROM Producto WHERE codigo_producto = :codigo_producto";
        $sentencia = $conexion->prepare($consultaSQL);
        $sentencia->bindParam(':codigo_producto', $codigo_producto, PDO::PARAM_STR);
        $sentencia->execute();
        header('Location: index.php');
        exit;
    } else {
        throw new Exception('No se proporcionó un código de producto válido.');
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
