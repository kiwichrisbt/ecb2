<?php
#---------------------------------------------------------------------------------------------------
# Module: ECB2 - Extended Content Blocks 2
# Author: Chris Taylor
# Copyright: (C) 2016 Chris Taylor, chris@binnovative.co.uk
# Licence: GNU General Public License version 3
#          see /ECB2/lang/LICENCE.txt or <http://www.gnu.org/licenses/>
#---------------------------------------------------------------------------------------------------

abstract class ecb2_FieldDefBase 
{
    protected $mod;
    protected $block_name;
    protected $value;
    protected $adding;
    protected $default_parameters;
    protected $options;
    protected $alias;
    protected $field;
    protected $field_alias_used;
    protected $restrict_params;
    protected $parameter_aliases;
    protected $error;

   

    /**
     * @param string $blockName
     * @param string $value
     * @param array $params
     * @param boolean $adding
     */
    public function __construct($mod, $blockName, $value, $params, $adding) 
    {
        $this->mod = $mod;
        $this->block_name = $blockName;
        $this->value = $value;
        $this->alias = munge_string_to_url($blockName, TRUE);
        $this->adding = $adding;
        $this->field = '';
        $this->default_parameters = [];
        $this->options = [];
        $this->restrict_params = TRUE;
        if ( isset($params['field_alias_used']) ) $this->field_alias_used = $params['field_alias_used'];
        $this->parameter_aliases = [];

        $this->set_field_parameters();
        $this->initialise_options($params);

    }



    /**
     *  ABSTRACT METHODS
     */

    /**
     *  sets the allowed parameters for this field type, $this->parameters & $this->restrict_params
     */
    abstract protected function set_field_parameters();



    /**
     *  get content block
     *  @return string
     */
    abstract public function get_content_block_input();



    /**
     *  COMMON METHODS
     */

    /**
     *  sets all defined 'options' and defaults if necessary
     */
    protected function initialise_options($params)
    {
        $this->field = $params['field'];    // only valid field names can get to here
        unset($params['field']);

        // set defaults
        if ( !empty($this->default_parameters) ) {
            foreach ($this->default_parameters as $default_param => $settings) {
                $this->options[$default_param] = $settings['default'];
            }
        }

        // handle any field aliases
        if ( !empty($this->parameter_aliases) ) {
            foreach ($this->parameter_aliases as $param_alias => $param) {
                if ( isset($params[$param_alias]) && !isset($params[$param]) ) {
                    $params[$param] = $params[$param_alias];
                    unset($params[$param_alias]);
                }
            }
        }
        // $this->parameter_aliases = [ 'alias' => 'parameter' ];

        if ( empty($params) ) return;

        // set cleaned options
        if ($this->restrict_params) {
            // just add pre-defined params
            foreach ($params as $key => $value) {
                if ( isSet($this->options[$key]) && !empty($value) ) {
                    $filter_type = $this->default_parameters[$key]['filter'];
                    $this->options[$key] = filter_var( $value, $filter_type); 
                }
            }
        
        } else {
            // add all params as options - e.g to pass unknown parameters onto modules
            foreach ($params as $key => $value) {
                $this->options[$key] = $value;
            }
        }

        // set default value if adding
        if ( $this->adding && $this->value===NULL && isset($this->options['default_value']) ) {
            $this->value = $this->options['default_value'];
        }

    }



    /**
     *  returns the default input smarty template contents
     *  see LISEFielddefBase for ideas :)
     */
    protected function get_template()
    {
        // default input smarty template filename
        $filename = $this->mod->GetModulePath() .DIRECTORY_SEPARATOR. 'lib' .DIRECTORY_SEPARATOR. 
            'fielddefs' .DIRECTORY_SEPARATOR. $this->field .DIRECTORY_SEPARATOR. 
            $this->mod::INPUT_TEMPLATE_PREFIX . $this->mod::FIELD_DEF_PREFIX . $this->field . '.tpl';

        if (is_readable($filename)) {
            return @file_get_contents($filename);
        }

    }



