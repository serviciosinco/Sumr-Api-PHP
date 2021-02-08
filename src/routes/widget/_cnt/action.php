<?php 
	
	if($_GET['Camilo']=='ok'){ echo 'Here'; /* print_r($_SERVER);*/ exit(); }

	$_id = PrmLnk('rtn', 2, 'ok');
	if(!isN($_id)){ $_wdgt_act_dt = GtClWdgtActDt([ 'id'=>$_id, 't'=>'enc' ]); }
	

    if($_wdgt_act_dt->chnl->id == _Cns('ID_WDGTCHNL_WHTSP')){

		if(isMobile() || !isN($_SERVER['HTTP_CLOUDFRONT_IS_MOBILE_VIEWER'])){	
			$_wa_url = 'api.whatsapp.com';
		}else{
			$_wa_url = 'web.whatsapp.com';
		}

		if($_wdgt_act_dt->wa->wlcm){ $_text = '&text='.rawurlencode($_wdgt_act_dt->wa->wlcm); }
		
		if($_GET['Camilo']=='ok'){
			echo h1( 'isMobile()->:'.isMobile() );
			echo h2( "HTTP_CLOUDFRONT_IS_MOBILE_VIEWER:".$_SERVER['HTTP_CLOUDFRONT_IS_MOBILE_VIEWER'] );
			echo $_wa_url; 
			echo 'Location: https://'.$_wa_url.'/send?phone='.$_wdgt_act_dt->chnl->lne.$_text;
			exit();
		}

	    header('Location: https://'.$_wa_url.'/send?phone='.$_wdgt_act_dt->chnl->lne.$_text);
		die();    
    }
    
         
?>