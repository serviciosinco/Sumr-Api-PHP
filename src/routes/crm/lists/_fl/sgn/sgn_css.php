<style>
	
	@-webkit-keyframes tra_puff {
	  0% { transform:scale(1);}
	  60% { transform:scale(0.9);}
	  90% { transform:scale(1.1);}
	  100% { transform:scale(1);}
	}
	
*{padding:0;margin:0}
#container._shw{height:800px!important}
.cnt_wrap{padding:0}
.sgn_pnl .h1{display:block;width:100%;font-family:Economica;text-transform:uppercase;background-color:#56497a;margin:0;padding:10px 0 15px;color:#fff;text-align:center;font-weight:300;font-size:20px}
.sgn_pnl ._sgn_new{display:inline-block;background-image:url('<?php echo DMN_IMG; ?>estr/svg/tra_col_add.svg');width:30px;height:30px;background-size:100% auto;background-repeat:no-repeat;margin:auto;display:block;margin-top:10px;cursor:pointer}
.sgn_pnl ._sgn_new:hover{opacity:.7}
.sgn_pnl ._sgn_mod,
.sgn_pnl ._sgn_mod_vst{position:absolute;width:100%;left:-2500px;background-color:#fff;z-index:1;top:0;height:100%}
.sgn_pnl ._sgn_add ._sgn{width:100px;height:123px;display:inline-block;margin-top:10px;margin-left:10px;position:relative}
.sgn_pnl ._sgn_add ._sgn ._opc_sgn_ok{width:0;height:0;border-top:20px solid #0d9434;border-left:20px solid #f0ad4e00;position:absolute;top:0;left:80px}
.sgn_pnl ._sgn_add ._sgn ._opc_sgn_no{width:0;height:0;border-top:20px solid #b80d1b;border-left:20px solid #f0ad4e00;position:absolute;top:0;left:80px}
.sgn_pnl ._sgn_add ._sgn ._sgn_img{cursor:pointer;width:100%;height:80%;background-image:url(DMN_IMG_ESTR_SVG.'sgn_1.svg');background-size:65% auto;background-repeat:no-repeat;border:1px solid #bab6c1;border-bottom:none;background-position:center}
.sgn_pnl ._sgn_add ._sgn ._sgn_img:hover{background-image:none}
.sgn_pnl ._sgn_add ._sgn ._sgn_txt{width:100%;height:20%;background:#ecf0f1;color:#757b80;text-align:center}
.sgn_pnl ._sgn_add ._sgn .sgn_tt{width:100%;height:100%;text-align:center;border:1px solid #bab6c1;border-top:none;border-radius:0 0 6px 6px!important}
.sgn_pnl ._sgn_add ._sgn .sgn_tt:focus{background:#fff;color:#000;border-top:1px solid #bab6c1}
.sgn_pnl .orv_sgn{background-color:#000000a3;width:100%;height:100%;position:absolute;z-index:9;top:-1000px}
.sgn_pnl .orv_sgn.ok{top:0}
.sgn_pnl .orv_sgn ._sgn_opc{width:60%;height:80%;z-index:9;background-color:#fff;position:absolute;left:50%;transform:translate(-50%,-50%);-webkit-transform:translate(-50%,-50%);border-radius:12px;top:-500px}
.sgn_pnl .orv_sgn ._sgn_opc.ok{top:50%}
.sgn_pnl .orv_sgn ._sgn_opc h1{display:block;width:100%;font-family:Economica;text-transform:uppercase;margin:0;padding:10px 0 15px;color:#6f6f6f;text-align:center;font-weight:300;font-size:20px;border-bottom:1px solid #F0F5F7}
.sgn_pnl .orv_sgn ._sgn_opc .x{width:60px;background-image:url('<?php echo DMN_IMG; ?>estr/svg/tra_close.svg');background-size:30% auto;opacity:.3;cursor:pointer;position:absolute;right:0;display:inline-block;min-height:50px;vertical-align:top;background-repeat:no-repeat;background-position:center center;font-size:0}
.sgn_pnl .orv_sgn ._sgn_opc .x:hover{opacity:.7;-webkit-animation:tra_puff .4s ease-out}
.sgn_pnl .orv_sgn ._sgn_opc ._opc{padding:20px}
.sgn_pnl .orv_sgn ._sgn_opc ._opc .opc_s{cursor:pointer;width:110px;display:inline-block;border:1px solid #bfbfbf;border-radius:10px;padding:86px 0 0;background-repeat:no-repeat;margin:9px;background-size:80px;background-position:15px 15px;background-image:url(DMN_IMG_ESTR_SVG.'sgn_4.svg')}
.sgn_pnl .orv_sgn ._sgn_opc ._opc .opc_s:hover{background-size:90px;background-position:10px 10px}
.sgn_pnl .orv_sgn ._sgn_opc ._opc .opc_s p{color:#8a8a8a;padding:6px 0;margin-top:22px;font-size:12px;text-align:center;overflow:hidden;width:100%;white-space:nowrap;background-color:#ececec;text-overflow:ellipsis;margin-bottom:0;border-radius:0 0 9px 9px}
.sgn_pnl ._sgn_mod.ok{left:0}
.sgn_pnl ._sgn_mod ._sgn_cnt{width:700px;margin:0 auto;border:1px solid #d6d6d6;padding:30px 0}
.sgn_pnl .atr{width:700px;height:40px;margin:0 auto}
.sgn_pnl .atr .btn_atr{display:inline-block;width:42px;height:42px;background-color:#868686;-webkit-mask-size:30px;-webkit-mask-repeat:no-repeat;-webkit-mask-position:center;-webkit-mask-image:url('<?php echo DMN_IMG; ?>estr/svg/lnd_pnl_btn_right.svg');mask-image:url('<?php echo DMN_IMG; ?>estr/svg/lnd_pnl_btn_right.svg');cursor:pointer;-webkit-transform:rotate(180deg);-moz-transform:rotate(180deg);rotation:180deg}
.sgn_pnl ._sgn_mod .atr .btn_vtp{width:40px;height:40px;display:inline-block;background-image:url('<?php echo DMN_IMG; ?>estr/svg/lnd_pnl_vw.svg');background-size:30px;background-position:center;background-repeat:no-repeat;vertical-align:text-bottom;float:right;position:relative;font-family:Economica;cursor:pointer}
.sgn_pnl ._sgn_mod_vst{position:absolute;width:100%;left:-2500px;background-color:#fff;z-index:1;top:0;height:100%}
.sgn_pnl ._sgn_mod_vst.ok table{margin:0 auto}
.sgn_pnl ._sgn_mod_vst.ok{left:0}
.sgn_pnl ._sgn_mod .atr  .btn_vtp:hover:before{color:#000}
.sgn_pnl ._sgn_mod .atr  .btn_vtp::before{content:<?php echo TX_VSTPRV ?>;right:19px;position:absolute;width:80px;top:6px;vertical-align:-webkit-baseline-middle;color:gray}
.sgn_pnl .atr .btn_atr:hover{background-color:#595959}

.sgn_pnl ._sgn_mod ._sgn_cnt ._c_p{position:relative;border:3px dotted #c4c4c4;min-height:20px;display:block}
.sgn_pnl ._sgn_mod ._sgn_cnt .on_edit{border:3px dotted #343434!important}
.sgn_pnl ._sgn_mod ._sgn_cnt ._c_p ._tt{padding:6px}
.sgn_pnl ._sgn_mod ._sgn_cnt ._c_p.ok{border:3px dotted #3d3d3d!important}
.sgn_pnl ._sgn_mod ._sgn_cnt ._c_p input{width:100%!important;display:block;background-color:transparent;padding-left:12px}
.sgn_pnl ._sgn_mod ._sgn_cnt ._tt.no{display:none}

.sgn_pnl ._sgn_add ._sgn ._sgn_img .__opc_sgn div{border:3px solid #c3c3c3;width:35px;height:35px;border-radius:50%;display:none}
.sgn_pnl ._sgn_add ._sgn ._sgn_img .__opc_sgn{width:76px;position:absolute;left:50%;top:50%;transform:translate(-50%,-50%);-webkit-transform:translate(-50%,-50%)}
.sgn_pnl ._sgn_add ._sgn ._sgn_img .__opc_sgn .eli{left:25px;background-image:url(DMN_IMG_ESTR_SVG.'sgn_2.svg');left:25px;background-position:center;background-repeat:no-repeat;background-size:15px}
.sgn_pnl ._sgn_add ._sgn ._sgn_img .__opc_sgn .edt{background-image:url(DMN_IMG_ESTR_SVG.'sgn_3.svg');left:25px;background-position:center;background-repeat:no-repeat;background-size:15px;margin-right:6px}
.sgn_pnl ._sgn_add ._sgn ._sgn_img .__opc_sgn .edt:hover:before{content:<?php echo TX_EDT ?>;font-family:Economica;top:-23px;position:absolute;background-color:#c7c7c7;padding:2px 7px;border-radius:5px;left:-3px}
.sgn_pnl ._sgn_add ._sgn ._sgn_img .__opc_sgn .eli:hover:before{content:<?php echo TX_ELMNR ?>;font-family:Economica;top:-23px;position:absolute;background-color:#c7c7c7;padding:2px 7px;border-radius:5px;left:32px}
.sgn_pnl ._sgn_add ._sgn ._sgn_img:hover > .__opc_sgn div{display:inline-block}
</style>