<?php 
	$__id_rnd = Gn_Rnd(20);
	$__id_fm = 'FmRpr';
 	$_vl = Php_Ls_Cln($_GET['__i']);
	
	if($__t =='mdl_gen_cod_md'){  
		$__dt = GtMdlGenDt([ 't'=>'id', 'id'=>$_vl ]);
		$__mgen_p = 'g/';
		$__mgen_u = '&g=ok';
	}else{
		$__dt = GtMdlDt([ 't'=>'enc', 'id'=>$_vl ]);
	}
		
	$__dt_pml_fm = $__dt->url->fm;
	$__dt_pml_lnd = $__dt->url->lnd;

	if($___Ls->mdlstp->tp == 'sac'){
		$TraColDt = GtTraColLs([ 'flt'=>' AND tracol_chk_pqr != 1 ' ]);
		$StoreBrnd = GtStoreBrndLs();
	}

	if(!isN($__dt->id)){
?>
<div class="_fm _code_builder"> 
        <div class="wrp">  
            <div id="<?php echo $__id_fm ?>_ld" class="_ld"></div>
            <div id="<?php echo $__id_fm ?>_rsl" class="_rsl"></div>
            <div id="<?php echo $__id_fm ?>_flds">

		  		<section class="_hdr"></section>
		  		
		  		<?php echo h1($__dt->tt); ?>
		  		
		  		<div id="__url_end_<?php echo $__id_rnd; ?>" class="_cod"></div>
		  		
                <div class="_ln main_gnr">
	                <div class="opt">
				  		<div class="fm _anm"><button cnt-tp="fm" class="_anm">Iframe</button></div>	
				  		<div class="lnd _anm"><button cnt-tp="lnd" class="_anm"><?php echo TX_LNDG ?></button></div>
				  		<div class="_snd">
	                   	  <input id="Snd_CodeUrl_<?php echo $__id_rnd; ?>" name="Snd_CodeUrl_<?php echo $__id_rnd; ?>" type="submit" value="<?php echo TX_GNRR ?>">
	                    </div> 
			  		</div>
                </div>
                
                <div class="_ln _nwrp __fm_flds">
                    <div class="col_1"> 
						
						<?php if($___Ls->mdlstp->tp == 'sac'){ ?>
								
							<?php $__id_op_crs_brnd = 'opt-'.Gn_Rnd(20); ?>

							<div id="<?php echo $__id_op_crs_brnd; ?>" class="owl-carousel owl_brnd">
								<?php foreach($StoreBrnd->ls as $_k=>$_v){

									if(!isN($_v->img->th_100)){ $_img_brnd='background-image: url('.$_v->img->th_100.');'; $_cls_brnd=''; }else{ $_img_brnd=''; $_cls_brnd='empty'; }
									
									echo '										
										<div class="item _anm ls_brnd '.$_cls_brnd.'" id="brnd_'.$_v->enc.'" rel="'.$_v->enc.'" style="'.$_img_brnd.'">
											<p>'.$_v->nm.'</p>
										</div>
									';
									
								} ?>
							</div>

							<?php 
								$_owlon .= "
									setTimeout(function() {
										SUMR_Main.ld.f.owl( function(){
											$('#".$__id_op_crs_brnd."').owlCarousel({
												items:2,
												center:true
											});
											SUMR_Main.ifr.dom();
										});
									}, 700); 
								";
							?>

						<?php } ?>

                        <ul class="_opt">
                            <?php echo li(_HTML_Input('_if_cfi', 'Cloudflare Ignore','','','checkbox')); ?>
                            <?php echo li(_HTML_Input('_if_opaque', 'Dark','','','checkbox')); ?>
							<?php echo li(_HTML_Input('_if_icon', 'Icons',1,'','checkbox')); ?>
							<?php echo li(_HTML_Input('_if_nocookies', 'Cookies Ignore','','','checkbox')); ?>
							<?php echo li(_HTML_Input('_if_amp', 'AMP Code','','','checkbox')); ?>
                        </ul>    
                    </div>
                    <div class="col_2">
                        
						<?php if($___Ls->mdlstp->tp == 'sac'){ ?>
							<?php $__id_op_crs = 'opt-'.Gn_Rnd(20); ?>
							<div id="<?php echo $__id_op_crs; ?>" class="owl-carousel owl_col">
								<?php foreach($TraColDt->ls as $_k => $_v){
									echo '										
										<div class="item _anm ls_col" id="col_'.$_v->enc.'" rel="'.$_v->enc.'" style="background-color:'.$_v->clr->vl.'; background-image: url('.$_v->icn->slc->img.') ">
											<p style="color:'.$_v->clr->vl.';">'.$_v->tt.'</p>
										</div>
									';
									
								} ?>
							</div>

							<?php 
								$_owlon .= "
									setTimeout(function() {
										SUMR_Main.ld.f.owl( function(){
											$('#".$__id_op_crs."').owlCarousel({
												items:2,
												center:true
											});
											SUMR_Main.ifr.dom();
										});
									}, 500); 
								";
							?>
							
						<?php } ?>
						
						<ul class="_opt">
                            <?php echo li( HTML_inp_tx('_if_w', TX_WDTH, '100%') ); ?>
                            <?php echo li( HTML_inp_tx('_if_h', TX_HEGT, '') ); ?>
                        </ul> 

                    </div>    
                </div>
                
                <div class="_ln _nwrp __lnd_flds">                	
                	<div class="_slc">
						<?php echo LsSis_Md('_md','id_sismd', '', '', '', FM_LS_MD); $CntWb .= JQ_Ls('_md',FM_LS_MD); ?>
                    </div>
                    
                    <div class="col_1"> 
                        <ul class="_opt">
                            <?php echo li(_HTML_Input('_ky', TX_MDKYW,'','','checkbox')); ?>
                            <?php echo li(_HTML_Input('_kyc', TX_MDKYWCNC,'','','checkbox')); ?>
                            <?php echo li(_HTML_Input('_nt', TX_TRCNET,'','','checkbox')); ?>
                            <?php echo li(_HTML_Input('_crt', TX_TRCCRTV,'','','checkbox')); ?>
                        </ul>
                    </div>
                    <div class="col_2"> 
                        <ul class="_opt">
                            <?php echo li(_HTML_Input('_plc', TX_TRCPLC,'','','checkbox')); ?>
                            <?php echo li(_HTML_Input('_trg', TX_TRCTRG,'','','checkbox')); ?>
                            <?php echo li(_HTML_Input('_pst', TX_TRCADPST,'','','checkbox')); ?>
                            <?php echo li(_HTML_Input('_adg', HTML_inp_tx('_adg_id', TX_GRPAD,'') ,'','','checkbox')); ?>
                        </ul>
                    </div>
                </div>
                
    		</div>
			<?php 
	        
	        
	        if($__t =='mdl_gen_cod_md'){  }
	              
          	$CntWb .= "
					
			  	SUMR_Main.ifr = {

					o:{},
					dom:function(){
					
						$('._code_builder .owl_col .owl-item .item.ls_col').off('click').click(function(){

							var id = $(this).attr('rel'),
								hv = $(this).attr('id');

							$('._code_builder .owl_col .owl-item .item.ls_col').removeClass('ok');	
							$('#'+hv).addClass('ok');
							SUMR_Main.ifr.o.col = id;

						});

						$('._code_builder .owl_brnd .owl-item .item.ls_brnd').off('click').click(function(){

							var id = $(this).attr('rel'),
								hv = $(this).attr('id');

							$('._code_builder .owl_brnd .owl-item .item.ls_brnd').removeClass('ok');	
							$('#'+hv).addClass('ok');
							SUMR_Main.ifr.o.brnd = id;

						});
						
						$('._code_builder .main_gnr .opt button').off('click').click(function(){

							var _tpcls = $(this).attr('cnt-tp');
							
							$('#__url_end_{$__id_rnd}').hide();
							$.colorbox.resize({ height:'550px' });
							$('._code_builder').removeClass('fm lnd').addClass(_tpcls);
							{$_owlon}

						});
						
						$('#__url_end_{$__id_rnd}').off('click').click(function(){
							
							var __tcpy = $('#__url_end_{$__id_rnd} ._if_txt').val();

							SUMR_Main.cpy.cpb({ 
			  			  		_t:__tcpy,
			  			  	});
			  			  	
						});
	
						$('#Snd_CodeUrl_{$__id_rnd}').off('click').click(function(){
							
							var __md_v = $('#_md').val(),
								__mget = '&utm_campaign=',
								_if_attr='',
								_if_s_attr='',
								_if_u_attr='',
								__script='';
							
							if ( $('._code_builder').hasClass('fm') ){
								
								if ($('#_if_cfi').is(':checked')){ _if_s_attr = _if_s_attr+' data-cfasync=\"false\" '; }
								if ($('#_if_opaque').is(':checked')){ _if_attr += ' data-dark=\"ok\"'; _if_u_attr += '&opaque=ok'; }
								if ($('#_if_icon').is(':checked')){ _if_attr += ' data-icon=\"ok\"'; _if_u_attr += '&icon=ok'; }
								if ($('#_if_nocookies').is(':checked')){ _if_attr += ' data-nocook=\"ok\"'; _if_u_attr += '&cook=no'; }
								
								if(!isN(SUMR_Main.ifr.o.col)){ _if_attr = _if_attr + ' data-col=\"'+SUMR_Main.ifr.o.col+'\"'; _if_u_attr += '&_tcol='+SUMR_Main.ifr.o.col; }
								if(!isN(SUMR_Main.ifr.o.brnd)){ _if_attr = _if_attr + ' data-brnd=\"'+SUMR_Main.ifr.o.brnd+'\"'; _if_u_attr += '&_sbrnd='+SUMR_Main.ifr.o.brnd; }

								if ( !isN($('#_if_w').val()) ){ 
									t_w = $('#_if_w').val();
									_if_attr += ' data-width=\"'+t_w+'\" width=\"'+t_w+'\" '; 
								}
								if ( !isN($('#_if_h').val()) ){ 
									t_h = $('#_if_h').val();
									_if_attr += ' data-height=\"'+t_h+'\" height=\"'+t_h+'\" '; 
								}

								if ($('#_if_amp').is(':checked')){
									__script = `<amp-iframe id=\"SUMR-FM-".$__dt->enc."\" width=\"200\" height=\"200\"
													sandbox=\"allow-scripts allow-same-origin allow-modals allow-popups allow-forms\"
													layout=\"responsive\"
													frameborder=\"0\"
													resizable
													src=\"".DMN_FORM.DB_CL_FLD."/{$__mgen_p}{$__dt->enc}/?amp=ok`+_if_u_attr+`{$__mgen_u}\">
													<div overflow tabindex=0 role=button aria-label=\"\"></div>
												</amp-iframe>`;
								}else{

									__script = \"<iframe id='SUMR-FM-".$__dt->enc."' \"+_if_attr+\" ".(!isN($__mgen_p)?' data-g=\"ok\" ':"" )." frameborder='0'></iframe> 
									<script \"+_if_s_attr+\" async>
										(function(w,d,s,l){ 
											var f=d.getElementsByTagName(s)[0], j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:''; 
											j.async=true; 
											j.src= '".DMN_JS."mdl/".DB_CL_FLD."/".$__mgen_p.$__dt->enc.".js'; 
											f.parentNode.insertBefore(j,f);
										})(window,document,'script','dataLayer');
									<\/script\>\";
								}
														  
								$('#__url_end_{$__id_rnd}').html('<textarea class=\"_if_txt\" readonly=\"readonly\"></textarea>').show();

								$('._if_txt').text(`<!-- Form - SUMR CRM -->`+__script);
									
							}else{

								if($('#_ky').is(':checked')){ __mget = __mget + '&__k={keyword}'+ '&utm_term={keyword}'; }
								if($('#_kyc').is(':checked')){ __mget = __mget + '&__kc={matchtype}'; }
								if($('#_nt').is(':checked')){ __mget = __mget + '&__nt={network}'; }
								if($('#_crt').is(':checked')){ __mget = __mget + '&__crt={creative}'; }
								if($('#_plc').is(':checked')){ __mget = __mget + '&__plc={placement}'; }
								if($('#_trg').is(':checked')){ __mget = __mget + '&__trg={target}'; }
								if($('#_pst').is(':checked')){ __mget = __mget + '&__pst={adposition}'; }
								if($('#_adg_id').val()){ __mget = __mget + '&__adg='+ $('#_adg_id').val(); }

								var __md_rel = $('#_md option:selected').attr('rel'),
									__md_v_q = '_md='+__md_v,
									__url_lnd = '".$__dt_pml_lnd."?'+__md_v_q+__mget;

								__mget = __mget + '&utm_source='+__md_rel+'&utm_medium=cpc';

								$('#__url_end_{$__id_rnd}').html('<div class=\"__url\"><a href=\"'+__url_lnd+'\" target=\"_blank\">'+__url_lnd+'</a></div>').show();
								
							}
							
							/*window.open(__url, '_blank');*/
							
							$.colorbox.resize({ height:'600px' });
			  			  	$('#__url_end_{$__id_rnd} ._if_txt').select();
							
						});
					
					}
			  	};	

				SUMR_Main.ifr.dom();
					
					
			  "; ?>
            <?php /*?></form><?php */ ?>                
    	</div>
</div>
<?php }  ?>

