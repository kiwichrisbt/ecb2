{* input.ecb2fd_textarea.tpl - v1.0 - 25Jun22 

***************************************************************************************************}
{if !empty($description)}
        {$description}<br>
{/if}
{if $wysiwyg}
        {cms_textarea name=$block_name enablewysiwyg=$wysiwyg rows=$rows cols=$cols value=$value}
{else}
        <textarea name="{$block_name}" rows="{$rows}" cols="{$cols}">{$value}</textarea>
{/if}