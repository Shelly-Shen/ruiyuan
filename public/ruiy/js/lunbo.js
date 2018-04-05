	window.onload = function() {
            var list = document.getElementsByClassName('lunbo-ul')[0];
            var prev = document.getElementsByClassName('prev')[0];
            var next = document.getElementsByClassName('next')[0];
            var oLi  = list.getElementsByTagName('li');
            var oTilite = document.getElementsByClassName('descriptdiv-title')[0];
            var oText = document.getElementsByClassName('descriptdiv-context')[0];
            var oImg = list.getElementsByTagName('img');
            console.log(oImg.length);
    		var arr1 = ["博士伦1","博士伦2","博士伦3","博士伦4","博士伦5","博士伦6","博士伦7","博士伦8"];
   			var arr2 = ["博士伦是一家全球性的眼睛保健公司，致力于通过创新的科技与技术，让消费者看得更好、形象更好、感觉更好。博士伦成立于1853年，目前年度营业额近二十亿美...","","博士伦是一家全球性的眼睛保健公司，致力于通过创新的科技与技术，让消费者看得更好、形象更好、感觉更好。博士伦成立于1853年，目前年度营业额近二十亿美...","","","","",""];
            function animate(offset) {
                var newLeft = parseInt(list.style.left) + offset;
                list.style.left = newLeft + 'px';
                 if(newLeft<-oLi.length*100){
			      list.style.left = 0+ 'px';
				 }
				 if(newLeft>0){
				      list.style.left = -oLi.length*100 + 'px';
				 }
            }
           
            prev.onclick = function() {             
                animate(800);
            }
            next.onclick = function() {  
                console.log(1);
                animate(-800);
            }
            console.log(oLi[2]);
             for(var i =0;i<oLi.length;i++){
                (function(i){
                oLi[i].onmouseover = function(){
                    oTilite.innerHTML = arr1[i];
                    oText.innerHTML = arr2[i];
                    console.log(0);
                   oImg[i].style.cssText = "border:3px solid red;border-radius: 8px;";
                for(var j = 0;j<oLi.length;j++){
                    if( j != i){
                   oImg[j].style.cssText = "border:none;border-radius: 0px;";
                    }
                }
                }
                oLi[i].onmouseout = function(){
                   oImg[i].style.cssText = "border:3px solid red;border-radius: 8px;";

                }
                })(i);

            }
        }
