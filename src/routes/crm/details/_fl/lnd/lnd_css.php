<style>
	
	@-webkit-keyframes lnd_puff {
	  0% { transform:scale(1);}
	  60% { transform:scale(0.9);}
	  90% { transform:scale(1.1);}
	  100% { transform:scale(1);}
	}
	
	#container._shw{ height: 800px!important; }
	
	.cnt_wrap{ padding: 0; }
	
	
	
	.lnd_pnl{ position: relative; background-color: #fff; overflow: hidden; min-height: 2000px; }
	
	.lnd_pnl ._ovr{ width: 100%; height: 100%; position: absolute; z-index: 1; pointer-events: none; position: fixed; }
	.lnd_pnl ._ovr::before{ width: 100%; height: 100%; display: block; position: absolute; left:0; top:0; pointer-events: none; background: rgba(0, 0, 0, 0); }
	.lnd_pnl ._ovr._show{ width: 100%; height: 100%; pointer-events: all; /*background-color: rgba(0,0,0,0.2);*/ }
	.lnd_pnl ._ovr._show::before{ }
	.lnd_pnl ._ovr ._lnd_mod_ovr{ position: absolute; width: 700px; min-height: 550px; height: 500px; left: 50%; top: -2000px;  background: #ffffff; margin-left: -350px; margin-top: -250px; z-index: 9999999999; border-radius: 18px 18px 18px 18px; /*overflow-x: hidden; overflow-y: scroll;*/ margin-bottom: 200px; overflow: hidden;}
		
	.lnd_pnl ._ovr ._lnd_mod_ovr ._hdr{ width: 100%; height: 10%; border-bottom: 1px solid #F0F5F7; position: relative; display: block; }
	.lnd_pnl ._ovr ._lnd_mod_ovr ._hdr nav{ display: block; width: 100%; position: relative; }
	.lnd_pnl ._ovr ._lnd_mod_ovr ._hdr nav ._left{ width: 65%; display: inline-block; }
	.lnd_pnl ._ovr ._lnd_mod_ovr ._hdr nav ._right{ width: 34.5%; display: inline-block; max-width: 35%; width: 35%; position: absolute;  right: 0;  top: 0; text-align: right; }
	.lnd_pnl ._ovr ._lnd_mod_ovr ._hdr nav ._right div{ display: inline-block; min-height: 50px; vertical-align: top; background-repeat: no-repeat; background-position: center center; }
	.lnd_pnl ._ovr ._lnd_mod_ovr ._hdr nav ._right .x{ width:60px;background-image:url("<?php echo DMN_IMG_ESTR_SVG ?>tra_close.svg");background-size:30% auto;opacity:0.3;cursor:pointer;position:absolute;right:0;display:inline-block;min-height:50px;vertical-align:top;background-repeat:no-repeat;background-position:center center;font-size:0; }
	.lnd_pnl ._ovr ._lnd_mod_ovr ._hdr nav ._right .x:Hover{ opacity:0.7;-webkit-animation:lnd_puff 0.4s ease-out; }

	
	
	.lnd_pnl ._ovr ._lnd_mod_ovr > ._bdy{ height: 90%; width: 100%; position: relative; }
	.lnd_pnl ._ovr ._lnd_mod_ovr > ._bdy > div{ display: inline-block; vertical-align: top; }
	
	.lnd_pnl ._ovr ._lnd_mod_ovr ._bdy ._left { width: 100%; height: 100%; background: none; }
	.lnd_pnl ._ovr ._lnd_mod_ovr ._bdy ._left._cls { width: 100%; filter: blur(1px); pointer-events: none; }
	.lnd_pnl ._ovr ._lnd_mod_ovr ._bdy .lnd_view{ display: none; }
	.lnd_pnl ._ovr ._lnd_mod_ovr ._bdy .lnd_img{ display: none; }
	.lnd_pnl ._ovr ._lnd_mod_ovr ._bdy .lnd_img{ display: none; }
	.lnd_pnl ._ovr ._lnd_mod_ovr ._bdy .lnd_dt{ display: none; }
	
	.lnd_pnl ._ovr.lnd-view ._lnd_mod_ovr .lnd_view{ display: block; width: 100%; height: 100%; }
	.lnd_pnl ._ovr.lnd-view ._lnd_mod_ovr .lnd_view ._hd{ width: 100%; height: 30%; border: 1px solid #bd6363; display: block!important; }
	.lnd_pnl ._ovr.lnd-view ._lnd_mod_ovr .lnd_view ._bdy{ width: 100%; height: 70%; }
	.lnd_pnl ._ovr.lnd-view ._lnd_mod_ovr .lnd_view ._bdy ._slc_tp{ margin: auto; width: 60%; margin-top: 5%; }
	.lnd_pnl ._ovr.lnd-view ._lnd_mod_ovr .lnd_view ._bdy ._slc_mdl_tp{ margin: auto; width: 60%; margin-top: 2%; }
	.lnd_pnl ._ovr.lnd-view ._lnd_mod_ovr .lnd_view ._bdy ._slc_mdl{ margin: auto; width: 60%; margin-top: 2%; }
	.lnd_pnl ._ovr.lnd-view ._lnd_mod_ovr .lnd_view ._bdy ._btn{ border-radius:10px; -moz-border-radius:10px; -webkit-border-radius:10px; border: 1px solid #666666; color: #FFF; text-transform: uppercase;  cursor: pointer; background-color: #333; font: 300 13px/1em Economica; padding: 15px 25px;  width: 40%; line-height: 1px; display: block; margin: auto; margin-top: 4%; }
	.lnd_pnl ._ovr.lnd-view ._lnd_mod_ovr .lnd_view ._bdy ._btn:Hover{ opacity: 0.7; }
	
	.lnd_pnl ._ovr.lnd-lgo ._lnd_mod_ovr .lnd_img{ display: inline-block; width: 100%; height: 100%; }
	.lnd_pnl ._ovr.lnd-lgo ._lnd_mod_ovr .lnd_img ._ls{ display: inline-block; margin-left: 20px; }
	.lnd_pnl ._ovr.lnd-lgo ._lnd_mod_ovr .lnd_img ._ls ._add{ width: 115px; height: 100px; display: inline-block; background: url('<?php echo DMN_IMG_ESTR_SVG ?>lnd_add_lgo.svg'); background-repeat:no-repeat; background-size: auto; margin-left: 15px; margin-top: 10px; -webkit-filter: grayscale(100%); filter: grayscale(100%); cursor: pointer; }
	.lnd_pnl ._ovr.lnd-lgo ._lnd_mod_ovr .lnd_img ._ls ._add:Hover{ -webkit-filter: grayscale(0%); filter: grayscale(0%); }
	.lnd_pnl ._ovr.lnd-lgo ._lnd_mod_ovr .lnd_img ._ls ._lgo{ display: inline-block; width: 100px; height: 100px; background-repeat:no-repeat!important; background-size: 85px!important; margin-left: 10px; margin-top: 10px; cursor: pointer; }
	.lnd_pnl ._ovr.lnd-lgo ._lnd_mod_ovr .lnd_img ._ls ._lgo:Hover{ opacity: 0.7; }
	
	.lnd_pnl ._ovr.lnd-img ._lnd_mod_ovr .lnd_img{ display: inline-block; width: 100%; height: 100%; }
	.lnd_pnl ._ovr.lnd-img ._lnd_mod_ovr .lnd_img ._ls{ display: inline-block; margin-left: 20px; }
	.lnd_pnl ._ovr.lnd-img ._lnd_mod_ovr .lnd_img ._ls ._add{ width: 115px; height: 100px; display: inline-block; background: url('<?php echo DMN_IMG_ESTR_SVG ?>lnd_add_lgo.svg'); background-repeat:no-repeat; background-size: auto; margin-left: 15px; margin-top: 10px; -webkit-filter: grayscale(100%); filter: grayscale(100%); cursor: pointer; }
	.lnd_pnl ._ovr.lnd-img ._lnd_mod_ovr .lnd_img ._ls ._add:Hover{ -webkit-filter: grayscale(0%); filter: grayscale(0%); }
	.lnd_pnl ._ovr.lnd-img ._lnd_mod_ovr .lnd_img ._ls ._img{ display: inline-block; width: 100px; height: 100px; background-repeat:no-repeat!important; background-size: 85px!important; margin-left: 10px; margin-top: 10px; cursor: pointer; }
	.lnd_pnl ._ovr.lnd-img ._lnd_mod_ovr .lnd_img ._ls ._img:Hover{ opacity: 0.7; }
	
	
	.lnd_pnl ._ovr._show{ overflow-x: hidden; overflow-y: scroll; }
	.lnd_pnl ._ovr._show *{ font-family: 'Source Sans Pro'; }
	.lnd_pnl ._ovr._show::before{ background: rgba(16, 16, 16, 0.71); position: fixed;  }
	.lnd_pnl ._ovr._show ._lnd_mod_ovr{ top: 45%; overflow:auto; }
	
	
	
	.lnd_pnl h1{ display: block; width: 100%; font-family: Economica; text-transform: uppercase; background-color: #48474a; margin: 0; padding: 5px 0 10px 0; color: white;  text-align: center; font-weight: 300; font-size: 16px; }
	.lnd_pnl h1::before{ display: inline-block;  background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>lnd_white.svg');  width: 15px; height: 15px;  background-size: 100% auto;  background-repeat: no-repeat; margin-right: 10px;  margin-bottom: -2px; }
	
	
	
	.lnd_pnl ._lnd_new{ display: inline-block; background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>tra_col_add.svg'); width: 30px; height: 30px;  background-size: 100% auto;  background-repeat: no-repeat; margin-right: 10px;  margin-bottom: -2px; margin: auto;  display: block; margin-top: 10px; cursor: pointer; }
	.lnd_pnl ._lnd_new:hover{ opacity: 0.7; }
	
	
	.lnd_pnl ._lnd_add{ display: flex; padding: 30px 40px; }
	.lnd_pnl ._lnd_add ._lnd{ width: 120px; height: 150px; display: inline-block; margin-top: 10px; margin-left: 10px; position: relative; border: 1px solid #bab6c1; overflow: hidden; border-radius:8px; -moz-border-radius:8px; -webkit-border-radius:8px; }
	
	.lnd_pnl ._lnd_add ._lnd:hover > ._lnd_opc{ top: 0px; opacity: 1; pointer-events: all; }
	
	.lnd_pnl ._lnd_add ._lnd ._lnd_opc{ width: 100%; position: absolute; z-index: 9; top: -300px; text-align: center; padding: 10px 0; opacity: 0; pointer-events: none; }
	
	.lnd_pnl ._lnd_add ._lnd ._lnd_opc div{ height: 20px; width: 20px; display: inline-block; cursor: pointer; background-size: auto 90%; background-repeat: no-repeat; background-position: center center; margin-left: 2px; margin-right: 2px; }
	.lnd_pnl ._lnd_add ._lnd ._lnd_opc div:hover{ opacity: 0.7; background-size: auto 100%; }
	
	.lnd_pnl ._lnd_add ._lnd ._lnd_opc ._opc_bldr{ border: 1px solid black; background: #76c376; }
	.lnd_pnl ._lnd_add ._lnd ._lnd_opc ._opc_lnd{ background-image: url('<?php echo DMN_IMG_ESTR_SVG?>lnd_opc_edt.svg'); }
	.lnd_pnl ._lnd_add ._lnd ._lnd_opc ._opc_view{ background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>lnd_opc_view.svg'); }
	
	.lnd_pnl ._lnd_add ._lnd ._lnd_img{ cursor: pointer; width: 100%; height: 80%; border-bottom: none; position: relative; }
	.lnd_pnl ._lnd_add ._lnd ._lnd_img::before{ width: 50px; height:70px; background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>lnd_ls.svg'); background-size: auto 50%; background-repeat: no-repeat; background-position: center center; -webkit-filter: grayscale(100%); filter: grayscale(100%); position: absolute; opacity: 0.3; left: 50%; top: 50%; margin-top: -35px; margin-left: -25px; }
	.lnd_pnl ._lnd_add ._lnd:hover ._lnd_img{ margin-top:15px; }
	
	
	.lnd_pnl ._lnd_add ._lnd ._lnd_img:Hover{ opacity: 0.7; }
	
	.lnd_pnl ._lnd_add ._lnd ._lnd_tt{ width: 100%; background: #ecf0f1; color: #757b80; text-align: center; position: absolute; left: 0; bottom: 0; }
	.lnd_pnl ._lnd_add ._lnd .lnd_tt{ width: 100%; height: 100%; text-align: center; border: 1px solid #bab6c1; border: none; border-radius:0px; -moz-border-radius:0px; -webkit-border-radius:0px; padding: 5px 10px; text-overflow: ellipsis; }
	.lnd_pnl ._lnd_add ._lnd .lnd_tt:focus{ background: white; color:black; }
	
	
	.lnd_pnl ._lnd_mod{ width: 100%; display: flex; background-color: #fff; }
	.lnd_pnl ._lnd_mod:not(.on){ opacity: 0; max-height: 1px; overflow: hidden; pointer-events: none; }
	.lnd_pnl ._lnd_mod.om{ min-height: 1000px; }
	
	.lnd_pnl ._lnd_mod ._lnd_col_1{ height: 100%; display: inline-block; }
	
	
	
	
	
	
	.lnd_pnl ._lnd_mod ._lnd_col_1 ._hdt{ width: 100%; height: 4%; display: flex; background: #939196; }
	.lnd_pnl ._lnd_mod ._lnd_col_1 ._hdt:empty{ display: none !important; }
	
	.lnd_pnl ._lnd_mod ._lnd_col_1 ._hdt::after, 
	.lnd_pnl ._lnd_mod ._lnd_col_1 ._hdt::before{ display: none !important; }
	
	
	
	.lnd_pnl ._lnd_mod ._lnd_col_1 ._hdt ._tab{ width: 100px; background: #afafaf; display: inline-block; margin-left: -4px; white-space: nowrap; text-overflow: ellipsis; padding-right: 15px; cursor: pointer; position: relative; border-radius: 10px 10px 0px 0px; -moz-border-radius: 10px 10px 0px 0px; -webkit-border-radius: 10px 10px 0px 0px; }
	.lnd_pnl ._lnd_mod ._lnd_col_1 ._hdt ._tab:hover > ._cls{ display: block; }
	.lnd_pnl ._lnd_mod ._lnd_col_1 ._hdt ._tab:hover{ width: 150px; margin-left: 4px; margin-right: 8px; cursor: pointer; }
	
	.lnd_pnl ._lnd_mod ._lnd_col_1 ._hdt ._tab ._cls{ position: absolute; background-repeat:no-repeat; top: -6px; right: -6px; background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>lnd_tb_cls.svg'); width: 20px; height: 20px; background-position: center center; background-size: auto 100%; display: none; cursor: pointer; }
	.lnd_pnl ._lnd_mod ._lnd_col_1 ._hdt ._tab ._cls:hover{ background-size: auto 80%; }
	
	
	.lnd_pnl ._lnd_mod ._lnd_col_1 ._hdt ._tab._slc{ border-bottom: 0px; background: #f0f2f3; z-index: 10; -webkit-box-shadow: 0px -15px 24px 8px rgba(0,0,0,0.13); -moz-box-shadow: 0px -15px 24px 8px rgba(0,0,0,0.13); box-shadow: 0px -15px 24px 8px rgba(0,0,0,0.13); height: 49px; margin-top: -6px; }
	.lnd_pnl ._lnd_mod ._lnd_col_1 ._hdt ._tab span{ font-family: Economica; position: relative; padding: 10px 0 0 10px; display: block; text-overflow: ellipsis; white-space: nowrap; overflow: hidden; pointer-events: none; }
	
	.lnd_pnl ._lnd_mod ._lnd_col_1 ._hdt ._tab._slc span{ padding-top: 12px; pointer-events: none; }
	.lnd_pnl ._lnd_mod ._lnd_col_1 ._hdt ._tab._slc span:before{ display: inline-block; background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>lnd_tab_edt.svg'); width: 17px; height: 17px; background-repeat: no-repeat; background-position: center center; background-size: auto 90%; margin-right: 5px; margin-bottom: -3px; animation: _blnk 0.8s cubic-bezier(.5, 0, 1, 1) infinite alternate; pointer-events: none; }
	.lnd_pnl ._lnd_mod ._lnd_col_1 ._hdt ._tab._ldn span:before{ background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>loader_black.svg'); }
	
	
	.lnd_pnl ._lnd_mod ._lnd_col_1 ._bdy{ width: 100%; height: 96%; }
	.lnd_pnl ._lnd_mod ._lnd_col_1 ._bdy span{ display: block; text-align: center; margin-top: 30%; font-size: 30px; font-family: Economica;  color: #bbb9bf; }
	
	
	.lnd_pnl ._lnd_mod ._lnd_col_1 ._bdy ._lnd_html{display:none; width: 100%; height: 100%; min-height: 2000px;  top: 0; overflow: hidden; background: white; position: absolute; position: relative; }
	.lnd_pnl ._lnd_mod ._lnd_col_1 ._bdy ._lnd_html iframe{ min-height: 2000px !important; }
	.lnd_pnl ._lnd_mod ._lnd_col_1 ._bdy ._lnd_html._slc{ display:block; width: 100%; height: 100%; position: relative; }
	.lnd_pnl ._lnd_mod ._lnd_col_1 ._bdy ._lnd_html ._lnd_ifrm{ width: 100%; height: 100%; min-height: 1000px; }
	
	
	.lnd_pnl ._lnd_mod ._lnd_col_1 ._bdy ._lnd_html .dvc_wrp:after{ }
	.lnd_pnl ._lnd_mod ._lnd_col_1 ._bdy ._lnd_html.dsk .dvc_wrp{  }
	
	
	.lnd_pnl ._lnd_mod ._lnd_col_1 ._bdy ._lnd_html.mbl,
	.lnd_pnl ._lnd_mod ._lnd_col_1 ._bdy ._lnd_html.tbl{ background-color: #f0f2f3; }
	
	.lnd_pnl ._lnd_mod ._lnd_col_1 ._bdy ._lnd_html.mbl .dvc_wrp,
	.lnd_pnl ._lnd_mod ._lnd_col_1 ._bdy ._lnd_html.tbl .dvc_wrp{ margin-left: auto; margin-right: auto; background-repeat: no-repeat; background-size:100% auto; position: relative; margin-top: 50px; }
	
	
	.lnd_pnl ._lnd_mod ._lnd_col_1 ._bdy ._lnd_html.mbl .dvc_wrp ._lnd_ifrm,
	.lnd_pnl ._lnd_mod ._lnd_col_1 ._bdy ._lnd_html.tbl .dvc_wrp ._lnd_ifrm{ min-height: unset !important; overflow: hidden; }
	
	
	/*--------------------  MOBILE RESPONSIVE --------------------*/
	
	
		.lnd_pnl ._lnd_mod ._lnd_col_1 ._bdy ._lnd_html.mbl .dvc_wrp{ width: 400px; height: 820px; background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>dvc_rsp_mobile.svg'); }
		.lnd_pnl ._lnd_mod ._lnd_col_1 ._bdy ._lnd_html.mbl .dvc_wrp ._lnd_ifrm{ width: 359px; height: 777px; position: absolute; left: 21px; top: 21px; border-radius:39px;
	-moz-border-radius:39px; -webkit-border-radius:39px; }
		.lnd_pnl ._lnd_mod ._lnd_col_1 ._bdy ._lnd_html.mbl .dvc_wrp::before{ width: 100%; height: 40px; position: absolute; top:3px; left: 0; z-index: 1; background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>dvc_rsp_mobile_top.svg'); background-repeat: no-repeat; background-position: center top; background-size: auto 100%; }
		.lnd_pnl ._lnd_mod ._lnd_col_1 ._bdy ._lnd_html.mbl .dvc_wrp::after{ width: 100%; height: 40px; position: absolute; bottom:40px; left: 0; z-index: 1; background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>dvc_rsp_mobile_bottom.svg'); background-repeat: no-repeat; background-position: center center; background-size: 100px auto; }
		
	
	/*--------------------  TABLET RESPONSIVE --------------------*/
	
	
		.lnd_pnl ._lnd_mod ._lnd_col_1 ._bdy ._lnd_html.tbl .dvc_wrp{ width: 600px; height: 900px; background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>dvc_rsp_tablet.svg'); }
		.lnd_pnl ._lnd_mod ._lnd_col_1 ._bdy ._lnd_html.tbl .dvc_wrp ._lnd_ifrm{ width: 572px; height: 719px; position: absolute; left: 17px; top: 91px; }
		
	
	/*--------------------  ICONS RESPONSIVE --------------------*/
	
	.lnd_pnl ._lnd_mod ._lnd_col_1 ._bdy ._lnd_html .opt_dvc{ text-align: center; padding: 5px 0 3px 0; width: 100%; background-color: #f0f2f3; }
	.lnd_pnl ._lnd_mod ._lnd_col_1 ._bdy ._lnd_html .opt_dvc ul{ list-style: none; display: block; margin: 0; padding: 0; }
	.lnd_pnl ._lnd_mod ._lnd_col_1 ._bdy ._lnd_html .opt_dvc ul li{ display: inline-block; vertical-align: top; width: 25px; height: 25px; margin-left: 5px; margin-right: 5px; background-repeat: no-repeat; background-position: center center; background-size: auto 70%; opacity: 0.4; cursor: pointer; }
	.lnd_pnl ._lnd_mod ._lnd_col_1 ._bdy ._lnd_html .opt_dvc ul li.on,
	.lnd_pnl ._lnd_mod ._lnd_col_1 ._bdy ._lnd_html .opt_dvc ul li:hover{ opacity: 1; }
	
	.lnd_pnl ._lnd_mod ._lnd_col_1 ._bdy ._lnd_html .opt_dvc ul li.mbl{ background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>dvc_mobile.svg'); }
	.lnd_pnl ._lnd_mod ._lnd_col_1 ._bdy ._lnd_html .opt_dvc ul li.dsk{ background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>dvc_desktop.svg'); }
	.lnd_pnl ._lnd_mod ._lnd_col_1 ._bdy ._lnd_html .opt_dvc ul li.tbl{ background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>dvc_tablet.svg'); }
	
	
	
	.lnd_pnl ._lnd_mod ._lnd_col_1.opn{ width: 100%; }
	.lnd_pnl ._lnd_mod ._lnd_col_1.cls{ width: 75%; }
	
	
	
	.lnd_pnl ._lnd_mod ._lnd_col_2{ display: inline-block; background: #222526; vertical-align: top; position: relative; min-height: 1000px; }
	.lnd_pnl ._lnd_mod ._lnd_col_2 ._hd { display: block!important; width: 40px; height: 45px; position: absolute; left: -30px; border-radius: 10px 0px 0px 10px; -moz-border-radius: 10px 0px 0px 10px; -webkit-border-radius: 10px 0px 0px 10px; background-color:#222526; }
	.lnd_pnl ._lnd_mod ._lnd_col_2 ._hd .btn_pnl:Hover{ opacity: 0.7; }
	
	.lnd_pnl ._lnd_mod ._lnd_col_2.opn{ width: 25%; }
	.lnd_pnl ._lnd_mod ._lnd_col_2.opn ._hd .btn_pnl{ display:block; background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>lnd_pnl_btn_right.svg'); width: 40px; height: 40px; background-size: 25px 25px; background-repeat: no-repeat; background-position: center center; display: block; cursor: pointer; }
	
	.lnd_pnl ._lnd_mod ._lnd_col_2.opn ._bdy{ width: 100%; padding: 0 20px; }
	.lnd_pnl ._lnd_mod ._lnd_col_2.opn ._bdy hr{ width: 100%; border-color: #3d4142;  margin-bottom: 30px; border-top: 0; }
	
	
	
	.lnd_pnl ._lnd_mod ._lnd_col_2.opn ._bdy .row_1{ width: 100%; padding: 30px 0 10px 0; display: block; margin: auto; text-align: center; }
	.lnd_pnl ._lnd_mod ._lnd_col_2.opn ._bdy .row_1 div{ width: 30%; border: 1px solid #757378; height: 100%; display: inline-block; background-repeat: no-repeat!important; text-align: center; cursor: pointer; border-radius:8px; -moz-border-radius:8px; -webkit-border-radius:8px; background-size: contain; }
	.lnd_pnl ._lnd_mod ._lnd_col_2.opn ._bdy .row_1 div:Hover{ opacity: 0.7; }
	.lnd_pnl ._lnd_mod ._lnd_col_2.opn ._bdy .row_1 div span{ display: block; font-size: 12px; width: 100%; margin-top: 3%; margin-left: 10px; color: white; padding: 5px 0; font-family: Economica; text-transform: uppercase; }
	
	.lnd_pnl ._lnd_mod ._lnd_col_2.opn ._bdy .row_1 .col_1{ background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>lnd_pnl_dsgn.svg'); }
	.lnd_pnl ._lnd_mod ._lnd_col_2.opn ._bdy .row_1 .col_2{ background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>lnd_pnl_mdl.svg'); }
	.lnd_pnl ._lnd_mod ._lnd_col_2.opn ._bdy .row_1 .col_3{ background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>lnd_pnl_vw.svg'); }
	.lnd_pnl ._lnd_mod ._lnd_col_2.opn ._bdy .row_1 .col_4{ background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>lnd_opc_view_blue.svg'); }
	
	.lnd_pnl ._lnd_mod ._lnd_col_2.opn ._bdy .row_2{ width: 100%; text-align: center; display: flex; }
	.lnd_pnl ._lnd_mod ._lnd_col_2.opn ._bdy .row_2 div{ width: 32.5%; border: 1px solid #757379; display: inline-block; cursor: pointer; text-transform: uppercase; padding-top: 10px; padding-bottom: 8px; }
	.lnd_pnl ._lnd_mod ._lnd_col_2.opn ._bdy .row_2 div:first-child{ border-radius: 10px 0px 0px 0px; -moz-border-radius: 10px 0px 0px 0px; -webkit-border-radius: 10px 0px 0px 0px; border-right: none; }
	.lnd_pnl ._lnd_mod ._lnd_col_2.opn ._bdy .row_2 div:last-child{ border-radius: 0px 10px 0px 0px; -moz-border-radius: 0px 10px 0px 0px; -webkit-border-radius: 0px 10px 0px 0px; border-left: none; }
	.lnd_pnl ._lnd_mod ._lnd_col_2.opn ._bdy .row_2 div span{ display: block;  margin-top: 3px; color: #a09a9a; font-family: Economica; pointer-events: none; }
	.lnd_pnl ._lnd_mod ._lnd_col_2.opn ._bdy .row_2 > div._slc{ border-bottom: none; }
	.lnd_pnl ._lnd_mod ._lnd_col_2.opn ._bdy .row_2 > div._slc span{ color: #fff; }
	
	
	.lnd_pnl ._lnd_mod ._lnd_col_2.opn ._bdy .row_3{ width: 100%; }
	.lnd_pnl ._lnd_mod ._lnd_col_2.opn ._bdy .row_3 > div{ display: none; }
	.lnd_pnl ._lnd_mod ._lnd_col_2.opn ._bdy .row_3 > div._slc{ display: block!important; margin-top: 20px; }
	.lnd_pnl ._lnd_mod ._lnd_col_2.opn ._bdy .row_3 > div._slc .lnd_load{ height: 40px; background-color: transparent; }
	.lnd_pnl ._lnd_mod ._lnd_col_2.opn ._bdy .row_3 > div._slc .lnd_load div{ height: 40px; width: 40px; margin-left: -20px; margin-top: -20px; background-size: auto 100%; }
	
	.lnd_pnl ._lnd_mod ._lnd_col_2.opn ._bdy .row_3 .col_1{ width: 100%; }
	.lnd_pnl ._lnd_mod ._lnd_col_2.opn ._bdy .row_3 .col_1 ._slc_tp{ width: 95%; margin: auto; }
	.lnd_pnl ._lnd_mod ._lnd_col_2.opn ._bdy .row_3 .col_1 ._slc_tp > div{ margin-top: 15px; }
	.lnd_pnl ._lnd_mod ._lnd_col_2.opn ._bdy .row_3 .col_1 ._slc_tp > div label{ display:none; }
	.lnd_pnl ._lnd_mod ._lnd_col_2.opn ._bdy .row_3 .col_1 ._slc_mdl_tp{ width: 95%; margin: auto; }
	.lnd_pnl ._lnd_mod ._lnd_col_2.opn ._bdy .row_3 .col_1 ._slc_mdl{ width: 100%; overflow: scroll; margin-top: 25px; }
	
	.lnd_pnl ._lnd_mod ._lnd_col_2.opn ._bdy .row_3 .col_1 ._slc_mdl .sch{ margin-bottom:20px; position:relative; }
	.lnd_pnl ._lnd_mod ._lnd_col_2.opn ._bdy .row_3 .col_1 ._slc_mdl .sch+ .___txar{ display:block; width:100%; }
	.lnd_pnl ._lnd_mod ._lnd_col_2.opn ._bdy .row_3 .col_1 ._slc_mdl .sch.fll .___txar{ padding-right:0px; }
	.lnd_pnl ._lnd_mod ._lnd_col_2.opn ._bdy .row_3 .col_1 ._slc_mdl .sch input[type=text]{ text-align:center; background-image:url('<?php echo DMN_IMG_ESTR_SVG ?>search_bck.svg'); background-position:right 5px center; background-size:15px auto; background-repeat:no-repeat; width: 100%; }

	
	.lnd_pnl ._lnd_mod ._lnd_col_2.opn ._bdy .row_3 .col_1 ._slc_mdl ul{ list-style: none; margin: 0; padding: 0 10px 200px 10px; }
	.lnd_pnl ._lnd_mod ._lnd_col_2.opn ._bdy .row_3 .col_1 ._slc_mdl ul li{ margin-top: 12px; }
	.lnd_pnl ._lnd_mod ._lnd_col_2.opn ._bdy .row_3 .col_1 ._slc_mdl ul li button{ cursor: pointer; width: 100%; border-radius:8px; -moz-border-radius:8px; -webkit-border-radius:8px; background: var(--main-bg-color); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; color: white; font-family: Economica; text-transform: uppercase; border: none; padding: 7px 10px; font-weight: 300; font-size: 12px; }
	.lnd_pnl ._lnd_mod ._lnd_col_2.opn ._bdy .row_3 .col_1 ._slc_mdl ul li button:hover{ background: var(--second-bg-color); }
	.lnd_pnl ._lnd_mod ._lnd_col_2.opn ._bdy .row_3 .col_1 ._slc_mdl ul li button._ld{ background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>lnd_ldr_white.svg'); background-repeat: no-repeat; background-position: center center; background-size: auto 80%; text-indent: -2000px; }
	
	
	
	
	
	.lnd_pnl ._lnd_mod ._lnd_col_2.opn ._bdy .row_3 .col_2{ display: none; width: 100%; height: 100%; }
	.lnd_pnl ._lnd_mod ._lnd_col_2.opn ._bdy .row_3 .col_2 ._attr{ border: 1px solid; margin: auto; display: block; width: 90%; margin-top: 20px; }
	.lnd_pnl ._lnd_mod ._lnd_col_2.opn ._bdy .row_3 .col_2 ._attr ._left{ width: 29%; display: inline-block; vertical-align: top; margin-top: 7px; border-right: 1px solid; }
	.lnd_pnl ._lnd_mod ._lnd_col_2.opn ._bdy .row_3 .col_2 ._attr ._left span{ font-family: Economica; color: #757378; font-size: 15px; }
	.lnd_pnl ._lnd_mod ._lnd_col_2.opn ._bdy .row_3 .col_2 ._attr ._right{ width: 70%; display: inline-block; }
	.lnd_pnl ._lnd_mod ._lnd_col_2.opn ._bdy .row_3 .col_2 ._attr ._right .lndmdlsgmattr_vle{ width: 100%; }
	
	.lnd_pnl ._lnd_mod ._lnd_col_2.opn ._bdy .row_3 .col_2 ._clr{ text-align: center; margin-top: 100px; }
	.lnd_pnl ._lnd_mod ._lnd_col_2.opn ._bdy .row_3 .col_2 ._clr span{ font-family: Economica; color:#999; font-size: 18px; }
	.lnd_pnl ._lnd_mod ._lnd_col_2.opn ._bdy .row_3 .col_2 ._clr #_clr{ width: 50px; height: 30px; }
	
	.lnd_pnl ._lnd_mod ._lnd_col_2.opn ._bdy .row_3 .col_3{ display: none; }
	
	.lnd_pnl ._lnd_mod ._lnd_col_2.cls{ width:10px; position: absolute; right: 0; }
	.lnd_pnl ._lnd_mod ._lnd_col_2.cls ._bdy{ display: none; }
	.lnd_pnl ._lnd_mod ._lnd_col_2.cls ._hd .btn_pnl{ margin-top: 5px!important; display: inline-block;  background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>lnd_pnl_btn_left.svg'); width: 30px; height: 30px;  background-size: 100% auto;  background-repeat: no-repeat; display: block; cursor: pointer; margin: auto; }
	
</style>