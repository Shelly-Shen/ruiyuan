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

class QuestionController extends Controller_BaseModel{

  function init(){
    $_levels=Cms_Service_Api_Types::getInstance()->listLevels(Cms_Service_TypesConst::QUESTION_ROOT_ID,[
      'maxlevel'=>4,
      'ignore_del'=>true,
      'level_max_count'=>6,
      'sub_level_max_count'=>999,
    ],"name")[Cms_Service_TypesConst::QUESTION_ROOT_ID];
    $navbars=[
      ['text'=>'问答首页','href'=>'/ask']
    ];
    foreach($_levels as $level) $navbars[]=$level;
    $this->getView()->assign('navbars_baseurl','/ask/level');
    $this->getView()->assign('navbars',$navbars);
    parent::init();
  }

  function indexAction(){
    if(Request::isAjax() && Request::getStringParam('do')=='getNewList'){
      try{
        #if(!Cms_Service_Api_Cache::begin(10)) Cms_Service_Api_Cache::json_success(
        Response::json_success(
          Cms_Service_Api_Contents_Question::getInstance()->getLastQuestionList(
            Request::getIntParam('begin_id'),
            Request::getIntParam('page',1),
            10
          )->_data
        );
      }catch(Exception $e){
        Response::json_error($e->getMessage());
        // Response::error_end($e);
      }
    }

    if(Request::isAjax() && Request::getStringParam('do')=='getRandom'){
      try{
        Response::json_success(Cms_Service_Api_Contents_Question::getInstance()->getRandom());
      }catch(Exception $e){
        Response::json_error($e->getMessage());
        // Response::error_end($e);
      }
    }
    if(/*Request::isAjax() &&*/ Request::getStringParam('do')=='wantqueslist'){

      try{
        Response::json_success(
          Cms_Service_Api_Contents_Question::getInstance()->getLastQuestionList(0,1,20)->_data
        );
      }catch(Exception $e){
        Response::json_error($e->getMessage());
        // Response::error_end($e);
      }
      /*
      try{
        Response::json_success(Cms_Service_Api_Contents_Question::getInstance()->getWanted(Cms_Service_TypesConst::QUESTION_ROOT_ID,20,1,Cms_Service_Api_Contents_Question::ORDER_HIGH)->_data);
      }catch(Exception $e){
        Response::json_error($e->getMessage());
        // Response::error_end($e);
      }
      */
    }
  }
  
  function questionlistAction(){
    if(Request::isAjax() && Request::getStringParam('do')=='getSearchList'){
      try{
        Response::json_success(
          Cms_Service_Api_Contents_Question::getInstance()->getSearchList(
            Request::getIntParam('cms_types_id'),
            Request::getIntParam('sort_by'),
            Request::getIntParam('order_by'),
            Request::getIntParam('page',1),
            20,
            Request::getStringParam('kw'),
            Request::getArrayParam('fav')
          )->_data
        );
      }catch(Exception $e){
        Response::json_error($e->getMessage());
        // Response::error_end($e);
      }
    }
  }

