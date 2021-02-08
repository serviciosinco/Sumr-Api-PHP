<?php 
	
	
	$__bd_dt = GtCntBdAllDt($_GET['__i']);
	$__rnd = Gn_Rnd(10); 
	
	
	//Tipologia
	
	foreach($__bd_dt->tot->tp as $_k => $_v){
		
			if($_v->tot < 1){ $_prnt = 0; }else{ $_prnt = $_v->tot; }
			$_medio[] = "{ name:'".ctjTx(str_replace("'", "",$_v->tt),'in')."',   data:[". number_format($_prnt, 2, '.', '') ."] } ";
			$_tabla .= '<tr><td>'.ctjTx($_v->tt,'in').'</td><td>'. number_format($_prnt, 2, '.', '') .'</td></tr>';  
			$_medio_clr[] = "'".Gn_Rnd_Clr()."'";  
	
	}
	$_grf_tag = implode(",", $_medio);
	$_grf_clr = implode(",", $_medio_clr);
	
	
	
	//Tag
	foreach($__bd_dt->tot->tag as $_k => $_v){
		
		if($_v->tot < 1){ $_prnt = 0; }else{ $_prnt = $_v->tot; }
		$_medio_tg[] = "{ name:'".ctjTx(str_replace("'", "",$_v->tt),'in')."',   data:[". number_format($_prnt, 2, '.', '') ."] } ";
		$_tabla_tg .= '<tr><td>'.ctjTx($_v->tt,'in').'</td><td>'. number_format($_prnt, 2, '.', '') .'</td></tr>';  
		$_medio_clr_tg[] = "'".Gn_Rnd_Clr()."'";  
		
	}
	$_grf_tag_tg = implode(",", $_medio_tg);
	$_grf_clr_tg = implode(",", $_medio_clr_tg);
	
	
	//Sexo
	foreach($__bd_dt->tot->sx as $_k => $_v){
		
			$_medioSx[] = "{ name:'".ctjTx(str_replace("'", "",$_v->tt),'in')."',   y:". number_format($_v->tot, 2, '.', '') .", color:'".Gn_Rnd_Clr()."' } ";
		
	}
	$_grf_tagSx = implode(",", $_medioSx);	
	
	
	
	
	//Fechas
	$_month = $__bd_dt->his->cnt->month;

	
	for($i=$_month->f_start; $i<=$_month->f_end; $i = date("Y-m", strtotime($i ."+ 1 month"))){
	    $__id_f = date("Y-m", strtotime($i));
	    $tt_f[] = '"'.$__id_f.'"';
	    $tot_f[] = ($_month->ls->{$__id_f}->tot != NULL ? $_month->ls->{$__id_f}->tot : '0');
	}


