{* ECB2 _changelog.tpl *}

<h3>Version 1.99... - 23Jun22.....</h3>
<ul>
   <li>Significantly refactored module, to enable future development of the module and simpify use. Is fully compatible with all previous usage. Please report any issues you may find.</li>
   <li>Expanded help content, with example tags</li>
   <li>'textinput' field replaces 'input', field=input is a fully supported alias</li>
   <li>'textarea' field replaces 'editor', with a wysiwyg option added (default=false). field=editor is a fully supported alias</li>
   <li>'dropdown' field now replaces 'dropdown_from_module', 'dropdown_from_udt', 'dropdown_from_customgs' & 'dropdown_from_gbc', plus has a new alias 'select'. A new 'template' parameter enables dropdown values to be retrieved from a smarty template (alias for 'gcb' field).</li>
   <li></li>
   <li></li>
   <li></li>
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