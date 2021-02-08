<?php 
	
//-------------- LINEA 1 FORMULARIO --------------//	
	
	
	
	if($__scrpt->tot > 0){
		$OpnOnFnd = '<button class="call_plcy_btn _anm" id="Call_Plcy_'.$___Ls->id_rnd.'"></button>';
	}else{
		$OpnOnFnd = '';
	}

	if(_ChckMd('mdl_cnt_est_no','ok')){
		$attr = ['disabled'=>'disabled'];		
	}
	

	$__fm_l_1[] = LsCntEst([ 
							'id'=>'mdlcnt_est', 
							'v'=>'id_siscntest', 
							'va'=>$___Ls->dt->rw['mdlcnt_est'], 
							'v_go'=>'enc', 
							'rq'=>1, 
							'mdl'=>$___Ls->dt->rw['mdlcnt_mdl'], 
							'mdlstp'=>$___Ls->mdlstp->id, 
							'attr'=>$attr
						]);		        	   	

   	$CntWb .= JQ_Ls('mdlcnt_est',FM_LS_EST, '', '_slcClr', ['ac'=>'no']);
   
    $CntWb .= " 
    
		$('#mdlcnt_est').change(function(){
			
			var __id = $(this).val();
			var __est_i = $(this).val();
			var _noi = $('#mdlcnt_est ._slc_opt:selected').attr('noi');			
			
			if(_noi == 1){
				SUMR_Main.ld.f.slc({ i:__id, t:'mdlcnt_noi_op1', b:'noi_bx', t_p:'".$___Ls->mdlstp->tp."' , d:{ _are : '".$___Ls->dt->rw['_are']."' } });
				$('._fm_spc.__cnt_noi').addClass('_shw');
			}else{
				$('._fm_spc.__cnt_noi').removeClass('_shw');
			}
		});
	";
   
    $CntWb .= "
		
		/*$('#mdlcnt_est').change(function() {
			
			__id = $(this).val();
			__est_i = $(this).val();
			
			if(__est_i == 1){
				SUMR_Main.ld.f.slc({ i:__id, t:'mdlcnt_noi_op1', b:'noi_bx', t_p:'".$___Ls->mdlstp->tp."' });
				$('#__sctnoi').fadeIn().effect('shake');
			}else{
				$('#__sctnoi').fadeOut();
			}
			
		});*/
		
	"; 

//-------------- LINEA 2 FORMULARIO --------------//

	    if((ChckSESS_superadm() ) || $___Ls->dt->tot == 0 || _ChckMd('mdl_cnt_fnt_mod')){
	       	$__fm_l_2[] = LsSis_Md('mdlcnt_m','id_sismd', $___Ls->dt->rw['mdlcnt_m'], '', 1, '', ['tp'=>$___Ls->mdlstp->tp]); 
		   	$CntWb .= JQ_Ls('mdlcnt_m',FM_LS_MD);
	    }else{
		    $__fm_l_2[] = Spn(ctjTx($___Ls->dt->rw['sismd_tt'],'in'),'','_tt_shw');
	        $__hd_prd .= '<input id="mdlcnt_m" name="mdlcnt_m" type="hidden" value="'.$___Ls->dt->rw['mdlcnt_m'].'" />';
	    }
	    
	    if( _ChckMd('mdl_cnt_md_tp','ok') ){
			$__fm_l_md[] = LsSisMdTp('sismd_tp','id_sismdtp', $___Ls->dt->rw['sismd_tp'], TX_SLCTP, 2); 
			$CntWb .= JQ_Ls('sismd_tp', TX_SLCTP);

			$CntWb .= " 
    
				$('#sismd_tp').change(function(){
					
					var __id = $(this).val();
					SUMR_Main.ld.f.slc({ i:__id, t:'mdl_cnt_md', b:'md_bx', t_p:'".$___Ls->mdlstp->tp."' , d:{ _are : '".$___Ls->dt->rw['_are']."' } });

				});
			";
		}

	    if(ChckSESS_superadm() || $___Ls->dt->tot == 0 || _ChckMd('mdl_cnt_fnt_mod')){
			$__fnt_df_us = 5;
			
	    	$__fm_l_4[] = LsCntFnt('mdlcnt_fnt','id_sisfnt', (($___Ls->dt->rw['mdlcnt_fnt'] != '') ? $___Ls->dt->rw['mdlcnt_fnt']:$__fnt_df_us), FM_LS_CNTFNT, '', '', ['tp'=>$___Ls->mdlstp->tp]); 
	        $CntWb .= JQ_Ls('mdlcnt_fnt',FM_LS_CNTFNT);
	    } else{
		    $__fm_l_4[] = Spn(ctjTx($___Ls->dt->rw['sisfnt_nm'],'in'),'','_tt_shw');
	        $__hd_prd .= '<input id="mdlcnt_fnt" name="mdlcnt_fnt" type="hidden" value="'.$___Ls->dt->rw['mdlcnt_fnt'].'" />';
		}
		
		if(_ChckMd('mdl_cnt_cl_sds_mod','ok')){
	    	$__fm_l_sds[] = LsClSds('mdlcnt_cl_sds','id_clsds', $___Ls->dt->rw['mdlcnt_cl_sds'] , TX_SDS, '', ''); 
	        $CntWb .= JQ_Ls('mdlcnt_cl_sds',TX_SDS);
	    }



