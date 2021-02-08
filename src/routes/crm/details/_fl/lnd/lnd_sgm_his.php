<div class="_lnd_sgm_his">
	<ul>
		<?php 
			
			$_enc = _GetPost('_i');
			
			$LndSgmHisLs = GtLndMdlSgmHisLs([ "fl"=>"AND lndmdlsgmhis_lndmdlsgm IN (SELECT id_lndmdlsgm FROM ".TB_LND_MDL_SGM." WHERE lndmdlsgm_enc = '".$_enc."')" ]);
			if(count($LndSgmHisLs->ls) > 0){
				
				$rsp['e'] = "ok";
				$rsp['dt'] = $LndSgmHisLs->ls;
				
			}
			
			foreach($LndSgmHisLs->ls as $_v){
				
				$li .= li('	<div class="us" style="background-image:url('.DMN_FLE.'us/_sm_'.$_v->us_img.');"></div>'. 
			    				'<div class="bx">'.
			    					$_v->us.HTML_BR.
				    				$_v->fi.HTML_BR.
				    			'</div>
					    	<button id="'.$_v->enc.'" rel="'.$_v->tt.'" class="_btn_lnd_sgm_his"></button> ');
				
			}
			
			echo $li;
			
			$CntJV .= "SUMR_Lnd.f.DomRbld();";
			
		?>
	</ul>
</div>

<style>
	
	._lnd_sgm_his h2{ font-family: Economica; color: #ffffff; text-align: center; text-transform: uppercase; font-size: 14px; }
	._lnd_sgm_his ul { list-style: none; padding: 0; margin: 20px 0 0 0 ; }
	._lnd_sgm_his ul li{ border-bottom: 1px dotted #7a7a7a; width: 90%; margin-left: auto; margin-right: auto; display: block; color: #ffffff; padding-top: 10px; padding-bottom: 10px; }	
	._lnd_sgm_his ul li .us{ width: 30px; height: 30px; background-repeat: no-repeat; background-size: cover; background-position: center center; display: inline-block; border-radius: 30px 30px 30px 30px;
    -moz-border-radius:200px;  -webkit-border-radius: 30px 30px 30px 30px; }
	._lnd_sgm_his ul li .bx{ display: inline-block; padding-left: 10px; }
	._lnd_sgm_his ul li button{ background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>btn_lnd_sgm_his.svg'); width: 30px; height: 30px; background-color: transparent; background-position: center center; background-size: 70% auto; display: inline-block; float: right; border: none; background-repeat: no-repeat; opacity: 0.7; }
	._lnd_sgm_his ul li button:hover{ background-size: 100% auto; opacity: 1; }

</style>