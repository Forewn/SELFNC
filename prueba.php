<?php
    require './dashboard/Config/Config.php';


    // $clave = '11111';
    $usuario = "Aga222";

    $stmt = $connect->prepare('SELECT a.id_usuario, a.usuario, a.password, a.id_rol, b.nombre AS nombre
    FROM usuarios a
    JOIN profesores b 
    ON  b.cedula_profesor = a.cedula_profesor
    WHERE usuario = :usuario');

    $stmt->execute(array(
    ':usuario' => $usuario
    ));

    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    echo $data['nombre'];

?>
