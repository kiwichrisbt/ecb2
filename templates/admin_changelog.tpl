{* ECB2 admin_changelog.tpl *}


<h3>Version 1.99.???? - 21Jul22 ????</h3>
<ul>
   <li>bug fix for using a module call 'mod' parameter - if any parameters being passed through to the module contain a space it would probably cause an error. Fixed.</li>
   <li>added database to store ecb2_block definitions</li>
   <li>added repeater functionality - sortable content blocks, optionally limited by 'max_blocks'</li>
   <li>improved admin layout & added module custom icons</li>
   <li>input_repeater is now an alias of textinput (fully compatible)</li>
   <li></li>
   <li></li>
</ul>
<br>


<h3>Version 1.99.3 - 06Jul22</h3>
<ul>
   <li>add in module 'Manage' permissions for access to module admin page</li>
   <li>admin_image - bug fix</li>
</ul>
<br>


<h3>Version 1.99.1 - 06Jul22</h3>
<ul>
   <li>about tweaks</li>
   <li>admin_image - error message added if image file not found plus add in sample image for help page.</li>
</ul>
<br>


<h3>Version 1.99 - 05Jul22</h3>
<ul>
   <li>Significantly refactored module, to enable future development of the module and simplify use. Is fully compatible with all previous usage. Please report any issues you may find.</li>
   <li>Expanded help content, with example tags and demo content blocks for all field types.</li>
   <li>Some field types have been renamed, to make their use more obvious. All previous field types are fully supported as an alias for the new field name</li>
   <li>'textinput' field replaces 'input', field=input is a fully supported alias</li>
   <li>'textarea' field replaces 'editor', with a wysiwyg option added (default=false). field=editor is a fully supported alias</li>
   <li>'dropdown' field now replaces 'dropdown_from_module', 'dropdown_from_udt', 'dropdown_from_customgs' & 'dropdown_from_gbc', plus has a new alias 'select'. A new 'template' parameter enables dropdown values to be retrieved from a smarty template ('gcb' parameter is as alias). A sample LISE module template added into help</li>
   <li>'checkbox' - added an inline_label option</li>
   <li>'radio' - added 'flip_values' option - swaps the dropdowns values <-> text</li>
   <li>'date_time_picker' field replaces 'datepicker' and 'timepicker' with both fully supported as aliases</li>
   <li>parameter 'default' now used instead of 'default_value', ('default_value' parameter is an alias) - for all fields that can have a default</li>
   <li>'page_picker', renamed from the now alias: 'pages'</li>
   <li>'module_picker', renamed from the now alias: 'module'</li>
   <li>'admin_fieldset_start', renamed from the now alias: 'fieldset_start'</li>
   <li>'admin_fieldset_end', renamed from the now alias: 'fieldset_end'</li>
   <li>'admin_hr', renamed from the now alias: 'hr'</li>
   <li>'admin_image', renamed from the now alias: 'image'</li>
   <li>'admin_link', renamed from the now alias: 'link'</li>
   <li>'admin_module_link', renamed from the now alias: 'module_link'</li>
   <li>'admin_text', renamed from the now alias: 'text'</li>
   <li>added sample LISE template into help</li>
</ul>
<br>


<h3>Version 1.8 - 22Jun22</h3>
<ul>
   <li>dropdown & sortablelist - 'mod' option added - can load options directly from a modules template</li>
   <li>dropdown & sortablelist - 'flip_values' option added - swaps the dropdowns values <-> text. Can simplify using data from another source.</li>
   <li>undocumented & non-functioning method get_dropdown_from_module removed.</li>
   <li>bug fix for v1.7 - color_picker had stopped working</li>
   <li>time_picker & colour_picker js moved into single file ecb2_admin.js</li>
   <li>force refresh of css & js files after module update</li>
</ul>
<br>


<h3>Version 1.7 - 20Jun22</h3>
<ul>
   <li>color_picker - changed to use colpick for consistency with LISE & CustomGS, added options: clear_css_cache & no_hash</li>
   <li>image - added field type for displaying an image on an admin page only. Usefully to provide extra guidance to editors.</li>
