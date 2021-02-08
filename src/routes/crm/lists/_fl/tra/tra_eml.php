<?php 
if(class_exists('CRM_Cnx')){
	
	$___eml = new CRM_Eml();
	$___Ls->cnx->cl = 'ok';
	$___Ls->sch->f = 'emlcnv_snpt, emlmsg_bdy_snpt';

	$___Ls->sch->m = ' || 	(
								id_emlmsg IN (	SELECT emlmsgaddr_msg 
												FROM '._BdStr(DBT).TB_THRD_EML_MSG_ADDR.' 
													INNER JOIN '._BdStr(DBM).TB_FLL_CNT.' ON emlmsgaddr_fllcnt = id_fllcnt
												WHERE fllcnt_eml LIKE \'%[-SCH-]%\'
							) 
					
	)';

	$___Ls->_strt();
	
	if(_SbLs_ID('i')){ $__fl .= _AndSql('trarsp_tra', _SbLs_ID('i')); }
	
	if(!isN($___Ls->gt->i)){	

		$___Ls->qrys = sprintf("SELECT * FROM "._BdStr(DBM).TB_TRA_RSP.", "._BdStr(DBM).TB_US.", "._BdStr(DBM).TB_TRA."
						   WHERE trarsp_us = id_us AND
						   		 trarsp_tra = id_tra AND 
								 ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));				 
		
	}elseif($___Ls->_show_ls == 'ok'){ 

		if(isN($___Ls->sch->cod)){
			$_fl .= '
				AND emlbox_jnk = 2
				AND emlbox_trsh = 2
			';
		}

		//--------- Start - Get Emails Account of User - Build Query / Buils Buttons Accounts ---------//

			$_eml_acc = GtEmlLs();
			$_eml_acc_bx = '';
			
			if(!isN($_eml_acc->ls) && $_eml_acc->tot > 1){
				
				foreach($_eml_acc->ls as $_eml_acc_k=>$_eml_acc_v){
					
					if(!isN($_eml_acc_v->img->th_100)){ $_thmb=$_eml_acc_v->img->th_100; }else{ $_thmb=$_eml_acc_v->avtr; }
					if($_eml_acc_v->view != 'ok'){ 
						$_bx_view_cls='off'; 
					}else{ 
						$_bx_view_cls=''; 
						$_eml_acc_bx_q[] = $_eml_acc_v->id;
					}

					$_eml_acc_bx_a[] = '"'.$_eml_acc_v->enc.'"';
					$_eml_acc_bx .= '<div class="eml_box '.$_bx_view_cls.'" eml-id="'.$_eml_acc_v->enc.'">
											<div style="background-image:url('.$_thmb.');" class="avtr" title="'.$_eml_acc_v->nm.' ('.$_eml_acc_v->eml.')"></div>
									</div>';

				}

				if(!isN($_eml_acc_bx_a)){ $CntWb .= "	SUMR_Main.eml.o.acc = [".implode(',',$_eml_acc_bx_a)."];"; }
				if(!isN($_eml_acc_bx_q)){ $_fl .= " AND emlmsg_eml IN (".implode(',',$_eml_acc_bx_q).") "; }else{ $_fl .= " AND useml_us = -1 "; }

			}else{

				$_fl .= " AND useml_us = '".SISUS_ID."'";

			}

		//--------- Start - Get Emails Account of User - Build Query / Buils Buttons Accounts ---------//


		$Ls_Whr = "FROM "._BdStr(DBC).VW_MAIN_CNV_EML."
						LEFT JOIN ".TB_MDL_CNT_CNV." ON mdlcntcnv_cnv = id_maincnv
				   WHERE 	id_emlmsg != '' AND 
							cleml_cl = '".DB_CL_ID."' AND
							emlcnv_sac != 3 AND 
							emlmsg_inp = 'in' AND
							emlbox_drf = 2 AND
							emlbox_view = 1 AND
							emlbox_out = 2 AND
							mdlcntcnv_mdlcnt IS NULL
							".$___Ls->sch->cod." {$_fl}
			";
                   
        $___Ls->qrys = "SELECT id_emlcnv, maincnv_enc, emlcnv_enc, emlcnv_snpt, emlcnv_snpt, id_emlmsg, emlmsg_eml, emlmsg_f, emlbox_lbl, mdlcntcnv_mdlcnt,
								(SELECT COUNT(DISTINCT emlcnvmsg_cnv) $Ls_Whr) AS ".QRY_RGTOT." 
						$Ls_Whr
						GROUP BY emlcnvmsg_cnv
						ORDER BY emlmsg_f DESC";
        
		$___Ls->hdr->mre .= '<div id="show_opt_'.$___Ls->id_rnd.'" class="_anm eml-opt"><div class="chk">'.$___Ls->inp_chk([ 't'=>'d1', 'id'=>'chk_all_'.$___Ls->id_rnd ]).'</div></div>';
		if(!isN($_eml_acc_bx)){ $___Ls->hdr->mre .= '<div id="show_box_'.$___Ls->id_rnd.'" class="_anm box-slc">'.$_eml_acc_bx.'</div>'; }

	}

	$___Ls->tt = null;
	$___Ls->_bld(); //echo $___Ls->qrys;

