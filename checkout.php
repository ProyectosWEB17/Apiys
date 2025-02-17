<?php
include "config/config.php";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Checkout - APIYS</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<!-- Navbar -->
<?php include "header.php"; ?>

<!-- Checkout -->
<div class="container mx-auto mt-10 bg-white p-6 rounded shadow-md">
    <h2 class="text-2xl font-bold mb-4">Resumen de Compra</h2>

    <table class="w-full text-left border-collapse">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Imagen</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody id="contenido-carrito"></tbody>
    </table>

    <div class="text-right mt-4">
        <h3 class="text-xl font-bold">Total: <span id="total-compra">$0 CLP</span></h3>
    </div>

    <!-- Formulario para procesar pago -->
    <form id="form-pago" action="procesar_pago.php" method="POST">
        <input type="hidden" name="productos" id="productos-input">
        <input type="hidden" name="total" id="total-input">

        <label class="block text-lg font-semibold">Método de Pago:</label>
        <select name="metodo_pago" class="border rounded p-2 w-full mt-2" required>
            <option value="">Selecciona una opción</option>
            <option value="webpay">💳 WebPay (Transbank)</option>
            <option value="mercadopago">🛍️ Mercado Pago</option>
        </select>

        <button type="submit" class="bg-blue-600 text-white px-6 py-3 mt-4 w-full rounded hover:bg-blue-700">
            Proceder al Pago
        </button>
    </form>
</div>

<!-- Footer -->
<?php include "footer.php"; ?>

<script src="js/carrito.js"></script>
<script>
    // Cargar carrito desde localStorage al checkout
    function cargarCarritoCheckout() {
        let carrito = JSON.parse(localStorage.getItem("carrito")) || [];
        let contenidoCarrito = document.getElementById("contenido-carrito");
        let totalCompra = document.getElementById("total-compra");
        let total = 0;

        contenidoCarrito.innerHTML = "";
        
        carrito.forEach((producto, index) => {
            let subtotal = producto.precio * producto.cantidad;
            total += subtotal;

            contenidoCarrito.innerHTML += `
                <tr class="border-b">
                    <td class="py-2">${producto.nombre}</td>
                    <td class="py-2"><img src="${producto.imagen}" class="h-14 w-14 object-cover rounded-md"></td>
                    <td class="py-2 text-center">${producto.cantidad}</td>
                    <td class="py-2">$${producto.precio.toLocaleString("es-CL")} CLP</td>
                    <td class="py-2">$${subtotal.toLocaleString("es-CL")} CLP</td>
                </tr>
            `;
        });

        totalCompra.innerText = `$${total.toLocaleString("es-CL")} CLP`;
    }

    // Llenar los datos en el formulario antes de enviarlo
    document.getElementById("form-pago").addEventListener("submit", function () {
        document.getElementById("productos-input").value = localStorage.getItem("carrito");
        document.getElementById("total-input").value = document.getElementById("total-compra").textContent.replace("$", "").replace(" CLP", "").replace(/\./g, "");
    });

    document.addEventListener("DOMContentLoaded", cargarCarritoCheckout);
</script>

</body>
</html>
