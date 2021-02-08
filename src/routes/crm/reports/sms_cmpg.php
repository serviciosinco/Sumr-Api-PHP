<?php 
	$__i = Php_Ls_Cln($_GET['_cmpg']);
	$__cmpg_dt = GtSmsCmpgDt(['id'=>$__i, 
								  't'=>'enc', 
								  'q_tot'=>'ok', 
								  'q_btch'=>'ok', 
								  'lsts'=>['e'=>'ok', 'trck'=>'ok', 'usop'=>'ok', 'snd'=>'ok']
								 ]
							); 
	
	$_bd = MDL_TB_SMS_CMPG_UP_BD;
	$_bd2 = MDL_TB_SMS_CMPG_BD;
	$_bd3 = DB_PRC. '.' .MDL_UP_BD;
	$_bd4 = DB_PRC.'.'.MDL_UP_COL_BD;
	

	$Ls_Cnt_Qry = "SELECT * FROM $_bd
					INNER JOIN $_bd2 ON smscmpgup_cmpg = id_smscmpg
					INNER JOIN $_bd3 ON smscmpgup_up = id_up
					INNER JOIN $_bd4 ON upcol_up = id_up
					WHERE smscmpg_enc = '$__i' AND upcol_est = 615 ";
					
	$Ls_Cnt_Rg = $__cnx->_qry($Ls_Cnt_Qry); $Tot_Ls_Cnt_Rg = $Ls_Cnt_Rg->num_rows;
	
	foreach($__cmpg_dt->ls->snd->week->dates as $_k){
		$__grph_week_op[] = $__cmpg_dt->ls->snd->week->opn->grp->$_k;
		$__grph_week_clc[] = $__cmpg_dt->ls->snd->week->clc->grp->$_k;
		$__grph_week_rmv[] = $__cmpg_dt->ls->snd->week->rmv->grp->$_k;
	}
	
	foreach($__cmpg_dt->ls->snd->day->hours as $_k){
		$__grph_day_op[] = $__cmpg_dt->ls->snd->day->opn->grp->$_k;
		$__grph_day_clc[] = $__cmpg_dt->ls->snd->day->clc->grp->$_k;
		$__grph_day_rmv[] = $__cmpg_dt->ls->snd->day->rmv->grp->$_k;
	}
	
	foreach($__cmpg_dt->ls->snd->dsp->grp->ls as $_k => $_v){
		$__grph_dsp[] = "{name: '".$_v->nm."', y:".$_v->tot." }";
	}
	
	foreach($__cmpg_dt->ls->snd->os->grp->ls as $_k => $_v){
		$__grph_os[] = "{name: '".$_v->nm."', y:".$_v->tot." }";
	}
	
	foreach($__cmpg_dt->ls->snd->clnt->grp->ls as $_k => $_v){
		$__grph_clnt[$_v->nm] = $_v->tot;
		$__grph_clnt_ctg[$_v->nm] = "'".$_v->nm."'";
	}
	
	foreach($__cmpg_dt->ls->snd->brws->grp->ls as $_k => $_v){
		$__grph_brws[] = "{name: '".$_v->nm."', y:".$_v->tot." }";
	}
	
	foreach($__cmpg_dt->ls->snd->bnct->grp->ls as $_k => $_v){
		$__grph_bnct[] = "{name: '".$_v->nm."', y:".$_v->tot." }";
	}
	
	foreach($__cmpg_dt->ls->snd->opnp->grp->ls as $_k => $_v){
		$__grph_opnp[] = "{name: '".$_v->nm."', code:'".$_v->id."', value:".$_v->tot." }";
	}

