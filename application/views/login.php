<?php 
// $this->output->delete_cache();
// $this->db->cache_on();
$web = $this->db->get('setting')->row_array();
// $this->db->cache_off(); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="<?= base_url('assets/'.$web['icon']) ?>">

  <title><?= $web['website_name'] ?> | <?= $title ?></title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url('assets/cms') ?>/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?= base_url('assets/cms') ?>/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url('assets/cms') ?>/dist/css/adminlte.min.css">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="<?= base_url('assets/cms/') ?>plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- Toastr -->
    <link rel="stylesheet" href="<?= base_url('assets/cms/') ?>plugins/toastr/toastr.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="<?= base_url('login') ?>" class="h1"><b><?= $web['website_name'] ?></b></a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <form id="form-login">
        <div class="input-group mb-3">
          <input type="text" name="username" id="username" class="form-control" placeholder="Username">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="password" id="password" class="form-control" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <!-- /.col -->
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-login btn-block">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

     <!--  <div class="social-auth-links text-center mt-2 mb-3">
        <a href="#" class="btn btn-block btn-primary">
          <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
        </a>
        <a href="#" class="btn btn-block btn-danger">
          <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
        </a>
      </div> -->
      <!-- /.social-auth-links -->

      <!--<p class="mb-1">-->
      <!--  <a href="forgot-password.html">I forgot my password</a>-->
      <!--</p>-->
      <!--<p class="mb-0">-->
      <!--  <a href="register.html" class="text-center">Register a new membership</a>-->
      <!--</p>-->
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="<?= base_url('assets/cms') ?>/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?= base_url('assets/cms') ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url('assets/cms') ?>/dist/js/adminlte.min.js"></script>
<!-- SweetAlert2 -->
<script src="<?= base_url('assets/cms/') ?>plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="<?= base_url('assets/cms/') ?>plugins/toastr/toastr.min.js"></script>
<script>

  var Toast = Swal.mixin({
       toast: true,
       position: 'top-end',
       showConfirmButton: false,
       timer: 3000
     });

  function sukses(msg){
     Toast.fire({
       icon: 'success',
       title: msg,
     })
  }
  function warning(msg){
     Toast.fire({
       icon: 'warning',
       title: msg,
     })

  }
</script>
<script>
   $(".btn-login").on('click', function(e){
    e.preventDefault('submit')
      // console.log('akak');
      var username = $('#username').val()
      var password = $('#password').val()

      if (username == '' || password == '') {
        warning('Username dan Password Belum diisi!')
      } else {
          
          $.ajax({
            url:"<?= base_url() ?>doLogin",
            type:"POST",
            data:$('#form-login').serialize(),
            dataType:"JSON",
            success:function(data)
            {
              if (data.success) {
                sukses(data.msg)
                window.setTimeout(function(){
                  window.location.href = "cms/dashboard"
                },3000)
              } else {
                warning(data.msg)
              }
            }
          })
        
      }
    })
</script>

</body>
</html>
