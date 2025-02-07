<link rel="stylesheet" href="<?= base_url('assets/dist/leaflet/') ?>leaflet.css">
<style type="text/css">
    #map {
        height: 500px;
    }
</style>
<div class="banner-area" id="home">
  <div class="container-fluid">
    <div class="row align-items-center">
      <div class="col-lg-6">
        <div class="banner-content">
          <span>Selamat datang di <?= $web->website_name ?></span>
          <h1>Kami Melayani Dengan Sepenuh Hati</h1>
          <p>
            <?= $web->about ?>
          </p>
          <div class="banner-btn">
            <a href="#" class="get-btn">Hubungi Kami</a>
          </div>
        </div>
      </div>
      <div class="col-lg-6 pe-0">
        <div class="banner-img">
          <img src="<?= base_url('assets/landing/') ?>img/home-two.jpg" alt="Images">
        </div>
      </div>
    </div>
  </div>
</div>
<div class="brand-area">
  <div class="container">
    <div class="brand-slider owl-carousel owl-theme">
      <div class="brand-item">
        <img src="<?= base_url('assets/landing/') ?>img/brand/brand-1.png" alt="Images">
      </div>
      <div class="brand-item">
        <img src="<?= base_url('assets/landing/') ?>img/brand/brand-2.png" alt="Images">
      </div>
      <div class="brand-item">
        <img src="<?= base_url('assets/landing/') ?>img/brand/brand-3.png" alt="Images">
      </div>
      <div class="brand-item">
        <img src="<?= base_url('assets/landing/') ?>img/brand/brand-4.png" alt="Images">
      </div>
      <div class="brand-item">
        <img src="<?= base_url('assets/landing/') ?>img/brand/brand-5.png" alt="Images">
      </div>
      <div class="brand-item">
        <img src="<?= base_url('assets/landing/') ?>img/brand/brand-6.png" alt="Images">
      </div>
      <div class="brand-item">
        <img src="<?= base_url('assets/landing/') ?>img/brand/brand-1.png" alt="Images">
      </div>
    </div>
  </div>
</div>
<div class="choose-area pt-100 pb-70">
  <div class="container">
    <div class="section-title text-center">
      <span class="span-bg">Mengapa Harus Menggunakan Jasa Kami?</span>
      <!-- <h2>Kami punya rencana terbaik untuk Anda. </h2> -->
    </div>
    <div class="row pt-45 justify-content-center">
      <div class="col-lg-4 col-sm-6">
        <div class="choose-item">
          <div class="choose-item-icon one-bg">
            <i class='bx bx-user-check'></i>
          </div>
          <h3>Tenaga Ahli</h3>
          <p>Tenaga ahli berpengalaman untuk perbaikan dan perawatan Vespa.</p>
          <!-- <a href="#" class="read-more">
            Read More <i class="bx bx-right-arrow-alt"></i>
          </a> -->
        </div>
      </div>
      <div class="col-lg-4 col-sm-6">
        <div class="choose-item">
          <div class="choose-item-icon two-bg">
            <i class='bx bx-package'></i>
          </div>
          <h3>Suku Cadang Berkualitas</h3>
          <p>Suku cadang dan aksesoris asli Vespa berkualitas tinggi.</p>
          <!-- <a href="#" class="read-more">
            Read More <i class="right-icon bx bx-right-arrow-alt"></i>
          </a> -->
        </div>
      </div>
      <div class="col-lg-4 col-sm-6 offset-lg-0 offset-sm-3">
        <div class="choose-item">
          <div class="choose-item-icon three-bg">
            <i class='bx bx-happy-beaming'></i>
          </div>
          <h3>Pelayanan Ramah</h3>
          <p>Pelayanan ramah dan profesional dengan estimasi biaya transparan.</p>
          <!-- <a href="#" class="read-more">
            Read More <i class="right-icon bx bx-right-arrow-alt"></i>
          </a> -->
        </div>
      </div>

      <div class="col-lg-4 col-sm-6 offset-lg-0 offset-sm-3">
        <div class="choose-item">
          <div class="choose-item-icon one-bg">
            <i class='bx bx-happy-beaming'></i>
          </div>
          <h3>Kecepatan dan ketepatan waktu</h3>
          <p>Kecepatan dan ketepatan waktu dalam menyelesaikan perbaikan.</p>
          <!-- <a href="#" class="read-more">
            Read More <i class="right-icon bx bx-right-arrow-alt"></i>
          </a> -->
        </div>
      </div>

      <div class="col-lg-4 col-sm-6 offset-lg-0 offset-sm-3">
        <div class="choose-item">
          <div class="choose-item-icon three-bg">
            <i class='bx bx-happy-beaming'></i>
          </div>
          <h3>Konsultasi teknis gratis</h3>
          <p>Konsultasi teknis gratis untuk pemahaman kendaraan Vespa.</p>
          <!-- <a href="#" class="read-more">
            Read More <i class="right-icon bx bx-right-arrow-alt"></i>
          </a> -->
        </div>
      </div>
    </div>
  </div>
