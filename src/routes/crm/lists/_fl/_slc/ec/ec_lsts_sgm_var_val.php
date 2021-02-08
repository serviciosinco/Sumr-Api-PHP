<?php 	
	
	if($__t_s_e != 'undefined'){ $_v_df = $__t_s_e; }else{ $_v_df = ''; }
		
	if($__t_s_i == 2){
		
		echo SlDt([ 'id'=>'eclstssgmvar_vl', 'va'=>$_v_df, 'rq'=>'no', 't'=>$_v_df, 'cls'=>CLS_CLND ]);
		
	}elseif($__t_s_i == 3){
		
		$__vardt = GtSisEcSgmVarDt(['id'=>$__t_s_p]);

		if(!isN($__vardt->ls)){
			
			
			if($__vardt->ls->l == 'LsCntEst'){
						
				echo LsCntEst([ 'id'=>'eclstssgmvar_vl', 'v'=>'id_siscntest', 'va'=>$___Ls->dt->rw['mdlcnt_est'], 'v_go'=>'enc', 'rq'=>1, 'mdl'=>$___Ls->dt->rw['mdlcnt_mdl'], 'mdlstp'=>$___Ls->mdlstp->id ]);		        	   	
				$__lbl = ['eclstssgmvar_vl',FM_LS_EST, '', '_slcClr', ['ac'=>'no']];
				
			}
			
			
			/*
			echo $__vardt->ls->l;
			echo $__vardt->ls->l;
			echo $__vardt->ls->d;
			
			echo $myf('eclstssgmvar_vl',$__vardt->ls->v, $_v_df, '', 1, '', [ 'tp'=>$___Ls->mdlstp->tp ]);
			
			*/
			
	        $CntWb .= JQ_Ls($__lbl);  
	        
		}
				
		
	}elseif($__t_s_i == 4){
		
		echo OLD_HTML_chck('eclstssgmvar_vl', '', $_v_df );
		
	}elseif($__t_s_i == 5 || $__t_s_i == 7 || $__t_s_i == 9){
		
		if($__t_s_i == 5){ $__rd_vl = FMRQD_NM; }else{ $__rd_vl = FMRQD; }
		echo HTML_inp_tx('eclstssgmvar_vl', '', $_v_df, '', $__rd_vl); 
		
	}elseif($__t_s_i == 6){

		
	}

	
?>	