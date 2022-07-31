<?php
#---------------------------------------------------------------------------------------------------
# Module: ECB2 - Extended Content Blocks 2
# Author: Chris Taylor
# Copyright: (C) 2016 Chris Taylor, chris@binnovative.co.uk
# Licence: GNU General Public License version 3
#          see /ECB2/lang/LICENCE.txt or <http://www.gnu.org/licenses/>
#---------------------------------------------------------------------------------------------------

class ecb2Properties 
{

    private $content_id;        //?????? is this needed ???????
    // private $properties;

    const MINIMUM_ID = 1000;    // start AUTO_INCREMENT at - any lower ids are newly added fields



	/**
	 *  @return array of properties containing all ecb2 properties for $content_id page
	 */
	public function load_properties($content_id)
	{
		if ( $content_id <= 0 ) return FALSE;

        $this->content_id = $content_id;
		$props = [];
		$db = CmsApp::get_instance()->GetDb();
		$query = 'SELECT * FROM '.CMS_DB_PREFIX.'module_ecb2_props WHERE content_id = ?
            ORDER BY prop_name, position';
		$dbr = $db->GetArray($query, [$content_id]);

        if ( !empty($dbr) ) {
            foreach( $dbr as $row ) {
                $props[$row['prop_name']][$row['id']] = $row['content'];
            }
        }
		return $props;
	}



    /**
     *  save a single property
     */
	public function save_property( $blockName, $ecb_values = [], $content_id )
	{
        if ( $content_id <= 0 || empty($blockName) || !is_array($ecb_values) ) return FALSE;

		$db = CmsApp::get_instance()->GetDb();
		$query = 'SELECT id FROM '.CMS_DB_PREFIX.'module_ecb2_props WHERE content_id = ? 
                    AND prop_name = ?';
		$savedprops = $db->GetCol($query, [$content_id, $blockName]);
        $props_not_updated =array_flip($savedprops);
		$insert_query = 'INSERT INTO '.CMS_DB_PREFIX."module_ecb2_props
            (content_id, type, prop_name, content, position)
            VALUES (?, ?, ?, ?, ?, NOW(), NOW())";
		$update_query = 'UPDATE '.CMS_DB_PREFIX."module_ecb2_props 
            SET content = ?, position = ? WHERE id = ?";  // NOW()
        $position = 1;
        $updated_props = [];
		foreach( $ecb_values as $key => $value ) {
			if ( in_array($key, $savedprops) ) {  // update
				$dbr = $db->Execute($update_query, [$value, $position, $key]);
                unset($props_not_updated[$key]);
                $updated_props[$key] = $key;
			}
			else {  // insert 
				$dbr = $db->Execute($insert_query, [$content_id, 'string', $blockName, $value, $position]);
            }

            $position++;
		}
        // delete any remaining props (deleted by editor)
        if ( !empty($props_not_updated) ) {
            $delete_query = 'DELETE FROM '.CMS_DB_PREFIX.'module_ecb2_props 
                WHERE id IN ('.implode(',', array_keys($props_not_updated)).')';
            $dbr = $db->Execute($delete_query);
        }
		return TRUE;
	}



    /**
     *  to be used for module install/upgrade only
     */
    public function create_database()
    {
        // create module_ecb2_props table
        $db = CmsApp::get_instance()->GetDb();
        $dict = NewDataDictionary($db);
        $taboptarray = array( 'mysql' => 'TYPE=MyISAM' );

// NOTE: type - might be redundant
        $fields = "
            id          I KEY AUTO,
            content_id  I NOTNULL,
            type	    C(25) NOTNULL,
            prop_name	C(255) NOTNULL,
            content	    XL,
            position    I,
            extra	    X"
        ;
        $sqlarray = $dict->CreateTableSQL(CMS_DB_PREFIX.'module_ecb2_props', $fields, $taboptarray);
        $res = $dict->ExecuteSQLArray($sqlarray);
        // add index
        $sqlarray = $dict->CreateIndexSQL('ecb2_idx_props_by_content_id', CMS_DB_PREFIX.'module_ecb2_props', 'content_id');
        $dict->ExecuteSQLArray($sqlarray);
        // start AUTO_INCREMENT at 1000 - any lower ids are newly added fields
        $query = 'ALTER TABLE '.CMS_DB_PREFIX.'module_ecb2_props AUTO_INCREMENT = ?';
        $db->Execute($query, [$this::MINIMUM_ID]);


    }



    /**
     *  to be used for module uninstall only
     */
    public function remove_database()
    {
        $db = CmsApp::get_instance()->GetDb();
        $dict = NewDataDictionary( $db );
        $sqlarray = $dict->DropIndexSQL(CMS_DB_PREFIX.'module_ecb2_props', 'ecb2_idx_props_by_id');
        $dict->ExecuteSQLArray($sqlarray);
        $sqlarray = $dict->DropTableSQL( CMS_DB_PREFIX.'module_ecb2_props');
        $dict->ExecuteSQLArray($sqlarray);
    }



}