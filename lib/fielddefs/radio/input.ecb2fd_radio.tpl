{* input.ecb2fd_radio.tpl - v1.0 - 25Jun22 

***************************************************************************************************}
{if !empty($description)}
        {$description}<br>
{/if}
        {html_radios name=$block_name options=$options separator=$separator selected=$value} 