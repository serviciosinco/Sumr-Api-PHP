<?php

try {

	if(class_exists('CRM_Cnx')){


		$__Up = new CRM_Up();
		$__Up->tp = 'up_a_cnt';

		$___Ls->cnx->prc = 'ok';
		$___Ls->tp = 'mdl_cnt';
		$___Ls->ino = 'id_up';
		$___Ls->ik = 'up_enc';
		$___Ls->edit->big = 'ok';
		$___Ls->_strt();


		$__id  = 'id_up';
		$__bd  = DBP.".".MDL_UP_BD;
		$__bd3 = DBP.".".MDL_UP_COL_BD;
		$__bd4 = _BdStr(DBM).TB_SIS_SLC;
		$__ls = FL_UP_GN;


		if(!isN($___Ls->gt->i)){

			$__id_fm = 'FmUp'.$__id_unq;
			$___fle = GtUpDt([ 'id'=>$___Ls->gt->i, 't'=>'enc' ]);


			$_aws = new API_CRM_Aws();
			$_pth = $_aws->_s3_get([ 'b'=>'prvt', 'lcl'=>'ok', 'fle'=>DIR_PRVT_UP.$___fle->fle ]);

			if($_pth->tmp){
				$___fle_pth = $_pth->tmp;
			}else{
				echo h2('Error on aws s3 get '.DIR_PRVT_UP.$___fle->fle);
				print_r( $_pth );
				exit();
			}


			/*if($_GET["pipe" == "ok"] || SISUS_ID == 181){
				echo json_encode($_pth); exit();
			}*/

			$___tp_up = 'up_mdl_cnt';


			if(!isN($___fle->tp)){

				$Ls_Fld_Qry = "SELECT * FROM ".DBP.".".TB_UP_FLD." WHERE upfld_".$___fle->tp." = 1 ORDER BY upfld_tt ASC";
				$Ls_Fld = $__cnx->_qry($Ls_Fld_Qry);

				if($Ls_Fld){

					$row_Ls_Fld = $Ls_Fld->fetch_assoc();
					$Tot_Ls_Fld = $Ls_Fld->num_rows;

					$___Ls->qrys = sprintf("

										SELECT *
										FROM $__bd3
											 INNER JOIN $__bd ON upcol_up = id_up
										WHERE upcol_est = 615 AND up_enc = %s
										ORDER BY id_upcol DESC
										LIMIT 100

										", GtSQLVlStr($___Ls->gt->i, "text"));
				}

			}

		}elseif($___Ls->_show_ls == 'ok'){


			if(!isN($__t)){ $__f .= ' AND up_tp = "'.$__t.'" '; }

			$Ls_TotLds = ", (SELECT COUNT(*) FROM $__bd3 WHERE upcol_up = id_up) AS __tot_lds ";
			$Ls_TotLds_Ld = ",(SELECT COUNT(*) FROM $__bd3 WHERE upcol_up = id_up AND upcol_est = "._CId('ID_UPEST_ON').") AS __tot_lds_ld ";
			$Ls_TotLds_W = ", (SELECT COUNT(*) FROM $__bd3 WHERE upcol_up = id_up AND upcol_est = "._CId('ID_UPEST_W').") AS __tot_lds_w ";
			$Ls_TotLds_P = ", (SELECT COUNT(*) FROM $__bd3 WHERE upcol_up = id_up AND upcol_est = "._CId('ID_UPEST_PRC').") AS __tot_lds_p ";

			$Ls_Whr = "	FROM $__bd
							 INNER JOIN "._BdStr(DBM).TB_US." ON up_us = id_us
							 ".GtSlc_QryExtra([ 't'=>'tb', 'col'=>'up_est', 'als'=>'e' ])."
						WHERE $__id != ''
						AND up_cl IN (SELECT id_cl FROM "._BdStr(DBM).TB_CL." WHERE cl_sbd = '".Gt_SbDMN()."')
					";




			$___Ls->qrys = "SELECT *,
							(SELECT COUNT(*) $Ls_Whr LIMIT 1) AS ".QRY_RGTOT.",
							"._QrySisSlcF([ 'als'=>'e', 'als_n'=>'estado' ]).",
							".GtSlc_QryExtra([ 't'=>'fld', 'p'=>'estado', 'als'=>'e' ])."
							$Ls_TotLds $Ls_TotLds_Ld $Ls_TotLds_W $Ls_TotLds_P $Ls_Whr $__f
							ORDER BY id_up DESC
						";

		}

		$___Ls->_bld();

	?>
	<?php if($___Ls->ls->chk=='ok'){ ?>

		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg LsRgNw LsCntr">

        	<tbody>

                <?php $_CntJV .= "var __up={};"; ?>

                <?php
	                do {

		                $__estado = json_decode($___Ls->ls->rw['___estado']);

		                foreach($__estado as $__tp_k=>$__tp_v){
							$__estado_go[$__tp_v->key] = $__tp_v;
						}

						$AvncId = Gn_Rnd(5).'_avnc';
                ?>
		         		<tr id="__rw_<?php echo $AvncId; ?>" class="<?php echo $__estado_go->cls->vl; ?>">
					 		<td width="5%" <?php echo NWRP ?>><?php echo Strn(TX_FM_No).HTML_BR.Spn($___Ls->ls->rw[$__id], '', '_f'); ?></td>
					 		<td width="48%" align="left" nowrap="nowrap">
			                    <?php

				                    if(!isN($___Ls->ls->rw['up_nm'])){
					                	$_up_nm = $___Ls->ls->rw['up_nm'];
				                    }else{
					                	$_up_nm = $___Ls->ls->rw['up_fle'];
					                }

					                echo Strn( ShortTx(ctjTx($_up_nm,'in'),60,'Pt', true) );

					                if(!isN($___Ls->ls->rw['up_hi'])){
						            	echo HTML_BR.Spn($___Ls->ls->rw['up_hi'], '', '_f');
					                }

					                echo HTML_BR.ShortTx(ctjTx($___Ls->ls->rw['us_nm'].' '.$___Ls->ls->rw['us_ap'],'in'),60,'Pt', true);
					                echo HTML_BR.Spn(ctjTx($___Ls->ls->rw['estado_sisslc_tt'],'in'),'','up_est_tt','font-weight: 500;color:'.$__estado_go['clr']->vl,'_tt_'.$___Ls->ls->rw['up_enc']);
					            ?>
				        	</td>
				        	<td width="10%" align="left" nowrap="nowrap"><?php echo _Tme($___Ls->ls->rw['up_fi']).HTML_BR.Spn(TX_FIN); ?></td>

		                    <td width="10%" align="left" nowrap="nowrap"><?php echo Strn($___Ls->ls->rw['up_col']).HTML_BR.Spn(TX_COLS); ?></td>
		                    <td width="10%" align="left" nowrap="nowrap"><?php echo Strn($___Ls->ls->rw['up_row']).HTML_BR.Spn(TX_ROWS); ?></td>
							<?php if($__tp == 'up'){ ?>
		                    	<td width="10%" align="left" nowrap="nowrap"><?php echo Strn($___Ls->ls->rw['up_tp']).HTML_BR.Spn(TX_TP); ?></td>
		                    <?php } ?>
		                    <td id="<?php echo 'n_w_'.$AvncId; ?>" width="10%" align="left" nowrap="nowrap">
			                    <?php echo Strn($___Ls->ls->rw['__tot_lds_w']).HTML_BR.Spn(TX_RGNOT); ?>
			                </td>
		                    <td id="<?php echo 'n_o_'.$AvncId; ?>" align="center" width="10%" <?php echo NWRP.$_clr_rw ?>>
					            <?php echo Strn($___Ls->ls->rw['__tot_lds_ld']).HTML_BR.Spn(TX_CRGD, '', 'ok') ?>
					        </td>
					        <td id="<?php echo 'n_l_'.$AvncId; ?>" align="center" width="10%" <?php echo NWRP.$_clr_rw ?>>
					            <?php echo Strn($___Ls->ls->rw['__tot_lds']).HTML_BR.Spn(TX_RCRDS) ?>
					        </td>
							<td id="<?php echo 'n_l_'.$AvncId; ?>" align="center" width="10%" <?php echo NWRP.$_clr_rw ?>>
								<?php
									if($___Ls->ls->rw['up_est'] != _CId('ID_UPEST_ELI')){
										echo OLD_HTML_chck('chck_est'.$___Ls->ls->rw[$___Ls->ik], '', 1, 'in', ['c'=>'chck_est', 'attr'=>['rel'=> $___Ls->ls->rw[$___Ls->ik] ]] );
									}
			    				?>
					        </td>
							<td width="1%" align="left" nowrap="nowrap"><?php

								if($___Ls->ls->rw['up_est'] != _CId('ID_UPEST_ON')){


									$_CntJV .= "

							        	function f_{$AvncId}_js(r){

								        	try{

									        	if(!isN(r)){

										        	if(!isN(r.p) && !isN(r.p.n)){
							        					$('#".$AvncId."').val(r.p.n).trigger('change');
							        				}

							        				if(!isN(r.d)){
							        					if(!isN(r.d.l)){ $('#n_l_".$AvncId." strong').html(r.d.l); }
							        					if(!isN(r.d.o)){ $('#n_o_".$AvncId." strong').html(r.d.o); }
							        					if(!isN(r.d.w)){ $('#n_w_".$AvncId." strong').html(r.d.w); }
							        				}

							        				if(!isN(r.p) && !isN(r.p.n) && r.p.n != '100'){ $('#bx_".$AvncId."').fadeIn(); }


													$('#__rw_".$AvncId."').removeClass().addClass(r.up.d.est_cls);


													if(!isN(r) && !isN(r.p) && !isN(r.p.n) && r.p.n == '100'){
											        	$('#bx_".$AvncId."').fadeOut();
										        	}else{
											        	if(!isN(r.up) && !isN(r.up.b) && !isN(r.up.b.html)){
											        		f_{$AvncId}_knob(r.up.b);
											        		$('#bx_".$AvncId."').fadeIn();
														}
										        	}

								        		}

								        		return true;

							        		}catch(e) {

												SUMR_Main.log.f({ t:'".TX_ERROR.": ', m:e });

											}
							        	}

							        	function f_{$AvncId}_knob(r){
								        	if(!isN(r)){
									        	if(!isN(r.html)){ var html = r.html; }
									        	$('#bx_".$AvncId."').html(html);
									        	if(!isN(r.js)){ eval(r.js); }
								        	}

							        	}


							        ";

								    if(!isN($___Ls->ls->rw['up_col']) && !isN($___Ls->ls->rw['up_row']) &&

								    		(
								    			$___Ls->ls->rw['up_est'] == _CId('ID_UPEST_PRC') ||
								    			$___Ls->ls->rw['up_est'] == _CId('ID_UPEST_LD') ||
								    			$___Ls->ls->rw['up_est'] == _CId('ID_UPEST_PRC')
								    		)

								    	){

								    	$_CntJV .= "

								    		__up['{$AvncId}'] = { id:'".$___Ls->ls->rw['up_enc']."', f:'{$AvncId}', t:'".$___Ls->ls->rw['up_est']."' };
											f_{$AvncId}_knob();

								    	";

								    }

						        }



								echo '<div class="__avnc_l" id="bx_'.$AvncId.'" style="display:none;"></div>';

							?></td>


		                    	<td width="1%" align="left" nowrap="nowrap" class="_btn">
			                    	<?php echo $___Ls->_btn([ 't'=>'mod', 'up'=>'ok' ]); ?>
			                    </td>
			                    <td width="1%" align="left" nowrap="nowrap" class="_btn">
			                    	<?php echo $___Ls->_btn([ 't'=>'upl_fle', 'up'=>'ok' ]); ?>
			                    </td>
								<td width="1%" align="left" nowrap="nowrap" class="_btn">
									<?php echo HTML_Ls_Btn([ 't'=>'up', 'l'=>Fl_Rnd(FL_FM_UP.__t('mdl_cnt',true).ADM_LNK_DT.$___Ls->ls->rw['up_enc']) ]); ?>
								</td>

                  		</tr>

				  	<?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>

				  	<?php
						$_CntJV .= "

							$('.chck_est').click(function() {

								if($(this).is(':checked')) { var est = 'ok'; } else { var est = 'no'; }
								var id_chck = $(this).attr('rel');

								swal({
									title: '".TX_ETSGR."',
									text: '".TX_CNL_UP."!',
									type: 'warning',
									showCancelButton: true,
									confirmButtonClass: 'btn-danger',
									confirmButtonText: '".TX_YSV."',
									confirmButtonColor: '#8fb360',
									cancelButtonText: '".TX_CNCLR."',
									closeOnConfirm: true
								},
								function(isConfirm){

									if (isConfirm) {

										_Rqu({
											t:'up_cnt',
											d:'chck_est',
											est: est,
											_id_chck: id_chck,
											_bs:function(){ $('.LsCntr tr').addClass('_ld'); },
                        					_cm:function(){ $('.LsCntr tr').removeClass('_ld'); },
											_cl:function(_r){
												if(!isN(_r)){
													if(_r.e == 'ok'){
														$('#chck_est'+id_chck+'_div').remove();
														$('#_tt_'+id_chck).html('Eliminado').css('color', '#ff0000');
													}
												}
											}
										});

									} else {
										$('#chck_est'+id_chck).attr('checked',false);
									}
								});
							});
						";

	                  $_CntJV .= "

	                  		function f_up_updt(){

					        	try{

									/*
						        	SUMR_Main.autop({
						        		t:'_auto',
					        			d:{
						        			tp:'up',
						        			tp2:'".$__t."',
					        				up:__up,
					        			},
					        			_c:function(r){
						        			if(!isN(r)){
							        			if(!isN(r.ls)){
								        			$.each(r.ls, function(k, v) {
									        			if(!isN(v.f)){
								        					window['f_'+v.f+'_js'](v);
								        				}
								        			});
							        			}
							        		}
				        				},
				        				_cm:function(e){
					        				setTimeout(function(){
								        		f_up_updt();
								        	}, 30000);
				        				}
					        		});
									*/

					        		return true;

				        		}catch(e) {
									SUMR_Main.log.f({ t:'".TX_ERROR."', m:e });
								}

				        	}

	                  		f_up_updt();

	                  ";


                  ?>

                <style>

	              	.__avnc_l{ margin-top: 6px; margin-left: 10px; margin-right: 10px; position: relative; }
	              	.__avnc_l:before{ content:' '; display: block; width: 17px; height: 17px; position: absolute; left: 5px; top: 4px; background-image: url(<?php echo _iEtg(DMN_IMG_ESTR_SVG.'loader_black.svg') ?>); background-repeat: no-repeat; background-position: center center; background-size: auto 100%; }
	              	.LsCntr tr._ld{pointer-events: none;opacity: 0.2;}

                </style>

          	</tbody>
			<?php
				$CntWb .= '$("._ls").colorbox({ width:"95%", height:"95%", trapFocus:false, overlayClose:false, escKey:false, onClosed:function(){ } }); ';
				$CntWb .= '$(".FmUpBd").colorbox({width:"400", height:"255", overlayClose:false, escKey:false, onLoad:function(){ $("#colorbox").removeAttr("tabindex");}, onClosed:function(){ } });';
			?>
		</table>
        <?php $___Ls->_bld_l_pgs(); ?>

	<?php } ?>

	<?php if (!isN($_i)){  ?>

			<?php if(($___fle->est == _CId('ID_UPEST_LD') || $___fle->est == _CId('ID_UPEST_COLS')) && $__w != 'ok'){ ?>

			<?php

                try {

					if(!isN( $___fle_pth )){
						$inputFileType = PHPExcel_IOFactory::identify($___fle_pth);
						$objReader = PHPExcel_IOFactory::createReader($inputFileType);
						$objReader->setReadFilter( new CRM_Up_RdrFltr() );
						$objReader->setReadDataOnly(true);
						//if($___fle->ext == 'xls'){ $objReader->setPreCalculateFormulas(false); }
						$objPHPExcel = $objReader->load($___fle_pth);
					}else{
						echo h2('Error empty file:'.$___fle_pth);
					}

                } catch (Exception $e) {

                    echo 'a_cnt: Error loading file "' . pathinfo($___fle_pth, PATHINFO_BASENAME) . '": ' . $e->getMessage();

                }

				if( $objPHPExcel->getSheetCount() > 0 && $objPHPExcel->getSheetCount() == 1 ){

						//-------------------- GET GLOBAL VALUES  * --------------//

						/*
							$objReader_b = PHPExcel_IOFactory::createReader($inputFileType);
						 	$objReader_b->setReadDataOnly(true);
							$objPHPExcel_b = $objReader_b->load($___fle_pth);
					   		$sheetData_b = $objPHPExcel_b->getActiveSheet();
					   		$highestRow = $sheetData_b->getHighestRow();
					   	*/

				   		//--------------------  PROCESS WORKSHEET * --------------//


						//foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {

		                    $worksheet = $objPHPExcel->getActiveSheet();
	                        $worksheetTitle = $worksheet->getTitle();
	                        $highestRowP = $worksheet->getHighestRow();
	                        $highestColumn = $worksheet->getHighestColumn();
	                        $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
	                        $nrColumns = ord($highestColumn) - 64;

	                    //}


	                    if($Tot_Ls_Fld > 0){

		                    do{

							  $_fields[] = ['t'=>ctjTx($row_Ls_Fld['upfld_tt'], 'in'), 'v'=>$row_Ls_Fld['upfld_vl'] ];

							} while ($row_Ls_Fld = $Ls_Fld->fetch_assoc());

						}



						usort($_fields, '__XlsCmpr');
						$_fiels_bd = json_decode($___fle->fld, TRUE);


			?>
								<?php if($objPHPExcel){ ?>

						            <form action="" method="POST" target="_self" name="<?php echo $__id_fm ?>" id="<?php echo $__id_fm ?>" class="UpColSelc">

										<input name="MM_process" type="hidden" id="MM_process" value="UpMMProcess" />
					                    <input name="__i" type="hidden" id="__i" value="<?php echo $___fle->enc ?>" />
					                    <input name="__col" type="hidden" id="__col" value="<?php echo $highestColumnIndex ?>" />
					                    <input name="__rws" type="hidden" id="__rws" value="<?php echo $highestRow ?>" />

					                    <?php echo h1($highestRow . TX_RCRDS .' '. Spn(TX_DSPLGD)); ?>


					                    <div class="__scrl_cols">

						                    <table width="100%" cellpadding="0" cellspacing="0" border="0" class="_sc1">
						                    <?php

				                                $row = 1;

				                                while ($row <= $highestRowP){

				                                   	$_html .= '<tr id="_rw_'.$row.'">';

												    for ($col = 0; $col < $highestColumnIndex; ++ $col) {


													   $cell = $worksheet->getCellByColumnAndRow($col, $row);
			                                           $data = $cell->getValue();



													   if(  PHPExcel_Shared_Date::isDateTime( $worksheet->getCellByColumnAndRow($col, $row) )  ){
													   	    $dte_format = PHPExcel_Style_NumberFormat::toFormattedString( $data , 'YYYY-MM-DD@@@H:I:S');

													   	    $val_atm = explode('@@@', $dte_format);

													   	    if($val_atm[1] != '0:00:00'){
														   	   $val = $val_atm[1];
													   	    }else{
														   	   $val = $val_atm[0];
													   	    }


													   }else{

														   	if($row == 1){ $_max_chr=20; }else{ $_max_chr=50; }
													   		$val = ShortTx( strip_tags( $data ), $_max_chr, 'Pt');

													   }


													   	if(!isN($_fiels_bd['c_'.$col])){
															$_val_col = $_fiels_bd['c_'.$col]['id'];
														}else{
															$_val_col = $val;
														}


														if($row == 1){

				                                           $_th_c = '';
				                                           $_th_cls = '';

				                                           if(stripos($_val_col, '[') !== false){
					                                       		$_th_t = $val . bdiv([ 'c'=> Spn(TX_CMPPRZNL), 'cls'=>'_dcstm' ]) ;
					                                       		$_th_cls = '_cstm';
					                                       }else{
						                                       	$_th_t = $val;
					                                       }


					                                       $_th_c .= $_th_t . Ls_XLS_F(['id'=>'tt_xls_'.$col, 'nm'=>'tt_xls_'.$col.'[id]', 'b'=>$_fields, 'v_a'=>$_val_col ]);

			                                               $_th_id = Gn_Rnd(10);

			                                               $_html .= '<th class="'.$_th_cls.'" id="'.$col.'_'.$_th_id.'">' .$_th_c. '</th>';

			                                               $CntWb .= '$("#'.$col.'_'.$_th_id.'").click(function(){ $(this).removeClass("_cstm"); });';

														   $CntWb .= JQ_Ls('tt_xls_'.$col.'', '-campo-');

														   $HdrSve['c_'.$col] = $val;

			                                           	}else{

			                                               if($row < 50){ $_html .= '<td>'.$val . $_id_row . '</td>'; }
			                                           	   $_ins[$row][] = $val;

													   	}

			                                        }

													$_html .= '</tr>';
													$row++;

				                                }


												try {
												   echo $_html;
												} catch (Exception $e) {
												   echo 'Caught exception: ',  $e->getMessage(), "\n";
												}
						                    ?>
						                    </table>

					                    </div>

					                    <input name="__hdr" type="hidden" id="__hdr" value='<?php echo json_encode($HdrSve) ?>'; />
						            </form>


						            <style>

							        	.UpColSelc{  }
							        	.UpColSelc .__scrl_cols{ overflow-y: scroll; }

							            .UpColSelc .__scrl_cols::-webkit-scrollbar { width: 3px; cursor: pointer; height: 50px; margin-right: -10px; }
										.UpColSelc .__scrl_cols::-webkit-scrollbar-track{ background-color: rgba(228, 231, 232, 0); }
										.UpColSelc .__scrl_cols::-webkit-scrollbar-thumb { background-color: rgba(165, 169, 173, 0.7); opacity: 0.5; max-height: 100px !important; }
										.UpColSelc .__scrl_cols th{ text-align: center; }
										.UpColSelc .__scrl_cols td{ min-width: 100px !important; text-align: center !important; }

						            </style>

								<?php } ?>

						<?php }else{ ?>

							<div class="_wrn_sheet"><?php echo TX_ELMSUBR ?></div>
							<style> ._wrn_sheet{ background-color: #ff7800; padding: 15px 0; color: #ffffff; text-align: center; font-size: 11px; } </style>

						<?php } ?>

	            <?php }else{ ?>


		            <div class="_db_exc" id="_db_exc" <?php if(($___fle->est == _CId('ID_UPEST_LD') || $___fle->est == _CId('ID_UPEST_COLS')) && $__w != 'ok'){ ?>style="display:none;"<?php } ?>>

		            	<div class="__cnt">
			            	<?php if($___fle->rd != 'ok'){ ?>
			            	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
					          	<thead>
					                <tr>
					                    <th width="1%" <?php echo NWRP ?>><?php echo TX_FM_No ?></th>
					                    <th width="1%" <?php echo NWRP ?>><?php echo TX_CLD ?></th>
					                    <th width="48%" <?php echo NWRP ?>><?php echo TX_ERROR ?></th>
					                    <th width="1%" <?php echo NWRP ?>></th>
					                </tr>
								</thead>
						        <tbody>
							        <?php if(!isN($___Ls->dt->rw)){ ?>
					                	<?php do { ?>
										<tr id="upcol_rw_<?php echo $___Ls->dt->rw['id_upcol'] ?>">
											<td width="1%" <?php echo NWRP ?>><?php echo Spn($___Ls->dt->rw['id_upcol']); ?></td>
						                    <td width="1%" <?php echo NWRP ?>><?php echo Spn($___Ls->dt->rw['upcol_row']); ?></td>
						                    <td width="48%" ><?php echo ctjTx($___Ls->dt->rw['upcol_w'],'in') ?></td>
						                    <td width="1%" align="left" <?php echo $_clr_rw ?> class="_btn">
									                <?php echo HTML_Ls_Btn([ 't'=>'edt', 'js'=>'ok', 'l'=>"__w_upedt({ id:'".$___Ls->dt->rw['id_upcol']."' });" ]); ?>
								            </td>
					                  	</tr>
									  	<?php } while ($___Ls->dt->rw = $___Ls->sql->fetch_assoc()); ?>
								  	<?php } ?>
						       	</tbody>
							   	<?php


							  		$CntWb .= '$("._ls").colorbox({ width:"95%", height:"95%", trapFocus:false, overlayClose:false, escKey:false, onClosed:function(){ } }); ';
							  		$CntWb .= '$(".FmUpBd").colorbox({width:"400", height:"255", overlayClose:false, escKey:false, onLoad:function(){ $("#colorbox").removeAttr("tabindex");}, onClosed:function(){ } });';
									$CntWb .= '$(".FmUpBd").click(function() {		SUMR_Main.anm.h_cmpct("on");	});';

									//$CntWb .= '$("#_db_exc .__cnt").mCustomScrollbar({ setHeight:"88%", theme:"dark-3" });';

									$_CntJV .= "

										function __w_upedt(_p){

											if(isN(_p)){ _p = ''; }

											var _w = $('#__w_upedt');
											var _u = '".FL_FM_GN.__t('up_col',true).ADM_LNK_DT."'+_p.id+'"._SbLs_ID()."';

											if( !_w.hasClass('_opn') || _p.o == 'ok' ){

												_w.addClass('_opn');

												/*$('#_bx_ldhere').mCustomScrollbar('destroy');*/

												_ldCnt({
													u:_u,
													c:'_bx_ldhere',
													_cl:function(){
														/*$('#_bx_ldhere').mCustomScrollbar({ setHeight:'95%', alwaysShowScrollbar:true, theme:'light-1' });*/
													}
												});

											}else{
												_w.removeClass('_opn');
											}
										};

									";
							  	?>
					        </table>
					        <?php } ?>
						</div>


						<div class="__w_upedt _anm" id="__w_upedt">
			                <div class="__bx _anm">
				                <a href="<?php echo Void(); ?>" class="_x" onclick="__w_upedt();"></a>
		                		<div id="_bx_ldhere"></div>
			                </div>
		                </div>


		                <div class="__w_exc _anm" id="__w_exc">
			                <div class="__bx _anm">
				                <a href="<?php echo Void(); ?>" class="_x" onclick="__w_exc();"></a>
		                		<iframe src="<?php //echo DMN_AUTO."?_t=up_mdl_cnt&__e=".encAd(SIS_ENCI).ADM_LNK_DT.$_i; ?>" frameborder="0" id="_db_exc_rsl" ></iframe>
			                </div>
		                </div>

		       	</div>

			<?php } ?>

			<?php if($___fle->rd == 'ok'){ ?><div id="__db<?php echo $__id_unq ?>" class="_db_<?php echo $___fle->est_cls ?>" ></div><?php } ?>

	<?php } ?>

	<?php }


} catch (Exception $e) {

    echo $e->getMessage();

}

?>