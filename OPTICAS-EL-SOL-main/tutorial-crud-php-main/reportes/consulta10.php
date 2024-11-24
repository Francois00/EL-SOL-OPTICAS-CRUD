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

$query10 = "CALL obtenerInformacionDeCatalogos()";
$sentencia10 = $conexion->prepare($query10);
$sentencia10->execute();
$resultado10 = $sentencia10->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include '../templates/header.php'; ?>

<div class="container mt-3">
    <h2>Consulta 10: Información de Catálogos</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Código Catálogo</th>
                <th>Tipo de Productos</th>
                <th>Última Modificación</th>
                <th>Stock</th>
                <th>Empleado Responsable</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($resultado10 && count($resultado10) > 0) { ?>
                <?php foreach ($resultado10 as $fila) { ?>
                    <tr>
                        <td><?= escapar($fila['codigo_catalogo']) ?></td>
                        <td><?= escapar($fila['tipo_de_productos']) ?></td>
                        <td><?= escapar($fila['UltimaModificacion']) ?></td>
                        <td><?= escapar($fila['Stock']) ?></td>
                        <td><?= escapar($fila['nombre_empleado']) ?></td>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <tr>
                    <td colspan="5">No se encontraron resultados</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<?php include '../templates/footer.php'; ?>
