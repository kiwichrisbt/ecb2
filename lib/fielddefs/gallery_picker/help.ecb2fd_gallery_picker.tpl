{* help.ecb2fd_gallery_picker.tpl *}
<p>The gallery_picker creates a dropdown to choose from a selection of galleries in the Gallery module.</p>

<pre>{literal}{content_module module=ECB2 field=gallery_picker block=pageTopGallery label='Page Top Gallery' dir='page-top-galleries'}</pre>

<p>Parameters:</p>
<ul>
    <li>field (required) - 'gallery_picker'</li>
    <li>dir (optional) - only returns galleries that are sub-galleries of this gallery dir, default is all galleries, excluding default top level gallery</li>
    <li>description (optional) - adds additional text explanation for editor</li>
</ul>

<p>Provides a gallery picker for the Gallery module.</p>
<p>Example:
      {content_module module='ECB2' field='gallery_picker' block=pageTopGallery label='Page Top Gallery' dir='page-top-galleries'}</p>
<p>Parameters:</p>
<ul>
   <li>dir (optional) - only returns galleries that are sub-galleries of this gallery dir, default is all galleries, excluding default top level gallery</li>
   <li>description (optional) - a description of the field</li>
</ul>
<br>