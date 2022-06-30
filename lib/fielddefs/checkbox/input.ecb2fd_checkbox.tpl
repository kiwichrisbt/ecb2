{* input.ecb2fd_checkbox.tpl - v1.0 - 25Jun22 

***************************************************************************************************}
{if !empty($description)}
        {$description}<br>
{/if}
        <input type="hidden" name="{$block_name}" value="0">
        <input type="checkbox" id="{$block_name}" class="cms_checkbox" name="{$block_name}" value="1" {if $value}checked="checked"{/if}>
{if $inline_label}
        <label for="{$block_name}"> <b>{$inline_label}</b></label>
{/if}