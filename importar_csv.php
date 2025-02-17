<?php
include "config/config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["archivo_csv"])) {
    $archivo = $_FILES["archivo_csv"]["tmp_name"];
    
    if (($gestor = fopen($archivo, "r")) !== FALSE) {
        fgetcsv($gestor); // Saltar la primera fila (encabezados)

        while (($datos = fgetcsv($gestor, 1000, ",")) !== FALSE) {
            $nombre = mysqli_real_escape_string($conn, $datos[1]);
            $descripcion = mysqli_real_escape_string($conn, $datos[2]);
            $precio = floatval($datos[3]); // Convertir a número
            $stock = intval($datos[4]);
            $imagen = mysqli_real_escape_string($conn, $datos[5]);
            $categoria = mysqli_real_escape_string($conn, $datos[6]);

            $sql = "INSERT INTO productos (nombre, descripcion, precio, stock, imagen, categoria) 
                    VALUES ('$nombre', '$descripcion', $precio, $stock, '$imagen', '$categoria')";

            $conn->query($sql);
        }
        fclose($gestor);
        echo "✅ Productos importados correctamente.";
    } else {
        echo "❌ Error al abrir el archivo.";
    }
}
?>

<form action="importar_csv.php" method="post" enctype="multipart/form-data">
    <input type="file" name="archivo_csv" accept=".csv" required>
    <button type="submit">Subir CSV</button>
</form>
