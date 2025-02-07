<!-- <style type="text/css">
    .main-nav {
        border-bottom: 1px solid #02213D !important;
    }
</style> -->
<!-- Toastr -->
<div class="sign-in-area pricing-bg pt-50 pb-70">
    <div class="container">
        <div class="row pt-45">
            <div class="col-lg-12">
                <div class="user-all-form">
                    <div class="contact-form">
                        <div class="section-title text-center">
                            <!-- <span class="span-bg">Masuk</span> -->
                            <h3>Masukkan Username dan Password</h3>
                        </div>
                        <form id="form-login">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <input type="text" name="username" id="username" class="form-control" required data-error="Please enter your Username or Email" placeholder="Username or Email">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <input class="form-control" type="password" name="password" id="password" placeholder="Password">
                                    </div>
                                </div>
                                <!-- <div class="col-lg-6 col-sm-6 form-condition">
                                    <div class="agree-label">
                                        <input type="checkbox" id="chb1">
                                        <label for="chb1">
                                            Remember Me
                                        </label>
                                    </div>
                                </div> -->
                                <div class="col-lg-12">
                                    <a class="forget" href="<?= base_url('forgot-password') ?>">Lupa Password?</a>
                                </div>
                                <div class="col-lg-12 col-md-12 text-center">
                                    <button type="submit" class="default-btn btn-login">
                                    Masuk
                                    </button>
                                </div>
                                <div class="col-12">
                                    <p class="account-desc">
                                        Belum Punya Akun?
                                        <a href="<?= base_url('register') ?>">Daftar</a>
                                    </p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
   $(".btn-login").on('click', function(e){
    $(this).html(`<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
  Loading...`).attr('disabled', true);
    e.preventDefault('submit')
      // console.log('akak');
      var username = $('#username').val()
      var password = $('#password').val()

      if (username == '' || password == '') {
        alert('Username dan Password Belum diisi!')
      $('.btn-login').html(`Masuk`).attr('disabled', false);
      } else {
          
          $.ajax({
            url:"<?= base_url() ?>doLogin",
            type:"POST",
            data:$('#form-login').serialize(),
            dataType:"JSON",
            complete:function(){
                  $('.btn-login').html(`Masuk`).attr('disabled', false);
            },
            success:function(data)
            {
              if (data.success) {
                alert(data.msg)
                  window.location.href = data.redirect
              } else {
                alert(data.msg)
              }
            }
          })
        
      }
    })
</script>
