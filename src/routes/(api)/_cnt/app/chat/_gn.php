<?php 

	
	if(!isN($_cnv_enc)){

		$__chat->maincnv_enc = $_cnv_enc;
		$__chat->_gtDt(); 
		$_MainCnvDt = $__chat->_main_cnv;
		$__dt_chat = $_MainCnvDt->d;

	}elseif(!isN($_cnvrmsj_cnvr)){ 

		$__chat->maincnv_enc = $_cnvrmsj_cnvr;
		$_MainCnvDt = $__chat->MainCnvDt();
		$__dt_chat = $_MainCnvDt->d;

	}

	if(!isN($_cl_us)){ $__dt_us = GtUsDt($_cl_us, 'enc'); }
	if(!isN($_cl_us_oth)){ $__dt_us_oth = GtUsDt($_cl_us_oth, 'enc'); }
	
	if($__p3_o == 'us'){
		
		include(GL_APP."chat/chat_us.php");
		
	}elseif($__p3_o == 'cnv'){
		
		include(GL_APP."chat/chat_cnv.php"); // Detail
		
	}elseif($__p3_o == 'cnv_dt'){
		
		include(GL_APP."chat/chat_cnv_d.php"); // Detail
		
	}elseif($__p3_o == 'snd'){
		
		include(GL_APP."chat/chat_snd.php");
		
	}
				
	
	
?>