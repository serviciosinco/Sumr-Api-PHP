<?php 
	
try {
	

	$__postcmn = _NwFb_Acc_Post([
		't'=>'cmn',
		'id'=>$___datprcs_v['sclaccpost_id'],
		'access_token'=>$_tkn_v->vl, 
		'lmt'=>$_lmt 
	]);
	
	$__totpostcmn = count($__postcmn);
	
	if(isN( $__postcmn->w )){ $__tkn_scss = 'ok'; }else{ $__tkn_scss = 'no'; }

	if($__totpostcmn > 0){

		foreach($__postcmn->data as $postcmn_k=>$postcmn_v){

			$__SclBd = new CRM_Thrd();
			$__SclBd->__t = 'acc_post_cmn';	
			$__SclBd->scl_rds = $___datprcs_v['scl_rds'];
			$__SclBd->postcmn_id = $postcmn_v->id;
			$__SclBd->postcmn_post = $__id_accpost;
			$__SclBd->postcmn_created_time = $postcmn_v->created_time->date;
			$__SclBd->postcmn_attach = json_encode($postcmn_v->attachment);
			$__SclBd->postcmn_message = $postcmn_v->message;
			$__SclBd->postcmn_message_tags = json_encode($postcmn_v->message_tags);
			$__SclBd->postcmn_from = $postcmn_v->from->id;
			$__SclBd->postcmn_from_o = json_encode($postcmn_v->from);
			$__Prc = $__SclBd->In();


			$___postcmnin .= $this->li(print_r($__Prc, true).' -> './*print_r($postcmn_v, true).*/' <br> TOT:'.$__totpostcmn.' Id_Post:'.$___datprcs_v['sclaccpost_id'].' -> '.$___datprcs_v['id_sclaccpost'].
				' -> TotR:'.$___datprcs_v['_tot'].' -> TotW:'.$___datprcs_v['sclaccpost_c_comments']);
				
		}
		
	}	


} catch (Exception $e) {
    
	$this->Rqu([ 't'=>'fb_post_cmn' ]);
    echo $e->getMessage();
    
}

	
?>