//-------------- LINEA 3 FORMULARIO --------------//

		if(ChckSESS_superadm()){
			
			if(!isN($___Ls->dt->rw['mdlcnt_m_k'])){
				//$__fm_l_5[] = HTML_inp_tx('mdlcnt_m_k', 'Key', ctjTx($___Ls->dt->rw['mdlcnt_m_k'],'in'));
				$__fm_l_5[] = '<div class="opt_tx _anm">'.ctjTx($___Ls->dt->rw['mdlcnt_m_k'],'in').'</div>';
			}
			
		}else{
			
			$__hd_prd .= HTML_inp_hd('mdlcnt_m_k', $___Ls->dt->rw['mdlcnt_m_k']); 
			
		}
		
		
		if($___Ls->dt->tot == 1){
		    $__fm_l_3[] = HTML_inp_tx('mdlcnt_pgd', '-', ctjTx($___Ls->dt->rw['mdlcnt_pgd'],'in'), FMRQD_NMR);
		}
		
		if($___Ls->dt->tot == 1){
			$__fm_l_6[] = LsSis_Dcto('mdlcnt_dcto','id_dcto', $___Ls->dt->rw['mdlcnt_dcto'], '', 2); $CntWb .= JQ_Ls('mdlcnt_dcto',FM_LS_DCTO);
		}
		
		
		if($___Ls->dt->tot == 0){
			$__fm_l_7[] = OLD_HTML_chck('cnt_sndi', '', '', 'in').$OpnOnFnd;
		}
		

		if($___Ls->dt->tot == 0){
			
			$__Cl = new CRM_Cl([ 'cl'=>$__dt_cl->id ]);
			$___plcy_main = $__Cl->plcy_main([ 'cl'=>$__dt_cl->id ]);
			$__fm_l_8[] = LsPlcy('_cnt_plcy', 'clplcy_enc', $___plcy_main->enc , FM_LS_PLCY, 'ok', '', [ 'cl'=>CL_ENC ] ); $CntWb .= JQ_Ls('_cnt_plcy', '');
				
		}			
		
?>

