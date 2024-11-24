<?php
include '../funciones.php'; 
$config = include '../config.php'; 

try {
    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);
} catch (PDOException $e) {
    die('Error de conexión: ' . $e->getMessage());
}

$query4 = "SELECT proveedor.nombre_proveedor, proveedor_correos.correo, producto.nombre as Nombre_Producto
           FROM proveedor
           INNER JOIN proveedor_correos
           ON proveedor.codigo_proveedor = proveedor_correos.codigo_proveedor
           INNER JOIN distribuir_productos
           ON distribuir_productos.codigo_proveedor = proveedor_correos.codigo_proveedor
           INNER JOIN producto
           ON producto.codigo_producto = distribuir_productos.codigo_producto
           WHERE proveedor_correos.correo LIKE '%yahoo%'
           ORDER BY proveedor.nombre_proveedor";

$sentencia4 = $conexion->prepare($query4);
$sentencia4->execute();
$resultado4 = $sentencia4->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include '../templates/header.php'; ?>

<div class="container mt-3">
    <h2>Consulta 4: Proveedores con correos Yahoo y Productos Distribuidos</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Proveedor</th>
                <th>Correo</th>
                <th>Nombre Producto</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($resultado4 as $fila) { ?>
                <tr>
                    <td><?= escapar($fila['nombre_proveedor']) ?></td>
                    <td><?= escapar($fila['correo']) ?></td>
                    <td><?= escapar($fila['Nombre_Producto']) ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<?php include '../templates/footer.php'; ?>
