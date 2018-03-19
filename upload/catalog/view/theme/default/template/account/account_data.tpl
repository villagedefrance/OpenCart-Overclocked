<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="<?php echo $direction; ?>" lang="<?php echo $language; ?>" xml:lang="<?php echo $language; ?>">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>" />
<link rel="icon" type="image/png" href="admin/docicon.png" />
<link rel="stylesheet" type="text/css" href="catalog/view/theme/<?php echo $template; ?>/stylesheet/account-data.css" media="screen, print" />
</head>
<body>
<?php foreach ($customers as $customer) { ?>
<div class="documents">
  <?php if ($logo) { ?>
    <img src="<?php echo $logo; ?>" alt="" style="padding:15px 0 0 5px;" />
  <?php } ?>
  <h1><?php echo $text_customer_data; ?></h1>
  <table class="store">
    <tr>
      <td class="top-left">
        <b><?php echo $customer['store_name']; ?></b><br />
        <?php echo $customer['store_address']; ?><br /><br />
        <img src="catalog/view/theme/<?php echo $template; ?>/image/location/phone.png" alt="" height="14" width="14" /> <?php echo $customer['store_telephone']; ?><br />
        <?php if ($customer['store_fax']) { ?>
          <img src="catalog/view/theme/<?php echo $template; ?>/image/location/fax.png" alt="" height="14" width="14" /> <?php echo $customer['store_fax']; ?><br />
        <?php } ?>
        <img src="catalog/view/theme/<?php echo $template; ?>/image/location/mail.png" alt="" height="14" width="14" /> <?php echo $customer['store_email']; ?><br />
		<img src="catalog/view/theme/<?php echo $template; ?>/image/location/global.png" alt="" height="14" width="14" /> <?php echo $customer['store_url']; ?><br />
        <?php if ($customer['store_company_id']) { ?>
          <img src="catalog/view/theme/<?php echo $template; ?>/image/location/company.png" alt="" height="14" width="14" /> <?php echo $customer['store_company_id']; ?><br />
        <?php } ?>
        <?php if ($customer['store_company_tax_id']) { ?>
          <img src="catalog/view/theme/<?php echo $template; ?>/image/location/tax.png" alt="" height="14" width="14" /> <?php echo $customer['store_company_tax_id']; ?><br />
        <?php } ?>
      </td>
      <td class="top-right">
        <table>
          <tr>
            <td><?php echo $text_customer_id; ?></td>
            <td><?php echo $customer['customer_id']; ?></td>
          </tr>
          <tr>
            <td><?php echo $text_date_added; ?></td>
            <td><?php echo $customer['date_added']; ?></td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
  <table class="personal">
    <tbody>
      <tr>
        <td><?php echo $text_firstname; ?></td>
        <td><?php echo $customer['firstname']; ?></td>
      </tr>
      <tr>
        <td><?php echo $text_lastname; ?></td>
        <td><?php echo $customer['lastname']; ?></td>
      </tr>
      <tr>
        <td><?php echo $text_email; ?></td>
        <td><?php echo $customer['email']; ?></td>
      </tr>
      <tr>
        <td><?php echo $text_telephone; ?></td>
        <td><?php echo $customer['telephone']; ?></td>
      </tr>
    <?php if ($customer['fax']) { ?>
      <tr>
        <td><?php echo $text_fax; ?></td>
        <td><?php echo $customer['fax']; ?></td>
      </tr>
    <?php } ?>
    <?php if ($customer['gender']) { ?>
      <tr>
        <td><?php echo $text_gender; ?></td>
        <td><?php echo $customer['gender']; ?></td>
      </tr>
    <?php } ?>
    <?php if ($customer['date_of_birth']) { ?>
      <tr>
        <td><?php echo $text_date_of_birth; ?></td>
        <td><?php echo $customer['date_of_birth']; ?></td>
      </tr>
    <?php } ?>
      <tr>
        <td><?php echo $text_ip; ?></td>
        <td><?php echo $customer['ip']; ?></td>
      </tr>
      <tr>
        <td><?php echo $text_user_agent; ?></td>
        <td><?php echo $customer['user_agent']; ?></td>
      </tr>
    </tbody>
  </table>
<?php foreach ($addresses as $address) { ?>
  <table class="address">
    <tr>
      <td><?php echo $address['address']; ?></td>
    </tr>
  </table>
<?php } ?>
  <table class="bank">
    <tr>
      <td class="center"><span><?php echo $customer['store_name']; ?> <?php echo $text_copyrights; ?></span></td>
    </tr>
  <table>
</div>
<?php } ?>
</body>
</html>