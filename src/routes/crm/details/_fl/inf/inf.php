<?php 

	$__inf_fm = 'fm'; $_inf_cls = 'FmInf';
					
	$Ls_Qry = "SELECT * FROM "._BdStr(DBM).TB_MDL_S_TP."
						INNER JOIN "._BdStr(DBM).TB_MDL_S_TP_CL." ON id_mdlstp = mdlstpcl_mdlstp
						INNER JOIN "._BdStr(DBM).TB_CL." ON id_cl = mdlstpcl_cl
					WHERE cl_enc = '".CL_ENC."' AND mdlstp_inf = 1
					ORDER BY mdlstp_ord ASC";		

	$Ls = $__cnx->_qry($Ls_Qry);	
		
	if($Ls){
		
		$row_Ls = $Ls->fetch_assoc(); 
		$Tot_Ls = $Ls->num_rows;
		
		if($Tot_Ls > 0){

			
			$__tabs = [['n'=>'bsc', 'l'=>TX_INIC ],
					   ['n'=>'glb', 'l'=>TX_GLBL, 'bimg'=>$__dt_cl->img->th_50]];
			
			do{	
				
			 	$_enc = $row_Ls['mdlstp_enc'];
			 	$__img = _ImVrs(['img'=>ctjTx($row_Ls['mdlstp_img'],'in'), 'f'=>DMN_FLE_MDL_TP ]);
			 	
			 	$_r[$_enc]['nm'] = $row_Ls['mdlstp_nm'];
			 	$_r[$_enc]['est'] = $row_Ls['mdlstp_clr'];
			 	$_r[$_enc]['img'] = $__img->big;
			 	$_r[$_enc]['tp'] = $row_Ls['mdlstp_tp'];
					
				$__tabs[] = [
					'n'=>$row_Ls['mdlstp_tp'], 
					'l'=>ctjTx($row_Ls['mdlstp_nm'],'in'),
					'bimg'=>$__img->big
				];
						
			}while( $row_Ls = $Ls->fetch_assoc() );
			
			$vl = _jEnc($_r);
		
		}
	
	} 	

	$__cnx->_clsr($Ls);
	
	if($__dt_cl->sbd == "cityu"){
		$__tabs[] = [
			'n'=>'marks', 
			'l'=>ctjTx('Marcas', 'in'),
			'bimg'=>DMN_FLE_MDL_TP.'mdl_s_tp_31.svg'
		];
	}
	
	
	$___Dt->_dvlsfl_all($__tabs,[
		'idb'=>'ok',
		'hd'=>'no',
		'sng'=>'ok',
		'tomny'=>'ok',
		'dtb'=>1
	]);
	
	
	$__inf_ls = __LsDt([ 'k'=>'sis_inf', 'cl'=>$___Ls->cl->id ]);		
			
?>
<style>
	
	._icn_inf{height: 32px;width: 32px;display: inline-block;margin-right: 6px;margin-bottom: -10px !important;background-size: 20px;background-repeat: no-repeat;background-position: center; }
	
