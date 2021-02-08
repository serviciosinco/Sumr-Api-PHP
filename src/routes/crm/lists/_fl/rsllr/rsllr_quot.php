<?php 
if(class_exists('CRM_Cnx')){
	
	$___Ls->new->w = 600;
	$___Ls->new->h = 300;
	$___Ls->new->scrl = 'no';
	
	$___Ls->ino = 'id_quot';
	$___Ls->ik = 'quot_enc';
	
	$___Ls->edit->scrl = 'ok';
	$___Ls->edit->big = 'ok';	
	$___Ls->_strt();
	
	if(!isN($___Ls->gt->isb)){ $__fl .= $___Ls->_andsql([ 'f'=>'cl_enc', 'v'=>$___Ls->gt->isb ]); }
	
	if(!isN($___Ls->gt->i)){	

		$___Ls->qrys = sprintf("SELECT *
								FROM "._BdStr(DBR).TB_RSLLR_QUOT."
									INNER JOIN "._BdStr(DBM).TB_CL." ON quot_cl = id_cl
									INNER JOIN "._BdStr(DBM).TB_ORG_SDS." ON quot_org = id_orgsds 
								    
								WHERE ".$___Ls->ik." = %s 
								LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));				 
		
	}elseif($___Ls->_show_ls == 'ok'){ 

		$Ls_Whr = "	FROM "._BdStr(DBR).TB_RSLLR_QUOT."
						INNER JOIN "._BdStr(DBM).TB_CL." ON quot_cl = id_cl 
						INNER JOIN "._BdStr(DBM).TB_ORG_SDS." ON quot_org = id_orgsds 
						INNER JOIN "._BdStr(DBM).TB_ORG." ON orgsds_org = id_org  
						INNER JOIN "._BdStr(DBM).MDL_SIS_CD_BD." ON orgsds_cd = id_siscd
						
					WHERE cl_enc != '' $__fl ".$___Ls->sch->cod." 
					ORDER BY id_quot DESC";
				   
		$___Ls->qrys = "SELECT  *, (SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." $Ls_Whr";
		
	}
		
	$___Ls->_bld();
?>
<?php if($___Ls->ls->chk=='ok'){ $__blq = 'off'; ?>

<?php $___Ls->_bld_l_hdr(); ?>
<?php if(($___Ls->qry->tot > 0)){ ?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
  	<thead>
	    <tr>
	    	<th width="1%" <?php echo NWRP ?>></th>
	        <th width="43%" <?php echo NWRP ?>><?php echo TX_NM ?></th>   
	        <th width="50%" <?php echo NWRP ?>><?php echo TX_ORG ?></th>
	        <th width="5%" <?php echo NWRP ?>><?php echo TX_FI ?></th>
	        <th width="1%" <?php echo NWRP ?>></th>   
	    </tr>
  	</thead>
  	<tbody>
	<?php do { ?>
    	<tr>
	        <td width="1%" align="left" nowrap="nowrap"><?php echo $___Ls->ls->rw[$___Ls->ino]; ?></td>
	        <td width="43%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['quot_nm'],'in'),50); ?></td>
	        <td width="50%" align="left" nowrap="nowrap"><?php echo Spn($___Ls->ls->rw['clftp_hst'],'','_f'); ?></td> 
	        <td width="5%" nowrap="nowrap"><?php echo Spn(_Tme($___Ls->ls->rw['quot_fi'], 'sng')); ?></td> 
	        <td width="1%" align="left" nowrap="nowrap" class="_btn"><?php echo $___Ls->_btn([ 't'=>'mod' ]); ?></td>  
      </tr>
      <?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>
      <?php $CntWb .= " $('#".TBGRP."_gst ._n').html('".$___Ls->qry->tot."'); "; ?>
  	</tbody>
</table>
<?php $___Ls->_bld_l_pgs(); ?>
<?php } ?>
<?php $___Ls->_h_ls_nr(); ?>
<?php } ?>
<?php if($___Ls->fm->chk=='ok'){ ?>
<div class="FmTb">
  	<div id="<?php echo $___Ls->fm->bx->id ?>" class="<?php echo DV_GNR_FM_BX ?>" >
	    <form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>" >
	      	<?php $___Ls->_bld_f_hdr(); ?>
		  	<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
				
				<?php if($___Ls->dt->tot == 0){ ?>
					
					<?php include(GL_RSLLR.'rsllr_quot_start.php'); ?>	
							
				<?php }else{ ?>
					
					<?php include(GL_RSLLR.'rsllr_quot_detail.php'); ?>
					
				<?php } ?>	
				       
		    </div>              
	    </form>
  	</div>
</div>

<?php include(GL_RSLLR.'rsllr_quot_css.php'); ?>

<?php } ?>
<?php } ?>
