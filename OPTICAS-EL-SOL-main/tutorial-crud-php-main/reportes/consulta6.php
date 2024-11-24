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

$codigo_proveedor_pattern = "11%"; // Ejemplo, puede ser cualquier patrón de código
$query6 = "CALL obtenerProveedoresConTelefonosYCorreos(:codigo_proveedor_pattern)";
$sentencia6 = $conexion->prepare($query6);
$sentencia6->bindParam(':codigo_proveedor_pattern', $codigo_proveedor_pattern, PDO::PARAM_STR);
$sentencia6->execute();
$resultado6 = $sentencia6->fetchAll(PDO::FETCH_ASSOC);

?>

<?php include '../templates/header.php'; ?>

<div class="container mt-3">
    <h2>Consulta 6: Proveedores con Teléfonos y Correos</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Proveedor</th>
                <th>Teléfono</th>
                <th>Correo</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($resultado6 && count($resultado6) > 0) { ?>
                <?php foreach ($resultado6 as $fila) { ?>
                    <tr>
                        <td><?= escapar($fila['Proveedor']) ?></td>
                        <td><?= escapar($fila['Telefono']) ?></td>
                        <td><?= escapar($fila['Correo']) ?></td>
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
