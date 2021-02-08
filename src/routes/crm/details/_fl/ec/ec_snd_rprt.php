<?php 
	
	$_i = Php_Ls_Cln($_GET['__i']);
	$_tp = Php_Ls_Cln($_GET['_g_tot_tp']);
	$_dwn = Php_Ls_Cln($_GET['_dwn']);

	
	
	//-------------- Detalle de la campaña --------------//
	
	if(!isN($_i)){
		$__cmpg_dt = GtEcCmpgDt([	'id'=>$_i,
									't'=>'enc', 
									'q_tot'=>'ok', 
									'q_btch'=>'ok', 
									'lsts'=>[ 'e'=>'ok', 'trck'=>'ok', 'usop'=>'ok', 'snd'=>'ok' ]
								]); 
	}
	
	//-------------- Valida si es envío o apertura --------------//
	
	
	if( $_tp == "g_tot_snd" ){
		$_ls = GtEcCmpgSndLs([ 'cmpg'=>$__cmpg_dt->id, 't'=>'lsts', 'bd'=>DB_CL ]); //Enviados
	}elseif( $_tp == "g_tot_op" ){
		$_ls = GtEcCmpgUsOpLs([ 'id'=>$__cmpg_dt->id, 'lmt'=>'no' ]); //Abiertos
	}elseif( $_tp == "g_tot_trck" ){
		$_ls = GtEcCmpgUsTrckLs([ 'id'=>$__cmpg_dt->id, 'lmt'=>'no' ]);
	}elseif( $_tp == "_ec_lsts_sgm_eml_tot" ){
		$_ls_f = GtEcLstsSgmDt([ 'id'=>$_i, 'ls'=>'ok', 'd'=>[ 'var'=>'ok' ] ]); //Segmentos
		foreach($_ls_f->var->qry_r->ls as $_k => $_v){
			foreach(GtCntEmlLs([ 'i'=>$_v->cnt ])->ls as $_k2 => $_v2){
				$_ls['ls'][]['eml'] = $_v2;
			}
		}
		$_ls = json_decode(json_encode($_ls));
	}

	
	
	//-------------- Construye la tabla --------------//
	if( isN($_dwn) ){ echo " <div class='_ec_snd_rprt_dwn'></div> "; }
	echo '<table class="_c1 _ls_s_1 _usop">';
		
		if( $_tp == "g_tot_snd" ){
			$__usop .= " 
						<tr class='_tt'>
							<td>Correo</td>
						</tr>
					";
		}elseif( $_tp == "g_tot_op" ){
			$__usop .= " 
						<tr class='_tt'>
							<td>Apertura</td>
							<td>Nombre completo</td>
							<td>Email</td>
							<td>Teléfono</td>
						</tr>
					";
		}elseif( $_tp == "g_tot_trck" ){
			$__usop .= " 
						<tr class='_tt'>
							<td>Nombre completo</td>
							<td>Email</td>
							<td>Teléfono</td>
						</tr>
					";
		}elseif( $_tp == "_ec_lsts_sgm_eml_tot" ){
			$__usop .= " 
						<tr class='_tt'>
							<td>Email</td>
						</tr>
					";
		}else{
			echo " <span class='_no_rprt'>No existe reporte.</span> ";
		}
		
		foreach($_ls->ls as $_k => $_v){
			if( $_tp == "g_tot_snd" ){
				$__usop .= " 
						<tr>
							<td>".Spn($_v->eml)."</td>
						</tr>
					";
			}elseif( $_tp == "g_tot_op" ){
				$__usop .= " 
						<tr>
							<td>".Strn($_v->tot)."</td>
							<td>".$_v->nm."</td>
							<td>".Spn($_v->eml)."</td>
							<td>".Spn($_v->tel)."</td>
						</tr>
					";
			}elseif( $_tp == "g_tot_trck" ){
				$__usop .= " 
						<tr>
							<td>".$_v->nm."</td>
							<td>".Spn($_v->eml)."</td>
							<td>".Spn($_v->tel)."</td>
						</tr>
					";
			}elseif( $_tp == "_ec_lsts_sgm_eml_tot" ){
				$__usop .= " 
						<tr>
							<td>".Spn($_v->eml)."</td>
						</tr>
					";
			}
		}
		echo $__usop;
	echo '</table>';
	
	
	//-------------- Funcion al botón de descarga --------------//

	

	if( isN($_dwn) ){

		$CntJV .= " 
			$('._ec_snd_rprt_dwn').off('click').click(function(){
				var _rnd = Math.random();
				window.open('".FL_DT_GN.__t('ec_snd_rprt',true).TXGN_POP.TXGN_BX.$___Ls->bx_rld.ADM_LNK_SB.$_i."&_g_tot_tp=".$_tp."&_dwn=ok&Rnd='+_rnd);
			});
		"; 
	}
	
	if( !isN($_dwn) && $_dwn == "ok" ){
		
		if($_tp == "g_tot_snd"){
			$__fle_nm = "Enviados.xls";
		}elseif( $_tp == "g_tot_op" ){
			$__fle_nm = "Abiertos.xls";
		}elseif( $_tp == "g_tot_trck" ){
			$__fle_nm = "Clicks.xls";
		}elseif( $_tp == "_ec_lsts_sgm_eml_tot" ){
			$__fle_nm = "Correos.xls";
		}else{
			$__fle_nm = "CRM.xls";
		}
		
		//header("Content-type: application/x-msdownload");
		header('Content-type: application/vnd.ms-excel; charset=utf-8');
		header("Content-Disposition: attachment; filename=$__fle_nm");
		header("Pragma: no-cache");
		header("Expires: 0");
		header("Cache-Control: private", false);
		
	}
	
?>

<?php if( isN($_dwn) ){ ?>
	<style>
		
		/*-------------- Estilos de la tabla --------------*/
		
		._usop{ width: 100%; margin-top: 25px; }
		._usop tr{ font-size: 11px; color: #787878; margin: 0; padding: 3px 0; border-bottom: 1px dotted #aaaaaa; list-style-type: none; }
		._usop tr td{ height: 30px; }
		._usop tr._tt td{ color:black; }
		._usop tr td strong{ vertical-align: top; width: 20px; height: 20px; border: 2px solid gray; display: inline-block; border-radius: 100px 100px 100px 100px; -moz-border-radius: 100px 100px 100px 100px; -webkit-border-radius: 100px 100px 100px 100px; text-align: center; padding: 1px; font-family: Economica; color: #080808; line-height: 17px; margin-right: 6px; }
		._usop tr > td > span{ color: #4a8eb6; }
		
		._ec_snd_rprt_dwn{ background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>inf_xls.svg'); background-color: #067206; width: 30px; height: 30px; background-size: 20px; background-position: center; cursor: pointer; background-repeat: no-repeat; }
		._ec_snd_rprt_dwn:Hover{ opacity: 0.8; }
		
		._no_rprt{ margin: auto; color: #b4b4b4; text-align: center; display: block; font-size: 20px; font-family: Economica;}
	</style>
<?php } ?>