<?php 
if(class_exists('CRM_Cnx')){
	 	
	$___Ls->sch->f = 'orgsdsarr_tt';
	$___Ls->new->w = 1000;
	$___Ls->new->h = 600;
	$___Ls->_strt();	

	if(!isN($___Ls->gt->i)){	
		
		$___Ls->qrys = sprintf("
								SELECT * FROM "._BdStr(DBM).TB_ORG_SDS_ARR_SLS."
								INNER JOIN "._BdStr(DBM).TB_ORG_SDS_ARR." ON id_orgsdsarr = orgsdsarrsls_arr
								INNER JOIN "._BdStr(DBM).TB_ORG_SDS." ON orgsdsarr_orgsds = id_orgsds
								INNER JOIN "._BdStr(DBM).TB_ORG."  ON orgsds_org = id_org
								WHERE ".$___Ls->ik." = %s LIMIT 1
								", GtSQLVlStr($___Ls->gt->i, "text"));	
		
	}elseif($___Ls->_show_ls == 'ok'){ 	
		
        $Ls_Whr = " FROM "._BdStr(DBM).TB_ORG_SDS_ARR_SLS."
					INNER JOIN "._BdStr(DBM).TB_ORG_SDS_ARR." ON id_orgsdsarr = orgsdsarrsls_arr
					INNER JOIN "._BdStr(DBM).TB_ORG_SDS." ON orgsdsarr_orgsds = id_orgsds
					INNER JOIN "._BdStr(DBM).TB_ORG."  ON orgsds_org = id_org
                    WHERE ".$___Ls->ino." != ''
					AND orgsdsarr_est = 1
					AND  org_enc = '{$__i}'
					".$___Ls->sch->cod." ORDER BY ".$___Ls->ino." ";
		$___Ls->qrys = "SELECT *,
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
		    	<th width="19%" <?php echo NWRP ?>><?php echo "Valor" //Ricardo ?></th>
		    	<th width="19%" <?php echo NWRP ?>><?php echo "Transacciones" ?></th>
		    	<th width="19%" <?php echo NWRP ?>><?php echo 'Fecha' ?></th>
		    	<th width="19%" <?php echo NWRP ?>><?php echo 'Hora' ?></th>
		    	<th width="1%" <?php echo NWRP ?>></th>
		  	</tr>
		  	<?php do { ?> 
                <tr> 
                    <td width="1%" <?php echo NWRP ?>><?php echo Spn($___Ls->ls->rw[$___Ls->ino]); ?></td>
                    <td width="19%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx( number_format($___Ls->ls->rw['orgsdsarrsls_vl'], 0, ",", ".") ,'in'),40); ?></td>
                    <td width="19%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['orgsdsarrsls_trs'],'in'),40); ?></td>
                    <td width="19%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['orgsdsarrsls_f'],'in'),40); ?></td>
                    <td width="19%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['orgsdsarrsls_h'],'in'),40); ?></td>
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
		  
		<?php  
			$__idtp_act = '_act';
		?>
		                                         
	    <form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>" >
	      <?php $___Ls->_bld_f_hdr(); ?>      
		  <div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">			
	        <div class="ln_1">
			  	<div class="col_1">
					<div class="__orgsdsarrsls_vl">
						<span class="_dlr">$</span>
						<span class="_vl"><?php echo number_format( $___Ls->dt->rw['orgsdsarrsls_vl'], 0, ",", "."); ?></span>
					</div>
		        	<?php

						$_org_dt = GtOrgSdsArrDt([ 'i'=>$___Ls->gt->isb, 't'=>'org_enc' ]);
						echo HTML_inp_tx('orgsdsarrsls_vl', "Ventas" , ctjTx($___Ls->dt->rw['orgsdsarrsls_vl'],'in'), FMRQD_NM);

					?>
	        	</div>
	        	<div class="col_2">
					<?php 
						echo HTML_inp_tx('orgsdsarrsls_trs', "Transacciones" , ctjTx($___Ls->dt->rw['orgsdsarrsls_trs'],'in'), '');
						echo SlDt([ 'id'=>'orgsdsarrsls_f', 'va'=>$___Ls->dt->rw['orgsdsarrsls_f'], 'rq'=>'no', 'ph'=>'Fecha', 'yr'=>'ok', 'mth'=>'ok' ]);
						echo LsOrgSds([ 'id'=>'orgsdsarr_sls_enc', 'v'=>'orgsds_enc', 'va'=>$___Ls->dt->rw['orgsds_enc'], 'rq'=>1, 'org'=>$___Ls->gt->isb ]);
						$CntWb .= JQ_Ls('orgsdsarr_sls_enc');
			        	//echo SlDt([ 'id'=>'orgsdsarrsls_h', 'va'=>$___Ls->dt->rw['orgsdsarrsls_h'], 'rq'=>'no', 'ph'=>'Hora', 'lmt'=>'no', 't'=>'hr' ]);
		        	?>
	        	</div>
			</div>
	      </div>
	    </form>
			
	  </div>
	</div>   

	<?php 

		if($_org_dt->mnt == 1){

			$CntWb .= "
				var sls = $('#orgsdsarrsls_vl').val();

				if(sls > 0){ $('#orgsdsarrsls_vl').show(); }else{ $('#orgsdsarrsls_vl').hide(); }
				
				$('#orgsdsarrsls_f').on('change',function(){

					var date_slc = $(this).val();

					var date = new Date(date_slc);
					var ultimoDia = new Date(date.getFullYear(), date.getMonth()+1, 0);

					var dia  = ultimoDia.getDate();

					var dates = new Date(date_slc);
					dates = dates.getDate() + 1;

					if(dates == dia){ $('#orgsdsarrsls_vl').show(); }else{ $('#orgsdsarrsls_vl').hide().val(0);	}
				});
			";

		}

		$CntWb .= "
					try{
						$('#orgsdsarrsls_vl').keyup(function(p){
							if( !isN($(this).val()) ){
								if( isNaN($(this).val()) ){
									$('.__orgsdsarrsls_vl ._vl').html('Numero no valido');
									$('.__orgsdsarrsls_vl ._vl').addClass('_err');
								}else{
									$('.__orgsdsarrsls_vl ._vl').removeClass('_err');
									let _num_frmt = $(this).val().replace(/\./g,'');
									_num_frmt = _num_frmt.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
									_num_frmt = _num_frmt.split('').reverse().join('').replace(/^[\.]/,'');
									$('.__orgsdsarrsls_vl ._vl').html(_num_frmt);
								}
							}else{
								$('.__orgsdsarrsls_vl ._vl').html(0);
							}
						});

					}catch(e) {
						SUMR_Main.log.f({ t:'Error en div __orgsdsarrsls_vl', m:e });
					}
		";
	
	?>

	<style>
		.__orgsdsarrsls_vl{ width: 100%; height: 80px; border: 1px solid #f6f5f6; text-align: center; padding-top: 20px; }

		.__orgsdsarrsls_vl > span{ font-family: Economica; color: #759775; font-size: 20px; }
		.__orgsdsarrsls_vl > span._dlr{ font-size: 25px!important; }

		.__orgsdsarrsls_vl > span._vl._err{ color:#b75757!important; }
		#orgsdsarrsls_vl{ margin-top:20px; }
	</style>


<?php } ?>
<?php } ?>