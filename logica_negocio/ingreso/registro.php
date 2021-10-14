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
          <h4 class="font-18 m-b-5 text-center">Bienvenido</h4>
          <p class="text-muted text-center">Ingrese sus credenciales</p>

          <form name="formulario_registro" id="formulario_registro"  >
          <input type="hidden" name="accion" value="si_registralos">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Nombre *</label>
                  <input type="text" autocomplete="off" name="nombre" data-parsley-error-message="Campo requerido" id="nombre" class="form-control" required placeholder="Ingrese su nombre" />
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label>Email *</label>
                  <input type="email" data-parsley-error-message="Campo requerido" autocomplete="off" name="email" id="email" class="form-control" required placeholder="Ingrese su email" />
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label>DUI *</label>
                  <input type="text" autocomplete="off" name="dui" id="dui" data-parsley-error-message="Campo requerido" class="form-control" required placeholder="Ingrese su dui" />
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label>Fecha nacimiento *</label>
                  <input type="text" autocomplete="off" name="fecha" data-parsley-error-message="Campo requerido" id="fecha" class="form-control" required placeholder="Ingrese su fecha nacimineto" />
                </div>
              </div>


              <div class="col-md-6">
                <div class="form-group">
                  <label>Usuario <span class="eliminar_obligaroio">*</span></label>
                  <input maxlength="20" type="text" autocomplete="off" name="usuario" id="usuario" data-parsley-error-message="Campo requerido" class="form-control" required placeholder="Ingrese su usuario" />
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label>Contraseña<span class="eliminar_obligaroio">*</span></label>
                  <input maxlength="50" minlength="5" type="password" data-parsley-error-message="Campo requerido" autocomplete="off" name="pass" id="pass" class="form-control" required placeholder="Ingrese su contraseña" />
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Rep. Contraseña<span class="eliminar_obligaroio">*</span></label>
                  <input maxlength="50" minlength="5" type="password" data-parsley-error-message="Campo requerido" autocomplete="off" name="re_pass" id="re_pass" class="form-control" required placeholder="Ingrese su contraseña" />
                </div>
              </div>

              <div class="col-md-12">
                <div class="form-group">
                  <label>Foto de Perfil</label>
                  <input type="file" id="foto" name="foto" class="filestyle" data-buttonname="btn-secondary">
                </div>
              </div>


            </div>


        </div>
        <div class="modal-footer">
         
          <button type="submit" class="btn btn-primary">Guardar</button>
          </form>
        </div>

      </div>
    </div>



  </div>

  <?php include '../../layouts/footerScript.php'; ?>

  <!-- App js -->
  <script src="../../public/assets/js/app.js"></script>
  <script src="funciones_ingreso.js" type="text/javascript" charset="utf-8"></script>

</body>

</html>