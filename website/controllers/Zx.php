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

class ZxController extends Controller_BaseModel{
  
  function init(){
    $_levels=Cms_Service_Api_Types::getInstance()->listLevel(Cms_Service_TypesConst::ZX_ROOT_ID,[
      'maxlevel'=>4,
      'ignore_del'=>true,
      'level_max_count'=>6,
      'sub_level_max_count'=>999,
    ]);
    $navbars=[
      ['text'=>'资讯首页','href'=>'/news']
    ];
    foreach($_levels as $level) $navbars[]=$level;
    $this->getView()->assign('navbars_baseurl','/news/level');
    $this->getView()->assign('navbars',$navbars);
    parent::init();
  }

  function infocatagoryAction(){
    if(Request::isAjax() && Request::getStringParam('do')=='getSearchList'){
      try{
        Response::json_success(Tool::removeRows(
          Cms_Service_Api_Contents_Default::getInstance()->getLastDefaultList(
            Request::getIntParam('begin_id'),
            Request::getIntParam('page',1),
            10,
            ['cms_types_id'=>Request::getIntParam('cms_types_id'),
             'sort_id'=>Request::getIntParam('sort_id'),
             'kw'=>Request::getStringParam('kw'),
             ]
          )->_data
        ,'content'));
      }catch(Exception $e){
        Response::json_error($e->getMessage());
        // Response::error_end($e);
      }
    }

  }

  function indexAction(){
    if(Request::isAjax() && Request::getStringParam('do')=='getNewList'){
      try{
        Response::json_success(Tool::removeRows(
          Cms_Service_Api_Contents_Default::getInstance()->getLastDefaultList(
            Request::getIntParam('begin_id'),
            Request::getIntParam('page',1),
            10
          )->_data
        ,'content'));
      }catch(Exception $e){
        Response::json_error($e->getMessage());
        // Response::error_end($e);
      }
    }
  }

  function detailAction(){

    $this->meta->title=$this->meta->title.' - '.$this->meta->sitetitle;
    $this->updateMeta();

    if(Request::getStringParam('do')=='del'){
      Cms_Service_Api_Contents_Default::getInstance()->delCommentMy(Request::getIntParam('id'));
    }

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
          'comment_id'=>Cms_Service_Api_Contents_Default::getInstance()->createComment(
            Request::getIntParam('id'),
            Request::getStringParam('comment')
          )
        ]);
      }catch(Exception $e){
        Response::error_end($e);
      }
    }


    if(Request::isAjax() && Request::getStringParam('do')=='createChildComment'){
      try{
        Response::json_success([
          'comment_id'=>Cms_Service_Api_Contents_Default::getInstance()->createChildComment(
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
        $page=Request::getIntParam('page',1)-1;
        if($page===0){
      Response::json_success(Cms_Service_Api_Contents_Default::getInstance()->getCommentListByAgree(
        Request::getIntParam('id'),
        3
      )->_data);
        }else{
      Response::json_success(Cms_Service_Api_Contents_Default::getInstance()->getCommentList(
        Request::getIntParam('id'),
        Request::getIntParam('begin_id'), // 第一条二级回复的id，分页之后也需要传第一页的第一条id
        $page
      )->_data);
        }
      }catch(Exception $e){
        Response::error_end($e);
      }
    }

    if(Request::isAjax() && Request::getStringParam('do')=='getChildCommentList'){
      try{
      $comments=Cms_Service_Api_Contents_Default::getInstance()->getChildCommentList(
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
          Cms_Service_Api_Contents_Default::getInstance()->setAgree(
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
          Cms_Service_Api_Contents_Default::getInstance()->setCommentAgree(
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
          Cms_Service_Api_Contents_Default::getInstance()->setChildCommentAgree(
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


