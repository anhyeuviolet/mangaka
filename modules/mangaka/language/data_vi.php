<?php

/**
 * @Project MANGA ON NUKEVIET 4.x
 * @Author KENNYNGUYEN (nguyentiendat713@gmail.com)
 * @License GNU/GPL version 2 or any later version
 * @Createdate 25/08/2015 15:30
 */


if( ! defined( 'NV_ADMIN' ) ) die( 'Stop!!!' );


// Add Genre
$db->query( "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_block_cat (bid, adddefault, numbers, title, alias, image, description, keywords, add_time, edit_time) VALUES
(1, 0, 20, '16+', '16', '', '', '', '". NV_CURRENTTIME ."', '". NV_CURRENTTIME ."'),
(2, 0, 25, '18+', '18', '', '', '', '". NV_CURRENTTIME ."', '". NV_CURRENTTIME ."'),
(3, 0, 25, 'Action', 'Action', '', '', '', '". NV_CURRENTTIME ."', '". NV_CURRENTTIME ."'),
(4, 0, 25, 'Adult', 'Adult', '', '', '', '". NV_CURRENTTIME ."', '". NV_CURRENTTIME ."'),
(5, 0, 25, 'Adventure', 'Adventure', '', '', '', '". NV_CURRENTTIME ."', '". NV_CURRENTTIME ."'),
(6, 0, 25, 'Anime', 'Anime', '', '', '', '". NV_CURRENTTIME ."', '". NV_CURRENTTIME ."'),
(7, 0, 25, 'Comedy', 'Comedy', '', '', '', '". NV_CURRENTTIME ."', '". NV_CURRENTTIME ."'),
(8, 0, 25, 'Comic', 'Comic', '', '', '', '". NV_CURRENTTIME ."', '". NV_CURRENTTIME ."'),
(9, 0, 25, 'Doujinshi', 'Doujinshi', '', '', '', '". NV_CURRENTTIME ."', '". NV_CURRENTTIME ."'),
(10, 0, 25, 'Drama', 'Drama', '', '', '', '". NV_CURRENTTIME ."', '". NV_CURRENTTIME ."'),
(11, 0, 25, 'Ecchi', 'Ecchi', '', '', '', '". NV_CURRENTTIME ."', '". NV_CURRENTTIME ."'),
(12, 0, 25, 'Fantasy', 'Fantasy', '', '', '', '". NV_CURRENTTIME ."', '". NV_CURRENTTIME ."'),
(13, 0, 25, 'Gender Bender', 'Gender-Bender', '', '', '', '". NV_CURRENTTIME ."', '". NV_CURRENTTIME ."'),
(14, 0, 25, 'Harem', 'Harem', '', '', '', '". NV_CURRENTTIME ."', '". NV_CURRENTTIME ."'),
(15, 0, 25, 'Historical', 'Historical', '', '', '', '". NV_CURRENTTIME ."', '". NV_CURRENTTIME ."'),
(16, 0, 25, 'Horror', 'Horror', '', '', '', '". NV_CURRENTTIME ."', '". NV_CURRENTTIME ."'),
(17, 0, 25, 'Josei', 'Josei', '', '', '', '". NV_CURRENTTIME ."', '". NV_CURRENTTIME ."'),
(18, 0, 25, 'Live Action', 'Live-Action', '', '', '', '". NV_CURRENTTIME ."', '". NV_CURRENTTIME ."'),
(19, 0, 25, 'Magic', 'Magic', '', '', '', '". NV_CURRENTTIME ."', '". NV_CURRENTTIME ."'),
(20, 0, 25, 'Manga', 'Manga', '', '', '', '". NV_CURRENTTIME ."', '". NV_CURRENTTIME ."'),
(21, 0, 25, 'Manhua', 'Manhua', '', '', '', '". NV_CURRENTTIME ."', '". NV_CURRENTTIME ."'),
(22, 0, 25, 'Manhwa', 'Manhwa', '', '', '', '". NV_CURRENTTIME ."', '". NV_CURRENTTIME ."'),
(23, 0, 25, 'Martial Arts', 'Martial-Arts', '', '', '', '". NV_CURRENTTIME ."', '". NV_CURRENTTIME ."'),
(24, 0, 25, 'Mature', 'Mature', '', '', '', '". NV_CURRENTTIME ."', '". NV_CURRENTTIME ."'),
(25, 0, 25, 'Mecha', 'Mecha', '', '', '', '". NV_CURRENTTIME ."', '". NV_CURRENTTIME ."'),
(26, 0, 25, 'Mystery', 'Mystery', '', '', '', '". NV_CURRENTTIME ."', '". NV_CURRENTTIME ."'),
(27, 0, 25, 'Nấu Ăn', 'Nau-An', '', '', '', '". NV_CURRENTTIME ."', '". NV_CURRENTTIME ."'),
(28, 0, 25, 'One shot', 'One-shot', '', '', '', '". NV_CURRENTTIME ."', '". NV_CURRENTTIME ."'),
(29, 0, 25, 'Psychological', 'Psychological', '', '', '', '". NV_CURRENTTIME ."', '". NV_CURRENTTIME ."'),
(30, 0, 25, 'Romance', 'Romance', '', '', '', '". NV_CURRENTTIME ."', '". NV_CURRENTTIME ."'),
(31, 0, 25, 'School Life', 'School-Life', '', '', '', '". NV_CURRENTTIME ."', '". NV_CURRENTTIME ."'),
(32, 0, 25, 'Sci-fi', 'Sci-fi', '', '', '', '". NV_CURRENTTIME ."', '". NV_CURRENTTIME ."'),
(33, 0, 25, 'Seinen', 'Seinen', '', '', '', '". NV_CURRENTTIME ."', '". NV_CURRENTTIME ."'),
(34, 0, 25, 'Shoujo', 'Shoujo', '', '', '', '". NV_CURRENTTIME ."', '". NV_CURRENTTIME ."'),
(35, 0, 25, 'Shoujo Ai', 'Shoujo-Ai', '', '', '', '". NV_CURRENTTIME ."', '". NV_CURRENTTIME ."'),
(36, 0, 25, 'Shounen', 'Shounen', '', '', '', '". NV_CURRENTTIME ."', '". NV_CURRENTTIME ."'),
(37, 0, 25, 'Shounen Ai', 'Shounen-Ai', '', '', '', '". NV_CURRENTTIME ."', '". NV_CURRENTTIME ."'),
(38, 0, 25, 'Slice of life', 'Slice-of-life', '', '', '', '". NV_CURRENTTIME ."', '". NV_CURRENTTIME ."'),
(39, 0, 25, 'Smut', 'Smut', '', '', '', '". NV_CURRENTTIME ."', '". NV_CURRENTTIME ."'),
(40, 0, 25, 'Soft Yaoi', 'Soft-Yaoi', '', '', '', '". NV_CURRENTTIME ."', '". NV_CURRENTTIME ."'),
(41, 0, 25, 'Soft Yuri', 'Soft-Yuri', '', '', '', '". NV_CURRENTTIME ."', '". NV_CURRENTTIME ."'),
(42, 0, 25, 'Sports', 'Sports', '', '', '', '". NV_CURRENTTIME ."', '". NV_CURRENTTIME ."'),
(43, 0, 25, 'Supernatural', 'Supernatural', '', '', '', '". NV_CURRENTTIME ."', '". NV_CURRENTTIME ."'),
(44, 0, 25, 'Tragedy', 'Tragedy', '', '', '', '". NV_CURRENTTIME ."', '". NV_CURRENTTIME ."'),
(45, 0, 25, 'Trap &#40;Crossdressing&#41;', 'Trap-Crossdressing', '', '', '', '". NV_CURRENTTIME ."', '". NV_CURRENTTIME ."'),
(46, 0, 25, 'Trinh Thám', 'Trinh-Tham', '', '', '', '". NV_CURRENTTIME ."', '". NV_CURRENTTIME ."'),
(47, 0, 25, 'Truyện scan', 'Truyen-scan', '', '', '', '". NV_CURRENTTIME ."', '". NV_CURRENTTIME ."'),
(48, 0, 25, 'Video Clip', 'Video-Clip', '', '', '', '". NV_CURRENTTIME ."', '". NV_CURRENTTIME ."'),
(49, 0, 25, 'VnComic', 'VnComic', '', '', '', '". NV_CURRENTTIME ."', '". NV_CURRENTTIME ."'),
(50, 0, 25, 'Webtoon', 'Webtoon', '', '', '', '". NV_CURRENTTIME ."', '". NV_CURRENTTIME ."'),
(51, 0, 25, 'Yuri', 'Yuri', '', '', '', '". NV_CURRENTTIME ."', '". NV_CURRENTTIME ."'),
(52, 0, 25, 'Truyện full', 'truyen-full', '', '', '','". NV_CURRENTTIME ."', '". NV_CURRENTTIME ."')");

//Add leech sample Chapter from Blogtruyen.Com, ComicVn, TruyenTranhTuan
$db->query( "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_get_chap (
id, title, url_host, url_html_pattern, url_pattern, img_structure, chapno_structure, preg_img_structure, replace_1, replace_2, replace_3, numget_img, preg_chapno_structure, numget_chap, add_time, edit_time
) VALUES
(1, 'Blogtruyen', 'http://blogtruyen.com/', 'div[class=list-wrap]', '.title a', 'article[id=content]', 'h1', '', '', '', '', '', '', '',  '". NV_CURRENTTIME ."',  '". NV_CURRENTTIME ."'),
(2, 'ComicVn', 'http://comicvn.net/', 'table.list-chapter', 'a', 'textarea[id=txtarea]', 'option[selected=selected]', '', '', '', '', '', '', '',  '". NV_CURRENTTIME ."',  '". NV_CURRENTTIME ."'),
(3, 'TruyenTranhTuan.Com', 'http://truyentranhtuan.com/', 'div #manga-chapter', 'a', 'null', 'div #read-title p', 'var slides_page_url_path = \\\[(.*?)\\\]', '&quot;', ',', '&quot;', '1', '', '',  '". NV_CURRENTTIME ."',  '". NV_CURRENTTIME ."')");

