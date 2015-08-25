<?php

/**
 * @Project MANGA ON NUKEVIET 4.x
 * @Author KENNYNGUYEN (nguyentiendat713@gmail.com)
 * @License GNU/GPL version 2 or any later version
 * @Createdate 15/07/2015 10:51
 */

if( ! defined( 'NV_IS_FILE_MODULES' ) ) die( 'Stop!!!' );

$sql_drop_module = array();
$array_table = array(
	'admins',
	'block',
	'block_cat',
	'bodytext',
	'cat',
	'config_post',
	'rows',
	'get_chap',
	'get_manga',
	'logs',
);
$table = $db_config['prefix'] . '_' . $lang . '_' . $module_data;
$result = $db->query( 'SHOW TABLE STATUS LIKE ' . $db->quote( $table . '_%' ) );
while( $item = $result->fetch( ) )
{
	$name = substr( $item['name'], strlen( $table ) + 1 );
	if( preg_match( '/^' . $db_config['prefix'] . '\_' . $lang . '\_' . $module_data . '\_/', $item['name'] ) and ( preg_match( '/^([0-9]+)$/', $name ) or in_array( $name, $array_table ) or preg_match( '/^bodyhtml\_([0-9]+)$/', $name ) ) )
	{
		$sql_drop_module[] = 'DROP TABLE IF EXISTS ' . $item['name'];
	}
}

$result = $db->query( "SHOW TABLE STATUS LIKE '" . $db_config['prefix'] . "\_" . $lang . "\_comment'" );
$rows = $result->fetchAll();
if( sizeof( $rows ) )
{
	$sql_drop_module[] = "DELETE FROM " . $db_config['prefix'] . "_" . $lang . "_comment WHERE module='" . $module_name . "'";
}

