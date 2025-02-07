<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $title ?></title>
    <style>
        .table th,
        .table td {
/*            border: 1px solid black;*/
            padding: 10px;
            font-size: 14px
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
        hr{
            border: 0.2px solid black;
        }

        .float-start{
            float: left;
        }
        .float-end{
            float: right;
        }
        body{
            font-family: Roboto,serif;
            font-size: 0.875rem;
            font-weight: 400;
            line-height: 1.5
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
    </style>
</head>

<body>
    <div class="footer">
        <table width="100%" style="border: 0">
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
    <div class="tengah">
        <h2>
            <?= $web->website_name ?> <br><br><br><br>
            <span style="font-size: 15px; ">
                <?= $web->address ?>
            </span>
            <br><br><br>
            <span style="font-size: 12px; font-weight:light">
                <?=  $web->phone ?> - <?= $web->email ?>
            </span>
        </h2>
        <hr>
        <br>
        <h4 class="float-start">Informasi Umum</h4><br><br><br><br><br><br>

        <table class="table" width="100%">
            <tr>
                <td width="50%">
                    <span class="float-start">Tanggal Servis</span>
                    <span class="float-end"><?= dateIndonesia($transaction->service_date) ?></span>
                </td>
                <td width="50%" style="border-left:1px solid black">
                    <span class="float-start">Pelanggan</span>
                    <span class="float-end"><?= $customer->name ?></span>
                </td>
            </tr>
            <tr>
                <td width="50%">
                    <span class="float-start">Kode Transaksi</span>
                    <span class="float-end"><?= $transaction->transaction_code ?></span>
                </td>
                <td width="50%" style="border-left:1px solid black">
                    <span class="float-start">Bengkel</span>
                    <span class="float-end"><?= $workshop->name ?></span>
                </td>
            </tr>
            <tr>
                <td width="50%">
                    <span class="float-start">Status Transaksi</span>
            <span class="float-end"><?= $transaction->status ?></span>
                </td>
                <td width="50%" style="border-left:1px solid black">
                     <span class="float-start">Tipe Vespa</span>
            <span class="float-end"><?= $vespa->name ?></span>
                </td>
            </tr>
          
        </table>
        <hr>
        <br>
        <h4 class="float-start">Sparepart + Jasa</h4><br><br><br><br><br><br>

        <?php foreach ($detail as $value): ?>
            <div style="margin-top:1rem; margin-bottom:0.5rem">
                <span class="float-start"><?= $value->name ?></span>
                <span class="float-end">@<?= $value->qty ?> x <?= number_format($value->price,0,',','.') ?></span>
            </div>
        <?php endforeach ?>
        <div style="margin-top:1rem; margin-bottom:0.5rem">
            <span class="float-start">Jasa</span>
            <span class="float-end"><?= number_format($transaction->repair_service,0,',','.') ?></span>
        </div>
    </div>
    <hr>
    <div class="mb-2 mt-2">
        <span class="float-start h6">Total</span>
        <span class="float-end h6">RP. <?= number_format($transaction->repair_service+$transaction->total,0,',','.') ?></span>
    </div>
</body>

</html>
