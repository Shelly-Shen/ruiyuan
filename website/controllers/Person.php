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

class PersonController extends Controller_BaseModel{
	function indexAction(){
    if(Request::getStringParam('do')=='his'){
      try{
        Response::json_success(
          Cms_Service_Api_Contents_Question::getInstance()->userAnswers(
            Request::getIntParam('user_id'),
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
	function personinfoAction(){

	}
	function libraryAction(){

    if(Request::getStringParam('do')=='his'){
      try{
        Response::json_success(
          Cms_Service_Api_Contents_Wenku::getInstance()->userWenkus(
            Request::getIntParam('user_id'),
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
	function examAction(){}

	function askquestionAction(){
    if(Request::getStringParam('do')=='his'){
      try{
        Response::json_success(
          Cms_Service_Api_Contents_Question::getInstance()->userQuestions(
            Request::getIntParam('user_id'),
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
}

