<div class="sign-in-area pricing-bg pt-50 pb-70">
    <div class="container">
        <div class="row pt-45">
            <div class="col-lg-12">
                <div class="user-all-form">
                    <div class="contact-form">
                        <div class="section-title text-center">
                            <!-- <span class="span-bg">Masuk</span> -->
                            <h3 id="text-label">Masukkan Email Anda</h3>
                        </div>
                        <form id="form-forgot">
                            <div class="row">
                                <input type="hidden" id="type" name="type" value="email">
                                <div class="col-lg-12">
                                    <div class="form-group" id="form-email">
                                        <input type="email" name="email" id="email" class="form-control" required data-error="Please enter your Email" placeholder="Email">
                                    </div>
                                    <div id="form-otp">
                                       <div class="form-group d-flex">
                                         <input type="number" name="otp[]" class="form-control otp-input mx-2" maxlength="1">
                                         <input type="number" name="otp[]" class="form-control otp-input mx-2" maxlength="1">
                                         <input type="number" name="otp[]" class="form-control otp-input mx-2" maxlength="1">
                                         <input type="number" name="otp[]" class="form-control otp-input mx-2" maxlength="1">
                                       </div>
                                    </div>
                                    <div id="form-password">
                                        <div class="form-group">
                                            <label>Password Baru</label>
                                            <input type="password" name="password" id="password" class="form-control" required data-error="Masukkan Password Baru Anda" placeholder="Masukkan Password Baru Anda">
                                        </div>
                                        <div class="form-group">
                                            <label>Konfirmasi Password</label>
                                            <input type="password" name="confpassword" id="confpassword" class="form-control" required data-error="Masukkan Konfirmasi Password Baru Anda" placeholder="Masukkan Konfirmasi Password Baru Anda">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 text-center">
                                    <button type="submit" class="default-btn btn-send" id="btn-btn">
                                    Kirim Kode
                                    </button>
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
    $(document).ready(function(){
        $("#form-otp").attr('hidden', true);
        $("#form-password").attr('hidden', true);
        $('input[type="number"]').on('input', function() {
            if (this.value.length === this.maxLength) {
              var index = $('input[type="number"]').index(this);
              if (index === $('input[type="number"]').length - 1) {
                return;
              }
              $('input[type="number"]').eq(index + 1).focus();
            }
          });
    })
    $(".btn-send").click(function(e){
        e.preventDefault()
        var email = $("#email").val();
        var otp = $('input[name="otp"]').val();
        var formData = new FormData($('#form-forgot')[0]);
        console.log(otp)
        if (email) {
            $.ajax({
                url:`${base_url}send-code`,
                type:'post',
                dataType:'json',
                data: formData,
                contentType: false,
                processData: false,
                beforeSend:function()
                {
                    $(".btn-send").html('<span class="fa fa-spin fa-spinner"></span> Sedang Mengirim OTP').attr('disabled', true);
                },
                complete:function(){
                    $(".btn-send").html('Kirim Kode').attr('disabled', false);
                },
                success:function(response){
                    alert(response.msg)
                    if (response.type == 'email') {
                        $("#form-email").attr('hidden', false)
                        $("#form-otp").attr('hidden', true)
                        $("#form-password").attr('hidden', true)
                        $("#btn-btn").removeClass('btn-send').addClass('btn-confirmation').text('Kirim Kode').attr('disabled', false);
                        $("#text-label").text('Masukkan Email Anda');
                    }else if(response.type == 'otp'){
                        $("#form-otp").attr('hidden', false)
                        $("#form-email").attr('hidden', true)
                        $("#form-password").attr('hidden', true)
                        $("#btn-btn").removeClass('btn-send').addClass('btn-confirmation').text('Konfirmasi Kode OTP').attr('disabled', false);
                        $("#text-label").text('OTP telah dikirim');
                    }else if(response.type == 'password'){
                        $("#text-label").text('Buat Password Baru Anda');
                        $("#btn-btn").removeClass('btn-send').addClass('btn-confirmation').text('Perbarui Password').attr('disabled', false);
                        $("#form-otp").attr('hidden', true)
                        $("#form-email").attr('hidden', true)
                        $("#form-password").attr('hidden', false)
                        $(".otp-input").val('')
                    }else{
                        window.location.href=`${base_url}login`
                    }
                }
            })

        }else{
            alert('Masukkan Email Anda')
        }
    })
</script>