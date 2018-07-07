<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
  <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
  <?php } ?>
  </div>
  <?php if ($success) { ?>
    <div class="success"><?php echo $success; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/report.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons">
        <a href="<?php echo $reset; ?>" class="button-delete ripple"><?php echo $button_reset; ?></a>
        <a onclick="location='<?php echo $close; ?>';" class="button-cancel ripple"><?php echo $button_close; ?></a>
      </div>
    </div>
    <div class="content-body">
    <?php if ($navigation_hi) { ?>
      <div class="pagination" style="margin-bottom:10px;"><?php echo $pagination; ?></div>
    <?php } ?>
      <table class="list">
        <thead>
          <tr>
            <td class="left"><?php echo $column_id; ?></td>
            <td class="left"><?php echo $column_image; ?></td>
            <td class="left"><?php echo $column_title; ?></td>
            <td class="left"><?php echo $column_link; ?></td>
            <td class="center"><?php echo $column_clicked; ?></td>
            <td class="right"><?php echo $column_percent; ?></td>
          </tr>
        </thead>
        <tbody>
        <?php if ($banners) { ?>
          <?php foreach ($banners as $banner) { ?>
            <tr>
              <td class="center"><?php echo $banner['banner_image_id']; ?></td>
              <td class="center"><img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" style="padding:1px; border:1px solid #DDD;" /></td>
              <td class="left"><?php echo $banner['title']; ?></td>
              <td class="left"><?php echo $banner['link']; ?></td>
              <td class="center"><?php echo $banner['clicked']; ?></td>
              <td class="right"><?php echo $banner['percent']; ?></td>
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
<?php echo $footer; ?>