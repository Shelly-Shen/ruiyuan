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

	class EnvelopeController extends Controller_BaseModel{
		//站内性列表页
		function listAction(){}
		//站内性详情页
		function detailAction(){
			if(Request::isAjax() && Request::getStringParam('do')=='sendmsg'){
	      try{
	        Response::json_success(Cms_Service_Api_Chat::getInstance()->SendMsg(Request::getIntParam("receiver_id"),Request::getStringParam("message")));
	      }catch(Exception $e){
	        Response::error_end($e);
	      }
	    }
		}
		//发送信息
		function sendmsgAction(){
		  if(Request::isAjax() && Request::getStringParam("do")=="searchusername"){
		    Response::json_success(Cms_Service_Api_Users::getInstance()->getlist(-1,-1,1,5,Request::getStringParam('searchkw','###')));
		  }

		  if(Request::isAjax() && Request::getStringParam('do')=='sendmsg'){
	      try{
	        Response::json_success(Cms_Service_Api_Chat::getInstance()->SendMsg(Request::getIntParam("receiver_id"),Request::getStringParam("message")));
	      }catch(Exception $e){
	        Response::error_end($e);
	      }
	    }	

		}
	}
