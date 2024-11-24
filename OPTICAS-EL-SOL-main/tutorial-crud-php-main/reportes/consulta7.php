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

$query7 = "CALL obtenerProductosInvolucradosEnPedidosPorEmpleado()";
$sentencia7 = $conexion->prepare($query7);
$sentencia7->execute();
$resultado7 = $sentencia7->fetchAll(PDO::FETCH_ASSOC);

?>

<?php include '../templates/header.php'; ?>

<div class="container mt-3">
    <h2>Consulta 7: Productos Incluidos en Pedidos por Empleados en Turno 'T'</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Número de Pedido</th>
                <th>Cantidad</th>
                <th>Empleado</th>
                <th>Código Proveedor</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($resultado7 && count($resultado7) > 0) { ?>
                <?php foreach ($resultado7 as $fila) { ?>
                    <tr>
                        <td><?= escapar($fila['numero_pedido']) ?></td>
                        <td><?= escapar($fila['cantidad']) ?></td>
                        <td><?= escapar($fila['nombre_empleado']) ?></td>
                        <td><?= escapar($fila['codigo_proveedor']) ?></td>
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
