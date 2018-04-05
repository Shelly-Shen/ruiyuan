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

class SiteController extends Controller_AdminModel{

  function configAction(){

    if(Request::getStringParam('do_formdata_siteinfo')!='')
      Cms_Service_Request_Website::handle('do_formdata_siteinfo');

  	$ca=new Cms_Service_Api_Website;
  	$this->getView()->assign('info',$ca->getinfo());

  }
  function filterwordAction(){

    if(Request::getStringParam('do_formdata_siteinfo')!='')
      Cms_Service_Request_Website::handle('do_formdata_siteinfo');

  	$ca=new Cms_Service_Api_Website;
  	$this->getView()->assign('info',$ca->getinfo());

  }

  function navAction(){
  // 分类管理
    if(Request::isAjax() && Request::getStringParam('do_ajax_type')!='')
      Cms_Service_Request_Types::handle('do_ajax_type');
  }

  function navdetailAction(){
  // 分类详细管理
    if(Request::getStringParam('do_formdata_typedetail')!='')
      Cms_Service_Request_Types::handle('do_formdata_typedetail');
  }

  function appupdateAction(){
    if(Request::getStringParam('do_updateapp')=='1')
      Cms_Service_Api_Website::getInstance()->updateapp();
  }

}
