<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?=ucwords(str_replace("-"," ",$this->uri->segment(2)))?> | Admin Page</title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- Bootstrap 3.3.7 -->
	<link rel="stylesheet" href="<?=base_url(); ?>assets/AdminLTE/bower_components/bootstrap/dist/css/bootstrap.min.css">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="<?=base_url(); ?>assets/AdminLTE/bower_components/font-awesome/css/font-awesome.min.css">
	<!-- Ionicons -->
	<link rel="stylesheet" href="<?=base_url(); ?>assets/AdminLTE/bower_components/Ionicons/css/ionicons.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="<?=base_url(); ?>assets/AdminLTE/dist/css/AdminLTE.min.css">
	<!-- AdminLTE Skins. Choose a skin from the css/skins
		folder instead of downloading all of them to reduce the load. -->
	<link rel="stylesheet" href="<?=base_url(); ?>assets/AdminLTE/dist/css/skins/_all-skins.min.css">
	<link rel="stylesheet" href="<?=base_url('assets/css/dashboard-style.css'); ?>"/>

	<link rel="stylesheet" href="<?=base_url('assets/css/magnific-popup.css'); ?>">
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

	<!-- Google Font -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
	<link href="<?=base_url('assets/images/icon.png');?>" rel="shortcut icon" type="text/css">
	<!-- jQuery 3 -->
	<script src="<?=base_url(); ?>assets/AdminLTE/bower_components/jquery/dist/jquery.min.js"></script>
