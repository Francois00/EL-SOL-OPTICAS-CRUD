<?php
include '../funciones.php'; 
$config = include '../config.php'; 

try {
    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);
} catch (PDOException $e) {
    die('Error de conexión: ' . $e->getMessage());
}

$query2 = "CALL obtenerProductoConMayorStock()";
$sentencia2 = $conexion->prepare($query2);
$sentencia2->execute();
$resultado2 = $sentencia2->fetchAll(PDO::FETCH_ASSOC);

?>

<?php include '../templates/header.php'; ?>

<div class="container mt-3">
    <h2>Consulta 2: Producto con Mayor Stock</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Tipo de Producto</th>
                <th>Proveedor</th>
                <th>Mayor Stock</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($resultado2 as $fila) { ?>
                <tr>
                    <td><?= escapar($fila['nombre']) ?></td>
                    <td><?= escapar($fila['tipo_de_producto']) ?></td>
                    <td><?= escapar($fila['nombre_proveedor']) ?></td>
                    <td><?= escapar($fila['Mayor_Producto']) ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<?php include '../templates/footer.php'; ?>
