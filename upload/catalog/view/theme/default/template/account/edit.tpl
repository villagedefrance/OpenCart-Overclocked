<?php echo $header; ?>
<?php echo $content_header; ?>
<?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
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
  <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" name="edit">
  <h2><?php echo $text_your_details; ?></h2>
  <div class="content">
    <table class="form">
      <tr>
        <td><span class="required">*</span> <?php echo $entry_firstname; ?></td>
        <td><input type="text" name="firstname" value="<?php echo $firstname; ?>" size="30" />
        <?php if ($error_firstname) { ?>
          <span class="error"><?php echo $error_firstname; ?></span>
        <?php } ?></td>
      </tr>
      <tr>
        <td><span class="required">*</span> <?php echo $entry_lastname; ?></td>
        <td><input type="text" name="lastname" value="<?php echo $lastname; ?>" size="30" />
        <?php if ($error_lastname) { ?>
          <span class="error"><?php echo $error_lastname; ?></span>
        <?php } ?></td>
      </tr>
      <tr>
        <td><span class="required">*</span> <?php echo $entry_email; ?></td>
        <td><input type="text" name="email" value="<?php echo $email; ?>" size="30" />
        <?php if ($error_email) { ?>
          <span class="error"><?php echo $error_email; ?></span>
        <?php } ?></td>
      </tr>
      <tr>
        <td><span class="required">*</span> <?php echo $entry_telephone; ?></td>
        <td><input type="text" name="telephone" value="<?php echo $telephone; ?>" />
        <?php if ($error_telephone) { ?>
          <span class="error"><?php echo $error_telephone; ?></span>
        <?php } ?></td>
      </tr>
      <?php if ($show_fax) { ?>
      <tr>
        <td><?php echo $entry_fax; ?></td>
        <td><input type="text" name="fax" value="<?php echo $fax; ?>" /></td>
      </tr>
      <?php } ?>
      <?php if ($show_gender) { ?>
      <tr>
        <td><?php echo $entry_gender; ?></td>
        <td><?php if ($gender) { ?>
          <input type="radio" name="gender" value="1" checked="checked" /><?php echo $text_female; ?>
          <input type="radio" name="gender" value="0" /><?php echo $text_male; ?>
        <?php } else { ?>
          <input type="radio" name="gender" value="1" /><?php echo $text_female; ?>
          <input type="radio" name="gender" value="0" checked="checked" /><?php echo $text_male; ?>
        <?php } ?> &nbsp; <a class="button button-gender"><i class="fa fa-info-circle"></i></a>
        </td>
      </tr>
      <?php } ?>
      <?php if ($show_dob) { ?>
      <tr>
        <td><span class="required">*</span> <?php echo $entry_date_of_birth; ?></td>
        <td><input type="text" name="date_of_birth" value="<?php echo $date_of_birth; ?>" id="date-of-birth" size="12" /> &nbsp; <a class="button button-dob"><i class="fa fa-info-circle"></i></a>
        <?php if ($error_date_of_birth) { ?>
          <span class="error"><?php echo $error_date_of_birth; ?></span>
        <?php } ?>
        </td>
      </tr>
      <?php } ?>
    </table>
  </div>
  <div class="buttons">
    <div class="left"><a href="<?php echo $back; ?>" class="button"><i class="fa fa-arrow-left"></i> &nbsp; <?php echo $button_back; ?></a></div>
    <div class="right"><input type="submit" value="<?php echo $button_continue; ?>" class="button" /></div>
  </div>
  </form>
  <h2><?php echo $heading_gdpr; ?></h2>
  <div class="content-info">
    <p><?php echo $help_gdpr; ?></p>
    <ul>
      <li><?php echo $gdpr_firstname; ?></li>
      <li><?php echo $gdpr_lastname; ?></li>
      <li><?php echo $gdpr_address; ?></li>
      <li><?php echo $gdpr_email; ?></li>
      <li><?php echo $gdpr_telephone; ?></li>
    <?php if ($show_fax) { ?>
      <li><?php echo $gdpr_fax; ?></li>
    <?php } ?>
    <?php if ($show_gender) { ?>
      <li><?php echo $gdpr_gender; ?></li>
    <?php } ?>
    <?php if ($show_dob) { ?>
      <li><?php echo $gdpr_date_of_birth; ?></li>
    <?php } ?>
      <li><?php echo $gdpr_password; ?></li>
    <?php if ($track_online) { ?>
      <li><?php echo $gdpr_user_agent; ?></li>
    <?php } ?>
      <li><?php echo $gdpr_ip; ?></li>
    </ul>
  </div>
  <h2><?php echo $heading_copying; ?></h2>
  <div class="content-info">
    <p><?php echo $help_copying; ?></p>
    <p>
      <a onclick="window.open('<?php echo $customer_data; ?>');" class="button"><i class="fa fa-eye"></i> &nbsp; <?php echo $button_view; ?></a> &nbsp;
      <a onclick="window.open('<?php echo $customer_data; ?>&pdf=true');" class="button"><i class="fa fa-download"></i> &nbsp; <?php echo $button_download; ?></a> &nbsp;
      <a href="<?php echo $customer_data; ?>" id="print-data" class="button"><i class="fa fa-print"></i> &nbsp; <?php echo $button_print; ?></a>
    </p>
  </div>
  <h2><?php echo $heading_closing; ?></h2>
  <div class="content-info">
    <p><?php echo $help_closing; ?></p>
    <p>
      <a href="<?php echo $close_account; ?>" class="button-danger"><i class="fa fa-close"></i> &nbsp; <?php echo $button_delete; ?></a>
    </p>
  </div>
  <?php echo $content_bottom; ?>
</div>
<?php echo $content_footer; ?>

<link rel="stylesheet" type="text/css" href="catalog/view/javascript/jquery/confirm/jquery-confirm.min.css" />

<script type="text/javascript" src="catalog/view/javascript/jquery/confirm/jquery-confirm.min.js"></script>

<script type="text/javascript"><!--
$('a.button-gender').confirm({
	title: '<?php echo $gdpr_gender; ?>',
	content: '<?php echo $dialog_gender; ?>',
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

<script type="text/javascript"><!--
$('a.button-dob').confirm({
	title: '<?php echo $gdpr_date_of_birth; ?>',
	content: '<?php echo $dialog_date_of_birth; ?>',
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

<script type="text/javascript"><!--
$(document).ready(function() {
	$('#date-of-birth').datepicker({dateFormat: 'yy-mm-dd'});
});
//--></script>

<script type="text/javascript" src="catalog/view/javascript/jquery/jquery-printpage.min.js"></script>

<script type="text/javascript"><!--
$(document).ready(function() {
	$('#print-data').printPage({
		url: false,
		attr: 'href',
		message: '<?php echo $text_print_data; ?>'
	});
});
//--></script>

<?php echo $footer; ?>