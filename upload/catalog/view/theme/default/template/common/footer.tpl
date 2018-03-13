<?php if ($this->config->get($template . '_back_to_top')) { ?>
<p id="backtotop" style="display:block;">
  <a href="#" title=""><span></span></a>
</p>
<?php } ?>
<div id="footer-holder" class="<?php echo $footer_class; ?>">
  <div id="footer" class="<?php echo $mod_shape; ?> <?php echo $mod_color; ?>">
  <?php if ($footer_blocks) { ?>
  <div class="column-one" style="width:<?php echo ($this->config->get($template . '_footer_big_column')) ? (72 / $max_position) : (100 / $max_position); ?>%; display:<?php echo ($max_position > 0) ? 'block' : 'none'; ?>">
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
  <div class="column-two" style="width:<?php echo ($this->config->get($template . '_footer_big_column')) ? (72 / $max_position) : (100 / $max_position); ?>%; display:<?php echo ($max_position > 1) ? 'block' : 'none'; ?>">
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
  <div class="column-three" style="width:<?php echo ($this->config->get($template . '_footer_big_column')) ? (72 / $max_position) : (100 / $max_position); ?>%; display:<?php echo ($max_position > 2) ? 'block' : 'none'; ?>">
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
  <div class="column-four" style="width:<?php echo ($this->config->get($template . '_footer_big_column')) ? (72 / $max_position) : (100 / $max_position); ?>%; display:<?php echo ($max_position > 3) ? 'block' : 'none'; ?>">
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
  <?php if ($this->config->get($template . '_footer_big_column')) { ?>
  <div class="big-column">
  <?php if ($this->config->get($template . '_footer_location')) { ?>
  <p class="icon-location-<?php echo $footer_class; ?>"><?php echo $company; ?><br /><?php echo $address; ?></p>
  <?php } ?>
  <?php if ($this->config->get($template . '_footer_phone')) { ?>
  <p class="icon-phone-<?php echo $footer_class; ?>"><?php echo $telephone; ?></p>
  <?php } ?>
  <?php if ($this->config->get($template . '_footer_email')) { ?>
  <p class="icon-mail-<?php echo $footer_class; ?>"><?php echo $email; ?></p>
  <?php } ?>
  <span>
  <?php if ($this->config->get($template . '_footer_skype') && $skype) { ?>
  <script type="text/javascript" src="http://download.skype.com/share/skypebuttons/js/skypeCheck.js"></script>
  <a onclick="window.open('skype:<?php echo $skype; ?>?chat');" class="icon-skype" title="Skype"></a>
  <style>#skypedetectionswf{ display: none; }</style>
  <?php } ?>
  <?php if ($this->config->get($template . '_footer_instagram') && $instagram) { ?>
  <a onclick="window.open('<?php echo $instagram; ?>');" class="icon-instagram" title="Instagram"></a>
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
  <?php } ?>
  </div>
</div>
<?php if ($web_design) { ?>
<div style="float:right;"><?php echo $web_design; ?></div>
<?php } ?>
<?php if ($this->config->get($template . '_powered_by')) { ?>
<div id="powered"><?php echo $powered; ?></div>
<?php } ?>
<?php echo ($matomo) ? $matomo : ''; ?><br />
</div>
</div>

<?php foreach ($scripts as $script) { ?>
<script type="text/javascript" src="<?php echo $script; ?>"></script>
<?php } ?>

<?php if ($this->config->get($template . '_right_click')) { ?>
<script type="text/javascript"><!--
document.onselectstart = new Function('return false');
document.oncontextmenu = new Function('return false');
$('img').mousedown(function() {
  return false;
});
//--></script>
<?php } ?>

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

</body>
</html>