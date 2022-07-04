{* help.ecb2fd_admin_module_link.tpl *}
<p>The admin_module_link field creates a link on the admin page to the specified module.</p>

<pre>{literal}{content_module module=ECB2 field=admin_module_link block="test18" label="Test" default_value="fill it"}{/literal}</pre>

<p>Parameters:</p>
<ul>
    <li>field (required) - 'admin_module_link', alias: '<b>module_link</b>'</li>
    <li>block (required) - the name of the content block</li>
    <li>mod (required) - name of the module to link to<br>
    <li>text (optional) - text to use in the link</li>
    <li>target (optional) - default: '_self'</li>
    <li>description (optional) - adds additional text explanation for editor</li>
</ul>