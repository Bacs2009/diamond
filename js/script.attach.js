 function scrollTop(val, speed){
    $('html,body').stop().animate({scrollTop:val},speed,'easeInOutExpo'); 
  }
  
 
  
  
  var is_flash_ready = false;
  var gid = 0;
  var id = 0;
  function share(network, gid, id, sid, fileName, name, text){
    if(network == 'FACEBOOK'){
      shareFB('/?collection_id='+gid+'&ring_id='+sid,name,'/temp_files/'+fileName,text);
    }else{
      shareVK('/?collection_id='+gid+'&ring_id='+sid,name,'/temp_files/'+fileName,text);
    }
  }
  function close(){
     $.fancybox.close();
     //alert("close");
  }
  function flashReady(){
    is_flash_ready = true;
    if(id > 0){
      select_flash(gid, id);
    }   
  }
  function select_flash(gid_id, id_id){

    if(is_flash_ready){
      document["flashHolder"].select(gid_id, id_id);
    }else{
      gid = gid_id;
      id = id_id;
    }
  }
  function err(err_log){
  }
  function order(gid,id){
    document.location.href = '/?collection_id='+gid+'&ring_id='+id;
  }


head.js("/js/libs/jquery.min.js")
		  .js("/js/jquery.maskedinput.min.js")
		  .js("/js/jpreloader.min.js")
		  .js("/js/chosen.jquery.min.js")
		  .js("/js/jcarusel.js")
		  .js("/js/browser_detect.js")
		  .js("/js/jquery.PrintArea.js")
      //.js("/js/plugins.js")
		  .js("/js/libs/jquery.easing.min.js")
		  .js("/js/jquery.nicescroll.js")
		  .js("/js/jquery.inview.js")
		  .js("/js/chosenImage/chosenImage.jquery.js")
		  .js("/js/fancybox/jquery.fancybox.pack.js?v=2.1.4")
		  .js("/js/libs/jquery.address.js")
          .js("/js/script.js")
		  ;
      if (head.browser.ie)  {
         head.js("http://html5shiv.googlecode.com/svn/trunk/html5.js");
      }