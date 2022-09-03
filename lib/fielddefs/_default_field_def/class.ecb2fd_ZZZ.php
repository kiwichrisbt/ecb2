<?php
#---------------------------------------------------------------------------------------------------
# Module: ECB2 - Extended Content Blocks 2
# Author: Chris Taylor
# Copyright: (C) 2016 Chris Taylor, chris@binnovative.co.uk
# Licence: GNU General Public License version 3
#          see /ECB2/lang/LICENCE.txt or <http://www.gnu.org/licenses/>
#---------------------------------------------------------------------------------------------------


class ecb2fd_ZZZ extends ecb2_FieldDefBase 
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
            ''              => ['default' => '',    'filter' => FILTER_SANITIZE_STRING],
            ''              => ['default' => '',    'filter' => FILTER_SANITIZE_STRING],
            'default_value' => ['default' => '',    'filter' => FILTER_SANITIZE_STRING], 
            'description'   => ['default' => '',    'filter' => FILTER_SANITIZE_STRING]
        ];
        // $this->parameter_aliases = [ 'alias' => 'parameter' ];
        // $this->restrict_params = FALSE;    // default: true
        // $this->use_json_format = TRUE;     // default: FALSE - can override e.g. 'groups' type

    }


    /**
     *  @return string complete content block 
     */
    public function get_content_block_input() 
    {



    
        $smarty = \CmsApp::get_instance()->GetSmarty();
        $tpl = $smarty->CreateTemplate( 'string:'.$this->get_template(), null, null, $smarty );
        $tpl->assign('block_name', $this->block_name );
        $tpl->assign('value', $this->value );


        $tpl->assign('description', $this->options['description'] );
        return $tpl->fetch();
   
    }



    // /**
    //  *  Data entered by the editor is processed before its saved in props table
    //  *  This method, if required, overides the parent class method, to enable additional processing 
    //  *  before the data is saved.
    //  *  Can be omitted and ecb2_FieldDefBase will handle default processing
    //  *
    //  *  @return string formatted json containing all field data ready to be saved & output
    //  */
    // public function get_content_block_value( $inputArray ) 
    // {
    //     $this->set_field_object( $inputArray );
    //
    //     // do other stuff here
    //
    //     return $this->ECB2_json_encode_field_object(); 
    // }



}