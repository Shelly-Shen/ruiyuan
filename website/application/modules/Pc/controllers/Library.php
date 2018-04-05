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

class LibraryController extends Controller_BaseModel{
  function init(){
    $_levels=Cms_Service_Api_Types::getInstance()->listLevel(Cms_Service_TypesConst::LIBRARY_ROOT_ID,[
      'maxlevel'=>4,
      'ignore_del'=>true,
      'level_max_count'=>6,
      'sub_level_max_count'=>999,
    ],"name");
    $navbars=[
      ['text'=>'文库首页','href'=>'/wenku']
    ];
    foreach($_levels as $level) $navbars[]=$level;
    $this->getView()->assign('navbars_baseurl','/wenku/level');
    $this->getView()->assign('navbars',$navbars);
    parent::init();
  }

	function indexAction(){

	}
	
  function librarylistAction(){


    if(Request::isAjax() && Request::getStringParam('do')=='getSearchList'){
      try{
        Response::json_success(
          Cms_Service_Api_Contents_Wenku::getInstance()->getSearchList(
            Request::getIntParam('cms_types_id'),
            Request::getIntParam('sort_by'),
            Request::getIntParam('order_by'),
            Request::getIntParam('page',1),
            20,
            Request::getStringParam('kw')
          )->_data
        );
      }catch(Exception $e){
        Response::json_error($e->getMessage());
        // Response::error_end($e);
      }
    }
  }

  function librarydetailAction(){
  	
    $this->meta->title=$this->meta->title.' - '.$this->meta->sitetitle;
    $this->updateMeta();

    if(Request::getStringParam('do')=='uploadJson'){
      try{
        Cms_Service_Api_Contents::getInstance()->KindEditorUploadJson();
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

  function uploadlibraryAction(){

    if(Request::isAjax() && Request::getStringParam('do')=='checkexist'){
      try{
        Cms_Service_Api_Contents::getInstance()->checkExists(
          Request::getStringParam('title'),
          Cms_Service_Api_Contents::DUMP_WENKU_TITLE
        );
        Response::json_success(0);
      }catch(Exception $e){
        Response::json_error(0);
      }
    }

    if(/*Request::isAjax() &&*/ Request::getStringParam('do')=='getkw'){
      try{
        Response::json_success(
          Cms_Service_Api_Keywords::getInstance()->getKeywords(
            Request::getStringParam('str')
          )
        );
      }catch(Exception $e){
        Response::error_end($e);
      }
    }

    if(/*Request::isAjax() &&*/ Request::getStringParam('do')=='gettype'){
      try{
        $type_id=Cms_Service_Api_Contents_Wenku::getInstance()->getCmsTypeId(Request::getStringParam('str'));
        $data=Cms_Service_Api_Contents_Wenku::getInstance()->getCmsTypesList($type_id);
        Response::json_success([
          'type_id'=>$type_id,
          'data'=>$data,
        ]);
      }catch(Exception $e){
        Response::error_end($e);
      }
    }

    if(/*Request::isAjax() &&*/ Request::getStringParam('do')=='gettypebyid'){
      try{
        /*$type_id=Request::getStringParam('type_id');
        $data=Cms_Service_Api_Contents_Wenku::getInstance()->getCmsTypesList($type_id,true);
        Response::json_success([
          'type_id'=>$type_id,
          'data'=>$data,
        ]);*/
        Response::json_success(Cms_Service_Api_Types::getInstance()->listType(
          Request::getIntParam('type_id')
        ));
      }catch(Exception $e){
        Response::error_end($e);
      }
    }

    if(/*Request::isAjax() &&*/ Request::getStringParam('do')=='searchkw'){
      try{
        $data=Cms_Service_Api_Keywords::getInstance()->searchKeywords(Request::getStringParam('kwstr'));
        Response::json_success($data);
      }catch(Exception $e){
        Response::error_end($e);
      }
    }

    if(Request::getStringParam('do')=='create'){
      try{
        $result=Cms_Service_Api_Contents_Wenku::getInstance()->create();
      }catch(Exception $e){
        $result=['msg'=>$e->getMessage()];
      }
      Response::iframeCallback(Request::getStringParam('cbname'),$result);
    }


    
  }

  function successAction(){}

  function downloadAction(){
    Cms_Service_Api_Contents_Wenku::getInstance()->downloadFile(Request::getIntParam('wenku_id'));
  }

}

