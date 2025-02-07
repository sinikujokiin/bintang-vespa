<?php 

  // $this->db->cache_on();
  $web = $this->db->get('setting')->row_array();
  // $this->output->cache($n);
  // $this->db->cache_off();
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= $web['website_name'] ?> || <?= $title ?></title>
  <link rel="icon" href="<?= base_url('assets/'.$web['icon']) ?>">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url('assets/cms/') ?>plugins/fontawesome-free/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?= base_url('assets/cms/') ?>plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?= base_url('assets/cms/') ?>plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?= base_url('assets/cms/') ?>plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url('assets/cms/') ?>dist/css/adminlte.min.css">
  <!-- jQuery -->
  <script src="<?= base_url('assets/cms/') ?>plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="<?= base_url('assets/cms/') ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script>
    var base_url = "<?= base_url() ?>";
  </script>
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="<?= base_url('assets/cms/') ?>plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="<?= base_url('assets/cms/') ?>plugins/toastr/toastr.min.css">
  <script src="<?= base_url('assets/cms/') ?>dist/js/adminlte.min.js"></script>
  <!-- select2 -->
  <link rel="stylesheet" href="<?= base_url('assets/cms') ?>/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="<?= base_url('assets/cms') ?>/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <script src="<?= base_url('assets/cms') ?>/plugins/select2/js/select2.full.min.js"></script>
  
</head>
<body class="sidebar-mini layout-fixed layout-navbar-fixed control-sidebar-slide-open ">
<div class="wrapper">
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="<?= base_url('assets/'.$web['logo']) ?>" alt="Logo <?= $web['website_name'] ?>" height="60" width="60">
  </div>

  <?php $userData = $this->session->userdata('userData'); ?>
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-light nav-compact">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <!-- <li class="nav-item d-none d-sm-inline-block">
        <a href="<?= base_url('assets/cms/') ?>index3.html" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li> -->
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <!--<li class="nav-item">-->
      <!--  <a class="nav-link" data-widget="navbar-search" href="#" role="button">-->
      <!--    <i class="fas fa-search"></i>-->
      <!--  </a>-->
      <!--  <div class="navbar-search-block">-->
      <!--    <form class="form-inline">-->
      <!--      <div class="input-group input-group-sm">-->
      <!--        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">-->
      <!--        <div class="input-group-append">-->
      <!--          <button class="btn btn-navbar" type="submit">-->
      <!--            <i class="fas fa-search"></i>-->
      <!--          </button>-->
      <!--          <button class="btn btn-navbar" type="button" data-widget="navbar-search">-->
      <!--            <i class="fas fa-times"></i>-->
      <!--          </button>-->
      <!--        </div>-->
      <!--      </div>-->
      <!--    </form>-->
      <!--  </div>-->
      <!--</li>-->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <?= $userData['fullname'] ?> <span class="fa fa-user-tie"></span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header"><?= $userData['username'] ?></span>
          <div class="dropdown-divider"></div>
          <a href="<?= base_url('cms/data-profile') ?>" class="dropdown-item">
            <i class="fas fa-user mr-2"></i> Profile
            <!-- <span class="float-right text-muted text-sm"></span> -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="<?= base_url('logout') ?>" class="dropdown-item dropdown-footer">Logout</a>
        </div>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-light-dark elevation-4">
    <!-- Brand Logo -->
    <a href="<?= base_url('cms/dashboard') ?>" class="brand-link">
      <img src="<?= base_url('assets/'.$web['icon']) ?>" alt="Logo <?= $web['website_name'] ?>" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light"><?= $web['website_name'] ?></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?= base_url('uploads/profile/'.$userData['profile_picture']) ?>" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="<?= base_url('cms/data-profile') ?>" class="d-block"><?= $userData['fullname'] ?></a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <!--<div class="form-inline">-->
      <!--  <div class="input-group" data-widget="sidebar-search">-->
      <!--    <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">-->
      <!--    <div class="input-group-append">-->
      <!--      <button class="btn btn-sidebar">-->
      <!--        <i class="fas fa-search fa-fw"></i>-->
      <!--      </button>-->
      <!--    </div>-->
      <!--  </div>-->
      <!--</div>-->

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column nav-compact nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
          <?php 
          $labels = getMenu(0,'cms');

          foreach ($labels as $label): 
            $parents = getMenu($label['id_menu'], 'cms');
          ?>
            <?php if ($label['have_link'] == 'yes'): ?>
              <?php 
                $segs = $this->uri->segment_array();
                $totalSegs = count($segs);
                $link = $this->uri->segment(1)."/".$this->uri->segment(2);
                // for ($i = 1; $i <= $totalSegs; $i++) {
                //     if ($segs[$i] === $segs[$totalSegs]) {
                //         $link .= $segs[$i];
                //     } else {
                //         $link .= $segs[$i] . "/";
                //     }
                // }

                $active_label = $link == $label['menu_url'] ? 'active' : "";

               ?>
              <li class="nav-item ">
                <a href="<?= base_url().$label['menu_url'] ?>" class="nav-link <?= $active_label ?>">
                  <i class="nav-icon fas fa-<?= $label['icon'] ?>"></i>

                  <p>
                    <?= $label['menu_title'] ?>
                  </p>
                </a>
              </li>
            <?php else: ?>
              <li class="nav-header"><?= $label['menu_title'] ?></li>
            <?php endif ?>

            <?php foreach ($parents as $parent): ?>
              <?php 
                $segs = $this->uri->segment_array();
                $totalSegs = count($segs);
                $link = $this->uri->segment(1)."/".$this->uri->segment(2);
                // for ($i = 1; $i <= $totalSegs; $i++) {
                //     if ($segs[$i] === $segs[$totalSegs]) {
                //         $link .= $segs[$i];
                //     } else {
                //         $link .= $segs[$i] . "/";
                //     }
                // }

                $active = $link == $parent['menu_url'] ? 'active' : "";

               ?>
              <?php if ($parent['have_link'] == 'yes'): ?>
                <li class="nav-item ">
                  <a href="<?= base_url().$parent['menu_url'] ?>" class="nav-link <?= $active ?>">
                    <i class="nav-icon fas fa-<?= $parent['icon'] ?>"></i>

                    <p>
                      <?= $parent['menu_title'] ?>
                    </p>
                  </a>
                </li>
              <?php else: $childs = getMenu($parent['id_menu'], 'cms');
                $url = $this->db->select('menu_parent')->get_where('menus', ['menu_url' => $link])->row_array();
                // var_dump($link);
                $parent_id = isset($url['menu_parent']) ? $url['menu_parent'] : "" ;
                $active = $parent['id_menu'] == $parent_id ? "active" : ""; 
                $open = $parent['id_menu'] == $parent_id ? "menu-open" : ""; 
                ?>

                <li class="nav-item <?= $open ?>">
                  <a href="#" class="nav-link <?= $active ?>">
                    <i class="nav-icon fas fa-<?= $parent['icon'] ?>"></i>
                    <p>
                      <?= $parent['menu_title'] ?>
                      <i class="right fas fa-angle-left"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">

                    <?php foreach ($childs as $child): $active = $link == $child['menu_url'] ? "active" : "" ;?>  
                        <li class="nav-item">
                          <a href="<?= base_url().$child['menu_url'] ?>" class="nav-link <?= $active ?>">
                            <i class="far fa-circle nav-icon"></i>
                            <p><?= $child['menu_title'] ?></p>
                          </a>
                        </li>
                    <?php endforeach ?>

                  </ul>
                </li>


              <?php endif ?>

            <?php endforeach ?>



          <?php endforeach ?>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><?= $title ?></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active"><?= $title ?></li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <?= $contents ?>
      
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <!-- <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.2.0-rc
    </div>
    <strong>Copyright &copy; <?= date("Y") ?> 888 Living Template By <a href="https://adminlte.io">AdminLTE.io V 3.2.0-rc</a>.</strong> All rights reserved.
  </footer> -->

