<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.2/dist/leaflet.css">
<style type="text/css">
    #map {
        height: 250px;
    }
</style>
<div class="contaner-fluid">
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
				  <h3 class="card-title title-card">
				    <?= $title ?>
				  </h3>
				</div>
	        <form id="form">
				<div class="card-body">
					<div class="row">
					  <div class="col-12">
					    <div class="form-group">
					      <label for="name">Nama Bengkel</label>
					      <input type="hidden" name="id" class="form-control" id="id" value="<?= encrypt_decrypt('encrypt',$data->id) ?>">
					      <input type="text" name="name" class="form-control" id="name" value="<?= $data->name ?>" placeholder="nama bengkel">
					      <span class="name_error text-danger"></span>
					    </div>
					  </div>
					  <div class="col-12">
					    <div class="form-group">
					      <label for="phone">No Telepon</label>
					      <input type="text" name="phone" class="form-control" id="phone" value="<?= $data->phone ?>" placeholder="no telepon bengkel">
					      <span class="phone_error text-danger"></span>
					    </div>
					  </div>
					  <div class="col-12">
					    <div class="form-group">
					      <label for="email">Email</label>
					      <input type="email" name="email" class="form-control" id="email" value="<?= $data->email ?>" placeholder="email bengkel">
					      <span class="email_error text-danger"></span>
					    </div>
					  </div>
					  <div class="col-12">
					    <div class="form-group">
					      <label for="address">Alamat Lengkap</label>
					      <textarea name="address" id="address" placeholder="alamat lengkap" class="form-control"><?= $data->address ?></textarea>
					      <span class="address_error text-danger"></span>
					    </div>
					  </div>
					  <div class="col-12">
					  	<div class="row">
					  	    <div class="col-md-6 col-12">
					  	        <div id="map"></div>
					  	    </div>
					  	    <div class="col-md-6 col-12">
					  	        <!-- Lat Field -->
					  	        <div class="form-group">
					  	            <label for="lat" class="form-label">Lat</label><span class="text-danger">*</span>
					  	            <input class="form-control" required readonly name="lat" type="text" value="<?= $data->lat ?>" id="lat">
					  	        </div>

					  	        <!-- Long Field -->
					  	        <div class="form-group">
					  	            <label for="long" class="form-label">Long</label><span class="text-danger">*</span>
					  	            <input class="form-control" required readonly name="long" type="text" value="<?= $data->long ?>" id="long">
					  	        </div>

					  	        <div class="form-group">
					  	            <label for="link" class="form-label">Link</label><span class="text-danger">*</span>
					  	            <input class="form-control" required name="link" type="url" value="<?= $data->link ?>" id="link">
					  	        </div>
					  	    </div>
					  	</div>
					  </div>
					</div>
				</div>
				<div class="card-footer">
					<a href="<?= base_url($this->uri->segment(1).'/'.$this->uri->segment(2)); ?>" class="btn btn-secondary" title="Back To List">Back</a>
					<button type="button" class="btn btn-primary btn-submit" id="btn-submit" data-draft="false">Submit</button>
				</div>
			</form>
			</div>
		</div>
	</div>
</div>


<script src="https://unpkg.com/leaflet@1.9.2/dist/leaflet.js"></script>

<script>
    var lat    = `<?= $data->lat?>`;
    var long   = `<?= $data->long?>`;
    var radius = 0;
    var map    = L.map('map').setView([lat, long], 15);;
    var marker = undefined;
    var circle = undefined;

    var tiles = L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
     attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
     maxZoom: 18,
     id: 'mapbox/streets-v11',
     tileSize: 512,
     zoomOffset: -1,
     accessToken: `<?= $this->config->item('mapbox_api') ?>`
 }).addTo(map);

    updateMarker(lat,long);
    
    function onMapClick(e) {
        lat  = e.latlng.lat;
        long = e.latlng.lng;

        $("#lat").val(lat);
        $("#long").val(long);

        updateMarker(lat, long);

        // if (radius) {
        //     updateCircle();
        // }
    }
    map.on('click', onMapClick);

    function updateMarker(lat, long) {
        if (marker != undefined) {
            map.removeLayer(marker);
        };
        marker = L.marker([lat, long], {draggable: true}).addTo(map)
            .on('dragend', function (e) {
                lat  = marker.getLatLng().lat;
                long = marker.getLatLng().lng;

                $("#lat").val(lat)
                $("#long").val(long)

                if (radius) {
                    updateCircle()
                }
            });
    }

    // function updateCircle() {
    //     if (circle != undefined) {
    //         map.removeLayer(circle);
    //     };

    //     circle = L.circle([lat, long], {
    //         color: 'red',
    //         fillColor: '#f03',
    //         fillOpacity: 0.5,
    //         radius: radius
    //     }).addTo(map);
    // }

    // $(document).on('input', '#radius', function() {
    //     radius = $(this).val();

    //     if (radius) {
    //         updateCircle()
    //     } else {
    //         map.removeLayer(circle);
    //     }
    // });
</script>

<script>


    $('.btn-submit').click(function(e){
	    e.preventDefault('submit')
	    var formData = new FormData($('#form')[0]);
	    $.ajax({
	      url:base_url+'cms/save-workshop/update',
	      dataType:'json',
	      type:'POST',
	      data: formData,
	      contentType: false,
	      processData: false,
	      success: (response) =>{

	        if (response.status) {
	          sukses(response.alert);
		          $(".swal2-confirm").click(function(){
		            window.location.href = `${base_url}cms/data-workshop`
		          })
	        }else{
	          var error = response.error
	          $.each(error, function(key, value) {

	            $('.' + key + '_error').html(value.length > 0 ? `<i class="fa fa-exclamation"> ${value}</i>` : value)
	            $('#' + key).removeClass('is-invalid').addClass(value.length > 0 ? 'is-invalid' : 'is-valid').find('.text-danger').remove()
	          })
	        }

	      }
	    })
	  })
</script>