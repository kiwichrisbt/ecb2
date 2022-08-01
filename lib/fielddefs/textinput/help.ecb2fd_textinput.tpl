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
    <li>assign (required for repeater*) - the name of the content block</li>
    <li>size (optional) - sets the width of the html input. May be overridden by css - default 30</li>
    <li>max_length (optional) - maximum number of characters - default 255</li>
    <li>repeater (optional) - enables 1 or more textinput fields to be created and sorted by clicking & dragging. Note: assign must be used to correctly supply the multiple values to the page template as an array.</li>
    <li>max_blocks (optional) - the maximum number of repeater fields that can be created</li>
    <li>default (optional) - (alias: '<b>default_value</b>') - initial value when creating a new page</li>
    <li>description (optional) - adds additional text explanation for editor</li>
</ul>

<fieldset>
    <legend>Sample textinput with repeater & max_blocks - use 'repeater=1 max_blocks=3 assign=tmp' </legend>
    {$fielddef->get_demo_input(['size'=>100, 'default'=>"a sample textinput", 'repeater'=>1, 'max_blocks'=>3, 'assign'=>'tmp'])}
</fieldset>