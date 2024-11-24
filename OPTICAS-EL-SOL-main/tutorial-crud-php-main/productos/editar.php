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
        // Configuración de la conexión
        $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
        $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

        // Preparar los datos del producto
        $producto = [
            "codigo_producto" => $_GET['codigo_producto'],
            "nombre" => $_POST['nombre'],
            "marca" => $_POST['marca'],
            "descripcion" => $_POST['descripcion'],
            "precio" => $_POST['precio'],
            "tipo_de_producto" => $_POST['tipo_de_producto'],
            "codigo_catalogo" => $_POST['codigo_catalogo']  // Agregar este campo
        ];

        // Llamar al procedimiento almacenado para actualizar el producto
        $consultaSQL = "CALL modificarProducto(:codigo_producto, :nombre, :marca, :descripcion, :precio, :tipo_de_producto, :codigo_catalogo)";
        $consulta = $conexion->prepare($consultaSQL);

        // Pasar los parámetros al procedimiento
        $consulta->bindParam(':codigo_producto', $producto['codigo_producto'], PDO::PARAM_STR);
        $consulta->bindParam(':nombre', $producto['nombre'], PDO::PARAM_STR);
        $consulta->bindParam(':marca', $producto['marca'], PDO::PARAM_STR);
        $consulta->bindParam(':descripcion', $producto['descripcion'], PDO::PARAM_STR);
        $consulta->bindParam(':precio', $producto['precio'], PDO::PARAM_STR);
        $consulta->bindParam(':tipo_de_producto', $producto['tipo_de_producto'], PDO::PARAM_STR);
        $consulta->bindParam(':codigo_catalogo', $producto['codigo_catalogo'], PDO::PARAM_STR);  // Enlazar código_catalogo

        $consulta->execute();

        $resultado['mensaje'] = 'El producto ' . escapar($_POST['nombre']) . ' ha sido actualizado correctamente';

    } catch (PDOException $error) {
        $resultado['error'] = true;
        $resultado['mensaje'] = $error->getMessage();
    }
}

try {
    // Conexión a la base de datos
    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

    // Obtener los datos del producto
    $codigo_producto = $_GET['codigo_producto'];
    $consultaSQL = "CALL leerProductoPorCodigo(:codigo_producto)";

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
                    <label for="codigo_catalogo">Código del Catálogo</label>
                    <input type="text" name="codigo_catalogo" id="codigo_catalogo" value="<?= escapar($producto['codigo_catalogo']) ?>" class="form-control" required>
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
