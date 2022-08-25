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

    const ECB2_IMAGE_DIR = 'ecb2_images';



    /**
     *  @return string path to ECB2 images dir
     */
    public static function ECB2ImagesPath() 
    {
        $config = cmsms()->GetConfig();
        return cms_join_path( $config['image_uploads_path'], self::ECB2_IMAGE_DIR ).DIRECTORY_SEPARATOR;
    }



    /**
     *  @return string url to ECB2 images dir
     */
    public static function ECB2ImagesUrl() 
    {
        $config = cmsms()->GetConfig();
        return cms_join_path( $config['uploads_url'], 'images', self::ECB2_IMAGE_DIR ).DIRECTORY_SEPARATOR;
    }



    /**
     *  creates the ECB2 images dir - if it doesn't already exist
     */
    public static function CreateImagesDir() 
    {
        $ecb2_images_dir = self::ECB2ImagesPath();
        if ( !file_exists($ecb2_images_dir) ) {
            mkdir($ecb2_images_dir, 0777, true);
        }
    }



    /**
     *  unique filename for ECB2 images dir, if filename already exists, it has _x 
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
     *  upload file into ecb2_images_dir with unique filename if necessary
     *
     *  @return mixed $unique_filename or FALSE on failure of upload
     *  @param string $original_filename - original filename of uploaded file
     *  @param string $tmp_filename - temp filename of the file on the server
     */
    public static function ECB2MoveUploadedFile( $original_filename, $tmp_filename  ) 
    {
        if ( empty($original_filename) || empty($tmp_filename) ) return false;

        $ecb2_images_path = self::ECB2ImagesPath();
        $unique_filename = self::ECB2UniqueFilename( $original_filename );
        $success = cms_move_uploaded_file( $tmp_filename, $ecb2_images_path.$unique_filename );
        
        if (!$success) return FALSE;

        return $unique_filename;

    }



}