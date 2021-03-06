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

class RuiyController extends Controller_BaseModel{
  //下载app
  function downloadappAction(){
  }

  function init(){
    if(in_array($this->getRequest()->action,['login','reg','logout'])){
      $this->ignoreSetBefore();
    }
    parent::init();
  }
  function thiredregAction(){
    if(Request::isAjax() && Request::getStringParam('doreg')=='1'){


    try{
      Cms_Service_Api_Users_Regnew::getInstance()->RegnewWith_Mobile_Password_MobileYzm(
        Request::getStringParam('mobile'),
        Request::getStringParam('pwd'),
        Request::getStringParam('mobileyzm'),
        Request::getStringParam('username','')
      );
      Response::json_success(true);
    }catch(Exception $e){
      Response::json_error(['msg'=>$e->getMessage()]);
    }

    }
  }
  function thiredbindAction(){
    if(Request::isAjax() && Request::getStringParam('dobind')=='1'){
      try{
        Cms_Service_Api_Users_Regnew::getInstance()->BindWith_Mobile_MobileYzm(
          Request::getStringParam('mobile'),
          Request::getStringParam('mobileyzm')
        );
        Response::json_success(true);
      }catch(Exception $e){
        Response::json_error(['msg'=>$e->getMessage()]);
      }
    }
  }
  function indexAction(){
    if(Request::getTypeUA()!=='PC'){
      $this->redirect('/');
      exit;
    }
    if(Request::isAjax() && Request::getStringParam('do')=='getRandom'){
      try{
        Response::json_success(Cms_Service_Api_Contents_Question::getInstance()->getRandom());
      }catch(Exception $e){
        Response::json_error($e->getMessage());
        // Response::error_end($e);
      }
    }
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
    if(Request::getStringParam('do')=='wantqueslist'){
      try{
        Response::json_success(Cms_Service_Api_Contents_Question::getInstance()->getWanted(Cms_Service_TypesConst::QUESTION_ROOT_ID,20,1,Cms_Service_Api_Contents_Question::ORDER_HIGH)->_data);
      }catch(Exception $e){
        Response::json_error($e->getMessage());
        // Response::error_end($e);
      }
    }
  }
  function loginAction(){
    
  }
  function regAction(){

  }
  function forgetpwdAction(){
    
  }
  function catagorynavAction(){}
  function zxAction(){

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
      Response::json_success(Cms_Service_Api_Contents_Default::getInstance()->getCommentList(
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

  function footerAction(){}

  function logoutAction(){
    Cms_Service_Api_Users::getInstance()->logout();
    Response::redirect_url(Tool::getLastUrl());
  }

  //结果页
  function consultAction(){}
 function newsAction(){}
 function newAction(){}
 function newsroomAction(){}
function lianxAction(){}
function serveAction(){}
function innovateAction(){}
function busiAction(){}
function itconsultAction(){}
function softwaveAction(){}
function salesforceAction(){}
function spaAction(){}
function dealerAction(){}
function engineAction(){}
function landAction(){}
function retailAction(){}
function signupAction(){}
function successAction(){}
function header22Action(){}
function exampleAction(){}
function newretailAction(){}
function realestateAction(){}
function dealersAction(){}
function automakerAction(){}
function serviceAction(){}
}

