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

class LearnController extends Controller_BaseModel{
	function mycourseAction(){
		if(Request::getStringParam('do')==='getmycourselist'){
           	header('Content-Type: text/json');
          	echo '[
	          	{"id":1,"name":"电商运营","score":3.4,"money":100,"img":"/front/images/tv.png"},
	          	{"id":1,"name":"电商运营","score":3.4,"money":100,"img":"/front/images/tv.png"},
	          	{"id":1,"name":"电商运营","score":3.4,"money":100,"img":"/front/images/tv.png"},
	          	{"id":1,"name":"电商运营","score":3.4,"money":100,"img":"/front/images/tv.png"},
	          	{"id":1,"name":"电商运营","score":3.4,"money":100,"img":"/front/images/tv.png"},
	          	{"id":1,"name":"电商运营","score":3.4,"money":100,"img":"/front/images/tv.png"},
	          	{"id":1,"name":"电商运营","score":3.4,"money":100,"img":"/front/images/tv.png"},
	          	{"id":1,"name":"电商运营","score":3.4,"money":100,"img":"/front/images/tv.png"}]';
          	die;
        }
	}

	function myassessAction(){
		if(Request::getStringParam('do')==='getmyassesslist'){
           	header('Content-Type: text/json');
          	echo '[
	          	{"id":1,"name":"成龙东网络时代微电商经营之道","content":"这课程很好看！！哈哈哈","time":"2016.11.21","replynum":"20","img":"/front/images/assess.png"},
	          	{"id":1,"name":"成龙东网络时代微电商经营之道","content":"这课程很好看！！哈哈哈","time":"2016.11.21","replynum":"20","img":"/front/images/assess.png"},
	          	{"id":1,"name":"成龙东网络时代微电商经营之道","content":"这课程很好看！！哈哈哈","time":"2016.11.21","replynum":"20","img":"/front/images/assess.png"},
	          	{"id":1,"name":"成龙东网络时代微电商经营之道","content":"这课程很好看！！哈哈哈","time":"2016.11.21","replynum":"20","img":"/front/images/assess.png"},
	          	{"id":1,"name":"成龙东网络时代微电商经营之道","content":"这课程很好看！！哈哈哈","time":"2016.11.21","replynum":"20","img":"/front/images/assess.png"},
	          	{"id":1,"name":"成龙东网络时代微电商经营之道","content":"这课程很好看！！哈哈哈","time":"2016.11.21","replynum":"20","img":"/front/images/assess.png"},
	          	{"id":1,"name":"成龙东网络时代微电商经营之道","content":"这课程很好看！！哈哈哈","time":"2016.11.21","replynum":"20","img":"/front/images/assess.png"},
	          	{"id":1,"name":"成龙东网络时代微电商经营之道","content":"这课程很好看！！哈哈哈","time":"2016.11.21","replynum":"20","img":"/front/images/assess.png"}]';
          	die;
        }
	}

	function mycollectAction(){
		if(Request::getStringParam('do')==='getmycollectlist'){
           	header('Content-Type: text/json');
          	echo '[
	          	{"id":1,"name":"电商运营","score":3.4,"money":100,"img":"/front/images/tv.png"},
	          	{"id":1,"name":"电商运营","score":3.4,"money":100,"img":"/front/images/tv.png"},
	          	{"id":1,"name":"电商运营","score":3.4,"money":100,"img":"/front/images/tv.png"},
	          	{"id":1,"name":"电商运营","score":3.4,"money":100,"img":"/front/images/tv.png"},
	          	{"id":1,"name":"电商运营","score":3.4,"money":100,"img":"/front/images/tv.png"},
	          	{"id":1,"name":"电商运营","score":3.4,"money":100,"img":"/front/images/tv.png"},
	          	{"id":1,"name":"电商运营","score":3.4,"money":100,"img":"/front/images/tv.png"},
	          	{"id":1,"name":"电商运营","score":3.4,"money":100,"img":"/front/images/tv.png"}]';
          	die;
        }
	}

	function mydownloadAction(){
		if(Request::getStringParam('do')==='getmydownloadlist'){
           	header('Content-Type: text/json');
          	echo '[
	          	{"id":1,"name":"电商运营","score":3.4,"money":100,"img":"/front/images/tv.png"},
	          	{"id":1,"name":"电商运营","score":3.4,"money":100,"img":"/front/images/tv.png"},
	          	{"id":1,"name":"电商运营","score":3.4,"money":100,"img":"/front/images/tv.png"},
	          	{"id":1,"name":"电商运营","score":3.4,"money":100,"img":"/front/images/tv.png"},
	          	{"id":1,"name":"电商运营","score":3.4,"money":100,"img":"/front/images/tv.png"},
	          	{"id":1,"name":"电商运营","score":3.4,"money":100,"img":"/front/images/tv.png"},
	          	{"id":1,"name":"电商运营","score":3.4,"money":100,"img":"/front/images/tv.png"},
	          	{"id":1,"name":"电商运营","score":3.4,"money":100,"img":"/front/images/tv.png"}]';
          	die;
        }
	}	
}

