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
    </div>
    <div class="content">
	<?php if ($navigation_hi) { ?>
      <div class="pagination" style="margin-bottom:10px;"><?php echo $pagination; ?></div>
    <?php } ?>
      <table class="list">
        <thead>
          <tr>
            <td class="left"><?php echo $column_ip; ?></td>
            <td class="left"><?php echo $column_customer; ?></td>
            <td class="left"><?php echo $column_url; ?></td>
            <td class="left"><?php echo $column_referer; ?></td>
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
            <td style="text-align:right;"><a onclick="filter();" class="button-filter"><?php echo $button_filter; ?></a></td>
          </tr>
          <?php if ($customers) { ?>
            <?php foreach ($customers as $customer) { ?>
            <tr>
              <td class="left"><a href="http://whatismyipaddress.com/ip/<?php echo $customer['ip']; ?>" target="_blank"><?php echo $customer['ip']; ?></a></td>
              <td class="left"><?php echo $customer['customer']; ?></td>
              <td class="left"><a href="<?php echo $customer['url']; ?>" target="_blank"><?php echo implode('<br />', str_split($customer['url'], 30)); ?></a></td>
              <td class="left"><?php if ($customer['referer']) { ?>
                <a href="<?php echo $customer['referer']; ?>" target="_blank"><?php echo implode('<br />', str_split($customer['referer'], 30)); ?></a>
              <?php } ?></td>
              <td class="left"><?php echo $customer['date_added']; ?></td>
              <td class="right"><?php foreach ($customer['action'] as $action) { ?>
                <a href="<?php echo $action['href']; ?>" class="button-form"><?php echo $action['text']; ?></a>
              <?php } ?></td>
            </tr>
            <?php } ?>
          <?php } else { ?>
            <tr>
              <td class="center" colspan="6"><?php echo $text_no_results; ?></td>
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

	var filter_ip = $('input[name=\'filter_ip\']').attr('value');

	if (filter_ip) {
		url += '&filter_ip=' + encodeURIComponent(filter_ip);
	}

	var filter_customer = $('input[name=\'filter_customer\']').attr('value');

	if (filter_customer) {
		url += '&filter_customer=' + encodeURIComponent(filter_customer);
	}

	location = url;
}
//--></script>

<?php echo $footer; ?>