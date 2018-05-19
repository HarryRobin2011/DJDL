<?php
namespace Tool\Controller;
use Think\Controller;
use Think\Page;

class IndexController extends CommonController {
    public function index(){


        $this->display();
    }



    //欢迎页
    public function welcome(){
        // 所有会员奖励钱包剩余总金额
        $reward_wallet = M('member_cash')->where()->sum('reward_wallet');
        //会员总数
        $member_quanbu= M('member')->where()->count();
        //今日注册会员
        $new= M('member')->where()->select();
        //$oldday = date('Y-m-d',strtotime($new['reg_time']));
        $newday = date('Y-m-d',time());
      //dump($new[542]['reg_time']);
       //$oldday = date('Y-m-d',$new[542]['reg_time']);
      // dump($oldday);
        $member_newuser =0;

        for($i=0;$i <= $member_quanbu; $i++){
             $oldday = date('Y-m-d',$new[$i]['reg_time']);

            if($oldday == $newday){
                $member_newuser +=1;
                 //echo "今日注册会员$member_newuser"."<br>";
            }

        }
       // echo $member_newuser;

        //有效会员
        $map['level'] = array('neq',0);
        $member_count= M('member')->where($map)->count();
        //会员购买总金额
//        $member_money =M('gold_list')->where(array('status'=>1))->sum('money');
        //明日需分红金额
//        $queue = M('queue')->where()->sum('bonusmoney');
        //平台已分红总金额
//        $queue_log = M('queue_log')->where()->sum('bonusmoney');
        //平台提现中的金额
        /*$map1['status'] = 0;
        $tixian_one = M('baoli_list')->where($map1)->sum('money');
        $jiangjin0['status'] = 0;
        $jiangjin0['type'] = 'jiangli';
        $tixian_jiangjin0 = M('baoli_list')->where($jiangjin0)->sum('money');
        $licai0['status'] = 0;
        $licai0['type'] = 'licai';
        $tixian_licai0 = M('baoli_list')->where($licai0)->sum('money');
        //平台已经处理提现成功的金额
        $map1['status'] = 1;
        $tixian_count = M('baoli_list')->where($map1)->sum('money');

        $jiangjin1['status'] = 1;
        $jiangjin1['type'] = 'jiangli';
        $tixian_jiangjin1 = M('baoli_list')->where($jiangjin1)->sum('money');
        $licai1['status'] = 1;
        $licai1['type'] = 'licai';
        $tixian_licai1 = M('baoli_list')->where($licai1)->sum('money');*/

        $this->assign('member_quanbu',$member_quanbu);
        $this->assign('member_count',$member_count);
        $this->assign('member_newuser',$member_newuser);
        $this->assign('member_money',$member_money);
        $this->assign('reward_wallet',$reward_wallet);
        $this->assign('tixian_jiangjin0',$tixian_jiangjin0);
        $this->assign('tixian_jiangjin1',$tixian_jiangjin1);
        $this->assign('tixian_licai0',$tixian_licai0);
        $this->assign('tixian_licai1',$tixian_licai1);
        $this->assign('queue',$queue);
        $this->assign('queue_log',$queue_log);
        $this->assign('tixian_one',$tixian_one);
        $this->assign('tixian_count',$tixian_count);
        $this->assign('list',$member_list);
        $this->assign('page',$show);
        $this->display();
    }

    private function array_sort($arr,$keys,$orderby='asc'){
  $keysvalue = $new_array = array();
  foreach ($arr as $k=>$v){
    $keysvalue[$k] = $v[$keys];
  }
  if($orderby== 'asc'){
    asort($keysvalue);
  }else{
    arsort($keysvalue);
  }
  reset($keysvalue);
  foreach ($keysvalue as $k=>$v){
    $new_array[] = $arr[$k];
  }
  return $new_array;
}

    //会员管理
    public function member(){

        $member_count= M('member')->where()->count();
        $page = new Page($member_count);
        $show = $page->show();
        $member_list = M('member')->field('animal_num,id,realname,nickname,references,currency,reg_time,account,active,status,yuanbao')->select();
		$farm=M('user_farm')->select(); 
        $num=array();
        foreach($farm as $v){
            $num[$v['userid']]+=$v['num']+$v['add_num'];
        }
        
        foreach($member_list as $k=> $v){
            $member_list[$k]['animal_num']=$num[$v['id']]+ $member_list[$k]['animal_num']+$v['machine_animal'];
        }
         
        
        $member_list=$this->array_sort($member_list,'animal_num','desc'); 
        $this->assign('member_count',$member_count);
        $this->assign('list',$member_list);
        $this->assign('animal_num',$num);
        $this->assign('page',$show);
        $this->display();
    }
    
    public function equity(){ 
        $equity_count= M('equity_detail')->where()->count();
        $page = new Page($equity_count); 
        $show = $page->show();
        $equity_list = M('equity_detail')->select();
        $equity_list=$this->array_sort($equity_list,'addtime','desc'); 
        $this->assign('equity_count',$equity_count);
        $this->assign('list',$equity_list);
        $equity= M('equity')->find();
        $this->assign('equity',$equity);
        $this->assign('page',$show);
        $this->display();
    }
    
