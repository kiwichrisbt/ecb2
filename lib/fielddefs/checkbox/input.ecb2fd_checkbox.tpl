{* input.ecb2fd_checkbox.tpl - v1.0 - 25Jun22 

***************************************************************************************************}
{if !empty($description)}
        {$description}<br>
{/if}
        <input type="hidden" id="test5a" name="{$block_name}" value="0">
        <input type="checkbox" class="cms_checkbox" name="{$block_name}" value="1" {if $value}checked="checked"{/if}>