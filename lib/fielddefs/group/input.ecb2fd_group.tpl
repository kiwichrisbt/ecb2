{* input.ecb2fd_group.tpl - v1.0 - 25Jun22 

***************************************************************************************************}
{if !empty($description)}
    {$description}<br>
{/if}

{if empty($assign)}
    <div class="pagewarning">
        {$mod->Lang('error_assign_required')}
    </div><br>
{/if}


    {* <input type="hidden" id="{$block_name}" name="{$block_name}[type]" value="{$type}"/> *}
    
    <div id="{$block_name}-repeater" class="ecb_repeater sortable" data-block-name="{$block_name}" data-highest-row="{$values|@count}" {if $max_blocks>0}data-max-blocks="{$max_blocks}"{/if}>
    
        <div class="repeater-wrapper-header">
            <div class="drag-panel-blank"></div>
        {foreach $sub_fields as $field_def}
            <div>{$field_def->get_field_label()}</div>
        {/foreach}
            <div class="right-panel-blank"></div>
        </div>

        <div class="repeater-wrapper-template" style="display:none;">
            <div class="drag-panel">
                <span class="ecb2-icon-grip-dots-vertical-solid"></span>
            </div>
        {foreach $sub_fields as $field_def}
            {$field_def->get_content_block_input()}
        {/foreach}
            <div class="right-panel">
                <button class="ecb2-repeater-remove ecb2-btn ecb2-btn-default ecb2-icon-only" data-repeater="#{$block_name}-repeater" title="{$mod->Lang('remove_line')}" role="button" aria-disabled="false"><span class="ecb2-icon-trash-can-regular"></span></button>
            </div>
        </div>

        <button class="ecb2-repeater-add ecb2-btn ecb2-btn-default" data-repeater="#{$block_name}-repeater" title="{$mod->Lang('add_line')}" role="button" {if !empty($max_blocks) && $values|count>=$max_blocks} disabled aria-disabled="true"{else}aria-disabled="false"{/if}><span class="ecb2-icon-plus"></span>&nbsp;&nbsp;{$mod->Lang('add_item')}</button>


    {foreach $values as $row => $fields}
        <div class="repeater-wrapper">
            <div class="drag-panel">
                <span class="ecb2-icon-grip-dots-vertical-solid"></span>
            </div>

        {foreach $sub_fields as $field_def}
            {$field_def->set_sub_field_value($fields, $row)}
            {$field_def->get_content_block_input()}
        {/foreach}

            <div class="right-panel">
                <button class="ecb2-repeater-remove ecb2-btn ecb2-btn-default ecb2-icon-only" data-repeater="#{$block_name}-repeater" title="{$mod->Lang('remove_line')}" role="button" aria-disabled="false"><span class="ecb2-icon-trash-can-regular"></span></button>
            </div>
        </div>
    {/foreach}

    </div>        


