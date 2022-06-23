<?php
#
# ECB2 - Extended Content Blocks 2
#
# maintained by Chris Taylor, <chris@binnovative.co.uk>, since 2016
#
#-------------------------------------------------------------------------
#
# A fork of module: Extended Content Blocks (ECB)
# Original Author: Zdeno Kuzmany (zdeno@kuzmany.biz) / kuzmany.biz  / twitter.com/kuzmany
#
#-------------------------------------------------------------------------
#
# CMS - CMS Made Simple is (c) 2009 by Ted Kulp (wishy@cmsmadesimple.org)
# This project's homepage is: http://www.cmsmadesimple.org
# The module's homepage is: http://dev.cmsmadesimple.org/projects/skeleton/
#
#-------------------------------------------------------------------------
#
# This program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
# Or read it online: http://www.gnu.org/licenses/licenses.html#GPL
#
#-------------------------------------------------------------------------


class ecb2_tools {

   private $block_name = '';
   private $value = '';
   private $adding = false;
   private $options = array();
   private $alias = '';
   private $field = '';
   private $txt = '';


   
   /**
    * @param string $blockName
    * @param string $value
    * @param array $params
    * @param boolean $adding
    */
    public function __construct($blockName, $value, $params, $adding) 
    {
        $mod = cms_utils::get_module('ECB2');
        $this->block_name = $blockName;
        $this->alias = munge_string_to_url($blockName, true);
        $this->value = $value;
        $this->adding = $adding;

        $this->get_extra_options($params);
        if ( isset($this->options["default_value"]) && isSet($params["default_value"]) ) {
            $this->default = $params["default_value"];
            if ( $adding==true ) $this->value = $this->default;
        }

        // if first ECB2 content block on the page - load ECB2 js & css (move all js & css into these)
        if (!cms_utils::get_app_data('ECB2_js_css_loaded')) {
            echo '
                <link rel="stylesheet" type="text/css" href="../modules/ECB2/lib/css/ecb2_admin.css?v'.$mod::MODULE_VERSION.'">
                <script language="javascript" src="../modules/ECB2/lib/js/ecb2_admin.js?v'.$mod::MODULE_VERSION.'"></script>';
            cms_utils::set_app_data('ECB2_js_css_loaded', 1);
        }

    }

   /**
   *  get content block
   * @return string
   */
   public function get_content_block_input() {

      $mod = cms_utils::get_module('ECB2');
      $function = 'get_' . $this->field;
      $functionExists = method_exists('ecb2_tools', $function);
      if ( empty($this->field) || !$functionExists ) {
         $err = '<div class="pagewarning">' . $mod->Lang('field_error') . '</div><br>';
         return $err;
      }

      if ( !empty($this->options['description']) ) {
         $this->options['description'] .= '<br>';
      }
      return $this->$function();
   }



    /**
     *
     * @return string
     */
    private function get_textarea() {
        $tmp = '<textarea name="%s" rows="%d" cols="%d">%s</textarea>';
        $value = $this->value ? $this->value : $this->options["default_value"];
        return $this->options['description'].sprintf($tmp, $this->block_name, $this->options["rows"], $this->options["cols"], $value);
    }

    /**
     *
     * @return string
     */
    private function get_pages() {
        $contentOps = \ContentOperations::get_instance();
        return $this->options['description'].$contentOps->CreateHierarchyDropdown('', $this->value, $this->block_name, 1, 1);
    }

    /**
     *
     * @return string
     */
    private function get_editor() {
        $mod = cms_utils::get_module('ECB2');
        $value = $this->value ? $this->value : $this->options["default_value"];
        return $this->options['description'].$mod->CreateTextArea(true, '', $value, $this->block_name, '', '', '', '', $this->options["cols"], $this->options["rows"]);
    }

    /**
     *
     * @return string
     */
    private function get_input() {
        $tmp = '<input type="text" name="%s" size="%d" maxlength="%d" value="%s"/>';
        $value = $this->value ? $this->value : $this->options["default_value"];
        return $this->options['description'].sprintf($tmp, $this->block_name, $this->options["size"], $this->options["max_length"], $value);
    }

