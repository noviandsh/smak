<!DOCTYPE html>
<html>
<head>
    <?=$head?>
</head>
<body>
    <div id="article-container">
        <?=$navbar?>
        <?=$svg?>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Library</li>
            </ol>
        </nav>
        <div id="article-box">
            <div id="article-content">
                <?php
                    echo "<h2>".ucfirst($content[0]['title'])."</h2><br/><img src='".base_url('assets/img/').$this->uri->segment(1)."/".$content[0]['image']."' alt=''><br/>";
                    if ($this->uri->segment(1) == 'article'){
                        echo $content[0]['content'];
                    }else{
                        echo $content[0]['description'];
                    }
                ?>
            </div>
            <div id="side-content">
                <div id="side-news">
                    <h5>Informasi terbaru</h5>
                </div>
                <div id="side-event">
                    <h5>Kegiatan terbaru</h5>
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
    <script src="<?=base_url()?>assets/js/article.js"></script>
</body>
</html>