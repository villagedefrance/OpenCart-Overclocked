<?php echo $header; ?>
<?php echo $content_header; ?>
<?php if ($this->config->get('default_breadcrumbs')) { ?>
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
                <img src="index.php?route=information/contact/captcha" alt="" id="captcha-image" />
              </div>
            </div>
            <div class="captcha-text">
              <label><?php echo $entry_captcha; ?></label>
              <input type="text" name="captcha" id="captcha" value="<?php echo $captcha; ?>" autocomplete="off" />
		    </div>
            <div class="captcha-action"></div>
          </div>
          <br />
          <?php if ($error_captcha) { ?>
            <span class="error"><?php echo $error_captcha; ?></span>
          <?php } ?>
          <div class="buttons">
            <div class="right"><input type="submit" value="<?php echo $button_continue; ?>" class="button" /></div>
          </div>
        </div>
        <?php if (!$hide_location) { ?>
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
          <?php if ($map) { ?>
           <br />
           <br />
           <img src="catalog/view/theme/<?php echo $template; ?>/image/location/global.png" alt="" /> &nbsp <b><?php echo $text_geolocation; ?></b>
           <br />
           <br />
           <i><?php echo $text_latitude; ?></i> <?php echo $map_latitude; ?> <i>&deg; N</i>
           <br />
		   <br />
           <i><?php echo $text_longitude; ?></i> <?php echo $map_longitude; ?> <i>&deg; E</i>
           <br />
          <?php } ?>
        </div>
        <?php } ?>
      </div>
      <?php if ($map) { ?>
        <div id="contact-map"></div>
      <?php } ?>
    </div>
  </form>
  <?php echo $content_bottom; ?>
</div>
<?php echo $content_footer; ?>

<script type="text/javascript"><!--
$('#captcha-image').load(function(event) { 
	$(event.target).fadeIn(100);
});
//--></script>

<?php if ($map) { ?>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3.exp&amp;sensor=false&amp;language=en"></script>

<script type="text/javascript"><!--
var mapDiv, map, infobox;
var lat = <?php echo $map_latitude; ?>;
var lon = <?php echo $map_longitude; ?>;
jQuery(document).ready(function($) {
	mapDiv = $("#contact-map");
	mapDiv.height(360).gmap3({
		map:{
			options:{
				center:[lat,lon],
				zoom: 15
			}
		},
		marker:{
			values:[
				{latLng:[lat, lon], data:"<?php echo $map_location; ?>"},
			],
			options:{
				draggable: false
			},
			events:{
				mouseover: function(marker, event, context) {
					var map = $(this).gmap3("get"),
					infowindow = $(this).gmap3({get:{name:"infowindow"}});
					if (infowindow) {
						infowindow.open(map, marker);
						infowindow.setContent(context.data);
					} else {
						$(this).gmap3({
							infowindow:{
								anchor:marker, 
								options:{content: context.data}
							}
						});
					}
				},
				mouseout: function() {
					var infowindow = $(this).gmap3({get:{name:"infowindow"}});
					if (infowindow) {
						infowindow.close();
					}
				}
			}
		}
	});
});
//--></script>
<?php } ?>

<?php echo $footer; ?>