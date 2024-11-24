<?php
include '../funciones.php'; 
$config = include '../config.php'; 

try {
    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);
} catch (PDOException $e) {
    die('Error de conexión: ' . $e->getMessage());
}

$query1 = "CALL obtenerCantidadPedidosPorEmpleado()";
$sentencia1 = $conexion->prepare($query1);
$sentencia1->execute();
$resultado1 = $sentencia1->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include '../templates/header.php'; ?>

<!-- Mostrar los resultados de las consultas en la página -->
<div class="container mt-3">
    <h2>Resultados de las Consultas</h2>
    
    <!-- Consulta 1 -->
    <h3>Consulta 1: Cantidad de Pedidos por Empleado</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Nombre Empleado</th>
                <th>Estado</th>
                <th>Número de Pedido</th>
                <th>Teléfono</th>
                <th>Cantidad de Pedidos</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($resultado1 as $fila) { ?>
                <tr>
                    <td><?= escapar($fila['nombre_empleado']) ?></td>
                    <td><?= escapar($fila['estado']) ?></td>
                    <td><?= escapar($fila['numero_pedido']) ?></td>
                    <td><?= escapar($fila['telefono']) ?></td>
                    <td><?= escapar($fila['Cantidad_Pedidos']) ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<?php include '../templates/footer.php'; ?>
