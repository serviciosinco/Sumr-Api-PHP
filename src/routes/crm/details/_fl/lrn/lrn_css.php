<style>
	.Cvr_Dcs ._lrn_ls .CollapsiblePanel {
	     margin: 0;
	     padding: 0;
	     background:#525a5e;
	}
	
	.Cvr_Dcs ._lrn_ls .CollapsiblePanelTab {
	     font: bold .7em sans-serif;
	     cursor: pointer !important;
	     -moz-user-select: none;
	     -khtml-user-select: none;
	     margin: 0;
	     border-bottom-width: 1px;
	     border-bottom-style: solid;
	     border-bottom-color: #b4abab;
	     text-align: left;
	     padding: 10px 0 20px 20px;
	     font-family: Economica;
	     text-align: left;
	     font-size: 18px;
	     color:white;
	}
	
	.Cvr_Dcs ._lrn_ls .CollapsiblePanelTab span{
	     float: right;
	     color: #999;
	     font-size: 12px;
	}
	
	
	.Cvr_Dcs ._lrn_ls .CollapsiblePanelTab:first-child {
		
		padding-top: 30px;
		
	}
	
	
	.Cvr_Dcs ._lrn_ls .CollapsiblePanelContent {
	     margin: 0;
	     background-color: #F3F2F4;
	     padding-top: 15;
	     padding-right: 0;
	     padding-bottom: 15;
	     padding-left: 0;
	     text-align: center;
	     font-family: Economica;
	     height: 100%!important;
	}
	.Cvr_Dcs ._lrn_ls .CollapsiblePanelContent table td{
	     font-size: 11px;
	     font-weight: normal;
	     color: #999;
	     padding-left: 20px;
	     border-bottom-width: 1px;
	     border-bottom-style: dotted;
	     border-bottom-color: #CCC;
	     padding-top: 2px;
	     padding-bottom: 2px;
	}
	.Cvr_Dcs ._vd{
	     display: block;
	     padding: 15px 0 20px 15px;
	     cursor: pointer;
	     color: #50595c;
	     border-bottom: 2px solid white;
	     text-align: left;
	     text-decoration: none;
	     white-space: nowrap;
	     text-overflow: ellipsis;
	     font-family:Work Sans; 
	     font-weight:300; 
	     font-size: 11px;
	}
	.Cvr_Dcs ._vd:hover{
		background-color: rgb(210, 208, 208)!important;	
	}
	
	.Cvr_Dcs ._vd:Hover{
	     color:#6d6a6a;
	}
	.Cvr_Dcs ._lrn_ls .CollapsiblePanelContent table tr:hover td{
	     color: #000;
	     border-bottom-color: #0FF;
	     cursor: pointer;
	}
	.Cvr_Dcs ._lrn_ls .CollapsiblePanelTab a {
	     color: #6d6a6a;
	     text-decoration: none;
	}
	.Cvr_Dcs ._lrn_ls .CollapsiblePanelOpen ._lrn_ls .CollapsiblePanelTab {
	     background-color: #EEE;
	}
	.Cvr_Dcs ._lrn_ls .CollapsiblePanelTabHover, ._lrn_ls .CollapsiblePanelOpen ._lrn_ls .CollapsiblePanelTabHover {
	     border-bottom-width: 1px;
	     border-bottom-style: solid;
	     border-bottom-color: #6d6a6a;
	     color: #BFBABA;
	}
	.Cvr_Dcs ._lrn_ls .CollapsiblePanelTabHover span{
	     color: #000;
	}
	.Cvr_Dcs ._lrn_ls .CollapsiblePanelFocused ._lrn_ls .CollapsiblePanelTab {
	}
	.Cvr_Dcs._lrn_ls ._tot{
	     color: #FFF;
	     background-color: #0CF;
	     font-size: .7em;
	     text-align: left;
	     padding-top: 15px;
	     padding-bottom: 15px;
	     padding-left: 10px;
	     padding-right: 10px;
	}
	.Cvr_Dcs ._lrn_ls ._tot span{
	     float: right;
	     color: #FFF;
	     font-size: 14px;
	}
	.Cvr_Dcs ._lrn_cmnt{
	     width: 30px;
	     background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>cmnt.svg');
	     height: 30px;
	     background-repeat: no-repeat;
	     background-size: 30px;
	     margin: auto;
	     display: none;
	     margin-top: 2%;
	     cursor: pointer;
	     right: 7%;
	     position: absolute;
	     -webkit-transition: all 1s ease;
	    -moz-transition: all 1s ease;
	    -ms-transition: all 1s ease;
	    -o-transition: all 1s ease;
	    transition: all 1s ease;
	    z-index: 9999;
	}
	.Cvr_Dcs ._lrn_cmnt:Hover{
	     opacity: 0.7;
	}
	.Cvr_Dcs ._lrn_dv{
	     min-height: 500px;
	     width: 100%;
	     display: flex;
	}
	.Cvr_Dcs ._lrn_ls{
	     width: 20%;
	     height: 100%;
	     border: none;
	     display: inline-block;
	     vertical-align: top;
	     overflow: scroll;
	}
	.Cvr_Dcs ._lrn_vd{
	     width: 80%;
	     height: 100%;
	     display: inline-block;
	}
	
	.Cvr_Dcs ._lrn_vd ._intro{
		
	}
	
	.Cvr_Dcs ._lrn_vd ._intro ._p{
		display: flex;
		padding-bottom: 100px;
	}
	
	.Cvr_Dcs ._lrn_vd ._intro ._p ._c{
		vertical-align: top;
		min-height: 200px;
		width: 33.3%;
		font-size: 11px; font-family: Work Sans, Roboto, Tahoma;
		padding: 40px 50px 20px 50px;
		color: #64757b;
	}
	
	
	.Cvr_Dcs ._lrn_vd ._intro ._p ._c h2{ font-weight: 500; font-size: 23px; border: none; text-align: center; color: #0e0e0e; }
	
	.Cvr_Dcs ._lrn_vd ._intro ._p ._c ._img{ width: 100px; height: 100px; margin-left: auto; margin-right: auto; background-size: 100% auto; background-position: center center; background-repeat: no-repeat; margin-top: 20px; margin-bottom: 20px; }
	.Cvr_Dcs ._lrn_vd ._intro ._p ._c ._img.books{ background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>lrn_intro_books.svg');}
	.Cvr_Dcs ._lrn_vd ._intro ._p ._c ._img.studnt{ background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>lrn_intro_student.svg');}
	.Cvr_Dcs ._lrn_vd ._intro ._p ._c ._img.knw{ background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>lrn_intro_know.svg');}
	
	
	.Cvr_Dcs ._lrn_vd ._intro ._p ._c p{ font-weight: 300; text-align: justify; }
	
	
	.Cvr_Dcs ._lrn_html, ._lrn_html_2{
	     width: 25%;
	     height: 500px;
	     background: #5f5f5f;
	     display: none;
	     position: absolute;
	     opacity: 0.9;
	     padding: 30px;
	    color:white!important;
	     font-size: 16px;
	     overflow: scroll;
	     font-family: Economica;
	     z-index: 999;
	}
	.Cvr_Dcs ._lrn_inf{
	     width: 25px;
	     background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>info.svg');
	     height: 25px;
	     background-repeat: no-repeat;
	     background-size: 25px;
	     position: absolute;
	     right: 4%;
	     cursor: pointer;
	     margin-top: 2%;
	     -webkit-transition: all 1s ease;
	    -moz-transition: all 1s ease;
	    -ms-transition: all 1s ease;
	    -o-transition: all 1s ease;
	    transition: all 1s ease;
	     display: none;
	    z-index: 9999;
	}
	.Cvr_Dcs ._lrn_inf:Hover{
	     opacity:0.9;
	}
	.Cvr_Dcs ._inf_ok{
	     width: 30px!important;
	     background-size: 30px!important;
	     height: 30px!important;
	}
	.Cvr_Dcs ._cmnt_ok{
	     width: 35px!important;
	     background-size: 35px!important;
	     height: 35px!important;
	}
	.Cvr_Dcs ._lrn_drc{
	     width: 20px;
	     background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>right_white.svg');
	     height: 20px;
	     background-repeat: no-repeat;
	     background-size: 100% auto;
	     position: relative;
	     float: left;
	     margin-right: 10px;
	}
	
	.Cvr_Dcs ._vd_clk{
	     background: rgb(210, 208, 208)!important 
	}
	.Cvr_Dcs ._lrn_dv_clk{
	     background: #252525 !important;
	}
	.Cvr_Dcs ._lrn_ifrm{
	     height: 500px;
	     background-color: #e1e5e6;
	     background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>no-video.svg');
	     background-repeat: no-repeat;
	     background-size: 70px;
	     background-position: center;
	}
	.Cvr_Dcs ._lrn_html::-webkit-scrollbar, ._lrn_html_2::-webkit-scrollbar {
	     width: 8px;
	}
	.Cvr_Dcs ._lrn_html::-webkit-scrollbar-track, ._lrn_html_2::-webkit-scrollbar-track {
	     -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
	}
	.Cvr_Dcs ._lrn_html::-webkit-scrollbar-thumb, ._lrn_html_2::-webkit-scrollbar-thumb {
	     background-color: darkgrey;
	     outline: 1px solid slategrey;
	}
	.Cvr_Dcs ._lrn_ldr{
	     background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>loader_white.svg');
	     background-size: 100px;
	     background-position: center;
	     cursor: pointer;
	     background-repeat: no-repeat;
	    height: 100px;
	     width: 100px;
	     margin: auto;
	     margin-top: 50%;
	}
	.Cvr_Dcs .jp-video{
	     display: none;
	}
	
	.Cvr_Dcs ._new_cmnt, ._sve_cmnt{
	     color:#a9a9a9 !important;
	     text-transform:uppercase;
	     font-family:Economica;
	     display:none;
	     font-size:12px;
	     font-weight:300;
	     margin-right:10px;
	     border-radius: 20px 20px 20px 20px;
	     -moz-border-radius: 20px 20px 20px 20px;
	     -webkit-border-radius: 20px 20px 20px 20px;
	     background-color: #ffffff;
	     width: 50%;
	     margin-left: auto;
	     margin-right: auto;
	     padding: 10px 35px 10px 35px;
	     text-decoration: none !important;
	     background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>ec_cmnt_add.svg');
	     background-size: 20px auto;
	     background-position: 10px center;
	     background-repeat: no-repeat;
	     border: 1px solid #bbbbbb !important;
	     white-space: nowrap;
	     background-color: transparent !important;
	}
	.Cvr_Dcs ._new_cmnt:hover, ._sve_cmnt:Hover{
	     color:white !important;
	     text-decoration: none;
	     border: 1px solid #232323;
	}
	.Cvr_Dcs .dv_new{
	     margin-top: 20px;
	     display: none;
	}
	.Cvr_Dcs ._cmnt_add{
	     height: 70px;
	     color:black;
	}
	.Cvr_Dcs ._cmnt_cls{
	     width:16px;
	     height: 16px;
	     cursor:pointer;
	    width:16px;
	    position:relative;
	    top:10px !important;
	    float: right;
	     background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>cancel.svg');
	}
	.Cvr_Dcs ._sve_cmnt{
	     background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>save.svg');
	     margin-top: 10px;
	}
	.Cvr_Dcs .cnt_wrap{
	     padding: 0px!important;
	}
	
	.Cvr_Dcs ._cmnt span{ font-size: 12px; display: block; margin-top: 25px;}
</style>