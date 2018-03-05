<?php
// Heading
$_['lang_heading_title']             = 'OpenBay Pro';
$_['lang_text_manager']              = 'OpenBay Pro manager';

$_['tab_update']                     = 'Software updates';
$_['tab_update_v1']                  = 'Legacy updater';
$_['tab_update_v2']                  = 'Easy updater';

// Text
$_['text_install']                   = 'Install';
$_['text_uninstall']                 = 'Uninstall';
$_['lang_text_success']              = 'Success: Settings have been saved';
$_['lang_text_no_results']           = 'No results found';
$_['lang_checking_version']          = 'Checking software version';
$_['lang_btn_manage']                = 'Manage';
$_['lang_btn_retry']                 = 'Retry';
$_['lang_btn_save']                  = 'Save';
$_['lang_btn_cancel']                = 'Cancel';
$_['lang_btn_update']                = 'Update';
$_['lang_btn_settings']              = 'Settings';
$_['lang_btn_patch']                 = 'Patch';
$_['lang_btn_test']                  = 'Test connection';
$_['lang_latest']                    = 'You are running the latest version';
$_['lang_installed_version']         = 'Installed version';
$_['lang_admin_dir']                 = 'Admin directory';
$_['lang_admin_dir_desc']            = 'If you have changed your admin directory update it to the new location';
$_['lang_version_old_1']             = 'A new version is available. Your version is';
$_['lang_version_old_2']             = 'the latest is';
$_['lang_use_beta']                  = 'Use Beta release';
$_['lang_use_beta_2']                = 'NOT suggested!';
$_['lang_test_conn']                 = 'Test FTP connection';
$_['lang_text_run_1']                = 'Run update';
$_['lang_text_run_2']                = 'Run';
$_['lang_no']                        = 'No';
$_['lang_yes']                       = 'Yes';
$_['lang_language']                  = 'API response language';
$_['lang_getting_messages']          = 'Getting OpenBay Pro messages';
$_['text_check_new']                 = 'Checking for newer version';
$_['text_downloading']               = 'Downloading update files';
$_['text_extracting']                = 'Extracting files';
$_['text_running_patch']             = 'Running patch files';
$_['text_fail_patch']                = 'Unable to extract update files';
$_['text_updated_ok']                = 'Update complete, installed version is now ';
$_['text_check_server']              = 'Checking server requirements';
$_['text_version_ok']                = 'Software is already up to date, installed version is ';
$_['text_remove_files']              = 'Removing files no longer required';
$_['text_confirm_backup']            = 'Ensure that you have a full backup before continuing';
$_['text_progress']                  = 'Progress';

// Column
$_['lang_column_name']               = 'Plugin name';
$_['lang_column_status']             = 'Status';
$_['lang_column_action']             = 'Action';

// Error
$_['error_permission']               = 'Warning: You do not have permission to modify eBay extensions!';

// Updates
$_['lang_use_pasv']                  = 'Use passive FTP';
$_['field_ftp_user']                 = 'FTP Username';
$_['field_ftp_pw']                   = 'FTP Password';
$_['field_ftp_server_address']       = 'FTP server address';
$_['field_ftp_root_path']            = 'FTP path on server';
$_['field_ftp_root_path_info']       = '(No trailing slash e.g. httpdocs/www)';
$_['desc_ftp_updates']               = 'Enabling updates from here means you do not have to manually update your module using the standard drag and drop through FTP. Your FTP are not sent to the API.<br />';

$_['lang_run_patch_desc']            = 'Post update patch<span class="help">Only needed if you manually update</span>';
$_['lang_run_patch']                 = 'Run patch';
$_['update_error_username']          = 'Username expected';
$_['update_error_password']          = 'Password expected';
$_['update_error_server']            = 'Server expected';
$_['update_error_admindir']          = 'Admin directory expected';
$_['update_okcon_noadmin']           = 'Connection OK but your OpenCart admin directory was not found';
$_['update_okcon_nofiles']           = 'Connection OK but OpenCart folders were not found! Is your root path correct?';
$_['update_okcon']                   = 'Connected to server OK. OpenCart folders found';
$_['update_failed_user']             = 'Could not login with that user';
$_['update_failed_connect']          = 'Could not connect to server';
$_['update_success']                 = 'Module has been updated (v.%s)';
$_['lang_patch_notes1']              = 'To read about the recent and past updates';
$_['lang_patch_notes2']              = 'click here';
$_['lang_patch_notes3']              = "The update tool will make changes to your shop's file system. Make sure you have a backup before using this tool.";

