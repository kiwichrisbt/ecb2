<?php
#---------------------------------------------------------------------------------------------------
# Module: ECB2 - Extended Content Blocks 2
# Author: Chris Taylor
# Copyright: (C) 2016 Chris Taylor, chris@binnovative.co.uk
# Licence: GNU General Public License version 3
#          see /ECB2/lang/LICENCE.txt or <http://www.gnu.org/licenses/>
#---------------------------------------------------------------------------------------------------


if (!isset($gCms)) exit;

// Setup Module Permissions
$this->CreatePermission(ECB2::MANAGE_PERM,'Extended Content Blocks 2 - Manage');


// create module_ecb2_props table
$props_table = new ecb2Properties();
$props_table->create_database();

// $db = $this->GetDb();
// $dict = NewDataDictionary($db);
// $taboptarray = array( 'mysql' => 'TYPE=MyISAM' );
// $fields = "
// 	content_id I NOTNULL,
// 	type	C(25) NOTNULL,
// 	name	C(255) NOTNULL,
// 	content	XL,
// 	param1	C(255),
// 	param2	C(255),
// 	param3	C(255),
// 	modified_date   T DEFTIMESTAMP,
// 	create_date     T DEFTIMESTAMP
// ";
// $sqlarray = $dict->CreateTableSQL(CMS_DB_PREFIX.'module_ecb2_props', $fields, $taboptarray);
// $res = $dict->ExecuteSQLArray($sqlarray);
// // add index
// $sqlarray = $dict->CreateIndexSQL('ecb2_idx_props_by_id', CMS_DB_PREFIX.'module_ecb2_props', 'content_id');
// $dict->ExecuteSQLArray($sqlarray);

//  create module_ecb2_blocks table
$blocks_table = new ecb2Blocks();
$blocks_table->create_database();
// $fields = "
//     id       I KEY AUTO,
//     type	 C(25) NOTNULL,
//     name	 C(255) NOTNULL,
//     group_id I,
//     attribs  X,
//     position I
// ";
// $sqlarray = $dict->CreateTableSQL(CMS_DB_PREFIX.'module_ecb2_blocks', $fields, $taboptarray);
// $res = $dict->ExecuteSQLArray($sqlarray);


