{* input.ecb2fd_file_selector.tpl - v1.0 - 25Jun22 

***************************************************************************************************}
{if !empty($description)}
        {$description}<br>
{/if}

    <div class="ecb_file_selector">
    {if $is_sub_field}
        {if is_null($sub_row_number)}{* output template field *}
            <select id="" name="" class="{$class}" data-repeater="#{$block_name}-repeater" data-field-name="{$block_name}">
                {html_options options=$opts selected=$value}
            </select>

        {else}    
            <select id="{$subFieldId}" name="{$subFieldName}" class="{$class}">
                {html_options options=$opts selected=$value}
            </select>
        {/if}

    {else}
            <select class="cms_dropdown" name="{$block_name}">
                {html_options options=$opts selected=$value}
            </select>
    {/if}

{* {if $preview}      
        <img style="max-width:130px;" class="ecb_file_selector_preview {if !empty($value)}show{/if}" {if !empty($value)}src="{$uploads_url}/{$value}"{/if} alt="{$block_name}" data-uploadsurl="{$uploads_url}" data-supported-extensions="{$supported_extensions}">
{/if} *}

    {if $preview}
        <img class="ecb_file_selector_preview {if !empty($thumbnail_url)}show{/if}" {if !empty($thumbnail_url)}src="{$thumbnail_url}?{$smarty.now}"{/if} alt="{$block_name}" data-ajax-url="{$ajax_url}" data-top-dir="{$top_dir}" data-thumbnail-width="{$thumbnail_width}" data-thumbnail-height="{$thumbnail_height}">
    {/if}

    </div>


