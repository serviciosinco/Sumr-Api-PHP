<?php 
	
	
	$__usd = GtUsDt( PrmLnk('rtn', 3, 'ok'), 'enc');
	$__ecd = GtEcDt( PrmLnk('rtn', 2, 'ok'), 'enc');
	
	
	$__ec = new API_CRM_ec();
	$__ec->id = PrmLnk('rtn', 2, 'ok');
	$__ec->id_t = 'enc';
	$__ec->mdlc = $__mdlC;
	$__ec->evnc = $__evnC;
	$__ec->mdli = $__mdlI;
	$__ec->evni = $__evnI; 
	$__ec->frm = 'Ml';
	$__ec->html = 'ok';
	
	if($__scl == 'no'){
		$__ec->ec_scl = 'no';
	}
	
	if($__tll == 'no'){
		$__ec->ec_tll = 'no';
	}
	
	$__ec->sve_url = $__l;
	$__ec->snd_i = $__s;
	$__ec->edt = $__edit;
	$__ec->sc = $__sc;

	
	if($__ecd->est->id == _CId('ID_SISEST_APRB')){ $__aprb_js = "_aprb();"; }
	
	$__ec->html_mre = '	<link href="'.DMN_EC.'inc/sty/all.css?_t=aprb" rel="stylesheet" type="text/css">
						<link href="https://fonts.googleapis.com/css?family=Oswald|Roboto" rel="stylesheet" type="text/css"></link>
						<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
						<script type="text/javascript" src="'.DMN_EC.'inc/js/js.js"></script>

						
						<div class="ec_actv">					   		
					   		<button class="c_est _anm" id="send-aprobation">Aprobar</button>					   		
					   		<div class="_cmn">
					   			<div class="_snd">
					   				<div class="c1"><div class="us" style="background-image:url('.(!isN($__usd->img->sm_s)?$__usd->img->sm_s:$__usd->img).');"></div></div>
					   				<div class="c2">
					   					<textarea rows="5" cols="5" class="_anm" placeholder="'.$__usd->nm.' dice..." id="comment-text"></textarea>
					   					<div class="btn" id="send-comment"><button>Dilo</button></div>
					   				</div>
					   			</div>
					   		</div>	
					   		
					   		<div id="comments" class="comments">
					   		</div>
					   	</div>
					   	
					   	<script>
					   		
					   		function _aprb(){
								$("#send-aprobation").addClass(\'_aprb\');	
								$("#send-aprobation").text("Aprobado");
								$("#_mrk_bx, #_noaprbd_bx").fadeOut();
							}	
								
							function _cmnt_get(){
								
								__cmnt({
									_t:"aprb_cmnt",
									_d:{
										_us:"'.$__usd->enc.'",
										_ec:"'.$__ecd->enc.'",
									},
									_c:function(d){
										if(!isN(d)){
											if(d.e == \'ok\'){
												$(\'#comments\').html( d.html );
											}
										}
									}
								});
								
							}
								
					   		
					   		$(document).ready(function() {
								
								
								
								
								
								$("#send-comment").off("click").click(function (){
									
									___com = $("#comment-text").val();
									
									__sve({
										_t:"aprb",
										_d:{
											MM_insert:"AprbCom",
											_us:"'.$__usd->enc.'",
											_tx:___com,
											_ec:"'.$__ecd->enc.'",
											_s:"comment"
										},
										_c:function(d){
											if(!isN(d)){
												if(d.e == "ok"){
													$("#comment-text").val(\'\');	
													_cmnt_get();
												}
											}
										}
									});
								});
								
								
								$("#send-aprobation").off("click").click(function (){
									
									__sve({
										_t:"aprb",
										_d:{
											MM_update:"Aprb",
											_us:"'.$__usd->enc.'",
											_ec:"'.$__ecd->enc.'",
										},
										_c:function(d){
											if(d.e == "ok"){
												
												_aprb();
												_cmnt_get();
												
											}
										}
									});
									
								});
								
								
								_cmnt_get();
								'.$__aprb_js.'
							
							});
					   		
					   	</script>
					   	
					   	';
	
	$__body = $__ec->_bld();				
	$__html = 'ok';
	
	
	if($__edit == 'ok'){ 
		$__ec->_EcUpd_Fld([ 'id'=>$__ec->__dtec->id, 'f'=>'ec_upd_img', 'v'=>1 ]);
	}
	
	
	echo $__body;
	
?>