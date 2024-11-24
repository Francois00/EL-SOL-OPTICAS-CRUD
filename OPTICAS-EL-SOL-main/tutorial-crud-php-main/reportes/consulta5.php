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

$inicio = '2022-09-22';
$fin = '2022-10-29';
$query5 = "CALL obtenerCatalogosModificadosEntreFechas(:inicio, :fin)";
$sentencia5 = $conexion->prepare($query5);
$sentencia5->bindParam(':inicio', $inicio, PDO::PARAM_STR);
$sentencia5->bindParam(':fin', $fin, PDO::PARAM_STR);
$sentencia5->execute();
$resultado5 = $sentencia5->fetchAll(PDO::FETCH_ASSOC);

?>

<?php include '../templates/header.php'; ?>

<div class="container mt-3">
    <h2>Consulta 5: Catálogos Modificados entre Fechas</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Versión</th>
                <th>Fecha Última Modificación</th>
                <th>Nombre del Empleado</th>
                <th>Turno</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($resultado5 && count($resultado5) > 0) { ?>
                <?php foreach ($resultado5 as $fila) { ?>
                    <tr>
                        <td><?= escapar($fila['version']) ?></td>
                        <td><?= escapar($fila['fecha_ultima_modificacion']) ?></td> <!-- Aquí usamos el nombre correcto -->
                        <td><?= escapar($fila['nombre_empleado']) ?></td>
                        <td><?= escapar($fila['turno']) ?></td>
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
