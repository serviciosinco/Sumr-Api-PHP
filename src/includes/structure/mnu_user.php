<li class="br_rds _myp _anm" id="_m_ldr_bar">

	<div class="__us _anm">
	    <div class="__nm _anm">
			<div class="c1"><?php echo SISUS_NM ?></div>
	    	<div class="c2"><?php echo SISUS_AP ?></div>
	    </div>
		<a class="br_rds grd_black __mn_dt" href="<?php echo VoId() ?>" rel="us_myp" name="us-opt" id="us-opt" pop="ok">
			<?php 
				
				echo 	Spn('', '', '_n','','us_myp_ntf').
						Spn('', '', '_c', 'background-image:url('.SISUS_LNG_FLG.'); ').
						bdiv([ 
							'cls'=>'icon icon-us '.( SISUS_GNR == _CId('ID_SX_N_DF') ? '_ndf':'' ), 
							'c'=>'
								<div class="bar_b_ldr _anm">
						       		<div class="arc-rotate2 _anm">
										<div class="loader _anm">	
											<div class="load _anm"></div>
										</div>
									</div>
						   		</div>
								<figure class=""></figure>'
						]). 
						Spn(TX_USR,'','_cmp') 
			
			?>
		</a>
	</div>
	                                                    		
	<ul>
	                                                            	
		<li>
	    	<a href="<?php echo VoId() ?>" name="cls-ses" id="cls-ses">
		    	<?php echo Spn(TX_OUT,'','_cmp') .TX_SGNOFF. bdiv(['cls'=>'icon icon-out']) ?>
		    </a>
	    </li>
	    
		<li><a href="<?php echo VoId() ?>" class="__chngpss"><?php echo TX_CHNCLV ?></a></li>
		<li><a href="<?php echo VoId() ?>" class="__chnglng"><?php echo TX_CHNLNG ?></a></li>
	    
	    <?php if(_ChckMd('call_phnadd')){ ?>
    		<li><a href="<?php echo VoId() ?>" rel="us_tel" class="__mn_ls"><?php echo TX_MIS_NM ?></a></li>
    	<?php } ?>
    	<?php if(ChckSESS_superadm() || _ChckMd('dwn')){ ?>
    		<li><a href="<?php echo VoId() ?>" rel="dwn" class="__mn_ls"><?php echo TX_DWN ?></a></li>
    	<?php } ?>
    	<?php if(_ChckMd('us_eml')){ ?>
    		<li><a href="<?php echo VoId() ?>" rel="us_eml" class="__mn_ls"><?php echo TX_MIS_MLS ?></a></li>
    	<?php } ?>

	    <li>	
	        <div class="__psh" id="us_psh_div">
	            <?php echo OLD_HTML_chck('us_psh_allw', TX_NTFCNS, '', 'in', ['c'=>'']); ?>
	            <input id="us_enc" name="us_enc" type="hidden" value="<?php echo SISUS_ENC ?>">
	            <input id="us_dvc" name="us_dvc" type="hidden" value="">
	        </div>                                                               
	    </li>	
	    <?php if(ChckSESS_superadm()){ ?>
        <li>	
            <div class="__psh">
                <?php echo OLD_HTML_chck('usadm_bug', TX_CNSL, 1, 'in', ['c'=>'']); ?>
				<?php $_CntJQ .= " 
				
	                		SUMR_Main.log.set('ok');
	                	
							$('#usadm_bug').change(function() {
							    if(this.checked) {
							        SUMR_Main.log.set('ok');
							    }else{
								    SUMR_Main.log.set();
							    }
							});
							
	                	";	 ?>
            </div>                                                               
        </li>	
        <?php } ?>

	   
	</ul>

</li>
<script id="mnu-script" us-ntf="<?php echo SISUS_NTF; ?>"></script>

<?php 
	
	if(SISUS_PSSCHN == 1){ 
		
		$_CntJQ .= "$.colorbox({ 
						href:'".Fl_Rnd(FL_FM_GN.__t('pssw',true)).TXGN_POP."', 
						width:'800px', 
						height:'300px', 
						overlayClose:false, 
						escKey:false
					}); "; 
	}
	
?>