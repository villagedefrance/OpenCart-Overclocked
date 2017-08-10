<?php
// Heading
$_['heading_title']     = 'Export / Import (CSV)';

$_['heading_import']    = 'Import';
$_['heading_export']    = 'Export';
$_['heading_parameter'] = 'Parameters';

// Text
$_['text_success']      = 'Success: You have successfully imported a CSV file!';
$_['text_import']       = 'Select a CSV file';
$_['text_spreadsheet']  = 'Select the following parameters in your spreadsheet (Microsoft Excel or OpenOffice Calc) to open the exported file.';
$_['text_charset']      = 'Characters Set:';
$_['text_delimiter']    = 'File Delimiter:';
$_['text_enclosure']    = 'File Enclosure:';
$_['text_escaped']      = 'File Escaped:';
$_['text_ending']       = 'File Ending:';

// Entry
$_['entry_import']      = 'Import a CSV file:';
$_['entry_export']      = 'Export a CSV file:<span class="help">Select a database table to export.</span>';

// Button
$_['button_import']     = 'Import';
$_['button_export']     = 'Export';
$_['button_refresh']    = 'Refresh';

// Help
$_['help_function']     = 'The Export / Import (CSV) Tool allows you to mass edit an individual database table by exporting it into a spreadsheet, using the standard CSV format.';
$_['help_caution']      = '<b>Important!</b> Editing tables this way is quick and easy, but keep in mind that some columns values are common to more than one table in your database.<br />All changes must be consistent, otherwise the integrity of your database will be compromised, and in NO circumstances you should edit the ID numbers in tables!';

// Error
$_['error_permission']  = 'Warning: You do not have permission to modify <b>Export / Import (CSV)</b>!';
$_['error_empty']       = 'Warning: No file selected or the file was empty!';
$_['error_export']      = 'Error: The CSV file cannot be generated!';
