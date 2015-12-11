<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Material Admin</title>

		<!-- BEGIN META -->
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="keywords" content="your,keywords">
		<meta name="description" content="Short explanation about this website">

		<!-- BEGIN STYLESHEETS -->
<!--		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,300,400,600,700,800' rel='stylesheet' type='text/css'/>-->
		<link type="text/css" rel="stylesheet" href="<?php echo site_url('/css/theme-default/bootstrap.css'); ?>" />
		<link type="text/css" rel="stylesheet" href="<?php echo site_url('css/theme-default/materialadmin.css'); ?>" />
		<link type="text/css" rel="stylesheet" href="<?php echo site_url('css/theme-default/font-awesome.min.css'); ?>" /> <!--Font Awesome Icon Font-->
		<link type="text/css" rel="stylesheet" href="<?php echo site_url('css/theme-default/material-design-iconic-font.min.css'); ?>" /> <!--Material Design Iconic Font-->
                <link type="text/css" rel="stylesheet" href="<?php echo site_url('css/theme-default/libs/rickshaw/rickshaw.css'); ?>" />
		<link type="text/css" rel="stylesheet" href="<?php echo site_url('css/theme-default/libs/morris/morris.core.css'); ?>" />
                <link type="text/css" rel="stylesheet" href="<?php echo site_url('css/theme-default/libs/morris/morris.core.css'); ?>">
                <link type="text/css" rel="stylesheet" href="<?php echo site_url('css/theme-default/libs/summernote/summernote.css'); ?>">
                <link type="text/css" rel="stylesheet" href="<?php echo site_url('css/theme-default/libs/bootstrap-switch/bootstrap-switch.css'); ?>">
                <link type="text/css" rel="stylesheet" href="<?php echo site_url('css/main.css'); ?>">
                
                <link type="text/css" rel="stylesheet" href="<?php echo site_url('css/theme-default/libs/DataTables/jquery.dataTables.css'); ?>">
		<link type="text/css" rel="stylesheet" href="<?php echo site_url('css/theme-default/libs/DataTables/extensions/dataTables.colVis.css'); ?>">
		<link type="text/css" rel="stylesheet" href="<?php echo site_url('css/theme-default/libs/DataTables/extensions/dataTables.tableTools.css'); ?>">

		<!-- Additional CSS includes -->
                
                <!-- BEGIN JAVASCRIPT -->
                <script src="<?php echo site_url('js/libs/ckeditor/ckeditor.js'); ?>"></script>
                
                <script src="<?php echo site_url('js/libs/jquery/jquery-1.11.2.min.js'); ?>"></script>
                <script src="<?php echo site_url('js/libs/jquery/jquery-migrate-1.2.1.min.js'); ?>"></script>
                <script src="<?php echo site_url('js/libs/bootstrap/bootstrap.min.js'); ?>"></script>
                <script src="<?php echo site_url('js/libs/spin.js/spin.min.js'); ?>"></script>
                <script src="<?php echo site_url('js/libs/autosize/jquery.autosize.min.js'); ?>"></script>
                <script src="<?php echo site_url('js/libs/moment/moment.min.js'); ?>"></script>
                <script src="<?php echo site_url('js/libs/flot/jquery.flot.min.js'); ?>"></script>
                <script src="<?php echo site_url('js/libs/flot/jquery.flot.time.min.js'); ?>"></script>
                <script src="<?php echo site_url('js/libs/flot/jquery.flot.resize.min.js'); ?>"></script>
                <script src="<?php echo site_url('js/libs/flot/jquery.flot.orderBars.js'); ?>"></script>
                <script src="<?php echo site_url('js/libs/flot/jquery.flot.pie.js'); ?>"></script>
                <script src="<?php echo site_url('js/libs/flot/curvedLines.js'); ?>"></script>
                <script src="<?php echo site_url('js/libs/jquery-knob/jquery.knob.min.js'); ?>"></script>
                <script src="<?php echo site_url('js/libs/sparkline/jquery.sparkline.min.js'); ?>"></script>
                <script src="<?php echo site_url('js/libs/nanoscroller/jquery.nanoscroller.min.js'); ?>"></script>
                <script src="<?php echo site_url('js/libs/d3/d3.min.js'); ?>"></script>
                <script src="<?php echo site_url('js/libs/d3/d3.v3.js'); ?>"></script>
                <script src="<?php echo site_url('js/libs/rickshaw/rickshaw.min.js'); ?>"></script>
                <script src="<?php echo site_url('js/core/source/App.js'); ?>"></script>
                <script src="<?php echo site_url('js/core/source/AppNavigation.js'); ?>"></script>
                <script src="<?php echo site_url('js/core/source/AppOffcanvas.js'); ?>"></script>
                <script src="<?php echo site_url('js/core/source/AppCard.js'); ?>"></script>
                <script src="<?php echo site_url('js/core/source/AppForm.js'); ?>"></script>
                <script src="<?php echo site_url('js/core/source/AppNavSearch.js'); ?>"></script>
                <script src="<?php echo site_url('js/core/source/AppVendor.js'); ?>"></script>
                <script src="<?php echo site_url('js/libs/summernote/summernote.min.js'); ?>"></script>
                <script src="<?php echo site_url('js/libs/bootstrap-switch/bootstrap-switch.js'); ?>"></script>
                <script src="<?php echo site_url('js/libs/bootpag/jquery.bootpag.min.js'); ?>"></script>
                <script src="<?php echo site_url('js/ejs_production.js'); ?>"></script>
                <script src="<?php echo site_url('js/main.js'); ?>"></script>

<!--                <script src="<?php echo site_url('js/libs/DataTables/jquery.dataTables.min.js'); ?>"></script>
                <script src="<?php echo site_url('js/libs/DataTables/extensions/ColVis/js/dataTables.colVis.min.js'); ?>"></script>
                <script src="<?php echo site_url('js/libs/DataTables/extensions/TableTools/js/dataTables.tableTools.min.js'); ?>"></script>
                <script src="<?php echo site_url('js/core/demo/Demo.js'); ?>"></script>
                <script src="<?php echo site_url('js/core/demo/DemoTableDynamic.js'); ?>"></script>-->
                <!-- END JAVASCRIPT -->
		
		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		<script type="text/javascript" src="<?php echo site_url('js/libs/utils/html5shiv.js'); ?>"></script>
		<script type="text/javascript" src="<?php echo site_url('js/libs/utils/respond.min.js'); ?>"></script>
		<![endif]-->
	</head>
	<body class="menubar-hoverable header-fixed">
            <header id="header">
                <?php if($header) echo $header;?>
            </header>           

            <div id="base">
		<!-- BEGIN OFFCANVAS LEFT -->
                <div class="offcanvas">
                </div><!--end .offcanvas-->
                <!-- END OFFCANVAS LEFT -->

		<div id="content">
                    <section>
                        <div class="section-body">
                            <div class="row">
                                <?php if($content) echo $content;?>
                            </div>
                        </div>
                    </section>
		</div>
                <div id="menubar" class="menubar-inverse">
                    <?php if($menubar) echo $menubar;?>
                </div>
                <div class="offcanvas">
                   <?php if($offcanvas) echo $offcanvas;?> 
                </div>
            </div>
            

	</body>
</html>