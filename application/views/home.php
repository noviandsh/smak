<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function readMore($str, $char)
{
    $s = substr($str, 0, $char);
    $result = substr($s, 0, strrpos($s, ' '));
    $result = strip_tags($result);
    return $result;
}
function thumb($image){
    $extension_pos = strrpos($image, '.'); // find position of the last dot, so where the extension starts
    $thumb = substr($image, 0, $extension_pos) . '_thumb' . substr($image, $extension_pos);
    return $thumb;
}
?><!DOCTYPE html>
<html lang="en">
<head>
	<?=$head?>
</head>
<body>
	<!-- SVGs -->
    <?=$svg?>

    <div id="container">
        <?=$navbar?>
        <div id="header-shadow">
            <div id="header" class="section">
                <div id="image-slider">
                    <div class="control-next"><i class="fas fa-arrow-right"></i></div>
                    <div class="control-prev"><i class="fas fa-arrow-left"></i></div>
                    <div id="slider-item-box">
                        <?php
                            foreach(array_reverse($slider) as $a){
                                echo "<div class='slider-item' style='background-image:url(".base_url('assets/img/slider/').$a['file'].")'></div>";
                            }
                        ?>
                    </div>
                </div>
                <div id="header-filter">
                    <a href="#info">
                        <div id="scroll-arrow"><i class="fas fa-arrow-down"></i></div>
                    </a>
                </div>
            </div>
        </div>
        <div id="info" class="section">
            <div id="news">
                <span class="content-title">Berita & Informasi Terbaru</span><br><br>
                <?php
                    foreach($article as $a){
                        echo "<div class='news-item' data-aos='fade-right' data-aos-easing='ease-in-out-back'>
                                <img src='".base_url('assets/img/article/'.$a['image'])."' alt=''>
                                <div class='desc'>
                                    <h4><a href='".base_url('article/'.$a['link'])."'>".ucwords($a['title'])."</a></h4>
                                    <div class='date'><div></div><span>".date("j F Y", strtotime($a['date']))."</span></div>
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
                        echo "<div class='agenda-item' data-aos='fade-left'>
                                <div class='calendar'>
                                    <div class='month'>".$month[$e['startDate']['month']]."</div>
                                    <div class='date'>".$e['startDate']['date']."</div>
                                </div>
                                <div class='desc'>
                                    <h4><a href='".base_url('event/'.$e['link'])."'>".ucwords($e['title'])."</a></h4>
                                    <span><i class='fas fa-map-marker-alt'></i> ".ucfirst($e['location'])."</span>
                                    <div>".readMore($e['description'], 200)."...</div>
                                </div>
                            </div>";
                    }
                ?>
                
            </div>
        </div>
        <div id="content" class="section">
            <div id="content-clip">
                <div id="content-filter">
                    <div id="headmaster-box">
                        <div id="headmaster-profile" data-aos="zoom-in-up">
                            <div style="background:url(<?=base_url('assets/img/person/'.$headmaster[0]['photo'])?>);background-size: cover;" class="photo"></div>
                            <span><?=$headmaster[0]['name']?></span>
                        </div>
                        <div id="headmaster-speech" data-aos="zoom-out-left">
                            <h4>Kepala Sekolah SMAK Yos Sudarso Batu</h4><br>
                            <?=$speech[0]['content']?>
                        </div>
                    </div>
                </div>
            </div>
            <div id="testi-title">Alumni</div>
            <div id="testi" class="section">
                <?php
                    foreach($testi as $val){
                        echo "<div class='testi-card' data-aos='zoom-out-down'>
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
            </div>
            <div id="gallery" class="section">
                <div id="gallery-title">Galeri</div>
                <div id="gallery-box">
                    <?php 
                        foreach($gallery as $gal){
                            echo "<a href='".base_url()."assets/img/gallery/".$gal['file']."' data-aos='zoom-in-up'><div class='gallery-item' style='background:url(".base_url()."assets/img/gallery/".thumb($gal['file']).");background-size:cover;background-position:center;'>
                                </div></a>";
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <?=$footer?>
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
                        <img src="<?=base_url('assets/img/article/').$popup[0]['image']?>" style="min-width:100%;margin-bottom:30px;" alt="">
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
    <script src="<?=base_url()?>assets/js/jquery-scrollspy.min.js"></script>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        let menu = {
            undefined: 0,
            article: 20,
            event: 40,
            gallery: 60,
            alumni: 80
        };
        if('<?=$this->uri->segment(1)?>' === ''){
            $('#menubar div').css('margin-left', '0%');
        }else{
            $('#menubar div').css('margin-left', menu['<?=$this->uri->segment(1)?>']+'%');
        }
    </script>
    <script src="<?=base_url()?>assets/js/main.js"></script>
</body>
</html>