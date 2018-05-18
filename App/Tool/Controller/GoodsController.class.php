<?php
/**
 * 商品后台管理
 * User:十八
 * QQ：274020083
 * Date: 16/6/11
 * Time: 上午11:22
 */

namespace Tool\Controller;
use Think\Controller;
use Think\Page;

class GoodsController extends CommonController{



    public function index(){
        $goods_count =  M('goods')->where('deleted=0')->count();
		$page = new Page($goods_count);
        $show = $page->show();
		$goods_list = M('goods')->where('deleted=0')->order('id desc')->limit($page->listRows.','.$page->firstRow)->select();
        $this->assign('list',$goods_list);
		$this->assign('page', $page);
		
        $this->display();
    }
	
	public function order_index(){
		
		$order_count = M('goods_orders')->count();
		$page = new Page($order_count);
		$show = $page->show();
		
		$goods_list = M('goods_orders')->where('1=1')->order('id desc')->limit($page->listRows.','.$page->firstRow)->select();
        $this->assign('list',$goods_list);
		$this->assign('page', $page);		
        $this->display();
	}

	private function get_upload_max_filesize_byte($dec=2){  
		$max_size=ini_get('upload_max_filesize');  
		preg_match('/(^[0-9\.]+)(\w+)/',$max_size,$info);  
		$size=$info[1];  
		$suffix=strtoupper($info[2]);  
		$a = array_flip(array("B", "KB", "MB", "GB", "TB", "PB"));  
		$b = array_flip(array("B", "K", "M", "G", "T", "P"));  
		$pos = $a[$suffix]&&$a[$suffix]!==0?$a[$suffix]:$b[$suffix];  
		return round($size*pow(1024,$pos),$dec);  
	}  

    //公告发布

    public function post(){
	   if(IS_POST){
		   $post = I('post.');
			
		   $post['enabled'] =1;
		   $post['delete'] = 0;
		   $post['create_time'] = NOW_TIME;
		   $post['update_time'] = NOW_TIME;		   
		   if(empty($post['goods_name'])){
			   $this->error('商品名称不能为空');
	
		   }
		   if(empty($post['goods_price']) || !is_numeric($post['goods_price']) || floatval($post['goods_price']) <=0){
				$this->error('商品价格有误');	
		   }
		   if(empty($post['goods_stock']) || !is_numeric($post['goods_price']) || intval($post['goods_price']) <=0){
				$this->error('商品库存有误');	
		   }
		  if($_FILES['goods_imgurl']['error'] > 0){
			  	switch($_FILES['goods_imgulr']['error']) { 
				case 1: 
				// 文件大小超出了服务器的空间大小 
				$this->error("文件不能超过".$this->get_upload_max_filesize_byte()); 
				break; 
				case 2: 
				// 要上传的文件大小超出浏览器限制 
				$this->error("文件大小超过浏览器限制"); 
				break;
				
				case 3: 
				// 文件仅部分被上传 
				$this->error("文件没有上传完整"); 
				break;
				
				case 4: 
				// 没有找到要上传的文件 
				$this->error("请选择上传的文件"); 
				break;
				
				case 5: 
				// 服务器临时文件夹丢失 
				$this->error("服务器异常"); 
				break;
				
				case 6: 
				// 文件写入到临时文件夹出错 
				$this->error("文件写入受限"); 
				break; 
				}
		   		$this->error('文件上传有误');
		   }else{
				$dir = "/Public/fuguiji/images/goods/".date('Ymd',time())."/";
				$pathname = date('YmdHis',time()).mt_rand(1000,9999).$_FILES['goods_imgurl']['name'];
				
				if(!is_dir('.'.$dir)){
					@mkdir('.'.$dir,777,true);
				}
				if(!move_uploaded_file($_FILES['goods_imgurl']['tmp_name'], '.'.$dir.$pathname)){
					$this->error('保存图片有误');
				}
				$post['goods_imgurl'] = $dir.$pathname;
		   }
		   
		   $cnt = M('goods')->where(array('goods_name'=>$post['goods_name'], 'deleted'=>0))->count();
		   if($cnt){
				$this->error('该商品名称已存在');
		   }
		   $ret =  M('goods')->create($post);
		   if($ret){
			   M('goods')->add();
			   die("<script>alert('商品发布成功');parent.window.location.reload();</script>");
			   //$this->success('商品发布成功');
		   }else{
	
			   $this->error('商品发布失败');
		   }
	   }
	   $this->display();
    }

