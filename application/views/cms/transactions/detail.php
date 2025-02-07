<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-12 col-lg-8">

      <div class="card card-dark">
        <div class="card-header">
          <h3 class="card-title title-card">
            <?= $title ?> <b><?= $transaction->transaction_code ?></b>
          </h3>
          <div class="card-tools">
          </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <div class="form-group">
            <label>Nama Pelanggan</label>
            <br>
            <span><?= $customer->name ?></span>
          </div>
          <div class="form-group">
            <label>Lokasi Bengkel</label>
            <br>
            <span><?= $workshop->name ?></span> <br>
            <span><?= $workshop->address ?></span>
          </div>
          <div class="form-group">
            <label>Jenis Vespa</label>
            <br>
            <span><?= $vespa->name ?> (<?= $vespa->year ?>)</span>
          </div>
          <div class="form-group">
            <label>Keluhan</label>
            <br>
            <span><?= $transaction->concern ?></span>
          </div>
          <div class="form-group">
            <label>Tanggal Transaksi</label>
            <br>
            <span><?= dateIndonesia($transaction->service_date).' '.$transaction->service_time ?></span>
          </div>
          <div class="form-group">
            <label>Estimasi Pengerjaan</label>
            <br>
            <span><?= $transaction->work_estimate ? $transaction->work_estimate.' Menit' : '' ?></span>
          </div>
          <div class="form-group">
            <label>Waktu Pengerjaan</label>
            <br>
            <span><?= dateIndonesia(date("Y-m-d", strtotime($transaction->start_time))).' '.date("H:i", strtotime($transaction->start_time)).' s/d ',dateIndonesia(date("Y-m-d", strtotime($transaction->finish_time))).' '.date("H:i", strtotime($transaction->finish_time)) ?> <br>
              <?php 
              $actual_work = '';
              if ($transaction->start_time && $transaction->finish_time) {
                $start_time = new DateTime($transaction->start_time);
                $finish_time = new DateTime($transaction->finish_time);
                $interval = $start_time->diff($finish_time);
                $actual_work = $interval->format('%H:%I:%S');
              } ?>
              <b>
                
              (<?= $actual_work ?>)
              </b>
            </span>
          </div>
          <div class="form-group">
            <label>Jasa Perbaikan</label>
            <br>
            <span>Rp. <?= number_format($transaction->repair_service,0,',','.') ?></span>
          </div>
          <div class="form-group">
            <label>Sparepart Yang Diganti</label>
            <br>
            <ol>
              <?php foreach ($detail as $value): ?>
                <li><?= $value->name.' @ '.$value->qty.' pcs' ?></li>
              <?php endforeach ?>
            </ol>
            <span>Rp. <?= number_format($transaction->total,0,',','.') ?></span>
          </div>

          <div class="form-group">
            <label>Total</label>
            <br>
            <span>Rp. <?= number_format($transaction->repair_service+$transaction->total,0,',','.') ?></span>
          </div>

        </div>
        <!-- /.card-body -->
        <div class="card-footer text-right">
          <a href="<?= base_url($this->uri->segment(1).'/'.$this->uri->segment(2).'/cetak'.'/'.encrypt_decrypt('encrypt',$transaction->id)) ?>" class="btn btn-primary" title="Cetak"><i class="fa fa-print"></i> Cetak</a>
          <a href="<?= base_url($this->uri->segment(1).'/'.$this->uri->segment(2)) ?>" class="btn btn-secondary" title="Back To List Product">Back</a>
        </div>
      </div>
      <!-- /.card -->
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->
</div>