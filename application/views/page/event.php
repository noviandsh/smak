<div id="all-agenda">
    <span class="content-title">Info Kegiatan</span><br><br>
    <?php
    
        function readMore($str, $char)
        {
            $s = substr($str, 0, $char);
            $result = substr($s, 0, strrpos($s, ' '));
            $result = strip_tags($result);
            return $result;
        }
        $month = array('01' => 'JAN','02' => 'FEB','03' => 'MAR','04' => 'APR','05' => 'MEI','06' => 'JUN','07' => 'JUL','08' => 'AUG','09' => 'SEP','10' => 'OKT','11' => 'NOV','12' => 'DEC');
        foreach($event as $e){
            echo "<div class='agenda-item'>
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
</div>