    /**
     *
     * @return string
     */
    private function get_timepicker() {
        $smarty = \CmsApp::get_instance()->GetSmarty();
        $mod = cms_utils::get_module('ECB2');
        $timepicker_addon_js_url = $mod->GetModuleURLPath().'/lib/js/jquery-ui-timepicker-addon.js';
        $class = 'timepicker';
        $tpl = $smarty->CreateTemplate( $mod->GetTemplateResource('datepicker_template.tpl'), null, null, $smarty );
        $tpl->assign('is_datepicker_lib_load', $mod->is_datepicker_lib_load);
        $tpl->assign('timepicker_addon_js_url', $timepicker_addon_js_url);
        $tpl->assign('description', $this->options['description']);
        $tpl->assign('class', $class);
        $tpl->assign('block_name', $this->block_name);       
        $tpl->assign('size', $this->options['size']);
        $tpl->assign('max_length', $this->options['max_length']);
        $tpl->assign('time_format', $this->options['time_format']);
        $tpl->assign('value', $this->value);
        $mod->is_datepicker_lib_load = true;
        return $tpl->fetch();
    }

    /**
     *
     * @return string
     */
    private function get_datepicker() {
        $smarty = \CmsApp::get_instance()->GetSmarty();
        $mod = cms_utils::get_module('ECB2');
        //$timepicker_addon_js_url = $mod->GetModuleURLPath().'/lib/js/jquery-ui-timepicker-addon.js';
        $class = !empty($this->options['time']) ? 'datetimepicker' : 'datepicker';
        $tpl = $smarty->CreateTemplate( $mod->GetTemplateResource('datepicker_template.tpl'), null, null, $smarty );
        //$tpl->assign('is_datepicker_lib_load', $mod->is_datepicker_lib_load );
        //$tpl->assign('timepicker_addon_js_url', $timepicker_addon_js_url );
        $tpl->assign('description', $this->options['description']);
        $tpl->assign('class', $class);
        $tpl->assign('block_name', $this->block_name);       
        $tpl->assign('size', $this->options['size']);
        $tpl->assign('max_length', $this->options['max_length']);
        $tpl->assign('time_format', $this->options['time_format']);
        $tpl->assign('change_month', $this->options['change_month']);
        $tpl->assign('change_year', $this->options['change_year']);
        $tpl->assign('year_range', $this->options['year_range']);
        $tpl->assign('value', $this->value);
        //$mod->is_datepicker_lib_load = true;
        return $tpl->fetch();
    }



    /**
     *
     * @return string
     */
    private function get_color_picker() 
    {
        $smarty = \CmsApp::get_instance()->GetSmarty();
        $mod = cms_utils::get_module('ECB2');
        if ( !isset($this->value) && isset($this->default) ) $this->value = $this->default;
        //$colorpicker_addon_js_url = $mod->GetModuleURLPath().'/lib/js/colpick.js';
        $tpl = $smarty->CreateTemplate( $mod->GetTemplateResource('colorpicker_template.tpl'), null, null, $smarty );
        //$tpl->assign('is_colorpicker_lib_load', $mod->is_colorpicker_lib_load );
        //$tpl->assign('colorpicker_addon_js_url', $colorpicker_addon_js_url );
        $tpl->assign('description', $this->options['description']);
        $tpl->assign('class', 'colorpicker');
        $tpl->assign('block_name', $this->block_name);    
        $tpl->assign('alias', $this->alias);    
        $tpl->assign('size', $this->options['size']);
        $tpl->assign('no_hash', $this->options['no_hash']);
        $tpl->assign('value', $this->value);       
        // $mod->is_colorpicker_lib_load = true;
        return $tpl->fetch();
    }



   /**
   *
   * @return string
   */
   private function get_checkbox() {
      $mod = cms_utils::get_module('ECB2');
      // a hack for if $adding not being set correctly by Content Manager (2.2.14)
      if ( !$this->adding && empty($_REQUEST['m1_content_id']) && empty($this->value) && isset($this->default) ) {
         $this->value = $this->default;
      }
      return $this->options['description'].$mod->CreateInputHidden('', $this->block_name, 0) . $mod->CreateInputCheckbox('', $this->block_name, 1, $this->value);
   }