<?php echo $__hd_prd; ?>
<?php if($___Ls->dt->tot == 0){ ?>	
	<?php

		if(mBln($___Ls->mdlstp->mdls) == 'ok' || isN($___Ls->mdlstp->id)){

			$__mdls_f = '<div class="mdls">
							'.(!isN($___Ls->mdlstp->img->big)?'<span style="background-image:url('.$___Ls->mdlstp->img->big.');" class="icn"></span>':'').'
							<div class="slc">'.LsMdlS($___Ls->mdlstp->tp, 'mdlcnt_f_mdl', 'id_mdls', '', FM_LS_SLTP, 2, '', [ 'cl'=>'ok' ] ).'</div>
						</div><div class="sep"></div>';

			$CntWb .= JQ_Ls('mdlcnt_f_mdl', TX_SLCNMDLS);

			$CntWb .= " 
    
				$('#mdlcnt_f_mdl').change(function(){
					var __id = $(this).val();			
					SUMR_Main.ld.f.slc({ i:__id, t:'mdlcnt_mdl', b:'mdlcnt_mdl_bx', t_p:'".$___Ls->mdlstp->id."', d:{ m : '".$___Ls->dt->rw['_are']."' } });
				});

			";


		}
	?>

	<div class="mdl_steps <?php if(isN($__mdls_f)){ echo 'full'; } ?>">
		<?php echo $__mdls_f; ?>
		<div id="mdlcnt_mdl_bx" class="_anm sl-mdl">
			<?php 
				echo LsMdl('mdlcnt_mdl', 'mdl_enc', $___Ls->dt->rw['mdl_enc'], '', 1, '', [ 'tp'=>$___Ls->mdlstp->id, 'mdl_s_sch' => 'ok', 'flt_are'=>'ok' ]);                           
				$CntWb .= JQ_Ls('mdlcnt_mdl', TX_SLCNMDL); 
			?>
		</div>
	</div>

	<?php

		$CntWb .= " 
    
			$('#mdlcnt_mdl').change(function(){

				$('._fm_spc.__cnt_sch_ing').removeClass('_shw');
				var __id = $(this).val();
				var __est_i = $(this).val();
			
				var _sch = $('#mdlcnt_mdl ._slc_opt:selected').attr('_sch');			
			
				if(_sch == 1){
					SUMR_Main.ld.f.slc({ i:__id, t:'mdl_cnt_sch', b:'sch_bx' });
					$('._fm_spc.__cnt_sch_ing').addClass('_shw');
				}else{
					$('._fm_spc.__cnt_sch_ing').removeClass('_shw');
				}
				
			});
		";
		
		echo LsMdlSPrd('mdlcnt_prd','id_mdlsprd', '' ,TX_PRD_A , 1,'', [ 'tp_mdl' => $__t2, 'est'=>'ok' ] );  
		$CntWb .= JQ_Ls('mdlcnt_prd',TX_PRD_A); 
		
	?>
<?php } ?>

<div class="_fm_spc _c1 __cnt_sch __cnt_sch_ing">
	<?php echo '<div class="tt_slc">'.'Horario'.'</div>' ?>
	<div class="_d1"><div id="sch_bx" class="_sbls"></div></div>
</div>

<style>

	._fm_spc.__cnt_sch_ing{ display: none; }
	._fm_spc.__cnt_sch_ing._shw{ display: flex!important; }

</style>

<?php if($___Ls->dt->tot > 0){ ?>

	
	
	<?php if( mBln($___Ls->mdlstp->ctg->main->attr->prd->vl) == 'ok'){ ?>
	<div class="_fm_spc _c1 __cnt_prd_i">
		<?php echo '<div class="tt_slc">'.TX_PRDING.'</div>' ?>
		<div class="_d2 prd_i"><?php echo $___Ls->dt->rw['mdlsprd_nm']; ?></div>
	</div>

	<div class="_fm_spc _c1 __cnt_prd" style="padding-top:5px; padding-bottom:5px;">
		<?php echo '<div class="tt_slc">'.TX_PRDINTS.'</div>' ?>
		<div class="_d1"><div id="mdl_cnt_prd_<?php echo $___Ls->id_rnd ?>" class="opt_tx _anm __prd_slc"></div></div>
		<div class="_d2"></div>
		<?php 
			
			$CntWb .= "
			
				SUMR_Main.bxajx.__mdlcnt_bx_prd_now = $('#mdl_cnt_prd_".$___Ls->id_rnd."');
				
				SUMR_Main.bxajx.__mdlcnt_bx_prd_now.off('click').click(function(e){
						
					if(e.target != this){
						e.stopPropagation(); return;
					}else{
						SUMR_Main.bxajx.__mdlcnt_main.addClass('_prd');
					}
					
				});	
			"; 
			
		?> 							
	</div>
	<?php  } ?>
	
	<div class="_fm_spc _c1 __cnt_cntc" style="display:none;">
			<?php echo '<div class="tt_slc">'.'Contactabilidad'.'</div>' ?>
			<div class="_d1"><div id="mdl_cnt_h_cntc_<?php echo $___Ls->id_rnd ?>" class="opt_tx _anm __cntc_slc"></div></div>
			<div class="_d2"></div>
			<?php 
				
				$CntWb .= "
				
					SUMR_Main.bxajx.__mdlcnt_bx_cntc_now = $('#mdl_cnt_h_cntc_".$___Ls->id_rnd."');
					
					SUMR_Main.bxajx.__mdlcnt_bx_cntc_now.off('click').click(function(e){
							
						if(e.target != this){
					    	e.stopPropagation(); return;
						}else{
							SUMR_Main.bxajx.__mdlcnt_main.addClass('_h_cntc');
						}
						
					});	
				"; 
				
			?> 							
	</div>
	
	<?php if($__mdl_dt->tot->sch > 0){ ?>
	
	<div class="_fm_spc _c1 __cnt_sch">
			<?php echo '<div class="tt_slc">Horario</div>' ?>
			<div class="_d1"><div id="mdl_cnt_sch_<?php echo $___Ls->id_rnd ?>" class="opt_tx _anm __sch_slc"></div></div>
			<div class="_d2"></div>
			
			<?php 
				
				$CntWb .= "
				
					__mdlcnt_bx_sch_now = $('#mdl_cnt_sch_".$___Ls->id_rnd."');
					
					__mdlcnt_bx_sch_now.off('click').click(function(e){
							
						if(e.target != this){
					    	e.stopPropagation(); return;
						}else{
							SUMR_Main.bxajx.__mdlcnt_main.addClass('_sch');
						}
						
					});	
				
					
				"; 
				
			?> 
								
	</div>
	
	<?php } ?>
	
	
<?php } ?>
	
