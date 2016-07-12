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
        <a href="<?php echo $insert; ?>" class="button"><?php echo $button_insert; ?></a>
        <a onclick="$('form').attr('action','<?php echo $delete; ?>'); $('form').submit();" class="button-delete"><?php echo $button_delete; ?></a>
      </div>
    </div>
    <div class="content">
    <?php if ($navigation_hi) { ?>
      <div class="pagination" style="margin-bottom:10px;"><?php echo $pagination; ?></div>
    <?php } ?>
    <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form">
      <table class="list">
        <thead>
         <thead>
          <tr>
            <td width="1" style="text-align:center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" id="check-all" class="checkbox" />
            <label for="check-all"><span></span></label></td>
            <td class="left"><?php if ($sort == 'name') { ?>
              <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
            <?php } else { ?>
              <a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?>&nbsp;&nbsp;<img src="view/image/sort.png" alt="" /></a>
            <?php } ?></td>
            <td class="left"><?php if ($sort == 'code') { ?>
              <a href="<?php echo $sort_code; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_code; ?></a>
              <?php } else { ?>
              <a href="<?php echo $sort_code; ?>"><?php echo $column_code; ?></a>
              <?php } ?></td>
            <td class="right"><?php echo $column_clicks; ?></td>
            <td class="right"><?php echo $column_orders; ?></td>
            <td class="center"><?php if ($sort == 'date_added') { ?>
              <a href="<?php echo $sort_date_added; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date_added; ?></a>
              <?php } else { ?>
              <a href="<?php echo $sort_date_added; ?>"><?php echo $column_date_added; ?></a>
              <?php } ?></td>
            <td class="right"><?php echo $column_action; ?></td>
          </tr>
        </thead>
        <tbody>
        <tr class="filter">
          <td></td>
          <td><input type="text" name="filter_name" value="<?php echo $filter_name; ?>" /></td>
          <td><input type="text" name="filter_code" value="<?php echo $filter_code; ?>" /></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td class="center"><input type="text" name="filter_date_added" value="<?php echo $filter_date_added; ?>" size="12" id="date" /></td>
          <td class="right"><a onclick="filter();" class="button-filter"><?php echo $button_filter; ?></a></td>
        </tr>
        <?php if ($marketings) { ?>
          <?php foreach ($marketings as $marketing) { ?>
          <tr>
            <td style="text-align:center;"><?php if (in_array($marketing['marketing_id'], $selected)) { ?>
              <input type="checkbox" name="selected[]" value="<?php echo $marketing['marketing_id']; ?>" id="<?php echo $marketing['marketing_id']; ?>" class="checkbox" checked />
              <label for="<?php echo $marketing['marketing_id']; ?>"><span></span></label>
            <?php } else { ?>
              <input type="checkbox" name="selected[]" value="<?php echo $marketing['marketing_id']; ?>" id="<?php echo $marketing['marketing_id']; ?>" class="checkbox" />
              <label for="<?php echo $marketing['marketing_id']; ?>"><span></span></label>
            <?php } ?></td>
            <td class="left"><?php echo $marketing['name']; ?></td>
            <td class="left"><?php echo $marketing['code']; ?></td>
            <td class="right"><?php echo $marketing['clicks']; ?></td>
            <td class="right"><?php echo $marketing['orders']; ?></td>
            <td class="center"><?php echo $marketing['date_added']; ?></td>
            <td class="right"><?php foreach ($marketing['action'] as $action) { ?>
              <a href="<?php echo $action['href']; ?>" class="button-form"><?php echo $action['text']; ?></a>
            <?php } ?></td>
          </tr>
          <?php } ?>
        <?php } else { ?>
          <tr>
            <td class="center" colspan="7"><?php echo $text_no_results; ?></td>
          </tr>
        <?php } ?>
        </tbody>
      </table>
    </form>
    <?php if ($navigation_lo) { ?>
      <div class="pagination"><?php echo $pagination; ?></div>
    <?php } ?>
    </div>
  </div>
</div>
<?php echo $footer; ?>

<script type="text/javascript"><!--
function filter() {
  url = 'index.php?route=marketing/marketing&token=<?php echo $token; ?>';
  
  var filter_name = $('input[name=\'filter_name\']').val();
  
  if (filter_name) {
    url += '&filter_name=' + encodeURIComponent(filter_name);
  }
  
  var filter_code = $('input[name=\'filter_code\']').val();
  
  if (filter_code) {
    url += '&filter_code=' + encodeURIComponent(filter_code);
  }
    
  var filter_date_added = $('input[name=\'filter_date_added\']').val();
  
  if (filter_date_added) {
    url += '&filter_date_added=' + encodeURIComponent(filter_date_added);
  }
 
  location = url;
}
//--></script>

<script type="text/javascript"><!--
$(document).ready(function() {
  $('#date').datepicker({dateFormat: 'yy-mm-dd'});
});
//--></script>
<?php echo $footer; ?>