<?php 
	
	class CRM_Ls extends CRM_Main{
	         
	    function __construct() {
		    
		    global $__cnx;
		    
		    ini_set('max_execution_time', 30);
		     
		    parent::__construct();
				
	    }
	
		function __destruct() {
			
		    parent::__destruct();
	    	
	   	}
	   	
		public function _c_cnx($p=NULL){
			
			global $__cnx;
			
			if($p['t'] == 'cl'){	
				$__cnx->_bdbr([ 'd'=>'cl' ]);
	        }elseif($p['t'] == 'prc'){	
				$__cnx->_bdbr([ 'd'=>'prc' ]);
	        }elseif($p['t'] == 'aut'){	
				$__cnx->_bdbr([ 'd'=>'aut' ]);
	        }else{
				$__cnx->_bdbr([ 'd'=>'main', 'src'=>'_c_cnx' ]);
	        }
	        
		}
		
		
		public function _chkpml(){		
			
			//------------ PERMISSIONS CHECKER ------------//
			
			if(strpos($this->tp, 'mdl_cnt') !== false && !isN($this->gt->tsb)){ $this->tpsb = str_replace('mdl_cnt', $this->gt->tsb.'_cnt', $this->tp); }
				
			if(ChckSESS_adm()){ $this->hb->all='ok'; } 
			if(_ChckMd($this->tp.'_eli') || _ChckMd($this->tpg.'_eli') || _ChckMd($this->tpsb.'_eli') || $p['eli']){ $this->hb->eli='ok'; }
			if(_ChckMd($this->tp.'_ing') || _ChckMd($this->tpg.'_ing') || _ChckMd($this->tpsb.'_ing') || $p['ing']){ $this->hb->ing='ok'; }
			if(_ChckMd($this->tp.'_mod') || _ChckMd($this->tpg.'_mod') || _ChckMd($this->tpsb.'_mod') || $p['mod']){ $this->hb->mod='ok'; }
			if(_ChckMd($this->tp.'_upl') || _ChckMd($this->tpg.'_upl') || _ChckMd($this->tpsb.'_upl') || $p['upl']){ $this->hb->upl='ok'; }
			if(_ChckMd($this->tp.'_dwn') || _ChckMd($this->tpg.'_dwn') || _ChckMd($this->tpsb.'_dwn') || $p['dwn']){ $this->hb->dwn='ok'; }
			
			if(defined('SISUS_ID') && SISUS_ID == 163){ 
				echo 'Permiso: '.$this->tp.'-Permiso: '.$this->tpg.'-Permiso: '.$this->tpsb;
			}

		}
		
		
		public function _p_sch($p=NULL){
			$_v=_GPJ(['v'=>'sch']);
			return $_v;
		}
		
		public function _p_fl($p=NULL){
			$_v=_GPJ(['v'=>'fl']);
			return _jEnc($_v['f']);
		}
		
		public function _f_gt(){
			if(!isN( $this->_p_fl() )){
				$g = json_encode( $this->_p_fl() );
			}else{
				$g = '';
			}
			return($g);
		}
		
		public function _s_gt(){
			if(!isN( $this->_p_sch() )){
				$g = $this->_p_sch();
			}else{
				$g = '';
			}
			return($g);
		}
		
		
		function _btn_fnc($p){
			if(!isN($p['i']) && !isN($p['f'])){
				$_js = "$('#".$p['i']."').off('click').click(function(e){ e.preventDefault(); ".$p['f']." });";
				return($_js);
			}
		}
		
		
		public function _btn($p=NULL){
			
			if(!isN($p['ttc'])){$_ttc=$p['ttc'];}

			if($p['t']=='in'){

				if(!isN($p['id'])){$_id=$p['id'];}else{$_id=$this->ls->btn->ing;} 
				$html = '<div class="___in '.$_ttc.'"><button name="'.$_id.'" id="'.$_id.'">'.Spn(BTN_TX_NW,'','_anm').'</button></div>';
				
			}elseif($p['t']=='upl'){
				
				if(!isN($p['tt'])){$_tt=$p['tt'];}else{$_tt=TX_UPLMSV;}
				if(!isN($p['id'])){$_id=$p['id'];}
				
				$html = '<div class="___upmsv '.$_ttc.'"><button name="'.$_id.'" id="'.$_id.'">'.Spn($_tt,'','_anm').'</button></div>';	

			}elseif($p['t']=='upd'){
				
				$html = '<img src="'.BTN_UPD.'" height="20"/>';	

			}elseif($p['t']=='dwn'){
				
				$html = '<div class="___dwn"><button name="'.$this->ls->btn->dwn.'" id="'.$this->ls->btn->dwn.'">'.Spn(BTN_TX_XLS,'','_anm').'</button></div>' ;				
					
			}elseif($p['t']=='mod'){
				
				if($this->hb->mod == 'ok' || $p['shw'] == 'ok'){
		        	$html = HTML_Ls_Btn([ 'id'=>'btn_'.$this->tp.'_'.$p['id'], 't'=>'edt', 'js'=>'ok', 'cls'=>trim('btn_mod '.$_ttc), 'l'=>$this->_h_ls_edit([ 'up'=>$p['up'] ]) ]);
		        }
	        	
			}elseif($p['t']=='dtl'){

		        $html = HTML_Ls_Btn([ 't'=>'dtl', 'js'=>'ok', 'l'=>$this->_h_ls_detail() ]);
	        	
			}elseif($p['t']=='go'){

		        $html = HTML_Ls_Btn([ 't'=>'onl', 'js'=>'ok', 'l'=>$this->_h_ls_detail() ]);
	        	
			}elseif($p['t']=='upl_fle'){

		        $html = HTML_Ls_Btn([ 't'=>'up', 'js'=>'ok', 'l'=>$this->_h_ls_edit([ 'up_fle'=>'ok' ]) ]);
	        	
			}elseif($p['t']=='mycmz'){

		        $html = HTML_Ls_Btn([ 't'=>'dsgn', 'cls'=>'icn_fll', 'js'=>'ok', 'l'=>$this->_h_ls_edit([ 'tp'=>$p['tp'], 'ik'=>$p['ik'] ]), 'cll'=>$p['cll'] ]);
				
			}elseif($p['t']=='dsgn'){

		        $html = HTML_Ls_Btn([ 't'=>'dsgn', 'cls'=>'icn_fll', 'js'=>'ok', 'l'=>$this->_h_ls_form([ 'tp'=>$p['tp'], 'ik'=>$p['ik'] ]), 'cll'=>$p['cll'] ]);
				
			}
			
			return( $html ); 
		}
		
		
		public function _sql($p=NUll){
			
			if(!isN($this->sql)){
				
				if($p['t']=='dt'){
					
					$this->dt->rw = $this->sql->fetch_assoc(); 
					$this->dt->tot = $this->sql->num_rows;
					$this->uid = $this->dt->rw[$this->ik];
					$this->uidn = $this->dt->rw[$this->ino];	

				}elseif($p['t']=='ls'){
					
					$this->ls->rw = $this->sql->fetch_assoc(); 
					$this->ls->tot = $this->sql->num_rows;
					
					if(!isN($this->qrys_tot)){	
						$t_ls_rw = $this->sql_tot->fetch_assoc();
						$this->ls->tot_all = $t_ls_rw[QRY_RGTOT];	
					}else{
						$this->ls->tot_all = $this->ls->rw[QRY_RGTOT];	
					}
					
						
				}	
			
			}
		}
		
		
		
		public function _sch_ls($p=NULL){
			
			if($p['ld']){$_ldwb = $p['ld'];}else{$_ldwb = ICN_LDR_SIS;}
			if(!isN($p['__i'])){ $__i = _SbLs_ID(); }
			if($p['mre']){$_mrvr = $p['mre'].'&';}
			if($p['fl'] == 'ok'){ $SrchGrp = "&_g='+Us_Grp.value+'&_ng='+No_Grp.checked+'"; }
			
			if(isN($this->c_flt)){

				if($this->pnl()){ 
					$_pop='ok'; $_pnl_e='ok'; $_pnl_sw='ok'; $_pnl_ss='ok'; 
					$_pnl_js = ",
						pop:'".$_pop."',
						pnl:{
							e:'".$_pnl_e."',
							sw:'".$_pnl_sw."',
							ss:'".$_pnl_ss."',
							tp:'h'
						}
					";
				}

				$__sch_ls = "
					
					if(!isN( SUMR_Main.url['".$this->gt->plct."'] )){
						_ldCnt({ 
							u:SUMR_Main.url['".$this->gt->plct."'].lnk,
							c:SUMR_Main.url['".$this->gt->plct."'].box, 
							d:{
								fl:{ sch:_valinp }
							}
							{$_pnl_js}
						});
					}
					
				";
				 
				$__sch_cl = "

					if(!isN( SUMR_Main.url['".$this->gt->plct."'] )){
						_ldCnt({ 
							u:SUMR_Main.url['".$this->gt->plct."'].lnk+'&___fl_c=ok', 
							c:SUMR_Main.url['".$this->gt->plct."'].box,
							ucln:['pgN','totRws','Rd']
							{$_pnl_js}
						});
					}
				";

			}else{ 
				
				$__sch_ls = "SUMR_Main.pnlf.f.do({ sch:_valinp, bxf:'Fl_Bx_".$this->id_rnd."', plc:'".$this->gt->plct."', bxrld:'".$this->bx_rld."' });";
				$__sch_cl = "SUMR_Main.pnlf.f.do({ clr:'ok', sch:'', bxf:'Fl_Bx_".$this->id_rnd."', plc:'".$this->gt->plct."', bxrld:'".$this->bx_rld."' });";
				
			}
			
			$this->js .= "
			
				function Sch_Ls".$this->id_rnd."(){
					var _valinp = $('#".$p['inp'].$this->id_rnd."').val(); 
					if(!isN(_valinp)){ {$__sch_ls} }						
				} 
				
				function Sch_Cl".$this->id_rnd."(){
					{$__sch_cl}
				} 
				
				$('#".BTN_SCHCLN.$this->id_rnd."').off('click').click(function(e){ e.preventDefault(); Sch_Cl".$this->id_rnd."(); });
				$('#".BTN_SCH.$this->id_rnd."').off('click').click(function(e){ e.preventDefault(); Sch_Ls".$this->id_rnd."(); });";
			
				$Rtrn_vl .= '<div class="___sch">
									<button name="'.BTN_SCH.$this->id_rnd.'" id="'.BTN_SCH.$this->id_rnd.'">'./*BTN_TX_SCH.*/'</button>
							</div>' ;
			
			if(!isN($p['vl'])){
				$Rtrn_vl .= '<div class="___sch_cln">
									<button name="'.BTN_SCHCLN.$this->id_rnd.'" id="'.BTN_SCHCLN.$this->id_rnd.'">'./*BTN_TX_SCHCLN.*/'</button>
							 </div>';
			}
			
			return($Rtrn_vl);
		}



		public function _pgrg($p=NULL){
			
			if( !isN($p['u']) ){

				if($p['pop_cls']=='ok'){ $_clsclr = JS_SCR_POPCLS; }
				if($p['pop']=='ok'){ $_clsp = TXGN_POP; }
				
				if(!isN($p['c'])){ $__c = ", c:'".trim($p['c'])."' " ;  }
				if(!isN($p['w'])){ $__w = trim($p['w']); }else{ $__w = '90%'; }
				if(!isN($p['h'])){ $__h = trim($p['h']); }else{ $__h = '90%'; }
				if(!isN($p['scrl'])){ $__scrl = trim($p['scrl']); }else{ $__scrl = $p['scrl']; }
				if(!isN($p['cl'])){ $__cl = ', _cl:'.trim($p['cl']); }
				if(!isN($p['cm'])){ $__cm = ', _cm:'.trim($p['cm']); }
				if(!isN($p['cbx_grp'])){ $__cgrp = ", _rel:'".trim($p['cbx_grp'])."' "; }

				if(!isN($p['dt'])){ $__dt = "+'".ADM_LNK_DT."'+_rid"; }
				if(!isN($this->bx_rld)){ $p['mre'] .= TXGN_BX.$this->bx_rld; }
				if(!isN($this->gt->plct)){ $__plct = ", pf:'".$this->gt->plct."' "; } 
				
				/*if($this->pnl()){
					
					$_pop=$p['pop']='ok'; 
					$_pnl_e='ok'; 
					$_pnl_sw='ok'; 
					$_pnl_ss='ok'; 

					$__pnl = ",	pnl:{
									e:'".$_pnl_e."',
									sw:'".$_pnl_sw."',
									ss:'".$_pnl_ss."',
									tp:'h'
								}
					" ;
				
				}*/
				if(!isN($p['pnl']) && !is_object($p['pnl'])){ $p['pnl']=_jEnc($p['pnl']); }

				if(!isN($p['pnl']) && $p['pnl']->e == 'ok'){

					if(isN( $p['pnl']->s )){ $__pnl_s = 'l'; }else{ $__pnl_s = $p['pnl']->s; }
					if(isN( $p['pnl']->tp )){ $__pnl_tp = 'h'; }else{ $__pnl_tp = $p['pnl']->tp; }
					if(!isN( $p['pnl']->sw )){ $__pnl_sw = ' ,sw:"'.$p['pnl']->sw.'" '; }else{ $__pnl_sw = ''; }

					$_pop=$p['pop']='ok';
					$__pnl = ", pnl:{ e:'ok', s:'".$__pnl_s."', tp:'".$__pnl_tp."' ".$__pnl_sw." } " ;	
					
				}
				
				//$_r .= " var _rid = ''; "; Se incluyo en algun momento para eliminar el ID, pero toca mirar en que momento y para que se incluyo 

				$_r .= "
						
					_ldCnt({ 
						u:'".$p['u']."?".$p['mre']."&".$_clsp."&__rnd='+Math.random()".$__dt.",  
						pop:'".$p['pop']."', 
						w:'".$__w."', 
						h:'".$__h."', 
						scrl:'".$__scrl."' ".$__cl." ".$__cm." ".$__pnl." ".$__c." ".$__cgrp." ".$__plct."
					});";
							
				$_r .= $_clsclr;
					
			}
			
			return($_r);
		}
		
		public function VlFm($_p=NULL){
			
			//-------------- GENERAL OPTIONS - START --------------//
				
				$_ldrsis = ICN_LDR_SIS;
				
				if(ChckSESS_superadm()){ 
					$_shwalert .= " if(!isN(d) && !isN(d.w)){ swal('Error', d.w, 'error'); } "; 
				}

				$_shwalert .= " if(!isN(d) && !isN(d.w_us)){ swal('Error', d.w_us, 'error'); } ";
			
				if($this->pop() || $this->sbl()){ $this->prfx .= DV_SBCNT; }
				if($_p['fm_el']=='ok'){ $__prfx_jv = '_el';	}
				
				$__id_fm_opc = 'opc'.$_p['fm'].$__prfx_jv;
			
			//-------------- GENERAL OPTIONS - ENDS --------------//
			
			if($_p['fm_el']=='ok' && $this->dt->tot == 0){ $_hb = 'no'; }else{ $_hb = 'ok'; }
								
			if(!isN($_p['fm']) && ($_hb == 'ok')){

				$_dvld = DV_GNR_FM.$this->prfx;		
							
				//-------------- VALIDATE DELETE --------------//
					
					if($_p['fm_el'] == 'ok'){
						
						/*--------------- REFRESH CONFIRM ---------------*/	
						
						if($this->gt->pop != 'ok'){
							$JS_BtnRfr .= "	$('#".$this->fm->hdr->b->rfr."').off('click').click(function(e){	
												
												e.preventDefault();
												
												swal({   
													title: '".TX_CFRFR."',    
													showCancelButton: true,   
													confirmButtonColor: '".BTN_OK_CLR."',   
													confirmButtonText: '".TX_DSDLG."', 
													cancelButtonText: '".TX_NTHNKS."',   
												}, 
												function(c){   
													if(c){ _ldCnt({ u:'".$_SERVER['REQUEST_URI']."&__rnd=".Gn_Rnd(3)."', c:'".$this->bx_rld."' }); }
												});	
											});"; 
						}						
						
						/*--------------- DELETE BUTTON ACTION ---------------*/	
						
						$JS_BtnEli = "
					
							$('#".$this->fm->hdr->b->eli."').off('click').click(function(e){
								
								e.preventDefault();
								
								SUMR_Main.btn_eli_c({
									tp:'el',
									_c:function(){
										if( isN(SUMR_Main.ibx['save']) ){	
											SUMR_Main.ibx['save'] = $.ajax(".$__id_fm_opc.");
										}
		
									}
								})
							});
						
						"; 
						
					}else{
						
						/*--------------- SAVE BUTTON ACTION ---------------*/	
						
						$JS_BtnSve = "	$('#".$this->fm->hdr->b->sve."').off('click').click(function(e){
											
											e.preventDefault();

											if( $('#".$_p['fm']."').valid() ){
											
												SUMR_Main.btn_sve_c({
													tp:'ed',
													_c:function(){
														$('#".$_p['fm']."').submit();
													}
												});
												
											}
											
										});

										$('#".$_p['fm']."').keydown(function(e){
									    	if(event.keyCode == 13) {
												event.preventDefault();
												return false;
											}
										});
										
										
										";
						
						
						/*--------------- SAVE AND NEXT BUTTON ACTION ---------------*/	
						
						$JS_BtnSve .= "	$('#".$this->fm->hdr->b->sve_nxt."').off('click').click(function(e){
											
											e.preventDefault();
											
											if( $('#".$_p['fm']."').valid() ){
												SUMR_Main.btn_sve_c({
													tp:'ed',
													_c:function(){
														SUMR_Main.bxajx.sve_nxt = 'ok';
														$('#".$_p['fm']."').submit();
													}
												})
											}
										});
										
									";
					}
				
				//-------------- VALIDATE PASS FORM --------------//
				
					if($this->fm->pss == 'ok'){
						
						$JS_VldOp = '{rules: {
											us_pass:{minlength: 5}, 
											us_passcnf:{minlength: 5, equalTo: "#us_pass"}
									},
									messages: {
											us_pass: {required:"'.TX_PSWRPRS.'",minlength: "'.TX_CNTCRCT.'"},
											us_passcnf: {required: "'.TX_CNFPSWR.'",minlength: "'.TX_CNTCRCT.'", equalTo:"'.TX_CLVCND.'"}
											}
									}';
					}
				
					
				
				
				if(!isN($this->bx_rld)){
					
					$JS_F_Ld_c .=	"$('#".$_p['fm']."').fadeOut('fast'); SUMR_Main.anm.shwLd({ id:'".$this->id_ldr."', e:'o' });";
					$Vl_Err .= "$('#".$_p['fm']."').fadeIn('fast');";
					
				}else{
					
					if($this->pnl() || !isN($this->bx_rld)){ 
						
						$JS_F_Ld_c .=	"
							
							SUMR_Main.anm.shwLd({ id:'".$this->id_ldr."', e:'o' });
							$('#".$this->fm->id."').addClass('_disabled');
								
						";
						
					}elseif($this->pop()){
						$JS_F_Ld_c .=	"SUMR_Main.anm.tld('".ICN_LDR_POP."','in');";
						$Vl_Err .=	"SUMR_Main.anm.tld('".ICN_LDR_POP."','out');";
					}else{
						
						$JS_F_Ld_c .= "SUMR_Main.anm.tld('".$_dvld."','out');";
						$Vl_Err .= "SUMR_Main.anm.tld('".$_dvld."','in');";	
					}
					
				}
			
				
				$JS_F_Ld = " function ShLod_".$this->id_rnd."(){".$JS_F_Ld_c."}";				
				
				
				
				if(!isN($this->bx_rld)){ $__cntwb = $this->bx_rld; }else{ $__cntwb = DV_LDR_WB; }					
				if($this->pop() && $_p['fm_el'] == 'ok'){	$__vl_aft = 'cls'; }

		
				if(!isN($this->bx_rld)){
					
					if(isN($this->gt->i) && $this->pop() && !$this->pnl()){

						$JS_Scc_BxrGoTo_pop = " var __m_pop = 'ok'; ";
						$JS_Scc_BxrGoTo_pop_w = " var __m_pop_w = '".$this->edit->w."'; ";
						$JS_Scc_BxrGoTo_pop_h = " var __m_pop_h = '".$this->edit->h."'; ";
						$JS_Scc_BxrGoTo_pop_rbck = '
						
							if(!isN(d.i)){	
								_ldCnt({ u:SUMR_Main.bxajx._'.$this->bx_rld.', c:\''.$this->bx_rld.'\' });
							}	
						';
						
						$JS_Scc_BxrGoTo_pop_cls = '$.colorbox.close();';
					}

					
					$JS_Scc_BxrGoTo .= '
					
						if(!isN(d.i)){	
							var __m_i = \''.ADM_LNK_DT.'\'+d.i; 
							'.$JS_Scc_BxrGoTo_pop.'
							'.$JS_Scc_BxrGoTo_pop_w.'
							'.$JS_Scc_BxrGoTo_pop_h.'
						}else{ 
							var __m_i = \'\',
								__m_pop = \'\',
								__m_pop_w = \'\',
								__m_pop_h = \'\';
						}
						
						'.$JS_Scc_BxrGoTo_pop_cls.'
						
						setTimeout(function(){ 
						
							_ldCnt({ 
								u:SUMR_Main.bxajx._'.$this->bx_rld.'+__m_i, 
								c:\''.$this->bx_rld.'\', 
								pop:__m_pop,
								w:__m_pop_w, 
								h:__m_pop_h, 
								_cl:_cllbck 
							});		
							
						}, 1000);
						
					';
					
					if($this->fpop()){
						
						$JS_Scc_GoTo .= "SUMR_Main.pop.bck({ t:'pop' });";
						
					}elseif($this->pnl()){
						
						$JS_Scc_GoTo .= "
						
							if(isN(d.enc)){
								SUMR_Main.pop.bck({ t:'pnl' });
							}
						
						";
						
					}
					
					//if(ChckSESS_superadm()){ echo 'GoTo:'.$JS_Scc_GoTo; }
					
					//if(!isN($this->ls)){ 
						/*
						$JS_Scc_GoTo =	' 
							_ldCnt({ 
								u:\''.FL_LS_GN.'?'.$this->vr.'&__rnd='.Gn_Rnd(3).'\',
								pop:\''.$this->gt->pop.'\', 
								_cl:_cllbck 
							}); '; 
						*/	
					//}
					
					
				}else{
					
					if($this->pop()){ $_tbck='pop'; }
					elseif($this->pnl()){ $_tbck='pnl'; }
				
					//-------------- RELOAD WITHOUT SUB BOX --------------//
					
					if(!isN($this->gt->plcf)){
						$this->goto->bck = '
							if(!isN( SUMR_Main.url[\''.$this->gt->plcf.'\'] )){
								_ldCnt({
									u:SUMR_Main.url[\''.$this->gt->plcf.'\'].lnk,
									c:SUMR_Main.url[\''.$this->gt->plcf.'\'].box, 
									_cl:_cllbck
								});
							}
						';
					}else{
						$this->goto->bck = '
							if(!isN( SUMR_Main.url[\''.$this->gt->plct.'\'] )){
								_ldCnt({
									u:SUMR_Main.url[\''.$this->gt->plct.'\'].lnk,
									c:SUMR_Main.url[\''.$this->gt->plct.'\'].box, 
									_cl:_cllbck
								});
							}
						';
					}
				
					if((isN($this->vw->rfrsh) && $this->vw->rfrsh != 'no') || $this->gt->pr == 'Ing'){
						
						$JS_Scc_GoTo =	'

							if(d.c != \'ok\'){

								if(!isN(d.enc) || !isN(d.i)){
									
									if(!isN(d.enc)){ var _rid=d.enc; }else if(!isN(d.i)){ var _rid=d.i; }
									
									if(!isN(_rid)){
										'.$this->ls->sve->rld.'
									}else{
										SUMR_Main.pop.bck({ t:\''.$_tbck.'\' });	
									}
									
									'.($this->pop()?$this->goto->bck:'').'

								}else{	
									'.$this->goto->bck.'
									'.($this->pnl()?'SUMR_Main.pnl.f.shw();':' SUMR_Main.pop.bck({ t:\''.$_tbck.'\' });').' 
								}
								
							}

						';
						
					}else{
						
						if($this->ls->nxt->hb == 'ok'){ 
							
							$__nxt_go = ' 
								
								if(!isN(SUMR_Main.bxajx.sve_nxt) && SUMR_Main.bxajx.sve_nxt == "ok"){
									
									var __nxt_id = $("#'.$this->ls->nxt->id.$this->uid.'").nextAll(".'.$this->ls->nxt->cls.'").first().attr("id");
									var __nxt_go = $("#"+__nxt_id+" .ls_btn.btn_mod ").attr("href");
									
									if(!isN(__nxt_go)){
										eval(__nxt_go);
										SUMR_Main.bxajx.sve_nxt = "";
									}
									
								}	
								
							'; 
							
						}
						
						$JS_Scc_GoTo =	'	
							if(d.c != \'ok\'){
								if(!isN(d.enc) || !isN(d.i)){ '.$__nxt_go.'
									'.($this->pop()?$this->goto->bck:'').'	
								}
							}
						'; 
							
					}
					
				}
				
				if($this->pnl() || !isN($this->bx_rld)){	
					$JS_Scc_LdOut .= "SUMR_Main.anm.shwLd({ id:'".$this->id_ldr."' }); $('#".$this->fm->id."').removeClass('_disabled');";	
				}elseif($this->pop()){
					$JS_Scc_LdOut .= "SUMR_Main.anm.tld('".ICN_LDR_POP."','out');";
				}else{
					$JS_Scc_LdOut .= 'if(!isN(d)){ StTm_Est({ e:d.m }); }';
				}
				
				 
				if(!isN($this->bx_rld)){
					$JS_Scc_BxIn .=	"$('#".$_p['fm']."').fadeIn('fast');";
				}else{
					$JS_Scc_BxIn .=	"SUMR_Main.anm.tld('".DV_GNR_FM.$this->prfx."','in');";
				}						

				if($_p['fm_el']=='ok'){ 
					
					$JS_Data .= " _data_snd['MM_delete']='".$this->nm."';"; 
					
					if(!isN($this->fm->key)){ $JS_Data .= " _data_snd['___key']='".$this->fm->key."';";  }
					if(!isN($this->fm->f1)){ $JS_Data .= " _data_snd['".$this->fm->f1."']='".$this->fm->f1_v."';";  }
					if(!isN($this->uid)){ $JS_Data .= " _data_snd['uid']='".$this->uid."';"; }
							
					$JS_BfrSnd = "beforeSend";		
					$JS_Url = "url:'".Fl_Rnd(PRC_GN.__t($this->tp,true))."&Rd='+Math.random(), ";	
					
				}else{
					
					$JS_Vldt = "$('#".$_p['fm']."').validate(".$JS_VldOp.");";
					$JS_Snd = "$('#".$_p['fm']."').ajaxForm(".$__id_fm_opc.");";
					$JS_BfrSnd = "beforeSubmit";
					$JS_Url = "url:'".Fl_Rnd(PRC_GN.__t($this->tp,true))."&Rd='+Math.random(), ";					
				}
				
				
				if($this->pnl()){
					$JS_Scc_LdIn .= "$('.crm-panel[pnl-lvl=\'".$this->pnl_i()."\']').addClass('smr-loading');";
					$JS_Scc_LdOut .= "$('.crm-panel[pnl-lvl=\'".$this->pnl_i()."\']').removeClass('smr-loading');";
				}elseif($this->pop()){
					$JS_Scc_LdIn .= "$('#colorbox').addClass('smr-loading');";
					$JS_Scc_LdOut .= "$('#colorbox').removeClass('smr-loading');";
				}else{
					$JS_Scc_LdIn = '';
				}

				//echo $JS_Scc_LdOut;
				//echo h1('BxRGoTo:'.$JS_Scc_BxrGoTo);
				//echo h2('GoTo:'.$JS_Scc_GoTo);
				
				if(!Dvlpr()){ $_tout = 20000; }else{ $_tout = 50000; }

				$__js = ' 
						
						'.$JS_F_Ld.'
		
						var _data_snd={};
						var _rid = \'\'; /* Cambio de ubicación de la Linea 239 */
						 
						'.$JS_Data.'
						
						var '.$__id_fm_opc.' = {
								
								'.$JS_Url.'
								type: \'POST\',
								dataType:\'json\', 
								'.$JS_BfrSnd.':function(){
									ShLod_'.$this->id_rnd.'();
									'.$JS_Scc_LdIn.'
								},
								timeout:'.$_tout.',
								data:_data_snd,
								error: function(x, t, m) {
							        if(t === \'timeout\') {
							            SUMR_Main.log.f({ m:\'Serviciosin: Excede tiempo de carga\' });
							        } else {
							            SUMR_Main.log.f({ m:\'Serviciosin: \'+t });
							        }
							        
							        swal({   
								        type: "error",
							        	title: "Uups..",   
							        	text: "'.TX_SMTAGN.'",   
									});
							        
							        '.$Vl_Err.'
							    },
								complete: function(d){
									'.$JS_Scc_LdOut.'
									delete SUMR_Main.ibx[\'save\'];	
								},
								success: function (d){ 
									
									if(!isN(d.cl)){ 
										var _cllbck = function(){ eval(d.cl); }
									}
								
									if(!isN(d) && !isN(d.e) && d.e==\'ok\'){	
										if(!isN(d.fcl) && d.fcl ==\'ok\' && !isN(_cllbck)){
											_cllbck();
										}else{
											StTm_Est({ e:d.m, a:\''.$__vl_aft.'\' });
											'.$JS_Scc_GoTo.'
											'.$JS_Scc_BxrGoTo.'
											'.$JS_Scc_BxrGoTo_pop_rbck.'
										}
									}else{										
										if(!isN(_cllbck)){ _cllbck(); }
										'.$JS_Scc_BxIn.'
									}		
									
									'.$_shwalert.' 
									
								}
							};
						
						'.$JS_Snd.'	
						'.$JS_Vldt.' 		
						
						'.$JS_BtnRfr.'	
						'.$JS_BtnSve.'
						'.$JS_BtnEli.'	
						
				';
				
				return($__js);

			}

		}
	

		public function _h_fm_img($p=NULL){
			if(!isN($p['b'])){ $_btn=$p['b']; }else{ $_btn=$this->img->btn; }
			return('$("#'.$_btn.'").off(\'click\').click(function(e){ e.preventDefault(); _ldCnt({ u:\''.$p['u'].'\', pnl:{ e:\'ok\', tp:\'h\' }, pop:\'ok\' }); });');
		}
		
		
		public function _tp_pr($Cn){
			if(($Cn != "")){$TxPr = TX_EDIT;}else{$TxPr = TX_NW;}
			return Spn(' ('.$TxPr.') ', '', '_tprc');
		}
		
		
		public function _h_fm_hdr($p=NULL){
			
			//------------ POP LOADER ------------//
			
				if($this->pop() || $this->pnl() /*|| $this->sub()*/){ $_html_pop = '<div id="'.$this->id_ldr.'" class="_m_ldr_pop _anm"></div> '; }
			
			//------------ THUMBNAIL HEADER ------------//
				
				$__img = _ImVrs([ 'img'=>$this->dt->rw[ $this->img->f ], 'f'=>$this->img->dir ]);
				$_f = $this->_clrbx_img([ 't2'=>$this->tp, 't3'=>$this->gt->tsb, 'id'=>($this->img->enc=='ok'?$this->dt->rw[$this->ik]:$this->uidn) ]);
				$this->js .= $this->_h_fm_img([ 'u'=>$_f ]);

				if($__img->ext == 'svg'){
					$__bck_url = 'background-image:url('.$__img->big.')';
				}else{	
					if(!isN($__img->th_200)){ $__bck_url = 'background-image:url('.$__img->th_200.')'; }else{ $__bck_url_cls = '_empty'; }
				}
				
				if(!isN($this->img->dir)&&($this->dt->tot>0)){ 
					$_html_th = '<div class="img _anm '.$__bck_url_cls.'" id="'.$this->img->btn.'"><div class="_c _anm" style="'.$__bck_url.'"></div></div>'; 
				}
				
				if(($this->pop() || $this->pnl()) && isN($this->bx_rld)){
					if($this->pop()){ $_tbck='pop'; }
					if($this->pnl()){ $_tbck='pnl'; }
					$this->fm->hdr->ref = "SUMR_Main.pop.bck({ t:'".$_tbck."' });";
				}
				
			//------------ TITLE HEADER ------------//    
	        
				if( !isN($this->tt) ){
					if((!$this->sbl() || $this->fm->hdr->bck=='ok') && !isN($this->fm->hdr->ref)){ 
						$_html_bck = '<a href="'.Void().'" onClick="'.$this->fm->hdr->ref.'" class="_bck">'.
											Spn('','','_icn').
											Spn(TX_VLVLSDE,'','_t').' '.ShortTx($this->tt,80).'</a>'; 
					}
					if(!isN($this->tt_ext)){ $_r_mrett = ' '.Spn($this->tt_ext); }
					$_html_tt = h2( ShortTx($this->tt, 60, 'Pt', true) . $_r_mrett . $this->_tp_pr($this->gt->pr). '<br>'.$_html_bck );	
				}
				
			//------------ ID GENERATOR ------------//  	
			
				if(!isN($this->prfx)){ $_prfx .= $this->prfx; } 
				if($this->sbl() || $this->pop()){ $_prfx .= DV_SBCNT; }
				
				$this->fm->hdr->b->rfr = ID_BTNRFR./*$this->tp.*/$_prfx.$this->id_rnd;
				$this->fm->hdr->b->sve = ID_BTNSVE./*$this->tp.*/$_prfx.$this->id_rnd;
				$this->fm->hdr->b->sve_nxt = ID_BTNSVE_NXT./*$this->tp.*/$_prfx.$this->id_rnd;
				$this->fm->hdr->b->eli = 'but_eli'./*$this->tp.*/$_prfx.$this->id_rnd;
			
			//------------ BUTTONS HEADER ------------//  
				
				
				/*--------------- CUSTOM BUTTON ---------------*/
				
					if(!isN($this->fm->hdr->cbtn)){ 
						$_html_b_custom = $this->fm->hdr->cbtn->html; 
						$this->js .= $this->fm->hdr->cbtn->js; 
					}
				
				/*--------------- REFRESH BUTTON ---------------*/
	
					//if($this->fm->hdr->rfr == 'ok'){  
						//$_html_b_rfr = '<div class="___rfrsh"><button id="'.$this->fm->hdr->b->rfr.'" name="'.$this->fm->hdr->b->rfr.'" class="btn_upd_view"></button> </div>'; 
					//}
				
				/*--------------- SAVE BUTTON ---------------*/	
					
					if($this->hb->mod == 'ok' || $this->hb->ing == 'ok'){		
							
						if(isN($this->tt) || $this->sbl()){ 
							$__grdr_icn = '_mny';
						}	
							
						$this->fm->btn->sve = $_html_b_mod = '<div class="___edt"><button id="'.$this->fm->hdr->b->sve.'" name="'.$this->fm->hdr->b->sve.'" class="_anm sve '.$__grdr_icn.'">'.Spn(TXBT_GRDR,'','_anm').'</button></div>';
		
					}
				
				/*--------------- SAVE AND NEXT BUTTON ---------------*/	
					
					if(($this->hb->mod == 'ok' || $this->hb->ing == 'ok') && $this->ls->nxt->hb == 'ok' && $this->dt->tot>0){		
							
						if(isN($this->tt) || $this->sbl()){ 
							$__grdr_icn = '_mny';
						}	
							
						$this->fm->btn->sve_nxt = $_html_b_mod_nxt = '<div class="___edt_nxt"><button id="'.$this->fm->hdr->b->sve_nxt.'" name="'.$this->fm->hdr->b->sve_nxt.'" class="_anm '.$__grdr_icn.'">'.Spn(TXBT_GRDRNXT,'','_anm').'</button></div>';
		
					}	
				
				/*--------------- DELETE BUTTON ---------------*/
					
					if($this->dt->tot>0 && $this->hb->eli == 'ok'){		
						$_html_b_eli = '<div class="___eli"><button name="'.$this->fm->hdr->b->eli.'" id="'.$this->fm->hdr->b->eli.'" class="_anm">'.Spn(TXBT_BRR,'','_anm').'</button></div>'; 
					}	
					
			//------------ BOX BUILD ------------// 
				
				//<!--class="btn"--> Before	
				$__html = '	<div class="'.ID_HDRLS.' _anm '.$this->cls_hdr.'" id="'.$this->id_hdr.'">'. 
								$_html_pop.$_html_th.$_html_tt.
								'<div class="__hdr_btn">'.$_html_b_custom.$_html_b_rfr.$_html_b_mod.$_html_b_mod_nxt.$_html_b_eli.'</div>'.
							'</div>';  
	
			return($__html);
		}
		
		
		public function _h_fm_mmfm(){
			
			if(!isN($this->uid)){ $_r .= '<input name="'.$this->ik.'" type="hidden" id="'.$this->ik.'" value="'.$this->uid.'" />'; } 
			if(!isN($this->gt->tsb)){ $_r .= '<input name="t2" type="hidden" id="t2" value="'.$this->gt->tsb.'" />'; }
			if(!isN($this->id_rnd)){ $_r .= '<input type="hidden" name="MM_rndm" value="'.$this->id_rnd.'" />'; }
			                    
			if($this->dt->tot > 0){ $_r .= '<input type="hidden" name="MM_update" value="'.$this->nm.'" />';  }
	        if($this->dt->tot == 0){ $_r .= '<input type="hidden" name="MM_insert" value="'.$this->nm.'" />';  }
	        
	        
			return($_r);
		}
		
		public function _h_fm($p=NULL){
			
			
			/*-------------- VAR LINK ON SUCCESS --------------*/					
													
				$this->_sql([ 't'=>'dt' ]);	
				
				$this->fm->id = 'BxFm'.$this->id_rnd;
				$this->fm->bx->id = DV_GNR_FM.$this->id_rnd;
				$this->fm->fld->id = DV_GNR_FM_CMP.$this->id_rnd;
				$this->fm->el->id = $this->fm->id.'_El';		
				$this->fm_html->hdr .= $this->_h_fm_hdr();
				$this->fm_html->hdr .= $this->_h_fm_mmfm();
				
				$this->_h_ls_chck([ 't'=>'dt' ]);
				
				/*-------------- LINK ON SUCCESS --------------*/					
				
				$_pnl=[];

				if($this->pop()){ $_pnl['e']='ok'; }
				if(($this->dt->tot==0 ||isN($this->dt->tot)) && $this->fm->chk=='ok'){ $_pnl['e']='no'; }
				if(($this->pop() && $this->sbl()) || $this->pnl()){ $_pnl['e']='ok'; }
				if(isN($this->bx_rld)){ $_pnl['e']='no'; }else{ $_rldbx=$this->bx_rld; }					
				
				if(isN($_rldbx)){

					if($this->pnl()){
						$_pnl = $this->gt->pnl;
						$_pnl->sw = 'ok';
						$_pnl->ss = 'ok';
					}

					$this->ls->sve->rld = $this->_pgrg([
														'u'=>FL_LS_GN, 
														'c'=>$_rldbx,
														'dt'=>'ok',
														'mre'=>__t($this->tp).$this->ls->vrall, 
														'pop'=>$this->scc->pop, 
														'pnl'=>$_pnl, 
														'w'=>$this->scc->w, 
														'h'=>$this->scc->h, 
														'scrl'=>$this->scc->scrl 
													]); //echo $this->ls->sve->rld;

				}	
					
					
				/*-------------- VALIDATE FORM --------------*/


				$this->js .= $this->VlFm([
									  'fm'=>$this->fm->el->id,
									  'fm_el'=>'ok',
									  'fm_tp'=>$this->fm->tp,
									  'fm_pss'=>__t($this->fm->pss), 
									  'fm_ls'=>FL_LS_GN, 
									  'fm_vr'=>__t($this->fm->tp).$this->ls->vrall,
									  'fm_pop'=>$this->fm->pop
								]);  
				  
				$this->js .= $this->VlFm([
								  	'fm'=>$this->fm->id,
								  	'fm_tp'=>$this->fm->tp,
								  	'fm_ls'=>FL_LS_GN, 
								  	'fm_vr'=>__t($this->fm->tp).$this->ls->vrall,
								  	'fm_pop'=>$this->fm->pop
								]); 
				
																				
		}
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		public function _h_ls_chck($p=NULL){ 
			
			if($p['t'] == 'dt'){
				if(($this->gt->pr == "Dt" && !isN($this->gt->i) && $this->dt->tot > 0) || $this->gt->pr == 'Ing'){ $this->fm->chk='ok'; }
			}elseif($p['t'] == 'ls'){
				if(($this->dt->tot == 0) && ($this->gt->pr != 'Ing')){ $this->ls->chk='ok'; }elseif($this->gt->pr=='Ing'){ $this->fm->chk='ok'; }
			}
			
		}
		
		public function _h_ls_pgscnt($p=NULL){
			if ($this->qry->pgs > 0 && !isN($p['d'])) { 
				if($_p['tt']!='no'){ $Vlr = TX_XPLF.'<span> '.TX_RES.'</span>'; } 
				$Vlr .= implode(' | ', $p['d']);
				return($Vlr);
			}
		}
	
		public function _h_ls_prg($p=NULL){
			if($Str != '' && !isN(SIS_NMRG) && !isN($this->qry->tot) && !isN($this->qry->pgs)){	
				$Vlr =  '<span>'.($Str + 1).'</span> a <span>'.min($Str + SIS_NMRG, $this->qry->tot).'</span> de <span>'.$this->qry->tot.'</span>';  		
			}
			return $Vlr;
		}
		
		
		public function _h_ls_rcpg($p=NULL){
			
			if(!isN($this->qry->qrs)){
				
				$var1 = 0; 
				$MdPgs = SIS_NMPG / 2;
				$MxPgs = $this->gt->pgn + $MdPgs;
				$MzPgs = $MxPgs - $MdPgs;
				$a_Pg = $this->gt->pgn - $MdPgs;
				$b_Pg = $this->qry->pgs+1;
				
				if(!isN($this->edit->pop) || $this->pnl()){ $_pop=$this->edit->pop; }
				if(($this->pop() && $this->sbl()) || $this->edit->pnl == 'ok' || $this->pnl()){ $_pnl='ok'; } 
				if(!isN($this->gt->pnl->sty)){ $_pnl_s=$this->gt->pnl->sty; }
				if(!isN($this->gt->pnl->tp)){ $_pnl_t=$this->gt->pnl->tp; }
				if($this->pop() || $this->pnl()){ $_pop_pg = 'ok'; }

				do {
					
					if($var1 == $this->gt->pgn){
						$StyDt = "Sl";
					}else{
						$StyDt = "";
					}
						
					$Sch = ['&Pr=Ls'];
					$Chn = [];
					$NwTxPgd = str_replace($Sch,$Chn,$this->qry->qrs);
					
					
					if(($var1 == $a_Pg)){	
						
						$_fpgN='&pgN='.($var1);
						
						$lnkDt = JQ__ldCnt([
									'u'=>FL_LS_GN.'?'.TXGN_LS.$_fpgN.$NwTxPgd, 
									'c'=>(!isN($this->bx_rld)?$this->bx_rld:''),
									'p'=>$_pop_pg,
									'pnl'=>[
										'e'=>$_pnl,
										's'=>$_pnl_s,
										't'=>$_pnl_t,
										'sw'=>'ok',
										'ss'=>'ok'
									]
								]);
						$data[] = "<a class=\"".$StyDt."\" href=\"".$lnkDt."\">".($var1+1)."</a>";
						
					}else if(($var1 > $a_Pg)&&($var1 < $b_Pg)){
						
						$_fpgN='&pgN='.($var1);

						$lnkDt = JQ__ldCnt([ 
									'u'=>FL_LS_GN.'?'.TXGN_LS.$_fpgN.$NwTxPgd, 
									'c'=>(!isN($this->bx_rld)?$this->bx_rld:''),
									'p'=>$_pop_pg,
									'pnl'=>[
										'e'=>$_pnl,
										's'=>$_pnl_s,
										't'=>$_pnl_t,
										'sw'=>'ok',
										'ss'=>'ok'
									]
								]);
								
						$data[] = "<a class=\"".$StyDt."\" href=\"".$lnkDt."\">".($var1+1)."</a>";
					}
					
					$var1 ++;
						
				} while ($var1 <= $MxPgs);
				
				
				$this->ls_html->pgs = '<div class="Tot_Tb">'.$this->_h_ls_prg().$this->_h_ls_pgscnt([ 'd'=>$data ]).'</div>';
			}
			
		}
	
		
		
		public function _h_ls_qupgsi($p=NULL){
			
			if(!isN( $this->ls->tot_all )){
				
				if(!isN($this->gt->totrws) && $this->fl->rst!='ok'){
					$totRws = $this->gt->totrws;
				}else{
					$totRws = $this->ls->tot_all;
				}
				
				$totPgs = ceil($totRws/SIS_NMRG)-1;
				$qryStr = "";
				
				if(!empty($_SERVER['QUERY_STRING'])) { 
					$params = explode("&", $_SERVER['QUERY_STRING']);
					$newParams = array(); 
					
					foreach ($params as $param) {   
						if(stristr($param, "pgN") == false && stristr($param, "totRws") == false){
							array_push($newParams, $param);
						}
					} 
					
					if(count($newParams) != 0){
						$qryStr = "&" . htmlentities(implode("&", $newParams)); 
					}
				
				}
				
				$qryStr = sprintf("&totRws=%d%s", $totRws, $qryStr);
				
				$this->qry->tot = $totRws;
				$this->qry->qrs = $qryStr;
				$this->qry->pgs = $totPgs;
				
				/*
				define('TT_RWS', $totRws);
				define('LS_QR', $qryStr);
				define('TT_PGS',$totPgs);
				*/
				
				$this->_h_ls_rcpg();
				
				return(true);
				
			}
		}
	
	
		
		public function _sch_inp($p=NULL){ //$V,$N=''
			
			if(!isN($p['v'])){ $V_v = $p['v']; }else{ $V_v = TX_SEARCH; }
			if(!isN($p['id'])){ $_id=$p['id']; } 
			
			$chg = str_replace('*.', ' ', $V_v); if(!isN($p['v'])){ $_vl = $p['v']; }
			
			$_rtrn = "<div><form id='Sch_".$_id.$this->id_rnd."' name='Sch_".$_id.$this->id_rnd."'><input placeholder='".$chg."' type='text' name='".$_id.$this->id_rnd."' id='".$_id.$this->id_rnd."' class='required _sch' value='".$_vl."' /></form></div>";
			
			
			
			$this->js .= "	
							
				$('#Sch_".$_id.$this->id_rnd."').submit(function(){ return false; });
							
			   	$('#Sch_".$_id.$this->id_rnd."').off('keyup').keyup(function(e){
					
					if(e.keyCode==13){
						
						if( $('#Sch_".$_id.$this->id_rnd."').valid() ){
							
							if(typeof Sch_Ls".$this->id_rnd." === 'function') {
							
								Sch_Ls".$this->id_rnd."();	
							
							}
						
						}
						
					}
					
				});
						
			";
					   
			return($_rtrn);
		}
		
		
		public function _clrbx_img($p=NULL){ //$_b, $t=NULL
			
			if($p['p']=='nw'){$_t=TXGN_UPLNW;}else{$_t=TXGN_UPL;}
			if(!isN($p['id'])){$_m.='&_i='.$p['id'];}
			
			if(!isN($p['t2'])){$_m.='&_t2='.$p['t2'];}
			if(!isN($p['t3'])){$_m.='&_t3='.$p['t3'];}
			if(!isN($p['t4'])){$_m.='&_t4='.$p['t4'];}
			
			$_r = FL_FM_GN.'?'.$_t.$_m;
			return($_r);
			
		}
		
	
		public function _h_ls_hdr($p=NULL){
			
			$__dtcl = __Cl([ 'id'=>$__sbdmn, 't'=>'sbd' ]);
			$__flt_dt = $this->_f_chk([ 'cl'=>$__dt_cl->id, 't'=>$this->gt->t, 't2'=>$this->gt->tsb ]); 

			$_s = 'Sch_Cnt';
			$_sch = $__flt_dt->sch;

			if(!isN($__mre['cls'])){ $___mre = $__mre['cls']; }else{ $___mre = ''; }
			

			//------------ ID GENERATOR ------------//  	
			
				if(!isN($this->prfx)){ $_prfx .= $this->prfx; } 
				if($this->sbl() || $this->pop()){ $_prfx .= DV_SBCNT; }
				$this->ls->hdr->b->rfr = ID_BTNRFR./*$this->tp.*/$_prfx.$this->id_rnd;

			/*--------------- REFRESH BUTTON ---------------*/
	
				//if($this->fm->hdr->rfr == 'ok'){  
					$_html_b_rfr = '<div class="___rfrsh"><button id="'.$this->ls->hdr->b->rfr.'" name="'.$this->ls->hdr->b->rfr.'" class="btn_upd_view _anm"></button> </div>'; 
					$this->js .= '$(\'#'.$this->ls->hdr->b->rfr.'\').click(function(){
											
											swal({   
												title: "'.TX_ETSGR.'",
												text: "'.TX_CFRFR.'",
												showCancelButton: true,   
												confirmButtonColor: "'.BTN_OK_CLR.'",   
												confirmButtonText: "'.TX_DSDLG.'", 
												cancelButtonText: "'.TX_NTHNKS.'",   
											}, 
											function(c){
												if(c){
													'.$this->ls->rld.'
												}
											});	

									  });'; 
					

				
				//}
					
			//------------ BUTTONS BUILDER ------------//
				
				
				if(!isN($this->tt) && !$this->sbl()){

					$_t = h2(TX_LSDE.' '.Spn($this->tt), $this->tt_cls);
						
					if(!isN($this->ls->tot_all) && is_numeric($this->ls->tot_all)){ 
						$_t .= ' '.Spn( number_format($this->ls->tot_all, 0, '.', ',') ,'ok','_n'); 
					}
					
				}elseif(!isN($this->tt_sb)){
					$_t = h2($this->tt_sb, $this->tt_cls);	
					$_ttc = '_sub';
				}else{ 
					$_ttc = '_sub'; 
				} 

				if(!isN($this->hdr->mre)){
					$_html_hdrm = '	<div class="__hdr_mre">'.$this->hdr->mre.'</div>'; 
				}
					
				if(!isN($this->sch->f) || $this->sch->shw == 'ok'){ 
					
					$_html_sch = '	<div class="__hdr_sch">'.$this->_sch_inp([ 'v'=>$_sch, 'id'=>$_s ]) .
										$this->_sch_ls([
														'inp'=>$_s, 
														'vl'=>$_sch, 
														'mre'=>__t($this->tp).$p['othg'].TXGN_BX.(!isN($this->bx_rld)?$this->bx_rld:''),
														'bxr'=>$p['bxr'],
														'__i'=>$p['__i']
													]).	
									'</div>'; 
				}
				
				if(!isN($this->dwn) || !isN($this->dwn_o)){ 
					
					
					if($this->hb->dwn == 'ok'){
						$_html_dwn .= $this->_btn([ 't'=>'dwn' ]); 
					}
					
					if(!isN($this->dwn_o)){ $__dwn_u = $this->dwn_o; }else{ $__dwn_u = FL_FM_DWN.'?'.__t($this->tp).$this->ls->vrall; }
					if(!isN($this->dwn_s)){ $__dwn_s_w = $this->dwn_s[0]; $__dwn_s_h = $this->dwn_s[1]; }else{ $__dwn_s_w = '450'; $__dwn_s_h = '550'; }
					
					//$_dwn_f = '$.colorbox({  width:"'.$__dwn_s_w.'", height:"'.$__dwn_s_h.'", trapFocus:false, iframe:false, href:"'.$__dwn_u.'&__rnd="+Math.random() });';
					
					$_dwn_f = "
						_ldCnt({
							u:'".$__dwn_u."',
							w:'".$__dwn_s_w."',
							h:'".$__dwn_s_h."',
							pop:'ok',
							pnl:{
								e:'ok',
								tp:'h',
								s:'l',
							},
							cls:'_fll'
						});
					";		
					
				}
				
				if(!isN($p['up'])){ 
					$this->js .= "$.colorbox({href:\"".$this->_clrbx_img([ 't2'=>$this->tp, 't3'=>$this->gt->tsb, 'p'=>'nw' ])."\", width:\"400px;\", trapFocus:false, height:\"500px\", transition:\"elastic\", overlayClose:false, escKey:false, onClosed:function(){ }}); "; 
				}
				
				if($this->hb->ing == 'ok'){ $_html_b_in = $this->_btn([ 't'=>'in', 'id'=>$this->ls->btn->ing, 'ttc'=>$_ttc ]); }
				
				if($this->hb->upl == 'ok' && !isN($this->upl_f)){ 
					
					$_html_b_up = $this->_btn([ 't'=>'upl', 'id'=>$this->ls->btn->upl ]);
					
					if(!isN($this->up_o)){ $__up_u = $this->up_o; }else{ $__up_u = FL_FM_UP.'?'.__t($this->tp).$this->ls->vrall; }
					if(!isN($this->up_s)){ $__up_s_w = $this->up_s[0]; $__up_s_h = $this->up_s[1]; }else{ $__up_s_w = '800'; $__up_s_h = '400'; }
					
					$_up = '$.colorbox({  width:"'.$__up_s_w.'", height:"'.$__up_s_h.'", trapFocus:false, overlayClose: false, escKey:false, iframe:false, href:"'.$__up_u.'&__rnd="+Math.random() });'; 
					 
				}
				
				
				$_html = '<div class="'.ID_HDRLS.' '.$___mre.' _anm '.$this->cls_hdr.'" id="'.$this->id_hdr.'">'.$_t.'
						  	<div class="__hdr_btn _anm">'.
						  		$_html_hdrm.
						  		$_html_sch.
								$_html_dwn.
								$_html_b_rfr.  
						  		$_html_b_in.
						  		$_html_b_up.
						  	'</div>
						  </div>';
				
				$this->js .= $this->_btn_fnc([ 'i'=>$this->ls->btn->ing, 'f'=>$this->ls->hdr->ref ]). 
							 $this->_btn_fnc([ 'i'=>$this->ls->btn->dwn, 'f'=>$_dwn_f ]). 
							 $this->_btn_fnc([ 'i'=>$this->ls->btn->upl, 'f'=>$_up ]);	

				
			return($_html);
		}
		
		
		function _img_th($_p){
			
			$img = "<img id='".$_p['id']."' src='".$_p['src']."' style='max-width:".$_p['width']."; ".$_p['style']." ' ".$NmAl." ".$_p['more']." />";
			
			return $img;
		}
	
		
		function _ld_img($p=NULL){
		
			if(!isN($p['w'])){ $_w=$p['w']; }else{ $_w=30; }
			if(!isN($p['w'])){ $_pth=$p['pth']; }else{ $_pth='../../../'; } 
			
			$_pr = [	'id'=>'Nw_'.$p['i'], 
						'src'=>$p['s'], 
						'pth'=>$_pth, 
						'tm'=>'th_com', 
						'width'=>$_w, 
						'more'=>'onload="SUMR_Main.ld_imls(\''.$p['i'].'\'); "', 
						'style'=>'display:none;'
					];
					
			$_r = $this->_img_th($_pr);
			$_r .= "<div id='Old_".$p['i']."' class='Old".$p['c']."'></div>";
			
			return($_r);
		}
	
	
		public function _h_ls_img($p=NULL){
			
			if(!isN( $this->ls->rw[$this->img->f] )){
				$img_th = _ImVrs([ 'img'=>$this->ls->rw[$this->img->f], 'f'=>$this->img->dir, 'img_ste'=>$this->ls->rw[$this->ik] ]);
			}

			if($this->gt->tmpl=='cmz'){ $__img_go = $img_th->th_100; }
			elseif(!isN($p['sz'])){ $__img_go = $img_th->{ $p['sz'] }; }
			else{ $__img_go = $img_th->ste->th; }
			
		    return $this->_ld_img([ 
		    		's'=>$__img_go, 
					'i'=>$this->ls->rw[$this->ino].$this->id_rnd 
		    	]); 
					    
		}
		
		public function _h_ls_edit($p=NULL){
			
			if(!isN($p['tp'])){ $_tp=$p['tp']; }else{ $_tp=$this->tp; }
			if(!isN($p['ik'])){ $_ik=$p['ik']; }else{ $_ik=$this->ik; }
			if(!isN($p['cbx_grp'])){ $_cbxgrp=$p['cbx_grp']; }else{ $_cbxgrp=''; }

			if(($this->pop() && $this->sbl()) || $this->edit->pnl == 'ok'){ $_pnl='ok'; }
			//if($this->pnl() && !isN($this->bx_rld)){ $_pop='no'; $_pnl='no'; }else{ $_pop=$this->edit->pop; } //No se necesita con varios paneles ahora
			if(!isN($this->edit->pop) || $this->pnl()){ $_pop=$this->edit->pop; }

			if($p['up']=='ok'){ $_dr=FL_UP_GN; }
			elseif($p['up_fle']=='ok'){ $_dr = FL_FM_UP; $_w=400; $_h=255; }
			else{ $_dr=FL_LS_GN; }
										
			$_b = 	$this->_pgrg([ 
						'u'=>$_dr, 
						'c'=>(!isN($this->bx_rld)?$this->bx_rld:''),
						'mre'=>__t($_tp).$this->ls->vrall.ADM_LNK_DT.$this->ls->rw[$_ik], 
						'pop'=>$_pop,
						'w'=>(!isN($_w)?$_w:$this->edit->w), 
						'h'=>(!isN($_h)?$_h:$this->edit->h),
						'pnl'=>[
							'e'=>$_pnl
						],
						'scrl'=>$this->edit->scrl,
						'cbx_grp'=>$_cbxgrp
					]);
			
			return $_b;	
		}
		
		public function _h_ls_detail($p=NULL){
			
			if(($this->pop() && $this->sbl()) || $this->edit->pnl == 'ok'){ $_pnl='ok'; }
			//if($this->pnl() && !isN($this->bx_rld)){ $_pop='no'; $_pnl='no'; }else{ $_pop=$this->edit->pop; }
			if(!isN($this->edit->pop) || $this->pnl()){ $_pop=$this->edit->pop; }
			
			$_b = 	$this->_pgrg([ 
						'u'=>FL_DT_GN, 
						'c'=>(!isN($this->bx_rld)?$this->bx_rld:''),
						'mre'=>__t($this->tp).$this->ls->vrall.ADM_LNK_DT.$this->ls->rw[$this->ik], 
						'pop'=>$_pop,
						'w'=>(!isN($_w)?$_w:$this->edit->w), 
						'h'=>(!isN($_h)?$_h:$this->edit->h),
						'pnl'=>[
							'e'=>$_pnl
						],
						'scrl'=>$this->edit->scrl
					]);
			
			return $_b;	
		}
		
		
		public function _h_ls_form($p=NULL){
			
			if(!isN($p['tp'])){ $_tp=$p['tp']; }else{ $_tp=$this->tp; }
			if(!isN($p['ik'])){ $_ik=$p['ik']; }else{ $_ik=$this->ik; }
			if(!isN($p['cbx_grp'])){ $_cbxgrp=$p['cbx_grp']; }else{ $_cbxgrp=''; }
			
			if(($this->pop() && $this->sbl()) || $this->edit->pnl == 'ok'){ $_pnl='ok'; }
			//if($this->pnl() && !isN($this->bx_rld)){ $_pop='no'; $_pnl='no'; }else{ $_pop=$this->edit->pop; }							
			if(!isN($this->edit->pop) || $this->pnl()){ $_pop=$this->edit->pop; }

			$_b = 	$this->_pgrg([ 
						'u'=>FL_FM_GN, 
						'c'=>(!isN($this->bx_rld)?$this->bx_rld:''),
						'mre'=>__t($_tp).$this->ls->vrall.ADM_LNK_DT.$this->ls->rw[$_ik], 
						'pop'=>$_pop,
						'w'=>(!isN($_w)?$_w:$this->edit->w), 
						'h'=>(!isN($_h)?$_h:$this->edit->h),
						'pnl'=>[
							'e'=>$_pnl
						],
						'scrl'=>$this->edit->scrl,
						'cbx_grp'=>$_cbxgrp
					]);
			
			return $_b;	
		}
		
		
		public function _h_ls_nr($_i=NULL){
			if ($this->ls->tot == 0) {	echo '<div class="n_r">'.TX_NR.'</div>'; }else{ return false; } return($_r);
		}
	
		
		public function _h_ls($p=NULL){
		
			//------------ BUTTONS ID ------------//
			
				$this->ls->btn->dwn = BTN_INF.$this->id_rnd;
				$this->ls->btn->ing = BTN_INRG.$this->id_rnd;
				$this->ls->btn->upl = BTN_UPL.$this->id_rnd;
			
			//------------ SEARCH BOX ------------//
			
			
				if(isN($this->sch->e)){ $this->sch->e = 'ok'; }
			
			
			//------------ BUILD BOX ------------//
				
				if($this->pop()){ $_pnl='ok'; }
				if($this->pop() && $this->sbl()){ $_pnl='ok'; }
				//if($this->pnl() && !isN($this->bx_rld)){ $_pop='no'; $_pnl='no'; }else{ $_pop=$this->new->pop; }
				if(!isN($this->edit->pop) || $this->pnl()){ $_pop=$this->edit->pop; }

				if($this->new->up=='ok'){ $_dir=FL_FM_UP; }else{ $_dir=FL_LS_GN; }		
				
				if($this->pnl()){ $_pop='ok'; $_pnl_e='ok'; $_pnl_sw='ok'; $_pnl_ss='ok'; }
				
				$this->ls->rld = "	
									if(!isN( SUMR_Main.url['".$this->gt->plct."'] )){
										_ldCnt({ 
											u:SUMR_Main.url['".$this->gt->plct."'].lnk,
											c:SUMR_Main.url['".$this->gt->plct."'].box,
											pop:'".$_pop."',
											pnl:{
												e:'".$_pnl_e."',
												sw:'".$_pnl_sw."',
												ss:'".$_pnl_ss."',
												tp:'h'
											}
										});
									}
								";
								
									
				$this->ls->hdr->ref = $this->_pgrg([ 'u'=>$_dir, 
													 'c'=>$this->bx_rld,
													 'mre'=>__t($this->tp).TXGN_ING. $this->ls->vrall, 
													 'pop'=>$_pop, 
													 'pnl'=>[
														'e'=>$_pnl
													 ],
													 'w'=>$this->new->w, 
													 'h'=>$this->new->h,
													 'scrl'=>$this->new->scrl 
												]);
				
				if($this->gt->opnw == 'ok'){ $this->js .= $this->ls->hdr->ref; }
							
				$this->_sql([ 't'=>'ls' ]);		
				$this->_h_ls_qupgsi();
				$this->_h_ls_chck([ 't'=>'ls' ]); 
							
				if(!isN($this->tp) && $this->flt == 'ok'){ $this->ls->hdr->flt = '../../'.DIR_CNT_FLT.'_fl/'.$this->tp.'.php'; }
				$this->ls_html->hdr = $this->_h_ls_hdr();
				
		}
		
		
		public function _bld_f($p=NULL){

			$flt = dirname(__FILE__,5).'/'.DIR_CNT_FLT.$p['f'].$p['t'].'.php';

			if(!isN($flt) && file_exists($flt)){
				include_once($flt);
				echo $this->c_flt;
				echo $this->_c_flt_dte();
			}else{
				echo 'Not exists '.$flt;
			}

		}
		
		public function _show_f($p=NULL){

			if(!isN($this->ls->hdr->flt) /*&& file_exists($this->ls->hdr->flt)*/){
				
				if($this->f_on == 'ok'){ $cls = '_on'; }

				echo '<div class="_lsfltr '.$cls.'">';
				
				try{
					$this->_c_flt();
				} catch (Exception $e) {
				    superadm_echo($e->getMessage()) ;
				}
				
				echo '</div>';

			}

		}
		
		public function _pgbld(){

			if(!isN($this->gt->pgn)){ $this->ls->pg = $this->gt->pgn; } 
			$this->ls->st = $this->ls->pg*SIS_NMRG;
			
		}
		
		public function _bld($p=NULL){
			
			global $__cnx;
				
			$this->_pgbld();
			$this->_chkpml();
			
			if(!isN($this->ttm)){
				$this->tt .= ' '.$this->ttm;
			}
			
			//if(isN($this->flt)){ $this->flt = 'ok'; }
			
			if($this->gt->pr != "Dt" && $this->gt->pr != "Ing" && $this->qry->all != 'ok' ){
				if(!isN($this->ls->lmt)){ $__tot = $this->ls->lmt; }else{ $__tot = SIS_NMRG; }
				$this->qrys = sprintf("%s LIMIT %d, %d", $this->qrys, $this->ls->st, $__tot);
			}

			if($this->cnx->cl == 'ok'){ 
		        $this->_c_cnx([ 't'=>'cl' ]);
			}elseif($this->cnx->prc == 'ok'){ 
		        $this->_c_cnx([ 't'=>'prc' ]);
			}elseif($this->cnx->aut == 'ok'){ 
		        $this->_c_cnx([ 't'=>'aut' ]);	
			}else{ 
		        $this->_c_cnx([ 't'=>'main' ]);	
			}
			
			if(!isN($this->qrys)){ $this->sql = $__cnx->_qry($this->qrys, [ 'rst'=>'no' ] ); }		
			
			if(!isN($this->qrys_tot)){ $this->sql_tot = $__cnx->_qry($this->qrys_tot); } 
			
			
			if(!($this->sql) && ChckSESS_superadm()){ echo $__cnx->c_r->error; }
				
				
			
			if($this->ls->nxt->hb == 'ok'){ 
				$this->ls->nxt->id = 'rw_'.$this->tp.'_mod_'; 				
				$this->ls->nxt->cls = 'rw_'.$this->tp.'_mod'; 
			}
			
			if($this->gt->pr == "Dt" || $this->gt->pr == "Ing"){
				$this->_h_fm();
				$this->js .= JV_Blq();
			}else{
				$this->_h_ls();	
			}

		}
		
		public function _qtu($p=NULL){
			
			if($p['f'] == 'ok'){
				$_a = explode('_', $p['v']);
				if(count($_a) == 1){ 
					$_v = ucfirst($p['v']);
				}else{
					foreach($_a as $kgo=>$vgo){
						$_v .= ucfirst($vgo);
					}
				}
			}else{
				$_v = str_replace('_', '', $p['v']);
			}
			
			return($_v);
		}
	
		
		public function _strt($p=NULL){
			
			if(isN($this->ik)){ $this->ik = $this->_qtu([ 'v'=>$this->tp ]).'_enc'; }
			if(isN($this->ino)){ $this->ino = 'id_'.$this->_qtu([ 'v'=>$this->tp ]); }
			if(isN($this->nm)){ $this->nm = 'Ed'.$this->_qtu([ 'v'=>$this->tp, 'f'=>'ok' ]); }
			if(isN($this->img->f)){ $this->img->f= $this->_qtu([ 'v'=>(!isN($this->tpr)?$this->tpr:$this->tp) ]).'_img'; }
			if(isN($this->img->dir)){ 
				$fldr = 'DMN_FLE_'.strtoupper( (!isN($this->tpr)?$this->tpr:$this->tp) );
				if(defined($fldr)){
					$this->img->dir = _Cns($fldr); 
				}
			}
			
			if(!isN($this->img->svg) && $this->img->svg=='ok'){ $this->cls_hdr='svgi'; }
			
			if(isN($this->img->btn)){ $this->img->btn = BTN_IMG.$this->id_rnd; }
			
			if(isN($this->gbd->sch)){
				$__flt_dt = $this->_f_chk([ 't'=>$this->gt->t, 't2'=>$this->gt->tsb ]); 
				$this->gbd->sch = $__flt_dt->sch;
			}
			
			//-------------- SETUP ON SUCCESS   --------------//
			
			
				if($this->new->big == 'ok'){
					$this->new->w='95%';
					$this->new->h='95%';
				}else{	
					if(isN($this->new->w)){ $this->new->w = 400; }
					if(isN($this->new->h)){ $this->new->h = 600; }
				}
				
				
				if(isN($this->new->pop)){ $this->new->pop='ok'; }
			
			
			//-------------- SETUP ON EDIT   --------------//
			
				if($this->edit->big == 'ok'){
					$this->edit->w='95%';
					$this->edit->h='95%';
				}
				
				if(isN($this->edit->pop)){ $this->edit->pop='ok'; }
				if(isN($this->edit->scrl) || $this->new->scrl == 'ok'){ $this->edit->scrl = 'ok'; }
				if(isN($this->edit->w)){ 
					if(!isN($this->new->w)){ $this->edit->w = $this->new->w; }else{	$this->edit->w = '95%'; } 
				}
				if(isN($this->edit->h)){ 
					if(!isN($this->new->h)){ $this->edit->h = $this->new->h; }else{	$this->edit->h = '95%'; } 
				}
					
				if(!isN( $this->ing->vrall )){ foreach($this->ing->vrall as $_k=>$_v){ $this->ls->vrall .= $_v; }}
			
			//-------------- SETUP ON SUCCESS   --------------//
						
				if($this->pop() && isN($this->scc->pop) && isN($this->bx_rld)){ $this->scc->pop='ok'; }
					
				if(isN($this->scc->w)){ 
					
					if($this->edit->big == 'ok'){
						$this->scc->w='95%';
					}elseif(!isN($this->edit->w)){ 
						$this->scc->w = $this->edit->w; 
					}elseif(!isN($this->new->w)){ 
						$this->scc->w = $this->new->w; 
					}else{ 
						$this->scc->w = '95%'; 
					}
				}
				if(isN($this->scc->h)){ 
					
					if($this->edit->big == 'ok'){
						$this->scc->h='95%';
					}elseif(!isN($this->edit->h)){ 
						$this->scc->h = $this->edit->h; 
					}elseif(!isN($this->new->h)){ 
						$this->scc->h = $this->new->h; 
					}else{ 
						$this->scc->h = '95%';
					}
				}
				
				if(isN($this->scc->scrl)){ 
					if(!isN($this->new->scrl)){
						$this->scc->scrl = $this->new->scrl;
					}elseif(!isN($this->edit->scrl)){
						$this->scc->scrl = $this->edit->scrl;
					}else{
						$this->scc->scrl = 'no'; 
					}
				}	
			
			//-------------- SEARCH AND LOCK RELOAD  --------------//	
			
				$this->_sch();	
				$this->_bld_f_q();
					
				if(_SbLs_ID('i')){ 
					$__jqte = 'jqte_pop'.$__prfx_fm;
					$this->js .= JV_HtmlEd($__jqte);
				}

		}
		
	
		
		public function _bld_l_grph($p=NULL){
			
			if(!isN($this->grph) && $this->grph->tot > 0){
				
				if($this->grph->h == 'mny'){ $_itm_c = '__bl _mny'; }else{ $_itm_c = '__bl'; }
				
				for ($i = 1; $i <= $this->grph->tot; $i++) {	
					$_html .= '	<div class="item _anm">
									<input type="button" class="_hs _anm" OnClick="SUMR_Main.grph.fltr(\'bx_grph_'.$this->id_rnd.'_'.$i.'\');" value=""/>
									<div id="bx_grph_'.$this->id_rnd.'_'.$i.'" class="'.$_itm_c.' _anm"></div>
								</div>
							';
				}  
			    $_html_r = '<div id="__grph_crsl_'.$this->id_rnd.'" class="owl-carousel owl-theme owl-ls-empty _anm">'.$_html.'</div>';
			    
			    $this->js .= '	SUMR_Main.ld.f.owl( function(){
									SUMR_Main.ld.f.knob( function(){
										$("#__grph_crsl_'.$this->id_rnd.'").owlCarousel({
											items:1,
											nav:true,
											autoHeight: false,
											autoHeightClass:"owl-height"
										});
									});	
								});';		
		    }
		    
		    return $_html_r;
		}
		
		public function _bld_l_no_data($p=NULL){

		    $_html_r = '
		    	<section class="_cvr" style="background-color:#cbf0fd;">
					<iframe src="'.DMN_ANM.'nodata/index.html" frameborder="0" width="100%" scrolling="no" height="300"></iframe>			
				</section>';

		    return $_html_r;
		}			

		
		public function _bld_l_hdr($p=NULL){
			
			echo $this->ls_html->hdr;

			if(!isN($this->anm_no_data) && $this->anm_no_data == 'ok'){
				if($this->ls->tot > 0){
					echo $this->_bld_l_grph();	
				}else{
					echo $this->_bld_l_no_data();	
				}	
			}else{
				echo $this->_bld_l_grph();	
			}

			$this->_show_f();
		}
		
		
		
		public function _bld_f_hdr($p=NULL){
			$_html .= $this->fm_html->hdr;
			echo $_html;
		}
		
		
		public function _bld_l_pgs($p=NULL){
			$_html .= $this->ls_html->pgs;
			echo $_html;
		}


		public function _bld_cllps($p=NULL){
			
			if(!isN($p['k'])){ $_key=$p['k']; }else{ $_key=Gn_Rnd(10); }
			if(!isN($p['o'])){ $_opn=$p['o']; }else{ $_opn='false'; }

			$_html_r = '
				<div id="Fm_CTab_'.$_key.'_'.$this->id_rnd.'" class="CollapsiblePanel '.$p['cls'].'">
					<div class="CollapsiblePanelTab _anm">'.$p['tt'].'</div>
					<div class="CollapsiblePanelContent">'.$p['c'].'</div>
				</div>
			';

			$this->js .= 'var Fm_CTab_'.$_key.'_'.$this->id_rnd.' = new Spry.Widget.CollapsiblePanel("Fm_CTab_'.$_key.'_'.$this->id_rnd.'", {contentIsOpen:'.$_opn.'});';			

			return $_html_r;
			
		}

		public function inp_chk($p=null){

			if(!isN($p['id'])){ $_id= ' id="'.$p['id'].'" '; }
			if(!isN($p['attr'])){ 
				foreach($p['attr'] as $attr_k=>$attr_v){
					$_attr .= ' '.$attr_k.'="'.$attr_v.'" '; 
				}
			}

			if($p['t'] == 'd1'){
				$_html = '
					<div class="pretty p-svg p-curve p-jelly p-smooth p-pulse">
						<input type="checkbox" '.$_id.' '.$_attr.' />
						<div class="state p-success">
							<!-- svg path -->
							<svg class="svg svg-icon" viewBox="0 0 20 20">
								<path d="M7.629,14.566c0.125,0.125,0.291,0.188,0.456,0.188c0.164,0,0.329-0.062,0.456-0.188l8.219-8.221c0.252-0.252,0.252-0.659,0-0.911c-0.252-0.252-0.659-0.252-0.911,0l-7.764,7.763L4.152,9.267c-0.252-0.251-0.66-0.251-0.911,0c-0.252,0.252-0.252,0.66,0,0.911L7.629,14.566z" style="stroke: white;fill:white;"></path>
							</svg>
							<label></label>
						</div>
					</div>
				';
			}

			return $_html;

		}


		public function qta($p=null){

			global $__cnx;

			if(!isN($p['q'])){

				$Ls = $__cnx->_qry($p['q']);

				if($Ls){

					$row = $Ls->fetch_assoc(); 
					$tot = $Ls->num_rows; 	
					
					if($tot > 0){
						do {   
							$_rsp['ls'][] = $row;        
						} while ($row = $Ls->fetch_assoc());
					}
					
				}else{
		
					$rsp['w'][] = $__cnx->c_r->error;
		
				}

				$__cnx->_clsr($Ls);

			}

			return _jEnc($_rsp);

		}

	} 
  
?>