   /**
    *
    * @return string
    */
   private function get_file_selector() {
      $mod = cms_utils::get_module('ECB2');
      $config = cmsms()->GetConfig();

      // Get the directory contents
      $adddir = get_site_preference('contentimage_path');
      if ($this->options['dir'])
         $adddir = $this->options['dir'];

      $dir = cms_join_path($config['uploads_path'], $adddir);
      $filetypes = $this->options['filetypes'];
      if ($filetypes != '') {
         $filetypes = explode(',', $filetypes);
      }

      $excludes = $this->options['excludeprefix'];
      if ($excludes != '') {
         $excludes = explode(',', $excludes);
         for ($i = 0; $i < count($excludes); $i++) {
            $excludes[$i] = $excludes[$i] . '*';
         }
      }
      $maxdepth = !empty($this->options['recurse']) ? -1 : 0;   // default
      $fl = get_recursive_file_list( $dir, $excludes, $maxdepth, 'FILES' );

      // Remove prefix
      $filelist = array();
      for ($i = 0; $i < count($fl); $i++) {
         if ( in_array( pathinfo($fl[$i], PATHINFO_EXTENSION), $filetypes ) )
            $filelist[] = str_replace($dir, '', $fl[$i]);
      }

      // Sort
      if (is_array($filelist) && $this->options['sortfiles']) {
         sort($filelist);
      }

      // create select options
      $opts = array();
      $url_prefix = $adddir;
      for ($i = 0; $i < count($filelist); $i++) {
         $opts[$filelist[$i]] = $url_prefix . $filelist[$i];
      }
      $opts = array('' => '') + $opts;

      $preview = '';
      if ($this->options['preview']) {
         if ($this->value) {
            $preview = '<img style="max-width:130px;" class="file_selector_preview" data-uploadsurl="' . $config["uploads_url"] . '"   src="' . $config["uploads_url"] . '/' . $this->value . '" alt="">';
         } else {
            $preview = '<img style="max-width:130px;" class="file_selector_preview" alt="" data-uploadsurl="' . $config["uploads_url"] . '">';
         }
      }

      return $this->options['description'].'<div class="ecb_file_selector_select">' . $mod->CreateInputDropdown('', $this->block_name, $opts, -1, $this->value) . '</div>' . $preview;
   }



    /**
    *
    * @return string
    */
    private function get_sortablelist() 
    {
        $mod = cms_utils::get_module('ECB2');
        $options = array();
        $tmp = array();

        if ( $this->options['mod'] ) {
            // call module to get values
            $exclude_options = ['values','udt','default_value','first_value','description','label_left','label_right','max_number','required_number','mod','flip_values','compact','field','allowduplicates','max_selected'];
            $params = [];
            foreach ($this->options as $key => $value) {
                if ( !in_array($key, $exclude_options) ) $params[$key] = $value;
            }
            $module = cms_utils::get_module( $this->options['mod'] );
            if ( $module ) { 
                $tmp_action = isset($this->options['action']) ? $this->options['action'] : '';
                $cms_module_call = "{cms_module module=".$this->options['mod'];
                foreach ($params as $key => $value) {
                    $cms_module_call .= " $key=$value";
                };
                $cms_module_call .= "}";
                $smarty = \CmsApp::get_instance()->GetSmarty();
                $this->options["values"] = strip_tags($smarty->fetch('string:'.$cms_module_call));
            }
        }




        if ( $this->options['udt'] ) {
            $options = UserTagOperations::get_instance()->CallUserTag($this->options['udt'], $tmp);
        }
        // create $optionsarray of key => text from comma separated string of 'key=text,key2=text2'
        $optionsarray = explode(',', $this->options["values"]);
        if (empty($optionsarray)) return;
        foreach ($optionsarray as $option) {
            if ($option!='') {
                $key_val = explode('=', $option);
                $options[$key_val[0]] = $key_val[1];
            }
        }
        if ( $this->options['mod'] ) {  // format reversed in module output for sortablelist
            $options = array_flip($options);
        }
        if ( $this->options['flip_values'] ) { 
            $options = array_flip($options);
        }
        if (empty($this->options['first_value']) == false)
            $options = array($this->options['first_value'] => '') + $options;
        $selectedList = explode(',', $this->value);
        $available = $options;
        $selected = array();
        foreach ($selectedList as $item) {
            if ( array_key_exists($item, $available) ) {
                $selected[$item] = $available[$item];
                unset($available[$item]);
            }
        }
        if ($this->options["max_number"]) // max_number takes precidence if both set
            $this->options["required_number"] = "";
        $smarty = Smarty_CMS::get_instance();
        $tpl = $smarty->CreateTemplate($mod->GetTemplateResource('sortablelist_template.tpl'), null, null, $smarty);
        $tpl->assign('selectarea_prefix',$this->block_name);
        $tpl->assign('selected_str',$this->value);
        $tpl->assign('selected',$selected);
        $tpl->assign('available', $available);
        $tpl->assign('description', $this->options['description']);
        $tpl->assign('labelLeft', $this->options["label_left"]);
        $tpl->assign('labelRight', $this->options["label_right"]);
        $tpl->assign('mod',$mod);
        $tpl->assign('maxNumber', $this->options["max_number"]);
        $tpl->assign('requiredNumber', $this->options["required_number"]);
        return $this->options['description'].$tpl->fetch();
    }



