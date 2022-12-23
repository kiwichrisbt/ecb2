{* input.ecb2fd_dropdown.tpl - v1.0 - 27Jun22 

    Note: $selected_values is an array supplied when select is multiple
          $options array of: $text => $value

***************************************************************************************************}
{if !empty($description)}
        {$description}<br>
{/if}

{if $is_sub_field}
    {if $multiple}
        <div class="ecb_multiple_select cms_dropdown {if $compact}ecb_compact{/if}">
        {if $compact}
            {$none_selected=$mod->Lang('none_selected')}
            <div class="ecb_select_summary">
                <span class="ecb_select_text" data-empty="{$none_selected}">{$selected_text|default:$none_selected}</span>
                &nbsp;<a class="ecb_select_edit" href="edit/hide"></a>
            </div>
        {/if}
            <input type="hidden" id="{if $not_sub_field_template}{$sub_parent_block}_r_{$sub_row_number}_{$block_name}{/if}" class="ecb_select_input repeater-field" name="{if $not_sub_field_template}{$sub_parent_block}[r_{$sub_row_number}][{$block_name}]{/if}" value="{if $not_sub_field_template}{$value}{/if}" data-repeater="#{$sub_parent_block}-repeater" data-field-name="{$block_name}"/>
            <select class="cms_dropdown" name="{if $not_sub_field_template}{$sub_parent_block}[r_{$sub_row_number}][{$block_name}]_tmp{/if}" multiple size="{$size}">
            {foreach $options as $value => $text}
                <option value="{$value}" {if $value|in_array:$selected_values}selected{/if}>{$text|default:$value}</option>
            {/foreach}
            </select>
        </div>
    {else}

        <select id="{if $not_sub_field_template}{$sub_parent_block}_r_{$sub_row_number}_{$block_name}{/if}" class="cms_dropdown repeater-field" name="{if $not_sub_field_template}{$sub_parent_block}[r_{$sub_row_number}][{$block_name}]{/if}" data-repeater="#{$sub_parent_block}-repeater" data-field-name="{$block_name}">
        {foreach $options as $value => $text}
            <option value="{$value}" {if $selected==$value}selected{/if}>{$text}</option>
        {/foreach}
        </select>
    {/if}


{else}{* not $is_sub_field *}
    {if $multiple}
        <div class="ecb_multiple_select cms_dropdown {if $compact}ecb_compact{/if}">
        {if $compact}
            {$none_selected=$mod->Lang('none_selected')}
            <div class="ecb_select_summary">
                <span class="ecb_select_text" data-empty="{$none_selected}">{$selected_text|default:$none_selected}</span>
                &nbsp;<a class="ecb_select_edit" href="edit/hide"></a>
            </div>
        {/if}
            <input type="hidden" id="{$block_name}" class="ecb_select_input" name="{$block_name}" value="{$selected}" />
            <select class="cms_dropdown" name="{$block_name}_tmp" multiple size="{$size}">
            {foreach $options as $value => $text}
                <option value="{$value}" {if $value|in_array:$selected_values}selected{/if}>{$text|default:$value}</option>
            {/foreach}
            </select>
        </div>
    {else}

        <select class="cms_dropdown" name="{$block_name}">
        {foreach $options as $value => $text}
            <option value="{$value}" {if $selected==$value}selected{/if}>{$text}</option>
        {/foreach}
        </select>
    {/if}
{/if}