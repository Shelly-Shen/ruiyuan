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

class CompetitiveController extends Controller_BaseModel{
	function newlistAction(){
		if(Request::getStringParam('do')==='getnewlist'){
			header('Content-Type:text/json');
			echo '[
				{"id":1,"name":"电商运营","score":3.4,"money":100,"img":"/front/images/tv.png"},
				{"id":1,"name":"电商运营","score":3.4,"money":100,"img":"/front/images/tv.png"},
				{"id":1,"name":"电商运营","score":3.4,"money":100,"img":"/front/images/tv.png"},
				{"id":1,"name":"电商运营","score":3.4,"money":100,"img":"/front/images/tv.png"},
				{"id":1,"name":"电商运营","score":3.4,"money":100,"img":"/front/images/tv.png"},
				{"id":1,"name":"电商运营","score":3.4,"money":100,"img":"/front/images/tv.png"},
				{"id":1,"name":"电商运营","score":3.4,"money":100,"img":"/front/images/tv.png"}
			]';
			die;
		}
	}


}

