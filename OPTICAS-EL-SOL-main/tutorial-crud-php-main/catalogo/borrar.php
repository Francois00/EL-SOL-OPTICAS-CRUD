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

    if (isset($_GET['codigo_catalogo'])) {
        $codigo_catalogo = $_GET['codigo_catalogo'];
        $consultaSQL = "DELETE FROM Catalogo WHERE codigo_catalogo = :codigo_catalogo";
        $sentencia = $conexion->prepare($consultaSQL);
        $sentencia->bindParam(':codigo_catalogo', $codigo_catalogo, PDO::PARAM_STR);
        $sentencia->execute();
        header('Location: index.php');
        exit;
    } else {
        throw new Exception('No se proporcionó un código de catálogo válido.');
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

