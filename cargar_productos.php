<?php
include("db/conectar.php");
$conn = conectar_DB();

if (!$conn) {
    die("Error en la conexión a la base de datos");
}
$inicio = isset($_GET["inicio"]) ? $_GET["inicio"] : 0;
$productosPorPagina = isset($_GET["productosPorPagina"]) ? $_GET["productosPorPagina"] : 10;

$categoria = $_GET['categoria'];

$query = "SELECT * FROM articulos WHERE categoria = :categoria LIMIT :inicio, :productosPorPagina";
$stmt = $conn->prepare($query);
$stmt->bindParam(':categoria', $categoria, PDO::PARAM_STR);
$stmt->bindParam(':inicio', $inicio, PDO::PARAM_INT);
$stmt->bindParam(':productosPorPagina', $productosPorPagina, PDO::PARAM_INT);
$stmt->execute();

// Mostrar resultados
if ($stmt->rowCount() > 0) {
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // Imprime los resultados aquí como lo hacías antes
    }
} else {
    echo "No hay productos disponibles para esta categoría.";
}

// Cerrar la conexión a la base de datos
$conn = null;
?>
