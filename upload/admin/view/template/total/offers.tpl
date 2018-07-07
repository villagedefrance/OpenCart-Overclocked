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
      <h1><img src="view/image/total.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons">
        <a onclick="$('#form').submit();" class="button-save ripple"><?php echo $button_save; ?></a>
        <a onclick="apply();" class="button-save ripple"><?php echo $button_apply; ?></a>
        <a href="<?php echo $cancel; ?>" class="button-cancel ripple"><?php echo $button_cancel; ?></a>
      </div>
    </div>
    <div class="content">
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
      <table class="form">
        <tr>
          <td><?php echo $entry_status; ?></td>
          <td><select name="offers_status">
            <?php if ($offers_status) { ?>
              <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
              <option value="0"><?php echo $text_disabled; ?></option>
            <?php } else { ?>
              <option value="1"><?php echo $text_enabled; ?></option>
              <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
            <?php } ?>
          </select></td>
        </tr>
        <tr>
          <td><?php echo $entry_taxes; ?><span class="help"><?php echo $help_taxes; ?></span></td>
          <td><?php if ($offers_taxes) { ?>
            <input type="radio" name="offers_taxes" value="1" id="offer-tax-on" class="radio" checked />
            <label for="offer-tax-on"><span><span></span></span><?php echo $text_yes; ?></label>
            <input type="radio" name="offers_taxes" value="0" id="offer-tax-off" class="radio" />
            <label for="offer-tax-off"><span><span></span></span><?php echo $text_no; ?></label>
          <?php } else { ?>
            <input type="radio" name="offers_taxes" value="1" id="offer-tax-on" class="radio" />
            <label for="offer-tax-on"><span><span></span></span><?php echo $text_yes; ?></label>
            <input type="radio" name="offers_taxes" value="0" id="offer-tax-off" class="radio" checked />
            <label for="offer-tax-off"><span><span></span></span><?php echo $text_no; ?></label>
          <?php } ?></td>
        </tr>
        <tr>
          <td><?php echo $entry_sort_order; ?></td>
          <td><input type="text" name="offers_sort_order" value="<?php echo $offers_sort_order; ?>" size="1" /></td>
        </tr>
      </table>
    </form>
    </div>
  </div>
</div>
<?php echo $footer; ?>