<?php $months = [
  '1' => 'January',
  '2' => 'February',
  '3' => 'Maret',
  '4' => 'April',
  '5' => 'Mei',
  '6' => 'Juni',
  '7' => 'Juli',
  '8' => 'Agustus',
  '9' => 'September',
  '10' => 'Oktober',
  '11' => 'November',
  '12' => 'Desember',
];
$m = $this->input->get('m');
$y = $this->input->get('y'); 
?>
<div class="container-fluid">
  <div class="card">
    <div class="card-body">
      <div class="row">
        <div class="col-lg-8 col-sm-12">
          <br>
          <button class="btn btn-primary btn-sm" id="btn-print"><i class="fa fa-print"></i> Cetak Laporan</button>
        </div>
        <div class="col-lg-4 col-sm-12">
          <form action="">
            <div class="row">
              <div class="col-5">
                <div class="form-group">
                  <label for="m">Bulan</label>
                  <input type="hidden" name="search">
                  <select class="form-control select2" name="m" id="m">
                    <option value="">Semua</option>
                    <?php foreach ($months as $key => $value): ?>
                      <option value="<?= $key ?>" <?= $m == $key ? 'selected' : ''  ?>><?= $value ?></option>
                    <?php endforeach ?>
                  </select>
                </div>
              </div>
              <div class="col-5">
                <div class="form-group">
                  <label for="y">Tahun</label>
                  <select class="form-control select2" name="y" id="y">
                    <option value="">Semua</option>
                    <?php for ($i = date('Y'); $i >= 2020 ; $i--): ?>
                      <option value="<?= $i ?>" <?= $y == $i ? 'selected' : ''  ?>><?= $i ?></option>
                    <?php endfor ?>
                  </select>
                </div>
                
              </div>
              <div class="col-2">
                <div class="form-group">
                  <label>&nbsp;</label>
                  <br>
                  <button type="submit" class="btn btn-sm btn-primary">Cari</button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
      <div class="row" id="show">
        <iframe width="100%" hidden id="iframe"></iframe>

        <table class="table table-bordered table-striped" id="table">
            <?php 
            
            $month = '' ;
            $year = '' ;
            if ($m) $month = 'Bulan '.$months[$m];
            if ($y) $year = 'Tahun '.$y;

             ?>
            <caption><?= $m || $y ? 'Laporan '.$month.' '.$year : 'Laporan Keseluruhan'  ?></caption>
            <thead>
              <tr>
                <td>No.</td>
                <td>Kode</td>
                <td>Pelanggan</td>
                <td>Jenis Vespa</td>
                <td>Bengkel</td>
                <td>Tangggal Servis</td>
                <td>Pengerjaan</td>
                <td>Sparepart</td>
                <td class="text-right">Biaya</td>
              </tr>
            </thead>
            <tbody>
              <?php if ($data): ?>
                <?php $no =1; foreach ($data as $value): ?>
                  <tr>
                    <td><?= $no++ ?></td>
                    <td class="text-nowrap"><?= $value['transaction_code'] ?></td>
                    <td><?= $value['customer'] ?></td>
                    <td><?= $value['vespa'] ?></td>
                    <td><?= $value['workshop'] ?></td>
                    <td><?= dateIndonesia($value['service_date']) ?></td>
                    <td>
                      <?= dateIndonesia(date("Y-m-d", strtotime($value['start_time']))).' '.date("H:i", strtotime($value['start_time'])).' s/d ',dateIndonesia(date("Y-m-d", strtotime($value['finish_time']))).' '.date("H:i", strtotime($value['finish_time'])) ?> <br>
                          <?php 
                          $actual_work = '';
                          if ($value['start_time'] && $value['finish_time']) {
                            $start_time = new DateTime($value['start_time']);
                            $finish_time = new DateTime($value['finish_time']);
                            $interval = $start_time->diff($finish_time);
                            $actual_work = $interval->format('%H:%I:%S');
                          } ?>
                          <b>
                            
                          (<?= $actual_work ?>)
                          </b>
                      
                    </td>
                    <td>
                      <ol>
                        <?php foreach ($value['detail'] as $detail): ?>
                          <li><?= $detail['name'] ?></li>
                        <?php endforeach ?>
                      </ol>
                    </td>
                    <td class="text-right">Jasa : Rp. <?= number_format($value['repair_service'],0,',','.') ?> <br>
                        Sparepart : Rp. <?= number_format($value['total'],0,',','.') ?>
                    </td>
                  </tr>
                <?php endforeach ?>
              <?php else: ?>
                <tr>
                  <td colspan="9" class="text-center">Tidak Ada <?= $m || $y ? 'Laporan '.$month.' '.$year : 'Laporan Keseluruhan'  ?></td>
                </tr>
              <?php endif ?>
            </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<!-- <iframe></iframe> -->

<script>
  $("#btn-print").click(function(){
    var m = $('#m').val();
    var y = $('#y').val();
    window.location.href = `${base_url}cms/report/cetak?m=${m}&y=${y}`
    // $.ajax({
    //   url: `${base_url}cms/report/cetak`,
    //   method: 'GET',
    //   data:{
    //     m:m,
    //     y:y,
    //   },
    //   // dataType: 'json',
    //   xhrFields: {
    //       responseType: 'blob'
    //     },
    //   success: function(response) {
    //     var url = window.URL.createObjectURL(response);

    //      // Menampilkan PDF
    //      var $iframe = $('<iframe>').attr('src', url);
    //      $("#iframe").attr('hidden',false)
    //      $('#show').append($iframe);

    //      // Membersihkan URL dari blob setelah iframe dihapus
    //      $iframe.on('load', function() {
    //        window.URL.revokeObjectURL(url);
    //      });
    //   }

    // });
  })
</script>