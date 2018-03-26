<!DOCTYPE html>
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
<head>
<meta charset="UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1" />
<?php if ($description) { ?>
<meta name="description" content="<?php echo $description; ?>" />
<?php } ?>
<?php if ($keywords) { ?>
<meta name="keywords" content="<?php echo $keywords; ?>" />
<?php } ?>
<title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>" />
<link rel="icon" type="image/png" href="favicon.png" />
<?php foreach ($links as $link) { ?>
<link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />
<?php } ?>
<link rel="stylesheet" type="text/css" href="view/stylesheet/stylesheet_<?php echo $admin_css; ?>.css" />
<link rel="stylesheet" type="text/css" href="view/javascript/jquery/ui/themes/start/jquery-ui-1.12.1.min.css" />
<link rel="stylesheet" type="text/css" href="view/javascript/awesome/css/font-awesome.min.css" />
<link rel="stylesheet" type="text/css" href="view/stylesheet/animate-custom.min.css" />
<?php foreach ($styles as $style) { ?>
<link rel="<?php echo $style['rel']; ?>" type="text/css" href="<?php echo $style['href']; ?>" media="<?php echo $style['media']; ?>" />
<?php } ?>
<script type="text/javascript" src="view/javascript/jquery/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="view/javascript/jquery/jquery-migrate-1.4.1.min.js"></script>
<script type="text/javascript" src="view/javascript/jquery/jquery-migrate-3.0.1.min.js"></script>
<script type="text/javascript" src="view/javascript/jquery/ui/jquery-ui-1.12.1.min.js"></script>
<script type="text/javascript" src="view/javascript/jquery/ui/minified/jquery.ui.touch-punch.min.js"></script>
<script type="text/javascript" src="view/javascript/jquery/tabs.min.js"></script>
<script type="text/javascript" src="view/javascript/common.min.js"></script>
<?php foreach ($scripts as $script) { ?>
<script type="text/javascript" src="<?php echo $script; ?>"></script>
<?php } ?>
<!--[if lt IE 9]>
<script type="text/javascript" src="view/javascript/html5shiv.min.js"></script>
<![endif]-->
</head>
<body>
<div id="container-<?php echo $resolution; ?>">
<div id="header"></div>
