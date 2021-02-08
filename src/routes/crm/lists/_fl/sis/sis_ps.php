<?php
if(class_exists('CRM_Cnx')){
	
	$___Ls->sch->f = 'sisps_tt';
	
	$___Ls->new->w = 800;
	$___Ls->new->h = 400;
	$___Ls->edit->w = 800;
	$___Ls->edit->h = 400;
	$___Ls->img->dir = DMN_FLE_PS;
		
	$___Ls->_strt();
	
	if(!isN($___Ls->gt->i)){	
		

		$___Ls->qrys = sprintf("SELECT * FROM ".TB_SIS_PS." WHERE ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));
		
	}elseif($___Ls->_show_ls == 'ok'){  
		 
		$Ls_Whr = "FROM "._BdStr(DBM).TB_SIS_PS." WHERE  ".$___Ls->ino." != '' ".$___Ls->sch->cod." ORDER BY ".$___Ls->ino." DESC";
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
		<th width="49%" <?php echo NWRP ?>><?php echo TT_FM_PS ?></th>
		<th width="1%" <?php echo NWRP ?>></th>
  	</tr>
  	<?php do { ?>
	<tr>    
		<td width="1%" <?php echo NWRP ?>><?php echo Spn($___Ls->ls->rw[$___Ls->ino]); ?></td>
		<td width="49%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['sisps_tt'],'in'),40,'Pt', true); ?></td>
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
	<form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>">
    	<?php $___Ls->_bld_f_hdr(); ?>   
		<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>"> 
        <div class="ln_1">
	        <div class="col_1">

				<?php /*Constantes Ricardo*/ ?>
	        	<?php echo LsLng(['id'=>'sisps_lng', 'v'=>'id_sislng', 'va'=>$___Ls->dt->rw['sisps_lng'], 'rq'=>1 ]); $CntWb .= JQ_Ls('sisps_lng','Lenguaje'); ?>
        	
				<?php echo HTML_inp_tx('sisps_tt', TT_FM_PS , ctjTx($___Ls->dt->rw['sisps_tt'],'in'), FMRQD); ?>   
				<?php echo HTML_inp_tx('sisps_iso2', 'ISO 2' , ctjTx($___Ls->dt->rw['sisps_iso2'],'in'), FMRQD); ?>
				<?php echo HTML_inp_tx('sisps_iso3', 'ISO 3' , ctjTx($___Ls->dt->rw['sisps_iso3'],'in'), FMRQD); ?>  	
	        </div>
	        <div class="col_2">
	        	<?php echo HTML_inp_tx('sisps_cia', 'CIA' , ctjTx($___Ls->dt->rw['sisps_cia'],'in'), FMRQD); ?> 
				<?php echo HTML_inp_tx('sisps_tel', 'Indicativo Telefono' , ctjTx($___Ls->dt->rw['sisps_tel'],'in'), FMRQD); ?>
				<?php echo HTML_inp_tx('sisps_int', 'Indicativo Intenet' , ctjTx($___Ls->dt->rw['sisps_int'],'in'), FMRQD); ?>	
	        </div>
	        
			
			
        </div>
      </div>
    </form>
  </div>
</div>
<?php } ?>

<?php } ?> 

