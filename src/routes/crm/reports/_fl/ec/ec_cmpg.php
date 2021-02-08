<?php 
	
	$__i = Php_Ls_Cln($_GET['_cmpg']);
	
	$__cmpg_dt = GtEcCmpgDt([	'id'=>$__i, 
								't'=>'enc', 
								'ec'=>'ok',
								'q_tot'=>'ok', 
								'q_btch'=>'ok', 
								'lsts'=>[ 'e'=>'ok', 'trck'=>'ok', 'usop'=>'ok', 'snd'=>'ok' ]
							]); 
							
							
	
	
	
	//------------------------------ LISTA DE EMAILS ENVIADOS ------------------------------//
	
	
		$__cmpg_lsts_eml = GtEcCmpgLstsEmlDt([ "enc"=>$__i ]);
		
		foreach($__cmpg_lsts_eml as $_k => $_v){
			$_medio_clr_eml = Gn_Rnd_Clr();
			$_medio_eml[] = "{ name:'".ctjTx(str_replace("'", "",$__cmpg_lsts_eml->$_k->nm),'in')."',   data:[". number_format($__cmpg_lsts_eml->$_k->tot, 2, '.', '') ."], color:'".$_medio_clr_eml."' } ";
			$_tabla_eml .= '<tr><td>'.ctjTx($__cmpg_lsts_eml->$_k->nm,'in').'</td><td>'. number_format($__cmpg_lsts_eml->$_k->tot, 2, '.', '') .'</td></tr>';
			
		}
		
		$_grf_tag_eml = implode(",", $_medio_eml);
		
	
	//------------------------------ LISTA DE BASES DE DATOS IMPACTADAS ------------------------------//
	
	
		$__cmpg_bd = GtEcCmpgBdDt([ "enc"=>$__i ]);
		
		foreach($__cmpg_bd as $_k => $_v){
			$_medio_clr = Gn_Rnd_Clr();
			$_medio[] = "{ name:'".ctjTx(str_replace("'", "",$__cmpg_bd->$_k->nm),'in')."',   data:[". number_format($__cmpg_bd->$_k->tot, 2, '.', '') ."], color:'".$_medio_clr."' } ";
			$_tabla .= '<tr><td>'.ctjTx($__cmpg_bd->$_k->nm,'in').'</td><td>'. number_format($__cmpg_bd->$_k->tot, 2, '.', '') .'</td></tr>'; 
			
		}
		$_grf_tag = implode(",", $_medio);
	
	
	//------------------------------ PROGRESIÓN POR SEMANA ------------------------------//
							
		foreach($__cmpg_dt->ls->snd->week->dates as $_k){
			$__grph_week_op[] = $__cmpg_dt->ls->snd->week->opn->grp->$_k;
			$__grph_week_clc[] = $__cmpg_dt->ls->snd->week->clc->grp->$_k;
			$__grph_week_rmv[] = $__cmpg_dt->ls->snd->week->rmv->grp->$_k;
		}
	
	//------------------------------ PROGRRESION POR HORA ------------------------------//
		
		foreach($__cmpg_dt->ls->snd->day->hours as $_k){
			$__grph_day_op[] = $__cmpg_dt->ls->snd->day->opn->grp->$_k;
			$__grph_day_clc[] = $__cmpg_dt->ls->snd->day->clc->grp->$_k;
			$__grph_day_rmv[] = $__cmpg_dt->ls->snd->day->rmv->grp->$_k;
		}
	
	//------------------------------ LISTA DE DISPOSITIVOS ------------------------------//
		
		foreach($__cmpg_dt->ls->snd->dsp->grp->ls as $_k => $_v){
			$__grph_dsp[] = "{name: '".$_v->nm."', y:".$_v->tot." }";
		}
	
	//------------------------------ LISTA DE SISTEMAS OPERATIVOS ------------------------------//
		
		foreach($__cmpg_dt->ls->snd->os->grp->ls as $_k => $_v){
			$__grph_os[] = "{name: '".$_v->nm."', y:".$_v->tot." }";
		}
	
	//------------------------------ LISTA DE CLIENTES DE CORREO ------------------------------//
		
		foreach($__cmpg_dt->ls->snd->clnt->grp->ls as $_k => $_v){
			$__grph_clnt[$_v->nm] = $_v->tot;
			$__grph_clnt_ctg[$_v->nm] = "'".$_v->nm."'";
		}
	
	//------------------------------ LISTA DE NAVEGADORES ------------------------------//
		
		foreach($__cmpg_dt->ls->snd->brws->grp->ls as $_k => $_v){
			$__grph_brws[] = "{name: '".$_v->nm."', y:".$_v->tot." }";
		}
	
	//------------------------------ LISTA DE TIPO DE REBOTE ------------------------------//
		
		if($__cmpg_dt->ls->snd->bnct->grp->tot > 0){
			foreach($__cmpg_dt->ls->snd->bnct->grp->ls as $_k => $_v){
				$__grph_bnct[] = "{name: '".$_v->nm."', y:".$_v->tot." }";
			}
		}
	
	//------------------------------ LISTA DE APERTURAS ------------------------------//
		
		foreach($__cmpg_dt->ls->snd->opnp->grp->ls as $_k => $_v){
			$__grph_opnp[] = "{name: '".$_v->nm."', code:'".$_v->id."', value:".$_v->tot." }";
		}

