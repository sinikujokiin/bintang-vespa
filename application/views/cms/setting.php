<div class="container-fluid">
	<div class="row">
		<div class="col-12">
			<div class="card card-dark">
				<div class="card-header">
					<h3 class="card-title title-card text-light">
					  <?= $title ?>
					</h3>
				</div>
				<div class="card-body">
					<form id="form">
						<div id="accordion">
							<div class="card card-primary">
								<div class="card-header">
									<h4 class="card-title w-100">
										<a class="d-block w-100" data-toggle="collapse" href="#collapseOne">
											Profile Website
										</a>
									</h4>
								</div>
								<div id="collapseOne" class="collapse" data-parent="#accordion">
									<div class="card-body">
										<div class="row">
											<div class="col-lg-6 col-sm-12">
												<div class="form-group">
													<label>Logo Website</label>
													<div style="background: grey; width:50%; padding: 4px;" class="mb-3">
														<img src="<?= base_url('assets/'.$data['logo']) ?>" id="current-logo" width="100%" style="background: inverse;" alt="">
													</div>
													<input type="file" name="logo" id="logo" class="form-control" placeholder="Logo Website">
													<input type="hidden" name="id_web" value="<?= encrypt_decrypt("encrypt", $data['id_web']) ?>">
													<span class="logo_error text-danger"></span>
												</div>
												<div class="form-group">
													<label>Icon Website</label>
													<div style="background: grey; width:15%; padding: 4px;" class="mb-3">
														<img src="<?= base_url('assets/'.$data['icon']) ?>" id="current-icon" width="100%" style="background: inverse;" alt="">
													</div>
													<input type="file" name="icon" id="icon" class="form-control" placeholder="Logo Website">
													<span class="icon_error text-danger"></span>
												</div>
											</div>
											<div class="col-lg-6 col-sm-12">
												<div class="form-group">
													<label>Website Name</label>
													<input type="text" name="website_name" id="website_name" class="form-control" value="<?= $data['website_name']?>" placeholder="Website Name">
													<span class="website_name_error text-danger"></span>

												</div>
												<div class="form-group">
													<label>Email</label>
													<input type="email" name="email" id="email" class="form-control" value="<?= $data['email']?>" placeholder="Email">
													<span class="email_error text-danger"></span>
												</div>
												<div class="form-group">
													<label>Phone</label>
													<input type="text" name="phone" id="phone" class="form-control" value="<?= $data['phone']?>" placeholder="Phone">
													<span class="phone_error text-danger"></span>
												</div>
												<div class="form-group">
													<label>Address</label>
													<textarea name="address" rows="3" id="address" class="form-control" placeholder="Address"><?= $data['address']?></textarea>
													<span class="address_error text-danger"></span>
												</div>
												<div class="form-group">
													<label>Maps </label> <a href="javascript:void(0)" onclick="showMap(this)"  data-iframe='<?= $data['link_map'] ?>'>Show Maps</a>
													<textarea name="link_map" rows="2" id="link_map" class="form-control" placeholder="Maps"><?= $data['link_map']?></textarea>
													<span class="link_map_error text-danger"></span>
												</div>
											</div>
											<div class="form-group col-12">
												<label>About <?= $data['website_name']?></label>
												<textarea class="form-control" id="about" name="about"><?= $data['about']?></textarea>
												<span class="about_error text-danger"></span>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="card card-primary">
								<div class="card-header">
									<h4 class="card-title w-100">
										<a class="d-block w-100" data-toggle="collapse" href="#collapseTwo">
											Sosial Media
										</a>
									</h4>
								</div>
								<div id="collapseTwo" class="collapse" data-parent="#accordion">
									<div class="card-body">
										<div class="row">
											<div class="form-group col-lg-6 col-12">
												<label>Link Facebook</label>
												<textarea class="form-control" id="link_fb" name="link_fb"><?= $data['link_fb']?></textarea>
												<span class="link_fb_error text-danger"></span>
											</div>
											<div class="form-group col-lg-6 col-12">
												<label>Nama Facebook</label>
												<input type="text" class="form-control" id="nama_fb" name="nama_fb" value="<?= $data['nama_fb']?>">
												<span class="nama_fb_error text-danger"></span>
											</div>
											<div class="form-group col-lg-6 col-12">
												<label>Link Instagram</label>
												<textarea class="form-control" id="link_ig" name="link_ig"><?= $data['link_ig']?></textarea>
												<span class="link_ig_error text-danger"></span>
											</div>
											<div class="form-group col-lg-6 col-12">
												<label>Nama Instagram</label>
												<input type="text" class="form-control" id="nama_ig" name="nama_ig" value="<?= $data['nama_ig']?>">
												<span class="nama_ig_error text-danger"></span>
											</div>
											<div class="form-group col-lg-6 col-12">
												<label>Link Twitter</label>
												<textarea class="form-control" id="link_twitter" name="link_twitter"><?= $data['link_twitter']?></textarea>
												<span class="link_twitter_error text-danger"></span>
											</div>
											<div class="form-group col-lg-6 col-12">
												<label>Nama Twitter</label>
												<input type="text" class="form-control" id="nama_twitter" name="nama_twitter" value="<?= $data['nama_twitter']?>">
												<span class="nama_twitter_error text-danger"></span>
											</div>
											<div class="form-group col-lg-6 col-12">
												<label>Link Tiktok</label>
												<textarea class="form-control" id="link_tiktok" name="link_tiktok"><?= $data['link_tiktok']?></textarea>
												<span class="link_tiktok_error text-danger"></span>
											</div>
											<div class="form-group col-lg-6 col-12">
												<label>Nama Tiktok</label>
												<input type="text" class="form-control" id="nama_tiktok" name="nama_tiktok" value="<?= $data['nama_tiktok']?>">
												<span class="nama_tiktok_error text-danger"></span>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="card card-primary">
								<div class="card-header">
									<h4 class="card-title w-100">
										<a class="d-block w-100" data-toggle="collapse" href="#collapseSEO">
											SEO
										</a>
									</h4>
								</div>
								<div id="collapseSEO" class="collapse" data-parent="#accordion">
									<div class="card-body">
										<div class="row">
											<div class="form-group col-lg-6 col-12">
												<label>keyword</label>
												<textarea class="form-control" name="keyword" id="keyword" placeholder="Gunakan ,'koma' untuk memisahkan"><?= $data['keyword'] ?></textarea>
												<span class="keyword_error text-danger"></span>
											</div>
											<div class="form-group col-lg-6 col-12">
												<label>Deskripsi</label>
												<textarea class="form-control" name="deskripsi" id="deskripsi"><?= $data['deskripsi'] ?></textarea>
												<span class="deskripsi_error text-danger"></span>
											</div>
											<div class="form-group col-lg-6 col-12">
												<label>Google Tag</label>
												<textarea class="form-control" name="g_tag" id="g_tag"><?= $data['g_tag'] ?></textarea>
												<span class="g_tag_error text-danger"></span>
											</div>
											<div class="form-group col-lg-6 col-12">
												<label>Script Google Tag</label>
												<textarea class="form-control" name="script_g_tag" id="script_g_tag"><?= $data['script_g_tag'] ?></textarea>
												<span class="script_g_tag_error text-danger"></span>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
							<div class="col-12 text-right">
								<button class="btn btn-primary" type="submit" id="btn-submit">Submit</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>


<div class="modal" id="modal-map" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Location <?= $data['website_name'] ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="iframe-map">
      </div>
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<script>
	function showMap(data)
	{
		var iframe = $(data).data("iframe")

		$("#modal-map").modal("show")
		$("#iframe-map").html(iframe)
		$("iframe").attr("width", "100%")

	}

	$("#logo, #icon").change(function(){
	   bacaGambar(this);
	});

	function bacaGambar(input) {
		var name = input.name
	   if (input.files && input.files[0]) {
	      var reader = new FileReader();
	 
	      reader.onload = function (e) {
	          $('#current-'+name).attr('src', e.target.result);
	      }
	 
	      reader.readAsDataURL(input.files[0]);
	   }
	}


	$('#btn-submit').click(function(e){
	  e.preventDefault('submit')
	  var formData = new FormData($('#form')[0]);
	  $.ajax({
	    url:base_url+'cms/update-profile-website',
	    dataType:'json',
	    type:'POST',
	    data: formData,
	    contentType: false,
	    processData: false,
	    success: (response) =>{

	      if (response.status) {
	        sukses(response.alert);
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