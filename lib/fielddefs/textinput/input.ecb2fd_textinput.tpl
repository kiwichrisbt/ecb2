{* input.ecb2fd_textinput.tpl - v1.0 - 25Jun22 

***************************************************************************************************}
{if !empty($description)}
        {$description}<br>
{/if}
{if !$repeater}
        <input type="text" name="{$block_name}" size="{$size}" maxlength="{$max_length}" value="{$value}"/>

{else}

    <input type="hidden" id="{$block_name}" name="{$block_name}" value="{$value}" size="100"/>

    <div id="{$block_name}-repeater" class="ecb_repeater" data-block-name="{$block_name}">
        <button class="ecb2-repeater-add ecb2-button-inline ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary" data-repeater="#{$block_name}-repeater" title="{$mod->Lang('add_line')}" role="button" aria-disabled="false">+</button>
{foreach $ecb_values as $ecb_id => $ecb_value}
        <div class="repeater-wrapper">
            <input id="repeater-field-{$block_name}-{$ecb_value@iteration}" name="{$block_name}[{$ecb_id}]" class="repeater-field" size="{$size}" maxlength="{$max_length}" value="{$ecb_value}" data-repeater="#{$block_name}-repeater"/>

            <button class="ecb2-repeater-remove ecb2-button-inline ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary" data-repeater="#{$block_name}-repeater" title="{$mod->Lang('remove_line')}" role="button" aria-disabled="false">&minus;</button>
        </div>
{/foreach}
    </div>
{/if}