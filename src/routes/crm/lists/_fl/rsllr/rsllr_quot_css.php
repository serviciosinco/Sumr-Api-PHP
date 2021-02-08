<style>
	
	.quote_start, .quote_detail *{ background-repeat: no-repeat; font-family: Roboto; }
	
	
	.quote_start{ width:100%; padding: 30px 20px; display: block; }
	.quote_start .steps{ display: flex; width: 100%; padding: 0; list-style: none; }
	.quote_start .steps li{ width: 33%; border: 1px dashed #a8adae; margin: 0 0.5%; text-align: center; border-radius: 10px; -moz-border-radius: 10px; -webkit-border-radius: 10px; padding: 30px 0; }
	.quote_start .steps li::before{ width: 30px; height: 30px; display: block; margin-left: auto; margin-right: auto; background-size: auto 100%; background-position: center center; }
	.quote_start .steps li.on{ animation: _puff 0.8s cubic-bezier(.5, 0, 1, 1) infinite alternate; cursor: pointer; }
	
	
	.quote_start .steps li.off{ pointer-events: none; }
	.quote_start .steps li.scss{ cursor: pointer; }
	
	.quote_start .steps li.off,
	.quote_start .steps li.scss{ opacity: 0.6; -webkit-filter: grayscale(100%); filter: grayscale(100%);  }
	
	
	.quote_start .steps li h2{ width: 100%; display: block; text-align: center; border: none; font-size: 14px; color: #c3c5c5; }
	.quote_start .steps li h2 span{ width: 100%; display: block; font-size: 25px; color: #444545; }
	.quote_start .steps li h2 step{ width: min-content; display: block; font-size: 13px; color: #fff; background-color: #c3c5c5; border-radius:10px; -moz-border-radius:10px; -webkit-border-radius:10px; margin-left: auto; margin-right: auto; padding: 5px 10px; white-space: nowrap; }
	
	
	.quote_start .steps li.sch::before{ background-image:url(<?php echo DMN_IMG_ESTR_SVG ?>rsllr_quot_sch.svg); }
	.quote_start .steps li.sve::before{ background-image:url(<?php echo DMN_IMG_ESTR_SVG ?>rsllr_quot_sve.svg); }
	.quote_start .steps li.itms::before{ background-image:url(<?php echo DMN_IMG_ESTR_SVG ?>rsllr_quot_itms.svg); }
	
	
	.quote_start:not(.sch) .isch,
	.quote_start:not(.sve) .isve,
	.quote_start.sch .steps,
	.quote_start.sve .steps{ opacity: 0; pointer-events: none; position: absolute; top: -500px; }	
	
	.quote_start .isch{ position: relative; }
	.quote_start .isch input[type=text]{ text-align: center; font-size: 40px; padding: 30px 60px 30px 10px; font-family: Economica; border-radius:20px; -moz-border-radius:20px; -webkit-border-radius:20px; }
	.quote_start .isch input[type=text]::-webkit-input-placeholder { line-height: 30px; font-size: 20px; font-weight:100; color:#949799;  }
	.quote_start .isch input[type=text]:-moz-placeholder { line-height: 30px; font-size: 20px; font-weight:100; color:#949799; }
	.quote_start .isch input[type=text]::-moz-placeholder { line-height: 30px; font-size: 20px; font-weight:100; color:#949799; }
	.quote_start .isch input[type=text]:-ms-input-placeholder { line-height: 30px; font-size: 20px; font-weight:100; color:#949799; }
	
	.quote_start.mny .isch input[type=text]{ font-size: 30px; padding: 20px 40px 20px 10px; }
	
	
	.quote_start .isch button.btn-sch{ display: block; position: absolute; right: 15px; top: 22px; border: 1px solid red; width: 70px; height: 70px; background-image: url(<?php echo _iEtg(DMN_IMG_ESTR_SVG.'ls_sch.svg') ?>); opacity: 0.4; background-repeat: no-repeat; background-position:center center; border: none; background-size: 40% auto; background-color: transparent; cursor: pointer; }
	.quote_start .isch button.btn-sch:hover{ opacity: 1; }
			
	.quote_start.mny .isch button.btn-sch{ top:16px; width: 50px; height: 50px; }
	.quote_start.__ld .isch button.btn-sch{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>mail_loader.svg); pointer-events: none; } 	
	
	
	
	
	
	
	
	.quote_start .org-found{ margin-top: 20px; margin-bottom: 20px; }
	.quote_start .org-found ._opt ._bx{ border:none; cursor: pointer; pointer-events: none; }
	
	.quote_start .org-found ._opt ._bx figure{ width: 120px; height: 120px;  margin-left: auto; margin-right: auto; margin-top: 10px; border-radius:200px; -moz-border-radius:200px; -webkit-border-radius:200px; border: 2px solid #f2f4f5; position: relative; pointer-events: none; }
	.quote_start .org-found ._opt ._bx figure img{ width: 105px; height: 105px; border-radius:200px; -moz-border-radius:200px; -webkit-border-radius:200px; background-repeat: no-repeat; background-position: center center; background-size:contain; position: absolute; left: 5.5px; top: 5.5px; overflow: hidden; pointer-events: none; }
	
	
	.quote_start .org-found ._opt{ cursor: pointer; }
	.quote_start .org-found ._opt h3{ font-size: 14px !important; font-family: Economica !important; width: 100%; padding: 0; margin: 5px 0 0 0 !important; border: 0 !important; color: #565252 !important; font-weight: 300 !important; }
	.quote_start .org-found ._opt:not(.mre):hover ._bx figure{ border-color:var(--main-bg-color);  }
	
	
	.quote_start .org-found ._opt ._bx figure._non img{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>ec_broken.svg); background-color: #bfc3c5; background-size: 50% auto; opacity: 0.2; }
	
	.quote_start .org-found ._opt ._bx figure ._dtl{ width: 30px; height: 30px; background-color: white; position: absolute; bottom: -100px; right: 0; border-radius:200px; -moz-border-radius:200px; -webkit-border-radius:200px; background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>ls_detail.svg); background-repeat: no-repeat; background-position: center center; background-size: 60% auto; border: 2px solid #adaaaa; opacity: 0; pointer-events: none; }
	.quote_start .org-found ._opt:hover ._bx figure ._dtl{ opacity: 1; pointer-events: all; bottom: 0; right: 0; }
	.quote_start .org-found ._opt ._bx figure ._dtl:hover{ background-size: 50% auto; border-color:var(--main-bg-color); }
	.quote_start .org-found ._opt._slct ._bx figure{ border-color:var(--main-bg-color); }
	
	.quote_start .org-found ._opt ._bx h2{ font-weight: 700; margin:0; padding: 0; border: none; text-align: center; font-family:Economica; font-size: 14px; text-overflow: ellipsis; margin-top: -10px; font-size: 12px; width: 100%; margin-left: auto; margin-right: auto; background-color:var(--second-bg-color); color: white; border-radius:10px; -moz-border-radius:10px; -webkit-border-radius:10px; font-size: 11px; padding: 5px 7px; white-space: nowrap; text-overflow: ellipsis; }
	.quote_start .org-found ._opt ._bx h2 span._sds{ display: block; width: 100%; font-size: 0.9em; font-weight: 300; }
	.quote_start .org-found ._opt ._bx h2 span._cd{ display: block; width: 100%; font-size: 0.8em; font-weight: 300; }
	
	
	.quote_start .org-found ._opt.tt ._bx{ background-color: #e5e8e8; height: 150px; }
	.quote_start .org-found ._opt ._bx h1.__tt{ border: none; line-height: 20px; padding-top: 30px; }
	.quote_start .org-found ._opt ._bx h1.__tt span{ font-size: 17px; color: #8c9595;  }
	
	
	.quote_start .org-found ._opt ._bx ._tp:empty{ display: none; }
	.quote_start .org-found ._opt ._bx ._tp{ position: absolute; top: 0; right: 0; }
	.quote_start .org-found ._opt ._bx ._tp ul{ padding: 0; margin: 0; list-style: none; display: flex; }
	.quote_start .org-found ._opt ._bx ._tp ul li{ margin-right: auto; border-radius:200px; -moz-border-radius:200px; -webkit-border-radius:200px; width: 35px; height: 35px; background-color: #dfe6e6;  border:3px solid white; margin-left:4px; background-position: center center; background-size: auto 50%; background-repeat: no-repeat; overflow: hidden; text-indent: -1000px; }
	
	
	.quote_start .org-found ._opt.sch{ height: 100px; }
	.quote_start .org-found ._opt.sch ._bx figure{ margin-top: 30px; width: 50px; height: 50px; background-repeat: no-repeat; background-position: center center; background-size:contain; margin-left: auto; margin-right: auto; border-radius:200px; -moz-border-radius:200px; -webkit-border-radius:200px; background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>ec_sch.svg); background-size: 70% auto; opacity: 0.2; border: 2px solid #b0aeae; position: relative; }
	.quote_start .org-found ._opt.sch:hover ._bx figure{ background-size: 50% auto; opacity: 1 !important; }
	

	
	.quote_start .org-found ._opt.empty{ border:none !important; height: 120px; }
	.quote_start .org-found ._opt.empty ._bx figure{ border: none !important; margin-top: 40px; width: 40px; height: 40px; opacity: 0.2; }




	
	
	
	
	
	
	
	
	
	.quote_start .isve{ position: relative; }
	.quote_start .isve input[type=text]{ text-align: center; font-size: 40px; padding: 30px 60px 30px 10px; font-family: Economica; border-radius:20px; -moz-border-radius:20px; -webkit-border-radius:20px; }
	.quote_start .isve input[type=text]::-webkit-input-placeholder { line-height: 30px; font-size: 20px; font-weight:100; color:#949799;  }
	.quote_start .isve input[type=text]:-moz-placeholder { line-height: 30px; font-size: 20px; font-weight:100; color:#949799; }
	.quote_start .isve input[type=text]::-moz-placeholder { line-height: 30px; font-size: 20px; font-weight:100; color:#949799; }
	.quote_start .isve input[type=text]:-ms-input-placeholder { line-height: 30px; font-size: 20px; font-weight:100; color:#949799; }	
	
	.quote_start .isve button.btn-sve{ display: block; position: absolute; right: 15px; top: 22px; border: 1px solid red; width: 70px; height: 70px; background-image: url(<?php echo _iEtg(DMN_IMG_ESTR_SVG.'ls_sve.svg') ?>); opacity: 0.4; background-repeat: no-repeat; background-position:center center; border: none; background-size: 40% auto; background-color: transparent; cursor: pointer; }
	.quote_start .isve button.btn-sve:hover{ opacity: 1; }
	.quote_start.__ld .isve button.btn-sve{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>mail_loader.svg); pointer-events: none; } 	
	
	
	
	
	
	
	
	.quote_detail{ width:100%; margin-left: auto; margin-right: auto; padding: 30px 0px 100px 0px; display: flex; }
	
	
	.quote_detail h1,
	.quote_detail h2,
	.quote_detail h3{ margin: 0; padding: 0; }
	
	.quote_detail .__slc_ok{ display: flex; font-family: Economica; text-transform: uppercase; font-size: 16px; font-weight: 300; padding-top: 10px; padding-bottom: 10px; padding-right: 0; }	
	.quote_detail .__slc_ok span._icn{ width: 25px; height: 25px; display: inline-block; margin-bottom: -3px; margin-right: 10px; background-size: auto 90%; background-position: center center; }
	.quote_detail .__slc_ok span._mre{ width: 16px; height: 16px; display: inline-block; margin-bottom: -1px; margin-left: 6px; background-size: auto 90%; background-position: center center; background-image:url(<?php echo DMN_IMG_ESTR_SVG ?>rsll_mre.svg); cursor: pointer; }
	.quote_detail .__slc_ok span._mre:hover{ background-size: auto 80%; }
	
	.quote_detail .__slc_ok h3,
	.quote_detail .__slc_ok .__slc{ width: 50% !important; }
	
	
	.quote_detail .__slc_ok h3 span.tt{ font-family: Economica; color: #484b4e; font-weight: 400; font-size: 14px; }
	
	.quote_detail .__slc_ok .prc{ font-family: Economica; font-size: 16px; margin: 0; text-align: left; font-weight: 500; font-family: Economica; display: inline-block; margin-left: 6px; margin-right: 6px; color:#c0c4c5; }

	
	.quote_detail .itms{ width: 65%; vertical-align: top; }
	.quote_detail .itms .bsnss_lne { padding: 0; margin: 0; list-style: none; padding-left: 30px; }
	
	.quote_detail .itms .bsnss_lne > li{ position: relative; }
	.quote_detail .itms .bsnss_lne > li .bx_qty{ position: absolute; top: 0; right: 75px; width: 120px; padding-top: 6px; text-align: center; display: none; }
	.quote_detail .itms .bsnss_lne > li .bx_qty input[type=text]{ text-align: center; width: 100%; font-size: 12px; }
	
	.quote_detail .itms .bsnss_lne > li .bx_qty input[type=text]::-webkit-input-placeholder,
	.quote_detail .itms .bsnss_lne > li .bx_qty input[type=text]:-moz-placeholder,
	.quote_detail .itms .bsnss_lne > li .bx_qty input[type=text]::-moz-placeholder,
	.quote_detail .itms .bsnss_lne > li .bx_qty input[type=text]:-ms-input-placeholder,
	.quote_detail .itms .bsnss_lne > li .bx_qty input[type=text]::-ms-input-placeholder{ text-align: center; }

	.quote_detail .itms .bsnss_lne > li._us{ border-bottom: 1px solid #CCC; display: block; width: 100%; position: relative; padding: 15px 0 20px 0; }
	.quote_detail .itms .bsnss_lne > li._us ._tt{ font-family: Economica; font-size: 25px; text-transform: uppercase; color: #171515; }
	.quote_detail .itms .bsnss_lne > li._us ._tt::before{ display: inline-block; width: 25px; height: 25px; margin-bottom: -6px; margin-right: 10px; background-image:url(<?php echo DMN_IMG_ESTR_SVG ?>myp_us_info.svg); background-size: auto 100%; background-position: center center; background-repeat: no-repeat; }
	
	.quote_detail .itms .bsnss_lne > li._us .___txar{ position: absolute; right: 0; top: 0; }
	.quote_detail .itms .bsnss_lne > li._us .___txar input[type=text]{ text-align: center; }
	
	.quote_detail .itms .bsnss_lne > li.on .bx_qty{ display: block; }
	
	
	.quote_detail .total{ width: 35%; vertical-align: top; padding-top: 50px; }
	.quote_detail .total .plan_dsc{ border-radius: 10px 10px 0px 0px; -moz-border-radius: 10px 10px 0px 0px; -webkit-border-radius: 10px 10px 0px 0px; overflow: hidden; width: 80%; margin-left: auto; /*margin-right: auto;*/ border-bottom: 2px solid var(--second-bg-color); position: sticky; top: 20px; }
	.quote_detail .total .plan_dsc .hdr{ background-color: #2b2b33; border-bottom: 2px solid var(--second-bg-color); padding: 0 0 20px 0; }
	
	
	.quote_detail .total .plan_dsc .hdr .org{ background-color:<?php echo $_org_dt->org->clr; ?>; padding-top: 20px; padding-bottom: 20px; margin-bottom: 20px; }
	.quote_detail .total .plan_dsc .hdr .org figure{ position: relative; min-height: 100px; }
	.quote_detail .total .plan_dsc .hdr .org figure::before,
	.quote_detail .total .plan_dsc .hdr .org figure::after{ width: 20%; height: 1px; position: absolute; top: 50px; background-color: #fff; z-index: 1; }
	.quote_detail .total .plan_dsc .hdr .org figure::before{ left: 0; }
	.quote_detail .total .plan_dsc .hdr .org figure::after{ right: 0; }
	.quote_detail .total .plan_dsc .hdr .org h1{ font-family: Economica; color: white; text-transform: uppercase; font-size: 20px; font-weight: 700; display: block; width: 100%; border: none; }
	.quote_detail .total .plan_dsc .hdr .org h1 span{ font-size: 0.7em; opacity: 0.5; display: block; width: 100%; font-family: Economica; }
	.quote_detail .total .plan_dsc .hdr .org h2{ font-family: Economica; color: white; font-size: 14px; font-weight: 300; display: block; width: 100%; border: none; text-align: center; }
	
	.quote_detail .total .plan_dsc .hdr .org figure .clogo{ margin-left: auto; margin-right: auto; width: 100px; height: 100px; background-color: white; border-radius:200px; -moz-border-radius:200px; -webkit-border-radius:200px; background-repeat: no-repeat; background-position: center center; background-size: auto 60%; z-index: 2; position: relative; }
	.quote_detail .total .plan_dsc .hdr .org figure .clogo .cflag{ width:20px; height:20px; border-radius:200px; -moz-border-radius:200px; -webkit-border-radius:200px; overflow: hidden; background-repeat: no-repeat; background-position: center center; background-size:contain; z-index: 2; position: absolute; right: 14px; bottom: -2px; }
	
	.quote_detail .total .plan_dsc .hdr .nm{ font-family: Economica; font-size: 32px; font-weight: 700; color: #fff; text-transform: uppercase; width: 100%; display: block; text-align: center; }
	
	
	
	
	.quote_detail .total .plan_dsc .hdr .psos{ text-align: center; width: 80%; margin-left: auto; margin-right: auto; font-family: Economica; font-size: 25px; font-weight: 300; color: #fff; text-transform: uppercase; }
	.quote_detail .total .plan_dsc .hdr .psos span{ font-size: 14px; font-weight: 300; opacity: 0.5; text-transform: lowercase; }
	
	.quote_detail .total .plan_dsc .rsllr_itms{ list-style: none; margin: 0; padding: 0; }
	.quote_detail .total .plan_dsc .rsllr_itms li { background-color: #fff; font-size: 14px; font-weight: 300; padding: 10px 0; text-align: center; color: #6f6c6c; }
	.quote_detail .total .plan_dsc .rsllr_itms li:nth-child(odd) { background-color: #f4f4f4; }
	.quote_detail .total .plan_dsc .rsllr_itms li ._qty{ font-size: 11px; color: #817e7e; }
	.quote_detail .total .plan_dsc .rsllr_itms li._us{  }
	.quote_detail .total .plan_dsc .rsllr_itms li._us span{ font-size: 11px; color: #817e7e; }
	.quote_detail .total .plan_dsc .rsllr_itms li._us strong{ display: block; width: 100%; }
	.quote_detail .total .plan_dsc .rsllr_itms li i{ font-size: 11px; color: var(--main-bg-color); display: block; width: 100%; }
	.quote_detail .total .plan_dsc .rsllr_itms li strong{ width: 100%; display: block; }
	
	
	
	
	
	
	
	
	
	.quote_detail .VTabbedPanels.mny._new > ul.TabbedPanelsTabGroup{ display: none; }
	.quote_detail .VTabbedPanels.mny._new > div.TabbedPanelsContentGroup{ width: 100%; border: none; }
  	
  	.quote_detail .VTabbedPanels.mny{ display: flex; }	
    .quote_detail .VTabbedPanels.mny > ul.TabbedPanelsTabGroup{ background-color: white; width:45px !important; }
    .quote_detail .VTabbedPanels.mny > div.TabbedPanelsContentGroup{ border-left: 1px dotted #bcbfbf; }
    .quote_detail .VTabbedPanels.mny > div.TabbedPanelsContentGroup .TabbedPanelsContent{ padding-top: 30px; }
    .quote_detail .VTabbedPanels.mny > div.TabbedPanelsContentGroup .TabbedPanelsContent._main{ padding-top: 0; }
    
    
    .quote_detail .VTabbedPanels .Tt_Tb .btn{ margin-right: 0 !important; }
    .quote_detail .VTabbedPanels .TabbedPanelsTab{ background-size: 60% auto; background-position: center center; min-height: 35px; min-width: 35px; max-width: 35px; background-repeat: no-repeat; opacity: 0.3; } 
    .quote_detail .VTabbedPanels .TabbedPanelsTabSelected,
    .quote_detail .VTabbedPanels .TabbedPanelsTabHover{ opacity: 1; background-color: white !important; }
    
    .quote_detail .VTabbedPanels .TabbedPanelsTab._bsc{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>atmt_main.svg); }
    .quote_detail .VTabbedPanels .TabbedPanelsTab._mdl{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>atmt_mdl.svg); }

    
    .quote_detail .Tt_Tb{ padding-left: 20px; }
				        
				        
	
	
	
	
	
	
	
	
	
	
	
	
</style>