<?php if($___Ls->dt->tot != 0){ ?>
	<div class="_fm_spc _c<?php echo count($__fm_l_1); ?> __cnt_est">
		<?php echo '<div class="tt_slc">'.TX_ETD.'</div>' ?>
		<?php for ($i=0; $i<=count($__fm_l_1); $i++) { ?>
			<div class="_d<?php echo $i+1; ?>"> <?php echo $__fm_l_1[$i]; 
			?> </div>
		<?php } ?>		
	</div>	
<?php } ?>	

<div class="_fm_spc _c1 __cnt_noi <?php if(mBln($___Ls->dt->rw['siscntest_noi']) == 'ok'){ echo "_shw"; } ?>">
	<?php echo '<div class="tt_slc">'.TX_SCNTNOI.'</div>' ?>
	<?php echo HTML_inp_hd('mdlcnt_noi', $___Ls->dt->rw['mdlcnt_noi']); ?>
	
	<div class="_d1">
		
		<div class="_noi_slc" id="__sctnoi" style="">

		
			<?php $__dt_noi = GtCntNoiSubLs([ 'id'=>$___Ls->dt->rw['mdlcnt_noi'], 'pipe'=>'ok' ]); ?>
			
			<?php 
				if(SISUS_ID == 181){
					
					echo json_encode($__dt_noi);
					
					/*$isss = 1;
					do{
						echo "Hola";
						$isss++;
					}while( $isss == 1 );*/
					
				}
			?>
						
						<div id="noi_bx" class="_sbls">
								
								<?php  
                                	if($___Ls->dt->rw['siscntest_noi'] == '1'){
										
										$_bx_i = $__dt_noi->tot;
									
										for ($i=1; $i<=$__dt_noi->tot; $i++) {	
												
											if(SISUS_ID == 181){
												
											}
												
											echo '<div id="noi_bx_'.$i.'" class="_sbls _noi_sb _noi_sb_'.$i.'"></div>';
											$CntWb .= " SUMR_Main.ld.f.slc({ 
															i:'".$__dt_noi->ls->{'sb'.$_bx_i}."', 
															t:'mdlcnt_noi_op$i', 
															t_f:'".$__dt_noi->ls->{'sb'.($_bx_i+1)}."', 
															t_i:'".$__dt_noi->ls->{'sb'.$_bx_i}."', 
															t_e:'{$__t_s_e}', 
															s_t:'".$__dt_noi->tot."', 
															b:'noi_bx_$i',
															d: { _are : '".$___Ls->dt->rw['_are']."' }
														}); ";
											

											if( $__dt_noi->ls->{'sb'.$_bx_i} == 2){ $__unibx = 'ok'; }
														
											$_bx_i--;
											
										}
                                	}	
                            	?>
                        	
                        </div>
			
		
		    <div id="noi_otu_bx" class="_noi_sb _noi_sb_1">
		    <?php 
		          
				if($___Ls->dt->rw['mdlcnt_noi'] == '2' || $__unibx == 'ok'){ 
					$__t_s_i = $___Ls->dt->rw['mdlcnt_noi_otc'];
					$__ts = 'mdlcnt_noi_otc';
					$__i = $___Ls->dt->rw['mdlcnt_noi_otc'];
					$__inc = 'ok';
					include('_slc.php');
				}
				
		    ?>
		    </div>   

			</div>
