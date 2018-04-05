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

class DebugController extends Controller_BaseModel{
  function ipxxAction(){
    var_dump(GreatAPI::Singleton()->FetchUrlData('/ServerIndex/Testxx.cwg'));
    die;
  }
  function transAction(){
  	Cms_Service_Api_Transform::getInstance()->make_request([
  	    'server_file'=>'/website/userdata/transformdir/aax.doc',
  	    'origin_name'=>'wordtest.docx',
  	  ],'http://192.168.0.106:8004/transform/transcb'
  	);
  	die;
  }
  function transcbAction(){
  	$fp=fopen('/tmp/a.log','ab+');
  	fwrite($fp, json_encode(Request::getParams()));
  	var_dump(Request::getParams());
  	die;
  }
  function logAction(){
  	readfile('/tmp/a.log');
  	die;
  }
  function xxxxAction(){
  	Cms_Service_Api_Contents_Cart::getInstance()->delcart(416,[418,420]);
  	var_dump(
  	Cms_Service_Api_Contents_Cart::getInstance()->getcart());
  	exit;
  }
  function qqAction(){
    Cms_Service_Api_AuthLogin_QQ::getInstance()->loginpage();
    die;
  }
  function aaaAction(){
  	$t=Cms_Service_Api_Contents_Question::getInstance();

  // 补充旧数据，回答人
    $ans=$t->getCommentModel()->newsearch2([
      'where'=>'o_state & '.Cms_Service_Api_Comments::STATE_ANSWER.'>0',
      'rows'=>['cms_users_id','target_id'],
    ])->_data;
    for($i=0;$i<count($ans);$i++){
      Cms_Service_Api_Oo::getInstance()->IdId_create(Cms_Service_Api_Contents_Question::OO_ID_AQID,$ans[$i]['cms_users_id'],$ans[$i]['target_id']);
    }

    // 补充旧数据，解答人
    $x=Cms_Service_Api_Comments::STATE_ANSWER|Cms_Service_Api_Contents_Question::ANSWER_BEST;
    $ans=$t->getCommentModel()->newsearch2([
      'where'=>'o_state & '.$x.'='.$x,
      'rows'=>['cms_users_id','target_id'],
    ])->_data;
    $m=$t->getContentModel();
    $m->newupdate([
      'where'=>'content_type=\'question_content\'',
      'update'=>[
        Cms_Service_Api_Contents_Question::ROW_BEST_ANS_USER_ID=>Cms_Service_Const::SYSTEM_CMS_USERS_ID,
      ],
    ]);
    for($i=0;$i<count($ans);$i++){

    $answer_user_id=$ans[$i]['cms_users_id'];


    $m->newupdate([
      'where'=>['id=:question_id','content_type=\'question_content\''],
      'params'=>['question_id'=>$ans[$i]['target_id'],],
      'update'=>[
        Cms_Service_Api_Contents_Question::ROW_BEST_ANS_USER_ID=>$answer_user_id,
      ],
    ]);


    }

  }
  function makeorderAction(){
    Cms_Service_Api_Contents_Order::getInstance()->create('{

    "placeinfo":{
      "receiver":"陈尼玛",
      "province_id":"401",
      "city_id":"402",
      "district_id":"403",
      "fullplace":"茂名x路180号104",
      "email":"182192@abc.com",
      "zipcode":"200182",
      "mobilecode":"18827162514",
      "phonepre":"021987",
      "phonemid":"50291837",
      "phoneext":"12345"
    },

    "data":[{
      "commoditys":[
        {
          "id":"2412",
          "buy":[
            [[2414,2418],14],
            [[2414,2416],6]
          ]
        },
        {
          "id":"2523",
          "buy":[
            [[2525,2528],8],
            [[2526,2529],10],
            [[2527,2529],15]
          ]
        }
      ],
      "remark":"黑色已补差价"
    }],

    "paytype":"score"

    }' // alipay wxpay receiver
    );
  }
}


/*
{
  "2016":{
    "2019,1920":[10,null],
    "2018,180":[7,null]
  },
  "2017":{
    "219,1920":[20,null],
    "18,128":[17,null],
    "18,19":[7,null]
  },
  "2019":{
    "2019,1920":[10,null],
    "2018,180":[7,null]
  },
  "2022":{
    "219,1920":[20,null],
    "18,128":[17,null],
    "18,19":[7,null]
  }
}

[
        [2412,[2414,2418],14],
        [2412,[2414,2416],6],
        [2523,[2525,2528],8],
        [2523,[2526,2529],10],
        [2523,[2527,2529],15]
]

*/
