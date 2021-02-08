<?php
if(class_exists('CRM_Cnx')){

	$___Ls->tt = TX_SISSLC;
	$___Ls->ik = 'sisslc_enc';
	
	$___Ls->ino = 'id_sisslc';
	$___Ls->tt = _Cns('TX_RCRDS');
	$___Ls->img->dir = DIR_FLE_SIS_SLC;
	$___Ls->sch->f = 'sisslc_tt, sisslctp_key';
	$___Ls->edit->bg = 'ok';
	$___Ls->ls->lmt = 1000;
	
	if($___Ls->gt->tsb == 'cl'){ 
		
		$__bd = TB_CL_SLC; 
		$__bd2 = TB_CL_SLC_F;
		$__bd3 = TB_CL_SLC_TP_F;
		$__bd4 = TB_CL_SLC_TP;
		
		$cl = 'ok';
		$___Ls->cnx->cl = 'ok';
		
	}else{
		
		$__bd = TB_SIS_SLC; 
		$__bd2 = TB_SIS_SLC_F;
		$__bd3 = TB_SIS_SLC_TP_F;
		$__bd4 = TB_SIS_SLC_TP;
		
		$cl = 'no';
		
	}		
	
	
	
	if(!ChckSESS_superadm()){ $__fl .= _AndSql('id_us', SISUS_ID); }
	
	$___Ls->_strt();
	
	if(!isN($___Ls->gt->i)){	
		
		$___Ls->qrys = sprintf("SELECT * 
								FROM $__bd 
									 INNER JOIN $__bd4 ON sisslc_tp = id_sisslctp
								WHERE ".$___Ls->ik." = %s 
								LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));
		
	}elseif($___Ls->_show_ls == 'ok'){  
		
		$Ls_Whr = "	FROM $__bd 
						 INNER JOIN $__bd4 ON sisslc_tp = id_sisslctp
						 
					WHERE ".$___Ls->ino." != '' AND sisslc_tp = (	SELECT id_sisslctp 
																	FROM ".$__bd4." 
																	WHERE sisslctp_enc = ".GtSQLVlStr($___Ls->gt->isb, "text").")
							".$___Ls->sch->cod." 
					ORDER BY sisslc_tt ASC, sisslc_tt DESC";
					
		$___Ls->qrys = "SELECT *, 
						
						(SELECT
								GROUP_CONCAT(
									
									JSON_OBJECT(	
										'id', IF(id_sisslcf IS NULL, '', id_sisslcf),
										'f', IF(sisslcf_f IS NULL, '', sisslcf_f), 
										'tp', IF(sisslctpf_tt IS NULL, '', sisslctpf_tt), 
										'tp_i', IF(id_sisslctpf IS NULL, '', id_sisslctpf) , 
										'tp_ord', IF(sisslctpf_ord IS NULL, '', sisslctpf_ord) , 
										'vl', IF(sisslcf_vl IS NULL, '', sisslcf_vl)
									)
									
									SEPARATOR ','
									
								)	
								
						   FROM $__bd2
						   		INNER JOIN $__bd3 ON sisslcf_f = id_sisslctpf
						   		
						   WHERE sisslcf_slc = id_sisslc
						   ORDER BY sisslctpf_ord ASC
						) AS ___fld,
	 
					(SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." 
					$Ls_Whr"; 
	} 

$___Ls->_bld(); 
	
?>
<?php if($___Ls->ls->chk=='ok'){ ?>
<?php $___Ls->_bld_l_hdr(); ?>
<?php if(($___Ls->qry->tot > 0)){ ?>
<?php $___col_v = GtSlcF_Ls([ 'id'=>$___Ls->ls->rw['id_sisslc'], 'tp'=>$___Ls->gt->isb, 'cl'=>$cl ]); ?>

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg list_sis_slc_f">
 	<tr>
    	<th width="1%" <?php echo NWRP ?>></th>
    	<th width="1%" <?php echo NWRP ?>></th>
		<th width="1%" <?php echo NWRP ?>><?php echo TX_FM_No ?></th>
		<th width="1%" <?php echo NWRP ?>><?php echo TX_ORD ?></th>
		<th width="49%" <?php echo NWRP ?>><?php echo TX_TT; ?></th>
		<?php //print_r($___col_v);?>
		
		
		<?php foreach($___col_v->ls as $_k=>$_v){ 
				if($_v->tpd->id != 11 && $_v->tpd->id != 10 && $_v->tpd->id != 7 ){ ?>
					
					<th width="1%" <?php echo NWRP ?>><?php echo $_v->tp->tt ?></th>	
				
				<?php } ?> 
		<?php } ?>
		<th width="1%" <?php echo NWRP ?>></th>
  	</tr>
  	<?php do { ?>
  	<?php 
	  
		$___col = CG_Array([ 'f'=>$___Ls->ls->rw['___fld'], 'k'=>'f' ]);
		$__tt_img = fgr('<img src="'.DMN_FLE_SIS_SLC.$___Ls->ls->rw['sisslc_img'].'">'); 
	  	
  	?>
  	<tr>
		<td width="1%" align="left" style="text-align:center !important; background-color:<?php if($cl == 'ok'){ echo 'var(--main-bg-color)'; }else{ echo 'gray'; } ?>; "><?php echo $__tt_img; ?></td>  
		<td width="1%" align="left" nowrap="nowrap" class="_btn"><?php echo $___Ls->_btn([ 't'=>'mod' ]); ?></td>      
		<td width="1%" <?php echo NWRP ?>><?php echo Spn($___Ls->ls->rw[$___Ls->ino]); ?></td>
		<td width="1%" <?php echo NWRP ?>><?php echo Spn($___Ls->ls->rw['sisslc_ord']); ?></td>
	    <td width="49%" align="left" nowrap="nowrap">
		    <?php 
			    echo /*ShortTx(*/ ctjTx($___Ls->ls->rw['sisslc_tt'],'in') /*,40,'Pt', true)*/;
			    
			    if(!isN($___Ls->ls->rw['sisslc_cns'])){
				    
			    	echo h1(strtoupper( 'ID_'.str_replace('_','',$___Ls->ls->rw['sisslctp_key']).'_'.ctjTx($___Ls->ls->rw['sisslc_cns'],'in') ), 'id_cns'); 
			    
			    }
			?>
	    </td>
	    
	    <?php foreach($___col_v->ls as $_k=>$_v){
	    		if($_v->tpd->id != 11 && $_v->tpd->id != 10 && $_v->tpd->id != 7 ){ ?>
	 				<td width="1%" align="center" nowrap="nowrap">
						<?php 
							if($___col != ''){ 
								if($_v->tpd->id == 9){
									$_e = mBln($___col->{$_v->tp->id}->vl);
									echo Spn($_e,'',$_e);
								}else{
									echo ctjTx($___col->{$_v->tp->id}->vl,'in'); 
								}
							} 
						?>
		    		</td>	
				<?php } ?> 
		<?php } ?> 
		<td width="1%" align="left" nowrap="nowrap"></td>
		
  	</tr>
  <?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>
</table>
<style>
	
	.list_sis_slc_f .id_cns{ text-transform: uppercase; font-style: italic; font-size: 11px; font-weight: 400; font-family: Economica; color: #bcc3c5; margin: 0; width: 100%; padding: 0; border: none; }
	
</style>


<?php $___Ls->_bld_l_pgs(); ?>
<?php } ?>
<?php $___Ls->_h_ls_nr(); ?>
<?php } ?>
<?php if($___Ls->fm->chk=='ok'){ ?>
<div class="FmTb">
  	<div id="<?php echo $___Ls->fm->bx->id ?>" class="<?php echo DV_GNR_FM_BX ?>" >
    <form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>" >
      <?php $___Ls->_bld_f_hdr(); ?>

      <div id="<?php echo $___Ls->fm->fld->id ?>" >
        <?php
	        
			    
			    $__Cl = new CRM_Cl();
				$__Rnd = Gn_Rnd(20);
				
				$CntJV .= " 
				
				__sisslc_bx_cl = $('#bx_cl_".$__Rnd."');
				__sisslc_bx_mdl_s = $('#bx_mdl_s_".$__Rnd."');				
				
				function MdlSTp_Dom_Rbld(){
					
					var __sisslc_bx_cl_itm = $('#bx_cl_".$__Rnd." > li.itm.cl ');	
					var __sisslc_bx_cl_itm_cdata = $('#bx_cl_".$__Rnd." > li.itm.cl button.csdata');		
					var __sisslc_bx_mdl_s_itm = $('#bx_mdl_s_".$__Rnd." > li.itm.mdl_s ');
					
					
					__sisslc_bx_cl_itm.not('.sch, .nosnd').off('click').click(function(e){
						
						/*e.preventDefault();

						if(e.target != this){
							
							e.stopPropagation(); return;
						
						}else{*/

							$(this).hasClass('on') ? est = 'del' : est = 'in'; 	
							var _id = $(this).attr('rel');
							
							_Rqu({ 
								t:'sis_slc_f', 
								d:'cl',
								est: est,
								_id_cl : _id,
								_id_sisslc : '".Php_Ls_Cln($___Ls->gt->i)."',
								_bs:function(){ __sisslc_bx_cl.addClass('_ld'); },
								_cm:function(){ __sisslc_bx_cl.removeClass('_ld'); },
								_cl:function(_r){
									if(!isN(_r)){
										if(!isN(_r.cl)){
											SisSlcSet(_r.cl);			
										}
									}
								} 
							});

						/*}*/
					});
					
					__sisslc_bx_mdl_s_itm.not('.sch, .nosnd').off('click').click(function(){
						
						$(this).hasClass('on') ? est = 'del' : est = 'in'; 	
						var _id = $(this).attr('rel');
						
						_Rqu({ 
							t:'sis_slc_f', 
							d:'mdlstp',
							est: est,
							_id_mdlstp : _id,
							_id_sisslc : '".Php_Ls_Cln($___Ls->gt->i)."',
							_bs:function(){ __sisslc_bx_mdl_s.addClass('_ld'); },
							_cm:function(){ __sisslc_bx_mdl_s.removeClass('_ld'); },
							_cl:function(_r){
								if(!isN(_r)){
									if(!isN(_r.cl)){
										SisSlcSet(_r.cl);			
									}
								}
							} 
						});
						
					});
					

					__sisslc_bx_cl_itm_cdata.not('.sch, .nosnd').off('click').click(function(e){
						
						e.preventDefault();

						if(e.target != this){	
							e.stopPropagation(); return;
						}else{

							_ldCnt({ 
								u:'".Fl_Rnd(FL_LS_GN.__t('sis_slc_f_cl',true)).Fl_i($___Ls->dt->rw[$___Ls->ino])."',  
								pop:'ok',
								pnl:{
									e:'ok',
									tp:'h',
									s:'l'
								},
								scrl:'ok',
								cls:'_fll'
							});

						}

					});


					SUMR_Main.LsSch({ str:'#cl_sch_".$__Rnd."', ls:__sisslc_bx_cl_itm });
					SUMR_Main.LsSch({ str:'#mdl_s_sch_".$__Rnd."', ls:__sisslc_bx_mdl_s_itm });
					
				}
				
				function SisSlcF_Html(){
					__sisslc_bx_cl.html('');
					__sisslc_bx_cl.append('<li class=\"sch\">".HTML_inp_tx('cl_sch_'.$__Rnd, TX_SEARCH, '')."<button class=\"_new _anm\" new-tp=\"cl\"></button></li>');
					
					$.each(_sisslc['ls'], function(k, v) { 
						
						if(!isN(v.tot) && !isN(v.tot.sisslc) && v.tot.sisslc > 0){ var _cls = 'on'; }else{ var _cls = 'off'; }
						
						if(!isN(v.img)){
							if(!isN(v.img.sm_s)){ img=v.img.sm_s; }else{ img=v.img; }
						}else{ 
							img=''; 
						}
						
						if(!isN(v.clr)){ var _bclr = v.clr; }else{ var _bclr = ''; }
						
						__sisslc_bx_cl.append('<li class=\"_anm itm cl '+_cls+'\" cl-id=\"'+v.enc+'\" rel=\"'+v.enc+'\" style=\"background-color:'+_bclr+'\">
													<figure style=\"background-image:url('+img+')\" class=\"_bg\"></figure>
													<span>'+v.nm+'</span>
													<button class=\"csdata _anm\"></button>
												</li>');
					});	
					
					MdlSTp_Dom_Rbld();
				}
				
				
				
				function SisSlcMdlS_Html(){
					
					
					try{
						
						__sisslc_bx_mdl_s.html('');
						__sisslc_bx_mdl_s.append('<li class=\"sch\">".HTML_inp_tx('mdl_s_sch_'.$__Rnd, TX_SEARCH, '')."<button class=\"_new _anm\" new-tp=\"cl\"></button></li>');
						
						if(!isN(_sisslcmdl) && !isN(_sisslcmdl['ls'])){
							
							$.each(_sisslcmdl['ls'], function(k, v) { 
			
								if(!isN(v.__est) && v.__est > 0){ var _cls = 'on'; }else{ var _cls = 'off'; }
								
								if(!isN(v.img)){ if(!isN(v.img.sm_s)){ img=v.img.sm_s; }else{ img=v.img; } }else{  img=''; }
			
								__sisslc_bx_mdl_s.append('<li class=\"_anm itm mdl_s '+_cls+'\" cl-id=\"'+v.enc+'\" rel=\"'+v.enc+'\">
															<figure style=\"background-image:url('+img+')\" class=\"_bg\"></figure>
															<span>'+v.nm+'</span>
														</li>');
							});	
						
						}
						
						MdlSTp_Dom_Rbld();
					
					
					}catch(e) {
						
						SUMR_Main.log.f({ t:'Error:', m:e });
						
					}
					
				}
		
				
				
				";
				
				$CntJV .= "	
					
					function SisSlcSet(p){
						if( !isN(p) ){	
							_sisslc = {};
							_sisslcmdl = {};
							if( !isN(p.sisslc.cl) ){ _sisslc['ls'] = p.sisslc.cl.ls; _sisslc['tot'] = p.sisslc.cl.tot; }
							if( !isN(p.sisslc.mdls) ){ _sisslcmdl['ls'] = p.sisslc.mdls.ls; _sisslcmdl['tot'] = p.sisslc.mdls.tot; }

							SisSlcF_Html();
							SisSlcMdlS_Html();
						}
					}
				
				
					
			";
			
			if($___Ls->dt->tot > 0){
			
				$CntJV .= " 

					_Rqu({ 
						t:'sis_slc_f', 
						_id_sisslc : '".Php_Ls_Cln($___Ls->gt->i)."',
						_cl:function(_r){
							if(!isN(_r)){
								if(!isN(_r.cl)){
									SisSlcSet(_r.cl);			
								}
							}
						} 
					});
					
				";
				
			}
				
			
		?>
        
        
        <div class="ln_1 sisslcf_dsh dsh_cnt">
          <div class="col_1 _c _anm _scrl">
	          
	        <?php 
			  	$___Ls->_dvlsfl_all([
					['n'=>'us_mdl', 'l'=>'Modulo', 'bimg'=>'']
				]);
			?>
			<?php 
				$_id_tbpnl = 'TabPnl_'.Gn_Rnd(20);
				 $CntWb .= " SUMR_Main.bxajx.".$_id_tbpnl." = new Spry.Widget.TabbedPanels('".$_id_tbpnl."' {$_tb_dfl}); "; 
				$CntWb .= _DvLsFl([ 'i'=>$___Ls->tb->eml ]);  
			?>
			<div style="width: 100%;" id="<?php echo $_id_tbpnl ?>" class="VTabbedPanels TbGnrl mny tab_slc">
	          	<ul class="TabbedPanelsTabGroup">
		            <?php echo $___Ls->tab->bsc->l ?>
		            <?php echo $___Ls->tab->us_mdl->l ?> 
	          	</ul>
			  	<div class="TabbedPanelsContentGroup">
	            	<div class="TabbedPanelsContent">
			           	<div class="_wrp">
				           	<?php echo h2( TX_CL ); ?>
					    	<ul id="bx_cl_<?php echo $__Rnd; ?>" class="_ls dls _anm"></ul>	 
					    	<div class="_new_fm" id="bx_fm_cl_<?php echo $__Rnd; ?>"></div>  
					    </div>  	   
	            	</div>
					<div class="TabbedPanelsContent">
	                	<div class="_wrp">
				           	<?php echo h2( MDL_S_TP ); ?>
					    	<ul id="bx_mdl_s_<?php echo $__Rnd; ?>" class="_ls dls _anm"></ul>	
					    </div>
		            </div>
	          	</div>   	  
        	</div>
			
			
				
          </div>
          <div class="col_2">
			  
			<?php echo h1(strtoupper( 'ID_'.str_replace('_','',$___Ls->dt->rw['sisslctp_key']).'_'.ctjTx($___Ls->dt->rw['sisslc_cns'],'in') )); ?>		
	        <?php echo HTML_inp_tx('sisslc_tt', TX_CON_TT , ctjTx($___Ls->dt->rw['sisslc_tt'],'in'), FMRQD); ?>
			<?php echo HTML_inp_tx('sisslc_cns', 'Id '.TX_CNST , ctjTx($___Ls->dt->rw['sisslc_cns'],'in')); ?>
			<?php echo HTML_inp_tx('sisslc_ord', TX_ORD , ctjTx($___Ls->dt->rw['sisslc_ord'],'in')); ?>
		  	<?php 	  	
			  	
			  	if(!isN($___Ls->gt->isb)){
				  	echo HTML_inp_hd("sisslc_tp", $___Ls->gt->isb);
				}else{  	
			  		echo LsSisSlcTp('sisslc_tp','id_sisslctp', $___Ls->dt->rw['sisslc_tp'], TX_SLCTP, 1); $CntWb .= JQ_Ls('sisslc_tp',TX_SLCTP); 
			  	}
			  	
			  	$___col_v = GtSlcF_Ls([ 'id'=>$___Ls->dt->rw['id_sisslc'], 'tp'=>$___Ls->gt->isb, 'cl'=>$cl ]);
		        
	          	if($___col_v->e == 'ok'){
		          	
		          	foreach($___col_v->ls as $_k=>$_v){ 
			          	
			         	echo HTML_inp_hd("sisslc_fld[".$_v->tp->key."][id]", $_v->id);
			         	echo HTML_inp_hd("sisslc_fld[".$_v->tp->key."][tp][id]", $_v->tp->id);
			         	echo HTML_inp_hd("sisslc_fld[".$_v->tp->key."][vl][c]", $_v->tpd->sqv);
			         	echo HTML_inp_hd("sisslc_fld[".$_v->tp->key."][tpd_vl]", $_v->tpd->id);
			       	
			         	$___id_fld = "sisslc_fld[".$_v->tp->key."][vl][v]";		   
			         	
			         	
			         	if($_v->tpd->id == 10){ 
				         	$__vl = $_v->vl; 
				        }else{ 
					        $__vl = $_v->vl;
					    }

						
			         	if($_v->tpd->id == 6){		         	
				         	echo h3(_Cns($_v->tp->cns)).HTML_inp_clr([ 'id'=>$___id_fld, 'plc'=>_Cns($_v->tp->cns), 'vl'=>$__vl, 'v'=>$_v->icls ]); 
			         	}elseif($_v->tpd->id == 4){
				          	echo SlDt([ 'id'=>$___id_fld, 'va'=>$__vl, 'rq'=>'ok',  'ph'=>_Cns($_v->tp->cns), 'lmt'=>'no',  'scls'=>'_clndr_on', 'cls'=>CLS_CLND.' _clndr_on' ]);
			         	}elseif($_v->tpd->id == 9){	
				         	echo OLD_HTML_chck($___id_fld, _Cns($_v->tp->cns), $__vl, 'in');	
				        }elseif($_v->tpd->id == 7){     	
				         	echo HTML_textarea($___id_fld, _Cns($_v->tp->cns), $__vl, $_v->icls, 'ok', '_htmlc');	
				        }elseif($_v->tpd->id == 11){ 	
				         	echo HTML_textarea($___id_fld, _Cns($_v->tp->cns), $__vl, $_v->icls);	
				        }elseif($_v->tpd->id == 10){
					        
					        $__id_edtr_1 = '__my_e_'.Gn_Rnd(10);
					        $__id_bxcmrr = 'sisslc_fld_code_'.Gn_Rnd(10);
					        
					        
					    ?>
					        
						        
					        <?php echo HTML_BR; ?>
					        <a class="vw_qry"></a>
					        <div class="div_qry">
						        <div class="div_qry_cde">
									<?php echo HTML_textarea($___id_fld, _Cns($_v->tp->cns), $__vl, '', '', '_cls_slc', 2, '', '', '', ['cid'=>$__id_bxcmrr] );  ?>
						        </div>
						        <div class="div_qry_btf"></div>
					        </div>

					          
					        <?php
					        
					        $CntWb .= ' 
					        
								SUMR_Main.ld.f.cdmrr(function(){			
									$("._cls_slc").delay(1000).fadeIn("slow", function(){
			    						var '.$__id_edtr_1.' =  CodeMirror.fromTextArea(document.getElementById("'.$__id_bxcmrr.'"), {
				    											lineNumbers: true,
															    styleActiveLine: true,
															    theme:"solarized dark",
															    matchBrackets: true,
															    viewportMargin: Infinity
															});				
										'.$__id_edtr_1.'.on("change", function('.$__id_edtr_1.', change) {
											$("#'.$__id_bxcmrr.'").html( '.$__id_edtr_1.'.getValue() );
										});	
									});
								});
				
								function ___ld_my_g(){			   	
								   	var _f = $("._cls_slc").val();
								    var _p = {};
									if(_f_b != \'\' && _f_b != "undefined" && _f_b != null){ eval(_f_b); }
								    _p.id = \'#test_g\';
								    
								    '.$__li_chr_f.'
								    
								    if(_f != \'\' && _f != "undefined"  && _f != null){ 	
										eval(_f);
										if(_f_a != \'\' && _f_a != "undefined" && _f_a != null){ eval(_f_a); }
									}
							   	}
						     										
								$(".vw_qry").off("click").click(function(){
									
									var qry_sql =  $("._cls_slc").val();
									
									if(!$(".div_qry").hasClass("_vw")){
										$(".div_qry").addClass("_vw");
										$(".vw_qry").addClass("_edt");
										
										SUMR_Main.ibx["_qry"] =$.ajax({
															type:"POST",
															url: "'.Fl_Rnd(FL_JSON_GN.__t("sql_btf",true)).'",
															data: {
																"qry_sql": qry_sql
															  },
															beforeSend: function() {  
															},
															success:function(p){
																SUMR_Main.ibx["_qry"] = "";
																if(p.e == "ok"){
																	$(".div_qry_btf").html(p.qry_btf);
																}
															}
													});	
									}else{
										$(".div_qry").removeClass("_vw");
										$(".vw_qry").removeClass("_edt");
									}
								});		
							';		
						    
			         	}else{
			         		echo HTML_inp_tx($___id_fld, _Cns($_v->tp->cns) , $__vl, $_v->icls );
			         	}
			        }
				}else{ 
					echo h2( TX_NOFLDATTCH ); 
				} 
				
				
				$CntWb .= JV_HtmlEd('_htmlc');
			?>
			<ul class="upl_img_opt">
				<li><button class="_anm upl_img upl_bck" id="<?php echo 'upl_bck_'.$___Ls->fm->id; ?>"> <span class="_anm">Background</span></button></li>
			</ul>
			<?php 				
				$_f = HTML_ClrBxImg('sis_slc_f_bck').$___Ls->uidn;
				$CntWb .= $___Ls->_h_fm_img([ 'b'=>'upl_bck_'.$___Ls->fm->id, 'u'=>$_f ]);
			?>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>

<style>
			
.tab_slc.VTabbedPanels > .TabbedPanelsTabGroup .TabbedPanelsTab{ background-repeat: no-repeat; background-position: center center; background-size: 60% auto; height: 40px; border: 1px solid #767777; opacity: 0.4; max-width: 40px; }
.tab_slc.VTabbedPanels .TabbedPanelsTab._bsc{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>cnt_dtl.svg); }
.tab_slc.VTabbedPanels .TabbedPanelsTabSelected._bsc{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>cnt_dtl_w.svg); }
.tab_slc.VTabbedPanels .TabbedPanelsTab._us_mdl{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>modules.svg); }
.tab_slc.VTabbedPanels .TabbedPanelsTabSelected._us_mdl{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>modules_w.svg); }

.div_qry{display:block;margin-top:10px}
.div_qry .div_qry_cde{display:block!important;min-height:300px}
.div_qry .div_qry_btf{display:none!important}
.div_qry._vw .div_qry_cde{display:none!important}
.div_qry._vw .div_qry_btf{display:block!important;min-height:290px}
.div_qry._vw{display:block;margin-top:10px;border:0 solid;font-size:14px;padding-left:10px}
.vw_qry{display:block;text-align:center;text-align:center;width:37%;background-image:url('<?php echo DMN_IMG_ESTR_SVG ?>mysql.svg');color:#a9a9a9!important;text-transform:uppercase;font-family:Economica;font-size:12px;font-weight:300;margin-right:10px;border-radius:20px 20px 20px 20px;-moz-border-radius:20px;-webkit-border-radius:20px 20px 20px 20px;background-color:#fff;margin-left:auto;margin-right:auto;padding:10px 35px;text-decoration:none!important;background-size:25px auto;background-position:10px center;background-repeat:no-repeat;border:1px solid #bbb!important;white-space:nowrap;background-color:transparent!important;margin-top:30px}
.vw_qry::before{content:"<?php echo  TX_FRMT.' '.TXT_SQL; ?>"}
.vw_qry:Hover{color:#000!important;text-decoration:none;border:1px solid #232323;background-color:#fff;cursor:pointer}
.vw_qry._edt{background-size:20px auto;background-image:url('<?php echo DMN_IMG_ESTR_SVG ?>scl_edt.svg')!important}
.vw_qry._edt::before{content:"<?php echo TX_EDT.' '.TXT_SQL; ?>"}
.sisslcf_dsh ul.dls{margin-top:0!important;padding-top:0!important;padding-left:3px!important}
.tab_slc ._wrp{ position: relative !important }
.tab_slc.VTabbedPanels.mny ul li.TabbedPanelsTab{width: 30px !important;height: 30px !important; }
.tab_slc .itm span {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    width: 100%;
    display: block;
    position: relative;
    text-align: center;
}
</style>	



<?php } ?>
<?php } ?> 
