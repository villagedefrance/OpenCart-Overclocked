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
        <a onclick="location = '<?php echo $eucountries; ?>';" class="button ripple"><?php echo $button_eucountry; ?></a>
        <a onclick="location = '<?php echo $cancel; ?>';" class="button-cancel ripple"><?php echo $button_cancel; ?></a>
      </div>
    </div>
    <div class="content">
      <div id="tabs" class="htabs">
        <a href="#tab-configuration"><?php echo $tab_configuration; ?></a>
        <a href="#tab-status"><?php echo $tab_status; ?></a>
      </div>
      <div id="tab-configuration" class="toolbox">
        <table class="tool">
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
              <?php $geo_zone_name[] = $geo_zone['name']; ?>
            <?php } ?>
            <?php echo (in_array('EU VAT Zone', $geo_zone_name)) ? '<img src="view/image/success.png" alt="" />' : '<img src="view/image/attention.png" alt="" />'; ?>
            </td>
            <td class="right"><a onclick="location = '<?php echo $action_geo_zone; ?>';" class="button ripple"><?php echo $button_edit; ?></a></td>
          </tr>
          <tr>
            <td><?php echo $text_status_tax_rate; ?></td>
            <td class="center"><?php foreach ($tax_rates as $tax_rate) { ?>
              <?php $tax_rate_name[] = $tax_rate['name']; ?>
            <?php } ?>
            <?php echo (in_array('EU Members VAT', $tax_rate_name)) ? '<img src="view/image/success.png" alt="" />' : '<img src="view/image/attention.png" alt="" />'; ?>
            </td>
            <td class="right"><a onclick="location = '<?php echo $action_tax_rate; ?>';" class="button ripple"><?php echo $button_edit; ?></a></td>
          </tr>
          <tr>
            <td><?php echo $text_status_tax_class; ?></td>
            <td class="center"><?php foreach ($tax_classes as $tax_class) { ?>
              <?php $tax_class_title[] = $tax_class['title']; ?>
            <?php } ?>
            <?php echo (in_array('EU E-medias', $tax_class_title)) ? '<img src="view/image/success.png" alt="" />' : '<img src="view/image/attention.png" alt="" />'; ?>
            </td>
            <td class="right"><a onclick="location = '<?php echo $action_tax_class; ?>';" class="button ripple"><?php echo $button_edit; ?></a></td>
          </tr>
          <tr>
            <td><?php echo $text_status_tax_rule; ?></td>
            <td class="center"><?php foreach ($tax_classes as $tax_class) { ?>
              <?php $tax_class_tax_rule[] = $tax_class['tax_rules']; ?>
            <?php } ?>
            <?php echo (isset($tax_class_tax_rule)) ? '<img src="view/image/success.png" alt="" />' : '<img src="view/image/attention.png" alt="" />'; ?>
            </td>
            <td class="right"><a onclick="location = '<?php echo $action_tax_rule; ?>';" class="button ripple"><?php echo $button_edit; ?></a></td>
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