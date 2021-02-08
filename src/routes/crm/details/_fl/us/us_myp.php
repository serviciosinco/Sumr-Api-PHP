<?php 
	
	
	$___us_tel = GtUsTelLs([ 'id'=>SISUS_ID ]);
	$___us_are = $___ses->GtUsAreAll([ 'us'=>SISUS_ENC ]);
	$___us_prm = $___ses->GtUsPrmAll([ 'us'=>SISUS_ENC ]);
	
?>
<div class="Cvr_MyP">
	<?php //echo h1(MDL_MYP); ?>
	<div class="cont">
		<div class="dsc">
			<div class="nm"> 
				<div class="_cvr _anm">
					<div class="_c">
						<h1><?php echo SISUS_NM.' '.Spn(SISUS_AP); ?></h1>
						<h2><?php echo SISUS_FN; ?></h2>
					</div>
				</div>
			    <div class="_ln">
					<?php $_id_tbpnl = 'TabPnl_'.Gn_Rnd(20); $CntJV .= " SUMR_Main.bxajx.".$_id_tbpnl." = new Spry.Widget.TabbedPanels('".$_id_tbpnl."', {defaultTab:0}); "; ?>
					<div id="<?php echo $_id_tbpnl ?>" class="VTabbedPanels">
							<ul class="TabbedPanelsTabGroup">
								<li class="TabbedPanelsTab"><?php echo Spn('','','_tt_icn _tt_icn_us_mdl').TX_USMDLS ?></li>
								<li class="TabbedPanelsTab"><?php echo Spn('','','_tt_icn _tt_icn_us_are').MDL_CL_ARE ?></li>
								<li class="TabbedPanelsTab"><?php echo Spn('','','_tt_icn _tt_icn_us_prm').TX_PRM ?></li>
								<li class="TabbedPanelsTab"><?php echo Spn('','','_tt_icn _tt_icn_us_info').TX_INF_PRS ?></li>
								<li class="TabbedPanelsTab"><?php echo Spn('','','_tt_icn _tt_icn_us_stup').TX_CNFG ?></li>
							</ul>
							<div class="TabbedPanelsContentGroup">
								<div class="TabbedPanelsContent">
									<div class="ln">
										<?php 	
											echo h2(TX_USMDLS .' '.Spn(TX_ASGNS));	
										?>         
									</div> 
								</div>
								<div class="TabbedPanelsContent">
									<div class="ln">
										<?php 	
											echo h2(MDL_CL_ARE .' '.Spn(TX_ASGNS));
											
											if(!isN($___us_are->o)){
												foreach($___us_are->o as $___us_are_k=>$___us_are_v){
													if(!isN($___us_are_v->tt)){
														$_li_are .= li($___us_are_v->tt);
													}
												}
												echo ul($_li_are,'_mdlstp');	
											}
											
										?>         
									</div> 
								</div>
								<div class="TabbedPanelsContent">
									<div class="ln">
										<?php 
											echo h2(TX_USMDLS.' '.Spn(TX_PRM));
											
											
											if(!isN($___us_prm)){
												foreach($___us_prm->mdl_a as $___us_prm_k=>$___us_prm_v){
													$_li_prm .= li($___us_prm_v->nm.' '.Spn($___us_prm_v->mdlstp->nm));
												}
												echo ul($_li_prm,'_mdlstp');	
											}
										
										
										?> 
									</div> 
								</div>
								<div class="TabbedPanelsContent">
									<div class="ln">
										<?php 
											echo h2(TX_PRGS.' '.Spn(TX_PRM));
										
										
										
										?> 
									</div> 
								</div>
								<div class="TabbedPanelsContent">
									<div class="ln">
										<?php     
											echo h2(TX_ESTS.Spn(TX_ASGNS));
										?> 
									</div>		
								</div>                                    
							</div>
					</div>
			
			    </div>	
			</div>
		</div>
		<div class="dtl">
			<div class="pic _anm">
				<div class="_c"></div>
				<?php 
					
					$CntWb .= "
						
						$('.Cvr_MyP .pic').addClass(SUMR_Main.us.gnr);
						
						if(!isN(SUMR_Main.us.img) && !isN(SUMR_Main.us.img.bg_s)){ 
							$('.Cvr_MyP .pic ._c').html('<img src=\"'+SUMR_Main.us.img.bg_s+'\">'); 
						}else if(!isN(SUMR_Main.us.img)){ 
							$('.Cvr_MyP .pic ._c').html('<img src=\"'+SUMR_Main.us.img+'\">'); 
						}
						
						$('.Cvr_MyP .pic').off('click').click(function(){
							_ldCnt({ 
								u:'".HTML_ClrBxImg('us').SISUS_ENC."&cll=Upd_UI({t:\'us\',e:t})', 
								pop:'ok', 
								cls:'_upl',
								pnl:{
									e:'ok',
									tp:'h'
								}
							});
						});
		
					";
					
				?> 	
			</div>
			
			<?php if(defined('SISUS_CRG') && !isN(SISUS_CRG)){ ?>
			<div class="itm itm1 _anm">
				<div class="icn icn1"></div>
				<p><?php echo SISUS_CRG; ?></p>	
			</div>
			<?php } ?>
			
			<?php if(!isN($___us_tel) && $___us_tel->tot > 0){ ?>
				<?php foreach($___us_tel->ls as $___us_tel_k=>$___us_tel_v){ ?>
					<div class="itm itm2 _anm">
						<div class="icn icn2"></div>
						<p><?php echo $___us_tel_v->telc; ?></p>
					</div>
				<?php } ?>
			<?php } ?>
			
			<!--
			<div class="itm itm3 _anm">
				<div class="icn icn3"></div>
				<p>www.example.com</p>
			</div>
			-->
			
			<div class="itm itm4 _anm">
				<div class="icn icn4"></div>
				<p><?php echo SISUS_USER; ?></p>
			</div>
			<div class="col col1"></div>
			<div class="col col2"></div>
			<div class="col col3"></div>
		</div>
	</div>						
