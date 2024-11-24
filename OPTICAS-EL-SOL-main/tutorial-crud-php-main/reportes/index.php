<?php include '../templates/header.php'; ?>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f9;
        margin: 0;
        padding: 0;
    }

    .container {
        margin-top: 50px;
        max-width: 800px;
    }

    h2 {
        color: #333;
        text-align: center;
        margin-bottom: 30px;
    }

    ul {
        list-style-type: none;
        padding: 0;
        margin: 0;
        font-size: 18px;
    }

    li {
        margin-bottom: 10px;
    }

    li a {
        text-decoration: none;
        color: #007BFF;
        transition: color 0.3s;
    }

    li a:hover {
        color: #0056b3;
    }

    .table {
        margin-top: 20px;
        width: 100%;
        border-collapse: collapse;
        background-color: #fff;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .table th,
    .table td {
        padding: 12px;
        text-align: left;
        border: 1px solid #ddd;
    }

    .table th {
        background-color: #007BFF;
        color: white;
    }

    .table tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .table tr:hover {
        background-color: #f1f1f1;
    }

    .container a {
        font-size: 16px;
        padding: 8px 15px;
        margin: 10px 0;
        text-decoration: none;
        color: #fff;
        background-color: #007BFF;;
        border-radius: 4px;
        display: inline-block;
    }

    .container a:hover {
        background-color: #218838;
    }
</style>
<div class="container mt-3">
    <h2>Índice de Consultas</h2>
    <ul>
        <li><a href="consulta1.php">Consulta 1: Cantidad de Pedidos por Empleado</a></li>
        <li><a href="consulta2.php">Consulta 2: Producto con Mayor Stock</a></li>
        <li><a href="consulta3.php">Consulta 3: Costo Promedio por Tipo de Producto</a></li>
        <li><a href="consulta4.php">Consulta 4: Proveedores con Correos en Yahoo</a></li>
        <li><a href="consulta5.php">Consulta 5: Catálogos Modificados entre Fechas</a></li>
        <li><a href="consulta6.php">Consulta 6: Proveedores con Teléfonos y Correos (por código)</a></li>
        <li><a href="consulta7.php">Consulta 7: Productos Involucrados en Pedidos por Empleado</a></li>
        <li><a href="consulta8.php">Consulta 8: Productos SOLAR para NIÑOS por Pedido</a></li>
        <li><a href="consulta9.php">Consulta 9: Número de Pedidos por Empleado</a></li>
        <li><a href="consulta10.php">Consulta 10: Información de Catálogos</a></li>
        <li><a href="consulta11.php">Consulta 11: Meses en Catálogo por Producto</a></li>
        <li><a href="consulta12.php">Consulta 12: Productos Distribuidos después de 2017-01-01</a></li>
        <li><a href="consulta13.php">Consulta 13: Productos para Niños con Precio Menor a 150</a></li>
    </ul>
</div>

<?php include '../templates/footer.php'; ?>
