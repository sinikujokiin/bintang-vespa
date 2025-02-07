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
          <table id="dt-menu-cms" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>No.</th>
                <th>Parent Name</th>
                <th>Menu Title</th>
                <th>Menu URL</th>
                <th>Icon</th>
                <th>Have Link</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>

            </tbody>
            <tfoot>
              <tr>
                <th>No.</th>
                <th>Parent Name</th>
                <th>Menu Title</th>
                <th>Menu URL</th>
                <th>Icon</th>
                <th>Have Link</th>
                <th>Action</th>
              </tr>
            </tfoot>
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
            <label for="menu_parent">Is Parent?</label>
            <input type="hidden" name="id_menu" id="id_menu">
            <input type="hidden" name="type" id="type" value="cms">
            <div id="show_menu_parent">
              
            </div>
            <!-- <select name="menu_parent" id="menu_parent" class="form-control">
            </select> -->
            <span class="menu_parent_error text-danger"></span>
          </div>
          <div class="form-group">
            <label for="menu_title">Menu Title</label>
            <input type="text" name="menu_title" class="form-control" id="menu_title" placeholder="Menu Title">
            <span class="menu_title_error text-danger"></span>
          </div>
          <div class="form-group">
            <label for="have_link">Have A Link?</label>
              <div id="show_have_link">
                
              </div>
              <span class="have_link_error text-danger"></span>
          </div>
          <div class="form-group" id="show-link">
            <label for="menu_url">Menu URL</label>
            <div class="input-group">
              <span class="input-group-text" id="basic-addon3"><?= base_url() ?></span>
              <input type="text" class="form-control" name="menu_url" id="menu_url" placeholder="Link Menu" aria-describedby="basic-addon3">
            </div>
              <span class="menu_url_error text-danger"></span>
          </div>
          <div class="form-group">
            <label for="icon">Icon</label>
            <div class="input-group">
              <span class="input-group-text"><span id="show-icon"></span></span>
              <input type="text" class="form-control" autocomplete="none" name="icon" id="icon">
            </div>
              <span class="icon_error text-danger"></span>
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
      loadMenu('cms')
    })
  function loadMenu(type)
  {
        id_table = type == 'cms' ? '#dt-menu-cms' : '#dt-menu-frontend';
        dt = $(id_table).DataTable({
          "responsive": true, "lengthChange": true, "autoWidth": false,
          // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
        //   "processing": true,
        // "serverSide": true,

          "processing": true,
          "serverSide": true,
          "destroy":true,
          "ajax": {
              "url":base_url+"cms/get-data-menu",
              "type": "POST",
              "data":{
                type:type
              }
          },
          "columnDefs": [
          {
              targets : [-1,0],
              orderable: false
          },
          {
              targets : [-1,0, 4,5],
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
    $('.modal-title').text('Add Menu')
    $('.text-danger').empty()
    $('.is-invalid').removeClass('is-invalid')
    $('.is-valid').removeClass('is-valid')
    loadParent();
    loadMenuFLag();
  })

  $('#icon').keyup(function() {
    var icon = $(this).val()
    $('#show-icon').removeClass().text('').addClass(`fa fa-${icon}`)
  })

  function loadMenuFLag()
  {
    var html = `
      <select name="have_link" id="have_link" class="form-control">
        <option value="">Pilih</option>
        <option value="yes">Have A Link</option>
        <option value="no">No Have A Link</option>
      </select>
    `;

    $('#show_have_link').html(html)
  }

  function loadParent()
  {
      // type = $('.active')[2].id;
      type = 'cms';
      // $('#type').val(type)
      $.ajax({
          url:base_url+"cms/get-parent-menu",
          data:{
            type:type
          },
          type:"get",
          dataType:"JSON",
          async: false,            
          success:function(data)
          {
              var html = `
              <select name="menu_parent" class="form-control select2" id="menu_parent">
              
              <option value="0">Menu Label</option>`;
              for ( i = 0 ; i < data.length ; i++ )
                  {
                     if(data[i]['menu_parent_title']==null){
                       html += `<option value="${data[i].id_menu}">Sub Menu of Label ${data[i].menu_title}</option>`;  
                     }else{
                       if(data[i]['menu_parent_parent_title']==null){
                         html += `<option value="${data[i].id_menu}">Sub Menu of ${data[i].menu_title}</option>`;  
                       }
                       // else{
                       //   html += `<option value=${data[i].id_menu}">Sub Menu of ${data[i].menu_title}</option>`;  
                       // }
                     }
                  }
                 html += `</select>`;
              $('#show_menu_parent').html(html);
              $("#menu_parent").select2({
                theme:"bootstrap4"
              })
          }
      });
  }

  $('.btn-submit').click(function(e){
    e.preventDefault('submit')
    $.ajax({
      url:base_url+'cms/save-menu/'+aksi,
      dataType:'json',
      type:'POST',
      data:$('#form').serialize(),
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

    $('.text-danger').empty()
    $('.is-invalid').removeClass('is-invalid')
    $('.is-valid').removeClass('is-valid')
    $('#modal-form').modal('show')
    $('.modal-title').text('Edit Menu')
        loadParent();
        loadMenuFLag();
    $.ajax({
      url:base_url+'cms/get-data-menu/'+id,
      dataType:'json',
      success: (response) => {
        $.each(response.data, function(key, value) {
            $('#'+key).val(value)
        })
        var classIcon = response.data.icon == null ? '#' : response.data.icon;
        $('#icon').val(classIcon)
        classIcon == '#' ? $('#show-icon').removeClass().text(classIcon) : $('#show-icon').removeClass().text('').addClass(`fa fa-${classIcon}`);
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
            url:base_url+'cms/delete-menu/'+id,
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