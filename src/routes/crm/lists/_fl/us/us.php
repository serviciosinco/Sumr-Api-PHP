<?php 
if(class_exists('CRM_Cnx')){

	$___Ls->new->w = 600;	
	
	if(ChckSESS_superadm()){
		$___Ls->edit->big = 'ok';
		$___Ls->edit->w = 850;
		$___Ls->edit->h = 800;
	}else{
		$___Ls->edit->w = 600;
		$___Ls->edit->h = 750;
	}

	if(ChckSESS_superadm()){
		$___Ls->new->h = 750;
	}else{
		$___Ls->new->h = 520;
	}
	
	$___Ls->ls->lmt = 200;
	$___Ls->img->dir = DMN_FLE_US;
	$___Ls->img->enc = 'ok'; 
	$___Ls->sch->f = 'us_user, us_nm, us_ap';
	$___Ls->_strt();
	
	if(!ChckSESS_superadm() && !_ChckMd('us') ){ $__fl .= ' AND id_us = 0'; }
	if(!ChckSESS_superadm()){ $__fl .= " AND us_nivel != 'superadmin' "; }

	if(!isN($___Ls->gt->i)){
		$___Ls->qrys = sprintf("SELECT * FROM "._BdStr(DBM).TB_US." WHERE ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));
	}elseif($___Ls->_show_ls == 'ok'){ 
		$__fl .= " AND id_us IN (SELECT uscl_us FROM "._BdStr(DBM).TB_US_CL.", "._BdStr(DBM).TB_CL." WHERE id_cl = uscl_cl AND cl_sbd = '".Gt_SbDMN()."') ";
		
		$Ls_Whr = "FROM "._BdStr(DBM).TB_US."
					INNER JOIN "._BdStr(DBM).TB_US_EST." ON us_est = id_usest
				    INNER JOIN "._BdStr(DBM).TB_SIS_SLC." ON us_gnr = id_sisslc
				  
				  WHERE  ".$___Ls->ino." != '' $__fl ".$___Ls->sch->cod." $__fl ORDER BY id_us DESC";
				  
		$___Ls->qrys = "SELECT *, (SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." $Ls_Whr"; 
	} 
	$___Ls->_bld();
?>
<?php if($___Ls->ls->chk=='ok'){ ?>
<?php $___Ls->_bld_l_hdr(); ?>
<?php if(($___Ls->qry->tot > 0)){ ?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
  <tr>
    <th width="1%" <?php echo NWRP ?>><?php echo TX_FM_No ?></th>
    <th width="16%" <?php echo NWRP ?>><?php echo TX_NM ?></th>
    <th width="17%" <?php echo NWRP ?>><?php echo TX_AP ?></th>
	<th width="33%" <?php echo NWRP ?>><?php echo TX_US ?></th>
	<?php if(ChckSESS_superadm()){ ?>
    	<th width="33%" <?php echo NWRP ?>><?php echo TX_AGN ?></th>
    	<th width="33%" <?php echo NWRP ?>><?php echo TX_US ?></th>
	  <?php } ?>
	<th width="1%" <?php echo NWRP ?>><?php echo TX_EST ?></th>
  	<th width="1%"></th>
  </tr>
  <?php do { ?>
  <tr >
    <td width="1%" <?php echo NWRP ?>><?php echo Spn($___Ls->ls->rw['id_us']); ?></td>
    <td width="0%" align="left" nowrap="nowrap"><?php echo Spn('','','_us_est','background-color:'.$___Ls->ls->rw['usest_clr'].';','us_est_'.$___Ls->ls->rw[$___Ls->ik]).ctjTx($___Ls->ls->rw['us_nm'],'in'); ?></td>
    <td width="0%" align="left" nowrap="nowrap"><?php echo ctjTx($___Ls->ls->rw['us_ap'],'in'); ?></td>
    <td width="33%" align="left" nowrap="nowrap">
	    <?php 
		    echo ctjTx($___Ls->ls->rw['us_user'],'in'); 
		    
		    if(ChckSESS_superadm() && !isN( $___Ls->ls->rw['us_msv_user'] )){
		    	echo HTML_BR.Spn(ctjTx($___Ls->ls->rw['us_msv_user'],'in'), '', 'msv'); 
		    }
		?>
	</td>
	<?php if(ChckSESS_superadm()){ ?>
    	<td width="33%" align="left" nowrap="nowrap"><?php echo mBln(ctjTx($___Ls->ls->rw['us_age'],'in')); ?></td>
	    <td width="33%" align="left" nowrap="nowrap">
		    <?php $__id = 'BtnUs_'.Gn_Rnd(20); ?>
		    <button id="<?php echo $__id; ?>"><?php echo TX_FZRLGN ?></button>
		    <?php 
			    $CntWb .= "
			    	$('#".$__id."').off('click').click(function(){
						SUMR_Main.lgin.frce({
				    		id:'".$___Ls->ls->rw['us_enc']."',
				    		b:function(){
					    		SUMR_Main.log.f({ m:'Before send' });	
				    		},
				    		s:function(d){
					    		if(d.e == 'ok'){
					    			swal('".TX_PRCEXT."', '".TX_CTNRCRG."', 'success'); 
					    			location.href = '/'+'?__r='+Math.random();
								}else{
									swal('".TX_ERROR."', '".TX_NSPDIN."', 'error');
								}
				    		}
						});
					});
			    ";
		    ?>  
		</td>
	<?php } ?>
	<td width="33%" align="left" nowrap="nowrap"><?php 
			echo OLD_HTML_chck('usest_chck_'.$___Ls->ls->rw[$___Ls->ik], '', $___Ls->ls->rw['us_est'], 'in', ['c'=>'usest_chck', 'attr'=>['rel'=> $___Ls->ls->rw[$___Ls->ik] ]] ); 
		?> </td>
    <td width="1%" align="left" <?php echo $_clr_rw ?> class="_btn">
	    <?php 	
		    if(_ChckMd('sis_us') || _ChckMd('us_mod')){  
	        	echo $___Ls->_btn([ 't'=>'mod' ]); 
			} 
		?>
    </td>
  </tr>
  <?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>
		<?php    
			$CntJV .= "
				$('.usest_chck').click(function() {  
					
					if($(this).is(':checked')) { var est = 'ok'; } else { var est = 'no'; }  

					var _id_us = $(this).attr('rel');
					
					swal({ 
						title: '".TX_ETSGR."',              
						text: '".TX_SWAL_SVE."!',  
						type: 'warning',                        
						showCancelButton: true,                 
						confirmButtonClass: 'btn-danger',       
						confirmButtonText: '".TX_YSV."',      
						confirmButtonColor: '#8fb360',          
						cancelButtonText: '".TX_CNCLR."',           
						closeOnConfirm: true 
					},
					function(isConfirm){ 
						
						if (isConfirm) {
							_Rqu({ 
								t:'us_mod', 
								d:'us_est',
								est: est,
								_id_us: _id_us,
								_bs:function(){ $('.Ls_Rg').addClass('_ld'); },
								_cm:function(){ $('.Ls_Rg').removeClass('_ld'); },
								_cl:function(_r){
									if(!isN(_r)){
										if(!isN(_r.e) && _r.e == 'ok'){
											$('#us_est_'+_id_us).css('background-color', _r.us.est_clr);
										}				
									}
								} 
							});
						} else {
							$('#usest_chck_'+_id_us).attr('checked',false);
						}
						
					});	    
				});	
			";
		?>
</table>
<style>
	.Ls_Rg._ld{opacity: .5;pointer-events: none;}
	table ._us_est{ display: inline-block; width: 10px; height: 10px; margin-right: 5px; margin-bottom: -2px; border-radius:200px; -moz-border-radius:200px; -webkit-border-radius:200px; }
	table span.msv::before{ display: inline-block; width: 14px; height: 14px; margin-right: 5px; margin-bottom: -4px; background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>logo_massive.svg); background-repeat: no-repeat; background-position: center center; background-size: auto 100%; -webkit-filter: grayscale(100%); filter: grayscale(100%); opacity: 0.5; }
	
	
</style>	

<?php $___Ls->_bld_l_pgs(); ?>
<?php } ?>
<?php $___Ls->_h_ls_nr(); ?>
<?php } ?>
<?php if($___Ls->fm->chk=='ok'){ ?>
<?php ?>	
<?php 

	if(ChckSESS_superadm() && $___Ls->dt->tot > 0){ 
	
		$CntJV .= " _Rqu({ 
						t:'us',
						_id_us: '".Php_Ls_Cln($___Ls->gt->i)."',
						_cl:function(_r){ 
							if(!isN(_r)){ 
								if(!isN(_r.us)){ ClSet(_r.us); } 
							} 
							NvgSpeed();
						} 
					}); "; 
	} 

?>
<div class="FmTb">
  <div id="<?php  echo DV_GNR_FM ?>" class="dsh_us <?php if($___Ls->dt->tot == 0){ echo '_new'; } if(!ChckSESS_superadm()){ echo ' -us'; } ?>">
    <form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>">
      	<?php $___Ls->_bld_f_hdr(); ?>      
	  	<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
        <?php echo bdiv(['cls'=>'bnr__cnt']); ?>
        <?php 
			$_id_tbpnl = 'TabPnl_'.Gn_Rnd(20); $CntWb .= " SUMR_Main.bxajx.".$_id_tbpnl." = new Spry.Widget.TabbedPanels('".$_id_tbpnl."'); ";
       		$__idtp_2 = '_mdl'; 
			$__idtp_3 = '_tkn';
			$__idtp_4 = '_cl';
		?> 
        <div id="<?php echo $_id_tbpnl ?>" class="TabbedPanels TbGnrl">
              <ul class="TabbedPanelsTabGroup">
                <li class="TabbedPanelsTab"><?php echo TX_DTSBSC ?></li>
                <?php if(ChckSESS_superadm() && $___Ls->dt->tot > 0){ ?> 
                <li class="TabbedPanelsTab" id="<?php echo TBGRP.$__idtp_3 ?>"><?php echo TX_USTKN ?></li>
                <?php } ?>
              </ul>
              <div class="TabbedPanelsContentGroup">
                    <div class="TabbedPanelsContent">
	                    
	                        <?php
	        
	        $__Cl = new CRM_Cl();
	        $__Rnd = Gn_Rnd(20);
			
			
			$CntJV .= " 
			
			
			var SUMR_Us = {
								us: $('#bx_us_".$__Rnd."'),
								prm: $('#bx_prm_".$__Rnd."'),
								are: $('#bx_are_".$__Rnd."'),
								mdl: $('#bx_mdl_".$__Rnd."'),
								plcy: $('#bx_plcy_".$__Rnd."'),
								
								us_fm : $('#bx_fm_us_".$__Rnd."'),
								prm_fm : $('#bx_fm_prm_".$__Rnd."'),
								are_fm : $('#bx_fm_are_".$__Rnd."'),
								
								clgrpprm: {}
								
							}; 
			
			function Dom_Rbld(){
				
				var __clgrp_bx_us_itm = $('#bx_us_".$__Rnd." > li.itm ');
				var __clgrp_bx_prm_itm = $('#bx_prm_".$__Rnd." li.itm.prm ');
				var __clgrp_bx_are_itm = $('#bx_are_".$__Rnd." > li.itm ');
				var __clgrp_bx_mdl_itm = $('#bx_mdl_".$__Rnd." > li.itm ');
				var __clgrp_bx_plcy_itm = $('#bx_plcy_".$__Rnd." > li.itm ');

				var __clgrp_bx_new = $('.cl_grp_dsh .sch button');
				var __clgrp_bx_new_bck = $('.cl_grp_dsh h2 button');
				var __clgrp_bx_new_sve = $('.cl_grp_dsh ._scrl ._new_fm button');
				
				
				
				__clgrp_bx_us_itm.not('.sch').off('click').click(function(){
					
					var est = $(this).hasClass('on') ? 'del' : 'in'; 		
					var _id = $(this).attr('rel');
					
					_Rqu({ 
						t:'us', 
						d:'cl',
						est: est,
						_id_cl : _id,
						_id_us : '".Php_Ls_Cln($___Ls->gt->i)."',
						_bs:function(){ SUMR_Us.us.addClass('_ld'); },
						_cm:function(){ SUMR_Us.us.removeClass('_ld'); },
						_cl:function(_r){
							if(!isN(_r)){
								if(!isN(_r.us)){
									ClSet(_r.us);			
								}
							}
						} 
					});
					
				});
				
				__clgrp_bx_prm_itm.not('.sch').off('click').click(function(){
					var est = $(this).hasClass('on') ? 'del' : 'in'; 		
					var _id = $(this).attr('rel');
					_Rqu({ 
						t:'us', 
						d:'prm',
						est: est,
						_id_prm : _id,
						_id_us : '".Php_Ls_Cln($___Ls->gt->i)."',
						_bs:function(){ SUMR_Us.prm.addClass('_ld'); },
						_cm:function(){ SUMR_Us.prm.removeClass('_ld'); },
						_cl:function(_r){
							if(!isN(_r)){
								if(!isN(_r.us)){
									ClSet(_r.us);			
								}
							}
						} 
					});
				});

				__clgrp_bx_are_itm.not('.sch').off('click').click(function(){
					
					var est = $(this).hasClass('on') ? 'del' : 'in'; 		
					var _id = $(this).attr('rel');
					
					_Rqu({ 
						t:'us', 
						d:'are',
						est: est,
						id_clare : _id,
						id_us : '".Php_Ls_Cln($___Ls->gt->i)."',
						_bs:function(){ SUMR_Us.are.addClass('_ld'); },
						_cm:function(){ SUMR_Us.are.removeClass('_ld'); },
						_cl:function(_r){
							if(!isN(_r)){
								if(!isN(_r.us)){
									ClSet(_r.us);			
								}
							}
						} 
					});
					
				});
				
				__clgrp_bx_mdl_itm.not('.sch').off('click').click(function(){
					
					var est = $(this).hasClass('on') ? 'del' : 'in'; 		
					var _id = $(this).attr('rel');
					
					_Rqu({ 
						t:'us', 
						d:'mdl',
						est: est,
						id_mdl : _id,
						_id_us : '".Php_Ls_Cln($___Ls->gt->i)."',
						_bs:function(){ SUMR_Us.mdl.addClass('_ld'); },
						_cm:function(){ SUMR_Us.mdl.removeClass('_ld'); },
						_cl:function(_r){
							if(!isN(_r)){
								if(!isN(_r.us)){
									ClSet(_r.us);			
								}
							}
						} 
					});
					
				});
				
				__clgrp_bx_plcy_itm.not('.sch').off('click').click(function(){
					
					var est = $(this).hasClass('on') ? 'del' : 'in'; 		
					var _id = $(this).attr('rel');
					
					_Rqu({ 
						t:'us', 
						d:'plcy',
						est: est,
						_id_plcy : _id,
						_id_us : '".Php_Ls_Cln($___Ls->gt->i)."',
						_bs:function(){ SUMR_Us.plcy.addClass('_ld'); },
						_cm:function(){ SUMR_Us.plcy.removeClass('_ld'); },
						_cl:function(_r){
							if(!isN(_r)){
								if(!isN(_r.us)){
									ClSet(_r.us);			
								}
							}
						} 
					});
					
				});
				
				
				__clgrp_bx_new.off('click').click(function(e){

					e.preventDefault();
					var _tp = $(this).attr('new-tp');
					
					if(e.target != this){
				    	e.stopPropagation(); return;
					}else{
						GrpFmBld({ t:_tp });
						$('.cl_grp_dsh').addClass('_new _new_'+_tp);
					}
			
				});
				
				
				__clgrp_bx_new_bck.off('click').click(function(e){
					e.preventDefault();
					var _tp = $(this).attr('new-tp');
					
					if(e.target != this){
				    	e.stopPropagation(); return;
					}else{
						$('.cl_grp_dsh').removeClass('_new _new_'+_tp);
					}
				});	
				
				
				__clgrp_bx_new_sve.off('click').click(function(e){
					
					e.preventDefault();
					var _tp = $(this).attr('new-tp');
					
					if(e.target != this){
				    	e.stopPropagation(); return;
					}else{

						var __data_snd = { 
								t:'us', 
								d:'new_'+_tp, 
								_id_grp : '".Php_Ls_Cln($___Ls->gt->i)."',
								_bs:function(){ _Rqu_Msg({ t:'prc' }); },
								_w:function(){ _Rqu_Msg({ t:'w' }); },
								_cl:function(_r){
									if(!isN(_r)){
										if(!isN(_r.e) && _r.e == 'ok'){
											ClSet(_r.us);	
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
				
				
				
				
				
				SUMR_Main.LsSch({ str:'#us_sch_".$__Rnd."', ls:__clgrp_bx_us_itm });
				SUMR_Main.LsSch({ str:'#prm_sch_".$__Rnd."', ls:__clgrp_bx_prm_itm });
				SUMR_Main.LsSch({ str:'#are_sch_".$__Rnd."', ls:__clgrp_bx_are_itm });
				SUMR_Main.LsSch({ str:'#mdl_sch_".$__Rnd."', ls:__clgrp_bx_mdl_itm });
				SUMR_Main.LsSch({ str:'#plcy_sch_".$__Rnd."', ls:__clgrp_bx_plcy_itm });
				
			}
			
			
			function ClGrpUs_Html(){
				
				
				SUMR_Us.us.html('');
				SUMR_Us.us.append('<li class=\"sch\">".HTML_inp_tx('us_sch_'.$__Rnd, TX_SEARCH, '')."<button class=\"_new _anm\" new-tp=\"us\"></button></li>');
				
				if(!isN(_clgrpus) && !isN(_clgrpus['ls'])){
					
					$.each(_clgrpus['ls'], function(k, v) {
						 
						if(v.tot > 0){ var _cls = 'on'; }else{ var _cls = 'off'; }
						if(!isN(v.img)){
							if(!isN(v.img.sm_s)){ img=v.img.sm_s; }else{ img=v.img; }
						}else{ img=''; }
						SUMR_Us.us.append('<li class=\"_anm itm us '+_cls+'\" us-id=\"'+v.enc+'\" rel=\"'+v.enc+'\"><figure style=\"background-image:url('+img+')\" class=\"_bg\"></figure><span>'+v.nm+'</span></li>');
					});	
					
					$('#tot_us_".$__Rnd."').html( _clgrpus['tot'] );
				
				}
				
				
				Dom_Rbld();
			}
			
			function ClGrpAre_Html(){
				
				
				SUMR_Us.are.html('');
				SUMR_Us.are.append('<li class=\"sch\">".HTML_inp_tx('are_sch_'.$__Rnd, TX_SEARCH, '')."<button class=\"_new _anm\" new-tp=\"are\"></button></li>');
				
				if(!isN(_clgrpare) && !isN(_clgrpare['ls'])){
					
					$.each(_clgrpare['ls'], function(k, v) {
						 
						if(v.tot > 0){ var _cls = 'on'; }else{ var _cls = 'off'; }
						if(!isN(v.img)){
							if(!isN(v.img.sm_s)){ img=v.img.sm_s; }else{ img=v.img; }
						}else{ img=''; }
						SUMR_Us.are.append('<li class=\"_anm itm are '+_cls+'\" us-id=\"'+v.enc+'\" rel=\"'+v.enc+'\"><figure style=\"background-image:url('+img+')\" class=\"_bg\"></figure><span>'+v.nm+'</span></li>');
					});	
					
					$('#tot_are_".$__Rnd."').html( _clgrpare['tot'] );
				
				}
				
				Dom_Rbld();
			}
			
			function ClGrpMdl_Html(){
				
				
				SUMR_Us.mdl.html('');
				SUMR_Us.mdl.append('<li class=\"sch\">".HTML_inp_tx('mdl_sch_'.$__Rnd, TX_SEARCH, '')."<button class=\"_new _anm\" new-tp=\"mdl\"></button></li>');
				
				if(!isN(_clgrpmdl) && !isN(_clgrpmdl['ls'])){
					
					$.each(_clgrpmdl['ls'], function(k, v) {
						 
						if(v.tot > 0){ var _cls = 'on'; }else{ var _cls = 'off'; }
						if(!isN(v.img)){
							if(!isN(v.img.sm_s)){ img=v.img.sm_s; }else{ img=v.img; }
						}else{ img=''; }
						SUMR_Us.mdl.append('<li class=\"_anm itm mdl '+_cls+'\" us-id=\"'+v.enc+'\" rel=\"'+v.enc+'\"><figure style=\"background-image:url('+img+')\" class=\"_bg\"></figure><span>'+v.nm+'</span></li>');
					});	
					
					$('#tot_mdl_".$__Rnd."').html( _clgrpmdl['tot'] );
				
				}
				
				Dom_Rbld();
			}
			
			function ClGrpPlcy_Html(){

				SUMR_Us.plcy.html('');
				SUMR_Us.plcy.append('<li class=\"sch\">".HTML_inp_tx('plcy_sch_'.$__Rnd, TX_SEARCH, '')."<button class=\"_new _anm\" new-tp=\"plcy\"></button></li>');
				
				if(!isN(_clgrpplcy) && !isN(_clgrpplcy['ls'])){
					
					$.each(_clgrpplcy['ls'], function(k, v) {
						 
						if(v.tot > 0){ var _cls = 'on'; }else{ var _cls = 'off'; }
						if(!isN(v.img)){
							if(!isN(v.img.sm_s)){ img=v.img.sm_s; }else{ img=v.img; }
						}else{ img=''; }
						SUMR_Us.plcy.append('<li class=\"_anm itm plcy '+_cls+'\" us-id=\"'+v.enc+'\" rel=\"'+v.enc+'\"><figure style=\"background-image:url('+img+')\" class=\"_bg\"></figure><span>'+v.nm+'</span></li>');
					});	
					
					$('#tot_plcy_".$__Rnd."').html( _clgrpplcy['tot'] );
				
				}
				
				Dom_Rbld();
			}
			
			
			
			
			function ClGrpMlt_Html(p){
				
				if(p.t == 'prm'){
					box = SUMR_Us.prm;
					nmsch = 'prm';	
					ls = _clgrpprm['ls'];
					lstot = _clgrpprm['tot'];
					tpid = 'prm-tp-id';
					idli = 'prm-id';
					cls = 'prm';
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
										
									
										if(v2.tot > 0){ var _cls = 'on'; }else{ var _cls = 'off'; }
										
										if(!isN(v2.img)){ img=v2.img; }else{ img=''; }
										
										if(p.t == 'prm'){
											var _fgr_sty = 'background-image:url('+img+')';
										}else{
											var _fgr_sty = 'background-color:'+v2.clr;
										}
										
										var __cnt = '<figure style=\"'+_fgr_sty+'\" class=\"_md\"></figure><span>'+v2.nm+'<span class=\"sub\">('+v2.vl+')</span></span>';
										
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
			
			
			/*$l_gnr = __Ls(array('k'=>'sx', 'id'=>'us_gnr', 'va'=>$___Ls->dt->rw['us_gnr'] , 'ph'=>FM_LS_SISSX)); */
			/*$l_prmtp = __Ls([ 'k'=>'mdls_tp_prm', 'id'=>'mdlstpprm_tp', 'ph'=>'-' ]);*/
			
			$CntJV .= "
			
			function GrpFmBld(p){
				
				if(p.t == 'us'){
					
					var _html = '".HTML_inp_tx('us_user', TX_US, ctjTx($___Ls->dt->rw['us_user'],'in'), FMRQD_EM)." 
		            			".HTML_inp_tx('us_nm', TX_NM, ctjTx($___Ls->dt->rw['us_nm'],'in'), FMRQD)." 
								".HTML_inp_tx('us_ap', TX_AP, ctjTx($___Ls->dt->rw['us_ap'],'in'), FMRQD).
								$l_gnr->html."<button new-tp=\"us\">".TXBT_GRDR."</button>'; 
					
					SUMR_Us.us_fm.html( _html );
					
					$l_gnr->js  
				
				}else if(p.t == 'prm'){
					
					var _html = '".LsMdlSTp('mdlstpprm_mdlstp', 'id_mdlstp', '', '', 1).
								   $l_prmtp->html.			 
				    			   HTML_inp_tx('mdlstpprm_nm', TX_NM , '', FMRQD).   	
								   HTML_inp_tx('mdlstpprm_vl', TX_KEY, '', FMRQD)."
								   <button new-tp=\"prm\">".TXBT_GRDR."</button>'; 
					
					SUMR_Us.prm_fm.html( _html );
					
					$l_prmtp->js 
					".JQ_Ls('mdlstpprm_mdlstp', FM_LS_SLTP)." 
				
				}else if(p.t == 'are'){
					
					var _html = '".HTML_inp_tx('us_user', TX_US, ctjTx($___Ls->dt->rw['us_user'],'in'), FMRQD_EM)." 
		            			".HTML_inp_tx('us_nm', TX_NM, ctjTx($___Ls->dt->rw['us_nm'],'in'), FMRQD)." 
								".HTML_inp_tx('us_ap', TX_AP, ctjTx($___Ls->dt->rw['us_ap'],'in'), FMRQD).
								$l_gnr->html."<button new-tp=\"us\">".TXBT_GRDR."</button>'; 
					
					SUMR_Us.are_fm.html( _html );
					
					$l_gnr->js  
				
				}
				
				Dom_Rbld();
			}
			
			
			function ClSet(p){
				
				if( !isN(p) ){
					
					_clgrpus = {};
					_clgrpprm = {}; 
					_clgrpare = {}; 
					_clgrpmdl = {};
					_clgrpplcy = {};
					
					_clgrpus['dt'] = {};
					_clgrpprm['dt'] = {};
					_clgrpare['dt'] = {};
					_clgrpmdl['dt'] = {};
					_clgrpplcy['dt'] = {};
					
					if( !isN(p.cl) ){ _clgrpus['ls'] = p.cl.ls; _clgrpus['tot'] = p.cl.tot; ClGrpUs_Html(); }
					if( !isN(p.prm) ){ _clgrpprm['ls'] = p.prm.ls; _clgrpprm['tot'] = p.prm.tot; ClGrpMlt_Html({ t:'prm' }); }
					if( !isN(p.are) ){ _clgrpare['ls'] = p.are.ls; _clgrpare['tot'] = p.are.tot; ClGrpAre_Html(); }
					if( !isN(p.mdl) ){ _clgrpmdl['ls'] = p.mdl.ls; _clgrpmdl['tot'] = p.mdl.tot; ClGrpMdl_Html(); }
					if( !isN(p.plcy) ){ _clgrpplcy['ls'] = p.plcy.ls; _clgrpplcy['tot'] = p.plcy.tot; ClGrpPlcy_Html(); }
						
				}
			}
			
			function NvgSpeed(){

				try{
					
					_Rqu({ 
						t:'us_nvgt', 
						thread:'us_nvgt',
						us:'".Php_Ls_Cln($___Ls->gt->i)."',
						_cl:function(_r){
							if(!isN(_r)){

								if(!isN(_r.data) && !isN(_r.ctg)){
									SUMR_Grph.f.g4({ 
										id: '#".$___Ls->fm->id." .bnr__cnt',
										d:[{ name: 'Velocidad', data: _r.data.s }, { name: 'Rtt', data: _r.data.r }],
										c: _r.ctg,
										lgnd:true,
										tt: ' ',
										tt_sb: '',
										c_e: false
									});	
								}

							}
						} 
					});
					
				}catch(e) {
					
					SUMR_Main.log.f({ t:'Error en grafica 4', m:e });

				}

				return true;

			}
				
		";
		
		if($___Ls->dt->tot > 0){

			$CntJV .= " 
				
				_Rqu({ 
					t:'cl_grp', 
					_id_grp : '".Php_Ls_Cln($___Ls->gt->i)."',
					_cl:function(_r){
						if(!isN(_r)){
							if(!isN(_r.us)){
								ClSet(_r.us);	
							}
						}
					} 
				});	
				
			";
			
		}
			
    
    ?>
	                    
	                    
	                    
                		<div class="cl_grp_dsh dsh_cnt <?php if($___Ls->dt->tot == 0){ echo '_new'; } if(!ChckSESS_superadm()){ echo ' -us'; } ?>">
                    		<div class="_c _c1 _anm">
			
								<?php if($___Ls->dt->tot > 0){ echo h2(TX_DTSBSC); } ?>
                                                           
                                <div class="sub_nw">
	                                <div class="_n1">
		                                <?php echo HTML_inp_tx('us_nm', TX_NM, ctjTx($___Ls->dt->rw['us_nm'],'in'), FMRQD); ?> 
	                                </div>
                                	<div class="_n2">
                                		<?php echo HTML_inp_tx('us_ap', TX_AP, ctjTx($___Ls->dt->rw['us_ap'],'in'), FMRQD); ?>
                                	</div>
                                	<div class="_n3">
										<?php 
											if(ChckSESS_superadm()){ 
												echo SlDt([ 'id'=>'us_fn', 'va'=>$___Ls->dt->rw['us_fn'], 'rq'=>'no', 'ph'=>TX_FCHNCM, 'lmt'=>'no', 'yr'=>'ok', 'cls'=>CLS_CLND ]);
											}else{
												echo HTML_inp_hd('us_fn', ctjTx($___Ls->dt->rw['us_fn'],'in'));
											}
										?>	
                                	</div>
                                </div>
                                
                                 
                                <div class="sub_nw">
	                                <div class="_n1">
		                                <?php 
		                                    if(ChckSESS_superadm() || $___Ls->dt->tot == 0){
												echo HTML_inp_tx('us_user', TX_US.' ('.TX_EML.')', ctjTx($___Ls->dt->rw['us_user'],'in'), FMRQD_EM, '', '', '', 'off');
		                                    	if($___Ls->dt->tot > 0 && ChckSESS_superadm()){ 
			                                    	echo HTML_inp_tx('us_msv_user', TX_US.' (Massive Space) ', ctjTx($___Ls->dt->rw['us_msv_user'],'in'));
												}else{
													echo HTML_inp_hd('us_msv_user', ctjTx($___Ls->dt->rw['us_msv_user'],'in'));
												}
			                                }else{
												echo HTML_inp_hd('us_user', ctjTx($___Ls->dt->rw['us_user'],'in')); echo h2(ctjTx($___Ls->dt->rw['us_user'],'in'));
												echo HTML_inp_hd('us_msv_user', ctjTx($___Ls->dt->rw['us_msv_user'],'in'));
		                                    } 
		                                ?> 
	                                </div> 
	                                <div class="_n2">
		                                <?php if($___Ls->dt->tot != 1){ echo '<input id="us_pass" placeholder="'.TX_PSS.'" name="us_pass" type="password" value="" '.FMRQD.' autocomplete="off"/>'; } ?> 
		                                <?php if($___Ls->dt->tot == 1){ echo LsSis_SiNo('us_pass_chn','id_sissino', $___Ls->dt->rw['us_pass_chn'], TX_FMSLC_PSSCHNG); $CntWb .= JQ_Ls('us_pass_chn',TX_FMSLC_PSSCHNG); }  ?>
		                            </div>     
	                                <div class="_n3">
										<?php 
											if(ChckSESS_superadm() || $___Ls->dt->tot == 1){ 
												echo LsUsEst('us_est','id_usest', $___Ls->dt->rw['us_est'], '', 2); $CntWb .= JQ_Ls('us_est', FM_LS_EST); 
											}else{ 
												echo HTML_inp_hd('us_est', 1); 
											}
										?>    
		                            </div> 
                                </div>
								
                            	<?php 
                                    if(!ChckSESS_superadm()){
                                    	echo HTML_inp_hd('us_age', !isN($___Ls->dt->rw['us_age'])?$___Ls->dt->rw['us_age']:2 ); 
                                    }else{
	                                  	echo LsSis_SiNo('us_age','id_sissino', $___Ls->dt->rw['us_age'], FM_LS_AGESINO); $CntWb .= JQ_Ls('us_age',FM_LS_AGESINO); 
                                    }
                                ?>
                                <?php 
                                    if(!ChckSESS_superadm()){
                                    	echo HTML_inp_hd('us_nivel', $___Ls->dt->rw['us_nivel']);	
                                    }else{
                                    	echo $_bldr->UsNvl([ 'va'=>$___Ls->dt->rw['us_nivel'] ]); 
                                    }
                                ?> 
								<?php 
									if(ChckSESS_superadm() || $___Ls->dt->tot > 0){
										$l = __Ls([ 'k'=>'sx', 'id'=>'us_gnr', 'va'=>$___Ls->dt->rw['us_gnr'] , 'ph'=>TX_SLCGNR ]); 
										echo $l->html; $CntWb .= $l->js; 
									}else{
										echo HTML_inp_hd('us_gnr', _Cns('ID_SX_N_DF'));
									}
								?>
								<?php 
									
									if($___Ls->dt->tot > 0 && ChckSESS_superadm()){ 
										echo OLD_HTML_chck('us_chk_pqr', 'Default PQR', $___Ls->dt->rw['us_chk_pqr'], 'in');
										echo OLD_HTML_chck('us_chk_tck', 'Default Ticket', $___Ls->dt->rw['us_chk_tck'], 'in');
										echo OLD_HTML_chck('us_chk_obs', 'Default Observador', $___Ls->dt->rw['us_chk_obs'], 'in'); 
									}else{
										echo HTML_inp_hd('us_chk_pqr', $___Ls->dt->rw['us_chk_pqr']);
										echo HTML_inp_hd('us_chk_tck', $___Ls->dt->rw['us_chk_tck']);
										echo HTML_inp_hd('us_chk_obs', $___Ls->dt->rw['us_chk_obs']);
									}
									
								?>
								<?php if(_ChckMd('us_mod_pssw') && $___Ls->dt->tot == 1){ ?> 
									<div>
										<a href="<?php echo VoId() ?>" class="__chngpssus"><?php echo TX_CHNCLV ?></a>
									</div>
									<?php $CntWb .= "$('.__chngpssus').colorbox({ 
														href:'".Fl_Rnd(FL_FM_GN.__t('my_pssw',true))."&_i=".$___Ls->dt->rw['us_enc'].TXGN_POP."', 
														width:'400px', 
														height:'450px', 
														slideshow:false, 
														overlayClose:false, 
														escKey:false, 
														rel: false
													});"; 
									?>
									
								<?php } ?>
								
					        </div>
					        
							<?php 
							  	$___Ls->_dvlsfl_all([
									['n'=>'us_mdl', 't'=>'mdl_us', 't2'=>'us', 'l'=>'Modulo', 'bimg'=>''],
									['n'=>'us_plcy', 'l'=>'Politicas de privacidad', 'bimg'=>''],
									['n'=>'us_tel', 't'=>'us_tel', 't2'=>'cl', 'l'=>MDL_US_TEL, 'bimg'=>''],
									['n'=>'us_grp', 't'=>'us_grp', 't2'=>'cl', 'l'=>'Grupos', 'bimg'=>'']
								]);
							?>
							<?php if($___Ls->dt->tot > 0 && ChckSESS_superadm()){ ?>
							<?php 
								$_id_tbpnl = 'TabPnl_'.Gn_Rnd(20);
								$CntWb .= " SUMR_Main.bxajx.".$_id_tbpnl." = new Spry.Widget.TabbedPanels('".$_id_tbpnl."' {$_tb_dfl}); "; 
								$CntWb .= _DvLsFl([ 'i'=>$___Ls->tb->eml ]);  
							?>
					        <div style="width: 100%;" id="<?php echo $_id_tbpnl ?>" class="VTabbedPanels TbGnrl mny tab_mdl">
					          	<ul class="TabbedPanelsTabGroup">
						            <?php echo $___Ls->tab->bsc->l ?>
						            <?php if(_ChckMd('us_mdl')){ echo $___Ls->tab->us_mdl->l; } ?> 
									<?php if(_ChckMd('us_plcy')){ echo $___Ls->tab->us_plcy->l; } ?> 
									<?php if(_ChckMd('us_tel')){ echo $___Ls->tab->us_tel->l; } ?>
									<?php if(_ChckMd('us_grp')){ echo $___Ls->tab->us_grp->l; } ?>
					          	</ul>
							  	<div class="TabbedPanelsContentGroup">
					            	<div class="TabbedPanelsContent">
										<?php if(ChckSESS_superadm()){ ?>   
										<div class="_c _c2 _anm _scrl">
									        <?php echo h2('<button new-tp="us"></button> '.TX_CL); ?>
									        <div class="_wrp">
										    	<ul id="bx_us_<?php echo $__Rnd; ?>" class="_ls _anm dls"></ul>	
										    	<div class="_new_fm" id="bx_fm_us_<?php echo $__Rnd; ?>"></div>	 
									        </div>
										</div>
										<?php } ?>
								        <div class="_c _c3 _anm _scrl">
									        <?php echo h2('<button new-tp="prm"></button>'.TX_PRM); ?>
									        <div class="_wrp">
										    	<ul id="bx_prm_<?php echo $__Rnd; ?>" class="_ls _anm dls"></ul>	
										    	<div class="_new_fm" id="bx_fm_prm_<?php echo $__Rnd; ?>"></div>   
										    </div>
								        </div>
								        <div class="_c _c4 _anm _scrl">
									        <?php echo h2('<button new-tp="are"></button> '.TX_ARE); ?>
									        <div class="_wrp">
										    	<ul id="bx_are_<?php echo $__Rnd; ?>" class="_ls _anm dls"></ul>	
										    	<div class="_new_fm" id="bx_fm_are_<?php echo $__Rnd; ?>"></div>	 
									        </div>
								        </div>   	   
									</div>
									<?php if(_ChckMd('us_mdl')){ ?>
									<div class="TabbedPanelsContent">
					                    <!--<div class="ln">
					                       <div class="_c _c2 _anm _scrl">
										        <?php echo h2('<button new-tp="mdl"></button> '.TX_MDL); ?>
										        <div class="_wrp">
											    	<ul id="bx_mdl_<?php echo $__Rnd; ?>" class="_ls _anm dls"></ul>	
											    	<div class="_new_fm" id="bx_fm_mdl_<?php echo $__Rnd; ?>"></div>	 
										        </div>
									        </div>
										</div>-->
										
										<div class="ln" style="padding-left:20px;">
											<?php echo $___Ls->tab->us_mdl->d; ?>
										</div>
										
									</div>
									<?php } ?>
									<?php if(_ChckMd('us_plcy')){ ?>
									<div class="TabbedPanelsContent">
					                     <div class="ln">
					                       <div class="_c _c2 _anm _scrl">
										        <?php echo h2('Politicas de privacidad'); ?>
										        <div class="_wrp">
											    	<ul id="bx_plcy_<?php echo $__Rnd; ?>" class="_ls _anm dls"></ul>	
											    	<div class="_new_fm" id="bx_fm_plcy_<?php echo $__Rnd; ?>"></div>	 
										        </div>
									        </div>
					                    </div> 
									</div>
									<?php } ?>
									<?php if(_ChckMd('us_tel')){ ?>
									<div class="TabbedPanelsContent">
					                    <div class="ln" style="padding-left:20px;">
											<?php echo $___Ls->tab->us_tel->d; ?>
					                    </div> 
									</div>
									<?php } ?>
									<?php if(_ChckMd('us_grp')){ ?>
									<div class="TabbedPanelsContent">
					                    <div class="ln" style="padding-left:20px;">
											<?php echo $___Ls->tab->us_grp->d; ?>
					                    </div> 
									</div>
									<?php } ?>
					          	</div>   	  
							</div>
							<?php } ?>
							
                		</div>
                    </div>
                    
                    <?php if(ChckSESS_superadm() && $___Ls->dt->tot > 0){ ?> 
                    <div class="TabbedPanelsContent">
                        <!-- Inicia Aperturas -->
                            <div class="ln">
                                <?php echo bdiv(['id'=>DV_LSFL.$__idtp_3]) ?>
                            </div> 
                       <!-- Finaliza Aperturas -->
                    </div>
					<?php } ?>
					
                    <?php       
						$CntJV .= _DvLsFl_Vr(['i'=>$___Ls->dt->rw[$___Ls->ino], 'n'=>$__idtp_2, 't'=>$___Ls->mdlstp->tp.'_mdl']);
						$CntJV .= _DvLsFl_Vr(['i'=>$___Ls->dt->rw[$___Ls->ino], 'n'=>$__idtp_3, 't'=>'us_tkn']);
						$CntJV .= _DvLsFl_Vr(['i'=>$___Ls->dt->rw[$___Ls->ino], 'n'=>$__idtp_4, 't'=>$___Ls->mdlstp->tp.'_cl']);		  
						$CntWb .= _DvLsFl(['i'=>$__idtp_2])._DvLsFl(['i'=>$__idtp_3])._DvLsFl(['i'=>$__idtp_4]); 
					?>              
              </div>
        </div>
        <style>

			.dsh_us._new .bnr__cnt,
			.dsh_us.-us .bnr__cnt{ background-image: url(<?php echo DMN_IMG_ESTR ?>cvr_us.jpg); background-size:100% auto; min-height: 150px; background-position: top center; position:relative; }
			
			.dsh_us._new .bnr__cnt::before,
			.dsh_us.-us .bnr__cnt::before{ position:absolute; left:50%; bottom:-40px; margin-left:-40px; border:1px solid red; width:80px; height:80px; border-radius:200px; -moz-border-radius:200px; -webkit-border-radius:200px; background-color:white; background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>user_new.svg); background-size: auto 100%; border:3px solid white; }
			
			.dsh_us._new .TabbedPanels{ margin-top:0 !important; }
			.dsh_us._new .TabbedPanelsTabGroup{ display:none; }

			.dsh_us._new .cl_grp_dsh._new .sub_nw{ display:block; }
			.dsh_us._new .cl_grp_dsh._new .sub_nw ._n1, 
			.dsh_us._new .cl_grp_dsh._new .sub_nw ._n2, 
			.dsh_us._new .cl_grp_dsh._new .sub_nw ._n3{ width:100% !important; }
			.dsh_us._new .dsh_cnt{ margin-top:45px; }

			.dsh_us._new input[type=text],
			.dsh_us._new input[type=password]{ text-align:center; }
			.dsh_us._new input[type=text],
			.dsh_us._new input[type=password]::-webkit-input-placeholder { text-align:center !important; }
			.dsh_us._new input[type=text],
			.dsh_us._new input[type=password]::-moz-placeholder { text-align:center !important; }
			.dsh_us._new input[type=text],
			.dsh_us._new input[type=password]:-ms-input-placeholder { text-align:center !important; }
			.dsh_us._new input[type=text],
			.dsh_us._new input[type=password]:-moz-placeholder { text-align:center !important; }

			.dsh_us._new.-us input[type=text],
			.dsh_us._new.-us input[type=password]{ font-size:1.5em; padding: 10px 0; margin-bottom:6px; }
			.dsh_us._new.-us input[type=text],
			.dsh_us._new.-us input[type=password]::-webkit-input-placeholder { font-size:1.5em; }
			.dsh_us._new.-us input[type=text],
			.dsh_us._new.-us input[type=password]::-moz-placeholder { font-size:1.5em; }
			.dsh_us._new.-us input[type=text],
			.dsh_us._new.-us input[type=password]:-ms-input-placeholder { font-size:1.5em; }
			.dsh_us._new.-us input[type=text],
			.dsh_us._new.-us input[type=password]:-moz-placeholder { font-size:1.5em; }


			.dsh_us .cl_grp_dsh{ text-align: center; margin-top: 10px; display: flex; }
			
			.dsh_us .cl_grp_dsh > ._c._c1{ margin-right:10px; } 

			.dsh_us .cl_grp_dsh ._c,
	        .dsh_us .cl_grp_dsh ._c._c1{ width: 33%; } 
	        .dsh_us .cl_grp_dsh ._c._c1 h2{ text-align: right; } 
	        .dsh_us .cl_grp_dsh ._c h2{ text-align: center; } 
	        .dsh_us .cl_grp_dsh ._c ul .itm.prm_tp{ padding: 0; margin: 0 0 10px 0; position: relative; }
	        .dsh_us .cl_grp_dsh ._c ul .itm.prm_tp ul{ padding: 0 0 0 30px; margin: 0; z-index: 10; }
	        .dsh_us .cl_grp_dsh ._c ul .itm.prm_tp h2{ display: block; position: absolute; left: 0; top: 0; padding: 10px 0; width: 35px; height: 100%; border: none; background-color: #6a6d6e; color: white; z-index: 0; writing-mode: tb-rl; line-height: 38px; font-size: 11px; font-weight: 300; text-overflow: ellipsis; border-radius: 10px 0px 0px 10px; -moz-border-radius: 10px 0px 0px 10px; -webkit-border-radius: 10px 0px 0px 10px; }
	        
			.dsh_us .cl_grp_dsh._new_us ._c._c2,
	        .dsh_us .cl_grp_dsh._new_prm ._c._c3,
	        .dsh_us .cl_grp_dsh._new_est ._c._c4{ width: 48%; border: none; }
	        
	        .dsh_us .cl_grp_dsh._new_us ._c._c2 ._ls,
	        .dsh_us .cl_grp_dsh._new_prm ._c._c3 ._ls,
	        .dsh_us .cl_grp_dsh._new_est ._c._c4 ._ls{ display: none; pointer-events: none; }  
	        .dsh_us .cl_grp_dsh._new_us ._c._c2 h2 button,
	        .dsh_us .cl_grp_dsh._new_prm ._c._c3 h2 button,
	        .dsh_us .cl_grp_dsh._new_est ._c._c4 h2 button{ display: inline-block; }
	        .dsh_us .cl_grp_dsh._new_us ._c._c3,
	        .dsh_us .cl_grp_dsh._new_us ._c._c4,
	        .dsh_us .cl_grp_dsh._new_prm ._c._c2,
	        .dsh_us .cl_grp_dsh._new_prm ._c._c4,
	        .dsh_us .cl_grp_dsh._new_est ._c._c2,
	        .dsh_us .cl_grp_dsh._new_est ._c._c3{ max-width: 15%; opacity: 0.4; -webkit-filter: grayscale(100%); filter: grayscale(100%); pointer-events: none; }  
	        
			.dsh_us .cl_grp_dsh._new ._c._c1,
			.dsh_us .cl_grp_dsh.-us ._c._c1{ width: 100%; border: none; }
			
			.dsh_us .cl_grp_dsh._new ._c._c2,
			.dsh_us .cl_grp_dsh._new ._c._c3,
			.dsh_us .cl_grp_dsh._new ._c._c4,
			.dsh_us .cl_grp_dsh._new .tab_mdl{ display: none; }
	        
			.dsh_us .cl_grp_dsh._new .sub_nw{ display: flex; vertical-align: top; }
			
			.dsh_us .cl_grp_dsh._new .sub_nw ._n1,
			.dsh_us .cl_grp_dsh._new .sub_nw ._n2,
			.dsh_us .cl_grp_dsh._new .sub_nw ._n3{ width: 33%; }
	        
	        .dsh_us .tab_mdl ul{ background-color: transparent !important; }
	        .dsh_us .tab_mdl .TabbedPanelsTab{ height: 5%; width: 5% !important; border-radius: 12px !important; margin: 7px auto !important; display: block !important; }
	        .tab_mdl.VTabbedPanels .TabbedPanelsTabGroup .TabbedPanelsTab{ background-repeat: no-repeat; background-position: center center; background-size: 60% auto; height: 40px; border: 1px solid #767777; opacity: 0.4; max-width: 40px; }
			
			.tab_mdl.VTabbedPanels .TabbedPanelsTab._bsc{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>cl_are.svg); }
			.tab_mdl.VTabbedPanels .TabbedPanelsTabSelected._bsc{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>cl_are_w.svg); }

			.tab_mdl.VTabbedPanels .TabbedPanelsTab._us_mdl{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>cl_mdlstp.svg); }
			.tab_mdl.VTabbedPanels .TabbedPanelsTabSelected._us_mdl{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>cl_mdlstp_w.svg); }

			.tab_mdl.VTabbedPanels .TabbedPanelsTab._us_plcy{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>plcy_icn.svg); }
			.tab_mdl.VTabbedPanels .TabbedPanelsTabSelected._us_plcy{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>plcy_icn_w.svg); }

			.tab_mdl.VTabbedPanels .TabbedPanelsTab._us_tel{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>cnt_tels.svg); }
			.tab_mdl.VTabbedPanels .TabbedPanelsTabSelected._us_tel{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>cnt_tels_w.svg); }

			.tab_mdl.VTabbedPanels .TabbedPanelsTab._us_grp{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>grupos.svg); }
			.tab_mdl.VTabbedPanels .TabbedPanelsTabSelected._us_grp{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>grupos_w.svg); }

        </style> 
    </form>
  </div>
</div>
<?php } ?>
<?php } ?>