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
      <h1><img src="view/image/log.png" alt="" /> <?php echo $heading_title; ?> <?php echo $heading_total; ?></h1>
      <div class="buttons">
        <a id="clear-selected" class="button ripple"><i class="fa fa-check-square-o"></i> &nbsp; <?php echo $button_clear; ?></a>
        <a onclick="location = '<?php echo $erase; ?>';" class="button-repair ripple"><i class="fa fa-trash"></i> &nbsp; <?php echo $button_erase; ?></a>
        <a onclick="location = '<?php echo $close; ?>';" class="button-cancel ripple"><?php echo $button_close; ?></a>
      </div>
    </div>
    <div class="content">
      <div id="tabs" class="htabs">
        <a href="#tab-log"><?php echo $tab_log; ?></a>
        <a href="#tab-settings"><?php echo $tab_settings; ?></a>
        <a href="#tab-help"><?php echo $tab_help; ?></a>
      </div>
      <div id="tab-log">
      <?php if ($navigation_hi) { ?>
        <div class="pagination" style="margin-bottom:10px;"><?php echo $pagination; ?></div>
      <?php } ?>
        <form action="<?php echo $clear; ?>" method="post" enctype="multipart/form-data" id="form" name="log">
          <table class="list">
            <thead>
              <tr>
                <td width="1" style="text-align:center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" id="check-all" class="checkbox" />
                <label for="check-all"><span></span></label></td>
                <td class="left"><?php echo $column_user; ?></td>
                <td class="left"><?php echo $column_action; ?></td>
                <td class="left"><?php echo $column_allowed; ?></td>
                <td class="left"><?php echo $column_url; ?></td>
                <td class="left"><?php echo $column_ip; ?></td>
                <td class="left"><?php echo $column_date; ?></td>
            </tr>
          </thead>
          <tbody class="log">
          <?php if ($entries) { ?>
            <?php foreach ($entries as $entry) { ?>
              <tr class="<?php echo (!$entry['allowed'] || ($entry['allowed'] == 0)) ? 'denied' : $entry['action']; ?>">
                <td style="text-align:center;"><?php if ($entry['selected']) { ?>
                  <input type="checkbox" name="selected[]" value="<?php echo $entry['log_id']; ?>" id="<?php echo $entry['log_id']; ?>" class="checkbox" checked />
                  <label for="<?php echo $entry['log_id']; ?>"><span></span></label>
                <?php } else { ?>
                  <input type="checkbox" name="selected[]" value="<?php echo $entry['log_id']; ?>" id="<?php echo $entry['log_id']; ?>" class="checkbox" />
                  <label for="<?php echo $entry['log_id']; ?>"><span></span></label>
                <?php } ?></td>
                <td class="left"><a href="<?php echo $entry['user']; ?>" target="_blank"><?php echo $entry['username']; ?></a></td>
                <td class="left"><?php echo $entry['action']; ?></td>
                <td class="left"><?php echo $entry['allowed']; ?></td>
                <td class="left"><a href="<?php echo $entry['url_link']; ?>" target="_blank"><?php echo $entry['url']; ?></a></td>
                <td class="left"><?php echo $entry['ip']; ?></td>
                <td class="left"><?php echo $entry['date']; ?></td>
              </tr>
            <?php } ?>
          <?php } else { ?>
            <tr>
              <td class="center" colspan="7"><?php echo $text_no_results; ?></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
        </form>
      <?php if ($navigation_lo) { ?>
        <div class="pagination"><?php echo $pagination; ?></div>
      <?php } ?>
      </div>
      <div id="tab-settings">
        <form action="<?php echo $settings; ?>" method="post" enctype="multipart/form-data" id="settings">
        <table class="form">
          <tbody>
            <tr>
              <td><?php echo $entry_user_log_enable; ?><span class="help"><?php echo $help_user_log_enable; ?></span></td>
              <td><select name="user_log_enable">
                <?php if ($user_log_enable) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select></td>
            </tr>
            <tr>
              <td><?php echo $entry_user_log_login; ?></td>
              <td><select name="user_log_login">
                <?php if ($user_log_login) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select></td>
            </tr>
            <tr>
              <td><?php echo $entry_user_log_logout; ?></td>
              <td><select name="user_log_logout">
                <?php if ($user_log_logout) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select></td>
            </tr>
            <tr>
              <td><?php echo $entry_user_log_hacklog; ?><span class="help"><?php echo $help_user_log_hacklog; ?></span></td>
              <td><select name="user_log_hacklog">
                <?php if ($user_log_hacklog) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select></td>
            </tr>
            <tr>
              <td><?php echo $entry_user_log_access; ?><span class="help"><?php echo $help_user_log_access; ?></span></td>
              <td><select name="user_log_access">
                <?php if ($user_log_access) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select></td>
            </tr>
            <tr>
              <td><?php echo $entry_user_log_modify; ?></td>
              <td><select name="user_log_modify">
                <?php if ($user_log_modify) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select></td>
            </tr>
            <tr>
              <td><?php echo $entry_user_log_allowed; ?></td>
              <td><select name="user_log_allowed">
                <?php if ($user_log_allowed == 1) { ?>
                  <option value="0"><?php echo $text_denied; ?></option>
                  <option value="1" selected="selected"><?php echo $text_allowed; ?></option>
                  <option value="2"><?php echo $text_all; ?></option>
                <?php } elseif ($user_log_allowed == 2) { ?>
                  <option value="0"><?php echo $text_denied; ?></option>
                  <option value="1"><?php echo $text_allowed; ?></option>
                  <option value="2" selected="selected"><?php echo $text_all; ?></option>
                <?php } else { ?>
                  <option value="0" selected="selected"><?php echo $text_denied; ?></option>
                  <option value="1"><?php echo $text_allowed; ?></option>
                  <option value="2"><?php echo $text_all; ?></option>
                <?php } ?>
              </select></td>
            </tr>
            <tr>
              <td><?php echo $entry_user_log_display; ?></td>
              <td><input type="text" name="user_log_display" value="<?php echo $user_log_display; ?>" /></td>
            </tr>
            <tr>
              <td class="buttons"><a onclick="updateSettings();" class="button-filter animated fadeIn ripple"><i class="fa fa-gears"></i> &nbsp;&nbsp; <?php echo $button_settings; ?></a></td>
              <td></td>
            </tr>
          </table>
        </form>
      </div>
      <div id="tab-help">
        <h3><?php echo $heading_help; ?></h3>
        <table class="form">
          <tr>
            <td><?php echo $text_description; ?></td>
          </tr>
        </table>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript"><!--
$('.htabs a').tabs();
//--></script>

<script type="text/javascript"><!--
var form = document.getElementById('form');

document.getElementById('clear-selected').addEventListener('click', function() {
	form.submit();
});
//--></script>

<script type="text/javascript"><!--
function updateSettings() {
	$('#settings').submit();
}
//--></script>
<?php echo $footer; ?>