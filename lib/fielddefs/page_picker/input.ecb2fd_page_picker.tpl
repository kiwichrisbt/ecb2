{* input.ecb2fd_page_picker.tpl - v1.0 - 25Jun22 

***************************************************************************************************}
{if !empty($description)}
        {$description}<br>
{/if}
{if $is_sub_field}
    {if is_null($sub_row_number)}{* output template field *}
        <input type="hidden" id="" name="" class="{$class}" value="-1" data-repeater="#{$block_name}-repeater" data-field-name="{$block_name}"/>

    {else}
        {page_selector id=$subFieldId name=$subFieldName value=$value allowcurrent=$allowcurrent
allow_all=$allow_all}{* class not supported - use js to add *}
    {/if}

{else}
        {page_selector name=$block_name value=$value allowcurrent=$allowcurrent allow_all=$allow_all}

{/if}