function initializ_scripts(){
  /* ==========================================================================
  SELECT
  ========================================================================== */		
  $(".chzn-select").chosen();

  /* $(".chzn-select").chosen();*/
  /* ==========================================================================
  Constructor product
  ========================================================================== */
  $('.b-constructor-product-close').click(function(){
    $(this).parent().fadeOut();
  })
};
initializ_scripts();


/* ==========================================================================
jCarusel
========================================================================== */
$('[data-jcarousel]').each(function() {
  var el = $(this);
  el.jcarousel({'vertical': true});
});

$('[data-jcarousel-control]').each(function() {
  var el = $(this);
  el.jcarouselControl(el.data());
});


/* ==========================================================================
ajax_select_curent_ring
========================================================================== */
$('body').on('click','.ajax_select_curent_ring',function(){

  ring_name = $(this).find('img').attr('src').split('/').pop().split('.')[0];
  ga('send', 'event', 'ViewRing', ring_name);

  //$('.nicescroll-rails').css('visibility', 'hidden');
  $('.b-scroller').scrollTop(0);
  $('.b-product-ajax-container .ajax-continaer-ring').removeClass('b-scroller');

  $('#insert_block_data').scrollTop(0);

  var this_page = $(this).closest('.b-page');

  if($("#globalLangSet").html() == 'ua'){
    lang_url = '/ua';
  }else if($("#globalLangSet").html() == 'en'){
    lang_url = '/en';
  }else{
    lang_url = '';
  }

  $.ajax({
    url: lang_url+$(this).attr('href'),
    dataType: 'html',
    beforeSend : function() {
      //$('#jpreOverlay').css('display', 'block');
      //this_page.find('.b-product').append('<div class="jpreOverlay" style="position: absolute; display:none; top: 0px; left: 0px; width: 100%; height: '+$('.b-prduct-block').innerHeight()+'px; z-index: 9999999;"><div class="class" style="position: absolute; top: 35%; left: 0%;"></div><div class="jpreLoader" style="position: absolute; top: 50%; left: 46%;"><div class="jpreBar" style="width: 100%; height: 0%; overflow: hidden;"></div><div class="b-top-jbar"></div><div class="b-bottom-jbar"></div><div class="b-txt-loader">идет загрузка</div></div></div>')
      //this_page.find('.jpreOverlay').show();
	  lang = $("#globalLangSet").text();
  if(lang == 'ru'){
    load_page = "идет загрузка";
  }else if(lang == 'ua'){
    load_page = "йде завантаження";
  }else{
    load_page = "loading page";
  }
      $('body').append('<div class="jpreOverlay" style="position: fixed; display:none; top: 45px; bottom: 41px; left: 0px; width: 100%; z-index: 9999999;"><div class="class" style="position: absolute; top: 35%; left: 0%;"></div><div class="jpreLoader" style="position: absolute; top: 50%; left: 50%;"><div class="jpreBar" style="width: 100%; height: 0%; overflow: hidden;"></div><div class="b-top-jbar"></div><div class="b-bottom-jbar"></div><div class="b-txt-loader">'+load_page+'</div></div></div>');
      $('.jpreOverlay').show();
    },
    success: function(data){
     // alert(1);
      view_product(data);
      $('.jpreOverlay').find('.jpreBar').css({'height':'0%'}).animate({'height':'100%'}, 500, function(){
        $('.jpreOverlay').animate({'opacity': 0}, 250, function(){
          $('.jpreOverlay').remove();
        });
        
      });
      //this_page.find('.jpreBar').css({'height':'0%'}).animate({'height':'100%'},500,function(){
      //  this_page.find('.jpreOverlay').stop(true).fadeOut(200,function(){
      //    this_page.find('.jpreOverlay').remove();
      //  });
      //});

      //*
      //console.log(data);
      //view_product(data);
      /*/
      this_page.find('#insert_block_data').html(data);
      
      $('html,body').stop().animate({scrollTop:this_page.offset().top-46},1500,'easeInOutExpo');
      initializ_scripts();

      $('.b-checkbox').each(function(index, element) {
        if ($(this).find('input').attr("checked")){
          $(this).addClass('b-active');
        }else{
          $(this).removeClass('b-active');
        }
      });
      //*/

    ///////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////
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
          '<div style="font: 12px CharisSilItalic;">'+all_info_ring+'</div>'+
          '<div class="b-size-popup b-size-product" id="order_ring_'+i+'">'+sizer_name+': <a href="#" class="b-open-size-select" id="size_selector_'+i+'_'+ring_id+'">'+size+'</a>'+
          '<div class="b-size-select" >'+sizer+'<div class="b-size-select-close">&times;</div>'+
          '</div>'+
          '</div>'+
          '<div class="b-price-popup"><span class="b-uah" id="popup_'+i+'_price_'+ring_id+'">'+price_uah+'</span> UAH (<span class="b-usd" id="popup_s_'+i+'_price_'+ring_id+'">'+price_usd+'</span> USD)</div>'+
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
  Footer other products
  ============================================================ */




  // Распечатать страницу



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


    
    ///////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////
    




    }
  });
return false;
});
