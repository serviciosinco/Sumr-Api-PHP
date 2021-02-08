<?php 
	
	$_dt_scl_acc_cnv = GtSclAccCnvDt([ 'enc'=>$___Dt->gt->isb ]);
		
	$___Ls = new CRM_Ls();
	$___Ls->qry->all = 'ok';
	$___Ls->cnx->cl = 'ok';
	$___Ls->_strt();	
	
	$__tpR = $_GET['_t2'];
		
	if($__tpR=='obs'){ $__fl .= " AND id_us != ".SISUS_ID." "; }	

	$___Ls->qrys = "	SELECT *, 
								(SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT.",
								(SELECT COUNT(*) FROM "._BdStr(DBM).TB_US_SCL_ACC_CNV." WHERE ussclacccnv_us = id_us AND ussclacccnv_sclacccnv='".$_dt_scl_acc_cnv->id."' ) AS __tot_rsp,
								(
									SELECT
										GROUP_CONCAT(clare_tt SEPARATOR ' / ')
									FROM
										"._BdStr(DBM).TB_US_ARE."
										INNER JOIN "._BdStr(DBM).TB_CL_ARE." ON usare_clare = id_clare
									WHERE usare_us = id_us AND clare_est = 1
								
								) AS __are
									
									
						FROM "._BdStr(DBM).TB_US."
							INNER JOIN "._BdStr(DBM).TB_US_EST." ON us_est = id_usest
							INNER JOIN "._BdStr(DBM).TB_SIS_SLC." ON us_gnr = id_sisslc
						WHERE
					  		 id_us IN ( SELECT uscl_us 
					  		 			FROM "._BdStr(DBM).TB_US_CL."
					  		 				 INNER JOIN "._BdStr(DBM).TB_CL." ON uscl_cl = id_cl
					  		 			WHERE cl_sbd = '".Gt_SbDMN()."'
					  		 ) 
					  		 $__fl
					  	ORDER BY __tot_rsp DESC, us_ap ASC, us_nm ASC";
	
	$___Ls->_bld(); 
?>	
<?php if(($___Ls->qry->tot > 0)){ ?>
	<div class="Dsh_Scl_Us">
		
		<ul>
			
			<li class="sch"><?php echo HTML_inp_tx('us_sch_'.$___Ls->id_rnd, TX_SEARCH, ''); ?></li>
			
			<?php do { ?>
		  		
		  		<?php 
			  		
			  		$__slc = 'off';
			  		
			  		if( !isN($___Ls->ls->rw['us_img']) ){
						$_img = _ImVrs(['img'=>$___Ls->ls->rw['us_img'], 'f'=>DMN_FLE_US ]);
						$_img = $_img->th_50;
					}else{
						$_img = GtUsImg([ 'img'=>$___Ls->ls->rw['us_img'], 'gnr'=>$___Ls->ls->rw['us_gnr'] ]);
					}
					
					if($___Ls->gt->tsb == 'rsp'){
						if($_dt_scl_acc_cnv->rsp->id == $___Ls->ls->rw['id_us']){ $__slc = 'on'; }
					}elseif($___Ls->gt->tsb == 'obs'){
						foreach($_dt_scl_acc_cnv->obs->ls as $_obs_k=>$_obs_v){
							if($_obs_v->id == $___Ls->ls->rw['id_us']){
								$__slc = 'on'; break;
							}
						}
					}
		
							
		  		?>
		  		
		  		<li id="sclacccnv_us_slc_<?php echo $___Ls->ls->rw['us_enc']; ?>" us-id="<?php echo $___Ls->ls->rw['us_enc']; ?>" us-est="<?php echo $__slc; ?>" class="us-itm">
		  			<span style="background-image:url(<?php echo $_img; ?>);" class="_icn"></span>
		  			<?php 
			  			echo ctjTx($___Ls->ls->rw['us_nm'].' '.$___Ls->ls->rw['us_ap'],'in').
			  				 Spn(ctjTx($___Ls->ls->rw['us_crg'],'in'),'','_crg').
			  				 Spn(ctjTx( !isN($___Ls->ls->rw['__are'])?$___Ls->ls->rw['__are']:' - sin area - ' ,'in'),'','_are')
			  		?>
		  		</li>
		  	
		  	<?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>
	  	
		</ul>
		
	</div>
	
	
	
	<?php 
		
		$CntWb .= " 
			SUMR_Main.LsSch({ str:'#us_sch_".$___Ls->id_rnd."', ls:$('.Dsh_Scl_Us ul > li:not(.sch) ') });
			
			
			
			


			$('.Dsh_Scl_Us li.us-itm').click(function(){				
			
				var __btn = $(this);
				var __id = __btn.attr('us-id');
				var __est = __btn.attr('us-est');
				
				if(__est=='on'){ 
					var est = 'del'; var txt='¿Desea quitar este usuario?'; var stp='warning'; var sclr='#E1544A';
				}else{ 
					var est = 'in'; var txt='¿Desea asignar este usuario?'; var stp='info'; var sclr='".BTN_OK_CLR."';
				}
				
				
				swal({   
					title:'".TX_CFRFR."',    			
					title:'Confirmación',   
					text: txt,
					type: stp,  
					showCancelButton: true,   
					confirmButtonColor: sclr,   
					confirmButtonText: 'Si, hazlo ahora',
					cancelButtonText: 'No, gracias'  
				}, 
				function(c){  
					swal.close(); 
					SUMR_Main.scl.f.cnv.us_sve();	
				});	
													
							
			});
		
		 
		";	
		
	?>
	
<?php $___Ls->_bld_l_pgs(); ?>
<?php } ?>

<style>
	
	/*----------- TAREA - USUARIOS - LISTADO -----------*/
	
	.Dsh_Scl_Us h2{ font-family: Economica; text-align: center; }
	.Dsh_Scl_Us ul{ list-style-type: none; padding: 0; margin: 0 auto; width: 90%; }
	.Dsh_Scl_Us .us-itm{ width: 100%; padding: 5px 40px 5px 40px; position: relative; white-space: nowrap; text-overflow: ellipsis; text-transform: capitalize; -webkit-filter: grayscale(100%); filter: grayscale(100%); cursor: pointer; font-size: 11px; font-weight:300; border-radius:8px; -moz-border-radius:8px; -webkit-border-radius:8px; border: 2px solid #e2e6e7; margin-bottom: 5px; color:#b6bbbe; font-weight: bolder; }
	
	.Dsh_Scl_Us .us-itm[us-est="on"],
	.Dsh_Scl_Us .us-itm:hover{ -webkit-filter: grayscale(0%); filter: grayscale(0%); background-color: #c2f3ce; border-color: #c2f3ce; color:#000; }
	.Dsh_Scl_Us .us-itm[us-est="on"]:after{ width: 37px; height: 37px; position: absolute; right: -8px; top: -4px; background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>tra_us_chk.svg'); background-repeat: no-repeat; background-position: center center; background-size: auto 100%; border-radius:200px; -moz-border-radius:200px; -webkit-border-radius:200px;background-color: white; }
	
	.Dsh_Scl_Us .us-itm ._icn{ width: 35px; height: 35px; position: absolute; left: -8px; top: 2px; border-radius:200px; -moz-border-radius:200px; -webkit-border-radius:200px; background-color: #cbcecf; background-repeat: no-repeat; background-position: center center; background-size: auto 100%; }
	
	
	.Dsh_Scl_Us .us-itm ._crg{ display: block; width: 100%; }
	.Dsh_Scl_Us .us-itm ._are{ display: block; width: 100%; padding: 0 0 0 20px; position: relative; font-weight: 300; font-size: 10px; }
	.Dsh_Scl_Us .us-itm ._are:empty{ display: none; }
	.Dsh_Scl_Us .us-itm ._are::before{ background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>scl_rsp.svg'); display: block; position: absolute; left: 0; top:2px; width: 15px; height: 15px; background-repeat: no-repeat; background-position: center center; background-size: auto 60%; opacity: 0.4; border-radius:200px;
-moz-border-radius:200px; -webkit-border-radius:200px; background-color: #d8e0e2; }
	
	
	
	
	.Dsh_Scl_Us .sch{ width: 100%; margin-bottom: 30px; }
	.Dsh_Scl_Us .sch input[type=text]{ width: 100%; }
	
</style>