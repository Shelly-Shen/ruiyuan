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

class ExhibitionController extends Controller_BaseModel{

  function init(){
    $_levels=Cms_Service_Api_Types::getInstance()->listLevel(Cms_Service_TypesConst::SHOW_ROOT_ID,[
      'maxlevel'=>4,
      'ignore_del'=>true,
      'level_max_count'=>6,
      'sub_level_max_count'=>999,
    ]);
    $navbars=[
      ['text'=>'展会首页','href'=>'/exh']
    ];
    foreach($_levels as $level) $navbars[]=$level;
    $this->getView()->assign('navbars_baseurl','/exh/level');
    $this->getView()->assign('navbars',$navbars);
    parent::init();
  }

  function indexAction(){
    /*
    var_dump(Cms_Service_Api_Contents_Show::getInstance()->getSearchList(Cms_Service_TypesConst::SHOW_ROOT_ID,
    Cms_Service_Const::SORT_ALL,
    Cms_Service_Const::ORDER_ALL,
    ['month'=>'2016-11','city_id'=>446],
    1,
    20));
    die;
    */

    if(Request::isAjax() && Request::getStringParam('do')=='searchMonth'){
      Response::json_success(Tool::removeRows(
        Cms_Service_Api_Contents_Show::getInstance()->getSearchList(Cms_Service_TypesConst::SHOW_ROOT_ID,
          Cms_Service_Const::SORT_ALL,
          Cms_Service_Api_Contents_Show::ORDER_TIME,
          ['month'=>Request::getStringParam('month'),'ignore_ended'=>true,],
          1,
          min(6,Request::getIntParam('count',6))
        ),'content,_detail,summary')
      );
    }
    if(Request::isAjax() && Request::getStringParam('do')=='searchCity'){
      Response::json_success(
        Cms_Service_Api_Contents_Show::getInstance()->getSearchList(Cms_Service_TypesConst::SHOW_ROOT_ID,
          Cms_Service_Const::SORT_ALL,
          Cms_Service_Api_Contents_Show::ORDER_TIME,
          ['city_id'=>Request::getStringParam('city_id'),],
          1,
          min(6,Request::getIntParam('count',6))
        )
      );
    }

    if(Request::isAjax() && Request::getStringParam('do')=='concern'){
      try{
      Response::json_success(
        Cms_Service_Api_Contents_Show::getInstance()->setConcern(Request::getIntParam('id'))
      );
      }catch(Exception $e){
        Response::json_error(['msg'=>$e->getMessage()]);
      }
    }


  }

  function exhibitionlistAction(){
    if(Request::isAjax() && Request::getStringParam('do')=='search'){
      Response::json_success(Tool::removeRows(
        Cms_Service_Api_Contents_Show::getInstance()->getSearchList(
          Request::getIntParam('cms_types_id'),
          Request::getIntParam('sort_by'),
          Request::getIntParam('order_by'),
          [
            'city_id'=>Request::getStringParam('city_id',-1),
            'month'=>Request::getStringParam('month',-1),
          ],
          Request::getIntParam('page',1),
          10,
          Request::getStringParam('kw')
        )->_data
      ,'content,_detail'));
    }
  }

  function exhibitiondetailAction(){
    $this->meta->title=$this->meta->title.' - '.$this->meta->sitetitle;
    $this->updateMeta();

    if(Request::getStringParam('do')=='makeorder'){
      try{
      Response::json_success(Cms_Service_Api_ShowOrder::getInstance()->sendwithoutyzm(
        Request::getStringParam('name'),
        Request::getStringParam('remark'),
        Request::getStringParam('mobile')
      ));
      }catch(Exception $e){
        Response::json_error(['msg'=>$e->getMessage()]);
      }
    }

    if(Request::isAjax() && Request::getStringParam('do')=='concern'){
      try{
      Response::json_success(
        Cms_Service_Api_Contents_Show::getInstance()->setConcern(Request::getIntParam('id'))
      );
      }catch(Exception $e){
        Response::json_error(['msg'=>$e->getMessage()]);
      }
    }

  }

  function exhibitiondownloadAction(){
    $show_id=Request::getIntParam('show_id');
    $show=Cms_Service_Api_Contents_Show::getInstance()->getDetailById($show_id);

    Response::file(
      APP_PATH.'/public'.$show->_download_file->public_src,
      $show->_download_file->origin_name,
      null
    );
  }

}

