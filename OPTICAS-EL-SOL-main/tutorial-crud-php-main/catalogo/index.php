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

    if (isset($_POST['codigo_catalogo'])) {
        $consultaSQL = "SELECT * FROM Catalogo WHERE codigo_catalogo LIKE :codigo_catalogo";
        $sentencia = $conexion->prepare($consultaSQL);
        $codigo_catalogo = "%" . $_POST['codigo_catalogo'] . "%";
        $sentencia->bindParam(':codigo_catalogo', $codigo_catalogo, PDO::PARAM_STR);
    } else {
        $consultaSQL = "SELECT * FROM Catalogo";
        $sentencia = $conexion->prepare($consultaSQL);
    }

    $sentencia->execute();
    $catalogos = $sentencia->fetchAll();

} catch (PDOException $error) {
    $error = $error->getMessage();
}

$titulo = isset($_POST['codigo_catalogo']) ? 'Lista de catálogos (' . $_POST['codigo_catalogo'] . ')' : 'Lista de catálogos';
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
            <a href="crear.php" class="btn btn-primary mt-4">Crear Catálogo</a>
            <hr>
            <form method="post" class="form-inline">
                <div class="form-group mr-3">
                    <input type="text" id="codigo_catalogo" name="codigo_catalogo" placeholder="Buscar por Código" class="form-control">
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
                        <th>Versión</th>
                        <th>Tipo de Productos</th>
                        <th>Fecha Última Modificación</th>
                        <th>Stock</th>
                        <th>Código Empleado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($catalogos && $sentencia->rowCount() > 0) {
                        foreach ($catalogos as $fila) { ?>
                            <tr>
                                <td><?php echo escapar($fila["codigo_catalogo"]); ?></td>
                                <td><?php echo escapar($fila["version"]); ?></td>
                                <td><?php echo escapar($fila["tipo_de_productos"]); ?></td>
                                <td><?php echo escapar($fila["fecha_ultima_modificacion"]); ?></td>
                                <td><?php echo escapar($fila["stock"]); ?></td>
                                <td><?php echo escapar($fila["codigo_empleado"]); ?></td>
                                <td>
                                    <a href="<?= 'borrar.php?codigo_catalogo=' . escapar($fila["codigo_catalogo"]) ?>">🗑️Borrar</a>
                                    <a href="<?= 'editar.php?codigo_catalogo=' . escapar($fila["codigo_catalogo"]) ?>">✏️Editar</a>
                                </td>
                            </tr>
                        <?php }
                    } else { ?>
                        <tr>
                            <td colspan="7">No se encontraron resultados</td>
                        </tr>
                    <?php } ?>
                <tbody>
            </table>
        </div>
    </div>
</div>

<?php include '../templates/footer.php'; ?>
