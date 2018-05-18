<?php
/**
SMS????????
@author		sms.cn
@link		http://www.sms.cn
*/
namespace Api\Controller;

use Think\Controller;

class SmsController extends Controller {
	/**
	* SMSAPI??????
	*/
	const API_URL = 'http://utf8.sms.webchinese.cn/';

	/**
	* ??????
	* 
	* @var string
	*/
	protected $uid;

	/**
	* ???????
	* 
	* @var string
	* @link http://sms.sms.cn/ ???????????????->??????????
	*/
	protected $pwd;

	/**
	* sms api??????
	* @var string
	*/
	protected $apiURL;


	/**
	* ??????????????
	* @var string
	*/
	protected $smsParams;

	/**
	* ?????????
	* @var string
	*/
    protected $resultMsg;

	/**
	* ????????????
	* @var string
	*/
	protected $format;

	/**
	* ??????
	* 
	* @param string $uid ??????
	* @param string $pwd ???????
	*/
    public function __construct($uid = '', $pwd = '')
    {
		//?????????????§Õ??????
		$def_uid = 'zxc199404';
		$def_pwd = 'd41d8cd98f00b204e980';
        $this->uid	= $uid ?: $def_uid;
        $this->pwd	= $pwd ?: $def_pwd;
        $this->apiURL = self::API_URL;
		$this->format = 'json';
    }
	/**
	* SMS????????
	* @return array 
	*/
    protected function publicParams()
    {
        return array(
            'uid'		=> $this->uid,
            'pwd'		=> md5($this->pwd.$this->uid),
            'format'	=> $this->format,
        );
    }
	/**
	* ?????????????
	*
	* @param string $mobile ???????
	* @param string $content ???????????
	* @param string $template ???????ID
	* @return array
	*/
	public function send($mobile, $contentParam,$template='') {
		//??????????
		$this->smsParams = array(
			'ac'		=> 'send',
			'mobile'	=> $mobile,
			'content'	=> $this->array_to_json($contentParam),
			'template'	=> $template
		);
		$this->resultMsg = $this->request();
		return $this->json_to_array($this->resultMsg, true);
	}

	/**
	* ?????????????
	*
	* @param string $mobile ???????
	* @param string $content ????????
	* @return array
	*/
	public function sendAll($mobile, $content) {
		//??????????
		$this->smsParams = array(
			'ac'		=> 'send',
			'mobile'	=> $mobile,
			'content'	=> $content,
		);
		$this->resultMsg = $this->request();

		return $this->json_to_array($this->resultMsg, true);
	}

	/**
	* ???????????
	*
	* @return array
	*/
	public function getNumber() {
		//????
		$this->smsParams = array(
			'ac'		=> 'number',
		);
		$this->resultMsg = $this->request();
		return $this->json_to_array($this->resultMsg, true);
	}


	/**
	* ?????????
	*
	* @return array
	*/
	public function getStatus() {
		//????
		$this->smsParams = array(
			'ac'		=> 'status',
		);
		$this->resultMsg = $this->request();
		return $this->json_to_array($this->resultMsg, true);
	}
	/**
	* ???????§Ø?????????
	*
	* @return array
	*/
	public function getReply() {
		//????
		$this->smsParams = array(
			'ac'		=> 'reply',
		);
		$this->resultMsg = $this->request();
		return $this->json_to_array($this->resultMsg, true);
	}
	/**
	* ????????????
	*
	* @return array
	*/
	public function getSendTotal() {
		//????
		$this->smsParams = array(
			'ac'		=> 'number',
			'cmd'		=> 'send',
		);
		$this->resultMsg = $this->request();
		return $this->json_to_array($this->resultMsg, true);
	}

	/**
	* ???????
	*
	* @return array
	*/
	public function getQuery() {
		//????
		$this->smsParams = array(
			'ac'		=> 'query',
		);
		$this->resultMsg = $this->request();
		return $this->json_to_array($this->resultMsg, true);
	}

	/**
	* ????HTTP????
	* @return string
	*/
	private function request()
	{
		$params = array_merge($this->publicParams(),$this->smsParams);
        $rparams['Uid']=$params['uid'];
        $rparams['Key']=$params['pwd'];
        $rparams['smsMob']=$params['mobile'];
        $rparams['smsText']=$params['content'];
		if( function_exists('curl_init') )
		{   //var_dump($params);echo $this->apiURL;exit;
			return $this->curl_request($this->apiURL,$params);
		}
		else
		{
			return $this->file_get_request($this->apiURL,$params);
		}
	}
	/**
	* ???CURL????HTTP????
	* @param string $url		 //????URL
	* @param array $postFields //??????? 
	* @return string
	*/
	private function curl_request($url,$postFields){
		$postFields = http_build_query($postFields);
		//echo $url.'?'.$postFields;
		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_POST, 1 );
		curl_setopt ( $ch, CURLOPT_HEADER, 0 );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt ( $ch, CURLOPT_URL, $url );
		curl_setopt ( $ch, CURLOPT_POSTFIELDS, $postFields );
		$result = curl_exec ( $ch );
		curl_close ( $ch );
		return $result;
	}
	/**
	* ???file_get_contents????HTTP????
	* @param string $url  //????URL
	* @param array $postFields //??????? 
	* @return string
	*/
	private function file_get_request($url,$postFields)
	{
		$post='';
		while (list($k,$v) = each($postFields)) 
		{
			$post .= rawurlencode($k)."=".rawurlencode($v)."&";	//?URL?????
		}
		return file_get_contents($url.'?'.$post);
	}
	/**
	* ??????HTTP???????
	* @return string
	*/
	public function getResult()
	{
		$this->resultMsg;
	}
	/**
	* ??????¦Ë??????
	* @param  integer $len ????
	* @return string       
	*/
	public function randNumber($len = 6)
	{
		$chars = str_repeat('0123456789', 10);
		$chars = str_shuffle($chars);
		$str   = substr($chars, 0, $len);
		return $str;
	}

	//???????json?????
	function array_to_json($p)
	{
		return urldecode(json_encode($this->json_urlencode($p)));
	}
	//url???
	function json_urlencode($p)
	{
		if( is_array($p) )
		{
			foreach( $p as $key => $value )$p[$key] = $this->json_urlencode($value);
		}
		else
		{
			$p = urlencode($p);
		}
		return $p;
	}

	//??json??????????
	function json_to_array($p)
	{
		if( mb_detect_encoding($p,array('ASCII','UTF-8','GB2312','GBK')) != 'UTF-8' )
		{
			$p = iconv('GBK','UTF-8',$p);
		}
		return json_decode($p, true);
	}
}

?>