<?php
	$__inf_fm = 'fm'; $_inf_cls = 'FmInf';
	$_LrnLs = GtLrnDt();
?>
<div class="Cvr_Dcs">
    <div class="_lrn_dv">
	    <div class="_lrn_ls" >
		    <div id="___hdr_tab<?php echo $___Dt->id_rnd; ?>" class="_anm"></div>
	    	<?php
				$__clps_i=1;
				foreach($_LrnLs as $_k => $_v){
					if(!isN($_v->id)){
			?>
						<div id="<?php echo "_lrn_".$_v->enc ?>" class="CollapsiblePanel">
						<div class="CollapsiblePanelTab _lrn _lrn_dv_<?php echo $_v->enc ?>"><?php echo $_v->tt ?><a class="_lrn_drc" style="background-image: url(<?php echo $_v->img->big; ?>); "></a></div>
					        <div class="CollapsiblePanelContent">
					          	<?php
									foreach($_v->vds as $_k_vd => $_v_vd){
										if($_v_vd->id != ''){
											echo "<a class='_vd _vd_".$_v_vd->enc." _anm' id='".$_v_vd->enc."'>".$_v_vd->tt."</a>";
											$CntWb .= '
												_lrn_vd_on_'.$_v_vd->enc.' = "no";
												$("._vd_'.$_v_vd->enc.'").click(function(){ });
											';
										}
									}
								?>
					        </div>
					    </div>
						<?php

						/*if($__clps_i == 1){*/ $_opn='true'; /* }else{ $_opn='false'; }*/

						$CntWb .= 'var _lrn_'.$_v->enc.' = new Spry.Widget.CollapsiblePanel("_lrn_'.$_v->enc.'", {contentIsOpen:'.$_opn.'});';
						$CntWb .= '

							$("._lrn_dv_'.$_v->enc.'").click(function(){
								if($("._lrn_dv_'.$_v->enc.'").hasClass("_lrn_dv_clk")){
									$("._lrn_dv_'.$_v->enc.'").removeClass("_lrn_dv_clk");
								}else{
									$("._lrn_dv_'.$_v->enc.'").addClass("_lrn_dv_clk");
								}
							});

							$(".Cvr_Dcs ._vd").click(function(){

								var _id = $(this).attr("id");
								var _cvr = $(".Cvr_Dcs ._cvr");
								var _cvr_bx = $("#___cvr'.$___Dt->id_rnd.'");
								var _cvr_hd = $("#___hdr_tab'.$___Dt->id_rnd.'");
								var _cvr_if = $(".Cvr_Dcs ._cvr iframe");
								var _intro = $(".Cvr_Dcs ._intro");


								if( !isN(_cvr)){
									if(_cvr.length > 0){
										_cvr.delay(300).show();
										if(_cvr.length){
											if(!_cvr_hd.hasClass("_on")){
												_intro.fadeOut("fast");
												_cvr_bx.prependTo("#___hdr_tab'.$___Dt->id_rnd.'");
												_cvr_hd.addClass("_on");
												_cvr_if.height(100);
											}
										}
									}
								}



								_lrn_json({
									"_id":_id,
									"_tp":"_vd",
									"_cl":function(_r){
										if(_r!="" && _r!="undefined" && _r!=null){

											if(_r.e == "ok" && !isN(_r.url)){

												$("#_vd_enc").val(_id);

												$("._lrn_html").hide("slide", { direction: "left" });
												$("._lrn_html_2").hide("slide", { direction: "left" });
												$("._lrn_cmnt").removeClass("_cmnt_ok");
												$("._lrn_inf").removeClass("_inf_ok");
												_inf = "no";

												$("._vd").removeClass("_vd_clk");
												$("._vd_"+_id).addClass("_vd_clk");

												_vd_enc = _id;
												Lrn_Str({ "url":_r.url });

												$("._lrn_cmnt").attr("id", "_lrn_cmnt_"+_id).attr("rel", _id);
												$("._lrn_inf").attr("id", "_lrn_inf_"+_id).attr("rel", _id);

												$("._lrn_cmnt, ._lrn_inf").show();

											}else{
												swal("Apreciado usuario", "Este video no esta disponible", "info");
											}
										}
									}
								});

							});

						';

						$__clps_i++;
					}
				}


			?>
		</div>
		<div class="_lrn_vd">

			<div class="_intro">
				<section class="_cvr" style="background-color:#fff081;" id="___cvr<?php echo $___Dt->id_rnd; ?>">
			        <iframe src="<?php echo DMN_ANM; ?>centro_de_aprendizaje/index.html" frameborder="0" width="100%" scrolling="no" height="200" class="_anm"></iframe>
			    </section>
			    <section class="_p">
					<div class="_c c1">
						<h2>Comencemos</h2>
						<div class="_img books"></div>
						<p>Esta sección de nuestra herramienta está diseñada para ayudarte en el proceso de aprendizaje y a mejorar tu experiencia con ella. Construimos de forma constante y didáctica todo el material para acelerar tu curva de aprendizaje e impactar de manera positiva los procesos de implementación de nuestra aplicación.</p>
					</div>
					<div class="_c c2">
						<h2>Video-Tutoriales</h2>
						<div class="_img studnt"></div>
						<p>Consulta todas las secciones ubicadas en la barra lateral, a través de diferentes cápsulas u objetos de aprendizaje, donde podrás conocer paso a paso cómo desarrollar cada acción o actividad dentro de nuestra aplicación. Consulta el botón más información para obtener detalles e incluso deja tus comentarios sobre estos.</p>
					</div>
					<div class="_c c3">
						<h2>Mejoramiento</h2>
						<div class="_img knw"></div>
						<p>Conoce en detalle el manejo de nuestra herramienta y tu rol asignado, de esta manera podrás impactar de manera positiva tu área y así lograr actividades sistematizadas, organizadas y con medición que apunten al mejoramiento continuo de los diferentes procesos comerciales, estratégicos y operativos de tu organización.</p>
					</div>
			    </section>
			</div>



			<div class="_lrn_inf"></div>

			<div class="_lrn_html" id="_lrn_html">
				<div class="_lrn_ldr"></div>
			</div>

			<div class="_lrn_html_2" id="_lrn_html_2">
				<div class="dv_new_cmnt">
					<?php echo HTML_inp_hd('_vd_enc', ''); ?>
					<a href="javascript:void(0)" id="_new_cmnt" name="_new_cmnt" class="_new_cmnt" style="text-align: center; display: block;">Agregar Comentario</a>
					<div id="dv_new_<?php echo $___Ls->id_rnd; ?>" name="dv_new_<?php echo $___Ls->id_rnd; ?>" class="dv_new">
						<div class="_cmnt_cls"></div>
						<textarea id="_cmnt_add" class="_cmnt_add" ></textarea>
						<a href="javascript:void(0)" id="_sve_cmnt" name="_sve_cmnt" class="_sve_cmnt" style="text-align: center; display: block;">Guardar</a>
					</div>
					<div id="div_cmnt"></div>
				</div>
				<div class="_lrn_ldr"></div>
			</div>

			<div class="_lrn_cmnt"></div>
			<div class="_lrn_ifrm" id="player" style="display:none;"></div>


		</div>
    </div>