    /**
     *  @return array $options of 'value' => 'Text'
     *  @param string $module_name
     *  @param array $module_params  - if provided an array of all paramaters to be passed to the module
     *                               - if not provided $this->options is used
     *  @param array $exclude_options - excludes any specified options from being passed to the module
     *
     *         The module call needs to either:
     *                      - set $options array of 'value' => 'Text' with scope=global, or 
     *                      - a comma separated list of 'Text,...' or 'Text=value,...'  
     */
    protected function get_values_from_module($module_name, $module_params=[], $exclude_options=[])
    {
        $module = cms_utils::get_module( $module_name );
        if ( !$module ) return;

        $module_params = [];
        foreach ($this->options as $key => $value) {
            if ( !in_array($key, $exclude_options) && !empty($value) ) $module_params[$key] = $value;
        }
        $cms_module_call = "{cms_module module=".$module_name;
        foreach ($module_params as $key => $value) {
            $cms_module_call .= " $key=$value";
        }

        $smarty = \CmsApp::get_instance()->GetSmarty();
        $module_values = trim(strip_tags($smarty->fetch('string:'.$cms_module_call.'}')));
        $options = $smarty->get_template_vars('options');

        if ( !empty($options) && is_array($options) ) {   // first see if $options array set 
            return $options;
        }
        if ( !empty($module_values) ) {
            return $this->get_array_from_csl( $module_values );
        }

    }


    /**
     *  @return array of 'value' => 'Text'
     *  @param string $comma_separated_list of 'Text' or 'Text=value' e.g. 'Apple=apple,Orange=orange,...'
     */
    protected function get_array_from_csl( $comma_separated_list )
    {
        $value_options = [];
        if ( !empty($comma_separated_list) ) {
            $tmpOptions = explode(',', $comma_separated_list);
            foreach ($tmpOptions as $opt) {
                $key_val = explode('=', $opt);
                if ( count($key_val)>1 ) {
                    $value_options[$key_val[1]] = $key_val[0];
                } else {
                    $value_options[$key_val[0]] = $key_val[0];
                }
            }    
        }
        return $value_options;
    }



    /**
     *  @return array $this->options[values] to the result of a call to module $module_name
     *  @param string $udt_name - udt needs to return either:
     *                      - an array of 'Text' => 'value' - don't ask it's a legacy thing!
     *                      - a comma separated list of 'Text,...' or 'Text=value,...'                            
     */
    protected function get_values_from_udt($udt_name)
    {
        if (!UserTagOperations::get_instance()->UserTagExists($this->options['udt'])) {
            $this->error = $this->mod->Lang('udt_error', $this->options['udt']);
            return;
        }
        $tmp = [];
        $value_options = UserTagOperations::get_instance()->CallUserTag($this->options['udt'], $tmp);
        if ( !$value_options ) {
            $value_options = [];

        } elseif ( !is_array($value_options) ) {    // convert csl string into array
            $value_options = $this->get_array_from_csl($value_options);

        }
        return array_flip($value_options);  // for legacy compatibility
    }



    /**
     *  @return array $options array of 'value' => 'Text'
     *  @param string $template_name - template needs to either:
     *                      - set $options array of 'value' => 'Text' with scope=global, or 
     *                      - a comma separated list of 'Text,...' or 'Text=value,...'                            
     */
    protected function get_values_from_template($template_name)
    {
        $smarty = \CmsApp::get_instance()->GetSmarty();

        if ( !$smarty->templateExists('cms_template:'.$template_name) ) {
            $this->error = $this->mod->Lang('template_error', $template_name);
            return;
        }

        $template_values = trim( $smarty->fetch( 'cms_template:'.$template_name ) );
        $options = $smarty->get_template_vars('options');

        if ( !empty($options) && is_array($options) ) {   // first see if $options array set 
            return $options;
        }
        if ( !empty($template_values) ) {
            return $this->get_array_from_csl( $template_values );
        }

    }


    /**
     *  @return array $options array of 'value' => 'Text'
     *  @param string $customgs_field - needs to be a 'textarea' containing a set of 'Text' or 'Text=value',
     *      either on separate lines or separated by commas
     */
    protected function get_values_from_customgs($customgs_field)
    {
        $CustomGS = cms_utils::get_module('CustomGS');
        if ( !is_object($CustomGS) ) {
            $this->error = $this->mod->Lang('module_error', 'Custom Global Settings');
            return;
        }

        $CGS_field = $CustomGS->GetField( $customgs_field );
        if ( empty($CGS_field['value']) ) {
            $this->error = $this->mod->Lang('customgs_field_error', $customgs_field);
            return;
        } 
        
        // replace any newlines with commas to separate each title-value pair
        $CGS_field = str_replace(PHP_EOL, ',', $CGS_field['value']);
        return $this->get_array_from_csl( $CGS_field );
    }


}