<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>APIYS - Soluciones Industriales</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        function toggleMenu() {
            document.getElementById("mobile-menu").classList.toggle("hidden");
        }

        function toggleDropdown() {
            document.getElementById("dropdown-menu").classList.toggle("hidden");
        }
    </script>
</head>
<body class="bg-gray-100">

<!-- 🔹 NAVBAR FIJA -->
<nav class="fixed top-0 left-0 w-full bg-white shadow-md z-50">
    <div class="container mx-auto flex justify-between items-center px-6 py-4">
        <!-- Botón de menú hamburguesa -->
        <button onclick="toggleMenu()" class="text-2xl focus:outline-none">☰</button>

        <!-- 🔹 Logo con enlace a index.php -->
        <a href="index.php">
            <img src="img/logo.png" alt="Apiys Logo" class="h-12">
        </a>

        <!-- Barra de búsqueda -->
        <input type="text" id="searchInput" onkeyup="searchProducts()" placeholder="🔍 Buscar producto..." class="border px-4 py-2 rounded w-1/3 hidden sm:block">

        <!-- Información de contacto y Carrito -->
        <div class="flex items-center space-x-6">
            <div class="hidden lg:block text-right">
                <p class="text-sm font-semibold">Cotiza tu proyecto</p>
                <a href="mailto:contacto@apiys.cl" class="text-sm font-bold text-black hover:text-blue-600">contacto@apiys.cl</a> | 
                <span class="text-sm font-bold">+56 9 7483 6386</span>
            </div>

    <!-- 🔹 MENÚ DESPLEGABLE FIJO -->
    <div id="menu" class="fixed top-16 left-4 bg-white shadow-md hidden w-64 rounded-md">
        <ul class="py-2 text-left">
            <li><a href="index.php" class="block py-2 px-4 hover:bg-gray-200">🏠 Inicio</a></li>
            <li><a href="productos.php" class="block py-2 px-4 hover:bg-gray-200">🛍️ Productos</a></li>
            <li class="relative group">
                <a href="#" class="block py-2 px-4 hover:bg-gray-200">🏢 Empresa ▼</a>
                <ul class="absolute left-0 top-full hidden bg-white shadow-md w-56 rounded-md group-hover:block">
                    <li><a href="nosotros.php" class="block py-2 px-4 hover:bg-gray-200">Nosotros</a></li>
                    <li><a href="politicas-garantia.php" class="block py-2 px-4 hover:bg-gray-200">Política de Garantía</a></li>
                    <li><a href="politicas-cookies.php" class="block py-2 px-4 hover:bg-gray-200">Política de Cookies</a></li>
                    <li><a href="politicas-privacidad.php" class="block py-2 px-4 hover:bg-gray-200">Política de Privacidad</a></li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
</header>

<!-- 🔹 JAVASCRIPT -->
<script>
        function toggleMenu() {
            document.getElementById('menu').classList.toggle('hidden');
        }

        let cart = [];
        function addToCart(name, price) {
            cart.push({ name, price });
            document.getElementById('cartCount').innerText = cart.length;
            updateCart();
            toggleCart();
        }

        function updateCart() {
            let cartItems = document.getElementById('cartItems');
            cartItems.innerHTML = '';
            cart.forEach(item => {
                cartItems.innerHTML += `<li>${item.name} - $${item.price}</li>`;
            });
        }

        function toggleCart() {
            let modal = document.getElementById('cartModal');
            modal.style.display = (modal.style.display === "none" || modal.style.display === "") ? "flex" : "none";
        }
    </script>

<!-- 🔹 Espaciador para el header fijo -->
<div class="h-16"></div>