// Help tab
$_['lang_help_title']                = 'Information on help & support';
$_['lang_help_support_title']        = 'Support';
$_['lang_help_support_description']  = 'You should read our FAQ section to see if your question is already answered <a href="http://shop.openbaypro.com/index.php?route=information/faq" title="OpenBay Pro for OpenCart support FAQ">here</a>. <br />If you cannot find an answer then you can create a support ticket, <a href="http://support.welfordmedia.co.uk" title="OpenBay Pro for OpenCart support site">click here</a>';
$_['lang_help_template_title']       = 'Creating eBay templates';
$_['lang_help_template_description'] = 'Information for developers &amp; designers on creating custom templates for their eBay listings, <a href="http://shop.openbaypro.com/index.php?route=information/faq&topic=30" title="OpenBay Pro HTML templates for eBay">click here</a>';

$_['lang_tab_help']                  = 'Help';
$_['lang_help_guide']                = 'User guides';
$_['lang_help_guide_description']    = 'To download and view the eBay and Amazon user guides <a href="http://shop.openbaypro.com/index.php?route=information/faq&topic=37" title="OpenBay Pro user guides">click here</a>';

$_['lang_error_mbstring']            = 'PHP library "mb strings" is not enabled. Contact your hosting provider.';
$_['lang_error_ftpconnect']          = 'PHP FTP functions are not enabled. Contact your hosting provider.';
$_['lang_error_oc_version']          = 'Your version of OpenCart is not tested to work with this module. You may experience problems.';
$_['lang_error_fopen']               = 'PHP function fopen is disabled by your host - you will be unable to import images when importing products';
$_['lang_error_vqmod']               = 'You have VQMOD files for OpenBay Pro installed, this version does not require them. Have you installed the wrong version?';
$_['lang_patch_applied']             = 'Patch applied';
$_['faqbtn']                         = 'View FAQ';
$_['lang_clearfaq']                  = 'Clear hidden FAQ popups';
$_['lang_clearfaqbtn']               = 'Clear';
$_['help_easy_update']               = 'Click update to install the latest version of OpenBay Pro automatically';
$_['help_patch']                     = 'Click to run the patch scripts';

// Ajax elements
$_['lang_ajax_ebay_shipped']         = 'The order will be marked as shipped on eBay automatically';
$_['lang_ajax_amazoneu_shipped']     = 'The order will be marked as shipped on Amazon EU automatically';
$_['lang_ajax_amazonus_shipped']     = 'The order will be marked as shipped on Amazon US automatically';
$_['lang_ajax_refund_reason']        = 'Refund reason';
$_['lang_ajax_refund_message']       = 'Refund message';
$_['lang_ajax_refund_entermsg']      = 'You must enter a refund message';
$_['lang_ajax_refund_charmsg']       = 'Your refund message must be less than 1000 characters';
$_['lang_ajax_refund_charmsg2']      = 'Your message cannot contain the characters > or <';
$_['lang_ajax_courier']              = 'Courier';
$_['lang_ajax_courier_other']        = 'Other courier';
$_['lang_ajax_tracking']             = 'Tracking #';
$_['lang_ajax_tracking_msg']         = 'You must enter a tracking id, use "none" if you do not have one';
$_['lang_ajax_tracking_msg2']        = 'Your tracking ID cannot contain the characters > or <';
$_['lang_ajax_tracking_msg3']        = 'You must select courier if you want to upload tracking no.';
$_['lang_ajax_tracking_msg4']        = 'Please leave courier field empty if you want to use custom courier.';

$_['lang_title_help']                = 'Need help with OpenBay Pro?';
$_['lang_pod_help']                  = 'Help';
$_['lang_title_manage']              = 'Manage OpenBay Pro; updates, settings and more';
$_['lang_pod_manage']                = 'Manage';
$_['lang_title_shop']                = 'OpenBay Pro store; addons, templates and more';
$_['lang_pod_shop']                  = 'Store';

$_['lang_checking_messages']         = 'Checking for messages';
$_['lang_title_messages']            = 'Messages &amp; notifications';
$_['lang_error_retry']               = 'Could not connect to the OpenBay server.';
