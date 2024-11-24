<?php

include '../funciones.php';

csrf();
if (isset($_POST['submit']) && !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
    die();
}

if (isset($_POST['submit'])) {
    $resultado = [
        'error' => false,
        'mensaje' => 'El producto ' . escapar($_POST['nombre']) . ' ha sido agregado con éxito'
    ];

    $config = include '../config.php';

    try {
        $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
        $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

        $producto = [
            "codigo_producto" => $_POST['codigo_producto'],
            "nombre" => $_POST['nombre'],
            "marca" => $_POST['marca'],
            "descripcion" => $_POST['descripcion'],
            "precio" => $_POST['precio'],
            "tipo_de_producto" => $_POST['tipo_de_producto'],
            "codigo_catalogo" => $_POST['codigo_catalogo']
        ];

        $consultaSQL = "INSERT INTO Producto (codigo_producto, nombre, marca, descripcion, precio, tipo_de_producto, codigo_catalogo) 
                        VALUES (:codigo_producto, :nombre, :marca, :descripcion, :precio, :tipo_de_producto, :codigo_catalogo)";

        $sentencia = $conexion->prepare($consultaSQL);
        $sentencia->execute($producto);

    } catch (PDOException $error) {
        $resultado['error'] = true;
        $resultado['mensaje'] = $error->getMessage();
    }
}
?>

<?php include '../templates/header.php'; ?>

<?php if (isset($resultado)) { ?>
<div class="container mt-3">
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-<?= $resultado['error'] ? 'danger' : 'success' ?>" role="alert">
                <?= $resultado['mensaje'] ?>
            </div>
        </div>
    </div>
</div>
<?php } ?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2 class="mt-4">Crea un Producto</h2>
            <hr>
            <form method="post">
                <div class="form-group">
                    <label for="codigo_producto">Código del Producto</label>
                    <input type="text" name="codigo_producto" id="codigo_producto" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="nombre">Nombre del Producto</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="marca">Marca</label>
                    <input type="text" name="marca" id="marca" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="descripcion">Descripción</label>
                    <input type="text" name="descripcion" id="descripcion" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="precio">Precio</label>
                    <input type="number" step="0.01" name="precio" id="precio" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="tipo_de_producto">Tipo de Producto</label>
                    <input type="text" name="tipo_de_producto" id="tipo_de_producto" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="codigo_catalogo">Código del Catálogo</label>
                    <input type="text" name="codigo_catalogo" id="codigo_catalogo" class="form-control" required>
                </div>
                <div class="form-group">
                    <input name="csrf" type="hidden" value="<?php echo escapar($_SESSION['csrf']); ?>">
                    <input type="submit" name="submit" class="btn btn-primary" value="Enviar">
                    <a class="btn btn-primary" href="index.php">Regresar al inicio</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include '../templates/footer.php'; ?>
