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

$query5 = "SELECT catalogo.version, catalogo.fecha_ultima_modificacion, empleado.nombre_empleado,
                  empleado.turno
           FROM catalogo
           INNER JOIN empleado
           ON empleado.codigo_empleado = catalogo.codigo_empleado
           WHERE catalogo.fecha_ultima_modificacion BETWEEN '2022-09-22' AND '2022-10-29'";

$sentencia5 = $conexion->prepare($query5);
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
                        <td><?= escapar($fila['fecha_ultima_modificacion']) ?></td> <!-- Asegúrate de que el nombre de la columna sea correcto -->
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
