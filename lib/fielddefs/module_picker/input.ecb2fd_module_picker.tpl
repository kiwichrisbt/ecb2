{* input.ecb2fd_module_picker.tpl - v1.0 - 25Jun22 

***************************************************************************************************}
{if !empty($description)}
        {$description}<br>
{/if}
        {html_options name=$block_name options=$modulesarray selected=$value}
