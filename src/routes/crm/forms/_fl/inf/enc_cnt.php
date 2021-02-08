<?php if(class_exists('CRM_Cnx')){

	
	// Mes Inicial
	$f1 = Php_Ls_Cln($_GET['_f_in']); 
	$f2 = Php_Ls_Cln($_GET['_f_out']);
	$enc = Php_Ls_Cln($_GET['_enc']);
	// Todos los datos del año actual
	$_now_f1 = date('Y-m-d', strtotime($f1));
	$_now_f2 = date('Y-m-d', strtotime($f2));
	
	if($enc != '' && $enc != 'undefined'){ 
		$__fl_p .= ' AND encfld_enc = "'.$enc.'" '; 
		$__fl_r .= ' AND enccnt_enc = "'.$enc.'" '; 
	}
	
	if($_now_f1 != '' && $_now_f2 != ''){ 
		$__fl_f_p .= " AND (enccnt_fi BETWEEN '".$_now_f1."' AND '".$_now_f2."') "; 
		$__fl_f_r .= " AND (enccnt_fi BETWEEN '".$_now_f1."' AND '".$_now_f2."') "; 
	}elseif($_now_f1 != '' && $_now_f2 != ''){ 
		$__fl_f_p .= " AND enccnt_fi = '".$_now_f1."' "; 
		$__fl_f_r .= " AND enccnt_fi = '".$_now_f1."' "; 
	}


	//-------------------- Preguntas --------------------//
	
		
		$Ls_Qs_Qry = sprintf(" SELECT *,
							   (SELECT
									GROUP_CONCAT( 
										 
										JSON_OBJECT(	
											'id', IF(id_fldlst IS NULL, '', id_fldlst),
											'tt', IF(fldlst_tt IS NULL, '', fldlst_tt),
											'ftt', IF(fld_tt IS NULL, '', fld_tt)
										)
							  
									SEPARATOR ',')
							   FROM sis_fld_lst, sis_fld 
							   WHERE fldlst_fld = id_fld AND
							   		 fldlst_fld = encfld_fld
							) AS ___fld
				   	   FROM ".TB_ENC_FLD.", sis_fld AS __t
				   	   WHERE encfld_fld = __t.id_fld AND
				   	   		 __t.fld_tp != 8
				   	   		 $__fl_p 
				   	"); 
				   			   
		$Ls_Qs = $__cnx->_qry($Ls_Qs_Qry); 
		$row_Ls_Qs = $Ls_Qs->fetch_assoc(); $Tot_Ls_Qs = $Ls_Qs->num_rows;
			
			do{
				
				if($row_Ls_Qs['___fld'] != ''){
					
					$___fld = (object)json_decode($row_Ls_Qs['___fld']); 
					
					foreach($___fld as $_k => $_v){
						//echo h2('Field:'.$row_Ls_Qs['id_fld']);
						
						$___op_rpta [ $row_Ls_Qs['id_fld'] ] ['id'] = $row_Ls_Qs['id_fld'];
						$___op_rpta [ $row_Ls_Qs['id_fld'] ] ['tt'] = ctjTx($_v->ftt,'in');
						$___op_rpta [ $row_Ls_Qs['id_fld'] ] ['op'][ $_v->id ] ['id'] = $_v->id;
						$___op_rpta [ $row_Ls_Qs['id_fld'] ] ['op'][ $_v->id ] ['tt'] = ctjTx($_v->tt,'in');
					}
					
				}else{
					
					//echo h2('Field:'.$row_Ls_Qs['id_fld']);
					
					$___op_rpta [ $row_Ls_Qs['id_fld'] ] ['id'] = $row_Ls_Qs['id_fld'];
					$___op_rpta [ $row_Ls_Qs['id_fld'] ] ['tt'] = ctjTx($row_Ls_Qs['sisfld_tt'],'in');
					
				}
													 
			}while( $row_Ls_Qs = $Ls_Qs->fetch_assoc() );
		
		
			
	//-------------------- Preguntas --------------------//	
	
	
	//-------------------- Respuestas --------------------//	
		
		$Ls_Rs_Qry = "SELECT *,
							
							IF( id_fldtp IN (5,6,7), 
								
								(	SELECT CONCAT('{\"id\":\"', id_fldlst,'\",',
													'\"tt\":\"', fldlst_tt,'\"}'
												  ) 
									FROM sis_fld_lst							 
									WHERE id_fldlst = encdts_dts 	   
								),
								
								''
							) AS __o
							  
				   	  FROM ".TB_ENC_CNT_DTS.", ".TB_ENC_CNT.", sis_fld, ".DBM."._sis_fld_tp, ".DBM."._sis_qly
				      WHERE encdts_enccnt = id_enccnt AND 
				      		encdts_fld = id_fld AND
							fld_tp = id_fldtp AND
							encdts_qly = id_qly
				   		 	$__fl_r $__fl_f_r"; 
		$Ls_Rs = $__cnx->_qry($Ls_Rs_Qry); 
		$row_Ls_Rs = $Ls_Rs->fetch_assoc(); $Tot_Ls_Rs = $Ls_Rs->num_rows;
			
			//echo h2( 'Tot Results:'.$Tot_Ls_Rs );
			
			do{
					
					
					$__field = $row_Ls_Rs['encdts_fld'];
					$__qlity = $row_Ls_Rs['encdts_qly'];
					
					
					if($row_Ls_Rs['__o'] != ''){ 
						
						$__cls = '_ok'; 
						$__option = (object)json_decode($row_Ls_Rs['__o']);
						$___rp_rpta[ $__field ][ $__option->id ] ++ ;
						$___op_rpta [ $__field ] ['all']++;
						$___op_rpta [ $__field ] ['op'] [ $__option->id ] ['tot'] ++;
														 
							
					}else{ 
						
						$__cls = '_no'; //echo $__qlity.HTML_BR;

						$___op_rpta [ $__field ] ['qly'] [ $__qlity ] ['tt'] = ctjTx($row_Ls_Rs['qly_tt'],'in');
						$___op_rpta [ $__field ] ['qly'] [ $__qlity ] ['clr'] = ctjTx($row_Ls_Rs['qly_clr'],'in');
						$___op_rpta [ $__field ] ['qly'] [ $__qlity ] ['img'] = DMN_IMG_ESTR.$row_Ls_Rs['qly_img'];
						$___op_rpta [ $__field ] ['qly'] [ $__qlity ] ['tot'] ++;
						$___op_rpta [ $__field ] ['cmn'] [ ] = [ 
																'tx'=>ctjTx($row_Ls_Rs['encdts_dts'],'in'),
																'icn'=>'_est_'.$__qlity,
																'img'=>DMN_IMG_ESTR.$row_Ls_Rs['qly_img']
															 	];
						$___op_rpta [ $__field ] ['all']++;
						
					} 
					
					
					/*Comentareados*/
					/*echo '<div class="'.$__cls.'">';
					
					echo ' ->Encuesta:'.$row_Ls_Rs['enccnt_enc'] .HTML_BR.
						 ' ->Value:'.$row_Ls_Rs['encdts_dts'] .HTML_BR.
						 ' ->Option: '. $row_Ls_Rs['__o'] .HTML_BR.
						 ' ->Field:'.$row_Ls_Rs['encdts_fld'];
					
					echo '</div>';*/
					
					
														 
			}while( $row_Ls_Rs = $Ls_Rs->fetch_assoc() );
			
			
			$___rp_o = _jEnc($___rp_rpta);
			$___op_o = _jEnc($___op_rpta);
			

			$__pq = 1;
			
			foreach($___op_o as $_k => $_v){

				$__ctg = '';
				$__ctg_2 = '';
				$___div_cmnt = '';
				
				if ($__pq%2==0){
				    $__c1 = 2;
				    $__c2 = 1; 
				}else{
				    $__c1 = 1;
				    $__c2 = 2;
				}
				
				foreach($_v->op as $_k2 => $_v2){
					
					$___t_n = ($_v2->tot!=NULL?$_v2->tot:'0');
					$___t_r[$__pq] .= '<tr><td>'.$_v2->tt.'</td><td>'.$___t_n.'</td></tr>';

					$__ctg[$_v2->tt] = "
						{
			            	name: '".$_v2->tt."',
							data: [".$___t_n."]
						}
					"; 
					
					$__tot_grph = ($___t_n * 100) / $_v->all;
					$__ctg_2[$_v2->tt] = "{name: '".$_v2->tt."', y: "._Nmb( $__tot_grph , 5)." }";
				}

				foreach($_v->qly as $_k3 => $_v3){
					
					$___t_n = ($_v3->tot!=NULL?$_v3->tot:'0');
					$___t_q[$__pq] .= '<tr><td>'.Spn('<img src="'.$_v3->img.'">','','cmn_icn '.$_v3->icn).$_v3->tt.'</td><td>'.$___t_n.'</td></tr>';
					
					
					$__ctg[$_v3->tt] = "
						{
			            	name: '".$_v3->tt."',
							data: [".$___t_n."]
						}
					";
					
					$__tot_grph = ($___t_n * 100) / $_v->all;
					$__ctg_2[$_v3->tt] = "{name: '".$_v3->tt."', y: "._Nmb( $__tot_grph , 5).", color:'".$_v3->clr."' }";
 
				}
				
				
				foreach($_v->cmn as $_k4 => $_v4){
					if($_v4->tx != NULL){
						$___t_cmn[$__pq] .= '<tr><td>'.Spn('<img src="'.$_v4->img.'">','','cmn_icn '.$_v4->icn).$_v4->tx.'</td></tr>';
					}
				}
				
				if($___t_r[$__pq] != NULL){
					$___div[$__pq] .= bdiv( ['c'=>h2($_v->tt).'<table class="Ls_Rg">'.$___t_r[$__pq].'</table>', 'cls'=>'d_data _c1'] );	
				}
				if($___t_q[$__pq] != NULL){
					$___div[$__pq] .= bdiv( ['c'=>h2($_v->tt).'<table class="Ls_Rg">'.$___t_q[$__pq].'</table>', 
															  'cls'=>'d_data _c'.$__c1,
															 ] 
													  );
					$___div_cmnt .= bdiv( ['c'=>h3(TX_CMTN).'<table class="Ls_Rg _Sb">'.$___t_cmn[$__pq].'</table>', 'cls'=>'d_comments'] );							  
				}
				
				$___div[$__pq] .= bdiv( ['id'=>'_____pq'.$__pq, 'cls'=>'_grph _c'.$__c2] );
				$___div[$__pq] .= $___div_cmnt;
				
				if($_v->qly == NULL){
						$CntWb .= "
								
							SUMR_Grph.f.g1({ 
								id: '#_____pq{$__pq}', 
								d:[".implode(',', $__ctg)."],
								tt: '', 
								tt_sb: '',
								c: [],
								c_e: false, 
								lgnd_alg: 'left',
								lgnd_vrt: 'middle',
								lgnd_flt: false
							});
						";
						
				}else{	
						
						$CntWb .= "
							SUMR_Grph.f.g2({ 
								id: '#_____pq{$__pq}',
								tt: '',
								d: [".implode(',', $__ctg_2)."]
							});
						";
				}

				
				echo bdiv( ['c'=>$___div[$__pq], 'cls'=>'enc_blck'] );
				$__pq++;
			}
			
	//-------------------- Respuestas --------------------//
	
	
	$Ls_Qs->free; $Ls_Rs->free;  
	
}

?>