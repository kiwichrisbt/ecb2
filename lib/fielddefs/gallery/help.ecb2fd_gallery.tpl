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
    <li>dir (optional) - a sub directory of the uploads directory, if not set a unique directory is created for this content block.</li>
    <li>resize_width (optional) - if set, images will be resized to this width before being uploaded. If only one of resize_width or resize_height is set, the original aspect ratio of the image is preserved.</li>
    <li>resize_height (optional) - if set, images will be resized to this height before being uploaded. If only one of resize_width or resize_height is set, the original aspect ratio of the image is preserved.</li>
    <li>resize_method (optional) - 'contain' (default), or 'crop' can be used.</li>
    <li>thumbnail_width (optional) - sets thumbnail width for this fields thumbnails. If thumbnail_width is set, but thumbnail_height is not, the ratio of the image will be used to calculate thumbnail_height. These settings will default to the ECB2 Thumbnail Width & Height options, or CMSMS Thumbnail Width & Height settings.</li>
    <li>thumbnail_height (optional) - sets thumbnail height for this fields thumbnails. If thumbnail_height is set, but thumbnail_width is not, the ratio of the image will be used to calculate thumbnail_width. These settings will default to the ECB2 Thumbnail Width & Height options, or CMSMS Thumbnail Width & Height settings.</li>
    <li>max_files (optional) - sets a maximum number of files that can be uploaded</li>
    <li>auto_add_delete (optional) default:true - will automatically delete unused files & thumbnails from the directory</li>
    <li>default_value (optional) - initial value when creating a new page</li>
    <li>description (optional) - adds additional text explanation for editor</li>
</ul>