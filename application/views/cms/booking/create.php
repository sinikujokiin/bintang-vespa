<link rel="stylesheet" href="<?= base_url('assets/dist/leaflet/') ?>leaflet.css">
<style type="text/css">
    #map {
        height: 500px;
    }
</style>
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
									<input type="hidden" name="user_lat" id="user_lat" value="">
									<input type="hidden" name="user_long" id="user_long" value="">
									<label for="customer_id">Pelanggan</label>
									<?php if ($this->session->userdata('userData')['role_id'] != 0): ?>
									<select class="select2 form-control" name="customer_id" id="customer_id">
										<?php foreach ($customers as $value): ?>
										<option value="<?= $value->id ?>"><?= $value->name ?></option>
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
                  <select class="select2 form-control" name="vespa_id" id="vespa_id">
                    <option selected disabled>Pilih Jenis Vespa</option>
                    <?php foreach ($vespa as $value): ?>
                    <option value="<?= $value->id ?>" title="<?= $value->description ?>"><?= $value->name ?> (<?= $value->year ?>)</option>
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
											<input type="date" name="service_date" class="form-control"  id="service_date" min="<?= date('Y-m-d') ?>" value="<?= date('Y-m-d') ?>">
										</div>
										<div class="col-lg-6">
											<input type="time" name="service_time" class="form-control"  id="service_time" min="<?= date('H:i:s') ?>" step="3600" value="<?= date('H:i:s') ?>">
										</div>
									</div>
									<!-- <input type="file" name="service_date" class="form-control" accept="image/*" id="service_date"> -->
									<span class="service_date_error text-danger"></span>
								</div>
							</div>
              <div class="col-12">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="true" name="is_general_check" id="is_general_check" checked>
                  <label class="form-check-label" for="is_general_check">
                    General Check
                  </label>
                </div>
              </div>
							<div class="col-12">
								<div class="form-group">
									<label for="concern">Keluhan</label>
									<textarea name="concern" id="concern" placeholder="Keluhan motor" class="form-control"></textarea>
									<span class="concern_error text-danger"></span>
								</div>
							</div>
						</div>
					</div>
					<div class="card-footer">
						<a href="<?= base_url($this->uri->segment(1).'/'.$this->uri->segment(2)); ?>" class="btn btn-secondary" title="Back To List">Back</a>
						<button type="button" class="btn btn-primary btn-submit" id="btn-submit" data-draft="false">Submit</button>
					</div>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="card card-body">
					<div class="form-group">
						<label for="workshop">Bengkel Dipilih</label>
						<input type="text" readonly id="workshop" name="workshop" value="<?= $workshop ? $workshop->name : ''?>" class="form-control">
						<span class="workshop_error text-danger"></span>
					</div>
					<div id="map"></div>
				</div>
			</div>
		</div>
	</form>
</div>



<script src="<?= base_url('assets/dist/leaflet/') ?>leaflet.js"></script>
<link rel="stylesheet" href="<?= base_url('assets/dist/leaflet/') ?>leaflet-routing-machine.css" />
<script src="<?= base_url('assets/dist/leaflet/') ?>leaflet-routing-machine.js"></script>
<script type="text/javascript">

	$("#btn-submit").on('click', function(e){
    $(this).html(`<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
  Loading...`).attr('disabled', true);
    e.preventDefault('submit')
      $.ajax({
        url:"<?= base_url() ?>cms/data-booking/store",
        type:"POST",
        data:$('#form').serialize(),
        dataType:"JSON",
        complete:function(){
              $('#btn-submit').html(`Submit`).attr('disabled', false);
        },
        success:function(response)
        {
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
        },
        error:function(e)
        {
          $('#btn-submit').html(`Submit`).attr('disabled', false);
        }
      })
    })
  navigator.geolocation.getCurrentPosition(function(location) {
    const latlng = new L.LatLng(location.coords.latitude, location.coords.longitude);
    $("#latlng").val(latlng)
 
  });


  var routing = ''; 
  function showRoute(datas)
  {
    var lat = $(datas).data('lat')
    var long = $(datas).data('long')
    var latnow = latlng.lat
    var longnow = latlng.lng
    console.log(lat,long, latlng.lat, latlng.lng)
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
    var longnow = latlng.lng
    console.log(lat,long, latlng.lat, latlng.lng)
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
  </script>
  <?php if ($workshop): ?>
    <script>
      map.setView([`<?= $workshop->lat?>`, `<?= $workshop->long?>`],10)
      map.locate({setView: false, maxZoom:10});
      
    </script>
  <?php else: ?>
    <script>
      
      map.locate({setView: true, maxZoom:10});
    </script>
  <?php endif ?>
  <script>
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
    var latlng = '';
    var marker = '';
    function onLocationFound(e) {
        latlng = e.latlng;
        // console.log(latlng.lat,latlng.lng)
        $("#user_lat").val(latlng.lat)
        $("#user_long").val(latlng.lng)
        marker = L.marker(e.latlng).bindPopup('Lokasi Anda Saat ini').addTo(map).openPopup();

    }

    function onLocationError(e) {
        alert("Lokasi Anda tidak dapat ditemukan");
    }

    map.on('locationfound', onLocationFound);
    map.on('locationerror', onLocationError);



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
		             marker = L.marker([data[i].lat, data[i].long], {id:data[i].id, name:data[i].name,icon:iconGarage}).bindPopup(`${html}`).addTo(map);

              }

              // tambahkan event listener untuk klik marker

              marker.on('click', function(e) {
              	$("#workshop_id").val(e.target.options.id)
              	$("#workshop").val(e.target.options.name)
              	showRoutes(e.target._latlng.lat, e.target._latlng.lng)
              	// console.log(marker.options.id)
              });
           }
         });
    })
 //          L.marker([-6.859829, 109.378317]).bindPopup('Pantai Widuri').addTo(map);
 //          L.marker([-6.869374, 109.394864]).bindPopup('Nilla Collection').addTo(map);
 //          L.marker([-6.890105, 109.380705]).bindPopup('Alun-Alun Pemalang').addTo(map);
 //          L.marker([-6.888103, 109.386499]).bindPopup('Hotel Kencana Pemalang').addTo(map);


   function bookingNow(datas)
   {
      var href = $(datas).data('href');

      window.location.href=`${href}`;
   }
</script>