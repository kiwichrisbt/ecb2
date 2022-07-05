{* help.ecb2fd_input_repeater.tpl *}
<p>The input_repeater field creates one or more text inputs that can be added or removed by the editor.</p>
<p>The content block output is a string with each input field's contents delimiter by '||'. To make the output a more useful array use 'explode', e.g. {literal}{"||"|explode:$content_block_name}{/literal}</p>

<pre>{literal}{$input_repeater_test="||"|explode:"{content_module module='ECB2' field='input_repeater' label='Test 22: input_repeater' block='test22' size=50 max_length=255 description='Press (+) and (-) to add and remove additional input fields'}" scope=global}{/literal}</pre>

<p>Parameters:</p>
<ul>
    <li>field (required) - 'input_repeater'</li>
    <li>block (required) - the name of the content block</li>
    <li>size (optional) - sets the width of the html input. May be overridden by css - default 30</li>
    <li>max_length (optional) - maximum number of characters - default 255 (optional)</li>
    <li>default (optional) - (alias: '<b>default_value</b>') - initial value when creating a new page</li>
    <li>description (optional) - adds additional text explanation for editor</li>
</ul>