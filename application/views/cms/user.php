<div class="container-fluid">
  <div class="row">
    <div class="col-12">

      <div class="card card-dark">
        <div class="card-header">
          <h3 class="card-title title-card">
            Data <?= $title ?>
          </h3>
          <div class="card-tools">
            <button type="button" class="btn btn-primary btn-sm" id="btn-tambah"><span class="fa fa-plus"></span> Add Data</button>
          </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <table id="dt-menu-user" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>No.</th>
                <th width="5%">Profile</th>
                <th>Fullname</th>
                <th>Username</th>
                <th>Contact</th>
                <th>Role</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>

            </tbody>
          </table>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->
</div>

<div class="modal fade" id="modal-form">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"></h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
        </button>
      </div>
      <div class="modal-body" style="max-height: 75vh; overflow-y: auto;">
        <form id="form">
          <div class="form-group">
            <label for="fullname">Fullname</label>
            <input type="text" name="fullname" class="form-control" id="fullname" placeholder="Fullname">
            <input type="hidden" name="id_user" id="id_user" value="">
            <span class="fullname_error text-danger"></span>
          </div>
          <div class="form-group">
            <label for="nickname">Nickname</label>
            <input type="text" name="nickname" class="form-control" id="nickname" placeholder="Username">
            <span class="nickname_error text-danger"></span>
          </div>
          <div class="form-group">
            <label for="username">Username</label>
            <input type="text" name="username" class="form-control" id="username" placeholder="Username">
            <span class="username_error text-danger"></span>
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" class="form-control" id="password" placeholder="Password">
            <span class="password_error text-danger"></span>
          </div>
          <div class="form-group">
            <label for="password_conf">Confirmation Password</label>
            <input type="password" name="password_conf" class="form-control" id="password_conf" placeholder="Password">
            <span class="password_conf_error text-danger"></span>
          </div>
          <div class="form-group">
            <label for="role">Role</label>
            <select class="form-control" id="role_id" name="role_id">
              <option value="">-- Select Role --</option>
              <?php foreach ($roles as $role): ?>
                <option value="<?= $role['id_role'] ?>"><?= $role['role_name'] ?></option>                
              <?php endforeach ?>
            </select>
            <span class="role_id_error text-danger"></span>
          </div> 
          <div class="form-group">
            <label for="profile_pictures">Profile Picture <sup style="color: red;">*PNG,JPG,JPEG</sup></label>
            <div class="preview_image">
              <img id="preview_image" src="#" width="50%" height="50%">
            </div>
            <div id="show-image"></div>
            <input type="file" class="form-control" autocomplete="none" name="profile_pictures" id="profile_pictures">
            <div id="show-image">
              
            </div>
            <span class="profile_pictures_error text-danger"></span>
          </div>
          <div class="form-group">
            <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
              <input type="checkbox" class="custom-control-input" name="status" id="status" value="active">
              <label class="custom-control-label" for="status">Non Active</label>
            </div>
          </div>

        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger light" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary btn-submit">Submit</button>
      </div>
        </form>
    </div>
  </div>
</div>


<script>
  $(document).ready(function(){
      loadAdmin()
      
      // $(".dataTables_filter input").val(role_name).draw()
    })

  $("#profile_pictures").change(function(){
     bacaGambar(this);
  });

  function bacaGambar(input) {
     if (input.files && input.files[0]) {
        var reader = new FileReader();
   
        reader.onload = function (e) {
            $('.preview_image').attr("hidden", false)
            $('#preview_image').attr('src', e.target.result);
        }
   
        reader.readAsDataURL(input.files[0]);
     }
  }
  function loadAdmin()
  {
        dt = $("#dt-menu-user").DataTable({
          "responsive": true, "lengthChange": true, "autoWidth": false,
          // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
        //   "processing": true,
        // "serverSide": true,

          "processing": true,
          "serverSide": true,
          "destroy":true,
          "ajax": {
              "url":base_url+"cms/get-data-user",
              "type": "POST",
          },
          "columnDefs": [
          {
              targets : [-1,0],
              orderable: false
          },
          {
              targets : [-1,0, -2],
              class: 'text-nowrap text-center'
          }
          ],
          "order" : [],
        })

        var role_name = $("#role_name").val()
        if (role_name) {
          dt.search(role_name).draw();
        }


  }

  $("#status").change(function(){
    var status = $(this).prop('checked'); 
    if (status) {
      $(".custom-control-label").text('Active')
    }else{
      $(".custom-control-label").text('Non Active')
    }
  })


  $('#btn-tambah').click(function(){
    $('.preview_image').attr("hidden", true)
    aksi = 'tambah';
    $('#form')[0].reset()
    $('#modal-form').modal('show')
    $('.modal-title').text('Add Admin')
    $('.text-danger').empty()
    $('.is-invalid').removeClass('is-invalid')
    $('.is-valid').removeClass('is-valid')
    $(".custom-control-label").text('Non Active')
    $("#show-image").html('')
  })

  
  $('.btn-submit').click(function(e){
    e.preventDefault('submit')
    var formData = new FormData($('#form')[0]);
    $.ajax({
      url:base_url+'cms/save-user/'+aksi,
      dataType:'json',
      type:'POST',
      data: formData,
      contentType: false,
      processData: false,
      success: (response) =>{

        if (response.status) {
          sukses(response.alert);
          $('#modal-form').modal('hide')
          dt.ajax.reload()
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

  function ButtonEdit(id)
  {
    aksi = 'ubah'
    // $('#form')[0].reset()
    $('#form')[0].reset()
    $('.preview_image').attr("hidden", true)
    $('.text-danger').empty()
    $('.is-invalid').removeClass('is-invalid')
    $('.is-valid').removeClass('is-valid')
    $('#modal-form').modal('show')
    $('.modal-title').text('Edit Admin')
    $.ajax({
      url:base_url+'cms/get-data-user/'+id,
      dataType:'json',
      success: (response) => {
        $.each(response.data, function(key, value) {
          if (key == 'password') {
          }else if (key == 'profile_picture') {
            $('.preview_image').attr("hidden", false)
            $('#preview_image').attr('src', `${base_url}/uploads/profile/${value}`);
          }else if (key == 'status') {
            $('#'+key).prop('checked', value == 'Active' ? true : false )
            $(".custom-control-label").text(value)
          }else{
            $('#'+key).val(value)
          }
        })
      }
    })
  }

  function ButtonDelete(id)
  {
    Swal.fire({ 
      title: "Are you sure you want to delete data?", 
      text: "Deleted data cannot be recovered!!", 
      icon: "warning", 
      showCancelButton: !0, 
      confirmButtonColor: "#DD6B55", 
      confirmButtonText: "Yes, Deleted!!", 
      closeOnConfirm: !1 
    }).then((result) => {
      if (result.value) {
          $.ajax({
            url:base_url+'cms/delete-user/'+id,
            type:'post',
            dataType:'json',
            success: (response) => {
              sukses(response.alert);
              dt.ajax.reload()
            }
          })
      }
    })
  }

  function showImage(data){
    var image = $(data).data('image')
    $('#modal-show').modal('show')
    $("#show-profile_pictures").html(`<img src="${image}" alt="" width="100%">`)

  }
</script>