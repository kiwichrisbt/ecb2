{* colorpicker_template.tpl - v1.0 - 24Mar22 

***************************************************************************************************}
{*if !$is_colorpicker_lib_load}
        <script src="{$colorpicker_addon_js_url}"></script>
{/if*}
{if !empty($description)}
        {$description}
{/if}
        {strip}
        <input class="{$class}" type="text" name="{$block_name}" id="{$alias}" size="{$size}" value="{$value}"
            {if !empty($no_hash)} data-no-hash="{$no_hash}"{/if}
        />
        {/strip}
