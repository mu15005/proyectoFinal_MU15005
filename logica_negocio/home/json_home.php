<?php
@session_start();

require_once("../../Conexion/Modelo_generico.php");
$modelo = new Modelo_generico();
if ((isset($_POST['accion']) && isset($_POST['accion']) !== "")) {
	$accion = $_POST['accion'];

	switch ($accion) {
		
			case "si_registralo":
                $codigoProyecto = generaCodigoProyecto(); 
                $proyecto = array(
                    "table" => "proyecto",
                    "c_codigo"=>$codigoProyecto,
                    "c_nombre" => $_POST['nombre'],
                    "b_estado" => false,
                    "dt_fechacreacion" => date("Y-m-d G:i:s")
                    
                );
        $result = $modelo->insertar_generica($proyecto);
        if($result["resultado"]){
           /*Si la persona se creo procedo a registrar su usuario*/
           $idColaboracion = $modelo->retonrar_id_insertar("usuario"); 
           $array_usuario = array(
               "table" => "colaboracion",
               "e_idcolaboracion"=>$idColaboracion,
               "c_codigoproyecto" => $codigoProyecto,
               "c_propietario" =>true,
               "c_usuario" => $_SESSION['idusuario'],
               "b_estado" => false
              
           );
           $result_usuario = $modelo->insertar_generica($array_usuario);
            print json_encode(array("resultado"=>"Exito"),JSON_FORCE_OBJECT);
            exit();
        	
        }else {
        	print json_encode(array("resultado"=>"Error"),JSON_FORCE_OBJECT);
			exit();
        }
		
			break;
            case "si_consultalos" :
                // $usuario = $_SESSION['usuario'];
                $usuario="marck";
                $resultado = $modelo->get_query("SELECT

                proyecto.c_nombre, 
                proyecto.c_codigo, 
                proyecto.b_estado, 
                proyecto.dt_fechacreacion, 
                usuario.c_usuario
            FROM
                proyecto
                INNER JOIN
                colaboracion
                ON 
                    proyecto.c_codigo = colaboracion.c_codigoproyecto
                INNER JOIN
                usuario
                ON 
                    colaboracion.c_usuario = usuario.c_idusuario
            WHERE
                usuario.c_usuario='".$usuario."'");
        if($resultado["resultado"]){
            
            $fila="";
            
            foreach ($resultado["filas"] as $value) {
               
                $fila.="<li><a data-codigo='".$value->c_codigo."' class='link_proyecto' href='#'>".$value->c_nombre."</a></li>
                </li>";
           
            }
            
            $datos=[
                "resultado"=>"Exito",
                "fila"=>$fila,
                "totalProyectos"=>$resultado["totalFilas"]
            ];
            print json_encode($datos,JSON_FORCE_OBJECT);
            exit;

        }else {
            print json_encode(array("resultado"=>"Error"));
            exit;
        }




                break;
                case "si_carga_proyecto" :
                    print "hola";
                    exit;
                    break;
	}
}
function generaCodigoProyecto()
{
    $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    // Output: video-g6swmAP8X5VG4jCi.mp4
    return 'P' . substr(str_shuffle($permitted_chars), 0, 9);
}
