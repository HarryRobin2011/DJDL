<?php
namespace Api\Model;   
use Think\Model;
class SmsModel extends Model{
    //构造虚拟模型 3.2.3+需要
    Protected $autoCheckFields = false;
    public function sendcode($mobile,$content){  
       // $content = "恭喜您，成为新田庄主，已配送300株秧苗到仓库中";
        $url='http://utf8.sms.webchinese.cn/'; 
        $rparams['Uid']='zxc199404';
        $rparams['Key']='d41d8cd98f00b204e980';
        $rparams['smsMob']=$mobile;
        $rparams['smsText']=$content;
        $this->file_get_request($url,$rparams);
    }
    private function file_get_request($url,$postFields)
    {
        $post='';
        while (list($k,$v) = each($postFields)) 
        {
            $post .= rawurlencode($k)."=".rawurlencode($v)."&"; //×ªURL±ê×¼Âë
        }
        return file_get_contents($url.'?'.$post);
    }
    
}

?>