  // 有效会员统计
 public function member1(){

        $map['level'] = array('neq',0);
        $member_count= M('member')->where($map)->count();
        $member_money =M('gold_list')->where(array('status'=>1))->sum('money');
        $queue = M('queue')->where()->sum('bonusmoney');
        $queue_log = M('queue_log')->where()->sum('bonusmoney');
        $page = new Page($member_count,1000);
        $show = $page->show();
        $member_list = M('member')->where($map)->limit($page->listRows.','.$page->firstRow)->select();

        $this->assign('member_count',$member_count);
        $this->assign('member_money',$member_money);
        $this->assign('queue',$queue);
        $this->assign('queue_log',$queue_log);
        $this->assign('list',$member_list);
        $this->assign('page',$show);
        $this->display();
    }

    //增加会员
    public function add_member(){


        $info = I('post.');

        $info['password'] = md5($info['password']);
        if(!$info['highpass']){
             die("<script>alert('支付密码不能为空');history.go(-1);</script>");
        }
        $info['highpass'] = md5($info['highpass']);

        $m = M('member');

        $references = $m->where(array('account'=>$info['references']))->find();

        if($info['references'] != ''){

            if(!$references){
                die("<script>alert('推荐人不存在');history.go(-1);</script>");
            }
            $second_generation = $references['references'] ? $references['references'] : ''; // 2dai
            $three_generations = $references['second_generation'] ? $references['second_generation'] : ''; // 3dai
            $info['second_generation'] = $second_generation;
            $info['three_generations'] = $three_generations;
            $info['animal_num'] = 300;
            $info['path'] = empty($references['path']) ? $references['account'] : $references['path'] . ',' . $references['account'];
        }

        $phone = $m->where(array('phone'=>$info['phone']))->find();

        if($phone){

            die("<script>alert('该手机已经被注册');history.go(-1);</script>");
        }

        $info['reg_time'] = NOW_TIME;
        $info['reg_id'] = get_client_ip();

        if($m->create($info)){

            $mid = $m->add();
            init_cash($mid);
            //init_team($mid);
            $this->success('成功');

        }
        else{

            $this->success('错误');
        }

    }
    

    //禁用会员
    public function stop_member(){

        if(IS_POST){

            $id = I('post.id');
            $member =   M('member')->where(array('id'=>$id))->find();

            if($member['status'] == 0){

                M('member')->where(array('id'=>$id))->setField('status',1);
                $this->success('修改成功');
            }
            if($member['status'] == 1){

                M('member')->where(array('id'=>$id))->setField('status',0);
                $this->success('修改成功');
            }
        }
    }


	//删除会员
    public function del_member(){

        if(IS_POST){

            $id = I('post.id');
            $member =   M('member')->where(array('id'=>$id))->delete();
        }
    }
    /**
     * 系统设置
     */

    public function system_set(){

        if(IS_POST){

            $data = I('post.');

            if(isset($data['limit_get_money'])){
                $data['limit_get_money'] = trim(implode('|',$data['limit_get_money']));
            }

            if(isset($data['limit_to_money'])){
                $data['limit_to_money'] = trim(implode('|',$data['limit_to_money']));
            }

            if(isset($data['limit_help_get'])){
                $data['limit_help_get'] = trim(implode('|',$data['limit_help_get']));
            }
            if(isset($data['limit_help_to'])){
                $data['limit_help_to'] = trim(implode('|',$data['limit_help_to']));
            }

            if(isset($data['rank_name'])){
                $data['max_rank'] = count(array_filter(explode('|',$data['rank_name'])));
            }

            if(isset($data['ticket_use'])){
                $data['ticket_use'] = trim(implode('|',$data['ticket_use']));
            }
            if( M('system_config')->where(array('id'=>1))->save($data))
            {

                S('system_config',$data,0);
                die("<script>alert('设定成功！');history.back(-1);</script>");
            }
            else{

                die("<script>alert('设定失败！');history.back(-1);</script>");
            }

        }
        //加载动态配置
        $c = M('system_config')->find();
        $c['limit_help_get'] =  array_filter(explode('|',$c['limit_help_get']));
        $c['limit_help_to'] =  array_filter(explode('|',$c['limit_help_to']));
        $c['limit_to_money'] =  array_filter(explode('|',$c['limit_to_money']));
        $c['limit_get_money'] =  array_filter(explode('|',$c['limit_get_money']));
        $c['ticket_use'] =  array_filter(explode('|',$c['ticket_use']));
        $this->assign('c',$c);
        $this->display();

    }
    /**
     * 分红设置
     */
    public function fenhong_set(){
        if($_POST){
            $path = 'App/Common/Conf/system.php';
            $file = include $path;
            $config = I('post.');
          
            F('sysclose',$config['sysclose']);
            unset($config['sysclose']);
            //$config['machine_rate']=1.4;
            
            if($config['transfer_percent']>=100 || $config['machine_rate'] >=100 ||  $config['clean_rate']>=100 || $config['enclosure_rate_one'] >=100 || $config['enclosure_rate_two'] >=100 || $config['enclosure_rate_three'] >=100 || $config['enclosure_rate_fourth'] >=100  ){
                 $this->error('利率不能大于100！');
            }
            $res = array_merge($file, $config);
            $str = '<?php return array(';
            foreach ($res as $key => $value){
                // '\'' 单引号转义
                $str .= '\''.$key.'\''.'=>'.'\''.$value.'\''.',';
            };
            $str .= '); ?>';
            //写入文件中,更新配置文件
            if(file_put_contents($path, $str)){
                die("<script>alert('设定成功！');history.back(-1);</script>");
            }else {
                die("<script>alert('设置失败！');history.back(-1);</script>");
            }

        }else{
            $sysstatus=F('sysclose');
            $this->assign('sysclose',$sysstatus);
            $this->display();
        }
    }

    
      /**
     * 激活码管理
     */
     

