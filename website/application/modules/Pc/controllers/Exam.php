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
 
 class ExamController extends Controller_BaseModel{
  function init(){
    $_levels=Cms_Service_Api_Types::getInstance()->listLevel(Cms_Service_TypesConst::QUESTIONBANK_ROOT_ID,[
      'maxlevel'=>4,
      'ignore_del'=>true,
      'level_max_count'=>6,
      'sub_level_max_count'=>999,
    ]);
    $navbars=[
      ['text'=>'消防考试','href'=>'/pc/exam/index']
    ];
    foreach($_levels as $level) $navbars[]=$level;
    $this->getView()->assign('navbars_baseurl','/pc/exam/examlist');
    $this->getView()->assign('navbars',$navbars);
    parent::init();
  }

 	//考试首页
 	function indexAction(){}
 	//考试列表页
 	function examlistAction(){}
 	//考试详情页
 	function detailAction(){

      $detail=json_decode(GreatAPI::Singleton()->FetchUrlData('/ServerQuestionBank/GetPaperDetail.cwg',array(
        'id'=>Request::getIntParam('id'),
        'begin'=>Request::getStringParam("renew","no"),
      )));

      if($detail->_answering_detail->_has_record && !$detail->_answering_detail->_is_answering){
      	Response::redirect_url('/pc/exam/result?id='.Request::getIntParam("id"));
      }

 	}
 	//课程目录
 	function contentsAction(){}
 	//考试结果
 	function resultAction(){}
  //习题练习
 	function exampracticeAction(){}
  
  //习题评论
  function examcommentAction(){}

 }