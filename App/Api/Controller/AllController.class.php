<?php
/**
 * Created by PhpStorm.
 * User: jiaruo
 * Date: 17/2/16
 * Time: 上午10:14
 */

namespace Api\Controller;

class AllController extends CommonController
{
    protected $userId = null;
    public function _initialize()
    {
        parent::_initialize(); // 此控制器无需token
    }

     
	
	
	//获得公告
	public function getNotice(){
		$res = M('notice')->order('id desc')->select();
		foreach($res as $k=>$v){
			$res[$k]['date']=date('m-d',$v['date']);
		}
		if(!$res){
			$res = array(
				'id'=>'1',
				'content'=>'-',
				'date'=>'01-01',
				'title'=>'-',
			);
		}
		//$res['date'] = date('m-d',$res['date']);
		$this->echoJson($res);
	}
	 

	
}