
<div class="container-fluid">
  <div class="row">
    <div class="col-md-3">

      <!-- Profile Image -->
      <div class="card card-primary card-outline">
        <div class="card-body box-profile">
          <div class="text-center">
            <img class="profile-user-img img-fluid img-circle"
                 src="<?= base_url('uploads/profile/').$data['profile_picture'] ?>"
                 alt="User profile picture">
                 <div class="ribbon-wrapper ribbon-sm" style="cursor: pointer;">
                   <div class="ribbon bg-warning text-sm">
                                              <!-- <a data-toggle="modal" data-target="#crop_modal" class="btn btn-icon btn-warning">Upload Foto</a> -->
                    <a title="Update Profle" data-toggle="modal" data-target="#crop_modal"><span class="fa fa-edit"></span></a>
                   </div>
                 </div>
          </div>

          <h3 class="profile-username text-center"><?= $data['fullname'] ?></h3>

          <p class="text-muted text-center"><?= $data['username'] ?></p>

          <ul class="list-group list-group-unbordered mb-3">
            <li class="list-group-item">
              <b>Email</b> <a class="float-right"><?= $data['email'] ?></a>
            </li>
            <li class="list-group-item">
              <b>Phone</b> <a class="float-right"><?= $data['phone'] ?></a>
            </li>
          </ul>

          <!-- <a href="#" class="btn btn-primary btn-block"><b>Simpan</b></a> -->
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>
    <!-- /.col -->
    <div class="col-md-9">
      <div class="card card-dark">
        <div class="card-header p-2">
          <ul class="nav nav-pills">
            <li class="nav-item"><a class="nav-link active" href="#profile" data-toggle="tab">Profile</a></li>
            <li class="nav-item"><a class="nav-link" href="#account" data-toggle="tab">Acccount</a></li>
            <!-- <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Settings</a></li> -->
          </ul>
        </div><!-- /.card-header -->
        <div class="card-body">
          <div class="tab-content">
            <div class="active tab-pane" id="profile">
              <form id="form-profile">
                <div class="form-group">
                  <label for="">Fullname</label>
                  <input type="text" name="fullname" id="fullname"value="<?= $data['fullname'] ?>" class="form-control">
                </div>
                <div class="form-group">
                  <label for="">Nickname</label>
                  <input type="text" name="nickname" id="nickname"value="<?= $data['nickname'] ?>" class="form-control">
                </div>
                <div class="form-group">
                  <label for="">Email</label>
                  <input type="email" name="email" id="email"value="<?= $data['email'] ?>" class="form-control">
                </div>
                <div class="form-group">
                  <label for="">Phone</label>
                  <input type="text" name="phone" id="phone"value="<?= $data['phone'] ?>" class="form-control">
                </div>
                <div class="form-group text-right">
                  <button type="submit" class="btn btn-primary btn-save-profile">Save</button>
                </div>
              </form>
            </div>
            <!-- /.tab-pane -->
            <div class="tab-pane" id="account">
              <form id="form-akun">
                <div class="form-group">
                  <label for="">Username</label>
                  <input type="text" name="username" id="username" readonly value="<?= $data['username'] ?>" class="form-control">
                </div>
                <div class="form-group">
                  <label for="">Password Old</label>
                  <input type="password" name="old_password" id="old_password" class="form-control">
                </div>
                <div class="form-group">
                  <label for="">Password New</label>
                  <input type="password" name="new_password" id="new_password" class="form-control">
                </div>
                <div class="form-group">
                  <label for="">Re Password</label>
                  <input type="password" name="re_password" id="re_password" class="form-control">
                </div>
                <div class="form-group text-right">
                  <button type="submit" class="btn btn-primary btn-save-akun">Save</button>
                </div>
              </form>
            </div>
            <!-- /.tab-pane -->
          </div>
          <!-- /.tab-content -->
        </div><!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->
</div><!-- /.container-fluid -->

<div id="crop_modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title"><i class="icon-upload"></i>Form Upload</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>

            <div class="modal-body with-padding">

                <button type="button" class="btn btn-primary" onclick="document.getElementById('profile_pictures').click();">Choose Picture</button>
                <br><br>
                
                <form id="form-profile-picture">
                    <div class="col-md-12">
                        <input type="hidden" name="id_user" id="id_user" class="form-control" value="<?= $this->session->userdata('userData')['id_user'] ?>">
                        <input type="file" id="profile_pictures" name="profile_pictures" style="display: none" class="form-control" accept="image/*">
                    </div>
                    <!-- Crop and preview -->   
                    <div class="col-md-12">
                        <div class="row">
                          <div class="preview_image" hidden>
                            <img id="preview_image" src="#" width="100%">
                          </div>
                        </div>
                    </div> 
                    <div class="avatar-upload">
                        <input type="hidden" class="avatar-data" name="avatar_data">
                    </div>                                                 

            </div>

            <div class="modal-footer">
                <button class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="save">Save</button>
            </div>
                </form>
        </div>
    </div>
</div>

<script>
  $("#profile_pictures").change(function(){
     bacaGambar(this);
  });

  function bacaGambar(input) {
     if (input.files && input.files[0]) {
        var reader = new FileReader();
        
        reader.onload = function (e) {
        console.log(e.target)
            $('.preview_image').attr("hidden", false)
            $('#preview_image').attr('src', e.target.result);
        }
   
        reader.readAsDataURL(input.files[0]);
     }
  }

  $("#save").click(function(){
        var formData = new FormData($('#form-profile-picture')[0]);
        formData.append("id_user", $("#id_user").val())
        $.ajax({
          url:base_url+'cms/save-profile-picture',
          dataType:'json',
          type:'POST',
          data: formData,
          contentType: false,
          processData: false,
          success: (response) =>{

            if (response.status) {
              sukses('Berhasil Mengubah Foto');
              $(".swal2-confirm").click(function(){
                window.location.href = ``
              })
            }else{
              var error = response.error
              $.each(error, function(key, value) {

                $('.' + key + '_error').html(value.length > 0 ? `<i class="fa fa-exclamation"> ${value}</i>` : value)
                $('#' + key).removeClass('is-invalid').addClass(value.length > 0 ? 'is-invalid' : 'is-valid').find('.text-danger').remove()
              })
            }

          }
        })
  })

  $(".btn-save-profile").click(function(e){
    e.preventDefault("submit");

    $.ajax({
      url:`${base_url}cms/update-profile`,
      type:"POST",
      dataType:"JSON",
      data:$('#form-profile').serialize(),
      success:function(response){
        sukses(response.msg)
      }
    })

  })

  $(".btn-save-akun").click(function(e){
    e.preventDefault("submit");

    $.ajax({
      url:`${base_url}cms/update-password`,
      type:"POST",
      dataType:"JSON",
      data:$('#form-akun').serialize(),
      success:function(response){
        if (response.status) {
          sukses(response.msg)
        }else{
          warning(response.msg)
        }
      }
    })

  })
</script>