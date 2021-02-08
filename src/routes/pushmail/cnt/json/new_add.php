<?php
	
	//---------------- SETUP - START ----------------//
		
		$__p_tp = Php_Ls_Cln($_POST['tp']); 
		$__p_cl = Php_Ls_Cln($_POST['cl']); 
		
	//---------------- SETUP - END ----------------//
		
		
		$__cl_plcy = GtPlcyLs([ 'cl'=>$__p_cl ]);
		
		if(!isN($__cl_plcy) && $__cl_plcy->e == 'ok' && $__cl_plcy->tot > 0){
			foreach($__cl_plcy->ls as $plcy_k=>$plcy_v){
				$__plcy_html .= '<div class="_plcy_lnk" id="_plcy_lnk'.$plcy_v->enc.'">					
									'._HTML_Input('Plcy_Chck'.$plcy_v->enc, '<a href="'.$plcy_v->lnk->url.'" target="_blank">'.$plcy_v->lnk->tt.Spn('('.$plcy_v->nm.')','','_nm').'</a>','','_chk','checkbox',[ 'n'=>'plcy[]', 'attr'=>[ 'data-plcy-id'=>$plcy_v->enc ] ]).'	
								</div> '; 	
			}				
		}	
				
		if($__p_tp == 'tel'){ 
	
			
			$rsp['html'] = '
						<div class="bx_ln s1">
							<div class="c1">
								'.LsSis_PsOLD('cnttel_ps','id_sisps', 57, '-', 2, '', '', 'iso').'	
							</div>
							<div class="c2">
								<input placeholder="Teléfono" type="text" id="cnt_tel" name="cnt_tel" class="'.FMRQD_NM.'" >
							</div>
						</div>
						<div class="_plcy_ls">'.$__plcy_html.'</div>
					';	
			
			$rsp['js'] = JQ_Ls('cnttel_ps', '-', '', 'psFlg', ['ac'=>'no']);		
			
		}elseif($__p_tp == 'eml'){ 
			
			$rsp['html'] = '<input placeholder="Email" type="text" id="cnt_eml" name="cnt_eml" class="'.FMRQD_EM.'" ><div class="_plcy_ls">'.$__plcy_html.'</div>';
			
		}elseif($__p_tp == 'emp'){ 
			
			$rsp['html'] = '<div class="__sch_json">
								<div class="_c1">
									<div class="_sl"><select id="cnt_org" name="cnt_org" class="required"></select></div>
								</div>
								<div class="_c2">
									<input placeholder="Cargo" type="text" id="cnt_org_crg" name="cnt_org_crg">
								</div>
						    </div> ';
			
		}elseif($__p_tp == 'uni' || $__p_tp == 'clg'){ 
			
			$rsp['html'] = '<div class="__sch_json">
								<div class="_sl"><select id="cnt_org" name="cnt_org" class="required"></select></div>
						    </div> ';
			
		}
	
		
		if(!isN($rsp['html'])){
			$rsp['e'] = 'ok';
		}

		
?>