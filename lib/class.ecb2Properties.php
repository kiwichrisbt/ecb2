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

    private $content_id;
    private $properties;



	/**
	 *  sets $this->properties to contain all ecb2 properties for $content_id page
	 */
	public function load_properties($content_id)
	{
		if ( $content_id <= 0 ) return FALSE;

        $this->content_id = $content_id;
		$this->properties = [];
		$db = CmsApp::get_instance()->GetDb();
		$query = 'SELECT * FROM '.CMS_DB_PREFIX.'module_ecb2_props WHERE content_id = ?';
		$dbr = $db->GetArray($query, [(int)$this->content_id]);

		foreach( $dbr as $row ) {
			$this->properties[$row['name']] = $row['content'];
		}
		return TRUE;
	}



    /**
     *  save a single property
     */
	public function save_property( $blockName, $ecb_values = [], $content_id )
	{
        if ( $content_id <= 0 || !is_array($ecb_values) ) return FALSE;

		$db = CmsApp::get_instance()->GetDb();
		$query = 'SELECT content_id FROM '.CMS_DB_PREFIX.'module_ecb2_props WHERE content_id = ?';
		$gotprops = $db->GetCol($query, [$content_id]);

		$now = $db->DbTimeStamp(time());
		$iquery = 'INSERT INTO '.CMS_DB_PREFIX."module_ecb2_props
                    (content_id,type,prop_name,content,modified_date)
                    VALUES (?,?,?,?,$now)";
		$uquery = 'UPDATE '.CMS_DB_PREFIX."module_ecb2_props SET content = ?, modified_date = $now WHERE content_id = ? AND prop_name = ?";

		foreach( $this->_props as $key => $value ) {
			if( in_array($key,$gotprops) ) {
				// update
				$dbr = $db->Execute($uquery,array($value,$this->mId,$key));
			}
			else {
				// insert
				$dbr = $db->Execute($iquery,array($this->mId,'string',$key,$value));
			}

            // also need delete
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
        $fields = "
            id          I KEY AUTO,
            content_id  I NOTNULL,
            type	    C(25) NOTNULL,
            prop_name	C(255) NOTNULL,
            content	    XL,
            position    I,
            param1	    C(255),
            param2	    C(255),
            param3	    C(255),
            modified_date   T DEFTIMESTAMP,
            create_date     T DEFTIMESTAMP
        ";
        $sqlarray = $dict->CreateTableSQL(CMS_DB_PREFIX.'module_ecb2_props', $fields, $taboptarray);
        $res = $dict->ExecuteSQLArray($sqlarray);
        // add index
        $sqlarray = $dict->CreateIndexSQL('ecb2_idx_props_by_content_id', CMS_DB_PREFIX.'module_ecb2_props', 'content_id');
        $dict->ExecuteSQLArray($sqlarray);
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