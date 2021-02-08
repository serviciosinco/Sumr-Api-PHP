<?php
if(class_exists('CRM_Cnx')){
	
	$___Ls->sch->f = 'sisbd_nm';
	
	$___Ls->new->w = 800;
	$___Ls->new->h = 600;
	$___Ls->edit->w = 800;
	$___Ls->edit->h = 600;
	$___Ls->img->dir = DMN_FLE_BD;
		
	$___Ls->_strt();
	
	if(!isN($___Ls->gt->i)){	
		

		$___Ls->qrys = sprintf("SELECT * FROM ".TB_SIS_BD."
									WHERE ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));
		
	}elseif($___Ls->_show_ls == 'ok'){  
		 
		$Ls_Whr = "FROM "._BdStr(DBM).TB_SIS_BD." WHERE  ".$___Ls->ino." != '' ".$___Ls->sch->cod." ORDER BY ".$___Ls->ino." DESC";
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
    	<th width="1%" <?php echo NWRP ?>><?php echo TX_IMG ?></th>
		<th width="49%" <?php echo NWRP ?>><?php echo TX_NM ?></th>
		
		<th width="1%" <?php echo NWRP ?>><?php echo 'Modo Tabs' ?></th>
		<th width="1%" <?php echo NWRP ?>><?php echo 'Email' ?></th>
		<th width="1%" <?php echo NWRP ?>><?php echo 'Documentos' ?></th>
		<th width="1%" <?php echo NWRP ?>><?php echo 'Telefonos' ?></th>
		<th width="1%" <?php echo NWRP ?>><?php echo 'Ciudades' ?></th>
		<th width="1%" <?php echo NWRP ?>><?php echo 'Universidades' ?></th>
		<th width="1%" <?php echo NWRP ?>><?php echo 'Colegio' ?></th>
		<th width="v%" <?php echo NWRP ?>><?php echo 'Empresas' ?></th>
		
		<th width="v%" <?php echo NWRP ?>><?php echo 'Medio' ?></th>
		<th width="v%" <?php echo NWRP ?>><?php echo 'Fuentes' ?></th>
		
		<th width="1%" <?php echo NWRP ?>></th>
  	</tr>
  	<?php do { 
	  	$__tt_img = fgr('<img src="'.DMN_FLE_BD.$___Ls->ls->rw['sisbd_img'].'">');  	
  	?>
	<tr>   
		<td width="1%" <?php echo NWRP ?>><?php echo Spn($___Ls->ls->rw[$___Ls->ino]); ?></td>
		<td width="1%" align="left"><?php echo $__tt_img; ?></td> 
		<td width="49%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['sisbd_nm'],'in'),40,'Pt', true); ?></td>
		
		<td width="1%" align="left" nowrap="nowrap"><?php echo _sino($___Ls->ls->rw['sisbd_tabs']); ?></td>
		<td width="1%" align="left" nowrap="nowrap"><?php echo _sino($___Ls->ls->rw['sisbd_eml']); ?></td>
		<td width="1%" align="left" nowrap="nowrap"><?php echo _sino($___Ls->ls->rw['sisbd_dc']); ?></td>
		<td width="1%" align="left" nowrap="nowrap"><?php echo _sino($___Ls->ls->rw['sisbd_tel']); ?></td>
		<td width="1%" align="left" nowrap="nowrap"><?php echo _sino($___Ls->ls->rw['sisbd_cd']); ?></td>
		<td width="1%" align="left" nowrap="nowrap"><?php echo _sino($___Ls->ls->rw['sisbd_uni']); ?></td>
		<td width="1%" align="left" nowrap="nowrap"><?php echo _sino($___Ls->ls->rw['sisbd_clg']); ?></td>
		<td width="1%" align="left" nowrap="nowrap"><?php echo _sino($___Ls->ls->rw['sisbd_emp']); ?></td>
		
		<td width="1%" align="left" nowrap="nowrap"><?php echo _sino($___Ls->ls->rw['sisbd_md']); ?></td>
		<td width="1%" align="left" nowrap="nowrap"><?php echo _sino($___Ls->ls->rw['sisbd_fnt']); ?></td>
		
		
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
				<?php echo HTML_inp_tx('sisbd_nm', TT_FM_NM , ctjTx($___Ls->dt->rw['sisbd_nm'],'in'), FMRQD); ?>   
				<?php echo HTML_inp_tx('sisbd_usnvl', 'Nivel Usuario' , ctjTx($___Ls->dt->rw['sisbd_usnvl'],'in'), FMRQD); ?> 	
				
				<?php 
					
					echo h2('Campos Editables');
					echo OLD_HTML_chck('sisbd_fld_nm', "Nombre", $___Ls->dt->rw['sisbd_fld_nm'] ); 
		        	echo OLD_HTML_chck('sisbd_fld_ap', "Apellido", $___Ls->dt->rw['sisbd_fld_ap'] );
					
					echo h2('Campos Adicionales');
					echo OLD_HTML_chck('sisbd_fn', "Fecha de Nacimiento", $___Ls->dt->rw['sisbd_fn'] ); 
		        	echo OLD_HTML_chck('sisbd_gnr', "Genero", $___Ls->dt->rw['sisbd_gnr'] );
		        	
		        	
					
				?>
				
	        </div>
	        <div class="col_2">
	        	<?php 
				        	
		        	echo h2('Tabs'); 
		        	echo OLD_HTML_chck('sisbd_comp', "Comprimido", $___Ls->dt->rw['sisbd_comp'] );
		        	echo OLD_HTML_chck('sisbd_tabs', "Modo Tab", $___Ls->dt->rw['sisbd_tabs'] ); 
		        	echo OLD_HTML_chck('sisbd_eml', "Email", $___Ls->dt->rw['sisbd_eml'] );
		        	echo OLD_HTML_chck('sisbd_dc', "Documentos", $___Ls->dt->rw['sisbd_dc'] );
		        	echo OLD_HTML_chck('sisbd_tel', "Telefonos", $___Ls->dt->rw['sisbd_tel'] );
		        	echo OLD_HTML_chck('sisbd_cd', "Ciudades", $___Ls->dt->rw['sisbd_cd'] );
		        	echo OLD_HTML_chck('sisbd_uni', "Universidad", $___Ls->dt->rw['sisbd_uni'] );
		        	echo OLD_HTML_chck('sisbd_clg', "Colegio", $___Ls->dt->rw['sisbd_clg'] );
		        	echo OLD_HTML_chck('sisbd_emp', "Empresas", $___Ls->dt->rw['sisbd_emp'] );
		        	echo OLD_HTML_chck('sisbd_md', "Medio", $___Ls->dt->rw['sisbd_md'] );
		        	echo OLD_HTML_chck('sisbd_fnt', "Fuente", $___Ls->dt->rw['sisbd_fnt'] );
		        	
	        	?>
	        </div>
        </div>
      </div>
    </form>
  </div>
</div>
<?php } ?>

<?php } ?> 

