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
      <h1><img src="view/image/module.png" alt="" /> <?php echo $heading_title; ?></h1>
    <div class="buttons">
        <a onclick="location = '<?php echo $refresh; ?>';" class="button"><?php echo $button_refresh; ?></a>
      </div>
    </div>
    <div class="content">
      <?php if ($success_download) { ?>
        <div class="success" style="margin-top:10px;"><?php echo $success_download; ?></div>
      <?php } ?>
      <?php if ($success_install) { ?>
        <div class="success" style="margin-top:10px;"><?php echo $success_install; ?></div>
      <?php } ?>
	  <form action="<?php echo $update; ?>" method="post" enctype="multipart/form-data" id="form" name="update">
	    <table class="form">
		<?php if ($version && $revision) { ?>
		  <tr>
            <td></td>
            <td colspan="2"><span style='color: #FF8800;'><b><?php echo $text_status; ?></b></span></td>
          </tr>
          <tr>
            <td></td>
            <td><?php echo $current_version; ?></td>
            <td><?php echo $version; ?></td>
          </tr>
          <tr>
            <td></td>
            <td><?php echo $current_revision; ?></td>
            <td><?php echo $revision; ?></td>
          </tr>
        <?php } else { ?>
          <tr>
            <td></td>
            <td colspan="2"><?php echo $text_no_file; ?></td>
          </tr>
		<?php } ?>
        <?php if ($ver_update || $rev_update) { ?>
		  <tr>
            <td></td>
            <td colspan="2"><span style='color: #FF8800;'><b><?php echo $text_update; ?></b></span></td>
          </tr>
		  <?php if ($ready) { ?>
          <tr>
            <td></td>
            <td colspan="2">
			  <a onclick="Install();" class="button-form"><?php echo $button_install; ?></a>
			</td>
          </tr>
		  <?php } else { ?>
		  <tr>
            <td></td>
            <td colspan="2">
			  <a onclick="Download();" class="button-form"><?php echo $button_download; ?></a>
			</td>
          </tr>
		  <?php } ?>
		<?php } ?>
        </table>
        <input type="hidden" name="buttonForm" value="" />
      </form>
    </div>
  </div>
</div>

<script type="text/javascript"><!--
function Download() {
	document.update.buttonForm.value='download';
	$('#form').submit();
}
function Install() {
	document.update.buttonForm.value='install';
	$('#form').submit();
}
//--></script>

<?php echo $footer; ?>