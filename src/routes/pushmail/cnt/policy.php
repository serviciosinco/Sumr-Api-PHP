<!doctype html>
<html lang='es' class='no-js'>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Política de datos</title>
<link href="<?php echo DMN_EC; ?>inc/sty/all.css?_t=vrfy" rel="stylesheet" type="text/css">
<base href="/" target="_self">
<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" /> 
<body class="<?php if($_vrf_tp == 'ok'){ echo '_ok'; }else{ echo '_no'; } ?>">
	
	<?php //<figure class="_logo"></figure> ?>
	
	<figure class="_logo" style="background-image: url(<?php echo $_cl_dt->lgo->lght->big ?>) !important; "></figure>			
	
	<section class="_wrp">
		<?php 
			
			if(!isN($__dtsnd->cmpg) && !isN($__dtsnd->cmpg->lsts)){
				
				$__Cnt = new CRM_Cnt([ 'cl'=>$_cl_dt->id ]);
				
				foreach($__dtsnd->cmpg->lsts->ls as $lsts_k=>$lsts_v){	

					$____plcy = GtEcLstsPlcyLs([ 'eclsts'=>$lsts_v->id, 'cl'=>$_cl_dt->enc, 'rl'=>'on' ]);

					if($____plcy->tot > 0){ 

						foreach($____plcy->ls as $plcy_k=>$plcy_v){

							if($plcy_v->sndi == 'ok'){
								
								$__li .= li('<a href="'.$plcy_v->url.'">'.$plcy_v->nm.' (v'.$plcy_v->v.')</a>');
								
								if($_vrf_tp == 'ok'){ $_p_est = 1; }elseif($_vrf_tp == 'no'){ $_p_est = 2; }
								
								//------------ Set Policy to Email ------------//
								
									$__chk_eml = $__Cnt->CntEmlPlcyChk([ 'cnteml'=>$__dtsnd->eml->id, 'plcy'=>$plcy_v->id ]);
									
									if($__chk_eml->e == 'ok' && !isN($__chk_eml->id) && !isN($_p_est)){
										$__prc_eml = $__Cnt->UpdCntEml_Plcy([ 'id'=>$__chk_eml->id, 'sndi'=>$_p_est ]);			
									}
								
								//------------ Set Policy to Cnt ------------//
								
									$__chk_cnt = $__Cnt->CntPlcyChk([ 'cnt'=>$__dtsnd->cnt->id, 'plcy'=>$plcy_v->id ]);
									
									if($__chk_cnt->e == 'ok' && !isN($__chk_cnt->id) && !isN($_p_est)){
										$__prc_cnt = $__Cnt->UpdCnt_Plcy([ 'id'=>$__chk_cnt->id, 'sndi'=>$_p_est ]);			
									}
								
								//------------ End - Set Policy ------------//
								
							}	

						}

					}	

				}
				
			}elseif(!isN($__dtsnd) && !isN($__dtsnd->plcy->id)){

				$__Cnt = new CRM_Cnt([ 'cl'=>$_cl_dt->id ]);

				if($_vrf_tp == 'ok'){ $_p_est = 1; }elseif($_vrf_tp == 'no'){ $_p_est = 2; }
				
				//------------ Set Policy to Email ------------//
								
					$__chk_eml = $__Cnt->CntEmlPlcyChk([ 'cnteml'=>$__dtsnd->eml->id, 'plcy'=>$__dtsnd->plcy->id ]);
										
					if($__chk_eml->e == 'ok' && !isN($__chk_eml->id) && !isN($_p_est)){
						$__prc_eml = $__Cnt->UpdCntEml_Plcy([ 'id'=>$__chk_eml->id, 'sndi'=>$_p_est ]);			
					}else{
						$__Cnt->plcy_id = $__dtsnd->plcy->id;
						$__Cnt->cnteml_sndi = $_p_est;
						$__prc_eml = $__Cnt->InCntEml_Plcy([ 'cnteml'=>$__dtsnd->eml->id ]); 
					}
				
				//------------ Set Policy to Cnt ------------//
				
					$__chk_cnt = $__Cnt->CntPlcyChk([ 'cnt'=>$__dtsnd->cnt->id, 'plcy'=>$__dtsnd->plcy->id ]);
					
					if($__chk_cnt->e == 'ok' && !isN($__chk_cnt->id) && !isN($_p_est)){
						$__prc_cnt = $__Cnt->UpdCnt_Plcy([ 'id'=>$__chk_cnt->id, 'sndi'=>$_p_est ]);			
					}else{
						$__Cnt->plcy_id = $__dtsnd->plcy->id;
						$__Cnt->cnt_sndi = $_p_est;
						$__prc = $__Cnt->InCnt_Plcy([ 'cnt'=>$__dtsnd->cnt->id ]); 
					}
				
				//------------ End - Set Policy ------------//


			}
			
		?>
		<?php if($_vrf_tp == 'ok' && $__prc_eml->e == 'ok' && $__prc_cnt->e == 'ok'){ ?>
		
			<h1>¡Verificación Exitosa!</h1>
			<div class="prgrph">
				Usted ha aceptado la política de datos.
				<ul>
					<?php echo $__li; ?>
				</ul>
			</div>
		
		<?php }elseif($_vrf_tp == 'no' && $__prc_eml->e == 'ok' && $__prc_cnt->e == 'ok'){ ?>
			
			<h1>¡No Verificado!</h1>
			<div class="prgrph">
				Usted no ha aceptado la política de datos.
				<ul>
					<?php echo $__li; ?>
				</ul>
			</div>
		
		<?php } ?>	
			
	</section>
	
	<noscript> 
		<div class="_JvRc"> Su navegador NO tiene activo JAVA, puede representar dificultades para navegar </div> 
	</noscript>
</body>
</html> 