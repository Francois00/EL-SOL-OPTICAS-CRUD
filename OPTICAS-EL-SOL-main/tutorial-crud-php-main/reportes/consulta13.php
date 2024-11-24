<?php
include '../funciones.php'; 
$config = include '../config.php'; 

try {
    // Conexión a la base de datos
    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);
} catch (PDOException $e) {
    die('Error de conexión: ' . $e->getMessage());
}

$query13 = "SELECT Producto.tipo_de_producto AS 'Tipo de producto',
                   Producto.descripcion AS 'Descripcion',
                   Producto.precio AS 'Precio'
            FROM Producto
            WHERE Producto.tipo_de_producto = 'MONTURA PARA NIÑOS'
            AND Producto.nombre LIKE '%SOLAR%'
            AND Producto.precio < 150";

$sentencia13 = $conexion->prepare($query13);
$sentencia13->execute();
$resultado13 = $sentencia13->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include '../templates/header.php'; ?>

<div class="container mt-3">
    <h2>Consulta 13: Productos de Tipo "MONTURA PARA NIÑOS" y Precio Menor a 150</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Tipo de Producto</th>
                <th>Descripción</th>
                <th>Precio</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($resultado13 && count($resultado13) > 0) { ?>
                <?php foreach ($resultado13 as $fila) { ?>
                    <tr>
                        <td><?= escapar($fila['Tipo de producto']) ?></td>
                        <td><?= escapar($fila['Descripcion']) ?></td>
                        <td><?= escapar($fila['Precio']) ?></td>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <tr>
                    <td colspan="3">No se encontraron resultados</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<?php include '../templates/footer.php'; ?>
