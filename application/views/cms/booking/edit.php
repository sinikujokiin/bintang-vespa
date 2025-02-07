<link rel="stylesheet" href="<?= base_url('assets/dist/leaflet/') ?>leaflet.css">
<style type="text/css">
    #map {
        height: 450px;
    }
</style>
<?php $readonly ='' ;if (!isset($this->session->userdata('userData')['customer_id'])): $readonly = 'readonly' ?>
  
<?php endif ?>
<div class="contaner-fluid">
	<form id="form">
		<div class="row">
			<div class="col-lg-6">
				<div class="card">
					<div class="card-header">
						<h3 class="card-title title-card">
						<?= $title ?>
						</h3>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-12">
								<div class="form-group">
									<input type="hidden" name="workshop_id" id="workshop_id" value="<?=  $workshop?$workshop->id:'' ?>">
                  <input type="hidden" name="id" id="id" value="<?=  encrypt_decrypt('encrypt', $transaction->id) ?>">
									<label for="customer_id">Pelanggan</label>
									<?php if ($this->session->userdata('userData')['role_id'] != 0): ?>
									<select class="form-control select2" <?= $readonly ?> name="customer_id" id="customer_id">
										<?php foreach ($customers as $value): ?>
										<option value="<?= $value->id ?>" <?= $transaction->customer_id == $value->id ? 'selected' : 'disabled'  ?>><?= $value->name ?></option>
										<?php endforeach ?>
									</select>
									<?php else: ?>
									<input type="text" name="customer" class="form-control"  id="customer" readonly value="<?= $this->session->userdata('userData')['fullname']; ?>" placeholder="fa fa-home">
									<?php endif ?>
									<span class="customer_id_error text-danger"></span>
								</div>
							</div>
               <div class="col-12">
                <div class="form-group">
                  <label for="vespa_id">Tipe Vespa</label>
                  <select class="select2 form-control" <?= $readonly ?> name="vespa_id" id="vespa_id">
                    <option selected disabled>Pilih Jenis Vespa</option>
                    <?php foreach ($vespa as $value): ?>
                    <option value="<?= $value->id ?>" <?= $transaction->vespa_id == $value->id ? 'selected' : 'disabled'  ?> title="<?= $value->description ?>"><?= $value->name ?> (<?= $value->year ?>)</option>
                    <?php endforeach ?>
                  </select>
                  <span class="vespa_id_error text-danger"></span>
                </div>
              </div>
							<div class="col-12">
								<div class="form-group">
									<label for="service_date">Rencana Service</label>
									<div class="row">
										<div class="col-lg-6">
											<input type="date" name="service_date" <?= $readonly ?> class="form-control"  id="service_date" min="<?= date('Y-m-d') ?>" value="<?= $transaction->service_date ?>">
										</div>
										<div class="col-lg-6">
											<input type="time" name="service_time" <?= $readonly ?> class="form-control"  id="service_time" min="<?= date('H:i:s') ?>" value="<?= $transaction->service_time ?>">
										</div>
									</div>
									<!-- <input type="file" name="service_date" class="form-control" accept="image/*" id="service_date"> -->
									<span class="service_date_error text-danger"></span>
								</div>
							</div>
              <div class="col-12">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="is_general_check" value="true" id="is_general_check" <?= $transaction->is_general_check ? 'checked' : '' ?>>
                  <label class="form-check-label" for="is_general_check">
                    General Check
                  </label>
                </div>
              </div>
							<div class="col-12">
								<div class="form-group">
									<label for="concern">Keluhan</label>
									<textarea name="concern" id="concern" <?= $readonly ?> placeholder="Keluhan motor" class="form-control"><?= $transaction->concern ?></textarea>
									<span class="concern_error text-danger"></span>
								</div>
							</div>
              <input type="hidden" name="send_notif" value="<?= $transaction->send_notif ?>">  
              <?php if (!isset($this->session->userdata('userData')['customer_id'])): ?>
                <div class="col-12">
                  <div class="form-group">
                    <label for="work_estimate">Estimasi Pengerjaan</label>
                    <div class="input-group mb-2 mr-sm-2">
                        <input type="number"  name="work_estimate" id="work_estimate" min="0" value="<?= $transaction->work_estimate ?>" step="5" class="form-control">
                        <div class="input-group-append">
                          <div class="input-group-text">Menit</div>
                        </div>
                      </div>
                    <span class="work_estimate_error text-danger"></span>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">
                    <label for="repair_service">Jasa Servis</label>
                    <div class="input-group mb-2 mr-sm-2">
                        <div class="input-group-prepend">
                          <div class="input-group-text">Rp. </div>
                        </div>
                        <input type="number"  name="repair_service" id="repair_service" min="0" value="<?= $transaction->repair_service ? $transaction->repair_service : 0 ?>" step="5" class="form-control">
                      </div>
                    <span class="repair_service_error text-danger"></span>
                  </div>
                </div>
              <?php endif ?>
						</div>
					</div>
					<div class="card-footer">
						<a href="<?= base_url($this->uri->segment(1).'/'.$this->uri->segment(2)); ?>" class="btn btn-secondary" title="Back To List">Back</a>
						<button type="button" class="btn btn-primary btn-submit" id="btn-submit" data-draft="false">Submit</button>
					</div>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="card" id="right-card">
          <div class="card-body">
  					<div class="form-group">
  						<label for="workshop">Bengkel Dipilih</label>
  						<input type="text" readonly id="workshop" name="workshop" value="<?= $workshop ? $workshop->name : ''?>" class="form-control">
  						<span class="workshop_error text-danger"></span>
  					</div>
            <?php if (!isset($this->session->userdata('userData')['customer_id'])): ?>
              <div class="form-group">
                <input type="hidden" name="number" id="number" value="0"> 
                <label for="workshop">Sparepart <button id="btn_add_column" type="button" class="btn btn-primary btn-sm"> <i class="fa fa-plus"></i></button></label>
              </div>
            <?php endif ?>
  					<div id="map">
              <div class="row mt-2">
                <div class="col-lg-4">
                  <label>Sparepart</label>
                </div>
                <div class="col-lg-2">
                    <label>Qty</label>
                </div>
                <div class="col-lg-2">
                    <label>Harga</label>
                </div>
                <div class="col-lg-3">
                    <label>Subtotal</label>
                </div>
                <div class="col-lg-1">
                </div>
              </div>     
            </div>
          </div>
          
				</div>
			</div>
		</div>
	</form>
