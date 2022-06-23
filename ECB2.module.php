<?php
#---------------------------------------------------------------------------------------------------
# Module: ECB2 - Extended Content Blocks 2
# Author: Chris Taylor
# Copyright: (C) 2016 Chris Taylor, chris@binnovative.co.uk
# Licence: GNU General Public License version 3
#          see /ECB2/lang/LICENCE.txt or <http://www.gnu.org/licenses/>
#---------------------------------------------------------------------------------------------------
# A fork of module: Extended Content Blocks (ECB)
# Original Author: Zdeno Kuzmany (zdeno@kuzmany.biz) / kuzmany.biz  / twitter.com/kuzmany
#---------------------------------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2011 by Ted Kulp (wishy@cmsmadesimple.org)
# Project's homepage is: http://www.cmsmadesimple.org
# Module's homepage is: http://dev.cmsmadesimple.org/projects/ecb2
#---------------------------------------------------------------------------------------------------
# This program is free software; you can redistribute it and/or modify it under the terms of the
# GNU General Public License as published by the Free Software Foundation; either version 3
# of the License, or (at your option) any later version.
#
# This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
# without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
# See the GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License along with this program.
# If not, see <http://www.gnu.org/licenses/>.
#---------------------------------------------------------------------------------------------------

class ECB2 extends \CMSModule {

    const MODULE_VERSION = '1.8';

    // public $is_datepicker_lib_load = false;
    // public $is_colorpicker_lib_load = false;

    public function __construct() {
        parent::__construct();

        \CMSMS\HookManager::add_hook( 'Core::ContentEditPre', [ $this, 'ContentEditPre' ] );
    }

    public function GetName() { return 'ECB2';  }
    public function GetFriendlyName() { return $this->Lang('friendlyname'); }
    public function GetVersion() { return self::MODULE_VERSION; }
    public function MinimumCMSVersion() { return '2.0'; }
    public function LazyLoadFrontend() { return true; }
    public function GetHelp() {
        $smarty = \CmsApp::get_instance()->GetSmarty();
        $smarty->assign('mod', $this);
        return $this->ProcessTemplate('_help.tpl');
    }
    public function GetAuthor() { return 'Chris Taylor (twitter.com/KiwiChrisBT)'; }
    public function GetAuthorEmail() { return 'chris@binnovative.co.uk'; }
    public function GetChangeLog() { return $this->ProcessTemplate('_changelog.tpl'); }
    public function HasAdmin() { return false;}
    public function GetDescription() { return $this->Lang('module_description'); }
    public function InstallPostMessage() { return $this->Lang('postinstall');}
    public function UninstallPostMessage() { return $this->Lang('postuninstall');}
    public function UninstallPreMessage() { return $this->Lang('really_uninstall');}

    public function InitializeFrontend() {
        $this->RegisterModulePlugin();
        $this->RestrictUnknownParams();
        $this->SetParameterType('block_name', CLEAN_STRING);
        $this->SetParameterType('value', CLEAN_STRING);
        $this->SetParameterType('adding', CLEAN_STRING);
        $this->SetParameterType('sortfiles', CLEAN_STRING);
        $this->SetParameterType('excludeprefix', CLEAN_STRING);
        $this->SetParameterType('recurse', CLEAN_STRING);
        $this->SetParameterType('filetypes', CLEAN_STRING);
        $this->SetParameterType('field', CLEAN_STRING);
        $this->SetParameterType('dir', CLEAN_STRING);
        $this->SetParameterType('preview', CLEAN_STRING);
        $this->SetParameterType('date_format', CLEAN_STRING);
        $this->SetParameterType('description', CLEAN_STRING);
        $this->SetParameterType('default_value', CLEAN_STRING);
        $this->SetParameterType('max_number', CLEAN_INT);
        $this->SetParameterType('maxnumber', CLEAN_INT);
        $this->SetParameterType('legend', CLEAN_STRING);
        $this->SetParameterType('compact', CLEAN_STRING);
        $this->SetParameterType('size', CLEAN_INT);
        $this->SetParameterType('change_month', CLEAN_INT);
        $this->SetParameterType('change_year', CLEAN_INT);
        $this->SetParameterType('year_range', CLEAN_STRING);
        $this->SetParameterType('no_hash', CLEAN_INT);
        $this->SetParameterType('clear_css_cache', CLEAN_INT);
        $this->SetParameterType('flip_values', CLEAN_INT);
    }



    public function InitializeAdmin() 
    { 
        // $this->AddImageDir('icons'); 
//        \CMSMS\HookManager::add_hook('Core::ContentEditPre','ECB2::ContentEditPre');
    }



    function HasCapability($capability, $params = array()) {
    //***********************************************************************************************
    // http://www.cmsmadesimple.org/apidoc/CMS/CMSModule.html#HasCapability
    //***********************************************************************************************
        switch ($capability) {
            case 'contentblocks':
                return TRUE;

            default:
                return FALSE;
        }
    }



    public function GetContentBlockFieldInput($blockName, $value, $params, $adding=false, ContentBase $content_obj) {
    //***********************************************************************************************
    // http://www.cmsmadesimple.org/APIDOC2_0/classes/CMSModule.html#method_GetContentBlockFieldInput
    //***********************************************************************************************
        $ecb2 = new ecb2_tools($blockName, $value, $params, $adding);

        return $ecb2->get_content_block_input();
    }



    public function ContentEditPre( $params )
    {
        $contentId = $params['content']->Id();
        $props = $params['content']->GetEditableProperties();
        $new_props = $params['content']->Properties();
        $clear_css_cache = false;
        // $ECB2_props = [];

        foreach ($props as $prop) {
            // if ( isset($prop->extra) && isset($prop->extra['module']) && $prop->extra['module']=='ECB2') {
            //     $ECB2_props[ $prop->name ] = $prop;
            // }
            if ( !$clear_css_cache && isset($prop->extra) && isset($prop->extra['module']) && 
                 $prop->extra['module']=='ECB2' && isset($prop->extra['params']['clear_css_cache']) ) {
                // test if value has changed
                $db = CmsApp::get_instance()->GetDb();
                $query = 'SELECT content FROM '.CMS_DB_PREFIX.'content_props 
                    WHERE content_id = ? AND prop_name = ?';
                $old_value = $db->GetOne( $query, [$contentId, $prop->name] );
                $new_value = $new_props[$prop->name];
                if ($new_value != $old_value) $clear_css_cache = true;
            }
        }
        if ($clear_css_cache) {
            $this->ClearStylesheetCache();
        }
    }



    // shamelessly copied from CustomGS - thanks Rolf & Jos :)
	function ClearStylesheetCache()
	{
		foreach (glob("../tmp/cache/stylesheet_combined_*.css") as $filename) {
			touch( $filename, time() - 360000 );
		}
	}

}


