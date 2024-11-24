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

$query9 = "SELECT empleado.codigo_empleado, empleado.nombre_empleado, empleado.turno, 
                  COUNT(pedido.numero_pedido) as numero_pedidos
           FROM Empleado
           INNER JOIN pedido
           ON empleado.codigo_empleado = pedido.codigo_empleado
           GROUP BY empleado.codigo_empleado
           ORDER BY numero_pedidos DESC
           LIMIT 2";

$sentencia9 = $conexion->prepare($query9);
$sentencia9->execute();
$resultado9 = $sentencia9->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include '../templates/header.php'; ?>

<div class="container mt-3">
    <h2>Consulta 9: Empleados con Más Pedidos</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Código Empleado</th>
                <th>Nombre Empleado</th>
                <th>Turno</th>
                <th>Número de Pedidos</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($resultado9 && count($resultado9) > 0) { ?>
                <?php foreach ($resultado9 as $fila) { ?>
                    <tr>
                        <td><?= escapar($fila['codigo_empleado']) ?></td>
                        <td><?= escapar($fila['nombre_empleado']) ?></td>
                        <td><?= escapar($fila['turno']) ?></td>
                        <td><?= escapar($fila['numero_pedidos']) ?></td>
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
