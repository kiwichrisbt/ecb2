{* help.ecb2fd_fieldset_start.tpl *}
<p>Creates the start of a fieldset for grouping relavant admin fields together. Note: a matching 'fieldset_end' block is required for each fieldset_start.</p>

<pre>{literal}{content_module module=ECB2 field=fieldset_start block="test" label="15: fieldset_start"}{/literal}</pre>

<p>TIP: set label='&nbsp;' to not show the field label.</p>

<p>Parameters:</p>
<ul>
    <li>field (required) - 'fieldset_start'</li>
    <li>legend (optional) - text to show as fieldset legend - default: ''</li>
    <li>description (optional) - adds additional text explanation for editor</li>
</ul>