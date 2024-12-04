<?php
// Establece el tipo de contenido a JSON
header("Content-Type: application/json");

// Manejo para solicitudes preflight (método OPTIONS)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200); // Responde con éxito para OPTIONS
    exit();
}

// Incluye los archivos necesarios para la conexión a la base de datos y la clase Casa
require_once("../configuracion/conexion.php");
require_once("../modelos/Usuarios.php");

// Configuración de la clave de cifrado (compartida)
define("CLAVE_SECRETA", "0123456789abcdef0123456789abcdef");

function Desencriptar_BODY($JSON) {
    // Definir el tipo de cifrado (AES-256-ECB)
    $cifrado = "aes-256-ecb";
    
    // Desencriptar usando openssl_decrypt
    $JSON_desencriptado = openssl_decrypt(base64_decode($JSON), $cifrado, CLAVE_SECRETA, OPENSSL_RAW_DATA);
    
    // Verificar si la desencriptación falló
    if ($JSON_desencriptado === false) {
        // Devolver un mensaje de error si la desencriptación falla
        return false;
    }

    // Devolver los datos desencriptados
    return $JSON_desencriptado;
}

// Crea una instancia de la clase Casa
$usuario = new Usuario();

// Obtiene los datos enviados en formato JSON
$body_encriptado = file_get_contents("php://input");
$body = json_decode(Desencriptar_BODY($body_encriptado), true);

// Si no se pudo desencriptar el JSON, devuelve un error
if ($body === null) {
    echo json_encode(["Error" => "Error al desencriptar los datos."]);
    exit();
}

// Obtén el método HTTP utilizado
$method = $_SERVER['REQUEST_METHOD'];

// Define las operaciones basadas en el método HTTP
switch ($method) {
    case "GET":
        $usuario = $casa->obtener_usuario();
        echo json_encode($datos);
        break;

    case "PATCH":
        $usuario = $casa->obtener_usuario_por_cedula($body["cedula"]);
        echo json_encode($datos);
        break;

    case "POST":
        $usuario = $casa->insertar_usuario($body["cedula"], $body["nombre"],  $body["pass"]);
        echo json_encode(["Correcto" => "Inserción Realizada"]);
        break;

    case "PUT":
        $usuario = $casa->actualizar_usuario($body["cedula"], $body["nombre"], $body["pass"]);
        echo json_encode(["Correcto" => "Actualización Realizada"]);
        break;

    case "DELETE":
        $usuario = $casa->eliminar_usuario($body["cedula"]);
        echo json_encode(["Correcto" => "Eliminación Realizada"]);
        break;

    default:
        http_response_code(405);
        echo json_encode(["Error" => "Método no permitido"]);
        break;
}
?>
