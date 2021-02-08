<?php 
if(class_exists('CRM_Cnx')){


$__i = Php_Ls_Cln($_GET['__i']);

$__lssb = _SbLs();	
$__bxrld = _BxRld_ID();
if($__lssb == 'ok'){ $__vrall = TXGN_POP.TXGN_BX.$__bxrld.LNK_RND.Gn_Rnd(20); }
$__id = 'id_atmttrgrcndc'; // Id de Datos
$__bd = MDL_EC_AUTO_TRGR_CNDC_BD; // Base de Datos
$__bd2 = MDL_SIS_EC_CNDC_BD; // Base de Datos

$__bdtp = $__t; // Tipo de Datos
$__fmnm = 'EdEcAutoTrgrCndc'; // Nombre Formulario

$__lsgt_flt = JQ__ldCnt(FL_LS_GN.__t($__bdtp,true)._pFl(['g'=>$__lsgt_flt_cmp.$__lsgt_flt_cmp_nd]).$_adsch.$__vrall, $__bxrld,'',false); // Link Nuevo

if($_bxpop != 'ok'){
	$__lsgt = JQ__ldCnt(FL_LS_GN.__t($__bdtp,true)._pFl(['g'=>$Flt_Cmp.$Flt_CmpND, 't'=>'get']).$_adsch.TXGN_LS.$__vrall, $__bxrld); // Link Listas
}else{
	$__lsgt = 'javascript:'.JS_SCR_POPCLS; // Link Listas
}

if($__lssb == 'ok'){
	$__lsgtin = 'SUMR_Main.anm.h_cmpct(\'on\'); $.colorbox({href:"'.FL_LS_GN.__t($__bdtp, true)._SbLs_ID()._SbLs_Vst().TXGN_ING.TXGN_POP.$__vrall.LNK_RND.Gn_Rnd(20).'",trapFocus:false, width:'.CLRBX_WD_POP.', height:"90%", overlayClose:false, escKey:false, onClosed:function(){ SUMR_Main.anm.h_cmpct(); }	});'; // Link Nuevo
}else{
	$__inf = FL_FM_GN.'?'.__t($__bdtp);
	$__lsgtin = JQ__ldCnt(FL_LS_GN.__t($__bdtp,true).TXGN_ING, $__bxrld, '', '', false); // Link Nuevo
}

$__img = 'no'; // Inorduye Imagen?
$__totrws = $_GET['totRws'];

if(_SbLs_ID('i')){ $__fl .= _AndSql('atmttrgrcndc_cnt', _SbLs_ID('i')); $__jqte = 'jqte_pop'.$__prfx_fm; }

if (isset($_GET['_i'])) {
		
	$___Ls->qrys = sprintf("SELECT * 
							FROM $__bd, $__bd2
					   		WHERE atmttrgrcndc_cndc = id_eccndc AND
							 $__id = %s LIMIT 1", GtSQLVlStr($_GET['_i'], "int"));	
	
}else{ 

	$Ls_Whr = "FROM $__bd, $__bd2
			   WHERE atmttrgrcndc_cndc = id_eccndc AND
					 atmttrgrcndc_trgr = '".GtSQLVlStr($__i, "int")."' $__schcod 
			  ORDER BY id_atmttrgrcndc DESC";
	$___Ls->qrys = "SELECT *, (SELECT COUNT(*) $Ls_Whr) AS __rgtot $Ls_Whr";
	
	
	$__tt = 'CONDICIONALES';

} 



$___Ls->_bld();


if(HTML_Ls_Chck('l', $_GET["Pr"], NULL, $___Ls->dt->tot)){ 
			
			$__blq = 'off'; 
			$__Bld = new CRM_LsFm();
			$__Bld->tp = $__bdtp; 
			$__Bld->hdr_tt = $__tt; 
			$__Bld->hdr_ls =$__ls;
			$__Bld->hdr_md_ing = true; 
			$__Bld->hdr_in =$__lsgtin; 
			$__Bld->hdr_inf = $__inf;
			$__Bld->hdr_sb = $__lssb; 
			$__Bld->tot = TT_RWS;
			$__Bld->ftr_pgn = PrG($startRow_Ls_Rg,SIS_NMRG,TT_RWS,TT_PGS).PgsCnt(TT_PGS,$Pgs);

		do {
			  	
		  	$Nm = Itc($NmNw); 
            $_lnktr_l = FL_LS_GN.__t($__bdtp,true)._pFl(['g'=>$Flt_Cmp.$Flt_CmpND, 't'=>'get'])._SbLs_ID()._SbLs_Vst().ADM_LNK_DT.$___Ls->ls->rw[$__id]._pFl(['g'=>$Flt_Cmp.$Flt_CmpND, 't'=>'get']).$__vrall.$_adsch;
            $_lnktr = _Ls_Lnk_Rw(['l'=>$_lnktr_l, 'sb'=>$__lssb, 'r'=>$__bxrld]);

			$__actdt = GtAtmtTrgrCndcDt(['id'=>$___Ls->ls->rw['id_atmttrgrcndc'], 'dt'=>'ok']);
			
			$__bdy .= $__Bld->_Td([
							'lnk'=>$_lnktr,
							'n'=>$NmNw,
							'c'=>'	<td width="99%" align="left" nowrap="nowrap" class="__sgm_var">'.h2(ctjTx($___Ls->ls->rw['eccndc_nm'],'in')).
										Strn(ctjTx($___Ls->ls->rw['sisecsgmvar_nm'] ,'in')).' '. ($__actdt->ls->d->tt!=NULL?$__actdt->ls->d->tt:'')
						            .'</td>'
					  		]	  	
						); 
			
			$NmNw = $Nm;
			
  		} while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); 
  		
  		$__Bld->body = $__bdy; 
  		$Bld_r = $__Bld->_Ls();
  		
  		echo $Bld_r->html;
  		
  		
  		$CntWb .= $Bld_r->js;
  		$CntWb .= " $('#".TBGRP."_gst ._n').html('".$Tot_Ls_Rg."'); ";
} 
	
?>
<?php if(HTML_Ls_Chck('f', $_GET["Pr"], $_GET["_i"], $___Ls->dt->tot)){ $__blq = 'on'; ?>
<div class="FmTb">
  <div id="<?php echo $___Ls->fm->bx->id ?>">
    <?php 
	    	echo HTML_Fm_Del($__id, $___Ls->dt->rw[$__id], Fl_Rnd(PRC_GN.__t($__bdtp,true)), $__fmnm); 
  	echo VlFm([
		  	'fm'=>$__fmnm.'El',
		  	'fm_el'=>'ok',
		  	'fm_tp'=>$__bdtp,
		  	'fm_sbl'=>$__lssb,  
		  	'fm_ls'=>FL_LS_GN, 
		  	'fm_vr'=>__t($__bdtp),
		  	'fm_pop'=>$_bxpop,
		  	'fm_cnt2'=>$__bxrld
		 ]) . 
		 VlFm([
			  	'fm'=>$__fmnm,
			  	'fm_tp'=>$__bdtp,
			  	'fm_sbl'=>$__lssb,
			  	'fm_ls'=>FL_LS_GN, 
			  	'fm_vr'=>__t($__bdtp).$__vrall,
			  	'fm_pop'=>$_bxpop,
			  	'fm_cnt2'=>$__bxrld
		  ]);  
  	?>
    <?php 
		$__fm_trg = ' target="_self" name="'.$__fmnm.'" id="'.$__fmnm.'" ';
	?>
    <form action="<?php echo Fl_Rnd(PRC_GN.__t($__bdtp,true)) ?>" method="POST" <?php echo $__fm_trg ?> >

	
	 <?php $___fm_hdr = 	HTML_Fm_Hdr($__img, $___Ls->dt->tot, $__imgdir.$___Ls->dt->rw[$__imgid], HTML_ClrBxImg($__bdtp).$___Ls->dt->rw[$__id], $__tt, $__lsgt, $_GET["Pr"], $_GET["_i"], $__lssb, $__bdtp, '', '', $__md_ing, $__md_mod, $_bxpop); echo $___fm_hdr->html; $CntWb .= $___fm_hdr->js; ?>
	  	<div id="<?php echo $___Ls->fm->fld->id ?>"><?php echo HTML_Fm_MMFM($__id, $___Ls->dt->rw[$__id], $___Ls->dt->tot, $__fmnm); ?>
      
        
					<div class="ln_2col">
						<div class="_c">
							<?php echo HTML_inp_hd('atmttrgrcndc_trgr', _SbLs_ID('i')); ?>
							<?php echo LsSisEcCndc('atmttrgrcndc_cndc','id_eccndc', $___Ls->dt->rw['atmttrgrcndc_cndc'], '', 2); $CntWb .= JQ_Ls('atmttrgrcndc_cndc', ''); ?>	
						</div>
						<div class="_c">
							<div id="atmt_trgr_cndc_bx" class="_sbls">
                            	<?php 	
	                            	if($___Ls->dt->rw['atmttrgrcndc_cndc'] != ''){ 
	                            		$__t_s_i = $___Ls->dt->rw['atmttrgrcndc_cndc']; 
	                            	}else{ 
		                            	$__t_s_i = 2; 
		                           	} 
		                            
		                            if($___Ls->dt->rw['atmttrgrcndc_v_vl'] != ''){
			                        	$__i = $___Ls->dt->rw['atmttrgrcndc_v_vl'];     
		                            }else{
			                        	$__i = 1;     
		                            }	
		                            
		                            
								   	$__ts = $__prfx->tp.'_atmt_trgr_cndc_ls'; $__inc = 'ok'; include('_slc.php'); 
								   	

                                    $CntWb .= "
										
										function ShwCndcOpt(){	
											__var_id = $('#atmttrgrcndc_cndc').val();
											__sl = $('#atmttrgrcndc_cndc option:selected');
											__sl_r = __sl.attr('rel');	
											SUMR_Main.ld.f.slc({i:'atmttrgrcndc_v_vl', t:'atmt_trgr_cndc_val', t_i:__sl_r });
										}
						
						
										$('#atmttrgrcndc_cndc').change(function() {
											
											$('#atmt_trgr_cndc_bx').html('');
											
											__id = $(this).val();
											__est_i = $(this).val();
											SUMR_Main.ld.f.slc({
												i:__id, 
												t:'".$__prfx->tp."_atmt_trgr_cndc_ls', 
												t_i:__est_i, 
												b:'atmt_trgr_cndc_bx'
											});
											
												
                                		});";
                                		 
								?>			
                            </div> 
						</div>   
                    </div>
                    
                    <?php if(!isN($__bxrld)){ $CntWb .= " $('#$__bxrld').removeClass('cnt_wrap'); "; } ?>
	  </div>   
	           
    </form>
  </div>
</div>

<?php $CntWb .= JV_Blq().JV_HtmlEd('jqte_pop'); ?>
<?php } ?>
<?php } 

?>