</div>
<!-- ./wrapper -->


<!-- DataTables  & Plugins -->
<script src="<?= base_url('assets/cms/') ?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url('assets/cms/') ?>plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url('assets/cms/') ?>plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url('assets/cms/') ?>plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?= base_url('assets/cms/') ?>plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?= base_url('assets/cms/') ?>plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?= base_url('assets/cms/') ?>plugins/jszip/jszip.min.js"></script>
<script src="<?= base_url('assets/cms/') ?>plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?= base_url('assets/cms/') ?>plugins/pdfmake/vfs_fonts.js"></script>
<script src="<?= base_url('assets/cms/') ?>plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?= base_url('assets/cms/') ?>plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?= base_url('assets/cms/') ?>plugins/datatables-buttons/js/buttons.colVis.min.js"></script>


<!-- SweetAlert2 -->
<script src="<?= base_url('assets/cms/') ?>plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="<?= base_url('assets/cms/') ?>plugins/toastr/toastr.min.js"></script>
<!-- AdminLTE for demo purposes -->
<!-- <script src="<?= base_url('assets/cms/') ?>dist/js/demo.js"></script> -->
<!-- Page specific script -->
<!-- <script src="https://js.pusher.com/7.0/pusher.min.js"></script> -->
<script>
  $(".select2").select2({
    theme: 'bootstrap4',
    width:'100%'
  })
  // Enable pusher logging - don't include this in production
  // Pusher.logToConsole = false;

  // var pusher = new Pusher('675a4d76165ab66bc57b', {
  //   cluster: 'ap1'
  // });

  // var channel = pusher.subscribe('my-channel');
  // channel.bind('my-event', function(data) {
      
  //     getNotifChat()

  //     console.log(data);
  //     waiting = $("#waiting").val()
  //   if (waiting == "false") {
  //     getDirectChat()

  //   }
  //   loadListChat()
  // });
</script>

<script>

  var Toast = Swal.mixin({
       toast: true,
       position: 'top-end',
       showConfirmButton: false,
       timer: 3000
     });

  function sukses(msg){
     Swal.fire({
       icon: 'success',
       title: msg
     })

  }

  function warning(msg){
     Swal.fire({
       icon: 'warning',
       title: msg
     })

  }

  function info(msg = 'Please Wait ...'){
     Swal.fire({
       icon: 'info',
       title: msg,
       showConfirmButton:false,
       timer:500
     })

  }
  $(document).ready(function(){
    // getNotifChat()
    var icon = $("ul li a.active i").attr("class").replace("nav-icon", '')
    icon = `<span class="${icon}"></span> `
    $(".title-card").prepend(icon);

  })


  // function getNotifChat()
  // {
  //   $.ajax({
  //     url:base_url+"get-notification-chat",
  //     type:"get",
  //     dataType:"json",
  //     success:function(response){
  //           $(".jml_unread").text(response.jml_unread);
  //           $(".list-unread").html(response.lisChat)
  //     }
  //   })
  // }
  
  $.ajaxSetup({
      beforeSend:function(){
          $(".btn-submit").attr("disabled", true).html(`<span class="fa fa-spin fa-spinner"></span>`)
      },
      complete:function(){
          $(".btn-submit").attr("disabled", false).html(`Submit`)
          $("#btn-submit").attr("disabled", false).html(`Submit`)
          $("#btn-draft").attr("disabled", false).html(`Save As Draft`)
      }
  })
</script>
</body>
</html>