    /**
     *
     * @return string
     */
    private function get_text() {

        if (!$this->options["text"])
            return;
        return $this->options['description'].$this->options["text"];
    }

    /**
     *
     * @return string
     */
    private function get_hr() {
        return $this->options['description'].'<hr style="display:block; border:0 none; background:#ccc;" />';
    }

    /**
     *
     * @return string
     */
    private function get_link() {

        if (!$this->options["link"] || !$this->options["text"])
            return;

        $mod = cms_utils::get_module('ECB2');
        return $this->options['description'].'<a target="' . $this->options["target"] . '" href="' . $this->options["link"] . '">' . $this->options["text"] . '</a>';
    }

    /**
     *
     * @return string
     */
    private function get_module_link() {

        $mod = '';
        if ($this->options["mod"])
            $mod = cms_utils::get_module($this->options["mod"]);

        $userid = get_userid();
        $userops = cmsms()->GetUserOperations();
        $adminuser = $userops->UserInGroup($userid, 1);

        $tmp = '<input id="mt_' . $this->block_name . '" ' . ( $adminuser ? 'type="text"' : 'type="hidden"') . ' name="' . $this->block_name . '" value="' . ($this->value ? $this->value : $this->options["default_value"]) . '"  size="%d" maxlength="%d" />';
        $tmp = sprintf($tmp, $this->options["size"], $this->options["max_length"]);
        // original CT edit
        return $this->options['description'].(is_object($mod) ? $mod->CreateLink('', 'defaultadmin', '', $this->options["text"], array(), '', false, 0, 'target="' . $this->options["target"] . '"') : $this->options["text"]); // . '<br />' . $tmp; // CT comment out
    }



   private function _create_select( $options ) {
   //***********************************************************************************************
   // dropdown Content Block - creates a select using the supplied parameters & $this->options
   //
   // creates a select using the supplied options
   //
   //***********************************************************************************************
      $mod = cms_utils::get_module('ECB2');
      $smarty = \CmsApp::get_instance()->GetSmarty();

      $tpl = $smarty->CreateTemplate( $mod->GetTemplateResource('select_template.tpl'), null, null, $smarty );
      $tpl->assign( 'block_name', $this->block_name );
      $tpl->assign( 'description', $this->options['description'] );
      $tpl->assign( 'multiple', $this->options['multiple'] );
      $tpl->assign( 'compact', $this->options['compact'] );
      $tpl->assign( 'none_selected', $mod->Lang('none_selected') );

      if ( isset($this->options['size']) && $this->options['size']>0 ) {
         $size = $this->options['size'];
      } elseif ( !empty($this->options['compact']) ) {
         $size = count($options);
      } else {
         $size = 5;  // default
      }
      $tpl->assign( 'size', $size );

      $tpl->assign( 'selected', $this->value );
      if ( $this->options['multiple'] ) {
         $selected_values = explode(',', $this->value);
         $selected_text = [];
         foreach ($selected_values as $value) {
            $selected_text[] = array_search( $value, $options );
         }
         $selected_text = implode(', ', $selected_text);
         $tpl->assign( 'selected_values', $selected_values );  // array
         $tpl->assign( 'selected_text', $selected_text );      // text
      }
      if ( empty($this->options['first_value'])==false )
         $options = array($this->options['first_value'] => '') + $options;
      $tpl->assign('options', $options );
      return $tpl->fetch();

   }



