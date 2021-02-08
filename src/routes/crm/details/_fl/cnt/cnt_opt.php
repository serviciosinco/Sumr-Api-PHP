<?php 

	$msv_chnl = Php_Ls_Cln($_GET['msv_chnl']); // Channel Massive

	if(!isN($msv_chnl)){
		
		$_GtWhtspCnvDt = GtWhtspCnvDt([ "cid"=>$msv_chnl ]);

		if(!isN($_GtWhtspCnvDt->id)){
			$_GtMainCnvDt = GtMainCnvDt([ "tp"=>"whtsp", "maincnv_id"=>$_GtWhtspCnvDt->id ]);
		}

	}
	
?>
<div class="dsh_chat_options" id="dsh_chat_options">
	<h1><button class="back _anm" id="dsh_chat_options_bck"></button>Herramientas / Opciones</h1>
	<p class="intro">Seleccione una de estas opciones disponibles para los leads de su compañia.</p>
	<div class="op_itms">
		<h2 class="opts">Opciones</h2>
		<ul class="itms opts">
			<?php if(_ChckMd('lopt_shop_ord')){ ?><li class="ord _anm"><button class="_anm" title="Generar Pedido" data-tp-in="shop-ordr">Generar Pedido</button></li><?php } ?>
			<?php if(_ChckMd('lopt_mdl_cnt')){ ?><li class="mdl _anm"><button class="_anm" title="Generar Oportunidad" data-tp-in="mdl_cnt">Generar Oportunidad</button></li><?php } ?>
			<?php if(_ChckMd('lopt_sac')){ ?><li class="sac _anm"><button class="_anm" title="Registrar PQR" data-tp-in="sac">Registrar SAC / Ticket</button></li><?php } ?>
			<!--<li class="pqr"><button>Ticket de Soporte</button></li>-->
		</ul>
		<h2 class="tools">Herramientas</h2>
		<ul class="itms">
			<?php if(_ChckMd('lopt_scrpt')){ ?><li class="scrpt_shct"><button class="_anm" title="Respuestas (Scripts)">Respuestas (Scripts)</button></li><?php } ?>
		</ul> 
	</div>	
</div>

