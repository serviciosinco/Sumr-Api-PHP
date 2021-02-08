<?php 
	
	//$__dt_cnt = GtCntDt([ 'id'=>$__i, 'ls_tp'=>'ok', 'clg_lst'=>'ok', 'ls_clg'=>'ok', 'ls_f_scl'=>'ok', 'ls_f_org'=>'ok', 'ls_f_tpc'=>'ok' ]);
	
	$__i = Php_Ls_Cln($_GET['__i']);
	$__tp = Php_Ls_Cln($_GET['_tp']);
	$__cipcn = Php_Ls_Cln($_GET['_call_id_mdlcnt']);
	$__clidcl = Php_Ls_Cln($_GET['_call_id_call']);
	$__telid = Php_Ls_Cln($_GET['__tel_id']);
	$__sch = Php_Ls_Cln($_GET['_sch']);
	
	$__rnd_op = Gn_Rnd(20);
	$lmt = (($_REQUEST['_pg']-1)*50);

	
	if($__tp == "_call_ls"){ 

		if($__i != NULL){ $__fl .= sprintf(" AND id_mdlstp = %s ", GtSQLVlStr( $__i, "int")); }
		
		$__schcod = Sch_Cd('id_mdlcnt, id_cnt, mdlcnt_m, mdlcnt_dsp, mdlcnt_ref, cnt_nm, cnt_ap',$_GET['_sch'], 2, 
						   ['_mre'=>' || (
						   						id_cnt IN (SELECT cnteml_cnt FROM '.TB_CNT_EML.' WHERE cnteml_eml LIKE \'%'.$__sch.'%\' )  ||
						   						id_cnt IN (SELECT cntdc_cnt FROM '.TB_CNT_DC.' WHERE cntdc_dc LIKE \'%'.$__sch.'%\' ) ||
						   						id_cnt IN (SELECT cnttel_cnt FROM '.TB_CNT_TEL.' WHERE cnttel_tel LIKE \'%'.$__sch.'%\' ) 
						   					  )	
						   				 ']); // Codigo Armado
		
		$Ls_Qry = " SELECT *
					FROM ".TB_MDL_CNT."
						 INNER JOIN ".TB_CNT." ON mdlcnt_cnt = id_cnt
						 INNER JOIN ".TB_BD." ON mdlcnt_mdl = id_mdl
						 INNER JOIN "._BdStr(DBM).TB_MDL_S." ON mdl_mdls = id_mdls
						 INNER JOIN "._BdStr(DBM).TB_MDL_S_TP." ON mdls_tp = id_mdlstp
					WHERE id_mdlcnt != '' $__fl $__schcod
					ORDER BY id_mdlcnt DESC
					LIMIT ".$lmt." , 50 ";
					
		$Ls_Rg = $__cnx->_qry($Ls_Qry); 
		$row_Ls_Rg = $Ls_Rg->fetch_assoc(); $Tot_Ls_Rg = $Ls_Rg->num_rows;  
		

?>
		<?php echo HTML_inp_hd('_pg',$row_Ls_Rg['__rgtot'], ''); ?>
			<table class='cll_tb cnt' width="100%">
				<!--<tr>
					<th width='40%'>Nombre</th>
					<th width='65%'>Programa</th>
					<th width='1%'></th>
				</tr>-->
			<?php do{ ?>
				<tr>
					<td width='40%' class='_cntnm'><?php echo ctjTx($row_Ls_Rg['cnt_nm'].HTML_BR.$row_Ls_Rg['cnt_ap'], "in") ?></td>
					<td width='65%' class='_pronm'>
						<div class="_sprt" style="background-color:<?php echo $row_Ls_Rg['mdlstp_clr']; ?>">
							
						</div>
						<div class="_cnt">
						<?php echo 	h2( ctjTx($row_Ls_Rg['mdl_nm'], 'in')." ".
									Spn(ctjTx($row_Ls_Rg['mdlstp_nm'], 'in'), 'ok')).
									Spn('','','_icn _dte').
									Spn(FechaESP_OLD($row_Ls_Rg['mdlcnt_fi'],'yrdy'),'','_dte');	
						?>
						</div>
					</td>
					<td width='1%' class='_icn_cnt'><button onclick="SUMR_Call.f.cnt({ 'tp':'_slc',  'pc':'<?php echo $row_Ls_Rg['mdlcnt_enc']; ?>' });"></button></td>	
				</tr>
			<?php } while ($row_Ls_Rg = $Ls_Rg->fetch_assoc()); ?>
			</table>
<?php }elseif($__tp == "_rcnt"){ ?>
	
	<?php  ?>
		
	<?php 
		
		
		if(!ChckSESS_superadm()){ $__fl .= sprintf(" AND call_us = %s ", GtSQLVlStr(SISUS_ID, "int")); }
		
		
		$__id = 'id_call'; // Id de Datos
		$Ls_Qry_Cll = "	SELECT *,
							(	SELECT CONCAT('{\"nm\":\"',cnt_nm,'\", 
												\"ap\":\"',cnt_ap, '\", 
												\"cnt\":\"',cnt_enc, '\", 
												\"mdlcnt\":', '\"',mdlcnt_enc,'\"
											 }')
												
								FROM ".TB_MDL_CNT_CALL."
									 INNER JOIN ".TB_MDL_CNT." ON mdlcntcall_mdlcnt = id_mdlcnt
									 INNER JOIN ".TB_CNT." ON mdlcnt_cnt = id_cnt  
								WHERE mdlcntcall_call = id_call	 
							) AS _p_cnt,
							
							(	
								SELECT CONCAT('{\"nm\":\"',cnt_nm,'\", 
												\"ap\":\"',cnt_ap, '\", 
												\"cnt\":\"',cnt_enc, '\" 
											}')
											 
								FROM ".TB_CALL_CNT." 
									 INNER JOIN ".TB_CNT." ON cntcall_cnt = id_cnt
									 
							) AS _cnt
	
						FROM "._BdStr(DBT).TB_CALL." 
						WHERE id_call != '' {$__fl}
						/*GROUP BY call_callstatus*/
						HAVING (_p_cnt != '' || _cnt != '')
						ORDER BY id_call DESC
						LIMIT 20";
							 
			$Ls_Rg_Cll = $__cnx->_qry($Ls_Qry_Cll);
			$row_Ls_Rg_Cll = $Ls_Rg_Cll->fetch_assoc(); 
			$Tot_Ls_Rg_Cll = $Ls_Rg_Cll->num_rows; 
	?>
		<?php if($Tot_Ls_Rg_Cll > 0){ ?>
		<table class='cll_tb rcnt' width="100%">
		<?php do{ ?>
			<?php
				if($row_Ls_Rg_Cll['_p_cnt'] != ''){ 
					$__jscnt = $row_Ls_Rg_Cll['_p_cnt']; 
				}elseif($row_Ls_Rg_Cll['_cnt'] !=''){ 
					$__jscnt = $row_Ls_Rg_Cll['_cnt']; 
				}
				if($__jscnt != ''){
					$__cnt = json_decode(ctjTx($__jscnt, "in"));
				}
			?>
			<tr>
				<td width='93%' class='_cntnm _<?php echo $row_Ls_Rg_Cll['call_callstatus']; ?>'>
					<?php echo Spn('','','_callstatus') ?>
					<?php echo h2($__cnt->nm.' '.$__cnt->ap.
								  bdiv(['cls'=>'_date', 'c'=>		
								  		Spn('','','_icn _dte').FechaESP_OLD($row_Ls_Rg_Cll['call_fi'],'yrdy').HTML_BR.
								  		Spn('','','_icn _hor')._DteHTML(['d'=>$row_Ls_Rg_Cll['call_fi'], 'nd'=>'no']) ,'','_dte']	
								  ).
								  bdiv(['c'=>$row_Ls_Rg_Cll['call_callstatus'],'cls'=>'_callstatus_tx'])
								); 
					?>
				</td>
				<td width='5%' class='_pronm'>
					<?php echo Spn(Cnv_Int_Tme($row_Ls_Rg_Cll['call_callduration']), 'ok')?>
				</td>
				<td width="1%" class="btn_call_again"><button onclick="SUMR_Call.f.cnt({ 'tp':'_slc', 'pc':'<?php echo $__cnt->mdlcnt; ?>', 'ic':'<?php echo $__cnt->cnt; ?>' });"></button></td>
				<td width="1%" class="btn_call_info"><button onclick="SUMR_Call.f.cnt({ 'tp':'_cll_inf',  'pc':'<?php echo $__cnt->mdlcnt; ?>', 'ic':'<?php echo $row_Ls_Rg_Cll['call_enc']; ?>' });"></button></td>
			</tr>
		<?php } while ($row_Ls_Rg_Cll = $Ls_Rg_Cll->fetch_assoc()); ?>
		</table>
		<?php } ?>
			
<?php }elseif($__tp == "_cll_inf"){	  ?>

	<?php  ?>

	<?php 
		
		$Ls_Qry_Cll = sprintf("	SELECT *,
							(	SELECT CONCAT('{\"nm\":\"',cnt_nm,'\", 
												\"ap\":\"',cnt_ap, '\", 
												\"cnt\":\"',cnt_enc, '\", 
												\"mdlcnt\":', '\"',mdlcnt_enc,'\"
											 }')
												
								FROM ".TB_MDL_CNT_CALL."
									 INNER JOIN ".TB_MDL_CNT." ON mdlcntcall_mdlcnt = id_mdlcnt
									 INNER JOIN ".TB_CNT." ON mdlcnt_cnt = id_cnt  
								WHERE mdlcntcall_call = id_call	 
							) AS _p_cnt,
							
							(	
								SELECT CONCAT('{\"nm\":\"',cnt_nm,'\", 
												\"ap\":\"',cnt_ap, '\", 
												\"cnt\":\"',cnt_enc, '\" 
											}')
											 
								FROM "._BdStr(DBM).TB_CALL_CNT." 
									 INNER JOIN ".TB_CNT." ON cntcall_cnt = id_cnt
									 
							) AS _cnt
	
							FROM "._BdStr(DBT).TB_CALL."
							WHERE id_call != '' {$__fl} AND call_enc = %s LIMIT 1", GtSQLVlStr( $__clidcl, "text"));
							
		$Ls_Rg_Cll = $__cnx->_qry($Ls_Qry_Cll);

		if($Ls_Rg_Cll){
			$row_Ls_Rg_Cll = $Ls_Rg_Cll->fetch_assoc(); 
			$Tot_Ls_Rg_Cll = $Ls_Rg_Cll->num_rows; 
		}
		if($Tot_Ls_Rg_Cll > 0){ ?>
			<?php echo HTML_inp_hd('_pg',$row_Ls_Rg_Cll['__rgtot'], ''); ?>
			<?php echo h2("Detalles","h_dtl"); ?>
			
			
			
			<?php if($Tot_Ls_Rg_Cll > 0){ ?>
			
			<table class='cll_tb inf'>
					
			<?php do{ ?>
				<?php
					if($row_Ls_Rg_Cll['_p_cnt'] != ''){ 
						$__jscnt = $row_Ls_Rg_Cll['_p_cnt']; 
					}elseif($row_Ls_Rg_Cll['_cnt'] !=''){ 
						$__jscnt = $row_Ls_Rg_Cll['_cnt']; 
					}
					if($__jscnt != ''){
						$__cnt = json_decode(ctjTx($__jscnt, "in"));
					}
				?>
				
				
				<p class="call_nm"><?php echo $__cnt->nm.' '.$__cnt->ap; ?></p>
				<p class="call_ph"><?php echo $row_Ls_Rg_Cll['call_phonenumber']; ?></p>
				<div class="icn_cll">  </div>
				
				<tr>
					<td><div class="icn_dtl dtl1"></div></td>
					<td class="lin"><?php echo (TX_CON_DRC.": ").HTML_BR; ?>
					<?php echo Spn(Cnv_Int_Tme($row_Ls_Rg_Cll['call_callduration']), 'ok'); ?></td>
				</tr>
				<?php /*<tr>
					<td><?php echo ("Destino: "); ?></td>
					<td><?php echo $row_Ls_Rg_Cll['call_phonenumber']; ?></td>
				</tr>
				<tr>
					<td><?php echo ("Contacto: "); ?></td>
					<td><?php echo $__cnt->nm.' '.$__cnt->ap; ?></td>
				</tr> */?>

				<tr>
					<td><div class="icn_dtl dtl2"></div></td>
					<td class="lin"><?php echo (TX_F.": ").HTML_BR; ?>
					<?php echo Spn(bdiv(['cls'=>' ', 'c'=>	FechaESP_OLD($row_Ls_Rg_Cll['call_fi'],'yrdy')]));?></td>
				</tr>
				<tr>
					<td><div class="icn_dtl dtl3"></div></td>
					<td class="lin"><?php echo (TX_HR.": ").HTML_BR; ?>
					<?php echo Spn(bdiv(['cls'=>' ', 'c'=> _DteHTML(['d'=>$row_Ls_Rg_Cll['call_fi'], 'nd'=>'no']) ,'','_dte']	)); ?></td>	
				</tr>
				<tr>
					<td><div class="icn_dtl dtl4"></div></td>
					<td><?php echo  (TX_CLL." ".TX_RLZBY).HTML_BR; ?>
					<?php echo Spn($row_Ls_Rg_Cll['call_caller']); ?></td>
					
				</tr>
			<?php } while ($row_Ls_Rg_Cll = $Ls_Rg_Cll->fetch_assoc()); ?>
			</table>
			
			<?php } ?>
			
		<?php } ?>
	
<?php }elseif($__tp == "_slc"){ ?>
		
		<?php  ?>
		
		<?php 
			$FncRnd = Gn_Rnd(20);
			$__tkn = __ApTkn( ['c'=>'CRM'] );			
			//$__dt_mdl_cnt = GtMdlCntDt($__cipcn);
			$__dt_mdl_cnt = GtMdlCntDt([ 'id'=>$__cipcn, 't'=>'enc', 'shw'=>[ 'cnt'=>'ok' ] ]);
			$__dt_cnt_p = Gt_FllCnt([ 'cnt'=>$__dt_mdl_cnt->cnt->id ]);
		?>
		
		<div class='btn_cll_bx_dt' id='btn_cll_bx_<?php echo $__rnd_op ?>' >
			
			<div class='div_cll_us'>
				<ul>
					<li>
						<div class="us_pic">
							
							<div id="__grph_crsl_pic_<?php echo $__rnd_op; ?>" class="owl-carousel">
						        <?php if($__dt_cnt_p->pht != NULL){ ?>
							        <?php foreach($__dt_cnt_p->pht as $_k => $_v){ ?>
							        <div class="item"><img src="<?php echo $_v->url ?>" /></div>
							        <?php } ?>
						        <?php }else{ ?>
						        	<div class="item"><img src="<?php echo DMN_IMG_ESTR_SVG.'call_user.svg' ?>" /></div>
						        <?php } ?>
						    </div>
							<?php
		
								$CntWb .= 'SUMR_Main.ld.f.owl( function(){
												
												SUMR_Main.ld.f.knob( function(){
													
													$("#__grph_crsl_pic_'.$__rnd_op.'").owlCarousel({
														autoPlay: true,
														stopOnHover: true,
														navigation : true,
														slideSpeed : 300,
														paginationSpeed : 400,
														navigation: true,
														singleItem: true 
													});
													
												});	
												
											});';
								
							?>	
						</div>
					</li>
					<li><?php echo h2( $__dt_mdl_cnt->cnt->nm.' '.$__dt_mdl_cnt->cnt->ap ); ?></li>						
					<li>
						<?php 
							
							$__TelDt = GtCntTelDt(['id'=>$__telid, 't'=>'enc']);
							
							echo LsCntTel(['id'=>'call_tel'.$__rnd_op, 'cnt'=>$__dt_mdl_cnt->cnt->id, 'ct'=>'no', 'rq'=>2, 'va'=>$__TelDt->tel ]); ?> 
					<?php $CntWb .= JQ_Ls('call_tel'.$__rnd_op, FM_LS_SLTEL, '', '', ['ac'=>'no'] ); ?>
					</li>
					
				</ul>				
			</div>
			
			<?php if(_ChckMd('call')){  ?>
			<div class='btn_cll_bx_slc'>	
				<div class="_c">		
					<div class='_c1'>
						<button class='btn_mute'></button>
					</div>
					<div class='_c2'>
						<button rel='<?php echo $__dt_mdl_cnt->id; ?>' class='btn_call'></button>
					</div>
				</div>
				<div class='call_opt'>
					<div id='call_my'>
						<?php echo LsUsTel(['id'=>'us_tel'.$__rnd_op, 'v'=>'id_ustel', 'us'=>SISUS_ID, 'ct'=>'no', 'rq'=>2 ]); ?> 
						<?php $CntWb .= JQ_Ls('us_tel'.$__rnd_op, '', '', '', ['ac'=>'no'] ); ?> 	
						<?php echo OLD_HTML_chck('call_mydvc', TX_UMYCEL); ?>
					</div>	
				</div>	
			</div>
			<?php }else{ ?>	
				<div class='btn_cll_bx_nomdl call_noty wrn'>
					<?php echo TX_PFNTCLL ?>
				</div>
			<?php } ?>
			<div class='btn_cll_bx_prgs call_noty inf'>
				<?php echo TX_CNTSISTCL ?>
			</div>
			<div class='btn_cll_bx_off call_noty wrn'>
				<?php echo TX_SNPRCLL ?>
			</div>	
			<div class='btn_cll_bx_bsy call_noty wrn'>
				<?php echo TX_SOCPCLL ?>
			</div>
		</div>
<?php 
			
		$CntWb .= '	
			
			function f_'.$FncRnd.'(_p){
								
				var __id_sid = _p.sid;
				
				if(__id_sid != undefined && __id_sid != ""){
																	
					$.ajax({
						type: "POST",
						dataType: "json",
						url:"'.FL_JSON_GN.__t('call_mydvc', true).'",
						data: { "__sid": __id_sid, "__p": "dt" },
						success: function(d) {
							if(d.call.est.id != "completed" && $("#f_'.$FncRnd.'_cod").is(":visible")){
								
								swal({
								  title: "<div><span style=\'color:#3398bd\' id=\'f_'.$FncRnd.'_cod\'>"+d.call.est.tt+"<span></div>",
								  text: d.call.est.stt,
								  html: true,
								  type: "info"
								});
									
								setTimeout(function(){ 
					        		f_'.$FncRnd.'({ sid: __id_sid });
					        	}, 3000);
								
						    }else{
							    									    
							    swal({
								  title: "'.TX_YCLL.'",
								  text: "'.TX_FNZLD.'",
								  html: true,
								  type: "success"
								});
							    
						    }
						}
					});
					
				}
        	}
			
			function __CallNow_'.$FncRnd.'(){
				
				SUMR_Call.__tel = $("#call_tel'.$__rnd_op.'").val();	
				SUMR_Call.__tel_id = $(\'#call_tel'.$__rnd_op.' option:selected\').attr(\'rel\');
				SUMR_Call.__tel_us = $(\'#us_tel'.$__rnd_op.'\').val();
			
				/*SUMR_Call.f.opn({ c:"ok" });*/
				
				if($("#call_mydvc").is(":checked")){
					
					SUMR_Call.f.mydvc({
						_cl:SUMR_Main.cl.id, 
						_n:SUMR_Call.__tel,
						_n_id:SUMR_Call.__tel_id,
						_us:SUMR_Main.us.enc,
						_ustel:SUMR_Call.__tel_us,
						_c:function(c){
							if(c.e == "ok"){
								swal({
								  title: "<div>'.TX_STBLCD.'<span style=\'color:#3398bd\' id=\'f_'.$FncRnd.'_cod\'>'.TX_CNEXN.'<span></div>",
								  text: "'.TX_RCCLLINS.'",
								  html: true,
								  type: "info"
								});
								setTimeout(function(){ 
						        	f_'.$FncRnd.'({ sid: c.sid });
						        }, 3000);
							}	
						}
					});
							
				}else{ 
					
					SUMR_Call.f.init({
						_cl:SUMR_Main.cl.id, 
						_tkn: \''.$__tkn.'\', 
						_b: \'btn_call\',
						_bx: \'btn_cll_bx_'.$__rnd_op.'\',
						_n: SUMR_Call.__tel,
						_n_id: SUMR_Call.__tel_id,
						_cnt: \''.$__dt_mdl_cnt->cnt->enc.'\',
						_mdlcnt: \''.$__dt_mdl_cnt->enc.'\',
						_us:SUMR_Main.us.enc,
						_ustel: SUMR_Call.__tel_us,
						_c:function(c){
							if(!isN(c.his)){
								if(!isN(SUMR_Call.f.mdlcnt_his)){
									if(!isN(c.his.enc) && !isN(c.his.mdlcnt) && !isN(c.his.mdlcnt.enc)){
										SUMR_Call.f.mdlcnt_his({ mdlcnt:c.his.mdlcnt.enc, mdlcnthis:c.his.enc });
									}
								}
							}	
						}
					});
					
				}
				
			}
			
			$(".btn_mute").off("click").click(function() {
				SUMR_Call.f.mute();
			});
			
			$(".btn_call").off("click").click(function() {
				__CallNow_'.$FncRnd.'();
			});

			SUMR_Main.ld.f.call(function(){
				SUMR_Call.f.rdy({ 
					_b: \'btn_call\',
					_tkn: \''.$__tkn.'\',
					_c:function(){
						SUMR_Call.f.dom();	
					}
				});
			});
		';
				
?>
<?php } ?>