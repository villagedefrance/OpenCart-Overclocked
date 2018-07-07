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
  <?php if (!empty($error)) { ?>
    <?php foreach ($error as $error) { ?>
      <?php echo '<div class="warning">' . $error . '</div>'; ?>
    <?php } ?>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <a onclick="window.open('https://www.openbaypro.com');" title=""><img src="https://uk.openbaypro.com/asset/OpenBayPro_30px_h.png" alt="OpenBay Pro" style="margin:5px 0 0 5px; border:0;" border="0" /></a>
    </div>
    <div class="content-body" style="padding-right:0;">
      <div style="float:left; width:60%;">
        <div style="clear:both;"></div>
        <table class="list">
          <thead>
          <tr>
            <td class="left" width="60%"><?php echo $lang_column_name; ?></td>
            <td class="center" width="20%"><?php echo $lang_column_status; ?></td>
            <td class="right" width="20%"><?php echo $lang_column_action; ?></td>
          </tr>
          </thead>
          <tbody>
          <?php if ($extensions) { ?>
            <?php foreach ($extensions as $extension) { ?>
              <tr>
                <td class="left"><?php echo $extension['name']; ?></td>
                <td class="center"><?php echo $extension['status'] ?></td>
                <td class="right"><?php foreach ($extension['action'] as $action) { ?>
                  <?php if ($action['type'] == 'uninstall') { ?>
                    <a class="button-form-<?php echo $action['type']; ?> ripple" data-title="<?php echo $action['text']; ?>" href="<?php echo $action['href']; ?>"><?php echo $action['text']; ?></a>
                  <?php } else { ?>
                    <a class="button-form-<?php echo $action['type']; ?> ripple" href="<?php echo $action['href']; ?>"><?php echo $action['text']; ?></a>
                  <?php } ?>
                <?php } ?></td>
              </tr>
            <?php } ?>
          <?php } else { ?>
            <tr>
              <td class="center" colspan="8"><?php echo $lang_text_no_results; ?></td>
            </tr>
          <?php } ?>
          </tbody>
        </table>
        <a onclick="location='<?php echo $manage_link; ?>'" title="">
          <div class="openbayPod overviewPod">
            <img src="<?php echo HTTPS_SERVER . 'view/image/openbay/openbay_icon1.png'; ?>" title="<?php echo $lang_title_manage; ?>" alt="Manage icon" border="0" />
            <h3><?php echo $lang_pod_manage; ?></h3>
          </div>
        </a>
        <a onclick="window.open('https://help.openbaypro.com/');" title="">
          <div class="openbayPod overviewPod">
            <img src="<?php echo HTTPS_SERVER . 'view/image/openbay/openbay_icon7.png'; ?>" title="<?php echo $lang_title_help; ?>" alt="Help icon" border="0" />
            <h3><?php echo $lang_pod_help; ?></h3>
          </div>
        </a>
        <a onclick="window.open('http://shop.openbaypro.com/?utm_campaign=OpenBayModule&utm_medium=referral&utm_source=shopbutton');" title="">
          <div class="openbayPod overviewPod">
            <img src="<?php echo HTTPS_SERVER . 'view/image/openbay/openbay_icon11.png'; ?>" title="<?php echo $lang_title_shop; ?>" alt="Shop icon" border="0" />
            <h3><?php echo $lang_pod_shop; ?></h3>
          </div>
        </a>
      </div>
      <div style="float:right; width:40%; text-align:center;">
        <div id="openbay_version" class="attention" style="background-image:none; margin:0 20px 10px 20px; text-align:left;">
          <div id="openbay_version_loading">
            <img src="view/image/loading.gif" alt="Loading" /> <?php echo $lang_checking_version; ?>
          </div>
        </div>
        <div id="openbay_notification" class="attention" style="background-image:none; margin:0 20px; text-align:left;">
          <div id="openbay_loading">
            <img src="view/image/loading.gif" alt="Loading" /> <?php echo $lang_getting_messages; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript"><!--
function getOpenbayVersion() {
	var version = '<?php echo $openbay_version; ?>';

	$('#openbay_version').empty().html('<div id="openbay_version_loading"><img src="view/image/loading.gif" alt="Loading" /> <?php echo $lang_checking_version; ?></div>');

	setTimeout(function() {
		var token = "<?php echo $_GET['token']; ?>";

		$.ajax({
			type: 'GET',
			url: 'index.php?route=extension/openbay/version&token=' + token,
			dataType: 'json',
			success: function(json) {
				$('#openbay_version_loading').hide();

				if (version < json.version) {
					$('#openbay_version').removeClass('attention').addClass('warning').append('<?php echo $lang_version_old_1; ?> v.' + version + ', <?php echo $lang_version_old_2; ?> v.' + json.version);
				} else {
					$('#openbay_version').removeClass('attention').addClass('success').append('<?php echo $lang_latest; ?> (v.' + version + ')');
				}
			},
			failure: function() {
				$('#openbay_version').html('<?php echo $lang_error_retry; ?><strong><span onclick="getOpenbayVersion();"><?php echo $lang_btn_retry; ?></span></strong>');
			},
			error: function(xhr, ajaxOptions, thrownError) {
				if (xhr.status != 0) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			}
		});
	}, 500);
}

function getOpenbayNotifications() {
	$('#openbay_notification').empty().html('<div id="openbay_loading"><img src="view/image/loading.gif" alt="Loading" /> <?php echo $lang_checking_messages; ?></div>');

	var html = '';

	setTimeout(function() {
		$.ajax({
			type: 'GET',
			url: 'index.php?route=extension/openbay/getNotifications&token=<?php echo $this->request->get['token']; ?>',
			dataType: 'json',
			success: function(json) {
				html += '<h3 style="background:url(<?php echo HTTPS_SERVER; ?>/view/image/information.png) no-repeat top left; color:#222;"><?php echo $lang_title_messages; ?></h3>';
				html += '<ul>';

				$.each(json, function(key, val) {
					html += '<li>' + val + '</li>';
				});

				html += '</ul>';

				$('#openbay_notification').html(html);
			},
			error: function (xhr, ajaxOptions, thrownError) {
				if (xhr.status != 0) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			}
		});
	}, 500);
}

$(document).ready(function() {
	getOpenbayVersion();
	getOpenbayNotifications();
});
//--></script>

<script type="text/javascript"><!--
$('a.button-form-uninstall').confirm({
	content: '',
	icon: 'fa fa-question-circle',
	theme: 'light',
	useBootstrap: false,
	boxWidth: 580,
	animation: 'zoom',
	closeAnimation: 'scale',
	opacity: 0.1
});
$('a.button-form-uninstall').on('click', function() {
	$.dialog({
		title: '<?php echo $text_confirm_uninstall; ?>',
		content: '<?php echo $text_confirm; ?>',
		icon: 'fa fa-exclamation-circle',
		theme: 'light',
		useBootstrap: false,
		boxWidth: 580,
		animation: 'zoom',
		closeAnimation: 'scale',
		opacity: 0.1,
		buttons: {
			confirm: function() {
				location.href = this.$target.attr('href');
			},
			cancel: function() { }
		}
	});
});
//--></script>

<?php echo $footer; ?>