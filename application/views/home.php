<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to CodeIgniter</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="<?=base_url()?>assets/css/jquery-ui.min.css">
    <link rel="stylesheet" type="text/css" media="screen" href="<?=base_url()?>assets/css/all.min.css">
    <link rel="stylesheet" type="text/css" media="screen" href="<?=base_url()?>assets/css/slick.css">
    <link rel="stylesheet" type="text/css" media="screen" href="<?=base_url()?>assets/css/slick-theme.css">
    <link rel="stylesheet" type="text/css" media="screen" href="<?=base_url()?>assets/css/magnific-popup.css">
    <link rel="stylesheet" type="text/css" media="screen" href="<?=base_url()?>assets/css/main.css">
</head>
<body>
	<!-- SVGs -->
    <svg id="svg-wave">
        <defs>
            <clipPath id="wave" clipPathUnits="objectBoundingBox">
                <path class="st0" d="M0,0v1c0,0,.2452-.1,.5-.1s.5,.1,.5,.1V0"/>
            </clipPath>
            <clipPath id="mid" clipPathUnits="objectBoundingBox">
                <path class="st0" d="M.7486,.0993c-.1037,0-.25-.054-.25-.054S.3507,0,.2486,0S0,.0268,0,.0268v.4338v.08v.4176c0,0,.1476-.0575,.2514-.0575
	            s.25,.054,.25,.054s.148,.0453,.25,.0453S1,.9732,1,.9732V.5394v-.08V.0418C1,.0418,.8524,.0993,.7486,.0993z"/>
            </clipPath>
            <clipPath id="menu" clipPathUnits="objectBoundingBox">
                <path class="st0" d="M0,.05c0,0,.0782-.0482,.1443,0s.1828,.0163,.2148,.0096s.109-.0297,.1553-.0264s.1024,.0352,.1509,.0286
                    c.0485-.0066,.1311-.0352,.1784-.0231s.1281,.0161,.1567,.0135"/>
            </clipPath>
            <clipPath id="control-prev" clipPathUnits="objectBoundingBox">
                <path d="M.1451,.2C.0264,.1282,0,0,0,0v.5v.5c0,0,.0264-.1282,.1451-.2c.1187-.0718,.2393-.1736,.2393-.3C.3844,.3736,.2637,.2718,.1451,.2z"/>
            </clipPath>
            <clipPath id="control-next" clipPathUnits="objectBoundingBox">
                    <path d="M.8549,.2C.9736,.1282,1,0,1,0v.5v.5c0,0-.0264-.1282-.1451-.2c-.1187-.0718-.2393-.1736-.2393-.3
                    C.6156,.3736,.7363,.2718,.8549,.2z"/>
            </clipPath>
        </defs>
    </svg>

    <div id="container">
        <div id="navbar">
            <div id="logo">
                <img src="<?=base_url()?>assets/img/logo.png" alt="" srcset=""> 
                <div id="school-name">
                    <span>SMAK YOS SUDARSO BATU</span><br>
                    <small>JL. PANGLIMA SUDIRMAN NO. 63</small>
                </div>
            </div>
            <div id="school-info">
                <ul>
                    <li><i class="fas fa-phone-alt"></i> (0341) 591375</li>
                    <li><i class="fas fa-envelope"></i> smakyossudarso@gmail.com</li>
                </ul>
            </div>
            <div id="menubar">
                <ul>
                    <li id="menu-one"><a href="">Beranda</a></li>
                    <li id="menu-two"><a href="">Profil</a></li>
                    <li id="menu-three"><a href="">Ekstra</a></li>
                    <li id="menu-four"><a href="">Alumni</a></li>
                    <li id="menu-five"><a href="">Kontak</a></li>
                    <div></div>
                </ul>
            </div>
            <div id="burgerbar">
                <i class="fas fa-bars"></i>
            </div>
        </div>
        <div id="header-shadow">
            <div id="header">
                <div id="image-slider">
                    <div class="control-next"><i class="fas fa-arrow-right"></i></div>
                    <div class="control-prev"><i class="fas fa-arrow-left"></i></div>
                    <div id="slider-item-box">
                        <?php
                            foreach(array_reverse($slider) as $a){
                                echo "<div class='slider-item'>
                                        <img src='".base_url('assets/img/slider/').$a['file']."' alt=''>
                                    </div>";
                            }
                        ?>
                        <!-- <div class="slider-item">
                            <img src="<?=base_url()?>assets/img/2.jpg" alt="">
                        </div>
                        <div class="slider-item">
                            <img src="<?=base_url()?>assets/img/3.jpg" alt="">
                        </div>
                        <div class="slider-item">
                            <img src="<?=base_url()?>assets/img/4.jpg" alt="">
                        </div> -->
                    </div>
                </div>
                <div id="header-filter">
                    <a href="#info">

                        <div id="scroll-arrow" href="#"><i class="fas fa-arrow-down"></i></div>
                    </a>
                </div>
            </div>
        </div>
        <div id="info">
            <div id="gallery-box">
                <?php 
                    foreach($gallery as $gal){
                        echo "<a href='".base_url()."assets/img/gallery/".$gal['file']."'><div class='gallery-item' style='background:url(".base_url()."assets/img/gallery/".$gal['file'].");background-size:cover;background-position:center;'>
                            </div></a>";
                    }
                ?>
            </div>
        </div>
        <div id="content">
            <div id="content-clip">
                <div id="content-filter">
                    <div id="news">
                        <span class="content-title">Berita & Informasi Terbaru</span><br><br>
                        <div class="news-item">
                            <img src="<?=base_url()?>assets/img/1.jpg" alt="">
                            <div class="desc">
                                <h2><a href="#">Lorem ipsum dolor sit amet.</a></h2>
                                <span>29 Oktober 2019</span>
                                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Porro neque id dolore labore. Dolorem quae obcaecati voluptates architecto perspiciatis rerum.</p>
                            </div>
                        </div>
                        <div class="news-item">
                            <img src="<?=base_url()?>assets/img/2.jpg" alt="">
                            <div class="desc">
                                <h2><a href="#">Lorem ipsum dolor sit amet.</a></h2>
                                <span>29 Oktober 2019</span>
                                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Porro neque id dolore labore. Dolorem quae obcaecati voluptates architecto perspiciatis rerum.</p>
                            </div>
                        </div>
                        <div class="news-item">
                            <img src="<?=base_url()?>assets/img/3.jpg" alt="">
                            <div class="desc">
                                <h2><a href="#">Lorem ipsum dolor sit amet.</a></h2>
                                <span>29 Oktober 2019</span>
                                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Porro neque id dolore labore. Dolorem quae obcaecati voluptates architecto perspiciatis rerum.</p>
                            </div>
                        </div>
                    </div>
                    <div id="agenda">
                        <span class="content-title">Info Kegiatan</span><br><br>
                        <div class="agenda-item">
                            <div class="calendar">
                                <div class="month">DEC</div>
                                <div class="date">29</div>
                            </div>
                            <div class="desc">
                                <h2><a href="#">Lorem ipsum dolor sit amet.</a></h2>
                                <span>11:00 - 16:00 (August 31, 2019) | Aula SMKN 1 Cerme</span>
                                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Porro neque id dolore labore. Dolorem quae obcaecati voluptates architecto perspiciatis rerum.</p>
                            </div>
                        </div>
                        <div class="agenda-item">
                            <div class="calendar">
                                <div class="month">DEC</div>
                                <div class="date">29</div>
                            </div>
                            <div class="desc">
                                <h2><a href="#">Lorem ipsum dolor sit amet.</a></h2>
                                <span>11:00 - 16:00 (August 31, 2019) | Aula SMKN 1 Cerme</span>
                                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Porro neque id dolore labore. Dolorem quae obcaecati voluptates architecto perspiciatis rerum.</p>
                            </div>
                        </div>
                        <div class="agenda-item">
                            <div class="calendar">
                                <div class="month">DEC</div>
                                <div class="date">29</div>
                            </div>
                            <div class="desc">
                                <h2><a href="#">Lorem ipsum dolor sit amet.</a></h2>
                                <span>11:00 - 16:00 (August 31, 2019) | Aula SMKN 1 Cerme</span>
                                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Porro neque id dolore labore. Dolorem quae obcaecati voluptates architecto perspiciatis rerum.</p>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
            <div id="testi">
                <div class="testi-card">
                    <span class="title">Lorem, ipsum dolor.</span>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Necessitatibus expedita deleniti mollitia consequuntur accusantium sequi, accusamus ab obcaecati inventore iste labore rem itaque corrupti aliquid libero non dolorum magnam voluptas.</p>
                    <div class="testi-profile">
                        <div class="profile-photo" style="background:url('<?=base_url()?>assets/img/1.jpg');background-size: cover;background-position: center;">
                        </div>
                        <span class="profile-name">Novian D Syahrizal</span>
                    </div>
                </div>
                <div class="testi-card">
                    <span class="title">Lorem, ipsum dolor.</span>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Necessitatibus expedita deleniti mollitia consequuntur accusantium sequi, accusamus ab obcaecati inventore iste labore rem itaque corrupti aliquid libero non dolorum magnam voluptas.</p>
                    <div class="testi-profile">
                        <div class="profile-photo" style="background:url('<?=base_url()?>assets/img/1.jpg');background-size: cover;background-position: center;">
                        </div>
                        <span class="profile-name">Syahrizal D Novian</span>
                    </div>
                </div>
                <div class="testi-card">
                    <span class="title">Lorem, ipsum dolor.</span>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Necessitatibus expedita deleniti mollitia consequuntur accusantium sequi, accusamus ab obcaecati inventore iste labore rem itaque corrupti aliquid libero non dolorum magnam voluptas.</p>
                    <div class="testi-profile">
                        <div class="profile-photo" style="background:url('<?=base_url()?>assets/img/1.jpg');background-size: cover;background-position: center;">
                        </div>
                        <span class="profile-name">Novian D Syahrizal</span>
                    </div>
                </div>
                <div class="testi-card">
                    <span class="title">Lorem, ipsum dolor.</span>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Necessitatibus expedita deleniti mollitia consequuntur accusantium sequi, accusamus ab obcaecati inventore iste labore rem itaque corrupti aliquid libero non dolorum magnam voluptas.</p>
                    <div class="testi-profile">
                        <div class="profile-photo" style="background:url('<?=base_url()?>assets/img/1.jpg');background-size: cover;background-position: center;">
                        </div>
                        <span class="profile-name">Syahrizal D Novian</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<script src="<?=base_url()?>assets/js/jquery.min.js"></script>
    <script src="<?=base_url()?>assets/js/jquery-ui.min.js"></script>
    <script src="<?=base_url()?>assets/js/TweenMax.js"></script>
    <script src="<?=base_url()?>assets/js/TimelineMax.js"></script>
    <script src="<?=base_url()?>assets/js/slick.min.js"></script>
    <script src="<?=base_url()?>assets/js/jquery.magnific-popup.js"></script>
    <script src="<?=base_url()?>assets/js/main.js"></script>
</body>
</html>