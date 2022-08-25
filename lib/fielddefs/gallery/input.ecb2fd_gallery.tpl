{* input.ecb2fd_gallery.tpl - v1.0 - 25Jun22 

***************************************************************************************************}
{if !empty($description)}
        {$description}<br>
{/if}

<div class="ecb2-dropzone dropzone-previews" data-dropzone-url="{$action_url}" data-block-name="{$block_name}" data-dropzone-values="{$json_values|cms_escape}">
    <div class="fallback ecb2-fallback">
        <input name="file" type="file" multiple />
    </div>

    <input type="hidden" class="type" name="{$block_name}[type]" value="{$type}"/>
    <input type="hidden" class="location" name="{$block_name}[location]" value="{$location}"/>

    <div class="dropzone-preview-template">
        <div class="dz-preview dz-file-preview" style="display:none;">
            <input id="" name="" class="dz-input-filename" type="hidden" value=""/>
            <div class="dz-image">
                <img data-dz-thumbnail="">
            </div>  
            <div class="dz-details">
                <div class="dz-filename"><span data-dz-name></span></div>
                <div class="dz-size" data-dz-size></div>
            </div>
            <div class="dz-remove" data-dz-remove><i class="ecb2-icon-trash-regular"></i></div>
            <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>
            <div class="dz-success-mark"><i class="ecb2-icon-check"></i></div>
            <div class="dz-error-mark"><i class="ecb2-icon-xmark"></i></div>
            <div class="dz-error-message"><span data-dz-errormessage></span></div>
        </div>
    </div>

</div>


