<div id="all-testi">
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
</div><br>
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