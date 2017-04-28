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
      <h1><img src="view/image/download.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons">
        <a onclick="location='<?php echo $news_list; ?>';" class="button-cancel"><?php echo $button_news; ?></a>
        <a href="<?php echo $insert; ?>" class="button"><?php echo $button_insert; ?></a>
        <a onclick="$('#form').submit();" class="button-delete"><?php echo $button_delete; ?></a>
      </div>
    </div>
    <div class="content-body">
    <?php if ($navigation_hi) { ?>
      <div class="pagination" style="margin-bottom:10px;"><?php echo $pagination; ?></div>
    <?php } ?>
    <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form">
      <table class="list">
        <thead>
          <tr>
            <td width="1" style="text-align:center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" id="check-all" class="checkbox" />
            <label for="check-all"><span></span></label></td>
            <td class="left"><?php if ($sort == 'pdd.name') { ?>
              <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
            <?php } else { ?>
              <a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?>&nbsp;&nbsp;<img src="view/image/sort.png" alt="" /></a>
            <?php } ?></td>
            <td class="center"><?php echo $column_action; ?></td>
          </tr>
        </thead>
        <tbody>
        <?php if ($downloads) { ?>
          <?php $class = 'odd'; ?>
          <?php foreach ($downloads as $download) { ?>
            <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
            <tr class="<?php echo $class; ?>">
              <td style="text-align:center;"><?php if ($download['selected']) { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $download['news_download_id']; ?>" id="<?php echo $download['news_download_id']; ?>" class="checkbox" checked />
                <label for="<?php echo $download['news_download_id']; ?>"><span></span></label>
              <?php } else { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $download['news_download_id']; ?>" id="<?php echo $download['news_download_id']; ?>" class="checkbox" />
                <label for="<?php echo $download['news_download_id']; ?>"><span></span></label>
              <?php } ?></td>
              <td class="left"><?php echo $download['name']; ?></td>
              <td class="right">
                <?php foreach ($download['action'] as $action) { ?>
                  <a href="<?php echo $action['href']; ?>" class="button-form"><?php echo $action['text']; ?></a>
                <?php } ?>
              </td>
            </tr>
          <?php } ?>
        <?php } else { ?>
          <tr>
            <td class="center" colspan="3"><?php echo $text_no_results; ?></td>
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