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
        <a onclick="location='<?php echo $close; ?>';" class="button-cancel ripple"><?php echo $button_close; ?></a>
      </div>
    </div>
    <div class="content-body">
    <?php if ($navigation_hi) { ?>
      <div class="pagination" style="margin-bottom:10px;"><?php echo $pagination; ?></div>
    <?php } ?>
      <div class="report">
        <div class="left"><i class="fa fa-search" style="font-size:19px;"></i></div>
        <div class="left"><em><?php echo $entry_date_start; ?></em> <input type="text" name="filter_date_start" value="<?php echo $filter_date_start; ?>" id="input-date-start" size="12" /> <img src="view/image/calendar.png" alt="" /></div>
        <div class="left"><em><?php echo $entry_date_end; ?></em> <input type="text" name="filter_date_end" value="<?php echo $filter_date_end; ?>" id="input-date-end" size="12" /> <img src="view/image/calendar.png" alt="" /></div>
        <div class="right"><a onclick="filter();" class="button-filter ripple"><?php echo $button_filter; ?></a></div>
      </div>
      <table class="list">
        <thead>
          <tr>
            <td class="left"><?php echo $column_affiliate; ?></td>
            <td class="left"><?php echo $column_email; ?></td>
            <td class="left"><?php echo $column_status; ?></td>
            <td class="right"><?php echo $column_commission; ?></td>
            <td class="right"><?php echo $column_orders; ?></td>
            <td class="right"><?php echo $column_total; ?></td>
            <td class="right"><?php echo $column_action; ?></td>
          </tr>
        </thead>
        <tbody>
        <?php if ($affiliates) { ?>
          <?php foreach ($affiliates as $affiliate) { ?>
          <tr>
            <td class="left"><?php echo $affiliate['affiliate']; ?></td>
            <td class="left"><?php echo $affiliate['email']; ?></td>
            <td class="left"><?php echo $affiliate['status']; ?></td>
            <td class="right"><?php echo $affiliate['commission']; ?></td>
            <td class="right"><?php echo $affiliate['orders']; ?></td>
            <td class="right"><?php echo $affiliate['total']; ?></td>
            <td class="right"><?php foreach ($affiliate['action'] as $action) { ?>
              <a href="<?php echo $action['href']; ?>" class="button-form ripple"><?php echo $action['text']; ?></a>
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
    <?php if ($navigation_lo) { ?>
      <div class="pagination"><?php echo $pagination; ?></div>
    <?php } ?>
    </div>
  </div>
</div>

<script type="text/javascript"><!--
function filter() {
	url = 'index.php?route=report/affiliate_commission&token=<?php echo $token; ?>';

	var filter_date_start = $('input[name=\'filter_date_start\']').prop('value');

	if (filter_date_start) {
		url += '&filter_date_start=' + encodeURIComponent(filter_date_start);
	}

	var filter_date_end = $('input[name=\'filter_date_end\']').prop('value');

	if (filter_date_end) {
		url += '&filter_date_end=' + encodeURIComponent(filter_date_end);
	}

	location = url;
}
//--></script>

<script type="text/javascript"><!--
window.addEventListener("keydown", function(event) {
	if (event.defaultPrevented) {
		return;
	}

	switch (event.key) {
	case "Enter": filter();
		break;
	default:
		return;
	}

	event.preventDefault();
}, true);
//--></script>

<script type="text/javascript"><!--
$(document).ready(function() {
  $('#input-date-start').datepicker({dateFormat: 'yy-mm-dd'});
  $('#input-date-end').datepicker({dateFormat: 'yy-mm-dd'});
});
//--></script>

<?php echo $footer; ?>