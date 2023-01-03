<?php
#---------------------------------------------------------------------------------------------------
# Module: ECB2 - Extended Content Blocks 2
# Author: Chris Taylor
# Copyright: (C) 2016 Chris Taylor, chris@binnovative.co.uk
# Licence: GNU General Public License version 3
#          see /ECB2/lang/LICENCE.txt or <http://www.gnu.org/licenses/>
#---------------------------------------------------------------------------------------------------


class ecb2fd_group extends ecb2_FieldDefBase 
{

	public function __construct($mod, $blockName, $id, $value, $params, $adding) 
	{	
		parent::__construct($mod, $blockName, $id, $value, $params, $adding);

	}



    /**
     *  sets the allowed parameters for this field type
     *
     *  $this->default_parameters - array of parameter_names => [ default_value, filter_type ]
     *      FILTER_SANITIZE_STRING, FILTER_VALIDATE_INT, FILTER_VALIDATE_BOOLEAN, FILTER_SANITIZE_EMAIL 
     *      see: https://www.php.net/manual/en/filter.filters.php
     *  $this->restrict_params - optionally allow any other parameters to be included, e.g. module calls
     */
    public function set_field_parameters() 
    {
        $this->default_parameters = [
            'max_blocks'    => ['default' => 0,       'filter' => FILTER_VALIDATE_INT],
            'layout'        => ['default' => 'table', 'filter' => FILTER_SANITIZE_STRING],
            'description'   => ['default' => '',      'filter' => FILTER_SANITIZE_STRING],
            'assign'        => ['default' => '',      'filter' => FILTER_SANITIZE_STRING]
        ];
        // $this->parameter_aliases = [ 'alias' => 'parameter' ];
        $this->restrict_params = FALSE;    // default: true
        $this->use_json_format = TRUE;     // default: FALSE - can override e.g. 'groups' type
        $this->allowed_sub_fields = [
            'textinput',
            'textarea',
            'dropdown',
            'checkbox',
            'radio',
            'color_picker',
            'date_time_picker',
            'file_selector',
            'page_picker',
            'gallery_picker',
            'module_picker'     
        ];
        $this->sub_fields_ignored_params = [
            'assign',
            'repeater',
            'max_blocks'
        ];
        $this->layout_options = ['table','block'];  // block, grid ...


    }



    /**
     *  some extra tweaks to options in addition to standard initialisation (FieldDefBase)
     */
    protected function initialise_options($params)
    {
		parent::initialise_options($params);

        if ( !in_array($this->options['layout'], $this->layout_options) ) {
            $this->options['layout'] = $this->default_parameters['layout']['default'];
        }

    }



    /**
     *  @return string complete content block 
     */
    public function get_content_block_input() 
    {
        if ( empty($this->values) ) $this->values[] = NULL;

        if ($this->error) return $this->mod->error_msg($this->error);

        $smarty = \CmsApp::get_instance()->GetSmarty();
        $tpl = $smarty->CreateTemplate( 'string:'.$this->get_template(), null, null, $smarty );
        $tpl->assign( 'block_name', $this->block_name );
        $tpl->assign( 'value', $this->value );
        $tpl->assign( 'mod', $this->mod );
        $tpl->assign( 'block_name', $this->block_name );
        $tpl->assign( 'type', $this->field );
        $tpl->assign( 'values', $this->values );      // sub_field values
        $tpl->assign( 'sub_fields', $this->sub_fields );
        $tpl->assign( 'max_blocks', $this->options['max_blocks'] );
        $tpl->assign( 'description', $this->options['description'] );
        $tpl->assign( 'layout', $this->options['layout'] );
        $tpl->assign( 'assign', $this->options['assign'] );
        return $tpl->fetch();
   
    }



    /**
     *  Data entered by the editor is processed before its saved in props table
     *  This method,  overides the parent class method, to enable additional processing 
     *  before the data is saved.
     *
     *  @return string formatted json containing all field data ready to be saved & output
     */
    public function get_content_block_value( $inputArray ) 
    {

        // if all sub_fields empty then set 'sub_fields' to empty
        if ( !empty($inputArray) && count($inputArray)==1 ) {
            $firstRow = current($inputArray);
            $value_found = FALSE;
            foreach ($firstRow as $value) {
                if ( !empty($value) ) $value_found = TRUE;
            }
            if ( !$value_found ) $inputArray = array('sub_fields' => []);
        }

        $this->field_object = $this->create_field_object( $inputArray );
    
        return $this->ECB2_json_encode_field_object(); 
    }



}