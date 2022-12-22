{* help.ecb2fd_group.tpl *}
<p>The group field creates a simple text input, for storing a single string.</p>

<fieldset>
    {$fielddef->get_demo_input([])}
</fieldset>

<pre>{literal}{content_module module=ECB2 field=group block="test" label="Test" default="a sample group"}{/literal}</pre>

<p>Parameters:</p>
<ul>
    <li>field (required) - 'group'</li>
    <li>block (required) - the name of the content block</li>
    <li>layout (optional) - either 'table' (default), or 'grid'.</li>
    <li>max_blocks (optional) - the maximum number of repeater fields that can be created</li>
    <li></li>
{*    <li>default_value (optional) - initial value when creating a new page</li>*}
    <li>description (optional) - adds additional text explanation for editor</li>
</ul>

<p>Tip: change the order of the subX_ parameters to change the order of the fields in the admin page.</p>
<p>Note: the default PHP limit for inputs on one page is 1000. This is set by max_input_vars in php.ini. If you may need more than this on a single page you can increase max_input_vars. Each sub field in each group row is 1 input, plus all other fileds on the page.</p>
<p>Tip: sub field parameters like 'repeater', 'max-blocks' and 'assign' are ignored.</p>