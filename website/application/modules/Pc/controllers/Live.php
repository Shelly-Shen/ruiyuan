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

class LiveController extends Controller_BaseModel{
	function hotliveAction(){
		if(Request::getStringParam('do')==='gethotlivelist'){
          sleep(rand()%3);
          header('Content-Type: text/json');
          echo '[{"id":1,"name":"李老师","jobs":"运营总监","description":"李老师是淘宝前十排行天猫店总监7年淘宝电商运营经验，淘宝销售破万","img":"/front/images/tv_circle.png","states":"正在直播"},
          	{"id":1,"name":"李老师","jobs":"运营总监","description":"李老师是淘宝前十排行天猫店总监7年淘宝电商运营经验，淘宝销售破万","img":"/front/images/tv_circle.png","states":"2016.7.12 16:00开播"},
          	{"id":1,"name":"李老师","jobs":"运营总监","description":"李老师是淘宝前十排行天猫店总监7年淘宝电商运营经验，淘宝销售破万","img":"/front/images/tv_circle.png","states":"正在直播"},
          	{"id":1,"name":"李老师","jobs":"运营总监","description":"李老师是淘宝前十排行天猫店总监7年淘宝电商运营经验，淘宝销售破万","img":"/front/images/tv_circle.png","states":"2016.7.12 16:00开播"},
          	{"id":1,"name":"李老师","jobs":"运营总监","description":"李老师是淘宝前十排行天猫店总监7年淘宝电商运营经验，淘宝销售破万","img":"/front/images/tv_circle.png","states":"正在直播"},
          	{"id":1,"name":"李老师","jobs":"运营总监","description":"李老师是淘宝前十排行天猫店总监7年淘宝电商运营经验，淘宝销售破万","img":"/front/images/tv_circle.png","states":"2016.7.12 16:00开播"},
          	{"id":1,"name":"李老师","jobs":"运营总监","description":"李老师是淘宝前十排行天猫店总监7年淘宝电商运营经验，淘宝销售破万","img":"/front/images/tv_circle.png","states":"正在直播"},
          	{"id":1,"name":"李老师","jobs":"运营总监","description":"李老师是淘宝前十排行天猫店总监7年淘宝电商运营经验，淘宝销售破万","img":"/front/images/tv_circle.png","states":"2016.7.12 16:00开播"}]';
          die;
        }

	}


}