?>
<?php if($___Ls->ls->chk=='ok'){ $__blq = 'off'; ?>

<div class="myeml_dash">
	<section class="_cvr" ></section>
	<div class="eml-wrp">
		<?php $___Ls->_bld_l_hdr(); ?>
		<?php if(($___Ls->qry->tot > 0)){ ?>
		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg LsRgNw LsRgEml">
			<tbody>
				<?php do { ?>
				<tr row-id="<?php echo $___Ls->ls->rw['maincnv_enc']; ?>">
					<td width="1%" align="left" nowrap="nowrap">
						<div class="chk">
						<?php 
							echo $___Ls->inp_chk([ 
									't'=>'d1', 
									'id'=>$___Ls->ls->rw['maincnv_enc'],
									'attr'=>[
										'cnv-id'=>$___Ls->ls->rw['maincnv_enc']
									]
								]);
						?>
						</div>
					</td>
					<td width="1%" align="left" nowrap="nowrap">
						<?php 

							$__nm = [];
							$__lbl = $___eml->_box_lbl([ 'id'=>$___Ls->ls->rw['emlbox_lbl'] ]);

							//if(isN($___Ls->ls->rw['from_name'])){
								$__addr = $___eml->_gt_ls_addr([ 'cnv'=>$___Ls->ls->rw['id_emlcnv']]);
								
								if(!isN($__addr->ls->from)){
									foreach($__addr->ls->from as $__addr_k=>$__addr_v){ 
										//echo json_encode($__addr_v->dt->nm); 
										$__nm[] = !isN($__addr_v->dt->nm)?$__addr_v->dt->nm:$__addr_v->dt->eml;
									}
									$__nm = implode(',',$__nm);
								}
							/*}else{
								$__nm = ctjTx($___Ls->ls->rw['from_name'],'in');
							}*/

							if(ChckSESS_superadm() && !isN($___Ls->ls->rw['mdlcntcnv_mdlcnt'])){ 
								$_prfx_eml = $___Ls->ls->rw['mdlcntcnv_mdlcnt']/*.'->'*/; 
							}else{
								$_prfx_eml = '';
							}

							echo Strn( $_prfx_eml.$__nm, 'from');
							//echo Spn($___Ls->ls->rw['maincnv_enc']);

						?>
					</td>
					<td width="80%" align="left" nowrap="nowrap">
						<?php 
							if(!isN($___Ls->ls->rw['emlcnv_snpt'])){
								echo Spn(ctjTx($___Ls->ls->rw['emlcnv_snpt'],'in'),'','snpt');
							}else{
								echo Spn('(Sin asunto)','','snpt');
							}
							echo Spn($__lbl->nm,'','lbl');
							//if(ChckSESS_superadm()){ echo HTML_BR.$___Ls->ls->rw['emlmsg_f']; }
						?>
					</td>
					<td width="5%" align="left" nowrap="nowrap"><?php ?></td>
					<td width="5%" align="left" nowrap="nowrap">
						<div class="rw-wrp">
							<div class="rw-dte _anm">
								<?php echo FechaESP([ 'f'=>$___Ls->ls->rw['emlmsg_f'], 't'=>'cmpr', 'brk'=>'ok' ]); ?>
							</div>
							<div class="rw-opt _anm">
								<button class="btn-sac _anm" cnv-id="<?php echo $___Ls->ls->rw['maincnv_enc']; ?>"></button>
								<button class="btn-sac-no _anm" cnv-id="<?php echo $___Ls->ls->rw['maincnv_enc']; ?>"></button>
							</div>
						</div>
					</td>
					<td width="5%" align="left" nowrap="nowrap" class="_btn">
						<?php echo HTML_Ls_Btn([ 't'=>'onl', 'rel'=>$___Ls->ls->rw['maincnv_enc'], 'cls'=>'shw_eml_cnv', 'l'=>Void() ]);  ?>	
					</td>
				</tr>
				<?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>
			</tbody>
		</table>
		<?php $___Ls->_bld_l_pgs(); ?>
		<?php 

			$CntWb .= "
					
				$('.shw_eml_cnv').click(function(){

					var _enc = $(this).attr('rel');
					
					_ldCnt({
						u:'".FL_DT_GN.__t('my_eml_cnv', true)."&cnv_id='+_enc,
						c:'',
						pop:'ok',
						cls:'_fll _thdr',
						pnl:{
							e:'ok',
							s:'l',
							tp:'h'
						}
					});

				});
				
			";
		?>
	</div>
</div>
<?php } ?>
<style>

	#<?php echo $___Ls->id_hdr; ?>{ position:sticky; position:-webkit-sticky; top:150px; padding: 10px 20px 10px 8px; background-color: #fff; z-index:10; }
	#<?php echo $___Ls->id_hdr; ?> .__hdr_btn{ width:100%; }
	#<?php echo $___Ls->id_hdr; ?> .__hdr_btn .__hdr_mre{ border:none; }
	#<?php echo $___Ls->id_hdr; ?> .___in{ display:none; }
	#<?php echo $___Ls->id_hdr; ?> .eml-opt{ height: 20px; padding:0px; border:none; margin-right: 20px; }

	#<?php echo $___Ls->id_hdr; ?> .eml-opt .chk{ padding-top:10px; }

	#<?php echo $___Ls->id_hdr; ?> .eml-opt .sac,
	#<?php echo $___Ls->id_hdr; ?> .eml-opt .no-sac{  }

	#<?php echo $___Ls->id_hdr; ?> .eml-opt .sac button,
	#<?php echo $___Ls->id_hdr; ?> .eml-opt .no-sac button{ width:30px; height:30px; padding:7px; min-height: 30px; max-height: 30px; background-repeat:no-repeat; background-position:center center; background-size: auto 80%; }
	#<?php echo $___Ls->id_hdr; ?> .eml-opt .sac button:hover,
	#<?php echo $___Ls->id_hdr; ?> .eml-opt .no-sac button:hover{ padding:7px; background-size: auto 70%; }

	#<?php echo $___Ls->id_hdr; ?> .eml-opt .sac button{ background-image: url('<?php echo DMN_IMG_ESTR_SVG.'eml_snd_sac.svg'; ?>'); }
	#<?php echo $___Ls->id_hdr; ?> .eml-opt .no-sac button{ background-image: url('<?php echo DMN_IMG_ESTR_SVG.'eml_snd_nosac.svg'; ?>'); }

	#<?php echo $___Ls->id_hdr; ?> .box-slc{ height: 20px; padding:0px; border:none; }
	#<?php echo $___Ls->id_hdr; ?> .box-slc._ld{ pointer-events:none; }
	#<?php echo $___Ls->id_hdr; ?> .box-slc .eml_box{ height: 30px; width:30px; border:1px solid #ccc; margin-right:5px; border-radius:200px; -moz-border-radius:200px; -webkit-border-radius:200px; cursor:pointer; }
	#<?php echo $___Ls->id_hdr; ?> .box-slc .eml_box._ld .avtr{ background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>mail_loader.svg') !important; background-size: 15px auto; background-position: center center; background-repeat: no-repeat; }
	#<?php echo $___Ls->id_hdr; ?> .box-slc .eml_box .avtr{ height: 30px; width:30px; border-radius:200px; -moz-border-radius:200px; -webkit-border-radius:200px; overflow:hidden; background-size:cover; background-repeat:no-repeat; background-position:center center; border:2px solid white; pointer-events:none; }
	#<?php echo $___Ls->id_hdr; ?> .box-slc .eml_box.off .avtr{ opacity:0.3; }

</style>

<?php 

	if(!isN($_eml_acc_bx_a)){
		$CntWb .= "	SUMR_Main.eml.o.acc = [".implode(',',$_eml_acc_bx_a)."];";
	}

	$CntWb .= "	SUMR_Main.eml.rnd = '".$___Ls->id_rnd."'; 
				SUMR_Main.eml.plct = '".$___Ls->gt->plct."';
				SUMR_Main.eml.opt(); 
			"; 
?>
<?php $___Ls->_h_ls_nr(); ?>
<?php } ?>
<?php if($___Ls->fm->chk=='ok'){ ?>
<div class="FmTb">
  <div id="<?php echo DV_GNR_FM.DV_SBCNT ?>">
    <?php 
	    ?>
    <?php 
		$__fm_trg = ' target="_self" name="'.$__fmnm.'" id="'.$__fmnm.'" ';
		//$__fm_trg = ' target="_blank" ';
	?>
    <form action="<?php echo Fl_Rnd(PRC_GN.__t($__bdtp,true)) ?>" method="POST" <?php echo $__fm_trg ?> >
      <?php $___Ls->_bld_f_hdr(); ?>
		<div class="ln_1">
            <div class="col_1"> 
                <?php echo HTML_inp_hd('trarsp_us_asg', SISUS_ID); ?>
                <?php echo HTML_inp_hd('trarsp_tra', _SbLs_ID('i')); ?>
                <?php echo LsUs('trarsp_us','id_us', $___Ls->dt->rw['trarsp_us'], FM_LS_SLUSRSP, 2); $CntWb .= JQ_Ls('trarsp_us',FM_LS_SLUSRSP); ?>
                <?php $l = __Ls(['k'=>'us_rol', 'id'=>'trarsp_tp', 'va'=>$___Ls->dt->rw['trarsp_tp'] , 'ph'=>FM_LS_SLGN]); echo $l->html; $CntWb .= $l->js; ?>
            </div>
            <div class="col_2"> 
                <?php echo HTML_textarea('trarsp_dsc', TX_OBS, ctjTx($___Ls->dt->rw['trarsp_dsc'],'in'), '', 'ok'); ?>   
            </div>
        </div>
    </form>
  </div>
</div>
<?php } ?>
<?php } ?>
