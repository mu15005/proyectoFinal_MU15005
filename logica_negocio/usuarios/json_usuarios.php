<?php 

	require_once("../../Conexion/Modelo_generico.php");
	$modelo = new Modelo_generico();
	if (isset($_POST['ingreso_datos']) && $_POST['ingreso_datos']=="si_actualizalo") {
        $_POST['direccion'] = "Sin direccion";
        $array_update = array(
            "table" => "tb_persona",
            "id" => $_POST['llave_persona'],
            "dui"=>$_POST['dui'],
            "nombre" => $_POST['nombre'],
            "email" => $_POST['email'],
            "direccion" => $_POST['direccion'], 
            "telefono" => $_POST['telefono'],
            "fecha_nacimiento" => $modelo->formatear_fecha($_POST['fecha']), 
            "tipo_persona" => $_POST['tipo_persona']
        );
        $resultado = $modelo->actualizar_generica($array_update);

        if($resultado[0]=='1' && $resultado[4]>0){
            print json_encode(array("Exito",$_POST,$resultado));
            exit();

        }else {
            print json_encode(array("Error",$_POST,$resultado));
            exit();
        }


    }else if (isset($_POST['consultar_info']) && $_POST['consultar_info']=="si_condui_especifico") {

        $resultado = $modelo->get_todos("tb_persona","WHERE id = '".$_POST['id']."'");
        if($resultado[0]=='1'){
            print json_encode(array("Exito",$_POST,$resultado[2][0]));
            exit();

        }else {
            print json_encode(array("Error",$_POST,$resultado));
            exit();
        }



    }else if(isset($_POST['eliminar_datos']) && $_POST['eliminar_datos']=="si_eliminalo"){
        $array = array(
            "table"=>"tb_persona",
            "id"=>$_POST['id']
        );
        $resultado = $modelo->eliminar_generica($array);
        if($resultado[0]=='1'){
            print json_encode(array("Exito",$_POST,$resultado));
            exit();

        }else {
            print json_encode(array("Error",$_POST,$resultado));
            exit();
        }

    }else if(isset($_POST['ingreso_datos']) && $_POST['ingreso_datos']=="si_registro"){
		$_POST['direccion']="San vicente";

		$id_insertar = $modelo->retonrar_id_insertar("tb_persona"); 
        $array_insertar = array(
            "table" => "tb_persona",
            "id"=>$id_insertar,
            "nombre" => $_POST['nombre'],
            "email" => $_POST['email'],
            "direccion" => $_POST['direccion'],
            "dui" => $_POST['dui'],
            "telefono" => $_POST['telefono'],
            "estado" => 1,
            "fecha_nacimiento" => $modelo->formatear_fecha($_POST['fecha']),
            "fecha_registro" => date("Y-m-d G:i:s"),
            "tipo_persona" => $_POST['tipo_persona']
        );
        $result = $modelo->insertar_generica($array_insertar);
        if($result[0]=='1'){
            /*Si la persona se creo procedo a registrar su usuario*/
            $id_usuario = $modelo->retonrar_id_insertar("tb_usuario"); 
            $array_usuario = array(
                "table" => "tb_usuario",
                "id"=>$id_usuario,
                "id_persona" => $id_insertar,
                "usuario" => $_POST['usuario'],
                "contrasena" => $modelo->encriptarlas_contrasenas($_POST['contrasenia'])
            );
            $result_usuario = $modelo->insertar_generica($array_usuario);

            print json_encode(array("Exito",$_POST,$result,$result_usuario));
            exit();
        	print json_encode(array("Exito",$_POST,$result));
			exit();

        }else {
        	print json_encode(array("Error",$_POST,$result));
			exit();
        }
		




	} else if (isset($_POST['consultar_datos']) && $_POST['consultar_datos']=="si_consultalos") {
		$sql = "SELECT * FROM tb_persona";
		$resultado = $modelo->get_query($sql);

		$html=$html_tr="";
		$cuanto=0;
		if ($resultado[0]=="1") {
			foreach ($resultado[2] as $row) {
				
				$tipo_persona = ($row['tipo_persona']==1) ? "Administrador":"Empleado";
				$html_tr.='<tr>
                            <td>'.$row['nombre'].'</td>
                            <td>'.$row['dui'].'</td>
                            <td>'.$row['telefono'].'</td>
                            <td>'.$row['email'].'</td>
                            <td>'.$modelo->formatear_fecha($row['fecha_nacimiento']).'</td>
                            <td>'.$tipo_persona.'</td> 
                            <td>
                            	<div class="dropdown m-b-10">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Seleccione
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item btn_eliminar" data-id="'.$row['id'].'"  href="javascript:void(0)">Eliminar</a>
                                        <a class="dropdown-item btn_editar" data-id="'.$row['id'].'"  href="javascript:void(0)" >Actualizar</a>
                                        <a class="dropdown-item btn_recupearcontra" href="javascript:void(0)">Recuperar contraseña</a>
                                    </div>
                                </div>
                            </td> 
                        </tr>';
				
			}

			$html.='<table id="tabla_personas" class="table table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>DUI</th>
                            <th>Teléfono</th>
                            <th>Email</th>
                            <th>Fecha Nacimiento</th>
                            <th>Tipo de persona</th>
                            <th>Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        ';
            $html.=$html_tr;
            $html.='</tbody>
            		</table>';

           	print json_encode(array("Exito",$html,$resultado[4]));

		}else{
			print json_decode(array("Error",$resultado));
		}
		
	}


?>