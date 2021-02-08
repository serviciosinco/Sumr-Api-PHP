<?php
if(class_exists('CRM_Cnx')){
	
	$___Ls->sch->f = 'aud_v, aud_db, aud_ip, us_nm, us_ap';

	$___Ls->edit->w = 800;
	$___Ls->edit->h = 800;

	$___Ls->_strt();
	
	
	if(!isN($___Ls->gt->i)){	

		for($i = 1; $i <= 5; $i++){
			$_fl_v .= ", ( SELECT audvl_vl FROM ".MDL_AUD_VL_BD." WHERE audvl_key = '[v".$i."]' AND audvl_aud = id_aud ) AS _vl_".$i." ";
		}
		
		$_fl_aud .= ", ( SELECT sisslcf_vl FROM ".TB_SIS_SLC_F." WHERE sisslcf_slc = aud_auddsc AND sisslcf_f = 39 ) AS _aud_dsc";
		
		$___Ls->qrys = sprintf("SELECT * $_fl_aud $_fl_v FROM ".MDL_AUD_BD." 
									INNER JOIN ".TB_US." ON aud_us = id_us 
								WHERE ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));
		
	}elseif($___Ls->_show_ls == 'ok'){ 
		
		for($i = 1; $i <= 5; $i++){
			$_fl_v .= ", ( SELECT audvl_vl FROM ".MDL_AUD_VL_BD." WHERE audvl_key = '[v".$i."]' AND audvl_aud = id_aud ) AS _vl_".$i." ";
		}
		
		$_fl_aud .= ", ( SELECT sisslcf_vl FROM ".TB_SIS_SLC_F." WHERE sisslcf_slc = aud_auddsc AND sisslcf_f = 39 ) AS _aud_dsc";
		

		$Ls_Whr = "FROM ".MDL_AUD_BD." 
						INNER JOIN ".TB_US." ON aud_us = id_us
						INNER JOIN ".TB_US_SES." ON aud_ses = id_uses
						WHERE ".$___Ls->ino." != '' ".$___Ls->sch->cod." AND uses_cl = ".DB_CL_ID."
						ORDER BY ".$___Ls->ino." DESC";
						

		$___Ls->qrys = "SELECT * $_fl_aud $_fl_v , (SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." $Ls_Whr"; 
	
	} 
	
	$___Ls->_bld();
?>
<?php if($___Ls->ls->chk=='ok'){ ?>
<?php $___Ls->_bld_l_hdr(); ?>
<?php if(($___Ls->qry->tot > 0)){ ?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
  	<tr>
	    <th width="1%" <?php echo NWRP ?>><?php echo TX_FM_No ?></th>
	    <th width="10%" <?php echo NWRP ?>><?php echo TX_USR ?></th>
	    <th width="30%" <?php echo NWRP ?>><?php echo MDL_AUD ?></th>
		<th width="10%" <?php echo NWRP ?>><?php echo TX_SES ?></th>
		<th width="10%" <?php echo NWRP ?>><?php echo TX_IP ?></th>
		<th width="10%" <?php echo NWRP ?>><?php echo TX_FIN ?></th>
		<th width="1%" <?php echo NWRP ?>></th>
	</tr>
  	<?php do { ?>
  	<tr>
	    <td width="1%" <?php echo NWRP ?>><?php echo Spn($___Ls->ls->rw[$___Ls->ino]); ?></td>
	    <td width="10%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['us_nm']." ".$___Ls->ls->rw['us_ap'],'in'),40,'Pt', true); ?></td>
	    <td width="30%" align="left" nowrap="nowrap"><?php echo ctjTx(strtr( $___Ls->ls->rw['_aud_dsc'], ['[v1]'=>$___Ls->ls->rw['_vl_1'],
		    																							   '[v2]'=>$___Ls->ls->rw['_vl_2'],
		    																							   '[v3]'=>$___Ls->ls->rw['_vl_3'],
		    																							   '[v4]'=>$___Ls->ls->rw['_vl_4'],
		    																							   '[v5]'=>$___Ls->ls->rw['_vl_5']] ),'in'); ?></td>
		
		<td width="10%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['aud_ses'],'in'),40,'Pt', true); ?></td>
		<td width="10%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['aud_ip'],'in'),40,'Pt', true); ?></td>
		<td width="10%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['aud_fi'],'in'),40,'Pt', true); ?></td>
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
<div class="FmTb">
  <div id="<?php echo $___Ls->fm->bx->id ?>" class="<?php echo DV_GNR_FM_BX ?>" >

	
    <form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>" >

      <div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
	  
        <div class="ln_1 <?php echo $__cls_divcol; ?>">
			<?php echo h1(ctjTx(strtr( $___Ls->dt->rw['_aud_dsc'], ['[v1]'=>$___Ls->dt->rw['_vl_1'],
																'[v2]'=>$___Ls->dt->rw['_vl_2'],
																'[v3]'=>$___Ls->dt->rw['_vl_3'],
																'[v4]'=>$___Ls->dt->rw['_vl_4'],
																'[v5]'=>$___Ls->dt->rw['_vl_5']] ),'in')); ?>
			<div class="col_1">
				<ul class="dt_aud">
					<li><?php echo ShortTx(ctjTx('Usuario: '.$___Ls->dt->rw['us_nm']." ".$___Ls->dt->rw['us_ap'],'in'),40,'Pt', true).HTML_BR; ?></li>
					<li><?php echo ctjTx('Fecha: '.$___Ls->dt->rw['aud_fi'],'in').HTML_BR; ?></li>
				</ul>
			</div>
			<div class="col_2">
				<?php echo h2('POST'); ?>
				<?php $vl = json_decode($___Ls->dt->rw['aud_v']); ?>
				<ul class="list_aud">
					<?php 
						foreach($vl as $k => $v){
							if($k != 'ec_cd'){
								echo '<li>'.$k.' : '.$v.'</li>';
							}
						}
					?>
				</ul>
			</div>
        </div>
      </div>
    </form>
  </div>
</div>
<?php } ?>
<?php } ?> 
<style>

.dt_aud{ list-style-type: none; }
.list_aud{

	border: 3px dashed gray;
    border-radius: 12px;
    list-style-type: none;
    background-color: #e8e8e8;
    padding: 20px;

}

.list_aud li{ cursor:pointer; }
.list_aud li:hover{ background-color: #cacaca; }

</style>