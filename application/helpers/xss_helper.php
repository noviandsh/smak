<?php
    function xss($str){
        return htmlentities($str, ENT_QUOTES, 'UTF-8');
    }