</div>
	
	<div class="_d2"><div></div></div>
	
</div> 

<style>
	
	.lead_detail ._noi_slc{ display: block!important; }
	._fm_spc.__cnt_noi{ display: none; }
	._fm_spc.__cnt_noi._shw{ display: flex!important; }
	
</style>

<?php if( _ChckMd('mdl_cnt_md_tp','ok') ){ ?>
	<div class="_fm_spc _c<?php echo count($__fm_l_md); ?> __cnt_md">
		<?php echo '<div class="tt_slc">'.'Tipo de medio'.'</div>' ?>
		<?php for ($i=0; $i<=count($__fm_l_md); $i++) { ?>
			<div class="_d<?php echo $i+1; ?>"> <?php echo $__fm_l_md[$i]; ?> </div>
		<?php } ?>
	</div> 
<?php } ?>
 
<div class="_fm_spc _c<?php echo count($__fm_l_2); ?> __cnt_md">
		<?php echo '<div class="tt_slc">'.TX_MD.'</div>' ?>
		<?php for ($i=0; $i<=count($__fm_l_2); $i++) { ?>
			<div id="md_bx" class="_d<?php echo $i+1; ?>"> <?php echo $__fm_l_2[$i]; ?> </div>
		<?php } ?>
</div> 

<div class="_fm_spc _c<?php echo count($__fm_l_4); ?> __cnt_fnt">
		<?php echo '<div class="tt_slc">'.TX_FNT.'</div>' ?>
		<?php for ($i=0; $i<=count($__fm_l_4); $i++) { ?>
			<div class="_d<?php echo $i+1; ?>"> <?php echo $__fm_l_4[$i]; ?> </div>
		<?php } ?>
</div> 

<?php if(_ChckMd('mdl_cnt_cl_sds_mod', 'ok')){ ?>
	<div class="_fm_spc _c<?php echo count($__fm_l_sds); ?> __cnt_cl_sds">
		<?php echo '<div class="tt_slc">'.TX_SDS.'</div>' ?>
		<?php for ($i=0; $i<=count($__fm_l_sds); $i++) { ?>
			<div class="_d<?php echo $i+1; ?>"> <?php echo $__fm_l_sds[$i]; ?> </div>
		<?php } ?>
	</div> 
<?php } ?>


<?php /*if($___Ls->dt->tot == 0){ ?>

	<div class="_fm_spc _c<?php echo count($__fm_l_4); ?> __cnt_fnt">
		<?php echo '<div class="tt_slc">'.TX_PRDO.'</div>' ?>
		<div class="_d1">
			<?php 
				echo LsMdlSPrd('mdlcnt_prd','id_mdlsprd', ($___Ls->dt->rw['mdlcnt_prd'] != ''), FM_LS_PRD, '', '', array('tp'=>$___Ls->mdlstp->tp));  
				$CntWb .= JQ_Ls('mdlcnt_prd',FM_LS_PRD); 
			?> 
		</div>
	</div> 

<?php }*/ ?>

<!--
<div class="_fm_spc _c<?php echo count($__fm_l_3); ?> __cnt_pay">
		<?php echo '<div class="tt_slc">'.TX_PG.'</div>' ?>
		<?php for ($i=0; $i<=count($__fm_l_3); $i++) { ?>
			<div class="_d<?php echo $i+1; ?>"> <?php echo $__fm_l_3[$i]; ?> </div>
		<?php } ?>
</div> 
-->

