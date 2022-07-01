{* help.ecb2fd_file_selector.tpl *}
<p>The file_selector field enables a file to be selected from a set directory and can optionally show a thumbnail.</p>

<pre>{literal}{content_module module=ECB2 field=file_selector block="test10" dir="images" filetypes="jpg,gif,png" excludeprefix="thumb_"}{/literal}</pre>

<p>Parameters:</p>
<ul>
    <li>field (required) - 'file_selector'</li>
    
    <li>filetypes (required) - comma separated list of file extensions to display, e.g. 'jpg,gif,png'</li>
    <li>dir (optional) - specify a sub directory of 'uploads' to use</li>
    <li>excludeprefix (optional) - exclude any files that have this prefix, e.g. 'thumb_'</li>
    <li>recurse (optional) - if set will show all files in sub directories</li>
    <li>sortfiles (optional) - will sort files by filename</li>
    <li>preview (optional) - will show a thumbnail of the image - only for images</li>
    <li>description (optional) - adds additional text explanation for editor</li>
</ul>
