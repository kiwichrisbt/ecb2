{* input.ecb2fd_textinput.tpl - v1.0 - 25Jun22 

***************************************************************************************************}
{if !empty($description)}
        {$description}<br>
{/if}
{if !$repeater}
        <input type="text" name="{$block_name}" size="{$size}" maxlength="{$max_length}" value="{$value}"/>

{else}
    {if empty($assign)}
        <div class="pagewarning">
            {$mod->Lang('error_assign_required')}
        </div><br>
    {/if}
    <input type="hidden" id="{$block_name}" name="{$block_name}" value="{$value}" size="100"/>

    <div id="{$block_name}-repeater" class="ecb_repeater sortable" data-block-name="{$block_name}" {if $max_blocks>0}data-max-blocks="{$max_blocks}"{/if}>

        <button class="ecb2-repeater-add ecb2-btn ecb2-btn-default" data-repeater="#{$block_name}-repeater" title="{$mod->Lang('add_line')}" role="button" {if !empty($max_blocks) && $max_blocks>=$ecb_values|@count} disabled aria-disabled="true"{else}aria-disabled="false"{/if}><span class="ecb2-icon-plus"></span>&nbsp;&nbsp;{$mod->Lang('add_item')}</button>

    {foreach $ecb_values as $ecb_id => $ecb_value}
        <div class="repeater-wrapper">
            <div class="drag-panel">
                <span class="ecb2-icon-grip-dots-vertical-solid"></span>
            </div>
            <input id="repeater-field-{$block_name}-{$ecb_value@iteration}" name="{$block_name}[]" class="repeater-field" size="{$size}" maxlength="{$max_length}" value="{$ecb_value}" data-repeater="#{$block_name}-repeater"/>
            <div class="right-panel">
                <button class="ecb2-repeater-remove ecb2-btn ecb2-btn-default ecb2-icon-only" data-repeater="#{$block_name}-repeater" title="{$mod->Lang('remove_line')}" role="button" aria-disabled="false"><span class="ecb2-icon-trash-can-regular"></span></button>
            </div>
        </div>
    {/foreach}
    </div>

{/if}