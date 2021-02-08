<?php 
	

	
	$__i = Php_Ls_Cln($_GET['__i']);

		$query_LsRg = sprintf('	SELECT * FROM us, ec_cmnt_rd, ec_cmnt WHERE id_eccmnt = eccmntrd_eccmnt AND eccmntrd_us = id_us AND eccmntrd_eccmnt = %s', GtSQLVlStr($__i,'int'));
		$LsRg = $__cnx->_qry($query_LsRg); 
		$row_LsRg = $LsRg->fetch_assoc(); 
		$Tot_LsRg = $LsRg->num_rows;	
	
?>

<style>
	
	.eccmnt_usrd h2{ font-family: Economica; color: #ffffff; text-align: center; text-transform: uppercase; font-size: 14px; }
	
	.eccmnt_usrd ul { list-style: none; padding: 0; margin: 20px 0 0 0 ; }
	.eccmnt_usrd ul li{ border-bottom: 1px dotted #7a7a7a; width: 90%; margin-left: auto; margin-right: auto; display: block; color: #ffffff; padding-top: 10px; padding-bottom: 10px; }	
	.eccmnt_usrd ul li .us{ width: 30px; height: 30px; background-repeat: no-repeat; background-size: 100% auto; background-position: center center; display: inline-block; border-radius:200px; -moz-border-radius:200px; -webkit-border-radius:200px; }
	.eccmnt_usrd ul li .bx{ display: inline-block; padding-left: 10px; }
	.eccmnt_usrd ul li button{ background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>ec_txt_his_rstr.svg'); width: 30px; height: 30px; background-color: transparent; background-position: center center; background-size: 70% auto; display: inline-block; float: right; border: none; background-repeat: no-repeat; opacity: 0.7; }
	.eccmnt_usrd ul li button:hover{ background-size: 100% auto; opacity: 1; }
	
	
	
</style>

<div class="eccmnt_usrd">	
	
	<h2><?php echo ctjTx($row_LsRg['eccmnt_cmnt'], 'in') ?></h2>
	
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


				$date = new DateTime( $row_LsRg['eccmntrd_fi'] );
				
				$li .= li('<div class="us" style="background-image:url('.$_img.');"></div>'. 
			    				'<div class="bx">'.
			    					ctjTx($row_LsRg['us_nm']." ".$row_LsRg['us_ap'],'in').HTML_BR.
				    				Spn( FechaESP_OLD( $row_LsRg['eccmntrd_fi'] ).' - '.Spn($date->format('H:i a'),'','_h'), '', '_f').
				    				
			    				'</div>
			    				 <div id="cntrstre_'.$__div.'" style="display:none;">
			    				 '.ctjTx($row_LsRg['eccmzsgmhis_vle'],'in').'
			    				 </div>'
			    			);
			    
			    
			    $CntWb .= "
			    
			    	
			    ";
			    			
				
			}while($row_LsRg = $LsRg->fetch_assoc());
			
			echo $li;			
		}
		
	?>
	</ul>
	
</div>

<?php  ?>