<?php
#---------------------------------------------------------------------------------------------------
# Module: ECB2 - Extended Content Blocks 2
# Author: Chris Taylor
# Copyright: (C) 2016 Chris Taylor, chris@binnovative.co.uk
# Licence: GNU General Public License version 3
#          see /ECB2/lang/LICENCE.txt or <http://www.gnu.org/licenses/>
#---------------------------------------------------------------------------------------------------

class ecb2_FileUtils 
{

    const ECB2_IMAGE_DIR = '_ecb2_images';
    const ECB2_IMAGE_TEMP_DIR = '_tmp';     // sub dir of ECB2_IMAGE_DIR
    const THUMB_PREFIX = 'thumb_'; 


    /**
     *  @return string path to ECB2 images temp sub dir: /ECB2_IMAGE_DIR/ECB2_IMAGE_TEMP_DIR
     */
    public static function ECB2ImagesTempPath() 
    {
        $config = cmsms()->GetConfig();
        return cms_join_path( $config['image_uploads_path'], self::ECB2_IMAGE_DIR, 
            self::ECB2_IMAGE_TEMP_DIR ).DIRECTORY_SEPARATOR;
    }



    /**
     *  @return string path to unique ECB2 images sub dir: /ECB2_IMAGE_DIR/blockname_module_id
     *  @param string $blockname - name of props blockname
     *  @param string $id - content id - i.e. page id
     *  @param string $module - if not Content page (default) - not actually used yet
     *  @param string $uploads_dir - if set is a subdir of /uploads to use
     */
    public static function ECB2ImagesPath( $blockname, $id='', $module='', $uploads_dir='' ) 
    {
        $config = cmsms()->GetConfig();
        if ( !empty($uploads_dir) ) {
            $imagesPath = cms_join_path( $config['image_uploads_path'], $uploads_dir );
            return $imagesPath.DIRECTORY_SEPARATOR;
        }

        if ( empty($blockname) ) return FALSE;

        $imagesPath = cms_join_path( $config['image_uploads_path'], self::ECB2_IMAGE_DIR );
        $dirname = munge_string_to_url( $blockname. ($module ? '_'.$module : '') . ($id ? '_'.$id : '') );
        return $imagesPath.DIRECTORY_SEPARATOR.$dirname.DIRECTORY_SEPARATOR;
    }



    /**
     *  @return string url to either a subdir of /uploads, or a unique ECB2 images sub dir: 
     *                   /ECB2_IMAGE_DIR/blockname_module_id
     *  @param string $blockname - name of props blockname
     *  @param string $id - content id - i.e. page id
     *  @param string $module - if not Content page (default) - not actually used yet
     *  @param string $uploads_dir - if set is a subdir of /uploads to use
     */
    public static function ECB2ImagesUrl( $blockname, $id, $module='', $uploads_dir='' ) 
    {
        $config = cmsms()->GetConfig();
        if ( !empty($uploads_dir) ) {
            $ecb2Url = cms_join_path( $config['image_uploads_url'], $uploads_dir );
            return $ecb2Url.DIRECTORY_SEPARATOR;
        }

        if ( empty($blockname) ) return FALSE;

        $ecb2Url = cms_join_path( $config['image_uploads_url'], self::ECB2_IMAGE_DIR ).DIRECTORY_SEPARATOR;
        $dirname = munge_string_to_url( $blockname. ($module ? '_'.$module : '') . ($id ? '_'.$id : '') );
        return $ecb2Url.$dirname.DIRECTORY_SEPARATOR;
    }



    /**
     *  creates the unique ECB2 images sub dir - if it doesn't already exist: 
     *          /ECB2_IMAGE_DIR/blockname_module_id
     *      or the ECB2_IMAGE_DIR/ECB2_IMAGE_TEMP_DIR if params all empty
     *  @param string $blockname - name of props blockname
     *  @param string $id - content id - i.e. page id
     *  @param string $module - if not Content page (default) - not actually used yet
     *  @param string $uploads_dir - if set is a subdir of /uploads/images to use (default)
     */
    public static function CreateImagesDir( $blockname='', $id='', $module='', $uploads_dir='' )
    {
        $success = false;
        if ( !empty($uploads_dir) || !empty($blockname) ) {
            $ecb2_images_dir = self::ECB2ImagesPath( $blockname, $id, $module, $uploads_dir );
        } else {
            $ecb2_images_dir = self::ECB2ImagesPath( self::ECB2_IMAGE_TEMP_DIR );
        }

        if ( $ecb2_images_dir && !file_exists($ecb2_images_dir) ) {
            $success = mkdir($ecb2_images_dir, 0755, true);
        }
        return $success;
    }



