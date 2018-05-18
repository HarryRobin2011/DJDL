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

class AccountController extends Controller
{	
	 /**
     * 找回密码
     */
    public function forgetPwd(){
        $this->display();
    }
}