<?php 
	
	
	$__avtrs = __LsDt(['k'=>'sis_avtrs']);
	$__emlcl = __LsDt(['k'=>'sis_eml', 'cl'=>$__dt_cl->id]);
	$__rnd_bsc = Gn_Rnd(20);
	
	
	foreach($__emlcl->ls->sis_eml as $__emlcl_k=>$__emlcl_v){ 
		if($__emlcl_v->admns->vl == 1){
			$__emlcl_o .= '<li eml-cl-id="'.$__emlcl_v->enc.'" eml-cl-class="'.$__emlcl_v->cls->vl.'" class="'.$__emlcl_v->cls->vl.' _anm">'.$__emlcl_v->tt.'</li>';
		}
	}
	
	foreach($__avtrs->ls->sis_avtrs as $_avtrs_k=>$_avtrs_v){								
		$__avtrs_o .= '<li class="_img _o _anm" avtr-id="'.$_avtrs_v->enc.'" style="background-image:url('.$_avtrs_v->img.');"></li>';	
	}
														
?>
<div class="eml_acc __cblq new">
	<div class="sgm">	
		
		<div class="_new_in">
			
			<div id="__crsl_bsc_<?php echo $__rnd_bsc ?>" class="owl-carousel eml-stup-in">
				<div class="item _anm" >	
					<div class="_clnt">
						<?php echo h1(TX_FMSLC) ?>
						<?php echo h2(TX_CL.' '.TT_FM_EML) ?>
						<ul><?php echo $__emlcl_o ?></ul>
					</div>
				</div>	
				<div class="item _anm" >	
					<div class="_bsc">
						<form id="acc-in_fm_<?php echo $__rnd_bsc ?>">
						<?php echo HTML_inp_tx('new_eml_nm', TX_NM, '', FMRQD, '', '_nm', '', '', 'off' ) ?>
						<?php echo HTML_inp_tx('new_eml_eml', TT_FM_EML, '', FMRQD_EM, '', '_eml', '', '', 'off' ) ?>
						</form>
					</div>
				</div>	
				<div class="item _anm" >
					<div class="_avtr">
						<?php echo h1(TX_FMSLC.' '.TX_AVTR) ?>
						<?php echo h2(TX_IDCNT) ?>
						<ul><?php echo $__avtrs_o ?></ul>	
					</div>				
				</div>		
			</div>
			<button class="_nxt _anm _o" id="eml-acc-new-next"></button>
			
		</div>	
			
		<?php 
			
			$CntJV .= '
				
				__eml_o_stup_nwin = $(".eml_acc .sgm ._new_in");
				__eml_o_stup_c = $(".eml_acc .sgm ._new_in_data");

				
				function __eml_stup_avtr(){
					$("#eml-acc-new-next").hide();
					__eml_o_stup_crsl.trigger("to.owl.carousel", 2);
					parent.$.colorbox.resize({ height:380 });	
				}
				
				
				function __eml_stup_crsl(){
					
					__eml_o_stup_crsl = $("#__crsl_bsc_'.$__rnd_bsc.'");
					
						
					SUMR_Main.ld.f.owl( function(){
						__eml_o_stup_crsl.owlCarousel({
							autoPlay: false,
							items: 1,
							autoHeight:true,
							mouseDrag:false,
							touchDrag:false,
							pullDrag:false
						});
					});
						
					
					$("#acc-in_fm_'.$__rnd_bsc.'").validate(); 
					
					
					$("#eml-acc-new-next").off("click").click(function() {  
						
						if( $("#new_eml_nm").valid() && $("#new_eml_eml").valid() ){ 
							
							SUMR_Main.scl.eml_stup["nm"] = $("#new_eml_nm").val();
							SUMR_Main.scl.eml_stup["eml"] = $("#new_eml_eml").val();     
						    __eml_stup_avtr();
						    
					    }
					});
					
					
					$("._new_in ._clnt li").off("click").click(function() {  
						
						SUMR_Main.scl.eml_stup["tp"]={};
						SUMR_Main.scl.eml_stup["tp"]["id"] = $(this).attr("eml-cl-id");
						SUMR_Main.scl.eml_stup["tp"]["cls"] = $(this).attr("eml-cl-class");
						
						if(!isN( SUMR_Main.scl.eml_stup.tp ) ){
							
							if(SUMR_Main.scl.eml_stup.tp.cls == \'imap\'){
								__eml_o_stup_crsl.trigger("to.owl.carousel", 1);
								parent.$.colorbox.resize({ height:170 });
								$("#eml-acc-new-next").show();
							}else{	
								SUMR_Main.eml.tkn({ tp:SUMR_Main.scl.eml_stup.tp.id, tpc:SUMR_Main.scl.eml_stup.tp.cls, cl:\''.DB_CL_ENC.'\', us:\''.SISUS_ENC.'\' });
								window.addEventListener(\'message\', function(e) {
									_r = e.data;

									if(!isN(_r) && !isN(_r.success) && _r.success == "ok"){
										
										if(!isN(_r._eml)){ SUMR_Main.scl.eml_stup["eml"] = _r._eml; }
										__eml_stup_avtr();	
									}
								});

							}
						}
						
					});
					
					
					$("._new_in ._avtr li").off("click").click(function() {  
						
						SUMR_Main.scl.eml_stup["avtr"] = $(this).attr("avtr-id");
						
						if(!isN( SUMR_Main.scl.eml_stup.avtr )){
							
							__eml_o_stup_c.hide();
							__eml_o_acc.removeClass("new");
							
							
							SUMR_Main.eml.rqu({
								_tp:"eml_new",	
								_nm:SUMR_Main.scl.eml_stup.nm,
								_eml:SUMR_Main.scl.eml_stup.eml,
								_tpe:SUMR_Main.scl.eml_stup.tp.id,
								_avtr:SUMR_Main.scl.eml_stup.avtr,
								_us:"'.SISUS_ENC.'",
								_bf:function(){ },
								_cmp:function(){ },
								_cl:function(__r){
									if(!isN(__r)){
										if(!isN(__r.sve) && !isN(__r.sve.e)){
											
											__eml_rqu_s(__r);
											
											if(__r.sve.e == "exist"){
												
												swal(\'Error!\', \''.TX_CRREXT.'\', \'error\');	

											}else if(__r.sve.e == "ok" && !isN(__r.sve.id) ){ 	
												
												__eml_gt_acc();

												__eml_accstup = __r.sve.enc;
												
												/*
												SUMR_Main.scl.f.pop({ 
											        t:"eml_acc",
										        	e:"on", w:700, h:400,
										        	cl:function(){	
											        	setTimeout(function(){ __eml_o_stup_c.fadeIn("fast"); }, 500);
											        	__eml_poprbld();
										        	} 
										        }); 
										        */
										        
										        swal(\''.TX_PERF.'\', \''.TX_CNXEXTB.'\', \'success\');
										        __eml_dtl({ id:__eml_accstup });
										        __eml_domrbld();
										        	
									        }
									        		
										}else{
											swal(\'Error!\', \''.TX_PRBLPRCS.'\', \'error\');
										}
									}
								},
								_w:function(){
									
								}
							});	 
					        
						}
						
					});
				
				}
				
				__eml_stup_crsl();
				
				
			';
				

			 
		?>		
		
	</div>	
</div>

<style>
	
	
	/*-------------------- NEW SETUP DESGIN --------------------*/

	.eml_acc ._new_in *{ background-repeat: no-repeat; font-family: 'Source Sans Pro'; font-weight: 400; background-repeat: no-repeat; }
	
	.eml_acc ._new_in ._o{ border-radius:200px; -moz-border-radius:200px; -webkit-border-radius:200px;}
	
	.eml_acc ._new_in{ display: none; min-height: 100px; padding: 20px 15px; }
	

	.eml_acc .sgm ._new_in{ position: relative; display: block; }
	.eml_acc .sgm ._new_in h1,
	.eml_acc .sgm ._new_in h2{ font-family: Economica; text-align: center; text-transform: uppercase; padding: 0; margin: 0;  }
	
	.eml_acc .sgm ._new_in h1{ font-size: 18px; color: #3f484a; }
	.eml_acc .sgm ._new_in h2{ font-size: 14px; color: #7b7f81; }
	
	.eml_acc .sgm ._new_in ._nxt{ background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>mail_stup_next.svg'); background-repeat: no-repeat; background-position: center center; background-size: 80% auto; border-radius:200px;
-moz-border-radius:200px; -webkit-border-radius:200px; width: 50px; height: 50px; border: none; opacity: 0.5; cursor: pointer; position: absolute; background-color: white; right: 0px; bottom: 10px; display: none; z-index: 1; }
	.eml_acc .sgm ._new_in ._nxt:hover{ opacity: 1; }
	
	.eml_acc .sgm ._new_in ._bsc{ }
	.eml_acc .sgm ._new_in ._bsc input[type=text]{ width: 100%; margin-top: 10px; text-align: center; background-repeat: no-repeat; background-position: 10px center; background-size: 20px auto; }
	.eml_acc .sgm ._new_in ._bsc input[type=text]:placeholder-shown { text-align: center !important; }
	.eml_acc .sgm ._new_in ._avtr{ display: block; }
	.eml_acc .sgm ._new_in ._bsc .___txar label.error{ position: absolute; right: 5px; top: 15px; color: #850000; font-size: 10px; text-align: right; text-transform: lowercase; }
	
	.eml_acc .sgm ._new_in ._bsc ._nm{ background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>mail_stup_nm.svg'); }
	.eml_acc .sgm ._new_in ._bsc ._eml{ background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>mail_stup_eml.svg'); }
	
	
	.eml_acc .sgm ._new_in ._avtr ul{ margin: 0; text-align: center; padding: 20px 0; }
	.eml_acc .sgm ._new_in ._avtr ul li { width: 60px; height: 60px; display: inline-block; vertical-align: top; background-size: 90% auto; background-position: center center; background-repeat: no-repeat; cursor: pointer; margin: 0; padding: 0; }
	.eml_acc .sgm ._new_in ._avtr ul li:hover{ background-size: 80% auto; }
	.eml_acc .sgm ._new_in .owl-controls{ display: none !important; }
	
	
	.eml_acc .sgm ._new_in ._clnt{  }
	.eml_acc .sgm ._new_in ._clnt ul{ list-style-type:none; padding: 20px 50px 0 50px; }
	.eml_acc .sgm ._new_in ._clnt ul li{ width: 100%; text-align: center; font-family: Economica; text-transform: uppercase; border: 1px solid #b4bcbf; font-size: 16px; margin-bottom: 10px; border-radius:7px; -moz-border-radius:7px; -webkit-border-radius:7px; padding: 10px 5px; background-repeat: no-repeat; background-size: 60px auto; background-position: -10px center; padding-left: 60px; cursor: pointer; color: #b4bcbf; }
	.eml_acc .sgm ._new_in ._clnt ul li:hover{ background-color: #ebf0f1; background-size: 50px auto; color: #5a6061; }
	
	
	
	.eml_acc .sgm ._new_in ._clnt ul li.gmail{ background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>mail_stup_gmail.svg'); }
	.eml_acc .sgm ._new_in ._clnt ul li.imap{ background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>mail_stup_imap.svg'); }
	.eml_acc .sgm ._new_in ._clnt ul li.office{ background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>mail_stup_office.svg'); }
		
		
	
</style>