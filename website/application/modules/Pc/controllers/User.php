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

class UserController extends Controller_AdminModel{
  function asAction(){
    if(Request::isAjax() && Request::getStringParam('do_ajax_search')!='')
      Cms_Service_Request_Search::handle('do_ajax_search');
  }
  function adminsAction(){
  	$ca=new Cms_Service_Api_Users;
  	$page=Request::getIntParam('page',1);
  	$list=$ca->getlist('UTYPE_ADMIN',$page);

  	$this->getView()->assign('adminslist',$list);
  	$this->getView()->assign('page',$page);
  }
  function normalAction(){
    $ca=new Cms_Service_Api_Users;
    $page=Request::getIntParam('page',1);
    $list=$ca->getlist(['UTYPE_NORMAL','UTYPE_ADMIN,UTYPE_BLACK'],$page);

    $this->getView()->assign('userslist',$list);
    $this->getView()->assign('page',$page);
  }
  function blackAction(){
    $ca=new Cms_Service_Api_Users;
    $page=Request::getIntParam('page',1);
    $list=$ca->getlist('UTYPE_BLACK',$page);

    $this->getView()->assign('userslist',$list);
    $this->getView()->assign('page',$page);
  }
  function authorizeAction(){
  }
  function addAction(){
    if(Request::getStringParam('doadd')){
      Cms_Service_Api_Users::getInstance()->createUser([
        'mobilecode'=>Request::getStringParam('mobilecode'),
        'name'=>Request::getStringParam('name'),
        'password'=>Request::getStringParam('pwd'),
        'recommend'=>Request::getStringParam('recommend'),
        'earn_score'=>Request::getDoubleParam('earn_score'),
        'face'=>@$_FILES['face'],
      ]);
    }
  }

}