</div>
<!--<link rel="stylesheet" href="../../includes/_sty/_fl/jplayer.css" type="text/css"/>
<script type="text/javascript" src="../../includes/_js/jplayer.js"></script>-->
<?php
	$CntWb .= '$(".FmInf").colorbox({width:"950", height:"650", overlayClose:false, escKey:false, onLoad:function(){ $("#colorbox").removeAttr("tabindex");}, onClosed:function(){ SUMR_Main.anm.h_cmpct();} });';
	$CntWb .= '$(".FmPop").colorbox({width:"'.CLRBX_WD_POP.'", overlayClose:false, escKey:false, onClosed:function(){ SUMR_Main.anm.h_cmpct();} });';
	$CntWb .= '$(".FmPopBsc").colorbox({overlayClose:false, escKey:false});';
	$CntWb .= '$(".LsPop").colorbox({width:"95%", height:"90%", overlayClose:false, escKey:false});';
	$CntWb .= '$(".PlnsPop").colorbox({ onClosed:function(){ SUMR_Main.anm.h_cmpct();} }); ';
	$CntWb .= '$(".FmInf, .FmPop, .FmPopBsc, .LsPop, .PlnsPop").click(function() { SUMR_Main.anm.h_cmpct("on"); });';
	$CntWb .= '

		_inf = "no";

		$("._lrn_inf").click(function(){
			var _id = $(this).attr("rel");
			if(_inf == "no"){
				$("._lrn_ldr").show();
				$("._lrn_html").html("<div class=\"_lrn_ldr\"></div>");
				$("._lrn_html").show("slide", { direction: "left" });
				$("._lrn_inf").addClass("_inf_ok");
				$("._lrn_cmnt").removeClass("_cmnt_ok");
				_lrn_json({
					"_tp":"_inf",
					"_id":_id,
					"_cl":function(_r){
						if(_r!="" && _r!="undefined" && _r!=null){
							$("._lrn_html").html(_r.dsc);
							$("._lrn_ldr").hide();
						}
					}
				});
				_inf = "ok";
			}else{
				$("._lrn_html").hide("slide", { direction: "left" });
				$("._lrn_html_2").hide("slide", { direction: "left" });
				$("._lrn_inf").removeClass("_inf_ok");
				$("._lrn_cmnt").removeClass("_cmnt_ok");
				_inf = "no";
			}
		});

		$("._lrn_cmnt").click(function(){
			var _id = $(this).attr("rel");
			if(_inf == "no"){
				$("._lrn_ldr").show();
				$("._lrn_html_2").show("slide", { direction: "left" });
				$("._lrn_cmnt").addClass("_cmnt_ok");
				$("._lrn_inf").removeClass("_inf_ok");
				_lrn_json({
					"_tp":"_cmnt",
					"_id":_id,
					"_cl":function(_r){

						if( !isN(_r) ){

							$("#div_cmnt").html("");
							if( !isN(_r.ls) ){
								$.each(_r.ls, function(k, v) {
									$("#div_cmnt").append("<div class=\"_cmnt\"><span>"+v.us+" - "+v.fi+"</span>"+v.tx+"</div>");
								});
							}

							$("._new_cmnt").click(function(){ $(".dv_new").show(""); });
							$("._cmnt_cls").click(function(){ $(".dv_new").hide(""); });
							$("._lrn_ldr").hide();
						}

					}
				});
				_inf = "ok";
			}else{
				$("._lrn_html").hide("slide", { direction: "left" });
				$("._lrn_html_2").hide("slide", { direction: "left" });
				$("._lrn_cmnt").removeClass("_cmnt_ok");
				$("._lrn_inf").removeClass("_inf_ok");
				_inf = "no";
			}
		});

		$("._sve_cmnt").click(function(){
			sve_cmnt({ "_id":$("#_vd_enc").val() });
		});

		function sve_cmnt(_p){
			if($("._cmnt_add").val() != ""){
				_lrn_json({
					"_tp":"_cmnt_new",
					"_id":_p._id,
					"_cmnt": $("._cmnt_add").val(),
					"_cl":function(_r){
						if(_r!="" && _r!="undefined" && _r!=null){
							$(".dv_new").hide("slow");
							$("._cmnt_add").val("");

							$("#div_cmnt").html("");
							if( !isN(_r.ls) ){
								$.each(_r.ls, function(k, v) {
									$("#div_cmnt").append("<div class=\"_cmnt\"><span>"+v.us+" - "+v.fi+"</span>"+v.tx+"</div>");
								});
							}

						}
					}
				});
			}
		}

		function _lrn_json(_p){
			$.ajax({
				type:"POST",
				url:"'.FL_JSON_GN.__t('lrn', true).'",
				data:_p,
				beforeSend: function() {

				},
				success:function(r){
					if(!isN(_p._cl)){
						_p._cl(r);
					}
				}
			});
		};

		function Lrn_Str(p=null){
			$("._lrn_ifrm").html("<iframe width=\"100%\" height=\"100%\" src=\"https://www.youtube.com/embed/"+p.url+"?rel=0&showinfo=0\" frameborder=\"0\" allow=\"autoplay; encrypted-media\" allowfullscreen></iframe>").fadeIn("fast");
		}

		/* Videos por youtube */
		/*tag = document.createElement("script");
		tag.src = "https://www.youtube.com/iframe_api";
      	firstScriptTag = $("script")[0];
      	firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

		function Lrn_Str(p=null) {

			player = new YT.Player("player", {
			  height: "100%;",
			  width: "100%",
			  videoId: p.url,
			  playerVars: { "autoplay": 1, "controls": 0, "rel":0, "showinfo":0 },
			  events: {
			    "onReady": onPlayerReady,
			    "onStateChange": onPlayerStateChange
			  }
			});
		}

		function onPlayerReady(e) {
			e.target.playVideo();
		}

		var done = false;
		function onPlayerStateChange(e) {

			var _tme = parseInt(player.j.currentTime);

			if (e.data == YT.PlayerState.PLAYING) {
				_lrn_json({
					"_id":_vd_enc,
					"_tp":"_act",
					"_act":"play",
					"_tme":_tme
				});
			}else if(e.data == YT.PlayerState.PAUSED){
				_lrn_json({
					"_id":_vd_enc,
					"_tp":"_act",
					"_act":"stop",
					"_tme":_tme
				});
			}else if(e.data == YT.PlayerState.ENDED){
				alert(22222);
			}


		}*/

	';

	include('lrn_css.php');

?>