{* input.ecb2fd_color_picker.tpl - v1.0 - 25Jun22 

***************************************************************************************************}
{if !empty($description)}
        {$description}<br>
{/if}
        {strip}
        <input class="{$class}" type="text" name="{$block_name}" id="{$alias}" size="{$size}" value="{$value}"
            {if !empty($no_hash)} data-no-hash="{$no_hash}"{/if}
        />
        {/strip}