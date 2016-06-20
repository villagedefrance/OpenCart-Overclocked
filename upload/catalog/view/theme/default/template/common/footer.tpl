<?php if ($this->config->get($template . '_back_to_top')) { ?>
<p id="backtotop" style="display:block;">
  <a href="#" title=""><span></span></a>
</p>
<?php } ?>
<div id="footer-holder" class="footer-<?php echo $footer_class; ?>">
  <div id="footer" class="<?php echo $mod_shape; ?> <?php echo $mod_color; ?>-skin">
  <?php if ($footer_blocks) { ?>
  <div class="column-one" style="width:<?php echo $column_width; ?>;">
  <?php foreach ($footer_blocks as $footer_block) { ?>
  <?php if (($footer_block['position'] == 1) && $footer_block['status']) { ?>
  <h3><?php echo $footer_block['name']; ?></h3>
  <ul>
  <?php foreach ($footer_routes as $footer_route) { ?>
  <?php if ($footer_route['footer_id'] == $footer_block['footer_id']) { ?>
  <li><a href="<?php echo $footer_route['route']; ?>"><?php echo $footer_route['title']; ?></a></li>
  <?php } ?>
  <?php } ?>
  </ul>
  <?php } ?>
  <?php } ?>
  </div>
  <div class="column-two" style="width:<?php echo $column_width; ?>;">
  <?php foreach ($footer_blocks as $footer_block) { ?>
  <?php if (($footer_block['position'] == 2) && $footer_block['status']) { ?>
  <h3><?php echo $footer_block['name']; ?></h3>
  <ul>
  <?php foreach ($footer_routes as $footer_route) { ?>
  <?php if ($footer_route['footer_id'] == $footer_block['footer_id']) { ?>
  <li><a href="<?php echo $footer_route['route']; ?>"><?php echo $footer_route['title']; ?></a></li>
  <?php } ?>
  <?php } ?>
  </ul>
  <?php } ?>
  <?php } ?>
  </div>
  <div class="column-three" style="width:<?php echo $column_width; ?>;">
  <?php foreach ($footer_blocks as $footer_block) { ?>
  <?php if (($footer_block['position'] == 3) && $footer_block['status']) { ?>
  <h3><?php echo $footer_block['name']; ?></h3>
  <ul>
  <?php foreach ($footer_routes as $footer_route) { ?>
  <?php if ($footer_route['footer_id'] == $footer_block['footer_id']) { ?>
  <li><a href="<?php echo $footer_route['route']; ?>"><?php echo $footer_route['title']; ?></a></li>
  <?php } ?>
  <?php } ?>
  </ul>
  <?php } ?>
  <?php } ?>
  </div>
  <div class="column-four" style="width:<?php echo $column_width; ?>;">
  <?php foreach ($footer_blocks as $footer_block) { ?>
  <?php if (($footer_block['position'] == 4) && $footer_block['status']) { ?>
  <h3><?php echo $footer_block['name']; ?></h3>
  <ul>
  <?php foreach ($footer_routes as $footer_route) { ?>
  <?php if ($footer_route['footer_id'] == $footer_block['footer_id']) { ?>
  <li><a href="<?php echo $footer_route['route']; ?>"><?php echo $footer_route['title']; ?></a></li>
  <?php } ?>
  <?php } ?>
  </ul>
  <?php } ?>
  <?php } ?>
  </div>
  <div class="big-column">
  <?php if ($this->config->get($template . '_footer_location')) { ?>
  <p class="icon-location-<?php echo $footer_class; ?>" title="Location"><?php echo $company; ?><br /><?php echo $address; ?></p>
  <?php } ?>
  <?php if ($this->config->get($template . '_footer_phone')) { ?>
  <p class="icon-phone-<?php echo $footer_class; ?>" title="Phone"><?php echo $telephone; ?></p>
  <?php } ?>
  <?php if ($this->config->get($template . '_footer_email')) { ?>
  <p class="icon-mail-<?php echo $footer_class; ?>" title="Email"><?php echo $email; ?></p>
  <?php } ?>
  <span>
  <?php if ($this->config->get($template . '_footer_skype') && $skype) { ?>
  <script type="text/javascript" src="http://download.skype.com/share/skypebuttons/js/skypeCheck.js"></script>
  <a onclick="window.open('skype:<?php echo $skype; ?>?chat');" class="icon-skype" title="Skype"></a>
  <style>#skypedetectionswf{ display: none; }</style>
  <?php } ?>
  <?php if ($this->config->get($template . '_footer_pinterest') && $pinterest) { ?>
  <a onclick="window.open('<?php echo $pinterest; ?>');" class="icon-pinterest" title="Pinterest"></a>
  <?php } ?>
  <?php if ($this->config->get($template . '_footer_google') && $google) { ?>
  <a onclick="window.open('<?php echo $google; ?>');" class="icon-google" title="Google+"></a>
  <?php } ?>
  <?php if ($this->config->get($template . '_footer_twitter') && $twitter) { ?>
  <a onclick="window.open('<?php echo $twitter; ?>');" class="icon-twitter" title="Twitter"></a>
  <?php } ?>
  <?php if ($this->config->get($template . '_footer_facebook') && $facebook) { ?>
  <a onclick="window.open('<?php echo $facebook; ?>');" class="icon-facebook" title="Facebook"></a>
  <?php } ?>
  </span>
  </div>
  <?php } ?>
  </div>
</div>
<!--
OpenCart is open source software and you are free to remove the powered by OpenCart if you want, but it's generally accepted practise to make a small donation.
Please donate via PayPal to donate@opencart.com
//-->
<?php if ($web_design) { ?>
<div style="float:right;"><?php echo $web_design; ?></div>
<?php } ?>
<?php if ($this->config->get($template . '_powered_by')) { ?>
<div id="powered"><?php echo $powered; ?></div>
<?php } ?>
</div>
<?php echo ($piwik) ? $piwik : ''; ?>
<?php if ($this->config->get($template . '_back_to_top')) { ?>
<script type="text/javascript"><!--
$(document).ready(function() {
  $('#backtotop').hide();
  $(function() {
    $(window).scroll(function() {
      if ($(this).scrollTop() > 100) {
        $('#backtotop').fadeIn();
      } else {
        $('#backtotop').fadeOut();
      }
    });
    $('#backtotop a').click(function() {
      $('body,html').animate({scrollTop:0}, 800);
      return false;
    });
  });
});
//--></script>
<?php } ?>
</body></html>