    public function pin(){

        if(IS_POST){

            $data = I('post.');
            make_pin(member_id($data['account']),$data['count']);
        }

        $pin_list = M('member_pin')->select();
        $this->assign('list',$pin_list);
        $this->display();
    }

    /**
     * 用户钱包管理
     */

    public function wallet(){

        if(IS_POST){
            $data = I('post.');



            $mid = M('member')->where(array('account'=>$data['account']))->field('id')->find();
            if(!$mid){
                die("<script>alert('用户不存在！');history.go(-1);</script>");
            }
			

            $mid = $mid['id'];


            if($data['wallet'] == ''){

                die("<script>alert('请选择一个钱包！');history.go(-1);</script>");
            }

            $wallet = member_cash($mid);//用户的钱包信息
            M('member')->where(array('id'=>$mid))->setInc($data['wallet'],$data['count']); //增加奖励

            if($data['wallet'] == 'animal_num'){
                $wallet_type = 1;
            }

            if($data['wallet'] == 'currency'){

                $wallet_type = 2;
            }
            $after_wallet = member_cash($mid);  //奖励之后的信息

            $to['before_prize'] = $wallet[$data['wallet']];
            $to['prize'] = $data['count'];
            $to['after_prize'] = $after_wallet[$data['wallet']];
            $to['date'] = NOW_TIME;
            $to['touch_member'] = $data['account'];
            $to['recep_member'] = '系统';
            $to['content'] = '系统赠送';
            $to['wallet'] = $wallet_type;

            $ret = M('member_cash_log')->add($to);
             if($ret){
                 $m = M('equity');
                 $equity = $m->find();
                 $equitytemp=$equity;
                 $edtime=time();
                 if($equity!=null){
                     $equity['currnum']=$equity['currnum']-$data['count'];
                     $equity['edittime']=$edtime;
                     $m->save($equity);
                 }
                $this->success('赠送奖励成功');
            }else{

                $this->error('赠送奖励失败');
            }
        }

        $wallet_list = M('member_cash_log')->where(array('status'=>0))->select();
        $this->assign('list',$wallet_list);
        $this->display();

    }

    public function intendant(){
        
        $member_count= M('member')->where()->count();
        $page = new Page($member_count);
        
        $show = $page->show();
        $member_list = M('member')->where("isadmin=1")->field('animal_num,id,realname,nickname,references,currency,reg_time,account,active,status,yuanbao')->select();
        $farm=M('user_farm')->select();
        $num=array();
        foreach($farm as $v){
            $num[$v['userid']]+=$v['num']+$v['add_num'];
        }
        
        foreach($member_list as $k=> $v){
            $member_list[$k]['animal_num']=$num[$v['id']]+ $member_list[$k]['animal_num']+$v['machine_animal'];
        }
        
        
        $member_list=$this->array_sort($member_list,'animal_num','desc');
        $this->assign('member_count',$member_count);
        $this->assign('list',$member_list);
        $this->assign('animal_num',$num);
        $this->assign('page',$show);
        $this->display();
    }
    
   
    
    public function add_equity(){       
        $info = I('post.num');       
        $m = M('equity');
        $cnt=floatval($info);
        if($cnt<=0){         
            die("<script>alert('发行总量需大于0');history.go(-1);</script>");
        }
        $equity = $m->find();
        $equitytemp=$equity;
        $edtime=time();
        if($equity==null){
            $equity['totalnum']=$cnt*10000;
            $equity['currnum']=$cnt*10000;
            $equity['edittime']=$edtime;
            $result =$m->add($equity);
        }else{
            $equity['totalnum']=$equity['totalnum']+$cnt*10000;
            $equity['currnum']=$equity['currnum']+$cnt*10000;
            $equity['edittime']=$edtime;
            $result =$m->save($equity);
        }
        if($result){
            $equitydetail['addnum']=$cnt*10000;
            $equitydetail['addtime']=$edtime;
            $equitydetail['adduser'] = I('post.adduser');  
            $result = M('equity_detail')->add($equitydetail);
            if($result){
            $this->success('成功'); 
            }else{
                if($equitytemp!=null){
                    $equitytemp['edittime']=$edtime;
                    $m->save($equity);
                }
            }
        }
        else{
            
            $this->success('失败');
        }
        
    }