?>

	
	<div class="rsmn">
		<div class="_c1">
			<?php 
				echo h1($__cmpg_dt->nm);
			?>
			<?php if(ChckSESS_superadm()){
				//print_r($__cmpg_dt);
			} ?>
			<?php if($__cmpg_dt->est == 1){ $est = GA_SENT; }elseif($__cmpg_dt->est == 2){ $est = GA_SENT; }
			elseif($__cmpg_dt->est == 3){ $est = TX_INPROCSS; }elseif($__cmpg_dt->est == 4){ $est = TX_INPROCSS; } ?>
			<ul>
				<li><?php echo Strn(TX_S.': ').Spn($est); ?></li>
				<li><?php echo Strn(TX_MSJ.': ').Spn($__cmpg_dt->msj); ?></li>
				<li><?php echo Strn(TX_DAYS.' '.TX_PRGM.': '). FechaESP_OLD($__cmpg_dt->p_f) ; ?></li>
				<li><?php echo Strn(TX_HR.' '.TX_PRGM.': '). _DteHTML(['d'=>$__cmpg_dt->p_h, 'nd'=>'no']) ; ?></li>
				<?php if($__cmpg_dt->lsts != NULL){ ?>
					<li>
						<?php 
							
							
							foreach($__cmpg_dt->lsts as $_k => $_v){
								if($_v->nm != NULL){
									$__lst_shw[] = $_v->nm.' ('._Nmb($_v->qry_t->tot->allw, 3).')';
									$__lst_tot = $__lst_tot+$_v->qry_t->tot->allw;
								}
							}
							
							echo Strn( TX_LST '('._Nmb($__lst_tot, 3).'): ').implode(',', $__lst_shw);
							
							
						?>
					</li>
				<?php } ?>
			</ul>
		</div>
		<div class="_c2">
			<?php 
				echo '<img src="'.$__cmpg_dt->ec->img_v->ste->th.'" width="150"> ';
			?>
		</div>
	</div>
	<div class="rsmn_p">
		<?php 
			
			
			$CntWb .= $___g_snd->js.$___g_op->js.$___g_err->js.$___g_efct->js.$___g_trck->js.$___g_rmv->js;
			
			$__btch .= li(bdiv(['cls'=>'_g', 'c'=>$___g_snd->html]).Strn(TX_EXCO).HTML_BR._Nmb($__cmpg_dt->up->in, 6) );
			$__btch .= li(bdiv(['cls'=>'_g', 'c'=>$___g_snd->html]).Strn(TX_ERCRG).HTML_BR._Nmb($__cmpg_dt->up->w, 6) );
			$__btch .= li(bdiv(['cls'=>'_g', 'c'=>$___g_snd->html]).Strn(TX_CRGD).HTML_BR._Nmb($__cmpg_dt->up->l, 6) );
			
			$__btch .= li(bdiv(['cls'=>'_g', 'c'=>$___g_snd->html]).Strn(GA_SENT).HTML_BR._Nmb($__cmpg_dt->btch->snd, 6) );
			$__btch .= li(bdiv(['cls'=>'_g', 'c'=>$___g_snd->html]).Strn(TX_ERNV).HTML_BR._Nmb($__cmpg_dt->btch->w, 6) );
			
			
			echo ul($__btch);
			
		?>		
	</div>

	
	
	<div class="_ln cx2">
		<div class="_c1 _grph" style="height: 400px!important;">
			<div id="_grph_1"></div>
			<?php 
				
				$__g_i = number_format( ($__cmpg_dt->up->in - $__cmpg_dt->up->w) / $__cmpg_dt->up->in * 100 , 2, '.', '');
				$__g_w = number_format( $__cmpg_dt->up->w / $__cmpg_dt->up->in * 100 , 2, '.', '');
				
				$__g_p = number_format( $__cmpg_dt->up->p / ($__cmpg_dt->up->in - $__cmpg_dt->up->w) * 100 , 2, '.', '');
				$__g_l = number_format( $__cmpg_dt->up->l / ($__cmpg_dt->up->in) * 100 , 2, '.', '');
				
				$CntWb .= "  
				
							SUMR_Grph.f.g8({ 
			                    id: '#_grph_1',
			                    dt_lbl: true,
			                    c: ['".TX_IMPRTDS."', '".TX_CNER."'],
			                    d: [{ y: ".$__g_i.",     
			                          color: colors[0],     
			                          drilldown: {  
				                        name: '".TX_ESTS."',               
			                            categories: ['".TX_PRCCRG."', '".TX_CRGD."'],         
			                            data: [
			                                ".number_format($__g_p, 2, '.', '').",
			                                ".number_format($__g_l, 2, '.', '')."
			                            ],         
			                            color: colors[0]     
			                          } 
			                       },
			                       { y: ".$__g_w.",     
			                          color: '#a50000',  
			                          drilldown: {    
				                        name: 'Errores',                
			                            categories: ['Errores'],         
			                            data: [
			                                ".$__g_w."  
			                            ],
			                            color: '#a50000'      
			                          } 
			                       }],
			                    tt: '', 
			                });
				";
				
				
			?>
		</div>
		<div class="_c2 _grph" style="height: 400px!important;">
			<div id="_grph_2"></div>
			<?php 
				
				$_medio[] = "{ name:'".ctjTx(str_replace("'", "",TX_EXCO),'in')."',   data:[". number_format($__cmpg_dt->up->in, 2, '.', '') ."], color:'#3a8500' } "; 
				$_medio[] = "{ name:'".ctjTx(str_replace("'", "",TX_PRCCRG),'in')."',   data:[". number_format($__cmpg_dt->up->p, 2, '.', '') ."] } "; 
				$_medio[] = "{ name:'".ctjTx(TX_ERCRG,'in')."',   data:[". number_format($__cmpg_dt->up->w, 2, '.', '') ."], color:'#a50000' } "; 
				$_medio[] = "{ name:'".ctjTx(TX_CRGD,'in')."',   data:[". number_format($__cmpg_dt->up->l, 2, '.', '') ."] } ";
				
				$_medio[] = "{ name:'".ctjTx(TX_PRC.' ('.TX_SND.')','in')."',   data:[". number_format($__cmpg_dt->btch->in, 2, '.', '') ."], color:'#57bcfa' } ";
				$_medio[] = "{ name:'".ctjTx(GA_SENT.' ','in')."',   data:[". number_format($__cmpg_dt->btch->snd, 2, '.', '') ."], color:'#12858d' } ";
				$_medio[] = "{ name:'".ctjTx(TX_ERNV,'in')."',   data:[". number_format($__cmpg_dt->btch->w, 2, '.', '') ."], color:'#a50000' } "; 
						
						                    
				
				$_grf_tag = implode(",", $_medio);
				
				
				$CntWb .= "  
					SUMR_Grph.f.g1({ 
						id: '#_grph_2',
						dt_lbl: true,
						d: [".$_grf_tag."],
						tt: '".TX_GNRLS." ', 
						tt_sb: '".TX_RLCNDS."',
						c_e: false
					});
				";
				
				
			?>
		</div>	
	</div>
	
	
	<?php echo HTML_BR.HTML_BR; ?>

	<div class="_ln cx1">
		<div class="_c2 ">
			<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg"> 
		    	<tr>
		    	    <th nowrap="nowrap" <?php echo $__xl_st ?> class="_sb"><?php echo 'Errores' ?></th>
			    </tr>
			    <?php $_i = 1; do { ?> 
				    <tr <?php  echo ' class="Rw_'.$Nm.'" ';  ?> >
				       	<td align="left" nowrap="nowrap" <?php  ?>><?php echo ctjTx(Spn($row_Ls_Cnt_Rg['upcol_w'],  ''),'in'); ?></td>
				    </tr>
				    
			    <?php  } while ($row_Ls_Cnt_Rg = $Ls_Cnt_Rg->fetch_assoc()); ?>
		    </table>
		</div>
    </div>
	
	<?php echo HTML_BR.HTML_BR; ?>