?>

<div class="ec_cmpg_dsh_inf">
	
	<div class="rsmn">
		<div class="_c1">
			<?php 
				echo h1($__cmpg_dt->nm);
			?>
			<ul>
				<li><?php echo Strn('Estado: ').Spn($__cmpg_dt->est->nm); ?></li>
				<li><?php echo Strn('Asunto: ').$__cmpg_dt->sbj; ?></li>
				<li><?php echo Strn('Dia Programado: '). FechaESP_OLD($__cmpg_dt->p_f) ; ?></li>
				<li><?php echo Strn('Hora Programada: '). _DteHTML(array('d'=>$__cmpg_dt->p_h, 'nd'=>'no')) ; ?></li>
				<?php if(!isN($__cmpg_dt->lsts->ls)){ ?>
					<li>
						<?php 
							print_r($_v->qry_t->tot->allw);
							foreach($__cmpg_dt->lsts->ls as $_k => $_v){
								if(!isN($_v->nm)){
									$__lst_shw[] = $_v->nm.' ('._Nmb($_v->qry_t->tot->allw, 3).')';
									$__lst_tot = $__lst_tot+$_v->qry_t->tot->allw;
								}
							}
							
							echo Strn('Lista ('._Nmb($__lst_tot, 3).'): ').implode(',', $__lst_shw);
							
							
						?>
					</li>
				<?php } ?>
			</ul>
		</div>
		<div class="_c2">
			<div class="_prvw">
				<div class="_bxwrp">
					<?php echo '<img src="'.$__cmpg_dt->ec->img_v->ste->bg.'"> '; ?>
				</div>
			</div>
		</div>
	</div>
	<div class="rsmn_p">
		<?php 
			

			$___g_c = str_replace('#','',TAG_CLR_MAIN);
			
			$___g_snd = _Kn_Prcn([ 
									'id'=>'g_tot_snd', 
									'l'=>'ok', 
									'v'=>$__cmpg_dt->_tot_snd_p<100?_Nmb($__cmpg_dt->_tot_snd_p, 5):$__cmpg_dt->_tot_snd_p, 
									'clr'=>$___g_c, 
									'w'=>'60', 
									'di'=>'ok', 
									'ds'=>'0.01' 
								]); 
								
								
			$___g_op = _Kn_Prcn([ 
									'id'=>'g_tot_op', 
									'l'=>'ok', 
									'v'=>$__cmpg_dt->_tot_op_p<100?_Nmb($__cmpg_dt->_tot_op_p, 5):$__cmpg_dt->_tot_op_p, 
									'clr'=>$___g_c, 
									'w'=>'60', 
									'di'=>'ok', 
									'ds'=>'0.01' 
								]); 
								
			$___g_err = _Kn_Prcn([ 
									'id'=>'g_tot_err', 
									'l'=>'ok', 
									'v'=>$__cmpg_dt->_tot_err_p<100?_Nmb($__cmpg_dt->_tot_err_p, 5):$__cmpg_dt->_tot_err_p, 
									'clr'=>$___g_c, 
									'w'=>'60', 
									'di'=>'ok', 
									'ds'=>'0.01' 
								]); 
								
			$___g_efct = _Kn_Prcn([ 
									'id'=>'g_tot_efct', 
									'l'=>'ok', 
									'v'=>$__cmpg_dt->_tot_efct_p<100?_Nmb($__cmpg_dt->_tot_efct_p, 5):$__cmpg_dt->_tot_efct_p, 
									'clr'=>$___g_c, 
									'w'=>'60', 
									'di'=>'ok', 
									'ds'=>'0.01' 
								]); 
								
			$___g_trck = _Kn_Prcn([ 
									'id'=>'g_tot_trck', 
									'l'=>'ok', 
									'v'=>$__cmpg_dt->_tot_trck_p<100?_Nmb($__cmpg_dt->_tot_trck_p, 5):$__cmpg_dt->_tot_trck_p, 
									'clr'=>$___g_c, 
									'w'=>'60', 'di'=>'ok', 
									'ds'=>'0.01' 
								]); 
				
			$___g_rmv = _Kn_Prcn([ 
									'id'=>'g_tot_rmv', 
									'l'=>'ok', 
									'v'=>$__cmpg_dt->_tot_rmv_p<100?_Nmb($__cmpg_dt->_tot_rmv_p, 5):$__cmpg_dt->_tot_rmv_p, 
									'clr'=>$___g_c, 
									'w'=>'60', 
									'di'=>'ok', 
									'ds'=>'0.01' 
								]); 
			
			$CntWb .= $___g_snd->js.$___g_op->js.$___g_err->js.$___g_efct->js.$___g_trck->js.$___g_rmv->js;
			
			$__btch .= li(bdiv([ 'cls'=>'_g', 'c'=>$___g_snd->html ]).Strn('Enviados').HTML_BR._Nmb($__cmpg_dt->_tot_snd, 3) );
			$__btch .= li(bdiv([ 'cls'=>'_g', 'c'=>$___g_op->html ]).Strn('Abiertos').HTML_BR._Nmb($__cmpg_dt->_tot_op, 3) );
			$__btch .= li(bdiv([ 'cls'=>'_g', 'c'=>$___g_err->html ]).Strn('Rebotes').HTML_BR._Nmb($__cmpg_dt->_tot_err, 3) );
			$__btch .= li(bdiv([ 'cls'=>'_g', 'c'=>$___g_efct->html ]).Strn('Efectivos').HTML_BR._Nmb($__cmpg_dt->_tot_efct, 3) );
			$__btch .= li(bdiv([ 'cls'=>'_g', 'c'=>$___g_trck->html ]).Strn('Clicks únicos').HTML_BR._Nmb($__cmpg_dt->_tot_trck, 3) );
			$__btch .= li(bdiv([ 'cls'=>'_g', 'c'=>$___g_rmv->html ]).Strn('Removidos').HTML_BR._Nmb($__cmpg_dt->_tot_rmv, 3) );
			
			echo ul($__btch);
			
			//Abre el panel de contactos
			$CntWb .= " 
						
				$('.g_tot').parent('div').parent('._g').parent('li').off('click').click(function (){
					
					var _g_tot_tp = $(this).find('._g').find('div').find('.g_tot').attr('id');
					
					_ldCnt({
						
						u:'".FL_DT_GN.__t('ec_snd_rprt',true).TXGN_POP.TXGN_BX.$___Ls->bx_rld.ADM_LNK_SB.$__i."&_g_tot_tp='+_g_tot_tp,
						w:'98%',
						h:'98%',
						pop:'ok',
						pnl:{
							e:'ok',
							tp:'h',
							s:'l'
						}
						
					});
				});
			
			";
			
		?>		
	</div>
	
	<div class="_ln cx2">
		<div class="_c1 _ls_s_1 _trck">
			<?php 
				
				echo h2('Top Links '.Spn('Clicked','ok'));
				
				if($__cmpg_dt->ls->trck->tot > 0){
					
					foreach($__cmpg_dt->ls->trck->ls as $_k => $_v){
						$__trck .= li(Strn($_v->tot).bdiv([ 'c'=>$_v->lnk ]) );
					}
					
					echo ul($__trck);
				
				}
			?>
		</div>
		<div class="_c2 _ls_s_1 _usop">
			<?php 
				
				echo h2('Usuarios '.Spn('con mas aperturas','ok'));
				
				foreach($__cmpg_dt->ls->usop->ls as $_k => $_v){
					$__usop .= li(Strn($_v->tot).bdiv(array( 'c'=>$_v->nm.HTML_BR.Spn($_v->eml, 'ok') )));
				}
				
				echo ul($__usop);
			?>
		</div>	
	</div>
	
	
	
	
	<div class="_ln cx2">
		<div class="_c1 _grph">
			<div id="_grph_1"></div>
			<?php 
				
				$CntWb .= " SUMR_Grph.f.g3({ 
								id: '#_grph_1', 
								d: [ {name: 'Abiertos', data: [".implode(',', $__grph_week_op)."]}, 
									 {name: 'Clics', data: [".implode(',', $__grph_week_clc)."]},
									 {name: 'Removidos', data: [".implode(',', $__grph_week_rmv)."], color:'#D16666' }
									],
								tt: 'Aperturas',
								tt_sb: 'Primeros 7 Dias',
								y_tt: '',
								dt_lbl: true,
								c: [".implode(',', $__cmpg_dt->ls->snd->week->grp->c)."]
							}); "; 
			?>
		</div>
		<div class="_c2 _grph">
			<div id="_grph_2"></div>
			<?php 
				
				$CntWb .= " SUMR_Grph.f.g3({ 
								id: '#_grph_2', 
								d: [ {name: 'Abiertos', data: [".implode(',', $__grph_day_op)."]}, 
									 {name: 'Clics', data: [".implode(',', $__grph_day_clc)."]},
									 {name: 'Removidos', data: [".implode(',', $__grph_day_rmv)."], color:'#D16666' }
									],
								tt: 'Aperturas',
								tt_sb: 'Primeras 24 horas',
								y_tt: '',
								dt_lbl: true,
								c: [".implode(',', $__cmpg_dt->ls->snd->day->grp->c)."]
							}); "; 
			?>
		</div>	
	</div>
	
	<div class="_ln cx1">
		<div class="_c1 _grph">
			<div id="_grph_map"></div>
			<?php 	
				$CntWb .= " 
					SUMR_Grph.f.g9({ 
						id: '#_grph_map', 
						d: [".implode(',', $__grph_opnp)."],
						tt: 'Aperturas',
						tt_sb: 'por País',
						g_spc_b: 80,
						lgnd_algn: 'left',
						lgnd_valgn: 'middle',
						lgnd_lyt: 'vertical',
					});
				"; 
			?>
		</div>	
	</div>
	
	
	<?php 
				
		echo h2('Top Países '.Spn('con aperturas','ok'));
		
		$_col = _Nmb( $__cmpg_dt->ls->snd->opnp->grp->tot/3, 6 );
		$_c = 1;
		$_i = 1;
		
		foreach($__cmpg_dt->ls->snd->opnp->grp->ls as $_k => $_v){
			$__opnp[$_c] .= li(Strn($_v->tot).bdiv(array( 'c'=> $_v->nm, 'sty'=>'background-image:url('.$_v->img->th_c_100p.');' )));
			$_i++;
			if($_i > $_col){ $_i = 1; $_c++; }
		}
			
	?>
		
	<div class="_ln cx3">
		<div class="_c1 _ls_s_2">
			<?php echo ul($__opnp[1]); ?>
		</div>
		<div class="_c2 _ls_s_2">
			<?php echo ul($__opnp[2]); ?>
		</div>
		<div class="_c3 _ls_s_2">
			<?php echo ul($__opnp[3]); ?>
		</div>	
	</div>
	
	
	<div class="_ln cx3">
		<div class="_c1 _grph">
			<div id="_grph_3"></div>
			<?php 
				
				if(!isN($__grph_dsp)){
					
					$CntWb .= " 
					
						SUMR_Grph.f.g2({ 
							id: '#_grph_3_glb',
							g_h: 350,
							g_mrg_t:0,
							g_mrg_b:0,
							d: [ ".implode(',', $__grph_dsp)." ],
							tt: 'Aperturas',
							tt_sb: 'Unicas por dispositivo',
							dt_lbl: false,
							lgnd:true,
							dt_lbl_frmt: '{point.percentage:.1f}%',
							lgnd_frmt: function() {
					              return '<span>' + this.name +' </span> <span style=\"color:#727272;font-size:10px;\"> ' + this.percentage.toFixed(2) + ' %</span>';
					        },
					        i_s:'50%',
					        lgnd_lyt: 'horizontal',
					        lgnd_valgn: 'bottom',
						    lgnd_algn: 'center',
							lgnd_y: 0
						});
					"; 
				
				}
			?>
		</div>
		<div class="_c2 _grph">
			<div id="_grph_4"></div>
			<?php 
				
				
				if(!isN($__grph_os)){
						
					$CntWb .= " 
					
						SUMR_Grph.f.g2({ 
							id: '#_grph_4',
							g_h: 350,
							g_mrg_t:0,
							g_mrg_b:0,
							d: [ ".implode(',', $__grph_os)." ],
							tt: 'Aperturas Movil',
							tt_sb: 'Sistema Operativo',
							dt_lbl: false,
							lgnd:true,
							lgnd_frmt: function() {
					              return '<span>' + this.name +' </span> <span style=\"color:#727272;font-size:10px;\"> ' + this.percentage.toFixed(2) + ' %</span>';
					        },
					        i_s:'50%',
					        lgnd_lyt: 'horizontal',
					        lgnd_valgn: 'bottom',
							lgnd_algn: 'center',
							lgnd_y: 0
						});
						
					"; 
				
				}
			?>
		</div>
		<div class="_c3 _grph">
			<div id="_grph_5"></div>
			<?php 
				
				
				if(!isN($__grph_brws)){
					
					$CntWb .= " 
					
						SUMR_Grph.f.g2({ 
							id: '#_grph_5',
							g_h: 350,
							g_mrg_t:0,
							g_mrg_b:0,
							g_spc_t:0,
							d: [ ".implode(',', $__grph_brws)." ],
							tt: 'Aperturas',
							tt_sb: 'Navegador',
							dt_lbl: false,
							lgnd:true,
							lgnd_frmt: function() {
					              return '<span>' + this.name +' </span> <span style=\"color:#727272;font-size:10px;\"> ' + this.percentage.toFixed(2) + ' %</span>';
					        },
					        i_s:'50%',
					        lgnd_lyt: 'horizontal',
					        lgnd_valgn: 'bottom',
							lgnd_algn: 'center',
							lgnd_y: 0
						});
						
					"; 
				
				}
			?>
		</div>	
	</div>
		
	<div class="_ln cx2">
		<div class="_c1 _grph">
			<div id="_grph_6"></div>
			<?php 
				
				if(!isN($__grph_clnt_ctg)){
					
					$CntWb .= " 
											
						SUMR_Grph.f.g7({ 
							id: '#_grph_6',
							g_spc_b: 80,
							tt: 'Aperturas',
							tt_sb: 'Cliente Email',
							ctg: [ ".implode(',', $__grph_clnt_ctg)." ],
							d: [{ name: 'Aperturas', data:[".implode(',', $__grph_clnt)."] }]	
						});
						
					"; 
				
				}
			?>
		</div>
		<div class="_c2 _grph">
			<div id="_grph_7"></div>
			<?php 
				
				if(!isN($__grph_bnct)){
					
					$CntWb .= " 
						SUMR_Grph.f.g2({ 
							id: '#_grph_7',
							g_h: 350,
							g_mrg_t:0,
							g_mrg_b:0,
							g_spc_t:0,
							d: [ ".implode(',', $__grph_bnct)." ],
							tt: 'Rebotes',
							tt_sb: 'por tipologia',
							dt_lbl: false,
							lgnd:true,
							lgnd_frmt: function() {
									return '<span>' + this.name +' </span> <span style=\"color:#727272;font-size:10px;\"> ' + this.percentage.toFixed(2) + ' %</span>';
							},
							i_s:'50%',
							lgnd_lyt: 'horizontal',
							lgnd_valgn: 'bottom',
							lgnd_algn: 'center',
							lgnd_y: 0
						});
					
					"; 
					
					
				
				}
			?>
		</div>	
	</div>
	
	<div class="_ln cx2">
		<div class="_c1 _ls_s_2">
			<?php echo ul('Leads por base de datos'); ?>
		</div>
		<div class="_c2 _ls_s_2">
			<?php echo ul('Leads por base de datos texto'); ?>
		</div>
	</div>
	<div class="_ln cx2">
		<div class="_c1 _grph">
			<div id="_grph_8"></div>
			<?php 
				$CntWb .= "
					SUMR_Grph.f.g1({ 
						id: '#_grph_8',
						d: [".$_grf_tag."],
						tt: 'Leads', 
						c_e: false,
						lbls: false,
					});
				";
			?>
		</div>	
		<div class="_c2 _grph">
			<div id="_grph_9"></div>
			<?php 
				$CntWb .= "
					SUMR_Grph.f.g1({ 
						id: '#_grph_9',
						d: [".$_grf_tag_eml."],
						tt: 'Leads', 
						c_e: false,
						lbls: false,
					});
				";
			?>
		</div>	
	</div>
	
