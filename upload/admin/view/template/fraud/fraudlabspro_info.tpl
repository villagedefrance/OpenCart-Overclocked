<table class="list">
  <tr>
    <td style="text-align:center; background-color:#ab1b1c; border:1px solid #ab1b1c;" colspan="2"><img src="https://www.fraudlabspro.com/images/logo_200.png" alt="FraudLabs Pro" /></td>
  </tr>
  <tr>
    <td><?php echo $text_transaction_id; ?></td>
    <td><a href="https://www.fraudlabspro.com/merchant/transaction-details/<?php echo $flp_id; ?>/" target="_blank"><?php echo $flp_id; ?></a></td>
  </tr>
  <tr>
    <td><?php echo $text_score; ?></td>
    <td><strong><?php echo $flp_score; ?></strong></td>
  </tr>
  <tr>
    <td><?php echo $text_status; ?></td>
    <td id="flp_status">
      <?php if (strtolower($flp_status) == 'approve') { ?>
        <span style="font-weight:bold; color:#5CB85C;"><?php echo $flp_status; ?></span>
      <?php } elseif (strtolower($flp_status) == 'review') { ?>
        <span style="font-weight:bold; color:#F0AD4E;"><?php echo $flp_status; ?></span>
	  <?php } else { ?>
        <span style="font-weight:bold; color:#D9534F;"><?php echo $flp_status; ?></span>
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
    <td><?php echo $flp_credits . ' ' . $text_flp_upgrade; ?></td>
  </tr>
  <tr>
    <td><?php echo $text_message; ?></td>
    <td><?php echo $flp_message; ?></td>
  </tr>
<?php if (strtolower($flp_status) == 'review') { ?>
  <tr style="background-color:#FCFCFC;">
    <td id="flp_action">
      <form id="review-action" method="post">
	    <div align="center">
	      <button type="button" id="button-flp-approve" class="button"><?php echo $button_approve; ?></button>
	      <button type="button" id="button-flp-reject" class="button"><?php echo $button_reject; ?></button>
	    </div>
	    <input type="hidden" id="flp_id" name="flp_id" value="<?php echo $flp_id; ?>" />
	    <input type="hidden" id="new_status" name="new_status" value="" />
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
      $("#new_status").val("APPROVE");
      $("#review-action").submit();
    });
  });

  $(document).ready(function() {
    $("#button-flp-reject").click(function() {
      $("#new_status").val("REJECT");
      $("#review-action").submit();
    });
  });
//--></script>
<?php } ?>