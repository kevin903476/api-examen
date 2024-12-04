<?php
// Clase Categoria hereda de la clase Conectar
class Usuario extends Conectar {

    // Obtiene todas las categorías activas
    public function obtener_usuario() {
        // Establece la conexión a la base de datos
        $conexion = parent::conectar_bd();
        parent::establecer_codificacion();
        
        // Consulta SQL para obtener todas las categorías activas
        $consulta_sql = "SELECT * FROM usuario";   

        // Prepara la consulta SQL
        $consulta = $conexion->prepare($consulta_sql);
        $consulta->execute();

        // Retorna el resultado de la consulta como un array asociativo
        return $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);   
    }

    // Obtiene una categoría específica por su ID
    public function obtener_usuario_por_cedula($id) {
        // Establece la conexión a la base de datos
        $conexion = parent::conectar_bd();
        parent::establecer_codificacion();
        
        // Consulta SQL para obtener una propietario     específica por su ID
        $consulta_sql = "SELECT * FROM usuario WHERE cedula = ?";

        // Prepara la consulta SQL
        $consulta = $conexion->prepare($consulta_sql);
        $consulta->bindValue(1, $id);  // Asocia el valor del ID de categoría

        // Ejecuta la consulta
        $consulta->execute();

        // Retorna el resultado como un array asociativo
        return $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
    }

    // Inserta una nuevo propietario
    public function insertar_usuario($cedula, $nombre, $pass) {
        // Establece la conexión a la base de datos
        $conexion = parent::conectar_bd();
        parent::establecer_codificacion();
   
        // Sentencia SQL para insertar una nueva casa
        $sentencia_sql = "INSERT INTO `usuario`(`cedula`, `nombre`, `pass`) VALUES (?,?,?)";
        $sentencia = $conexion->prepare($sentencia_sql);
        $sentencia->bindValue(1, $cedula);  
        $sentencia->bindValue(2, $nombre);  
        $sentencia->bindValue(3, $pass); 
        $sentencia->execute();
    
        return ["success" => true, "message" => "Inserción Realizada"];
    }

    // Actualiza una categoría existente
    public function actualizar_usuario($cedula, $nombre, $pass) {
        // Establece la conexión a la base de datos
        $conexion = parent::conectar_bd();
        parent::establecer_codificacion();

            // Si se proporcionó un DNI_propietario, lo actualizamos
            $sentencia_sql = "UPDATE `usuario` SET `nombre`= ?, `pass`= ? WHERE cedula = ?";
            $sentencia = $conexion->prepare($sentencia_sql);
            $sentencia->bindValue(1, $nombre);
            $sentencia->bindValue(2, $pass);
            $sentencia->bindValue(3, $cedula);

        
    
        // Ejecuta la sentencia
        $sentencia->execute();
    
        // Retorna el resultado (aunque no es necesario para un update, se puede omitir)
        return $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }

    // Desactiva (elimina lógicamente) una categoría
    public function eliminar_usuario($cedula) {
        // Establece la conexión a la base de datos
        $conexion = parent::conectar_bd();
        parent::establecer_codificacion();
        
        // Sentencia SQL para "eliminar" (desactivar) una categoría
        $sentencia_sql = "DELETE FROM `usuario` WHERE cedula = ?";

        // Prepara la sentencia SQL
        $sentencia = $conexion->prepare($sentencia_sql);
        $sentencia->bindValue(1, $cedula);  // Asocia el ID de la categoría

        // Ejecuta la sentencia
        $sentencia->execute();

        // Retorna el resultado (aunque no es necesario para un delete lógico, se puede omitir)
        return $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }

}
?>
