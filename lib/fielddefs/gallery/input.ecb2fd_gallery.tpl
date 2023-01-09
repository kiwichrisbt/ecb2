{* input.ecb2fd_gallery.tpl - v1.0 - 25Jun22 

***************************************************************************************************}
{if !empty($description)}
        {$description}<br>
{/if}

<div class="ecb2-dropzone dropzone-previews" data-dropzone-url="{$action_url}" data-block-name="{$block_name}" data-location="{$location}" data-dropzone-values="{$json_filenames|cms_escape}" data-dropzone-thumbnail-width="{$thumbnail_width}" data-dropzone-thumbnail-height="{$thumbnail_height}" data-dropzone-thumbnail-prefix="{$thumbnail_prefix}"{if $resize_width} data-dropzone-resize-width="{$resize_width}"{/if}{if $resize_height} data-dropzone-resize-height="{$resize_height}"{/if}{if $resize_method} data-dropzone-resize-method="{$resize_method}"{/if}{if $max_files>0} data-dropzone-max-files="{$max_files}"{/if} data-dropzone-max-files-text="{$max_files_text}" data-highest-row="{$values|@count}">
    <div class="fallback ecb2-fallback">
        <input name="file" type="file" multiple />
    </div>

    <div class="dropzone-preview-template">
        <div class="dz-preview dz-file-preview" style="display:none;" data-row="">
            <input id="" name="" class="dz-input-filename" type="hidden" value=""/>
            <div class="dz-image" style="{if $thumbnail_width}width:{$thumbnail_width}px;{/if}{if $thumbnail_height} height:{$thumbnail_height}px;{/if}">
                <img data-dz-thumbnail="">
            </div>  
            <div class="dz-details">
                <div class="dz-filename"><span data-dz-name></span></div>
                <div class="dz-size" data-dz-size></div>
            </div>
            <button class="dz-remove ecb2-btn ecb2-btn-default" data-dz-remove title="Remove image" role="button" aria-disabled="false"><span class="ecb2-icon-trash-can-regular"></span></button>
            <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>
            <div class="dz-success-mark"><i class="ecb2-icon-check"></i></div>
            <div class="dz-error-mark"><i class="ecb2-icon-xmark"></i></div>
            <div class="dz-error-message"><span data-dz-errormessage></span></div>
        </div>
    </div>

    <div class="dz-upload-prompt ecb2-btn ecb2-btn-default" style="{if $thumbnail_height} height:{$thumbnail_height}px;{/if}" title="Drop images here or click to upload">
        <span class="ecb2-icon-plus"></span>
        <input id="" name="{$block_name}[empty]" class="dz-input-filename" type="hidden" value=""/>{* force input array even if empty *}
    </div>

</div>