    //清除数据
    public function clear(){


        M('help_to')->where('1')->delete();
        M('help_get')->where('1')->delete();
        M('help_mate')->where('1')->delete();
        M('help_log')->where('1')->delete();
        M('member_cash_log')->where('1')->delete();

        die("<script>alert('清除成功！');history.go(-1);</script>");

    }

    //跳到前台
    public function home(){

        session('member',null);

        $get = I('get.');

        $member =  M('member')->where(array('account'=>$get['account']))->find();

        $auth = array(
            'id'=>$member['id'],
            'account'=>$member['account'],
            'nickname'=>$member['nickname'],
            'realname'=>$member['realname'],
            'references'=>$member['references'],
            'last_ip' => $member['last_ip'],
            'last_time' => $member['last_time'],
            'level' => $member['level'],
            'password' => $member['password'],
        );
        session('member', $auth);

        $this->redirect('../index.php/Index/index');
    }



    public function admin(){


        $list=  M('tool_admin')->select();
        $this->assign('list',$list);
        $this->display();
    }
    
    public function admin_add(){

        if(IS_POST){

            $post = I('post.');
            $post['password']  = md5($post['password']);
            $ret =   M('tool_admin')->create($post);
            if($ret){
                M('tool_admin')->add();
                $this->success('添加成功');
            }else{
                $this->error('添加失败');
            }
        }
        $this->display();
    }

    public function admin_del(){

        if(IS_POST){

            $r = M('tool_admin')->where(array('id'=>I('post.id')))->delete();

            if($r){

                $this->success('删除成功');
            }else{

                $this->error('删除失败');
            }
        }
    }


    //修改用户资料
    public function info(){



        if(IS_POST){


            $post = I('post.');

            $member =  M('member')->where(array('id'=>$post['id']))->find();

            if(!$member){

                die("<script>alert('用户不存在');history.go(-1);</script>");
            }
            unset($post['account']);
            if($post['password'] == ''){

                unset($post['password']);
            }
            if($post['isadmin'] == 'on'){
                
                $post['isadmin'] =1;
            }else{
                $post['isadmin'] =0;
            }

            if($post['password'] != ''){

                $post['password'] = md5($post['password']);
            }
            if($post['highpass'] != ''){

                $post['highpass'] = md5($post['highpass']);
            }
            $post['references']=trim($post['references']);
            if($post['references'] != ''){
                if($post['references']==$member['account']){
                  die("<script>alert('推荐人不能是自己');history.go(-1);</script>");
                
                }
                $account= M('member')->where(array('account'=>$post['references']))->find();
               if(empty($account)){
                  die("<script>alert('推荐人账号错误');history.go(-1);</script>");
                
                }
            }

            $ret =  M('member')->where(array('id'=>$post['id']))->save($post);

            if($ret){

                die("<script>alert('修改成功');history.go(-1);</script>");
            }else{

                die("<script>alert('修改失败');history.go(-1);</script>");
            }

        }


        $id = I('get.id');
        $m = M('member')->where(array('id'=>$id))->find();
        if(!$m){

            die("<script>alert('用户不存在');history.go(-1);</script>");
        }

        $this->assign('member',$m);
        $this->display();
    }



