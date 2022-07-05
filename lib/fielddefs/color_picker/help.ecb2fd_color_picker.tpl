{* help.ecb2fd_color_picker.tpl *}
<p>The color_picker field provides a simple option for selecting a HEX color code.</p>

<pre>{literal}{content_module module=ECB2 field=color_picker block="test7" label="Color" default="#000000"}{/literal}</pre>

<p>Parameters:</p>
<ul>
    <li>field (required) - 'color_picker'</li>
    <li>block (required) - the name of the content block</li>
    <li>size (optional) - default 10</li>
    <li>no_hash (optional) - if set the hex value displayed and returned does not include a '#'</li>
    <li>clear_css_cache (optional) - if set the css cache is refreshed if the color is changed</li>
    <li>default (optional) - (alias: '<b>default_value</b>') - initial value when creating a new page</li>
    <li>description (optional) - adds additional text explanation for editor</li>
</ul>
