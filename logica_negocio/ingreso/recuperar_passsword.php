<?php include '../../layouts/header.php'; ?>

<?php include '../../layouts/headerStyle.php'; ?>

<body class="fixed-left">

    <?php include '../../layouts/loader.php'; ?>

    <!-- Begin page -->
    <div class="accountbg"></div>
    <div class="wrapper-page">

        <div class="card">
            <div class="card-body">

                <h3 class="text-center m-0">
                    <a href="index.php" class="logo logo-admin"><img src="../../public/assets/images/logo.png" height="30" alt="logo"></a>
                </h3>

                <div class="p-3">
                    <h4 class="font-18 m-b-5 text-center">Recuperar Contraseña</h4>
                    <p class="text-muted text-center">Ingrese su Correo para recuperar su contraseña</p>

                    <form class="form-horizontal m-t-30" id="recuperar_form">
                        <input type="hidden" name="validar_correo" value="si_validar">
                        <div class="form-group">
                            <label for="useremail">Correo *</label>
                            <input type="text" id="el_correo" name="el_correo" class="form-control" ata-parsley-error-message="El Correo es requerido" required>
                        </div>

                        <div class="form-group row m-t-20">
                            <div class="col-12 text-right">
                                <button class="btn btn-primary w-md waves-effect waves-light" type="submit">Validar</button>
                            </div>
                        </div>

                    </form>


                    <form style="display: none;" class="form-horizontal m-t-30" id="cambiar_pass">
                        <input type="hidden" name="validar_correo" id="validar_correo">
                        <input type="hidden" name="el_idusuario" id="el_idusuario" value="">
                        <div class="row">
                            <div class="col-md-11">
                                <div class="form-group">
                                    <label for="token">Ingrese El Codigo de Confirmacion</label>
                                    <input type="text" id="token" name="token" class="form-control" ata-parsley-error-message="Campo obligatorio" required maxlength="8">
                                </div>
                            </div>
                            <div class="col-md-1" style="position: relative;top:40px;">
                                <i id='icon_token' class=""></i>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-11">
                                <div class="form-group">
                                    <label for="la_contra">Ingrese su contraseña</label>
                                    <input type="password" id="la_contra" name="la_contra" class="form-control" ata-parsley-error-message="Campo obligatorio" minlength="8" required>
                                </div>
                                
                                <i id="icon_mostrar_contra" style="position: relative;top:-45px;left:-10px;float:right" class="fa fa-eye waves-effect waves-light"></i>
                                
                            </div>
                            <div class="col-md-1">

                            </div>
                        </div>
               

                <div class="row">
                    <div class="col-md-11">
                        <div class="form-group">
                            <label for="la_recontra">Repita su contraseña</label>
                            <input type="password" id="la_recontra" name="la_recontra" class="form-control" ata-parsley-error-message="Campo obligatorio" minlength="8" required>
                        </div>
                          
                        <i id="icon_mostrar_recontra" style="position: relative;top:-45px;left:-10px;float:right" class="fa fa-eye waves-effect waves-light"></i>
                                
                    </div>
                    <div class="col-md-1" style="position: relative;top:40px;">
                        <i id='icon_contra' class=""></i>
                    </div>
                </div>

                <div class="form-group row m-t-20">
                    <div class="col-12 text-right">
                        <button id="btn_actualizar_pass" class="btn btn-primary " disabled="true" type="submit">Actualizar contraseña</button>
                    </div>
                </div>

                </form>


            </div>

        </div>
    </div>



    </div>

    <?php include '../../layouts/footerScript.php'; ?>

    <!-- App js -->
    <script src="../../public/assets/js/app.js"></script>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript" src="../../public/plugins/parsleyjs/parsley.min.js"></script>
    <!-- Bootstrap inputmask js -->
    <script src="../../public/plugins/bootstrap-inputmask/bootstrap-inputmask.min.js"></script>
    <script>
        $("#recuperar_form").parsley();
        $("#el_dui").inputmask({
            mask: "99999999-9"
        }); //static mask
        $("#token").inputmask({
            mask: "999-999"
        });
    </script>
    <script src="funciones_ingreso.js"></script>

</body>

</html>