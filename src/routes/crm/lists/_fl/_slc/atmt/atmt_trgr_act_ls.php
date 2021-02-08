<?php 
	
	
	//--------- Post Data ----------//
	
	@ini_set('display_errors', true); 
	error_reporting(E_ALL & ~E_NOTICE);
	
	
	//--------- Detail of Trigger ----------//
	
		$__act = __LsDt(['k'=>'sis_atmt_act', 'id'=>$__t_s_i, 'tp'=>'enc', 'no_lmt'=>'ok' ]);
	
	//--------- Show List ----------//
	
	
	
	if(!isN($__act->d->ls)){
		
		$myf = $__act->d->ls->vl;
		
		if($__act->d->ls->vl == 'LsCntEst'){
			
			echo LsCntEst([ 
							'id'=>'atmttrgract_v_ls', 
							'v'=>'id_siscntest', 
							'va'=>$__i, 
							'rq'=>1
						]);		        	   	

			$CntWb .= JQ_Ls('atmttrgract_v_ls', FM_LS_EST, '', '_slcClr', ['ac'=>'no']);
   	
		}elseif($__act->d->ls->vl == 'LsCntEstTp'){
						
			echo LsCntEstTp('atmttrgract_v_ls', 'siscntesttp_enc', $__i, TX_SLCETP);

			$CntWb .= JQ_Ls('atmttrgract_v_ls', TX_SLCETP, '', '_slcClr');
   	
		}elseif($__act->d->ls->vl == 'LsEc'){
			
			echo LsEc('atmttrgract_v_ls', 'id_ec', $__i); 
	        $CntWb .= JQ_Ls('ecsnd_ec',FM_LS_TRSTP);        	   	
			$CntWb .= JQ_Ls('atmttrgract_v_ls', FM_LS_TRSTP );
   	
		}elseif($__act->d->ls->vl == 'LsCld'){
			
			$__sis_cld = LsSis_Cld([ 'id'=>'atmttrgract_v_ls', 'v'=>'id', 'va'=>$__i ]); 
			echo $__sis_cld->html;
			$CntWb .= $__sis_cld->js;
   	
		}elseif(!isN($myf) && function_exists($myf)){
			
			echo $myf('atmttrgract_v_ls',$___ls->v, $__i, '', 1);
			$CntWb .= JQ_Ls('atmttrgract_v_ls','');

		}
		
	}
	
	
	
	
?>	