    /**
    *
    * @return string - contains html for a select
    */    
    private function get_dropdown() 
    {
        if ( $this->options['mod'] ) {
            // call module to get values
            $exclude_options = ['size','multiple','values','default_value','first_value','description',
                'compact','field','mod','flip_values'];
            $params = [];
            foreach ($this->options as $key => $value) {
                if ( !in_array($key, $exclude_options) ) $params[$key] = $value;
            }
            $module = cms_utils::get_module( $this->options['mod'] );
            if ( $module ) { 
                $tmp_action = isset($this->options['action']) ? $this->options['action'] : '';
                $cms_module_call = "{cms_module module=".$this->options['mod'];
                foreach ($params as $key => $value) {
                    $cms_module_call .= " $key=$value";
                };
                $cms_module_call .= "}";
                $smarty = \CmsApp::get_instance()->GetSmarty();
                $this->options["values"] = strip_tags($smarty->fetch('string:'.$cms_module_call));

            }
        }

        if ( !$this->options['values'] ) return;

        // create $options array 
        $options = array();
        $tmpOptions = explode(',', $this->options["values"]);
        foreach ($tmpOptions as $option) {
            $key_val = explode('=', $option);
            if ( count($key_val)>1 ) {
                $options[$key_val[0]] = $key_val[1];
            } else {
                $options[$key_val[0]] = $key_val[0];
            }
        }    

        if ( $this->options['flip_values'] ) { 
            $options = array_flip($options);
        }

        return $this->_create_select( $options );
    }



   private function get_dropdown_from_udt() {
   //***********************************************************************************************
   // dropdown Content Block with $options array coming from a UDT
   //
   // returns a select
   //***********************************************************************************************
      if (!$this->options["udt"]) return;

      $mod = cms_utils::get_module('ECB2');
      $smarty = cmsms()->GetSmarty();

      if ( UserTagOperations::get_instance()->UserTagExists($this->options["udt"]) ) {
         $tmp = array();
         $options = UserTagOperations::get_instance()->CallUserTag($this->options["udt"], $tmp);
      } else {
         $err = $mod->Lang('udt_error', $this->options["udt"] );
         $options = array();
      }

      if (empty($this->options['first_value']) == false)
         $options = array($this->options['first_value'] => '') + $options;

      if (!empty($err)) return '<div class="pagewarning">'.$err.'</div>';

      return $this->_create_select( $options );
   }



   /**
    *
    * @return string
    */
   private function get_dropdown_from_gbc() {
   //***********************************************************************************************
   // dropdown Content Block with $options a comma separated list from a GCB
   //
   // returns a select
   //***********************************************************************************************
      if (!$this->options["gbc"]) return;

      $smarty = cmsms()->GetSmarty();

      $tmp = array();
      $options = array();
      $optionsgbc = $smarty->fetch('globalcontent:' . $this->options["gbc"]);

      $optionsarray = explode(',', $optionsgbc);
      if (empty($optionsarray)) return;

      foreach ($optionsarray as $option) {
         $key_val = explode('=', $option);
         $options[$key_val[0]] = $key_val[1];
      }

      if (empty($this->options['first_value']) == false)
         $options = array($this->options['first_value'] => '') + $options;

      return $this->_create_select( $options );
   }



