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
    protected $id;
    protected $field;
    protected $value;               // used when using single string values ECB2 v1 format
    protected $values;              // used when json format 
    protected $sub_fields;          // when multiple fields of different types
    protected $field_object;        // stdClass object that contains all values for saving
    protected $adding;
    protected $default_parameters;
    protected $options;
    protected $alias;
    protected $restrict_params;
    protected $field_alias_used;
    protected $parameter_aliases;
    protected $demo_count;
    protected $error;
    protected $is_sub_field;
    protected $sub_parent_block;
    protected $sub_row_number;
    protected $sub_fields_ignored_params;
    protected $cached_template;
    
    public $use_json_format;
    public $allowed_sub_fields;
   

    /**
     *  @param string $mod - ECB2 module class
     *  @param string $blockName
     *  @param string $id - content page id (poss module item id - in the future)
     *  @param string $value
     *  @param array $params
     *  @param boolean $adding
     */
    public function __construct($mod, $blockName, $value, $params, $adding, $id=0) 
    {
        $this->mod = $mod;
        $this->block_name = $blockName;
        $this->id = $id;
        $this->value = NULL;
        $this->values = [];
        $this->sub_fields = NULL;
        $this->field_object = NULL;
        $this->alias = munge_string_to_url($blockName, TRUE);
        $this->adding = $adding;
        $this->field = '';
        $this->default_parameters = [];
        $this->options = [];
        $this->restrict_params = TRUE;
        $this->allowed_sub_fields = [];
        $this->is_sub_field = FALSE;
        $this->sub_parent_block = '';
        $this->sub_row_number = NULL;
        $this->sub_fields_ignored_params = [];
        if ( isset($params['field_alias_used']) ) {
            $this->field_alias_used = $params['field_alias_used'];
        }
        $this->parameter_aliases = [];
        $this->demo_count = 0;
        $this->use_json_format = FALSE;     // single value stored as string ECB2 v1 format for simple fields
        //   once stored as json always stored as jason (output as object not string)
        if ( !empty($params['repeater']) ) $this->use_json_format = TRUE;

        $json_data = json_decode($value);
        if ( json_last_error()===JSON_ERROR_NONE && !is_integer($json_data) ) {
            // JSON is valid - either use $json_data->values OR $json_data->sub_fields - NOT both!
            $this->json_data = $json_data;
            $this->use_json_format = TRUE;
            if ( !empty($json_data->values) ) {
                $this->values = $json_data->values;  
            } elseif ( !empty($json_data->sub_fields) ) {
                $this->values = $json_data->sub_fields;
            }

        } elseif ( $this->use_json_format ) { // but JSON not valid
            $this->values[] = $value;

        } else { // single string value
            $this->value = $value;

        }

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
        if ( $this->adding && isset($this->options['default']) ) {
            if ( $this->use_json_format && empty($this->values[0])) {
                $this->values[0] = $this->options['default'];
            } elseif ( empty($this->value) ) {
                $this->value = $this->options['default'];
            }
        }

    }



    /**
     *  create a set of sub_fields from Content Block subX_params ...
     *  sets $this->sub_fields with array of sub_field ecb2_FieldDef's
     *  @param array $params - all Content Block params
     */
    public function create_sub_fields($params)
    {
        $sub_params = [];
        $sub_field_list = [];
        // get all sub_params that specify sub_fields options
        foreach ($params as $key => $value) {
            if ( preg_match('/^sub([0-9]*)_([A-Za-z0-9_]+)/', $key, $matches) ) {
                $sub_params[$matches[1]][$matches[2]] = $value;
            }
        }

        foreach ($sub_params as $sub_field_params) {
            // handle Sub Field Aliases
            if ( isset($sub_field_params['field']) && 
                 !in_array($sub_field_params['field'], $this->mod::FIELD_TYPES) && 
                 array_key_exists($sub_field_params['field'], $this->mod::FIELD_ALIASES) ) 
            {
                $sub_field_params['field_alias_used'] = $sub_field_params['field'];
                $sub_field_params['field'] = $this->mod::FIELD_ALIASES[$sub_field_params['field']];
            }

            // test for valid field type & name
            if ( !isset($sub_field_params['field']) ) {
                $this->error = $this->mod->Lang('error_sub_field_type_missing');
                return;  
            }
            if ( !in_array($sub_field_params['field'], $this->allowed_sub_fields) ) {
                $this->error = $this->mod->Lang('error_sub_field_type_not_allowed', $sub_field_params['field']);
                return;  
            } 
            if ( !isset($sub_field_params['name']) ) {
                $this->error = $this->mod->Lang('error_sub_field_name_missing', $sub_field_params['field']);
                return;  
            } 
            if ( !preg_match('/^[A-Za-z][A-Za-z0-9_]*/', $sub_field_params['name']) ) {
                $this->error = $this->mod->Lang('error_sub_field_name_format', $sub_field_params['name'],
                    $sub_field_params['field']);
                return;  
            } 

            $sub_type = $this->mod::FIELD_DEF_PREFIX.$sub_field_params['field'];
            $sub_name = $sub_field_params['name'];
            $sub_params = $sub_field_params;    // all except 'name'
            unset( $sub_params['name'] ); 
            // remove any sub_fields_ignored_params
            foreach ($sub_field_params as $tmp_param_name => $tmp_value) {
                if ( in_array($tmp_param_name, $this->sub_fields_ignored_params) ) {
                    unset( $sub_params[$tmp_param_name] );
                }
            }

            $sub_value = '';  // temporary value only - is updated before each field generated
            $sub_field = new $sub_type($this->mod, $sub_name, $sub_value, $sub_params, $this->adding, $this->id);
            $sub_field->set_as_subfield($this->block_name); // $parent_block_name
            $sub_fields[] = $sub_field;
        }
        
        if ( empty($sub_fields) ) {
            $this->error = $this->mod->Lang('error_no_sub_fields');
            return;  
        } 

        $this->sub_fields = $sub_fields;

    }



    /**
     *  set the $this->value of the fielddef when being used mulitple times within a group
     *  @param object $fields - all values for the entire row of fields in a group
     *  @param integer $row_number - to be used to group all row values together
     */
    public function set_sub_field_value($fields, $row_number)
    {
        // set value to default
        if ( isset($this->options['default']) ) {   
            $this->value = $this->options['default'];
        }
        // set to fields value if available
        if ( isset($fields->{$this->block_name}) ) {
            $block_value = $fields->{$this->block_name};
            if ( is_string($block_value) || is_numeric($block_value) ) {
                $this->value = $block_value;
            } elseif ( is_array($block_value) ) {
                $this->values = $block_value;
            } elseif ( is_object($block_value) && isset($block_value->values) ) {
                $this->values = $block_value->values;
            }
        }
        $this->sub_row_number = $row_number;

    }



    /**
     *  @return string Label for the field - defaults to block_name if label not set
     */
    public function get_field_label()
    {
        $label = ( !empty($this->options['label']) ) ? $this->options['label'] : $this->block_name;
        return $label;

    }



    /**
     *  sets the fielddef as a sub_field and sets the sub_parent_block
     *  @param string $parent_block_name - block_name of the parent block
     */
    public function set_as_subfield($parent_block_name)
    {
        $this->is_sub_field = TRUE;
        $this->sub_parent_block = $parent_block_name;
    }



    /**
     *  returns the field type 
     */
    public function get_type()
    {
        return $this->field;
    }



    /**
     *  returns the default input smarty template contents 
     *  retrieved from cached_template if already read and saved
     *  see LISEFielddefBase for ideas :)
     */
    protected function get_template()
    {
        if ( !empty($this->cached_template) ) {
            return $this->cached_template;
        }

        // default input smarty template filename
        $filename = $this->mod->GetModulePath() .DIRECTORY_SEPARATOR. 'lib' .DIRECTORY_SEPARATOR. 
            'fielddefs' .DIRECTORY_SEPARATOR. $this->field .DIRECTORY_SEPARATOR. 
            $this->mod::INPUT_TEMPLATE_PREFIX . $this->mod::FIELD_DEF_PREFIX . $this->field . '.tpl';

        if (is_readable($filename)) {
            $this->cached_template = @file_get_contents($filename);
            return $this->cached_template;
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
                $key_val = explode( '=', trim($opt) );
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
            $cms_module_call .= " $key=\"$value\"";
        }

        $smarty = \CmsApp::get_instance()->GetSmarty();
        $module_values = trim(strip_tags($smarty->fetch('string:'.$cms_module_call.'}')));
        $options = $smarty->getTemplateVars('options');

        if ( !empty($options) && is_array($options) ) {   // first see if $options array set 
            return $options;
        }
        if ( !empty($module_values) ) {
            return $this->get_array_from_csl( $module_values );
        }

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
        $options = $smarty->getTemplateVars('options');

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



    /**
     *  @return string formatted html from smarty help template
     */
    public function get_field_help()
    {
        $help_filename = $this->mod->GetModulePath() .DIRECTORY_SEPARATOR. 'lib' .DIRECTORY_SEPARATOR. 
            'fielddefs' .DIRECTORY_SEPARATOR. $this->field .DIRECTORY_SEPARATOR. 
            $this->mod::HELP_TEMPLATE_PREFIX . $this->mod::FIELD_DEF_PREFIX . $this->field . '.tpl';
        $field_help = (is_readable($help_filename)) ? @file_get_contents($help_filename) : '';

        $smarty = \CmsApp::get_instance()->GetSmarty();
        $tpl = $smarty->CreateTemplate( 'string:'.$field_help, null, null, $smarty );
        $tpl->assign('fielddef', $this);
        return $tpl->fetch();
    }



    /**
     *  @return string formatted html from smarty help template
     */
    public function get_demo_input( $params=[] )
    {
        $params['field'] = $this->field;
        $this->value = NULL;
        $this->demo_count++;
        $this->block_name = $this->mod::DEMO_BLOCK_PREFIX.$this->field.$this->demo_count; 

        // re-initialise with new $params from help call
        $this->initialise_options($params);

        // reset use_json_format depending on $params
        $this->use_json_format = !empty($params['repeater']);

        if ( $this->use_json_format ) {
            $this->values[] = $this->value;
        }

        if ( !empty($this->allowed_sub_fields) ) $this->create_sub_fields( $params );

        return $this->get_content_block_input();

    }



    /**
     *  Data entered by the editor is processed before its saved in props table
     *  Method can be overidden by child class, e.g. gallery, group
     *  
     *  @return string formatted json containing all field data ready to be saved & output
     */
    public function get_content_block_value( $inputArray ) 
    {
        $this->field_object = $this->create_field_object( $inputArray );

        return $this->ECB2_json_encode_field_object();
    }



    /**
     *  @param array $inputArray - 1 or more array items from editing the ecb2 field 
     *  @return stdClass field_object in the format of:
     *        (
     *            [values] => Array {
     *                [0] => '1c #1 - changed?'
     *                [1] => '1c .... not line 4 :)'
     *                [2] => '1c line #2 - changed?'
     *                ...
     *            }
     *                OR                  // if e.g. type is a group
     *            [sub_fields] => Array {
     *                [0] => field stdClass Object {
     *                    [field_name1] => '1st text'    // $test1c->sub_fields[0]->field_name1 = '1st text' 
     *                    [field_name2] => 'another text line'
     *                }
     *                [1] => field stdClass Object {
     *                     ...
     *                } 
     *            }
     *            [param1] => 'some_text_string'
     *        )
     */
    protected function create_field_object( $inputArray = [] ) 
    {    
        $field_object = new stdClass();
        foreach ($inputArray as $key => $value) {
            if ( preg_match('/^(r_)?[0-9]+$/', $key) ) { // is a value or child: r_0 or 0 
                if ( is_array($value) ) {   // sub_fields
                    $sub_fields = [];
                    foreach ($value as $field_name => $child_value) {
                        if ( is_array($child_value) ) {
                            $sub_fields[$field_name] = self::create_field_object( $child_value );
                        } else {
                            $sub_fields[$field_name] = $child_value;
                        }
                    }
                    $field_object->sub_fields[] = $sub_fields;

                } else {    // value
                    $field_object->values[] = $value;

                }
            
            } else { // is other data
                $field_object->$key = $value;

            }
        }

        if ( !isset($field_object->values) && !isset($field_object->sub_fields) ) {
            $field_object->values = [];        // ensure values set as empty array as a minimum
        }
        return $field_object;
    }



    /**
     *  @param array $inputArray - 1 or more array items from editing the ecb2 field 
     *  @return string json encoded $this->field_obj
     */
    protected function ECB2_json_encode_field_object() 
    {
        return json_encode( $this->field_object, JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION );
    }



}