<style>
	
	.dsh_chat_options{}
	.dsh_chat_options h1{ font-family: Economica; font-size: 20px; font-weight: 300; text-align: center; text-transform: lowercase; background-color: #e4e8ea; color: #505254; margin: 0; padding: 20px 0; }	
	.dsh_chat_options h1 button.back{ width:20px; height:20px; display:inline-block; margin-right:10px; background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>ls_bck.svg); background-repeat: no-repeat; background-position:center center; background-size:auto 70%; background-color:transparent; border:none; }
	.dsh_chat_options h1 button.back:hover{ background-size:auto 50%; }

	.dsh_chat_options p.intro{ font-family: Roboto; font-size: 12px; text-align: center; padding: 30px 40px 30px 40px; color: #6b6e70; }
	
	.dsh_chat_options .op_itms h2{ font-family: Economica; font-size: 16px; font-weight: 300; color: #505254; text-transform: lowercase; text-align: center; }
	
	.dsh_chat_options .op_itms h2::after{
		display:inline-block; background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>down_arrow_select.svg); background-repeat: no-repeat; background-position: center bottom; background-size:auto 95%; width: 20px; height: 12px; margin-left: 10px;
	}
	
	.dsh_chat_options .op_itms ul{ padding: 0 50px 0 50px; margin: 0; list-style: none; margin-bottom: 40px; }
	.dsh_chat_options .op_itms ul li{ text-align: center; width: 100%; display: block; margin-bottom: 10px; }
	.dsh_chat_options .op_itms ul li button{ font-family: Economica; font-size: 16px; font-weight: 300; width: 100%; display: block; border-radius:8px; -moz-border-radius:8px; -webkit-border-radius:8px; padding: 10px 5px 10px 40px; border: 1px solid #e7eaeb; color: #9ea6a9; position: relative; overflow: hidden; cursor: pointer; }
	.dsh_chat_options .op_itms ul li button:hover{ color: #565b5c; font-size: 14px; padding-top: 12px; padding-bottom: 12px; }
	.dsh_chat_options .op_itms ul li button:hover::before{ left: -20px; background-color: #fff; }
	
	
	.dsh_chat_options .op_itms ul li button::before{ width: 50px; height: 50px; position: absolute; left: -10px; top: -5px; transform: rotate(20deg); background-repeat: no-repeat; background-position: center center; background-size: auto 60%; border-radius:200px; -moz-border-radius:200px; -webkit-border-radius:200px; background-color: #e9eeef; -webkit-transition-property: all; -moz-transition-property: all; -ms-transition-property: all; -o-transition-property: all; transition-property: all; -webkit-transition-duration: 0.3s; -moz-transition-duration: 0.3s; -ms-transition-duration: 0.3s; -o-transition-duration: 0.3s; transition-duration: 0.3s; -webkit-transition-timing-function: ease; -moz-transition-timing-function: ease; -ms-transition-timing-function: ease; -o-transition-timing-function: ease; transition-timing-function: ease; -webkit-transition-delay: 0s; -moz-transition-delay: 0s; -ms-transition-delay: 0s; -o-transition-delay: 0s; transition-delay: 0s; }
	
	
	.dsh_chat_options .op_itms ul li.ord button::before{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>online_shop.svg); }
	.dsh_chat_options .op_itms ul li.sac button::before{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>mdl_pqr.svg); }
	.dsh_chat_options .op_itms ul li.scrpt_shct button::before{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>write_scrpt_shct.svg); background-size: auto 50%; }
	.dsh_chat_options .op_itms ul li.mdl button::before{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>tml_mdl.svg); }
	
	
	
	.dsh_chat_options.mny{}
	.dsh_chat_options.mny .op_itms{ display: flex; align-items: center; justify-content: center; }
	.dsh_chat_options.mny .op_itms .itms.opts{ margin-right: 15px; }
	
	
	.dsh_chat_options.mny .op_itms ul{ display: flex; padding: 0; align-items: center; justify-content: center; margin:0; }
	.dsh_chat_options.mny .op_itms ul li{ width: 40px; height:40px; margin-bottom: 0; margin-left:2px; margin-right:2px; }
	.dsh_chat_options.mny .op_itms ul li button{ width: 40px; height:40px; border-radius:200px; -moz-border-radius:200px; -webkit-border-radius:200px; text-indent: -500px; overflow: hidden; left: inherit; top: inherit; padding: 0; }
	.dsh_chat_options.mny .op_itms ul li button::before{ left:2px; top:2px; transform: rotate(0deg); width: 34px; height: 34px;  background-size: auto 50%; }
	.dsh_chat_options.mny .op_itms ul li:hover{ width: 35px; height:35px; }
	.dsh_chat_options.mny .op_itms ul li:hover button{ width: 35px; height:35px; }
	.dsh_chat_options.mny .op_itms ul li:hover button::before{ width: 29px; height: 29px; }
	
	
	
	.dsh_chat_options.mny .op_itms h2{ margin: 0; padding: 0; width:30px; height: 30px; text-indent: -5000px; overflow: hidden; position: relative; }
	.dsh_chat_options.mny .op_itms h2::after{ position: absolute; left: 0; top: 0; width: 30px; height: 30px; background-position: center center; background-size: auto 50%; margin: 0; opacity: 0.3; }
	.dsh_chat_options.mny .op_itms h2.opts::after{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>cntopt_opt.svg); }
	.dsh_chat_options.mny .op_itms h2.tools::after{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>cntopt_tools.svg); }
	
	
	
</style>	


<?php

	$CntWb .=	"
			
		$('#dsh_chat_options ul li button').off('click').click(function(e) { 
			
			if(e.target != this){

				e.stopPropagation(); return;

			}else{

				var tp = $(this).attr('data-tp-in');

				if(tp == 'sac'){

					SUMR_Tra.f.new({ cnv:{ id:'".$_GtMainCnvDt->enc."' }, t2:'sac' });

				}else if(tp == 'mdl_cnt'){

					SUMR_Main.mdlcnt.f.new({ cnv:{ id:'".$_GtMainCnvDt->enc."' }  });

				}else{
					if( $('#dsh_chat_options').hasClass('mny') ){
						/*$('#dsh_chat_options').removeClass('mny');*/
					}else{
						$('#dsh_chat_options').addClass('mny');
					}
				}
	
				console.log('Get Data of Channel '+SUMR_Main.msve.chnl);

			}
			
		});
			
	"; 
		
?>

