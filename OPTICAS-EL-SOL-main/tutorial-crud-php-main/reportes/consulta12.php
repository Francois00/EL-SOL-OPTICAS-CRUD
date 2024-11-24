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

$query12 = "CALL obtenerProductosDistribuidosDespuesDe20170101()";
$sentencia12 = $conexion->prepare($query12);
$sentencia12->execute();
$resultado12 = $sentencia12->fetchAll(PDO::FETCH_ASSOC);

?>

<?php include '../templates/header.php'; ?>

<div class="container mt-3">
    <h2>Consulta 12: Productos Incluidos en Pedidos desde 2017</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Número de Pedido</th>
                <th>Código de Producto</th>
                <th>Nombre del Producto</th>
                <th>Fecha de Ingreso</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($resultado12 && count($resultado12) > 0) { ?>
                <?php foreach ($resultado12 as $fila) { ?>
                    <tr>
                        <td><?= escapar($fila['numero_pedido']) ?></td>
                        <td><?= escapar($fila['codigo_producto']) ?></td>
                        <td><?= escapar($fila['nombre']) ?></td>
                        <td><?= escapar($fila['fecha_de_ingreso']) ?></td>
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
