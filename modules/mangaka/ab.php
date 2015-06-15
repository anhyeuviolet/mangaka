<?
function create_dom($url,$follow=1)
{
    $ch = curl_init();
    curl_setopt( $ch, CURLOPT_USERAGENT, " Google Mozilla/5.0 (compatible; Googlebot/2.1;)" );
    if($follow==1)
    {
        curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
    }
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt( $ch, CURLOPT_REFERER, "http://www.google.com/bot.html" );
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5000);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5000);
    $result = curl_exec($ch);
    return $result;
}

function truyentranhtuan($url){
    $string = create_dom($url);
	preg_match_all('/var slides_page_url_path = \[(.*?)\]/is',$string,$data);
	
	$content = $data[1];
	$content = array_shift($content);
	$content = preg_replace('/"/','',$content);$content = preg_replace('/,/','',$content);
	return $content;
}

$url = 'http://truyentranhtuan.com/thiet-tuong-tung-hoanh-chuong-171/';
$url_list = truyentranhtuan($url);
var_dump($url_list);