</div>

<style>
	
	.ec_cmpg_dsh_inf{ padding-bottom: 100px; }
	.ec_cmpg_dsh_inf *{ box-sizing: border-box; }
	
	.ec_cmpg_dsh_inf ._ln.cx1{ display: flex; width: 100%; }
	.ec_cmpg_dsh_inf ._ln.cx1 ._c1{ width: 100%; }
	
	.ec_cmpg_dsh_inf ._ln.cx2{ display: flex; width: 100%; }
	.ec_cmpg_dsh_inf ._ln.cx2 ._ls_s_1,
	.ec_cmpg_dsh_inf ._ln.cx2 ._ls_s_2{ width: 50%; }
	.ec_cmpg_dsh_inf ._ln.cx2 ._ls_s_1._c1,
	.ec_cmpg_dsh_inf ._ln.cx2 ._ls_s_2._c1{ margin-right: 0.5%; }
	.ec_cmpg_dsh_inf ._ln.cx2 ._ls_s_1._c2,
	.ec_cmpg_dsh_inf ._ln.cx2 ._ls_s_2._c2{ margin-left: 0.5%; }
	
	.ec_cmpg_dsh_inf ._ln.cx2 ._ls_s_1 ul li strong{ padding: 0; }
	
	.ec_cmpg_dsh_inf ._ln.cx2 ._grph{ width: 50%; }
	.ec_cmpg_dsh_inf ._ln.cx2 ._grph._c1{ margin-right: 0.5%; }
	.ec_cmpg_dsh_inf ._ln.cx2 ._grph._c2{ margin-left: 0.5%; }
	
	.ec_cmpg_dsh_inf ._ln.cx3{ display: flex; width: 100%; }
	.ec_cmpg_dsh_inf ._ln.cx3 ._ls_s_2{ width: 33.3%; }
	.ec_cmpg_dsh_inf ._ln.cx3 ._ls_s_2 ul li{ display: flex; }
	.ec_cmpg_dsh_inf ._ln.cx3 ._ls_s_2 ul li div{  width: 100%; }
	
	.ec_cmpg_dsh_inf ._ln.cx3 ._grph{ width: 33.3%; }
	
	.ec_cmpg_dsh_inf .rsmn_p ul li ._g{ position: relative; }
	.ec_cmpg_dsh_inf .rsmn_p ul li ._g input[type=text]{ top: 50% !important; left: 50% !important;  margin-top: -10px !important; margin-left: -17px !important; font-family: Economica !important; font-size: 18px !important; height: 16px !important; }
	
	.ec_cmpg_dsh_inf .rsmn_p ul li:Hover{ opacity:0.7; cursor: pointer; }

</style>

<?php //$CntWb .= '$("body").addClass("bx_informe");'; ?>