</head>
<body class="hold-transition skin-blue sidebar-mini">
  <!-- Site wrapper -->
  <div class="wrapper">

    <header class="main-header">
      <!-- Logo -->
      <a href="<?=base_url(); ?>admin/dashboard" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>A</b>LT</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>Admin</b>LTE</span>
      </a>
      <!-- Header Navbar: style can be found in header.less -->
      <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </a>

        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            
            <!-- User Account: style can be found in dropdown.less -->
            <li class="dropdown user user-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <!-- <img src="<?=base_url('assets/images/').$admin[0]['foto']; ?>" class="user-image" alt="User Image"> -->
                <!-- <span class="hidden-xs"><?=ucwords($admin[0]['username'])?></span> -->
              </a>
              <ul class="dropdown-menu">
                <!-- User image -->
                <li class="user-header">
                  <!-- <img src="<?=base_url('assets/images/').$admin[0]['foto']; ?>" class="img-circle" alt="User Image"> -->

                  <p>
                    <!-- <?=ucwords($admin[0]['username'])?> - Admin -->
                  </p>
                </li>
                <!-- Menu Footer-->
                <li class="user-footer">
                  <div class="pull-left">
                    <a href="<?=base_url('admin/profil')?>" class="btn btn-default btn-flat">Profile</a>
                  </div>
                  <div class="pull-right">
                    <a href="<?=base_url('dataproccess/logout')?>" class="btn btn-default btn-flat">Sign out</a>
                  </div>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </nav>
    </header>

    <!-- =============================================== -->

    <!-- Left side column. contains the sidebar -->
    <aside class="main-sidebar">
      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
          <div class="pull-left image">
            <!-- <img src="<?=base_url('assets/images/').$admin[0]['foto']; ?>" class="img-circle" alt="User Image"> -->
          </div>
          <div class="pull-left info">
            <p><?=ucwords($admin[0]['username'])?></p>
            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
          </div>
        </div>
        <!-- search form -->
        <!-- <form action="#" method="get" class="sidebar-form">
          <div class="input-group">
            <input type="text" name="q" class="form-control" placeholder="Search...">
            <span class="input-group-btn">
                  <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                  </button>
                </span>
          </div>
        </form> -->
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
          <li class="header">MAIN NAVIGATION</li>
          
          <li>
            <a href="<?=base_url()?>admin/dashboard">
              <i class="fa fa-home"></i> <span>Beranda</span>
            </a>
          </li>

          <li>
            <a href="<?=base_url()?>admin/halaman-depan">
              <i class="fa fa-calculator"></i> <span>Halaman Depan</span>
            </a>
          </li>

          <li>
            <a href="<?=base_url()?>admin/daftar-mobil">
              <i class="fa fa-car"></i> <span>Mobil</span>
            </a>
          </li>

          <li >
            <a href="<?=base_url()?>admin/paket-kredit">
              <i class="fa fa-credit-card"></i> <span>Paket Kredit</span>
            </a>
          </li>
          
          <!-- <li>
            <a href="<?=base_url()?>admin/simulasi-kredit">
              <i class="fa fa-usd"></i> <span>Simulasi Kredit</span>
              <span id="count-simulasi">
                <?php
                  if($countSimulasi>0){
                    echo "<span class='pull-right-container'>
                          <small class='label pull-right bg-green'>".$countSimulasi."</small>
                        </span>";
                  }
                ?>
              </span>
            </a>
          </li>
          
          <li>
            <a href="<?=base_url()?>admin/test-drive">
              <i class="fa fa-dashboard"></i> <span>Permintaan Test Drive</span>
              <span id="count-test-drive">
                <?php
                  if($countTestDrive>0){
                    echo "<span class='pull-right-container'>
                          <small class='label pull-right bg-green'>".$countTestDrive."</small>
                        </span>";
                  }
                ?>
              </span>
            </a>
          </li> -->
         
          <li>
            <a href="<?=base_url()?>admin/daftar-kontak">
              <i class="fa fa-address-card"></i> <span>Daftar Kontak</span>
            </a>
          </li>
          
          <!-- <li>
            <a href="<?=base_url()?>admin/inbox">
              <i class="fa fa-envelope"></i> <span>Pesan Masuk</span>
              <span id="count-inbox">
                <?php
                  if($countInbox>0){
                    echo "<span class='pull-right-container'>
                          <small class='label pull-right bg-green'>".$countInbox."</small>
                        </span>";
                  }
                ?>
              </span>
            </a>
          </li> -->

          <!-- <li>
            <a href="<?=base_url()?>admin/galeri">
              <i class="fa fa-picture-o"></i> <span>Galeri</span>
            </a>
          </li> -->

          <li>
            <a href="<?=base_url()?>admin/testimoni">
              <i class="fa fa-thumbs-up"></i> <span>Testimoni</span>
            </a>
          </li>
          
          <li>
            <a href="<?=base_url()?>admin/promo">
              <i class="fa fa-cart-plus"></i> <span>Promo</span>
            </a>
          </li>
          
          <li>
            <a href="<?=base_url()?>admin/artikel">
              <i class="fa fa-book"></i> <span>Artikel</span>
            </a>
          </li>

         
        </ul>
      </section>
      <!-- /.sidebar -->
    </aside>

    <!-- =============================================== -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          <!-- <?=ucwords(str_replace("-"," ",$this->uri->segment(2)))?> -->
          <!-- <small>it all starts here</small> -->
        </h1>
        <!-- <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
          <li><a href="#">Examples</a></li>
          <li class="active">Blank page</li>
        </ol> -->
      </section>

      <!-- Main content -->
      <section class="content">

        <!-- Default box -->
        <?=$content?>
        <!-- /.box -->

      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <footer class="main-footer">
      <div class="pull-right hidden-xs">
        <b>Version</b> 2.4.0
      </div>
      <strong>Copyright &copy; 2018 </strong>
    </footer>

    <!-- Control Sidebar -->
    <!-- /.control-sidebar -->
    <!-- Add the sidebar's background. This div must be placed
        immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
  </div>
  <!-- ./wrapper -->

  <!-- Bootstrap 3.3.7 -->
  <script src="<?=base_url(); ?>assets/AdminLTE/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  <!-- SlimScroll -->
  <script src="<?=base_url(); ?>assets/AdminLTE/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
  <!-- FastClick -->
  <script src="<?=base_url(); ?>assets/AdminLTE/bower_components/fastclick/lib/fastclick.js"></script>
  <!-- AdminLTE App -->
  <script src="<?=base_url(); ?>assets/AdminLTE/dist/js/adminlte.min.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="<?=base_url(); ?>assets/AdminLTE/dist/js/demo.js"></script>
  <script>
    $(document).ready(function () {
      $('.sidebar-menu').tree()
    })
  </script>
</body>
</html>