<div id="all-article">
    <?php
    function readMore($str, $char)
    {
        $s = substr($str, 0, $char);
        $result = substr($s, 0, strrpos($s, ' '));
        $result = strip_tags($result);
        return $result;
    }
    foreach($article as $a){
        echo "<div class='news-item'>
                <img src='".base_url('assets/img/article/'.$a['image'])."' alt=''>
                <div class='desc'>
                    <h4><a href='".base_url('article/'.$a['link'])."'>".ucwords($a['title'])."</a></h4>
                    <div class='date'><div></div><span>".date("j F Y", strtotime($a['date']))."</span></div>
                    <div>".readMore($a['content'], 200)."...</div>
                </div>
            </div>";
    }
    ?><br>
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