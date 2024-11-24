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

    if (isset($_POST['codigo_producto'])) {
       
        $consultaSQL = "CALL leerProductoPorCodigo(:codigo_producto)";
        $sentencia = $conexion->prepare($consultaSQL);
        $codigo_producto = "%" . $_POST['codigo_producto'] . "%";
        $sentencia->bindParam(':codigo_producto', $codigo_producto, PDO::PARAM_STR);
    } else {
        
        $consultaSQL = "CALL leerProducto()";
        $sentencia = $conexion->prepare($consultaSQL);
    }

    $sentencia->execute();
    $productos = $sentencia->fetchAll();

} catch (PDOException $error) {
    $error = $error->getMessage();
}

$titulo = isset($_POST['codigo_producto']) ? 'Lista de productos (' . $_POST['codigo_producto'] . ')' : 'Lista de productos';
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
            <a href="crear.php" class="btn btn-primary mt-4">Crear Producto</a>
            <hr>
            <form method="post" class="form-inline">
                <div class="form-group mr-3">
                    <input type="text" id="codigo_producto" name="codigo_producto" placeholder="Buscar por Código" class="form-control">
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
                        <th>Marca</th>
                        <th>Descripción</th>
                        <th>Precio</th>
                        <th>Tipo de Producto</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($productos && $sentencia->rowCount() > 0) {
                        foreach ($productos as $fila) { ?>
                            <tr>
                                <td><?php echo escapar($fila["codigo_producto"]); ?></td>
                                <td><?php echo escapar($fila["nombre"]); ?></td>
                                <td><?php echo escapar($fila["marca"]); ?></td>
                                <td><?php echo escapar($fila["descripcion"]); ?></td>
                                <td><?php echo escapar($fila["precio"]); ?></td>
                                <td><?php echo escapar($fila["tipo_de_producto"]); ?></td>
                                <td>
                                    <a href="<?= 'borrar.php?codigo_producto=' . escapar($fila["codigo_producto"]) ?>">🗑️Borrar</a>
                                    <a href="<?= 'editar.php?codigo_producto=' . escapar($fila["codigo_producto"]) ?>">✏️Editar</a>
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
