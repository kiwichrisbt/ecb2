<?php
#---------------------------------------------------------------------------------------------------
# Module: ECB2 - Extended Content Blocks 2
# Author: Chris Taylor
# Copyright: (C) 2016-2023 Chris Taylor, chris@binnovative.co.uk
# Licence: GNU General Public License version 3
#          see /ECB2/lang/LICENCE.txt or <http://www.gnu.org/licenses/gpl-3.0.html>
#---------------------------------------------------------------------------------------------------


if ( !defined('CMS_VERSION') ) exit;

$file_name = $this->ecb2_sanitize_string( get_parameter_value($_POST,'file_name') );
$top_dir = $this->ecb2_sanitize_string( get_parameter_value($_POST,'top_dir') );
$thumbnail_width = $this->ecb2_sanitize_string( get_parameter_value($_POST,'thumbnail_width') );
$thumbnail_height = $this->ecb2_sanitize_string( get_parameter_value($_POST,'thumbnail_height') );

if ( strtolower($_SERVER['REQUEST_METHOD'])!='post' || empty($file_name) ) exit;

if ( empty($top_dir) ) $top_dir = ''; 
if ( empty($thumbnail_width) ) $thumbnail_width = 0; 
if ( empty($thumbnail_height) ) $thumbnail_height = 0; 

$config = cmsms()->GetConfig();
$img_src = cms_join_path( $config['uploads_path'], $top_dir, $file_name  );

$thumbnail_url = ecb2_FileUtils::get_thumbnail_url($img_src, $thumbnail_width, $thumbnail_height);

echo $thumbnail_url;    // '' if no thumbnail


