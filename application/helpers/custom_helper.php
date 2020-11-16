<?php
    if(!defined('BASEPATH')) exit('No direct script access allowed');
    
    function xss($str){
        return htmlentities($str, ENT_QUOTES, 'UTF-8');
    }

    function valid2session($session, $error, $formData=null)
    {
        $ci =& get_instance();
        if($error != strip_tags($error)) {
            $remove_p = str_replace('<p>', '', $error);
            $remove_nl = explode('</p>', $remove_p);
            $count = count($remove_nl);
            unset($remove_nl[$count-1]);
            $data = preg_replace("/[^A-Za-z0-9 ]/", '', $remove_nl);
        }else{
            $data = $error;
        }
        $ci->session->set_flashdata($session, $data);
        $ci->session->set_flashdata('form-data', $formData);
        // return $session.$data;
    }
    function valid_error($session, $type){
        $ci =& get_instance();
        $html = '';
        if(!empty($ci->session->$session)){
            $valid = $ci->session->$session;
            $html .= "<div class='".$session." alert alert-".$type."' role='alert'>";
                if(gettype($valid) == 'array'){
                    foreach($valid as $val){
                        $html .= "<span>".$val."</span><br/>";
                    }
                }else{
                    $html .= "<span>".$valid."</span><br/>";
                }
            $html .= "</div>";
        }
        return $html;
    }
    function valid_value($field){
        $value = '';
        if(!empty($_SESSION['form-data'][$field])){
            $value = $_SESSION['form-data'][$field];
        }
        return $value;
    }

    function idDate($string){
        $bulanIndo = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September' , 'Oktober', 'November', 'Desember'];
 
        $tanggal = explode("-", $string)[2];
        $bulan = explode("-", $string)[1];
        $tahun = explode("-", $string)[0];
    
        return $tanggal . " " . $bulanIndo[abs($bulan)] . " " . $tahun;
    }