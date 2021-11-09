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
        if($result[0]=='1'){
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
                $usuario = $_SESSION['usuario'];
                echo $_SESSION["usuario"];
                exit;
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
        if($resultado[0]=='1'){
            
            $fila="";
            $codigoProyecto=$resultado[2]["c_codigo"];
            foreach ($resultado[2] as $value) {
               
                $fila.="<li><a data-codigo='".$value["c_codigo"]."' class='link_proyecto' href='#'>".$value["c_nombre"]."</a></li>
                </li>";
           
            }
            $tareas=getTareas($codigoProyecto);
            $datos=[
                "resultado"=>"Exito",
                "fila"=>$fila,
                "totalProyectos"=>$resultado[4],
                "tareas"=>$tareas
            ];
            $datosProyecto= $modelo->get_query("SELECT
            proyecto.c_codigo, 
            proyecto.c_nombre, 
            proyecto.b_estado, 
            proyecto.dt_fechacreacion, 
            usuario.c_idusuario
        FROM
            proyecto,
            usuario
            where c_idusuario='".$_SESSION["idusuario"]."'");
            $select="<option value='-1'>Seleccione</option>";
            if($datosProyecto[0]=='1'){
               foreach ($datosProyecto[2] as  $value) {
                $select.="<option value='".$value["c_codigo"]."'>".$value["c_nombre"]."</option>";
            }
            $datos["select"]=$select;
            
            print json_encode($datos,JSON_FORCE_OBJECT);
            exit;

        }else {
            print json_encode(array("resultado"=>"Error",JSON_FORCE_OBJECT));
            exit;
        }

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
function getTareas($codigo){
    $modelo = new Modelo_generico();
    $resultado = $modelo->get_query("SELECT
	tarea.e_idtarea, 
	tarea.c_nombre, 
	tarea.dt_fechacreacion, 
	tarea.dt_fechafinal, 
	tarea.b_estado, 
	tarea.c_codigoproyecto, 
	proyecto.c_codigo, 
	colaboracion.c_propietario, 
	colaboracion.c_codigoproyecto, 
	proyecto.b_estado
FROM
	tarea
	INNER JOIN
	proyecto
	ON 
		tarea.c_codigoproyecto = proyecto.c_codigo
	INNER JOIN
	colaboracion
	ON 
		proyecto.c_codigo = colaboracion.c_codigoproyecto
		where colaboracion.c_codigoproyecto ='".$codigo."' and tarea.b_estado=0 and Date(tarea.dt_fechafinal)=Date(now())");
        $fila="";
if($resultado[0]=='1'){



foreach ($resultado[2] as $value) {
   
    $fila.=" <label class='tasks-list-item'>
    <input type='checkbox' data-id='".$value["e_idtarea"]."'  value='1' class='tasks-list-cb tarea'>
    <span class='tasks-list-mark'></span>
    <span class='tasks-list-desc'>".$value["c_nombre"]."</span>
  </label>";

}

}
return $fila;
}
function getMensajesRecientes($codigo){
    $modelo = new Modelo_generico();
    $resultado = $modelo->get_query("SELECT
	mensaje.e_idmensaje, 
	mensaje.dt_fecha, 
	mensaje.e_idcolaboracion, 
	mensaje.c_mensaje, 
	colaboracion.e_idcolaboracion, 
	colaboracion.c_codigoproyecto, 
	colaboracion.c_usuario, 
	colaboracion.c_propietario, 
	colaboracion.b_estado, 
	proyecto.c_codigo
FROM
	mensaje
	INNER JOIN
	colaboracion
	ON 
		mensaje.e_idcolaboracion = colaboracion.e_idcolaboracion
	INNER JOIN
	proyecto
	ON 
		colaboracion.c_codigoproyecto = proyecto.c_codigo
		WHERE proyecto.c_codigo='".$codigo."' LIMIT 0,10;");
        $fila="";
if($resultado[0]=='1'){



foreach ($resultado[2] as $value) {
   
    $fila.="  <a href='#'>
                <div class='inbox-item'>
                    <div class='inbox-item-img'><img src='public/assets/images/users/avatar-1.jpg' class='rounded-circle' alt='></div>
                    <p class='inbox-item-author'>Didier Charpentier</p>
                    <p class='inbox-item-text'>".$value["c_mensaje"]."</p>
                    <p class='inbox-item-date'>".$value["hora"]."</p>
                </div>
            </a>";

}

}
return $fila;
}