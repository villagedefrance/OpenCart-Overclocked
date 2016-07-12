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
      <h1><img src="view/image/offer.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons">
        <a onclick="$('#form').submit();" class="button-save"><?php echo $button_save; ?></a>
        <a onclick="apply();" class="button-save"><?php echo $button_apply; ?></a>
        <a href="<?php echo $cancel; ?>" class="button-cancel"><?php echo $button_cancel; ?></a>
      </div>
    </div>
    <div class="content">
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
      <table class="form">
        <tbody>
          <tr>
            <td><span class="required">*</span>&nbsp;<label for="input-name"><?php echo $entry_name; ?></label></td>
            <td><?php if ($error_name) { ?>
              <input type="text" name="name" id="input-name" value="<?php echo $name; ?>" class="input-error" />
              <span class="error"><?php echo $error_name; ?></span>
            <?php } else { ?>
              <input type="text" name="name" id="input-name" value="<?php echo $name; ?>" size="50" />
            <?php } ?></td>
          </tr>
          <tr>
            <td><label for="input-description"><?php echo $entry_description; ?></label></td>
            <td><textarea name="description" id="input-description" cols="125" rows="5"><?php echo $description; ?></textarea></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <label for="input-code"><?php echo $entry_code; ?><br /><span class="help"><?php echo $help_code; ?></span></label></td>
            <td><?php if ($error_code) { ?>
              <input type="text" name="code" id="input-code" value="<?php echo $code; ?>" class="input-error" />
              <span class="error"><?php echo $error_code; ?></span>
            <?php } else { ?>
              <input type="text" name="code" id="input-code" value="<?php echo $code; ?>" size="50" />
            <?php } ?></td>
          </tr>
          <tr>
            <td><label for="input-example"><?php echo $entry_example; ?><br /><span class="help"><?php echo $help_example; ?></span></label></td>
            <td><input type="text" name="example1" id="input-example1" value="" size="125" /><br />
                <input type="text" name="example2" id="input-example2" value="" size="125" />
            </td>
          </tr>
        </tbody>
      </table>
    </form>
    </div>
  </div>
</div>

<script type="text/javascript"><!--
$('#input-code').on('keyup', function() {
  $('#input-example1').val('<?php echo $store; ?>?tracking=' + $('#input-code').val());
  $('#input-example2').val('<?php echo $store; ?>index.php?route=common/home&tracking=' + $('#input-code').val());
});

$('#input-code').trigger('keyup');
//--></script></div>
<?php echo $footer; ?>