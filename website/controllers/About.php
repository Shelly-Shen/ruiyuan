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

class AboutController extends Controller_AdminModel{
  function bannerAction(){
  }
  function typesAction(){
    // 分类管理
    if(Request::isAjax() && Request::getStringParam('do_ajax_type')!='')
      Cms_Service_Request_Types::handle('do_ajax_type');
  }
  function helptypesAction(){
    // 分类管理
    if(Request::isAjax() && Request::getStringParam('do_ajax_type')!='')
      Cms_Service_Request_Types::handle('do_ajax_type');
  }
  function createcontentAction(){


    // 文章发布
    if(Request::isAjax() && Request::getStringParam('do_ajax_content')!='')
      Cms_Service_Request_Contents::handle('do_ajax_content');
    if(Request::getStringParam('do_formdata_content')!='')
      Cms_Service_Request_Contents::handle('do_formdata_content');


    $this->getView()->assign('content',(object)[]);
    /*
  	$s=new Service_ZxModel;

  	$do=Request::getStringParam('do');
  	if($do!=''){
  	  try{
        if($do=='create')$s->createcontent();
  	    if(!Request::isAjax())Response::redirect_url('/admin/zx/contentslist');
      }catch(Exception $e){
        if(Request::isAjax())
          Response::json_error($e->getMessage());
        else $this->getView()->assign('errmsg',$e->getMessage());
      }
  	}

  	$this->getView()->assign('zx_tags',$s->getlist(1,10,true)->_data);
    */
  }
  function helpcreatecontentAction(){


    // 文章发布
    if(Request::isAjax() && Request::getStringParam('do_ajax_content')!='')
      Cms_Service_Request_Contents::handle('do_ajax_content');
    if(Request::getStringParam('do_formdata_content')!='')
      Cms_Service_Request_Contents::handle('do_formdata_content');


    $this->getView()->assign('content',(object)[]);
    /*
    $s=new Service_ZxModel;

    $do=Request::getStringParam('do');
    if($do!=''){
      try{
        if($do=='create')$s->createcontent();
        if(!Request::isAjax())Response::redirect_url('/admin/zx/contentslist');
      }catch(Exception $e){
        if(Request::isAjax())
          Response::json_error($e->getMessage());
        else $this->getView()->assign('errmsg',$e->getMessage());
      }
    }

    $this->getView()->assign('zx_tags',$s->getlist(1,10,true)->_data);
    */
  }
  function listAction(){
    $ca=new Cms_Service_Api_Contents;
    $page=Request::getIntParam('page',1);
    $list=$ca->getFooterContentListByKeywordTypeId(Request::getStringParam('contentkw','%'),Request::getStringParam('id',-1),$page);


    $this->getView()->assign('contentslist',$list);
    $this->getView()->assign('page',$page);
  }
  function helplistAction(){
    $ca=new Cms_Service_Api_Contents;
    $page=Request::getIntParam('page',1);
    $list=$ca->getFooterContentListByKeywordTypeId(Request::getStringParam('contentkw','%'),Request::getStringParam('id',-1),$page);


    $this->getView()->assign('contentslist',$list);
    $this->getView()->assign('page',$page);
  }
}