?>

	
	<!--<div class="rsmn">
		<div class="_c1">
			<?php 
				echo h1($__bd_dt->nm);
			?>
			<ul>
				<li><?php echo Strn('Estado: ').Spn($__bd_dt->est->nm); ?></li>
				<li><?php echo Strn('Asunto: ').$__bd_dt->sbj; ?></li>
				<li><?php echo Strn('Dia Programado: '). FechaESP_OLD($__bd_dt->p_f) ; ?></li>
				<li><?php echo Strn('Hora Programada: '). _DteHTML(array('d'=>$__bd_dt->p_h, 'nd'=>'no')) ; ?></li>
				<?php if($__bd_dt->lsts != NULL){ ?>
					<li>
						<?php 
							
							
							foreach($__bd_dt->lsts as $_k => $_v){
								if($_v->nm != NULL){
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
			<?php 
				echo '<img src="'.$__bd_dt->ec->img_v->th_ste.'" width="150"> ';
			?>
		</div>
	</div>-->
	<div class="rsmn_p">
		<?php 

			$_medio_clr_Lds = Gn_Rnd_Clr();
			$_medio_gen[] = "{ name:'".ctjTx(str_replace("'", "",'Leads'),'in')."',   data:[". number_format($__bd_dt->tot->cnt, 2, '.', '') ."], color:'".$_medio_clr_Lds."' } "; 
			$_tabla_gen .= '<tr><td>'.ctjTx('Leads','in').'</td><td>'. number_format($__bd_dt->tot->cnt, 2, '.', '') .'</td></tr>';  
			$__btch .= li(bdiv(array('cls'=>'_g', 'c'=>$___g_snd->html)).Strn('Leads', '', '', 'color:'.$_medio_clr_Lds.';').HTML_BR._Nmb($__bd_dt->tot->cnt, 3) );
			
			
			$_medio_clr_Tel = Gn_Rnd_Clr();
			$_medio_gen[] = "{ name:'".ctjTx(str_replace("'", "",'Con Telefono'),'in')."',   data:[". number_format($__bd_dt->tot->tel, 2, '.', '') ."], color:'".$_medio_clr_Tel."' } "; 
			$_tabla_gen .= '<tr><td>'.ctjTx('Con Telefono','in').'</td><td>'. number_format($__bd_dt->tot->tel, 2, '.', '') .'</td></tr>';  
			$__btch .= li(bdiv(array('cls'=>'_g', 'c'=>$___g_op->html)).Strn('Con Telefono', '', '', 'color:'.$_medio_clr_Tel.';').HTML_BR._Nmb($__bd_dt->tot->tel, 3) );
			
			
			
			$_medio_clr_Eml = Gn_Rnd_Clr();
			$_medio_gen[] = "{ name:'".ctjTx(str_replace("'", "",'Con Email'),'in')."',   data:[". number_format($__bd_dt->tot->eml, 2, '.', '') ."], color:'".$_medio_clr_Eml."' } "; 
			$_tabla_gen .= '<tr><td>'.ctjTx('Con Email','in').'</td><td>'. number_format($__bd_dt->tot->eml, 2, '.', '') .'</td></tr>';  
			$__btch .= li(bdiv(array('cls'=>'_g', 'c'=>$___g_err->html)).Strn('Con Email', '', '', 'color:'.$_medio_clr_Eml.';').HTML_BR._Nmb($__bd_dt->tot->eml, 3) );
			
			
			
			$_medio_clr_Doc = Gn_Rnd_Clr();
			$_medio_gen[] = "{ name:'".ctjTx(str_replace("'", "",'Con Documento'),'in')."',   data:[". number_format($__bd_dt->tot->dc, 2, '.', '') ."], color:'".$_medio_clr_Doc."' } "; 
			$_tabla_gen .= '<tr><td>'.ctjTx('Con Documento','in').'</td><td>'. number_format($__bd_dt->tot->dc, 2, '.', '') .'</td></tr>';  
			$__btch .= li(bdiv(array('cls'=>'_g', 'c'=>$___g_efct->html)).Strn('Con Documento', '', '', 'color:'.$_medio_clr_Doc.';').HTML_BR._Nmb($__bd_dt->tot->dc, 3) );
			
			
			
			$_medio_clr_Dir = Gn_Rnd_Clr();
			$_medio_gen[] = "{ name:'".ctjTx(str_replace("'", "",'Con direcciones'),'in')."',   data:[". number_format($__bd_dt->tot->dir, 2, '.', '') ."], color:'".$_medio_clr_Dir."' } "; 
			$_tabla_gen .= '<tr><td>'.ctjTx('Con direcciones','in').'</td><td>'. number_format($__bd_dt->tot->dir, 2, '.', '') .'</td></tr>';  
			$__btch .= li(bdiv(array('cls'=>'_g', 'c'=>$___g_trck->html)).Strn('Con direcciones', '', '', 'color:'.$_medio_clr_Dir.';').HTML_BR._Nmb($__bd_dt->tot->dir, 3) );
			
			
			
			$_grf_tag_gen = implode(",", $_medio_gen);
			$_grf_clr_gen = implode(",", $_medio_clr_gen);
			
			//$__btch .= li(bdiv(array('cls'=>'_g', 'c'=>$___g_snd->html)).Strn('Leads', '', '', 'color:#60965B;').HTML_BR._Nmb($__bd_dt->tot->cnt, 3) );
			//$__btch .= li(bdiv(array('cls'=>'_g', 'c'=>$___g_op->html)).Strn('Con Telefono', '', '', 'color:#bbfce9;').HTML_BR._Nmb($__bd_dt->tot->tel, 3) );
			//$__btch .= li(bdiv(array('cls'=>'_g', 'c'=>$___g_err->html)).Strn('Con Email', '', '', 'color:#26206d;').HTML_BR._Nmb($__bd_dt->tot->eml, 3) );
			//$__btch .= li(bdiv(array('cls'=>'_g', 'c'=>$___g_efct->html)).Strn('Con Documento', '', '', 'color:#efb505;').HTML_BR._Nmb($__bd_dt->tot->dc, 3) );
			//$__btch .= li(bdiv(array('cls'=>'_g', 'c'=>$___g_trck->html)).Strn('Con direcciones', '', '', 'color:#7cb5ec;').HTML_BR._Nmb($__bd_dt->tot->dir, 3) );
			
			echo ul($__btch);
			
		?>		
	</div>
	
	
	<div class="_ln cx1">
		<div class="_c1 _ls_s_1 _trck">
			<?php 
				
				echo h2('Generales');
				
			?>
		</div>
	</div>
	<div class="_ln cx1">
		<div class="_c1 _grph">
			<div id="_grph_5_<?php echo $__rnd ?>"></div>
			<?php 
				$CntWb .= "  
					SUMR_Grph.f.g1({ 
						id: '#_grph_5_".$__rnd."',
						d: [".$_grf_tag_gen."],
						tt: 'Generales', 
						c_e: false,
						lbls: false,
					});
				";
			?>
		</div>
	</div>
	
	<div class="_ln cx2">
		<div class="_c1 _ls_s_1 _trck">
			<?php 
				
				echo h2('Sexo');
				
			?>
		</div>
		<div class="_c2 _ls_s_1 _usop">
			<?php 
				
				echo h2('Leads por tipologia');
			?>
		</div>	
	</div>
	
	
	<div class="_ln cx2">
		<div class="_c1 _grph">
			<div id="_grph_1_<?php echo $__rnd ?>"></div>
			<script type="text/javascript">
				$('#_grph_1_<?php echo $__rnd  ?>').highcharts({

						chart: {
								type: 'pie', 
								margin: [0, 0, 20, 0],
								spacingTop: 0,
								spacingBottom: 0,
								spacingLeft: 0,
								spacingRight: 0,
								options3d: {
									enabled: false,
									alpha: 40
								}
						},
						title: { text:'' },
						subtitle: { text: '' }, 
						credits: { enabled: false },
						tooltip: { enabled:false },				
						plotOptions: { 
							pie: { 
								size:'70%', 
								allowPointSelect: true, 
								cursor: 'pointer', 
								innerSize: 70, depth: 20, 
								dataLabels: {
									shadow: true, 
									enabled: true,
									distance: -30,
									style: { textShadow:"0 0 6px contrast, 0 0 3px contrast", fontSize: '12px', color: '#fff' },
									formatter: function() {
								        return this.point.name + '<br>' + Highcharts.numberFormat(this.y, 0, ',', '.')+'' ;
								    }
								}
							} 
						},
						series: [{
				            colorByPoint: true,
				            data: [<?php echo $_grf_tagSx; ?>]
				        }]
															
															
				});
			
			</script>
		</div>
		<div class="_c2 _grph">
			<div id="_grph_2_<?php echo $__rnd ?>"></div>
			<?php 
				$CntWb .= "  
					SUMR_Grph.f.g1({ 
						id: '#_grph_2_".$__rnd."',
						d: [".$_grf_tag."],
						tt: 'Tipologias', 
						c_e: false,
						lbls: false,
					});
				";
			?>
		</div>	
	</div>
	
	<div class="_ln cx2">
		<div class="_c1 _ls_s_1 _trck">
			<?php 
				
				echo h2('Fechas');
				
			?>
		</div>
		<div class="_c2 _ls_s_1 _usop">
			<?php 
				
				echo h2('Leads por tipologia');
			?>
		</div>	
	</div>
	
	
	<div class="_ln cx2">
		<div class="_c1 _grph">
			<div id="_grph_3_<?php echo $__rnd ?>"></div>
			<?php 
				$CntWb .= " 
					__g_8({ 
						id: '#_grph_3_".$__rnd."', 
						d: [ {name: 'Leads', data: [".implode(',', $tot_f)."]} ],
						tt: 'Generación Leads',
						tt_sb: ' ',
						y_tt: '',
						dt_lbl: true,
						c: [".implode(',', $tt_f)."]
					}); 
				"; 
			?>
		</div>
		<div class="_c2 _grph">
			<div id="_grph_4_<?php echo $__rnd ?>"></div>
			<?php 
				$CntWb .= "  
					SUMR_Grph.f.g1({ 
						id: '#_grph_4_".$__rnd."',
						d: [".$_grf_tag_tg."],
						tt: 'Tags', 
						c_e: false,
						lbls: false,
					});
				";
			?>
		</div>	
	</div>
	
	


	
	<?php $CntWb .= '$("body").addClass("_bd");'; ?>