<?php if(!isN($__fm_l_5)){ ?> 
<div class="_fm_spc _c<?php echo count($__fm_l_5); ?> __cnt_key">
	<?php echo '<div class="tt_slc">'.TX_KEYWORD.'</div>' ?>
	<?php for ($i=0; $i<=count($__fm_l_5); $i++) { ?>
		<div class="_d<?php echo $i+1; ?>"> <?php echo $__fm_l_5[$i]; ?> </div>
	<?php } ?>
</div> 
<?php } ?>

<!--
<div class="_fm_spc _c<?php echo count($__fm_l_6); ?> __cnt_dsc">
		<?php echo '<div class="tt_slc">'.TX_DSCT.'</div>' ?>
		<?php for ($i=0; $i<=count($__fm_l_6); $i++) { ?>
			<div class="_d<?php echo $i+1; ?>"> <?php echo $__fm_l_6[$i]; ?> </div>
		<?php } ?>
</div> 
-->

<?php if(!isN($__fm_l_7)){ ?> 
<div class="_fm_spc _c<?php echo count($__fm_l_7); ?> __cnt_hbs">
	<?php echo '<div class="tt_slc">'.TX_HBSACCPT.'</div>' ?>
	<?php for ($i=0; $i<=count($__fm_l_7); $i++) { ?>
		<div class="_d<?php echo $i+1; ?>"> <?php echo $__fm_l_7[$i]; ?> </div>
	<?php } ?>
</div> 

<?php 				
						
	$CntWb .= '
	
		$("#Call_Plcy_'.$___Ls->id_rnd.'").click(function(e){  	        
	    	
	    	e.preventDefault();
	    	
			if(e.target != this){
		    	e.stopPropagation(); return;
			}else{

				_ldCnt({ 
					u:\''.FL_DT_GN.__t('scrpt_plcy', true).'\',
					d:{
						dc_start:\''.$___Ls->fm->id.'_nm_sch\'	
					},
					pop:\'ok\',
					cls:\'_fll\',
					pnl:{
						e:\'ok\',
						s:\'l\',
						tp:\'h\'
					}
				});
					
			}	    

	    });	
	    
	    
	    $("#Call_DocScan_'.$___Ls->id_rnd.'").click(function(e){  	        
	    	
	    	e.preventDefault();
	    	
			if(e.target != this){
		    	e.stopPropagation(); return;
			}else{

				_ldCnt({ 
					u:\''.FL_DT_GN.__t('scan_doc', true).'\',
					d:{
						dc_start:\''.$___Ls->fm->id.'_nm_sch\'	
					},
					pop:\'ok\',
					cls:\'_fll\',
					pnl:{
						e:\'ok\',
						s:\'l\',
						tp:\'h\'
					}
				});
					
			}	    

	    });	
	    
	    
	    

	'; 
?>
<?php } ?>
	
<?php if(!isN($__fm_l_8)){ ?> 
<div class="_fm_spc _c<?php echo count($__fm_l_8); ?> __cnt_fnt">
	<?php echo '<div class="tt_slc">'.TX_PLCY_DTS.'</div>' ?>
	<?php for ($i=0; $i<=count($__fm_l_8); $i++) { ?>
		<div class="_d<?php echo $i+1; ?>"> <?php echo $__fm_l_8[$i]; ?> </div>
	<?php } ?>
</div> 
<?php } ?>

    <?php if(!isN($__t2) && $__t2 == 'sac' && $___Ls->dt->tot == 0 ){ ?>  
		<div style="margin-top: 12px;" class="_c_mdlcnt_tracmnt"></div>
    <?php } ?>

		
