<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES., JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 3/9/2010 23:25
 */

if( ! defined( 'NV_MAINFILE' ) ) die( 'Stop!!!' );

if( ! function_exists( 'nv_search_suggest_manga' ) )
{
	/**
	 * nv_search_suggest_manga()
	 *
	 * @param mixed $block_config
	 * @return
	 */
	function nv_search_suggest_manga( $block_config )
	{
		global $site_mods, $my_head, $db_config, $module_name, $module_info, $nv_Request, $catid, $module_config;

		$module = $block_config['module'];
		$mod_data = $site_mods[$module]['module_data'];
		$mod_file = $site_mods[$module]['module_file'];
		$pro_config = $module_config[$module];

		include NV_ROOTDIR . '/modules/' . $mod_file . '/language/' . NV_LANG_DATA . '.php';

		if( file_exists( NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $mod_file . '/block.search_suggest.tpl' ) )
		{
			$block_theme = $module_info['template'];
		}
		else
		{
			$block_theme = 'default';
		}

		$xtpl = new XTemplate( 'block.search_suggest.tpl', NV_ROOTDIR . '/themes/' . $block_theme . '/modules/' . $mod_file );
		$xtpl->assign( 'LANG', $lang_module );
		$xtpl->assign( 'NV_BASE_SITEURL', NV_BASE_SITEURL );
		$xtpl->assign( 'MODULE_NAME', $module );
		$xtpl->assign( 'MODULE_FILE', $mod_file );
		$xtpl->assign( 'SEARCH_URL', NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module . "&amp;" . NV_OP_VARIABLE . "=suggest" );

		$xtpl->parse( 'main' );
		return $xtpl->text( 'main' );
	}
}

$content = nv_search_suggest_manga( $block_config );