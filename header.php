<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>APIYS - Soluciones Industriales</title>
    <script src="https://cdn.tailwindcss.com">actualizarCarrito();
</script>
</head>
<body class="bg-gray-100">

<!-- 🔹 NAVBAR FIJA -->
<nav class="fixed top-0 left-0 w-full bg-white shadow-md z-50">
    <div class="container mx-auto flex justify-between items-center px-6 py-4">
        <button onclick="toggleMenu()" class="text-2xl focus:outline-none">☰</button>

        <!-- 🔹 Logo -->
        <a href="index.php">
            <img src="img/logo.png" alt="Apiys Logo" class="h-12">
        </a>

        <!-- Barra de búsqueda -->
        <div class="relative">
            <input type="text" id="searchInput" placeholder="🔍 Buscar producto..." 
                class="border px-4 py-2 rounded w-64 sm:w-80 focus:ring-2 focus:ring-blue-400" 
                onkeyup="buscarProductos()">

            <!-- Resultados de búsqueda (Dropdown) -->
            <div id="searchResults" class="absolute bg-white shadow-lg rounded-md mt-2 w-80 hidden">
                <ul id="resultList" class="divide-y divide-gray-200"></ul>
            </div>
        </div>

        <!-- 🔹 Contacto y Carrito -->
        <div class="flex items-center space-x-6">
            <div class="hidden lg:block text-right">
                <p class="text-sm font-semibold">Cotiza tu proyecto</p>
                <a href="mailto:contacto@apiys.cl" class="text-sm font-bold text-black hover:text-blue-600">contacto@apiys.cl</a> | 
                <span class="text-sm font-bold">+56 9 7483 6386</span>
            </div>

            <!-- Botón para abrir el carrito -->
<button onclick="toggleCart()" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 relative">
    🛒 Carrito (<span id="cartCount">0</span>)
</button>

        </div>
    </div>

    <!-- 🔹 MENÚ DESPLEGABLE -->
    <div id="menu" class="fixed top-16 left-4 bg-white shadow-md hidden w-64 rounded-md">
        <ul class="py-2 text-left">
            <li><a href="index.php" class="block py-2 px-4 hover:bg-gray-200">🏠 Inicio</a></li>
            <li><a href="productos.php" class="block py-2 px-4 hover:bg-gray-200">🛍️ Productos</a></li>
            <li class="relative group">
                <a href="#" class="block py-2 px-4 hover:bg-gray-200">🏢 Empresa ▼</a>
                <ul class="absolute left-0 top-full hidden bg-white shadow-md w-56 rounded-md group-hover:block">
                    <li><a href="nosotros.php" class="block py-2 px-4 hover:bg-gray-200">Nosotros</a></li>
                    <li><a href="politica-garantia.php" class="block py-2 px-4 hover:bg-gray-200">Política de Garantía</a></li>
                    <li><a href="politica-cookies.php" class="block py-2 px-4 hover:bg-gray-200">Política de Cookies</a></li>
                    <li><a href="politica-privacidad.php" class="block py-2 px-4 hover:bg-gray-200">Política de Privacidad</a></li>
                </ul>
            </li>
        </ul>
    </div>
</nav>

<!-- 🔹 Espaciador para navbar fija -->
<div class="h-16"></div>

<!-- 🔹 CARRITO EMERGENTE MEJORADO -->
<div id="cartModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
    <div class="bg-white w-96 p-6 rounded-lg shadow-lg relative">
        <h2 class="text-xl font-bold mb-4 text-center">🛒 Carrito de Compras</h2>

        <!-- 🔹 LISTA DE PRODUCTOS EN EL CARRITO -->
        <ul id="cartItems" class="divide-y divide-gray-300 max-h-60 overflow-y-auto"></ul>

        <!-- 🔹 TOTAL Y BOTONES -->
        <div class="mt-4">
            <p class="text-lg font-bold text-right">Total: <span id="cartTotal">$0 CLP</span></p>
            <a href="checkout.php" class="bg-green-500 text-white px-4 py-2 mt-3 rounded hover:bg-green-600 w-full block text-center">Finalizar Compra</a>
            <button onclick="toggleCart()" class="absolute top-2 right-2 text-xl text-gray-600 hover:text-red-500">✖</button>
        </div>
    </div>
</div>

<!-- 🔹 INTEGRACIÓN DE SCRIPTS -->
<script src="js/carrito.js">actualizarCarrito();
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        actualizarContadorCarrito();
    });

    function toggleMenu() {
        document.getElementById("menu").classList.toggle("hidden");
    }

    function toggleCart() {
        document.getElementById("cartModal").classList.toggle("hidden");
        cargarCarrito();
    }

    function buscarProductos() {
        let input = document.getElementById("searchInput").value.trim();
        let resultsDiv = document.getElementById("searchResults");
        let resultList = document.getElementById("resultList");

        if (input.length < 2) {
            resultsDiv.classList.add("hidden");
            return;
        }

        fetch(`buscar.php?q=${input}`)
            .then(response => response.json())
            .then(data => {
                resultList.innerHTML = "";
                if (data.length === 0) {
                    resultList.innerHTML = "<li class='p-3 text-gray-600'>No hay resultados</li>";
                } else {
                    data.forEach(producto => {
                        let li = document.createElement("li");
                        li.className = "p-3 hover:bg-gray-100 flex items-center cursor-pointer";
                        li.innerHTML = `
                            <img src="${producto.imagen}" class="h-12 w-12 object-cover rounded mr-3">
                            <div>
                                <p class="font-medium">${producto.nombre}</p>
                                <p class="text-red-600 font-bold">$${new Intl.NumberFormat("es-CL").format(producto.precio)} CLP</p>
                            </div>
                        `;
                        li.onclick = () => window.location.href = `producto.php?id=${producto.id}`;
                        resultList.appendChild(li);
                    });
                }
                resultsDiv.classList.remove("hidden");
            })
            .catch(error => console.error("Error en la búsqueda:", error));
    }
actualizarCarrito();
</script>

</body>
</html>
