<?php 

	//------------------* SETUP - START ------------------//

		$_t = Php_Ls_Cln($_POST['t']);
		$_cmpg = Php_Ls_Cln($_POST['cmpg']);
		$_ins = Php_Ls_Cln($_POST['ins']);

		if(!isN($_cmpg)){
			$__cmpg_dt = GtVtexCmpgDt([ 'tp'=>'enc', 'id'=>$_cmpg ]);
		}

		if($_t == 'data'){

			$_ins_in = GtVtexCmpgInsRfdLs([ 'ins'=>$__cnt->id, 'cmpg'=>$_cmpg, 'cl'=>$__cl ]);

			if($_ins_in->e == 'ok'){
				$_r['e'] = 'ok';
				$_r['rfd'] = $_ins_in;
			}else{
				$__ins_dt = GtVtexCmpgInsDt([ 't'=>'enc', 'id'=>$_ins ]);
				$_r['ins']['coup'] = $__ins_dt->coup->v;
				$_r['r'] = $_ins_in;
			}

		}else if($_t == 'check'){

			$__CntInIns = new CRM_Cnt([ 'cl'=>$__cl ]);
			$__CntInIns->_vtex->acc = $__cmpg_dt->acc->id;

			$_rfrd = 'ok';

			$_c = Php_Ls_Cln($_POST['c']);

			if(!isN( $_c )){

				$__tot_rdm = count($_c);
				$_r['tckt'] = $__tckt_nme = ($__cmpg_dt->vlr->cod*$__tot_rdm).'K'; 

				$__gcoup = $__CntInIns->_vtex->coup_new([ 
					'srce'=>$__tckt_nme,
					'cmpg'=>$__cmpg_dt->id,
					'sumr'=>1
				]);

				if(!isN($__gcoup->id)){

					foreach($_c as $k=>$v){

						$prc = 	$__CntInIns->_vtex->InsRfd_Upd([ 
									'id'=>$v, 
									'tp'=>'enc',
									'f'=>[
										'vtexcmpginsrfd_ins_coup'=>$__gcoup->id,
										'vtexcmpginsrfd_chk_rdm'=>1
									]
								]);

						//$_r['rfd'][] = $prc; 
						if($prc->e != 'ok'){ $_rfrd = 'no'; }
					}

					if($_rfrd != 'no'){

						foreach ($__cnt->eml->ls as $key => $value) {

							$upd = $__CntInIns->_vtex->mdata_cnt_upd([
								'eml'=>$value,
								'f'=>[
									'FidelizacionN'=>$__tckt_nme
								]
							]);

							$_r['tmp_upd']['eml'] = $value;
							$_r['tmp_upd']['res'] = $upd;

						}

					}

				}

			}

			if($_rfrd != 'no'){
				
				$_ins_in = GtVtexCmpgInsRfdLs([ 'ins'=>$__cnt->id, 'cmpg'=>$_cmpg, 'cl'=>$_cl ]);

				if($_ins_in->e == 'ok'){ 
					$_r['e'] = 'ok';
					$_r['rfd'] = $_ins_in;
				}

			}

		}else if($_t == 'list'){

			$_ins_in = GtVtexCmpgInsLs([ 'rfd'=>$__cnt->id, 'cl'=>$__cl->id ]);

			if($_ins_in->e =='ok'){	
				$_r['e'] = 'ok';
				$_r['cmpg'] = $_ins_in;	
			}
			
		}else if($_t == 'logout'){

			$__vtex = new CRM_VTex();
			$__vtex->front_lgout();
			$_r['e'] = 'ok';
			
		}

        

	//------------------* PRINT RESULTS ------------------//
		
?>