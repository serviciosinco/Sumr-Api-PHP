<?php 

	$_ida = Php_Ls_Cln($_GET['ida']);
	$_phne = Php_Ls_Cln($_GET['phne']);
	$_nm = Php_Ls_Cln($_GET['nm']);

	if(!isN($_ida)){ 
		$_wdgt_act_dt = GtClWdgtActDt([ 'id'=>$_ida, 't'=>'enc', 'd'=>['cl'=>'ok', 'aws'=>'ok' ] ]);
	}
    
    //$r['tmp'] = $_wdgt_act_dt;

	if(!isN($_wdgt_act_dt->id)){
        
        $url = DMN_WDGT.'action/'.$_ida.'/';

        $shrt = new CRM_Shrt([ 'cl'=>$_wdgt_act_dt->cl->enc ]);
        $shrt->shrt_url = $url;
        $shrtu = $shrt->get([ 'url'=>$shrt->shrt_url ])->url;
        
        if(!isN($_wdgt_act_dt) && !isN($_wdgt_act_dt->aws)){
            $_tkns['key'] = $_wdgt_act_dt->aws->key;
            $_tkns['scrt'] = $_wdgt_act_dt->aws->scrt;
        }

        $aws = new API_CRM_Aws($_tkns);
        $aws->us_to = '57'.$_phne;
        $aws->us_msj = '¡Hola! Inicia la conversacion con '.(!isN($_wdgt_act_dt->cl->nm)?strtoupper($_wdgt_act_dt->cl->nm):'').' en Whatsapp dando clic en el siguiente enlace '.$shrtu.' / Gracias  / ';
        $_rsl_snd = $aws->_sms_snd();
        
        if($_rsl_snd->e == 'ok'){
            $r['e'] = 'ok';    
        }

	}else{

		$r['w'] = 'No detail';

	}
    
         
?>