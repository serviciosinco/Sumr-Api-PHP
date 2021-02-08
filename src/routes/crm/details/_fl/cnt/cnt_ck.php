<?php
if(class_exists('CRM_Cnx')){


	
	
	$Dt_Qry = sprintf("SELECT * 
					   FROM ".TB_CNT_CK." 
					   		INNER JOIN ".TB_CNT_CK_TRCK." ON cntcktrck_ck = cntck_ck 
					   		LEFT JOIN "._BdStr(DBM).TB_SIS_MD." ON cntcktrck_m = id_sismd 
					   WHERE cntck_cnt = %s 
					   ORDER BY cntcktrck_f DESC", GtSQLVlStr($_GET['_i'], "int"));
										   
	$Ls_Rg = $__cnx->_qry($Dt_Qry);
	$row_Ls_Rg = $Ls_Rg->fetch_assoc(); 
	$Tot_Ls_Rg = $Ls_Rg->num_rows;
	
?>

<?php do { 
	
	$_dtl_dte = '';
	$__icn_ifr = '';
	$__icn_cnvr = '';
	
?>
<div class="__ls_pop">
    <div class="_x1">
	    
	    <div class="_url">
		    <?php
			    
			    echo ($row_Ls_Rg['sismd_tt'] != '' ? 
			    	 Spn(TX_FI.' '.TT_SISMED,'ok','__e') . ' por '. ctjTx($row_Ls_Rg['sismd_tt'],'in')  . $icn . HTML_BR  .$p['f_i']: '' ).HTML_BR ;
			     
				$url = strtok($row_Ls_Rg['cntcktrck_url'], '?');
				$url_t = explode('?', $row_Ls_Rg['cntcktrck_url']);
				$url_g = explode('&', $url_t[1]);
			    //echo Strn('Url: '). strip_tags( $url ).HTML_BR; 
			    
			    if($url_g != ''){
				    foreach($url_g as $_v){
					    $__vr = explode('=', $_v);
					    $__v_t = $__vr[0];
					    $__v_v = $__vr[1];
					    
					    if($__v_t != ''){
						    if($__v_t == '__c'){ $__v_go = base64_decode( $__v_v ); }else{ $__v_go = urldecode( $__v_v ); }
						    if($__v_t == '_iF'){ $__icn_ifr = Spn('','','_pnl_icn _pnl_icn_ifr'); }
						    if($__v_t == '__e'){ $__icn_cnvr = Spn('','','_pnl_icn _pnl_icn_cnvr'); }
						    echo Strn($__v_t.': '). $__v_go .HTML_BR;
					    }					    
				    }
			    }
			?>
	    </div>
	</div>
	<div class="_x2">
		<?php 
			$__dte = _Dte_( array('d'=>$row_Ls_Rg['cntcktrck_f']) );	
	    	$_dtl_dte .= li( $__icn_cnvr . $__icn_ifr . Spn('','','_pnl_icn _pnl_icn_tme'). Spn($__dte->h).HTML_BR. Spn($__dte->f,'','_f')); 
	    	echo ul($_dtl_dte);
		?> 
	</div>	
</div>
<?php } while ($row_Ls_Rg = $Ls_Rg->fetch_assoc()); ?>
 
<?php $Ls_Rg->free; 
} 
?>