    function log(){

        $list =M('tool_admin_log')->where()->select();
        $this->assign('list',$list);
        $this->display();
    }
    function market(){
        $list = M('market_price')->order('id desc')->limit(10)->select();
        $this->assign('list',$list);
        $this->display();
    }
    function calendar(){
        if(IS_POST){
            $data = I('post.');
            if($data['price']>99 || $data['price'] < 0){
                echo "<script>alert('添加失败，利率必须大于0且小于99');</script>";
                 die;
            }
            if(M('market_price')->where(array('start'=>$data['date']))->find()){
                $id = M('market_price')->where(array('start'=>$data['date']))->save(array('price'=>$data['price'],'title'=>"当日利率:".$data['price'].'%'));
            }else{
                $id = M('market_price')->add(array(
                    'title' =>  "当日利率:".$data['price'].'%',
                    'start' =>  $data['date'],
                    'price' =>  $data['price']
                ));
            }
            if($id !== false){
                echo "<script>alert('添加成功');</script>";
                die;
            }
            echo "<script>alert('添加失败');</script>";
            die;
        }else{
            $this->display();
        }
    }
    function getCalendarJson(){
        $data = M('market_price')->select();
        foreach ($data as $k => $v){
            $data[$k]['end'] = $v['start'];
            $data[$k]['allDay'] = true;
            $data[$k]['color'] = '#c7c7c7';
        }
        $this->ajaxReturn($data);
    }
	function drawing(){
		/*$drawing = M('member_cash_log')->where(array('status'=>1))->order('id desc')->select();
        $this->assign('list',$drawing);
        $this->display();*/
		$drawing_count = M('apply_withdrawals')->where()->count();
		$page = new Page($drawing_count,1000);
        $show = $page->show();
        $drawing_list = M('apply_withdrawals')->where()->limit($page->listRows.','.$page->firstRow)->select();
		foreach($drawing_list as $k=>$d){
			$user = M('member')->field('id,account,bank_code,bank_name,bank_account')->where(array('id'=>$d['u_id']))->find();
			$drawing_list[$k]['account'] = $user['bank_name'] ? $user['bank_name'] : '';
			$drawing_list[$k]['account_no'] = empty($drawing_list[$k]['account_no']) ? $user['bank_code'] : $drawing_list[$k]['account_no'];
			$drawing_list[$k]['account_name'] = $user['account'];
		}
		$this->assign('drawing_count',$drawing_count);
        $this->assign('list',$drawing_list);
        $this->assign('page',$show);
        $this->display();
	}
	//打款
	function confirmDrawing(){
		if(IS_AJAX){
			/*$id = I('id');
			$log = M('member_cash_log')->where(array('id'=>$id,'zhuangtai'=>3))->find();
			if(!$log){
				echo json_encode(array('msg'=>"提款信息不存在",'errcode'=>-1));die;
			}
			$Deal = A('Deal');
			$res = $Deal->baoli_pass($log['id']);
			if($res === true){
				echo json_encode(array('msg'=>"成功提交银行处理",'errcode'=>1));die;
			}else{
				echo json_encode(array('msg'=>$res,'errcode'=>-1));die;
			}*/
			
			$id = I('id');
			$log = M('apply_withdrawals')->where(array('a_id'=>$id))->find();
			if(!$log){
				echo json_encode(array('msg'=>"提款信息不存在",'errcode'=>-1));die;
			}
			if($log['is_handle'] > 0){
				echo json_encode(array('msg'=>"已经处理过了",'errcode'=>-1));die;
			}
			$user = M('member')->where(array('id'=>$log['u_id']))->find();
			if(!user){
				echo json_encode(array('msg'=>"提款用户不存在",'errcode'=>-1));die;
			}
			$user["currency"] = $user["currency"] - $log['apply_money'];
			if($user["currency"] < 0){
				echo json_encode(array('msg'=>"用户余额不足不能提现",'errcode'=>-1));die;	
			}
			$yuanbao = round($user['yuanbao'] + $user['currency'] * 0.2, 2);//提现的20%进入元宝帐号
			M('member')->where(array('id'=>$log['u_id']))->save(array('currency'=>$user["currency"],'yuanbao'=>$yuanbao));
			M('apply_withdrawals')->where(array('a_id'=>$id))->save(array("is_handle"=>1));
			echo json_encode(array('msg'=>"已成功提现",'errcode'=>1));die;
		}
		echo json_encode(array('msg'=>"提款信息不存在",'errcode'=>-1));die;
	}
	function delLog(){
		if(IS_AJAX){
			$id = I('id');
			$log = M('member_cash_log')->where(array('id'=>$id))->find();
			if(!$log){
				echo json_encode(array('msg'=>"提款信息不存在",'errcode'=>-1));die;
			}
			if(M('member_cash_log')->where(array('id'=>$id))->delete()){
				
				echo json_encode(array('errcode'=>10000));die;
			}
		}
		echo json_encode(array('msg'=>"提款信息不存在",'errcode'=>-1));die;
	}
	//拒绝打款 
	function refuse(){
		if(IS_AJAX){
			/*$id = I('id');
			$log = M('member_cash_log')->where(array('id'=>$id,'zhuangtai'=>3))->find();
			if(!$log){
				echo json_encode(array('msg'=>"提款信息不存在",'errcode'=>-1));die;
			}
			if(M('member_cash_log')->where(array('id'=>$id))->save(array('zhuangtai'=>2))!== false){
				M('member')->where(array('account'=>$log['touch_member']))->setInc('money',$log['prize']);
				echo json_encode(array('errcode'=>10000));die;
			}*/
			$id = I('id');
			$log = M('apply_withdrawals')->where(array('a_id'=>$id))->find();
			if(!$log){
				echo json_encode(array('msg'=>"提款信息不存在",'errcode'=>-1));die;
			}
			if($log['is_handle'] > 0){
				echo json_encode(array('msg'=>"已经处理过了",'errcode'=>-1));die;
			}
			
			
			M('apply_withdrawals')->where(array('a_id'=>$id))->save(array('is_handle'=>2));
			
			echo json_encode(array('msg'=>"已成功拒绝",'errcode'=>10000));die;
		}
		echo json_encode(array('msg'=>"提款信息不存在",'errcode'=>-1));die;
	}
    public function dogmsg(){

       
        //member_cash_log dogmsg
        $wallet_list = M('dogmsg')->select();
        $this->assign('list',$wallet_list);
        $this->display();

    }

     //公告发布

    public function dogadd(){

   if(IS_POST){
       $post = I('post.');

       $post['create_time'] = NOW_TIME;
       if(   $post['rate']>99){
            $this->success('利率不能超过99%');
       } 
       if($post['upgrade_percent']< 1 ||  $post['upgrade_percent']> 99 ){
            $this->success('中奖概率必须大于1%且小于等于99');
       } 
        $maxlev=C('dog_maxlev')?C('dog_maxlev'):9;
       if($post['lev'] >$maxlev){
        $this->error("等级不能超过$maxlev级");
       }
       $ret =  M('dogmsg')->create($post); 
       if($ret){ 
           M('dogmsg')->add(); 
           $this->success('添加成功');
       }else{ 
           $this->error('添加失败');
       }
   }

        $this->display();
    }

