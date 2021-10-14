$(function(){
 
    $('form_registro_Proyectos').parsley();
     
    $(document).on("click",".link_proyecto",function(e){
		e.preventDefault(); 
 

		var codigo = $(this).attr("data-codigo");
		console.log(codigo);
		var datos = {"accion":"si_carga_proyecto","codigo":codigo}
        getAjax("json_home.php",datos).then(json=>{
           console.log(json)
        });
    });
	$(document).on("submit","#form_registro_Proyectos",function(event){
       
		event.preventDefault();
		var datos = $("#form_registro_Proyectos").serialize();
		
	
		getAjax("json_home.php",datos).then((json) =>{
			console.log(json);
      let dato=JSON.parse(json);
      
	    	if (dato.resultado=="Exito") {
         mostrarMensaje('Proyecto Registrado Con Exito', 'success',1500);
          $("#myModal").modal("hide");
            cargar_datos();
	    	 }else{
	    	 	
	    	 }

		});
	});
  cargar_datos();
});
function cargar_datos(){
 
	var datos = {"accion":"si_consultalos"};
	getAjax("json_home.php",datos).then(json=>{
    
    datos=JSON.parse(json);
    console.log(datos);
       $("#proyectos_del_usuario").empty().html(datos.fila);
       $("#cantidad_proyectos").empty().html(datos.totalProyectos)
      
    });

}
