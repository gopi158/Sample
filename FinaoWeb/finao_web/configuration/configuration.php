<?
    $url = 'http://localhost/finao_webservice/api.php';
    //$absolute_cookie_path = "C:/Users/Kunal/Dropbox/Development/Shared/FINAO/FinaoWeb/finao_web";
    $absolute_cookie_path = "C:/Users/Kragos/Desktop/Dropbox/FINAO/FinaoWeb/finao_web";
    
    //define("PUBLIC_KEY_HEX" , "E9F337977735B1CD52C2E840B67B9F77C8CC53FEEAACC2E6238525FAA1279127");
    if(!defined('PUBLIC_KEY_HEX')) define("PUBLIC_KEY_HEX" , "E9F337977735B1CD52C2E840B67B9F77C8CC53FEEAACC2E6238525FAA1279127");
    if(!defined('PUBLIC_KEY')) define("PUBLIC_KEY" ,Users::hex2bin(PUBLIC_KEY_HEX));
    if(!defined('IV')) define("IV","97534682");
    
    $css_path = 'http://37e6bf77ff29d0a853f5-3da34b3c89ddb105514cbc318fac8ef2.r22.cf2.rackcdn.com';
    $js_path = 'http://979d042481248a4a5825-e5f00f5bd9078858b9929a244675f85c.r16.cf2.rackcdn.com';
    $image_path = 'content/images/';
    $icon_path = 'content/images/icons/';
    $post_count = 10;
?>