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

class AjaxController extends Controller_BaseModel{
  function init(){
    $this->ignoreSetBefore();
    parent::init();
    Yaf_Dispatcher::getInstance()->disableView();
    // if(!Request::isAjax())die('请求方式错误，如果是调试情况请去掉此处验证');
  }
  function userexistsAction(){
    Cms_Service_Api_Users::getInstance()->infoBy(['name'=>Request::getStringParam('username')])?
      Response::json_error():
      Response::json_success();
  }
  function loginAction(){

    try{
      Cms_Service_Api_Users_Login::getInstance()->loginWith_Mobile_Password(
        Request::getStringParam('mobile'),
        Request::getStringParam('pwd')
      );
      Response::json_success(true);
    }catch(Exception $e){
      Response::json_error(['msg'=>$e->getMessage()]);
    }

  }

  function regnewAction(){
    try{
      if(!fetch_json_data('/ServerSMS/CheckSMS.cwg',[
        'mobilecode'=>Request::getStringParam('mobile'),
        'type0'=>'regnew',
        'yzm'=>Request::getStringParam('mobileyzm'),
      ]))throw new Exception("验证码错误");

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
  function bindAction(){

    try{
      if(!fetch_json_data('/ServerSMS/CheckSMS.cwg',[
        'mobilecode'=>Request::getStringParam('mobile'),
        'type0'=>'regnew',
        'yzm'=>Request::getStringParam('mobileyzm'),
      ]))throw new Exception("验证码错误");
      Cms_Service_Api_Users_Regnew::getInstance()->BindWith_Mobile_MobileYzm(
        Request::getStringParam('mobile'),
        Request::getStringParam('mobileyzm')
      );
      Response::json_success(true);
    }catch(Exception $e){
      Response::json_error(['msg'=>$e->getMessage()]);
    }


  }

  function regnewmobileyzmAction(){
    fetch_json_data('/ServerSMS/RegSMS.cwg',['mobilecode'=>Request::getStringParam('mobile')]);
    //Cms_Service_Api_Mobile::getInstance()->getyzm('regnew',Request::getStringParam('mobile'));
    Response::json_success(true);
  }
  function resetpwdmobileyzmAction(){
    Response::json_success(Cms_Service_Api_Users_Login::getInstance()->require_resetpwd_mobileyzm());
  }

  function resetpwdAction(){
    try{
      Cms_Service_Api_Users_Login::getInstance()->resetpwd_with_mobileyzm(
        Request::getStringParam('mobile'),
        Request::getStringParam('pwd'),
        Request::getStringParam('mobileyzm')
      );
      Response::json_success(true);
    }catch(Exception $e){
      Response::json_error(['msg'=>$e->getMessage()]);
    }
  }

  function signupAction(){
    Cms_Service_Api_Users_Sign::getInstance()->sign();
  }

}
