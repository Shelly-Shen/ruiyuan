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

class LecturerController extends Controller_BaseModel{
	function compreorderAction(){
		if(Request::getStringParam('do')==='getcompreorderlist'){
			Response::json_success(
				Cms_Service_Api_Users_Teacher::getInstance()->getSortResult(Cms_Service_Api_Recommends::SORT_ALL,
					Request::getIntParam('page',1),
					8
					)->_data
			);
		}
	}

}

