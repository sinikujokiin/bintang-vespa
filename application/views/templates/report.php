
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $title ?></title>
    <style>
       .table th {
            padding: 10px;
            font-size: 13px
        }
        .table td {
            /* border: 1px solid black; */
            padding: 3px;
            font-size: 12px
        }


        .table {
            border-collapse: collapse;
        }

        .text-left {
            text-align: left
        }

        .text-right {
            text-align: right
        }

        .tengah {
            text-align: center;
            line-height: 5px;
            vertical-align: middle;
        }
        .border td{
/*            border: 1.5px solid black*/
        }
        hr{
            border: 0.2px solid black;
        }

        .borderupdown {
            border-bottom: 1.5px solid black; 
            border-top: 1.5px solid black;
        }

 
        
        .footer {
            width: 100%;
            /* text-align: center; */
            position: fixed;
            bottom: 0;
            left: 0;
            /* padding: 15px; */
            /* right: 0; */
        }

        .pagenum:before {
            content: counter(page);
        }
        @page {
            margin-bottom: 5px;
        }

        .center{
        	text-align: center;
        }
    </style>
</head>

<body>
    <div class="footer">
        <table width="100%" class="table" style="border: 0">
            <tr style="border: 0">
                <td style="border: 0">
                    Halaman <span class="pagenum"></span>
                </td>
                <td style="text-align: right ; border:0">
                    <?= date("d-m-Y H:i:s") ?>
                </td>
            </tr>
        </table>

    </div>
    <div>
       <table class="table" width="100%" style="padding: 0;margin: 0;">
            <tr>
                <th width="25%"><img src="<?= getImage('assets/'.$web->logo)?>" alt="<?= $web->website_name ?>" width="35%"></th>
                <td style="padding: 0 2%" class="center">
                    <span style="font-size: 2rem; font-weight:500"><?= $web->website_name ?></span> <br>
                    <span style="font-size: 0.8rem;"><?= $web->address ?></span><br>
                    <span style="font-size: 0.8rem;"><?= $web->phone.' | '.$web->email ?></span>
                </td>
                <th width="25%"><img src="<?= getImage('assets/'.$web->logo)?>" alt="<?= $web->website_name ?>" width="35%"></th>
            </tr>
        </table>
        <hr>

        <h3 class="center"><?= $title ?></h3>
        <!-- <hr> -->
    </div>

    <table class="table" width="100%" border="1" cellspacing="0" id="table">
            <!-- <caption><?= $title ?></caption> -->
            <thead style="">
              <tr>
                <th width="1%">No.</th>
                <th width="9%">Kode</th>
                <th>Pelanggan</th>
                <th>Jenis Vespa</th>
                <th>Bengkel</th>
                <th>Tangggal Servis</th>
                <th>Pengerjaan</th>
                <th>Sparepart</th>
                <th class="text-right" width="13%">Biaya</th>
              </tr>
            </thead>
            <tbody>
              <?php if ($data): $total = 0; ?>
                <?php $no =1; foreach ($data as $value): $total += ($value['repair_service']+$value['total']) ?>
                  <tr>
                    <td><?= $no++ ?>.</td>
                    <td class="text-nowrap"><?= $value['transaction_code'] ?></td>
                    <td><?= $value['customer'] ?></td>
                    <td><?= $value['vespa'] ?></td>
                    <td><?= $value['workshop'] ?></td>
                    <td><?= dateIndonesia($value['service_date']) ?></td>
                    <td class="center">
                      <?= dateIndonesia(date("Y-m-d", strtotime($value['start_time']))).' '.date("H:i", strtotime($value['start_time'])).'<br> s/d <br>',dateIndonesia(date("Y-m-d", strtotime($value['finish_time']))).' '.date("H:i", strtotime($value['finish_time'])) ?> <br>
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
                          <li><?= $detail['name'] ?> x <?= $detail['qty'] ?></li>
                        <?php endforeach ?>
                      </ol>
                    </td>
                    <td class="text-right">Jasa : Rp. <b><?= number_format($value['repair_service'],0,',','.') ?></b> <br>
                        Sparepart : Rp. <b><?= number_format($value['total'],0,',','.') ?></b>
                    </td>
                  </tr>
                <?php endforeach ?>
                  <tr>
                  	<th colspan="8" class="text-right">Total</th>
                  	<th class="text-right"><?=  number_format($total,0,',','.') ?></th>
                  </tr>
              <?php else: ?>
                <tr>
                  <td colspan="9" class="text-center">Tidak Ada <?= $m || $y ? 'Laporan '.$month.' '.$year : 'Laporan Keseluruhan'  ?></td>
                </tr>
              <?php endif ?>
            </tbody>
        </table>
   

</body>

</html>
