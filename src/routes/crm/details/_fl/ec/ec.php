<iframe id="__html_ec" width="100%" height="1200" frameborder="0"></iframe>


<style>
	            	
	#__html_ec:not(.__rdy){
    	background-image: url(<?php echo _iEtg(DMN_IMG_ESTR_SVG.'loader_black.svg') ?>); background-repeat: no-repeat; background-position: center top 50px ;
	}
	
</style>


<?php 
                
    $CntWb .= "

      	var __if_url = '".DMN_EC.LNK_HTML."/".$___Dt->gt->isb."/?__l=ok&__edit=ok&Rnd='+Math.random();  
      
      	var __if_box = $('#__html_ec');

      	__if_box.on('load',function() {  

	        $('#__html_ec').addClass('__rdy');
	        
	    });


		$('#__html_ec').attr('src', __if_url);
			
		
     ";
?>