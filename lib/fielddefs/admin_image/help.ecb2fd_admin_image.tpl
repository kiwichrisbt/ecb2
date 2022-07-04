{* help.ecb2fd_admin_image.tpl *}
<p>Displays an image on an admin page only. Usefully to provide extra guidance to editors.</p>

<pre>{literal}{content_module module=ECB2 field=admin_image label="19: admin_image" block="test19" image='images/photo-coming-soon-4-3.jpg' description="This is an admin only image"}{/literal}</pre>

<p>Parameters:</p>
<ul>
    <li>field (required) - 'admin_image', alias: '<b>image</b>'</li>
    <li>block (required) - the name of the content block</li>
    <li>image (required) - path and filename relative to the uploads directory</li>
    <li>description (optional) - adds additional text explanation for editor</li>
</ul>