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

$query8 = "SELECT P.numero_pedido, PR.codigo_producto, PR.nombre, PR.precio
           FROM Producto as PR
           INNER JOIN Incluir_Producto as P
           ON P.codigo_producto = PR.codigo_producto
           WHERE PR.nombre LIKE 'SOLAR%' AND PR.nombre LIKE '%NIÑO%'
           ORDER BY P.numero_pedido ASC";

$sentencia8 = $conexion->prepare($query8);
$sentencia8->execute();
$resultado8 = $sentencia8->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include '../templates/header.php'; ?>

<div class="container mt-3">
    <h2>Consulta 8: Productos "SOLAR" para "NIÑO" en Pedidos</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Número de Pedido</th>
                <th>Código de Producto</th>
                <th>Nombre</th>
                <th>Precio</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($resultado8 && count($resultado8) > 0) { ?>
                <?php foreach ($resultado8 as $fila) { ?>
                    <tr>
                        <td><?= escapar($fila['numero_pedido']) ?></td>
                        <td><?= escapar($fila['codigo_producto']) ?></td>
                        <td><?= escapar($fila['nombre']) ?></td>
                        <td><?= escapar($fila['precio']) ?></td>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <tr>
                    <td colspan="4">No se encontraron resultados</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<?php include '../templates/footer.php'; ?>
