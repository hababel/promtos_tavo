    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script>

    <script src="<?php echo URL_PATH . PATH_ASSET; ?>jquery/jquery-3.6.3.min.js"></script>


    <script src="<?php echo URL_PATH . PATH_ASSET; ?>bootstrap-5.3.0-alpha1-dist/js/bootstrap.bundle.min.js"></script>
    <!--  -->

    <script src="<?php echo URL_PATH . PATH_ASSET; ?>js/sidebars.js"></script>
    <script src="<?php echo URL_PATH . PATH_ASSET; ?>js/dashboard.js"></script>
    <script src="<?php echo URL_PATH . PATH_ASSET; ?>js/general.js"></script>


    <script src="<?php echo URL_PATH . PATH_ASSET; ?>DataTables/datatables.js"></script>
    <script src="<?php echo URL_PATH . PATH_ASSET; ?>DataTables/Responsive-2.4.0/js/dataTables.responsive.js"></script>
    <script src="<?php echo URL_PATH . PATH_ASSET; ?>DataTables/Buttons-2.3.3/js/buttons.bootstrap.js"></script>

    <!-- Pluugin summernote -->
    <script src="<?php echo URL_PATH . PATH_ASSET; ?>summernote-0.9.0-dist/summernote-bs5.js"></script>
    <script src="<?php echo URL_PATH . PATH_ASSET; ?>summernote-0.9.0-dist/lang/summernote-es-ES.js"></script>

    <!-- Plugin para Select2 -->
    <script src="<?php echo URL_PATH . PATH_ASSET; ?>select2-4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- Plugin moment -->
    <script src="<?php echo URL_PATH . PATH_ASSET; ?>moment-2.30.1/moment.min.js"></script>
    <script src="<?php echo URL_PATH . PATH_ASSET; ?>moment-2.30.1/es.min.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">



    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script> -->
    <?php
		$controller = explode("Controller", get_class());
		if ($controller[0] == "Servicios" || $controller[0] == "Agenda") {
		?>
    	<script src="<?php echo URL_PATH . PATH_ASSET; ?>fullcalendar-scheduler-6.1.15/dist/index.global.js"></script>
    	<script src="<?php echo URL_PATH . PATH_ASSET; ?>fullcalendar-scheduler-6.1.15/locales/es.global.js"></script>
    <?php
		}
		?>

    <?php if (isset($carga_function)) { ?>
    	<script src="<?php echo URL_PATH . PATH_ASSET; ?>js/<?= $carga_function; ?>"></script>
    <?php } ?>