<?php 

	$___Ls = new CRM_Ls();

	$___Ls->cnx->cl = 'ok';
	$___Ls->sch->f = 'c_tt, ec_dsc, ec_lnk, ec_pml, ec_ord';
	$___Ls->ino = 'id_ec';
	$___Ls->ik = 'ec_enc';
	$___Ls->_strt();
	
	if(_Chk_GET('_are')){ $__fl .= _AndSql('ec_are', Php_Ls_Cln($_GET['_are'])); }
	
	if(_Chk_GET('_f1') && _Chk_GET('_f2')){ 
		$__fl .= ' AND ec_fi BETWEEN '.GtSQLVlStr($_GET['_f1'], 'date').' AND '.GtSQLVlStr($_GET['_f2'], 'date'); 
	}elseif(_Chk_GET('_f1')){
		$__fl .= ' AND ec_fi = '.GtSQLVlStr($_GET['_f1'], 'date'); 
	}elseif(_Chk_GET('_f2')){
		$__fl .= ' AND ec_fi = '.GtSQLVlStr($_GET['_f2'], 'date'); 
	}
	
	$Ls_Whr = "	FROM "._BdStr(DBM).TB_EC." 
				WHERE 	ec_est = '"._CId('ID_SISEST_OK')."' AND 
						ec_pst_fb = 1 AND 
						ec_cl = '".$__dt_cl->id."'
						$__schcod $__fl 
				ORDER BY ec_tb_ord IS NULL, ec_tb_ord ASC, id_ec DESC";
	
	$___Ls->qrys = "SELECT *, (SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." $Ls_Whr";
	$___Ls->_bld();

?>
<?php if($___Ls->qry->tot > 0){ ?>
	<div class="_lsfltr">
		<div id="FlC_1" class="CollapsiblePanel">
			<div class="CollapsiblePanelTab" tabindex="0"><?php echo TX_TTMN_FL ?></div>
			<div class="CollapsiblePanelContent col_x5">
			
				<div class="col col_1">
					<div class="sch">
					<?php 
						
						if($__sch != ''){ $_v_a = $__sch; }
						$__sch_bx = Inp_Sch([ 'a'=>'ok', 'v'=>$_v_a, 'n'=>$__s_fld ]); 

						echo $__sch_bx->html;

						$CntWb .= $__sch_bx->js;

						$CntWb .= "
							
							function Sch_Ls(){
									var _valinp = $('#".$__s_fld."').val();
									var fl_are = $('#_are').val();
									var fl_f1 = $('#_f1').val();
									var fl_f2 = $('#_f2').val();
									_ldCnt('".$__ls."?&sch='+ _valinp +'&_are='+ fl_are+'&_f1='+ fl_f1 +'&_f2='+ fl_f2 +'&__rnd=".Gn_Rnd(3)."');
							} 
							
							function Sch_Cl(){ _ldCnt('".$__ls."?".$_mrvr."Rnd=".Gn_Rnd(3)."'); } 
							
							$('#".BTN_SCHCLN."').click(function() { Sch_Cl(); });
							$('#".BTN_SCH."').click(function() { Sch_Ls(); });
						
						";
					?>
					</div>   
				</div>
				<div class="col col_2">
					<?php 
						echo LsClAre([
							'id'=>'_are',
							'v'=>'id_clare',
							'cl'=>$__dt_cl->enc,
							'va'=>$___Ls->dt->rw['clare_prnt'],
							'rq'=>2,
							'mlt'=>'no'
						]); 
					
					
					//echo LsFac('_are','id_are', Php_Ls_Cln($_GET['_are']), '', 2, FM_LS_SLFAC, 'ok'); 
					$CntWb .= JQ_Ls('_are', FM_LS_SLARE); 
				?>
				</div>
				<div class="col col_3">
					<?php //$_dt1 = SlDt('_f1', , 'ok', '', TX_ORD_FIN, 'no'); echo $_dt1->html; $CntWb .= $_dt1->js; ?>
					<?php 
						$_dt1 = SlDt([ 'a'=>'ok', 'id'=>'_f1', 'va'=>Php_Ls_Cln($_GET['_f1']), 'rq'=>'no', 'ph'=>TX_ORD_FIN, 'cls'=>CLS_CLND ]); 
						echo $_dt1->html; $CntWb .= $_dt1->js;
					?>
				</div>
				<div class="col col_4">
					<?php 
						$_dt2 = SlDt([ 'a'=>'ok', 'id'=>'_f2', 'va'=>Php_Ls_Cln($_GET['_f2']), 'rq'=>'no', 'ph'=>TX_ORD_FOU, 'cls'=>CLS_CLND ]); 
						echo $_dt2->html; $CntWb .= $_dt2->js;
					?>
				</div>
				<div class="col col_5">
				<?php 
						echo '<div class="c2"><input class="s grd_green" type="button" name="'.BTN_SCH.'" id="'.BTN_SCH.'" value="'.BTN_TX_SCH.'"></div>' ;
						
						if($__sch != NULL){
							echo '<div class="c2"><input class="c grd_gray" type="button" name="'.BTN_SCHCLN.'" id="'.BTN_SCHCLN.'" value="'.BTN_TX_SCHCLN.'"></div>';
						}
				?>
				</div>    
			</div>
		</div>
	</div>

	<input name="f_in" type="hidden" id="f_in" value="<?php if ((isset($_POST['_psgfl_f1'])) && ($_POST['_psgfl_f1'] != "")) {echo $_POST['_psgfl_f1'];}else{echo $_POST['_f_in'];} ?>">
	<input name="f_fin" type="hidden" id="f_fin" value="<?php if ((isset($_POST['_psgfl_f2'])) && ($_POST['_psgfl_f2'] != "")) {echo $_POST['_psgfl_f2'];}else{echo $_POST['f_fin'];} ?>">
	<?php 
		$__cnt_op = 'false';
		$CntWb .= "var FlC_1 = new Spry.Widget.CollapsiblePanel('FlC_1', {contentIsOpen:{$__cnt_op} });";
	?>
	<?php if($___Ls->qry->tot > 0){ ?>
		<div class="_ls">
			<ul>
				<?php do { ?>
						<?php $img_th = _ImVrs([ 'img'=>$___Ls->ls->rw['ec_img'], 'f'=>DMN_FLE_EC_IMG ]); ?>
						<?php if($_ajax != 'ok'){ $__cls = 'lazy'; $__img = ' data-src="'.$img_th->sm_s.'" src="" '; }else{ $__img = ' src="'.$img_th->sm_s.'" '; } ?>
						<li>
							<a href="<?php echo DMN_EC.PrmLnk('bld', $___Ls->ls->rw['ec_pml']); ?>" target="_blank">
								<?php echo  '<img class="'.$__cls.'"  border="0" '.$__img.' alt="'.ctjTx($___Ls->ls->rw['ec_tt'],'in').'" />' . HTML_BR . 
										ShortTx(ctjTx($___Ls->ls->rw['ec_tt'],'in'),100,'Pt').HTML_BR.Spn($___Ls->ls->rw['ec_fi']); ?>
							</a>
						</li>      
				<?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>
			</ul>
		</div>  
		<?php $___Ls->_bld_l_pgs(); ?>
	<?php }?>

  <?php } ?>