<?php
/**
 * Created by PhpStorm.
 * User: jiaruo
 * Date: 17/2/15
 * Time: 下午3:48
 */

namespace Api\Controller;


class ToolController extends CommonController
{
    public function sendCode(){
        if(IS_POST){ 
            $data = I('post.');
            $this->checkGet('mobile');
            $result = $this->getCode($data['mobile']);
            if(!$this->isFalse($result)){               
                $this->echoJson(10000);
            }
            $this->echoJson(-8);
        }
    }
    public function getPrice(){
       // $_POST['token']='cede49a52f40707828c097b59801dbed';
        $this->checkGet(array('token'));
        $list = M('market_price')->where(array('start'=>array('elt',date('Y-m-d'))))->order('start desc')->limit(7)->select();
        $this->userId = $this->tokenToUserId(I('post.token'));
        $membermsg=M('member m ')->join(' left join '.C('DB_PREFIX').'dogmsg c on m.dog_lev=c.lev')->field('m.enclosure_lev,c.rate dog_rate')->where('m.id='.$this->userId)->find();
        $enclosure[4]=0;
        $enclosure[0]=C('enclosure_rate_zero')?C('enclosure_rate_zero'):0.4; //围栏利率 
        $enclosure[1]=C('enclosure_rate_one')?C('enclosure_rate_one'):0.3;
        $enclosure[2]=C('enclosure_rate_two')?C('enclosure_rate_two'):0.2;
        $enclosure[3]=C('enclosure_rate_three')?C('enclosure_rate_three'):0.1;
        $dog_rate=$membermsg['dog_rate'] ;
      
        foreach ($list as $k => $v){
            $date[] = date('m-d',strtotime($v['start']));
            $price[] = $v['price'];
            $bprice=$v['price']-$enclosure[$membermsg['enclosure_lev']]+$dog_rate;
           // echo $bprice,'</br>';
          //  echo number_format($bprice,3, ".", ","),'</br>';
           //  echo sprintf("%.2f",substr(sprintf("%.3f", $bprice), 0, -2))  ,'</br>';
            $baseprice[]=$bprice;
        } 
        $date = array_reverse($date);
        $price = array_reverse($price);
        $baseprice = array_reverse($baseprice);
        $this->ajaxReturn(array('errcode'=>10000,'date'=>$date,'price'=>$price,'baseprice'=>$baseprice));
    }
    
//     public function getCode($mobile){
//         if(!$mobile) return false;
//         $code = mt_rand(111111,666666);
//         $expirationTime = time() + 30 * 60;
//         $content = $code;
        
//         $content = "您正在重设密码，验证码：{$code}，大雞大利 提醒您注意账号安全";
//         $url='http://utf8.sms.webchinese.cn/';
//         $rparams['Uid']='zxc199404';
//         $rparams['Key']='d41d8cd98f00b204e980';
//         $rparams['smsMob']=$mobile;
//         $rparams['smsText']=$content;
//         $result=$this->file_get_request($url,$rparams);
//         if($result != 1){
//             $this->echoJson(-21);
//         }
//         $id = M('sms_log')->add(array(
//             'mobile'    =>  $mobile,
//             'code'      =>  $code,
//             'content'   =>  $content,
//             'expiration_time'   =>  $expirationTime,
//         ));
//         return $id;
//     }

    /**
     * 腾讯云SDK AppID ：
     * Key：
     */   
    public function getCode($mobile){
        if(!$mobile) return false;      
        $code = mt_rand(111111,666666);
        $expirationTime = time() + 30 * 60;
        $sdkappid='1400088922';
        $appkey='0ff55955852d9058a82b11b6d109a999';
        $content = "验证码：{$code}请尽快使用该验证码进行您的大雞大利游戏。";
        $random = rand(100000,999999);
        $curTime = time();
        $wholeUrl = "https://yun.tim.qq.com/v5/tlssmssvr/sendsms?sdkappid=".$sdkappid."&random=" . $random;       
        // 按照协议组织 post 包体
        $data = new \stdClass();
        $tel = new \stdClass();
        $tel->nationcode = "86";
        $tel->mobile = "".$mobile;
        $data->params = Array($code);
        $data->tpl_id= 117415;
        $data->tel = $tel;
        $data->type = 0;
        $data->msg = $content;
        $data->sig = hash("sha256","appkey=".$appkey."&random=".$random."&time=".$curTime."&mobile=".$mobile, FALSE);
        $data->time = $curTime;
        $data->extend = "";
        $data->ext = "";
        $result=$this->http_request($wholeUrl,$data); 
        $dataObj=json_decode($result,true);
        if($dataObj['result'] != 0){
            $this->echoJson(-21);
        }
        $id = M('sms_log')->add(array(
            'mobile'    =>  $mobile,
            'code'      =>  $code,
            'content'   =>  $content,
            'expiration_time'   =>  $expirationTime,
        ));
        return $id;
    }
    
    
    private function http_request($url, $data) {
        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt( $ch, CURLOPT_HEADER, 0);
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt ( $ch, CURLOPT_POST, 1 );
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, FALSE );
        curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );       
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, json_encode($data));
        $output = curl_exec ( $ch );
        curl_close ( $ch );
        return $output;
    }
    
    private function file_get_request($url,$postFields)
    {
        $post='';
        while (list($k,$v) = each($postFields))
        {
            $post .= rawurlencode($k)."=".rawurlencode($v)."&"; //×ªURL±ê×¼Âë
        }
        return file_($url.'?'.$post);
    }
}