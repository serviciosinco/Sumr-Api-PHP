<?php
if(class_exists('CRM_Cnx')){
	
	$___Ls->sch->f = 'sismd_tt, sismd_clr';
	
	$___Ls->new->w = 500;
	$___Ls->new->h = 400;
	$___Ls->edit->w = 600;
	$___Ls->edit->h = 700;
	$___Ls->img->dir = DMN_FLE_SIS_MD;
	$___Ls->ls->lmt = 500;
	
	$___Ls->_strt();
	
	if(!isN($___Ls->gt->i)){
		
		$___Ls->qrys = sprintf("SELECT * FROM "._BdStr(DBM).TB_SIS_MD." WHERE ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));
		
	}elseif($___Ls->_show_ls == 'ok'){ 	
		 
		$Ls_Whr = "	FROM "._BdStr(DBM).TB_SIS_MD." 
						 INNER JOIN "._BdStr(DBM).TB_SIS_MD_TP." ON sismd_tp = id_sismdtp
					WHERE ".$___Ls->ino." != '' ".$___Ls->sch->cod." ORDER BY sismd_tt ASC";
		$___Ls->qrys = "SELECT *, (SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." $Ls_Whr";
	
		
	} 
	
	$___Ls->_bld(); 
	
?>
<?php if($___Ls->ls->chk=='ok'){ ?>
<?php $___Ls->_bld_l_hdr(); ?>
<?php if(($___Ls->qry->tot > 0)){ ?>

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
  	<tr>
    	<th width="2%" <?php echo NWRP ?>><?php echo TX_FM_No ?></th>
    	<th width="1%" <?php echo NWRP ?>></th>
		<th width="50%" <?php echo NWRP ?>><?php echo TX_NM ?></th>
		<th width="1%" <?php echo NWRP ?>><?php echo TX_CLR ?></th>
		<th width="1%" <?php echo NWRP ?>><?php echo TX_TP ?></th>
		<th width="1%" <?php echo NWRP ?>><?php echo TX_HBSACCPT ?></th>
		<th width="1%" <?php echo NWRP ?>><?php echo TX_MD_DFLT ?></th>
		<th width="1%" <?php echo NWRP ?>><?php echo 'DEFAULT WEB'; ?></th>
		<th width="1%" <?php echo NWRP ?>></th>
  	</tr>
  	<?php do { 
	  
	  	$__cl_o = GtSisMdClLs([ 'sismd'=>$___Ls->ls->rw['id_sismd'] ]);
		$__cl = '';
			  
		foreach($__cl_o->ls as $__cl_o_k=>$__cl_o_v){

			$__cl .= '<li style="background-image:url('.$__cl_o_v->cl->img->th_50.');" 
						  alt="'.ctjTx( $__cl_o_v->cl->nm ,'in').'" 
						  title="'.ctjTx( $__cl_o_v->cl->nm ,'in').'"> </li>' ;
			
		}
		
		
		$__tt_img = fgr('<img src="'.DMN_FLE_SIS_MD.$___Ls->ls->rw['sismd_img'].'">', '_o'); 
		
  	?>
  	<tr>    
	    <td align="left" <?php echo $_clr_rw ?>><?php echo $___Ls->ls->rw[$___Ls->ino]; ?></td>
	    <td width="1%"><?php echo $__tt_img; ?></td>
	    <td width="50%" align="left" <?php echo $_clr_rw ?>><?php echo ctjTx($___Ls->ls->rw['sismd_tt'],'in').ul($__cl, '_cl_avatar'); ?></td>
	    <td width="1%" align="left" <?php echo $_clr_rw ?>><?php echo Spn('','', '_clr_icn','background-color:'.$___Ls->ls->rw['sismd_clr'].'; ') . ctjTx($___Ls->ls->rw['sismd_clr'],'in'); ?></td>
	    <td width="1%" align="left" <?php echo $_clr_rw ?>><?php echo ctjTx($___Ls->ls->rw['sismdtp_tt'],'in'); ?></td>
	    <td width="1%" align="left" <?php echo $_clr_rw ?>><?php echo Spn(mBln($___Ls->ls->rw['sismd_sndi']),'',mBln($___Ls->ls->rw['sismd_sndi'])); ?></td>
		<td width="1%" align="left" <?php echo $_clr_rw ?>><?php echo Spn(mBln($___Ls->ls->rw['sismd_dfl']),'',mBln($___Ls->ls->rw['sismd_dfl'])); ?></td> 
		<td width="1%" align="left" <?php echo $_clr_rw ?>><?php echo Spn(mBln($___Ls->ls->rw['sismd_dflt_wb']),'',mBln($___Ls->ls->rw['sismd_dflt_wb'])); ?></td>
	    <td width="1%" align="left" nowrap="nowrap" class="_btn"><?php echo $___Ls->_btn([ 't'=>'mod' ]); ?></td>
  	</tr>
  	<?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>
  	
  	<style>
	  	
	  	figure._o{ border-radius:200px; -moz-border-radius:200px; -webkit-border-radius:200px; overflow: hidden; }
	  	
	</style>  	
</table>
<?php $___Ls->_bld_l_pgs(); ?>
<?php } ?>
<?php $___Ls->_h_ls_nr(); ?>
<?php } ?>
<?php if($___Ls->fm->chk=='ok'){ ?>
<div class="FmTb">
  <div id="<?php echo $___Ls->fm->bx->id ?>" class="<?php echo DV_GNR_FM_BX ?>">
    <form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>">
      	<?php $___Ls->_bld_f_hdr();?>
     	<div class="__cl_slc">  
	      	<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
	         	<div class="ln_1">
		         	<div class="col_1">
						<?php
						 	if(!isN($___Ls->dt->rw['sismd_key'])){
								echo h1(strtoupper( 'SIS_MD_'.str_replace('_','',$___Ls->dt->rw['sismd_key']) ), 'id_cns'); 
							}
						?>
			        	<?php echo HTML_inp_tx('sismd_tt', TX_NM, ctjTx($___Ls->dt->rw['sismd_tt'],'in')).HTML_BR; ?> 
	                	<?php echo HTML_inp_clr([ 'id'=>'sismd_clr', 'plc'=>TX_CLR, 'vl'=>ctjTx($___Ls->dt->rw['sismd_clr'],'in') ]).HTML_BR; ?>
	                    <?php //echo HTML_inp_clr('sismd_clr', TX_CLR, ctjTx($___Ls->dt->rw['sismd_clr'],'in')); ?>
	                    <?php echo HTML_inp_tx('sismd_key', TX_KEY, ctjTx($___Ls->dt->rw['sismd_key'],'in')); ?>                   		
		         	</div>
		         	<div class="col_2">
						<?php echo OLD_HTML_chck('sismd_dflt', TX_MD_DFLT, $___Ls->dt->rw['sismd_dflt'], 'in'); ?> 	
						<?php echo OLD_HTML_chck('sismd_dflt_wb', 'Medio por default (Web)', $___Ls->dt->rw['sismd_dflt_wb'], 'in'); ?>
						<?php echo OLD_HTML_chck('sismd_sndi', TX_HBSACCPT.' (por defecto)', $___Ls->dt->rw['sismd_sndi'], 'in').HTML_BR; ?>	
			        	<?php echo $_bldr->UsNvl([ 'id'=>'sismd_usnvl', 'v'=>'id_usnvl', 'va'=>$___Ls->dt->rw['sismd_usnvl'] ]); ?>
			        	<?php 
		                    echo LsSisMdTp('sismd_tp','id_sismdtp', $___Ls->dt->rw['sismd_tp'], TX_SLCTP, 2); 
		                    $CntWb .= JQ_Ls('sismd_tp', TX_SLCTP); 
		                ?>
		         	</div>
                	  
	                <?php if($___Ls->dt->tot > 0){ ?>
			          	<div class="ln">
			                <?php echo bdiv([ 'id'=>DV_LSFL.'_cl' ]) ?>
			                <?php       
								$CntJV .= _DvLsFl_Vr([ 'i'=>$___Ls->dt->rw[$___Ls->ino], 'n'=>'_cl', 't'=>'sis_md_cl' ]);		  
								$CntWb .= _DvLsFl([ 'i'=>'_cl', 't'=>'s' ]); 
							?> 
			            </div> 
					<?php } ?>
	          	</div>
	      	</div>
	    </div>
    </form>
  </div>


</div>
<?php } ?>
<?php } 
	
?>