    //牧羊犬升级
    public function dogupdate(){ 
        if(IS_POST){ 
            $post = I('post.');  
            if(isset($post['lev'])){
                unset($post['lev']);
            }
            if(   $post['rate']>99){
                $this->success('利率不能超过99%');
            } 
            if($post['upgrade_percent']< 1 ||  $post['upgrade_percent']> 99 ){
                $this->success('中奖概率必须大于1且 小于等于99');
            } 
            $maxlev=C('dog_maxlev')?C('dog_maxlev'):9;
            if($post['lev'] >$maxlev){
                $this->error("等级不能超过$maxlev级");
            }
             $ret =  M('dogmsg')->save($post); 
            if($ret){ 
                $this->success('修改成功');
            }
            else{
                $this->error('修改失败');
            }

         }

         $dogmsg = M('dogmsg')->where(array('id'=>I('get.id')))->find();
         $this->assign('dogmsg',$dogmsg);
         $this->display();
    }

 

    public function dogdel(){ 
        if(IS_POST){ 
            $r = M('dogmsg')->where(array('id'=>I('post.id')))->delete(); 
            if($r){ 
                $this->success('删除成功');
            }else{

                $this->error('删除失败');
            }
        }
    }


   
    
    //执行利率任务，锁系统不给用户进行操作
    //利益=围栏利率+稻草人利率+日期利率
    public function runrate(){  
        set_time_limit(0);
        ignore_user_abort(true); 
        ini_set('max_execution_time', 0);
        ini_set("memory_limit", 1048576000); 
        $add['task_date']=date('Y-m-d',strtotime("-1 day"));
        $moneyday=date('m-d',strtotime("-1 day"));
        $task=M('rate_task')->where(array('task_date'=>$add['task_date']))->find();  
        if($task){
             echo json_encode(array('msg'=>'日期:'. $add['task_date'].'任务已经执行过！请等待下一天再执行！','code'=>2));exit; 
           // $this->error('日期:'. $add['task_date'].'任务已经执行过！请等待下一天再执行！');
           // exit;
        }
        $rate=M('market_price')->where(array('start'=>$add['task_date']))->find();
        if($rate['price']+0<=0){
            // $this->error('请先设置日期：'.$add['task_date'].'的利率!');
             echo json_encode(array('msg'=>'请先设置日期：'.$add['task_date'].'的利率!','code'=>1));exit; 
        }
        //echo $rate['price'];exit;
        
        F('sysclose',1);
        $start= date('Y-m-d H:i:s',microtime(true));
        $add['create_time']=$start;
         
        $admin=session('admin');  //start 
        $add['username']=$admin['username'];
        $time=time();
        // $where='m.id=206';
        /*$machine_rate=C('machine_rate');
        if(!$machine_rate){
             echo json_encode(array('msg'=>'请先设置收割机的利率!','code'=>1));exit; 
        }*/
        $machine_rate=$base_rate=$rate['price']/100;
        $membermodel=M('member');
        $memberlist=M('member m ')->join(' left join '.C('DB_PREFIX').'dogmsg c on m.dog_lev=c.lev')->field('m.enclosure_lev,c.rate dog_rate,m.id,m.machine_egg')->select();
        $userrate=array();
        $enclosure[4]=0;
        $enclosure[0]=C('enclosure_rate_zero')?C('enclosure_rate_zero'):0.4; //围栏利率 
        $enclosure[1]=C('enclosure_rate_one')?C('enclosure_rate_one'):0.3;
        $enclosure[2]=C('enclosure_rate_two')?C('enclosure_rate_two'):0.2;
        $enclosure[3]=C('enclosure_rate_three')?C('enclosure_rate_three'):0.1;
        $save['egg_parent_status']=1;
        $save['all_rate']=0;
        M('member')->where('id >0')->save($save);
        $farmsave['egg_status']=1; //全部弄成未收
        M('user_farm')->where('id >0')->save($farmsave);
        foreach($memberlist as $v){
            $enclosure_rate=$enclosure[$v['enclosure_lev']]/100; //围栏利率 
            $dog_rate=$v['dog_rate']/100;
            $userrate[$v['id']]= array('enclosure_rate'=>$enclosure_rate,'dog_rate'=>$dog_rate,'machine_animal'=>0);
            if($v['machine_egg']){  //水稻不收取会覆盖苗不会覆盖。
                $machine_animal=(int)($v['machine_egg']*($machine_rate-$enclosure_rate+$dog_rate)); 
                $membermodel->where('id='.$v['id'])->setField('machine_animal',$machine_animal);
                $userrate[$v['id']]['machine_animal']=$machine_animal;

            }
             
        }

         
     
       //$taskid=1;
       $farmmodel=M('user_farm');
       $farlog=M('rate_log');
       $taskid=M('rate_task')->add($add);  
       $farratelog=array();
        if($taskid){
           $count=0;$arraycount=1;
           //$where=' userid=205';
           $allfarm=$farmmodel->field('add_num,num,userid,id')->select(); //一块地一块地的地算
           //var_dump($allfarm);exit;
           $allratelog=array();
            foreach($allfarm as $v){   
               // $dograte=$userrate[$v['userid']]['rate'];
                 // $machine_animal=$userrate[$v['userid']]['machine_animal']+0;
                
                $enclosure_rate=  $userrate[$v['userid']]['enclosure_rate'];   

                $dog_rate=$userrate[$v['userid']]['dog_rate'] ;
                 
                $allrate=($v['add_num']+$v['num'])*($base_rate+$enclosure_rate+$dog_rate);
                //base_rate
               // echo $rate['price'],'ccc',$enclosure[$enclosurelev],'kk',$userrate[$v['userid']]['rate'];;exit;
                //更新么快地的利润
                $farmmodel->where('id='.$v['id'])->save(array('egg_rate'=>$allrate,'task_id'=>$taskid));
               
                $allratelog[$v['userid']]['allrate']=$allrate+($allratelog[$v['userid']]['allrate']+0);
 
                /*$count++;
                if($count >=500){
                    $arraycount++;
                    $count=0;
                }
                $farratelog[$arraycount][]=array('task_id'=>$taskid,'farm_id'=>$v['id'],'rate'=>$allrate,'time'=>$time,'machine_animal'=>$machine_animal,'machine_rate'=>$machine_rate);*/
            } 
            
             /*$allratelog[$v['userid']]['base_rate']=$enclosure[$enclosurelev]/100;
                $allratelog[$v['userid']]['dog_rate']=$enclosure[$enclosurelev]/100;
                $allratelog[$v['userid']]['enclosure_rate']=$enclosure[$enclosurelev]/100;
                $allratelog[$v['userid']]['machine_animal']=$enclosure[$enclosurelev]/100;
                $allratelog[$v['userid']]['machine_rate']=$enclosure[$enclosurelev]/100;*/
            $count=1;$farratelog=array();
          
            foreach($allratelog as $k=> $v){
                $count++;
               $farratelog[]=array('task_id'=>$taskid,'base_rate'=>$rate['price']/100,'all_currency'=>$v['allrate'],'machine_rate'=>$machine_rate,'userid'=>$k,'enclosure_rate'=>$userrate[$k]['enclosure_rate'],'dog_rate'=>$userrate[$k]['dog_rate'],'time'=>$moneyday,'machine_animal'=>$userrate[$k]['machine_animal'],'create_time'=>$time);
               $membermodel->where('id='.$k)->setField('all_rate',$v['allrate']);
                if($count>500){
                     $farlog->addAll($farratelog);
                     $farratelog=array();
                }
                 
            }
            if(!empty($farratelog)){
                $farlog->addAll($farratelog);
            }  
            
            $end=date('Y-m-d H:i:s',microtime(true));
            M('rate_task')->where('id='.$taskid)->save(array('end_time'=>$end)); 
            // F('sysclose',0);//让他们手动打开系统。
            echo json_encode(array('msg'=>'任务执行成功 !','code'=>0));exit; 
        }else{
             echo json_encode(array('msg'=>'执行任务失败 !','code'=>3));exit; 
        }                                                             
          //  rate_task
    }
    public function textfarm(){  exit;
        $user=M('member')->field('id')->select();
        foreach($user as $v){
            
            M('user_farm')->add(array(
                    'userid'    => $v['id'],
                    'type' =>  1,
                    'create_time'   => time(),
                    'num'=>300,
                    'add_num'=>mt_rand(10,500),
                    'egg_status'=>1
                    
                ));
        }
    }

