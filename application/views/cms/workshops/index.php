<div class="container-fluid">
  <div class="row">
    <div class="col-12">

      <div class="card card-dark">
        <div class="card-header">
          <h3 class="card-title title-card">
            <?= $title ?>
          </h3>
          <div class="card-tools">
            <a href="<?= base_url('cms/data-workshop/create') ?>" class="btn btn-primary btn-sm"><span class="fa fa-plus"></span> Tambah <?= $title ?></a>

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
                <th width="1%">Status</th>
                <th width="1%">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php $no =1; foreach ($data as $value): ?>
                <tr id="<?=encrypt_decrypt('encrypt', $value->id) ?>">
                  <td width="1%"><?= $no++ ?></td>
                  <td width="10%"><?= $value->name ?></td>
                  <td width="10%"><?= $value->phone ?></td>
                  <td width="10%"><?= $value->email ?></td>
                  <td width="5%"><?= $value->status ?></td>
                  <td width="1%" class="text-nowrap">
                    <a href="<?= base_url('cms/data-workshop/edit/'.encrypt_decrypt('encrypt', $value->id)) ?>"  title="Edit Data" class="btn btn-warning shadow btn-sm sharp mr-1"><span class="fa fa-edit"></span></a>
                    <a href="#" type="button" id="btn-delete-<?= encrypt_decrypt('encrypt', $value->id) ?>" title="Delete Data" onclick="ButtonDelete(`<?= encrypt_decrypt('encrypt', $value->id) ?>`)" class="btn btn-danger shadow btn-sm sharp"><span class="fa fa-trash"></span></a>
                  <!-- <a href="<?= base_url('cms/data-workshop/edit/'.encrypt_decrypt('encrypt', $value->id)) ?>"  title="Delete Data" class="btn btn-danger shadow btn-sm sharp"><span class="fa fa-trash"></span></a> -->
                    
                  </td>
                </tr>
              <?php endforeach ?>
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
    $("#dt-kategori").DataTable()

  })

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
            url:base_url+'cms/delete-workshop/'+id,
            type:'post',
            dataType:'json',
            success: (response) => {
              sukses(response.alert);
              $(`#${id}`).remove()
            }
          })
      }
    })
  }


</script>