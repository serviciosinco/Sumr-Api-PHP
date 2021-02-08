<?php
if(class_exists('CRM_Cnx')){
	
	if($___Ls->gt->tsb == 'cl'){ 
		
		$___Ls->cnx->cl = 'ok'; 
		$__bd = TB_CL_SLC_TP;
		$__sub = 'sis_slc_tp_f';
		$__sub2 = 'sis_slc_f';
		$___Ls->tp = 'sis_slc_tp';
	
	}else{
	
		$__bd = TB_SIS_SLC_TP;
		$__sub = 'sis_slc_tp_f';
		$__sub2 = 'sis_slc_f';
	
	}
	
	$___Ls->flt = 'ok';
	$___Ls->img->dir = DMN_FLE_SIS_SLC_TP;
	$___Ls->tt = MDLSIS_SLC;
	$___Ls->sch->f = 'sisslctp_tt, sisslctp_key';
	$___Ls->new->w = 1200;
	$___Ls->new->h = 800;
	$___Ls->ls->lmt = 1000;
	$___Ls->_strt();
	
	if(!isN($___Ls->gt->i)){	
		
		$___Ls->qrys = sprintf("SELECT * FROM $__bd WHERE ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));

	}elseif($___Ls->_show_ls == 'ok'){ 
		
		if(!isN($___Ls->_fl->fk->cl_enc)){ 

			if(is_array($___Ls->_fl->fk->cl_enc)){
				$__all_are = implode(',', $___Ls->_fl->fk->cl_enc);
			}else{
				$__all_are = "'".$___Ls->_fl->fk->cl_enc."'";
			}
			
			$___Ls->qry_f = ' AND id_sisslctp IN ( SELECT sisslctpcl_sisslctp
										FROM '.TB_SIS_SLC_TP_CL.' 
											 INNER JOIN '.TB_CL.' ON sisslctpcl_cl = id_cl
										WHERE cl_enc IN ('.$__all_are.')
									) ';							
		}

		$Ls_Whr = "FROM $__bd WHERE ".$___Ls->ino." != '' ".$___Ls->qry_f." ".$___Ls->sch->cod." ORDER BY sisslctp_tt ASC, sisslctp_tt DESC";
		$___Ls->qrys = "SELECT *, (SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." $Ls_Whr";

	} 

	$___Ls->_bld(); 
	
?>
<?php if($___Ls->ls->chk=='ok'){ ?>

<?php $___Ls->_bld_l_hdr(); ?>
<?php if(($___Ls->qry->tot > 0)){ ?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
  	<tr>
    	<th width="1%" <?php echo NWRP ?>><?php echo TX_FM_No ?></th>
    	<th width="1%" <?php echo NWRP ?>></th>
		<th width="49%" <?php echo NWRP ?>><?php echo TX_SISSLC ?></th>
		<th width="49%" <?php echo NWRP ?>><?php echo TX_TP ?></th>
		<th width="1%" <?php echo NWRP ?>><?php echo TX_KEY ?></th>
		<th width="1%" <?php echo NWRP ?>></th>
  	</tr>
  	<?php do { ?>
	<?php 
	
		$__mnu_o = GtSisSlcTpCl_Ls([ 'sisslctp'=>$___Ls->ls->rw['id_sisslctp'] ]);
		$__cl = ''; 
	
		foreach($__mnu_o->ls as $_mnucl_k=>$_mnucl_v){
			$__cl .= '<li style="background-image:url('.$_mnucl_v->cl->img->th_50.');" 
			alt="'.ctjTx( $_mnucl_v->cl->nm ,'in').'" 
			title="'.ctjTx( $_mnucl_v->cl->nm ,'in').'"> </li>' ;
		}			

	?>	
  	<tr>    	
	  	<?php if(!isN($___Ls->ls->rw['sisslctp_img'])){ $__tt_img = fgr('<img src="'.DMN_FLE_SIS_SLC_TP.$___Ls->ls->rw['sisslctp_img'].'">'); } ?>        	  
		<td width="1%" <?php echo NWRP ?>><?php echo Spn($___Ls->ls->rw[$___Ls->ino]); ?></td>
		<td width="1%" align="left"><?php echo $__tt_img; ?></td>
		<td width="20%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['sisslctp_tt'],'in'),150,'Pt', true).ul($__cl, '_cl_avatar'); ?></td>
		<td width="49%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['sisslctp_tt'],'in'),40,'Pt', true); ?></td>
		<td width="1%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['sisslctp_key'],'in'),40,'Pt', true); ?></td>
		<td width="1%" align="left" nowrap="nowrap" class="_btn"><?php echo $___Ls->_btn([ 't'=>'mod' ]); ?></td>
  	</tr>
  	<?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>
</table>
<?php $___Ls->_bld_l_pgs(); ?>
<?php } ?>
<?php $___Ls->_h_ls_nr(); ?>
<?php } ?>

<?php if($___Ls->fm->chk=='ok'){ ?>
<?php if($___Ls->dt->tot > 0){ $__cls_divcol = '_col_sm'; } ?>
<div class="FmTb DshLsScltTp">
  	<div id="<?php echo $___Ls->fm->bx->id ?>" class="<?php echo DV_GNR_FM_BX ?>" > 

		<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">

	        <div class="ln_1 _anm <?php //echo $__cls_divcol; ?>" id="dv_col">
		        
	          	<div class="col_1 _anm" style="position: relative; ">
		         	
		         	<a href="<?php echo Void(); ?>" id="cmp_col" class="__cmpc"></a>
				 	<?php 
	            
			            $CntWb .= "
							$('#cmp_col').click(function() {
								if( $('#dv_col').hasClass('_mny') ){
									$('#dv_col').removeClass('_mny');
								}else{
									$('#dv_col').addClass('_mny');
								} 
							});
			            ";

					  	$___Ls->_dvlsfl_all([
							['n'=>'sis_slc_tp_cl', 'l'=>'Clientes', 'bimg'=>'']
						]);

						$_id_tbpnl = 'TabPnl_'.Gn_Rnd(20);
						$CntWb .= " SUMR_Main.bxajx.".$_id_tbpnl." = new Spry.Widget.TabbedPanels('".$_id_tbpnl."' {$_tb_dfl}); "; 
						$CntWb .= _DvLsFl([ 'i'=>$___Ls->tb->eml ]);  
						$CntJV .= "	
									$('#sisslctp_cl').change(function(){
										if(this.checked){
											$('._sis_slc_tp_cl').addClass('_shw');	
											_Rqu({ 
												t:'sis_slc_tp', 
												_id_sisslctp : '".Php_Ls_Cln($___Ls->gt->i)."',
												_cl:function(_r){ if(!isN(_r)){	if(!isN(_r)){ SisSlcSet(_r.sisslc.cl); } } } 
											});
										}else{ $('._sis_slc_tp_cl').removeClass('_shw'); }	
									});" ;

						$CntJV .= " 
							__sisslc_bx_cl = $('#bx_cl_".$__Rnd."');				
							
							function MdlSTp_Dom_Rbld(){
								
								var __sisslc_bx_cl_itm = $('#bx_cl_".$__Rnd." > li.itm.cl ');
								
								__sisslc_bx_cl_itm.not('.sch, .nosnd').off('click').click(function(){					
									$(this).hasClass('on') ? est = 'del' : est = 'in'; 	
									var _id = $(this).attr('rel');
									
									_Rqu({ 
										t:'sis_slc_tp', 
										d:'cl',
										est: est,
										_id_sisslctp : '".Php_Ls_Cln($___Ls->gt->i)."',
										_id_cl : _id,
										_bs:function(){ __sisslc_bx_cl.addClass('_ld'); },
										_cm:function(){ __sisslc_bx_cl.removeClass('_ld'); },
										_cl:function(_r){ if(!isN(_r)){ if(!isN(_r.sisslc.cl)){ SisSlcSet(_r.sisslc.cl); } } } 
									});	
								});
								SUMR_Main.LsSch({ str:'#cl_sch_".$__Rnd."', ls:__sisslc_bx_cl_itm });	
							}
							
							function SisSlcF_Html(){
								__sisslc_bx_cl.html('');
								__sisslc_bx_cl.append('<li class=\"sch\">".HTML_inp_tx('cl_sch_'.$__Rnd, TX_SEARCH, '')."<button class=\"_new _anm\" new-tp=\"cl\"></button></li>');
								
								$.each(_sisslc['ls'], function(k, v) { 

									if(!isN(v.tot) && v.tot > 0){ var _cls = 'on'; }else{ var _cls = 'off'; }
									if(!isN(v.img)){ if(!isN(v.img.sm_s)){ img=v.img.sm_s; }else{ img=v.img; } }else{ img=''; }
									if(!isN(v.clr)){ var _bclr = v.clr; }else{ var _bclr = ''; }
									
									__sisslc_bx_cl.append('<li class=\"_anm itm cl '+_cls+'\" cl-id=\"'+v.enc+'\" rel=\"'+v.enc+'\" style=\"background-color:'+_bclr+'\">
																<figure style=\"background-image:url('+img+')\" class=\"_bg\"></figure>
																<span>'+v.nm+'</span>
															</li>');
								});	
								MdlSTp_Dom_Rbld();
							}
						";

						$CntJV .= "	
							function SisSlcSet(p){	
								if( !isN(p) ){	
									_sisslc = {};
									if( !isN(p) ){ _sisslc['ls'] = p.ls; _sisslc['tot'] = p.tot; }
									SisSlcF_Html();
								}
							}	
						";

						if($___Ls->dt->tot > 0 && $___Ls->dt->rw['sisslctp_cl'] == 1){							
							$CntJV .= "
								$('._sis_slc_tp_cl').addClass('_shw'); 
								_Rqu({ 
									t:'sis_slc_tp', 
									_id_sisslctp : '".Php_Ls_Cln($___Ls->gt->i)."',
									_cl:function(_r){ if(!isN(_r)){ if(!isN(_r)){ SisSlcSet(_r.sisslc.cl); } } } 
								});
							";
						}			
					?>
					
					<div style="width: 100%;" id="<?php echo $_id_tbpnl ?>" class="VTabbedPanels TbGnrl mny tab_slc">
			          	<ul class="TabbedPanelsTabGroup">
				            <?php echo $___Ls->tab->bsc->l ?>
				            <?php echo $___Ls->tab->sis_slc_tp_cl->l ?> 
			          	</ul>
					  	<div class="TabbedPanelsContentGroup">
			            	<div class="TabbedPanelsContent">
					           	<div class="_wrp">
						           	<form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>"> 
							           	<?php $___Ls->_bld_f_hdr(); ?> 
									  	<?php echo HTML_inp_tx('sisslctp_tt', TX_TT, ctjTx($___Ls->dt->rw['sisslctp_tt'],'in'), FMRQD); ?>
									  	
										<?php echo HTML_inp_tx('sisslctp_key', TX_KEY, ctjTx($___Ls->dt->rw['sisslctp_key'],'in'), FMRQD); ?>

										<?php echo h2('Orden'); ?>
										<div class="bx_chck_org">
											<?php echo OLD_HTML_chck('sisslctp_ord', 'Orden', $___Ls->dt->rw['sisslctp_ord'], 'in'); ?> 
											<?php echo OLD_HTML_chck('sisslctp_ord_desc', 'Orden DESC', $___Ls->dt->rw['sisslctp_ord_desc'], 'in'); ?>  
										</div>
										
										<?php echo OLD_HTML_chck('sisslctp_sis', TX_SIS, $___Ls->dt->rw['sisslctp_sis'], 'in'); ?>
										<?php echo OLD_HTML_chck('sisslctp_cl', TX_CL, $___Ls->dt->rw['sisslctp_cl'], 'in'); ?>
										  
								  	</form>
								  	<div class="ln" style="margin-top: 50px;">
				                        <?php    
					                        if($___Ls->dt->tot > 0){
						                        $__slc_f = _DvLs([ 'id'=>'flds', 'i'=>$___Ls->gt->i, 't'=>$__sub, 't2'=>$___Ls->gt->tsb ]);
						                        echo $__slc_f->html; $CntJV .= $__slc_f->jv; $CntWb .= $__slc_f->js;
					                        }
					                    ?>
				                    </div> 
							    </div>  	   
			            	</div>
							<div class="TabbedPanelsContent __cl">
			                	<div class="_wrp">
						           	<div class="ln_1 sisslcf_dsh dsh_cnt _anm">
									  	<div class="_c _anm _scrl" style="width: 100%;">
										  	<?php echo h2( TX_CL ); ?>
											<ul id="bx_cl_<?php echo $__Rnd; ?>" class="_ls dls _anm"></ul>	 
											<div class="_new_fm" id="bx_fm_cl_<?php echo $__Rnd; ?>"></div>
									  	</div>
								  	</div>	
							    </div>
				            </div>
			          	</div>   	  
		        	</div>
	          	</div>
	          	
			  	<div class="col_2 _anm">
				  	
			  		<!-- Inicia Lista -->
			  			<?php echo h1("__Ls([	'k'=>'".$___Ls->dt->rw['sisslctp_key']."', 
				  								'id'=>'', 
				  								'v'=>'', 
				  								'va'=>'', 
				  								'ph' =>''
				  						]);"
				  					) 
				  		?>
	                    <div class="ln">
	                        <?php
		                    	
		                    	if($___Ls->dt->tot > 0){
			                        $__slc_f = _DvLs([ 'id'=>'rcrds', 'i'=>$___Ls->gt->i, 't'=>$__sub2, 't2'=>$___Ls->gt->tsb ]);
			                        echo $__slc_f->html; $CntJV .= $__slc_f->jv; $CntWb .= $__slc_f->js;
		                        }
		                        
		                    ?>
	                    </div> 
					<!-- Finaliza Lista -->	
	          	</div>
	        </div>
    	</div>
	</div>
</div>
<style>
	.ln_1._mny .col_1{  }
	.ln_1._mny .col_1 form,
	.ln_1._mny .col_1 div{ opacity: 0; pointer-events: none; }
	._sis_slc_tp_cl{ display: none !important;}
	._sis_slc_tp_cl._shw{ display: block !important }	
	
	.DshLsScltTp .VTabbedPanels.mny .TabbedPanelsTabGroup .TabbedPanelsTab{ width: 30px; height: 30px;background-position: center;background-repeat: no-repeat;background-size: 70% auto; }	
	.DshLsScltTp .VTabbedPanels.mny .TabbedPanelsTabGroup .TabbedPanelsTab._bsc{ background-image:url('<?php echo DMN_IMG_ESTR_SVG ?>cnt_dtl.svg'); }
	.DshLsScltTp .VTabbedPanels.mny .TabbedPanelsTabGroup .TabbedPanelsTabSelected._bsc{ background-image:url('<?php echo DMN_IMG_ESTR_SVG ?>cnt_dtl_w.svg'); }
	.DshLsScltTp .VTabbedPanels.mny .TabbedPanelsTabGroup .TabbedPanelsTab._sis_slc_tp_cl{ background-image:url('<?php echo DMN_IMG_ESTR_SVG ?>modules.svg'); }
	.DshLsScltTp .VTabbedPanels.mny .TabbedPanelsTabGroup .TabbedPanelsTabSelected._sis_slc_tp_cl{ background-image:url('<?php echo DMN_IMG_ESTR_SVG ?>modules_w.svg'); }

	.DshLsScltTp .bx_chck_org {
		border: none;
		border-radius: 12px;
		padding: 20px;
		background-color: #f3f3f3;
		margin-bottom: 12px;
	}
	.DshLsScltTp .bx_chck_org h3{ border:0px; }
	
</style>	
<?php } ?>
<?php } ?> 