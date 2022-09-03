<?php
#---------------------------------------------------------------------------------------------------
# Module: ECB2 - Extended Content Blocks 2
# Author: Chris Taylor
# Copyright: (C) 2016 Chris Taylor, chris@binnovative.co.uk
# Licence: GNU General Public License version 3
#          see /ECB2/lang/LICENCE.txt or <http://www.gnu.org/licenses/>
#---------------------------------------------------------------------------------------------------


class ecb2fd_module_picker extends ecb2_FieldDefBase 
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
        $this->parameter_aliases = [
            'default_value' => 'default'
        ];
        $this->default_parameters = [
            'text'          => ['default' => '',    'filter' => FILTER_SANITIZE_STRING],
            'link'          => ['default' => '',    'filter' => FILTER_SANITIZE_STRING],
            'default'       => ['default' => '',    'filter' => FILTER_SANITIZE_STRING], 
            'description'   => ['default' => '',    'filter' => FILTER_SANITIZE_STRING]
        ];
        // $this->parameter_aliases = [ 'alias' => 'parameter' ];
        // $this->restrict_params = FALSE;    // default: true

    }


    /**
     *  @return string complete content block 
     */
    public function get_content_block_input() 
    {
        $modops = cmsms()->GetModuleOperations();
        $modules = $modops->GetInstalledModules();
        $modulesarray = ['' => $this->mod->Lang('none_selected') ];
        foreach ($modules as $module) {
            $mod = cms_utils::get_module($module);
            if (is_object($mod)) {
                $name = $mod->GetFriendlyName();
                $modulesarray[$module] = ($name) ? $name : $module;
            }
        }
        if (class_exists('Collator')) {
            $coll = new Collator('en_US'); // TODO default locale always ok?
            uksort($modulesarray, function($a, $b) use ($coll) {
                return collator_compare($coll, $a, $b);
            });
        }
    
        $smarty = \CmsApp::get_instance()->GetSmarty();
        $tpl = $smarty->CreateTemplate( 'string:'.$this->get_template(), null, null, $smarty );
        $tpl->assign('block_name', $this->block_name );
        $tpl->assign('value', $this->value );
        $tpl->assign('modulesarray', $modulesarray );
        $tpl->assign('description', $this->options['description'] );
        return $tpl->fetch();
   
    }


}