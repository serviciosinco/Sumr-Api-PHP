<?php
if(class_exists('CRM_Cnx')){
	
	$___Ls->cnx->cl = 'ok';
	$___Ls->_strt();
	$___Ls->ik = 'cntprnt_enc';
	
	if(!isN($___Ls->gt->i)){
	
		$Ls_Whr = "FROM ".TB_CNT_PRNT." WHERE cntprnt_enc = '".$___Ls->gt->i."'";
		$___Ls->qrys = "SELECT *, (SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." $Ls_Whr";
	
	}elseif($___Ls->_show_ls == 'ok' || !isN($_i)){
	
		if( !isN($__i) ){ 
			$_fl = " AND cntattr_cnt IN ( SELECT cntprnt_cnt_1 FROM ".TB_CNT_PRNT." WHERE cntprnt_cnt_2 = ( SELECT cntappl_cnt FROM ".TB_CNT_APPL." WHERE cntappl_enc = '".$__i."' ) ) "; 
		}
		
		$Ls_Whr = "
					FROM ".TB_CNT_PRNT."
					INNER JOIN ".TB_CNT." ON cntprnt_cnt_1 = id_cnt
					INNER JOIN "._BdStr(DBM).TB_SIS_SLC." ON cntprnt_cnt_prnt_1 = id_sisslc
					LEFT JOIN cnt_prnt_est ON cntprntest_cntprnt = id_cntprnt
					WHERE cntprnt_cnt_2 IN (SELECT cntappl_cnt FROM ".TB_CNT_APPL." where cntappl_enc = '".$__i."' ) 
					AND cntprnt_rsp_fnc = 1
				";
		
		$___Ls->qrys = "SELECT *, (SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." $Ls_Whr";

	}
	
	$___Ls->_bld();
	
	if($___Ls->ls->chk=='ok'){
		$__blq = 'off'; ?>
		<?php if(($___Ls->qry->tot > 0)){ ?>
			<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
				<thead>
					<tr>
					<th width="49%" <?php echo NWRP ?>><?php echo TX_TT; ?></th>
					<th width="49%" <?php echo NWRP ?>><?php echo TX_VL; ?></th>
					<th width="1%" <?php echo NWRP ?>><?php echo TX_EST; ?></th>
					<th width="1%" <?php echo NWRP ?>></th>
				</tr>
				</thead>
				<tbody>
					<?php do { ?>
					<tr>
						<td width="49%" align="left" nowrap="nowrap"><?php echo ctjTx($___Ls->ls->rw['cnt_nm'], 'in'); ?></td>
						<td width="49%" align="left" nowrap="nowrap"><?php echo ctjTx($___Ls->ls->rw['sisslc_tt'], 'in'); ?></td>
						<td width="1%" align="left" nowrap="nowrap" class="_btn">
							<span class="cntprnt_est estprnt<?php echo ctjTx($___Ls->ls->rw['cntprntest_est'],'in');?>" id="<?php echo ctjTx($___Ls->ls->rw['cntprnt_enc'],'in');?>"></span>
						</td>
						<td width="1%" align="left" nowrap="nowrap" class="_btn"><?php echo $___Ls->_btn([ 't'=>'mod' ]); ?></td>
					</tr>
					<?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>
					<?php $CntWb .= " $('#".TBGRP."_gst ._n').html('".$___Ls->qry->tot."'); "; ?>
				</tbody>
			</table>
			<?php $CntWb .= "   
						
						var __mdls_bx_sch_itm = $('.cntprnt_est');
			
						__mdls_bx_sch_itm.off('click').click(function(){
							
							if($(this).hasClass('estprnt1')){
								var __est = 2;
							}else{
								var __est = 1;
							}
							
							var __id = $(this).attr('id');
							
							_Rqu({ 
								t:'cntrc', 
								d:'_est_prnt',
								_id_prnt : __id,
								_id_est : __est,
								_cl:function(_r){ 
									
									if(!isN(_r)){
										if(_r.cnt_prnt.e == 'ok'){
											
											if(_r.cnt_prnt.est == 1){
												$('#'+__id).removeClass('estprnt').removeClass('estprnt2').addClass('estprnt1');
											}else{
												$('#'+__id).removeClass('estprnt1').addClass('estprnt');
											}
											
													
										}
									}	
								} 
							});
						});
						
						
						"; ?>
			<?php $___Ls->_bld_l_pgs(); ?>
		<?php } ?>
		<?php $___Ls->_h_ls_nr(); ?>
	<?php } ?>
	
	<?php if($___Ls->fm->chk=='ok'){ ?>
		<div class="FmTb">
			<div id="<?php echo $___Ls->fm->bx->id ?>" class="<?php echo DV_GNR_FM_BX ?>" >
				<form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>" >
					<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
						<div class="ln_1">
							<?php
								$__dt_cnt = GtCntDt([ 't'=>'id', 'id'=>$___Ls->dt->rw['cntprnt_cnt_1'], 'ls_tp'=>'ok', 'ls_f_scl'=>'ok', 'ls_f_org'=>'ok', 'ls_f_tpc'=>'ok', 'count'=>'ok' ]);
							?>
							<div class="ln_1" id="____dtl_cnt_fnc">
							<?php 
							
								//-------------------- ICONS --------------------//
								
								$__icn_sub_dte = Spn('','','_tt_icn _tt_icn_dte');
								$__icn_sub_hur = Spn('','','_tt_icn _tt_icn_hra');
								$__icn_sub_eml = Spn('','','_tt_icn _tt_icn_eml');
								$__icn_sub_tel = Spn('','','_tt_icn _tt_icn_tel');
								$__icn_sub_docs = Spn('','','_tt_icn _tt_icn_docs');
								$__icn_sub_tp = Spn('','','_tt_icn _tt_icn_cnt_tp');
								$__icn_sub_rds = Spn('','','_tt_icn _tt_icn_cnt_rds');
								$__icn_sub_tpcs = Spn('','','_tt_icn _tt_icn_cnt_tpcs');
								$__icn_sub_sx = Spn('','','_tt_icn _tt_icn_cnt_sx');
								$__icn_sub_dir = Spn('','','_tt_icn _tt_icn_cnt_dir');
								$__icn_sub_fnc = Spn('','','_tt_icn _tt_icn_cnt_fn');
								$__icn_sub_prf = Spn('','','_tt_icn _tt_icn_cnt_prf');
								$__icn_sub_cref = Spn('','','_tt_icn _tt_icn_cnt_cref');
							?>
	
								<ul class="ls_1" >    
									<li class="_tt"><?php echo h4(Spn('','','_tt_icn _tt_icn_bscs').TX_DTSBSC); ?></li> 
									<?php if(!isN($__dt_cnt->nm)){ ?><li title="<?php echo TX_NM; ?>"><?php echo Strn(TX_NM,'',true).$__dt_cnt->nm; ?> </li><?php } ?>
									<?php if(!isN($__dt_cnt->sx)){ ?><li title="<?php echo TX_SX; ?>"><?php echo $__icn_sub_sx.$__dt_cnt->sx->tt; ?> </li><?php } ?>
									<?php if(!isN($__dt_cnt->fn)){ ?><li title="<?php echo TX_FCHNCM; ?>"><?php echo $__icn_sub_fnc.$__dt_cnt->fn; ?> </li><?php } ?>
									<?php if(!isN($__dt_cnt->dir)){ ?><li title="<?php echo TX_DIRC; ?>"><?php echo $__icn_sub_dir.$__dt_cnt->dir; ?> </li><?php } ?> 
									<?php if(!isN($__dt_cnt->dc_a)){ ?>
										<li class="_tt"><?php echo h4(Spn('','','_tt_icn _tt_icn_docs').TX_DOCS); ?></li> 
										<?php foreach($__dt_cnt->dc_a as $k => $v){ echo '<li>'.$__icn_sub_docs.$v->t.' '.$v->n .'</li>'; } ?>    	
									<?php } ?>
									<?php if(!isN($__dt_cnt->eml)){ ?>
										<li class="_tt"><?php echo h4(Spn('','','_tt_icn _tt_icn_emls').TX_EMAIL); ?></li> 
										<?php foreach($__dt_cnt->eml as $_eml_k=>$_eml_v){ ?>
											<?php if($_eml_v->rjct=='ok'){ $_cls_eml='_lckd'; $_cls_eml_tt='No apto para envio (Hard Bounce)'; }else{ $_cls_eml=''; } ?>
											<li class="<?php echo $_cls_eml; ?>"><?php echo $__icn_sub_eml.$_eml_v->v.Spn('','','_tt_icn _tt_icn_lckd','','',$_cls_eml_tt); ?> </li> <?php 
										}
									} ?>	  			        
								</ul>
			     	  
								<?php if(!isN($__dt_cnt->cd)){ ?>
									<ul class="ls_1" >	
										<li class="_tt"><?php echo h4(Spn('','','_tt_icn _tt_icn_geo').TX_GEOGRP); ?></li> 	
										<?php foreach($__dt_cnt->cd as $k => $v){ ?>
										<?php if(!isN($v)){ ?><li><?php echo Strn($v->rel->tt,'',true).Spn('','','background-image:url('.$v->ps->img->url->th_50.');').$v->cd->tt; ?></li><?php } ?>
										<?php } ?>     
									</ul>
								<?php } ?>

								<ul class="ls_1" >
									<?php if(!isN($__dt_cnt->tel)){ ?>
										<li class="_tt"><?php echo h4( Spn('','','_tt_icn _tt_icn_tels') . TX_CLRS); ?></li> 
											<?php foreach($__dt_cnt->tel_all->ls as $_k_tel => $_v_tel){
												$img_th = _ImVrs(array('img'=>$_v_tel->img_ps, 'f'=>DMN_FLE_PS)); ?>
												<li> <div  class="_img_ps1" style="background-image:  url( <?php echo $img_th->th_50;  ?>); "></div><?php echo $_v_tel->tel; ?> </li>
											<?php } ?>
									<?php } ?>

									<?php if(!isN($__dt_cnt->org)){ 
										foreach($__dt_cnt->org as $_org_k=>$_org_v){ 
											if(!isN($_org_v)){  
												$__org_icn = Spn('','','_tt_icn','background-image:url('.$_org_v->img.');');
												echo li( h4($__org_icn.$_org_v->tt), '_tt' );
												foreach($_org_v->ls as $_org_s_k=>$_org_s_v){
													echo li(Spn('','','_o','background-image:url('.$_org_s_v->img->sm_s.');border-color:'.$_org_s_v->clr.'').$_org_s_v->nm.Spn($_org_s_v->tpr->tt, 'ok'));
												}
											}
										}	 	
									} ?>

									<?php if(!isN($__dt_cnt->bd)){ ?><li><?php echo Strn(TX_BBD,'',true).$__dt_cnt->bd; ?> </li><?php } ?>

									<?php 
										if(!isN($__dt_cnt->ls_tp->html)){ echo li(h4($__icn_sub_tp.TX_VNC),'_tt').$__dt_cnt->ls_tp->html; }
										if(!isN($__dt_cnt->fll->scl->html)){ echo li(h4($__icn_sub_rds.TX_RDSC),'_tt').$__dt_cnt->fll->scl->html; }
										if(!isN($__dt_cnt->fll->tpc->html)){ echo li(h4(TX_TPIC),'_tt').$__dt_cnt->fll->tpc->html; }  
									?>
								</ul>
								<ul class="ls_1" >	
									<li class="_tt"><?php echo h4(Spn('','','_tt_icn _tt_icn_oth').TX_OTHDT); ?></li> 		
									<?php if(!isN($__dt_cnt->attr)){ ?>
										<?php foreach($__dt_cnt->attr as $_k => $_v){
											$l_dt = LsDmc([ 'attr'=>$_v->attr, 'id'=>$_v->vl, 'tp'=>'dt' ]);
											if($l_dt->e == "ok"){
												?><li class="li_fnc"><?php echo $_v->tt.': '.$l_dt->tt.'<br>' ?></li><?php
											}else{
												?><li class="li_fnc"><?php echo $_v->tt.': '.$_v->vl.'<br>' ?></li><?php
											}
										}	
									} ?>
								</ul>    							
							</div> 
						</div>
					</div>          
				</form>
			</div>
		</div>
	<?php } ?>
<?php } ?>
<style>
	
	#____dtl_cnt_fnc ._tt_icn{height:25px;width:25px;display:inline-block;margin-right:6px;margin-bottom:0!important;background-size:60% auto;background-repeat:no-repeat;background-position:center;vertical-align:middle}
	#____dtl_cnt_fnc .FmDivBx .VTabbedPanels > .TabbedPanelsContentGroup .TabbedPanelsContent .ln_1 h4,.FmDivBx .VTabbedPanels > .TabbedPanelsContentGroup .TabbedPanelsContent > h4{text-align:left!important}
	#____dtl_cnt_fnc li._tt{padding-left:0!important;margin-top:20px}
	#____dtl_cnt_fnc .ln_1 .ls_1 li{font-family:"Roboto",Verdana;color:#333;border-bottom-width:1px;border-bottom-style:dotted;border-bottom-color:#CCC;list-style-type:none;font-size:12px;text-align:left!important;cursor:help;white-space:normal;padding-left:30px}
	.estprnt,.estprnt2{width:35px;background-image:url(<?php echo DMN_IMG_ESTR_SVG ?>wrong.svg)!important;height:35px;display:block;background-size:65% auto;background-repeat:no-repeat;background-position:center center}
	.estprnt1{width:35px;background-image:url(<?php echo DMN_IMG_ESTR_SVG ?>active.svg)!important;height:35px;display:block;background-size:65% auto;background-repeat:no-repeat;background-position:center center}
	
</style>