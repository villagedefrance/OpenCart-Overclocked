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
  <?php if ($success) { ?>
    <div class="success"><?php echo $success; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/backup.png" alt="" /> <?php echo $heading_title; ?></h1>
	  <div class="buttons">
        <a onclick="location = '<?php echo $refresh; ?>';" class="button"><?php echo $button_refresh; ?></a>
        <a href="<?php echo $cancel; ?>" class="button-cancel"><?php echo $button_cancel; ?></a>
      </div>
    </div>
    <div class="content">
      <form action="<?php echo $customer_export; ?>" method="post" enctype="multipart/form-data" id="export-customer">
        <h2><?php echo $heading_export; ?></h2>
        <table class="tool">
          <tr>
            <td width="20%"><?php echo $text_options; ?></td>
			<td>
              <?php echo ($setting_fax) ? '<img src="view/image/success.png" alt="" />' : '<img src="view/image/warning.png" alt="" />'; ?> &nbsp; <?php echo $text_option_fax; ?><br />
			  <?php echo ($setting_gender) ? '<img src="view/image/success.png" alt="" />' : '<img src="view/image/warning.png" alt="" />'; ?> &nbsp; <?php echo $text_option_gender; ?><br />
			  <?php echo ($setting_dob) ? '<img src="view/image/success.png" alt="" />' : '<img src="view/image/warning.png" alt="" />'; ?> &nbsp; <?php echo $text_option_dob; ?><br />
              <br />
            </td>
          </tr>
          <tr>
		    <td width="20%"><?php echo $entry_export; ?></td>
            <td><a onclick="$('#export-customer').submit();" class="button-filter"><?php echo $button_export; ?></a></td>
          </tr>
        </table>
      </form>
    </div>
  </div>
</div>
<?php echo $footer; ?>