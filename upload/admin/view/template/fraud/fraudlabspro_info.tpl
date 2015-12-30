<table class="form">
  <tr>
    <td style="text-align:center; background-color:#AB1B1C; border:1px solid #AB1B1C;" colspan="2">
      <a onclick="window.open('http://www.fraudlabspro.com');"><img src="view/image/fraud/fraudlabspro.png" alt="FraudLabs Pro" /></a>
    </td>
  </tr>
  <tr>
    <td><?php echo $text_transaction_id; ?></td>
    <td><a onclick="window.open('https://www.fraudlabspro.com/merchant/transaction/<?php echo $flp_id; ?>?filter=');"><?php echo $flp_id; ?></a></td>
  </tr>
  <tr>
    <td><?php echo $text_score; ?></td>
    <td><span style="font-size:2em; font-weight:bold;"><?php echo $flp_score; ?></span></td>
  </tr>
  <tr>
    <td><?php echo $text_status; ?></td>
    <td id="flp_status">
      <?php if (strtolower($flp_status) == 'approve') { ?>
        <span style="font-size:2em; font-weight:bold; color:#5DC15E;"><?php echo $flp_status; ?></span>
      <?php } elseif (strtolower($flp_status) == 'review') { ?>
        <span style="font-size:2em; font-weight:bold; color:#F2B155;"><?php echo $flp_status; ?></span>
      <?php } else { ?>
        <span style="font-size:2em; font-weight:bold; color:#DE5954;"><?php echo $flp_status; ?></span>
      <?php } ?>
    </td>
  </tr>
  <tr>
    <td><?php echo $text_ip_address; ?></td>
    <td><?php echo $flp_ip_address; ?></td>
  </tr>
  <tr>
    <td><?php echo $text_ip_net_speed; ?></td>
    <td><?php echo $flp_ip_net_speed; ?></td>
  </tr>
  <tr>
    <td><?php echo $text_ip_isp_name; ?></td>
    <td><?php echo $flp_ip_isp_name; ?></td>
  </tr>
  <tr>
    <td><?php echo $text_ip_usage_type; ?></td>
    <td><?php echo $flp_ip_usage_type; ?></td>
  </tr>
  <tr>
    <td><?php echo $text_ip_domain; ?></td>
    <td><?php echo $flp_ip_domain; ?></td>
  </tr>
  <tr>
    <td><?php echo $text_ip_time_zone; ?></td>
    <td><?php echo $flp_ip_time_zone; ?></td>
  </tr>
  <tr>
    <td><?php echo $text_ip_location; ?></td>
    <td><?php echo $flp_ip_location; ?></td>
  </tr>
  <tr>
    <td><?php echo $text_ip_distance; ?></td>
    <td><?php echo $flp_ip_distance; ?></td>
  </tr>
  <tr>
    <td><?php echo $text_ip_latitude; ?></td>
    <td><?php echo $flp_ip_latitude; ?></td>
  </tr>
  <tr>
    <td><?php echo $text_ip_longitude; ?></td>
    <td><?php echo $flp_ip_longitude; ?></td>
  </tr>
  <tr>
    <td><?php echo $text_risk_country; ?></td>
    <td><?php echo $flp_risk_country; ?></td>
  </tr>
  <tr>
    <td><?php echo $text_free_email; ?></td>
    <td><?php echo $flp_free_email; ?></td>
  </tr>
  <tr>
    <td><?php echo $text_ship_forward; ?></td>
    <td><?php echo $flp_ship_forward; ?></td>
  </tr>
  <tr>
    <td><?php echo $text_using_proxy; ?></td>
    <td><?php echo $flp_using_proxy; ?></td>
  </tr>
  <tr>
    <td><?php echo $text_bin_found; ?></td>
    <td><?php echo $flp_bin_found; ?></td>
  </tr>
  <tr>
    <td><?php echo $text_email_blacklist; ?></td>
    <td><?php echo $flp_email_blacklist; ?></td>
  </tr>
  <tr>
    <td><?php echo $text_credit_card_blacklist; ?></td>
    <td><?php echo $flp_credit_card_blacklist; ?></td>
  </tr>
  <tr>
    <td><?php echo $text_credits; ?></td>
    <td><span style="font-size:1.5em; font-weight:bold;"><?php echo $flp_credits; ?></span> &nbsp;&nbsp; <?php echo $text_flp_upgrade; ?></td>
  </tr>
  <tr>
    <td><?php echo $text_message; ?></td>
    <td><?php echo $flp_message; ?></td>
  </tr>
<?php if (strtolower($flp_status) == 'review') { ?>
  <tr style="background:#FCFCFC;">
    <td></td>
    <td id="flp_action">
      <form id="review-action" method="post">
        <a id="button-flp-approve" class="button"><?php echo $button_approve; ?></a>
        <a id="button-flp-reject" class="button"><?php echo $button_reject; ?></a>
        <input type="hidden" id="flp_id" name="flp_id" value="<?php echo $flp_id; ?>" />
        <input type="hidden" id="new_flp_status" name="new_flp_status" value="" />
      </form>
    </td>
  </tr>
<?php } ?>
</table>
<div><?php echo $text_flp_merchant_area; ?></div>

<?php if (strtolower($flp_status) == 'review') { ?>
<script type="text/javascript"><!--
$(document).ready(function() {
	$("#button-flp-approve").click(function() {
		$("#new_flp_status").val("APPROVE");
		$("#review-action").submit();
	});

	$("#button-flp-reject").click(function() {
		$("#new_flp_status").val("REJECT");
		$("#review-action").submit();
	});
});
//--></script>
<?php } ?>