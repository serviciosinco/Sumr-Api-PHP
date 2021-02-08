<?php
if(class_exists('CRM_Cnx')){

	$___Ls->tt = _Cns('TX_TRA_COL');
	$___Ls->cnx->cl = 'ok';
	$___Ls->edit->w = 650;
	$___Ls->edit->h = 700;
	$___Ls->ino = "id_tracol";
	$___Ls->ik = "tracol_enc";
	$___Ls->img->enc = 'ok';
	$___Ls->img->dir = DMN_FLE_TRA_COL;

	$___Ls->_strt();
	
	if(!isN($___Ls->gt->i)){	
		 
		$___Ls->qrys = sprintf("SELECT *
								FROM  "._BdStr(DBM).TB_TRA_COL."
								WHERE ".$___Ls->ik." = %s 
								LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text")
							);
									
	}elseif($___Ls->_show_ls == 'ok'){
		
		if($__t == 'tra_col_grp'){

			$_fl = "AND id_tracol IN ( 
							SELECT tracolgrp_tracol 
							FROM "._BdStr(DBM).TB_TRA_COL_GRP." 
							WHERE tracolgrp_grp IN ( 
								SELECT id_clgrp FROM "._BdStr(DBM).TB_CL_GRP." WHERE clgrp_enc = '{$__i}' 
								) 
							)";
		}
		
		$Ls_Whr = "	FROM "._BdStr(DBM).TB_TRA_COL."
						 INNER JOIN "._BdStr(DBM).TB_CL." ON tracol_cl = id_cl
					WHERE ".$___Ls->ino." != '' AND
						  cl_enc = '".DB_CL_ENC."'
						  $_fl 
					ORDER BY ".$___Ls->ino." DESC";
					
		$___Ls->qrys = "SELECT *,
				   	(SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." $Ls_Whr";
		
	} 

	$__clr_dt = __LsDt(['k'=>'tra_col_clr']);
	$__tp_dt = __LsDt(['k'=>'tra_col_tp']);

	$___Ls->_bld();
?>
<?php if($___Ls->ls->chk=='ok'){ ?>

	<?php $___Ls->_bld_l_hdr(); ?>
	<?php if(($___Ls->qry->tot > 0)){  ?>
		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
			<tr>
			    <th width="1%" <?php echo NWRP ?>><?php echo TX_FM_No ?></th>
			    <th width="5%" <?php echo NWRP ?>><?php echo TX_TT ?></th>
				<?php if($__t == 'tra_col' && ChckSESS_superadm()){ ?>
					<th width="5%" <?php echo NWRP ?>><?php echo TX_CL ?></th>
				<?php } ?>
				<?php if(ChckSESS_superadm()){ ?>
				<th width="5%" <?php echo NWRP ?>><?php echo TX_DFLT_SAC ?></th>
				<th width="5%" <?php echo NWRP ?>><?php echo TX_DFLT_TCKT_SUMR ?></th>
				<th width="5%" <?php echo NWRP ?>><?php echo TX_DFLT_COL_PBLC ?></th>
				<?php } ?>
				<th width="5%" <?php echo NWRP ?>><?php echo TX_CLR ?></th>
				<th width="5%" <?php echo NWRP ?>><?php echo TX_TP ?></th>
			    <th width="1%" <?php echo NWRP ?>></th>
			</tr>
			<?php do {  ?>
		  		<tr>  
					<td align="left" <?php echo $_clr_rw ?>><?php echo $___Ls->ls->rw[$___Ls->ino]; ?></td>
				    <td width="30%" align="left" <?php echo $_clr_rw ?>><?php echo ctjTx($___Ls->ls->rw['tracol_tt'],'in'); ?></td>
					<?php if($__t == 'tra_col' && ChckSESS_superadm()){ ?>
						<td width="30%" align="left" <?php echo $_clr_rw ?>><?php echo ctjTx($___Ls->ls->rw['cl_nm'],'in'); ?></td>
					<?php } ?>
					<?php if(ChckSESS_superadm()){ ?>
					<td width="10%" align="left" <?php echo $_clr_rw ?>><?php echo Spn(mBln($___Ls->ls->rw['tracol_chk_pqr']),'',mBln($___Ls->ls->rw['tracol_chk_pqr'])); ?></td>
					<td width="10%" align="left" <?php echo $_clr_rw ?>><?php echo Spn(mBln($___Ls->ls->rw['tracol_chk_tck']),'',mBln($___Ls->ls->rw['tracol_chk_tck'])); ?></td>
					<td width="10%" align="left" <?php echo $_clr_rw ?>><?php echo Spn(mBln($___Ls->ls->rw['tracol_chk_pblc']),'',mBln($___Ls->ls->rw['tracol_chk_pblc'])); ?></td>
					<?php } ?>
				    <?php $_clr = $__clr_dt->ls->tra_col_clr->{$___Ls->ls->rw['tracol_clr']}->clr->vl; ?>
					<td width="10%" align="left" <?php echo $_clr_rw ?>><?php echo Spn('','', '_clr_icn','background-color:'.$_clr.'; ') . ctjTx($_clr,'in'); ?></td>
					<?php $_tp = $__tp_dt->ls->tra_col_tp->{$___Ls->ls->rw['tracol_tp']}; ?>
					<td width="10%" align="left"><?php echo $_tp->tt; ?></td>
				    <td width="1%" align="left" nowrap="nowrap" class="_btn"><?php echo $___Ls->_btn([ 't'=>'mod' ]); ?></td>
				</tr>
		  	<?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>
		</table>
		<?php $___Ls->_bld_l_pgs(); 
	}
	$___Ls->_h_ls_nr(); 
} ?>
<?php if($___Ls->fm->chk=='ok'){ ?>
<div class="FmTb">
  <div id="<?php echo $___Ls->fm->bx->id ?>" class="<?php echo DV_GNR_FM_BX ?>" >
  	<form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>">
     	<?php $___Ls->_bld_f_hdr(); ?>
	 	<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
		    <div class="ln_1">
	        	<div class="col_1">

					<?php if($__t == 'tra_col_grp'){ ?>
		        		<?php echo HTML_inp_hd('tracolgrp_grp', $__i); ?>
					<?php } ?>

	            	<?php echo HTML_inp_tx('tracol_tt', TX_TT , ctjTx($___Ls->dt->rw['tracol_tt'],'in'), FMRQD); ?>	
					<?php 
						if(ChckSESS_superadm()){
							echo OLD_HTML_chck('tracol_chk_pqr', TX_DFLT_SAC, $___Ls->dt->rw['tracol_chk_pqr'], 'in');
	            			echo OLD_HTML_chck('tracol_chk_tck', TX_DFLT_TCKT_SUMR, $___Ls->dt->rw['tracol_chk_tck'], 'in');
							echo OLD_HTML_chck('tracol_chk_pblc', TX_DFLT_COL_PBLC, $___Ls->dt->rw['tracol_chk_pblc'], 'in');
						}else{
							echo HTML_inp_hd('tracol_chk_pqr', $___Ls->dt->rw['tracol_chk_pqr']);
							echo HTML_inp_hd('tracol_chk_pqr', $___Ls->dt->rw['tracol_chk_tck']);
							echo HTML_inp_hd('tracol_chk_pqr', $___Ls->dt->rw['tracol_chk_pblc']);
						}
					?>
	            	
	        	</div>
				<div class="col_2">
		          <?php 
				  		$l = __Ls(['k'=>'tra_col_clr',
											'id'=>'tracol_clr',
											'ph'=>TX_CLR,
											'va'=>$___Ls->dt->rw['tracol_clr']
									]);
						echo $l->html; $CntWb .= $l->js;

						$l = __Ls(['k'=>'tra_col_tp',
											'id'=>'tracol_tp',
											'ph'=>TX_TP,
											'va'=>$___Ls->dt->rw['tracol_tp']
									]);
						echo $l->html; $CntWb .= $l->js;
						?>
							<div class="_c _c2 _anm _scrl _tracol_us">
								<?php echo h2(TX_USRS); ?>
								<div class="_wrp">
									<ul id="bx_tra_col_us" class="_ls _anm dls"></ul> 
								</div>
							</div>
						<?php		

						$CntJV .= " 

							var SUMR_Dsh_TraColUs = {
								bx_tra_col_us:$('#bx_tra_col_us'),
								bx_tra_col_us_itm:$('#bx_tra_col_us li.itm '),
								bx_tra_col_us_btn:$('#bx_tra_col_us li button'),

								__orgzna_bx_zna_itm:$('#bx_tra_col_us > li.itm'),

								f:{
									dom:function(){
										$('.tracolus_btn').off('click').click(function(e){
			
											e.preventDefault();
								
											$(this).hasClass('on') ? est = 'del' : est = 'in'; 	
											var _id = $(this).parent().parent().attr('rel');
											var _tp = $(this).attr('rel');
											
											_Rqu({
												t:'tra_col_us', 
												_id_tra_col : '".Php_Ls_Cln($___Ls->gt->i)."',
												_id_grp : '".Php_Ls_Cln($___Ls->gt->isb)."',
												_d: 'prc',
												_id: _id,
												_tp: _tp,
												_bs:function(){ $('._tracol_us ul').addClass('_ld'); },
												_cm:function(){ $('._tracol_us ul').removeClass('_ld'); },
												_cl:function(_r){
													if(!isN(_r)){
														if(!isN(_r.tra)){
															SUMR_Dsh_TraColUs.f.set(_r.tra);			
														}
													}
												}
											});
										});
									},
									html:function(){
										SUMR_Dsh_TraColUs.bx_tra_col_us.html('');
										
										if(!isN(_tracolus['ls'])){
											
											$.each(_tracolus['ls'], function(k, v) { 
												if(v.obs > 0){ var _cls1 = 'on'; }else{ var _cls1 = 'off'; }
												if(v.obs_d > 0){ var _cls2 = 'on'; }else{ var _cls2 = 'off'; }
												if(v.rsp > 0){ var _cls3 = 'on'; }else{ var _cls3 = 'off'; }
												if(v.rsp_d > 0){ var _cls4 = 'on'; }else{ var _cls4 = 'off'; }

												if(!isN(v.img)){
													if(!isN(v.img.sm_s)){ img=v.img.sm_s; }else{ img=v.img; }
												}else{ img=''; }
												SUMR_Dsh_TraColUs.bx_tra_col_us.append('
													<li class=\"_anm itm tra_col_us\" us-id=\"'+v.enc+'\" rel=\"'+v.enc+'\">
														<figure style=\"background-image:url('+img+')\" class=\"_bg\"></figure>
														<span>'+v.nm+'</span>
														<ul>
															<li rel=\""._CId('ID_USROL_OBS')."\" class=\"tracolus_btn _obs '+_cls1+'\"><div class=\"flg _anm\"><div class=\"wrp\">Observador</div></div>O</li>
															<li rel=\""._CId('ID_USROL_OBS_DFT')."\" class=\"tracolus_btn _obs_d '+_cls2+'\"><div class=\"flg _anm\"><div class=\"wrp\">Observador Default</div></div>OD</li>
															<li rel=\""._CId('ID_USROL_RSP')."\" class=\"tracolus_btn _rsp '+_cls3+'\"><div class=\"flg _anm\"><div class=\"wrp\">Responsable</div></div>R</li>
															<li rel=\""._CId('ID_USROL_RSP_DFT')."\" class=\"tracolus_btn _rsp_d '+_cls4+'\"><div class=\"flg _anm\"><div class=\"wrp\">Responsable Default</div></div>RD</li>
														</ul>
													</li>');
											
											});	
											
										}
										
										SUMR_Dsh_TraColUs.f.dom();
									},
									set:function(p){
										if( !isN(p) ){		
											_tracolus = {};			
											if( !isN(p.us) ){ _tracolus['ls'] = p.us.ls; _tracolus['tot'] = p.us.tot; }
											SUMR_Dsh_TraColUs.f.html();
										}
									}
								}	
							};

							_Rqu({ 
								t:'tra_col_us', 
								_id_tra_col : '".Php_Ls_Cln($___Ls->gt->i)."',
								_id_grp : '".Php_Ls_Cln($___Ls->gt->isb)."',
								_d: 'ls',
								_cl:function(_r){
									if(!isN(_r)){
										if(!isN(_r.tra)){
											SUMR_Dsh_TraColUs.f.set(_r.tra);			
										}
									}
								} 
							});
						";
						
					?>
					<style>
						._tracol_us ul{ list-style-type: none; padding:0; }
						._tracol_us ul._ld{ opacity: 0.4; }
						._tracol_us ul._ld li{ pointer-events: none; }
						._tracol_us ul .tra_col_us{width: 100%;background-color: #d4d4d4;border-radius: 7px;padding: 3px 35px;position: relative;height: 28px;margin: 3px 0;}
						._tracol_us ul .tra_col_us figure{ display: block;width: 35px;height: 35px;background-position: center center;background-repeat: no-repeat;background-size: 100% auto;border: 2px solid white;border-radius: 200px;-moz-border-radius: 200px;-webkit-border-radius: 200px;position: absolute;top: -4px;padding: 0;margin: 0;background-color: white;left: -5px; }
						._tracol_us ul .tra_col_us p{display:inline-block}
						._tracol_us ul .tra_col_us p span{font-size:12px;}	

						._tracol_us ul ul{display:inline-block;vertical-align:top;padding:0;position:absolute;right:0}
						._tracol_us span{margin-top:6px;display:inline-block}
						._tracol_us ul ul li{width:22px;height:22px;display:inline-block;text-align:center;border-radius:50%;padding-top:4px;position:relative;background-color:#fff;cursor:pointer;filter:grayscale(100%);opacity:.4}
						._tracol_us ul ul li:hover .flg{top:-24px;opacity:1}
						._tracol_us ul ul li .flg{position:absolute;width:70px;top:-40px;opacity:0;left:-26px;pointer-events:none}
						._tracol_us ul ul li .flg .wrp{background-color:var(--main-bg-color);color:#fff;text-align:center;width:70px;font-size:9px;position:relative;display:block;-webkit-line-clamp:2;-webkit-box-orient:vertical;text-overflow:ellipsis;white-space:nowrap;padding:3px 2px;border-radius:8px;overflow:hidden}
						._tracol_us ul ul li:hover{border:2px solid var(--main-bg-color);filter:grayscale(0%);opacity:1}
						._tracol_us ul ul li.on{filter:grayscale(0%);opacity:1}
						
					</style> 
	          	</div>
	        </div>
    	</div>
    </form>
  </div>
</div>
<?php } ?>
<?php } ?>
