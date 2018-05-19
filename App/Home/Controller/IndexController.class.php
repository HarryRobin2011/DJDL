<?php
/**
 *首页控制器
 * User:十八
 * QQ：274020083
 * Date: 16/7/27
 * Time: 下午4:12
 */
namespace Home\Controller;

use Think\Controller;

class IndexController extends Controller
{

    public function _initialize()
    {
        // $token = I('token');
        $token = $_SESSION['token'];
        $id = M('member')->where(array(
            'token' => $token
        ))->getField('id');
        if (ACTION_NAME != 'index' && ! $id) {
            $this->redirect('/');
        }
        $user = M('member')->where(array(
            'id' => $id,'isadmin'=>1
        ))->find();
        if($user!=null){
            //管理员只能进登录、首页、订单
            if(ACTION_NAME != 'index'&&ACTION_NAME != 'home'&&ACTION_NAME != 'records'){
                $this->redirect('/index/home');
            }
        }
    }

    /**
     * 登录页
     */
    public function index()
    {
        $account = cookie('account');
        $password = cookie('password');
        $this->assign('account', $account);
        $this->assign('password', $password);
        $this->display();
    }

    public function home()
    {
        $user = M('member')->where("token='" . $_SESSION['token'] . "'")->find();
        if (! $user) {
            die('<script>alert("用户无效");history.back(1)</script>');
        }
        $list = M('apply_withdrawals')->where('u_id=' . $user['id'])
            ->order('a_id desc')
            ->limit(0, 10)
            ->select();
        
        $goods_list = M('goods_orders')->where('member_id=' . $user['id'])
            ->order('id desc')
            ->limit(0, 10)
            ->select();
        $this->assign("list", $list);
        $this->assign("goods_list", $goods_list);
        $this->display();
    }

    public function chickensLog()
    {
        $this->display();
    }

    public function order()
    {
        $this->user = M('member')->where("token='" . $_SESSION['token'] . "'")->find();
        /*
         * if(empty($this->user['phone']) || empty($this->user['consignee_addr'])){
         * die("<script>alert('请先设置好您的电话和收货地址');location.href='".U('Index/user')."?token=".$_SESSION['token']."'</script>");
         * }
         */
        $goods_count = M("goods")->where("enabled=1 and deleted=0 and goods_stock > 0")->count();
        $pagesize = 3;
        $pagecount = ceil($goods_count / $pagesize);
        $page = I('get.page');
        if (empty($page) || ! is_numeric($page) || intval($page) < 0 || intval($page) > $pagecount) {
            $page = 1;
        }
        $list = M("goods")->where("enabled=1 and deleted=0 and goods_stock > 0")
            ->order('id desc')
            ->limit(($page - 1) * $pagesize, $pagesize)
            ->select();
        $this->assign('list', $list);
        $this->assign('page', $page);
        $this->assign('token', $_SESSION['token']);
        $this->assign('user', $this->user);
        $this->display();
    }

    public function chickenMarket()
    {
        $this->user = M('member')->where("token='" . $_SESSION['token'] . "'")->find();
        $userId = $this->user['id'];
        /*
         * if(empty($this->user['phone']) || empty($this->user['consignee_addr'])){
         * die("<script>alert('请先设置好您的电话和收货地址');location.href='".U('Index/user')."?token=".$_SESSION['token']."'</script>");
         * }
         */
        $goods_count = M("goods")->where("enabled=1 and deleted=0 and goods_stock > 0")->count();
        $pagesize = 3;
        $pagecount = ceil($goods_count / $pagesize);
        $page = I('get.page');
        if (empty($page) || ! is_numeric($page) || intval($page) < 0 || intval($page) > $pagecount) {
            $page = 1;
        }
        $list = M("goods")->where("enabled=1 and deleted=0 and goods_stock > 0")
            ->order('id desc')
           // ->limit(($page - 1) * $pagesize, $pagesize)
            ->select();
        $listOrder = M("goods_orders")->where("member_id=$userId")->order('order_time desc')->select();
        $this->assign('list', $list);
        $this->assign('orderList', $listOrder);
        $this->assign('page', $page);
        $this->assign('token', $_SESSION['token']);
        $this->assign('user', $this->user);
        $this->display();
    }

    public function farm()
    {
        $this->display();
    }

    public function records()
    {
        $token = $_SESSION['token'];
        $data = M('member')->where(array(
            'token' => $token
        ))->find();
        if (! empty($data)) {
            $greencount = M('user_farm')->where(array(
                'userid' => $this->userId,
                'type' => 1
            ))->count();
            $goldcount = M('user_farm')->where(array(
                'userid' => $this->userId,
                'type' => 2
            ))->count();
            $data['greencount'] = $greencount;
            $data['goldcount'] = $goldcount;
            $data['farmcount'] =$greencount+$goldcount;
        } else {
            $data['greencount'] = 0;
            $data['goldcount'] = 0;
            $data['farmcount'] =0;
        }
        if($data['greencount'] >=10&&$data['goldcount']>=1){
            $data['readonly'] ='';
        }else{
            $data['readonly'] ='readonly';
        }
        $this->assign('data', $data);
        $this->display();
    }

    public function tx()
    {
        $token = $_SESSION['token'];
        $data = M('member')->where(array(
            'token' => $token
        ))->find();
        $this->assign('data', $data);
        $this->display();
    }

    public function user()
    {
        $token = $_SESSION['token'];
        $data = M('member')->where(array(
            'token' => $token
        ))->find();
        $this->assign('data', $data);
        $this->display();
    }
}