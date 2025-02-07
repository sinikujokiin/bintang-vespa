<?php $errors =$this->session->flashdata('errors'); ?>
<style>
    sup{
        color:red;
    }
</style>
<div class="sign-in-area pricing-bg pt-50 pb-70">
    <div class="container">
        <div class="row pt-45">
            <div class="col-lg-12">
                <div class="user-all-form">
                    <div class="contact-form">
                        <div class="section-title text-center">
                            <!-- <span class="span-bg">Masuk</span> -->
                            <h3>Buat Akun Anda</h3>
                        </div>
                        <form id="form-login" action="" method="POST">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="name">Nama Lengkap<sup>*</sup></label>
                                        <input type="text" value="<?= set_value('name')?>" name="name" id="name" class="form-control" required placeholder="Nama Lengkap">
                                        <?=  isset($errors['name']) ? $errors['name'] : '' ?>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="phone">No. HP<sup>*</sup></label>
                                        <input type="text" value="<?= set_value('phone')?>" name="phone" id="phone" class="form-control" required placeholder="No. HP">
                                        <?=  isset($errors['phone']) ? $errors['phone'] : '' ?>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="email">Email<sup>*</sup></label>
                                        <input type="email" value="<?= set_value('email')?>" name="email" id="email" class="form-control" required placeholder="Email">
                                        <?=  isset($errors['email']) ? $errors['email'] : '' ?>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="username">Username<sup>*</sup></label>
                                        <input type="text" value="<?= set_value('username')?>" name="username" id="username" class="form-control" required placeholder="Username">
                                        <?=  isset($errors['username']) ? $errors['username'] : '' ?>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="password">Password<sup>*</sup> <i class='bx bx-info-circle' title="Password harus mengandung: &#013; huruf kecil &#013; huruf kapital &#013; angka &#013; simbol &#013; 8 karakter"></i></label>
                                        <input class="form-control" type="password" name="password" id="password" placeholder="Password">
                                        <?=  isset($errors['password']) ? $errors['password'] : '' ?>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="confpassword">Konfrmasi Password<sup>*</sup></label>
                                        <input class="form-control" type="password" name="confpassword" id="confpassword" placeholder="Konfimasi Password">
                                        <?=  isset($errors['confpassword']) ? $errors['confpassword'] : ''  ?>
                                    </div>
                                </div>
                                <!-- <div class="col-lg-6 col-sm-6 form-condition">
                                    <div class="agree-label">
                                        <input type="checkbox" id="chb1">
                                        <label for="chb1">
                                            Remember Me
                                        </label>
                                    </div>
                                </div> -->
                                <div class="col-lg-12 col-md-12 text-center">
                                    <button type="submit" class="default-btn btn-login">
                                    Masuk
                                    </button>
                                </div>
                                <div class="col-12">
                                    <p class="account-desc">
                                        Sudah Punya Akun?
                                        <a href="<?= base_url('login') ?>">Login</a>
                                    </p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>