<?php 
if(class_exists('CRM_Cnx')){

	$___Ls->cnx->cl = 'ok';	 
	$___Ls->sch->f = 'grph_tt';
	$___Ls->new->big = 'ok';
	$___Ls->edit->big = 'ok';
	$___Ls->_strt();

	if(!isN($___Ls->gt->i)){	
		
		$___Ls->qrys = sprintf("SELECT * FROM "._BdStr(DBM).MDL_GRPH_BD." WHERE ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));
		
	}elseif($___Ls->_show_ls == 'ok'){ 

		$Ls_Whr = "FROM "._BdStr(DBM).MDL_GRPH_BD." WHERE ".$___Ls->ino." != '' ".$___Ls->sch->cod." ORDER BY ".$___Ls->ino." DESC";
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
		<th width="49%" <?php echo NWRP ?>><?php echo TX_NM ?></th>
		<th width="1%" <?php echo NWRP ?>></th>
	</tr>
  	<?php do { ?>
    <tr>
    	<td width="1%" <?php echo NWRP ?>><?php echo Spn($___Ls->ls->rw[$___Ls->ino]); ?></td>
		<td width="49%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['grph_tt'],'in'),150,'Pt', true); ?></td>
		<td width="1%" align="left" nowrap="nowrap" class="_btn"><?php echo $___Ls->_btn([ 't'=>'mod' ]); ?></td>
  	</tr>
  	<?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>
</table>
<?php $___Ls->_bld_l_pgs(); ?>
<?php } ?>
<?php $___Ls->_h_ls_nr(); ?>
<?php } ?>
<?php if($___Ls->fm->chk=='ok'){ ?>
<div class="FmTb">
  	<div id="<?php echo $___Ls->fm->bx->id ?>" class="<?php echo DV_GNR_FM_BX ?>" > 

		<div class="imgbn">
			<?php echo $__dt_img->img; ?>
			<?php echo h1(ctjTx($___Ls->dt->rw['clg_tt'],'in')); ?>
		</div>         
		<?php $__idtp_grph_chr = '_grph_chr'; ?>
		<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
								
			<div class="ln_1">
				
				<div class="col_1">
						
						<form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>" >
							<?php $___Ls->_bld_f_hdr(); ?>
							<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
								<?php echo HTML_inp_tx('grph_tt', TX_TT, ctjTx($___Ls->dt->rw['grph_tt'],'in'), FMRQD); ?>
								<?php echo HTML_inp_tx('grph_c', TX_CTGR, ctjTx($___Ls->dt->rw['grph_c'],'in')); ?>
								<?php echo HTML_inp_tx('grph_d', TX_DTS, ctjTx($___Ls->dt->rw['grph_d'],'in'), ''); ?>
								
								
								<a id="btnn" name="btnn" href="<?php echo Void();?>" class="run_code">Run Code</a> 
					
								<?php 
												
									echo  HTML_textarea('grph_fnc', TX_FNC, ctjTx($___Ls->dt->rw['grph_fnc'],'in'), '', '', '', 2); 
									
									$__id_edtr = '__my_e_'.Gn_Rnd(10);
									
										
										
									$CntWb .= ' SUMR_Main.ld.f.cdmrr(function(){
													
													$("#grph_fnc").delay(1000).fadeIn("slow", function(){
															
														var '.$__id_edtr.' = CodeMirror.fromTextArea(document.getElementById("grph_fnc"), {
																		lineNumbers: true,
																		styleActiveLine: true,
																		theme:"solarized dark",
																		matchBrackets: true,
																		viewportMargin: Infinity
																	});
														
														
														'.$__id_edtr.'.on("change", function('.$__id_edtr.', change) {
															$("#grph_fnc").val( '.$__id_edtr.'.getValue() );
														});
	
													});
												});
												
	
												function ___ld_my_g(){
													
													var _f = $("#grph_fnc").val();
													var _p = {};
					
													_p.id = \'#test_g\';
													_p.c = eval( $("#grph_c").val() );
													_p.d = eval( $("#grph_d").val() );
													_p.clr = $("#grph_clr").val();
													
													'.$__li_chr_f.'
													
													
													if(_f != \'\' && _f != "undefined"  && _f != null){ 
														
														
														eval(_f);
					
													}
												}
													
												$("#btnn").click(function(){  	
													___ld_my_g();
												});
												
												';
										
										
									if($___Ls->dt->tot == 1){ $CntWb .= " setTimeout( ___ld_my_g , 1000); "; }
										
										
										
								?> 
						
						
							</div>
						</form>							  	 
						
						
					</div>
					
					<div class="col_2">
					
						
						<code>
							
							<?php 
								
								$_grph_chr = GtGrph_Chr( [ 'grph'=>$___Ls->dt->rw['id_grph'] ]);
								
								echo GRPH_F.$___Ls->dt->rw['id_grph'] ?>({

									
									<?php 
										
										echo HTML_BR;
										
										$__li_chr .= 'id: \'\', // Div contenedor'. HTML_BR;
										$__li_chr .= 'd: \'\', // Data'. HTML_BR;
										
										foreach($_grph_chr->ls as $k => $v){
											$__li_chr .= $v->k .': '.  GtSQLVlStr(  (($v->vle!=NULL)?$v->vle:$v->dfl), $v->tp ) .', // '.$v->tt .HTML_BR;
											$__li_chr_f .= 'if(_p.'.$v->k.' == undefined || _p.'.$v->k.' == null){ _p.'.$v->k.' = '.GtSQLVlStr( ($v->vle!=NULL?$v->vle:$v->dfl), $v->tp).'; } ';
										}
										
										echo ul( $__li_chr ); 
									?>
								
								});
							

						</code>
							
						<div class="ln">
							<?php 
								echo bdiv(['id'=>DV_LSFL.$__idtp_grph_chr, 'cls'=>'_sbls']);
								$CntJV .= _DvLsFl_Vr(['i'=>$___Ls->dt->rw[$___Ls->ino], 'n'=>$__idtp_grph_chr, 't'=>'_grph_chr_rlc']); 	  
								$CntWb .= _DvLsFl(['i'=>$__idtp_grph_chr, 't'=>'s']); 
							?>
						</div> 
							
						<?php echo h2('Graph Test'); ?>
						<div id="test_g"></div>
							
						<?php echo h2('Function Call'); ?>
						
				</div>	
			</div>	

		</div>	
		    
  	</div>
</div>
<?php } ?>
<?php } ?>
