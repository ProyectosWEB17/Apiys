<?php
include "config/config.php";
?>


<?php
include 'header.php'; // Header con menú

// Verifica si se recibe un ID en la URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM productos WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $producto = $result->fetch_assoc();
    } else {
        echo "<p class='text-center text-gray-600 mt-10'>Producto no encontrado.</p>";
        exit();
    }
} else {
    echo "<p class='text-center text-gray-600 mt-10'>ID de producto no válido.</p>";
    exit();
}
?>

<div class="container mx-auto mt-10 px-4">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Imagen del producto -->
        <div>
            <img src="<?= !empty($producto['imagen']) ? $producto['imagen'] : 'img/default.jpg'; ?>" class="w-full h-80 object-cover rounded shadow-md" alt="<?= $producto['nombre']; ?>">
        </div>

        <!-- Información del producto -->
        <div>
            <h1 class="text-3xl font-bold text-gray-800"><?= $producto['nombre']; ?></h1>
            <p class="text-gray-600 mt-2"><?= $producto['descripcion']; ?></p>
            <p class="text-2xl font-semibold text-red-600 mt-4">$<?= number_format($producto['precio'], 0, ',', '.'); ?> CLP</p>
            <p class="text-sm text-gray-500">IVA incluido</p>

            <!-- Botón de Añadir al Carrito -->
            <button onclick="agregarAlCarrito(<?= $producto['id']; ?>, '<?= $producto['nombre']; ?>', <?= $producto['precio']; ?>)" class="bg-green-600 text-white px-6 py-2 mt-4 rounded hover:bg-green-700">
                🛒 Añadir al Carrito
            </button>

            <!-- Enlace para volver a la lista de productos -->
            <a href="productos.php" class="block mt-4 text-blue-600 hover:underline">← Volver a Productos</a>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?> <!-- Footer -->
