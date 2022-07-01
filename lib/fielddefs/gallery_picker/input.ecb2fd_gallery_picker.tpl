{* input.ecb2fd_gallery_picker.tpl - v1.0 - 25Jun22 

***************************************************************************************************}
{if !empty($description)}
        {$description}<br>
{/if}
        {html_options name=$block_name options=$galleryArray selected=$value}
{*  $this->options['description'].$mod->CreateInputDropdown('', $this->block_name, $galleryArray, -1, $this->value);*}

