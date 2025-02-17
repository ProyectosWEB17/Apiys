<?php
include "config/config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos enviados desde checkout.php
    $productos = json_decode($_POST["productos"], true);
    $total = intval($_POST["total"]);
    $metodo_pago = $_POST["metodo_pago"];

    if (!$productos || $total <= 0 || !$metodo_pago) {
        die(json_encode(["success" => false, "message" => "Datos de compra inválidos."]));
    }

    // Insertar la compra en la base de datos
    $sql_insert = "INSERT INTO compras (total, metodo_pago, fecha) VALUES (?, ?, NOW())";
    $stmt = $conn->prepare($sql_insert);

    if (!$stmt) {
        die(json_encode(["success" => false, "message" => "Error en la consulta de compra: " . $conn->error]));
    }

    $stmt->bind_param("is", $total, $metodo_pago);
    if ($stmt->execute()) {
        $compra_id = $stmt->insert_id;
    } else {
        die(json_encode(["success" => false, "message" => "Error al registrar la compra: " . $stmt->error]));
    }
    $stmt->close();

    // Insertar productos comprados y actualizar stock
    foreach ($productos as $producto) {
        $id = intval($producto["id"]);
        $cantidad = intval($producto["cantidad"]);

        // Insertar en la tabla de productos comprados
        $sql_producto = "INSERT INTO productos_comprados (compra_id, producto_id, cantidad) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql_producto);

        if (!$stmt) {
            die(json_encode(["success" => false, "message" => "Error en la consulta de productos_comprados: " . $conn->error]));
        }

        $stmt->bind_param("iii", $compra_id, $id, $cantidad);
        $stmt->execute();
        $stmt->close();

        // Actualizar el stock en la base de datos
        $sql_update_stock = "UPDATE productos SET stock = stock - ? WHERE id = ? AND stock >= ?";
        $stmt = $conn->prepare($sql_update_stock);

        if (!$stmt) {
            die(json_encode(["success" => false, "message" => "Error en la consulta de actualización de stock: " . $conn->error]));
        }

        $stmt->bind_param("iii", $cantidad, $id, $cantidad);
        $stmt->execute();
        $stmt->close();
    }

    // Devolver respuesta de éxito
    echo json_encode(["success" => true, "message" => "Compra realizada con éxito."]);
}
?>
