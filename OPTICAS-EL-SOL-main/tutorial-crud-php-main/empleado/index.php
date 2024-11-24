<?php

include '../funciones.php';

csrf();
if (isset($_POST['submit']) && !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
    die();
}

$error = false;
$config = include '../config.php';

try {
    // Configuración de la conexión
    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

    // Buscar empleados por código si se proporciona
    if (isset($_POST['codigo_empleado'])) {
        $codigo_empleado = "%" . $_POST['codigo_empleado'] . "%";
        // Usar el procedimiento almacenado para buscar empleados
        $consultaSQL = "CALL leerEmpleado()";
        $sentencia = $conexion->prepare($consultaSQL);
        $sentencia->bindParam(':codigo_empleado', $codigo_empleado, PDO::PARAM_STR);
    } else {
        // Usar el procedimiento almacenado para obtener todos los empleados
        $consultaSQL = "CALL leerEmpleado()";
        $sentencia = $conexion->prepare($consultaSQL);
    }

    $sentencia->execute();
    $empleados = $sentencia->fetchAll();

} catch (PDOException $error) {
    $error = $error->getMessage();
}

$titulo = isset($_POST['codigo_empleado']) ? 'Lista de empleados (' . $_POST['codigo_empleado'] . ')' : 'Lista de empleados';

?>

<?php include '../templates/header.php'; ?>

<?php if ($error) { ?>
<div class="container mt-2">
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-danger" role="alert">
                <?= $error ?>
            </div>
        </div>
    </div>
</div>
<?php } ?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <a href="crear.php" class="btn btn-primary mt-4">Crear Empleado</a>
            <hr>
            <form method="post" class="form-inline">
                <div class="form-group mr-3">
                    <input type="text" id="codigo_empleado" name="codigo_empleado" placeholder="Buscar por Código" class="form-control">
                </div>
                <input name="csrf" type="hidden" value="<?php echo escapar($_SESSION['csrf']); ?>">
                <button type="submit" name="submit" class="btn btn-primary">Ver resultados</button>
            </form>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2 class="mt-3"><?= $titulo ?></h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Turno</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($empleados && $sentencia->rowCount() > 0) {
                        foreach ($empleados as $fila) { ?>
                            <tr>
                                <td><?php echo escapar($fila["codigo_empleado"]); ?></td>
                                <td><?php echo escapar($fila["nombre_empleado"]); ?></td>
                                <td><?php echo escapar($fila["turno"]); ?></td>
                                <td><?php echo escapar($fila["estado"]); ?></td>
                                <td>
                                    <a href="<?= 'borrar.php?codigo_empleado=' . escapar($fila["codigo_empleado"]) ?>">🗑️Borrar</a>
                                    <a href="<?= 'editar.php?codigo_empleado=' . escapar($fila["codigo_empleado"]) ?>">✏️Editar</a>
                                </td>
                            </tr>
                        <?php }
                    } else { ?>
                        <tr>
                            <td colspan="5">No se encontraron resultados</td>
                        </tr>
                    <?php } ?>
                <tbody>
            </table>
        </div>
    </div>
</div>

<?php include '../templates/footer.php'; ?>
