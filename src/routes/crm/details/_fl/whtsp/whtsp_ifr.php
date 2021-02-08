<?php

	if(defined('SISUS_MSV_USER') && !isN(SISUS_MSV_USER)){
		
		$__massive = new API_CRM_Massive();
		$__lgin = $__massive->us_lgin([ 'us'=>SISUS_MSV_USER ]);

		if(isN($__lgin->rsl->token)){
			$___clss = 'no_login';
			$___title = h1('No authorization code for '.SISUS_MSV_USER); 
			$___subtitle = h2($__lgin->rsl->message); 
		}/*else{
			$CntWb .= '	
				console.log("'.$__lgin->rsl->token.'"); 
				console.log("User:'.SISUS_MSV_USER.'"); 
				console.log("https://server.massivespace.rocks/login?authorization='.$__lgin->rsl->token.'"); 
			';
		}*/
		
	}else{
		
		$___clss = 'no_user';
		$___title = h1('No tienes este módulo activo'); 
		$___subtitle = 'Permite que uno de nuestros asesores te ayude';

	}	
	
?>
<div class="Dsh_Whtsp _anm <?php echo $___clss; ?>">
	
	<?php if(isN( $___clss )){ ?>
	<div class="c1 _anm">
		<div class="_ui"></div>
		<div class="_bx _anm">
			<?php echo '<div class="_icn"></div>'; ?>
			<?php echo h1('Cargando Componentes...'); ?>
			<!--<a href="https://s.sumr.co/cec9" target="_new">Iniciar Conversación</a>-->
		</div>
	</div>
	<div class="c2 _anm">
		<div class="Dsh_Whtsp_Opt" id="Dsh_Whtsp_Opt"></div>	
	</div>
	
	<script>

		SUMR_Main.msve = {
			chnl:'',
			ui:{ on:'' },
			o:{},
			on:false,
			try:0,
			f:{
				chk:()=>{
					try{

						setTimeout(function(){ 	
							if(!SUMR_Main.msve.on){
								console.log('Check if is on, instead logout');
								SUMR_Main.msve.f.ses.out({ id:'<?php echo $___Dt->id_rnd; ?>' });
								SUMR_Main.msve.f.chk();
								setTimeout(function(){
									SUMR_Main.msve.f.ld();
								}, 3000);
							}
						}, 10000);

					}catch(e) {
						SUMR_Main.log.f({ m:e });
					}
				},
				rdy:function(){
					$('.Dsh_Whtsp').addClass('rdy');
					SUMR_Main.msve.f.chk();
				},
				ld:function(p){	
					
					if( $('#Dsh_Whtsp_Ifr<?php echo $___Dt->id_rnd; ?>').length == 0 ){	
						
						$(".Dsh_Whtsp ._ui").append('<iframe id="Dsh_Whtsp_Ifr<?php echo $___Dt->id_rnd; ?>" class="Dsh_Whtsp_Ifr _anm" width="100%" border="0" style="height: auto;  margin-top: -57px; min-height:700px; border: none; "></iframe><!--<button onClick="SUMR_Main.msve.f.ses.out();">Send Close</button>-->');
						
						SUMR_Main.msve.o.box = $('#Dsh_Whtsp_Ifr<?php echo $___Dt->id_rnd; ?>');
						if(!isN(p) && !isN(p.noa) && p.noa == 'ok'){ var m=''; }else{ var m='authorization=<?php echo $__lgin->rsl->token; ?>'; }
						document.getElementById('Dsh_Whtsp_Ifr<?php echo $___Dt->id_rnd; ?>').onload = ()=>{ SUMR_Main.msve.f.rdy(); };
						document.getElementById('Dsh_Whtsp_Ifr<?php echo $___Dt->id_rnd; ?>').src = 'https://server.massivespace.rocks/login?'+m;
						SUMR_Main.msve.f.rsze();
					}

				},
				ses:{
					out:function(p){
						if(!isN(p) && !isN(p.id) && $('#Dsh_Whtsp_Ifr'+p.id).length > 0){
							var wn = document.getElementById('Dsh_Whtsp_Ifr'+p.id).contentWindow;
							wn.postMessage({ 'action_type': 'logout' }, '*');
						}
					}
				},
				init:function(){

					
					$(window).resize(function() {
						SUMR_Main.msve.f.rsze();
					});
					
					$(document).keydown(function(e) {
						if (e.keyCode == 65 && e.ctrlKey) {
							alert('Some action to paste');
						}
					});

					SUMR_Main.free.add(function(){

						SUMR_Main.msve.f.ses.out({ id:'<?php echo $___Dt->id_rnd ?>' });
						
						setTimeout(function(){
							$("#Dsh_Whtsp_Ifr<?php echo $___Dt->id_rnd ?>").appendTo(".___CpyBx");
						}, 1000);

					});

					$(window).off("message").on("message", function(m){

						if( m.originalEvent.origin != "https://server.massivespace.rocks" ){
							
							return false;
							
						}else{
							
							SUMR_Main.msve.chnl = null;
							
							SUMR_Main.ld.f.lopt(
								function(){
									/*SUMR_Lopt.f.shw();*/
								}
							);

							var p = JSON.parse(m.originalEvent.data); console.log( p );
							
							if(!isN(p) && !isN(p.type)){
								
								SUMR_Main.msve.ui.on = p.type;

								if(p.type == "logout_success"){

									SUMR_Main.log.f({ m:'Logout Massive' });
									$("#Dsh_Whtsp_Ifr<?php echo $___Dt->id_rnd ?>").remove();

								}else if(p.type == "login_success"){
									
									SUMR_Main.msve.on = true;

									setTimeout(function(){
										$(".Dsh_Whtsp").addClass("on");
										SUMR_Main.msve.f.rsze();
									}, 2000);

								}else if(p.type == "login_fail"){
									
									SUMR_Main.msve.f.ses.out({ id:'<?php echo $___Dt->id_rnd; ?>' });

									setTimeout(function(){
										
										if(SUMR_Main.msve.try > 3){ var noa="ok"; }else{ var noa=""; }
										SUMR_Main.msve.try++;
										SUMR_Main.msve.f.ld({ noa:noa });

									}, 3000);

								}else if(p.type == "list_channel"){	
										
								}else if(p.type == "active_channel"){

									if(!isN(p.channel) && !isN(p.channel.id)){	
										SUMR_Main.msve.chnl = p.channel.id;
										/*SUMR_Lopt.f.opn({ off:'ok' });*/
										SUMR_Lopt.f.shw({ e:"o" });	
									}
									
								}else if(p.type == "dashboard"){

									setTimeout(function(){
										$(".Dsh_Whtsp").addClass("on");
									}, 2000);

								}

								SUMR_Main.msve.f.rsze();
									
							}
							
						}

					});	

					SUMR_Lopt.f.dom();
					SUMR_Lopt.f.shw({ e:"o" });	
					
				},
				rsze:function(){

					var wh = $(window).height();

					if(SUMR_Main.msve.ui.on == 'active_channel'){
						var _h = wh-10;
					}else if(SUMR_Main.msve.ui.on == 'list_channel'){
						var _h = wh+2000;
					}else if(SUMR_Main.msve.ui.on == 'dashboard'){
						var _h = wh+2000;
					}

					SUMR_Main.msve.o.box.css('min-height', _h).css('max-height', _h);

				}
			}
		};

	</script>	
	
	<?php }else{ ?>
		
		<div class="_bx">
			<?php echo '<div class="_icn"></div>'; ?>
			<?php echo $___title; ?>
			<?php echo $___subtitle.HTML_BR.HTML_BR; ?>
			<!--<a href="https://s.sumr.co/cec9" target="_new">Iniciar Conversación</a>-->
		</div>

	<?php } ?>