</style>
<div class="Cvr_Inf">
	<div id="<?php echo $___Dt->tab->id ?>" class="VTabbedPanels mny">
    	<ul class="TabbedPanelsTabGroup">
			
			<li class="TabbedPanelsTab" style="display: none;"></li>
			
			<?php echo $___Dt->tab->bsc->l ?>
			<?php echo $___Dt->tab->glb->l ?>
            <?php foreach($vl as $k => $v){ ?>  
            	<?php 
					if(_ChckMd($v->tp) || _ChckMd($v->tp.'_cnt') || _ChckMd('inf_'.$v->tp) ){ 

						echo $___Dt->tab->{$v->tp}->l ;

					} ?>
			<?php } ?>
        
			<?php 
				
				if($__dt_cl->sbd == "cityu"){
					echo $___Dt->tab->marks->l;
				}
				 
			?>

        </ul>
		<div class="TabbedPanelsContentGroup">
			
			<section class="_cvr" style="background-color:#9879aa;">
		        <iframe src="<?php echo DMN_ANM; ?>informes/index.html" frameborder="0" width="100%" scrolling="no" height="200"></iframe>
		    </section>		    
		    <div class="TabbedPanelsContent">    
				
				<div class="_intro">
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
			
		    </div>
		    <div class="TabbedPanelsContent">    
		    	
		    	
		    	<div class="TabbedPanelsContent">
		            <div class="_ln">
	            		<?php echo h2($v->nm) ?>
	            		<ul class="grid_thmb">					
	                        <?php    
		
								foreach($__inf_ls->ls->sis_inf as $_inf_k=>$_inf_v){
						      		echo __MnBtn([
						      			'h'=>__t($_inf_v->tp->vl,true)."&_t2=".$_inf_v->rel->vl."&_tp=", 
						      			't'=>$__inf_fm, 
						      			
						      			'c'=>bdiv([ 
						      					'cls'=>'_icn',
						      					'sty'=>'background-image:url('.$_inf_v->img.');' 
						      				]).
						      				'<button class="_info _anm" data-attr-id="'.$_inf_v->enc.'"></button>'.
						      				Spn($_inf_v->tt,'','_tt _anm').
						      				Spn($_inf_v->rsmn->vl,'','_dsc _anm'), 
						      				
						      			'cls'=>$_inf_cls.' _anm', 
						      			'lcls'=>'_anm' 
						      		]);	
					      		}
					      		
	                        ?>
	                    </ul>
		            </div> 
		    	</div>
		    	
		    		
		    </div>

		    <?php foreach($vl as $k => $v){?>	
		    	<?php if(_ChckMd($v->tp) || _ChckMd($v->tp.'_cnt') || _ChckMd('inf_'.$v->tp) ){  ?>
					
					<div class="TabbedPanelsContent">
			            <div class="_ln">
		            		<?php //echo h2($v->nm) ?>
		                    <ul class="grid_thmb">						
		                        <?php
			                        
									foreach($__inf_ls->ls->sis_inf as $_inf_k=>$_inf_v){
							      		echo __MnBtn([
							      			'h'=>__t($_inf_v->tp->vl,true)."&_t2=".$_inf_v->rel->vl."&_tp=".$v->tp, 
							      			't'=>$__inf_fm, 
							      			
							      			'c'=>bdiv([ 
							      					'cls'=>'_icn',
							      					'sty'=>'background-image:url('.$_inf_v->img.');' 
							      				]).
						      					'<button class="_info _anm" data-attr-id="'.$_inf_v->enc.'"></button>'.
						      					Spn($_inf_v->tt,'','_tt _anm').
						      					Spn($_inf_v->rsmn->vl,'','_dsc _anm'),
						      					 
							      			'cls'=>$_inf_cls.' _anm', 
							      			'lcls'=>'_anm' 
							      		]);	
						      		}
						      		
      		
			                        //Costantes de texto - Terminarlas ricardo
									/*
									echo __MnBtn(['h'=>__t('mdl_cnt',true)."&_t2=md&_tp=".$v->tp, 't'=>$__inf_fm, 'c'=>Spn(TX_LDSMD), 'cls'=>$_inf_cls]);
		                            echo __MnBtn(['h'=>__t('mdl_cnt',true)."&_t2=md_f&_tp=".$v->tp, 't'=>$__inf_fm, 'c'=>Spn(TX_LDSMDAT), 'cls'=>$_inf_cls]);
		                            echo __MnBtn(['h'=>__t('mdl_cnt',true)."&_t2=etp&_tp=".$v->tp, 't'=>$__inf_fm, 'c'=>Spn(TX_LDSETPS), 'cls'=>$_inf_cls]);
		                            echo __MnBtn(['h'=>__t('mdl_cnt',true)."&_t2=est&_tp=".$v->tp, 't'=>$__inf_fm, 'c'=>Spn(TX_LDSTDS), 'cls'=>$_inf_cls]);
		                            echo __MnBtn(['h'=>__t('mdl_cnt',true)."&_t2=mdl&_tp=".$v->tp, 't'=>$__inf_fm, 'c'=>Spn(TX_LDSMDL), 'cls'=>$_inf_cls]);
		                            echo __MnBtn(['h'=>__t('mdl_cnt',true)."&_t2=gst&_tp=".$v->tp, 't'=>$__inf_fm, 'c'=>Spn(TX_USGSTNS), 'cls'=>$_inf_cls]);
		                            echo __MnBtn(['h'=>__t('mdl_cnt',true)."&_t2=md_est&_tp=".$v->tp, 't'=>$__inf_fm, 'c'=>Spn(TX_MDSTDS), 'cls'=>$_inf_cls]);
		                            echo __MnBtn(['h'=>__t('mdl_cnt',true)."&_t2=cnt_gst&_tp=".$v->tp, 't'=>$__inf_fm, 'c'=>Spn(TX_GSTNCNTS), 'cls'=>$_inf_cls]);
		                            echo __MnBtn(['h'=>__t('mdl_cnt',true)."&_t2=gst_are&_tp=".$v->tp, 't'=>$__inf_fm, 'c'=>Spn(TX_MNGNTAREA), 'cls'=>$_inf_cls]);
									echo __MnBtn(['h'=>__t('mdl_cnt',true)."&_t2=us&_tp=".$v->tp, 't'=>$__inf_fm, 'c'=>Spn('Leads por usuario'), 'cls'=>$_inf_cls]); //Ricardo
		                            */
		                        ?>
		                    </ul>
			            </div>
			    	</div>
				<?php	} ?>
		    <?php } ?>   
			
			
			<?php if($__dt_cl->sbd == "cityu"){ ?>

				<div class="TabbedPanelsContent">
					<div class="_ln">
						<?php echo h2($v->nm) ?>
						<ul class="grid_thmb">					
							<?php    

								echo __MnBtn([
									'h'=>__t('marks',true)."&_t2=sls_x_day&_tp=&__fch_act=ok", 
									't'=>'fm', 
									
									'c'=>bdiv([ 
											'cls'=>'_icn',
											'sty'=>'background-image:url(https://fle.sumr.cloud/sis/slc/slc_902.svg);' 
										]).
										'<button class="_info _anm" data-attr-id="ab7c01aa65a5700881f293f8f94d698e5cd2de8c"></button>'.
										Spn('Ventas x dia - Fechas', '', '_tt _anm').
										Spn('', '', '_dsc _anm'), 
										
									'cls'=>'FmInf _anm', 
									'lcls'=>'_anm' 
								]);
		
								echo __MnBtn([
									'h'=>__t('marks',true)."&_t2=sls&_tp=&__fch_act=no", 
									't'=>'fm', 
									
									'c'=>bdiv([ 
											'cls'=>'_icn',
											'sty'=>'background-image:url(https://fle.sumr.cloud/sis/slc/slc_902.svg);' 
										]).
										'<button class="_info _anm" data-attr-id="ab7c01aa65a5700881f293f8f94d698e5cd2de8c"></button>'.
										Spn('Ventas totales - Columnas', '', '_tt _anm').
										Spn('', '', '_dsc _anm'), 
										
									'cls'=>'FmInf _anm', 
									'lcls'=>'_anm' 
								]);

								echo __MnBtn([
									'h'=>__t('marks',true)."&_t2=sls_x_week&_tp=&__fch_act=ok", 
									't'=>'fm', 
									
									'c'=>bdiv([ 
											'cls'=>'_icn',
											'sty'=>'background-image:url(https://fle.sumr.cloud/sis/slc/slc_902.svg);' 
										]).
										'<button class="_info _anm" data-attr-id="ab7c01aa65a5700881f293f8f94d698e5cd2de8c"></button>'.
										Spn('Ventas totales - Día de Semana - Marca', '', '_tt _anm').
										Spn('', '', '_dsc _anm'), 
										
									'cls'=>'FmInf _anm', 
									'lcls'=>'_anm' 
								]);

								echo __MnBtn([
									'h'=>__t('marks',true)."&_t2=sls_x_week_2&_tp=&__fch_act=no", 
									't'=>'fm', 
									
									'c'=>bdiv([ 
											'cls'=>'_icn',
											'sty'=>'background-image:url(https://fle.sumr.cloud/sis/slc/slc_902.svg);' 
										]).
										'<button class="_info _anm" data-attr-id="ab7c01aa65a5700881f293f8f94d698e5cd2de8c"></button>'.
										Spn('Ventas totales - Día de Semana - Totales', '', '_tt _anm').
										Spn('', '', '_dsc _anm'), 
										
									'cls'=>'FmInf _anm', 
									'lcls'=>'_anm' 
								]);

								echo __MnBtn([
									'h'=>__t('marks',true)."&_t2=sls_x_mes_y&_tp=&__fch_act=no", 
									't'=>'fm', 
									
									'c'=>bdiv([ 
											'cls'=>'_icn',
											'sty'=>'background-image:url(https://fle.sumr.cloud/sis/slc/slc_902.svg);' 
										]).
										'<button class="_info _anm" data-attr-id="ab7c01aa65a5700881f293f8f94d698e5cd2de8c"></button>'.
										Spn('Ventas Totales por mes', '', '_tt _anm').
										Spn('', '', '_dsc _anm'), 
										
									'cls'=>'FmInf _anm', 
									'lcls'=>'_anm' 
								]);

								echo __MnBtn([
									'h'=>__t('marks',true)."&_t2=sls_x_mes_y_2&_tp=&__fch_act=no", 
									't'=>'fm', 
									
									'c'=>bdiv([ 
											'cls'=>'_icn',
											'sty'=>'background-image:url(https://fle.sumr.cloud/sis/slc/slc_902.svg);' 
										]).
										'<button class="_info _anm" data-attr-id="ab7c01aa65a5700881f293f8f94d698e5cd2de8c"></button>'.
										Spn('Ventas Totales por mes y año', '', '_tt _anm').
										Spn('', '', '_dsc _anm'), 
										
									'cls'=>'FmInf _anm', 
									'lcls'=>'_anm' 
								]);

								echo __MnBtn([
									'h'=>__t('marks',true)."&_t2=sls_esf&_tp=&__fch_act=no", 
									't'=>'fm', 
									
									'c'=>bdiv([ 
											'cls'=>'_icn',
											'sty'=>'background-image:url(https://fle.sumr.cloud/sis/slc/slc_902.svg);' 
										]).
										'<button class="_info _anm" data-attr-id="ab7c01aa65a5700881f293f8f94d698e5cd2de8c"></button>'.
										Spn('Esfuerzo', '', '_tt _anm').
										Spn('', '', '_dsc _anm'), 
										
									'cls'=>'FmInf _anm', 
									'lcls'=>'_anm' 
								]);

								echo __MnBtn([
									'h'=>__t('marks',true)."&_t2=sls_esf_x_mes&_tp=&__fch_act=no", 
									't'=>'fm', 
									
									'c'=>bdiv([ 
											'cls'=>'_icn',
											'sty'=>'background-image:url(https://fle.sumr.cloud/sis/slc/slc_902.svg);' 
										]).
										'<button class="_info _anm" data-attr-id="ab7c01aa65a5700881f293f8f94d698e5cd2de8c"></button>'.
										Spn('Esfuerzo x mes', '', '_tt _anm').
										Spn('', '', '_dsc _anm'), 
										
									'cls'=>'FmInf _anm', 
									'lcls'=>'_anm' 
								]);

								echo __MnBtn([
									'h'=>__t('marks',true)."&_t2=sls_tck&_tp=&__fch_act=no", 
									't'=>'fm', 
									
									'c'=>bdiv([ 
											'cls'=>'_icn',
											'sty'=>'background-image:url(https://fle.sumr.cloud/sis/slc/slc_902.svg);' 
										]).
										'<button class="_info _anm" data-attr-id="ab7c01aa65a5700881f293f8f94d698e5cd2de8c"></button>'.
										Spn('Tickets', '', '_tt _anm').
										Spn('', '', '_dsc _anm'), 
										
									'cls'=>'FmInf _anm', 
									'lcls'=>'_anm' 
								]);

								echo __MnBtn([
									'h'=>__t('marks',true)."&_t2=sls_tck_2&_tp=&__fch_act=no", 
									't'=>'fm', 
									
									'c'=>bdiv([ 
											'cls'=>'_icn',
											'sty'=>'background-image:url(https://fle.sumr.cloud/sis/slc/slc_902.svg);' 
										]).
										'<button class="_info _anm" data-attr-id="ab7c01aa65a5700881f293f8f94d698e5cd2de8c"></button>'.
										Spn('Tickets x mes', '', '_tt _anm').
										Spn('', '', '_dsc _anm'), 
										
									'cls'=>'FmInf _anm', 
									'lcls'=>'_anm' 
								]);

								echo __MnBtn([
									'h'=>__t('marks',true)."&_t2=sls_trs&_tp=&__fch_act=no", 
									't'=>'fm', 
									
									'c'=>bdiv([ 
											'cls'=>'_icn',
											'sty'=>'background-image:url(https://fle.sumr.cloud/sis/slc/slc_902.svg);' 
										]).
										'<button class="_info _anm" data-attr-id="ab7c01aa65a5700881f293f8f94d698e5cd2de8c"></button>'.
										Spn('Transacciones', '', '_tt _anm').
										Spn('', '', '_dsc _anm'), 
										
									'cls'=>'FmInf _anm', 
									'lcls'=>'_anm' 
								]);

								echo __MnBtn([
									'h'=>__t('marks',true)."&_t2=sls_trs_2&_tp=&__fch_act=no", 
									't'=>'fm', 
									
									'c'=>bdiv([ 
											'cls'=>'_icn',
											'sty'=>'background-image:url(https://fle.sumr.cloud/sis/slc/slc_902.svg);' 
										]).
										'<button class="_info _anm" data-attr-id="ab7c01aa65a5700881f293f8f94d698e5cd2de8c"></button>'.
										Spn('Transacciones x mes', '', '_tt _anm').
										Spn('', '', '_dsc _anm'), 
										
									'cls'=>'FmInf _anm', 
									'lcls'=>'_anm' 
								]);
										
								echo __MnBtn([
									'h'=>__t('marks',true)."&_t2=sls_mtr_c&_tp=&__fch_act=no", 
									't'=>'fm', 
									
									'c'=>bdiv([ 
											'cls'=>'_icn',
											'sty'=>'background-image:url(https://fle.sumr.cloud/sis/slc/slc_902.svg);' 
										]).
										'<button class="_info _anm" data-attr-id="ab7c01aa65a5700881f293f8f94d698e5cd2de8c"></button>'.
										Spn('Ventas por metro cuadrado', '', '_tt _anm').
										Spn('', '', '_dsc _anm'), 
										
									'cls'=>'FmInf _anm', 
									'lcls'=>'_anm' 
								]);

								/*echo __MnBtn([
									'h'=>__t('marks',true)."&_t2=sls_mtr_c_2&_tp=&__fch_act=no", 
									't'=>'fm', 
									
									'c'=>bdiv([ 
											'cls'=>'_icn',
											'sty'=>'background-image:url(https://fle.sumr.cloud/sis/slc/slc_902.svg);' 
										]).
										'<button class="_info _anm" data-attr-id="ab7c01aa65a5700881f293f8f94d698e5cd2de8c"></button>'.
										Spn('Ventas por metro cuadrado', '', '_tt _anm').
										Spn('', '', '_dsc _anm'), 
										
									'cls'=>'FmInf _anm', 
									'lcls'=>'_anm' 
								]);*/

								echo __MnBtn([
									'h'=>__t('marks',true)."&_t2=sls_year&_tp=&__fch_act=no", 
									't'=>'fm', 
									
									'c'=>bdiv([ 
											'cls'=>'_icn',
											'sty'=>'background-image:url(https://fle.sumr.cloud/sis/slc/slc_902.svg);' 
										]).
										'<button class="_info _anm" data-attr-id="ab7c01aa65a5700881f293f8f94d698e5cd2de8c"></button>'.
										Spn('Ventas por año', '', '_tt _anm').
										Spn('', '', '_dsc _anm'), 
										
									'cls'=>'FmInf _anm', 
									'lcls'=>'_anm' 
								]);

								echo __MnBtn([
									'h'=>__t('marks',true)."&_t2=sls_fac&_tp=&__fch_act=no", 
									't'=>'fm', 
									
									'c'=>bdiv([ 
											'cls'=>'_icn',
											'sty'=>'background-image:url(https://fle.sumr.cloud/sis/slc/slc_902.svg);' 
										]).
										'<button class="_info _anm" data-attr-id="ab7c01aa65a5700881f293f8f94d698e5cd2de8c"></button>'.
										Spn('Facturacion por mes', '', '_tt _anm').
										Spn('', '', '_dsc _anm'), 
										
									'cls'=>'FmInf _anm', 
									'lcls'=>'_anm' 
								]);

								echo __MnBtn([
									'h'=>__t('marks',true)."&_t2=sls_fac_year&_tp=&__fch_act=no", 
									't'=>'fm', 
									
									'c'=>bdiv([ 
											'cls'=>'_icn',
											'sty'=>'background-image:url(https://fle.sumr.cloud/sis/slc/slc_902.svg);' 
										]).
										'<button class="_info _anm" data-attr-id="ab7c01aa65a5700881f293f8f94d698e5cd2de8c"></button>'.
										Spn('Facturacion comparativo', '', '_tt _anm').
										Spn('', '', '_dsc _anm'), 
										
									'cls'=>'FmInf _anm', 
									'lcls'=>'_anm' 
								]);
								
							?>
						</ul>
					</div>
				</div>
			<?php } ?>
		</div>
    </div>		