   public function get_dropdown_from_customgs() {
   //***********************************************************************************************
   // creates a dropdown from the values in a CustomGS field
   // note: the CustomGS field should be a plain textarea
   //       use either newlines or commas to separate each title-value pair
   //***********************************************************************************************
      $dropdown = array();
      $err = '';
      $mod = cms_utils::get_module('ECB2');
      $CustomGS = cms_utils::get_module('CustomGS');

      if( is_object($CustomGS) ) {
         // create array $dropdown with a
         $selectOptions = $CustomGS->GetField( $this->options['customgs_field'] );
         if ( empty($selectOptions['value']) ) {
            $err = '<div class="pagewarning">' . $mod->Lang('customgs_field_error', $this->options['customgs_field'] ) . '</div><br>';

         } else {
            // use either newlines or commas to separate each title-value pair
            $selectOptions = str_replace(PHP_EOL, ',', $selectOptions['value']);
            $selectLines = explode(',', $selectOptions);
            foreach ($selectLines as $oneOption) {
               $opt = explode( '=', trim($oneOption) );
               $dropdown[$opt[0]] = isSet($opt[1]) ? $opt[1] : $opt[0];
            }
         }
      }

      return $err.$this->_create_select( $dropdown );
   }




    /**
     *
     * @return string
     */
    private function get_module() {

        $modops = cmsms()->GetModuleOperations();
        $modules = $modops->GetInstalledModules();
        $modulesarray = array();
        foreach ($modules as $module) {
            $mod = cms_utils::get_module($module);
            if (is_object($mod))
                $modulesarray[$mod->GetName()] = $module;
        }

        $mod = cms_utils::get_module('ECB2');
        return $this->options['description'].$mod->CreateInputDropdown('', $this->block_name, $modulesarray, -1, $this->value);
    }



    /**
     *
     * @return string
     */
    private function get_radio() {
        if (!$this->options["values"])
            return;
        $mod = cms_utils::get_module('ECB2');
        $smarty = cmsms()->GetSmarty();

        $options = array();

        $optionsarray = explode(',', $this->options["values"]);
        if (empty($optionsarray))
            return;

        foreach ($optionsarray as $option) {
            $key_val = explode('=', $option);
            $options[$key_val[0]] = $key_val[1];
        }

        $delimiter = ($this->options["inline"]) ? '&nbsp;&nbsp;&nbsp;&nbsp;' : '<br>';

        if ( !empty($this->value) ) {
            $selectedValue = $this->value;
        } else {
            if ($this->options["default_value"]=='-1') {
                $selectedValue = reset($options);
            } else {
                $selectedValue = $options[$this->options["default_value"]];
            }
        }

        return $this->options['description'].$mod->CreateInputRadioGroup('', $this->block_name, $options, $selectedValue, '', $delimiter);
    }



    /**
     *
     * @return string
     */
    public function get_hidden() {
        $tmp = '<input type="hidden" name="%s" value="%s">';
        $input = sprintf($tmp, $this->block_name, $this->options['value']);
        return $input;
    }



    public function get_fieldset_start() {
    //**********************************************************************************************
    //
    //
    //**********************************************************************************************
        $tmp = '</p>
        </div>
            <fieldset name="%s">
            <legend>%s</legend>
            %s
        <div><p>';
        $input = sprintf($tmp, $this->block_name, $this->options['legend'], $this->options['description']);
        return $input;
    }



   public function get_fieldset_end() {
   //**********************************************************************************************
   //
   //**********************************************************************************************
      return '</p>
      </div>
      </fieldset>
      <div><p>';
   }



   public function get_gallery_picker() {
   //***********************************************************************************************
   // gallery_picker Content Block
   //
   // returns an select input of galleries 'gallery title' => 'gallery-dir', home gallery is excluded
   // Parameters:
   //    dir - only return galleries that are sub-galleries of this gallery dir,
   //          default is all galleries, excluding default top level gallery
   //***********************************************************************************************
      $dir = $this->options['dir'].'/';    // default dir (needs '/' at end)

      $mod = cms_utils::get_module('ECB2');
      $GalleryModule = cms_utils::get_module('Gallery');
      if (!is_object($GalleryModule)) {
         $err = '<div class="pagewarning">' . $mod->Lang('gallery_module_error') . '</div><br>';
         return $err;
      }

      $galleries = Gallery_utils::GetGalleries();
      $galleryArray = array('--- none ---' => '');

      foreach ($galleries as $gallery) {
         if ($gallery['filename']!='') {    // ignores default gallery
            if ($dir!='/') {
               // only select sub-galleries of $dir
               $isSubDir = stripos($gallery['filepath'], $dir);

               if ($isSubDir!==FALSE && $isSubDir==0) {
                  $gallery_dir = $gallery['filepath'].rtrim($gallery['filename'], '/');
                  $galleryArray[$gallery['title']] = $gallery_dir;
               }

            } else {
               // select all galleries
               $gallery_dir = $gallery['filepath'].rtrim($gallery['filename'], '/');
               $galleryArray[$gallery['title']] = $gallery_dir;
            }
         }
      }

      return $this->options['description'].$mod->CreateInputDropdown('', $this->block_name, $galleryArray, -1, $this->value);
   }



