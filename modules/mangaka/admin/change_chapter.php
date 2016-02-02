<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 2-10-2010 18:49
 */

if( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );

$id = $nv_Request->get_int( 'id', 'post', 0 );
$catid = $nv_Request->get_int( 'catid', 'post', 0 );
$mod = $nv_Request->get_string( 'mod', 'post', '' );
$new_vid = $nv_Request->get_int( 'new_vid', 'post', 0 );
$content = 'NO_' . $catid;

if( $catid > 0 AND $id > 0 ){
	list($id_i, $catid_i, $old_sort) = $db->query( 'SELECT id, catid, chapter_sort FROM ' . NV_PREFIXLANG . '_' . $module_data . '_' . $catid . ' WHERE id=' . $id  )->fetch(3);
	if($catid_i > 0 AND $id_i>0)
	{
		if( defined( 'NV_IS_ADMIN_MODULE' ) or ( isset( $array_cat_admin[$admin_id][$catid_i] ) and $array_cat_admin[$admin_id][$catid_i]['add_content'] == 1 ) )
		{
			if( $mod == 'chapter_sort' AND $new_vid > 0 )
			{
				$sql1 = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_rows SET chapter_sort=' . $new_vid . ' WHERE catid = ' . $catid_i . ' AND id = ' . $id_i ;
				$db->query( $sql1 );
				
				$sql2 = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_' . $catid_i . ' SET chapter_sort = ' . $new_vid . ' WHERE id = ' . $id_i ;
				$db->query( $sql2 );
				
				$sql3 = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_rows SET chapter_sort = ' . $old_sort . ' WHERE catid = ' . $catid_i . ' AND chapter_sort = ' . $new_vid . ' AND id <> ' . $id_i ;
				$db->query( $sql3 );
				
				$sql4 = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_' . $catid_i . ' SET chapter_sort = ' . $old_sort . ' WHERE chapter_sort = ' . $new_vid . ' AND id <> ' . $id_i ;
				$db->query( $sql4 );
				
				$content = 'OK_' . $catid_i;
			}
		}
		$nv_Cache->delMod( $module_name );
	}
}
include NV_ROOTDIR . '/includes/header.php';
echo $content;
include NV_ROOTDIR . '/includes/footer.php';