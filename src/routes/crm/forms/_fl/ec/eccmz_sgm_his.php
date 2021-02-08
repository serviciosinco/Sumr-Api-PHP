<?php 
	
	$__sgm = Php_Ls_Cln($_GET['eccmzsgm_sgm']);
	$__cmz = Php_Ls_Cln($_GET['id_eccmz']);
	$__div = Php_Ls_Cln($_GET['iddv']);
	
	$sgm_dt = ChkEcEdtSgm([ 'sgm'=>$__sgm, 'eccmz'=>$__cmz ]);

	if(!isN($sgm_dt->id)){

		$query_LsRg = sprintf('	SELECT  *
								FROM '._BdStr(DBM).TB_EC_CMZ_SGM_HIS.'
									 INNER JOIN '._BdStr(DBM).TB_US.' ON eccmzsgmhis_us = id_us
								WHERE eccmzsgmhis_eccmzsgm = %s ORDER BY id_eccmzsgmhis DESC', GtSQLVlStr($sgm_dt->id,'int'));
		
		$LsRg = $__cnx->_qry($query_LsRg);
		
		if($LsRg){
			$row_LsRg = $LsRg->fetch_assoc(); 
			$Tot_LsRg = $LsRg->num_rows;	
		}
	}
?>

<style>
	
	.EcCmz_SgmHis h2{ font-family: Economica; color: #ffffff; text-align: center; text-transform: uppercase; font-size: 14px; }
	
	.EcCmz_SgmHis ul { list-style: none; padding: 0; margin: 20px 0 0 0 ; }
	.EcCmz_SgmHis ul li{ border-bottom: 1px dotted #7a7a7a; width: 90%; margin-left: auto; margin-right: auto; display: block; color: #ffffff; padding-top: 10px; padding-bottom: 10px; }	
	.EcCmz_SgmHis ul li .us{ width: 30px; height: 30px; background-repeat: no-repeat; background-size: 100% auto; background-position: center center; display: inline-block; border-radius:200px; -moz-border-radius:200px; -webkit-border-radius:200px; }
	.EcCmz_SgmHis ul li .bx{ display: inline-block; padding-left: 10px; }
	.EcCmz_SgmHis ul li button{ background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>ec_txt_his_rstr.svg'); width: 30px; height: 30px; background-color: transparent; background-position: center center; background-size: 70% auto; display: inline-block; float: right; border: none; background-repeat: no-repeat; opacity: 0.7; }
	.EcCmz_SgmHis ul li button:hover{ background-size: 100% auto; opacity: 1; }
	
	
	
</style>

<div class="EcCmz_SgmHis">	
	
	<h2>Historial de versiones (<?php echo $Tot_LsRg ?>)</h2>
	
	<ul>
	<?php 
		
		if($Tot_LsRg > 0){	
			
			do{
				
				
				if( !isN($row_LsRg['us_img']) ){
					$img = _ImVrs([ 'img'=>$row_LsRg['us_img'], 'f'=>DMN_FLE_US ]);
					$_img = $img->sm_s;
				}else{
					$_img = GtUsImg([ 'img'=>$row_LsRg['us_img'], 'gnr'=>$row_LsRg['us_gnr'] ]);
				}


				$img = _ImVrs([ 'img'=>$row_LsRg['us_img'], 'f'=>DMN_FLE_US ]);
				
				$date = new DateTime( $row_LsRg['eccmzsgmhis_f'] );
				$idhis = $row_LsRg['id_eccmzsgmhis'];
				
				$li .= li(' <div class="us" style="background-image:url('.$_img.');"></div>'. 
			    				'<div class="bx">'.
			    					ctjTx($row_LsRg['us_nm'],'in').HTML_BR.
				    				Spn( FechaESP_OLD( $row_LsRg['eccmzsgmhis_f'] ).' - '.Spn($date->format('H:i a'),'','_h'), '', '_f').
			    				'</div>
			    				 <div id="cntrstre_'.$__div.'_'.$idhis.'" style="display:none;">
			    				 '.ctjTx($row_LsRg['eccmzsgmhis_vle'],'in', '', ['html'=>'ok','schr'=>'no','nl2'=>'no']).'
			    				 </div>
			    			<button id="rstr_'.$__sgm.'_'.$row_LsRg['id_eccmzsgmhis'].'"></button>'
			    			);
			    
			    
			    $CntWb .= "
			    
			    	$('#rstr_".$__sgm."_".$row_LsRg['id_eccmzsgmhis']."').off('click').click(function (){ 
				    	
				    	__html_rstre = $('#cntrstre_{$__div}_{$idhis}').html(); 
				    	
				    	/*alert( '#cntrstre_{$__div}_{$idhis}' + ' -> '+ __html_rstre );*/
				    	
				    	$('#".$__div." .__c').summernote('code', __html_rstre);
				    	/*SUMR_Main.pnl.f.shw({ pnl_id:'".$___Ls->gt->pnl->id."' });*/
				    	
				    });
			    ";
			    			
				
			}while($row_LsRg = $LsRg->fetch_assoc());
			
			echo $li;			
		}
		
	?>
	</ul>
	
</div>

<?php  ?>