   private function get_input_repeater() {
   //***********************************************************************************************
   //    creates a repeating text field that
   //
   //***********************************************************************************************
      $smarty = \CmsApp::get_instance()->GetSmarty();
      $mod = cms_utils::get_module('ECB2');

      $fields = explode('||', $this->value);
      $tpl = $smarty->CreateTemplate( $mod->GetTemplateResource('input_repeater_template.tpl'), null, null, $smarty );
      $tpl->assign('block_name', $this->block_name );
      $tpl->assign('size', $this->options["size"] );
      $tpl->assign('max_length', $this->options["max_length"] );
      $tpl->assign('value', $this->value );
      $tpl->assign('fields', $fields );
      $tpl->assign('description', $this->options['description'] );
      $tpl->assign('title_add_line', $mod->Lang('add_line') );
      $tpl->assign('title_remove_line', $mod->Lang('remove_line') );
      return $tpl->fetch();
   }




    /**
     *
     * @return string
     */
    private function get_image() 
    {
        if (!$this->options['image']) return;

        $smarty = \CmsApp::get_instance()->GetSmarty();
        $mod = cms_utils::get_module('ECB2');
        $config = cmsms()->GetConfig();
        $img_url = cms_join_path( $config['uploads_url'], $this->options['image'] );
        $tpl = $smarty->CreateTemplate( $mod->GetTemplateResource('image_template.tpl'), null, null, $smarty );
        $tpl->assign('block_name', $this->block_name );
        $tpl->assign('img_url', $img_url );
        $tpl->assign('description', $this->options['description'] );
        return $tpl->fetch();
    }




