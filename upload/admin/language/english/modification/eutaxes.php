<?php
// Heading
$_['heading_title']         = 'EU Taxes';

// Text
$_['text_modification']     = 'Modification';
$_['text_success']          = 'Success: You have successfully modified <b>EU Taxes</b> !';
$_['text_status_geo_zone']  = 'Status EU Geo_zone';
$_['text_status_tax_rate']  = 'Status EU tax_rate';
$_['text_status_tax_class'] = 'Status EU tax_class';
$_['text_status_tax_rule']  = 'Status EU tax_rule';
$_['text_default']          = 'Default';
$_['text_yes']              = 'Yes';
$_['text_no']               = 'No';

// Column
$_['column_flag']           = 'Flag';
$_['column_eucountry']      = 'EU Country';
$_['column_code']           = 'Code';
$_['column_rate']           = 'VAT Rate';
$_['column_setting']        = 'Setting';
$_['column_status']         = 'Status';
$_['column_action']         = 'Action';

// Tab
$_['tab_general']           = 'General';
$_['tab_setting']           = 'Settings';
$_['tab_configuration']     = 'Configuration';
$_['tab_status']            = 'Statuses';

// Entry
$_['entry_eucountry']       = 'EU Country Name:';
$_['entry_description']     = 'EU Country Description:';
$_['entry_store']           = 'EU Country Stores:';
$_['entry_code']            = 'EU Country Code:<span class="help">Please enter a valid 2 digits country code.<br />e.g: Germany = DE.</span>';
$_['entry_rate']            = 'EU Country VAT Rate:<span class="help">Enter the Basic VAT Rate for this country, with 4 decimals.</span>';
$_['entry_status']          = 'Status:';

// Help
$_['help_manager']          = 'All current EU countries are already setup with the correct VAT Base Rates. Feel free to edit them if required. You can also add new countries if needed.<br />However, it is not recommended to remove the default countries, you can simply disable them if they are not required.';
$_['help_geo_zone']         = 'A <b>Geo Zone</b>, called "EU VAT Zone" should be present in your list of geo-zones. It contains all current EU countries. If you add new countries to the Manager, you should also add them under "EU VAT Zone". It is required and must not be removed.';
$_['help_tax_class']        = 'A <b>Tax Class</b> "EU E-medias" should be present in your list of Tax Classes. This Tax Class must be given to all electronic products (e-products) that are present in your store. "EU E-medias" must Not be removed. See Tax Rule below.';
$_['help_tax_rate']         = 'A <b>Tax Rate</b> "EU Members VAT" should be present in your list of Tax rates. The rate itself is set by default at "20%" but can be changed to any since it will be bypassed anyway, according to the shipping country. Type should be set to "Percentage" because VAT rates are percentages. Customer Group should be "Customer" as opposed to "Company" since company are exempt of VAT. Geo Zone should be "EU VAT Zone".';
$_['help_tax_rule']         = 'A <b>Tax Rule</b> should be present in your list of Tax rules. It should belong to the "EU E-medias" Class and should use the "EU Members VAT" Rate. Please make sure it is based on "Shipping" as only "Shipping" will give the correct result at checkout. Priority is "1" per default but can be changed.';
$_['help_troubleshoot']     = 'EU Taxes is designed to install/uninstall all its files. If, for any reason, it stops working properly, simply uninstall and re-install. All required tables should be restored.';

// Button
$_['button_eucountry']      = 'Add/Edit EU Countries';
$_['button_save']           = 'Save';
$_['button_apply']          = 'Apply';

// Error
$_['error_permission']      = 'Warning: You do not have permission to modify module <b>EU VAT Manager</b> !';
$_['error_eucountry']       = 'EU Country Name must be greater than 3 and less than 128 characters!';
$_['error_description']     = 'Description must be greater than 3 characters!';
