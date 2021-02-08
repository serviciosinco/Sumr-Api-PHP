<?php
if(class_exists('CRM_Cnx')){

	$___Ls->cnx->cl = 'ok';
	$___Ls->sch->f = 'mdl_nm';	
	$___Ls->new->w = 800;
	$___Ls->new->h = 400;
	$___Ls->edit->w = 800;
	$___Ls->edit->h = 400;
	
	$___Ls->_strt();
    

	if(!isN($___Ls->gt->i)){
	
		$___Ls->qrys = sprintf("SELECT * FROM ".TB_MDL_US." WHERE ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));
	
	}elseif($___Ls->_show_ls == 'ok'){  
        
        if(_SbLs_ID('i') && $___Ls->gt->tsb == 'mdl'){	
            $__fl .= " AND mdl_enc = ".GtSQLVlStr($___Ls->gt->isb, "text")." "; 
        }else{
			$__fl .= " AND us_enc = ".GtSQLVlStr($___Ls->gt->isb, "text")." "; 	
		}	

		$Ls_Whr = "	FROM ".TB_MDL_US."
                         INNER JOIN ".TB_MDL." ON mdlus_mdl = id_mdl
                         INNER JOIN "._BdStr(DBM).TB_US." ON mdlus_us = id_us
                         ".GtSlc_QryExtra([ 't'=>'tb', 'col'=>'mdlus_tp', 'als'=>'t' ])."
					WHERE ".$___Ls->ino." != '' ".$___Ls->sch->cod." {$__fl}
					ORDER BY ".$___Ls->ino." DESC";
					
        $___Ls->qrys = "SELECT  mdl_nm, us_nm, us_ap, us_user, mdlus_enc,
                                "._QrySisSlcF([ 'als'=>'t', 'als_n'=>'Tipo' ]).",
                                ".GtSlc_QryExtra([ 't'=>'fld', 'p'=>'Tipo', 'als'=>'t' ]).",
                                (SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." 
						$Ls_Whr";
        
	} 
	
	$___Ls->_bld();
	
?>

<?php if($___Ls->ls->chk=='ok'){ ?>
	<?php $___Ls->_bld_l_hdr(); ?>
	<?php if(($___Ls->qry->tot > 0)){ ?>
		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
			<tr>
				<th width="1%" <?php echo NWRP ?>><?php echo TX_FM_No ?></th>
				<?php if($___Ls->gt->tsb == 'mdl'){ ?>
					<th width="49%" <?php echo NWRP ?>><?php echo TX_US ?></th>
				<?php }else{ ?>
					<th width="49%" <?php echo NWRP ?>><?php echo TX_MDL ?></th>
				<?php } ?>
				<th width="49%" <?php echo NWRP ?>><?php echo TX_TP ?></th>
				<th width="1%" <?php echo NWRP ?>></th>
			</tr>
			<?php do { ?>
				<tr>    
					<td width="1%" <?php echo NWRP ?>><?php echo Spn($___Ls->ls->rw[$___Ls->ino]); ?></td>

					<?php if($___Ls->gt->tsb == 'mdl'){ ?>
						<td width="49%" align="left" nowrap="nowrap">
							<?php echo ShortTx(ctjTx($___Ls->ls->rw['us_nm'].' '.$___Ls->ls->rw['us_ap'],'in'),40,'Pt', true).HTML_BR.
										Spn(ctjTx($___Ls->ls->rw['us_user'],'in'));
							?>
						</td>
					<?php }else{ ?>
						<td width="49%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['mdl_nm'],'in'),40,'Pt', true); ?></td>
					<?php } ?>
				
					<td width="49%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['Tipo_sisslc_tt'],'in'),40,'Pt', true) ?></td>
					<td width="1%" align="left" class="_btn"><?php echo $___Ls->_btn([ 't'=>'mod' ]); ?></td>
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
				<form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>">
					<?php $___Ls->_bld_f_hdr(); ?>   
					<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>"> 
						<div class="ln_1">

							<?php 
							
								if($___Ls->gt->tsb == 'mdl'){
									$__mdl_d = GtMdlDt([ 'id'=>$___Ls->gt->isb, 't'=>'enc' ]);
									echo HTML_inp_hd('mdlus_mdl', $__mdl_d->id);
									echo LsUs('mdlus_us','id_us', $___Ls->dt->rw['mdlus_us'] ,'Usuarios', 2,'no'); $CntWb .= JQ_Ls('mdlus_us','Usuarios');
								}else{
									$_us_dt = GtUsDt($___Ls->gt->isb, 'enc');
									echo HTML_inp_hd('mdlus_us', $_us_dt->id);
									echo LsMdl('mdlus_mdl', 'id_mdl', $___Ls->dt->rw['mdlus_mdl'], TX_MDL, 2, '', [ 'prfx'=>'mdlstp_nm' ]); $CntWb .= JQ_Ls('mdlus_mdl', TX_MDL);
								}

							?> 

                            <?php 
                                $l = __Ls([ 'k'=>'us_rol', 'id'=>'mdlus_tp', 'v'=>'', 'va'=>$___Ls->dt->rw['mdlus_tp'], 'ph' =>'' ]);
                                echo $l->html; $CntWb .= $l->js;
                            ?>
						</div>
					</div>
				</form>
			</div>
		</div>
	<?php } ?>
<?php } ?> 