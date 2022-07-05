{* help.ecb2fd_textinput.tpl *}
<p>The textinput field creates a simple text input, for storing a single string.</p>

<fieldset>
{$fielddef->get_demo_input(['size'=>55, 'max_length'=>55, 'default'=>"a sample textinput"])}
</fieldset>

<pre>{literal}{content_module module=ECB2 field=textinput block="test5" label="Text" size=55 max_length=55 default="a sample textinput"}{/literal}</pre>

<p>Parameters:</p>
<ul>
    <li>field (required) - '<b>textinput</b>', or alias: '<b>input</b>'</li>
    <li>block (required) - the name of the content block</li>
    <li>size (optional) - sets the width of the html input. May be overridden by css - default 30</li>
    <li>max_length (optional) - maximum number of characters - default 255 </li>
    <li>default (optional) - (alias: '<b>default_value</b>') - initial value when creating a new page</li>
    <li>description (optional) - adds additional text explanation for editor</li>
</ul>