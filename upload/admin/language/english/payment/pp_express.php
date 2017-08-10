<?php
// Heading
$_['heading_title']                    = 'PayPal Express';

// Link
$_['text_pp_express']                  = '<a onclick="window.open(\'https://www.paypal.com/\');"><img src="view/image/payment/paypal.png" alt="PayPal" title="PayPal" style="border:1px solid #EEEEEE;" /></a>';

// Text
$_['text_payment']                     = 'Payment';
$_['text_success']                     = 'Success: You have modified payment <b>PayPal Express</b> account details !';
$_['text_authorization']               = 'Authorization';
$_['text_sale']                        = 'Sale';
$_['text_signup']                      = 'Sign up for PayPal - save your settings first as this page will be refreshed.';
$_['text_sandbox']                     = 'Sign up for PayPal Sandbox - save your settings first as this page will be refreshed.';
$_['text_debug_clear_success']         = 'Success: You have successfully cleared your <b>Debug Log</b> !';
$_['text_info']                        = '<b>PayPal Express security protocol now uses TLS1.2.</b><br /><br />In order to use PayPal Express, your server should meet the following requirements:<br /> - PHP version: 5.5.19+<br /> - Curl version: 7.29+<br /> - SSL Certificate is recommended';
$_['text_clear']                       = 'Clear';
$_['text_browse']                      = 'Browse';
$_['text_image_manager']               = 'Image manager';

// Tab
$_['tab_api']                          = 'API Details';
$_['tab_order_status']                 = 'Order Status';
$_['tab_checkout_customisation']       = 'Checkout Customization';
$_['tab_debug_log']                    = 'Debug Log';

// Entry
$_['entry_username']                   = 'API Username';
$_['entry_password']                   = 'API Password';
$_['entry_signature']                  = 'API Signature';
$_['entry_sandbox_username']           = 'API Sandbox Username';
$_['entry_sandbox_password']           = 'API Sandbox Password';
$_['entry_sandbox_signature']          = 'API Sandbox Signature';
$_['entry_ipn_url']                    = 'IPN URL';
$_['entry_test']                       = 'Test (Sandbox) Mode';
$_['entry_debug']                      = 'Debug logging';
$_['entry_currency']                   = 'Default currency';
$_['entry_recurring_cancel']           = 'Recurring cancellation';
$_['entry_transaction_method']         = 'Transaction method';
$_['entry_total']                      = 'Total';
$_['entry_total_max']                  = 'Total Maximum';
$_['entry_geo_zone']                   = 'Geo Zone';
$_['entry_status']                     = 'Status';
$_['entry_sort_order']                 = 'Sort Order';

$_['entry_canceled_reversal_status']   = 'Canceled Reversal Status';
$_['entry_completed_status']           = 'Completed Status';
$_['entry_denied_status']              = 'Denied Status';
$_['entry_expired_status']             = 'Expired Status';
$_['entry_failed_status']              = 'Failed Status';
$_['entry_pending_status']             = 'Pending Status';
$_['entry_processed_status']           = 'Processed Status';
$_['entry_refunded_status']            = 'Refunded Status';
$_['entry_reversed_status']            = 'Reversed Status';
$_['entry_voided_status']              = 'Voided Status';

// Customise area
$_['entry_allow_note']                 = 'Allow note';
$_['entry_border_colour']              = 'Header border colour';
$_['entry_header_colour']              = 'Header background colour';
$_['entry_page_colour']                = 'Page background colour';
$_['entry_logo']                       = 'Logo';

// Help
$_['help_ipn_url']                     = 'Required for all subscriptions.';
$_['help_test']                        = 'Use the live or testing (sandbox) gateway server to process transactions?';
$_['help_debug']                       = 'Logs additional information to the system log.';
$_['help_currency']                    = 'Used for transaction searches.';
$_['help_recurring_cancel']            = 'Allow customers to cancel recurring payments.';
$_['help_transaction_method']          = 'Sale will charge customer immediately. Authorization will put funds on hold for future capture.';
$_['help_total']                       = 'The checkout total the order must reach before this payment method becomes <b>active</b>.';
$_['help_total_max']                   = 'The maximum checkout total the order must reach before this payment method becomes <b>inactive</b>.<br />Leave empty for no maximum.';
$_['help_allow_note']                  = 'If the buyer may enter some text in the flow to be returned by the responses.';
$_['help_border_colour']               = '6 characters HTML hexadecimal color code.';
$_['help_header_colour']               = '6 characters HTML hexadecimal color code.';
$_['help_page_colour']                 = '6 characters HTML hexadecimal color code.';
$_['help_logo']                        = 'Maximum size: 750 x 90 px (W x H)<br />You should only use a logo if you have SSL set up.';

// Button
$_['button_search']                    = 'Search';
$_['button_info']                      = 'Information';

// Error
$_['error_permission']                 = 'Warning: You do not have permission to modify payment <b>PayPal Express</b> !';
$_['error_username']                   = 'API Username Required!';
$_['error_password']                   = 'API Password Required!';
$_['error_signature']                  = 'API Signature Required!';
$_['error_sandbox_username']           = 'API Sandbox Username Required!';
$_['error_sandbox_password']           = 'API Sandbox Password Required!';
$_['error_sandbox_signature']          = 'API Sandbox Signature Required!';
$_['error_connection']                 = 'Could not connect to PayPal!';
$_['error_api']                        = 'Paypal Authorization Error';
$_['error_api_sandbox']                = 'Paypal Sandbox Authorization Error';
$_['error_timeout']                    = 'Request timed out!';
$_['error_missing_transaction']        = 'Could not find the transaction!';
$_['error_missing_parent_transaction'] = 'Could not find the parent transaction!';
$_['error_missing_data']               = 'Missing data!';
$_['error_missing_order']              = 'Could not find the order!';
$_['error_missing_profile']            = 'Could not find the payment profile!';
$_['error_general']                    = 'There was an error!';
$_['error_search_truncated']           = 'Search truncated: more than 100 results! Try to narrow your search criteria.';
$_['error_date_start']                 = 'Enter a start date!';
$_['error_not_cancelled']              = 'Not canceled! Error: %s';
$_['success_cancelled']                = 'Recurring payment has been cancelled!';
