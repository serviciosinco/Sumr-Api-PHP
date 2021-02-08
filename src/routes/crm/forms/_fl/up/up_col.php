<?php
if(class_exists('CRM_Cnx')){
	
 	
$__id = 'id_upcol'; // Id de Ciudades
$__bd = _BdStr(DBP).MDL_UP_COL_BD; // Base de Datos sis_lnd_fld
$__bd2 = _BdStr(DBP).MDL_UP_BD; // Base de Datos sis_lnd_fld
$__bdtp = 'up_col'; // Tipo de Datos
$__fmnm = 'EdUpCol'; // Nombre Formulario


for ($i = 0; $i <= (UPCOL_CNT); $i++) { 
	$__sch_mre[] = 'upcol_'.$i; 
} 

$__sch_mre_v = implode(',', $__sch_mre);

if (isset($_GET['_i'])) {
	 
	$Dt_Qry = sprintf("	SELECT * 
						FROM $__bd, $__bd2 
						WHERE upcol_up = id_up AND $__id = %s 
						LIMIT 1", GtSQLVlStr($_GET['_i'], "int"));
						
	$Dt_Rg = $__cnx->_qry($Dt_Qry);
	$row_Dt_Rg = $Dt_Rg->fetch_assoc();
	$Tot_Dt_Rg = $Dt_Rg->num_rows;
	
}
	
?>

<?php if($Tot_Dt_Rg > 0){ ?>

<div class="FmTb">
	<div class="__btns"><input type="button" id="Snd<?php echo $__fmnm ?>" value="<?php echo TXBT_GRDR ?>" ></div>
    <form method="POST" name="<?php echo $__fmnm ?>" target="_self" id="<?php echo $__fmnm ?>">
          	<?php echo HTML_Fm_MMFM('id_upcol', $row_Dt_Rg['id_upcol'], 1, 'EdUpCol'); ?>
          	<?php echo HTML_inp_hd('upcol_up', ctjTx($row_Dt_Rg['upcol_up'],'in')); ?>
            <?php echo HTML_inp_hd('upcol_row', ctjTx($row_Dt_Rg['upcol_row'],'in')); ?>
            <?php echo HTML_inp_hd('upcol_est', 353);  ?>
            <?php 	
			
				$__hdr_col = json_decode($row_Dt_Rg['up_fld'], true);
				
				if($row_Dt_Rg['up_hdr'] != ''){
					$__hdr_col_cmz = json_decode($row_Dt_Rg['up_hdr'], true);
				} 

					
				for ($i = 0; $i <= (UPCOL_CNT+1); $i++) { 
					//if($row_Dt_Rg['upcol_'.$i] != ''){
						$__fld = GtUpFldDt($__hdr_col['c_'.$i]['id'], 'vl');

						if($__fld->tt != '' || $__fld->vl == 'cnt_eml' || $__fld->vl == 'cnt_nm' || $__fld->vl == 'cnt_ap' ){
							if($__fld->vl == 'cnt_eml'){ $__rqr = FMRQD_EM; }else{ $__rqr = ''; }
							echo HTML_inp_tx('upcol_'.$i, '('.$__fld->tt.')' , ctjTx($row_Dt_Rg['upcol_'.$i],'in'), '', $__rqr); 
						}else{
							echo HTML_inp_hd('upcol_'.$i, ctjTx($row_Dt_Rg['upcol_'.$i],'in') );
						}
				    //}
				} 
				
				if($__hdr_col_cmz != ''){
					foreach($__hdr_col_cmz as $_k => $_v){
						if(stripos($_v, '[') !== false){ 
							$__hdr_sch[ $_v ] = str_replace('c_', '', $_k);
						}
					}
				
					foreach($__hdr_sch as $_k => $_v){
						echo HTML_inp_tx('upcol_'.$_v, '('.$_k.')' , ctjTx($row_Dt_Rg['upcol_'.$_v],'in') );
					}
				}
				
			?>   
			
			<?php if($row_Dt_Rg['up_tp'] == 'sms_cmpg_up'){ ?>
				
				<div class="_MblBx">
					<div class="_Hdr"></div>
					<div class="_Bdy">
						<div class="_Lft"></div>
						<div class="_Msj">
							<div class="_MsjBx" id="_MsjBx"></div>
						</div>
						<div class="_Rgh"></div>
						<div class="_Bck"></div>
					</div>
					<div class="_MsjCountBx" id="_MsjCountBx"><?php echo TX_NCRACT ?></div>
				</div>
			
			<?php } ?>
			
			
			<?php 	

          
          								
				$CntWb .= "	


							
											
							$('#Snd{$__fmnm}').click(function() {
								if( $('#{$__fmnm}').valid() ){
									
									$.ajax({
										type: 'POST',
										dataType: 'json',
										url:'".PRC_GN.__t('up_col', true)."',
										data: $('#{$__fmnm}').serialize(),
										beforeSend: function() {
											$('#Snd{$__fmnm}').addClass('_ld');
										},
										success: function(d) {
										    
										    $('#Snd{$__fmnm}').removeClass('_ld');
										    
										    if(d.e == 'ok'){
											    $('#upcol_rw_".$row_Dt_Rg['id_upcol']."').remove();
											    __w_upedt();
										    }
										    
										}
									});

								}
							}); 

							
				";
			?> 
</form>
</div>


<?php } ?>
<?php } 

?>