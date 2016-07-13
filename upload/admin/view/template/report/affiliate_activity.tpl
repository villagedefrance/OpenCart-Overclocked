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
        <div class="right"><a onclick="filter();" class="button-filter"><?php echo $button_filter; ?></a></div>
      </div>
      <table class="list">
        <thead>
          <tr>
            <td class="left"><?php echo $column_comment; ?></td>
            <td class="left"><?php echo $column_ip; ?></td>
            <td class="left"><?php echo $column_date_added; ?></td>
          </tr>
        </thead>
        <tbody>
      <?php if ($activities) { ?>
        <?php foreach ($activities as $activity) { ?>
          <tr>
            <td class="left"><?php echo $activity['comment']; ?></td>
            <td class="left"><?php echo $activity['ip']; ?></td>
            <td class="left"><?php echo $activity['date_added']; ?></td>
            <td class="right"><?php foreach ($affiliate['action'] as $action) { ?>
              <a href="<?php echo $action['href']; ?>" class="button-form"><?php echo $action['text']; ?></a>
            <?php } ?></td>
          </tr>
        <?php } ?>
      <?php } else { ?>
        <tr>
          <td class="center" colspan="4"><?php echo $text_no_results; ?></td>
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
  url = 'index.php?route=report/affiliate_activity&token=<?php echo $token; ?>';

  var filter_affiliate = $('input[name=\'filter_affiliate\']').val();

  if (filter_affiliate) {
    url += '&filter_affiliate=' + encodeURIComponent(filter_affiliate);
  }
  var filter_ip = $('input[name=\'filter_ip\']').val();

  if (filter_ip) {
    url += '&filter_ip=' + encodeURIComponent(filter_ip);
  }

  var filter_date_start = $('input[name=\'filter_date_start\']').attr('value');

  if (filter_date_start) {
    url += '&filter_date_start=' + encodeURIComponent(filter_date_start);
  }

  var filter_date_end = $('input[name=\'filter_date_end\']').attr('value');

  if (filter_date_end) {
    url += '&filter_date_end=' + encodeURIComponent(filter_date_end);
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
