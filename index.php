<?php

// require 'flight/Flight.php';
require 'flight/autoload.php';

Flight::register('db','PDO', array('mysql:host=localhost;dbname=api','root',''));

Flight::route('GET /alumnos', function () {
    $sentencia = Flight::db()->prepare("SELECT * FROM ALUMNOS");
    $sentencia->execute();
    $datos = $sentencia->fetchAll();
    Flight::json($datos);
});

Flight::route('POST /alumnos', function () {
    $nombres = (Flight::request()->data->nombres);
    $apellidos= (Flight::request()->data->apellidos);
    $sentencia = Flight::db()->prepare("INSERT INTO ALUMNOS(NOMBRES, APELLIDOS) VALUES(?,?)");
    $sentencia->bindParam(1,$nombres);
    $sentencia->bindParam(2,$apellidos);
    $sentencia->execute();

    Flight::jsonp(["Se ha agregado el alumno "]);
});

Flight::route('DELETE /alumnos', function () {
    $id = (Flight::request()->data->id);

    $sentencia = Flight::db()->prepare("DELETE FROM ALUMNOS WHERE ID = ?");
    $sentencia->bindParam(1,$id);
  
    $sentencia->execute();

    Flight::jsonp(["Se ha borrado el registro del alumno "]);
});

Flight::route('PUT /alumnos', function () {
    $id = (Flight::request()->data->id);
    $nombres = (Flight::request()->data->nombres);
    $apellidos= (Flight::request()->data->apellidos);
    $sentencia = Flight::db()->prepare("UPDATE ALUMNOS SET NOMBRES = ?, APELLIDOS= ? WHERE ID = ?");
    $sentencia->bindParam(1,$nombres);
    $sentencia->bindParam(2,$apellidos);
    $sentencia->bindParam(3,$id);
    $sentencia->execute();

    Flight::jsonp(["Se ha actualizado el alumno "]);
});

Flight::route('GET /alumnos/@id', function ($id) {
    $sentencia = Flight::db()->prepare("SELECT * FROM ALUMNOS WHERE ID = ?");
    $sentencia->bindParam(1,$id);
    $sentencia->execute();
    $datos = $sentencia->fetchAll();
    Flight::json($datos);
});

Flight::start();