    //更新公告
    public function update(){

        if(IS_POST){
             $post = I('post.');
			 $post['update_time'] = NOW_TIME;
			 if(empty($post['goods_name'])){
			   $this->error('商品名称不能为空');
	
			 }
			   if(empty($post['goods_price']) || !is_numeric($post['goods_price']) || floatval($post['goods_price']) <=0){
					$this->error('商品价格有误');	
			   }
			   if(empty($post['goods_stock']) || !is_numeric($post['goods_price']) || intval($post['goods_price']) <=0){
					$this->error('商品库存有误');	
			   }
			 $cnt = M('goods')->where(array('goods_name'=>$post['goods_name'], 'deleted'=>0,'id'=>array('NEQ', $post['id'])))->count();
			   if($cnt){
					$this->error('该商品名称已存在');
			   }
			   if($_FILES['goods_imgurl']['error'] > 0){
		   		switch($_FILES['goods_imgulr']['error']) { 
				case 1: 
				// 文件大小超出了服务器的空间大小 
				$this->error("文件不能超过".$this->get_upload_max_filesize_byte()); 
				break; 
				case 2: 
				// 要上传的文件大小超出浏览器限制 
				$this->error("文件大小超过浏览器限制"); 
				break;
				
				case 3: 
				// 文件仅部分被上传 
				$this->error("文件没有上传完整"); 
				break;
				
				case 4: 
				// 没有找到要上传的文件 
				$this->error("请选择上传的文件"); 
				break;
				
				case 5: 
				// 服务器临时文件夹丢失 
				$this->error("服务器异常"); 
				break;
				
				case 6: 
				// 文件写入到临时文件夹出错 
				$this->error("文件写入受限"); 
				break; 
				}
			   }else{
					$dir = "/Public/fuguiji/images/goods/".date('Ymd',time())."/";
					$pathname = date('YmdHis',time()).mt_rand(1000,9999).$_FILES['goods_imgurl']['name'];
					
					if(!is_dir('.'.$dir)){
						@mkdir('.'.$dir,777,true);
					}
					if(!move_uploaded_file($_FILES['goods_imgurl']['tmp_name'], '.'.$dir.$pathname)){
						$this->error('保存图片有误');
					}
					$post['goods_imgurl'] = $dir.$pathname;
			   }
             $ret =  M('goods')->save($post);

            if($ret){               
				die("<script>alert('商品修改成功');parent.window.location.reload();</script>");
				
            }
            else{
                $this->error('商品修改失败');
            }

         }

         $goods = M('goods')->where(array('id'=>I('get.id')))->find();
         $this->assign('goods',$goods);
         $this->display();
    }

	public function stop_goods(){
		$id = I("post.id");
		$goods = M('goods')->where('id='.$id)->find();
		if(!$goods){
			$this->error('商品不存在');
		}
		if($goods['enabled']){
			$goods['enabled'] = 0;
		}else{
			$goods['enabled'] = 1;			
		}
		$r = M('goods')->where('id='.$id)->save(array('enabled'=>$goods['enabled']));
		if($r){
			$this->success('成功');
		}else{
			$this->error('失败');
		}
	}
	
	public function pub_order(){
		$id = I("post.id");
		$goods_orders = M('goods_orders')->where('id='.$id)->find();
		if(!$goods_orders){
			die(json_encode(array('errorcode'=>1,'errormsg'=>'订单不存在')));
		}
		if($goods_orders['status'] > 0){
			die(json_encode(array('errorcode'=>2,'errormsg'=>'订单已经处理过了')));
		}
		$r = M('goods_orders')->where('id='.$id)->save(array('status'=>1));
		if($r){
			die(json_encode(array('errorcode'=>0,'errormsg'=>'')));
		}else{
			die(json_encode(array('errorcode'=>3,'errormsg'=>'确认发货失败')));
		}
	}
	
	public function refuse_order(){
		$id = I("post.id");
		$goods_orders = M('goods_orders')->where('id='.$id)->find();
		if(!$goods_orders){
			die(json_encode(array('errorcode'=>1,'errormsg'=>'订单不存在')));
		}
		if($goods_orders['status'] > 0){
			die(json_encode(array('errorcode'=>2,'errormsg'=>'订单已经处理过了')));
		}
		$r = M('goods_orders')->where('id='.$id)->save(array('status'=>2));
		if($r){
			die(json_encode(array('errorcode'=>0,'errormsg'=>'')));
		}else{
			die(json_encode(array('errorcode'=>3,'errormsg'=>'拒绝发货失败')));
		}
		
	}

    //删除公告
    public function del(){

        if(IS_POST){

            //$r = M('goods')->where(array('id'=>I('post.id')))->delete();
			$r = M('goods')->where(array('id'=>I('post.id')))->save(array('deleted'=>1));
            if($r){
				die("<script>alert('商品删除成功');parent.window.location.reload();</script>");				
                //$this->success('删除成功');				
            }else{

                $this->error('删除失败');
            }
        }

    }
}