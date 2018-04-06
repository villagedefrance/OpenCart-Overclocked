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
      <h1><img src="view/image/server.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons">
        <a href="<?php echo $insert; ?>" class="button"><?php echo $button_insert; ?></a>
        <a id="delete" class="button-delete"><?php echo $button_delete; ?></a>
      </div>
    </div>
    <div style="height:24px; margin-top:8px;">
      <a href="<?php echo $seo_category; ?>" class="button-filter"><?php echo $link_seo_category; ?></a>
      <a href="<?php echo $seo_product; ?>" class="button-filter"><?php echo $link_seo_product; ?></a>
      <a href="<?php echo $seo_manufacturer; ?>" class="button-filter"><?php echo $link_seo_manufacturer; ?></a>
      <a href="<?php echo $seo_information; ?>" class="button-filter"><?php echo $link_seo_information; ?></a>
      <a href="<?php echo $seo_news; ?>" class="button-filter"><?php echo $link_seo_news; ?></a>
      <?php if ($seo_url_total == $keyword_total) { ?>
        <span style="background:#5DC15E; color:#FFF; padding:3px 6px; float:right;"><?php echo $seo_url_total; ?> / <?php echo $keyword_total; ?></span>
      <?php } else { ?>
        <span style="background:#DE5954; color:#FFF; padding:3px 6px; float:right;"><?php echo $seo_url_total; ?> / <?php echo $keyword_total; ?></span>
      <?php } ?>
    </div>
    <div class="content-body">
    <?php if ($error_url_status) { ?>
      <div class="attention" style="margin:0 0 10px 0;"><?php echo $error_url_status; ?></div>
    <?php } ?>
    <?php if ($success_url_status) { ?>
      <div class="tooltip" style="margin:0 0 10px 0;"><?php echo $success_url_status; ?></div>
    <?php } ?>
    <?php if ($navigation_hi) { ?>
      <div class="pagination" style="margin-bottom:10px;"><?php echo $pagination; ?></div>
    <?php } ?>
      <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form">
        <table class="list">
        <thead>
          <tr>
            <td width="1" style="text-align:center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" id="check-all" class="checkbox" />
            <label for="check-all"><span></span></label></td>
            <td class="left"><?php if ($sort == 'url_alias_id') { ?>
              <a href="<?php echo $sort_url_alias_id; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_url_alias_id; ?></a>
            <?php } else { ?>
              <a href="<?php echo $sort_url_alias_id; ?>"><?php echo $column_url_alias_id; ?>&nbsp;&nbsp;<img src="view/image/sort.png" alt="" /></a>
            <?php } ?></td>
            <td class="left"><?php echo $column_query; ?></td>
            <td class="left"><?php if ($sort == 'keyword') { ?>
              <a href="<?php echo $sort_keyword; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_keyword; ?></a>
            <?php } else { ?>
              <a href="<?php echo $sort_keyword; ?>"><?php echo $column_keyword; ?>&nbsp;&nbsp;<img src="view/image/sort.png" alt="" /></a>
            <?php } ?></td>
            <td class="right"><?php echo $column_action; ?></td>
          </tr>
        </thead>
        <tbody>
          <?php if ($seo_urls) { ?>
            <?php foreach ($seo_urls as $seo_url) { ?>
              <tr>
                <td style="text-align:center;"><?php if ($seo_url['selected']) { ?>
                  <input type="checkbox" name="selected[]" value="<?php echo $seo_url['url_alias_id']; ?>" id="<?php echo $seo_url['url_alias_id']; ?>" class="checkbox" checked />
                  <label for="<?php echo $seo_url['url_alias_id']; ?>"><span></span></label>
                <?php } else { ?>
                  <input type="checkbox" name="selected[]" value="<?php echo $seo_url['url_alias_id']; ?>" id="<?php echo $seo_url['url_alias_id']; ?>" class="checkbox" />
                  <label for="<?php echo $seo_url['url_alias_id']; ?>"><span></span></label>
                <?php } ?></td>
                <td class="left"><?php echo $seo_url['url_alias_id']; ?></td>
                <?php if ($seo_url['query_link']) { ?>
                  <td class="left"><a href="<?php echo $seo_url['query_link']; ?>"><?php echo $seo_url['query']; ?></a></td>
                <?php } else { ?>
                  <td class="left"><?php echo $seo_url['query']; ?></td>
                <?php } ?>
                <td class="left"><?php echo $seo_url['keyword']; ?></td>
                <td class="right"><?php foreach ($seo_url['action'] as $action) { ?>
                  <a href="<?php echo $action['href']; ?>" class="button-form animated fadeIn"><?php echo $action['text']; ?></a>
                <?php } ?></td>
              </tr>
            <?php } ?>
          <?php } else { ?>
            <tr>
              <td class="center" colspan="5"><?php echo $text_no_results; ?></td>
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