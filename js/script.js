var choozen_option = {
  max_selected_options: 5
};
var isiPad = navigator.userAgent.toLowerCase().indexOf("ipad");
var isAndroid = navigator.userAgent.toLowerCase().indexOf("android");

var popup_view = false;

function handler_mobile(e){
  if(popup_view){
    e.preventDefault();
  }
  //var touch = e.touches[0];
}

if(isiPad > -1 || isAndroid > -1){
  document.addEventListener('touchmove', handler_mobile, false);
}


// Прокрутка страницы, выведенная в отдельную функцию
function scrollTop(val, speed){
  //alert(val);
  $('html,body').stop().animate({scrollTop:val}, speed, 'easeInOutExpo');
}

$.address.externalChange(function(e) {
    //alert('changed');
});

//$(document).ready(function(){ //when the document is ready...
window.onload = function(){
	
	
	flag_ring_name = false;
	var url = location.href;
    var urlAux = url.split('/');
    if(urlAux[5]=='collection'){
    	var lang = urlAux[3];
    	var col = urlAux[6];
        var ring = urlAux[7];
        if(urlAux[6]){
        	analizeUrlOnStart(col, ring, lang);
        }
    }else{
    	var lang = 'ru';
    	var col = urlAux[5];
    	var ring = urlAux[6];
    	if(urlAux[5]){
        	analizeUrlOnStart(col, ring, lang);
        }
    }
    
	
	$('#click-daw').bind('click', function(e){
		
			var isEN = location.href.split("//")[1].split("/")[1];
			
		if(isEN == "en")
		{
			
			
			
			if(isiPad > -1 || isAndroid > -1){
      popup_view = true;
    }else{
      $("html").niceScroll().hide();
    }
    
    
         preloader_animate();
        $('.content_point_m_en').css({'display': 'block'});
  $('#jpreBar').css({'height':'0%'}).stop(true).animate({'height':'100%'},500,function(){
    $('#jpreOverlay').stop(true).fadeOut(200);
    $('#jpreBar').css({'height':'0%'});
        
      $('.b-menu-colection').css('visibility','hidden');
      
  
});
			
		}
		else
		{
			
			
			 if(isiPad > -1 || isAndroid > -1){
      popup_view = true;
    }else{
      $("html").niceScroll().hide();
    }
    
    
         preloader_animate();
        $('.content_point_m').css({'display': 'block'});
  $('#jpreBar').css({'height':'0%'}).stop(true).animate({'height':'100%'},500,function(){
    $('#jpreOverlay').stop(true).fadeOut(200);
    $('#jpreBar').css({'height':'0%'});
        
      $('.b-menu-colection').css('visibility','hidden');
      
  
});

		}
		
	});
	
  // Удаление элемента из сравнения
  $('.b-compare-items .b-close').click(function(){
    var obj = $(this).closest('.ajax-continaer-ring');
    obj.dequeue().hide('fast').fadeOut('fast',function(){
      obj.remove();
      var width_wrapper = 0;
      $('.b-compare-items .b-item').each(function(index, element){
        width_wrapper = width_wrapper + $(this).innerWidth() + 20;
      });
      $('.b-compare-items > .b-wrapper').width(width_wrapper);
    });
    return false;
  });


  //Загрузка прелоадера при превом запуске страницы
  $('body').jpreLoader({
    splashID: "#jSplash",
    loaderVPos: '50%',
    autoClose: true,
    splashFunction: function(){
      $('.b-preloader-overlay').remove();

      var folders = $.address.value().split('/');
      if(folders[1] == ''){
        $('#preloader_scroll').fadeOut();
      }else{
        $.address.externalChange(function(event){
          var folders = event.value.split('/');
          if(folders[3]){
          		
        	  analizeUrlOnStart(folders[2], folders[3]);
            }
          if(folders[1] != 'home'){
            if(folders[1] == 'collection'){
              $('html,body').scrollTop(0);
              var scroll_to = $('#'+folders[2]).offset().top;
              scrollTop(scroll_to, 2500);
            }
            
          }else{
            $('html,body').scrollTop(0);
            $('#preloader_scroll').fadeOut();
             }
        });
      }
    }
  });


  //search wrapper width
  if($('.b-compare-items').length!=0){
    var width_w = 0;
    $('.b-compare-items .b-item').each(function(index, element){
      width_w = width_w + parseInt($(this).innerWidth()) + 25;
    });
    $('.b-compare-items > .b-wrapper').css('width', width_w);
    $(".b-compare-items").niceScroll().resize();
  }


  /* ====== Form scripts ======= */
  $('body').on('click','.b-checkbox',function(){
    if($(this).find('input').hasClass('b-he') || $(this).find('input').hasClass('b-she')){

      if(!$(this).find('input').prop("checked")){
        $(this).find('input').prop({'checked': true});
        $(this).addClass('b-active');
      }else{
        $(this).find('input').prop({'checked': false});
        $(this).removeClass('b-active');
      }

      var it = '.'+$(this).find('input').attr('class')+'-it';
      if(!$(this).find('input').prop("checked")){
       $(this).closest('.b-product-wrapper').find(it).hide();
      }else{
        $(this).closest('.b-product-wrapper').find(it).show();
      }

      if($(this).closest('.b-product-right').find('.b-checkbox.b-active').length==0){
        $(this).click();

        if(!$(this).find('input').prop("checked")){
          $(this).closest('.b-product-wrapper').find(it).hide();
        }else{
          $(this).closest('.b-product-wrapper').find(it).show();
        }
      }
    }else{
      if(!$(this).find('input').prop("checked")){
        $(this).find('input').prop({'checked': true});
        $(this).addClass('b-active');
      }else{
        $(this).find('input').prop({'checked': false});
        $(this).removeClass('b-active');
      }
    }
  });


  $('body').on('click','.b-radio',function(){
    var name = $(this).find('input').attr('name');
    $('input[name="'+name+'"]').each(function(index, element){
      $(this).parent().removeClass('b-active') ;
    });
    if(!$(this).find('input').attr("checked")){
      $(this).find('input').prop({'checked': true});
      $(this).addClass('b-active');
    }else{
      $(this).find('input').prop({'checked': false});
      $(this).removeClass('b-active');
    }
  });



  // Анимация посика
  $('.b-search-button').click(function(){
    if(!$(this).hasClass('b-active')){
      $('.b-search-input').animate({'right':0});
      $(this).addClass('b-active');
    }else{
      $('.b-search-input').animate({'right':-214});
      $(this).removeClass('b-active');
    }
    return false;
  });

  // Ajax товары в коллеции
  if(getQueryVariable('ring_id') && getQueryVariable('collection_id')){
    scrollTop($("#b-page" + getQueryVariable('collection_id')).offset().top, 0);
    open_collection_ring(getQueryVariable('collection_id'),getQueryVariable('ring_id'));
  }
  
  $('body').on('click','.b-show-current',function(){
    if(isiPad > -1 || isAndroid > -1){
      popup_view = true;
    }else{
      $("html").niceScroll().hide();
    }
    var this_page = $(this).closest('.b-page');
    if($("#globalLangSet").html() == 'ua'){
      lang_url = '/ua';
    }else if($("#globalLangSet").html() == 'en'){
      lang_url = '/en';
    }else{
      lang_url = '';
    }
    $.ajax({
        url: lang_url+'/ring/getring?collection_id='+$(this).attr('id').replace('collection_select_','')+'&lang='+$("#globalLangSet").html(),
        dataType: 'html',
        beforeSend: function(){
          preloader_animate();
        },
        success: function(data){
          $('#content_point').html(data);
          ring_name = $('.ajax_select_curent_ring').first().find('img').attr('src').split('/').pop().split('.')[0];
          //alert(data);
          ga('send', 'event', 'ViewRing', ring_name);
          
          $.ajax({
            url: lang_url + $('#content_point .b-ring-select  li:first-child a').attr('href'),
        	dataType: 'html',
            success: function(data){
              view_product(data);
             
            }
          });
        }
      });
      $('.b-menu-colection').css('visibility','hidden');
      return false;
  });


  $('body').on('click','.b-ring-select a',function(){
	  z_name = $(this).children().next().text();
	  z_name = transliterate(z_name);
      $.address.value('collection/'+transliterate($('.b-title-collection').text())+'/'+z_name);
  });




  $('body').on('click','.b-colletcion-list a', new_update_close);
  //$('.b-close-product').click(new_update_close);

  // Ajax запрос для получения списка коллекций и вывод их в списке
  $('body').on('click','#collection_list',function(){
    var top_x;
    if(!$(this).hasClass('b-active')){
      $(this).addClass('b-active');
      $.ajax({
        url: '/site/getcollections?lang='+$("#globalLangSet").html(),
        dataType: 'html',

        success: function(data){
            $('.b-colletcion-list').html(data);
            $('.b-colletcion-list a').each(function() {
                var href = $(this).attr('href');
                var arr = href.split('/');
                if(arr[1]==='ua' || arr[1]==='en'){
                    href = transliterate(arr[4]);
                }else{
                    href = transliterate(arr[3]);
                }
                $(this).attr('href', '/#/collection/'+href);
            });
            top_x = $('.b-colletcion').height();
            $('.b-colletcion').css('top',0-top_x);
            $('.b-colletcion').show().animate({'top':45});
        }
      });
    }else{
      top_x = $('.b-colletcion').height();
      $('.b-colletcion').animate({'top':0-top_x});
      $(this).removeClass('b-active');
    }
    return false;
  });



  $('body').on('click','.b-close-collection',function(){
    var top_x = $('.b-colletcion').height();
    $('.b-colletcion').animate({'top':0-top_x});
    $('#collection_list').removeClass('b-active');
    return false;
  });



  if($('.b-pages').length != 0){
    // Включение скрипта плавного скрола
    $("html").niceScroll();
    // Прокрутка страницы, выведенная в отдельную функцию
    function scrollTop(val, speed){
      //alert(val);
      $('html,body').stop().animate({scrollTop:val},speed,'easeInOutExpo');
    }
    // Если нажали на ссылку с переходом в корень
    $('a').click(function(){
      if($(this).attr('href')=='/'){
        scrollTop(0,2500);
        return false;
      }
    });
    // Меню перехода по коллекциям
    $('body').on('click','.b-menu-colection a, .b-show-colletion, .b-colletcion-list a',function(e){
      if($('.b-colletcion').css('display')=='block'){
        $('.b-close-collection a').click();
      }
      var href = $(this).attr('href');
      if(href.indexOf('/ua/') != -1){
        href = href.replace('/ua/','/');
      }
      if(href.indexOf('/en/') != -1){
        href = href.replace('/en/','/');
      }
      
      
      switch(href.split('/')[3]){
		case 'monarhiya':
			var x = 'b-page8';
			break;
		case 'luck.love.life.':
			var x = 'b-page12';
			break;
		case 'pomolvochnie':
			var x = 'b-page17';
			break;
		case 'nevinnost':
			var x = 'b-page2';
			break;
		case 'rai':
			var x = 'b-page10';
			break;	
		case 'soglasie':
			var x = 'b-page1';
			break;	
		case 'hraniteli':
			var x = 'b-page6';
			break;
		case 'faeton':
			var x = 'b-page5';
			break;
		case 'novoozarennie':
			var x = 'b-page3';
			break;
		case 'grani_lyubvi':
			var x = 'b-page4';
			break;
		case 'solovei':
			var x = 'b-page11';
			break;
		case 'hepipipl':
			var x = 'b-page13';
			break;
		case 'b-page8':
			var x = 'b-page8';
			break;
		case 'b-page12':
			var x = 'b-page12';
			break;
		case 'b-page17':
			var x = 'b-page17';
			break;
		case 'b-page2':
			var x = 'b-page2';
			break;
		case 'b-page10':
			var x = 'b-page10';
			break;	
		case 'b-page1':
			var x = 'b-page1';
			break;	
		case 'b-page6':
			var x = 'b-page6';
			break;
		case 'b-page5':
			var x = 'b-page5';
			break;
		case 'b-page3':
			var x = 'b-page3';
			break;
		case 'b-page4':
			var x = 'b-page4';
			break;
		case 'b-page11':
			var x = 'b-page11';
			break;
		case 'b-page13':
			var x = 'b-page13';
			break;
	} 
      
      var scroll_to = $('#'+x.replace('/#/collection/','')).offset().top;
	    scrollTop(scroll_to,2500);
      $.address.value(href);
      return false;
    });


    //save selectors as variables to increase performance
    var $window = $(window);

    var $pag0  = $('.b-page0');
    var $pag1  = $('.b-page1');
    var $pag2  = $('.b-page2');
    var $pag3  = $('.b-page3');
    var $pag4  = $('.b-page4');
    var $pag5  = $('.b-page5');
    var $pag6  = $('.b-page6');
    var $pag7  = $('.b-page7');
    var $pag8  = $('.b-page8');
    var $pag9  = $('.b-page9');
    var $pag10 = $('.b-page10');
    var $pag11 = $('.b-page11');
    var $pag12 = $('.b-page12');

    var windowHeight = 768; //get the height of the window

    //apply the class "inview" to a section that is in the viewport
    $('.b-page').bind('inview', function (event, visible){
      if(visible == true){
        $(this).addClass("inview");
      } else {
        $(this).removeClass("inview");
      }
    });


    function newPos(x, windowHeight, pos, adjuster, inertia){
      return x + "% " + (-((windowHeight + pos) - adjuster) * inertia)  + "px";
    }

    var $pag0  = $('.b-page0');
    var $pag1  = $('.b-page1');
    var $pag2  = $('.b-page2');
    var $pag3  = $('.b-page3');
    var $pag4  = $('.b-page4');
    var $pag5  = $('.b-page5');
    var $pag6  = $('.b-page6');
    var $pag7  = $('.b-page7');
    var $pag8  = $('.b-page8');
    var $pag9  = $('.b-page9');
    var $pag10 = $('.b-page10');
    var $pag11 = $('.b-page11');


    var parlax_1_1 = $('.bg1_1');
    var parlax_1_2 = $('.bg1_2');

    var parlax_2_1 = $('.bg2_1');
    var parlax_2_2 = $('.bg2_2');
    var parlax_2_3 = $('.bg2_3');

    var parlax_3_1 = $('.bg3_1');
    var parlax_3_2 = $('.bg3_2');
    var parlax_3_3 = $('.bg3_3');
    var parlax_3_4 = $('.bg3_4');

    var parlax_4_1 = $('.bg4_1');
    var parlax_4_2 = $('.bg4_2');
    var parlax_4_3 = $('.bg4_3');

    var parlax_5_1 = $('.bg5_1');
    var parlax_5_2 = $('.bg5_2');
    var parlax_5_3 = $('.bg5_3');

    var parlax_6_1 = $('.bg6_1');
    var parlax_6_2 = $('.bg6_2');

    var parlax_7_1 = $('.bg7_1');
    var parlax_7_2 = $('.bg7_2');
    var parlax_7_3 = $('.bg7_3');

    var parlax_8_1 = $('.bg8_1');
    var parlax_8_2 = $('.bg8_2');
    var parlax_8_3 = $('.bg8_3');

    var parlax_10_1 = $('.bg10_1');
    var parlax_10_2 = $('.bg10_2');
    var parlax_10_3 = $('.bg10_3');

    var parlax_9_1 = $('.bg9_1');
    var parlax_9_2 = $('.bg9_2');

    var parlax_11_1 = $('.bg11_1');
    var parlax_11_2 = $('.bg11_2');
    var parlax_11_3 = $('.bg11_3');
    var parlax_11_4 = $('.bg11_4');

    var parlax_12_1 = $('.bg12_1');
    var parlax_12_2 = $('.bg12_2');
    var parlax_12_3 = $('.bg12_3');


    function Page_int(){
      var pos = $window.scrollTop(); //position of the scrollbar

      $pag0.css({'backgroundPosition': newPos(0, windowHeight, pos, 720, 0.1)});
      /*
      $pag1.css({'backgroundPosition': newPos(0, windowHeight, pos, 1400, 0.1)});
      $pag2.css({'backgroundPosition': newPos(0, windowHeight, pos, 2700, 0.1)});
      $pag3.css({'backgroundPosition': newPos(0, windowHeight, pos, 3700, 0.1)});
      $pag4.css({'backgroundPosition': newPos(0, windowHeight, pos, 4700, 0.1)});
      $pag5.css({'backgroundPosition': newPos(0, windowHeight, pos, 5600, 0.1)});
      $pag6.css({'backgroundPosition': newPos(0, windowHeight, pos, 6500, 0.1)});
      $pag7.css({'backgroundPosition': newPos(0, windowHeight, pos, 7400, 0.1)});
      $pag8.css({'backgroundPosition': newPos(0, windowHeight, pos, 8300, 0.1)});
      $pag9.css({'backgroundPosition': newPos(0, windowHeight, pos, 9200, 0.1)});
      $pag10.css({'backgroundPosition': newPos(0, windowHeight, pos, 10100, 0.1)});
      $pag12.css({'backgroundPosition': newPos(0, windowHeight, pos, 11000, 0.1)});
      $pag11.css({'backgroundPosition': newPos(0, windowHeight, pos, 11900, 0.1)});


      parlax_1_1.css({'backgroundPosition': newPos(105, windowHeight, pos, 2050, 2)});
      parlax_1_2.css({'backgroundPosition': newPos(4, windowHeight, pos, 2000, 0.8)});

      parlax_2_1.css({'backgroundPosition': newPos(25, windowHeight, pos, 3100, 2)});
      parlax_2_2.css({'backgroundPosition': newPos(34, windowHeight, pos, 4100, 0.5)});
      parlax_2_3.css({'backgroundPosition': newPos(80, windowHeight, pos, 3500, 1)});

      parlax_4_1.css({'backgroundPosition': newPos(-3, windowHeight, pos, 5150, 2)});
      parlax_4_2.css({'backgroundPosition': newPos(25, windowHeight, pos, 4900, 0.8)});
      parlax_4_3.css({'backgroundPosition': newPos(80, windowHeight, pos, 7000, 0.3)});

      parlax_5_1.css({'backgroundPosition': newPos(20, windowHeight, pos, 6400, 1)});
      parlax_5_2.css({'backgroundPosition': newPos(70, windowHeight, pos, 6400, 0.5)});
      parlax_5_3.css({'backgroundPosition': newPos(80, windowHeight, pos, 7400, 0.3)});

      parlax_6_1.css({'backgroundPosition': newPos(25, windowHeight, pos, 7400, 0.5)});
      parlax_6_2.css({'backgroundPosition': newPos(80, windowHeight, pos, 7600, 0.2)});

      parlax_7_1.css({'backgroundPosition': newPos(25, windowHeight, pos, 8250, 2)});
      parlax_7_2.css({'backgroundPosition': newPos(73, windowHeight, pos, 8400, 0.5)});
      parlax_7_3.css({'backgroundPosition': newPos(80, windowHeight, pos, 9500, 0.3)});

      parlax_8_1.css({'backgroundPosition': newPos(25, windowHeight, pos, 10500, 0.3)});
      parlax_8_2.css({'backgroundPosition': newPos(73, windowHeight, pos, 9500, 0.5)});
      parlax_8_3.css({'backgroundPosition': newPos(80, windowHeight, pos, 9400, 0.8)});

      parlax_9_1.css({'backgroundPosition': newPos(25, windowHeight, pos, 10400, 0.5)});
      parlax_9_2.css({'backgroundPosition': newPos(73, windowHeight, pos, 10500, 0.3)});

      parlax_12_1.css({'backgroundPosition': newPos(0, windowHeight, pos, 12400, 1)});
      parlax_12_2.css({'backgroundPosition': newPos(73, windowHeight, pos, 12400, 0.5)});
      parlax_12_3.css({'backgroundPosition': newPos(25, windowHeight, pos, 12400, 0.3)});
      //*/
    }


    //function to be called whenever the window is scrolled or resized
    function Move(){
      var pos = $window.scrollTop(); //position of the scrollbar


      //if the first section is in view...
      if($pag0.hasClass("inview")){
        //call the newPos function and change the background position
        $pag0.css({'backgroundPosition': newPos(0, windowHeight, pos, 720, 0.1)});
      }

      //if the first section is in view...
      if($pag1.hasClass("inview")){
        //call the newPos function and change the background position
        $pag1.css({'backgroundPosition': newPos(0, windowHeight, pos, 1200, 0.1)});
        parlax_1_1.css({'backgroundPosition': newPos(105, windowHeight, pos, 1550, 2)});
        parlax_1_2.css({'backgroundPosition': newPos(4, windowHeight, pos, 1500, 0.5)});
      }

      //if the second section is in view...
      if($pag2.hasClass("inview")){
        //call the newPos function and change the background position
        $pag2.css({'backgroundPosition': newPos(0, windowHeight, pos, 2700, 0.1)});
        parlax_2_1.css({'backgroundPosition': newPos(0, windowHeight, pos, 2400, 0.8)});
        parlax_2_2.css({'backgroundPosition': newPos(30, windowHeight, pos, 3500, 0.3)});
        parlax_2_3.css({'backgroundPosition': newPos(90, windowHeight, pos, 2700, 0.5)});
      }

      //if the second section is in view...
      if($pag3.hasClass("inview")){
        //call the newPos function and change the background position
        $pag3.css({'backgroundPosition': newPos(0, windowHeight, pos, 3500, 0.1)});
        parlax_3_1.css({'backgroundPosition': newPos(0, windowHeight, pos, 3400, 0.8)});
        parlax_3_2.css({'backgroundPosition': newPos(90, windowHeight, pos, 3800, 0.5)});
        parlax_3_3.css({'backgroundPosition': newPos(10, windowHeight, pos, 3500, 0.3)});
        parlax_3_4.css({'backgroundPosition': newPos(80, windowHeight, pos, 3600, 0.3)});
      }

      //if the second section is in view...
      if($pag4.hasClass("inview")){
        //call the newPos function and change the background position
        $pag4.css({'backgroundPosition': newPos(0, windowHeight, pos, 4300, 0.1)});
        parlax_4_1.css({'backgroundPosition': newPos(-25, windowHeight, pos, 4200, 0.8)});
        parlax_4_2.css({'backgroundPosition': newPos(25, windowHeight, pos, 4000, 0.5)});
        parlax_4_3.css({'backgroundPosition': newPos(90, windowHeight, pos, 4900, 0.3)});
      }

      //if the second section is in view...
      if($pag5.hasClass("inview")){
        //call the newPos function and change the0background position
        $pag5.css({'backgroundPosition': newPos(0, windowHeight, pos, 5000, 0.1)});
        parlax_5_1.css({'backgroundPosition': newPos(15, windowHeight, pos, 4800, 0.8)});
        parlax_5_2.css({'backgroundPosition': newPos(70, windowHeight, pos, 5000, 0.5)});
        parlax_5_3.css({'backgroundPosition': newPos(80, windowHeight, pos, 5500, 0.3)});
      }

      //if the second section is in view...
      if($pag6.hasClass("inview")){
        //call the newPos function and change the background position
        $pag6.css({'backgroundPosition': newPos(0, windowHeight, pos, 5900, 0.1)});
        parlax_6_1.css({'backgroundPosition': newPos(0, windowHeight, pos, 5500, 0.5)});
        parlax_6_2.css({'backgroundPosition': newPos(100, windowHeight, pos, 5500, 0.2)});
      }

      //if the second section is in view...
      if($pag7.hasClass("inview")){
        //call the newPos function and change the background position
        $pag7.css({'backgroundPosition': newPos(0, windowHeight, pos, 6700, 0.1)});
        parlax_7_1.css({'backgroundPosition': newPos(15, windowHeight, pos, 6600, 0.8)});
        parlax_7_2.css({'backgroundPosition': newPos(80, windowHeight, pos, 7000, 0.3)});
        parlax_7_3.css({'backgroundPosition': newPos(90, windowHeight, pos, 6800, 0.5)});
      }

      //if the second section is in view...
      if($pag8.hasClass("inview")){
        //call the newPos function and change the background position
        $pag8.css({'backgroundPosition': newPos(0, windowHeight, pos, 7500, 0.1)});
        parlax_8_1.css({'backgroundPosition': newPos(15, windowHeight, pos, 7800, 0.3)});
        parlax_8_2.css({'backgroundPosition': newPos(75, windowHeight, pos, 7400, 0.5)});
        parlax_8_3.css({'backgroundPosition': newPos(90, windowHeight, pos, 7300, 0.8)});
      }

      //if the second section is in view...
      if($pag9.hasClass("inview")){
        //call the newPos function and change the background position
        $pag9.css({'backgroundPosition': newPos(0, windowHeight, pos, 8400, 0.1)});
        parlax_9_1.css({'backgroundPosition': newPos(0, windowHeight, pos, 8500, 0.5)});
        parlax_9_2.css({'backgroundPosition': newPos(100, windowHeight, pos, 9000, 0.3)});
      }

      //if the second section is in view...
      if($pag10.hasClass("inview")){
        //call the newPos function and change the background position
        $pag10.css({'backgroundPosition': newPos(0, windowHeight, pos, 9000, 0.1)});
        parlax_10_1.css({'backgroundPosition': newPos(-25, windowHeight, pos, 9000, 0.8)});
        parlax_10_2.css({'backgroundPosition': newPos(80, windowHeight, pos, 9300, 0.3)});
        parlax_10_3.css({'backgroundPosition': newPos(95, windowHeight, pos, 9300, 0.5)});
      }

      //if the second section is in view...
      if($pag12.hasClass("inview")){
        //call the newPos function and change the background position
        $pag12.css({'backgroundPosition': newPos(0, windowHeight, pos, 9800, 0.1)});
        parlax_12_1.css({'backgroundPosition': newPos(0, windowHeight, pos, 9600, 1)});
        parlax_12_2.css({'backgroundPosition': newPos(73, windowHeight, pos, 10000, 0.5)});
        parlax_12_3.css({'backgroundPosition': newPos(25, windowHeight, pos, 10000, 0.3)});
      }

      //if the second section is in view...
      if($pag11.hasClass("inview")){
        //call the newPos function and change the background position
        $pag11.css({'backgroundPosition': newPos(0, windowHeight, pos, 10000, 0.1)});
        parlax_11_1.css({'backgroundPosition': newPos(10, windowHeight, pos, 10600, 0.8)});
        parlax_11_2.css({'backgroundPosition': newPos(25, windowHeight, pos, 11000, 0.3)});
        parlax_11_3.css({'backgroundPosition': newPos(70, windowHeight, pos, 11000, 0.5)});
        parlax_11_4.css({'backgroundPosition': newPos(90, windowHeight, pos, 10700, 0.8)});
      }
    }

    Page_int();

    $window.resize(function(){ //if the user resizes the window...
      if(isiPad > -1 || isAndroid > -1){
        $('.b-data-ring.b-first-block-content').css({
          'position':'relative'
        });
      }else{
        Move(); //move the background images in relation to the movement of the scrollbar
        Page_int();
      }
    });

    $window.bind('scroll', function(){ //when the user is scrolling...

      if(isiPad > -1 || isAndroid > -1){
        $('.b-data-ring.b-first-block-content').css({
          'position':'relative'
        });
      }else{
        Move();
        if($(window).scrollTop() > 89){
          $('.b-data-ring.b-first-block-content').css({
            'position':'relative',
            'top': 89
          });
        }else{
          $('.b-data-ring.b-first-block-content').css({
            'position':'fixed',
            'top': 0
          });
        }
      } //move the background images in relation to the movement of the scrollbar

      var pos = $(window).scrollTop();
      var pageHeight = $('.b-page:first').height();

      var newPage = Math.floor((pos / pageHeight ) - 0.5) + 1;
      newPage = newPage-1;

      if(newPage <= -1){
        $('.b-menu-colection li').removeClass('b-active');
        $('.b-menu-colection').fadeOut();
        $.address.value('home');
      }else{
if(pos >= ($(document).height() - $(window).height())){ //added
			newPage = $('.b-menu-colection li').length-1;         //added
		}   
        $('.b-menu-colection').fadeIn();
        var translit = transliterate($('.b-menu-colection li').eq(newPage).find('a').text());
        var ring_name = $('.b-title-product').text();
        ring_name = ring_name.substring(3)
        ring_name = transliterate(ring_name.substr(0, ring_name.length - 2));
        if(flag_ring_name){
        	$.address.value('collection/'+ translit+'/'+ring_name);
      }else{
    	  $.address.value('collection/'+ translit);
      }
        
        $('.b-menu-colection li').removeClass('b-active');
        $('.b-menu-colection li').eq(newPage).addClass('b-active');
      }

      // Изменение цвета правого меню, если фон темный или светлый
      var color_menu_colletion = $('.b-menu-colection li').eq(newPage).find('a').attr('name');
      if(color_menu_colletion == 'idark'){
        $('.b-menu-colection').removeClass('idark');
      }else{
        $('.b-menu-colection').addClass('idark');
      }
    });
  }




  // Google map
  if($('#map_canvas').length!=0){
    var map_height = $(window).height() - 46 - $('.b-inner-container').height() -42 - 70;
    $('#map_canvas').css('height',map_height);

    $(window).resize(function(e){
      map_height = $(window).height() - 46 - $('.b-inner-container').height() -42 - 70;
      $('#map_canvas').css('height',map_height);
    });
    shopsMap.init();
  }



  /*
  Select size ring
  ========================================================================== */
  $('body').on('click','.b-size-select-close',function(){
    var close_a = $(this);
    close_a.parent().fadeOut();
    close_a.parent().prev('.b-open-size-select').removeClass('b-active');
  });



  $('body').on('click','.b-size-select a',function(){
    var size = $(this).html();
    $(this).closest('.b-size-product').find('.b-open-size-select').html(size);

    $(this).closest('.b-size-product').find('.b-size-select').fadeOut('fast');
    $(this).closest('.b-size-product').find('.b-open-size-select').removeClass('b-active');
    if($(this).closest('.b-size-product').find('.b-open-size-select').attr('id').indexOf('w') != -1){
      ring_id = $(this).closest('.b-size-product').find('.b-open-size-select').attr('id').split('_')[3];
      $("#hidden_size_w").val(size);
      old_price = $("#popup_w_price_"+ring_id).html();
      old_price_s = $("#popup_s_w_price_"+ring_id).html();
      change_price();
    }
    if($(this).closest('.b-size-product').find('.b-open-size-select').attr('id').indexOf('m') != -1){
      ring_id = $(this).closest('.b-size-product').find('.b-open-size-select').attr('id').split('_')[3];
      $("#hidden_size_m").val(size);
      old_price = $("#popup_m_price_"+ring_id).html();
      old_price_s = $("#popup_s_m_price_"+ring_id).html();
      change_price();
    }
    return false;
  });



  $('body').on('click','.b-open-size-select',function(){
    var open_a = $(this);
    open_a.addClass('b-active');
    open_a.next('.b-size-select').fadeIn();
    return false;
  });

  /* ==========================================================================
  By Button
  ========================================================================== */
  $('body').on('click','.b-button-by',function(){
    $('.b-order-aceeted').hide();
    $('.b-order-form-wrapper').show();
    var this_product = $(this).closest('.ajax-continaer-ring');
    var title_popup = this_product.find('.b-title-collection').html();
    $('.b-name-ring-popup').html(title_popup);

    var colection_popup = this_product.find('.b-title-product').html();
    $('.b-name-collection-popup span').html(colection_popup);

    var select_who = false;
    if(this_product.find('.b-checkbox.b-active').length !=0){
      select_who = true;
      $('#order-form').find('.b-who-blocks-popaup').html('');

      var total_uah = 0 , total_usd = 0;
      this_product.find('.b-checkbox.b-active').each(function(index, element){
        if($(this).attr('id').indexOf('m') != -1){
          var i = 'm';
        };
        if($(this).attr('id').indexOf('w') != -1){
          var i = 'w';
        };
        ring_id = $(this).attr('id').split('_')[2];

        var price_product = $(this).closest('.b-price-product');

        var img_popup;

        if(i == 'm'){
          img_popup  = $(this).closest('.b-prduct-block').find('.b-he-it img').attr('src');
          ga('send', 'event', 'OrderRing', img_popup.split('/').pop().split('.')[0]);
        }else{
          img_popup  = $(this).closest('.b-prduct-block').find('.b-she-it img').attr('src');
          ga('send', 'event', 'OrderRing', img_popup.split('/').pop().split('.')[0]);
        }
        if(document.location.href.indexOf('compare') != -1 && $(this).parent('.b-item').length > 0){
          if(i == 'm'){
            img_popup  = $(this).parent('.b-item').find('.b-he-it img').attr('src');
          }else{
            img_popup  = $(this).parent('.b-item').find('.b-she-it img').attr('src');
          }
        }
        var who  = $(this).text();
        var size = price_product.find('.b-open-size-select').html();
        var price_uah = price_product.find('.b-price-block .b-uah').html();
            price_uah = price_uah.replace(/(d{1,3})(?=(?:ddd)+(?:D|$))/g,'$1 ');
        var price_usd = price_product.find('.b-price-block .b-usd').html();
            price_usd = price_usd.replace(/(d{1,3})(?=(?:ddd)+(?:D|$))/g,'$1 ');
       
       
        metal_ring = $("#metal_"+ring_id).html();
        probe_ring = $("#probe_"+ring_id).html();
        stones_ring = $("#stones_"+ring_id).html() || '';
        enamel = $("#enamel_"+ring_id).html() || '';
        surface = $("#surface_"+ring_id).html() || '';
        var all_info_ring = metal_ring+', '+probe_ring+stones_ring+''+surface+''+enamel+$("#weight_"+ring_id).html();

        if(i == 'm'){
          sizer = ' <a href="#">18,5</a><a href="#">19</a><a href="#">19,5</a><a href="#">20</a><a href="#">20,5</a><a href="#">21</a><a href="#">21,5</a><a href="#">22</a><a href="#">22,5</a><a href="#">23</a><a href="#">23,5</a><a href="#">24</a>';
        }else{
          sizer = ' <a href="#">14</a><a href="#">14,5</a><a href="#">15</a><a href="#">15,5</a><a href="#">16</a><a href="#">16,5</a><a href="#">17</a><a href="#">17,5</a><a href="#">18</a><a href="#">18,5</a>';
        }
        sizer_name = $('.b-size-product').first().text().split(':')[0];
        if(sizer_name == ''){
          sizer_name = $('.sizer').first().text();
        }
        $('#order-form').find('.b-who-blocks-popaup').append(
          '<div class="b-who-popup"><div class="b-poup-img"><img src="'+img_popup+'" /></div>'+
          '<div class="b-for-who">'+who+'</div>'+
          //'<div style="font: 12px CharisSilItalic;">'+all_info_ring+'</div>'+
          '<div style="font-family:Georgia, CharisSilItalic; font-size:12px; font-style: italic;">'+all_info_ring+'</div>'+
          '<div class="b-size-popup b-size-product" id="order_ring_'+i+'">'+sizer_name+': <a href="#" class="b-open-size-select" id="size_selector_'+i+'_'+ring_id+'">'+size+'</a>'+
          '<div class="b-size-select" >'+sizer+'<div class="b-size-select-close">&times;</div>'+
          '</div>'+
          '</div>'+
          '<div class="b-price-popup"><span style="display:none;" class="b-uah" id="popup_'+i+'_price_'+ring_id+'">'+price_uah+'</span><span class="b-usd" id="popup_s_'+i+'_price_'+ring_id+'">'+price_usd+'</span> USD</div>'+
          '</div>'
        );

        price_uah = price_uah.replace(' ','');
        price_usd = price_usd.replace(' ','');

        if(i == 'w'){
          $("#hidden_info_w").val(all_info_ring.replace(/"/g,"'"));
        }else{
          $("#hidden_info_m").val(all_info_ring.replace(/"/g,"'"));
        }

        total_uah = total_uah + parseInt(price_uah);
        total_usd = total_usd + parseInt(price_usd);

        $('#order-form .b-price-block .b-uah').html(total_uah).css({'display':'none'});
        $('#order-form .b-price-block .b-usd').html(total_usd);

        var is_price_display = $(this).closest('.b-price-product').find('.b-price-block').css('display');
        if(is_price_display == 'none'){
          $('.b-price-popup').remove();
          $('.b-order-popup .b-total').remove();
        }
        $('#order-form').removeClass('b-tow-by');
        if($('.b-who-popup').length == 2){
          $('#order-form').addClass('b-tow-by');
        }

      });
    }else{
      select_who = false;
    }

    if(select_who == true){
      $.fancybox({
        href: '#order-form',
        'closeBtn':false,
        helpers : {
          overlay : {
            css : {
              'background' : 'rgba(255, 255, 255, 0.8)'
            }
          }
        }
      });
    }else{
      alert('Ошибка! Вы не выбрали "Для него" или "Для нее".');
    }
   
    return false;
  });


  /* ===========================================================
  Send letter call poup button
  ============================================================ */

  $('body').on('click','.b-send-letter',function(){
    $('#former_email').show();
    $('#mail_send').hide();
    $.fancybox({
      href: '#send-letter-form',
      'closeBtn':false,
      helpers : {
        overlay : {
          css : {
            'background' : 'rgba(255, 255, 255, 0.8)'
          }
        }
      }
    });
    return false;
  });


  /* ===========================================================
  Close button in popups
  ============================================================ */

  $('body').on('click','.b-close-popup',function(){
    $.fancybox.close();
  });


  /* ===========================================================
  Garderob link
  ============================================================ */

  $('.b-garderob').fancybox({
    helpers : {
      overlay : {
        css : {
          'background' : 'rgba(0, 0, 0, 0.95)'
        }
      }
    },
    minHeight: 700,
    tpl:{
      wrap : '<div class="fancybox-wrap" tabIndex="-1"><div class="fancybox-skin1"><div class="fancybox-outer"><div class="fancybox-inner"></div></div></div></div>',
    }
  });


  /* ===========================================================
  Открыть конструктор
  ============================================================ */

  $('body').on('click','.b-constructor-open',function(){
    $(this).parent().find('.b-consctructor-block').fadeIn();
    if(isiPad == -1 || isAndroid == -1){
      //if(!$(this).closest('.ajax-continaer-ring').hasClass('b-scroller') && $(window).width() < 1600){
      if(!$(this).closest('.ajax-continaer-ring').hasClass('b-scroller')){
        $(this).closest('.ajax-continaer-ring').addClass('b-scroller');
        $(this).closest('.ajax-continaer-ring').css({
          'height': $(window).height()-45-41-100,
          'overflow-x': 'hideen',
          'overflow-y': 'auto',
          'padding-bottom': 50
        }).niceScroll({autohidemode:false});
      }
    }
    return false;
  });




  $('.weight_help').bind('mouseover',function(){
    ider = "hint_"+$(this).attr('rel');
    $("#"+ider).show();
  });
  $('.weight_help').bind('mouseout',function(){
    ider = "hint_"+$(this).attr('rel');
    $("#"+ider).hide();
  });

  /*
  $('*').bind('mouseover', function(event){
    console.log(this);
  });
  */
};


// ***************** END DOCUMENT READY ************************ //

function preloader_animate(){
  if($('#jpreOverlay').length == 0){
  lang = $("#globalLangSet").text();
  if(lang == 'ru'){
    load_page = "идет загрузка";
  }else if(lang == 'ua'){
    load_page = "йде завантаження";
  }else{
    load_page = "loading page";
  }
  //console.log(load_page);
    $('body').append('<div id="jpreOverlay" style="position: fixed; top: 0px; left: 0px; width: 100%; height: 100%; z-index: 9999999;"><div id="jpreSlide" style="position: absolute; top: 35%; left: 0%;"></div><div id="jpreLoader" style="position: absolute; top: 50%; left: 50%;"><div id="jpreBar" style="width: 100%; height: 0%; overflow: hidden;"></div><div class="b-top-jbar"></div><div class="b-bottom-jbar"></div><div class="b-txt-loader">'+load_page+'</div></div></div>');
  }
  $('#jpreOverlay').show();
  //$('#jpreBar').css({'height':'0%'}).stop(true).animate({'height':'100%'},500,function(){
  //  $('#jpreOverlay').stop(true).fadeOut(200);
  //});
}


function shareVK(link,name,image,text){
  if(!window.location.origin){
    link_add = window.location.protocol+"//"+window.location.host;
    link = link_add+link;
    image = link_add+image;
  }else{
    link =  window.location.origin+link;
    image = window.location.origin+image;
  }
  var newWin = window.open('http://vkontakte.ru/share.php?url='+link+'&image='+image+'&title='+name+'&description='+text, 'vk_share', 'width=500,height=400,resizable=no,scrollbars=no,status=no');
  newWin.focus();
}



function shareFB(link,name,image,text){
  if(!window.location.origin){
    link_add = window.location.protocol+"//"+window.location.host;
    link = link_add+link;
    image = link_add+image;
  }else{
    link =  window.location.origin+link;
    image = window.location.origin+image;
  }
  //console.log(link);
  FB.ui({
    method: 'feed',
    name: name,
    link: link,
    picture: image,
    caption: ' ',
    description: text
  });
}

function shareTW(link,name,image,text){
  if(!window.location.origin){
    link_add = window.location.protocol+"//"+window.location.host;
    link = link_add+link;
    image = link_add+image;
  }else{
    link =  window.location.origin+link;
    image = window.location.origin+image;
  }
  
  var newWin = window.open('https://twitter.com/intent/tweet?text='+text+'&url='+link, 'tw_share', 'width=500,height=400,resizable=no,scrollbars=no,status=no');
  newWin.focus();
}

function shareGO(link,name,image,text){
  if(!window.location.origin){
    link_add = window.location.protocol+"//"+window.location.host;
    link = link_add+link;
    image = link_add+image;
  }else{
    link =  window.location.origin+link;
    image = window.location.origin+image;
  }
 
  var newWin = window.open('https://plus.google.com/share?url='+link, 'google_share', 'width=500,height=400,resizable=no,scrollbars=no,status=no');
  newWin.focus();
}

function sharePIN(link,name,image,text){
  if(!window.location.origin){
    link_add = window.location.protocol+"//"+window.location.host;
    link = link_add+link;
    image = link_add+image;
  }else{
    link =  window.location.origin+link;
    image = window.location.origin+image;
  }
 
  var newWin = window.open('http://pinterest.com/pin/create/bookmarklet/?media='+image+'&url='+link+'&description='+text+': '+name, 'pin_share', 'width=500,height=400,resizable=no,scrollbars=no,status=no');
  newWin.focus();
}


$.fn.chosenDestroy = function(){
  $(this).show().removeClass('chzn-done');
  $(this).next().remove();
  return $(this);
};


function capitaliseFirstLetter(string){
  return string.charAt(0).toUpperCase() + string.slice(1);
}



function add_to_compare_list(woman,man){
  if($("#checker_"+woman).prop('checked')){
    $.get('/compare/addtocompare?id='+woman,function(data){$("#compare_count").html(data);});
  }
  if($("#checker_"+man).prop('checked')){
    setTimeout(function(){$.get('/compare/addtocompare?id='+man,function(data){$("#compare_count").html(data);});},700);
  }
}

link_ua = $("#link_ua").text();
link_ru = $("#link_ru").text();
link_en = $("#link_en").text();

$('.m_names').each(function(){
  $(this).html($(this).html().substr(0,$(this).html().length-2));
});



function metal_changed(metal_id,w,m){
  if(metal_id != ''){
    $('#can_probe').removeAttr('disabled');
    woman = 0; man = 0;
    lang = $("#globalLangSet").text();
    if($('#fm_f').prop('checked')){

    //if($("#checker_"+w).prop('checked')){
      last_metal_w = metal_id;
      $("#metal_"+w).html($("#can_metal option:selected").html());
      woman = w;
    }
    if($('#fm_m').prop('checked')){
    //if($("#checker_"+m).prop('checked')){
      last_metal_m = metal_id;
       $("#metal_"+m).html($("#can_metal option:selected").html());
      man = m;
    }
    $.get('/ring/metalchanged',{lang:lang,metal_id:metal_id,woman:woman,man:man},function(data){
      // console.log(metal_id);
	   if(lang == 'en'){
        to_replace = '<option value="">Standard</option>';
      }else{
        to_replace = '<option value="">Проба</option>';
      }
     // to_replace = '<option value="">Проба</option>';
      max = 0;
      for(elem in data){
        //console.log(data[elem]['probes']);
        if(max<data[elem]['probes']){max = data[elem]['probes'];}
        to_replace += '<option value="'+data[elem]['probes']+'">'+data[elem]['probes']+'</option>';
      }
      $("#can_probe").html(to_replace);
      probe_changed_flag = 0;
       if($('#fm_f').prop('checked')){
         if(last_probe_w != ''){
           $("#can_probe").val(last_probe_w);
           probe_changed_flag = 1;
           max = last_probe_w;
         }
       }
       if($('#fm_m').prop('checked')){
         if(last_probe_m != ''){
           $("#can_probe").val(last_probe_m);
           probe_changed_flag = 1;
           max = last_probe_m;
         }
       }
      if(probe_changed_flag == 0){
        $("#can_probe").val(max);
      }
      $('#can_probe').chosenDestroy();
      $('#can_probe').chosen(choozen_option);
      probe_changed(max,w,m);
      // $("#can_probe").trigger("chosen:updated");
    });
  }else{
    if($('#fm_f').prop('checked')){
      $("#metal_"+w).html(default_metal_w);
    }
    if($('#fm_m').prop('checked')){
      $("#metal_"+m).html(default_metal_m);
    }
	 if(lang == 'en'){
        to_replace = '<option value="">Standard</option>';
      }else{
        to_replace = '<option value="">Проба</option>';
      }
//    to_replace = '<option value="">Проба</option>';
    $('#can_probe').chosenDestroy();
    $("#can_probe").html(to_replace);
    $('#can_probe').attr('disabled','disabled');
    $('#can_probe').chosen(choozen_option);
  }
  change_price();
}



function rebuild_constructor(){
  w = $("#w_ring").text() || 0;
  m = $("#m_ring").text() || 0;
  woman = 0; man = 0;
  if($('#fm_f').prop('checked')){
  //if($("#checker_"+w).prop('checked')){
    woman = w;
  }
  if($('#fm_m').prop('checked')){
  //if($("#checker_"+m).prop('checked')){
    man = m;
  }
  lang = $("#globalLangSet").text();
  if(lang == 'ua'){
    stones_text = "Камені";
  }else if(lang == 'en'){
    stones_text = "Stones";
  }else{
    stones_text = "Камни";
  }

  $.get('/ring/rebuildconstructor',{man:man,woman:woman,lang:lang}, function(data){
    if(lang == 'en'){
      to_replace = '<option value="">Metal</option>';
    }else if(lang == 'ua'){
      to_replace = '<option value="">Метал</option>';
    }else{
      to_replace = '<option value="">Металл</option>';
    }
    for(elem in data['metals']){
      if(data['metals'][elem]['name'] == 'золото'){
        if(lang == 'ru'){
          m_name = data['metals'][elem]['names_m'].replace('W', 'белое, ').replace('P', 'розовое, ').replace('Y','желтое, ').replace('B','черное, ');
        }else if(lang == 'en'){
          m_name = data['metals'][elem]['names_m'].replace('W', 'white, ').replace('P', 'pink, ').replace('Y','yellow, ').replace('B','black, ');
        }else{
          m_name = data['metals'][elem]['names_m'].replace('W', 'біле, ').replace('P', 'рожеве, ').replace('Y','жовте, ').replace('B','чорне, ');
        }
      }else{
        m_name = data['metals'][elem]['names_m'].replace('W', '');
      }
      to_replace += '<option value="'+data['metals'][elem]['names_m']+'">'+capitaliseFirstLetter(m_name)+'</option>';
    }
    $("#can_metal").html(to_replace);
    change_metal = 0;
    if($('#fm_f').prop('checked')){
      if(last_metal_w != ''){
        $("#can_metal").val(last_metal_w);
        change_metal = 1;
        metal_changed(last_metal_w,w,m);
      }
    }
    if($('#fm_m').prop('checked')){
      if(last_metal_m != ''){
        $("#can_metal").val(last_metal_m);
        change_metal = 1;
        metal_changed(last_metal_m,w,m);
      }
    }

    $('#can_metal').chosenDestroy();
    $('#can_metal').chosen(choozen_option);
    if(change_metal == 0){
      if(lang == 'en'){
        to_replace = '<option value="">Standard</option>';
      }else{
        to_replace = '<option value="">Проба</option>';
      }
      $('#can_probe').chosenDestroy();
      $("#can_probe").html(to_replace);
      $('#can_probe').attr('disabled','disabled');
      $('#can_probe').chosen(choozen_option);
    }

    if($('#fm_f').prop('checked') && data['stones']['w'] == 0){
      $('#can_stone').removeAttr('disabled');
      $('#can_stone').val(last_stones_w);
    }else{
       if($('#fm_f').prop('checked')){
        $('#can_stone').val('');
        $('#can_stone').attr('disabled','disabled');
      }
    }

    if($('#fm_m').prop('checked') && data['stones']['m'] == 0){
      $('#can_stone').removeAttr('disabled');
      $('#can_stone').val(last_stones_m);
    }else{
      if($('#fm_m').prop('checked')){
        $('#can_stone').val('');
        $('#can_stone').attr('disabled','disabled');
      }
    }
  $('#can_stone').chosenDestroy();
  $('#can_stone').chosen(choozen_option);

      if($('#fm_f').prop('checked')){
    $("#surface_type").val(last_surface_w);
  }
  if($('#fm_m').prop('checked')){
    $("#surface_type").val(last_surface_m);
  }
  $('#surface_type').chosenDestroy();
  $('#surface_type').chosen(choozen_option);

  if($('#fm_f').prop('checked')){
    $("#enamel_type").val(last_enamel_w);
  }
  if($('#fm_m').prop('checked')){
    $("#enamel_type").val(last_enamel_m);
  }
  $('#enamel_type').chosenDestroy();
  $('#enamel_type').chosen(choozen_option);

  change_price();

  });
}



function change_price(){
  if(document.location.href.indexOf('compare') != -1){
    if($('#order-form').css('display') == 'none'){
      return ;
    }
  }
  lang = $("#globalLangSet").text();
  w_id = $("#w_ring").text() || $("#hidden_ring_w").val();
  m_id = $("#m_ring").text() || $("#hidden_ring_m").val();

  if($('#order-form').css('display') == 'none'){
    size_m = $(".b-open-size-select[id*='ring_m_size']").text();
    size_w = $(".b-open-size-select[id*='ring_w_size']").text();
  }else{
    size_m = $("#size_selector_m_"+m_id).text();
    size_w = $("#size_selector_w_"+w_id).text();
  }
  metal = $("#can_metal").val();
  probe = $("#can_probe").val();
  surface = $("#surface_type").val();
  enamel = $("#enamel_type").val();
  stone_type = $("#can_stone").val();
  woman = 0; man = 0;
  if($('#order-form').css('display') == 'none'){
    if($("#checker_"+w_id).prop('checked')){
      woman = w_id;
      if($('.b-consctructor-block').css('display') == 'block'){
        if($('#fm_f').prop('checked')){
          woman = w_id;
        }else{
          woman = 0;
        }
      }
    }
    if($("#checker_"+m_id).prop('checked')){
      man = m_id;
      if($('.b-consctructor-block').css('display') == 'block'){
        if($('#fm_m').prop('checked')){
          man = m_id;
        }else{
          man = 0;
        }
      }
    }
  }else{
    if($("#size_selector_w_"+w_id) && size_w != ''){
      woman = w_id;
    }
    if($("#size_selector_m_"+m_id) && size_m != ''){
       man = m_id;
    }
  }



  $.post('/ring/changeprice',{lang:lang,
    size_m:size_m,
    size_w:size_w,
    //metal:metal,
    //probe:probe,
    //surface:surface,
    //enamel:enamel,
    //stone_type:stone_type,
    metal_m:last_metal_m,
    metal_w: last_metal_w,
    probe_m: last_probe_m,
    probe_w: last_probe_w,
    surface_m: last_surface_m,
    surface_w: last_surface_w,
    enamel_m: last_enamel_m,
    enamel_w: last_enamel_w,
    stone_type_m: last_stones_m,
    stone_type_w: last_stones_w,
    woman:woman,
    man:man},function(data){

    data['w'] = parseInt(data['w']);
    data['m'] = parseInt(data['m']);
    if($('#order-form').css('display') == 'none'){
      if(data['w'] && data['w'] != '' && data['w'] != 0){
    	  var fresh_price = parseInt(data['w']);
          fresh_price = (Math.round(fresh_price/10))*10;
          if(fresh_price<parseInt(data['w'])){
        	  fresh_price+=10;
          }
    	$("#ring_s_w_price_"+w_id).html(fresh_price);
        $("#ring_w_price_"+w_id).html(fresh_price);
      }
      if(data['m'] && data['m'] != '' && data['m'] != 0){
    	  var fresh_price = parseInt(data['m']);
          fresh_price = (Math.round(fresh_price/10))*10;
          if(fresh_price<parseInt(data['m'])){
        	  fresh_price+=10;
          }
        $("#ring_s_m_price_"+m_id).html(fresh_price);
        $("#ring_m_price_"+m_id).html(fresh_price);
      }
    }else{
      if(data['w'] && data['w'] != '' && data['w'] != 0){
        $("#popup_s_w_price_"+w_id).html(parseInt(data['w']));
        $("#popup_w_price_"+w_id).html(data['w']);
        $("#hidden_price_w").val(data['w']);
        
      }
      if(data['m'] && data['m'] != '' && data['m'] != 0){
        $("#popup_s_m_price_"+m_id).html(parseInt(data['m']));
        $("#popup_m_price_"+m_id).html(data['m']);
        $("#hidden_price_m").val(data['m']);
      }
       //w = parseInt(data['w']) || 0;
       //m = parseInt(data['m']) || 0;
       w = parseInt($("#hidden_price_w").val()) || 0;
       m = parseInt($("#hidden_price_m").val()) || 0;
      
      $('.b-total .b-price-block .b-uah').html(w+m);
      $('.b-total .b-price-block .b-usd').html(parseInt(w+m));
    }
   
  });
}



function enamel_changed(enamel_id,w,m){
  lang = $("#globalLangSet").text();
  if(lang == 'ru'){
    enamel_name = "Цвет эмали";
  }else if(lang == 'ua'){
    enamel_name = "Колір емалі";
  }else{
    enamel_name = "Enamel color";
  }
  if(enamel_id != ''){
  if($('#fm_f').prop('checked')){
    $("#enamel_"+w).html("<br />"+enamel_name+": "+$("#enamel_type option:selected").html());
    last_enamel_w = enamel_id;
  }
  if($('#fm_m').prop('checked')){
    $("#enamel_"+m).html("<br />"+enamel_name+": "+$("#enamel_type option:selected").html());
     last_enamel_m = enamel_id;
  }
  }else{
    if($('#fm_f').prop('checked')){
      $("#enamel_"+w).html(default_enamel_w);
    }
    if($('#fm_m').prop('checked')){
      $("#enamel_"+m).html(default_enamel_m);
    }
  }
  change_price();
}



function stones_changed(stones_id,w,m){
  if(stones_id != ''){
    if($('#fm_f').prop('checked')){
      $("#stones_"+w).find('span.m_name').each(function(){
        $(this).html($("#can_stone option:selected").html());
      });
   // $("#stones_"+w).html();
      last_stones_w = stones_id;
    }
    if($('#fm_m').prop('checked')){
      $("#stones_"+m).find('span.m_name').each(function(){
        $(this).html($("#can_stone option:selected").html());
      });
      last_stones_m = stones_id;
    }
  }else{
    if($('#fm_f').prop('checked')){
      $("#stones_"+w).html(default_stones_w);
    }
    if($('#fm_m').prop('checked')){
      $("#stones_"+m).html(default_stones_m);
    }
  }
  change_price();
}



function surface_changed(surface_id,w,m){
  lang = $("#globalLangSet").text();
  if(lang == 'ru'){
    enamel_name = "Тип покрытия";
  }else if(lang == 'ua'){
    enamel_name = "Тип поверхні";
  }else{
    enamel_name = "Surface type";
  }
  if(surface_id != ''){
  if($('#fm_f').prop('checked')){
    $("#surface_"+w).html("<br />"+enamel_name+": "+$("#surface_type option:selected").html());
    last_surface_w = surface_id;
  }
  if($('#fm_m').prop('checked')){
    $("#surface_"+m).html("<br />"+enamel_name+": "+$("#surface_type option:selected").html());
     last_surface_m = surface_id;
  }
  }else{
    if($('#fm_f').prop('checked')){
      $("#surface_"+w).html(default_surface_w);
    }
    if($('#fm_m').prop('checked')){
      $("#surface_"+m).html(default_surface_m);
    }
  }
  change_price();
}



function probe_changed(probe_id,w,m){
   lang = $("#globalLangSet").text();
   if(lang == 'en'){
     probe_name = 'standard';
   }else{
     probe_name = 'проба';
   }
  if(probe_id != ''){
  if($('#fm_f').prop('checked')){
    $("#probe_"+w).html($("#can_probe option:selected").html()+" "+probe_name);
    last_probe_w = probe_id;
  }
  if($('#fm_m').prop('checked')){
    $("#probe_"+m).html($("#can_probe option:selected").html()+" "+probe_name);
     last_probe_m = probe_id;
  }
  }else{
    if($('#fm_f').prop('checked')){
      $("#probe_"+w).html(default_probe_w);
    }
    if($('#fm_m').prop('checked')){
      $("#probe_"+m).html(default_probe_m);
    }
  }
  change_price();
}



function remove_from_compare(w,m,to_remove){
  if(w != ''){
    $.get('/compare/removecompare?id='+w,function(data){$("#compare_count").html(data);$('#compare_'+to_remove).remove();});
  }
  if(m != ''){
    $.get('/compare/removecompare?id='+m,function(data){$("#compare_count").html(data);$('#compare_'+to_remove).remove();});
  }
}



function set_order_info(w_id, m_id){
  $("#former_order").show();
  //console.log(1);
  if(w_id != 'ring_w_'){
    ring_id = w_id.split('_')[2];
    if($("#checker_"+ring_id).prop('checked')){
      $("#hidden_size_w").val($("#ring_w_size_"+ring_id).text());
      $("#hidden_ring_w").val(ring_id);
      $("#hidden_price_w").val($("#ring_w_price_"+ring_id).text());
    }else{
      $("#hidden_size_w").val('');
     $("#hidden_ring_w").val('');
     $("#hidden_price_w").val('');
    }
  }else{
    $("#hidden_size_w").val('');
    $("#hidden_ring_w").val('');
    $("#hidden_price_w").val('');
  }
  if(m_id != 'ring_m_'){
    ring_id = m_id.split('_')[2];
    if($("#checker_"+ring_id).prop('checked')){
      $("#hidden_size_m").val($("#ring_m_size_"+ring_id).text());
      $("#hidden_ring_m").val(ring_id);
      $("#hidden_price_m").val($("#ring_m_price_"+ring_id).text());
    }else{
      $("#hidden_size_m").val('');
      $("#hidden_ring_m").val('');
      $("#hidden_price_m").val('');
    }
  }else{
    $("#hidden_size_m").val('');
    $("#hidden_ring_m").val('');
    $("#hidden_price_m").val('');
  }
}

$("#former_email input,#former_email textarea").bind('focus',function(){
if($(this).val() == $(this).attr('placeholder')){
$(this).val('');
}
});
$("#former_email input,#former_email textarea").bind('blur',function(){
if($(this).val() == ''){
$(this).val($(this).attr('placeholder'));
}
});


$("#former_order input,#former_order textarea").bind('focus',function(){
if($(this).val() == $(this).attr('placeholder')){
$(this).val('');
}
});
$("#former_order input,#former_order textarea").bind('blur',function(){
if($(this).val() == ''){
$(this).val($(this).attr('placeholder'));
}
});



function view_product(code){
  $('#insert_block_data').html(code);
  f_name = $('.b-title-product').text();
  f_name = f_name.substring(3)
  f_name = transliterate(f_name.substr(0, f_name.length - 2));
  $.address.value('collection/'+transliterate($('.b-title-collection').text())+'/'+f_name);
  $('.b-scroller').scrollTop(0);

  $(".chzn-select").chosen(choozen_option);
  $('.b-checkbox').each(function(index, element){
    if($(this).find('input').attr("checked")){
      $(this).addClass('b-active');
    }else{
      $(this).removeClass('b-active');
    }
  });
  $('.b-constructor-product-close').click(function(){
    //$('.b-scroller').scrollTop(0); //нафейхоа?
    $(this).parent().fadeOut();
  });

  //$('.content_point').css('display', 'block');
  $('.content_point').css({'display': 'block'});
  $('#jpreBar').css({'height':'0%'}).stop(true).animate({'height':'100%'},500,function(){
    $('#jpreOverlay').stop(true).fadeOut(200);
    $('#jpreBar').css({'height':'0%'});
  });



  if(isiPad == -1 || isAndroid == -1){
    if(!$('.content_point .ajax-continaer-ring').hasClass('b-scroller')){
      $('.content_point .ajax-continaer-ring').addClass('b-scroller');
      $('.content_point .ajax-continaer-ring').css({
        'position': 'relative',
        'overflow-x': 'hideen',
        'overflow-y': 'auto',
        'height': (+$('.content_point').height() - (21 + 95)) + 'px'
      });

      $('.content_point .ajax-continaer-ring').niceScroll({autohidemode:false});

      // Волшебный рашпиль

      var magick_rasp = $('.content_point .ajax-continaer-ring').getNiceScroll()[0].id;

      //console.log(magick_rasp);

      $('#' + magick_rasp).css({
        'position': 'fixed'
      }).addClass('magick_rasp');
      //document.getElementById(magick_rasp).style.top = '45px !important';
      //$('.content_point .ajax-continaer-ring').getNiceScroll().css({
      //  'position': 'fixed'
      //});
    }

  }
  $('.b-print-page').unbind('click');
  $('.b-print-page').on('click',function(e){
    //text = $(this).closest('.b-product-ajax-container').html();
    text = $("#insert_block_data").parent().html();
    //console.log(text);
    printwin = open('', 'printwin', 'width=800,height=800');
    printwin.document.open();
    printwin.document.writeln('<html><head><link rel="stylesheet" type="text/css" href="/css/style.css" /></head><body onload="print();close()" class="b-product-wrapper"><style>html{min-width:0px;} #insert_block_data{padding-bottom:0px;} body{ overflow: none; min-width:785px;min-height: 50%;} .b-add-compare-link{display:none} .b-product-wrapper{width: 785px;} .b-compare-product{display:none} .b-ring-select{display:none}</style><style media="print">body{display:block}</style>');
    printwin.document.writeln(text);
    printwin.document.writeln('</body></html>');
    printwin.document.close();
    return false;
  });
  //console.log($('.b-ring-select ul'));
  $('.b-ring-select ul').css('top', 0); //WTF?
    $('[data-jcarousel]').each(function() {
    var el = $(this);
    el.jcarousel({'vertical': true});
  });

  $('[data-jcarousel-control]').each(function() {
    var el = $(this);
    el.jcarouselControl(el.data());
  });



  //$('.b-constructor-product-close').click(function(){
  //  $('.b-scroller').scrollTop(0);
  //  $(this).parent().fadeOut();
  //});

  /*
  var viewport_element = $(block[0]).children().first();
  viewport_element.addClass('fixed_block');



  $('.b-constructor-product-close').click(function(){
    $('.b-scroller').scrollTop(0);
    $(this).parent().fadeOut();
  });

  $('.b-checkbox').each(function(index, element){
    if($(this).find('input').attr("checked")){
      $(this).addClass('b-active');
    }else{
      $(this).removeClass('b-active');
    }
  });

  $('.content_point').css('display', 'block');
  */
  /*
  var random_node = block.find('.ajax-continaer-ring');
  if(isiPad == -1 || isAndroid == -1){
    if(!random_node.hasClass('b-scroller')){
      random_node.addClass('b-scroller');
      random_node.css({
        'height': $(window).height()-45-41-100,
        'overflow-x': 'hideen',
        'overflow-y': 'auto',
        'padding-bottom': 50,
        'position': 'relative'
      });
      random_node.niceScroll({autohidemode:false});
    }
  }
  */

  /*
  Select size ring
  ========================================================================== */
  $('body').on('click','.b-size-select-close',function(){
    var close_a = $(this);
    close_a.parent().fadeOut();
    close_a.parent().prev('.b-open-size-select').removeClass('b-active');
  });



  $('body').on('click','.b-size-select a',function(){
    var size = $(this).html();
    $(this).closest('.b-size-product').find('.b-open-size-select').html(size);

    $(this).closest('.b-size-product').find('.b-size-select').fadeOut('fast');
    $(this).closest('.b-size-product').find('.b-open-size-select').removeClass('b-active');
    if($(this).closest('.b-size-product').find('.b-open-size-select').attr('id').indexOf('w') != -1){
      ring_id = $(this).closest('.b-size-product').find('.b-open-size-select').attr('id').split('_')[3];
      $("#hidden_size_w").val(size);
      old_price = $("#popup_w_price_"+ring_id).html();
      old_price_s = $("#popup_s_w_price_"+ring_id).html();
      change_price();
    }
    if($(this).closest('.b-size-product').find('.b-open-size-select').attr('id').indexOf('m') != -1){
      ring_id = $(this).closest('.b-size-product').find('.b-open-size-select').attr('id').split('_')[3];
      $("#hidden_size_m").val(size);
      old_price = $("#popup_m_price_"+ring_id).html();
      old_price_s = $("#popup_s_m_price_"+ring_id).html();
      change_price();
    }
    return false;
  });



  $('body').on('click','.b-open-size-select',function(){
    var open_a = $(this);
    open_a.addClass('b-active');
    open_a.next('.b-size-select').fadeIn();
    return false;
  });

  /* ==========================================================================
  By Button
  ========================================================================== */
  $('body').on('click','.b-button-by',function(){
    $('.b-order-aceeted').hide();
    $('.b-order-form-wrapper').show();
    var this_product = $(this).closest('.ajax-continaer-ring');
    var title_popup = this_product.find('.b-title-collection').html();
    $('.b-name-ring-popup').html(title_popup);

    var colection_popup = this_product.find('.b-title-product').html();
    $('.b-name-collection-popup span').html(colection_popup);

    var select_who = false;
    if(this_product.find('.b-checkbox.b-active').length !=0){
      select_who = true;
      $('#order-form').find('.b-who-blocks-popaup').html('');

      var total_uah = 0 , total_usd = 0;
      this_product.find('.b-checkbox.b-active').each(function(index, element){
        if($(this).attr('id').indexOf('m') != -1){
          var i = 'm';
        };
        if($(this).attr('id').indexOf('w') != -1){
          var i = 'w';
        };
        ring_id = $(this).attr('id').split('_')[2];

        var price_product = $(this).closest('.b-price-product');
        var img_popup;

        if(i == 'm'){
          img_popup  = $(this).closest('.b-prduct-block').find('.b-he-it img').attr('src');
          ga('send', 'event', 'OrderRing', img_popup.split('/').pop().split('.')[0]);
        }else{
          img_popup  = $(this).closest('.b-prduct-block').find('.b-she-it img').attr('src');
          ga('send', 'event', 'OrderRing', img_popup.split('/').pop().split('.')[0]);
        }
        if(document.location.href.indexOf('compare') != -1 && $(this).parent('.b-item').length > 0){
          if(i == 'm'){
            img_popup  = $(this).parent('.b-item').find('.b-he-it img').attr('src');
          }else{
            img_popup  = $(this).parent('.b-item').find('.b-she-it img').attr('src');
          }
        }
        var who  = $(this).text();
        var size = price_product.find('.b-open-size-select').html();
        var price_uah = price_product.find('.b-price-block .b-uah').html();
            price_uah = price_uah.replace(/(d{1,3})(?=(?:ddd)+(?:D|$))/g,'$1 ');
        var price_usd = price_product.find('.b-price-block .b-usd').html();
            price_usd = price_usd.replace(/(d{1,3})(?=(?:ddd)+(?:D|$))/g,'$1 ');
            //price_usd = Math.round( (price_usd*10) / 10 );

        metal_ring = $("#metal_"+ring_id).html();
        probe_ring = $("#probe_"+ring_id).html();
        stones_ring = $("#stones_"+ring_id).html() || '';
        enamel = $("#enamel_"+ring_id).html() || '';
        surface = $("#surface_"+ring_id).html() || '';
        var all_info_ring = metal_ring+', '+probe_ring+stones_ring+''+surface+''+enamel+$("#weight_"+ring_id).html();

        if(i == 'm'){
          sizer = ' <a href="#">18,5</a><a href="#">19</a><a href="#">19,5</a><a href="#">20</a><a href="#">20,5</a><a href="#">21</a><a href="#">21,5</a><a href="#">22</a><a href="#">22,5</a><a href="#">23</a><a href="#">23,5</a><a href="#">24</a>';
        }else{
          sizer = ' <a href="#">14</a><a href="#">14,5</a><a href="#">15</a><a href="#">15,5</a><a href="#">16</a><a href="#">16,5</a><a href="#">17</a><a href="#">17,5</a><a href="#">18</a><a href="#">18,5</a>';
        }
        sizer_name = $('.b-size-product').first().text().split(':')[0];
        if(sizer_name == ''){
          sizer_name = $('.sizer').first().text();
        }
        $('#order-form').find('.b-who-blocks-popaup').append(
          '<div class="b-who-popup"><div class="b-poup-img"><img src="'+img_popup+'" /></div>'+
          '<div class="b-for-who">'+who+'</div>'+
          //'<div style="font: 12px CharisSilItalic;">'+all_info_ring+'</div>'+
          '<div style="font-family:Georgia, CharisSilItalic; font-size:12px; font-style: italic;">'+all_info_ring+'</div>'+
          '<div class="b-size-popup b-size-product" id="order_ring_'+i+'">'+sizer_name+': <a href="#" class="b-open-size-select" id="size_selector_'+i+'_'+ring_id+'">'+size+'</a>'+
          '<div class="b-size-select" >'+sizer+'<div class="b-size-select-close">&times;</div>'+
          '</div>'+
          '</div>'+
          '<div class="b-price-popup"><span style="display:none" class="b-uah" id="popup_'+i+'_price_'+ring_id+'">'+price_uah+'</span><span class="b-usd" id="popup_s_'+i+'_price_'+ring_id+'">'+price_usd+'</span> USD</div>'+
          '</div>'
        );

        price_uah = price_uah.replace(' ','');
        price_usd = price_usd.replace(' ','');

        if(i == 'w'){
          $("#hidden_info_w").val(all_info_ring.replace(/"/g,"'"));
        }else{
          $("#hidden_info_m").val(all_info_ring.replace(/"/g,"'"));
        }

        total_uah = total_uah + parseInt(price_uah);
        total_usd = total_usd + parseInt(price_usd);

        $('#order-form .b-price-block .b-uah').html(total_uah);
        $('#order-form .b-price-block .b-usd').html(total_usd);

        var is_price_display = $(this).closest('.b-price-product').find('.b-price-block').css('display');
        if(is_price_display == 'none'){
          $('.b-price-popup').remove();
          $('.b-order-popup .b-total').remove();
        }


        $('#order-form').removeClass('b-tow-by');
        if($('.b-who-popup').length == 2){
          $('#order-form').addClass('b-tow-by');
        }

      });
    }else{
      select_who = false;
    }

    if(select_who == true){
      $.fancybox({
        href: '#order-form',
        'closeBtn':false,
        helpers : {
          overlay : {
            css : {
              'background' : 'rgba(255, 255, 255, 0.8)'
            }
          }
        }
      });
    }else{
      alert('Ошибка! Вы не выбрали "Для него" или "Для нее".');
    }
    return false;
  });


  /* ===========================================================
  Send letter call poup button
  ============================================================ */

  $('body').on('click','.b-send-letter',function(){
    $('#former_email').show();
    $('#mail_send').hide();
    $.fancybox({
      href: '#send-letter-form',
      'closeBtn':false,
      helpers : {
        overlay : {
          css : {
            'background' : 'rgba(255, 255, 255, 0.8)'
          }
        }
      }
    });
    return false;
  });


  /* ===========================================================
  Close button in popups
  ============================================================ */

  
  
  $('body').on('click','.b-close-popup',function(){
    $.fancybox.close();
  });


 
  /* ===========================================================
  Garderob link
  ============================================================ */

  $('.b-garderob').fancybox({
    helpers : {
      overlay : {
        css : {
          'background' : 'rgba(0, 0, 0, 0.95)'
        }
      }
    },
    minHeight: 700,
    tpl:{
      wrap : '<div class="fancybox-wrap" tabIndex="-1"><div class="fancybox-skin1"><div class="fancybox-outer"><div class="fancybox-inner"></div></div></div></div>',
    }
  });


  /* ===========================================================
  Открыть конструктор
  ============================================================ */

  $('body').on('click','.b-constructor-open',function(){
    $(this).parent().find('.b-consctructor-block').fadeIn();
    if(isiPad == -1 || isAndroid == -1){
      //if(!$(this).closest('.ajax-continaer-ring').hasClass('b-scroller') && $(window).width() < 1600){
      if(!$(this).closest('.ajax-continaer-ring').hasClass('b-scroller')){
        $(this).closest('.ajax-continaer-ring').addClass('b-scroller');
        $(this).closest('.ajax-continaer-ring').css({
          'height': $(window).height()-45-41-100,
          'overflow-x': 'hideen',
          'overflow-y': 'auto',
          'padding-bottom': 50
        }).niceScroll({autohidemode:false});
      }
    }
    return false;
  });




  $('.weight_help').bind('mouseover',function(){
    ider = "hint_"+$(this).attr('rel');
    $("#"+ider).show();
  });
  $('.weight_help').bind('mouseout',function(){
    ider = "hint_"+$(this).attr('rel');
    $("#"+ider).hide();
  });
  
}

function new_update_close_m(){
  if(isiPad > -1 || isAndroid > -1){
    popup_view = false;
  }else{
    $("html").niceScroll().show();
  }
  $('.nicescroll-rails').css('opacity', '0');
  $('.content_point_m').animate({'opacity': 0}, 250, function(){
    $('.b-scroller').scrollTop(0);
    $(this).css({
      'display': 'none',
      'opacity': 1
    });
    //$('.b-scroller').scrollTop(0);
  });
  $('.b-menu-colection').css('visibility','visible');
  
}

function new_update_close_m_en(){
  if(isiPad > -1 || isAndroid > -1){
    popup_view = false;
  }else{
    $("html").niceScroll().show();
  }
  $('.nicescroll-rails').css('opacity', '0');
  $('.content_point_m_en').animate({'opacity': 0}, 250, function(){
    $('.b-scroller').scrollTop(0);
    $(this).css({
      'display': 'none',
      'opacity': 1
    });
    //$('.b-scroller').scrollTop(0);
  });
  $('.b-menu-colection').css('visibility','visible');
  
}

function new_update_close(){
	flag_ring_name = false;
  if(isiPad > -1 || isAndroid > -1){
    popup_view = false;
  }else{
    $("html").niceScroll().show();
  }
  $('.nicescroll-rails').css('opacity', '0');
  $('.content_point').animate({'opacity': 0}, 250, function(){
    $('.b-scroller').scrollTop(0);
    $(this).css({
      'display': 'none',
      'opacity': 1
    });
    //$('.b-scroller').scrollTop(0);
  });
  $('.b-menu-colection').css('visibility','visible');
  //content_point
  /*
  $('.b-product').removeClass('fixed_block').css({'top':-1046});

  $('.b-menu-colection').css('visibility','visible');
  var folders = $.address.value().split('/');
  try{
    var scroll_to = $('#'+folders[2]).offset().top;
  }catch(err){
  }
  scrollTop(scroll_to,500);
  if(isiPad == -1 || isAndroid == -1){
  }
  $('.b-product-ajax-container').html('');
  link_ua = '/ua/';
  link_ru = window.location.hostname;
  $('.b-lng-select a').first().attr('href',link_ru);
  $('.b-lng-select a').last().attr('href',link_ua);
  */
  
}

function open_collection_ring(collection_id,ring_id){
  if(isiPad > -1 || isAndroid > -1){
    popup_view = true;
  }
  if($("#globalLangSet").html() == 'ua'){
    lang_url = '/ua';
  }else if($("#globalLangSet").html() == 'en'){
    lang_url = '/en';
  }else{
    lang_url = '';
  }

  var this_page = $("#b-page"+collection_id);

  $.ajax({
    url: '/ring/getring?collection_id='+collection_id+'&lang='+$("#globalLangSet").html(),
    dataType: 'html',
    beforeSend: function(){
      preloader_animate();
    },
    success: function(data){
      //console.log(data);
      $('#content_point').html(data);
      
      //$('.carousel-wrapper ul')[0].style.top = 0;
      //DUBUG


      //$('.content_point').css('display', 'block');
      ring_name = $('.ajax_select_curent_ring').first().find('img').attr('src').split('/').pop().split('.')[0];

      ga('send', 'event', 'ViewRing', ring_name);

      $.ajax({
        url: lang_url+'/ring/getfullinfo?ring_id='+ring_id,
        dataType: 'html',
        success: function(data){
          
        	view_product(data);
         
        }
      });


      /*
      $("#b-page"+collection_id).find('.b-product-ajax-container').html(data);
      $('html,body').stop().animate({scrollTop:this_page.offset().top-46},1500,'easeInOutExpo');

      $.ajax({
        url: lang_url+'/ring/getfullinfo?ring_id='+ring_id,
        dataType: 'html',
        success: function(data){
          view_product(this_page, data);
        }
      });
      */
    }
  });

  //this_page.find('.b-product').animate({'top': '45px'});
  $('.b-menu-colection').css('visibility','hidden');
  $("html").niceScroll().hide();

}
 /* ===========================================================
  Footer other products
  ============================================================ */

  $('.b-other-products').click(function(){
    if($('.b-select-wraper').css('display') != 'none'){
      $('.b-select-wraper').hide();
    }else{
      $('.b-select-wraper').show();
    }
    return false;
  });



  $('body:not(.b-other-products)').click(function(){
    $('.b-select-wraper').hide();
  });


  // Распечатать страницу

  $('body').on('click','.b-print-page.b-comapre, .b-search-print',function(e){
    window.print();
    return false;
  });



function getQueryVariable(variable){
  var query = window.location.search.substring(1);
  var vars = query.split('&');
  for (var i = 0; i < vars.length; i++){
    var pair = vars[i].split('=');
    if(decodeURIComponent(pair[0]) == variable){
      return decodeURIComponent(pair[1]);
    }
  }
}

var mask = "(099) 999 99 99";
$('#order_phone').focus(function(){
  if($('#order_phone').val() == ""){
  $('#order_phone').mask(mask);
  $('#order_phone').val("(0");
  }
});
$('#order_phone').blur(function(){
  var phoner = /^\(\d{3}\) \d{3} \d{2} \d{2}$/;
  if(phoner.test($('#order_phone').val()) == false ){
    $('#order_phone').unmask();
	if($("#globalLangSet").html() == 'en'){
      pho = 'Telephone';
    }else{
      pho = 'Телефон';
    }
    setTimeout(function(){$('#order_phone').val(pho);},100);
  }
});

function transliterate(word){

    var answer = "";

    A = new Array();
    A["Ё"]="YO";A["Й"]="I";A["Ц"]="TS";A["У"]="U";A["К"]="K";A["Е"]="E";A["Н"]="N";A["Г"]="G";A["Ш"]="SH";A["Щ"]="SCH";A["З"]="Z";A["Х"]="H";A["Ъ"]="'";A["Є"]="JE";A["є"]="je";
    A["ё"]="yo";A["й"]="i";A["ц"]="ts";A["у"]="u";A["к"]="k";A["е"]="e";A["н"]="n";A["г"]="g";A["ш"]="sh";A["щ"]="sch";A["з"]="z";A["х"]="h";A["ъ"]="'";
    A["Ф"]="F";A["Ы"]="I";A["В"]="V";A["А"]="A";A["П"]="P";A["Р"]="R";A["О"]="O";A["Л"]="L";A["Д"]="D";A["Ж"]="ZH";A["Э"]="E";A[":"]="_";A["1"]="1";A["2"]="2";A["3"]="3";A["4"]="4";A["5"]="5";A["6"]="6";A["І"]="i";A["і"]="i";
    A["ф"]="f";A["ы"]="i";A["в"]="v";A["а"]="a";A["п"]="p";A["р"]="r";A["о"]="o";A["л"]="l";A["д"]="d";A["ж"]="zh";A["э"]="e";
    A["Я"]="YA";A["Ч"]="CH";A["С"]="S";A["М"]="M";A["И"]="I";A["Т"]="T";A["Ь"]="";A["Б"]="B";A["Ю"]="YU";
    A["я"]="ya";A["ч"]="ch";A["с"]="s";A["м"]="m";A["и"]="i";A["т"]="t";A["ь"]="";A["б"]="b";A["ю"]="yu";A[" "]="_";A["."]=".";A["L"]="l";A["o"]="o";A["v"]="v";A["e"]="e";A["u"]="u";A["c"]="c";A["k"]="k";A["i"]="i";A["f"]="f";
    A["A"]="A";A["B"]="B";A["C"]="C";A["D"]="D";A["E"]="E";A["F"]="F";A["G"]="g";A["H"]="H";A["I"]="I";A["J"]="J";A["K"]="K";A["L"]="L";A["M"]="M";A["N"]="N";A["O"]="O";A["P"]="P";A["Q"]="Q";A["R"]="R";A["S"]="S";A["T"]="T";A["W"]="W";A["X"]="X";A["Y"]="Y";A["Z"]="Z";
    A["a"]="a";A["b"]="b";A["c"]="c";A["d"]="d";A["e"]="e";A["f"]="f";A["g"]="g";A["h"]="h";A["i"]="i";A["j"]="j";A["k"]="k";A["l"]="l";A["m"]="m";A["n"]="n";A["o"]="o";A["p"]="p";A["q"]="q";A["r"]="r";A["s"]="s";A["t"]="t";A["w"]="w";A["x"]="x";A["y"]="y";A["z"]="z";
    for (i in word){

        if (A[word[i]] === 'undefined'){
            answer += word[i];
            }
        else {
            answer += A[word[i]];
            }

    }
    answer = answer.toLowerCase();
    return answer; // <=== Was *above* the } on the previous line
}

function analizeUrlOnStart(collection, ring, lang){
	
	
		switch(collection){
			case 'monarhiya':
				var x = 'b-page8';
				break;
			case 'luck.love.life.':
				var x = 'b-page12';
				break;
			case 'pomolvochnie':
			case 'zaruchini':
				var x = 'b-page17';
				break;
			case 'nevinnost':
			case 'nevinnist':
				var x = 'b-page2';
				break;
			case 'rai':
				var x = 'b-page10';
				break;	
			case 'soglasie':
			case 'zlagoda':
				var x = 'b-page1';
				break;	
			case 'hraniteli':
				var x = 'b-page6';
				break;
			case 'faeton':
				var x = 'b-page5';
				break;
			case 'novoozarennie':
			case 'novoosyaini':
				var x = 'b-page3';
				break;
			case 'grani_lyubvi':
			case 'grani_lyubovi':
				var x = 'b-page4';
				break;
			case 'solovei':
				var x = 'b-page11';
				break;
			case 'hepipipl':
				var x = 'b-page13';
				break;	
		} 
		
    
	    
	   if(ring){
		   flag_ring_name = true;
		   //$.get('/ring/metalchanged',{lang:lang,metal_id:metal_id,woman:woman,man:man},function(data)
		   $.ajax({
	             url: '/ring/getidbyname?lang='+lang,
	         	dataType: 'json',
	         	beforeSend: function(){
	                preloader_animate();
	              },
	             success: function(data){
	            	 var flag = true;
					   jQuery.each(data, function(i, val) {
					     val = val['name'];
					     var not_converted = val;
					     val = transliterate(val);
					     var strArray = val.split('_');
					     res = '_';
					     for(i=1; i<strArray.length; i++){
					    	 
					    	 res = res+strArray[i]+'_';
					     }
					     res = res.substr(0, res.length - 1);
					     res = res.substr(1);
					     //Тут будет запрос к контроллеру на предмет айди, при совпадении имени из БД с именем в адресной строке
					     if(ring==res && flag==true){
					    	 //alert(not_converted);
					    	$.ajax({
					             url: '/ring/getrealidbyname?name='+not_converted+'&lang='+lang,
					         	dataType: 'json',
					         	timeout: 1000,
					         	/*beforeSend: function(){
					                preloader_animate();
					              },*/
					             success: function(data){
					            	 c_id = (data[0]['collection_id']);
									   r_id = (data[0]['id']);
									   
									   open_collection_ring(c_id, r_id);
					              
					             },
					             error: function(x, t, m) {
					                 if(t==="timeout") {
					                     alert("got timeout");
					                 } else {
					                     alert(t);
					                 }
					             }
					           });
					    	 
					    	 flag = false;
					    	 delete c_id;
					    	 delete r_id;
					    	 
					    	 //open_collection_ring(6, 171);
					     }
					   });
	              
	             }
	           });
		  
		   
		   
	   }else{
		   var scroll_to = $('#'+x.replace('/#/collection/','')).offset().top;
		    scrollTop(scroll_to,2500);
	   }
}

function print_r(arr, level) {
    var print_red_text = "";
    if(!level) level = 0;
    var level_padding = "";
    for(var j=0; j<level+1; j++) level_padding += "    ";
    if(typeof(arr) == 'object') {
        for(var item in arr) {
            var value = arr[item];
            if(typeof(value) == 'object') {
                print_red_text += level_padding + "'" + item + "' :\n";
                print_red_text += print_r(value,level+1);
		} 
            else 
                print_red_text += level_padding + "'" + item + "' => \"" + value + "\"\n";
        }
    } 

    else  print_red_text = "===>"+arr+"<===("+typeof(arr)+")";
    return print_red_text;
}

function parseUrl( url ) {
    var a = document.createElement('a');
    a.href = url;
    return a;
}