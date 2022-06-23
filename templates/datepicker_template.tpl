{* datepicker_template.tpl - v1.0 - 18Jan22 

***************************************************************************************************}
{*if !$is_datepicker_lib_load}
        <script src="{$timepicker_addon_js_url}"></script>
{/if*}
{if !empty($description)}
        {$description}
{/if}
        {strip}
        <input type="text" class="{$class}"  name="{$block_name}" size="{$size}" maxlength="{$max_length}" 
            value="{$value}"
            {if !empty($time_format)} data-time-format="{$time_format}"{/if}
            {if !empty($date_format)} data-date-format="{$date_format}"{/if}
            {if !empty($time_format)} data-time-format="{$time_format}"{/if}
            {if !empty($change_month)} data-change-month="{$change_month}"{/if}
            {if !empty($change_year)} data-change-year="{$change_year}"{/if}
            {if !empty($year_range)} data-year-range="{$year_range}"{/if}
        />
        {/strip}
