<?php 
if(class_exists('CRM_Cnx')){
 	
 	$___Ls->sch->f = 'clgrp_nm';
 	$___Ls->new->w = 400;
 	$___Ls->new->h = 300;
 	$___Ls->edit->big = 'ok';
 	
 	$___Ls->ls->lmt = 1000;
 	$___Ls->_strt();
 	

	 
	if(!isN($___Ls->gt->i)){   
	    
	    $___Ls->qrys = sprintf("SELECT * FROM ".TB_CL_GRP." WHERE ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));
	    
	}elseif($___Ls->_show_ls == 'ok'){   
	     
	    $Ls_Whr = "	FROM ".TB_CL_GRP." 
	    			WHERE ".$___Ls->ino." != '' AND clgrp_cl = (SELECT id_cl FROM "._BdStr(DBM).TB_CL." where cl_enc = '".DB_CL_ENC."') ".$___Ls->sch->cod." 
	    			ORDER BY ".$___Ls->ino." DESC";
	    			
	    $___Ls->qrys = "SELECT *, (SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT.",
	    
						( 	SELECT COUNT(*) 
							FROM ".TB_CL_GRP_US.", ".TB_US." 
							WHERE id_clgrp = clgrpus_clgrp AND id_us =  clgrpus_us 
							
						) AS __rgtot_us,
						
						( 	SELECT COUNT(*) 
							FROM ".TB_CL_GRP_PRM.", ".TB_MDL_S_TP_PRM." 
							WHERE id_clgrp = clgrpprm_clgrp AND id_mdlstpprm =  clgrpprm_prm 
							
						) AS __rgtot_prm,
						
						( 	SELECT COUNT(*) 
							FROM "._BdStr(DBM).TB_TRA_COL_GRP.", "._BdStr(DBM).TB_TRA_COL." 
							WHERE id_clgrp = tracolgrp_grp AND id_tracol =  tracolgrp_tracol 
							
						) AS __rgtot_col 
						
						$Ls_Whr"; 
		
	} 
	
	$___Ls->_bld();
	
?>
<?php if($___Ls->ls->chk=='ok'){ ?>
<?php $___Ls->_bld_l_hdr(); ?>

<?php if(($___Ls->qry->tot > 0)){ ?>
   
<form method="POST" id="frm_new" class="FmTb" name="frm_new" target="_self">
    <div id="dv_new_<?php echo $___Ls->id_rnd; ?>" name="dv_new_<?php echo $___Ls->id_rnd; ?>" style="width: 50%;margin:auto;display: none;">
        <div class="ln_1">
            <div class="col_1" style="width: 58%;">
                <?php echo HTML_inp_tx('clgrp_nm', TX_NM , ctjTx($___Ls->dt->rw['clgrp_nm'],'in'), FMRQD); ?>
                <?php //echo HTML_inp_tx('cl_sbd', 'Subdominio' , ctjTx($___Ls->dt->rw['cl_sbd'],'in'), FMRQD); ?>
            </div>
        </div>
    </div>
</form>




<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
	<thead>
		<tr>
		    <th width="1%" <?php echo NWRP ?>><?php echo TX_FM_No ?></th>
		    <th width="48%" <?php echo NWRP ?>><?php echo TX_NM ?></th>
		    <th width="1%" <?php echo NWRP ?>><?php echo TX_TTUSR ?></th>
		    <th width="1%" <?php echo NWRP ?>><?php echo TX_TTPRMS ?></th>
		    <th width="1%" <?php echo NWRP ?>><?php echo TX_TTCOL ?></th> 
		    <th width="1%" <?php echo NWRP ?>><?php echo TX_CRDDT ?></th> 
		    <th width="1%" <?php echo NWRP ?>></th>
  		</tr>
	</thead>	
	<?php do { ?>
  	<?php 
        
		        
	  	$___id = $___Ls->ls->rw[$___Ls->ino];
	  	$___clgrp[$___id] = [ 
							'id'=>$___id, 
							'nm'=>ctjTx($___Ls->ls->rw['clgrp_nm'],'in'),
							'prnt'=>ShortTx(ctjTx($___Ls->ls->rw['clgrp_prnt'],'in'),150,'Pt', true),
							'tot'=>[
								'us'=>ctjTx($___Ls->ls->rw['__rgtot_us'],'in'),
								'prm'=>ctjTx($___Ls->ls->rw['__rgtot_prm'],'in'),
								'col'=>ctjTx($___Ls->ls->rw['__rgtot_col'],'in')
							],
							'fi'=>Spn(_Tme($___Ls->ls->rw['clgrp_fi'], 'col')),
							'hb'=>[
								'mod'=>$___Ls->hb->mod,
							],
							'btn'=>[

								'edt'=>$___Ls->_btn([ 't'=>'mod' ])

							]
						];
	
  	?>
  <?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>
  <?php 
	
		$__row = _bTree( $___clgrp, '', 'a');
		
		function _BldLs($p=NULL, $lvl_set='', $_parent_sub=''){
			
			if($lvl_set != NULL){ $lvl=$lvl_set; }else{ /*$lvl=0;*/ } $lvl=$lvl+1;
			
			foreach($p as $mn_v){
				
				$__tt_btn = $mn_v['nm'];
				$__id_prnt = $mn_v['prnt'];
				
				if($lvl==1){ $NmNw = 2; }
				 
				$__html_b .= '<tr '.cl($mn_v['trlnk'],$Nm,'','','','ok').'>';
				
				for($i=1; $i<$lvl;$i++){ if($lvl>$i && $__id_prnt != $_parent){ $__li_sub .= '—— '; } }

				
				$__html_b .= '
					<td width="1%" '.NWRP.'>'.Spn($mn_v['id'],'','_nmr '.$_nm_sis,'background-color:'.$mn_v['clr']['bck'].'; color:'.$mn_v['clr']['fnt'].';').'</td>
				    <td width="50%" align="left" '.NWRP.' style="text-align:left !important;">'.	
				    	$__li_sub.
				    	$__tt_btn.'</br>'. 	
				    '</td>
					<td width="5%" align="left" '.NWRP.'>'.$mn_v['tot']['us'].'</td>
					<td width="5%" align="left" '.NWRP.'>'.$mn_v['tot']['prm'].'</td>
					<td width="5%" align="left" '.NWRP.'>'.$mn_v['tot']['col'].'</td>
				    <td width="5%" align="left" '.NWRP.'>'.$mn_v['fi'].'</td>
				    <td width="1%" align="left" '.NWRP.' class="_btn">'.$mn_v['btn']['edt'].'</td>
				';
				
				if($mn_v['sub'] != NULL){
					$__chld = _BldLs($mn_v['sub'], $lvl, $__id_prnt);
					$__html_b .= $__chld;	
				}
								
				$_parent = $mn_v['prnt'];
				$__html_b .= '</tr>';
				
			}
				
			return $__html_b;
		}
	
		$__html = _BldLs($__row);
		
		echo $__html;
	?>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
	<?php do { ?>  
	<?php if(!isN($___Ls->ls->rw['clgrp_nm'])){ ?>
	<tr>    		
		<td align="left" <?php echo $_clr_rw ?>><?php echo $___Ls->ls->rw[$___Ls->ino]; ?></td>
	    <td width="48%" align="left" <?php echo $_clr_rw ?>><?php echo ctjTx($___Ls->ls->rw['clgrp_nm'],'in'); ?></td>
	    <td width="1%" align="left" <?php echo $_clr_rw ?>><?php echo ctjTx($___Ls->ls->rw['__rgtot_us'],'in'); ?></td>
	    <td width="1%" align="left" <?php echo $_clr_rw ?>><?php echo ctjTx($___Ls->ls->rw['__rgtot_prm'],'in'); ?></td>
	    <td width="1%" align="left" <?php echo $_clr_rw ?>><?php echo ctjTx($___Ls->ls->rw['__rgtot_col'],'in'); ?></td>
	    <td width="1%" align="left" <?php echo $_clr_rw ?>><?php echo ctjTx($___Ls->ls->rw['clgrp_fi'],'in'); ?></td>
	    <td width="1%" align="left" nowrap="nowrap" class="_btn"><?php echo $___Ls->_btn([ 't'=>'mod' ]); ?></td>
  	</tr>
  	<?php } ?>
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
		
		<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">

        <?php
	        
	        $__Cl = new CRM_Cl();
	        $__Rnd = Gn_Rnd(20);
			
			
			$CntJV .= " 
			
			
				var SUMR_Dsh_Cl_Grp = {
					bx_us:$('#bx_us_".$__Rnd."'),
					bx_prm:$('#bx_prm_".$__Rnd."'),
					bx_est:$('#bx_est_".$__Rnd."')
				};
				
				function Dom_Rbld(){
					
					SUMR_Dsh_Cl_Grp.bx_us_itm = $('#bx_us_".$__Rnd." > li.itm ');
					SUMR_Dsh_Cl_Grp.bx_prm_itm = $('#bx_prm_".$__Rnd." li.itm.prm ');
					SUMR_Dsh_Cl_Grp.bx_est_itm = $('#bx_est_".$__Rnd." li.itm.est ');
					SUMR_Dsh_Cl_Grp.bx_us_fm = $('#bx_fm_us_".$__Rnd."');
					SUMR_Dsh_Cl_Grp.bx_prm_fm = $('#bx_fm_prm_".$__Rnd."');
					SUMR_Dsh_Cl_Grp.bx_est_fm = $('#bx_fm_est_".$__Rnd."');
					
					SUMR_Dsh_Cl_Grp.bx_new = $('.cl_grp_dsh .sch button');
					SUMR_Dsh_Cl_Grp.bx_new_bck = $('.cl_grp_dsh h2 button');
					SUMR_Dsh_Cl_Grp.bx_new_sve = $('.cl_grp_dsh ._scrl ._new_fm button');
					
					
					SUMR_Dsh_Cl_Grp.bx_us_itm.not('.sch').off('click').click(function(){
						
						$(this).hasClass('on') ? est = 'del' : est = 'in'; 		
						var _id = $(this).attr('rel');
						
						_Rqu({ 
							t:'cl_grp', 
							d:'us',
							est: est,
							_id_us : _id,
							_id_grp : '".Php_Ls_Cln($___Ls->gt->i)."',
							_bs:function(){ SUMR_Dsh_Cl_Grp.bx_us.addClass('_ld'); },
							_cm:function(){ SUMR_Dsh_Cl_Grp.bx_us.removeClass('_ld'); },
							_cl:function(_r){
								if(!isN(_r)){
									if(!isN(_r.cl)){
										ClSet(_r.cl);			
									}
								}
							} 
						});
						
					});
					
					SUMR_Dsh_Cl_Grp.bx_prm_itm.not('.sch').off('click').click(function(){
						
						$(this).hasClass('on') ? est = 'del' : est = 'in'; 		
						var _id = $(this).attr('rel');
						
						_Rqu({ 
							t:'cl_grp', 
							d:'prm',
							est: est,
							_id_prm : _id,
							_id_grp : '".Php_Ls_Cln($___Ls->gt->i)."',
							_bs:function(){ SUMR_Dsh_Cl_Grp.bx_prm.addClass('_ld'); },
							_cm:function(){ SUMR_Dsh_Cl_Grp.bx_prm.removeClass('_ld'); },
							_cl:function(_r){
								if(!isN(_r)){
									if(!isN(_r.cl)){
										ClSet(_r.cl);			
									}
								}
							} 
						});
					});
					
					
					SUMR_Dsh_Cl_Grp.bx_est_itm.not('.sch').off('click').click(function(){
						$(this).hasClass('on') ? est = 'del' : est = 'in'; 		
						var _id = $(this).attr('rel');
						_Rqu({ 
							t:'cl_grp', 
							d:'est',
							est: est,
							_id_est : _id,
							_id_grp : '".Php_Ls_Cln($___Ls->gt->i)."',
							_bs:function(){ SUMR_Dsh_Cl_Grp.bx_est.addClass('_ld'); },
							_cm:function(){ SUMR_Dsh_Cl_Grp.bx_est.removeClass('_ld'); },
							_cl:function(_r){
								if(!isN(_r)){
									if(!isN(_r.cl)){
										ClSet(_r.cl);			
									}
								}
							} 
						});
					});
					
					
					SUMR_Dsh_Cl_Grp.bx_new.off('click').click(function(e){
	
						e.preventDefault();
						var _tp = $(this).attr('new-tp');
						
						if(e.target != this){
					    	e.stopPropagation(); return;
						}else{
							GrpFmBld({ t:_tp });
							$('.cl_grp_dsh').addClass('_new_'+_tp);
						}
				
					});
					
					
					SUMR_Dsh_Cl_Grp.bx_new_bck.off('click').click(function(e){
						e.preventDefault();
						var _tp = $(this).attr('new-tp');
						
						if(e.target != this){
					    	e.stopPropagation(); return;
						}else{
							$('.cl_grp_dsh').removeClass('_new _new_'+_tp);
						}
					});	
					
					
					SUMR_Dsh_Cl_Grp.bx_new_sve.off('click').click(function(e){
						
						e.preventDefault();
						var _tp = $(this).attr('new-tp');
						
						if(e.target != this){
					    	e.stopPropagation(); return;
						}else{
	
							var __data_snd = { 
									t:'cl_grp', 
									d:'new_'+_tp, 
									_id_grp : '".Php_Ls_Cln($___Ls->gt->i)."',
									_bs:function(){ _Rqu_Msg({ t:'prc' }); },
									_w:function(){ _Rqu_Msg({ t:'w' }); },
									_cl:function(_r){
										if(!isN(_r)){
											if(!isN(_r.e) && _r.e == 'ok'){
												ClSet(_r.cl);	
												$('.cl_grp_dsh').removeClass('_new _new_'+_tp);
												_Rqu_Msg({ t:'inok' });	
												GrpFmBld({ t:_tp });		
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
					
					
					
					
					
					SUMR_Main.LsSch({ str:'#us_sch_".$__Rnd."', ls:SUMR_Dsh_Cl_Grp.bx_us_itm });
					SUMR_Main.LsSch({ str:'#prm_sch_".$__Rnd."', ls:SUMR_Dsh_Cl_Grp.bx_prm_itm });
					SUMR_Main.LsSch({ str:'#est_sch_".$__Rnd."', ls:SUMR_Dsh_Cl_Grp.bx_est_itm });
					
				}
				
				
				function ClGrpUs_Html(){
					
					SUMR_Dsh_Cl_Grp.bx_us.html('');
					SUMR_Dsh_Cl_Grp.bx_us.append('<li class=\"sch\">".HTML_inp_tx('us_sch_'.$__Rnd, TX_SEARCH, '')."<button class=\"_new _anm\" new-tp=\"us\"></button></li>');
					
					if(!isN(_clgrpus['ls'])){
						
						$.each(_clgrpus['ls'], function(k, v) { 
							if(v.tot > 0){ var _cls = 'on'; }else{ var _cls = 'off'; }
							if(!isN(v.img)){
								if(!isN(v.img.sm_s)){ img=v.img.sm_s; }else{ img=v.img; }
							}else{ img=''; }
							SUMR_Dsh_Cl_Grp.bx_us.append('<li class=\"_anm itm us '+_cls+'\" us-id=\"'+v.enc+'\" rel=\"'+v.enc+'\">
															<figure style=\"background-image:url('+img+')\" class=\"_bg\"></figure>
															<span>'+v.nm+'</span>
															<p>'+v.user+'</p>
														</li>');
						});	
						
						$('#tot_us_".$__Rnd."').html( _clgrpus['tot'] );
					
					}
					
					Dom_Rbld();
				}
				
				
				function ClGrpMlt_Html(p){
					
					if(p.t == 'prm'){
						box = SUMR_Dsh_Cl_Grp.bx_prm;
						nmsch = 'prm';	
						ls = _clgrpprm['ls'];
						lstot = _clgrpprm['tot'];
						tpid = 'prm-tp-id';
						idli = 'prm-id';
						cls = 'prm';
					}else if(p.t == 'est'){
						box = SUMR_Dsh_Cl_Grp.bx_est;	
						nmsch = 'est';
						ls = _clgrpest['ls'];
						lstot = _clgrpest['tot'];
						tpid = 'est-tp-id';
						idli = 'est-id';
						cls = 'est';
					}
					
					
					if( box.html().length == 0){
						box.html('');
						box.append('<li class=\"sch\">".HTML_inp_tx('\'+nmsch+\'_sch_'.$__Rnd, TX_SEARCH, '')."<button class=\"_new _anm\" new-tp=\"'+nmsch+'\"></button></li>');
					}
					
					if(!isN(ls)){
						
						$.each(ls, function(k, v) { 
							
							if(!isN(tpid) && !isN(v) && !isN(v.enc)){
								
								if( $('['+tpid+'='+v.enc+']').length == 0 ){ 
									box.append('<li class=\"itm grp_tp\" '+tpid+'=\"'+v.enc+'\"><h2>'+v.nm+'</h2><ul></ul></li>'); 
								}
								
								if(!isN(v.ls)){
									
									$.each(v.ls, function(k2, v2) { 
										
										if(!isN( v2.nm )){
	
											if(!isN(v2.tot) && !isN(v2.tot.grp) && v2.tot.grp > 0){ var _cls = 'on'; }else{ var _cls = 'off'; }
											if(!isN(v2.img)){ img=v2.img; }else{ img=''; }
											
											if(p.t == 'prm'){
												var _fgr_sty = 'background-image:url('+img+')';
											}else{
												var _fgr_sty = 'background-color:'+v2.clr;
											}
											
											var __cnt = '<figure style=\"'+_fgr_sty+'\" class=\"_md\"></figure><span>'+v2.nm+'<span class=\"sub\">('+v2.sbt+')</span></span>';
											
											if( $('['+idli+'='+v2.enc+']').length == 0 ){ 
												$('['+tpid+'='+v.enc+'] > ul').append( '<li class=\"_anm itm '+cls+' '+_cls+'\" '+idli+'=\"'+v2.enc+'\" rel=\"'+v2.enc+'\">'+__cnt+'</li>' );
											}else{									
												$('['+idli+'='+v2.enc+']').html( __cnt ).removeClass('on off');
											}
											
											$('['+idli+'='+v2.enc+']').addClass(_cls);
										}		
									});
									
								}
							
							}
						});
					
					}
					
					$('#tot_est_".$__Rnd."').html( lstot );
					
					Dom_Rbld();
					
					
				}
			
			";
			
			
			$l_gnr = __Ls(['k'=>'sx', 'id'=>'us_gnr', 'va'=>$___Ls->dt->rw['us_gnr'] , 'ph'=>FM_LS_SISSX]); 
			$l_prmtp = __Ls([ 'k'=>'mdls_tp_prm', 'id'=>'mdlstpprm_tp', 'ph'=>'-' ]);
			
			$CntJV .= "
			
			function GrpFmBld(p){
				
				if(p.t == 'us'){
					
					var _html = '".HTML_inp_tx('us_user', TX_US, ctjTx($___Ls->dt->rw['us_user'],'in'), FMRQD_EM)." 
		            			".HTML_inp_tx('us_nm', TX_NM, ctjTx($___Ls->dt->rw['us_nm'],'in'), FMRQD)." 
								".HTML_inp_tx('us_ap', TX_AP, ctjTx($___Ls->dt->rw['us_ap'],'in'), FMRQD).
								$l_gnr->html."<button new-tp=\"us\">".TXBT_GRDR."</button>'; 
					
					SUMR_Dsh_Cl_Grp.bx_us_fm.html( _html );
					
					$l_gnr->js  
				
				}else if(p.t == 'prm'){ 
					
					var _html = '".LsMdlSTp('mdlstpprm_mdlstp', 'id_mdlstp', '', '', 1).
								   $l_prmtp->html.			 
				    			   HTML_inp_tx('mdlstpprm_nm', TX_NM , '', FMRQD).   	
								   HTML_inp_tx('mdlstpprm_vl', TX_KEY, '', FMRQD)."
								   <button new-tp=\"prm\">".TXBT_GRDR."</button>'; 
					
					SUMR_Dsh_Cl_Grp.bx_prm_fm.html( _html );
					
					$l_prmtp->js 
					".JQ_Ls('mdlstpprm_mdlstp', FM_LS_SLTP)." 
				
				}else if(p.t == 'est'){
					
					var _html = '".HTML_inp_tx('cntest_tt', TX_NM).
								  LsCntEstTp('cntest_tp','id_siscntesttp','',TX_TP).
								  HTML_inp_clr([ 'id'=>'cntest_clr', 'plc'=>TX_CLR ])."
								  <button new-tp=\"est\">".TXBT_GRDR."</button>'; 
					
					SUMR_Dsh_Cl_Grp.bx_est_fm.html( _html );
					
					".JQ_Ls('cntest_tp', TX_TP)."
				
				}
				
				Dom_Rbld();
			}
			
			
			function ClSet(p){
				
				if( !isN(p) ){
					
					_clgrpus = {};
					_clgrpprm = {}; 
					_clgrpest = {}; 
					_clgrptra = {}; 
					_clgrpus['dt'] = {};
					_clgrpprm['dt'] = {};
					_clgrpest['dt'] = {};
					_clgrptra['dt'] = {};
					
					if( !isN(p.grp.us) ){ _clgrpus['ls'] = p.grp.us.ls; _clgrpus['tot'] = p.grp.us.tot; }
					if( !isN(p.grp.prm) ){ _clgrpprm['ls'] = p.grp.prm.ls; _clgrpprm['tot'] = p.grp.prm.tot.grp; }
					if( !isN(p.grp.est) ){ _clgrpest['ls'] = p.grp.est.ls; _clgrpest['tot'] = p.grp.est.tot; }
					if( !isN(p.grp.tra) ){ _clgrptra['ls'] = p.grp.tra.ls; _clgrptra['tot'] = p.grp.tra.tot; $('#tot_col_".$__Rnd."').html( _clgrptra['tot'] ); }
					
					ClGrpUs_Html();
					
					ClGrpMlt_Html({ t:'prm' });
					ClGrpMlt_Html({ t:'est' });
				}
			}
			
			
				
		";
		
		if($___Ls->dt->tot > 0){

			$CntJV .= " 
			
				
				_Rqu({ 
					t:'cl_grp', 
					_id_grp : '".Php_Ls_Cln($___Ls->gt->i)."',
					_cl:function(_r){
						if(!isN(_r)){
							if(!isN(_r.cl)){
								ClSet(_r.cl);			
							}
						}
					} 
				});
				
			";
			
		}
			
    
    ?>
        
        
        <div class="cl_grp_dsh dsh_cnt <?php if($___Ls->dt->tot == 0){ echo '_new'; } ?>">
	        
	        <div class="_c _c1 _anm">
				
				<?php echo h2(TX_NM).HTML_inp_tx('clgrp_nm', TX_NM , ctjTx($___Ls->dt->rw['clgrp_nm'],'in'), FMRQD); ?>
				<?php 
					
					echo LsClGrp('clgrp_prnt','id_clgrp', $___Ls->dt->rw['clgrp_prnt'], TX_PRNT, 2, '', ['cl'=>$__mnuls_cl, 'sis'=>$__mnuls_sis] ); 
				  	$CntWb .= JQ_Ls('clgrp_prnt', TX_PRNT);  
					
				?>
				
				<?php if($___Ls->dt->tot > 0){ ?>
					<?php 
						$__fi = FechaESP_OLD( $___Ls->dt->rw['clgrp_fi'] );
						echo 	h2( TX_CRDL ).
								bdiv([ 'c'=>$__fi.Spn( date("h:i:s a", strtotime($___Ls->dt->rw['clgrp_fi'])) ) , 'cls'=>'bx' ]); 
					?>
					<?php 
						$__fi = FechaESP_OLD( $___Ls->dt->rw['clgrp_fa'] );
						echo 	h2( TX_LSTUPDT ).
								bdiv([ 'c'=>$__fi.Spn( date("h:i:s a", strtotime($___Ls->dt->rw['clgrp_fa'])) ) , 'cls'=>'bx' ]); 
					?>
					
					<?php echo h2( TX_TTUSR.':').bdiv([ 'id'=>'tot_us_'.$__Rnd, 'c'=>'0', 'cls'=>'bx' ]); ?>
					<?php echo h2( TX_TTPRMS.':').bdiv([ 'id'=>'tot_prm_'.$__Rnd, 'c'=>'0', 'cls'=>'bx' ]); ?>
					<?php echo h2( TX_TTETD.':').bdiv([ 'id'=>'tot_est_'.$__Rnd, 'c'=>'0', 'cls'=>'bx' ]); ?>
					<?php echo h2( TX_TTCOL.':').bdiv([ 'id'=>'tot_col_'.$__Rnd, 'c'=>'0', 'cls'=>'bx' ]); ?>
				
				<?php } ?>
	
	        </div>
	        
	        
	        
	        
	        
	        <?php 
			  	$___Ls->_dvlsfl_all([
					['n'=>'cl_mdl_are', 't'=>'cl_mdl_are', 'l'=>TX_MDL_ARE, 'bimg'=>''],
					['n'=>'tra_col_grp', 't'=>'tra_col_grp', 'l'=>TX_COLS, 'bimg'=>''],
					['n'=>'mdl_grp', 't'=>'mdl_grp', 'l'=>TX_MDL, 'bimg'=>'']
				]);
			?>
			<?php 
				$_id_tbpnl = 'TabPnl_'.Gn_Rnd(20);
				 $CntWb .= " SUMR_Main.bxajx.".$_id_tbpnl." = new Spry.Widget.TabbedPanels('".$_id_tbpnl."' {$_tb_dfl}); "; 
				$CntWb .= _DvLsFl([ 'i'=>$___Ls->tb->eml ]);  
			?>
				 
	        <div style="width: 100%;" id="<?php echo $_id_tbpnl ?>" class="VTabbedPanels TbGnrl mny">
	          	<ul class="TabbedPanelsTabGroup">
		            <?php echo $___Ls->tab->bsc->l ?>
		            <?php echo $___Ls->tab->cl_mdl_are->l ?>
		            <?php echo $___Ls->tab->tra_col_grp->l ?>  
					<?php echo $___Ls->tab->mdl_grp->l ?> 
	          	</ul>
			  	<div class="TabbedPanelsContentGroup">
	            	<div class="TabbedPanelsContent">
			            <div class="_c _c2 _anm _scrl">
					        <?php echo h2('<button new-tp="us"></button> '.TX_USRS); ?>
					        <div class="_wrp">
						    	<ul id="bx_us_<?php echo $__Rnd; ?>" class="_ls _anm dls"></ul>	
						    	<div class="_new_fm" id="bx_fm_us_<?php echo $__Rnd; ?>"></div>	 
					        </div>
				        </div>
				        <div class="_c _c3 _anm _scrl">
					        <?php echo h2('<button new-tp="prm"></button>'.TX_PRM); ?>
					        <div class="_wrp">
						    	<ul id="bx_prm_<?php echo $__Rnd; ?>" class="_ls _anm dls"></ul>	
						    	<div class="_new_fm" id="bx_fm_prm_<?php echo $__Rnd; ?>"></div>   
						    </div>
				        </div>
				        <div class="_c _c4 _anm _scrl">
					        <?php echo h2('<button new-tp="est"></button> '.TX_CCLVNTS); ?>
					        <div class="_wrp">
						    	<ul id="bx_est_<?php echo $__Rnd; ?>" class="_ls _anm dls"></ul>	 
						    	<div class="_new_fm" id="bx_fm_est_<?php echo $__Rnd; ?>"></div>  
						    </div>
				        </div>   	   
	            	</div>
					<div class="TabbedPanelsContent">
		                <!-- Inicia Documentos -->
	                    <div class="ln">
	                        <?php echo $___Ls->tab->cl_mdl_are->d ?>
	                    </div> 
		                <!-- Finaliza Documentos -->
		            </div>
		            <div class="TabbedPanelsContent">
		                <!-- Inicia Documentos -->
	                    <div class="ln">
	                        <?php echo $___Ls->tab->tra_col_grp->d ?>
	                    </div> 
		                <!-- Finaliza Documentos -->
		            </div>
					<div class="TabbedPanelsContent">
		                <!-- Inicia Documentos -->
	                    <div class="ln">
	                        <?php echo $___Ls->tab->mdl_grp->d ?>
	                    </div> 
		                <!-- Finaliza Documentos -->
		            </div>
	          	</div>
		       
		     	  
	        </div>
	        
        </div>
        
		        <style>
			        
			        
			        .cl_grp_dsh._new .VTabbedPanels{ display: none; }
			        .cl_grp_dsh._new ._c1{ width: 100% !important; border: none !important; }
			        
			        
			        .cl_grp_dsh .VTabbedPanels.mny > .TabbedPanelsTabGroup{ width: 4% !important; background-color:transparent !important; }
			        .cl_grp_dsh{ text-align: center; margin-top: 10px; display: flex; }
			        
					.cl_grp_dsh ._c{ width: 33%; }
			        .cl_grp_dsh ._c._c1{ width: 20%; } 
			        .cl_grp_dsh ._c._c1 h2{ text-align: right; } 
			        .cl_grp_dsh ._c h2{ text-align: center; } 
			        
			        .cl_grp_dsh ._c ul .itm.prm_tp{ padding: 0; margin: 0 0 10px 0; position: relative; }
			        .cl_grp_dsh ._c ul .itm.prm_tp ul{ padding: 0 0 0 30px; margin: 0; z-index: 10; }
			        .cl_grp_dsh ._c ul .itm.prm_tp h2{ display: block; position: absolute; left: 0; top: 0; padding: 10px 0; width: 35px; height: 100%; border: none; background-color: #6a6d6e; color: white; z-index: 0; writing-mode: tb-rl; line-height: 38px; font-size: 11px; font-weight: 300; text-overflow: ellipsis; border-radius: 10px 0px 0px 10px; -moz-border-radius: 10px 0px 0px 10px; -webkit-border-radius: 10px 0px 0px 10px; }
			        
					.cl_grp_dsh._new_us ._c._c2,
			        .cl_grp_dsh._new_prm ._c._c3,
			        .cl_grp_dsh._new_est ._c._c4{ width: 48%; border: none; }
			        
					.cl_grp_dsh ._c._c2 ._new_fm,
			        .cl_grp_dsh ._c._c3 ._new_fm,
			        .cl_grp_dsh ._c._c4 ._new_fm{ display: none; }
					
			        
			        .cl_grp_dsh._new_us ._c._c2 ._new_fm,
			        .cl_grp_dsh._new_prm ._c._c3 ._new_fm,
			        .cl_grp_dsh._new_est ._c._c4 ._new_fm{ display: block !important; margin-top: 60px; }
			        
			        
			        .cl_grp_dsh._new_us ._c._c2 ._ls,
			        .cl_grp_dsh._new_prm ._c._c3 ._ls,
			        .cl_grp_dsh._new_est ._c._c4 ._ls{ display: none; pointer-events: none; }
			        
			        .cl_grp_dsh._new_us ._c._c2 h2 button,
			        .cl_grp_dsh._new_prm ._c._c3 h2 button,
			        .cl_grp_dsh._new_est ._c._c4 h2 button{ display: inline-block; background-color: transparent; }
			        
			        
			        .cl_grp_dsh._new_us ._c._c3,
			        .cl_grp_dsh._new_us ._c._c4,
			        .cl_grp_dsh._new_prm ._c._c2,
			        .cl_grp_dsh._new_prm ._c._c4,
			        .cl_grp_dsh._new_est ._c._c2,
			        .cl_grp_dsh._new_est ._c._c3{ max-width: 15%; opacity: 0.4; -webkit-filter: grayscale(100%); filter: grayscale(100%); pointer-events: none; }
					
					._c2 ._ls._anm.dls .us span{ font-size: 12px; }
					._c2 ._ls._anm.dls .us p{ font-size: 11px;padding: 0;margin: 0; }

			        .cl_grp_dsh .VTabbedPanels > .TabbedPanelsTabGroup{ background-color: white !important; }
			        .cl_grp_dsh .VTabbedPanels > .TabbedPanelsTabGroup .TabbedPanelsTab{ background-repeat: no-repeat; background-position: center center; background-size: 60% auto; height: 40px; border: 1px solid #767777; opacity: 0.4; max-width: 40px; }
					.cl_grp_dsh .VTabbedPanels .TabbedPanelsTab._bsc{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>cnt_dtl.svg); }
					.cl_grp_dsh .VTabbedPanels .TabbedPanelsTabSelected._bsc{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>cnt_dtl_w.svg); }
					.cl_grp_dsh .VTabbedPanels .TabbedPanelsTab._cl_mdl_are{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>cl_are.svg); }
					.cl_grp_dsh .VTabbedPanels .TabbedPanelsTabSelected._cl_mdl_are{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>cl_are_w.svg); }
					.cl_grp_dsh .VTabbedPanels .TabbedPanelsTab._tra_col_grp{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>columns.svg); }
					.cl_grp_dsh .VTabbedPanels .TabbedPanelsTabSelected._tra_col_grp{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>columns_w.svg); }
			        .cl_grp_dsh .VTabbedPanels .TabbedPanelsTab._mdl_grp{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>modulo.svg); }
					.cl_grp_dsh .VTabbedPanels .TabbedPanelsTabSelected._mdl_grp{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>modulo_w.svg); }
		        </style>   
       
		
		         
      		</div>
    
    	</form>
    
  	</div>
</div>
<?php } ?>
<?php } ?>