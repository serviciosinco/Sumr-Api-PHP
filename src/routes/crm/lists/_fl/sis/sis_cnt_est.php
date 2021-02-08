<?php
if(class_exists('CRM_Cnx')){
	
	$___Ls->sch->f = 'siscntest_tt, siscntest_clr_bck, siscntesttp_tt';	
	$___Ls->img->dir = DMN_FLE_SIS_CNT_EST;
	$___Ls->edit->w = 1100;
	$___Ls->edit->h = 700;
	$___Ls->new->w = 800;
	$___Ls->new->h = 550;
	$___Ls->_strt();

							
	if(!isN($___Ls->gt->i)){	
		
		$___Ls->qrys = sprintf("SELECT * FROM "._BdStr(DBM).TB_SIS_CNT_EST." WHERE ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));
		
	}elseif($___Ls->_show_ls == 'ok'){	
		
		$__als_qry .= ", ( SELECT COUNT(*) FROM "._BdStr(DBM).TB_CL_GRP_EST." WHERE clgrpest_est = id_siscntest) AS __tot_grp ";		
		$__als_qry .= ", ( SELECT COUNT(*) FROM "._BdStr(DBM).TB_SIS_CNT_EST_ARE." WHERE siscntestare_est = id_siscntest) AS __tot_are ";
		
		$__als_qry .= ", ( 	SELECT 	
		
								GROUP_CONCAT(
									JSON_OBJECT(	
										'id', IF(id_clare IS NULL, '', id_clare),
										'enc', IF(clare_enc IS NULL, '', clare_enc), 
										'tt', IF(clare_tt IS NULL, '', clare_tt), 
										'logo', IF(clare_logo IS NULL, '', clare_logo), 	
										'cod', IF(clare_cod IS NULL, '', clare_cod), 
										'clr', IF(clare_clr IS NULL, '', clare_clr)
									)
									SEPARATOR ','
								)	
							
							FROM "._BdStr(DBM).TB_SIS_CNT_EST_ARE."
								 INNER JOIN "._BdStr(DBM).TB_CL_ARE." ON siscntestare_are = id_clare
							WHERE siscntestare_est = id_siscntest  AND clare_est = 1
							
						) AS __are_ls "; 
		 
		$Ls_Whr = "FROM "._BdStr(DBM).TB_SIS_CNT_EST."
					    INNER JOIN "._BdStr(DBM).TB_SIS_CNT_EST_TP." ON siscntest_tp = id_siscntesttp
						INNER JOIN "._BdStr(DBM).TB_CL." ON siscntest_cl = id_cl
				   WHERE cl_enc = '".DB_CL_ENC."' ".$___Ls->sch->cod."  
				   ORDER BY siscntesttp_tt ASC, siscntest_tt ASC";
				   
		$___Ls->qrys = "SELECT *, (SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." {$__als_qry}  $Ls_Whr";  

	} 
	
	$___Ls->_bld(); 
	

	$__Cl = new CRM_Cl(); 
	$__mdl_s_tp = $__Cl->ClMdlSTp_Ls([ 'cl'=>$__dt_cl->id, 'sis'=>'2' ]);
	
	
?>
<?php if($___Ls->ls->chk=='ok'){ ?>
<?php $___Ls->_bld_l_hdr();?>
<?php if(($___Ls->qry->tot > 0)){ ?>

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
  	<tr>
	  	
    	<th width="1%" <?php echo NWRP ?>><?php echo TX_FM_No ?></th>
    	<th width="1%" <?php echo NWRP ?>></th>
    	<th width="45%" <?php echo NWRP ?>><?php echo TX_NM ?></th>
    	<th width="45%" <?php echo NWRP ?>><?php echo TX_ETP ?></th>
    	
    	<th width="1%" <?php echo NWRP ?>><?php echo TX_GRP ?></th>
    	<th width="1%" <?php echo NWRP ?>><?php echo MDL_CL_ARE ?></th>
    	
		<?php foreach($__mdl_s_tp->ls as $__mdl_s_tp_k=>$__mdl_s_tp_v){ ?>
		<th width="1%" <?php echo NWRP ?>><?php echo _Cns('MDL_S_TP_'.strtoupper($__mdl_s_tp_v->tp)) ?></th>
		<?php } ?>
		
		<th width="1%" <?php echo NWRP ?>></th>
		
  	</tr>
  	<?php do { ?>
  	<?php 
	  	$__tt_img = fgr('<img src="'.DMN_FLE_SIS_CNT_EST.$___Ls->ls->rw['siscntest_img'].'">', '_o'); 
	  	$__are = GtSisCntEstAreLs([ 'cnx'=>$___Ls->c_r, 'est'=>$___Ls->ls->rw['id_siscntest'] ]);
	?>
  	<tr>  
	  	 
	    <td align="left" <?php echo $_clr_rw ?>><?php echo $___Ls->ls->rw[$___Ls->ino]; ?></td>
	    <td width="1%"><?php echo $__tt_img; ?></td>
	    <td width="45%" align="left" <?php echo $_clr_rw ?>>		    
		    <?php 

			    echo 	
			    		Spn('','', '_clr_icn','background-color:'.$___Ls->ls->rw['siscntest_clr_fnt'].'; ', '' ,'Fuente').
			    		Spn('','', '_clr_icn','background-color:'.$___Ls->ls->rw['siscntest_clr_bck'].'; ', '' ,'Background'). 
			    		Strn(ctjTx($___Ls->ls->rw['siscntest_tt'],'in'))/*.HTML_BR.
			    		Spn(ctjTx($___Ls->ls->rw['siscntest_clr_fnt'].' '.$___Ls->ls->rw['siscntest_clr_bck'],'in'),'ok','_f')*/; 
			    
			    echo $__are->html;		
			?>
		</td>
	    <td width="45%" align="left" <?php echo $_clr_rw ?>>
			<?php 

			    echo 	Spn('','', '_clr_icn','background-color:'.$___Ls->ls->rw['siscntesttp_clr_fnt'].'; ', '' ,'Fuente') . 
			    		Spn('','', '_clr_icn','background-color:'.$___Ls->ls->rw['siscntesttp_clr_bck'].'; ', '' ,'Background') . 
			    		ctjTx($___Ls->ls->rw['siscntesttp_tt'],'in')/*.HTML_BR.
			    		Spn(ctjTx($___Ls->ls->rw['siscntesttp_clr_fnt'].' '.$___Ls->ls->rw['siscntesttp_clr_bck'],'in'),'ok','_f')*/; 
			?>    
	    </td>    
	    
	    <td width="1%" align="left" <?php echo $_clr_rw ?>><?php echo $___Ls->ls->rw['__tot_grp']; ?></td>
		<td width="1%" align="left" <?php echo $_clr_rw ?>><?php echo $___Ls->ls->rw['__tot_are']; ?></td>    
		    
	    <?php foreach($__mdl_s_tp->ls as $__mdl_s_tp_k=>$__mdl_s_tp_v){ ?>
	    <td width="1%" align="center" <?php echo $_clr_rw ?>>

	    	<?php 
		    	
		    	$_e_sino = 2;
		    	$_e_icn = '';
		    	
		    	foreach($__mdl_s_tp_v->cntest as $_k=>$_v){	
			    	foreach($_v as $_k2=>$_v2){ 	
				    	

				    	if($_v2->id==$___Ls->ls->rw[$___Ls->ino] && $_v2->mdlstp->id==$__mdl_s_tp_v->id){

				    		if($_v2->mdlstp->est == 'ok'){ $_e_sino = 1; }
				    		
				    		if($_v2->mdlstp->dfl == 'ok'){ $_e_icn = Spn('','','icn_dfl'); }
				    	}				    	
				    	
			    	}	
		    	}
		    	
		    	echo $_e_icn._sino( $_e_sino ); ?>

		</td>
		<?php } ?>
		
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

  	<div id="<?php  echo DV_GNR_FM ?>">                         
    <form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>">
      <?php $___Ls->_bld_f_hdr(); ?> 

	  
      <div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
         <div class="ln_1">
              <div class="col_1 col"> 
                    <?php echo HTML_inp_tx('siscntest_tt', TX_NM, ctjTx($___Ls->dt->rw['siscntest_tt'],'in')); ?>
                    <?php echo LsCntEstTp('siscntest_tp','id_siscntesttp', $___Ls->dt->rw['siscntest_tp'], TX_TPDSTDO); $CntWb .= JQ_Ls('siscntest_tp', TX_TPDSTDO);?>
                    <?php echo $_bldr->UsNvl([ 'id'=>'siscntest_usnvl', 'v'=>'id_usnvl', 'va'=>$___Ls->dt->rw['siscntest_usnvl'] ]); ?> 
                    <?php         	
	                	echo OLD_HTML_chck( 'siscntest_noi', TX_ESTNOI, $___Ls->dt->rw['siscntest_noi'], 'in');
	                	echo OLD_HTML_chck( 'siscntest_buy', TX_CNTCMPRS, $___Ls->dt->rw['siscntest_buy'], 'in');
	                	echo OLD_HTML_chck( 'siscntest_asis', TX_ASIS, $___Ls->dt->rw['siscntest_asis'], 'in');
					?> 
					<div class="sac_opt">
					<?php    
						echo h2('SAC (Homologación)');     	
	                	echo OLD_HTML_chck( 'siscntest_tra_archv', TX_ARCHVD, $___Ls->dt->rw['siscntest_tra_archv'], 'in');
	                	echo OLD_HTML_chck( 'siscntest_tra_cncl', 'Cancelada', $___Ls->dt->rw['siscntest_tra_cncl'], 'in');
						echo OLD_HTML_chck( 'siscntest_tra_cmpl', 'Completada', $___Ls->dt->rw['siscntest_tra_cmpl'], 'in');
						echo OLD_HTML_chck( 'siscntest_tra_eli', 'Eliminada', $___Ls->dt->rw['siscntest_tra_eli'], 'in');
	                	echo OLD_HTML_chck( 'siscntest_tra_prc', 'En Proceso', $___Ls->dt->rw['siscntest_tra_prc'], 'in');
					?>
					</div>
			        <div class="__cx2">
				    	<div><?php echo HTML_inp_clr([ 'id'=>'siscntest_clr_bck', 'plc'=>TX_CLR.' '.TX_BCKG, 'vl'=>ctjTx($___Ls->dt->rw['siscntest_clr_bck'],'in') ]); ?> </div>  
				    	<div><?php echo HTML_inp_clr([ 'id'=>'siscntest_clr_fnt', 'plc'=>TX_CLR.' '.TX_TXFNT, 'vl'=>ctjTx($___Ls->dt->rw['siscntest_clr_fnt'],'in') ]); ?></div>  
			        </div>
			        <style>   
				        .__cx2{ display: flex; margin-top: 50px; }
				        .__cx2 div{ width: 50%; vertical-align: top; white-space: nowrap; }				        
			        </style>    
              </div>
              <div class="col_2 col"> 
                    <?php echo HTML_textarea('siscntest_dsc', TX_DSC, ctjTx($___Ls->dt->rw['siscntest_dsc'],'in'), '', 'ok'); ?> 
	                <?php foreach($__mdl_s_tp->ls as $__mdl_s_tp_k=>$__mdl_s_tp_v){ ?>
		                	
		                <?php  			                	
			                	
		                	$_e_sino = 2;
		                	$_e_dfl = 2;
		                	$_e_cls = '';
	    	
					    	foreach($__mdl_s_tp_v->cntest as $_k=>$_v){
						    	foreach($_v as $_k2=>$_v2){ 	
							    	if($_v2->id==$___Ls->dt->rw[$___Ls->ino] && $_v2->mdlstp->id==$__mdl_s_tp_v->id){
							    		if($_v2->mdlstp->est == 'ok'){
								    		$_e_sino = 1;
											$_e_cls = '_on';
							    		}
							    		if($_v2->mdlstp->dfl == 'ok'){ $_e_dfl=1; }
							    	}	
						    	}	
							}

							if($__mdl_s_tp_v->tp == 'sac' && mBln($_e_sino) == 'ok'){
								$__sac_allw = 'ok';
							}
			                
		                ?>	
		                <div class="mdl_s_tp <?php echo $_e_cls; ?>" id="mdlstp-<?php echo $__mdl_s_tp_v->enc; ?>">	
		                	<?php 	
			                	echo OLD_HTML_chck( 'siscntest_mdlstp['.$__mdl_s_tp_v->tp.'][est]', _Cns('MDL_S_TP_'.strtoupper($__mdl_s_tp_v->tp)), $_e_sino, 'in', ['c'=>'main', 'attr'=>[ 'opt-id'=>$__mdl_s_tp_v->enc, 'est-id'=>$___Ls->dt->rw[$___Ls->ino] ] ] ); 
			                ?>
							<div class="opt">	
								<?php echo OLD_HTML_chck('siscntest_mdlstp['.$__mdl_s_tp_v->tp.'][dfl]', TX_STDODFCT, $_e_dfl, 'in', ['c'=>'dfl', 'attr'=>['dfl-id'=>$__mdl_s_tp_v->enc, 'est-id'=>$___Ls->dt->rw[$___Ls->ino]] ]); ?>		
							</div>		
		                </div>
					<?php } ?>
					
					<?php 
						if($__sac_allw != 'ok'){
							echo '<style> .sac_opt{ display:none; } </style>'; 
						}
					?>

              </div>
              <div class="col_3 col">
			  		<?php if(!isN($___Ls->dt->tot)){ 
				  			$wid = '32%'; 
				  			include('sis_cnt_est_are.php');
	               	}else{
			      		$wid = '45%';        
				  	} ?>
	              
              </div> 
          </div>
      </div>
    </form>
	</div>

<?php 
	
	$CntJV .= "
		
		
		
		$('.mdl_s_tp input[type=checkbox]').off('click').click(function () {
			
	        if ($(this).is(':checked')){ var _chk='ok'; }else{ var _chk='no'; }
			
			var est_id = $(this).attr('est-id');
			var opt_id = $(this).attr('opt-id');
			var dfl_id = $(this).attr('dfl-id');
			
			if(!isN(opt_id)){	
				var d_snd = 'est';
				var d_mdlstp = opt_id;	
			}else if(!isN(dfl_id)){
				var d_snd = 'dfl';
				var d_mdlstp = dfl_id;
			}
			
			
			_Rqu({ 
				t:'sis_cnt_est', 
				d:d_snd,
				_e:_chk,
				_id_mdlstp:d_mdlstp,
				_id_est:est_id,
				_bs:function(){ $('#mdlstp-'+opt_id).addClass('_ld'); },
				_cm:function(){ $('#mdlstp-'+opt_id).removeClass('_ld'); },
				_cl:function(_r){
					if(!isN(_r)){
						if(_r.e != 'ok'){
							swal({
							  title: '".TX_TNPROBLHT."',
							  text: '".TX_DTERRO."',
							  type: 'warning',
							  showConfirmButton: false
							});	
						}else{
							if(_chk=='ok'){ 
								$('#mdlstp-'+opt_id).addClass('_on');
							}else{
								$('#mdlstp-'+opt_id).removeClass('_on');
							}
						}
					}
				} 
			});	
			
			
	    });
		
	";
	
?>

	

<style> 
	
	.col{ width: <?php echo $wid; ?> !important; display: inline-block }
	.mdl_s_tp{}
	.mdl_s_tp .opt{ display: none; padding: 10px 0 20px 0; }
	.mdl_s_tp .opt .__slc_ok{ border-radius: 10px; -moz-border-radius: 10px; -webkit-border-radius: 10px; background-color: #ebebeb; padding: 5px; border: none !important; }
	.mdl_s_tp .opt .__slc_ok h3{ border: none !important; font-size: 12px !important; font-weight: 300 !important; font-family: Roboto !important; margin-top: 0px !important;  }
	
	.mdl_s_tp._on{ border: 1px dashed #398749; padding: 10px 10px 5px 10px; border-radius: 10px; -moz-border-radius: 10px; -webkit-border-radius: 10px; margin-bottom: 10px; margin-top: 5px; }
	.mdl_s_tp._on .opt{ display: block; } 
	.mdl_s_tp._ld{ opacity: 0.4; }

</style>


</div>
<?php } ?>
<?php }

?>
