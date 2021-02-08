<?php 
	
try {

	$__postrct = _NwFb_Acc_Post([
		't'=>'rct',
		'id'=>$___datprcs_v['sclaccpost_id'],
		'access_token'=>$_tkn_v->vl, 
		'lmt'=>$_lmt 
	]);
	
	$__totpostrct = count($__postrct);

	if(isN( $__postrct->w )){ $__tkn_scss = 'ok'; }else{ $__tkn_scss = 'no'; }
	
	if($__totpostrct > 0){

		foreach($__postrct->data as $postrct_k=>$postrct_v){

			$__SclBd = new CRM_Thrd();
			$__SclBd->__t = 'acc_post_rct';	
			$__SclBd->scl_rds = $___datprcs_v['scl_rds'];
			$__SclBd->postrct_post = $__id_accrct;
			$__SclBd->postrct_from = $postrct_v->id;
			$__SclBd->postrct_from_o = json_encode(['id'=>$postrct_v->id, 'name'=>$postrct_v->name]);
			$__SclBd->postrct_type = $postrct_v->type;
			$__SclBd->postrct_created = $postrct_v->created_time;

			$__Prc = $__SclBd->In();		

			$___postrctin .= $this->li( 
				h1(
				'Process:'.print_r($__Prc, true).'<br>'. 
				'Account:'.$__id_acc.'<br>'. 
				'Date Check:'.$___datprcs_v['sclaccpost_f_chk'].'<br>'.
				'Date Wait:'.$___datprcs_v['__datewait'].'<br>'.
				'Last Now:'.$___datprcs_v['__datenow'].'<br>'.
				'-> FanPage:'. $___datprcs_v['sclacc_id'].'<br>'.
				'-> Reactions:'. $__totpostrct. '<br>'.
				'-> Reactions Item:'.$___datprcs_v['sclaccpost_c_reacts'].'<br>'
				) 
			);						

				
		}

	}	


} catch (Exception $e) {
    
	$this->Rqu([ 't'=>'fb_post_rct' ]);
    echo $e->getMessage();
    
}

	
?>