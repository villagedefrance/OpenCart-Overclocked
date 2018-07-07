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
      <h1><img src="view/image/review.png" alt="" /> <?php echo $heading_title; ?></h1>
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
          <td><span class="required">*</span> <?php echo $entry_author; ?></td>
          <td><?php if ($error_author) { ?>
            <input type="text" name="author" value="<?php echo $author; ?>" size="40" class="input-error" />
            <span class="error"><?php echo $error_author; ?></span>
          <?php } else { ?>
            <input type="text" name="author" value="<?php echo $author; ?>" size="40" />
          <?php } ?></td>
        </tr>
        <tr>
          <td><?php echo $entry_product; ?></td>
          <td><?php if ($error_product) { ?>
            <input type="text" name="product" value="<?php echo $product; ?>" class="input-error" />
            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>" />
            <span class="error"><?php echo $error_product; ?></span>
          <?php } else { ?>
            <input type="text" name="product" value="<?php echo $product; ?>" />
            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>" />
          <?php } ?></td>
        </tr>
        <tr>
          <td><span class="required">*</span> <?php echo $entry_text; ?></td>
          <td><?php if ($error_text) { ?>
            <textarea name="text" cols="60" rows="8" class="input-error"><?php echo $text; ?></textarea>
            <span class="error"><?php echo $error_text; ?></span>
          <?php } else { ?>
            <textarea name="text" cols="60" rows="8"><?php echo $text; ?></textarea>
          <?php } ?></td>
        </tr>
        <tr>
          <td><?php echo $entry_rating; ?></td>
          <td>
            <b class="rating"><?php echo $entry_bad; ?></b>&nbsp;
            <?php if ($rating == 1) { ?>
              <input type="radio" name="rating" value="1" id="one" class="checkbox" checked />
              <label for="one"><span></span></label>
            <?php } else { ?>
              <input type="radio" name="rating" value="1" id="one" class="checkbox" />
              <label for="one"><span></span></label>
            <?php } ?>
            &nbsp;
            <?php if ($rating == 2) { ?>
              <input type="radio" name="rating" value="2" id="two" class="checkbox" checked />
              <label for="two"><span></span></label>
            <?php } else { ?>
              <input type="radio" name="rating" value="2" id="two" class="checkbox" />
              <label for="two"><span></span></label>
            <?php } ?>
            &nbsp;
            <?php if ($rating == 3) { ?>
              <input type="radio" name="rating" value="3" id="three" class="checkbox" checked />
              <label for="three"><span></span></label>
            <?php } else { ?>
              <input type="radio" name="rating" value="3" id="three" class="checkbox" />
              <label for="three"><span></span></label>
            <?php } ?>
            &nbsp;
            <?php if ($rating == 4) { ?>
              <input type="radio" name="rating" value="4" id="four" class="checkbox" checked />
              <label for="four"><span></span></label>
            <?php } else { ?>
              <input type="radio" name="rating" value="4" id="four" class="checkbox" />
              <label for="four"><span></span></label>
            <?php } ?>
            &nbsp;
            <?php if ($rating == 5) { ?>
              <input type="radio" name="rating" value="5" id="five" class="checkbox" checked />
              <label for="five"><span></span></label>
            <?php } else { ?>
              <input type="radio" name="rating" value="5" id="five" class="checkbox" />
              <label for="five"><span></span></label>
            <?php } ?>
            &nbsp; <b class="rating"><?php echo $entry_good; ?></b>
            <?php if ($error_rating) { ?>
              <span class="error"><?php echo $error_rating; ?></span>
            <?php } ?>
          </td>
        </tr>
        <tr class="highlighted">
          <td><?php echo $entry_status; ?></td>
          <td><select name="status">
            <?php if ($status) { ?>
              <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
              <option value="0"><?php echo $text_disabled; ?></option>
            <?php } else { ?>
              <option value="1"><?php echo $text_enabled; ?></option>
              <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
            <?php } ?>
          </select></td>
        </tr>
        <?php if ($date_added) { ?>
        <tr>
          <td><?php echo $text_date_added; ?></td>
          <td><?php echo $date_added; ?></td>
        </tr>
        <?php } ?>
        <?php if ($date_modified) { ?>
        <tr>
          <td><?php echo $text_date_modified; ?></td>
          <td><?php echo $date_modified; ?></td>
        </tr>
        <?php } ?>
      </table>
    </form>
    </div>
  </div>
</div>

<script type="text/javascript"><!--
$('input[name=\'product\']').autocomplete({
	delay: 10,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/product/autocomplete&token=<?php echo $token; ?>&filter_name=' + encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item.name,
						value: item.product_id
					}
				}));
			}
		});
	},
	select: function(event, ui) {
		$('input[name=\'product\']').attr('value', ui.item.label);
		$('input[name=\'product_id\']').attr('value', ui.item.value);

		return false;
	},
	focus: function(event, ui) {
		return false;
	}
});
//--></script>

<?php echo $footer; ?>