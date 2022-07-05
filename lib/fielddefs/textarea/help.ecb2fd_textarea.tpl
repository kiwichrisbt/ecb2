{* help.ecb2fd_textarea.tpl *}
<p>The textarea field creates either a simple textarea input, for paragraphs of text, or optionally a full WYSIWYG editor to create formatted html.</p>

<fieldset>
{$fielddef->get_demo_input(['rows'=>3, 'cols'=>100, 'default'=>'a sample textarea'])}
</fieldset>

<pre>{literal}{content_module module="ECB2" field="textarea" label="Textarea" block="test6" rows=3 cols=100 default="a sample textarea"}{/literal}</pre>

<p>Parameters:</p>
<ul>
    <li>field (required) - '<b>textarea</b>', or alias: '<b>editor</b>' (sets wysiwyg=true)</li>
    <li>block (required) - the name of the content block</li>
    <li>rows (optional) - sets the height of the textarea. May be overridden by css - default 20</li>
    <li>cols (optional) - sets the width of the textarea. May be overridden by css - default 80</li>
    <li>wysiwyg (optional) - enables a wysiwyg editor on the textarea - default false</li>
    <li>default (optional) - (alias: '<b>default_value</b>') - initial value when creating a new page</li>
    <li>description (optional) - adds additional text explanation for editor</li>
</ul>

