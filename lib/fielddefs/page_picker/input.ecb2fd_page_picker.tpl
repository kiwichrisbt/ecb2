{* input.ecb2fd_page_picker.tpl - v1.0 - 25Jun22 

***************************************************************************************************}
{if !empty($description)}
        {$description}<br>
{/if}
        {$contentOps->CreateHierarchyDropdown('', $value, $block_name, 1, 1)}
<pre>
$value:{$value}
</pre>