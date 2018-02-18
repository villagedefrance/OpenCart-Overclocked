<?php
// Heading
$_['heading_title']          = 'User Log';
$_['heading_help']           = 'User Log Help';

// Tabs
$_['tab_log']                = 'Log';
$_['tab_settings']           = 'Settings';
$_['tab_help']               = 'Help';

// Columns
$_['column_user']            = 'User';
$_['column_action']          = 'Action';
$_['column_allowed']	     = 'Allowed';
$_['column_url']             = 'URL';
$_['column_ip']              = 'User IP';
$_['column_date']            = 'Date';

// Entry
$_['entry_user_log_enable']  = 'Enable Log';
$_['entry_user_log_login']   = 'Login events';
$_['entry_user_log_logout']  = 'Logout events';
$_['entry_user_log_hacklog'] = 'Failed Login events (brute force)';
$_['entry_user_log_access']  = 'Page Access events';
$_['entry_user_log_modify']  = 'Page Modify events';
$_['entry_user_log_allowed'] = 'Log Permissions';
$_['entry_user_log_display'] = 'Number of entries';

$_['text_denied']            = 'denied actions';
$_['text_allowed']           = 'allowed actions';
$_['text_all']               = 'all actions';

// Text
$_['text_success']           = 'Success: You have successfully cleared the <b>User Log</b>!';
$_['text_success_settings']  = 'Success: You have successfully updated the <b>User Log</b> settings!';
$_['text_description']       = '<p>The Administration User Log allows you to record actions performed by the administrators.<br />
  Setting options are available to select what is being recorded.</p>

  <p>Use the following options to configure your log:</p>
  <ul>
    <li>Enable log - enables and disables event recording (master);</li>
    <li>Login events - records every login attempts to the administration;</li>
    <li>Logout events - records every logout actions from the administration;</li>
    <li>Failed Login events - records every failed login attempts (brute force);</li>
    <li>Page Access events - records every page view/access;</li>
    <li>Page Modify events - records every insert/update/delete actions;</li>
    <li>Log Permissions - select the events to record. Events can be allowed, denied or all;</li>
    <li>Number of entries - specify the number of entries to display in the log.</li>
  </ul>

  <p>All events are based on two parameters: ACTIONS and PERMISSIONS.</p>
  <p>ACTIONS values can be:</p>
  <ul>
    <li>access - access/view;</li>
    <li>modify - change/modify;</li>
    <li>login/logout - input/output;</li>
    <li>clear log/clear entries - clear log/delete records;</li>
  </ul>

  <p>Each action is highlighted in a different colour, based on importance of the event:</p>
  <ul>
    <li>Warning messages will be highlighted in RED. These include: Cleaning log, Authorization process fails, Attempt to access a restricted page.</li>
    <li>A successful content Change/Modify action will be highlighted in YELLOW.</li>
    <li>A successful page Access action will be highlighted in BLUE.</li> 
    <li>A successful Login will be highlighted in GREEN.</li>
    <li>A successful Logout will be highlighted in GRAY.</li>
  </ul>

  <p>PERMISSIONS have two values: YES or NO.</p><br />';

// Help
$_['help_user_log_enable']   = 'Recommended!';
$_['help_user_log_hacklog']  = 'Recommended!';
$_['help_user_log_access']   = 'Enabling this will generate a large amount of data.';

// Buttons
$_['button_settings']        = 'Update Settings';
$_['button_erase']           = 'Clear All';
$_['button_clear']           = 'Clear';

// Error
$_['error_permission']       = 'Warning: You do not have permission to modify <b>User Log</b>!';
