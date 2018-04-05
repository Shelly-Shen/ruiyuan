window.addEventListener('scroll',function(e){
	var t = document.documentElement.scrollTop || document.body.scrollTop;
	if(t > 100){
	 	$('#dead').addClass('fixed').removeClass('header');
	 	$('#logo').attr('src','/ruiy/images/logow.png');
	 }else{
	 	$('#dead').removeClass('fixed').addClass('header');
	 	$('#logo').attr('src','/ruiy/images/logob.png')
	 }
	 if(t > 400){
	 	$('#nav').addClass('navf').removeClass('navr');
	 }else{
	 	$('#nav').addClass('navr').removeClass('navf');
	 }
	
})



$("[data-toggle=dropdown]").parent().hover(function(){
	$(this).children().last().toggleClass("in");
});


$('.carousel').carousel({
    interval: 10000
})
$('#cimg').click(function(){
	var pimg = document.getElementById('pimg');
	if(pimg.style.display == 'block'){
		$('#pimg').css('display','none');
	}else{
		$('#pimg').css('display','block');
	}
})

// $('.lian').mouseover(function(){
// 	$('.lian l1').css();
// });


