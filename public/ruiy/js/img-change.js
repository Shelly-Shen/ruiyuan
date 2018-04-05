$(document).ready(function(){
  var oImg = $('body .content .row>div:first-child img');
  var htmlAdd = '<div class="big-img"><a id="cha1">×</a><img src=""></div>';
  oImg.click(function(){
    console.log(oImg[0].src);
    $('body').prepend(htmlAdd);
    $('.big-img img').attr("src",oImg[0].src);
    $('#cha1').click(function(){
      console.log(1);
      $('.big-img').css('display','none');
    });
  });
});