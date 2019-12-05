<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/admin-style.css">
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/all.min.css">
</head>
<body>
    <div id="peeking">
        <div id="login-container" head-text="<?=$title?>">
            <?=$page?>
        </div>
    </div>
</body>
</html>