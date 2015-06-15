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
function grab_mangafox($url){
    $string = create_dom($url);
	
	preg_match('/<title>(.*?) Manga - Read (.*?) Manga Online for Free<\/title>/i',$string,$name);
    preg_match('/<th>Released:<\/th>(.*)<\/table>/isU',$string,$info);
    preg_match_all('/<a href=".*?\/genres\/.*?">(.*?)<\/a>/is',$info[1],$genres);
    preg_match_all('/<a href=".*?\/author\/.*?">(.*?)<\/a>/is',$info[1],$author);
    preg_match('/<a .*?>(\d+)<\/a>/is',$info[1],$year);
    preg_match_all('/<a href=".*?\/artist\/.*?">(.*?)<\/a>/is',$info[1],$artist);
    preg_match('/<img .*?src="(.*?)\?\d+" alt=".*?" \/>/is',$string,$thumb);
    preg_match('/<p class="summary">(.*?)<\/p>/is',$string,$desc);


    $manga['name']=$name[1];
    $manga['authors']=implode(',',$author[1]);
    $manga['artists']=implode(',',$artist[1]);
    $manga['genres']=implode(',',$genres[1]);
    $manga['cover']=$thumb[1];
    $manga['released']=$year[1];
    $manga['description']=$desc[1];

    return $manga;
}
function grab_vnsharing($url){
    $string = create_dom($url);
	
	preg_match('/<a class="bigChar" href="\/Truyen\/(.*)\">(.*)<\/a>/i',$string,$name);
    preg_match_all('/<a href=".*?\/TheLoai\/.*?">(.*?)<\/a>/is',$string,$genres);
    preg_match_all('/<a href=".*?\/TacGia\/.*?">(.*?)<\/a>/is',$string,$author);
    preg_match('/<img width="190px" height="250px" src="(.*?)"/is',$string,$thumb);


    $manga['name']=$name[2];
    $manga['authors']=implode(',',$author[1]);
    $manga['artists']=$manga['authors'];
    $manga['genres']=implode(',',$genres[1]);
    $manga['cover']=$thumb[1];
    $manga['released']=date("Y");

    return $manga;
}
?>