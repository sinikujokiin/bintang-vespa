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
                <th class="text-nowrap" width="20%">Nama Customer</th>
                <th class="text-nowrap" width="10%">Bengkel</th>
                <th class="text-nowrap" width="20%">Keluhan</th>
                <th class="text-nowrap" width="5%">Tanggal Rencana Servis</th>
                <th class="text-nowrap" width="5%">Estimasi Pengerjaan</th>
                <th class="text-nowrap" width="5%">Mulai Perbaikan</th>
                <th class="text-nowrap" width="5%">Selesai Perbaikan</th>
                <th class="text-nowrap" width="5%">Aktual Pengerjaan</th>
                <th class="text-nowrap" width="1%">Status</th>
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
          "url":base_url+"cms/get-data-history",
          "type": "POST",
        },
        "columnDefs": [
        {
          targets : [-1,0],
          orderable: false
        },
        {
          targets : [-1,0,-2],
          class: 'text-nowrap text-center'
        },
        ],
        "order" : [],
      })

  }
</script>