$(function(){
	console.log("Esta funcionando");
	// $( "#token" ).keyup(function() {
	// 	let token=$("#token").val();
	// 	console.log(token);
	//   });
	$(document).on("keyup","#la_recontra",function(event){
		event.preventDefault();
		$("#icon_contra").removeClass();
		let contra=$("#la_contra").val();
		let recontra=$("#la_recontra").val();

		if(contra==recontra){
			$("#icon_contra").addClass("text-success fa fa-check-circle-o ");

		}else{
			$("#icon_contra").addClass("text-danger fa fa-times");
		}


	});
	$(document).on("keyup","#la_contra",function(event){
		event.preventDefault();
		$("#icon_contra").removeClass();
		let contra=$("#la_contra").val();
		let recontra=$("#la_recontra").val();

		if(contra==recontra){
			$("#icon_contra").addClass("text-success fa fa-check-circle-o ");

		}else{
			$("#icon_contra").addClass("text-danger fa fa-times");
		}


	});
	$(document).on("keyup","#token",function(event){
		event.preventDefault();
		
		let token=$("#token").val();
		let el_idusuario=$("#el_idusuario").val();
		console.log(token);
		console.log(el_idusuario);
		tokenAux=token;
		tokenAux=tokenAux.replace(/[^\w\s]|_/g,'');
		
		console.log(tokenAux);
		if(tokenAux.length==6){
			$("#icon_token").addClass("fa fa-spin fa-circle-o-notch");
			setTimeout(function(){
				let datos={"token":token,"verificar_token":"si_verificar","el_idusuario":el_idusuario};
			getAjax("json_ingreso.php",datos).then(json=>{
				let dato=JSON.parse(json);
				console.log(dato);
				if (dato.resultado=="Exito") {
					$('#btn_actualizar_pass').attr('disabled', false);
					$("#icon_token").removeClass();
					$("#icon_token").addClass("text-success fa fa-check-circle-o ");

				}else{
					$("#icon_token").removeClass();
					$("#icon_token").addClass("text-danger fa fa-times");
					$('#btn_actualizar_pass').attr('disabled', false);
				}
			});	
			
			},500);
			
			
		}
	});
	$(document).on("click","#icon_mostrarcontra",function(event){
		event.preventDefault();
		$("#icon_mostrarcontra").removeClass();
		if($('#contrasena').prop('type')=="password"){
			$('#contrasena').prop('type',"text");
			$("#icon_mostrarcontra").addClass("fa fa-eye-slash waves-effect waves-light");
		}else{
			$('#contrasena').prop('type',"password");
			$("#icon_mostrarcontra").addClass("fa fa-eye waves-effect waves-light");
		}
		
	});
	$(document).on("click","#icon_mostrar_contra",function(event){
		event.preventDefault();
		$("#icon_mostrar_contra").removeClass();
		if($('#la_contra').prop('type')=="password"){
			$('#la_contra').prop('type',"text");
			$("#icon_mostrar_contra").addClass("fa fa-eye-slash waves-effect waves-light");
		}else{
			$('#la_contra').prop('type',"password");
			$("#icon_mostrar_contra").addClass("fa fa-eye waves-effect waves-light");
		}
		
	});
	$(document).on("click","#icon_mostrar_recontra",function(event){
		event.preventDefault();
		$("#icon_mostrar_recontra").removeClass();
		if($('#la_recontra').prop('type')=="password"){
			$('#la_recontra').prop('type',"text");
			$("#icon_mostrar_recontra").addClass("fa fa-eye-slash waves-effect waves-light");
		}else{
			$('#la_recontra').prop('type',"password");
			$("#icon_mostrar_recontra").addClass("fa fa-eye waves-effect waves-light");
		}
		
	});
	$(document).on("click","#link_registrar",function(event){
		event.preventDefault();
	 
		var timer = setInterval(function(){
			$(location).attr('href','registro.php');
			clearTimeout(timer); 
		},500)
	});
	$(document).on("submit","#formulario_registro",function(event){
		event.preventDefault();
		var datos = $("#formulario_registro").serialize();
		datos["accion"]="si_registralo";
		console.log("formulario desbloqueo",datos);
		getAjax("json_ingreso.php",datos).then((json) =>{
			console.log(" desbloqueo",json);
	    	if (json[0]=="Exito") {
	    	 	
				
				var timer = setInterval(function(){
					$(location).attr('href','index.php');
					clearTimeout(timer); 
				},3500)
	    	 }else{
	    	 	
	    	 }

		});
	});

	$(document).on("submit","#cambiar_pass",function(event){
		event.preventDefault();
		if ($("#la_contra").val()!=$("#la_recontra").val()) {
			Swal.fire(
			  'Error!',
			  'Las contraseñas no coinciden',
			  'error'
			)
		}else{
			var datos = $("#cambiar_pass").serialize();
			$.ajax({
		        dataType: "json",
		        method: "POST",
		        url:'json_ingreso.php',
		        data : datos,
		    }).done(function(json) {
		    	var timer = setInterval(function(){
					$(location).attr('href','index.php');
					clearTimeout(timer); 
				},3500)
		    	console.log("El dato es valido",json);

		    }).fail(function(e){
		    	console.error("El error es",e);
		    }).always(function(e){
		    	Swal.close(); 
		    	
		    });
		}
	});

	$(document).on("submit","#recuperar_form",function(event){
		event.preventDefault();
		var datos = $("#recuperar_form").serialize();
		getAjax("json_ingreso.php",datos).then(json=>{
			console.log("id"+json);
			let dato=JSON.parse(json);
		if(dato.resultado=="Exito"){
			$("#recuperar_form").css("display","none");
			$("#cambiar_pass").css("display","block");
		   
			   $("#validar_correo").val("actualizar_pass");
   
			$("#el_idusuario").val(dato.idusuario);
			
		}else{
			
		}
		
		});
	});
	$(document).on("submit","#recuperar_forms",function(event){
		mostrar_cargando("Obteniendo datos");
		event.preventDefault();
		
		var datos = $("#recuperar_form").serialize();
		$.ajax({
	        dataType: "json",
	        method: "POST",
	        url:'json_ingreso.php',
	        data : datos,
	    }).done(function(json) {
			console.log("El dato es valido",json);
	    	 $("#recuperar_form").css("display","none");
	    	 $("#cambiar_pass").css("display","block");
	    	 $("#validar_correo").val("actualizar_pass");
	    	 $("#el_id").val(json[1]);
	    	
	    }).fail(function(e){
	    	console.error("El error es",e);
	    }).always(function(e){
	    	Swal.close(); 
	    	
	    });


	});
	$(document).on("submit","#formulario_desbloqueo1",function(event){
		event.preventDefault();
		var datos = $("#formulario_desbloqueo1").serialize();
		console.log("formulario desbloqueo",datos);
		$.ajax({
	        dataType: "json",
	        method: "POST",
	        url:'json_ingreso.php',
	        data : datos,
	    }).done(function(json) {
	    	console.log(" desbloqueo",json);
	    	if (json[0]=="Exito") {
	    	 	
				Swal.fire({
				  icon: 'success',
				  title: json[1]
				});
				var timer = setInterval(function(){
					$(location).attr('href','../home/index.php?modulo=Home');
					clearTimeout(timer); 
				},3500)
	    	 }else{
	    	 	Swal.fire({
				  icon: 'error',
				  title: json[1]
				});
	    	 }

	    });
	});
	
	$("#formulario_login").submit(function(e){
		e.preventDefault();
		if ($("#correo").val()=="" || $("#contrasena").val()=="") {
			Swal.fire(
			  'Ops',
			  'Datos vacíos',
			  'error'
			)
			return;
		}else{
			$.ajax({
				dataType: "json",
				method:"POST",
				url:"json_ingreso.php",
				data:{"consultar_login":"si_consultalo","correo":$("#correo").val(),"contrasena":$("#contrasena").val()}
			}).done(function (json){
				console.log("el json: ",json);
				if (json[0]=="Exito") {
	    	 	
					Swal.fire({
					  icon: 'success',
					  title: json[1]
					});
					var timer = setInterval(function(){
						$(location).attr('href','../home/index.php?modulo=Home');
						clearTimeout(timer);
					},3500)
		    	 }else{
		    	 	Swal.fire({
					  icon: 'error',
					  title: json[1]
					});
		    	 }

			})


		}
	

	})
});


function mostrar_cargando(titulo,mensaje=""){
	Swal.fire({
	  title: titulo,
	  html: mensaje,
	  timer: 2000,
	  timerProgressBar: true,
	  didOpen: () => {
	    Swal.showLoading()
	     
	  },
	  willClose: () => {
	     
	  }
	}).then((result) => {
	  /* Read more about handling dismissals below */
	  if (result.dismiss === Swal.DismissReason.timer) {
	    console.log('I was closed by the timer')
	  }
	})
}


 function soloLetras(e) {
    var key = e.keyCode || e.which,
      tecla = String.fromCharCode(key).toLowerCase(),
      letras = " abcdefghijklmnñopqrstuvwxyz",
      especiales = [8, 37, 39, 46],
      tecla_especial = false;

    for (var i in especiales) {
      if (key == especiales[i]) {
        tecla_especial = true;
        break;
      }
    }

    if (letras.indexOf(tecla) == -1 && !tecla_especial) {
      return false;
    }
  }