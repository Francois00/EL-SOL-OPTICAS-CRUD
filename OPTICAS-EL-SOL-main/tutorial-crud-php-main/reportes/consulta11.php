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

$query11 = "SELECT producto.nombre, 
                   TIMESTAMPDIFF(YEAR, distribuir_productos.fecha_de_ingreso, catalogo.fecha_ultima_modificacion) AS Meses_en_Catalogo,
                   producto.tipo_de_producto, 
                   distribuir_productos.codigo_producto
            FROM catalogo
            INNER JOIN producto
            ON catalogo.codigo_catalogo = producto.codigo_catalogo  -- Corregido de codigo_catalago a codigo_catalogo
            INNER JOIN distribuir_productos
            ON distribuir_productos.codigo_producto = producto.codigo_producto";

$sentencia11 = $conexion->prepare($query11);
$sentencia11->execute();
$resultado11 = $sentencia11->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include '../templates/header.php'; ?>

<div class="container mt-3">
    <h2>Consulta 11: Información de Productos en el Catálogo</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Meses en Catálogo</th>
                <th>Tipo de Producto</th>
                <th>Código Producto</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($resultado11 && count($resultado11) > 0) { ?>
                <?php foreach ($resultado11 as $fila) { ?>
                    <tr>
                        <td><?= escapar($fila['nombre']) ?></td>
                        <td><?= escapar($fila['Meses_en_Catalogo']) ?></td>
                        <td><?= escapar($fila['tipo_de_producto']) ?></td>
                        <td><?= escapar($fila['codigo_producto']) ?></td>
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