<?php
// Heading
$_['heading_title']				= 'VQmods';

// H2 Headers
$_['header_add']					= 'Upload File';
$_['header_cache']				= 'Cache';
$_['header_backup']				= 'Backup';
$_['header_settings']			= 'Settings';
$_['header_error']				= 'Error Log';
$_['header_credits']				= 'Credits';
$_['header_vqmod']				= 'VQMod&#8482;';

// Columns
$_['column_action']				= 'Enable/Disable';
$_['column_author']				= 'Author';
$_['column_delete']				= 'Delete';
$_['column_file_name']			= 'Script File Name';
$_['column_status']				= 'Status';
$_['column_version']				= 'Script Version';
$_['column_vqmver']				= 'VQMod Version';

// Entry
$_['entry_backup']				= 'Backup VQMod Scripts:';
$_['entry_vqcache']				= 'VQMod Cache:';
$_['entry_vqmod_path']		= 'VQMod Path:';

// Button
$_['button_refresh']				= 'Refresh';
$_['button_close']				= 'Close';
$_['button_backup']				= 'Backup';
$_['button_cancel']				= 'Cancel';
$_['button_clear']				= 'Clear';
$_['button_download_log']		= 'Download Log';
$_['button_vqcache_dump']	= 'VQCache Dump';

// Text Highlighting
$_['highlight']						= '<span class="highlight">%s</span>';

// Use Errors
$_['error_delete']					= 'Warning: Unable to delete VQMod script!';
$_['error_filetype']				= 'Warning: Invalid filetype!  Please only upload .xml files.';
$_['error_install']					= 'Warning: Unable to install VQMod script!';
$_['error_invalid_xml']			= 'Warning: VQMod script XML syntax is invalid!  Please contact the author for support.';
$_['error_log_size']				= 'Warning: Your VQMod error log is %sMBs.  The limit for VQmods is 6MB.  You can download the error log by FTP or by clicking the "Download Log" button in the Error Log tab.  Otherwise consider clearing it.';
$_['error_log_download']		= 'Warning: No error logs available for download!';
$_['error_modded_file']			= 'Warning: VQMod script attempts to mod file "%s" which does not appear to exist!';
$_['error_move']					= 'Warning: Unable to save file on server.  Please check directory permissions.';
$_['error_permission']			= 'Warning: You do not have permission to modify <b>VQmods</b> !';
$_['error_uninstall']				= 'Warning: Unable to uninstall VQMod script!';
$_['error_vqmod_opencart']	= 'Warning: "vqmod_opencart.xml" is required for VQMod to function properly!';

// Upload Errors
$_['error_form_max_file_size']	= 'Warning: VQmod script exceeds max allowable size!';
$_['error_ini_max_file_size']	= 'Warning: VQmod script exceeds max php.ini file size!';
$_['error_no_temp_dir']			= 'Warning: No temporary directory found!';
$_['error_no_upload']			= 'Warning: No file selected for upload!';
$_['error_partial_upload']		= 'Warning: Upload incomplete!';
$_['error_php_conflict']			= 'Warning: Unknown PHP conflict!';
$_['error_unknown']				= 'Warning: Unknown error!';
$_['error_write_fail']				= 'Warning: Failed to write VQmod script!';

