<?php
include '../funciones.php';

csrf();
if (isset($_POST['submit']) && !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
    die();
}

$error = false;
$config = include '../config.php';

try {
    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

    if (isset($_POST['codigo_proveedor'])) {
        $consultaSQL = "SELECT * FROM Proveedor WHERE codigo_proveedor LIKE :codigo_proveedor";
        $sentencia = $conexion->prepare($consultaSQL);
        $codigo_proveedor = "%" . $_POST['codigo_proveedor'] . "%";
        $sentencia->bindParam(':codigo_proveedor', $codigo_proveedor, PDO::PARAM_STR);
    } else {
        $consultaSQL = "SELECT * FROM Proveedor";
        $sentencia = $conexion->prepare($consultaSQL);
    }

    $sentencia->execute();
    $proveedores = $sentencia->fetchAll();

} catch (PDOException $error) {
    $error = $error->getMessage();
}

$titulo = isset($_POST['codigo_proveedor']) ? 'Lista de proveedores (' . $_POST['codigo_proveedor'] . ')' : 'Lista de proveedores';
?>

<?php include '../templates/header.php'; ?>

<?php if ($error) { ?>
<div class="container mt-2">
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-danger" role="alert">
                <?= $error ?>
            </div>
        </div>
    </div>
</div>
<?php } ?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <a href="crear.php" class="btn btn-primary mt-4">Crear Proveedor</a>
            <hr>
            <form method="post" class="form-inline">
                <div class="form-group mr-3">
                    <input type="text" id="codigo_proveedor" name="codigo_proveedor" placeholder="Buscar por Código" class="form-control">
                </div>
                <input name="csrf" type="hidden" value="<?php echo escapar($_SESSION['csrf']); ?>">
                <button type="submit" name="submit" class="btn btn-primary">Ver resultados</button>
            </form>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2 class="mt-3"><?= $titulo ?></h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($proveedores && $sentencia->rowCount() > 0) {
                        foreach ($proveedores as $fila) { ?>
                            <tr>
                                <td><?php echo escapar($fila["codigo_proveedor"]); ?></td>
                                <td><?php echo escapar($fila["nombre_proveedor"]); ?></td>
                                <td>
                                    <a href="<?= 'borrar.php?codigo_proveedor=' . escapar($fila["codigo_proveedor"]) ?>">🗑️Borrar</a>
                                    <a href="<?= 'editar.php?codigo_proveedor=' . escapar($fila["codigo_proveedor"]) ?>">✏️Editar</a>
                                </td>
                            </tr>
                        <?php }
                    } else { ?>
                        <tr>
                            <td colspan="3">No se encontraron resultados</td>
                        </tr>
                    <?php } ?>
                <tbody>
            </table>
        </div>
    </div>
</div>

<?php include '../templates/footer.php'; ?>
