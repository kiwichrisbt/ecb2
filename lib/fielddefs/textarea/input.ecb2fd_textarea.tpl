{* input.ecb2fd_textarea.tpl - v1.0 - 25Jun22 

***************************************************************************************************}
{if !empty($description)}
        {$description}<br>
{/if}
{*if $wysiwyg}
        {cms_textarea name=$block_name enablewysiwyg=$wysiwyg rows=$rows cols=$cols value=$value}
{else}
        <textarea name="{$block_name}" rows="{$rows}" cols="{$cols}">{$value}</textarea>
{/if*}


{* NEW WITH REPEATER *}

{if !$repeater && !$use_json_format}
        {cms_textarea name=$block_name enablewysiwyg=$wysiwyg rows=$rows cols=$cols value=$value}

{elseif !$repeater && $use_json_format}
        {* <input type="hidden" name="{$block_name}[type]" value="{$type}"/> *}
        {cms_textarea name="$block_name[]" enablewysiwyg=$wysiwyg rows=$rows cols=$cols value=$values[0]}

{else}{* $repeater *}
    {if empty($assign) && $field_alias_used!='input_repeater'}
        <div class="pagewarning">
            {$mod->Lang('error_assign_required')}
        </div><br>
    {/if}

        {* <input type="hidden" name="{$block_name}[type]" value="{$type}"/> *}
        
        <div id="{$block_name}-repeater" class="ecb_repeater sortable {if $wysiwyg}wysiwyg{/if}" data-block-name="{$block_name}" data-highest-row="{$values|@count}" {if $max_blocks>0}data-max-blocks="{$max_blocks}"{/if}>

            <div class="repeater-wrapper-template" style="display:none;">
                <div class="drag-panel">
                    <span class="ecb2-icon-grip-dots-vertical-solid"></span>
                </div>
                <textarea id="" name="" class="repeater-field" cols="{$cols}" rows="{$rows}" data-repeater="#{$block_name}-repeater" style="display:none;"></textarea>
                <div class="right-panel">
                    <button class="ecb2-repeater-remove ecb2-btn ecb2-btn-default ecb2-icon-only" data-repeater="#{$block_name}-repeater" title="{$mod->Lang('remove_line')}" role="button" aria-disabled="false"><span class="ecb2-icon-trash-can-regular"></span></button>
                </div>
            </div>

            <button class="ecb2-repeater-add ecb2-btn ecb2-btn-default" data-repeater="#{$block_name}-repeater" title="{$mod->Lang('add_line')}" role="button" {if !empty($max_blocks) && $values|count>=$max_blocks} disabled aria-disabled="true"{else}aria-disabled="false"{/if}><span class="ecb2-icon-plus"></span>&nbsp;&nbsp;{$mod->Lang('add_item')}</button>

        {foreach $values as $value}
            <div class="repeater-wrapper">
                <div class="drag-panel">
                    <span class="ecb2-icon-grip-dots-vertical-solid"></span>
                </div>
                {cms_textarea id="{$block_name}_r_{$value@iteration}" name="{$block_name}[r_{$value@iteration}]" class="repeater-field" enablewysiwyg=$wysiwyg rows=$rows cols=$cols value=$value addtext="data-repeater=\"#{$block_name}-repeater\""}
                <div class="right-panel">
                    <button class="ecb2-repeater-remove ecb2-btn ecb2-btn-default ecb2-icon-only" data-repeater="#{$block_name}-repeater" title="{$mod->Lang('remove_line')}" role="button" aria-disabled="false"><span class="ecb2-icon-trash-can-regular"></span></button>
                </div>
            </div>
        {/foreach}

        </div>

{/if}