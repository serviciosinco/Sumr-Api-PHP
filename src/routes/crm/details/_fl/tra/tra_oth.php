<?php 

	$__cnt = Php_Ls_Cln($_GET['cnt']);
	$__dthmlg = GtCntEstTra([ 'cl'=>DB_CL_ID, 'est'=>_CId('ID_TRAEST_PRC') ]);
	$__dthmlga = GtCntEstTra([ 'cl'=>DB_CL_ID, 'est'=>_CId('ID_TRAEST_ARCHV') ]);

	$Ls_Qry = "	SELECT mdl_nm, mdl_img, siscntest_tt, siscntest_clr_bck, mdlcnt_fi, mdlcnttra_tra, tra_enc, mdlcnt_est
				FROM  ".TB_MDL_CNT."
						INNER JOIN ".TB_MDL_CNT_TRA." ON mdlcnttra_mdlcnt = id_mdlcnt
						INNER JOIN "._BdStr(DBM).TB_TRA." ON mdlcnttra_tra = id_tra
						INNER JOIN ".TB_CNT." ON mdlcnt_cnt = id_cnt
						INNER JOIN ".TB_MDL." ON mdlcnt_mdl = id_mdl
						INNER JOIN "._BdStr(DBM).TB_MDL_S." ON mdl_mdls = id_mdls
						INNER JOIN "._BdStr(DBM).TB_SIS_CNT_EST." ON mdlcnt_est = id_siscntest		 
				WHERE 	cnt_enc = ".GtSQLVlStr($__cnt, "text")." AND 
						mdls_tp = ".GtSQLVlStr(_Cns('SIS_MDLSTP_SAC'), "int")." AND
						( mdlcnt_est = ".GtSQLVlStr($__dthmlg->id, "int")." ||  mdlcnt_est = ".GtSQLVlStr($__dthmlga->id, "int")." )
				ORDER BY mdlcnt_fi DESC";

	$Ls = $__cnx->_qry($Ls_Qry);	

	if($Ls){

		$row_Ls = $Ls->fetch_assoc(); 
		$Tot_Ls = $Ls->num_rows;

		if($Tot_Ls > 0){
			do{	
				$_data[$row_Ls['mdlcnt_est']][] = $row_Ls;	
			}while( $row_Ls = $Ls->fetch_assoc() );
		}

	} 	

	$__cnx->_clsr($Ls);

?>
<div class="tra_oth_dash">
	<div class="_cvr"></div>
	<h1>
		Encontramos los siguientes
		<span>Tickets Abiertos</span>
	</h1>
	<div class="tick-items">
		<?php foreach($_data[$__dthmlg->id] as $_data_k=>$_data_v){ ?>
			<?php $_lst_cmnt = GtTraCmntLast([ 'id'=>$_data_v['mdlcnttra_tra'] ]); ?>
			<div class="item" data-id="<?php echo $_data_v['tra_enc']; ?>">
				<div class="rsm">
					<div class="c c1">
						<?php $_img = _ImVrs(['img'=>ctjTx($_data_v['mdl_img'],'in'), 'f'=>DMN_FLE_MDL ]); ?>
						<figure style="background-image:url(<?php echo $_img->big; ?>);"></figure>
					</div>
					<div class="c c2">
						<h2><?php echo ctjTx($_data_v['mdl_nm'],'in'); ?></h2>
						<span style="background-color:<?php echo $_data_v['siscntest_clr_bck']; ?>" class="status"><?php echo ctjTx($_data_v['siscntest_tt'],'in'); ?></span>
						<?php if(!isN($_lst_cmnt->tt)){ ?>
							<div class="lcmnt">
								<div class="tt">Ultimo comentario</div>
								<div class="txw">
									<div class="us" title="<?php echo $_lst_cmnt->us->nm; ?>">
										<div class="th" style="background-image:url(<?php echo $_lst_cmnt->us->img->th_100; ?>);"></div>
									</div>
									<div class="tx">
										<?php echo $_lst_cmnt->tt; ?>
										<div class="f"><?php echo FechaESP([ 'f'=>$_lst_cmnt->fi, 't'=>'cmpr' ]); ?></div>
									</div>	
								</div>
							</div>
						<?php } ?>
					</div>
					<div class="fi"><?php echo FechaESP([ 'f'=>$_data_v['mdlcnt_fi'], 't'=>'cmpr', 'brk'=>'ok' ]); ?></div>
				</div>
			</div>
		<?php } ?>
	</div>
	<br>
	<h1>
		<span>Tickets Archivados</span>
	</h1>
	<div class="tick-items">
		<?php foreach($_data[$__dthmlga->id] as $_data_a_k=>$_data_a_v){ ?>
			<?php $_lst_cmnt = GtTraCmntLast([ 'id'=>$_data_a_v['mdlcnttra_tra'] ]); ?>
			<div class="item" data-id="<?php echo $_data_a_v['tra_enc']; ?>">
				<div class="rsm">
					<div class="c c1">
						<?php $_img = _ImVrs(['img'=>ctjTx($_data_a_v['mdl_img'],'in'), 'f'=>DMN_FLE_MDL ]); ?>
						<figure style="background-image:url(<?php echo $_img->big; ?>);"></figure>
					</div>
					<div class="c c2">
						<h2><?php echo ctjTx($_data_a_v['mdl_nm'],'in'); ?></h2>
						<span style="background-color:<?php echo $_data_a_v['siscntest_clr_bck']; ?>" class="status"><?php echo ctjTx($_data_a_v['siscntest_tt'],'in'); ?></span>
						<?php if(!isN($_lst_cmnt->tt)){ ?>
							<div class="lcmnt">
								<div class="tt">Ultimo comentario</div>
								<div class="txw">
									<div class="us" title="<?php echo $_lst_cmnt->us->nm; ?>">
										<div class="th" style="background-image:url(<?php echo $_lst_cmnt->us->img->th_100; ?>);"></div>
									</div>
									<div class="tx">
										<?php echo $_lst_cmnt->tt; ?>
										<div class="f"><?php echo FechaESP([ 'f'=>$_lst_cmnt->fi, 't'=>'cmpr' ]); ?></div>
									</div>	
								</div>
							</div>
						<?php } ?>
					</div>
					<div class="fi"><?php echo FechaESP([ 'f'=>$_data_a_v['mdlcnt_fi'], 't'=>'cmpr', 'brk'=>'ok' ]); ?></div>
				</div>
			</div>
		<?php } ?>
	</div>
</div>

<?php 


	$CntWb .= "
	
		$('.tra_oth_dash .tick-items .item').off('click').click(function(){ 
			var id = $(this).attr('data-id');
			_ldCnt({ 
				u:'_cnt/_dt/_gn.php?_t=tra&_i='+id+'&__cll=ok', 
				pop:'ok',
				pnl:{
					e:'ok',
					s:'l',
					tp:'h',
				},
				_cl:function(){
					SUMR_Tra.f.Rqu({
						d:{
							tp:'dt',
							enc:SUMR_Tra.f.oid(),
							fi:SUMR_Tra.bxajx.fi_tme
						},
						_cl:function(_r){
							if(!isN(_r)){
								if(!isN(_r.d)){		
									$(SUMR_Tra.s.s200+','+SUMR_Tra.s.s207).removeClass('_ldr');
									SUMR_Tra.f.DtBld();
								}	
							}
						}
					});	
				}
			});
		});	
	";

?>