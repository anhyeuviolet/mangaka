<?php

/**
 * @Project MANGA ON NUKEVIET 4.x
 * @Author KENNYNGUYEN (nguyentiendat713@gmail.com)
 * @License GNU/GPL version 2 or any later version
 * @Createdate 25/08/2015 15:30
 */


if( ! defined( 'NV_ADMIN' ) ) die( 'Stop!!!' );

/**
 * Note:
 * 	- Module var is: $lang, $module_file, $module_data, $module_upload, $module_theme, $module_name
 * 	- Accept global var: $db, $db_config, $global_config
 */
// Dump data
// Them the loai vao DB
$db->query( "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_block_cat (bid, adddefault, numbers, title, alias, image, description, keywords, add_time, edit_time) VALUES
(1, 0, 20, 'Shounen', 'shounen', '', '', '', '". NV_CURRENTTIME ."', '". NV_CURRENTTIME ."'),
(2, 0, 20, 'Ecchi', 'ecchi', '', '', '', '". NV_CURRENTTIME ."', '". NV_CURRENTTIME ."'),
(3, 0, 20, 'Adventure', 'adventure', '', '', '', '". NV_CURRENTTIME ."', '". NV_CURRENTTIME ."'),
(4, 0, 20, 'Drama', 'drama', '', '', '', '". NV_CURRENTTIME ."', '". NV_CURRENTTIME ."'),
(5, 0, 20, 'Horror', 'Horror', '', '', '', '". NV_CURRENTTIME ."', '". NV_CURRENTTIME ."')");

//Mau leech Chapter Blogtruyen.Com, ComicVn, TruyenTranhTuan
$db->query( "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_get_chap (
id, title, url_host, url_html_pattern, url_pattern, img_structure, chapno_structure, preg_img_structure, replace_1, replace_2, replace_3, numget_img, preg_chapno_structure, numget_chap, add_time, edit_time
) VALUES
(1, 'Blogtruyen', 'http://blogtruyen.com', 'div[class=list-wrap]', '.title a', 'article[id=content]', 'h1', '', '', '', '', '', '', '',  '". NV_CURRENTTIME ."',  '". NV_CURRENTTIME ."'),
(2, 'ComicVn', 'http://comicvn.net', 'table.listchapter', 'a', 'textarea[id=txtarea]', 'option[selected=selected]', '', '', '', '', '', '', '',  '". NV_CURRENTTIME ."',  '". NV_CURRENTTIME ."'),
(3, 'TruyenTranhTuan.Com', '', 'div #manga-chapter', 'a', 'null', 'div #read-title p', 'var slides_page_url_path = \\\[(.*?)\\\]', '&quot;', ',', '&quot;', '1', '', '',  '". NV_CURRENTTIME ."',  '". NV_CURRENTTIME ."')");

