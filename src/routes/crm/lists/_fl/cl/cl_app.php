<?php 
if(class_exists('CRM_Cnx')){
	 	
	$___Ls->sch->f = 'clapp_tt';
	$___Ls->img->dir = DMN_FLE_CL_BCK_APP_CSTM;
	$___Ls->new->w = 500;
	$___Ls->new->h = 350;
	$___Ls->edit->w = 600;
	$___Ls->edit->h = 350;
	
	$___Ls->_strt();	

	if(!isN($___Ls->gt->isb)){ $__fl .= $___Ls->_andsql([ 'f'=>'_cl.cl_enc', 'v'=>$___Ls->gt->isb ]); }
	
	if(!isN($___Ls->gt->i)){	
		
		$___Ls->qrys = sprintf("	SELECT id_clapp, clapp_tt, clapp_pml, cl_sbd, clapp_enc, clapp_e, clapp_stup_act, clapp_stup_csfle
									FROM "._BdStr(DBM).TB_CL_APP."
										 INNER JOIN "._BdStr(DBM).TB_CL." AS _cl ON clapp_cl = _cl.id_cl
									WHERE ".$___Ls->ik." = %s 
									LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text")
							);
		
	}elseif($___Ls->_show_ls == 'ok'){ 
	

		$Ls_Whr = "	FROM "._BdStr(DBM).TB_CL_APP." 
						 INNER JOIN "._BdStr(DBM).TB_CL." AS _cl ON clapp_cl = _cl.id_cl
					WHERE _cl.cl_enc != '' AND ".$___Ls->ino." != '' $__fl ".$___Ls->sch->cod." 
					ORDER BY ".$___Ls->ino." DESC";

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
				<th width="30%" <?php echo NWRP ?>><?php echo TX_NM ?></th>
				<th width="30%" <?php echo NWRP ?>><?php echo TX_CL?></th>
				<th width="1%" <?php echo NWRP ?>></th>
			</tr>
			<?php do { ?> 
				<tr>
					<td width="1%" <?php echo NWRP ?>><?php echo Spn($___Ls->ls->rw[$___Ls->ino]); ?></td>
					<td width="30%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['clapp_tt'],'in'),40,'Pt', true); ?></td>
					<td width="30%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['clapp_cl'],'in'),40,'Pt', true);?></td>
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
	  <div id="<?php  echo DV_GNR_FM ?>"> 
		                                         
	    <form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>" >
	      <?php $___Ls->_bld_f_hdr(); ?>      
		  <div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?> app_dashboard">			
	        <div class="ln_1">
  				<div>
					<div class="col_1">
						<?php echo HTML_inp_tx('clapp_tt', TX_NM, ctjTx($___Ls->dt->rw['clapp_tt'],'in')); ?>
						<?php echo HTML_inp_tx('clapp_pml', TX_PML, ctjTx($___Ls->dt->rw['clapp_pml'],'in')); ?>
						<?php echo LsCl('clapp_cl','id_cl', (!isN($___Ls->dt->rw["clapp_cl"])?$___Ls->dt->rw["clapp_cl"]:$___Ls->gt->isb) , TX_CL, 2); $CntWb .= JQ_Ls('clapp_cl',TX_CL); ?>
						<?php echo h2(TX_VWONL). '<a href="'.DMN_APP.$___Ls->dt->rw['cl_sbd'].'/'.$___Ls->dt->rw['clapp_enc'].'?__r='.Gn_Rnd(6).'" target="_blank" class="___onl_btn">Ir a URL</a>'; ?>	
		          	</div>
		          	<div class="col_2">
			          	<?php echo OLD_HTML_chck('clapp_e', TX_ACTV, $___Ls->dt->rw['clapp_e'], 'in'); ?>
							<?php echo OLD_HTML_chck('clapp_stup_act', 'Setup (Mostrar Actividades)', $___Ls->dt->rw['clapp_stup_act'], 'in'); ?>
						  	<?php echo OLD_HTML_chck('clapp_stup_csfle', 'Custom Files', $___Ls->dt->rw['clapp_stup_csfle'], 'in'); ?>

							<?php if(($___Ls->dt->tot > 0)){ ?>												
								<div class="ln_1"><div id="_upl_fle"></div></div>
								<?php $CntWb .= "_ldCnt({ u:'".Fl_Rnd(FL_FM_GN.__t('up_app',true)).Fl_i($___Ls->dt->rw[$___Ls->ik])."', c:'_upl_fle' });"; ?>								
							<?php } ?>
		          	</div>
	          	</div>
		        <?php if($___Ls->dt->tot > 0){ ?>
		        
			        <div style="margin-top: 30px;">
						<div class="col_1">						
							<div class="icn">Iconos Dashboard</div>
					  		<?php	
				                $__act_icn = _DvLs([ 'id'=>'icn', 'i'=>$___Ls->gt->i, 't'=>'cl_app_icn', 't2'=>$___Ls->gt->tsb ]);
						        echo $__act_icn->html; $CntJV .= $__act_icn->jv; $CntWb .= $__act_icn->js;   
							?>	
			          	</div>
			          	<div class="col_2">
				          	
				          	<div class="tp">Modulos Dashboard</div>
					  		<?php
				                $__act_tp = _DvLs([ 'id'=>'tp', 'i'=>$___Ls->gt->i, 't'=>'cl_app_tp', 't2'=>$___Ls->gt->tsb ]);
						        echo $__act_tp->html; $CntJV .= $__act_tp->jv; $CntWb .= $__act_tp->js;
							?>
			          	</div>
		          	</div>
	          	
				<?php } ?>
  				
					
			</div>
	      </div>
		</form>

	  </div>
	</div>   
	
	<style>
		
		.app_dashboard{}
		
		.app_dashboard div.icn,
		.app_dashboard div.tp{ display: block; width: 100%; text-transform: uppercase; text-align: center; font-family: Economica; font-size: 17px; color: #a5a6a6; margin-bottom: 30px; }
		
		.app_dashboard div.icn::before,
		.app_dashboard div.tp::before{ width: 25px; height: 25px; display: inline-block; margin-bottom: -5px; margin-right: 10px; background-repeat: no-repeat; background-position: center center; background-size: auto 100%; }
		
		
		.app_dashboard div.icn::before{ background-image:url('<?php echo DMN_IMG_ESTR_SVG ?>app_icns.svg'); }
		.app_dashboard div.tp::before{ background-image:url('<?php echo DMN_IMG_ESTR_SVG ?>app_tp.svg'); }
		
		
		
		
		
	</style>
	
	
<?php } ?>
<?php } ?>