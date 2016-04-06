<!DOCTYPE html>
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
<head>
<meta charset="UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="robots" content="index, follow" />
<meta name="generator" content="<?php echo $version; ?>" />
<title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>" />
<?php if ($description) { ?>
<meta name="description" content="<?php echo $description; ?>" />
<?php } ?>
<?php if ($keywords) { ?>
<meta name="keywords" content="<?php echo $keywords; ?>" />
<?php } else { ?>
<meta name="keywords" content="<?php echo $text_home; ?>" />
<?php } ?>
<?php if ($metas) { ?>
<?php foreach ($metas as $meta) { ?>
<meta name="<?php echo $meta['name']; ?>" content="<?php echo $meta['content']; ?>" />
<?php } ?>
<?php } ?>
<?php if ($icon) { ?>
<link href="<?php echo $icon; ?>" rel="icon" />
<?php } ?>
<?php foreach ($links as $link) { ?>
<link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />
<?php } ?>
<?php if ($this->config->get('default_widescreen')) { ?>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/<?php echo $template; ?>/stylesheet/stylesheet-wide.css" />
<?php } else { ?>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/<?php echo $template; ?>/stylesheet/stylesheet.css" />
<?php } ?>
<link rel="stylesheet" type="text/css" href="catalog/view/javascript/jquery/ui/themes/start/jquery-ui-1.11.4.custom.min.css" />
<?php foreach ($styles as $style) { ?>
<link rel="<?php echo $style['rel']; ?>" type="text/css" href="<?php echo $style['href']; ?>" media="<?php echo $style['media']; ?>" />
<?php } ?>
<script type="text/javascript" src="catalog/view/javascript/jquery/jquery-1.12.3.min.js"></script>
<script type="text/javascript" src="catalog/view/javascript/jquery/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="catalog/view/javascript/jquery/ui/jquery-ui-1.11.4.custom.min.js"></script>
<script type="text/javascript" src="catalog/view/javascript/jquery/ui/minified/jquery.ui.touch-punch.min.js"></script>
<script type="text/javascript" src="catalog/view/javascript/common.js"></script>
<?php foreach ($scripts as $script) { ?>
<script type="text/javascript" src="<?php echo $script; ?>"></script>
<?php } ?>
<!--[if lt IE 9]>
<script type="text/javascript" src="catalog/view/javascript/html5.js"></script>
<![endif]-->
<?php if ($stores) { ?>
<script type="text/javascript"><!--
$(document).ready(function() {
<?php foreach ($stores as $store) { ?>
	$('body').prepend('<iframe src="<?php echo $store; ?>" style="display:none;"></iframe>');
<?php } ?>
});
//--></script>
<?php } ?>
<?php if ($theme['cookie_consent']) { ?>
<link rel="stylesheet" type="text/css" href="catalog/view/javascript/jquery/consent/cookiecuttr.css" />
<script type="text/javascript" src="catalog/view/javascript/jquery/jquery.cookie-1.4.1.min.js"></script>
<script type="text/javascript" src="catalog/view/javascript/jquery/consent/jquery.cookiecuttr.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$.cookieCuttr({
		cookieAnalytics: false,
		cookiePolicyPage: true,
		cookieAcceptButton: true,
		cookieDeclineButton: true,
		cookiePolicyPageMessage: '<?php echo $theme['cookie_message']; ?>',
		cookieAcceptButtonText: '<?php echo $theme['cookie_yes']; ?>',
		cookieDeclineButtonText: '<?php echo $theme['cookie_no']; ?>',
		cookieExpires: 365
	});
});
if (jQuery.cookie('cc_cookie_accept') == "cc_cookie_accept") {
	<?php echo ($google_analytics) ? "<br>" + $google_analytics : ''; ?><?php echo ($alexa_analytics) ? "<br>" + $alexa_analytics : ''; ?>
}
</script>
<?php } else { ?>
<?php echo ($google_analytics) ? $google_analytics : ''; ?>
<?php echo ($alexa_analytics) ? $alexa_analytics : ''; ?>
<?php } ?>
<?php if ($rss) { ?>
<link rel="alternate" type="application/rss+xml" href="<?php echo $rss_href; ?>" />
<?php } ?>
</head>
<body>
<div id="container">
<div id="header">
  <?php if ($logo) { ?>
    <div id="logo"><a href="<?php echo $home; ?>"><img src="<?php echo $logo; ?>" title="<?php echo $name; ?>" alt="<?php echo $name; ?>" /></a></div>
  <?php } ?>
  <div id="welcome">
    <?php if (!$logged) { ?>
      <?php echo $text_welcome; ?>
    <?php } else { ?>
      <?php echo $text_logged; ?>
    <?php } ?>
  </div>
  <?php echo $cart; ?>
  <div id='header-bottom'>
    <div id="search">
      <div class="search-inside">
        <input type="text" name="search" placeholder="<?php echo $text_search; ?>" value="" />
        <div class="button-search"></div>
      </div>
    </div>
  <?php echo $language; ?>
  <?php echo $currency; ?>
  </div>
</div>