<?php
// Heading
$_['heading_title']               = 'PayHub';

// Link
$_['text_payhub']                 = '<a onclick="window.open(\'https://www.payhub.com\');"><img src="view/image/payment/payhub.png" alt="PayHub" title="PayHub" style="border:1px solid #EEEEEE;" /></a>';

// Text
$_['text_payment']                = 'Payment';
$_['text_success']                = 'Success: You have modified <b>PayHub</b> account details!';
$_['text_test']                   = 'Test';
$_['text_live']                   = 'Live';
$_['text_default_cards_accepted'] = 'Visa / Mastercard';

// Entry
$_['entry_org_id']                = 'Organization ID';
$_['entry_username']              = 'API Username';
$_['entry_password']              = 'API Password';
$_['entry_terminal_id']           = 'API Terminal ID';
$_['entry_mode']                  = 'Transaction Mode';
$_['entry_total']                 = 'Total<span class="help">The checkout total the order must reach before this payment method becomes <b>active</b>.</span>';
$_['entry_total_max']             = 'Total Maximum<span class="help">The maximum checkout total the order must reach before this payment method becomes <b>inactive</b>.<br />Leave empty for no maximum.</span>';
$_['entry_order_status']          = 'Order Status';
$_['entry_geo_zone']              = 'Geo Zone';
$_['entry_status']                = 'Status';
$_['entry_sort_order']            = 'Sort Order';
$_['entry_cards_accepted']        = 'Card Types Accepted<span class="help">This will appear at the point where the user chooses the payment method during the checkout process.</span>';
$_['entry_invoice_prefix']        = 'Invoice Prefix<span class="help">This will be automatically prepended to the order ID and sent to PayHub in the "invoice" field.</span>';

// Error
$_['error_permission']            = 'Warning: You do not have permission to modify payment <b>PayHub</b> !';
$_['error_org_id']                = 'Organization ID Required!';
$_['error_username']              = 'username Required!';
$_['error_password']              = 'Password Required!';
$_['error_terminal_id']           = 'Terminal ID Required!';
$_['error_invoice_prefix']        = 'Invoice Prefix can only contain numbers, letters and dash (-) characters!';
