<?php echo $header; ?>
<?php echo $content_header; ?>
<?php if ($this->config->get($template . '_breadcrumbs')) { ?>
  <div class="breadcrumb">
  <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
  <?php } ?>
  </div>
<?php } ?>
<?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><?php echo $content_top; ?>
  <h1><?php echo $heading_title; ?></h1>
  <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
    <div class="content">
      <div class="contact-info">
        <div class="info-left">
          <h2><?php echo $text_contact; ?></h2>
          <br />
          <b><?php echo $entry_name; ?></b><br />
          <input type="text" name="name" size="30" value="<?php echo $name; ?>" />
          <br />
        <?php if ($error_name) { ?>
          <span class="error"><?php echo $error_name; ?></span>
        <?php } ?>
          <br />
          <b><?php echo $entry_email; ?></b><br />
          <input type="text" name="email" size="40" value="<?php echo $email; ?>" />
          <br />
        <?php if ($error_email) { ?>
          <span class="error"><?php echo $error_email; ?></span>
        <?php } ?>
          <br />
          <b><?php echo $entry_enquiry; ?></b><br />
          <textarea name="enquiry" cols="40" rows="10" style="width:99%;"><?php echo $enquiry; ?></textarea>
          <br />
        <?php if ($error_enquiry) { ?>
          <span class="error"><?php echo $error_enquiry; ?></span>
        <?php } ?>
          <br />
          <div id="captcha-wrap">
            <div class="captcha-box">
              <div class="captcha-view">
                <img src="<?php echo $captcha_image; ?>" alt="" id="captcha-image" />
              </div>
            </div>
            <div class="captcha-text">
              <label><?php echo $entry_captcha; ?></label>
              <input type="text" name="captcha" id="captcha" value="<?php echo $captcha; ?>" autocomplete="off" />
            </div>
            <div class="captcha-action"><i class="fa fa-repeat"></i></div>
          </div>
          <br />
        <?php if ($error_captcha) { ?>
          <span class="error"><?php echo $error_captcha; ?></span>
        <?php } ?>
          <div class="buttons">
            <div class="right"><input type="submit" value="<?php echo $button_continue; ?>" class="button" /></div>
          </div>
        </div>
      <?php if (!$hide_address) { ?>
        <div class="info-right">
          <h2><?php echo $text_location; ?></h2>
          <br />
          <img src="catalog/view/theme/<?php echo $template; ?>/image/location/address.png" alt="" /> &nbsp; <b><?php echo $store; ?></b><br />
          <?php echo $address; ?><br />
          <br />
        <?php if ($telephone) { ?>
          <img src="catalog/view/theme/<?php echo $template; ?>/image/location/phone.png" alt="" /> &nbsp; <?php echo $telephone; ?><br />
          <br />
        <?php } ?>
        <?php if ($fax) { ?>
          <img src="catalog/view/theme/<?php echo $template; ?>/image/location/fax.png" alt="" /> &nbsp; <?php echo $fax; ?><br />
          <br />
        <?php } ?>
        <?php if (!$hide_location && $latitude && $longitude) { ?>
          <br />
          <br />
          <img src="catalog/view/theme/<?php echo $template; ?>/image/location/global.png" alt="" /> &nbsp; <b><?php echo $text_geolocation; ?></b>
          <br />
          <br />
          <i><?php echo $text_latitude; ?></i> <?php echo $latitude; ?> <i>&deg; N</i>
          <br />
          <br />
          <i><?php echo $text_longitude; ?></i> <?php echo $longitude; ?> <i>&deg; E</i>
          <br />
        <?php } ?>
        </div>
      <?php } ?>
      <?php if ($display_map && !empty($google_map)) { ?>
        <div style="margin-left:5px;"><?php echo html_entity_decode($google_map, ENT_QUOTES, 'UTF-8'); ?></div>
        <div style="margin:5px 0 0 5px;"><a class="button button-resource"><i class="fa fa-info-circle"></i></a></div>
      <?php } ?>
      </div>
    </div>
  </form>
  <?php echo $content_bottom; ?>
</div>
<?php echo $content_footer; ?>

<script type="text/javascript"><!--
$('img#captcha-image').on('load', function(event) {
	$(event.target).show();
});
$('img#captcha-image').trigger('load');
//--></script>

<link rel="stylesheet" type="text/css" href="catalog/view/javascript/jquery/confirm/jquery-confirm.min.css" />

<script type="text/javascript" src="catalog/view/javascript/jquery/confirm/jquery-confirm.min.js"></script>

<script type="text/javascript"><!--
$('a.button-resource').confirm({
	title: '<?php echo $gdpr_resource; ?>',
	content: '<?php echo $dialog_resource; ?>',
	icon: 'fa fa-question-circle',
	theme: 'light',
	useBootstrap: false,
	boxWidth: 300,
	animation: 'zoom',
	closeAnimation: 'scale',
	opacity: 0.1,
	buttons: {
		ok: function() { }
	}
});
//--></script>

<?php echo $footer; ?>