</div>

<?php if (!isset($this->session->userdata('userData')['customer_id'])): ?>
  <script>
    $(document).ready(function(){
      var repair_charge = $("#repair_service").val(); 
      $("#right-card").append(`
        <div class="card-footer">
              <table width="100%">
                <tr>
                  <th widtht="70%">Total</th>
                  <th widtht="30%" class="text-right" id="grand-total">${repair_charge}</th>
                </tr>
              </table>
            </div>
        `)

      var detail = JSON.parse(`<?= $detail?>`);
      // console.log(detail)
      for (var i = 0; i < detail.length; i++) {
        addColumn(detail[i]);
        count()
      }
      $("#btn_add_column").click(function(){
        addColumn()

      })

    })


    function addColumn(data = null)
    {
      var number = parseInt($("#number").val())+1;
      var html =`
      <div class="row mt-2">
        <div class="col-lg-4">
          <select class="select2 form-control sparepart" name="sparepart_id[]" id="sparepart_id_${number}">
            <option selected disabled>Pilih Sparepart</option>
            <?php foreach ($spareparts as $value): ?>
            <option value="<?= $value->id ?>" price="<?= $value->price?>" stock="<?= $value->stock?>"><?= $value->name ?></option>
            <?php endforeach ?>
          </select>
        </div>
        <div class="col-lg-2">
            <input type="number" name="qty[]" class="form-control"  id="qty_${number}">
        </div>
        <div class="col-lg-2">
            <input type="number" name="price[]" class="form-control"  id="price_${number}" readonly>
        </div>
        <div class="col-lg-3">
            <input type="number" name="subtotal[]" class="form-control subtotal"  id="subtotal_${number}" readonly>
        </div>
        <div class="col-lg-1">
            <button type="button" class="btn btn-danger btn-sm btn_remove_column"> <i class="fa fa-times"></i></button>
        </div>
      </div>
      `;
      $("#map").append(html)
      $('#number').val(number)

      if (data) {
        fillForm(data)
      }
      $(".select2").select2({
        theme: 'bootstrap4',
        width:'100%'
      })

      $('.sparepart').change(function(){
        var id = $(this).attr('id');
        var num = id.split('_');
        num = num[num.length - 1];
        const price = $(`#${id} option:selected`).attr('price');
        const stock = $(`#${id} option:selected`).attr('stock');
        $(`#qty_${num}`).val(1).attr('max', stock)
        $(`#price_${num}`).val(price)
        $(`#subtotal_${num}`).val(price*1)
        count()

        $(`#qty_${num}`).change(function(){
          var qty = $(this).val()
          var harga = $(`#price_${num}`).val()
          $(`#subtotal_${num}`).val(qty*harga)

          count()
        })

      })
    }

    $("#repair_service").change(function(){
      count()
    })
    function fillForm(data)
    {
      var number = parseInt($("#number").val());
      // console.log(number)
      $(`#sparepart_id_${number}`).val(data.sparepart_id).trigger('change')
      $(`#qty_${number}`).val(data.qty).trigger('change')
      $(`#price_${number}`).val(data.price).trigger('change')
      $(`#subtotal_${number}`).val(data.price*data.qty).trigger('change')
    }
    function count() {
        var i1 = 0;
        $(".subtotal").each(function (index, element) {
            i1 += parseInt(element.value) || 0;
        });
        var jasa = $("#repair_service").val()
        var gt = i1+parseInt(jasa);
        $("#grand-total").text(gt.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' }))
     }

    $(document).on('click', '.btn_remove_column', function() {
          $(this).parent().parent().remove();
          var no = parseInt($("#number").val())-1;
          $('#number').text(no)
          count()
      });

  </script>

<?php else: ?>

<script src="<?= base_url('assets/dist/leaflet/') ?>leaflet.js"></script>
<link rel="stylesheet" href="<?= base_url('assets/dist/leaflet/') ?>leaflet-routing-machine.css" />
<script src="<?= base_url('assets/dist/leaflet/') ?>leaflet-routing-machine.js"></script>
<script type="text/javascript">

	
    const latlng = {'lat':`<?= $transaction->user_lat?>`, 'long':`<?= $transaction->user_long?>`};


  var routing = ''; 
  function showRoute(datas)
  {
    var lat = $(datas).data('lat')
    var long = $(datas).data('long')
    var latnow = latlng.lat
    var longnow = latlng.long
    console.log(lat,long, latlng.lat, latlng.long)
    if (routing) {
      routing.remove();
    }

    routing = L.Routing.control({
      waypoints: [
        L.latLng(latnow,longnow),
        L.latLng(lat, long)
      ]
    }).addTo(map);

  }

  function showRoutes(lat, long)
  {
    var lat = lat
    var long = long
    var latnow = latlng.lat
    var longnow = latlng.long
    console.log(lat,long, latlng.lat, latlng.long)
    if (routing) {
      routing.remove();
    }

    routing = L.Routing.control({
      waypoints: [
        L.latLng(latnow,longnow),
        L.latLng(lat, long)
      ]
    }).addTo(map);

  }


  // var latlong = $("#latlng").val()
  var map = L.map('map');
  if (`<?= isset($workshop) ?>`) {
  	map.setView([`<?= $workshop->lat?>`, `<?= $workshop->long?>`],10)
    map.locate({setView: false, maxZoom:10});
  }else{
    map.locate({setView: true, maxZoom:10});

  }
      L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
       attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
       maxZoom: 18,
       id: 'mapbox/streets-v11',
       tileSize: 512,
       zoomOffset: -1,
       accessToken: `<?= $this->config->item('mapbox_api') ?>`
   }).addTo(map);
    var LeafIcon = L.Icon.extend({
        options: {
           iconSize:     [40, 40],
        }
    });
    var iconGarage = new LeafIcon({
        iconUrl: `${base_url}assets/garage.webp`,
    })
    // console.log(latlng)
    var marker = '';
        marker = L.marker([latlng.lat, latlng.long]).addTo(map);




    // var marker = L.marker(latlong).addTo(map);

   // L.Routing.control({
   //    waypoints: [
   //      L.latLng(-6.12308,106.961),
   //      L.latLng(-6.2114,106.8446)
   //    ]
   //  }).addTo(map);
    $(document).ready(function(){

   $.getJSON(`${base_url}/get-data-workshop`, function(data) {
           for (var i = 0; i < data.length; i++) {
             var html = `
             <div class="text-center">
             <h6><b>${data[i].name}, ${data[i].id}</b></h6>
             </div>
               <hr>
               <table class="table table-bordered table-striped" style="widht="100%>
                 <tbody>
                   <tr>
                     <th>No. HP</th>
                     <td style='color:#FC8E41'>`+data[i].phone+`</td>
                   </tr>
                   <tr>
                     <th>Email</th>
                     <td style='color:#FC8E41'>`+data[i].email+`</td>
                   </tr>
                   <tr>
                     <th>Alamat Lengkap</th>
                     <td style='color:#FC8E41'>`+data[i].address+`</td>
                   </tr>
                 </tbody>
               </table>`;
                   // <tr>
                   //   <td colspan="2" class="text-center"><b><a type="button" data-lat="${data[i].lat}" data-long="${data[i].long}"   onclick=showRoute(this)>Tampilkan Arah</a></b></td>
                    
                   // </tr>
              if (`<?= $workshop ?$workshop->id : ''?>` == `${data[i].id}`) {
		             marker = L.marker([data[i].lat, data[i].long], {id:data[i].id, name:data[i].name,icon:iconGarage}).bindPopup(`${html}`).addTo(map);
		              showRoutes(data[i].lat, data[i].long);
              }else{
		             // marker = L.marker([data[i].lat, data[i].long], {id:data[i].id, name:data[i].name,icon:iconGarage}).bindPopup(`${html}`).addTo(map);

              }
           }
         });
    })
 //          L.marker([-6.859829, 109.378317]).bindPopup('Pantai Widuri').addTo(map);
 //          L.marker([-6.869374, 109.394864]).bindPopup('Nilla Collection').addTo(map);
 //          L.marker([-6.890105, 109.380705]).bindPopup('Alun-Alun Pemalang').addTo(map);
 //          L.marker([-6.888103, 109.386499]).bindPopup('Hotel Kencana Pemalang').addTo(map);


</script>
<?php endif ?>

<script>
    $("#btn-submit").on('click', function(e){
      $(this).html(`<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
    Loading...`).attr('disabled', true);
      e.preventDefault('submit')
        $.ajax({
          url:"<?= base_url() ?>cms/data-booking/update",
          type:"POST",
          data:$('#form').serialize(),
          dataType:"JSON",
          // complete:function(a,b){
          //   console.log(a,b)
          // },
          success:function(response)
          {
            console.log(response)
            if (response.status) {
              sukses(response.alert)
               $(".swal2-confirm").click(function(){
                window.location.href = `${base_url}cms/data-booking`
              })
            } else {
              var error = response.error
              $.each(error, function(key, value) {

                  $('.' + key + '_error').html(value.length > 0 ? `<i class="fa fa-exclamation"> </i> ${value}` : value)
                  $('#' + key).removeClass('is-invalid').addClass(value.length > 0 ? 'is-invalid' : 'is-valid').find('.text-danger').remove()
                })
              warning(response.alert)
            }
              $('#btn-submit').html(`Submit`).attr('disabled', false);
          },
          error:function(e)
          {
            $('#btn-submit').html(`Submit`).attr('disabled', false);
          }
        })
      })
</script>