<?php if(!isN($__dt_mdlcnt->attr)){ 
	
	
	
	?>

	<?php foreach($__dt_mdlcnt->attr as $_attr_k=>$_attr_v){ ?>	
		<?php $_cls_rnd = 'op_'.Gn_Rnd(20); 

			if(!isN($_attr_v->all->ls->vl)){
				$__slcdt = __LsDt([ 'id'=>$_attr_v->vl, 'no_lmt'=>'ok' ]);			
				$__vl = $__slcdt->d->tt;
			}else{
				$__vl = $_attr_v->vl;
			}
		
		?>
		<?php 
			
				if(!isN($_attr_v->edt) && $_attr_v->edt == 'ok'){
					
					$__cls = '_mod_attr ___edt_attr ';
					$__rel = $_attr_v->id_alt;
					$__id = 'id="attr'.$_attr_v->id_alt.'"';
					
				}else{
					$__cls = '';
					$__rel = '';	
					$__id = '';
				}

			
		?>
		<div <?php echo $__id; ?>  rel="<?php echo $__rel; ?>" class="<?php echo $__cls; ?>_fm_spc _c<?php echo count($__fm_l_6); ?> __cnt_dsc <?php echo $_cls_rnd; ?>">
			<?php echo '<div class="tt_slc">'.$_attr_v->tt.'</div>' ?>
			<div style="width:50%; padding-top:6px;" class="opt_tx"> <?php echo $__vl; ?> </div>
		</div> 	
		<style>
			
			.__cnt_dsc.<?php echo $_cls_rnd; ?>:before{ background-image:url('<?php echo $_attr_v->img; ?>')!important;  }
			
		</style>
		
	<?php } ?>

<?php } ?>


		
		
<?php /*

<div class="_fm_spc _c<?php echo count($__fm_l_6); ?> __cnt_md">
		<?php echo '<div class="tt_slc">Descarga Brochure</div>' ?>
		<?php //for ($i=0; $i<=count($__fm_l_6); $i++) { ?>
				<div class="_d<?php echo $i+1; ?>"> Si </div>
		<?php //} ?>
</div> 


<div class="_fm_spc _c<?php echo count($__fm_l_6); ?> __cnt_dsc">
		<?php echo '<div class="tt_slc">Ciudad</div>' ?>
		<?php //for ($i=0; $i<=count($__fm_l_6); $i++) { ?>
			<div class="_d<?php echo $i+1; ?>"> Vive lejos de Bogotá </div>
		<?php //} ?>
</div> 

*/ ?>

<?php 

$CntWb .=	"

function __Dom(p){
	/*$('.save_attr').off('click').click(function() {*/
	$('input._est_mod').blur(function(){ 

		var _vl = $('._est_mod').val().trim();

		if( !isN( _vl ) ){
			$('._est_mod').css({ 'border':'0px solid red' });

			swal({ 
				title: '".TX_ETSGR."',              
				text: '".TX_SWAL_SVE."!',  
				type: 'warning',                        
				showCancelButton: true,                 
				confirmButtonClass: 'btn-danger',       
				confirmButtonText: '".TX_YSV."',      
				confirmButtonColor: '#8fb360',          
				cancelButtonText: '".TX_CNCLR."',           
				closeOnConfirm: true 
			},
			function(isConfirm){ 
				if (isConfirm) {
					_Rqu({ 
						t:'mdl_cnt_attr', 
						d:'mod',
						_id_mdlcnt : '".Php_Ls_Cln($___Ls->gt->i)."',
						_id_attr: p,
						_vl: _vl,
						_bs:function(){ $('#attr'+p).addClass('_ld'); },
						_cm:function(){ $('#attr'+p).removeClass('_ld'); },
						_cl:function(_r){
							if(!isN(_r)){
								if(_r.e == 'ok'){
									$('._mod_attr').addClass('___edt_attr').removeClass('e_now');
									$('.___edt_attr#attr'+p+' .opt_tx').html('');
									$('.___edt_attr#attr'+p+' .opt_tx').html(_r.vl);	
								}							
							}
						} 
					}); 
				}
			});	
		}else{
			$('._est_mod').css({ 'border':'1px solid #ffb100' });	
		}
	});	
}

$('.___edt_attr').off('click').click(function() { 

	if($(this).hasClass('e_now')){

	}else{
		var __rel = $(this).attr('rel');
		var __html = $('.___edt_attr#attr'+__rel+' .opt_tx').html();

		if(!isN(__html)){
			var __val = __html.trim();
		}else{
			var __val = '';
		}

		$('.___edt_attr#attr'+__rel+' .opt_tx').html('');
		$('.___edt_attr#attr'+__rel+' .opt_tx').append('<input class=\"_est_mod\" type=\"text\" value=\"'+__val+'\">');
		$(this).removeClass('___edt_attr');
		$('.___edt_attr').addClass('e_now');

		__Dom(__rel);
	}
});

"; 

?>
