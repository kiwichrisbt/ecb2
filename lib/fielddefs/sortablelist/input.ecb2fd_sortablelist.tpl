{* input.ecb2fd_textinput.tpl - v1.0 - 25Jun22 

***************************************************************************************************}
{if !empty($description)}
        {$description}<br>
{/if}
        <input type="text" name="{$block_name}" size="{$size}" maxlength="{$max_length}" value="{$value}"/>
