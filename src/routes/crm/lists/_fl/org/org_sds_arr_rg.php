<?php
if(class_exists('CRM_Cnx')){
	 	
	$___Ls->sch->f = 'orgsdsarrrg_vl';
	$___Ls->new->w = 1000;
	$___Ls->new->h = 600;
	$___Ls->_strt();

	if(!isN($___Ls->gt->i)){	
		
		$___Ls->qrys = sprintf("SELECT * FROM "._BdStr(DBM).TB_ORG_SDS_ARR_RG." 
								INNER JOIN "._BdStr(DBM).TB_ORG_SDS_ARR." ON id_orgsdsarr = orgsdsarrrg_arr
								WHERE ".$___Ls->ik." = %s
								LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));
		
	}elseif($___Ls->_show_ls == 'ok'){ 	
		
		$Ls_Whr = " FROM "._BdStr(DBM).TB_ORG_SDS_ARR_RG."
					INNER JOIN "._BdStr(DBM).TB_ORG_SDS_ARR." ON id_orgsdsarr = orgsdsarrrg_arr
					WHERE ".$___Ls->ino." != '' 
					AND orgsdsarr_enc = '".$___Ls->gt->isb."' 
					".$___Ls->sch->cod." ORDER BY ".$___Ls->ino." DESC";
		$___Ls->qrys = "SELECT *,
						(SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." $Ls_Whr ";

	}
	
	$___Ls->_bld();

?>
<?php if($___Ls->ls->chk=='ok'){ ?>
<?php $___Ls->_bld_l_hdr(); ?>
	<?php if(($___Ls->qry->tot > 0)){ ?>
		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg"> 
			<tr>
		    	<th width="1%" <?php echo NWRP ?>><?php echo TX_FM_No ?></th>
		    	<th width="19%" <?php echo NWRP ?>><?php echo "Valor" //Ricardo ?></th>
				<th width="19%" <?php echo NWRP ?>><?php echo "Valor Administración" //Ricardo ?></th>
		    	<th width="19%" <?php echo NWRP ?>><?php echo "Fecha" ?></th>
		    	<th width="1%" <?php echo NWRP ?>></th>
		  	</tr>
		  	<?php do { ?>
			  	<tr> 
					<td width="1%" <?php echo NWRP ?>><?php echo Spn($___Ls->ls->rw[$___Ls->ino]); ?></td>
					<td width="19%" align="left" nowrap="nowrap"><?php echo cnVlrMon('', $___Ls->ls->rw['orgsdsarrrg_vl'] ); ?></td>
					<?php $_orgsdsarrrg_f_ls = new DateTime($___Ls->ls->rw['orgsdsarrrg_f']); ?>
					<td width="19%" align="left" nowrap="nowrap"><?php echo cnVlrMon('', $___Ls->ls->rw['orgsdsarrrg_vl_adm']); ?></td>
					<td width="19%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx( FechaESP_OLD($_orgsdsarrrg_f_ls->format('Y-m'), 10) ,'in'),40); ?></td>
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
		  	<div class="ln_1">
				<?php $_org_sds_arr_dt = GtOrgSdsArrDt([ 't'=>'enc', 'i'=>$___Ls->gt->isb ]); //Trae el valor del arriendo ?>

			  	<div class="__orgsdsarrrg_vl">
					<span class="_dlr">$</span>
					<span class="_vl"><?php echo number_format( ( (!isN($___Ls->dt->rw['orgsdsarrrg_vl']))? $___Ls->dt->rw['orgsdsarrrg_vl'] : $_org_sds_arr_dt->vl ) , 0, ",", "."); ?></span>
				</div>

				<?php 
					echo HTML_inp_hd('orgsdsarrrg_arr', $___Ls->gt->isb);
					echo HTML_inp_tx('orgsdsarrrg_vl', "Valor" , ( (!isN($___Ls->dt->rw['orgsdsarrrg_vl']))? ctjTx($___Ls->dt->rw['orgsdsarrrg_vl'],'in') : ctjTx($_org_sds_arr_dt->vl,'in') ) , FMRQD_NM);
					echo HTML_inp_tx('orgsdsarrrg_vl_adm', "Valor Administración" , ctjTx($___Ls->dt->rw['orgsdsarrrg_vl_adm'],'in') , FMRQD_NM);
					$_orgsdsarrrg_f = new DateTime($___Ls->dt->rw['orgsdsarrrg_f']);
					echo SlDt([ 'id'=>'orgsdsarrrg_f', 'va'=>$_orgsdsarrrg_f->format('Y-m'), 'rq'=>'no', 'ph'=>'Fecha', 'lmt'=>'no', 't'=>'mthyr' ]);
				?>
			</div>
			
	      </div>
	    </form>
	  </div>
	</div>   

	<?php 
	
		$CntWb .= "
			try{
				$('#orgsdsarrrg_vl').keyup(function(p){
					if( !isN($(this).val()) ){
						if( isNaN($(this).val()) ){
							$('.__orgsdsarrrg_vl ._vl').html('Numero no valido');
							$('.__orgsdsarrrg_vl ._vl').addClass('_err');
						}else{
							$('.__orgsdsarrrg_vl ._vl').removeClass('_err');
							let _num_frmt = $(this).val().replace(/\./g,'');
							_num_frmt = _num_frmt.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
							_num_frmt = _num_frmt.split('').reverse().join('').replace(/^[\.]/,'');
							$('.__orgsdsarrrg_vl ._vl').html(_num_frmt);
						}
					}else{
						$('.__orgsdsarrrg_vl ._vl').html(0);
					}
				});
			}catch(e) {
				SUMR_Main.log.f({ t:'Error en div __orgsdsarrrg_vl:', m:e });
			}
		";
	
	?>

	<style>
		.__orgsdsarrrg_vl{ width: 100%; height: 80px; border: 1px solid #f6f5f6; text-align: center; padding-top: 20px; }

		.__orgsdsarrrg_vl > span{ font-family: Economica; color: #759775; font-size: 20px; }
		.__orgsdsarrrg_vl > span._dlr{ font-size: 25px!important; }

		.__orgsdsarrrg_vl > span._vl._err{ color:#b75757!important; }
	</style>

<?php } ?>
<?php } ?>