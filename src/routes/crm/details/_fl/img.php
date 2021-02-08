<?php //if(ChckSESS_adm()){ ?>
	<div id="ImgDiv_Img_Th" class="_prvw">
		
		<div class="_prvw_wrp">
			<?php 
				
				$__img = Php_Ls_Cln($_GET['Img']);
				$__dir = Php_Ls_Cln($_GET['Dir']);
				$__Dmnimg = Php_Ls_Cln($_GET['dmn_im']);
				$__dmn = Php_Ls_Cln($_GET['dmn']);
				
				if(!isN($__dmn)){
					$__dmn_go = _Cns($__dmn);
				}elseif($__Dmnimg=='ok'){ 
					$__dmn_go = DMN_IMG; 
				}
				
				$_pr = [ 	'id'=>'Nw_ImgPop', 
							'src'=>$__dir.$__img, 
							'dmn'=>$__dmn_go, 
							'pth'=>'../../../', 
							'pth_o'=>'../../', 
							'tm'=>'th_com', 
							'width'=>500, 
							'fld'=>$__dir,
							'more'=>'onload="SUMR_Main.ld_imls(\'ImgPop\'); "', 
							'style'=>'display:none;'
						];
				
				echo ImTh($_pr);
			
			?>
		</div>
		
	</div>
<?php //} ?>