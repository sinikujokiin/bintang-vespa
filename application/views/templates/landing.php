
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('assets/landing/') ?>css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/landing/') ?>css/animate.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/landing/') ?>fonts/flaticon.css">
    <link rel="stylesheet" href="<?= base_url('assets/landing/') ?>css/boxicons.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/landing/') ?>css/owl.carousel.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/landing/') ?>css/owl.theme.default.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/landing/') ?>css/nice-select.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/landing/') ?>css/meanmenu.css">
    <link rel="stylesheet" href="<?= base_url('assets/landing/') ?>css/style.css">
    <link rel="stylesheet" href="<?= base_url('assets/landing/') ?>css/responsive.css">
    <title><?= $web->website_name ?></title>
    <link rel="icon" type="image/png" href="<?= base_url('assets/'.$web->icon) ?>">
    <script>
      var base_url = `<?= base_url()?>`
    </script>
    <script src="<?= base_url('assets/landing/') ?>js/jquery.min.js"></script>
    <script src="<?= base_url('assets/landing/') ?>js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('assets/landing/') ?>js/owl.carousel.min.js"></script>
  </head>
  <body>
    <div class="preloader">
      <div class="d-table">
        <div class="d-table-cell">
          <div class="spinner"></div>
        </div>
      </div>
    </div>
    <header class="top-header">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-8 col-md-9">
            <div class="header-left">
              <div class="header-left-card">
                <ul>
                  <li>
                    <div class="head-icon">
                      <i class='bx bx-home-smile'></i>
                    </div>
                    <a href="#"><?= $web->address ?></a>
                  </li>
                  <li>
                    <div class="head-icon">
                      <i class='bx bx-phone-call'></i>
                    </div>
                    <a href="tel:<?= $web->phone ?>"><?= $web->phone ?></a>
                  </li>
                  <li>
                    <div class="head-icon">
                      <i class='bx bxs-envelope'></i>
                    </div>
                    <a href="mailto:<?= $web->email ?>"><?= $web->email ?></span></a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-3">
            <div class="header-right">
              <div class="top-social-link">
                <ul>
                  <?php if ($web->nama_ig && $web->link_ig): ?>
                    <li>
                      <a href="<?= $web->link_ig ?>" target="_blank">
                        <i class='bx bxl-instagram'></i>
                      </a>
                    </li>
                  <?php endif ?>
                  <?php if ($web->nama_twitter && $web->link_twitter): ?>
                  <li>
                    <a href="<?= $web->link_twitter ?>" target="_blank">
                      <i class='bx bxl-twitter'></i>
                    </a>
                  </li>
                  <?php endif ?>
                  <?php if ($web->nama_fb && $web->link_fb): ?>
                  <li>
                    <a href="<?= $web->link_fb ?>" target="_blank">
                      <i class='bx bxl-facebook'></i>
                    </a>
                  </li>
                  <?php endif ?>
                  <?php if ($web->nama_tiktok && $web->link_tiktok): ?>
                  <li>
                    <a href="<?= $web->link_tiktok ?>" target="_blank">
                      <i class='bx bxl-tiktok'></i>
                    </a>
                  </li>
                  <?php endif ?>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </header>
    <div class="navbar-area">
      <div class="mobile-nav">
        <a href="<?= base_url() ?>" class="logo">
          <img src="<?= base_url('assets/'.$web->logo) ?>" width="100%" class="logo-one" alt="Logo">
        </a>
      </div>
      <div class="main-nav nav-bar">
        <div class="container">
          <nav class="navbar navbar-expand-md navbar-light ">
            <a class="navbar-brand" href="<?= base_url() ?>">
              <img src="<?= base_url('assets/'.$web->logo) ?>" width="40%" class="logo-one" alt="Logo">
              <img src="<?= base_url('assets/'.$web->logo) ?>" width="40%" class="logo-two" alt="Logo">
              <br>
              <h3 style="color:#10142D;"><?= $web->website_name ?></h3>
            </a>
            <div class="collapse navbar-collapse mean-menu" id="navbarSupportedContent">
              <ul class="navbar-nav m-auto">
                <li class="nav-item">
                  <a href="<?= $this->uri->segment(1) == 'login' || $this->uri->segment(1) == 'register' || $this->uri->segment(1) == 'forgot-password' ? base_url() : ''  ?>#home" class="nav-link">
                    Home
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?= $this->uri->segment(1) == 'login' || $this->uri->segment(1) == 'register' || $this->uri->segment(1) == 'forgot-password' ? base_url() : ''  ?>#services" class="nav-link">
                    Layanan
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?= $this->uri->segment(1) == 'login' || $this->uri->segment(1) == 'register' || $this->uri->segment(1) == 'forgot-password' ? base_url() : ''  ?>#branch" class="nav-link">
                    Cabang
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?= $this->uri->segment(1) == 'login' || $this->uri->segment(1) == 'register' || $this->uri->segment(1) == 'forgot-password' ? base_url() : ''  ?>#contact" class="nav-link">
                    Kontak
                  </a>
                </li>

                <li class="nav-item login-btn">
                  <a href="<?= base_url('login') ?>" class="nav-link">Login</a>
                </li>
              </ul>
              <div class="nav-btn">
                <a href="<?= base_url('login') ?>" class="default-btn btn-sm">
                  Login
                </a>
              </div>
            </div>
          </nav>
        </div>
      </div>
    </div>
    <?= $contents ?>
    
    <!-- <footer class="footer-area pt-100 pb-70">
      <div class="container">
        <div class="row">
          <div class="col-lg-4 col-xxl-3 col-md-6">
            <div class="footer-widget">
              <div class="footer-logo">
                <a href="<?= base_url() ?>">
                  <img src="<?= base_url('assets/landing/') ?>img/logo.png" class="footer-logo-one" alt="Logo">
                  <img src="<?= base_url('assets/landing/') ?>img/logo-2.png" class="footer-logo-two" alt="Logo">
                </a>
              </div>
              <p>
                Lorem ipsum dolor sit amet, consectetur adipisicing elit,
                sed do eiusmod tempor incididunt ut labore dolore magna
              </p>
              <div class="newsletter-area">
                <form class="newsletter-form" data-toggle="validator" method="POST">
                  <input type="email" class="form-control" placeholder="Your Email*" name="EMAIL" required autocomplete="off">
                  <button class="default-btn" type="submit">
                  Subscribe
                  </button>
                  <div id="validator-newsletter" class="form-result"></div>
                </form>
              </div>
            </div>
          </div>
          <div class="col-lg-2 col-xxl-3 col-md-6">
            <div class="footer-widget pl-30 pl-50">
              <h3>Useful Links</h3>
              <ul class="footer-list">
                <li>
                  <a href="about.html">About Us</a>
                </li>
                <li>
                  <a href="services-1.html">Services</a>
                </li>
                <li>
                  <a href="projects.html">Projects</a>
                </li>
                <li>
                  <a href="team.html">Team</a>
                </li>
                <li>
                  <a href="Blog-3.html">Blog</a>
                </li>
              </ul>
            </div>
          </div>
          <div class="col-lg-3 col-xxl-3 col-md-6">
            <div class="footer-widget pl-35">
              <h3>Other Resources</h3>
              <ul class="footer-list">
                <li>
                  <a href="services-1.html">Car Service</a>
                </li>
                <li>
                  <a href="services-1.html">Services</a>
                </li>
                <li>
                  <a href="privacy-policy.html">Privacy Policy</a>
                </li>
                <li>
                  <a href="#">Car Details </a>
                </li>
                <li>
                  <a href="#">Support</a>
                </li>
              </ul>
            </div>
          </div>
          <div class="col-lg-3 col-xxl-3 col-md-6">
            <div class="footer-widget">
              <div class="footer-widget">
                <h3>Address</h3>
                <ul class="footer-list-two">
                  <li>
                    <i class='bx bx-time'></i>
                    Sun - Fri: 8.00am - 6.00pm
                  </li>
                  <li>
                    <i class='bx bx-home-smile'></i>
                    <a href="#">2659 Autostrad St, London, UK</a>
                  </li>
                  <li>
                    <i class='bx bx-phone'></i>
                    <a href="tel:+215-123-4567">+215-123-4567</a>
                  </li>
                  <li>
                    <i class='bx bx-phone'></i>
                    <a href="tel:+215-523-8567">+215-523-8567</a>
                  </li>
                  <li>
                    <i class='bx bxs-envelope'></i>
                    <a href="https://templates.hibootstrap.com/cdn-cgi/l/email-protection#630a0d050c2306190a114d000c0e"><span class="__cf_email__" data-cfemail="afc6c1c9c0efcad5c6dd81ccc0c2">[email&#160;protected]</span></a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </footer> -->
    <div class="copy-right-area">
      <div class="container">
        <div class="copy-right-text text-center">
          <p>Copyright ©<script>document.write(new Date().getFullYear())</script> <?= $web->website_name ?></p>
        </div>
      </div>
    </div>
    
    <script src="<?= base_url('assets/landing/') ?>js/jquery.nice-select.min.js"></script>
    <script src="<?= base_url('assets/landing/') ?>js/wow.min.js"></script>
    <script src="<?= base_url('assets/landing/') ?>js/meanmenu.js"></script>
    <script src="<?= base_url('assets/landing/') ?>js/jquery.ajaxchimp.min.js"></script>
    <script src="<?= base_url('assets/landing/') ?>js/form-validator.min.js"></script>
    <!-- <script src="<?= base_url('assets/landing/') ?>js/contact-form-script.js"></script> -->
    <script src="<?= base_url('assets/landing/') ?>js/custom.js"></script>
    <?php if (!$this->uri->segment(1)): ?>
      
    <script>
      $('nav a').on('click', function(e) {
        $(".active").removeClass('active');
        $(this).addClass('active')
        if(this.hash !== ''){
          e.preventDefault()

          const hash = this.hash

          $('html, body').animate({
            scrollTop: $(hash).offset().top
          },
          800)
        }
      })
    </script>
    <?php endif ?>
  </body>
</html>