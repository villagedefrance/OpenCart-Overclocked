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
    <?php } ?>
    <?php if ($navigation_hi) { ?>
      <div class="pagination" style="margin-bottom:10px;"><?php echo $pagination; ?></div>
    <?php } ?>
      <table id="robot-online" class="list">
        <thead>
          <tr>
            <td class="left"><?php echo $column_ip; ?></td>
            <td class="left"><?php echo $column_robot; ?></td>
            <td class="left"><?php echo $column_user_agent; ?></td>
            <td class="left"><?php echo $column_date_added; ?></td>
            <td class="right"><?php echo $column_action; ?></td>
          </tr>
        </thead>
        <tbody>
          <tr class="filter">
            <td class="left"><input type="text" name="filter_ip" value="<?php echo $filter_ip; ?>" /></td>
            <td class="left"><input type="text" name="filter_robot" value="<?php echo $filter_robot; ?>" /></td>
            <td></td>
            <td></td>
            <td style="text-align:right;"><a onclick="filter();" class="button-filter ripple"><?php echo $button_filter; ?></a></td>
          </tr>
          <?php if ($robots) { ?>
            <?php foreach ($robots as $robot) { ?>
            <tr>
              <td class="left"><a onclick="window.open('http://whatismyipaddress.com/ip/<?php echo $robot['ip']; ?>');"><?php echo $robot['ip']; ?></a></td>
              <td class="left"><?php echo $robot['robot']; ?></td>
              <td class="left"><?php if ($robot['user_agent']) { ?>
                <?php echo implode('<br />', str_split($robot['user_agent'], 40)); ?>
              <?php } ?></td>
              <td class="left"><?php echo $robot['date_added']; ?></td>
              <td class="right"></td>
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
	url = 'index.php?route=report/robot_online&token=<?php echo $token; ?>';

	var filter_ip = $('input[name=\'filter_ip\']').prop('value');

	if (filter_ip) {
		url += '&filter_ip=' + encodeURIComponent(filter_ip);
	}

	var filter_robot = $('input[name=\'filter_robot\']').prop('value');

	if (filter_robot) {
		url += '&filter_robot=' + encodeURIComponent(filter_robot);
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