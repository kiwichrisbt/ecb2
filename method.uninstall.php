<?php
#---------------------------------------------------------------------------------------------------
# Module: ECB2 - Extended Content Blocks 2
# Author: Chris Taylor
# Copyright: (C) 2016 Chris Taylor, chris@binnovative.co.uk
# Licence: GNU General Public License version 3
#          see /ECB2/lang/LICENCE.txt or <http://www.gnu.org/licenses/>
#---------------------------------------------------------------------------------------------------

if (!isset($gCms)) exit;

// remove the permissions, etc
$this->RemovePermission(ECB2::MANAGE_PERM);
$this->RemovePreference();
$this->DeleteTemplate();



// remove the database tables & index
$props_table = new ecb2Properties();
$props_table->remove_database();
// $db = $this->GetDb();
// $dict = NewDataDictionary( $db );
// $sqlarray = $dict->DropIndexSQL(CMS_DB_PREFIX.'module_ecb2_props', 'ecb2_idx_props_by_id');
// $dict->ExecuteSQLArray($sqlarray);
// $sqlarray = $dict->DropTableSQL( CMS_DB_PREFIX.'module_ecb2_props');
// $dict->ExecuteSQLArray($sqlarray);
$blocks_table = new ecb2Blocks();
$blocks_table->remove_database();
// $sqlarray = $dict->DropTableSQL( CMS_DB_PREFIX.'module_ecb2_blocks');
// $dict->ExecuteSQLArray($sqlarray);


