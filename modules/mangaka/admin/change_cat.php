<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 2-10-2010 18:49
 */

if( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );

$catid = $nv_Request->get_int( 'catid', 'post', 0 );
$mod = $nv_Request->get_string( 'mod', 'post', '' );
$new_vid = $nv_Request->get_int( 'new_vid', 'post', 0 );
$content = 'NO_' . $catid;

list( $catid, $parentid, $numsubcat ) = $db->query( 'SELECT catid, parentid, numsubcat FROM ' . NV_PREFIXLANG . '_' . $module_data . '_cat WHERE catid=' . $catid  )->fetch( 3 );
if( $catid > 0 )
{
	if( defined( 'NV_IS_ADMIN_MODULE' ) or ( isset( $array_cat_admin[$admin_id][$catid] ) and $array_cat_admin[$admin_id][$catid]['add_content'] == 1 ) )
	{
		if( $mod == 'inhome' and ( $new_vid == 0 or $new_vid == 1 ) )
		{
			$sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_cat SET inhome=' . $new_vid . ' WHERE catid=' . $catid ;
			$db->query( $sql );
			$content = 'OK_' . $parentid;
		}

	}
	nv_del_moduleCache( $module_name );
}

include NV_ROOTDIR . '/includes/header.php';
echo $content;
include NV_ROOTDIR . '/includes/footer.php';