</div>
<div class="about-area pb-70" id="about">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-6">
        <div class="about-img-2">
          <img src="<?= base_url('assets/landing/') ?>img/about/about-img2.jpg" alt="Images">
        </div>
      </div>
      <div class="col-lg-6 ">
        <div class="about-content">
          <div class="section-title">
            <span class="span-bg">Tentang <?= $web->website_name ?></span>
            <h2>Kami Memiliki Pengalaman Lebih dari 5 Tahun</h2>
            <p>
              Bintang Vespa adalah sebuah bengkel spesialis yang terletak di kota yang menyediakan jasa perbaikan dan perawatan kendaraan Vespa. Bengkel ini memiliki tenaga ahli yang terampil dan berpengalaman dalam melakukan berbagai jenis perbaikan pada kendaraan Vespa, mulai dari perawatan rutin hingga perbaikan mesin yang lebih kompleks. Bintang Vespa juga menyediakan berbagai suku cadang dan aksesoris asli Vespa yang berkualitas tinggi, sehingga dapat memastikan bahwa kendaraan Vespa pelanggan selalu dalam kondisi prima dan terawat dengan baik. Dengan pelayanan yang ramah dan profesional, Bintang Vespa menjadi pilihan utama bagi para pemilik kendaraan Vespa yang membutuhkan jasa perawatan dan perbaikan yang handal dan berkualitas.
            </p>
          </div>
          <ul>
            <li>
              <i class='bx bx-check-circle'></i>
              Tenaga ahli yang berpengalaman
            </li>
            <li>
              <i class='bx bx-check-circle'></i>
              Suku cadang dan aksesoris asli Vespa
            </li>
            <li>
              <i class='bx bx-check-circle'></i>
              Pelayanan ramah dan profesional
            </li>
            <li>
              <i class='bx bx-check-circle'></i>
              Kecepatan dan ketepatan waktu
            </li>
            <li>
              <i class='bx bx-check-circle'></i>
              Konsultasi teknis gratis
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="pricing-area pricing-bg pt-100 pb-70" id="services">
  <div class="container">
    <div class="section-title text-center">
      <span class="span-bg">Layanan</span>
      <h4>Kami selalu siap untuk <br> memberikan Anda layanan terbaik.</h4>
    </div>
    <div class="row">
      <div class="col-lg-4 col-sm-6">
        <div class="pricing-card">
          <div class="pricing-card-into color-bg1">
            <i class="bx bx-paper-plane pricing-icon color-1"></i>
            <h3 class="color-1">Perbaikan dan perawatan kendaraan Vespa</h3>
            <p>Bengkel Bintang Vespa memiliki tenaga ahli yang berpengalaman dalam melakukan perbaikan dan perawatan kendaraan Vespa, mulai dari perawatan rutin hingga perbaikan mesin yang lebih kompleks</p>
         
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-sm-6">
        <div class="pricing-card">
          <div class="pricing-card-into color-bg2">
            <i class="bx bx-paper-plane pricing-icon color-2"></i>
            <h3 class="color-2">Penjualan suku cadang dan aksesoris asli Vespa</h3>
            <p>Bengkel Bintang Vespa menyediakan berbagai suku cadang dan aksesoris asli Vespa berkualitas tinggi untuk memastikan bahwa kendaraan Vespa pelanggan selalu dalam kondisi prima.</p>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-sm-6 offset-sm-3 offset-lg-0">
        <div class="pricing-card">
          <div class="pricing-card-into color-bg3">
            <i class="bx bx-paper-plane pricing-icon color-3"></i>
            <h3 class="color-3">Konsultasi teknis terkait kendaraan Vespa</h3>
            <p> Bengkel Bintang Vespa juga menyediakan layanan konsultasi teknis terkait kendaraan Vespa untuk membantu pelanggan memahami lebih baik tentang kendaraan Vespa mereka.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="counter-area pt-100 pb-70" id="branch">
  <div class="container">
    <div id="map"></div>
  </div>
</div>



<div class="contact-area pricing-bg pt-100 pb-70" id="contact">
    <div class="container">
        <div class="row">
            <div class="col-12">
              <div class="section-title">
                  <span class="span-bg">Kontak Kami</span>
                  <!-- <h2>Keep in Touch</h2> -->
                  <!-- <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris ante nisi, feugiat vel leo eget, dictum.</p> -->
              </div>
                <div class="contact-sidebar" style="background-color: white;">
                    <!-- <h2>Our Contact Details</h2> -->
                    <!-- <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris ante nisi, feugiat vel leo eget, dictum.</p> -->
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-12">
                            <div class="contact-card">
                                <i class='bx bx-home-smile'></i>
                                <div class="content">
                                    <h3>Alamat</h3>
                                    <p><a target="__BLANK" href="<?= $web->link_map ?>"><?= $web->address ?></a></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-12">
                            <div class="contact-card">
                                <i class='bx bx-phone-call'></i>
                                <div class="content">
                                    <h3>No. Telepon</h3>
                                    <p><a target="__BLANK" href="tel:<?= $web->phone ?>"><?= $web->phone ?></a></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-12">
                            <div class="contact-card">
                                <i class='bx bxs-envelope'></i>
                                <div class="content">
                                    <h3>Email</h3>
                                    <p><a target="__BLANK" href="mailto:<?= $web->email ?>"><?= $web->email ?></a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url('assets/dist/leaflet/') ?>leaflet.js"></script>
