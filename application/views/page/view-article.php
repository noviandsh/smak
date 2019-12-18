<div id="article-content">
    <?php
        echo "<h2>".ucfirst($content[0]['title'])."</h2>
            <div id='article-detail'>";

        if ($this->uri->segment(1) == 'article'){
            echo "<i class='fas fa-calendar-alt'></i>&nbsp;&nbsp;".date("j F, Y", strtotime($content[0]['date']))."&nbsp;&nbsp;&nbsp;&nbsp;<i class='fas fa-user'></i>&nbsp;&nbsp;".$content[0]['author'];
        }else{
            echo "<i class='fas fa-calendar-alt'></i>&nbsp;&nbsp;".date("g:i a j F, Y", strtotime($content[0]['startDate']))." - ".date("g:i a j F, Y", strtotime($content[0]['endDate']))."&nbsp;&nbsp;&nbsp;&nbsp;
                <i class='fas fa-map-marker-alt'></i>&nbsp;&nbsp;".$content[0]['location']."&nbsp;&nbsp;&nbsp;&nbsp;
                <i class='fas fa-user'></i>&nbsp;&nbsp;".$content[0]['author'];
        }

        echo "</div>
            <br/><img src='".base_url('assets/img/').$this->uri->segment(1)."/".$content[0]['image']."' alt=''><br/>";

        if ($this->uri->segment(1) == 'article'){
            echo $content[0]['content'];
        }else{
            echo $content[0]['description'];
        }
    ?>
</div>