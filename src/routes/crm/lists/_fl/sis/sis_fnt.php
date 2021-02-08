<?php
if(class_exists('CRM_Cnx')){
	
	$___Ls->sch->f = 'sisfnt_nm';
	
	$___Ls->new->w = 400;
	$___Ls->new->h = 250;
	$___Ls->edit->w = 550;
	$___Ls->edit->h = 600;
	$___Ls->_strt();

	
	if(!isN($___Ls->gt->i)){	
		 
		$___Ls->qrys = sprintf("SELECT * FROM ".TB_SIS_FNT." WHERE ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));
		
	}elseif($___Ls->_show_ls == 'ok'){	
		 
		$Ls_Whr = "FROM ".TB_SIS_FNT." WHERE ".$___Ls->ino." != '' ".$___Ls->sch->cod." ORDER BY sisfnt_nm DESC";
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
		<th width="90%" <?php echo NWRP ?>><?php echo TX_NM ?></th>
		<th width="90%" <?php echo NWRP ?>><?php echo 'Default Web' ?></th>
	    <th width="1%" <?php echo NWRP ?>></th>
	</tr>
	<?php do { 
		
			$__mnu_o = GtSisFntCl_Ls([ 'sisfnt'=>$___Ls->ls->rw['id_sisfnt'] ]);
			$__cl = ''; 
				  
			foreach($__mnu_o->ls as $_mnucl_k=>$_mnucl_v){
	
				$__cl .= '<li style="background-image:url('.$_mnucl_v->cl->img->th_50.');" 
							  alt="'.ctjTx( $_mnucl_v->cl->nm ,'in').'" 
							  title="'.ctjTx( $_mnucl_v->cl->nm ,'in').'"> </li>' ;
				
			}
		
	?>
	<tr>     
	    <td width="1%" <?php echo NWRP ?>><?php echo Spn($___Ls->ls->rw[$___Ls->ino]); ?></td>
		<td width="90%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['sisfnt_nm'],'in'),150,'Pt', true).ul($__cl, '_cl_avatar'); ?></td>
		<td width="1%" align="left" <?php echo $_clr_rw ?>><?php echo Spn(mBln($___Ls->ls->rw['sisfnt_dflt_appwb']),'',mBln($___Ls->ls->rw['sisfnt_dflt_appwb'])); ?></td> 
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

	    <div class="__cl_slc">  
		    <div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
			
		        <div class="ln_1">
		          	<div>
						  <?php echo HTML_inp_tx('sisfnt_nm', TX_NM , ctjTx($___Ls->dt->rw['sisfnt_nm'],'in'), FMRQD); ?>
						  <?php echo OLD_HTML_chck('sisfnt_dflt_appwb', 'Fuente por default (Web)', $___Ls->dt->rw['sisfnt_dflt_appwb'], 'in'); ?>
				  		<?php //echo HTML_inp_tx('lndfld_key', TX_KEY , ctjTx($___Ls->dt->rw['lndfld_key'],'in'), FMRQD); ?>
				  		
				  		
				  		<?php if(!isN($___Ls->dt->tot)){ ?>
				  		<div id="<?php echo $___Ls->fm->fld->id ?>" class="_t_wrp sisfnt_dsh_bx dsh_cnt">
				  			<?php 
					  			
					  			$__Cl = new CRM_Cl();
					  			$__Rnd = Gn_Rnd(20);
						  	$CntJV .= " 
						
								__sisfnt_bx_cl = $('#bx_cl_".$__Rnd."');
								
								function Dom_Rbld(){
									
									__sisfnt_bx_cl_itm = $('#bx_cl_".$__Rnd." li.itm.cl_fnt ');
									__sisfnt_bx_cl_fm = $('#bx_fm_cl_".$__Rnd."');
									
									__sisfnt_bx_cl_itm.not('.sch').off('click').click(function(){
										$(this).hasClass('on') ? est = 'del' : est = 'in'; 		
										var _id = $(this).attr('rel');
										_Rqu({ 
											t:'sis_fnt', 
											d:'fnt',
											est: est,
											_id_cl : _id,
											_id_fnt : '".Php_Ls_Cln($___Ls->gt->i)."',
											_bs:function(){ __sisfnt_bx_cl.addClass('_ld'); },
											_cm:function(){ __sisfnt_bx_cl.removeClass('_ld'); },
											_cl:function(_r){
												if(!isN(_r)){
													if(!isN(_r.cl)){
														ClSet(_r.cl);			
													}
												}
											} 
										});
									});			
								}
								
								function ClSisFnt_Html(){
			
									__sisfnt_bx_cl.html('');
									
									$.each(_clsisfnt['ls'], function(k, v) {
										if(v.tot > 0){ var _cls = 'on'; }else{ var _cls = 'off'; }
										if(!isN(v.img)){
											if(!isN(v.img.sm_s)){ img=v.img.sm_s; }else{ img=v.img; }
										}else{ img=''; }
										
										if(!isN(v.clr)){ var _bclr = v.clr; }else{ var _bclr = ''; }
										
										__sisfnt_bx_cl.append('<li class=\"_anm itm cl_fnt '+_cls+'\" cl-id=\"'+v.enc+'\" rel=\"'+v.enc+'\" style=\"background-color:'+_bclr+'\">
																	<figure style=\"background-image:url('+img+')\" class=\"_bg\"></figure>
																	<span>'+v.nm+'</span>
																</li>');
										
										
										
									});	
									$('#tot_cl_".$__Rnd."').html( _clsisfnt['tot'] );	
									Dom_Rbld();
								}
							";
						
							$CntJV .= "

								function ClSet(p){
									if( !isN(p) ){
										_clsisfnt = {}; 
										_clsisfnt['dt'] = {};	
										if( !isN(p.fnt) ){ _clsisfnt['ls'] = p.fnt.ls; _clsisfnt['tot'] = p.fnt.tot; }
										ClSisFnt_Html();
									}
								}		
							";
					  			
					  			
					  			$CntJV .= " 
								_Rqu({ 
									t:'sis_fnt', 
									_id_fnt : '".Php_Ls_Cln($___Ls->gt->i)."',
									_cl:function(_r){
										if(!isN(_r)){
											if(!isN(_r)){	 											
												ClSet(_r.cl);		
											}
										}
									} 
								});
								
							"; ?>
				        	
							<div class="_c _c2 _anm _scrl">
								
								<?php echo h2('<button new-tp="cl"></button> '.TX_CL); ?>
								<div class="_wrp">
							    	<ul id="bx_cl_<?php echo $__Rnd; ?>" class="_ls dls _anm"></ul>	 
							    	<div class="_new_fm" id="bx_fm_cl_<?php echo $__Rnd; ?>"></div>  
							    </div>
			
							</div>

			        
				      	</div>
				  		<?php } ?>
				  		<?php       
							/*$CntJV .= _DvLsFl_Vr([ 'i'=>$___Ls->dt->rw[$___Ls->ino], 'n'=>'_cl', 't'=>'sis_fnt_cl' ]);		  
							$CntWb .= _DvLsFl([ 'i'=>'_cl', 't'=>'s' ]);*/									
														
							/*$___Ls->_dvlsfl_all([
								['n'=>'cl', 't'=>'sis_fnt_cl', 's'=>'ok']
							]); */	
						
						?>
							
				  		<?php if($___Ls->dt->tot > 0){ ?>
			          	<div class="ln">
			                <?php echo $___Ls->tab->cl->d ?>  
			            </div> 
						<?php } ?>
						
		          	</div>
		        </div>
		    </div>
	    </div>    
    </form>
  	</div>
</div>
<style>
	
	._c{ display: inline-block; vertical-align: top; border-right: 1px solid #d0d5d8; width: 24.9%; padding-left: 15px; padding-right: 15px; position: relative; min-height: 450px; overflow-x: hidden; overflow-y: scroll; }
	
	
	.sisfnt_dsh > ._t_wrp ._c._c1,
	.sisfnt_dsh > ._t_wrp ._c._c4{ width: 20%; }
	.sisfnt_dsh > ._t_wrp ._c._c2{ width: 25%; }
	.sisfnt_dsh > ._t_wrp ._c._c3{ width: 35%; }
	
    .sisfnt_dsh._new_prm ._c._c3,
    .sisfnt_dsh._new_attr ._c._c4{ width: 48%; border: none; }
    
    .sisfnt_dsh._new_prm ._c._c3 ._ls,
    .sisfnt_dsh._new_attr ._c._c4 ._ls{ display: none; pointer-events: none; }
    
    .sisfnt_dsh._new_prm ._c._c3 h2 button,
    .sisfnt_dsh._new_attr ._c._c4 h2 button{ display: inline-block; }
    
    
    .sisfnt_dsh._new_prm ._c._c2,
    .sisfnt_dsh._new_prm ._c._c4,
    .sisfnt_dsh._new_attr ._c._c2,
    .sisfnt_dsh._new_attr ._c._c3{ max-width: 15%; opacity: 0.4; -webkit-filter: grayscale(100%); filter: grayscale(100%); pointer-events: none; }
    
    .sisfnt_dsh_bx{ text-align: center; margin-top: 10px; display: flex; }
	.sisfnt_dsh_bx ._c{ width: 90%; }
    .sisfnt_dsh_bx ._c._c1{ width: 90%; } 
    .sisfnt_dsh_bx ._c._c1 h2{ text-align: right; } 
    .sisfnt_dsh_bx ._c h2{ text-align: center; }  
    .sisfnt_dsh_bx ._c ul .itm.cl_fnt ul{ padding: 0 0 0 30px; margin: 0; z-index: 10; }
    .sisfnt_dsh_bx ._c ul .itm.cl_fnt h2{ display: block; position: absolute; left: 0; top: 0; padding: 10px 0; width: 35px; height: 100%; border: none; background-color: #6a6d6e; color: white; z-index: 0; writing-mode: tb-rl; line-height: 38px; font-size: 11px; font-weight: 300; text-overflow: ellipsis; border-radimdl: 10px 0px 0px 10px; -moz-border-radimdl: 10px 0px 0px 10px; -webkit-border-radimdl: 10px 0px 0px 10px; }

	.sisfnt_dsh_bx ._c ul .itm.cl_fnt.off {-webkit-filter: grayscale(100%);filter: grayscale(100%);opacity: 0.5;}
	.sisfnt_dsh_bx ._c ul .itm.cl_fnt.on,
	.sisfnt_dsh_bx ._c ul .itm.cl_fnt.off:hover {-webkit-filter: grayscale(100%);filter: grayscale(0%);opacity: 1;color: white;}
	
	        
</style>
<?php } ?>
<?php } ?>