<link rel="stylesheet" href="<?= base_url('assets/dist/leaflet/') ?>leaflet-routing-machine.css" />
<script src="<?= base_url('assets/dist/leaflet/') ?>leaflet-routing-machine.js"></script>
<script type="text/javascript">

  navigator.geolocation.getCurrentPosition(function(location) {
    const latlng = new L.LatLng(location.coords.latitude, location.coords.longitude);
    $("#latlng").val(latlng)
  //     var map = L.map('map').setView(latlng, 13)
  //     L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
  //      attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
  //      maxZoom: 18,
  //      id: 'mapbox/streets-v11',
  //      tileSize: 512,
  //      zoomOffset: -1,
  //      accessToken: `<?= $this->config->item('mapbox_api') ?>`
  //  }).addTo(map);
  //   var LeafIcon = L.Icon.extend({
  //       options: {
  //          iconSize:     [50, 50],
  //       }
  //   });
  //   var iconGarage = new LeafIcon({
  //       iconUrl: `${base_url}assets/garage.webp`,
  //   })

  //   var marker = L.marker(latlng).addTo(map);
  //     $.getJSON(`${base_url}/get-data-workshop`, function(data) {
  //       for (var i = 0; i < data.length; i++) {
  //         var html = `
  //         <div class="text-center">
  //         <h6><b>${data[i].name}</b></h6>
  //         </div>
  //           <hr>
  //           <table class="table table-bordered table-striped" style="widht="100%>
  //             <tbody>
  //               <tr>
  //                 <th>No. HP</th>
  //                 <td style='color:#FC8E41'>`+data[i].phone+`</td>
  //               </tr>
  //               <tr>
  //                 <th>Email</th>
  //                 <td style='color:#FC8E41'>`+data[i].email+`</td>
  //               </tr>
  //               <tr>
  //                 <th>Alamat Lengkap</th>
  //                 <td style='color:#FC8E41'>`+data[i].address+`</td>
  //               </tr>
  //               <tr>
  //                 <td colspan="" class="text-center"><b><a type="button" data-lat="${data[i].lat}" data-latnow="${location.coords.latitude}" data-long="${data[i].long}"  data-longnow="${location.coords.longitude}" onclick=showRoute(this)>Tampilkan Arah</a></b></td>
  //                 <td colspan="" class="text-center"><b><a target="_blank" href="">Booking Sekarang</a></b></td>
  //               </tr>
  //             </tbody>
  //           </table>`;
  //         L.marker([data[i].lat, data[i].long], {icon:iconGarage}).bindPopup(`${html}`).addTo(map);
  //       }
  //     });
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


  // var latlong = $("#latlng").val()
  var map = L.map('map');
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
    var marer = '';
    function onLocationFound(e) {
        latlng = e.latlng;
        marker = L.marker(e.latlng).bindPopup('Lokasi Anda Saat ini').addTo(map).openPopup();

    }

    function onLocationError(e) {
        alert("Lokasi Anda tidak dapat ditemukan");
    }

    map.on('locationfound', onLocationFound);
    map.on('locationerror', onLocationError);

    map.locate({setView: true, maxZoom: 16});
    // var marker = L.marker(latlong).addTo(map);

   // L.Routing.control({
   //    waypoints: [
   //      L.latLng(-6.12308,106.961),
   //      L.latLng(-6.2114,106.8446)
   //    ]
   //  }).addTo(map);
   $.getJSON(`${base_url}/get-data-workshop`, function(data) {
           for (var i = 0; i < data.length; i++) {
             var html = `
             <div class="text-center">
             <h6><b>${data[i].name}</b></h6>
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
                   <tr>
                     <td colspan="" class="text-center"><b><a type="button" data-lat="${data[i].lat}" data-long="${data[i].long}"   onclick=showRoute(this)>Tampilkan Arah</a></b></td>
                     <td colspan="" class="text-center"><b><a type="button" data-href="${base_url}booking-now?id=${data[i].id}" onclick=bookingNow(this)>Booking Sekarang</a></b></td>
                   </tr>
                 </tbody>
               </table>`;
             marker = L.marker([data[i].lat, data[i].long], {icon:iconGarage}).bindPopup(`${html}`).addTo(map);
           }
         });
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