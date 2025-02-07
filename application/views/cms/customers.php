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
          <table id="dt-kategori" class="table table-bordered table-responsive table-striped">
            <thead>
              <tr>
                <th width="1%">No.</th>
                <th width="10%">Nama</th>
                <th width="7%">Telepon</th>
                <th width="7%">Email</th>
                <!-- <th width="1%">Status</th> -->
                <th width="1%">Action</th>
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
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"></h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
        </button>
      </div>
      <div class="modal-body" style="max-height: 75vh; overflow-y: auto;">
        <form id="form">
          <div class="row">
            <div class="col-12">
              <div class="form-group">
                <label for="name">Nama Pelanggan</label>
                <input type="text" name="name" id="name" class="form-control">
                <span class="name_error text-danger"></span>
              </div>
              <div class="form-group">
                <label for="phone">No. HP</label>
                <input type="text" name="phone" id="phone" class="form-control">
                <span class="phone_error text-danger"></span>
              </div>
              <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control">
                <span class="email_error text-danger"></span>
              </div>

              <!-- <div class="form-group">
                <label for="image">Gambar</label>
                <div id="show-image"></div>
                <input type="file" class="form-control" name="image" id="image">
                <span class="image_error text-danger"></span>
              </div> -->
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
    $(".select2-tags").select2({
      placeholder:"Ketik untuk mencari atau membuat tag baru",
      tags:true,
      theme:'bootstrap4'
    })
    loadProduct()
    aksi = "";
  })
  function loadProduct()
  {
    dt = $("#dt-kategori").DataTable({
      "lengthChange": true, 
      "responsive":true,
      "autoWidth": false,
          // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
        //   "processing": true,
        // "serverSide": true,

        "processing": true,
        "serverSide": true,
        "destroy":true,
        "ajax": {
          "url":base_url+"cms/get-data-customer",
          "type": "POST",
        },
        "columnDefs": [
        {
          targets : [-1,0],
          orderable: false
        },
        {
          targets : [-1,0],
          class: 'text-nowrap text-center'
        },
        ],
        "order" : [],
      })

  }



  $('#btn-tambah').click(function(){
    aksi = 'tambah';
    $('#form')[0].reset()
    $('#modal-form').modal('show')
    $('.modal-title').text('Tambah Pelanggan')
    $('.text-danger').empty()
    $('.is-invalid').removeClass('is-invalid')
    $('.is-valid').removeClass('is-valid')
    $("#show-image").html("")
  })

  
  $('.btn-submit').click(function(e){
    e.preventDefault('submit')
    var formData = new FormData($('#form')[0]);
    $.ajax({
      url:base_url+'cms/save-customer/'+aksi,
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
    $('.modal-title').text('Ubah Pelanggan')
    $.ajax({
      url:base_url+'cms/get-data-customer/'+id,
      dataType:'json',
      success: (response) => {
        $.each(response.data, function(key, value) {
          if (key == 'image') {
            if (value) {
              $("#show-image").html(`<img src="${base_url}uploads/customer/${value}" width="150px" alt="Gambar ${response.data.nama}">`);
            }else{
              $("#show-image").html(``);
            }
          }else{
            $('#'+key).val(value)
          }
        })
      }
    })
  }

  function UpdateStatus(id)
  {
      $.ajax({
        url:base_url+'cms/update-status-customer/'+id,
        type:'post',
        dataType:'json',
        success: (response) => {
          sukses(response.alert);
          dt.ajax.reload()
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
            url:base_url+'cms/delete-customer/'+id,
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
</script>