<div id="all-gallery">
    <?php
        function thumb($image){
            $extension_pos = strrpos($image, '.'); // find position of the last dot, so where the extension starts
            $thumb = substr($image, 0, $extension_pos) . '_thumb' . substr($image, $extension_pos);
            return $thumb;
        }
        foreach($gallery as $a){
            echo "<a href='".base_url()."assets/img/gallery/".$a['file']."'><div class='gallery-item' style='background:url(".base_url()."assets/img/gallery/".thumb($a['file']).");background-size:cover;background-position:center;'>
                </div></a>";
        }
    ?>
</div>
<br>
<div id="pagination">
    <ul class="tsc_pagination">
        <!-- Show pagination links -->
        <?php 
            foreach ($links as $link) {
                echo "<li>". $link."</li>";
            } 
        ?>
    </ul>
</div>