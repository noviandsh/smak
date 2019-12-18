<!DOCTYPE html>
<html>
<head>
    <?=$head?>
</head>
<body>
    <div id="page-container">
        <?=$navbar?>
        <?=$svg?>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?=base_url()?>">Beranda</a></li>
                <li class="breadcrumb-item"><a href="<?=base_url()?>"><?=ucfirst($this->uri->segment(1))?></a></li>
                <?php
                    if(!empty($this->uri->segment(2)) && is_numeric($this->uri->segment(2)) != 1){
                        echo "<li class='breadcrumb-item active' aria-current='page'>".$content[0]['title']."</li>";
                    }
                ?>
            </ol>
        </nav>
        <div id="page-box">
            <div id="page-content">
                <?=$page?>
            </div>
            <div id="side-content"> 
                <div id="side-news">
                    <h5>Informasi terbaru</h5>
                    <ul>
                        <?php
                            foreach($article as $a){
                                echo "<li><a href='".base_url('article/').$a['link']."'>".$a['title']."</a></li>";
                            }
                        ?>
                    </ul>
                </div><br>
                <div id="side-event">
                    <h5>Kegiatan terbaru</h5>
                    <ul>
                        <?php
                            foreach($event as $a){
                                echo "<li><a href='".base_url('event/').$a['link']."'>".$a['title']."</a></li>";
                            }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
        <?=$footer?>
    </div>
	<script src="<?=base_url()?>assets/js/jquery.min.js"></script>
    <script src="<?=base_url()?>assets/js/jquery-ui.min.js"></script>
    <script src="<?=base_url()?>assets/js/TweenMax.js"></script>
    <script src="<?=base_url()?>assets/js/TimelineMax.js"></script>
    <script src="<?=base_url()?>assets/js/jquery.magnific-popup.js"></script>
    <script src="<?=base_url()?>assets/js/bootstrap.js"></script>
    <script src="<?php echo base_url('assets/js/jquery.magnific-popup.js'); ?>"></script>
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
        
        $('#all-gallery').magnificPopup({
            delegate: 'a', // child items selector, by clicking on it popup will open
            type: 'image',
            gallery: {enabled:true}
            // other options
        });
    </script>
    <script src="<?=base_url()?>assets/js/article.js"></script>
</body>
</html>