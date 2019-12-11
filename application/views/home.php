<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function readMore($str, $char)
{
    $s = substr($str, 0, $char);
    $result = substr($s, 0, strrpos($s, ' '));
    $result = strip_tags($result);
    return $result;
}
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
    <link rel="stylesheet" type="text/css" media="screen" href="<?=base_url()?>assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" media="screen" href="<?=base_url()?>assets/css/main.css">
</head>
<body>
	<!-- SVGs -->
    <svg id="svg-wave">
        <defs>
            <clipPath id="wave" clipPathUnits="objectBoundingBox">
                <path class="st0" d="M0,0v1c0,0,.2452-.1,.5-.1s.5,.1,.5,.1V0"/>
            </clipPath>
            <clipPath id="wave2" clipPathUnits="objectBoundingBox">
                <path class="st0" d="M0,0v1c0,0,.2452-.0353,.50-.0353c.2547,0,.50,.0353,.50,.0353V0H0z"/>
            </clipPath>
            <clipPath id="mid" clipPathUnits="objectBoundingBox">
                <path class="st0" d="M.7486,.0993c-.1037,0-.25-.054-.25-.054S.3507,0,.2486,0S0,.0268,0,.0268v.4338v.08v.4176c0,0,.1476-.0575,.2514-.0575
	            s.25,.054,.25,.054s.148,.0453,.25,.0453S1,.9732,1,.9732V.5394v-.08V.0418C1,.0418,.8524,.0993,.7486,.0993z"/>
            </clipPath>
            <clipPath id="mid2" clipPathUnits="objectBoundingBox">
                <path class="st0" d="M.7486,.04c-.1037,0-.25-.0207-.25-.0207S.3507,0,.2486,0S0,.0268,0,.0268v.4338v.0282V.51v.0294v.4472
                    c0,0,.1476-.0278,.2514-.0278s.25,.0207,.25,.0207s.148,.0193,.25,.0193S1,.9721,1,.9721V.5382V.51v-.0212v-.0294V.0122
                    C1,.0122,.8524,.04,.7486,.04z"/>
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
                    </div>
                </div>
                <div id="header-filter">
                    <a href="#">

                        <div id="scroll-arrow"><i class="fas fa-arrow-down"></i></div>
                    </a>
                </div>
            </div>
        </div>
        <div id="info">
            <div id="news">
                <span class="content-title">Berita & Informasi Terbaru</span><br><br>
                <?php
                    foreach($article as $a){
                        echo "<div class='news-item'>
                                <img src='".base_url('assets/img/article/'.$a['image'])."' alt=''>
                                <div class='desc'>
                                    <h4><a href='".base_url('article/'.$a['link'])."'>".ucwords($a['title'])."</a></h4>
                                    <span>".date("j F Y", strtotime($a['date']))."</span>
                                    <div>".readMore($a['content'], 200)."...</div>
                                </div>
                            </div>";
                    }
                ?>
            </div>
            <div id="agenda">
                <span class="content-title">Info Kegiatan</span><br><br>
                <?php
                    $month = array('01' => 'JAN','02' => 'FEB','03' => 'MAR','04' => 'APR','05' => 'MEI','06' => 'JUN','07' => 'JUL','08' => 'AUG','09' => 'SEP','10' => 'OKT','11' => 'NOV','12' => 'DEC');
                    foreach($event as $e){
                        echo "<div class='agenda-item'>
                                <div class='calendar'>
                                    <div class='month'>".$month[$e['startDate']['month']]."</div>
                                    <div class='date'>".$e['startDate']['date']."</div>
                                </div>
                                <div class='desc'>
                                    <h4><a href='#'>".ucwords($e['title'])."</a></h4>
                                    <span><i class='fas fa-map-marker-alt'></i> ".ucfirst($e['location'])."</span>
                                    <div>".readMore($e['description'], 200)."...</div>
                                </div>
                            </div>";
                    }
                ?>
                
            </div>
        </div>
        <div id="content">
            <div id="content-clip">
                <div id="content-filter">
                    
                        <div id="gallery-box">
                            <?php 
                                foreach($gallery as $gal){
                                    echo "<a href='".base_url()."assets/img/gallery/".$gal['file']."'><div class='gallery-item' style='background:url(".base_url()."assets/img/gallery/".$gal['file'].");background-size:cover;background-position:center;'>
                                        </div></a>";
                                }
                            ?>
                        </div>
                    <!-- </div> -->
                </div>
            </div>
            <div id="testi">
                <?php
                    foreach($testi as $val){
                        echo "<div class='testi-card'>
                                <p>".$val['testimoni']."</p>
                                <div class='testi-profile'>
                                    <div class='profile-photo' style='background:url(".base_url('assets/img/alumni/'.$val['photo']).");background-size: cover;background-position: center;'>
                                    </div>
                                    <div>
                                        <span class='profile-name'>".ucwords($val['name'])."</span><br>
                                        <small>".ucfirst($val['home']).", Alumni ".$val['year']."</small>
                                    </div>
                                </div>
                            </div>";
                    }
                ?>
                
                <!-- <div class="testi-card">
                    <span class="title">Lorem, ipsum dolor.</span>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Necessitatibus expedita deleniti mollitia consequuntur accusantium sequi, accusamus ab obcaecati inventore iste labore rem itaque corrupti aliquid libero non dolorum magnam voluptas.</p>
                    <div class="testi-profile">
                        <div class="profile-photo" style="background:url('<?=base_url()?>assets/img/1.jpg');background-size: cover;background-position: center;">
                        </div>
                        <span class="profile-name">Syahrizal D Novian</span>
                        <small>Kepanjen, Alumni 2014</small>
                    </div>
                </div>
                <div class="testi-card">
                    <span class="title">Lorem, ipsum dolor.</span>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Necessitatibus expedita deleniti mollitia consequuntur accusantium sequi, accusamus ab obcaecati inventore iste labore rem itaque corrupti aliquid libero non dolorum magnam voluptas.</p>
                    <div class="testi-profile">
                        <div class="profile-photo" style="background:url('<?=base_url()?>assets/img/1.jpg');background-size: cover;background-position: center;">
                        </div>
                        <span class="profile-name">Novian D Syahrizal</span>
                        <small>Kepanjen, Alumni 2014</small>
                    </div>
                </div>
                <div class="testi-card">
                    <span class="title">Lorem, ipsum dolor.</span>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Necessitatibus expedita deleniti mollitia consequuntur accusantium sequi, accusamus ab obcaecati inventore iste labore rem itaque corrupti aliquid libero non dolorum magnam voluptas.</p>
                    <div class="testi-profile">
                        <div class="profile-photo" style="background:url('<?=base_url()?>assets/img/1.jpg');background-size: cover;background-position: center;">
                        </div>
                        <span class="profile-name">Syahrizal D Novian</span>
                        <small>Kepanjen, Alumni 2014</small>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-news" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <!-- MODAL HEADER -->
                    <h4 class="modal-title" id="myModalLabel"><?=$popup[0]['title']?></h4>
                    <input hidden type="text">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <!-- MODAL BODY -->
                    <!-- view article -->
                    <div id="news-content">
                        <?=$popup[0]['content']?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- MODAL -->
    <script>
        var popup = <?=count($popup)?>;
    </script>
	<script src="<?=base_url()?>assets/js/jquery.min.js"></script>
    <script src="<?=base_url()?>assets/js/jquery-ui.min.js"></script>
    <script src="<?=base_url()?>assets/js/TweenMax.js"></script>
    <script src="<?=base_url()?>assets/js/TimelineMax.js"></script>
    <script src="<?=base_url()?>assets/js/slick.min.js"></script>
    <script src="<?=base_url()?>assets/js/jquery.magnific-popup.js"></script>
    <script src="<?=base_url()?>assets/js/bootstrap.js"></script>
    <script src="<?=base_url()?>assets/js/main.js"></script>
</body>
</html>