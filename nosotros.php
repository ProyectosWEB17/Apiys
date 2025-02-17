<?php include "header-static.php"; ?>

<!-- 🔹 SECCIÓN HERO CON IMAGEN DE FONDO -->
<div class="relative h-[50vh] flex items-center justify-center bg-cover bg-center" 
     style="background-image: url('img/nosotros-bg.jpg');">
    <div class="absolute inset-0 bg-black bg-opacity-50"></div> <!-- Capa oscura -->

    <div class="relative text-center text-white z-10 animate-fadeIn">
        <h1 class="text-4xl font-bold uppercase">Sobre Nosotros</h1>
        <p class="text-lg mt-3 max-w-3xl mx-auto">
            En APIYS, nos especializamos en ofrecer soluciones industriales de alta calidad, 
            brindando productos confiables para múltiples sectores.
        </p>
    </div>
</div>

<!-- 🔹 SECCIÓN INFORMACIÓN CON TARJETAS -->
<div class="container mx-auto px-6 py-12">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        <!-- Tarjeta 1: Misión -->
        <div class="bg-white shadow-lg rounded-lg p-6 border-t-4 border-blue-500 hover:shadow-xl transition">
            <h2 class="text-lg font-bold mb-2 text-gray-800">Nuestra Misión</h2>
            <p class="text-gray-600 text-sm">
                Entendemos las necesidades cambiantes de nuestros clientes, ofreciendo soluciones 
                integrales respaldadas por marcas líderes del mercado internacional. Nuestra visión es 
                ser reconocidos como el mejor proveedor de soluciones hidráulicas, destacando siempre 
                por nuestra excelencia y compromiso con la innovación y el desarrollo sostenible.
            </p>
        </div>

        <!-- Tarjeta 2: Sello -->
        <div class="bg-white shadow-lg rounded-lg p-6 border-t-4 border-blue-500 hover:shadow-xl transition">
            <h2 class="text-lg font-bold mb-2 text-gray-800">Nuestro Sello</h2>
            <p class="text-gray-600 text-sm">
                Nos destacamos por nuestro enfoque integral, donde cada solución está diseñada para 
                maximizar el rendimiento y minimizar los costos operativos. Contamos con un equipo 
                altamente calificado, capaz de responder de manera eficaz y oportuna a las necesidades 
                específicas de nuestros clientes. Nuestro expertise abarca no solo el campo de las 
                bombas, sino también todos los equipos y soluciones que ofrecemos al mercado.
            </p>
        </div>

        <!-- Tarjeta 3: Horarios -->
        <div class="bg-white shadow-lg rounded-lg p-6 border-t-4 border-blue-500 hover:shadow-xl transition">
            <h2 class="text-lg font-bold mb-2 text-gray-800">Horarios de Atención</h2>
            <p class="text-gray-600 text-sm">
                <strong>Lunes a Viernes:</strong> 8:30hrs - 17:45hrs.<br>
                Contamos con envío a todo el país a través de diferentes despachadores logísticos. 
                Nuestros despachos en región metropolitana los realizamos de manera gratuita y dentro 
                de <strong>XX horas hábiles</strong> una vez efectuada la compra.
                <br><br>
                Envío a regiones con un tiempo entre <strong>2 a 5 días hábiles</strong>. También ofrecemos 
                retiro en nuestras bodegas ubicadas en <strong>XXXXX</strong>, demorándonos <strong>90 minutos</strong> en 
                armar el pedido una vez efectuada la compra entre las <strong>10hrs y 15hrs</strong>.
            </p>
        </div>

    </div>
</div>
</section>

<?php include 'footer.php'; ?>
