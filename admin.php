<?php
session_start();
include "config/config.php"; // Conexión a la base de datos

// Verificar sesión de administrador
if (!isset($_SESSION["usuario"]) || $_SESSION["rol"] !== "admin") {
    header("Location: login.php");
    exit();
}

// Expiración de sesión (15 minutos de inactividad)
if (isset($_SESSION["ultimo_acceso"]) && (time() - $_SESSION["ultimo_acceso"] > 900)) {
    session_unset();
    session_destroy();
    header("Location: login.php?mensaje=Sesión expirada, inicia sesión nuevamente");
    exit();
}
$_SESSION["ultimo_acceso"] = time(); // Resetear tiempo de sesión

// Mensaje de confirmación
$mensaje = "";
if (isset($_SESSION["mensaje"])) {
    $mensaje = $_SESSION["mensaje"];
    unset($_SESSION["mensaje"]);
}

// 🔹 **Actualizar producto**
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_product"])) {
    $id = intval($_POST["id"]);
    $nuevo_stock = intval($_POST["stock"]);
    $nuevo_precio = floatval($_POST["precio"]);
    $nueva_categoria = $conn->real_escape_string($_POST["categoria"]);

    $sql = "UPDATE productos SET stock = ?, precio = ?, categoria = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("diss", $nuevo_precio, $nuevo_stock, $nueva_categoria, $id);

    if ($stmt->execute()) {
        $_SESSION["mensaje"] = "<div class='bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mt-4'>✅ Producto actualizado correctamente.</div>";
    } else {
        $_SESSION["mensaje"] = "<div class='bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mt-4'>❌ Error: " . $conn->error . "</div>";
    }
    $stmt->close();
    header("Location: admin.php");
    exit();
}

// 🔹 **Eliminar producto**
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_product"])) {
    $id = intval($_POST["id"]);
    $sql = "DELETE FROM productos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $_SESSION["mensaje"] = "<div class='bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mt-4'>🗑️ Producto eliminado correctamente.</div>";
    } else {
        $_SESSION["mensaje"] = "<div class='bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mt-4'>❌ Error: " . $conn->error . "</div>";
    }
    $stmt->close();
    header("Location: admin.php");
    exit();
}

// 🔹 **Obtener productos**
$sql_productos = "SELECT * FROM productos";
$result_productos = $conn->query($sql_productos);

// 🔹 **Obtener ventas**
$sql_ventas = "SELECT c.id, c.fecha_compra, c.total, u.usuario 
               FROM compras c 
               JOIN usuarios u ON c.usuario_id = u.id 
               ORDER BY c.fecha_compra DESC";
$result_ventas = $conn->query($sql_ventas);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administración</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-900">
    <div class="container mx-auto px-6 py-8">
        <h2 class="text-3xl font-bold text-center mb-6">Panel de Administración</h2>

        <div class="flex justify-between mb-4">
            <a href="importar_csv.php" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">📂 Importar CSV</a>
            <a href="agregar_producto.php" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">➕ Agregar Producto</a>
            <a href="logout.php" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">🚪 Cerrar Sesión</a>
        </div>

        <?= $mensaje ?>

        <h3 class="text-xl font-semibold mt-6 mb-4">Lista de Productos</h3>
        <div class="overflow-x-auto">
            <table class="w-full border-collapse border border-gray-300 bg-white shadow-md rounded-lg">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="border px-4 py-2">ID</th>
                        <th class="border px-4 py-2">Nombre</th>
                        <th class="border px-4 py-2">Precio</th>
                        <th class="border px-4 py-2">Stock</th>
                        <th class="border px-4 py-2">Categoría</th>
                        <th class="border px-4 py-2">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($producto = $result_productos->fetch_assoc()) : ?>
                        <tr class="text-center">
                            <td class="border px-4 py-2"><?= $producto['id'] ?></td>
                            <td class="border px-4 py-2"><?= $producto['nombre'] ?></td>
                            <form action="admin.php" method="post">
                                <td class="border px-4 py-2">
                                    <input type="hidden" name="id" value="<?= $producto['id'] ?>">
                                    <input type="number" step="0.01" name="precio" value="<?= $producto['precio'] ?>" class="w-20 p-1 border rounded text-center" required>
                                </td>
                                <td class="border px-4 py-2">
                                    <input type="number" name="stock" value="<?= $producto['stock'] ?>" class="w-16 p-1 border rounded text-center" required>
                                </td>
                                <td class="border px-4 py-2">
                                    <input type="text" name="categoria" value="<?= $producto['categoria'] ?>" class="p-1 border rounded text-center">
                                </td>
                                <td class="border px-4 py-2">
                                    <button type="submit" name="update_product" class="bg-yellow-500 text-white px-2 py-1 rounded hover:bg-yellow-600">Actualizar</button>
                                </td>
                            </form>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <h3 class="text-xl font-semibold mt-10 mb-4">Historial de Ventas</h3>
        <div class="overflow-x-auto">
            <table class="w-full border-collapse border border-gray-300 bg-white shadow-md rounded-lg">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="border px-4 py-2">ID Venta</th>
                        <th class="border px-4 py-2">Fecha</th>
                        <th class="border px-4 py-2">Total</th>
                        <th class="border px-4 py-2">Usuario</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($venta = $result_ventas->fetch_assoc()) : ?>
                        <tr class="text-center">
                            <td class="border px-4 py-2"><?= $venta['id'] ?></td>
                            <td class="border px-4 py-2"><?= $venta['fecha_compra'] ?></td>
                            <td class="border px-4 py-2">$<?= number_format($venta['total'], 0, ',', '.') ?> CLP</td>
                            <td class="border px-4 py-2"><?= $venta['usuario'] ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
