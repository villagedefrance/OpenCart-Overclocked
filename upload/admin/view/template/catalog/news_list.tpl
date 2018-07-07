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
      <h1><img src="view/image/review.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons">
        <a onclick="location='<?php echo $module; ?>';" class="button-cancel ripple"><i class="fa fa-puzzle-piece"></i> &nbsp; <?php echo $button_module; ?></a>
        <a onclick="location='<?php echo $downloads; ?>';" class="button ripple"><i class="fa fa-paperclip"></i> &nbsp; <?php echo $button_downloads; ?></a>
        <a href="<?php echo $insert; ?>" class="button ripple"><?php echo $button_insert; ?></a>
        <a onclick="$('form').attr('action', '<?php echo $reset; ?>'); $('form').submit();" class="button-repair ripple"><?php echo $button_reset; ?></a>
        <a id="delete" class="button-delete ripple"><?php echo $button_delete; ?></a>
      </div>
    </div>
    <div class="content-body">
    <?php if ($navigation_hi) { ?>
      <div class="pagination" style="margin-bottom:10px;"><?php echo $pagination; ?></div>
    <?php } ?>
    <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form" name="newslist">
      <table class="list">
        <thead>
          <tr>
            <td width="1" style="text-align:center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" id="check-all" class="checkbox" />
            <label for="check-all"><span></span></label></td>
            <td class="center"><?php echo $column_image; ?></td>
            <td class="left"><?php if ($sort == 'nd.title') { ?>
              <a href="<?php echo $sort_title; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_title; ?> (<?php echo $total_news; ?>)</a>
            <?php } else { ?>
              <a href="<?php echo $sort_title; ?>"><?php echo $column_title; ?> (<?php echo $total_news; ?>)&nbsp;&nbsp;<img src="view/image/sort.png" alt="" /></a>
            <?php } ?></td>
            <td class="left"><?php if ($sort == 'n.date_added') { ?>
              <a href="<?php echo $sort_date_added; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date_added; ?></a>
            <?php } else { ?>
              <a href="<?php echo $sort_date_added; ?>"><?php echo $column_date_added; ?>&nbsp;&nbsp;<img src="view/image/sort.png" alt="" /></a>
            <?php } ?></td>
            <td class="left"><?php if ($sort == 'n.sort_order') { ?>
              <a href="<?php echo $sort_sort_order; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_sort_order; ?>
            <?php } else { ?>
              <a href="<?php echo $sort_sort_order; ?>"><?php echo $column_sort_order; ?>&nbsp;&nbsp;<img src="view/image/sort.png" alt="" /></a>
            <?php } ?></td>
            <td class="left"><?php if ($sort == 'n.status') { ?>
              <a href="<?php echo $sort_status; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_status; ?>
            <?php } else { ?>
              <a href="<?php echo $sort_status; ?>"><?php echo $column_status; ?>&nbsp;&nbsp;<img src="view/image/sort.png" alt="" /></a>
            <?php } ?></td>
            <td class="left"><?php if ($sort == 'n.viewed') { ?>
              <a href="<?php echo $sort_viewed; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_viewed; ?>
            <?php } else { ?>
              <a href="<?php echo $sort_viewed; ?>"><?php echo $column_viewed; ?>&nbsp;&nbsp;<img src="view/image/sort.png" alt="" /></a>
            <?php } ?></td>
            <td class="right"><?php echo $column_action; ?></td>
          </tr>
        </thead>
        <tbody>
        <?php if ($news) { ?>
          <?php $class = 'odd'; ?>
          <?php foreach ($news as $news_story) { ?>
            <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
            <tr class="<?php echo $class; ?>">
              <td class="center"><?php if ($news_story['selected']) { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $news_story['news_id']; ?>" id="<?php echo $news_story['news_id']; ?>" class="checkbox" checked />
                <label for="<?php echo $news_story['news_id']; ?>"><span></span></label>
              <?php } else { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $news_story['news_id']; ?>" id="<?php echo $news_story['news_id']; ?>" class="checkbox" />
                <label for="<?php echo $news_story['news_id']; ?>"><span></span></label>
              <?php } ?></td>
              <td class="center"><img src="<?php echo $news_story['image']; ?>" alt="<?php echo $news_story['title']; ?>" style="padding:1px; border:1px solid #DDD;" /></td>
              <td class="left"><?php echo $news_story['title']; ?></td>
              <td class="left"><?php echo $news_story['date_added']; ?></td>
              <td class="center"><?php echo $news_story['sort_order']; ?></td>
              <?php if ($news_story['status'] == 1) { ?>
                <td class="center"><span class="enabled"><?php echo $text_enabled; ?></span></td>
              <?php } else { ?>
                <td class="center"><span class="disabled"><?php echo $text_disabled; ?></span></td>
              <?php } ?>
              <td class="center"><?php echo $news_story['viewed']; ?></td>
              <td class="right">
                <?php foreach ($news_story['action'] as $action) { ?>
                  <a href="<?php echo $action['href']; ?>" class="button-form animated fadeIn ripple"><?php echo $action['text']; ?></a>
                <?php } ?>
              </td>
            </tr>
          <?php } ?>
        <?php } else { ?>
          <tr class="even">
            <td class="center" colspan="8"><?php echo $text_no_results; ?></td>
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

<script type="text/javascript"><!--
$('#delete').on('click', function() {
	$.confirm({
		title: '<?php echo $text_confirm_delete; ?>',
		content: '<?php echo $text_confirm; ?>',
		icon: 'fa fa-question-circle',
		theme: 'light',
		useBootstrap: false,
		boxWidth: 580,
		animation: 'zoom',
		closeAnimation: 'scale',
		opacity: 0.1,
		buttons: {
			confirm: function() {
				$('form').submit();
			},
			cancel: function() { }
		}
	});
});
//--></script>

<?php echo $footer; ?>