<?php 
if(class_exists('CRM_Cnx')){
	$___Ls->cnx->cl = 'ok';
	$___Ls->img->dir = DIR_IMG_WEB_EC_TH;

	
	$___Ls->new->big = 'ok';
	$___Ls->edit->big = 'ok';
	
	$___Ls->sch->f = 'id_sgn, sgn_cd, sgn_tt';
	$___Ls->_strt();
	
	if(!isN($___Ls->gt->i)){	
		$___Ls->qrys = sprintf("SELECT * FROM ".TB_SGN." WHERE ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));
	}else{ 
		$Ls_Whr = "FROM ".TB_SGN." WHERE ".$___Ls->ino." != '' ".$___Ls->sch->cod." ORDER BY ".$___Ls->ino." DESC";
		$___Ls->qrys = "SELECT *, (SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." $Ls_Whr"; 
	} 
	
	$___Ls->_bld(); 
	
	if($___Ls->ls->chk=='ok'){ 
		$__blq = 'off';	
		$___Ls->_bld_l_hdr();
		if(($___Ls->qry->tot > 0)){ ?>
			<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg LsRgNw">
				
				<?php do { ?>
					<tbody>  	
						<tr>
							<td class="_img_rnd" width="0%" <?php echo NWRP ?>><?php echo _LdImg([ 's'=>($__tmplflt=='cmz'?$img_th->th_100:$img_th->ste->th), 'i'=>$___Ls->ls->rw[$___Ls->ino].$img_rnd ]); ?></td>
							<td width="95%" align="left" nowrap="nowrap">
							<?php 
								echo h2( ShortTx( ctjTx($_cod." ".$___Ls->ls->rw['sgn_tt'],'in') ,60,'Pt', true) ) .
								(($___Ls->ls->rw['sgn_fs']!='')? Spn( TX_DTAPRB .$___Ls->ls->rw['sgn_fs'],'','_f'):'' ).HTML_BR.
								Spn($___Ls->ls->rw['sisest_tt'],'',$___Ls->ls->rw['sisest_sty']).HTML_BR. 
								($___Ls->ls->rw['sgn_em']!=''?Spn(ctjTx($___Ls->ls->rw['sgn_em'],'in'), '', '_f'):'').
								(($___Ls->ls->rw['sgn_fi']!='')? Spn($___Ls->ls->rw['sgn_fi'],'','_f'):'' ); 
							?>				
							</td>
							<td width="0%" class="c" align="center" nowrap="nowrap">
								<?php if(!_cdgwrn($___Ls->ls->rw['ec_cd'])){ echo Strn('Bien','ok'); } else{ echo Strn('Mal','no') ; } echo HTML_BR.Spn(TX_COD);  ?>
							</td>
							<?php if($__tmplflt == 'cmz' || $__tmplflt == 'data' || $__tmplflt == ''){ ?>
								<td width="1%" align="left" class="_btn"><?php echo $___Ls->_btn([ 't'=>'mod' ]); ?></td>
							<?php } ?>
						</tr>
					</tbody>
				<?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>
			</table>
			<?php $___Ls->_bld_l_pgs(); ?>
		<?php } ?>
		<?php $___Ls->_h_ls_nr(); ?>
		<?php $CntWb .= '
			$("._rpr").colorbox({ width:"450px", height:"400px", overlayClose:false, escKey:false, trapFocus:false });
			$("._html").colorbox({ width:"450px", height:"400px", overlayClose:false, escKey:false, trapFocus:false }); 
			$("._dwn").colorbox({ iframe:true, width:"1000px", height:"600px", overlayClose:false, escKey:false, trapFocus:false });
			/*$("._dsgn").colorbox({ width:"95%", height:"95%", overlayClose:false, escKey:false});*/
			'; 
			/*$CntWb .= "
			function _rld_sgn(){ 
			$('.note-popover').hide();
			".JQ__ldCnt([ 'u=>'FL_LS_GN.__t($__bdtp,true).$___Ls->ls->vrall, 'c'=>$___Ls->bx_rld ])."
			}
			";*/
		?>
	<?php } ?>
	<?php if($___Ls->fm->chk=='ok'){ $__blq = 'on'; ?>
			<div class="FmTb">
				<?php $__RndId = '_'.Gn_Rnd(10); ?>
				<div id="bld_strt<?php echo $__RndId; ?>" <?php if($__option != 'ok' || $___Ls->dt->tot > 0){ ?>style="display: none;" <?php } ?> >
					<?php include('sgn_1.php'); ?>
				</div>
				<div id="bld_ec<?php echo $__RndId; ?>" <?php if($__option == 'ok' && $___Ls->dt->tot == 0){ ?>style="display: none;" <?php } ?> >
					<?php include('sgn_2.php'); ?>
				</div>
			</div>
	<?php } ?>
<?php } $CntWb .= JV_Blq($__blq).JV_HtmlEd($__jqte); 

?>