  function questiondetailAction(){

    $this->meta->title=$this->meta->title.' - '.$this->meta->sitetitle;
    $this->updateMeta();

    if(Request::getStringParam('do')=='uploadJson'){
      try{
        Cms_Service_Api_Contents_Question::getInstance()->KindEditorUploadJson();
      }catch(Exception $e){
        Response::error_end($e);
      }
    }


    if(Request::isAjax() && Request::getStringParam('do')=='createAnswer'){
      try{
        Response::json_success([
          'answer_id'=>Cms_Service_Api_Contents_Question::getInstance()->createAnswer(
            Request::getIntParam('question_id'),
            Request::getStringParam('answer'),
            Request::getStringParam('anomy')
          )
        ]);
      }catch(Exception $e){
        Response::json_error($e->getMessage());
        // Response::error_end($e);
      }
    }


    if(Request::isAjax() && Request::getStringParam('do')=='createAnswerComment'){
      try{
        Response::json_success([
          'comment_id'=>Cms_Service_Api_Contents_Question::getInstance()->createAnswerComment(
            Request::getIntParam('question_id'),
            Request::getStringParam('comment'),
            Request::getIntParam('reply_to')
          )
        ]);
      }catch(Exception $e){
        Response::error_end($e);
      }
    }


    if(Request::isAjax() && Request::getStringParam('do')=='getAnswerList'){
      try{
      Response::json_success(Cms_Service_Api_Contents_Question::getInstance()->getAnswerList(
        Request::getIntParam('id'),
        Request::getIntParam('begin_id'), // 第一条二级回复的id，分页之后也需要传第一页的第一条id
        Request::getIntParam('page')
      )->_data);
      }catch(Exception $e){
        Response::error_end($e);
      }
    }

    if(Request::isAjax() && Request::getStringParam('do')=='getAnswerCommentList'){
      try{
      $comments=Cms_Service_Api_Contents_Question::getInstance()->getAnswerCommentList(
        Request::getIntParam('reply_to'), // 二级回复的目标评论id
        Request::getIntParam('id'), // 问题id
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
          Cms_Service_Api_Contents_Question::getInstance()->setAgree(
            Request::getIntParam('id'), // 文章id
            Request::getIntParam('state') // 点赞状态 0 取消点赞 1 点赞
          )
        );
      }catch(Exception $e){
        Response::error_end($e);
      }
    }

    // 文章评论点赞、取消
    if(Request::isAjax() && Request::getStringParam('do')=='setAnswerAgree'){
      try{
        Response::json_success(
          Cms_Service_Api_Contents_Question::getInstance()->setAnswerAgree(
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
    if(Request::isAjax() && Request::getStringParam('do')=='setAnswerCommentAgree'){
      try{
        Response::json_success(
          Cms_Service_Api_Contents_Question::getInstance()->setAnswerCommentAgree(
            Request::getIntParam('id'), // 文章二级评论id
            Request::getIntParam('state') // 点赞状态 0 取消点赞 1 点赞
          )
        );
      }catch(Exception $e){
        Response::error_end($e);
      }
    }

    // 设置最佳答案
    if(Request::isAjax() && Request::getStringParam('do')=='setBest' ){
      try{
        Cms_Service_Api_Contents_Question::getInstance()->setBestAnswer(
          Request::getIntParam('question_id'),
          Request::getIntParam('answer_id')
        );
        Response::json_success();
      }catch(Exception $e){
        Response::error_end($e);
      }
    }

    // 设置推荐答案
    if(Request::isAjax() && Request::getStringParam('do')=='setRecommend' ){
      Cms_Service_Api_Contents_Question::getInstance()->setRecommendAnswerByAdmin(
        Request::getIntParam('question_id'),
        Request::getIntParam('answer_id')
      );
    }



    if(Request::isAjax() && Request::getStringParam('do')=='createMoreQuestion'){
      try{
        Response::json_success(
          Cms_Service_Api_Contents_Question::getInstance()->moreQuestion(
            Request::getIntParam('question_id'),
            Request::getIntParam('answer_id'),
            Request::getStringParam('question_content')
          )
        );
      }catch(Exception $e){
        Response::error_end($e);
      }
    }

    if(Request::isAjax() && Request::getStringParam('do')=='createMoreAnswer'){
      try{
        Response::json_success(
          Cms_Service_Api_Contents_Question::getInstance()->moreAnswer(
            Request::getIntParam('question_id'),
            Request::getIntParam('more_question_id'),
            Request::getStringParam('answer_content')
          )
        );
      }catch(Exception $e){
        Response::error_end($e);
      }
    }



  }

  function askquestionAction(){
    if(Request::isAjax() && Request::getStringParam('do')=='checkexist'){
      try{
        Cms_Service_Api_Contents::getInstance()->checkExists(
          Request::getStringParam('title'),
          Cms_Service_Api_Contents::DUMP_QUESTION_TITLE
        );
        Response::json_success(0);
      }catch(Exception $e){
        Response::json_error(0);
      }
    }

    if(Request::isAjax() && Request::getStringParam('do')=='getkw'){
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

    /*
    if(Request::isAjax() && Request::getStringParam('do')=='gettype'){
      try{
        $type_id=Cms_Service_Api_Contents_Question::getInstance()->getCmsTypeId(Request::getStringParam('str'));
        $data=Cms_Service_Api_Contents_Question::getInstance()->getCmsTypesList($type_id);
        Response::json_success([
          'type_id'=>$type_id,
          'data'=>$data,
        ]);
      }catch(Exception $e){
        Response::error_end($e);
      }
    }
    */

    if(Request::isAjax() && Request::getStringParam('do')=='gettypebyid'){
      try{
        /*
        $type_id=Request::getStringParam('type_id');
        $data=Cms_Service_Api_Contents_Question::getInstance()->getCmsTypesList($type_id,true);
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

    if(Request::isAjax() && Request::getStringParam('do')=='searchkw'){
      try{
        $data=Cms_Service_Api_Keywords::getInstance()->searchKeywords(Request::getStringParam('kwstr'));
        Response::json_success($data);
      }catch(Exception $e){
        Response::error_end($e);
      }
    }

    if(Request::getStringParam('do')=='createquestion'){
      try{
        $id=Cms_Service_Api_Contents_Question::getInstance()->create();
        $this->redirect('/ask/'.$id.'.html');
      }catch(Exception $e){
        $this->getView()->assign('errmsg',$e->getMessage());
      }
    }


  }

  function replyquestionAction(){
    
  }

}