   private function get_extra_options(array $params) {
   //***********************************************************************************************
   //
   //
   //***********************************************************************************************
      if (!isSet($params["field"]))
         return;

      $options = array();
      $default_options = array();
      switch (strtolower($params["field"])) {
            case "color_picker":
                $default_options["size"] = 10;
                $default_options["default_value"] = '';
                $default_options["description"] = '';
                $default_options['no_hash'] = false;
                $default_options['clear_css_cache'] = false;
                break;
            case "module_link":
                $default_options["mod"] = '';
                $default_options["text"] = '';
                $default_options["target"] = '_self';
                $default_options["default_value"] = '';
                $default_options["size"] = 30;
                $default_options["max_length"] = 255;
                $default_options["description"] = '';
                break;
            case "link":
                $default_options["text"] = '';
                $default_options["target"] = '_self';
                $default_options["link"] = '';
                $default_options["description"] = '';
                break;
            case "module":
                $default_options["default_value"] = '';
                $default_options["text"] = '';
                $default_options["link"] = '';
                $default_options["description"] = '';
                break;
            case "dropdown_from_module":
                $default_options["mod"] = '';
                $default_options["default_value"] = '';
                $default_options["first_value"] = '';
                $default_options["description"] = '';
                break;
            case "file_selector":
                $default_options["filetypes"] = '';
                $default_options["excludeprefix"] = '';
                $default_options["recurse"] = '';
                $default_options["sortfiles"] = '';
                $default_options["dir"] = '';
                $default_options["preview"] = '';
                $default_options["description"] = '';
                break;
            case "dropdown":
               $default_options["size"] = '';
               $default_options["multiple"] = '';
               $default_options["values"] = '';
               $default_options["default_value"] = '';
               $default_options["first_value"] = '';
               $default_options["description"] = '';
               $default_options["compact"] = '';
               $default_options["flip_values"] = '';
               break;
            case "dropdown_from_udt":
               $default_options["size"] = 5;
               $default_options["multiple"] = '';
               $default_options["values"] = '';
               $default_options["default_value"] = '';
               $default_options["first_value"] = '';
               $default_options["udt"] = '';
               $default_options["description"] = '';
               $default_options["compact"] = '';
               break;
            case "dropdown_from_gbc":
               $default_options["size"] = 5;
               $default_options["multiple"] = '';
               $default_options["values"] = '';
               $default_options["default_value"] = '';
               $default_options["first_value"] = '';
               $default_options["gbc"] = '';
               $default_options["description"] = '';
               $default_options["compact"] = '';
               break;
            case 'dropdown_from_customgs':
               $default_options['multiple'] = '';
               $default_options['size'] = '';
               $default_options['customgs_field'] = '';
               $default_options['description'] = '';
               $default_options["compact"] = '';
               break;
            case "textarea":
                $default_options["default_value"] = '';
                $default_options["rows"] = 20;
                $default_options["cols"] = 80;
                $default_options["description"] = '';
                break;
            case "editor":
                $default_options["default_value"] = '';
                $default_options["rows"] = 20;
                $default_options["cols"] = 80;
                $default_options["description"] = '';
                break;
            case "input":
                $default_options["default_value"] = '';
                $default_options["size"] = 30;
                $default_options["max_length"] = 255;
                $default_options["description"] = '';
                break;
            case "sortablelist":
                $default_options["values"] = '';
                $default_options["first_value"] = '';
                $default_options["allowduplicates"] = false;
                $default_options["max_selected"] = -1;
                $default_options["label_left"] = '';
                $default_options["label_right"] = '';
                $default_options["udt"] = '';
                $default_options["description"] = '';
                $default_options["max_number"] = '';
                $default_options["required_number"] = '';
                break;
            case "text":
                $default_options["text"] = '';
                $default_options["execute"] = '';
                $default_options["description"] = '';
                break;
            case "pages":
                $default_options["default_value"] = '';
                $default_options["description"] = '';
                break;
            case "checkbox":
                $default_options["default_value"] = '';
                $default_options["description"] = '';
                break;
            case 'timepicker':
                $default_options["size"] = 10;
                $default_options["max_length"] = 10;
                $default_options["time_format"] = 'HH:mm';
                $default_options["description"] = '';
                break;
            case 'datepicker':
                $default_options["size"] = 20;
                $default_options["max_length"] = 20;
                $default_options["date_format"] = 'yy-mm-dd';
                $default_options["time_format"] = 'HH:mm';
                $default_options["time"] = '';
                $default_options["description"] = '';
                $default_options["change_month"] = false;
                $default_options["change_year"] = false;
                $default_options["year_range"] = '';
                break;
            case 'radio':
                $default_options["multiple"] = '';
                $default_options["values"] = '';
                $default_options["default_value"] = -1;
                $default_options["inline"] = false;
                $default_options["description"] = '';
                break;
            case "hr":
                $default_options["description"] = '';
                break;
            case "image_picker":
                $default_options["description"] = '';
                break;
            case 'hidden':
                $default_options['value'] = '';
                break;
            case 'fieldset_start':
                $default_options['legend'] = '';
                $default_options["description"] = '';
                break;
            case 'gallery_picker':
               $default_options['dir'] = '';
               $default_options['description'] = '';
               break;
            case "input_repeater":
                $default_options["default_value"] = '';
                $default_options["size"] = 50;
                $default_options["max_length"] = 255;
                $default_options["description"] = '';
                break;
            case 'image':
                $default_options['image'] = '';
                $default_options['description'] = '';
                break;
        }

        $this->field = $params["field"];

        if ( in_array( $params["field"], ['dropdown','sortablelist'] ) ) {
            // accept all params - to possibly pass onto module
            if ( !empty($params) ) {
                foreach ($params as $key => $param) {
                    $default_options[$key] = $param;
                }
            }

        } else {
            // only use params that have a default set
            if (empty($params) == false) {
                foreach ($params as $key => $param) {
                    if (isSet($default_options[$key]) && empty($param) == false)
                    $default_options[$key] = $param;
                }
            }
        }

        $this->options = $default_options;
    }

}


