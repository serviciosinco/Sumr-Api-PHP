<?php 
if(class_exists('CRM_Cnx')){
	 	
	$___Ls->sch->f = 'sort_nm, sort_cl, sort_pml';
	
	$___Ls->new->w = 500;
	$___Ls->new->h = 350;
	$___Ls->edit->big = 'ok';
	
	$___Ls->_strt();	

	if(!isN($___Ls->gt->isb)){ $__fl .= $___Ls->_andsql([ 'f'=>'_cl.cl_enc', 'v'=>$___Ls->gt->isb ]); }
	
	if(!isN($___Ls->gt->i)){	
		
		$___Ls->qrys = sprintf("SELECT * FROM "._BdStr(DBM).TB_SORT." WHERE ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));
		
	}elseif($___Ls->_show_ls == 'ok'){ 
	

		$Ls_Whr = "	FROM "._BdStr(DBM).TB_SORT." 
						 INNER JOIN "._BdStr(DBM).TB_CL." AS _cl ON sort_cl = _cl.id_cl
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
				<th width="30%" <?php echo NWRP ?>><?php echo TX_PML ?></th>
				<th width="30%" <?php echo NWRP ?>><?php echo TX_CL?></th>
				<th width="1%" <?php echo NWRP ?>></th>
			</tr>
			<?php do { ?> 
				<tr>
					<td width="1%" <?php echo NWRP ?>><?php echo Spn($___Ls->ls->rw[$___Ls->ino]); ?></td>
					<td width="30%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['sort_nm'],'in'),40,'Pt', true); ?></td>
					<td width="30%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['sort_pml'],'in'),40,'Pt', true); ?></td>
					<td width="30%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['cl_nm'],'in'),40,'Pt', true);?></td>
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
	  <div id="<?php  echo DV_GNR_FM ?>" > 
		                                         
	    <form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>" >
	      <?php $___Ls->_bld_f_hdr(); ?>      
		  <div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?> __sort_detail <?php if($___Ls->dt->tot == 0){ echo '_new'; }?>">			
	        <div class="ln_1">
		        <div class="col_1 _anm">
					<?php echo HTML_inp_tx('sort_nm', TX_NM, ctjTx($___Ls->dt->rw['sort_nm'],'in')); ?>
					<?php echo HTML_inp_tx('sort_pml', TX_PML, ctjTx($___Ls->dt->rw['sort_pml'],'in')); ?>
					<?php echo LsCl('sort_cl','id_cl', $___Ls->dt->rw["sort_cl"], TX_CL, 2); $CntWb .= JQ_Ls('sort_cl',TX_CL); ?>
		        </div>
				<div class="col_2 _anm">
					<?php echo HTML_inp_tx('sort_msv_cid', 'Massive (Id Company)', ctjTx($___Ls->dt->rw['sort_msv_cid'],'in')); ?>
					<?php echo SlDt(['t'=>'dthr', 'id'=>'sort_snce','va'=>$___Ls->dt->rw['sort_snce'],'lmt'=>'no','yr'=>'ok','mth'=>'ok','rq'=>'no','ph'=>'Fecha (Desde)']); ?>
					<?php echo HTML_textarea('sort_html', 'Html Code', ctjTx($___Ls->dt->rw['sort_html'],'in','', ['html'=>'ok','schr'=>'no','nl2'=>'no','qte'=>'no']), '', 'ok', '', 10);  ?>	
					<?php echo HTML_textarea('sort_data', 'Data Json', ctjTx($___Ls->dt->rw['sort_data'],'in','', ['html'=>'ok','schr'=>'no','nl2'=>'no','qte'=>'no']), '', 'ok', '', 10);  ?>	
				</div>
			</div>
	      </div>
	    </form>			
	  </div>
	</div>
	
	
	 <style>
	        
        .__sort_detail._new .ln_1 .col_1{ width: 100% !important; } 
        .__sort_detail._new .ln_1 .col_2{ display: none; }   
	        
	</style>

   
<?php } ?>
<?php } ?>