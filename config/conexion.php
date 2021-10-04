<?php

require_once("configServer.php");
class Conexion {
    public static function conectar(){
       $conectString="mysql:host=".SERVER.";dbname=".DATABASE.";charset=utf8";
       try {
             $conexion=new PDO($conectString,USER,PASS);
             $conexion->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
						 return $conexion;
            } catch (Exception $e) {

                echo "Error en la conexion: ".$e->getMessage();
            }
    }

  }
