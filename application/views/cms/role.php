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
          <table id="dt-menu-role" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>No.</th>
                <th>Role Name</th>
                <th>Description Role</th>
                <th>Created At</th>
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
            <label for="role_name">Role Name</label>
            <input type="text" name="role_name" class="form-control" id="role_name" placeholder="Role Name">
            <input type="hidden" name="id_role" id="id_role" value="">
            <span class="role_name_error text-danger"></span>
          </div>
          <div class="form-group" id="show-link">
            <label for="description_role">Description</label>
            <textarea name="description_role" id="description_role" class="form-control"></textarea>
              <span class="description_role_error text-danger"></span>
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


<div class="modal fade" id="modal-akses">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Hak Akses</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
        </button>
      </div>
    <div class="modal-body" style="max-height: 65vh; overflow-y: auto;">
        <form id="form-akses">
          <input type="hidden" id="id_role" name="id_role">
          <label>
              <input type="checkbox" id="select_all"> 
              <span>Select All</span>
          </label>
          <hr size="1">
          <div id="role-akses"></div>
        </form>
    </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger light" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary btn-submit-akses">Submit</button>
      </div>
    </div>
  </div>
</div>


<script>
  $(document).ready(function(){
      loadRole()
    })
  function loadRole()
  {
      dt = $("#dt-menu-role").DataTable({
        "responsive": true, "lengthChange": true, "autoWidth": false,
        // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
      //   "processing": true,
      // "serverSide": true,

        "processing": true,
        "serverSide": true,
        "destroy":true,
        "ajax": {
            "url":base_url+"cms/get-data-role",
            "type": "POST",
        },
        "columnDefs": [
        {
            targets : [-1,0],
            orderable: false
        },
        {
            targets : [-1,0, 4],
            class: 'text-nowrap text-center'
        }
        ],
        "order" : [],
      })

  }


  $('#btn-tambah').click(function(){
    aksi = 'tambah';
    $('#form')[0].reset()
    $('#modal-form').modal('show')
    $('.modal-title').text('Add Role')
    $('.text-danger').empty()
    $('.is-invalid').removeClass('is-invalid')
    $('.is-valid').removeClass('is-valid')
  })

  
  $('.btn-submit').click(function(e){
    e.preventDefault('submit')
    var formData = new FormData($('#form')[0]);
    $.ajax({
      url:base_url+'cms/save-role/'+aksi,
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
    
    $('.text-danger').empty()
    $('.is-invalid').removeClass('is-invalid')
    $('.is-valid').removeClass('is-valid')
    $('#modal-form').modal('show')
    $('.modal-title').text('Edit Role')
    $.ajax({
      url:base_url+'cms/get-data-role/'+id,
      dataType:'json',
      success: (response) => {
        $.each(response.data, function(key, value) {
          if (key == 'description_role') {
            $('textarea#'+key).val(value)
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
            url:base_url+'cms/delete-role/'+id,
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


  function ButtonAccess(id)
    {
      $('#modal-akses').modal('show');
      $.ajax({
          url: base_url+'cms/get-access-role/'+id,
          type: "get",
          dataType: "html",
          success: function(response)
          {
              $("input[name='id_role']").val(id);
              $("#role-akses").html(response);
          }
      });
    }

    $("#select_all").click(function(){
      console.log($(this).is(':checked'));
      if($(this).is(':checked')==true)
      {
        $("#role-akses input[type='checkbox']").attr('checked',true);

        // $("#role-akses input[type='checkbox'][name='menu_id[]']").attr('checked',true);
        // $("#role-akses input[type='checkbox'][name='access_read[]']").attr('checked',true);
      }
      else
      {
        // $("#role-akses input[type='checkbox'][name='access_read[]']").attr('checked',false);

        // $("#role-akses input[type='checkbox'][name='menu_id[]']").attr('checked',false);
        $("#role-akses input[type='checkbox']").attr('checked',false);
      }
    })

    $('.btn-submit-akses').click(function(){
      $.ajax({
        url:base_url+'cms/save-access-role',
        dataType:'json',
        type:'POST',
        data:$('#form-akses').serialize(),
        success: (response) =>{
          if (response.success) {
            sukses('Successfully Updated Access');
            $('#modal-akses').modal('hide')
            dt.ajax.reload()
          }else{
            gagal('Failed Updated Access, Please Contact Administrator');
          }

        }
      })
    })
</script>