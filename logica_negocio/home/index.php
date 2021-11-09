 

<?php include '../../layouts/header.php'; ?>
<!-- C3 charts css -->
<link href="../../public/plugins/c3/c3.min.css" rel="stylesheet" type="text/css" />

<?php include '../../layouts/headerStyle.php'; ?>

<body class="fixed-left">

        <?php include '../../layouts/loader.php'; ?>

        <!-- Begin page -->
        <div id="wrapper">

        <?php include '../../layouts/navbar.php'; ?>

            <!-- Start right Content here -->
            <div class="content-page">
                <!-- Start content -->
                <div class="content">

                    <!-- Top Bar Start -->
                    <?php include("../../layouts/toolbar.php"); ?>
                    <!-- Top Bar End -->

                    <!-- ==================
                         PAGE CONTENT START
                         ================== -->
                         <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog ">
                                                            <div class="modal-content">
                                                                <form  class="form-horizontal m-t-30" id="form_registro_P" name="form_registro_P" >
                                                                    <input type="hidden" id="accion" name="accion" value="si_registralo">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title mt-0" id="myModalLabel">Nuevo Proyecto</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                </div>
                                                                <div class="modal-body">
                                                                
                                                                    <div class="row">
                                                                    <div class="col-md-3">
                                                                    <label>Nombre *</label>
                                                                    </div>
                                                                    <div class="col-md-9">
                                                                        <div class="form-group">
                                                                           
                                                                            <input type="text" autocomplete="off" name="nombre" data-parsley-error-message="Campo requerido" id="nombre" class="form-control" required placeholder="Ingrese nombre del proyecto"/>
                                                                        </div>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                </div>
                                                                <div class="modal-footer">
                                                                <button type="submit"  class="btn btn-primary waves-effect waves-light">Guardar</button>
                                                                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Cerrar</button>
                                                                    
                                                                </div>
                                                                </form>
                                                            </div><!-- /.modal-content -->
                                                        </div><!-- /.modal-dialog -->
                                                    </div><!-- /.modal -->
                                                    <div id="myModalt" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog ">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title mt-0" id="myModalLabel">Nuevo Proyecto</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form action="" method="post">
                                                                    <div class="row">
                                                                    <div class="col-md-3">
                                                                    <label>Nombre *</label>
                                                                    </div>
                                                                    <div class="col-md-9">
                                                                        <div class="form-group">
                                                                           
                                                                            <input type="text" autocomplete="off" name="nombre" data-parsley-error-message="Campo requerido" id="nombre" class="form-control" required placeholder="Ingrese nombre del proyecto"/>
                                                                        </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                    <label>descripcion *</label>
                                                                    </div>
                                                                    <div class="col-md-9">
                                                                        <div class="form-group">
                                                                           
                                                                            <input type="text-area" autocomplete="off" name="nombre" data-parsley-error-message="Campo requerido" id="nombre" class="form-control" required placeholder="Ingrese nombre del proyecto"/>
                                                                        </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                    <label>Fecha *</label>
                                                                    </div>
                                                                    <div class="col-md-9">
                                                                        <div class="form-group">
                                                                        <input type="datetime" autocomplete="off" name="fecha" data-parsley-error-message="Campo requerido" id="fecha" class="form-control" required placeholder="Ingrese su fecha"/>
                               </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                    <label>proyecto *</label>
                                                                    </div>
                                                                    <div class="col-md-9">
                                                                        <div class="form-group">
                                                                        <select id="select_productos" class="form-control">
                                                        
                                                        
                                                                                 </select> </div>
                                                                        </div>
                                                                    </div>
                                                                    </form>
                                                                </div>
                                                                <div class="modal-footer">
                                                                <button type="button" class="btn btn-primary waves-effect waves-light">Guardar</button>
                                                                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Cerrar</button>
                                                                    
                                                                </div>
                                                            </div><!-- /.modal-content -->
                                                        </div><!-- /.modal-dialog -->
                                                    </div><!-- /.modal -->
                    <div class="page-content-wrapper">

                        <div class="container-fluid">
                        <div class="col-md-12 col-xl-12">
                                    <div class="mini-stat clearfix bg-white">
                                        <span class="mini-stat-icon bg-purple mr-0 float-right"><i class="fa fa-cogs"></i></span>
                                        <div class="mini-stat-info">
                                            <span id="cantidad_proyectos" class="counter text-purple"></span>
                                            Proyectos
                                        </div>
                                        <div class="clearfix"></div>
                                        </div>
                                </div>
                        <div class="row">



<div class="col-xl-6" >
    <div class="card m-b-20">
        <div class="card-body">
            <div class="row">
                <div class="col-md-11">
                <h4 class="mt-0 m-b-15 header-title">Tareas Para Hoy</h4>
                </div>
                <div class="col-md-1">
                <button style="height: 30px;top:10px;position: relative;" id="btn_agregar_tarea" data-toggle="modal" data-target="#myModalt" type="button" class="btn btn-success btn-sm waves-effect waves-light"><i class="fa fa-plus"></i></button>
             
                </div>
            </div>
           
               
            <section  class="tasks">
   
    <fieldset id="tareas_hoy" class="tasks-list">
     
     
    </fieldset>
  </section>

        </div>
    </div>
</div>

<div class="col-xl-6">
    <div class="card m-b-20">
        <div class="card-body">
            <h4 class="mt-0 m-b-15 header-title">Mensajes Recientes</h4>

            <div id="mensajes_recientes" class="inbox-widget">
               
               

            </div>
        </div>
    </div>
</div>
                               
                        </div>

                        </div><!-- container -->

                    </div> <!-- Page content Wrapper -->

                </div> <!-- content -->

                <?php include '../../layouts/footer.php'; ?>

            </div>
            <!-- End Right content here -->

        </div>
        <!-- END wrapper -->

 
<?php include '../../layouts/footerScript.php'; ?>

        <!-- Peity chart JS -->
        <script src="../../public/plugins/peity-chart/jquery.peity.min.js"></script>

        <!--C3 Chart-->
        <script src="../../public/plugins/d3/d3.min.js"></script>
        <script src="../../public/plugins/c3/c3.min.js"></script>

        <!-- KNOB JS -->
        <script src="../../public/plugins/jquery-knob/excanvas.js"></script>
        <script src="../../public/plugins/jquery-knob/jquery.knob.js"></script>

        <!-- Page specific js -->
        <script src="../../public/assets/pages/dashboard.js"></script>

        <!-- App js -->
        <script src="../../public/assets/js/app.js"></script>
        <script src="funciones_home.js"></script>
    </body>
</html>