   public function lateloglist(){
        $post=I('post.');
        $count=$post['count']?$post['count']:20;
        $from=$post['from']?$post['from']:1;
        $list =M('rate_log l ')->field('l.*,m.realname')->join(' left join gs_member m on m.id=l.userid')->limit(($from-1)*$count,$count)->order('id desc')->select();
        $allcount=M('rate_log l ')->count();
        $data['list']=$list;
        $data['count']=ceil($allcount/$count); 
        echo json_encode($data); 
     
   }
    public function ratelog(){
        $task=M('rate_task')->order('id desc')->find(); 
        $list =M('rate_log l ')->field('l.*,m.realname')->join(' left join gs_member m on m.id=l.userid')->select();
        $this->assign('task',$task);
        $this->assign('list',$list);
        $this->display();
        
        
    }
    public function tasklog(){

       
        //member_cash_log dogmsg
        $tasklog = M('rate_task')->order('id desc')->select();
        $this->assign('list',$tasklog);
        $this->display();

    } 
    //重新执行利率任务。
    public function redealwork(){
       if(!F('sysclose')){
            echo json_encode(array('msg'=>'请先关闭系统 !','code'=>1));exit; 
       }
      $taskid=$_POST['id']+0;
      if(!$taskid){
        echo json_encode(array('msg'=>'数据错误 !','code'=>1));exit; 
      }
       $task=M('rate_task')->order('id desc')->field('id,task_date')->find();
       if($taskid!=$task['id']){
            echo json_encode(array('msg'=>'参数错误 !','code'=>1));exit; 
       }
      
        $add['task_date']=date('Y-m-d',strtotime("-1 day"));
        if($task['task_date'] !=$add['task_date']){
             echo json_encode(array('msg'=>'执行日期错误 !','code'=>1));exit; 
        }
        
      M('rate_task')->where(array('id'=>$taskid))->delete();  
      M('rate_log')->where(array('task_id'=>$taskid))->delete(); 
      $this->runrate();
    }

