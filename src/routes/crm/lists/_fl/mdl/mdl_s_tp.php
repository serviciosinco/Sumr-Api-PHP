<?php
if(class_exists('CRM_Cnx')){

	$___Ls->tt = MDL_SIS_TP;
	$___Ls->sch->f = 'mdlstp_nm, mdlstp_tp';
	$___Ls->img->dir = DMN_FLE_MDL_TP;
	$___Ls->new->w = 900;
	$___Ls->new->h = 700;
	$___Ls->edit->big = 'ok';
	
	$___Ls->_strt();

	if(!isN($___Ls->gt->i)){	
		
		$___Ls->qrys = sprintf("SELECT * FROM "._BdStr(DBM).TB_MDL_S_TP." WHERE  ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));

	}elseif($___Ls->_show_ls == 'ok'){ 
		 
		$Ls_Whr = "	FROM "._BdStr(DBM).TB_MDL_S_TP."
					WHERE ".$___Ls->ino." != '' ".$___Ls->sch->cod." 
					ORDER BY mdlstp_nm ASC";
					
		$___Ls->qrys = "SELECT *, 
		
						id_mdlstp AS ___id_main,
		
						(	SELECT COUNT(*) 
							FROM "._BdStr(DBM).TB_MDL_S_TP_ATTR." 
								 INNER JOIN "._BdStr(DBM).TB_CL." ON mdlstpattr_cl = id_cl
							WHERE mdlstpattr_mdlstp = ___id_main AND cl_enc = '".DB_CL_ENC."'
						) AS __attr_tot,
						
						(	SELECT COUNT(*) 
							FROM "._BdStr(DBM).TB_MDL_S_TP_PRM." 
								 INNER JOIN "._BdStr(DBM).TB_MDL_S_TP." tpin ON mdlstpprm_mdlstp = tpin.id_mdlstp
								 INNER JOIN "._BdStr(DBM).TB_MDL_S_TP_CL." ON mdlstpcl_mdlstp = tpin.id_mdlstp
								 INNER JOIN "._BdStr(DBM).TB_CL." ON mdlstpcl_cl = id_cl
							WHERE mdlstpprm_mdlstp = ___id_main AND cl_enc = '".DB_CL_ENC."'
						) AS __prm_tot,
							
						(SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT."
					$Ls_Whr"; 
		
	}

	$___Ls->_bld(); 
 
?>
<?php if($___Ls->ls->chk=='ok'){ ?>
<?php $___Ls->_bld_l_hdr();?>
<?php if(($___Ls->qry->tot > 0)){ ?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
  	<tr>
	    <th width="1%" <?php echo NWRP ?>><?php echo TX_FM_No ?></th>
	    <th width="1%" <?php echo NWRP ?>></th>
	    <th width="20%" <?php echo NWRP ?>><?php echo TX_NM ?></th>
	    <th width="1%" <?php echo NWRP ?>><?php echo TX_TP ?></th>
	    <th width="1%" <?php echo NWRP ?>><?php echo TX_PRM.Spn('Total', 'ok') ?></th>
	    <th width="1%" <?php echo NWRP ?>><?php echo TX_ATRBTS.Spn('Total', 'ok') ?></th>
	    <th width="1%" <?php echo NWRP ?>><?php echo TX_CLR ?></th>
	    <th width="1%" <?php echo NWRP ?>></th>
  	</tr>
  	<?php do { ?>
  		<?php 
		  	
		  	$__mnu_o = GtMdlSTpCl_Ls([ 'mdlstp'=>$___Ls->ls->rw['id_mdlstp'] ]);
			$__cl = ''; 
				  
			foreach($__mnu_o->ls as $_mnucl_k=>$_mnucl_v){
	
				$__cl .= '<li style="background-image:url('.$_mnucl_v->cl->img->th_50.');" 
							  alt="'.ctjTx( $_mnucl_v->cl->nm ,'in').'" 
							  title="'.ctjTx( $_mnucl_v->cl->nm ,'in').'"> </li>' ;
			}			
			
		?>
  	<tr>
	    <td width="1%" <?php echo NWRP ?>><?php echo Spn($___Ls->ls->rw[$___Ls->ino]); ?></td>
	    <td width="1%" <?php echo NWRP ?>><?php echo fgr('<img src="'.DMN_FLE_MDL_TP.$___Ls->ls->rw['mdlstp_img'].'">'); ?></td>
	    <td width="20%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['mdlstp_nm'],'in'),150,'Pt', true).ul($__cl, '_cl_avatar'); ?></td>
	    <td width="1%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['mdlstp_tp'],'in'),100,'Pt', true); ?></td>
	    <td width="1%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['__prm_tot'],'in'),100,'Pt', true); ?></td>
	    <td width="1%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['__attr_tot'],'in'),100,'Pt', true); ?></td>
	    <td width="1%"><?php echo Spn('','', '_clr_icn','background-color:'.$___Ls->ls->rw['mdlstp_clr']).$___Ls->ls->rw['mdlstp_clr']; ?></td>
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

	    <form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>">
			  
		
	      	<?php $___Ls->_bld_f_hdr(); ?>     
		   	
		   	<div class="__cl_slc mdlstp_dsh dsh_cnt ln_1">  	
			   	
			   	<?php
	        
				    $__Cl = new CRM_Cl();
					$__Rnd = Gn_Rnd(20);
					
					$CntJV .= " 
					
					
					__mdlstp_bx_prm = $('#bx_prm_".$__Rnd."');
					__mdlstp_bx_cl = $('#bx_cl_".$__Rnd."');
					__mdlstp_bx_attr = $('#bx_attr_".$__Rnd."');
					__mdlstp_bx_ctg = $('#bx_ctg_".$__Rnd."');
					
					
					function MdlSTp_Dom_Rbld(){
						
						__mdlstp_bx_prm_itm = $('#bx_prm_".$__Rnd." > li.itm ');
						__mdlstp_bx_cl_itm = $('#bx_cl_".$__Rnd." > li.itm.cl ');
						__mdlstp_bx_attr_itm = $('#bx_attr_".$__Rnd." > li.itm.prm ');
						__mdlstp_bx_ctg_itm = $('#bx_ctg_".$__Rnd." > li.itm.ctg ');
						
						__mdlstp_bx_prm_fm = $('#bx_fm_prm_".$__Rnd."');
						__mdlstp_bx_cl_fm = $('#bx_fm_cl_".$__Rnd."');
						__mdlstp_bx_attr_fm = $('#bx_fm_attr_".$__Rnd."');
						__mdlstp_bx_ctg_fm = $('#bx_fm_ctg_".$__Rnd."');
						
						__mdlstp_bx_new = $('.mdlstp_dsh .sch button._new');
						__mdlstp_bx_new_bck = $('.mdlstp_dsh h2 button');
						__mdlstp_bx_new_sve = $('.mdlstp_dsh ._scrl ._new_fm button');
				
						
						__mdlstp_bx_cl_itm.not('.sch, .nosnd').off('click').click(function(){
							
							$(this).hasClass('on') ? est = 'del' : est = 'in'; 	
							var _id = $(this).attr('rel');
							
							_Rqu({ 
								t:'mdl_s_tp', 
								d:'cl',
								est: est,
								_id_cl : _id,
								_id_mdlstp : '".Php_Ls_Cln($___Ls->gt->i)."',
								_bs:function(){ __mdlstp_bx_cl.addClass('_ld'); },
								_cm:function(){ __mdlstp_bx_cl.removeClass('_ld'); },
								_cl:function(_r){
									if(!isN(_r)){
										if(!isN(_r.cl)){
											MdlSTpSet(_r.cl);			
										}
									}
								} 
							});
							
						});
						
						__mdlstp_bx_ctg_itm.not('.sch, .nosnd').off('click').click(function(){
							
							$(this).hasClass('on') ? est = 'del' : est = 'in'; 	
							var _id = $(this).attr('rel');
							
							_Rqu({ 
								t:'mdl_s_tp', 
								d:'ctg',
								est: est,
								_id : _id,
								_id_mdlstp : '".Php_Ls_Cln($___Ls->gt->i)."',
								_bs:function(){ __mdlstp_bx_cl.addClass('_ld'); },
								_cm:function(){ __mdlstp_bx_cl.removeClass('_ld'); },
								_cl:function(_r){
									if(!isN(_r)){
										if(!isN(_r.cl)){
											MdlSTpSet(_r.cl);			
										}
									}
								} 
							});
							
						});

						
						__mdlstp_bx_new.off('click').click(function(e){
							
							e.preventDefault();
							var _tp = $(this).attr('new-tp');
							
							if(e.target != this){ 
						    	e.stopPropagation(); return false;
							}else{
								MdlSTpFmBld({ t:_tp });
								$('.mdlstp_dsh').addClass('_new _new_'+_tp);
							}
					
						});
						
						
						__mdlstp_bx_new_bck.off('click').click(function(e){
							e.preventDefault();
							var _tp = $(this).attr('new-tp');
							
							if(e.target != this){
						    	e.stopPropagation(); return;
							}else{
								$('.mdlstp_dsh').removeClass('_new _new_'+_tp);
							}
						});	
						
						
						__mdlstp_bx_new_sve.off('click').click(function(e){
							
							e.preventDefault();
							var _tp = $(this).attr('new-tp');
							
							if(e.target != this){
						    	e.stopPropagation(); return;
							}else{
				
								var __data_snd = { 
										t:'mdl_s_tp', 
										d:'new_'+_tp, 
										est:'in', 
										_id_mdlstp : '".Php_Ls_Cln($___Ls->gt->i)."',
										_bs:function(){ _Rqu_Msg({ t:'prc' }); },
										_w:function(){ _Rqu_Msg({ t:'w' }); },
										_cl:function(_r){
											if(!isN(_r)){
												if(!isN(_r.e) && _r.e == 'ok'){
													MdlSTpSet(_r.cl);	
													$('.mdlstp_dsh').removeClass('_new _new_'+_tp);
													_Rqu_Msg({ t:'inok' });
													MdlSTpFmBld({ t:_tp });		
												}else{	
													_Rqu_Msg({ t:'w' });		
												}
											}
										} 
									};
								
								
								$('#bx_fm_'+_tp+'_{$__Rnd} :input').each(function(e){	
									id = this.id;
									__data_snd[ this.id ] = this.value ;
								});
								
								swal({									  
									  title: '".TX_ETSGR."',              
									  text: '".TX_SWAL_SVE."!',                        
									  showCancelButton: true,                      
									  confirmButtonText: '".TX_SWAL_YES."',      
									  confirmButtonColor: '".BTN_OK_CLR."',          
									  cancelButtonText: '".TX_SWAL_CNCL."',           
									  closeOnConfirm: false                   
								},										  
								function(){                               
									_Rqu( __data_snd );
								});
				
								
							}
						});
						
						
						SUMR_Main.LsSch({ str:'#prm_sch_".$__Rnd."', ls:__mdlstp_bx_cl_itm });
						SUMR_Main.LsSch({ str:'#ctg_sch_".$__Rnd."', ls:__mdlstp_bx_ctg_itm });
						
						_DshPopH({ c:'.mdlstp_dsh_bx', ov:100 });
							
					}
					
					function MdlSCl_Html(){
						__mdlstp_bx_cl.html('');
						__mdlstp_bx_cl.append('<li class=\"sch\">".HTML_inp_tx('cl_sch_'.$__Rnd, TX_SEARCH, '')."<button class=\"_new _anm\" new-tp=\"cl\"></button></li>');
						
						$.each(_mdlstpcl['ls'], function(k, v) { 
							
							if(!isN(v.tot) && !isN(v.tot.mdsl_tp) && v.tot.mdsl_tp > 0){ var _cls = 'on'; }else{ var _cls = 'off'; }
							
							if(!isN(v.img)){
								if(!isN(v.img.sm_s)){ img=v.img.sm_s; }else{ img=v.img; }
							}else{ 
								img=''; 
							}
							
							if(!isN(v.clr)){ var _bclr = v.clr; }else{ var _bclr = ''; }
							
							__mdlstp_bx_cl.append('	<li class=\"_anm itm cl '+_cls+'\" cl-id=\"'+v.enc+'\" rel=\"'+v.enc+'\" style=\"background-color:'+_bclr+'\">
														<figure style=\"background-image:url('+img+')\" class=\"_bg\"></figure>
														<span>'+v.nm+'</span>
													</li>');
						});	
						
						$('#tot_us_".$__Rnd."').html( _mdlstpcl['tot'] );
						
						MdlSTp_Dom_Rbld();
					}
			
					function MdlSPrm_Html(p){
						
						tpid = 'prm-tp-id';
						idli = 'prm-id';
						cls = 'prm';
						
						
						if( __mdlstp_bx_prm.html().length == 0){
							__mdlstp_bx_prm.html('');
							__mdlstp_bx_prm.append('<li class=\"sch\">".HTML_inp_tx('prm_sch_'.$__Rnd, TX_SEARCH, '')."<button class=\"_new _anm\" new-tp=\"prm\"></button></li>');
						}
						
						if(!isN(_mdlstpprm['ls'])){
							
							$.each(_mdlstpprm['ls'], function(k, v) { 
								
								if(!isN(tpid) && !isN(v) && !isN(v.enc)){
									
									if( $('['+tpid+'='+v.enc+']').length == 0 ){ 
										__mdlstp_bx_prm.append('<li class=\"itm nosnd grp_tp\" '+tpid+'=\"'+v.enc+'\"><h2>'+v.nm+'</h2><ul></ul></li>'); 
									}
									
									if(!isN(v.ls)){
										
										$.each(v.ls, function(k2, v2) { 
											
											if(!isN( v2.nm )){
												_cls = 'on';
												if(!isN(v2.img)){ img=v2.img; }else{ img=''; }
												
												var _fgr_sty = 'background-image:url('+img+')';
												var __cnt = '<figure style=\"'+_fgr_sty+'\" class=\"_md\"></figure><span>'+v2.nm+'<span class=\"sub\">('+v2.sbt+')</span></span>';
												
												if( $('['+idli+'='+v2.enc+']').length == 0 ){ 
													$('['+tpid+'='+v.enc+'] > ul').append( '<li class=\"_anm itm nosnd '+cls+' '+_cls+'\" '+idli+'=\"'+v2.enc+'\" rel=\"'+v2.enc+'\">'+__cnt+'</li>' );
												}
												
												$('['+idli+'='+v2.enc+']').addClass(_cls);
											}		
										});
										
									}
								
								}
							});
						
						}
						
						$('#tot_attr_".$__Rnd."').html( _mdlstpattr['tot'] );
						
						MdlSTp_Dom_Rbld();
						
					}

					function MdlSAttr_Html(){
						__mdlstp_bx_attr.html('');
						__mdlstp_bx_attr.append('<li class=\"sch\">".HTML_inp_tx('attr_sch_'.$__Rnd, TX_SEARCH, '')."<button class=\"_new _anm\" new-tp=\"attr\"></button></li>');
						
						if( !isN(_mdlstpattr['ls']) ){
							$.each(_mdlstpattr['ls'], function(k, v) { 
								if(v.tot > 0){ var _cls = 'on'; }else{ var _cls = 'off'; }
								__mdlstp_bx_attr.append('<li class=\"_anm itm attr '+_cls+'\" us-id=\"'+v.enc+'\" rel=\"'+v.enc+'\" ><span>'+v.nm+'</span></li>');
							});	
						}
						
						MdlSTp_Dom_Rbld();
					}
					
					function MdlSTpCtg_Html(){
				 
						 
						__mdlstp_bx_ctg.html('');
						__mdlstp_bx_ctg.append('<li class=\"sch\">".HTML_inp_tx('ctg_sch_'.$__Rnd, TX_SEARCH, '')."<button class=\"_new _anm\" new-tp=\"ctg\"></button></li>');
						
						if( !isN(_mdlstpctg['ls']) ){
							$.each(_mdlstpctg['ls'], function(k, v) { 
								if(v.est > 0){ var _cls = 'on'; }else{ var _cls = 'off'; }
								__mdlstp_bx_ctg.append('<li class=\"_anm itm ctg '+_cls+'\" us-id=\"'+v.enc+'\" rel=\"'+v.enc+'\" ><span>'+v.tt+'</span></li>');
							});	
						}
						
						MdlSTp_Dom_Rbld();
					}
					
					";
					
					$l_prmtp = __Ls([ 'k'=>'mdls_tp_prm', 'id'=>'mdlstpprm_tp', 'ph'=>'-' ]);
					$l_mdlstpattr = __Ls([ 'k'=>'mdls_tp_attr', 'id'=>'mdlstpattr_attr', 'ph'=>'-' ]);
					
					$CntJV .= "
					
						function MdlSTpFmBld(p){
							
							if(p.t == 'prm'){
								
								var _html = '".HTML_inp_hd('mdlstpprm_mdlstp',Php_Ls_Cln($___Ls->gt->i)).
											   $l_prmtp->html.			 
							    			   HTML_inp_tx('mdlstpprm_nm', TX_NM , '', FMRQD).   	
											   HTML_inp_tx('mdlstpprm_vl', TX_KEY, '', FMRQD)."
											   <button new-tp=\"prm\">".TXBT_GRDR."</button>'; 
								
								__mdlstp_bx_prm_fm.html( _html );
								$l_prmtp->js 
							
							}else if(p.t == 'attr'){
								
								var _html = '".$l_mdlstpattr->html."		
											   <button new-tp=\"attr\">".TXBT_GRDR."</button>'; 
								
								__mdlstp_bx_attr_fm.html( _html );
								$l_mdlstpattr->js 
							
							}
							
							MdlSTp_Dom_Rbld();
						}
						
						function MdlSTpSet(p){
							
							if( !isN(p) ){	
								
								_mdlstpcl = {};
								_mdlstpprm = {};
								_mdlstpattr = {}; 
								_mdlstpctg= {};
								
								if( !isN(p.mdlstp.cl) ){ _mdlstpcl['ls'] = p.mdlstp.cl.ls; _mdlstpcl['tot'] = p.mdlstp.cl.tot; }
								if( !isN(p.mdlstp.prm) ){ _mdlstpprm['ls'] = p.mdlstp.prm.ls; _mdlstpprm['tot'] = p.mdlstp.prm.tot; }
								if( !isN(p.mdlstp.attr) ){ _mdlstpattr['ls'] = p.mdlstp.attr.ls; _mdlstpattr['tot'] = p.mdlstp.attr.tot; }
								if( !isN(p.mdlstp.ctg) ){ _mdlstpctg['ls'] = p.mdlstp.ctg.ls; _mdlstpctg['tot'] = p.mdlstp.ctg.tot; }

								
								MdlSCl_Html();
								MdlSPrm_Html();
								MdlSAttr_Html();
								MdlSTpCtg_Html();
								
							}
						}
					
				";
				
				if($___Ls->dt->tot > 0){
					
					$CntJV .= " 
						_Rqu({ 
							t:'mdl_s_tp', 
							_id_mdlstp : '".Php_Ls_Cln($___Ls->gt->i)."',
							_cl:function(_r){
								if(!isN(_r)){
									if(!isN(_r.cl)){
										MdlSTpSet(_r.cl);			
									}
								}
							} 
						});
					";
				}
					
				
				?>

			   	<div id="<?php echo $___Ls->fm->fld->id ?>" class="_t_wrp mdlstp_dsh_bx">
				   	
		        	<div class="_c _c1 _anm">
						
						<?php
						 	if(!isN($___Ls->dt->rw['mdlstp_tp'])){
								echo h1(strtoupper( 'SIS_MDLSTP_'.str_replace('_','',$___Ls->dt->rw['mdlstp_tp']) ), 'id_cns'); 
							}
						?>
						<?php echo h2(TX_DTSBSC); ?>
			         	<?php echo HTML_inp_tx('mdlstp_nm', TX_NM , ctjTx($___Ls->dt->rw['mdlstp_nm'],'in'), FMRQD); ?>
			            <?php echo HTML_inp_tx('mdlstp_tp', TX_TP , ctjTx($___Ls->dt->rw['mdlstp_tp'],'in')); ?>
						<?php echo HTML_inp_clr([ 'id'=>'mdlstp_clr', 'plc'=>TX_CLR, 'vl'=>ctjTx($___Ls->dt->rw['mdlstp_clr'],'in') ]); ?>
						<?php echo OLD_HTML_chck('mdlstp_inf', TX_INFRM, $___Ls->dt->rw['mdlstp_inf'], 'in'); ?> 
			            <?php echo OLD_HTML_chck('mdlstp_sch', TX_HRO, $___Ls->dt->rw['mdlstp_sch'], 'in'); ?> 
			            <?php echo OLD_HTML_chck('mdlstp_unq', 'Valores Unicos', $___Ls->dt->rw['mdlstp_unq'], 'in'); ?> 
			            
			            <?php echo OLD_HTML_chck('mdlstp_clg', 'Colegios', $___Ls->dt->rw['mdlstp_clg'], 'in'); ?> 
			            <?php echo OLD_HTML_chck('mdlstp_uni', 'Universidades', $___Ls->dt->rw['mdlstp_uni'], 'in'); ?> 
			            <?php echo OLD_HTML_chck('mdlstp_emp', 'Empresas', $___Ls->dt->rw['mdlstp_emp'], 'in'); ?> 

						<?php echo OLD_HTML_chck('mdlstp_tra', 'Tarea Automatica', $___Ls->dt->rw['mdlstp_tra'], 'in'); ?> 
						<?php echo OLD_HTML_chck('mdlstp_mdls', 'Filtro Submodulo', $___Ls->dt->rw['mdlstp_mdls'], 'in'); ?> 


						<?php $CntJV .= " 

							$('._mdlstp_tra').hide();

							function TabShw(p){
								if( p.is(':checked') ){ 
									$('._mdlstp_tra').show().removeClass('TabbedPanelsTabSelected');
								}else{
									$('._mdlstp_tra').hide();
									$('._bsc').addClass('TabbedPanelsTabSelected');
									$('#tab_bsc').show().addClass('TabbedPanelsContentVisible');
								}
							}

							var _this = $('#mdlstp_tra');
							TabShw(_this);
							
							$('#mdlstp_tra').change(function() {
								var _this = $(this);
								TabShw(_this);
							});

						"; ?>

					</div>
										
					<?php  
						
						$__tabs = [
							['n'=>'cl_row', 't'=>'cl_row', 'l'=>TX_ATTR],
							['n'=>'mdlstp_tra', 't'=>'mdl_s_tp_tra', 'l'=>'Atributos Tareas'],
							['n'=>'mdlstp_col', 't'=>'mdl_s_tp_col', 'l'=>'Columnas']
						];
						$___Ls->_dvlsfl_all($__tabs);
						
					?>
					<?php $_id_tbpnl = 'TabPnl_'.Gn_Rnd(20); $CntWb .= " SUMR_Main.bxajx.".$_id_tbpnl." = new Spry.Widget.TabbedPanels('".$_id_tbpnl."' {$_tb_dfl}); "; $CntWb .= _DvLsFl([ 'i'=>$___Ls->tb->eml ]);  ?>
					<div id="<?php echo $_id_tbpnl ?>" class="VTabbedPanels TbGnrl mny mdl_s_tp_tab">
			          	<ul class="TabbedPanelsTabGroup">
				            <?php echo $___Ls->tab->bsc->l ?>
				            <?php echo $___Ls->tab->cl_row->l ?>  
							<?php echo $___Ls->tab->mdlstp_tra->l ?>  
							<?php echo $___Ls->tab->mdlstp_col->l ?> 
			          	</ul>
					  	<div class="TabbedPanelsContentGroup">
				        	<div id="tab_bsc" class="TabbedPanelsContent">
				            	<div class="_c _c2 _anm _scrl">
									<?php echo h2('<button new-tp="cl"></button> '.TX_CL); ?>
									<div class="_wrp">
								    	<ul id="bx_cl_<?php echo $__Rnd; ?>" class="_ls dls _anm"></ul>	 
								    	<div class="_new_fm" id="bx_fm_cl_<?php echo $__Rnd; ?>"></div>  
								    </div>
									<?php /*if($___Ls->dt->tot > 0){ ?>
							          	<div class="ln">
							                <?php echo bdiv(array('id'=>DV_LSFL.'_cl')) ?>
							                <?php       
												$CntJV .= _DvLsFl_Vr(array('i'=>$___Ls->dt->rw[$___Ls->ino], 'n'=>'_cl', 't'=>'mdl_s_tp_cl'));
												$CntWb .= _DvLsFl(array('i'=>'_cl', 't'=>'s')); 
											?> 
							            </div> 
									<?php }*/ ?> 		
								</div>
								<div class="_c _c3 _anm _scrl">
									
									<?php echo h2('<button new-tp="prm"></button> '.TX_PRM); ?>
									<div class="_wrp">
								    	<ul id="bx_prm_<?php echo $__Rnd; ?>" class="_ls dls _anm"></ul>	 
								    	<div class="_new_fm" id="bx_fm_prm_<?php echo $__Rnd; ?>"></div>  
								    </div>
										
								</div> 	 
								<div class="_c _c4 _anm _scrl">
									
									<?php echo h2('<button new-tp="ctg"></button> '."Categorias"); ?>
									<div class="_wrp">
								    	<ul id="bx_ctg_<?php echo $__Rnd; ?>" class="_ls dls _anm"></ul>	 
								    	<div class="_new_fm" id="bx_fm_ctg_<?php echo $__Rnd; ?>"></div>  
								    </div>
										
								</div> 
				        	</div>
				        	<div class="TabbedPanelsContent">
				            	<?php echo $___Ls->tab->cl_row->d ?>	  
				        	</div>
							<div class="TabbedPanelsContent">
				            	<?php echo $___Ls->tab->mdlstp_tra->d ?> 
							</div>
							<div class="TabbedPanelsContent">
				            	<?php echo $___Ls->tab->mdlstp_col->d ?> 
				        	</div>
			          	</div> 
			        </div>
				</div>
		   	</div>
	    </form>
  	</div>
</div>
<style>
	
	.pop_cnt .VTabbedPanels{ width: 100%; }
	.mdlstp_dsh{ display: block; width: 100%; position: relative; }
	.mdlstp_dsh > ._t_wrp{ width: 100%; display: flex; }
	.mdlstp_dsh > ._t_wrp ._c{ display: inline-block; vertical-align: top; border-right: 1px solid #d0d5d8; width: 24.9%; padding-left: 15px; padding-right: 15px; position: relative; min-height: 450px; overflow-x: hidden; overflow-y: scroll; }
	
	.mdl_s_tp_tab.VTabbedPanels .TabbedPanelsTab._bsc{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>cnt_dtl.svg); }
	.mdl_s_tp_tab.VTabbedPanels .TabbedPanelsTabSelected._bsc{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>cnt_dtl_w.svg); }
	.mdl_s_tp_tab.VTabbedPanels .TabbedPanelsTab._cl_row{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>atrt.svg); }
	.mdl_s_tp_tab.VTabbedPanels .TabbedPanelsTabSelected._cl_row{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>atrt_w.svg); }
	.mdl_s_tp_tab.VTabbedPanels .TabbedPanelsTab._mdlstp_col{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>columns.svg); }
	
	.mdlstp_dsh > ._t_wrp ._c._c1{ width: 33%; }
	.mdlstp_dsh > ._t_wrp ._c._c4{ width: 33%; }
	.mdlstp_dsh > ._t_wrp ._c._c2{ width: 33%; }
	.mdlstp_dsh > ._t_wrp ._c._c3{ width: 33%; }
	
    .mdlstp_dsh._new_prm ._c._c3,
    .mdlstp_dsh._new_attr ._c._c4{ width: 48%; border: none; }
    
    .mdlstp_dsh._new_prm ._c._c3 ._ls,
    .mdlstp_dsh._new_attr ._c._c4 ._ls{ display: none; pointer-events: none; }
    
    .mdlstp_dsh._new_prm ._c._c3 h2 button,
    .mdlstp_dsh._new_attr ._c._c4 h2 button{ display: inline-block; }
    
    
    .mdlstp_dsh._new_prm ._c._c2,
    .mdlstp_dsh._new_prm ._c._c4,
    .mdlstp_dsh._new_attr ._c._c2,
    .mdlstp_dsh._new_attr ._c._c3{ max-width: 15%; opacity: 0.4; -webkit-filter: grayscale(100%); filter: grayscale(100%); pointer-events: none; }
	
	.mdl_s_tp_tab.VTabbedPanels.mny > ul li.TabbedPanelsTab{height: 40px;width: 40px; background-size: 70% auto; background-repeat: no-repeat; background-position: center; }
	.mdl_s_tp_tab.VTabbedPanels{ width: 100%; }
	
	
	li._anm.itm.ctg.on {border: 2px solid var(--second-bg-color) !important;color: var(--main-bg-color) !important;}
	        
</style>


<?php } ?>
<?php } ?>
