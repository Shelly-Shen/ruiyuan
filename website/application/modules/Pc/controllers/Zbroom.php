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

class ZbroomController extends Controller_BaseModel{

  function idAction(){
  	$this->redirect('/pc/zbroom/play?id='.Request::getIntParam('id'));
  }
  function playAction(){
    if(Request::isAjax() && Request::getStringParam('do')=='createComment'){
      try{
      Response::json_success(['comment_id'=>Cms_Service_Api_Contents_Course::getInstance()->createComment(
        Request::getIntParam('id'),
        Request::getStringParam('comment'),
        Request::getStringParam('score')
      ),'comment'=>Request::getStringParam('comment'),'score'=>Request::getStringParam('score')]);
      }catch(Exception $e){
        Response::json_error('未知错误');
      }
    }

    if(Request::isAjax() && Request::getStringParam('do')=='getCommentList'){
      try{
      Response::json_success(Cms_Service_Api_Contents_Course::getInstance()->getCommentList(
        Request::getIntParam('id'),
        Request::getIntParam('begin_id'),
        Request::getIntParam('page')
      )->_data);
      }catch(Exception $e){
        Response::json_error('未知错误');
      }
    }


  }
}
