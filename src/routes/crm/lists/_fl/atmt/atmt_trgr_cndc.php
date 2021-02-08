<?php 
if(class_exists('CRM_Cnx')){
	 	
	$___Ls->sch->f = '';
	$___Ls->new->w = 1000;
	$___Ls->new->h = 600;
	$___Ls->_strt();	

	if(!isN($___Ls->gt->i)){	
		
		$___Ls->qrys = sprintf("SELECT * FROM "._BdStr(DBA).TB_ATMT_TRGR_CNDC." WHERE ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));	
		
	}elseif($___Ls->_show_ls == 'ok'){ 
		
		$Ls_Whr = " FROM "._BdStr(DBA).TB_ATMT_TRGR_CNDC."
						 ".GtSlc_QryExtra(['t'=>'tb', 'col'=>'atmttrgrcndc_cndc', 'als'=>'t'])."
						 INNER JOIN "._BdStr(DBA).TB_ATMT_TRGR." ON id_atmttrgr = atmttrgrcndc_trgr
					WHERE ".$___Ls->ino." != '' AND 
						  atmttrgr_enc  = '".$___Ls->gt->isb."' 
					".$___Ls->sch->cod." 
					ORDER BY ".$___Ls->ino." DESC ";

		$___Ls->qrys = "SELECT *,
						".GtSlc_QryExtra(['t'=>'fld', 'p'=>'cndc', 'als'=>'t']).",
						(SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." $Ls_Whr";

	} 
	
	$___Ls->_bld(); 

?>
<?php if($___Ls->ls->chk=='ok'){ ?>
<?php $___Ls->_bld_l_hdr(); ?>
	<?php if(($___Ls->qry->tot > 0)){ ?>
		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
		  	<tr>
		    	<th width="1%" <?php echo NWRP ?>><?php echo TX_FM_No ?></th>
		    	<th width="19%" <?php echo NWRP ?>><?php echo "Titulo" ?></th>
		    	<th width="19%" <?php echo NWRP ?>><?php echo "Habilitado" ?></th>
		    	<th width="19%" <?php echo NWRP ?>><?php echo 'Fecha inicial' ?></th>
		    	<th width="1%" <?php echo NWRP ?>></th>
		  	</tr>
		  	<?php do { ?>
			<?php $__actdt = GtAtmtTrgrCndcDt(['id'=>$___Ls->ls->rw['id_atmttrgrcndc'], 'dt'=>'ok']); ?>
		  	<tr> 
				<td width="1%" <?php echo NWRP ?>><?php echo Spn($___Ls->ls->rw[$___Ls->ino]); ?></td>
				<td width="19%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['cndc_sisslc_tt'],'in'),40).HTML_BR.Spn($__actdt->d->tt); ?></td>
				<td width="19%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx( ( ($___Ls->ls->rw['atmttrgrcndc_hbl'] == 1)? "Activo" : "Inactivo" ) ,'in'),40); ?></td>
				<td width="19%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['atmttrgrcndc_fi'],'in'),40); ?></td>
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
		  
		<form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>" >
	      <?php $___Ls->_bld_f_hdr(); ?>      
		  <div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">			
	        
	        
	        <div class="ln_2col">
		        <div class="_c">
			        <?php 
				        echo HTML_inp_hd('atmttrgrcndc_trgr', $___Ls->gt->isb);
						$l = __Ls([ 'k'=>'sis_atmt_cndc', 'id'=>'atmttrgrcndc_cndc', 'va'=>$___Ls->dt->rw['atmttrgrcndc_cndc'], 'ph' =>'Condicional' ]);
						echo $l->html; $CntWb .= $l->js;
			        ?>
				</div>

				<div id="atmt_trgr_cndc_bx" class="_sbls">
					<?php 
						$CntWb .= "
							function _ShwCndcOpt(p=null){	
								var __id = $('#atmttrgrcndc_cndc').val();
								var __v_vl = '".$___Ls->dt->rw['atmttrgrcndc_v_vl']."';
								SUMR_Main.ld.f.slc({
									i:__id, 
									t:'atmt_trgr_cndc_ls', 
									t_i:__v_vl, 
									b:'atmt_trgr_cndc_bx'
								});
							}

							$('#atmttrgrcndc_cndc').change(function() {
								$('#atmt_trgr_cndc_bx').html('');
								_ShwCndcOpt();
							});
						";
					?>
					<?php 
						if(!isN($___Ls->dt->rw['atmttrgrcndc_cndc'])){
							$CntWb .= " _ShwCndcOpt(); ";
						}
					?>
				</div>

		        <div class="_c">
			        <?php 
				        echo OLD_HTML_chck('atmttrgrcndc_hbl', "Habilitado", $___Ls->dt->rw['atmttrgrcndc_hbl'] ); //Ricardo
			        ?>
		        </div>
	        </div>
			
			
	      </div>
	    </form>
	    
	  </div>
	</div>   
<?php } ?>
<?php } ?>