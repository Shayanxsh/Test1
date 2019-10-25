<?php
function get_web_page($url)
{
    $user_agent = 'Mozilla/5.0 (Windows NT 6.1; rv:8.0) Gecko/20100101 FireFox/8.0';
    $options = array(
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_POST => false,
        CURLOPT_USERAGENT => $user_agent,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER => false,
        CURLOPT_FOLLOWLOCATION => true
    );
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt_array($ch, $options);
    $content = curl_exec($ch);
    $err = curl_errno($ch);
    $errmsg = curl_error($ch);
    $header = curl_getinfo($ch);
    curl_close($ch);
    $header['errorno'] = $err;
    $header['errmsg'] = $errmsg;
    $header['content'] = $content;
    return $header;
}

$url = "https://www.digikala.com/product/dkp-90825";

$page = get_web_page($url);

//we should use regular expressions to match the strings in $page['content] with our desired strings
preg_match('/<h1 class="c-product__title">(.*?)<\/h1>/s', $page['content'], $match1);
$productTitle= $match1[1];

preg_match_all('/class="js-gallery-img"(.*)src="(.*)"(.*)+/i',$page['content'], $match2);
$imageSRC= $match2[2][0];

preg_match('/<div class="c-product__seller-price-raw js-price-value">(.*?)<\/div>/s', $page['content'], $match3);
$price= $match3[1];
