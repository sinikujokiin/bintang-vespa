<div class="container-fluid">
  <div class="row">
    <div class="col-12">

      <div class="card card-dark">
        <div class="card-header">
          <h3 class="card-title title-card">
            <?= $title ?>
          </h3>
          <div class="card-tools">
            <a href="<?= base_url('cms/data-booking/create') ?>" class="btn btn-primary btn-sm"><span class="fa fa-plus"></span> Add Data</a>

          </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <table id="dt-list" class="table table-bordered table-responsive table-striped">
            <thead>
              <tr>
                <th class="text-nowrap" width="1%">No.</th>
                <th class="text-nowrap">Kode</th>
                <th class="text-nowrap" width="20%">Nama Customer</th>
                <th class="text-nowrap" width="10%">Bengkel</th>
                <th class="text-nowrap" width="20%">Keluhan</th>
                <th class="text-nowrap" width="5%">Tanggal Rencana Servis</th>
                <th class="text-nowrap" width="5%">Estimasi Pengerjaan</th>
                <th class="text-nowrap" width="5%">Mulai Perbaikan</th>
                <!-- <th class="text-nowrap" width="5%">Selesai Perbaikan</th> -->
                <!-- <th class="text-nowrap" width="5%">Aktual Pengerjaan</th> -->
                <th class="text-nowrap" width="1%">Status</th>
                <th class="text-nowrap" width="1%">Aksi</th>
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

<script>
  $(document).ready(function(){
  
    loadData()
    aksi = "";
  })
  function loadData()
  {
    dt = $("#dt-list").DataTable({
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
          "url":base_url+"cms/get-data-booking",
          "type": "POST",
        },
        "columnDefs": [
        {
          targets : [-1,0],
          orderable: false
        },
        {
          targets : [-1,0,-2,1],
          class: 'text-nowrap text-center'
        },
        ],
        "order" : [],
      })

  }


  function startStop(_this)
  {
    var type = $(_this).data('type');
    var id = $(_this).attr('id');
    // console.log(id)

    $.ajax({
      url:`${base_url}/cms/data-booking/${type}/${id}`,
      type:'POST',
      dataType:'JSON',
      beforeSend:function(){
        $(`#${id}`).html(`<span class="fa fa-spin fa-spinner"></span> Loading ....`).attr('disabled',true);
      },
      complete:function() {
        $(`#${id}`).html(`<span class="fa fa-play"></span>`).attr('disabled',false);
      },
      success:function(response)
      {
        if (response.status) {
          sukses(response.msg)
          dt.ajax.reload()
        }else{
          warning(response.msg)
        }
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
            url:base_url+'cms/delete-booking/'+id,
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