    /** NB: NOT CURRENTLY USED...
     *  unique filename for ECB2 images, if filename already exists, it has _x 
     *      appended before the suffix, e.g. 'new_image_1.jpg', then 'new_image_2.jpg' 
     *
     *  @return string unique filename 
     *  @param string $uploaded_filename - original filename to make unique
     *  @param string $dir - directory to check for unique filename
     */
    public static function ECB2UniqueFilename( $uploaded_filename, $dir='' ) 
    {
        if ( empty($uploaded_filename) ) return;

        $dir_to_check = ( !empty($dir) ) ? $dir : self::ECB2ImagesPath();
        $tmp_filename = basename($uploaded_filename);   // may prevent filesystem traversal attacks
        $filename_only = pathinfo($tmp_filename, PATHINFO_FILENAME);
        $extension_only =  pathinfo($tmp_filename, PATHINFO_EXTENSION);
        $FileCounter = 0;

        while ( file_exists($dir_to_check.$tmp_filename) ) {
            $FileCounter++;
            $tmp_filename = $filename_only.'_'.$FileCounter.'.'.$extension_only;
        }

        return $tmp_filename;
    }



    /**
     *  upload file into ECB2ImagesTempPath
     *
     *  @return boolean $success
     *  @param string $original_filename - original filename of uploaded file
     *  @param string $tmp_filename - temp filename of the file on the server
     */
    public static function ECB2MoveUploadedFile( $original_filename, $tmp_filename  ) 
    {
        if ( empty($original_filename) || empty($tmp_filename) ) return false;

        $ecb2_images_path = self::ECB2ImagesTempPath();
        $success = cms_move_uploaded_file( $tmp_filename, $ecb2_images_path.$original_filename );
        return $success;

    }



    /**
     *  move files from _tmp into $dir, deleting any unwanted files
     *  existing files with same name will not be overwritten
     *
     *  @param array $values - filenames of all files in the gallery
     *  @param string $dir - directory to be updated with set gallery images
     *  @param boolean $auto_add_delete - if set delete any unused images & thumbnails
     */
    public static function updateGalleryDir( $values, $dir, $auto_add_delete )
    {
        if ( empty($values) ) return;

        $tmp_dir = self::ECB2ImagesTempPath();
        // create $dir if it doesn't exist
        if ( $dir && !file_exists($dir) ) {
            $success = mkdir($dir, 0755, true);
        }
        foreach ($values as $filename) {
            if ( !file_exists($dir.$filename) && file_exists($tmp_dir.$filename)) {
                rename( $tmp_dir.$filename, $dir.$filename );   // moves file from _tmp
            }
        }

        // if $auto_add_delete remove any unused files (& thumbnails <<< not yet done)
        foreach ( glob( $dir.'*.*' ) as $filename) {
            $tmp_filename = basename($filename);
            if ( !in_array($tmp_filename, $values) ) unlink($filename);
        }
    
    }



    /**
     *  move files from _tmp into $dir, deleting any unwanted files
     *  existing files with same name will not be overwritten
     *
     *  @param array $values - filenames of already selected files in the dir
     *  @param string $dir - directory to be used for this gallery
     *  @return array $all_filenames - any additional filenames, appended to 
     */
    public static function autoAddDirImages( $values, $dir)
    {
        $all_filenames = $values;
        foreach ( glob( $dir.'*.*' ) as $filename) {
            $tmp_filename = basename($filename);
            if ( !self::isECB2Thumb($tmp_filename) && !in_array($tmp_filename, $values) ) {
                $all_filenames[] = $tmp_filename;
            }
        }
        return $all_filenames;
    }


    /**
     * @return boolean true if $haystack starts with self::THUMB_PREFIX ('thumb_')
     */
    public static function isECB2Thumb( $haystack ) 
    {
        $length = strlen( self::THUMB_PREFIX );
        return substr( $haystack, 0, $length ) === self::THUMB_PREFIX;
    }



}