</div>                                                                  


<style>	
		
		
	.Cvr_MyP{ }
	
	.Cvr_MyP *::after, .Cvr_MyP *::before { display:none; -webkit-transition-property: all; -moz-transition-property: all; -ms-transition-property: all; -o-transition-property: all; transition-property: all; -webkit-transition-duration: 0.4s; -moz-transition-duration: 0.4s; -ms-transition-duration: 0.4s; -o-transition-duration: 0.4s; transition-duration: 0.4s; -webkit-transition-timing-function: ease-in-out; -moz-transition-timing-function: ease-in-out; -ms-transition-timing-function: ease-in-out; -o-transition-timing-function: ease-in-out; transition-timing-function: ease-in-out; -webkit-transition-delay: 0s; -moz-transition-delay: 0s; -ms-transition-delay: 0s; -o-transition-delay: 0s; transition-delay: 0s; }
	
	/*
	.Cvr_MyP > h1{ display: block; width: 100%; font-family: Economica; text-transform: uppercase; background-color:#383839; margin:0; padding: 10px 0 15px 0; color: white; text-align: center; font-weight: 300; font-size: 20px; }
	.Cvr_MyP > h1::before{ display: inline-block; background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>tra_white.svg'); width: 20px; height: 20px; background-size: 100% auto; background-repeat: no-repeat; margin-right: 10px; margin-bottom: -2px; }
	
	*/
	
	.Cvr_MyP h2{ font-family: Economica; width: 100%; font-size: 20px; color: #666; padding-top: 0px; padding-right: 0px; padding-bottom: 10px; padding-left: 0px; border-bottom-width: 1px; border-bottom-style: solid; border-bottom-color: #999; font-weight: 300; text-transform: uppercase; margin-top: 10px; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; }
	.Cvr_MyP h2 span{ color: #999; }
	.Cvr_MyP h3{ font-family: "Roboto", Verdana !important; font-size: 10px; font-weight: normal; white-space: normal !important; text-align: right; background-color: #F0EDF2; margin: 0px; padding-top: 15px; padding-right: 10px; padding-bottom: 15px; padding-left: 10px; color: #999; }
	.Cvr_MyP ._cvr{ width: 100%; min-height: 200px; background-repeat: no-repeat; background-position: left center !important; background-size: auto 200% !important; background-attachment: initial !important; margin-top: 0 !important; background-color:#4d5152; background-image: url(<?php echo DMN_IMG_ESTR_SVG.'myp_cover.svg' ?>); position: relative; cursor: pointer; }
	.Cvr_MyP ._cvr:hover{ background-color:#27292a;  }
	.Cvr_MyP ._cvr ._c{ position: absolute; right: 20%; top: 50%; height: 60px; margin-top: -30px; line-height: 28px; font-family: Economica; font-size: 20px; color: white; text-transform: uppercase; text-align: center;}
	.Cvr_MyP ._cvr ._c h1{ padding: 0; margin: 0; font-weight: 300; }
	.Cvr_MyP ._cvr ._c h1 span{ color: #959595; }
	.Cvr_MyP ._cvr ._c h2{ padding: 0; margin: 0; border: none !important; color: #d8dadb !important; }
	
	.Cvr_MyP ._ln{ width: 100%; position: relative; display: inline-table; text-align: center; vertical-align: top; white-space: nowrap; }
	.Cvr_MyP ._ln ._c1{ display: inline-table; min-width: 30%; width: 30%; padding: 1%; vertical-align: top; margin-top: 1%; margin-right: 1%; margin-bottom: 1%; margin-left: 0%; }
	.Cvr_MyP ._ln ._c2{ display: inline-table; min-width: 30%; width: 30%; padding: 1%; margin: 1%; vertical-align: top; }
	.Cvr_MyP ._ln ._c3{ display: inline-table; min-width: 30%; width: 30%; padding: 1%; vertical-align: top; margin-top: 1%; margin-right: 0%; margin-bottom: 1%; margin-left: 1%; }
	
	
	.Cvr_MyP ._ln p{ font-size:11px; }
	.Cvr_MyP ._ln .ls_2{ margin: 0px; padding: 0px; }
	.Cvr_MyP ._ln .ls_2 li{ font-family: "Roboto", Verdana; color: #333; border-bottom-width: 1px; border-bottom-style: dotted; border-bottom-color: #CCC; list-style-type: none; font-size: 10px; text-align: left !important; width: 100% !important; display: block !important; padding-top: 5px; padding-right: 10px; padding-bottom: 5px; padding-left: 10px; }
	.Cvr_MyP ._ln .ls_2 li strong{ color: #CDCBCF; font-weight: bolder; font-family: Economica; }
	.Cvr_MyP ._ln .ls_2 li span{ color: #999; }
	
	
	
	.Cvr_MyP .VTabbedPanels { overflow: hidden; zoom: 1; width: 100%; }
	.Cvr_MyP .VTabbedPanels .TabbedPanelsTabGroup { float: left; width: 20%; height: 50em; position: relative; border-top-width: 0px; border-right-width: 0px; border-bottom-width: 0px; border-left-width: 0px; border-top-style: none; border-right-style: none; border-bottom-style: none; border-left-style: none; padding: 0px; background-color: #F1EEF0; margin: 0px; }
	.Cvr_MyP .VTabbedPanels .TabbedPanelsTabGroup ._hd{ display: none; }
	.Cvr_MyP .VTabbedPanels .TabbedPanelsTab { background-image: url(<?php echo _iEtg(DMN_IMG_ESTR.'v_tbd.png') ?>); background-repeat: no-repeat; background-position: 1000px center; position: relative; float: none; list-style: none; cursor: pointer; font-family: Economica; font-size: 1.1em; font-weight: 300; margin-top: 0px; margin-right: 1px; margin-bottom: 0px; margin-left: 0px; padding-top: 7px; padding-right: 20px; padding-bottom: 14px; padding-left: 0px; /*background-color: #FFF;*/ border-bottom-width: 1px; border-bottom-style: solid; border-bottom-color: #D3D1D5; -webkit-transition: all 0.3s ease 0s; -moz-transition: all 0.3s ease 0s; -ms-transition: all 0.3s ease 0s; -o-transition: all 0.3s ease 0s; transition: all 0.3s ease 0s; color: #999; text-align: left; }
	.Cvr_MyP .VTabbedPanels .TabbedPanelsTabSelected { border-bottom-width: 1px; border-bottom-style: solid; border-bottom-color: #333; background-position: 150px center; color: #333; }
	.Cvr_MyP .VTabbedPanels .TabbedPanelsContentGroup { clear: none; float: left; padding: 0px; width: 80%; height: 100em; }
	.Cvr_MyP .VTabbedPanels .TabbedPanelsContent{ width: 99%; padding-left: 1%; padding-right: 0% !important; }
	.Cvr_MyP .VTabbedPanels .TabbedPanelsContent .ln_1 h2,
	.Cvr_MyP .VTabbedPanels .TabbedPanelsContent > h2{ font-family: Economica; color: #CCC; font-weight: 300; margin-bottom: 15px; border-bottom-width: 1px; border-bottom-style: dotted; border-bottom-color: #CCC; padding-bottom: 15px; }
	.Cvr_MyP .VTabbedPanels .TabbedPanelsTab ._tt_icn{ margin-left: 10px; }
	
	
	
	
	.Cvr_MyP .VTabbedPanels .TabbedPanelsContent ._mdlstp{ list-style: none; padding: 0; margin: 0;}
	.Cvr_MyP .VTabbedPanels .TabbedPanelsContent ._mdlstp li{ border-bottom: 1px dashed #aaa9a9; padding: 5px 0; }
	.Cvr_MyP .VTabbedPanels .TabbedPanelsContent ._mdlstp li span{ display: inline-block; font-size: 0.8em; color: #c9c7c7; }
	
	
	.Cvr_MyP .cont{display:-ms-flex;display:-webkit-flex;display:flex;background-color: #eaeaea;}
	.Cvr_MyP .cont > .dtl{width:320px;height:940px;overflow:scroll;-webkit-box-shadow:-23px 0 31px -22px rgba(0,0,0,0.75);-moz-box-shadow:-23px 0 31px -22px rgba(0,0,0,0.75);box-shadow:-23px 0 31px -22px rgba(0,0,0,0.75);background-color: white; /*z-index: 888888888888*/ }
	.Cvr_MyP .cont > .dsc{width:100%;background-color: white;}
	/*.Cvr_MyP .cont .dsc .nm{width:100%;height:270px;text-align:right;font-size:45px;font-family:sans-serif;padding:60px 70px;box-sizing:border-box;border-bottom:2px solid #a32a25}*/
	.Cvr_MyP .cont .dtl .pic{width:100%;height:auto; min-height:200px; background-color: #121212; cursor: pointer; position: relative; border-bottom: 4px solid var(--main-bg-color); overflow: hidden; }
	.Cvr_MyP .cont .dtl .pic img{ width: 100%; background-color:#121212; }
	.Cvr_MyP .cont .dtl .pic img[src="undefined"]{ display: none; }
	
	.Cvr_MyP .cont .dtl .pic ._c:empty{ min-height: 220px !important; background-position:center center; background-size: 50% auto; background-repeat:no-repeat; border-radius:200px; -moz-border-radius:200px; -webkit-border-radius:200px; }
	.Cvr_MyP .cont .dtl .pic.w ._c:empty{ background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>myp_nopic_w.svg');  }
	.Cvr_MyP .cont .dtl .pic.m ._c:empty{ background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>myp_nopic_m.svg');  }
	.Cvr_MyP .cont .dtl .pic.n ._c:empty{ background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>myp_nopic_n.svg');  }
	.Cvr_MyP .cont .dtl .pic.n ._c{ width:50%; height:50%; position:absolute; z-index:1; left:50%; top:50%; margin-left:-25%; margin-top:-25%; }
	
	.Cvr_MyP .cont .dtl .pic::before{ z-index:10; position: absolute; width: 100%; height: 1px; cursor: pointer; display: block; left: 0; top:-100%; opacity: 0; cursor: pointer; background-image: url(<?php echo DMN_IMG_ESTR_SVG.'myp_us_uppic.svg' ?>); background-repeat: no-repeat; background-position: center center; background-size: 20% auto; }
	.Cvr_MyP .cont .dtl .pic:hover{ height: auto; -webkit-animation: _pop 0.2s ease-out; }
	.Cvr_MyP .cont .dtl .pic:hover::before{ width: 100%; height: 100%; left: 0; top: 0; background-color: rgba(0, 0, 0, 0.6); opacity: 1; }
	
	
	.Cvr_MyP .cont .dtl .itm{position: relative; height: 70px; cursor: pointer; }
	.Cvr_MyP .cont .dtl .itm:hover{ height: 80px; }
	.Cvr_MyP .cont .dtl .itm.itm1{background-color:#111112}
	.Cvr_MyP .cont .dtl .itm.itm2{background-color:#333536}
	.Cvr_MyP .cont .dtl .itm.itm3{background-color:#414445}
	.Cvr_MyP .cont .dtl .itm.itm4{background-color:var(--main-bg-color)}
	.Cvr_MyP .cont .dtl .itm .icn{width:70px;height:100%;-webkit-box-shadow:inset -23px 0 31px -22px rgba(0,0,0,0.75);-moz-box-shadow:inset -23px 0 31px -22px rgba(0,0,0,0.75);box-shadow:inset -23px 0 31px -22px rgba(0,0,0,0.75);background-repeat:no-repeat;background-size:32px;background-position:center}
	
	.Cvr_MyP .cont .dtl .itm .icn.icn1 {background-image: url(<?php echo DMN_IMG_ESTR ?>placeholder.svg);}
	.Cvr_MyP .cont .dtl .itm .icn.icn2 {background-image: url(<?php echo DMN_IMG_ESTR ?>smartphone.svg);}
	.Cvr_MyP .cont .dtl .itm .icn.icn3 {background-image: url(<?php echo DMN_IMG_ESTR ?>internet.svg);}
	.Cvr_MyP .cont .dtl .itm .icn.icn4 {background-image: url(<?php echo DMN_IMG_ESTR ?>email.svg);}
	
	.itm p {display: block;vertical-align: top;color: white;font-size: 14px;margin: 0 auto;position: absolute;top: 25px;left: 100px;width: 150px;text-align: center;}
	
	.Cvr_MyP .cont .dtl .col{background-color:#dedede;height:150px;border-top:3px solid #fff}
	
</style>


