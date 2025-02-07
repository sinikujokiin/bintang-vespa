<!-- Sparkline -->
<script src="<?= base_url('assets/cms/') ?>plugins/sparklines/sparkline.js"></script>
<!-- ChartJS -->
<script src="<?= base_url('assets/cms/') ?>plugins/chart.js/Chart.min.js"></script>
<div class="container-fluid">  
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card card-body">
                <canvas class="chart" id="chart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
            <!-- <div id="chart"></div> -->
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-list"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Booking</span>
                    <span class="info-box-number" id="booking">
                    </span>
                </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-play"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Dalam Pengerjaan</span>
                    <span class="info-box-number" id="ongoing">
                    </span>
                </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-check"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Selesai</span>
                    <span class="info-box-number" id="finish">
                    </span>
                </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-times"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Batal</span>
                    <span class="info-box-number" id="cancel">
                    </span>
                </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>

        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-secondary elevation-1"><i class="fas fa-users"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Pelanggan</span>
                    <span class="info-box-number" id="customer">
                    </span>
                </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-secondary elevation-1"><i class="fas fa-building"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Bengkel</span>
                    <span class="info-box-number" id="workshop">
                    </span>
                </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>

        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-secondary elevation-1"><i class="fas fa-motorcycle"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Vespa</span>
                    <span class="info-box-number" id="vespa">
                    </span>
                </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
    </div>

<script>
    

    $(document).ready(function(){
        loadAlldata()
    })

    function loadAlldata(){
        $.ajax({
            url:`${base_url}cms/get-data-dashboard`,
            type:'get',
            dataType:"json",
            success:function(response){
                var graphOrder = response.data.chart;
                loadGraph(graphOrder.jumlah,graphOrder.bulan, graphOrder.isDate ? "Tanggal" : "Bulan")
                $.each(response.data, function(key, value) {
                    $(`#${key}`).text(value)
                })
            }
        })
    }



    function loadGraph(data, label, labelx){

        var salesGraphOrderCanvas = $('#chart').get(0).getContext('2d')
        var salesGraphOrderData = {
            labels: label,
            datasets: [{
                label: 'Total Pendapatan',
                fill: false,
                borderWidth: 2.5,
                lineTension: 0.5,
                spanGaps: true,
                borderColor: '#e5ad06',
                pointRadius: 3,
                pointHoverRadius: 7,
                pointColor: '#e5ad06',
                pointBackgroundColor: '#FFD700',
                data: data
            }]
        }
        var salesGraphOrderOptions = {
                maintainAspectRatio: false,
                responsive: true,
                legend: {
                    display: true
                },
                scales: {
                    xAxes: [{
                        ticks: {
                            fontColor: '#00000'
                        },
                        gridLines: {
                            display: true,
                            color: '#00000',
                            drawBorder: true
                        },
                        scaleLabel: {
                            display: true,
                            labelString: labelx
                          }
                    }],
                    yAxes: [{
                        ticks: {
                            stepSize: Math.floor(Math.max.apply(null,data)/4),
                            min:0,
                            fontColor: '#00000'
                        },
                        gridLines: {
                            display: true,
                            color: '#00000',
                            drawBorder: true
                        }
                    }]
                }
            }
            // This will get the first returned node in the jQuery collection.
            // eslint-disable-next-line no-unused-vars
             salesGraphOrder = new Chart(salesGraphOrderCanvas, { // lgtm[js/unused-local-variable]
                type: 'line',
                data: salesGraphOrderData,
                options: salesGraphOrderOptions
            })

    }

    $("#bulan, #tahun").change(function(){
        salesGraphOrder.destroy()
        loadAlldata()
    })
</script>