</div>


<style>

	


	.Dsh_Whtsp{ position: relative; display: flex; overflow: visible; }
	.Dsh_Whtsp .c1{ width: 100%; }
	.Dsh_Whtsp .c2{ opacity: 0; margin-right: -10px; pointer-events: none; }
	
	.Dsh_Whtsp:not(.on) .c1 .Dsh_Whtsp_Ifr{ opacity:0; pointer-events:none; }
	.Dsh_Whtsp:not(.on) .c1 ._bx{ width:100%; height:100%; position:absolute; left:0; top:0; padding:200px 0 50px 0; text-align:center; }
	.Dsh_Whtsp:not(.on) .c1 ._bx ._icn{ -webkit-animation: _puff 0.8s cubic-bezier(.5, 0, 1, 1) infinite alternate; animation: _puff 0.8s cubic-bezier(.5, 0, 1, 1) infinite alternate; background-image:url(<?php echo DMN_IMG_ESTR_SVG ?>whatsapp_nomdl.svg); width:200px; height:200px; display:block; margin-left:auto; margin-right:auto; }
	.Dsh_Whtsp:not(.on) .c1 ._bx h1{ animation: _blnk_ldr 0.8s cubic-bezier(.5, 0, 1, 1) infinite alternate; font-family:Economica; }
	.Dsh_Whtsp.on .c1 ._bx{ display:none; }


	.Dsh_Whtsp._new_opt .c1{ width: 75%; }
	.Dsh_Whtsp._new_opt .c2{ width: 25%; opacity: 1; pointer-events: all; margin-right: 0; }
	
	.Dsh_Whtsp .Dsh_Whtsp_Opt{ overflow: hidden; height: auto; }
	
	.Dsh_Whtsp.no_login,
	.Dsh_Whtsp.no_user{ display:block; text-align:center; }
	
	.Dsh_Whtsp.no_login ._bx,
	.Dsh_Whtsp.no_user ._bx{ padding-top:150px; padding-bottom:150px; text-align:center; }

	.Dsh_Whtsp.no_login ._bx ._icn,
	.Dsh_Whtsp.no_user ._bx ._icn{ background-image:url(<?php echo DMN_IMG_ESTR_SVG ?>whatsapp_nomdl.svg); width:200px; height:200px; display:block; margin-left:auto; margin-right:auto; }

	.Dsh_Whtsp.no_login ._bx h1,
	.Dsh_Whtsp.no_user ._bx h1{ font-family:Economica; }
	
	.Dsh_Whtsp.no_login ._bx h2,
	.Dsh_Whtsp.no_user ._bx h2{ font-family:Economica; color:#ccc; }
	

	.Dsh_Whtsp.no_login ._bx a:link,
	.Dsh_Whtsp.no_user ._bx a:link{ color:#999; font-family:Economica; text-transform:uppercase; text-decoration:none; display:inline-block; padding: 10px 15px; background-color:#e6e6e6; width:auto; border-radius:10px; -moz-border-radius:10px; -webkit-border-radius:10px; }


</style>

<?php $CntWb .= ' SUMR_Main.msve.f.init(); SUMR_Main.msve.f.ld(); '; ?>