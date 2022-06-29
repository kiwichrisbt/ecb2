{* ECB2 _help.tpl *}


<div class="clear"></div>

<div id="page_tabs">
    <div id="ecb">
        {$mod->Lang('extended_content_blocks')}
    </div>
    <div id="fields">
        {$mod->Lang('fields')}
    </div>
    <div id="about">
        {$mod->Lang('about')}
    </div>
</div>

<div class="clearb"></div>

<div id="page_content" class="ecb2-help">

    <div id="ecb_c">
        <div class="help-toc">
            <h3 class="border-bottom m_top_15 p_bottom_5">{$mod->Lang('field_types')}</h3>
            <ul>
            {foreach $field_types as $field_type}
                <ul><a class="smooth-scroll" href="#{$field_type}">{$field_type}</a></ul>   
            {/foreach}
            </ul>
        </div>

        <div class="help-content">
            {$mod->Lang('general_c')}
            
            <h2 class="border-bottom p_bottom_5 m_bottom_15">{$mod->Lang('field_types')}</h2>

        {foreach $field_help as $field_type => $help_content}
            <h2 id="{$field_type}" class="m_bottom_5">{$field_type}</h2>
            {eval var=$help_content}
            <br>
        {/foreach}
        </div>

   </div>

   <div id="fields_c">
      <div class="pageoverflow">
         {$mod->Lang('fields_c')}
      </div>
   </div>

   <div id="about_c">
      <div class="pageoverflow">
         {$mod->Lang('about_c')}
      </div>
   </div>

</div>
<br>


