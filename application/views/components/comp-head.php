<?php 
    function clean($string) {
        $string = strtolower($string);
        $string = trim($string, "-");
           $string = str_replace('-', ' ', $string); // Replaces all spaces with hyphens.
           $string = preg_replace('/[^A-Za-z0-9\-]/', ' ', $string); // Removes special chars.

           return preg_replace('/-+/', ' ', $string); // Replaces multiple hyphens with single one.
    }

    $val = ucfirst($this->uri->segment(1));
    $val2 = $this->uri->segment(2);
    if(!empty($val2) && is_numeric($val2) != 1){
        $title = ucfirst(clean($val2));
    }else{
        $title = $val;
    }
?>
<title><?=$title?> | SMAK YOS SUDARSO BATU</title>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<meta content='Selamat datang di SMA Katolik Yos Sudarso Batu' name='description'/>
<meta content='SMA, Katolik, Yos Sudarso, Batu' name='keywords'/>
<meta content='id' name='geo.country' />

<meta content='SMAK Yos Sudarso Batu' property='og:title'/>
<meta content='website' property='og:type'/>
<meta content='<?php echo base_url();?>' property='og:url'/>
<meta content='<?php echo base_url('assets/img/logo.png');?>' property='og:image'/>
<meta content='Selamat datang di SMA Katolik Yos Sudarso Batu' property='og:description'/>
<meta content='Smakyossudarsobatu.sch.id' property='og:site_name'/>
<meta content='id_ID' property='og:locale'/>
<meta content='en_GB' property='og:locale:alternate'/>
<meta content='id_ID' property='og:locale:alternate'/>

<link rel="stylesheet" type="text/css" media="screen" href="<?=base_url()?>assets/css/jquery-ui.min.css">
<link rel="stylesheet" type="text/css" media="screen" href="<?=base_url()?>assets/css/all.min.css">
<link rel="stylesheet" type="text/css" media="screen" href="<?=base_url()?>assets/css/slick.css">
<link rel="stylesheet" type="text/css" media="screen" href="<?=base_url()?>assets/css/slick-theme.css">
<link rel="stylesheet" type="text/css" media="screen" href="<?=base_url()?>assets/css/magnific-popup.css">
<link rel="stylesheet" type="text/css" media="screen" href="<?=base_url()?>assets/css/bootstrap.css">
<link rel="stylesheet" type="text/css" media="screen" href="https://unpkg.com/aos@next/dist/aos.css" />
<link rel="stylesheet" type="text/css" media="screen" href="<?=base_url()?>assets/css/main.css">
<link rel="shortcut icon" type="text/css" href="<?php echo base_url('assets/img/logo.png');?>" >
