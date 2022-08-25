{* help.ecb2fd_gallery.tpl *}
<p>The gallery field creates a simple text input, for storing a single string.</p>

<fieldset>
    {$fielddef->get_demo_input([])}
</fieldset>

<pre>{literal}{content_module module=ECB2 field=gallery block="test" label="Test" default="a sample gallery"}{/literal}</pre>

<p>Parameters:</p>
<ul>
    <li>field (required) - 'gallery'</li>
    <li>block (required) - the name of the content block</li>
    <li></li>
    <li></li>
    <li>default_value (optional) - initial value when creating a new page</li>
    <li>description (optional) - adds additional text explanation for editor</li>
</ul>