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
      <h1><img src="view/image/modification.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons">
        <a onclick="location = '<?php echo $eucountries; ?>';" class="button"><?php echo $button_eucountry; ?></a>
        <a onclick="location = '<?php echo $cancel; ?>';" class="button-cancel"><?php echo $button_cancel; ?></a>
      </div>
    </div>
    <div class="content">
      <div id="tabs" class="htabs">
        <a href="#tab-configuration"><?php echo $tab_configuration; ?></a>
        <a href="#tab-status"><?php echo $tab_status; ?></a>
      </div>
      <div id="tab-configuration">
        <table class="form">
          <?php echo $help_manager; ?><br /><br />
          <?php echo $help_geo_zone; ?><br /><br />
          <?php echo $help_tax_class; ?><br /><br />
          <?php echo $help_tax_rate; ?><br /><br />
          <?php echo $help_tax_rule; ?><br /><br />
          <?php echo $help_troubleshoot; ?><br /><br />
        </table>
      </div>
      <div id="tab-status">
		<table class="list">
        <thead>
          <tr>
            <td class="left"><?php echo $column_setting; ?></td>
            <td class="left"><?php echo $column_status; ?></td>
            <td class="right"><?php echo $column_action; ?></td>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><?php echo $text_status_geo_zone; ?></td>
            <td class="center"><?php foreach ($geo_zones as $geo_zone) { ?>
			  <?php if ($geo_zone['name'] == 'EU VAT Zone') { ?>
                <img src="view/image/success.png" alt="" />
              <?php } ?>
            <?php } ?></td>
            <td class="right"><a onclick="location = '<?php echo $action_geo_zone; ?>';" class="button"><?php echo $button_edit; ?></a></td>
          </tr>
          <tr>
            <td><?php echo $text_status_tax_rate; ?></td>
            <td class="center"><?php foreach ($tax_rates as $tax_rate) { ?>
			  <?php if ($tax_rate['name'] == 'EU Members VAT') { ?>
                <img src="view/image/success.png" alt="" />
              <?php } ?>
            <?php } ?></td>
            <td class="right"><a onclick="location = '<?php echo $action_tax_rate; ?>';" class="button"><?php echo $button_edit; ?></a></td>
          </tr>
          <tr>
            <td><?php echo $text_status_tax_class; ?></td>
            <td class="center"><?php foreach ($tax_classes as $tax_class) { ?>
              <?php if ($tax_class['title'] == 'EU E-medias') { ?>
                <img src="view/image/success.png" alt="" />
              <?php } ?>
            <?php } ?></td>
            <td class="right"><a onclick="location = '<?php echo $action_tax_class; ?>';" class="button"><?php echo $button_edit; ?></a></td>
          </tr>
          <tr>
            <td><?php echo $text_status_tax_rule; ?></td>
            <td class="center"><?php foreach ($tax_classes as $tax_class) { ?>
              <?php if ($tax_class['tax_rules']) { ?>
                <img src="view/image/success.png" alt="" />
              <?php } ?>
            <?php } ?></td>
            <td class="right"><a onclick="location = '<?php echo $action_tax_rule; ?>';" class="button"><?php echo $button_edit; ?></a></td>
          </tr>
        </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript"><!--
$('#tabs a').tabs();
//--></script>

<?php echo $footer; ?>