
document.addEventListener("DOMContentLoaded", function () {
    actualizarCarrito();
});

// Obtener carrito desde localStorage
function obtenerCarrito() {
    return JSON.parse(localStorage.getItem("carrito")) || [];
}

// Guardar carrito en localStorage
function guardarCarrito(carrito) {
    localStorage.setItem("carrito", JSON.stringify(carrito));
}

// Actualizar el carrito en el modal y en el contador
function actualizarCarrito() {
    let carrito = obtenerCarrito();
    let cartItems = document.getElementById("cartItems");
    let cartTotal = document.getElementById("cartTotal");
    let cartCount = document.getElementById("cartCount");

    if (!cartItems || !cartTotal || !cartCount) {
        console.warn("Elementos del carrito no encontrados en esta página.");
        return;
    }

    cartItems.innerHTML = "";
    let total = 0;
    let cantidadTotal = 0;

    carrito.forEach((producto, index) => {
        let subtotal = producto.precio * producto.cantidad;
        total += subtotal;
        cantidadTotal += producto.cantidad;

        cartItems.innerHTML += `
            <li class="flex items-center justify-between border-b py-3">
                <div class="flex items-center">
                    <img src="${producto.imagen}" class="h-14 w-14 object-cover rounded-md mr-3">
                    <div>
                        <p class="text-sm font-semibold">${producto.nombre}</p>
                        <p class="text-xs text-gray-500">$${producto.precio.toLocaleString("es-CL")} CLP</p>
                    </div>
                </div>
                <div class="flex items-center">
                    <button onclick="modificarCantidad(${index}, -1)" class="px-2 py-1 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">➖</button>
                    <span class="mx-2">${producto.cantidad}</span>
                    <button onclick="modificarCantidad(${index}, 1)" class="px-2 py-1 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">➕</button>
                    <button onclick="eliminarDelCarrito(${index})" class="ml-2 text-red-500">❌</button>
                </div>
            </li>
        `;
    });

    cartTotal.innerText = `$${total.toLocaleString("es-CL")} CLP`;
    cartCount.innerText = cantidadTotal;
}

// Agregar producto al carrito
function agregarAlCarrito(id, nombre, precio, imagen) {
    let carrito = obtenerCarrito();
    let productoExistente = carrito.find(producto => producto.id === id);

    if (productoExistente) {
        productoExistente.cantidad++;
    } else {
        carrito.push({ id, nombre, precio, imagen, cantidad: 1 });
    }

    guardarCarrito(carrito);
    actualizarCarrito();
}

// Modificar cantidad del producto en el carrito
function modificarCantidad(index, cambio) {
    let carrito = obtenerCarrito();
    if (carrito[index]) {
        carrito[index].cantidad += cambio;
        if (carrito[index].cantidad <= 0) {
            carrito.splice(index, 1);
        }
        guardarCarrito(carrito);
        actualizarCarrito();
    }
}

// Eliminar producto del carrito
function eliminarDelCarrito(index) {
    let carrito = obtenerCarrito();
    carrito.splice(index, 1);
    guardarCarrito(carrito);
    actualizarCarrito();
}

// Vaciar el carrito
function vaciarCarrito() {
    localStorage.removeItem("carrito");
    actualizarCarrito();
}

// Mostrar/Ocultar carrito
function toggleCart() {
    let modal = document.getElementById("cartModal");
    modal.style.display = (modal.style.display === "none" || modal.style.display === "") ? "flex" : "none";
}
