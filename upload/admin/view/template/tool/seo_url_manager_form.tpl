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
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/server.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons">
        <a onclick="$('#form').submit();" class="button-save ripple"><?php echo $button_save; ?></a>
        <a onclick="apply();" class="button-save ripple"><?php echo $button_apply; ?></a>
        <a href="<?php echo $cancel; ?>" class="button-cancel ripple"><?php echo $button_cancel; ?></a>
      </div>
    </div>
    <div class="content">
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
      <table class="form">
        <tr>
          <td><span class="required">*</span> <?php echo $entry_query; ?></td>
          <td><?php if ($error_query) { ?>
            <input type="text" name="query" value="<?php echo $query; ?>" size="40" class="input-error" />
            <span class="error"><?php echo $error_query; ?></span>
          <?php } else { ?>
            <input type="text" name="query" value="<?php echo $query; ?>" size="40" />
          <?php } ?></td>
        </tr>
        <tr>
          <td><span class="required">*</span> <?php echo $entry_keyword; ?></td>
          <td><?php if ($error_keyword) { ?>
            <input type="text" name="keyword" value="<?php echo $keyword; ?>" size="30" class="input-error" />
            <span class="error"><?php echo $error_keyword; ?></span>
          <?php } else { ?>
            <input type="text" name="keyword" value="<?php echo $keyword; ?>" size="30" />
          <?php } ?></td>
        </tr>
      </table>
    </form>
    </div>
  </div>
</div>
<?php echo $footer; ?>