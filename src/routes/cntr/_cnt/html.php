<?php 
	$__Rnd = Gn_Rnd(5);
	$_cntrsht = CntrDt(['id'=>$__pm_2,'tp'=>'enc','bd'=>$__cl->bd]);
	
	if(!isN($_cntrsht->lgo)){ $_logo = $_cntrsht->lgo; }else{ $_logo = '9b79793a5d7fcdba78536b724dcc65be9b210cbf.svg'; }
		
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Letter</title>
		<!-- Normalize or reset CSS with your favorite library -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">
		<!-- Load paper.css for happy printing -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">
		<!-- Set page size here: A5, A4 or A3 -->
		<!-- Set also "landscape" if you need -->
		<style>
			*{ font-family: Roboto; font-size: 12px; text-align: justify; }	
			@page { size: letter }
			section.sheet::before{ content:' '; display: block; background-image: url(<?php echo DMN_FLE_CNTRC.$_logo.'?'.$__Rnd; ?>); background-repeat: no-repeat; background-position: right center; background-size: auto 100%; height: 60px; margin-bottom: 40px; }
			p.num_page{position: absolute;bottom: 0;right: 20px;padding: 7px 10px;border-radius: 50%;color: #7b7b7b;font-size: 14px; }
			
			.idc-box ul{ list-style-type: none }
			.idc-box ul li .div {display: flex;border-bottom: 2px dotted black;margin: 5px 0;}
			.idc-box ul li .div p:first-child {flex: 1;position: relative;}
			.idc-box ul li .div p span {border: 2px solid white;position: absolute;top: 2px;}
			.idc-box ul li .div .pg{border: 2px solid white;position: relative;top: 2px;}
			.idc-box ul li .div p {margin: 0;}

		</style>
	</head>
	<!-- Set "A5", "A4" or "A3" for class name -->
	<!-- Set also "landscape" if you need -->
	<body class="letter">
		<!-- Each sheet element should have the class "sheet" -->
		<!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25 -->
		
		<?php
			
			$cnt_appl_attr = __LsDt(['k'=>'appl_attr']);
			$cnt_attr = __LsDt(['k'=>'cnt_attr']);
	
			foreach($cnt_appl_attr->ls->appl_attr as $ky => $vl){
				if( !isN($_cntrsht->appl_attr->ls->{$ky}) ){
					$__Forms->{$vl->cns} = $_cntrsht->appl_attr->ls->{$ky}->dt->tt;
				}
			}
			
			foreach($_cntrsht->fnc_act->cd as $k => $vl){
				$__Forms->{'prnt_cd_'.$vl->rel->Key->vl} = $vl->cd->tt;			
			}
			
		 	$i = 1;
		 	
		 	$__Forms->cnt_nm = $_cntrsht->cnt->nm;
		 	$__Forms->cnt_ap = $_cntrsht->cnt->ap;
		 	$__Forms->cnt_dc_tp = $_cntrsht->cnt->dc_tp;
		 	$__Forms->cnt_dc = $_cntrsht->cnt->dc;
		 	$__Forms->fnc_act_nm = $_cntrsht->fnc_act->nm;
		 	$__Forms->fnc_act_ap = $_cntrsht->fnc_act->ap;
		 	$__Forms->fnc_act_dc_tp = $_cntrsht->fnc_act->dc_tp;
		 	$__Forms->fnc_act_dc = $_cntrsht->fnc_act->dc;	
		 	$__Forms->cnt_uni = $_cntrsht->fnc_act->dc;	 	
		 	$__Forms->id_cntrc = $_cntrsht->cntrc_id;

			foreach($_cntrsht->ls as $k => $v){
				echo '<section class="sheet padding-10mm">'.$__Forms->CntrcHtml($v->html).'<p class="num_page">'.$i++.'</p></section>';
			}
		?>
	</body>
</html>
<script type="text/javascript">

	<?php $___font = __font(); ?>
	<?php if(!isN($___font->js->string)){ ?> var WebFontConfig = {  google: {families: <?php echo $___font->js->string; ?> },  timeout: 2000  }; <?php } ?>
	
	var __ldsnd={};
	var SUMR_Main={slc:{ sch:''}};
	
	function __ld_all(){
	
		SUMR_Ld.f.js({
	
			t:'c',
			u:'jquery.js',
			c:function(){
	
				$('body').addClass('SUMR_Rqu');
	
				SUMR_Ld.f.js({ t:'c', u:'jquery-ui.js' });
		
				$(document).ready(function(){

					<?php echo $_CntJQ_Vld; ?>
					<?php echo $_CntJQ; ?>							

					SUMR_Ld.f.js({
						u:'https://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js',
						c:function(){

							SUMR_Ld.f.js({
								u:'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.11.0/jquery.validate.min.js',
								c:function(){

									SUMR_Ld.f.js({
										u:'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.full.min.js', 
										c:function(r){

											if(!SUMR_Ld.f.isN(r)){

												if(!SUMR_Ld.f.isN(r.isTrusted) && r.isTrusted){

													if (jQuery.fn.select2) {

														$.validator.messages.required = "Obligatorio"; 
														$.validator.messages.email = "Formato erroneo"; 
														$.validator.messages.digits = "Debe ser numero"; 

														SUMR_Ld.f.css({ t:'p', h:'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css' });
														SUMR_Ld.f.js({ 
															u:'<?php echo DMN_JS ?>flatpickr.js',
															c:function(){

																SUMR_Ld.f.js({ 
																	u:'<?php echo DMN_JS ?>flatpicker/es.js',
																	c:function(){

																		flatpickr.localize(flatpickr.l10ns.es);
																		<?php echo $_CntJQ_S2; ?>

																		$('body').addClass('on');
																	}
																});
															}
														});
													}
												}
											}	
										}   
									});
								}
							});
						}	    
					});
				});
	
				$(window).on('load',function(){
					$('#snd').off('click').click(function(){
						$.ajax({
							type: "POST",
							url: "_prc.php",
							data: $('#cntr').serialize()		
						});		
					});     
				}); 
			}
		});	
	}
</script>
<script type="text/javascript" src="<?php echo DMN_JS ?>_ld.js<?php if(Dvlpr()){ echo '?__r='.Enc_Rnd('r'); } ?>" async></script>