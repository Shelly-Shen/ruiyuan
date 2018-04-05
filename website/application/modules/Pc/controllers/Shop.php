<?php 

/**
 * 邻米网络
 * ==================================================
 * 版权所有 2015-2017 上海邻米网络科技有限公司开发，并保留所有权利。
 * 网站地址: http://www.ilinme.com；
 * --------------------------------------------------
 * 本项目使用邻米核心开发，欢迎使用。
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===================================================
 * $Author: 邻米网络 & 雾海树妖 $2017/05/20
 */

class ShopController extends Controller_BaseModel{
  //订单提交状态
  function paystatesAction(){
    
  }

  //订单详情
  function orderdetailAction(){
    if (Request::isAjax() && Request::getStringParam("do")=="createJudge"){
      Cms_Service_Api_Contents_Commodity::getInstance()->judge(
        Request::getIntParam("order_id"),
        Request::getIntParam("commodity_id"),
        Request::getArrayParam("commodity_type_ids"),
        Request::getIntParam("score"),
        Request::getStringParam("judgetext")
      );
    }
  }

  //订单列表页
  function orderlistAction(){
    // ?do=setReceived&id=
    if(Request::isAjax() && Request::getStringParam('do')=='setReceived'){
      Cms_Service_Api_Contents_Order::getInstance()->setReceived(Request::getIntParam('id'));
    }

    // ?do=setCancelled&id=
    if(Request::isAjax() && Request::getStringParam('do')=='setCancelled'){
      Cms_Service_Api_Contents_Order::getInstance()->setCancelled(Request::getIntParam('id'));
    }

  }
  //上传列表页
  function shoplistAction(){
    
  }

	//商城首页
	function indexAction(){
		
	}

	//购物车
	function cartAction(){
    if(Request::isAjax() && Request::getStringParam('do')=='delcart'){
      Cms_Service_Api_Contents_Cart::getInstance()->delcart(
        Request::getIntParam('commodity_id'),
        Request::getArrayParam('type_ids')
      );
    }

    if(Request::isAjax() && Request::getStringParam("do")=="getsum"){
      try{
        Response::json_success(Cms_Service_Api_Contents_Commodity::getInstance()->sumChilds(Request::getJSONParam("data")));
      }catch(Exception $e){
        Response::json_error(["msg"=>$e->getMessage()]);
      }
    }

    if(Request::isAjax() && Request::getStringParam('do')=='modifycart'){
      try{
        Response::json_success(
        Cms_Service_Api_Contents_Cart::getInstance()->modifycart(
          Request::getIntParam('commodity_id'),
          Request::getArrayParam('type_ids'),
          Request::getIntParam('count'),
          null
        ));
      }catch(Exception $e){
        Response::error_end($e);
      }
    }

	}

  // 订单确认
  function orderAction(){
    if(Request::isAjax() && Request::getStringParam("do")=="createorder"){
      try{
        Response::json_success(
          Cms_Service_Api_Contents_Order::getInstance()->create(
            Request::getStringParam("data")
        ));
      }catch(Exception $e){
        Response::json_error(["msg"=>$e->getMessage()]);
      }
    }
  }

	//商品详情页
	function shopdetailAction(){
		$this->meta->title=$this->meta->title.' - '.$this->meta->sitetitle;
    $this->updateMeta();

    if(Request::isAjax() && Request::getStringParam('do')=='addcart'){
      try{
        Response::json_success(
        Cms_Service_Api_Contents_Cart::getInstance()->modifycart(
          Request::getIntParam('commodity_id'),
          Request::getArrayParam('type_ids'),
          Request::getIntParam('count'),
          null
        ));
      }catch(Exception $e){
        Response::error_end($e);
      }
    }

  

    if(Request::isAjax() && Request::getStringParam('do')=='createComment'){
      try{
        Response::json_success([
          'comment_id'=>Cms_Service_Api_Contents_Wenku::getInstance()->createComment(
            Request::getIntParam('id'),
            Request::getStringParam('comment'),
            Request::getIntParam('score')
          )
        ]);
      }catch(Exception $e){
        Response::error_end($e);
      }
    }




    if(Request::isAjax() && Request::getStringParam('do')=='createChildComment'){
      try{
        Response::json_success([
          'comment_id'=>Cms_Service_Api_Contents_Wenku::getInstance()->createChildComment(
            Request::getIntParam('id'),
            Request::getStringParam('comment'),
            Request::getIntParam('reply_to')
          )
        ]);
      }catch(Exception $e){
        Response::error_end($e);
      }
    }


    if(Request::isAjax() && Request::getStringParam('do')=='getCommentList'){
      try{
      Response::json_success(Cms_Service_Api_Contents_Wenku::getInstance()->getCommentList(
        Request::getIntParam('id'),
        Request::getIntParam('begin_id'), // 第一条二级回复的id，分页之后也需要传第一页的第一条id
        Request::getIntParam('page')
      )->_data);
      }catch(Exception $e){
        Response::error_end($e);
      }
    }

    if(Request::isAjax() && Request::getStringParam('do')=='getChildCommentList'){
      try{
      $comments=Cms_Service_Api_Contents_Wenku::getInstance()->getChildCommentList(
        Request::getIntParam('reply_to'), // 二级回复的目标评论id
        Request::getIntParam('id'), // 文章id
        Request::getIntParam('begin_id'), // 第一条二级回复的id，分页之后也需要传第一页的第一条id
        Request::getIntParam('page'),
        6
      );
      Response::json_success([
        'comments'=>$comments,
        'pager'=>Cms_Widget::factory('Pager')->newpager([
          'page_code'=>Request::getIntParam('page'),
          'page_itemcount'=>5,
          'item_count_prepage'=>6,
          'item_count_sum'=>$comments->_count,
          'url'=>'pagenum{{page}};',
         ],false)
      ]);
      }catch(Exception $e){
        Response::error_end($e);
      }
    }

    // 文章点赞、取消
    if(Request::isAjax() && Request::getStringParam('do')=='setAgree'){
      try{
        Response::json_success(
          Cms_Service_Api_Contents_Wenku::getInstance()->setAgree(
            Request::getIntParam('id'), // 文章id
            Request::getIntParam('state') // 点赞状态 0 取消点赞 1 点赞
          )
        );
      }catch(Exception $e){
        Response::error_end($e);
      }
    }

    // 文章评论点赞、取消
    if(Request::isAjax() && Request::getStringParam('do')=='setCommentAgree'){
      try{
        Response::json_success(
          Cms_Service_Api_Contents_Wenku::getInstance()->setCommentAgree(
            Request::getIntParam('id'), // 文章评论id
            Request::getIntParam('state') // 点赞状态 0 取消点赞 1 点赞
          )
        );
      }catch(Exception $e){
        // Response::json_error('未知错误');
        Response::error_end($e);
      }
    }

    // 文章二级评论点赞、取消
    if(Request::isAjax() && Request::getStringParam('do')=='setChildCommentAgree'){
      try{
        Response::json_success(
          Cms_Service_Api_Contents_Wenku::getInstance()->setChildCommentAgree(
            Request::getIntParam('id'), // 文章二级评论id
            Request::getIntParam('state') // 点赞状态 0 取消点赞 1 点赞
          )
        );
      }catch(Exception $e){
        Response::error_end($e);
      }
    }


	}

}