</ul>
<br>


<h3>Version 1.6.2 - 19Jan22</h3>
<ul>
   <li>datepicker - add options for change_month, change_year, year_range</li>
   <li>datepicker & timepicker - move ouput into smarty template 'datepicker_template.tpl', move custom js from inline into ecb2_admin.js</li>
   <li>bug fix for is_datepicker_lib_load - so it's only loaded once</li>
</ul>
<br>


<h3>Version 1.6.1 - 27Jul20</h3>
<ul>
   <li>move help & changelog into templates</li>
   <li>Bug fix: for 'checkbox' using default of true (checked) - work around for core bug</li>
</ul>
<br>


<h3>Version 1.6 - 03Jun20</h3>
<ul>
   <li>all 'dropdown' content blocks now have the option for a 'compact' display on the admin page. Set "compact=1" in the parameters a summary of the selected options is displayed and the full select is shown/hidden when 'edit/hide' is clicked</li>
   <li>file_selector content block - updated now uses core method instead of CGExtensions</li>
   <li>removed CGExtensions dependancy</li>
   <li>Bug fix: default value now works for checkbox, input, textarea & editor content blocks</li>
</ul>
<br>


<h3>Version 1.5.3 - 17Jun19</h3>
<ul>
   <li>minor bug fix in help</li>
</ul>
<br>


<h3>Version 1.5.2 - 19Feb19</h3>
<ul>
   <li>bug fix - admin js updated - fixes v1.5.1 multiple select's & input_repeater not working - please update</li>
</ul>
<br>

<h3>Version 1.5.1 - 18Feb19</h3>
<ul>
   <li>gallery_picker - bug fix</li>
</ul>
<br>

<h3>Version 1.5 - 16Feb19</h3>
<ul>
   <li>input_repeater content block - added - thanks to Simon Radford</li>
   <li>gallery_picker content block - added</li>
   <li>dropdown_from_customgs content block - added</li>
   <li>added error message for missing or incorrectly spelt field paramater - BR#11557 - thanks Ludger</li>
   <li>removed Admin page that only showed help - redundant as help easily visible from within Module Manager</li>
   <li>removed Permission 'Use ECB2' - also redundant</li>
   <li>code tidy up - consolidate js & css into separate external files</li>
</ul>
<br>

<h3>Version 1.3.1 - 12Jul17</h3>
<ul>
   <li>minor bug fix</li>
</ul>
<br>

<h3>Version 1.3 - 11Jul17</h3>
<ul>
   <li>sortablelist - added max_number and required_number options</li>
   <li>Added 'fieldset_start' and 'fieldset_end' fields</li>
</ul>
<br>

<h3>Version 1.2.2 - 05Jul17</h3>
<ul>
   <li>test for and display warning in admin if UDT does not exist</li>
</ul>
<br>

<h3>Version 1.2.1 - 19Apr17</h3>
<ul>
   <li>bug fix for color_picker, default_value - BR#11354 - thanks Stuart</li>
   <li>color_picker - tweaked layout</li>
   <li>sortablelist - now use jquery sortable instead of CGExtensions. Parameters removed: 'template'. Parameters not operational: 'max_selected', 'allowduplicates' (please advise if you require these). Plus some bug fixes.</li>
</ul>
<br>

<h3>Version 1.2 - 07Nov16</h3>
<ul>
   <li>Added 'description' parameter for all fields (optional) - adds additional text explanation for editor</li>
   <li>Added 'hidden' field - Can be used to set a page attribute that can then be accessed (e.g. from a Navigator-Template), using {ldelim}page_attr page=$node->alias key='testhidden'{rdelim}</li>
   <li>Bug fix - for php notice</li>
</ul>
<br>

<h3>Version 1.1 - 15Apr16</h3>
<ul>
    <li>Bug fix</li>
</ul>
<br>

<h3>Version 1.0 - 15Apr16</h3>
<ul>
    <li>Initial release. A fork of ECB module v1.6, that is compatible with CMSMS v2+</li>
    <li>Added radio field - to provide radio buttons on an admin page</li>
</ul>
<br>