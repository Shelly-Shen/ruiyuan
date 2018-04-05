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

class MypersonController extends Controller_BaseModel{
    //购买服务
    function goodslistAction(){}
    //绑定商家
    function bindbusinessAction(){}
    //商家信息
    function businessinfoAction(){}
    //资讯列表
    function zxlistAction(){}
    //发布质询
    function publishzxAction(){}
    function developingAction(){}

    function editanswerAction(){

    if(Request::isAjax() && Request::getStringParam('do')=='edit'){
        try{
          Response::json_success([
            Cms_Service_Api_Contents_Question::getInstance()->editAnswer(
              Cms_Service_Const::EDIT_BY_AUTHOR,
              Request::getIntParam('answer_id'),
              Request::getStringParam('answer')
            )
          ]);
        }catch(Exception $e){
          Response::json_error($e->getMessage());
          // Response::error_end($e);
        }
      }

    }

    function editquestionAction(){
    if(Request::isAjax() && Request::getStringParam('do')=='checkexist'){
      try{
        Cms_Service_Api_Contents::getInstance()->checkExists(
          Request::getStringParam('title'),
          Cms_Service_Api_Contents::DUMP_QUESTION_TITLE,
          Request::getIntParam('id')
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

    if(/*Request::isAjax() &&*/ Request::getStringParam('do')=='gettypebyid'){
      try{
        /*$type_id=Request::getStringParam('type_id');
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

    if(/*Request::isAjax() &&*/ Request::getStringParam('do')=='searchkw'){
      try{
        $data=Cms_Service_Api_Keywords::getInstance()->searchKeywords(Request::getStringParam('kwstr'));
        Response::json_success($data);
      }catch(Exception $e){
        Response::error_end($e);
      }
    }

    if(Request::getStringParam('do')=='editquestion'){
      try{
        Cms_Service_Api_Contents_Question::getInstance()->save(Cms_Service_Api_Contents_Question::EDIT_BY_AUTHOR);
        $this->redirect('/pc/question/questiondetail?question_id='.Request::getIntParam('question_id'));
      }catch(Exception $e){
        $this->getView()->assign('errmsg',$e->getMessage());
      }
    }
    }

    function interestingAction(){
      if(/*Request::isAjax() &&*/ Request::getStringParam('do')=='searchkw'){
        try{
          $data=Cms_Service_Api_Keywords::getInstance()->searchKeywords(Request::getStringParam('kwstr'),10);
          Response::json_success($data);
        }catch(Exception $e){
          Response::error_end($e);
        }
      }
      if(/*Request::isAjax() &&*/ Request::getStringParam('do')=='save'){
        try{
          Response::json_success(Cms_Service_Api_Users_Interest::getInstance()->resetmy(Request::getArrayParam('kws')));
        }catch(Exception $e){
          Response::error_end($e);
        }
      }
    }

    function uploadphotoAction(){
    if(Request::getStringParam('do')=='change'){

      try{
        $result=Cms_Service_Api_Users::getInstance()->changemyimgs();
      }catch(Exception $e){
        $result=['msg'=>$e->getMessage()];
      }
      Response::iframeCallback(Request::getStringParam('cbname'),$result);

    }

    }
    
    function myquestionAction(){

    if(Request::getStringParam('do')=='my'){
      try{
        Response::json_success(
          Cms_Service_Api_Contents_Question::getInstance()->userQuestions(
            null,
            Request::getIntParam('page',1),
            20
          )->_data
        );
      }catch(Exception $e){
        Response::json_error($e->getMessage());
        // Response::error_end($e);
      }
    }

    if(Request::isAjax() && Request::getStringParam('do')=='del'){
      Cms_Service_Api_Contents_Question::getInstance()->delmy(Request::getIntParam('id'));
    }



    }
    function myanswerAction(){
    if(Request::getStringParam('do')=='my'){
      try{
        Response::json_success(
          Cms_Service_Api_Contents_Question::getInstance()->userAnswers(
            null,
            Request::getIntParam('page',1),
            20
          )->_data
        );
      }catch(Exception $e){
        Response::json_error($e->getMessage());
        // Response::error_end($e);
      }
    }
    }
    function mylibraryAction(){

    if(Request::getStringParam('do')=='my'){
      try{
        Response::json_success(
          Cms_Service_Api_Contents_Wenku::getInstance()->userWenkus(
            Cms_Service_Const::ID_NOT_EXISTS,
            Request::getIntParam('page',1),
            20
          )->_data
        );
      }catch(Exception $e){
        Response::json_error($e->getMessage());
        // Response::error_end($e);
      }
    }

    if(Request::isAjax() && Request::getStringParam('do')=='del'){
      Cms_Service_Api_Contents_Wenku::getInstance()->delmy(Request::getIntParam('id'));
    }


    }

    function mycommentAction(){

    }
  
    function commentmyAction(){

    }
    //商城订单
    function mallorderAction(){}

    //我得积分
    function myscoreAction(){
      if(Request::isAjax() && Request::getStringParam('do')=='getScoreList'){
        Response::json_success(
          Cms_Service_Api_Users_Score::getInstance()->getList(Request::getIntParam('page'),20)->_data
        );
      }
    }


    //账户设置
    function setuserAction(){

    if(Request::getStringParam('do')=='change'){
      try{
        Response::json_success(
          Cms_Service_Api_Users::getInstance()->changemyinfo()
        );
      }catch(Exception $e){
        Response::json_error(['msg'=>$e->getMessage()]);
        // Response::error_end($e);
      }
    }

    }
    //修改密码
    function updatepassAction(){

    if(Request::getStringParam('do')=='change'){
      try{
        Response::json_success(
          Cms_Service_Api_Users::getInstance()->changepwd_by_oldpass(
            Request::getStringParam('oldpwd'),
            Request::getStringParam('newpwd')
          )
        );
      }catch(Exception $e){
        Response::json_error($e->getMessage());
        // Response::error_end($e);
      }
    }

    }
    //问题反馈
    function questionfeedbackAction(){

    if(Request::getStringParam('do')=='dosend'){
      try{
        Response::json_success(
          Cms_Service_Api_Feedback::getInstance()->sendwithoutyzm(
            Request::getStringParam('msg'),
            Request::getStringParam('mobilecode')
          )
        );
      }catch(Exception $e){
        Response::json_error(['msg'=>$e->getMessage()]);
        // Response::error_end($e);
      }
    }

    }

    //申请专家
    function applyexpertAction(){

    if(Request::getStringParam('do')=='apply'){
      try{
        $result=Cms_Service_Api_Users_Qualify::getInstance()->apply(null,Cms_Service_Api_Users_Qualify::APPLY_TYPE_EXPERTS);
      }catch(Exception $e){
        $result=['msg'=>$e->getMessage()];
      }
      Response::iframeCallback(Request::getStringParam('cbname'),$result);
    }

    }
    //申请机构
    function applyagencyAction(){

    if(Request::getStringParam('do')=='apply'){
      try{
        $result=Cms_Service_Api_Users_Qualify::getInstance()->apply(null,Cms_Service_Api_Users_Qualify::APPLY_TYPE_ORGANIZE);
      }catch(Exception $e){
        $result=['msg'=>$e->getMessage()];
      }
      Response::iframeCallback(Request::getStringParam('cbname'),$result);
    }

    }
    function zxcommentAction(){

    if(Request::getStringParam('do')=='my'){
      try{
        Response::json_success(
          Cms_Service_Api_Contents_Default::getInstance()->userComments(
            null,
            Request::getIntParam('page',1),
            20
          )->_data
        );
      }catch(Exception $e){
        Response::json_error($e->getMessage());
        // Response::error_end($e);
      }
    }

    if(Request::getStringParam('do')=='del'){
      Cms_Service_Api_Contents_Default::getInstance()->delCommentMy(Request::getIntParam('id'));
    }



    }
    function questionbankcommentAction(){

    }
    function zxcommentmyAction(){

    }
    function questioncommentAction(){


    if(Request::getStringParam('do')=='my'){
      try{
        Response::json_success(
          Cms_Service_Api_Contents_Question::getInstance()->userComments(
            null,
            Request::getIntParam('page',1),
            20
          )->_data
        );
      }catch(Exception $e){
        Response::json_error($e->getMessage());
        // Response::error_end($e);
      }
    }

    if(Request::getStringParam('do')=='del'){
      Cms_Service_Api_Contents_Question::getInstance()->delCommentMy(Request::getIntParam('id'));
    }



    }

    function questioncommentmyAction(){

    if(Request::getStringParam('do')=='my'){
      try{
        Response::json_success(
          Cms_Service_Api_Contents_Question::getInstance()->userCommenteds(
            null,
            Request::getIntParam('page',1),
            20
          )->_data
        );
      }catch(Exception $e){
        Response::json_error($e->getMessage());
        // Response::error_end($e);
      }
    }

    }

    function librarycommentAction(){


    if(Request::getStringParam('do')=='my'){
      try{
        Response::json_success(
          Cms_Service_Api_Contents_Wenku::getInstance()->userComments(
            null,
            Request::getIntParam('page',1),
            20
          )->_data
        );
      }catch(Exception $e){
        Response::json_error($e->getMessage());
        // Response::error_end($e);
      }
    }

    if(Request::getStringParam('do')=='del'){
      Cms_Service_Api_Contents_Wenku::getInstance()->delCommentMy(Request::getIntParam('id'));
    }


    }
    function librarycommentmyAction(){

    if(Request::getStringParam('do')=='my'){
      try{
        Response::json_success(
          Cms_Service_Api_Contents_Wenku::getInstance()->userCommenteds(
            null,
            Request::getIntParam('page',1),
            20
          )->_data
        );
      }catch(Exception $e){
        Response::json_error($e->getMessage());
        // Response::error_end($e);
      }
    }

    }
    function examcommentAction(){}
    function examcommentmyAction(){}
    function productcommentAction(){}
    function productcommentmyAction(){}
    
    //展会订单
    function exhibitionorderAction(){}


    //我得等级
    function mylevelAction(){}
    //积分充值
    function scorerechangeAction(){}
    //积分明细
    function scoredetailAction(){}



}