// Installation Errors
$_['error_error_log_write']						= 'Unable to write to VQMod error log!  Please set "<span class="error-install">/vqmod</span>" directory permissions to 755 or 777 and try again.';
$_['error_error_logs_write']					= 'Unable to write to VQMod error log!  Please set "<span class="error-install">/vqmod/logs</span>" directory permissions to 755 or 777 and try again.';
$_['error_opencart_version']					= 'OpenCart 1.5.x or later is required to use VQmods!';
$_['error_opencart_xml']						= 'Required file "<span class="error-install">/vqmod/xml/vqmod_opencart.xml</span>" does not appear to exist! <br />Please install the latest OpenCart-compatible version of VQMod from <a onclick="window.open(\'https://github.com/vqmod/vqmod/releases\');">https://github.com/vqmod/vqmod/releases</a> and try again.';
$_['error_opencart_xml_disabled']			= 'Warning: "<span class="error-install">vqmod_opencart.xml</span>" is disabled!  VQmod scripts will not function!';
$_['error_opencart_xml_version']				= 'You appear to be using a version of "<span class="error-install">vqmod_opencart.xml</span>" that is out-of-date for your OpenCart version! <br />Please install the latest OpenCart-compatible version of VQMod from <a onclick="window.open(\'https://github.com/vqmod/vqmod/releases\');">https://github.com/vqmod/vqmod/releases</a> and try again.';
$_['error_vqcache_dir']							= 'Required directory "<span class="error-install">/vqmod/vqcache</span>" does not appear to exist! <br /><br />Please install the latest OpenCart-compatible version of VQMod from <a onclick="window.open(\'https://github.com/vqmod/vqmod/releases\');">https://github.com/vqmod/vqmod/releases</a>.';
$_['error_vqcache_install_link']				= 'VQMod&#8482; has been detected on your system but does not appear to be installed!  Please run the VQmods installer <a href="%s" class="button">Install VQMod</a>';
$_['error_vqcache_write']						= 'Unable to write to "<span class="error-install">/vqmod/vqcache</span>" directory!  Set permissions to 755 or 777 and try again.';
$_['error_vqcache_files_missing']			= 'VQMod&#8482; does not appear to be properly generating VQCache files!';
$_['error_vqmod_core']							= 'Required file "<span class="error-install">vqmod.php</span>" is missing! <br />Please install the latest OpenCart-compatible version of VQMod from <a onclick="window.open(\'https://github.com/vqmod/vqmod/releases\');">https://github.com/vqmod/vqmod/releases</a> and try again.';
$_['error_vqmod_dir']							= 'The "<span class="error-install">/vqmod</span>" directory does not appear to exist!';
$_['error_vqmod_install_link']					= '<b>VQMod&#8482; does not appear to have been integrated with OpenCart!</b> <br /><br />Please run the VQmod installer at <a href="%1$s">%1$s</a>. <br /><br />If you have previously run the installer ensure that you are using the latest version of VQMod found at <a onclick="window.open(\'https://github.com/vqmod/vqmod/releases\');">https://github.com/vqmod/vqmod/releases</a>.';
$_['error_vqmod_opencart_integration']	= '<b>VQMod&#8482; does not appear to have been integrated with OpenCart!</b> <br /><br />Please install the latest OpenCart-compatible version of VQMod from <a onclick="window.open(\'https://github.com/vqmod/vqmod/releases\');">https://github.com/vqmod/vqmod/releases</a> and try again.';
$_['error_vqmod_script_dir']					= 'Required directory "<span class="error-install">/vqmod/xml</span>" does not appear to exist! <br />Please install the latest OpenCart-compatible version of VQMod from <a onclick="window.open(\'https://github.com/vqmod/vqmod/releases\');">https://github.com/vqmod/vqmod/releases</a> and try again.';
$_['error_vqmod_script_write']				= 'Unable to write to "<span class="error-install">/vqmod/xml</span>" directory! <br />Please set directory permissions to 755 or 777 and try again.';

// Dependency Errors
$_['error_simplexml']				= '<a onclick="window.open(\'http://php.net/manual/en/book.simplexml.php\');">SimpleXML</a> must be installed for VQMod to work properly! <br />Contact your host for more info.';
$_['error_ziparchive']			= '<a onclick="window.open(\'http://php.net/manual/en/class.ziparchive.php\');">ZipArchive</a> must be installed to download VQmod script files! <br />Contact your host for more info.';

// Log Errors
$_['error_mod_aborted']		= 'Mod Aborted';
$_['error_mod_skipped']			= 'Operation Skipped';

// Variable Settings
$_['setting_cachetime']			= 'cacheTime:<br /><span class="help">Deprecated as of VQMod&#8482; 2.2.0</span>';
$_['setting_dir_separator']		= 'Directory Separator:';
$_['setting_logfolder']			= 'Log Folder:<br /><span class="help">VQMod&#8482; 2.2.0 and later</span>';
$_['setting_logging']				= 'Error Logging:';
$_['setting_modcache']			= 'modCache:';
$_['setting_path_replaces']	= 'Path Replacements:<br /><span class="help">Changes do not go into effect until the mods.cache file is deleted.</span>';
$_['setting_protected_files']	= 'Protected Files:';
$_['setting_usecache']			= 'useCache:<br /><span class="help">Deprecated as of VQMod&#8482; 2.1.7</span>';

// Success
$_['success_clear_vqcache']	= 'Success: VQmod <b>Cache cleared!</b>';
$_['success_clear_log']			= 'Success: VQmod <b>Error log cleared!</b>';
$_['success_delete']				= 'Success: VQmod <b>Script deleted!</b>';
$_['success_install']				= 'Success: VQmod <b>Script installed!</b>';
$_['success_uninstall']			= 'Success: VQmod <b>Script uninstalled!</b>';
$_['success_upload']			= 'Success: VQmod <b>Script uploaded!</b>';

