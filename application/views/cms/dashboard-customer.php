<!-- Sparkline -->
<script src="<?= base_url('assets/cms/') ?>plugins/sparklines/sparkline.js"></script>
<!-- ChartJS -->
<script src="<?= base_url('assets/cms/') ?>plugins/chart.js/Chart.min.js"></script>

<?php $color = [
    'Booked' => 'info',
    'In Progress' => 'primary',
    'Finished' => 'success',
    'Canceled' => 'danger'
] ?>

<div class="container-fluid">  
   
    <div class="row">
        <div class="col-lg-8 col-md-8 col-12">
            <div class="card">
                <div class="card-header text-center">
                    <h3 class="card-title"><b>Jadwal Booking</b></h3>
                </div>
                <div class="card-body">
                    <table class="table table-responsive table-bordered table-jumlah" width="100%">
                        <thead>
                            <tr>
                                <th class="text-nowrap" width="1%">No.</th>
                                <th class="text-nowrap">No. Antrian</th>
                                <th class="text-nowrap">Bengkel</th>
                                <th class="text-nowrap">Tanggal</th>
                                <th class="text-nowrap">Waktu</th>
                                <th class="text-nowrap">Estimasi</th>
                                <th class="text-nowrap">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1; foreach ($booking as $book): ?>
                            <tr>
                                <td><?= $no++ ?>.</td>
                                <td><?= explode('-', $book->transaction_code)[1] ?></td>
                                <td><?= $book->workshop ?></td>
                                <td><?= dateIndonesia($book->service_date) ?> <br><?= $book->service_time ?></td>
                                <td>
                                    <?php if ($book->service_date.' '.$book->service_time >= date("Y-m-d H:i:s")): ?>
                                            <span class="badge badge-success"><?= $book->service_time ?></span>
                                    <?php else: ?>
                                            <span class="badge badge-warning">Sudah Melewati Jadwal</span>
                                    <?php endif ?>
                                  
                                <td><?= $book->work_estimate ? $book->work_estimate.' Menit' : '-'  ?> </td>
                                <td>
                                    <span class="badge badge-<?= $color[$book->status] ?>"><?= $book->status ?></span>
                                </td>
                            </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>



<script>
        $(".table").DataTable()
  
</script>