<style>
	
	._code_builder h1{ white-space: nowrap; text-overflow: ellipsis; width: 100%; font-family: Economica; color:var(--main-bg-color); font-size: 18px; text-transform: uppercase; text-align: center; font-weight: 300; padding: 0 20px; }
	._code_builder ._hdr{ min-height: 150px; width: 100%; background-image: url('<?php echo DMN_IMG_ESTR_SVG.'mdl_cod_hdr.svg'; ?>'); background-repeat: no-repeat; background-position: center center; background-size: auto 80%; }
	._code_builder ._cod{ border: 1px solid #bfc9cd; border-radius:7px; -moz-border-radius:7px; -webkit-border-radius:7px; padding: 5px; display: none; overflow: hidden; }
	._code_builder ._cod textarea{ font-size: 11px; text-overflow: ellipsis; border: none !important; color: #a9a9a9; height: auto; min-height: 130px; }
	._code_builder ._cod .__url a:link{ text-decoration: none; font-family: Economica; color: #a19c9c; display: block; text-overflow: ellipsis; font-size: 18px; padding: 10px; overflow-wrap: break-word; word-wrap: break-word; -ms-word-break: break-all; word-break: break-all; word-break: break-word; -ms-hyphens: auto; -moz-hyphens: auto; -webkit-hyphens: auto; hyphens: auto; }
	
	._code_builder .main_gnr{ display: flex; width: 100%; text-align: center; margin-top: 20px; }
	._code_builder .main_gnr .opt{ vertical-align: top; display: inline-block; width: auto; display: flex; width: 100%; }
	._code_builder .main_gnr .opt div{ display: inline-block; vertical-align: top; text-align: center; width: 33%;  }
	._code_builder .main_gnr .opt div button{ height: 33px; width: 95%; border: 1px solid #a1a8ad; border-radius:7px; -moz-border-radius:7px; -webkit-border-radius:7px; background-repeat: no-repeat; background-size: auto 70%; background-position: left 10px center; padding-left: 40px; padding-right: 20px; text-transform: uppercase; font-family: Economica; font-size: 14px; color: #7c7f82; cursor: pointer; opacity: 0.5; }
	._code_builder .main_gnr .opt div button:hover,
	._code_builder.fm .main_gnr .opt .fm button,
	._code_builder.lnd .main_gnr .opt .lnd button{ background-color: #e2e7e8; color: #2f3234; opacity: 1; }
	
	._code_builder .main_gnr .opt .fm button{ background-image: url('<?php echo DMN_IMG_ESTR_SVG.'mdl_cod_fm.svg'; ?>'); }
	._code_builder .main_gnr .opt .lnd button{ background-image: url('<?php echo DMN_IMG_ESTR_SVG.'mdl_cod_lnd.svg'; ?>'); }
	._code_builder .main_gnr .opt ._snd input[type=submit]{ width: 95%; }
	
	
	._code_builder ._ln._nwrp{ display: none; }
	._code_builder.fm .__fm_flds{ display: block; margin-top: 30px; }
	._code_builder.lnd .__lnd_flds{ display: block; margin-top: 30px; }
	
	
	._code_builder ._ln ._opt input[type=text]{ font-size: 11px; padding: 6px 4px; border: none !important; text-align: center; background-color: transparent !important; }
	._code_builder ._ln ._slc{ display: block; width: 100%; }
	
	._code_builder ._ln .col_1{ padding: 0 20px; }
	._code_builder ._ln .col_2{ padding: 0 20px; }
					
	<?php if($___Ls->mdlstp->tp == 'sac'){ ?>

		._code_builder .owl-carousel{ margin-bottom:10px; max-width:185px; }
		._code_builder .owl-carousel .item{display: inline-block; width: 45px;height: 45px;border-radius: 56px;margin: 5px;background-repeat: no-repeat;background-position: center center; background-size: auto 40%; cursor: pointer;opacity: 0.4;}
		._code_builder .owl-carousel .item.ls_brnd{ background-size: auto 100%; }

		._code_builder .owl-carousel .item p{position: relative;top: 42px;  text-align: center; font-family: Economica;}
		._code_builder .owl-carousel .item.ls_col:hover{ background-size: auto 60%; opacity: 1; }
		._code_builder .owl-carousel .item.ls_brnd:hover{ background-size: auto 120%; opacity: 1; }

		._code_builder .owl-carousel .item.ls_col.ok{ border: 3px dashed var(--main-bg-color); opacity: 1; }
		._code_builder .owl-carousel .item.ls_brnd.ok{ opacity: 1; }

		._code_builder .owl-carousel .owl-item {height: 75px;}

	<?php } ?>	

</style>