$sql_create_module = $sql_drop_module;

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_cat (
	 catid int(11) unsigned NOT NULL AUTO_INCREMENT,
	 title varchar(255) NOT NULL,
	 titlesite varchar(255) DEFAULT '',
	 alias varchar(255) NOT NULL DEFAULT '',
	 description text,
	 descriptionhtml text,
	 image varchar(255) DEFAULT '',
	 image_type varchar(255) DEFAULT '',
	 progress tinyint(2) NOT NULL DEFAULT '0',
	 viewcat varchar(50) NOT NULL DEFAULT 'viewcat_list',
	 numsubcat smallint(5) NOT NULL DEFAULT '0',
	 inhome tinyint(1) unsigned NOT NULL DEFAULT '1',
	 keywords text,
	 authors text,
	 translators text,
	 bid varchar(255) NOT NULL default '',
	 admins text,
	 add_time int(11) unsigned NOT NULL DEFAULT '0',
	 edit_time int(11) unsigned NOT NULL DEFAULT '0',
	 last_update int(11) unsigned NOT NULL DEFAULT '0',
	 groups_view varchar(255) DEFAULT '',
	 allowed_comm varchar(255) DEFAULT '',
 	 hitscm mediumint(8) unsigned NOT NULL default '0',
 	 allowed_rating tinyint(1) unsigned NOT NULL default '0',
	 total_rating int(11) NOT NULL default '0',
	 click_rating int(11) NOT NULL default '0',
	 PRIMARY KEY (catid),
	 UNIQUE KEY alias (alias)
	) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_get_chap (
	 id smallint(5) unsigned NOT NULL AUTO_INCREMENT,
	 title varchar(255) NOT NULL,
	 url_host varchar(255) NOT NULL,
	 url_html_pattern varchar(255) DEFAULT '', 
	 url_pattern varchar(255) DEFAULT '',
	 img_structure varchar(255) DEFAULT '',
	 chapno_structure varchar(255) DEFAULT '',
	 preg_img_structure varchar(255) DEFAULT '',
	 replace_1 varchar(255) DEFAULT '',
	 replace_2 varchar(255) DEFAULT '',
	 replace_3 varchar(255) DEFAULT '',
	 numget_img varchar(255) DEFAULT '',
	 preg_chapno_structure varchar(255) DEFAULT '',
	 numget_chap varchar(255) DEFAULT '',
	 add_time int(11) unsigned NOT NULL DEFAULT '0',
	 edit_time int(11) unsigned NOT NULL DEFAULT '0',
	 PRIMARY KEY (id)
	) ENGINE=MyISAM";
	
	$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_get_manga (
	 id smallint(5) unsigned NOT NULL AUTO_INCREMENT,
	 title varchar(255) NOT NULL,
	 html_title varchar(255) NOT NULL,
	 html_description varchar(255) DEFAULT '', 
	 html_author varchar(255) DEFAULT '',
	 html_trans varchar(255) DEFAULT '',
	 html_genre varchar(255) DEFAULT '',
	 html_img_thumb varchar(255) DEFAULT '',
	 add_time int(11) unsigned NOT NULL DEFAULT '0',
	 edit_time int(11) unsigned NOT NULL DEFAULT '0',
	 PRIMARY KEY (id)
	) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_block_cat (
	 bid smallint(5) unsigned NOT NULL AUTO_INCREMENT,
	 adddefault tinyint(4) NOT NULL DEFAULT '0',
	 numbers smallint(5) NOT NULL DEFAULT '20',
	 title varchar(255) NOT NULL DEFAULT '',
	 alias varchar(255) NOT NULL DEFAULT '',
	 image varchar(255) DEFAULT '',
	 description varchar(255) DEFAULT '',
	 keywords text,
	 add_time int(11) NOT NULL DEFAULT '0',
	 edit_time int(11) NOT NULL DEFAULT '0',
	 PRIMARY KEY (bid),
	 UNIQUE KEY title (title),
	 UNIQUE KEY alias (alias)
	) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_block (
	bid mediumint(8) unsigned NOT NULL,
	catid mediumint(8) unsigned NOT NULL,
	id int(11) unsigned NOT NULL,
	UNIQUE KEY bid (bid,catid)
	) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_rows (
	 id int(11) unsigned NOT NULL auto_increment,
	 catid smallint(5) unsigned NOT NULL default '0',
	 listcatid varchar(255) NOT NULL default '',
	 admin_id mediumint(8) unsigned NOT NULL default '0',
	 author varchar(255) default '',
	 addtime int(11) unsigned NOT NULL default '0',
	 edittime int(11) unsigned NOT NULL default '0',
	 status tinyint(4) NOT NULL default '1',
	 publtime int(11) unsigned NOT NULL default '0',
	 exptime int(11) unsigned NOT NULL default '0',
	 archive tinyint(1) unsigned NOT NULL default '0',
	 title varchar(255) NOT NULL default '',
	 alias varchar(255) NOT NULL default '',
	 chapter float(1) default '0',
	 inhome tinyint(1) unsigned NOT NULL default '0',
	 allowed_rating tinyint(1) unsigned NOT NULL default '0',
	 hitstotal mediumint(8) unsigned NOT NULL default '0',
	 total_rating int(11) NOT NULL default '0',
	 click_rating int(11) NOT NULL default '0',
	 PRIMARY KEY (id),
	 KEY catid (catid),
	 KEY admin_id (admin_id),
	 KEY author (author),
	 KEY title (title),
	 KEY addtime (addtime),
	 KEY publtime (publtime),
	 KEY exptime (exptime),
	 KEY status (status),
	 UNIQUE KEY chapter (chapter,catid)
	) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE IF NOT EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_bodytext (
	 id int(11) unsigned NOT NULL,
	 bodytext text NOT NULL,
	 PRIMARY KEY (id)
	) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE IF NOT EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_bodyhtml_1 (
	 id int(11) unsigned NOT NULL,
	 bodyhtml text NOT NULL,
	 PRIMARY KEY (id)
	) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE IF NOT EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_logs (
	 id mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
	 sid mediumint(8) NOT NULL DEFAULT '0',
	 userid mediumint(8) unsigned NOT NULL DEFAULT '0',
	 status tinyint(4) NOT NULL DEFAULT '0',
	 note varchar(255) NOT NULL,
	 set_time int(11) unsigned NOT NULL DEFAULT '0',
	 PRIMARY KEY (id),
	 KEY sid (sid),
	 KEY userid (userid)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE IF NOT EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_config_post (
	 group_id smallint(5) NOT NULL,
	 addcontent tinyint(4) NOT NULL,
	 postcontent tinyint(4) NOT NULL,
	 editcontent tinyint(4) NOT NULL,
	 delcontent tinyint(4) NOT NULL,
	 PRIMARY KEY (group_id)
	) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_admins (
	 userid mediumint(8) unsigned NOT NULL default '0',
	 catid smallint(5) NOT NULL default '0',
	 admin tinyint(4) NOT NULL default '0',
	 add_content tinyint(4) NOT NULL default '0',
	 pub_content tinyint(4) NOT NULL default '0',
	 edit_content tinyint(4) NOT NULL default '0',
	 del_content tinyint(4) NOT NULL default '0',
	 app_content tinyint(4) NOT NULL default '0',
	 UNIQUE KEY userid (userid,catid)
	) ENGINE=MyISAM";

$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'indexfile', 'viewcat_full_home')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'per_page', '20')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'homewidth', '400')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'homeheight', '300')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'blockwidth', '200')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'blockheight', '250')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'imagefull', '460')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'timecheckstatus', '0')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'show_no_image', '')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'allowed_rating_point', '1')";

$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'facebookappid', '')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'facebookadminid', '')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'facebookcomment', '')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'disqus_shortname', '')";

$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'socialbutton', '1')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'alias_lower', '1')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'structure_upload', 'Ym')";

// Comments
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'auto_postcomm', '1')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'allowed_comm', '-1')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'view_comm', '6')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'setcomm', '4')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'activecomm', '1')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'emailcomm', '0')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'adminscomm', '')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'sortcomm', '0')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'captcha', '1')";