</div>   

<style>
	
	.Cvr_Inf .VTabbedPanels{ display: flex; }
	.Cvr_Inf .VTabbedPanels.mny > .TabbedPanelsTabGroup{ width: 64px !important; padding-top: 20px; }
	.Cvr_Inf .VTabbedPanels > .TabbedPanelsContentGroup{ width: 100% !important; }	
	
	.Cvr_Inf .VTabbedPanels > .TabbedPanelsTabGroup .TabbedPanelsTab{ min-height:50px; background-repeat: no-repeat; background-position: center center; background-size: 40% auto; border: 1px dashed #8b8f92 !important; }
	.Cvr_Inf .VTabbedPanels > .TabbedPanelsTabGroup .TabbedPanelsTabSelected,
	.Cvr_Inf .VTabbedPanels > .TabbedPanelsTabGroup .TabbedPanelsTabHover{ border: 2px solid #404447 !important; opacity: 1; background-size: 50% auto; }
	
	.Cvr_Inf .VTabbedPanels .TabbedPanelsTab._bsc{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>inf_bsc.svg); }
	.Cvr_Inf .VTabbedPanels .TabbedPanelsTab._glb{ background-size: 100% auto; }
	.Cvr_Inf .VTabbedPanels .TabbedPanelsTab._vuni{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>vuni.svg); }
	.Cvr_Inf .VTabbedPanels .TabbedPanelsTab._ecor{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>ecor.svg); }
	.Cvr_Inf .VTabbedPanels .TabbedPanelsTab._marks{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>mark.svg); }

	.Cvr_Inf ._intro{}
	.Cvr_Inf ._intro ._p{ display: flex; padding-bottom: 100px; }
	.Cvr_Inf ._intro ._p ._c{ vertical-align: top; min-height: 200px; width: 33.3%; font-size: 11px; font-family: Work Sans, Roboto, Tahoma; padding: 40px 50px 20px 50px; color: #64757b; }
	.Cvr_Inf ._intro ._p ._c h2{ font-weight: 500; font-size: 23px; border: none; text-align: center; color: #0e0e0e; }
	.Cvr_Inf ._intro ._p ._c ._img{ width: 100px; height: 100px; margin-left: auto; margin-right: auto; background-size: 100% auto; background-position: center center; background-repeat: no-repeat; margin-top: 20px; margin-bottom: 20px; }
	.Cvr_Inf ._intro ._p ._c ._img.books{ background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>lrn_intro_books.svg');}
	.Cvr_Inf ._intro ._p ._c ._img.studnt{ background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>lrn_intro_student.svg');}
	.Cvr_Inf ._intro ._p ._c ._img.knw{ background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>lrn_intro_know.svg'); }
	
	
	.Cvr_Inf ._intro ._p ._c p{ font-weight: 300; text-align: justify; }
	
	.Cvr_Inf .grid_thmb{ display: block; width: 100%; white-space: normal; padding: 50px; text-align: center;  }
	.Cvr_Inf .grid_thmb li{ display: inline-block; margin:0px 35px 50px 35px; position: relative; vertical-align: top; }
	.Cvr_Inf .grid_thmb li a{ cursor: pointer; text-decoration: none; white-space: normal; }
	
	.Cvr_Inf .grid_thmb li a ._icn{ border-radius:10px; -moz-border-radius:10px; -webkit-border-radius:10px; width: 200px; height: 130px; display: block; background-repeat: no-repeat; background-position: center center; background-size: auto 100%; border: 1px dotted white; pointer-events: none; }
	
	.Cvr_Inf .grid_thmb li a ._tt{ text-transform: uppercase; font-family: Economica; font-size: 11px; display: block; background-color:var(--main-bg-color); color: white; position: absolute; top: 115px; left: 50%; -webkit-transform: translateX(-50%); transform: translateX(-50%); white-space: nowrap; text-overflow: ellipsis; max-width: 60%; border-radius:10px; -moz-border-radius:10px; -webkit-border-radius:10px; padding: 5px 10px; }
	
	
	.Cvr_Inf .grid_thmb li a ._dsc{ color: #454a4b; font-family: Roboto; font-size: 10px; text-align: center; white-space: normal; display: block; width: 200px; padding: 10px; color: #838586; margin-top: 20px; }
	.Cvr_Inf .grid_thmb li a ._info{ background-color: none; border: none; z-index: 999; position: absolute; right: -15px; top: 0px; width: 30px; height: 30px; background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>inf_help.svg'); background-repeat: no-repeat; background-position: center center; background-size:100% auto; opacity:0; pointer-events: none; cursor: pointer; }
	.Cvr_Inf .grid_thmb li a ._info:hover{ background-size:90% auto; }
	
	.Cvr_Inf .grid_thmb li a:hover{ -webkit-animation: _puff 0.4s ease-out; }
	.Cvr_Inf .grid_thmb li a:hover ._tt{ background-color:var(--second-bg-color); }
	.Cvr_Inf .grid_thmb li a:hover ._info{ top: -15px; opacity: 1; pointer-events: all; }
	.Cvr_Inf .grid_thmb li a:hover ._icn{ border-color: var(--second-bg-color); background-size: auto 90%; }
	
</style>
	                             
<?php 
	$CntWb .= "

		$('.FmInf').click(function(e){ 
			
			e.preventDefault();
										
			if(e.target != this){
		    	e.stopPropagation(); return;
			}else{
				
				var lurl = $(this).attr('l-url')+'".TXGN_POP."&Rd='+Math.random();
			
				$.colorbox({
					href:lurl,
					width:'90%', 
					height:'90%', 
					overlayClose:false, 
					escKey:false,
					trapFocus:false
				});
			}
			
		});
		
		
		$('.Cvr_Inf .grid_thmb li a ._info').click(function(e){ 
		
			e.preventDefault();
										
			if(e.target != this){
				
		    	e.stopPropagation(); return;
		    	
			}else{
				
				var _id = $(this).attr('data-attr-id');
						
				_ldCnt({ 
					u:'".FL_DT_GN.__t('inf_dsc',true).TXGN_POP.TXGN_BX.$___Ls->bx_rld.ADM_LNK_SB."'+_id,
					w:'98%',
					h:'98%',
					pop:'ok',
					pnl:{
						e:'ok',
						tp:'h',
						s:'l'
					}
				});	
			
			}
			
		});
	
	"; 

?> 

<style>
	.Cvr_Inf .grid_thmb li{margin: 0px 20px 50px 20px !important;}
</style>