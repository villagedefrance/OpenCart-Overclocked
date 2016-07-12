<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
  <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
  <?php } ?>
  </div>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/report.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons">
        <a onclick="location = '<?php echo $close; ?>';" class="button-cancel"><?php echo $button_close; ?></a>
      </div>
    </div>
    <div class="content">
    <?php if ($navigation_hi) { ?>
      <div class="pagination" style="margin-bottom:10px;"><?php echo $pagination; ?></div>
    <?php } ?>
      <div class="report">
        <div class="left"><img src="view/image/filter.png" alt="" /></div>
        <div class="left"><?php echo $entry_date_start; ?> <input type="text" name="filter_date_start" value="<?php echo $filter_date_start; ?>" id="input-date-start" size="12" /> <img src="view/image/calendar.png" alt="" /></div>
        <div class="left"><?php echo $entry_date_end; ?> <input type="text" name="filter_date_end" value="<?php echo $filter_date_end; ?>" id="input-date-end" size="12" /> <img src="view/image/calendar.png" alt="" /></div>
        <div class="left"><?php echo $entry_status; ?> <select name="filter_order_status_id" id="input-status">
          <option value="0"><?php echo $text_all_status; ?></option>
          <?php foreach ($order_statuses as $order_status) { ?>
            <?php if ($order_status['order_status_id'] == $filter_order_status_id) { ?>
              <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
            <?php } else { ?>
              <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
            <?php } ?>
          <?php } ?>
        </select></div>
        <div class="right"><a onclick="filter();" class="button-filter"><?php echo $button_filter; ?></a></div>
      </div>
      <table class="list">
        <thead>
          <tr>
            <td class="left"><?php echo $column_campaign; ?></td>
            <td class="left"><?php echo $column_code; ?></td>
            <td class="right"><?php echo $column_clicks; ?></td>
            <td class="right"><?php echo $column_orders; ?></td>
            <td class="right"><?php echo $column_total; ?></td>
          </tr>
        </thead>
        <tbody>
          <?php if ($marketings) { ?>
          <?php foreach ($marketings as $marketing) { ?>
          <tr>
            <td class="left"><?php echo $marketing['campaign']; ?></td>
            <td class="left"><?php echo $marketing['code']; ?></td>
            <td class="right"><?php echo $marketing['clicks']; ?></td>
            <td class="right"><?php echo $marketing['orders']; ?></td>
            <td class="right"><?php echo $marketing['total']; ?></td>
          </tr>
          <?php } ?>
          <?php } else { ?>
          <tr>
            <td class="center" colspan="5"><?php echo $text_no_results; ?></td>
          </tr>
          <?php } ?>
      </tbody>
      </table>
    <?php if ($navigation_lo) { ?>
      <div class="pagination"><?php echo $pagination; ?></div>
    <?php } ?>
    </div>
  </div>
</div>

<script type="text/javascript"><!--
function filter() {
  url = 'index.php?route=report/marketing&token=<?php echo $token; ?>';

  var filter_date_start = $('input[name=\'filter_date_start\']').attr('value');

  if (filter_date_start) {
    url += '&filter_date_start=' + encodeURIComponent(filter_date_start);
  }

  var filter_date_end = $('input[name=\'filter_date_end\']').attr('value');

  if (filter_date_end) {
    url += '&filter_date_end=' + encodeURIComponent(filter_date_end);
  }

  var filter_order_status_id = $('select[name=\'filter_order_status_id\']').val();

  if (filter_order_status_id != 0) {
    url += '&filter_order_status_id=' + encodeURIComponent(filter_order_status_id);
  }

  location = url;
}
//--></script>

<script type="text/javascript"><!--
$(document).ready(function() {
  $('#input-date-start').datepicker({dateFormat: 'yy-mm-dd'});
  $('#input-date-end').datepicker({dateFormat: 'yy-mm-dd'});
});
//--></script>

<?php echo $footer; ?>
