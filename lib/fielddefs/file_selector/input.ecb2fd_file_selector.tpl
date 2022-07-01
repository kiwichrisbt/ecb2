{* input.ecb2fd_file_selector.tpl - v1.0 - 25Jun22 

***************************************************************************************************}
{if !empty($description)}
        {$description}<br>
{/if}
        <div class="ecb_file_selector_select">
            <select class="cms_dropdown" name="{$block_name}">
                {html_options options=$opts selected=$value}
            </select>
        </div>
{if $preview}      
        <img style="max-width:130px;" class="file_selector_preview" data-uploadsurl="{$uploads_url}" {if isset($value)}src="{$uploads_url}/{$value}"{/if} alt="{$block_name}">
{/if}
