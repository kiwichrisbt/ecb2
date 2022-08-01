<?php

$lang['about'] = 'About';
$lang['add_line'] = 'Add line';
$lang['admin_only_help'] = 'Admin only fields';
$lang['admin_only_help_intro'] = 'The following fields are only used to format and add content to the admin pages. They do not provide any useful content for the frontend website pages.';


$lang['content_block_label_selected'] = 'Selected';
$lang['content_block_label_available'] = 'Available';
$lang['customgs_field_error'] = "Please create field '%s' in CustomGS";

$lang['drop_items'] = 'No items selected - drop selected items here';
$lang['drop_required_items'] = 'Drop %s required items here';

$lang['error_assign_required'] = 'The assign parameter is required to correctly output multiple values.';
$lang['error_filename'] = 'The file \'%s\' for the \'%s\' parameter could not be found.';
$lang['extended_content_blocks'] = 'Extended Content Blocks';

$lang['fields'] = 'Fields';
$lang['field_error'] = 'Please specify a correct field parameter for the ECB2 content block \'%s\'.';
$lang['field_types'] = 'Field types';
$lang['friendlyname'] = 'Extended Content Blocks 2';

$lang['gallery_module_error'] = 'Gallery module is not installed.';

$lang['hide'] = 'Hide';

$lang['installed'] = 'Module version %s installed.';

$lang['module_description'] = 'This module enables extra types of content block for page templates';
$lang['module_error'] = 'The \'%s\' module is not available.';

$lang['need_permission'] = 'You need permission to use this module';
$lang['none_selected'] = '--- none ---';

$lang['parameter_missing'] = 'Please specify a \'%s\' parameter for the ECB2 content block \'%s\'.';
$lang['postinstall'] = 'Extended Content Blocks 2 was successful installed';
$lang['postuninstall'] = 'Extended Content Blocks 2 was successful uninstalled';

$lang['really_uninstall'] = 'Really? Are you sure you want to uninstall the ECB2 module?';
$lang['remove'] = 'Remove';
$lang['remove_line'] = 'Remove line';

$lang['selected'] = 'Selected';
$lang['select'] = 'Select';

$lang['template_error'] = 'Invalid template name \'%s\'';

$lang['udt_error'] = 'User Defined Tag \'%s\' does not exist';
$lang['uninstalled'] = 'Module Uninstalled.';
$lang['upgraded'] = 'Module upgraded to version %s.';








###    ###   #########   ###        #########
###    ###   #########   ###        #########
###    ###   ###         ###        ###   ###
##########   #########   ###        #########
##########   #########   ###        #########
###    ###   ###         ###        ###
###    ###   #########   #########  ###
###    ###   #########   #########  ###



$lang['general_c'] = <<<'EOD'
<p>The Extended Content Blocks 2 (ECB2) module to give you more page editing options. Many aditional content block types are available to use in each page template. e.g. dropdown, colour picker, checkbox, radio button, and many more.</p>
<br>

<h3>Usage</h3>
<p>Use the CMSMS core <b>{content_module}</b> tag to add all ECB2 content blocks to any page template.</p>
<pre>{content_module module=ECB2 field=some_field_type block='some name' ...}</pre>
<p>The core content_module tag provides the following parameters for ALL of the ECB2 content blocks:</p>
<ul>
    <li>module (required) - 'ECB2'</li>
    <li>field (required) - one of ECB2 field types below</li>
    <li>block (required) - the name of the content block</li>
    <li>label (optional) - A label for the content block for use when editing the page.</li>
    <li>required (optional) - Allows specifying that the content block must contain some text.</li>
    <li>tab (optional) - The desired tab to display this field on in the edit form.</li>
    <li>priority (optional) integer - Allows specifying an integer priority for the block within the tab.</li>
    <li>assign (optional) string - Assign the results to a smarty variable with that name.</li>
</ul>

<p><b>Smarty tip</b>: parameter values that are single-word strings do not have to be quoted e.g. field=checkbox is the same as field='checkbox'.</p>

<br><br>
EOD;


$lang['about_c'] = <<<'EOD'
<p>ECB2 provides additional Content Blocks for use in page templates for CMS Made Simple v2+.</p>
<p>Thanks to Tom Phane @tomph, for his code improvements, optimisations, and help content (especially a great simple smarty tip).</p>
<p>The ECB2 module is a fork of the module Extended Content Blocks (ECB), for CMSMS v1, developed by Zdeno Kuzmany.</p>
<br><br>

<h3>Upgrading from ECB</h3>
<p>Install ECB2 module and change all "module" parameters, in content_module tags to be module="ECB2" (was "ECB"). Then ECB can be uninstalled.</p><br>

<h3>Upgrading from CGContentUtils</h3>
<p>Install ECB2 and change all "module" parameters, in content_module tags to be module=ECB2 (was "CGContentUtils").</p>
<p>Parameters:</p>
<ul>
    <li>block (required) - must stay the same</li>
    <li>field (required) - choose the appropriate ECB2 field
    <li>other parameters will be required depending on the field and preiovuis options set in CGContentUtils</li>
</ul>
<p>Check all are working as expected, then CGContentUtils can be uninstalled.</p>
<br>


<h3>Support</h3>
<p>As per the GPL licence, this software is provided as is. Please read the text of the license for the full disclaimer.
The module author is not obligated to provide support for this code. However you might get support through the following:</p>
<ul>
    <li>For support, first <strong>search</strong> the <a href="//forum.cmsmadesimple.org">CMS Made Simple Forum</a>, for issues with the module similar to those you are finding.</li>
    <li>Then, if necessary, open a <strong>new forum topic</strong> to request help, with a thorough description of your issue, and steps to reproduce it.</li>
    <li>Ask a question on the <a href="//cms-made-simple.slack.com" target="_blank">CMS Made Simple Slack channel</a>, or just share you thoughts if you found the Module useful. <a href="//www.cmsmadesimple.org/support/documentation/chat" target="_blank">Join CMSMS on Slack</a></li>
    <li>If you find a bug you can <a href="http://dev.cmsmadesimple.org/bug/list/1366" target="_blank">submit a Bug Report</a>.</li>
    <li>For any good ideas you can <a href="http://dev.cmsmadesimple.org/feature_request/list/1366" target="_blank">submit a Feature Request</a>.</li>
</ul><br>

<h3>Sponsor Development</h3>
<p>If you would like a new field or feature added to this module, please contact me. You can sponsor development from £50.</p><br>


<h3>Copyright &amp; Licence</h3>
<p>Copyright © 2019, Chris Taylor < chris at binnovative dot co dot uk >. All Rights Are Reserved.</p><br>
<p>This module has been released under the GNU Public License v3. However, as a special exception to the GPL, this software is distributed as an addon module to CMS Made Simple. You may only use this software when there is a clear and obvious indication in the admin section that the site was built with CMS Made Simple!</p><br>
<br>
EOD;


