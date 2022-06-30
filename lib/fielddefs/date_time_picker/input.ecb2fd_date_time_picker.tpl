{* input.ecb2fd_date_time_picker.tpl - v1.0 - 25Jun22 

***************************************************************************************************}
{if !empty($description)}
        {$description}<br>
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