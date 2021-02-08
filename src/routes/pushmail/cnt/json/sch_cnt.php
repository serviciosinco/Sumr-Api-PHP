<?php
	
	//---------------- SETUP - START ----------------//
	
		
		$__p_sch = Php_Ls_Cln($_POST['sch']); 
		$__p_cl = Php_Ls_Cln($_POST['cl']); 
		$__p_dvf_cod = Php_Ls_Cln($_POST['dvrf_cod']); 
		$__p_cref_cod = Php_Ls_Cln($_POST['cref_cod']);
		
		
	//---------------- SETUP - END ----------------//
		
		
		
		if(!isN($__p_sch)){
			
			$__cl = __Cl([ 'id'=>$__p_cl, 't'=>'enc' ]);
			$__cnt = new CRM_Cnt([ 'cl'=>$__cl->id ]);
			$__cnt->cnt_dc = filter_var($__p_sch, FILTER_SANITIZE_STRING);
			$__gcnt = $__cnt->_Cnt();
			
			$__dvrf = new CRM_Dvrf([ 'cl'=>$__cl->id ]);	
			
			if(!isN($__gcnt->i)){
			
				$__gcnt_dt = GtCntDt([ 'bd'=>$__cl->bd.'.', 'id'=>$__gcnt->enc, 't'=>'enc' ]);
				$__dvrf_dt = GtCntDvrfDt([ 't'=>'cod', 'id'=>$__p_dvf_cod, 'cnt'=>$__gcnt_dt->id, 'bd'=>$__cl->bd ]); 
				$__dvrf_hb = 'ok';
				
				
				if($__dvrf_dt->hb != 'ok' && !isN($__dvrf_dt->id)){ $__dvrf_w = 'code_exprd'; }
				if(isN($__dvrf_dt->id)){ $__dvrf_w = 'code_noexst'; }
				if(isN($__gcnt_dt->id)){ $__dvrf_w = 'cnt_noexst'; }
				if(!isN($__dvrf_dt->cnt) && !isN($__dvrf_dt->id) && $__dvrf_dt->cnt != $__gcnt_dt->id){ $__dvrf_w = 'cnt_cod_nopair'; }
				
					
				if(isN($__dvrf_w)){
					
					$rsp['e'] = 'ok';
					
					
					$rsp['dvrf'] = [
						'enc'=>$__dvrf_dt->enc
					];	
					
					
					$rsp['cref'] = $__p_cref_cod;
					
					
					$rsp['cnt'] = [
						'enc'=>$__gcnt_dt->enc,
						'nm'=>$__gcnt_dt->nm,
						'ap'=>$__gcnt_dt->ap,
						'sndi'=>$__gcnt_dt->sndi
					];	
					
					$__dvrf->UpdCod([ 'hb'=>2, 'id'=>$__dvrf_dt->id ]); 
				
				}else{
					
					$rsp['e'] = $__dvrf_w;
					
				}
				
			}
			
		}else{
			
			$rsp['e'] = 'no_data';	
			
		}
	
	
	//-------------- PRINT RESULTS --------------//

		
?>