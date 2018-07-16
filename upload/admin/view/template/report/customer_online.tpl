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
    <?php if (!$tracking) { ?>
      <div class="tooltip" style="margin-bottom:10px;"><?php echo $text_tracking; ?></div>
    <?php } else { ?>
      <div class="tooltip" style="margin-bottom:10px;"><?php echo $text_tooltip; ?></div>
    <?php } ?>
    <?php if ($navigation_hi) { ?>
      <div class="pagination" style="margin-bottom:10px;"><?php echo $pagination; ?></div>
    <?php } ?>
      <table id="customer-online" class="list">
        <thead>
          <tr>
            <td class="left"><?php echo $column_ip; ?></td>
            <td class="left"><?php echo $column_customer; ?></td>
            <td class="left"><?php echo $column_url; ?></td>
            <td class="left"><?php echo $column_referer; ?></td>
            <td class="left"><?php echo $column_user_agent; ?></td>
            <td class="left"><?php echo $column_date_added; ?></td>
            <td class="right"><?php echo $column_action; ?></td>
          </tr>
        </thead>
        <tbody>
          <tr class="filter">
            <td class="left"><input type="text" name="filter_ip" value="<?php echo $filter_ip; ?>" /></td>
            <td class="left"><input type="text" name="filter_customer" value="<?php echo $filter_customer; ?>" /></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td style="text-align:right;"><a onclick="filter();" class="button-filter ripple"><?php echo $button_filter; ?></a></td>
          </tr>
          <?php if ($customers) { ?>
            <?php foreach ($customers as $customer) { ?>
            <tr>
              <td class="left"><a onclick="window.open('http://whatismyipaddress.com/ip/<?php echo $customer['ip']; ?>');"><?php echo $customer['ip']; ?></a></td>
              <td class="left"><?php echo $customer['customer']; ?></td>
              <td class="left"><a onclick="window.open('<?php echo $customer['url']; ?>');"><?php echo implode('<br />', str_split($customer['url'], 30)); ?></a></td>
              <td class="left"><?php if ($customer['referer']) { ?>
                <a onclick="window.open('<?php echo $customer['referer']; ?>');"><?php echo implode('<br />', str_split($customer['referer'], 30)); ?></a>
              <?php } ?></td>
              <td class="left"><?php if ($customer['user_agent']) { ?>
                <?php echo implode('<br />', str_split($customer['user_agent'], 30)); ?>
              <?php } ?></td>
              <td class="left"><?php echo $customer['date_added']; ?></td>
              <td class="right"><?php foreach ($customer['action'] as $action) { ?>
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
	url = 'index.php?route=report/customer_online&token=<?php echo $token; ?>';

	var filter_ip = $('input[name=\'filter_ip\']').prop('value');

	if (filter_ip) {
		url += '&filter_ip=' + encodeURIComponent(filter_ip);
	}

	var filter_customer = $('input[name=\'filter_customer\']').prop('value');

	if (filter_customer) {
		url += '&filter_customer=' + encodeURIComponent(filter_customer);
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

<?php echo $footer; ?>