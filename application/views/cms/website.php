<div class="container-fluid">
  <div class="row">
    <div class="col-12">

      <div class="card card-dark">
        <div class="card-header">
          <h3 class="card-title title-card">
            <?= $title ?>
          </h3>
          <div class="card-tools">
            <button type="button" class="btn btn-success btn-sm" id="btn-import"><span class="fa fa-file-excel"></span> Import Data</button>
            <button type="button" class="btn btn-primary btn-sm" id="btn-tambah"><span class="fa fa-plus"></span> Add Data</button>
           
          </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <table id="dt-website" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>No.</th>
                <th>Nama Website</th>
                <th>Domain</th>
                <th>Category</th>
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
  <div class="modal-dialog modal-dialog-centered" website="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"></h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
        </button>
      </div>
      <div class="modal-body" style="max-height: 75vh; overflow-y: auto;">
        <form id="form">
          <div class="form-group">
            <label for="web_name">Website Name</label>
            <input type="text" name="web_name" class="form-control" id="web_name" placeholder="Website Name">
            <input type="hidden" name="web_id" id="web_id" value="">
            <span class="web_name_error text-danger"></span>
          </div>
          <div class="form-group">
            <label for="domain">Domain</label>
            <input type="url" name="domain" class="form-control" id="domain" placeholder="Domain">
            <span class="domain_error text-danger"></span>
          </div>
          <div class="form-group">
            <label for="category_id">Category</label>
            <select name="category_id" id="category_id" class="form-control select2">
              <option value="">Select Category</option>
              <?php foreach ($categories as $category): ?>
                <option value="<?= $category['category_id'] ?>"><?= $category['category_name'] ?></option>
              <?php endforeach ?>
            </select>
            <span class="category_id_error text-danger"></span>
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


<div class="modal fade" id="modal-import">
  <div class="modal-dialog modal-dialog-centered modal-xl" website="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"></h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
        </button>
      </div>
      <div class="modal-body" style="max-height: 75vh; overflow-y: auto;">
        <div class="row">
          <div class="col-9">
            <input type="file" name="import" id="import" class="form-control">
          </div>
          <div class="col-3">
            <a href="<?= base_url('download-format-excel-website') ?>" class="btn btn-success btn-sm" id="btn-download-format"><span class="fa fa-download"></span> Download Format Excel</a>
          </div>
        </div>
        <form id="form-export">
          <div id="list-data">
            
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger light" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="btn-submit">Submit</button>
      </div>
        </form>
    </div>
  </div>
</div>

<script>
  $(document).ready(function(){
      loadWebsite()
    })


  function loadWebsite()
  {
      dt = $("#dt-website").DataTable({
        "responsive": true, "lengthChange": true, "autoWidth": false,
        // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
      //   "processing": true,
      // "serverSide": true,

        "processing": true,
        "serverSide": true,
        "destroy":true,
        "ajax": {
            "url":base_url+"cms/get-data-website",
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

  $("#btn-submit").click(function(e){
    e.preventDefault("submit")
    Swal.fire({ 
      title: "Are you sure you want to add data?", 
      text: "", 
      icon: "warning", 
      showCancelButton: !0, 
      confirmButtonColor: "primary", 
      confirmButtonText: "Yes, Save Now!!", 
      closeOnConfirm: !1 
    }).then((result) => {
      if (result.value) {
          $.ajax({
            url:base_url+'cms/save-export-website',
            type:'post',
            data:$("#form-export").serialize(),
            dataType:'json',
            success: (response) => {
              if (response.status == true) {
                sukses(response.alert);
                dt.ajax.reload()
              $('#modal-import').modal('hide')
              }else{
                warning(response.alert);
              }
            }
          })
      }
    })
  })

  $('#btn-tambah').click(function(){
    aksi = 'add';
    $('#form')[0].reset()
    $('#web_id').val('')
    $('#category_id').val('').trigger("change")
    $('#modal-form').modal('show')
    $('.modal-title').text('Add Website')
    $('.text-danger').empty()
    $('.is-invalid').removeClass('is-invalid')
    $('.is-valid').removeClass('is-valid')
  })

  
  $('.btn-submit').click(function(e){
    e.preventDefault('submit')
    var formData = new FormData($('#form')[0]);
    $.ajax({
      url:base_url+'cms/save-website/'+aksi,
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
    aksi = 'edit'
    // $('#form')[0].reset()
    $('#form')[0].reset()
    
    $('.text-danger').empty()
    $('.is-invalid').removeClass('is-invalid')
    $('.is-valid').removeClass('is-valid')
    $('#modal-form').modal('show')
    $('.modal-title').text('Edit Website')
    $.ajax({
      url:base_url+'cms/get-data-website/'+id,
      dataType:'json',
      success: (response) => {
        $.each(response.data, function(key, value) {
            $('#'+key).val(value).trigger('change')
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
            url:base_url+'cms/delete-website/'+id,
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


  $("#btn-import").click(function(){

    $("#list-data").html("")
    $('#modal-import').modal('show')
  })



  $("#import").change(function(){
        const image = $(this).prop('files')[0];
        uploadImages(image)
  })

  function uploadImages(image) {
        var data = new FormData();
        data.append("file", image);
        $.ajax({
            url: `${base_url}get-data-import-website`,
            cache: false,
            contentType: false,
            processData: false,
            data: data,
            type: "POST",
            dataType:"json",
            success: function(response) {
              $("#list-data").html(response)
            },
            error: function(data) {
                console.log(data);
            }
        });
    }

</script>