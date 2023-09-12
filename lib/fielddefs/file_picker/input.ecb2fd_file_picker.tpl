{* input.ecb2fd_file_picker.tpl - v1.0 - 25Jun22 

    Note: Existing file_picker files are initiated using the normal cms_filepicker tag.
          Any newly added rows (groups) have the file_picker input initiated by the ecb js.

***************************************************************************************************}
{if !empty($description)}
        {$description}<br>
{/if}

    <div class="ecb_file_picker">
{if $is_sub_field}
    {if is_null($sub_row_number)}{* sub_field template field *}
        <input type="text" name="" value="{$value}" class="repeater-field ecb2-file-picker-template" data-repeater="#{$block_name}-repeater" data-field-name="{$block_name}" data-cmsfp-instance="" data-fp-profile="{$profile_sig}" data-lang-clear="{$lang_clear}" size="80"/>

    {else}{* sub_field *}
        {cms_filepicker id=$subFieldId name=$subFieldName value=$value profile=$profile top=$top type=$type}

    {/if}

{else}
        {cms_filepicker name=$block_name value=$value profile=$profile top=$top type=$type}

{/if}

{if $preview}
        <img class="ecb_file_picker_preview {if !empty($thumbnail_url)}show{/if}" {if !empty($thumbnail_url)}src="{$thumbnail_url}?{$smarty.now}"{/if} alt="{$block_name}" data-ajax-url="{$ajax_url}" data-top-dir="{$top_dir}" data-thumbnail-width="{$thumbnail_width}" data-thumbnail-height="{$thumbnail_height}">
{/if}
    </div>