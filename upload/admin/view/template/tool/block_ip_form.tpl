<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
  <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
  <?php } ?>
  </div>
  <?php if ($error_warning) { ?>
    <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/block.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons">
        <a onclick="$('#form').submit();" class="button-save"><?php echo $button_save; ?></a>
        <a onclick="apply();" class="button-save"><?php echo $button_apply; ?></a>
        <a href="<?php echo $cancel; ?>" class="button-cancel"><?php echo $button_cancel; ?></a>
      </div>
    </div>
    <div class="content">
    <h3><?php echo $heading_range; ?></h3>
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
      <div class="toggler" style="padding-bottom:10px;">
        <fieldset><p><?php echo $text_range; ?></p></fieldset>
      </div>
      <table class="form">
        <tr>
          <td><span class="required">* </span><?php echo $entry_from_ip; ?></td>
          <td><?php if ($error_from_ip) { ?>
            <input type="text" name="from_ip" value="<?php echo $from_ip; ?>" class="input-error" />
            <span class="error"><?php echo $error_from_ip; ?></span>
          <?php } else { ?>
            <input type="text" name="from_ip" value="<?php echo $from_ip; ?>" />
          <?php } ?></td>
        </tr>
        <tr>
          <td><span class="required">* </span><?php echo $entry_to_ip; ?></td>
          <td><?php if ($error_to_ip) { ?>
            <input type="text" name="to_ip" value="<?php echo $to_ip; ?>" class="input-error" />
            <span class="error"><?php echo $error_to_ip; ?></span>
          <?php } else { ?>
            <input type="text" name="to_ip" value="<?php echo $to_ip; ?>" />
          <?php } ?>
          <?php if ($error_range) { ?>
            <span class="error"><?php echo $error_range; ?></span>
          <?php } ?></td>
        </tr>
      </table>
    </form>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
$(document).ready(function() {
	$('.toggler').hide().before('<a id="<?php echo 'toggler'; ?>" class="button" style="margin:15px auto;"><i class="fa fa-info-circle"></i> &nbsp; <?php echo $button_info; ?></a>');
	$('#<?php echo 'toggler'; ?>').click(function() {
		$('.toggler').slideToggle(600);
		return false;
	});
});
//--></script>

<?php echo $footer; ?>
