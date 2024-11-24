<?php
include '../funciones.php'; 
$config = include '../config.php'; 

try {
    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);
} catch (PDOException $e) {
    die('Error de conexión: ' . $e->getMessage());
}

$tipo_de_producto = 'MONTURA OFTALMOLOGICA'; // Ejemplo, puedes cambiarlo dinámicamente
$query3 = "CALL obtenerCostoPromedioPorTipoDeProducto(:tipo_de_producto)";
$sentencia3 = $conexion->prepare($query3);
$sentencia3->bindParam(':tipo_de_producto', $tipo_de_producto, PDO::PARAM_STR);
$sentencia3->execute();
$resultado3 = $sentencia3->fetchAll(PDO::FETCH_ASSOC);


$sentencia1 = $conexion->prepare($query1);
$sentencia1->execute();
$resultado1 = $sentencia1->fetch(PDO::FETCH_ASSOC);

$sentencia2 = $conexion->prepare($query2);
$sentencia2->execute();
$resultado2 = $sentencia2->fetch(PDO::FETCH_ASSOC);

$sentencia3 = $conexion->prepare($query3);
$sentencia3->execute();
$resultado3 = $sentencia3->fetch(PDO::FETCH_ASSOC);
?>

<?php include '../templates/header.php'; ?>

<div class="container mt-3">
    <h2>Consulta 3: Costo Promedio de Monturas</h2>

    <h3>MONTURA OFTALMOLOGICA</h3>
    <p>Costo Promedio: <?= escapar($resultado1['Costo_Promedio']) ?></p>

    <h3>MONTURA SOLAR</h3>
    <p>Costo Promedio: <?= escapar($resultado2['Costo_Promedio']) ?></p>

    <h3>MONTURA PARA NIÑOS</h3>
    <p>Costo Promedio: <?= escapar($resultado3['Costo_Promedio']) ?></p>

</div>

<?php include '../templates/footer.php'; ?>
