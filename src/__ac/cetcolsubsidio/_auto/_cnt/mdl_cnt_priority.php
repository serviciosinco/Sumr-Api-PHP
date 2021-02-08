<?php 

	global $__cnx;
	
	$__CntChk = new CRM_Cnt_Up();
	$__CntIn = new CRM_Cnt([ 'cl'=>$__cl_v->id ]); 
				
				
	echo 'Run Priority';
	
	
	//-------------- LEADS TO SEND --------------//
		
			
				
		$SbQry = "	SELECT id_mdlcnt, mdlcnt_mdl, cnt_enc,						   
						   
						   (
							   
							   SELECT COUNT(*)
							   FROM ".$__cl_v->bd.".".TB_CNT_TEL."
							   WHERE cnttel_cnt = mdlcnt_cnt AND cnttel_tp = 3
							   
						   ) AS __tot_cel,
						   
						   
						   (
							   SELECT COUNT(*)
							   FROM ".$__cl_v->bd.".".TB_CNT_EML."
							   WHERE cnteml_cnt = mdlcnt_cnt
							   
						   ) AS __tot_eml,
						   
						   
						   (
							   SELECT COUNT(*)
							   FROM ".$__cl_v->bd.".".TB_MDL_PRD."  
							   		INNER JOIN "._BdStr(DBM).TB_MDL_S_PRD." ON mdlprd_prd = id_mdlsprd
							   WHERE mdlprd_mdl = mdlcnt_mdl AND mdlprd_est = 1
							   
						   ) AS __tot_prd_on
						   
						   
						   
						   
					FROM ".$__cl_v->bd.".".TB_MDL_CNT."
						 INNER JOIN ".$__cl_v->bd.".".TB_CNT." ON mdlcnt_cnt = id_cnt
					WHERE id_mdlcnt != '' AND 
						  
						  id_mdlcnt NOT IN (
							  SELECT mdlcntattr_mdlcnt
							  FROM ".$__cl_v->bd.".".TB_MDL_CNT_ATTR."
							  WHERE mdlcntattr_attr = '690'
						  )
					
					ORDER BY id_mdlcnt DESC
					
					/*ORDER BY RAND()	*/	
					LIMIT 50";

		$CetPrity = $__cnx->_qry($SbQry);
		
		if($CetPrity){
			
			$row_CetPrity = $CetPrity->fetch_assoc();
			$Tot_CetPrity = $CetPrity->num_rows; echo $Tot_CetPrity;
			
			do{
				
				$__dtmdlcnt = GtMdlCntDt([ 'id'=>$row_CetPrity['id_mdlcnt'], 'bd'=>$__cl_v->bd ]);
				
				$__mdlcnt_score = 5;
				
				if($row_CetPrity['__tot_cel'] > 0){ $__mdlcnt_score--; }
				if($row_CetPrity['__tot_eml'] > 0){ $__mdlcnt_score--; }
				if(!isN($row_CetPrity['mdlcnt_mdl'] != 43)){ $__mdlcnt_score--; }
				if($row_CetPrity['__tot_eml'] > 0){ $__mdlcnt_score--; }
				
				
				
				foreach($__dtmdlcnt->attr as $_attr_k=>$_attr_v){
		
					if($_attr_v->key == 'dwn_brch'){	
						if(strtolower($_attr_v->vl) == 'ok'){ 
							echo h2('dwn_brch:'.strtolower($_attr_v->vl));
							$__mdlcnt_score--; 
						}
					}
					
				}	
				
				
				echo h1('Score:'.$__mdlcnt_score);
				
				$__CntChk->mdl_id = $row_CetPrity['mdlcnt_mdl']; 
				$__CntChk->ext->mdl_cnt = ['becall_prity'=>$__mdlcnt_score];
				$__CntChk->Run();
				
				$__CntIn->gt_mdl_id = $row_CetPrity['mdlcnt_mdl'];
				$__CntIn->cnt_id = $row_CetPrity['cnt_enc']; 
				$__CntIn->test_tmp = 'ok';
				$__CntIn->ext_all = $__CntChk->ext_out;
				$__CntIn->invk->by = _CId('ID_SISINVK_AUTO');
				
				$PrcDt = $__CntIn->MdlCnt(); 
							
				//echo print_r($__dtmdlcnt->attr, true).'</br>';
				
				//$__Wbhk->();
				
			}while($row_CetPrity = $CetPrity->fetch_assoc()); 	
		
		}else{
			
			echo $__cnx->c_r->error;
			
		}

		$__cnx->_clsr($CetPrity);
		

	//-------------- LEADS TO SEND --------------//
					
					
?>