    public function clearrunrate(){
        echo json_encode(array('msg'=>'当前接口已停用','code'=>1));exit; 
       // M()->execute(' truncate gs_rate_task');
        //M()->execute(' truncate gs_rate_log');
        // echo json_encode(array('msg'=>'任务执行成功 !','code'=>0));exit; 
    }
     
    public function lotterymsg(){ 
        $lottery = M('lottery')->select();
        $this->assign('list',$lottery);
        $this->display();

    }

     //公告发布

    public function lotteryadd(){ 
       if(IS_POST){
           $post = I('post.'); 
           
           $percent=M('lottery')->field('sum(percent) as percent')->find();
            if($percent['percent']+$post['percent']>100){
                 $this->error('添加失败,所有奖品概率不能大于100');
            }
           $ret =  M('lottery')->create($post); 
           if($ret){ 
               M('lottery')->add(); 
               $this->success('添加成功');
           }else{ 
               $this->error('添加失败');
           }
        }

        $this->display();
    }

    //稻草人升级
    public function lotteryupdate(){ 
        if(IS_POST){ 
            $post = I('post.');  
             
           $percent=M('lottery')->field('sum(percent) as percent')->where('id!='.$post['id'])->find();
            if($percent['percent']+$post['percent']>100){
                 $this->error('添加失败,所有奖品加起来概率不能大于100');
            }

             $ret =  M('lottery')->save($post); 
            if($ret){ 
                $this->success('修改成功');
            }
            else{
                $this->error('修改失败');
            }

         }

         $lottery = M('lottery')->where(array('id'=>I('get.id')))->find();
         $this->assign('lottery',$lottery);
         $this->display();
    } 

    public function lotterydel(){ 
        if(IS_POST){ 
            $r = M('lottery')->where(array('id'=>I('post.id')))->delete(); 
            if($r){ 
                $this->success('删除成功');
            }else{

                $this->error('删除失败');
            }
        }
    }
    public function lotterylist(){
         
        $record= M('lottery_record')->alias('l')->field('l.*,m.nickname,t.type')->join(' left join '.C('DB_PREFIX').'member m on m.id=l.userid '.' left join '.C('DB_PREFIX').'lottery t on t.id=l.lotteryid')->order('id desc')->select();
       // var_dump($record);exit;
        $this->assign('list',$record); 
        $this->display();
    }
    public function  prizeupdate(){ 
        if(IS_POST){ 
            $post = I('post.');            
            $ret =  M('lottery_record')->where('id='.$post['id'])->save($post); 
            if($ret){ 
                $this->success('修改成功');
            }
            else{
                $this->error('修改失败');
            }

         }

         $lottery = M('lottery_record')->where(array('id'=>I('get.id')))->find();
         $this->assign('lottery',$lottery);
         $this->display();
    }
     public function email(){

        if(IS_POST){
            $data = I('post.');



            $mid = M('member')->where(array('account'=>$data['account']))->field('id')->find();
            if(!$mid){
                die("<script>alert('用户不存在！');history.go(-1);</script>");
            } 

            $to['msg'] =  $data['msg'];
            $to['account'] = $data['account'];
            $to['create_time'] = time();
           

            $ret = M('email')->add($to);

            if($ret){

                $this->success('发送邮箱成功');
            }else{

                $this->error('发送邮箱失败');
            }
        }

        $email_list = M('email')->order('id desc')->select();
        //var_dump($email_list);exit;
        $this->assign('list',$email_list);
        $this->display();

    }
    public function userlog(){  
        $user_finance = M('user_finance')->alias('c')->field('c.*,m.account')->join(' left join '.C('DB_PREFIX').'member m on m.id=c.userid')->where('c.type in(13,14,15)')->order('id desc')->select(); 
       // echo M()->getlastsql();exit;
        $this->assign('list',$user_finance);
        $this->display();

    }

     
     public function emaildel(){ 
        if(IS_POST){ 
            $r = M('email')->where(array('id'=>I('post.id')))->delete(); 
            if($r){ 
                $this->success('删除成功');
            }else{

                $this->error('删除失败');
            }
        }
    }
    //数据汇总
    public function summarydata(){
       $data= M('member')->field('sum(currency) currency,sum(animal_num) animal_num,sum(machine_egg) machine_egg, sum(machine_animal) machine_animal ')->find();
       $farm= M('user_farm')->field('sum(num) num,sum(add_num) add_num ')->find();
       $all['currency']=$data['currency']+$data['machine_egg']; 
       $all['animal_num']=$data['animal_num']+$data['machine_animal']+$farm['num']+$farm['add_num'];
       $userwin= M('lottery_record')->field('sum(animal_num) animal_num')->find();
       $all['userwin']=$userwin['animal_num'];  
       $all['userpay']= M('lottery_record')->field(' animal_num')->count()*5;
     //  var_dump($all);exit;
       $this->assign('all',$all);
       $this->display();
    }

}
