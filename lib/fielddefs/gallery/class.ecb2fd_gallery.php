<?php
#---------------------------------------------------------------------------------------------------
# Module: ECB2 - Extended Content Blocks 2
# Author: Chris Taylor
# Copyright: (C) 2016 Chris Taylor, chris@binnovative.co.uk
# Licence: GNU General Public License version 3
#          see /ECB2/lang/LICENCE.txt or <http://www.gnu.org/licenses/>
#---------------------------------------------------------------------------------------------------


class ecb2fd_gallery extends ecb2_FieldDefBase 
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
            'dir'              => ['default' => '',    'filter' => FILTER_SANITIZE_STRING],
            'thumbnail_width'  => ['default' => 0,    'filter' => FILTER_VALIDATE_INT],
            'thumbnail_height' => ['default' => 0,    'filter' => FILTER_VALIDATE_INT],
            'auto_add_delete'  => ['default' => true,  'filter' => FILTER_VALIDATE_BOOLEAN],
            'default_value'    => ['default' => '',    'filter' => FILTER_SANITIZE_STRING], 
            'description'      => ['default' => '',    'filter' => FILTER_SANITIZE_STRING]
        ];
        // $this->parameter_aliases = [ 'alias' => 'parameter' ];
        // $this->restrict_params = FALSE;    // default: true
        $this->use_json_format = TRUE;     // default: FALSE - can override e.g. 'groups' type

    }


    /**
     *  @return string complete content block 
     */
    public function get_content_block_input() 
    {
        $location = ecb2_FileUtils::ECB2ImagesUrl( $this->block_name, $this->id, '', $this->options['dir'] );
        $dir = ecb2_FileUtils::ECB2ImagesPath( $this->block_name, $this->id, '', $this->options['dir'] );
        if ( $this->options['auto_add_delete'] ) {
            $this->values = ecb2_FileUtils::autoAddDirImages( $this->values, $dir);
        }
        $thumbnail_width = $this->options['thumbnail_width'];
        $thumbnail_height = $this->options['thumbnail_height'];
        ecb2_FileUtils::get_required_thumbnail_size( $thumbnail_width, $thumbnail_height );

        $actionparms = [];
        $action_url = $this->mod->create_url( 'm1_', 'do_UploadFiles', '', $actionparms);
        $json_values = json_encode($this->values, JSON_HEX_APOS);

        $smarty = \CmsApp::get_instance()->GetSmarty();
        $tpl = $smarty->CreateTemplate( 'string:'.$this->get_template(), null, null, $smarty );
        $tpl->assign( 'block_name', $this->block_name );
        $tpl->assign( 'values', $this->values );
        $tpl->assign( 'json_values', $json_values );
        $tpl->assign( 'location', $location );
        $tpl->assign( 'thumbnail_width', $thumbnail_width );
        $tpl->assign( 'thumbnail_height', $thumbnail_height );
        $tpl->assign( 'thumbnail_prefix', ecb2_FileUtils::THUMB_PREFIX );
        $tpl->assign( 'type', $this->field );
        $tpl->assign( 'action_url', $action_url );
        $tpl->assign( 'description', $this->options['description'] );
        return $tpl->fetch();
   
    }



    /**
     *  Data entered by the editor is processed before its saved in props table
     *  Method can be overidden by this class (usually also calls parent class)
     *  
     *  @return string formatted json containing all field data ready to be saved & output
     */
    public function get_content_block_value( $inputArray ) 
    {
        $this->set_field_object( $inputArray );
    
        // handle moving files from _tmp into galleryDir, create thumbnails & delete any unwanted files
        $galleryDir = ecb2_FileUtils::ECB2ImagesPath( $this->block_name, $this->id, '', 
            $this->options['dir'] );
        ecb2_FileUtils::updateGalleryDir( $this->field_object->values, $galleryDir,
            $this->options['auto_add_delete'], $this->options['thumbnail_width'], $this->options['thumbnail_height'] );
    
        return $this->ECB2_json_encode_field_object(); 
    }



}