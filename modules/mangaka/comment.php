<?php

/**
 * @Project MANGA ON NUKEVIET 4.x
 * @Author KENNYNGUYEN (nguyentiendat713@gmail.com)
 * @License GNU/GPL version 2 or any later version
 * @Createdate 15/07/2015 10:51
 */

if( ! defined( 'NV_MAINFILE' ) )	die( 'Stop!!!' );

// Chi ap dung cho phan Viewcat
// Cap nhat lai so luong comment duoc kich hoat
$numf = $db->query( 'SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_comment where module= ' . $db->quote( $row['module'] ) . ' AND id=' . $row['id'] . ' AND status=1' )->fetchColumn();
$query = 'UPDATE ' . NV_PREFIXLANG . '_' . $mod_info['module_data'] . '_cat SET hitscm=' . $numf . ' WHERE catid=' . $row['id'];
$db->query( $query );