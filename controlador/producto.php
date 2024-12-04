<?php
header("Content-Type: application/json");

// Manejo para solicitudes preflight
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}



require_once("../configuracion/conexion.php");
require_once("../modelos/Producto.php");


/* function desencriptarBody($jsonEncriptado, $clave) {
    $method = $_SERVER['REQUEST_METHOD'];
    $cifrado = "aes-256-ecb";
    $jsonDesencriptado = openssl_decrypt(base64_decode($jsonEncriptado), $cifrado, $clave, OPENSSL_RAW_DATA);
        // Verificar si la desencriptación falló
        if ($jsonDesencriptado === false && $method != "GET") {
            // Devolver un mensaje de error si la desencriptación falla
            echo json_encode(["Error" => "Contraseña o Sentencia incorrecta"]);
            return false;
        }
    
        // Devolver los datos desencriptados
        return $jsonDesencriptado;
}
 */

$producto = new Producto();


// Verificar encabezado Cedula
if (!isset($_SERVER['HTTP_CEDULA'])) {
    echo json_encode(["Error" => "Encabezado Cedula no está en el Header"]);
    http_response_code(400);
    exit();
}
$cedula = $_SERVER['HTTP_CEDULA'];

// Consultar usuario por Cedula
$usuarioData = $usuario->obtener_usuario_por_cedula($cedula);
 
if (!$usuarioData) {
    echo json_encode(["Error" => "Usuario no encontrado"]);
    http_response_code(404);
    exit();
}

//$claveCifrado = $usuarioData[0]["pass"];

if ($usuarioData && $cedula == "01") {
    $body = json_decode(file_get_contents("php://input"), true);
}else {
    echo json_encode(["Error" => "Cedula no autorizada"]);
    exit();
}



/* $bodyEncriptado = file_get_contents("php://input");
$body = json_decode(desencriptarBody($bodyEncriptado, $claveCifrado), true); */

$method = $_SERVER['REQUEST_METHOD'];

// Si no se pudo desencriptar el JSON, devuelve un error
/* if ($body === null && $method != "GET") {
    echo json_encode(["Error" => "Error al desencriptar los datos."]);
    exit();
} */


switch ($method) {
    case "GET":
        $datos = $producto->obtener_usuario();
        echo json_encode($datos);
        break;

    case "POST":
        $resultado = $producto->insertar_usuario($body["nombre"], $body["empresa"]);
        echo json_encode(["Correcto" => "Usuario creado"]);
        break;

    case "PUT":
        $resultado = $producto->actualizar_usuario( $body["nombre"], $body["pass"],$body["idProducto"]);
        echo json_encode(["Correcto" => "Usuario actualizado"]);
        break;

    case "DELETE":
        $resultado = $producto->eliminar_usuario($body["idProducto"]);
        echo json_encode(["Correcto" => "Usuario eliminado"]);
        break;

    case "PATCH":
        // Realiza una búsqueda por cédula
        $datos = $producto->obtener_usuario_por_cedula($body["idProducto"]);
        echo json_encode($datos);   
        break;

}
?>