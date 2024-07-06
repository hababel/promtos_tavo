    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script>

    <script src="<?php echo URL_PATH; ?>app/assets/jquery/jquery-3.6.3.min.js"></script>

    <script src="<?php echo URL_PATH; ?>app/assets/bootstrap-5.3.0-alpha1-dist/js/bootstrap.bundle.min.js"></script>

    <script src="<?php echo URL_PATH; ?>app/assets/js/sidebars.js"></script>
    <script src="<?php echo URL_PATH; ?>app/assets/js/dashboard.js"></script>
    <script src="<?php echo URL_PATH; ?>app/assets/js/general.js"></script>
		<?php if (isset($carga_function)){ ?>
			<script src="<?php echo URL_PATH; ?>app/assets/js/<?= $carga_function; ?>"></script>
		<?php } ?>

    <script src="<?php echo URL_PATH; ?>app/assets/DataTables/datatables.js"></script>
    <script src="<?php echo URL_PATH; ?>app/assets/DataTables/Responsive-2.4.0/js/dataTables.responsive.js"></script>
    <script src="<?php echo URL_PATH; ?>app/assets/DataTables/Buttons-2.3.3/js/buttons.bootstrap.js"></script>

    <!-- Plugin para DataTable -->
    <script src="<?php echo URL_PATH; ?>app/assets/select2-4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script> -->
    <?php
    $controller = explode("Controller", get_class());
    if ($controller[0] == "Servicios") {
    ?>
        <script src="<?php echo URL_PATH; ?>app/assets/fullcalendar-6.1.9/dist/index.global.js"></script>
        <script src="<?php echo URL_PATH; ?>app/assets/fullcalendar-6.1.9/packages/core/index.global.js"></script>
        <script src="<?php echo URL_PATH; ?>app/assets/fullcalendar-6.1.9/packages/core/locales/es.global.js"></script>
    <?php
    }
    ?>
    <!-- <script src="<?php echo URL_PATH; ?>app/assets/DataTables/es-CO.json"></script> -->