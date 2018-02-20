<?php
// Heading
$_['heading_title']    = 'Block IPs';
$_['heading_range']    = 'IP Range';

// Text
$_['text_success']     = 'Success: You have modified <b>Block IPs</b> !';
$_['text_default']     = 'Default';
$_['text_info']        = '<b>List of banned IP addresses.</b><br /><br />Blocked IPs will be re-directed to an external page, and will not be able to navigate back in the store.';
$_['text_range']       = 'To block a specific IP, enter it\'s value in both fields.<br /><br />To block a range of IPs, enter the lower value in "From" and the higher value in "To". All the IP addresses inside a range will be blocked.';

// Column
$_['column_from_ip']   = 'From IP';
$_['column_to_ip']     = 'To IP';
$_['column_action']    = 'Action';

// Entry
$_['entry_from_ip']    = 'From IP:<span class="help">Example: 91.200.12.0</span>';
$_['entry_to_ip']      = 'To IP:<span class="help">Example: 91.200.12.255</span>';

// Button
$_['button_info']      = 'Information';

// Error
$_['error_permission'] = 'Warning: You do not have permission to modify <b>Block IPs</b> !';
$_['error_from_ip']    = 'IP is required and must be a valid IPv4 address!';
$_['error_to_ip']      = 'IP is required and must be a valid IPv4 address!';
$_['error_range']      = 'IP "To" cannot be lower than IP "From" !';
