<?php
if(class_exists('CRM_Cnx')){	
	
	$___Ls->cnx->cl = 'ok';
	$___Ls->new->w = 700;
	$___Ls->new->h = 500;
	$___Ls->edit->w = 1000;
	$___Ls->edit->h = 700;
	
	$___Ls->tt = _Cns('TX_CMPMKT');
	$___Ls->_strt();
	
	if(!isN($___Ls->gt->i)){		 
		$___Ls->qrys = sprintf("SELECT *
								FROM  ".TB_PLN_CMP."
								WHERE ".$___Ls->ik." = %s 
								LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text")
							);							
	}elseif($___Ls->_show_ls == 'ok'){
		$Ls_Whr = "	FROM  ".TB_PLN_CMP."
						INNER JOIN ".TB_PLN_CMP_TP." ON id_plncmp = plncmptp_plncmp
						INNER JOIN "._BdStr(DBM).TB_MDL_S_TP." ON id_mdlstp = plncmptp_tp
						INNER JOIN "._BdStr(DBM).TB_US." ON id_us = plncmp_slc
						INNER JOIN "._BdStr(DBM).TB_SIS_MD." ON id_sismd = plncmp_md
						 ".GtSlc_QryExtra([ 't'=>'tb', 'col'=>'plncmp_pay', 'als'=>'p' ])."
						 ".GtSlc_QryExtra([ 't'=>'tb', 'col'=>'plncmp_est', 'als'=>'e' ])."
					WHERE ".$___Ls->ino." != '' AND mdlstp_tp = '".$__t2."' 
					ORDER BY ".$___Ls->ino." DESC";
					
		$___Ls->qrys = "SELECT *, 
				(SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT.",
				"._QrySisSlcF([ 'als'=>'p', 'als_n'=>'pago' ]).",
				".GtSlc_QryExtra([ 't'=>'fld', 'p'=>'pago', 'als'=>'p' ]).",
				"._QrySisSlcF([ 'als'=>'e', 'als_n'=>'estado' ]).",
				".GtSlc_QryExtra([ 't'=>'fld', 'p'=>'estado', 'als'=>'e' ])." $Ls_Whr";
		
	}
	$___Ls->_bld();
?>
<?php if($___Ls->ls->chk=='ok'){ ?>
	<section class="_cvr" style="background-color:#75aeb1;"><iframe src="<?php echo DMN_ANM; ?>marketing/index.html" frameborder="0" width="100%" scrolling="no" height="200"></iframe></section> 
	<?php $___Ls->_bld_l_hdr(); ?>
	<?php if(($___Ls->qry->tot > 0)){  ?>
		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
			<tr>
			    <th width="1%" <?php echo NWRP ?>><?php echo TX_FM_No ?></th>
			    <th width="10%" <?php echo NWRP ?>><?php echo TX_COD ?></th>
			    <th width="35%" <?php echo NWRP ?>><?php echo TX_PRSPST ?></th>
			    <th width="20%" <?php echo NWRP ?>><?php echo TX_SLCT ?></th>
			    <th width="20%" <?php echo NWRP ?>><?php echo TX_VLRFCTPGD ?></th>
			    <th width="15%" <?php echo NWRP ?>><?php echo TX_CNT ?></th>
			    <th width="15%" <?php echo NWRP ?>><?php echo TX_EST ?></th>
			    <!--<th width="1%" <?php echo NWRP ?>><?php echo TX_MT ?></th>-->
			    <th width="1%" <?php echo NWRP ?>></th>
			</tr>
			<?php do {  ?>
		  		<tr>  
					<td align="left" <?php echo $_clr_rw ?>><?php echo $___Ls->ls->rw[$___Ls->ino]; ?></td>
				    <td width="10%" align="left"> <?php echo Spn(ctjTx($___Ls->ls->rw['plncmp_cod'],'in'), 'ok').HTML_BR; echo Spn(ctjTx($___Ls->ls->rw['sismd_tt'],'in'),'ok','');  ?></td>
				    <td width="35%" align="left"><?php echo ctjTx($___Ls->ls->rw['plncmp_prs'],'in'); ?></td>
				    <td width="20%" align="left"><?php echo $___Ls->ls->rw['us_nm'].' '.$___Ls->ls->rw['us_ap'].HTML_BR.Spn($___Ls->ls->rw['plncmp_fi'], '', ''); ?></td>
				    <td width="20%" align="left" <?php echo $_clr_rw ?>><?php echo $___Ls->ls->rw['pago_sisslc_tt'].' '.HTML_BR.Spn($___Ls->ls->rw['plncmp_f_end'], '', ''); ?></td>
				    <td width="15%" align="left" <?php echo $_clr_rw ?>><?php echo ctjTx($___Ls->ls->rw['plncmp_f_end'],'in'); ?></td>
				    <td width="15%" align="left" <?php echo $_clr_rw ?>><?php echo ctjTx($___Ls->ls->rw['estado_sisslc_tt'],'in'); ?></td>
				    <td width="1%" align="left" nowrap="nowrap" class="_btn"><?php echo $___Ls->_btn([ 't'=>'mod' ]); ?></td>
				</tr>
		  	<?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>
		</table>
		<?php $___Ls->_bld_l_pgs(); 
	}
	$___Ls->_h_ls_nr(); 
} ?>
<?php if($___Ls->fm->chk=='ok'){ ?>
<style>
	.lead_detail_tb.VTabbedPanels .TabbedPanelsTab {opacity: 0.4;}
	.lead_detail_tb.VTabbedPanels .TabbedPanelsTab.TabbedPanelsTabHover,
	.lead_detail_tb.VTabbedPanels .TabbedPanelsTab.TabbedPanelsTabSelected{opacity: 1 }
	.lead_detail_tb.VTabbedPanels .TabbedPanelsTab{width: 40px !important;height: 40px  !important;background-position: center  !important;background-size: 60% auto  !important; }
	.lead_detail_tb.VTabbedPanels .TabbedPanelsTab._bsc{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>cnt_dtl.svg); }
	.lead_detail_tb.VTabbedPanels .TabbedPanelsTab.TabbedPanelsTabSelected._bsc{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>cnt_dtl_w.svg); }
	.lead_detail_tb.VTabbedPanels .TabbedPanelsTab._fch{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>scl_dte.svg); }
	.lead_detail_tb.VTabbedPanels .TabbedPanelsTab.TabbedPanelsTabSelected._fch{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>scl_dte_w.svg); }
	.lead_detail_tb.VTabbedPanels .TabbedPanelsTab._prs{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>money.svg); }
	.lead_detail_tb.VTabbedPanels .TabbedPanelsTab.TabbedPanelsTabSelected._prs{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>money_w.svg); }
	.lead_detail_tb.VTabbedPanels .TabbedPanelsTab._mdk{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>keyword.svg); }
	.lead_detail_tb.VTabbedPanels .TabbedPanelsTab.TabbedPanelsTabSelected._mdk{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>keyword_w.svg); }
	.lead_detail_tb.VTabbedPanels .TabbedPanelsTab._rst{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>rsltds.svg); }
	.lead_detail_tb.VTabbedPanels .TabbedPanelsTab.TabbedPanelsTabSelected._rst{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>rsltds_w.svg); }
	.lead_detail_tb.VTabbedPanels .TabbedPanelsTab._obs{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>search2.svg); }
	.lead_detail_tb.VTabbedPanels .TabbedPanelsTab.TabbedPanelsTabSelected._obs{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>search_w.svg); }
	.lead_detail_tb.VTabbedPanels .TabbedPanelsTab._gst{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>gstn.svg); }
	.lead_detail_tb.VTabbedPanels .TabbedPanelsTab.TabbedPanelsTabSelected._gst{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>gstn_w.svg); }
	.lead_detail_tb .TabbedPanelsTabGroup{ background-color: white !important }
	
	/*  Palabras Clave  */
	.key_w{ position: relative }
	.key_w .add{width:25px;cursor:pointer;height:50px;margin:0px auto;font-size:0px;display:block;background-image:url(<?php echo DMN_IMG_ESTR_SVG ?>add.svg);background-position:center;background-repeat: no-repeat;}
	.key_w .add.del{cursor:none;opacity:0.4}
	
	.key_w .keyword .inpt_key{display:inline-block;width:80%;}
	.key_w .keyword .inpt_key .key_txt{background-color:#eeeaf3;color:black;padding-left:13px;}
	.key_w .keyword .sve,
	.key_w .keyword .cancel{ background-position:center center;background-repeat:no-repeat;width:25px;height:25px;display:inline-block;cursor: pointer;vertical-align:middle;margin-left:12px; }
	.key_w .keyword .sve{background-image:url(<?php echo DMN_IMG_ESTR_SVG ?>diskette.svg);}
	.key_w .keyword .cancel{background-image:url(<?php echo DMN_IMG_ESTR_SVG ?>scl_mn_chkno.svg);}
	
	.key_w .keyword_add li{background-color:#f1f1f1;padding:0px 15px;display:block;margin:2px 0;border-radius:6px;}
	.key_w .keyword_add li.del{cursor:none;opacity:0.2;}
	.key_w .keyword_add li .tx{width:90%;display:inline-block;vertical-align:top;margin:10px 0;}
	.key_w .keyword_add li .edt,
	.key_w .keyword_add li .eli{width:25px;display:inline-block;cursor:pointer;background-position:center;background-repeat:no-repeat;height:25px;padding:0;margin:8px 4px 0px 4px;}
	.key_w .keyword_add li .edt{background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>ec_edt.svg);}
	.key_w .keyword_add li .eli{background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>delete.svg);}
	
	.key_w .opc_sch {position:absolute;top:100px;display:block;width:70%;border:1px solid white;margin:0 0px 0px 40px;padding:0;}
	.key_w .opc_sch li{background-color:#ffffffe6;width:100%;display:block;padding:6px 20px;margin:1px 0;border:1px solid #e6e6e6;cursor:pointer}
	.key_w .opc_sch li:hover{background-color: #f3f3f3e6 }
	
	.key_w ._ld,
	.key_w .keyword_add li._ld{cursor:none;opacity:0.5;}  

	/*  Palabras Clave  */
</style>	
<div class="FmTb">
	<div id="<?php echo $___Ls->fm->bx->id ?>" class="<?php echo DV_GNR_FM_BX ?>" >
  		<form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>">
	     	<?php $___Ls->_bld_f_hdr(); ?>
		 	<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
		    	<div class="ln_1">
		        <?php
			    	$_id_tbpnl = 'TabPnl_'.Gn_Rnd(20); $CntJV .= " SUMR_Main.bxajx.".$_id_tbpnl." = new Spry.Widget.TabbedPanels('".$_id_tbpnl."', {defaultTab:0}); ";  
					$___Ls->_dvlsfl_all([
						['n'=>'fch', 'l'=>TX_CON_FCH],
						['n'=>'prs', 'l'=>TX_PRSPST],
						['n'=>'mdk', 'l'=>TX_MDKYW],
						['n'=>'rst', 'l'=>TX_RSLTDS],
						['n'=>'obs', 'l'=>TX_OBS],
						['n'=>'gst', 't'=>'pln_cmp_gst', 'l'=>TX_GST]
					]);	
			    ?> 
	        		<div id="<?php echo $_id_tbpnl ?>" class="VTabbedPanels mny lead_detail_tb">
						<ul class="TabbedPanelsTabGroup">
							<?php echo $___Ls->tab->bsc->l ?>
							<?php echo $___Ls->tab->fch->l ?>
							<?php echo $___Ls->tab->prs->l ?>
							<?php echo $___Ls->tab->mdk->l ?>
							<?php echo $___Ls->tab->rst->l ?>
							<?php echo $___Ls->tab->obs->l ?>
							<?php echo $___Ls->tab->gst->l ?>
						</ul>
						<div class="TabbedPanelsContentGroup">
						    <div class="TabbedPanelsContent _bsc">         
								<div class="_scrl">
									<?php echo  h3(TX_FS . h2($___Ls->dt->rw['plncmp_fi'])); ?>
								<div class="col_1">	           					
									
									<?php// $l = __Ls(['k'=>'sis_pnl_cmp_clf', 'id'=>'plncmp_clf', 'va'=>$___Ls->dt->rw['plncmp_clf'] , 'ph'=>TX_SLCTP]); 
										//	echo $l->html; $CntWb .= $l->js;
									?>												
									
									<?php echo LsSis_Md('plncmp_md','id_sismd', $___Ls->dt->rw['plncmp_md'], '', 2); $CntWb .=JQ_Ls('plncmp_md',FM_LS_LSTP);?>
									
									<?php if($___Ls->dt->rw['plncmp_md'] == 25 || $___Ls->dt->rw['plncmp_md'] == 259){
											if(ChckSESS_adm()){
												echo HTML_inp_tx('plncmp_fb_id', TX_FBID, ctjTx($___Ls->dt->rw['plncmp_fb_id'], 'in'));
											}else{
												echo HTML_inp_hd('plncmp_fb_id', $___Ls->dt->rw['plncmp_fb_id']); 
											}	
										}
										
									?>
									
									<?php echo LsUs('plncmp_slc','id_us', $___Ls->dt->rw['plncmp_slc'], '', 2); $CntWb .= JQ_Ls('plncmp_slc','');?>
									
									<?php $l = __Ls(['k'=>'sis_pln_cmp_est', 'id'=>'plncmp_est', 'va'=>$___Ls->dt->rw['plncmp_est'] , 'ph'=>TX_SLCEST]); 
											echo $l->html; $CntWb .= $l->js;
									?>
									
									<?php
										
									 echo LsSis_SiNo('plncmp_aprb','id_sissino', $___Ls->dt->rw['plncmp_aprb'], TX_APRBQ);  
										 $CntWb .=JQ_Ls('plncmp_aprb',TX_APRBQ). "
														$('#plncmp_aprb').change(function(){
															var __v = '';
															__v = $(this).val();
															
															if(__v == 1){
																$('#plncmp_aprb_us').removeClass('_hd');
															}else{
																$('#plncmp_aprb_us').addClass('_hd');
															}
															
														}).change();
														";
				
											if($___Ls->dt->rw['plncmp_aprb'] == 2){
												$CntWb .= "$('#plncmp_aprb').delay(800).effect('shake').effect('highlight');";
											}								
									
									?>
									
			
									
									<?php echo HTML_inp_tx('plncmp_aprb_us', TX_APRBPOR, ctjTx($row_Dt_Rg['plncmp_aprb_us'],'in'), '', '', '_hd'); ?> 
									 
											
									</div>
									<div class="col_2">
										
									<?php
									
									if(ChckSESS_superadm()){
										echo HTML_inp_tx('plncmp_cod', TX_COD, ctjTx($___Ls->dt->rw['plncmp_cod'],'in') );
										if($___Ls->dt->rw['plncmp_cod_bfr'] != ''){ echo Spn($___Ls->dt->rw['plncmp_cod_bfr'],'ok','_f').HTML_BR.HTML_BR; }
									}else{
										echo h3($___Ls->dt->rw['plncmp_cod']);
										if($___Ls->dt->rw['plncmp_cod_bfr'] != ''){echo Spn($___Ls->dt->rw['plncmp_cod_bfr'],'ok','_f'); }							
									}						
									?>
									
									<?php echo HTML_inp_tx('plncmp_url', TX_URL, ctjTx($___Ls->dt->rw['plncmp_url'],'in'),FMRQD_URL);?>
									
									<?php echo HTML_textarea('plncmp_obj', TX_OBJ, ctjTx($___Ls->dt->rw['plncmp_obj'],'in'), '', '', '', 2); ?><br>
									<?php echo HTML_textarea('plncmp_dsc', TX_CON_DSC, ctjTx($___Ls->dt->rw['plncmp_dsc'],'in'), '', '', '', 2); ?>
										
									</div>
								</div>       
							</div>
							<div class="TabbedPanelsContent">         
								<div class="_scrl">
									
									<?php echo h3(TX_CON_FCH); ?>
									           
									<div class="col_2">
										<?php echo SlDt([ 'id'=>'plncmp_f_str', 'va'=>$___Ls->dt->rw['plncmp_f_str'], 'rq'=>'no', 'ph'=>TX_ORD_FIN, 'cls'=>CLS_CLND ]); ?> 
									</div>
									<div class="col_2">
										<?php echo SlDt([ 'id'=>'plncmp_f_end', 'va'=>$___Ls->dt->rw['plncmp_f_end'], 'rq'=>'no', 'ph'=>TX_ORD_FOU, 'cls'=>CLS_CLND ]); ?>
									</div> 
									            	
								</div> 
							 </div>
							<div class="TabbedPanelsContent">         
								<div class="_scrl">
									
									<?php echo h3(TX_PRSPST); ?>
									  
									  
									<div class="col_1">	         
										<?php echo HTML_inp_tx('plncmp_prs', TX_PRSPST, ctjTx($___Ls->dt->rw['plncmp_prs'],'in'));?>
										<?php echo HTML_inp_tx('plncmp_utl', TX_UTLD, ctjTx($___Ls->dt->rw['plncmp_utl'],'in'));?>
										
										<?php $l = __Ls(['k'=>'sis_pay_est', 'id'=>'plncmp_pay', 'va'=>$___Ls->dt->rw['plncmp_pay'] , 'ph'=>TX_PG]); 
										       echo $l->html; $CntWb .= $l->js;
										?>
									</div>
									  
									<div class="col_2"></div>
									  
									            	
								</div> 
							 </div>
							<div class="TabbedPanelsContent">         
								<div class="_scrl">
									
									<?php echo h3(TX_MDKYW); ?>
									
									<div class="col_1 key_w">
										 
										<p class="add"></p>
										
										<ul class="keyword"></ul>
										<ul class="keyword_add"></ul>
										<?php 
											
											$CntJV .= "
											function buscar(){
												
												var textoBusqueda = $('input#key_txt').val(); 
												
												_Rqu({ 
													t:'pln_cmp', 
													tp:'pln_cmp_kyw',
													_id_cmp : '".Php_Ls_Cln($___Ls->gt->i)."', 
													est: 'sch',
													tx: textoBusqueda,
													_bs:function(){  },
													_cm:function(){  },
													_cl:function(_r){ 
														if(!isN(_r)){
															$('.opc_sch').remove();
															if(_r.sch.tot > 0){
																
																$('.key_w').append('<ul class=\"opc_sch\"></ul>');
																$.each(_r.sch.ls, function(k, v) {		
																	
																	$('<li class=\"opc_dj\">'+v.tt+'</li>').on({
																		click: function() {
																			
																			$('.key_txt').val($(this).html());
																			$('.key_txt').attr({
																				rel: v.enc,
																				data: 'ing_mod'
																			}); 
																			$('ul.opc_sch').remove();	
																		}
																	}).appendTo('ul.opc_sch');
																		
																});	
															}
 
														} 
													} 
												});
											}
													
												
											function Dom_Rbld(){
												$('.add').click(function() {
													$('.add, ul.keyword_add li').addClass('del');
													$('ul.keyword').html('');
													$('.keyword').append('<li class=\"inpt_key\"><input autocomplete=\"off\" class=\"key_txt anm\" type=\"text\" id=\"key_txt\" onKeyUp=\"buscar();\" placeholder=\"".TX_MDKYW."\"></li>');	
													
													$('<li class=\"sve\"></li>').on({
														click: function() {
															var key_txt = $('#key_txt').val();
															var key_mod = $('#key_txt').attr('data');
															var key_rel = $('#key_txt').attr('rel');
															
															if(key_mod == 'ing_mod'){ var est = 'in_onl'; }else{ var est = 'in'; }
															
															if(!isN(key_txt)){
																_Rqu({ 
																	t:'pln_cmp', 
																	tp:'pln_cmp_kyw',
																	_id_cmp : '".Php_Ls_Cln($___Ls->gt->i)."',
																	est: est,
																	d: key_txt,
																	
																	key_mod: key_mod,
																	key_rel: key_rel,
																	
																	_bs:function(){ $('.key_w').addClass('_ld'); },
																	_cm:function(){ $('.key_w').removeClass('_ld'); },
																	_cl:function(_r){ 
																		if(!isN(_r)){
																			if(_r.prc.e == 'ok'){
																				$('.add, ul.keyword_add li').removeClass('del');
																				$('.inpt_key, .sve, .cancel').remove();
																				$('.sve').remove();
																				ClSet(_r); 	
																			} 
																		} 
																	} 
																});
															}
														}
													}).appendTo('ul.keyword');
													
													$('<li class=\"cancel\"></li>').on({
														click: function() {
															$('.inpt_key, .sve, .cancel').remove();
															$('.opc_sch').remove();
															$('.add, ul.keyword_add li').removeClass('del');
														}
													}).appendTo('ul.keyword');
												});
												
												$('.edt').click(function() {
													var _id = $(this).parent().attr('id');
													var _txt = $('#'+_id+' .tx').html();
													
													$('.add, ul.keyword_add li').addClass('del');
													
													$('.keyword').html('');
													$('.keyword').append('<li class=\"inpt_key\"><input value=\"'+_txt+'\" class=\"key_txt anm\" type=\"text\" id=\"key_txt\" placeholder=\"".TX_MDKYW."\"></li>');	
														
													$('<li class=\"sve\"></li>').on({
														click: function() {
															var key_txt = $('#key_txt').val(); 
															
															var key_mod = $('#key_txt').attr('data');
															var key_rel = $('#key_txt').attr('rel');
															
															
															
															if(!isN(key_txt)){
																_Rqu({ 
																	t:'pln_cmp', 
																	tp:'pln_cmp_kyw',
																	_id_cmp : '".Php_Ls_Cln($___Ls->gt->i)."',
																	est: 'edt',
																	tx: key_txt,
																	mod: key_mod,
																	rel: key_rel,
																	d: _id,
																	_bs:function(){ $('ul.keyword li').addClass('_ld'); },
																	_cm:function(){ $('ul.keyword li').removeClass('_ld'); },
																	_cl:function(_r){ 
																		if(!isN(_r)){
																			if(_r.prc.e == 'ok'){
																				$('.add, ul.keyword_add li').removeClass('del');
																				$('.inpt_key, .sve, .cancel').remove();
																				$('.sve').remove();
																				ClSet(_r); 	
																			} 
																		} 
																	} 
																});
															}
														}
													}).appendTo('ul.keyword');
													
													$('<li class=\"cancel\"></li>').on({
														click: function() {
															$('.inpt_key, .sve, .cancel').remove();
															$('.add, ul.keyword_add li').removeClass('del');
														}
													}).appendTo('ul.keyword');									
												});
												
												$('.eli').click(function() {		
													var _id = $(this).parent().attr('id');
													_Rqu({ 
														t:'pln_cmp', 
														tp:'pln_cmp_kyw',
														_id_cmp : '".Php_Ls_Cln($___Ls->gt->i)."',
														est: 'eli',
														d: _id,
														_bs:function(){ $('.keyword_add li').addClass('_ld'); },
														_cm:function(){ $('.keyword_add li').removeClass('_ld'); },
														_cl:function(_r){ 
															if(!isN(_r)){
																if(_r.prc.e == 'ok'){
																	$('.add, ul.keyword_add li').removeClass('del');
																	$('.inpt_key, .sve, .cancel').remove();
																	$('.sve').remove();
																	ClSet(_r); 	
																} 
															} 
														} 
													});	
												});
											}
												
											function ClGrpAre_Html(){
												$('.keyword_add').html('');
												$.each(_plncmp['ls'], function(k, v) {
													$('.keyword_add').append('<li id=\"'+v.enc+'\"><p class=\"tx\">'+v.tt+'</p><!--<p class=\"edt\"></p>--><p class=\"eli\"></p></li>');
												});
												Dom_Rbld();
											}
											
											function ClSet(p){
												if( !isN(p) ){
													_plncmp = {};
													if( !isN(p.cmp.kyw) ){ 
														_plncmp['ls'] = p.cmp.kyw.ls; 
														_plncmp['tot'] = p.cmp.kyw.tot;
													}
													if(_plncmp['tot'] > 0){ ClGrpAre_Html(); }	
													Dom_Rbld();
												}
											}
										";
											
											$CntJV .= " 	
												_Rqu({ 
													t:'pln_cmp',
													tp:'pln_cmp_kyw',
													_id_cmp : '".Php_Ls_Cln($___Ls->gt->i)."',
													_cl:function(_r){ if(!isN(_r)){ if(!isN(_r)){ ClSet(_r); } } } 
												});
											";
											
										?>
									</div>
									<div class="col_2">
									           
										<?php echo HTML_textarea('plncmp_dsc_dmg', TX_DSC_DMG, ctjTx($___Ls->dt->rw['plncmp_dsc_dmg'],'in'), '', '', '', 2); ?><br>
										<?php echo HTML_textarea('plncmp_dsc_psc', TX_DSC_PSCGRF, ctjTx($___Ls->dt->rw['plncmp_dsc_psc'],'in'), '', '', '', 2); ?>
																
									</div>
									            	
								</div> 
							 </div>
							<div class="TabbedPanelsContent">         
								<div class="_scrl">
									
									<?php echo h3(TX_RSLTDS); ?>						
									
									<div class="col_1">						
										<?php echo HTML_inp_tx('plncmp_rsl_exp', TX_RSLESPR, ctjTx($___Ls->dt->rw['plncmp_rsl_exp'],'in'));?>
										<?php echo HTML_inp_tx('plncmp_rsl_clck', TX_CLCKS, ctjTx($___Ls->dt->rw['plncmp_rsl_clck'],'in'));?>
										<?php echo HTML_inp_tx('plncmp_rsl_alcn', TX_ALCNC, ctjTx($___Ls->dt->rw['plncmp_rsl_alcn'],'in'));?>							
									</div>	
										
									<div class="col_2">								
										<?php echo HTML_inp_tx('plncmp_gst', TX_GSTD, ctjTx($___Ls->dt->rw['plncmp_gst'],'in'));?>
										<?php echo HTML_inp_tx('plncmp_gst_fnl', TX_GSTD.' '.'('.TX_FNLMD.')', ctjTx($___Ls->dt->rw['plncmp_gst_fnl'],'in'));?>						
									</div>
									
									
									
								</div> 
							 </div>
							<div class="TabbedPanelsContent">         
								<div class="_scrl">
									
									<?php echo h3(TX_OBS); ?>
									  
									  <?php echo HTML_textarea('plncmp_obs', TX_OBS, ctjTx($___Ls->dt->rw['plncmp_obs'],'in'), '', '', '', 2); ?>         
									            	
								</div> 
							 </div>
							<div class="TabbedPanelsContent">         
								<div class="_scrl">
									           
									  <?php echo $___Ls->tab->gst->d ?>
									            	
								</div> 
							 </div>
						</div>	 
					</div>   
				</div>
				
			</div>
		</form>
    </div>
</div>
<?php } ?>
<?php } ?>