// Tabs
$_['tab_script_list']				= 'VQMod Scripts';
$_['tab_script_add']				= 'Add Script';
$_['tab_maintain']				= 'Maintenance';
$_['tab_error_log']				= 'Error Log';
$_['tab_settings']					= 'Settings';
$_['tab_about']					= 'About';

// Text
$_['text_autodetect']			= 'VQMod&#8482; appears to be installed at the following path.  Press <b>Save</b> to confirm path and complete installation.';
$_['text_autodetect_fail']		= 'Unable to detect VQMod&#8482; installation. <br />Please download and install the <a onclick="window.open(\'https://github.com/vqmod/vqmod/releases\');">latest version</a> or enter the non-standard server installation path.';
$_['text_cachetime']				= '%s seconds';
$_['text_delete']					= 'Delete';
$_['text_disable']					= 'Disable';
$_['text_disabled']				= 'Disabled';
$_['text_enable']					= 'Enable';
$_['text_enabled']				= 'Enabled';
$_['text_first_install']			= 'When Installing <b>VQmod&#8482;</b> for the first time, you will be <b>logged out of your Administration</b> and redirected to a blank page with a <b>confirmation message</b>.<br />You will have to <b>log back in</b> into your Administration <b>after install</b>.';
$_['text_getxml']					= 'Select an XML file';
$_['text_modification']			= 'Modification';
$_['text_no_results']				= 'No VQmod Scripts were found!';
$_['text_separator']				= ' &rarr; ';
$_['text_success']				= 'Success: You have modified <b>VQmods</b> !';
$_['text_unavailable']			= '&mdash;';
$_['text_upload']					= 'Upload';
$_['text_upload_help']			= 'Please select a valid VQMod .xml file from your local library.';
$_['text_usecache_help']		= 'useCache is deprecated as of VQMod&#8482; 2.1.7';
$_['text_vqcache_help']		= 'Clears the content of the VQCache directory and deletes "mods.cache" file.  Note: Some system files will still remain even after clearing the cache.';

// About
$_['text_vqm_version']			= 'VQmods Version:';
$_['text_vqm_author']			= 'VQmods Author:';
$_['text_vqm_website']			= 'VQmods Website:';
$_['text_vqm_support']			= 'VQmods Support:';
$_['text_vqm_license']			= 'VQmods License:';
$_['text_vqmm_version']		= 'VQmod Manager Version:';
$_['text_vqmm_author']		= 'VQmod Manager Author:';
$_['text_vqmm_website']		= 'VQmod Manager Website:';
$_['text_vqmm_license']		= 'VQmod Manager License:';
$_['text_vqmod_version']		= 'VQmod&#8482; Version:';
$_['text_vqmod_author']		= 'VQmod&#8482; Authors:';
$_['text_vqmod_website']		= 'VQmod&#8482; Repository:';
$_['text_vqmod_license']		= 'VQmod&#8482; License:';

// Version
$_['vqmods_description']		= '<b>VQmods</b> is a VQmod&#8482; File Manager for Opencart, based on the original <b>VQmod Manager</b> by Ryan (rph), and integrating the latest <b>VQmod&#8482;</b> Core Files!';
$_['vqmods_version']			= '2.0.0 - Overclocked Edition';
$_['vqmods_author']				= 'Villagedefrance';
$_['vqmods_support']			= 'contact@villagedefrance.net';
$_['vqmods_license']				= 'GNU General Public License';
$_['vqmod_manager_version']	= '2.0.1';
$_['vqmod_manager_author']	= 'Ryan (rph) – OpenCartHelp.com';
$_['vqmod_manager_license']	= 'Attribution-NonCommercial-ShareAlike 3.0 Unported (CC BY-NC-SA 3.0)';
$_['vqmod_version']				= 'v2.5.1 - Opencart';
$_['vqmod_author']				= 'Qphoria (qphoria@gmail.com) & Jay Gilford (jay@jaygilford.com)';
$_['vqmod_license']				= 'GNU General Public License';

// Javascript Warnings
$_['warning_required_delete']		= 'WARNING: Deleting \\\'vqmod_opencart.xml\\\' will cause VQMod to STOP WORKING!  Continue?';
$_['warning_required_uninstall']	= 'WARNING: Uninstalling \\\'vqmod_opencart.xml\\\' will cause VQMod to STOP WORKING!  Continue?';
$_['warning_vqmod_delete']		= 'WARNING: Deleting a VQMod script cannot be undone!  Are you sure you want to do this?';
?>