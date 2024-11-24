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

if (!isset($_GET['codigo_producto'])) {
    $resultado['error'] = true;
    $resultado['mensaje'] = 'El producto no existe';
}

if (isset($_POST['submit'])) {
    try {
        $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
        $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

        $producto = [
            "codigo_producto" => $_GET['codigo_producto'],
            "nombre" => $_POST['nombre'],
            "marca" => $_POST['marca'],
            "descripcion" => $_POST['descripcion'],
            "precio" => $_POST['precio'],
            "tipo_de_producto" => $_POST['tipo_de_producto']
        ];

        $consultaSQL = "UPDATE Producto SET
            nombre = :nombre,
            marca = :marca,
            descripcion = :descripcion,
            precio = :precio,
            tipo_de_producto = :tipo_de_producto
            WHERE codigo_producto = :codigo_producto";

        $consulta = $conexion->prepare($consultaSQL);
        $consulta->execute($producto);

    } catch (PDOException $error) {
        $resultado['error'] = true;
        $resultado['mensaje'] = $error->getMessage();
    }
}

try {
    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

    $codigo_producto = $_GET['codigo_producto'];
    $consultaSQL = "SELECT * FROM Producto WHERE codigo_producto = :codigo_producto";

    $sentencia = $conexion->prepare($consultaSQL);
    $sentencia->bindParam(':codigo_producto', $codigo_producto, PDO::PARAM_STR);
    $sentencia->execute();

    $producto = $sentencia->fetch(PDO::FETCH_ASSOC);

    if (!$producto) {
        $resultado['error'] = true;
        $resultado['mensaje'] = 'No se ha encontrado el producto';
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
                El producto ha sido actualizado correctamente
            </div>
        </div>
    </div>
</div>
<?php } ?>

<?php if (isset($producto) && $producto) { ?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2 class="mt-4">Editando el producto <?= escapar($producto['codigo_producto']) . ' ' . escapar($producto['nombre']) ?></h2>
            <hr>
            <form method="post">
                <div class="form-group">
                    <label for="nombre">Nombre del Producto</label>
                    <input type="text" name="nombre" id="nombre" value="<?= escapar($producto['nombre']) ?>" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="marca">Marca</label>
                    <input type="text" name="marca" id="marca" value="<?= escapar($producto['marca']) ?>" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="descripcion">Descripcion</label>
                    <input type="text" name="descripcion" id="descripcion" value="<?= escapar($producto['descripcion']) ?>" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="precio">Precio</label>
                    <input type="number" step="0.01" name="precio" id="precio" value="<?= escapar($producto['precio']) ?>" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="tipo_de_producto">Tipo de Producto</label>
                    <input type="text" name="tipo_de_producto" id="tipo_de_producto" value="<?= escapar($producto['tipo_de_producto']) ?>" class="form-control" required>
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
