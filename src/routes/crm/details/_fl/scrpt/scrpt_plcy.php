<div class="dsh_scrpt">	
	<section class="_cvr" style="background-color:#F7F7FF; margin-top: 45px;">
		<iframe src="<?php echo DMN_ANM; ?>script/index.html" frameborder="0" width="100%" scrolling="no" height="200"></iframe>
	</section>	
	<div class="_txt"></div>
</div>

<script>
	
	<?php 
		$__scrpt_js .= " Scrpt_Gt({ ord:1, t:'sndi', pnl_id:'".$___Dt->gt->pnl->id."' }); ";		
		$_dc_start = Php_Ls_Cln($_POST['dc_start']);
	?>
	
	SUMR_Main.ld.f.scrpt(function () {
		
		SUMR_Main.bxajx.typed={};
		SUMR_Main.bxajx.mdlcnt={};
		SUMR_Main.bxajx.mdlcnt.dcstart='<?php echo $_dc_start; ?>';
		
		
		<?php echo $__scrpt_js; ?>
		
	});	

</script>
<style>
	
	
	.dsh_scrpt input[type=text]::-webkit-input-placeholder { text-align: center; font-family:"Anonymous Pro"; }
	.dsh_scrpt input[type=text]::-moz-placeholder { text-align: center; font-family:"Anonymous Pro"; }
	.dsh_scrpt input[type=text]:-ms-input-placeholder { text-align: center; font-family:"Anonymous Pro"; }
	.dsh_scrpt input[type=text]:-moz-placeholder { text-align: center; font-family:"Anonymous Pro"; }


	.dsh_scrpt figure{ background-image:url('<?php echo DMN_IMG_ESTR ?>cvr_script.svg'); margin: 0px; padding: 250px 0 0 0; background-repeat: no-repeat; background-position: center bottom ; background-color: #F7F7FF; position: sticky; top: 0; z-index: 1; }
	.dsh_scrpt ._txt{ padding: 50px 70px 200px 70px; font-size: 14px; }
	.dsh_scrpt ._txt .usmsj{ background-color: #eff4f4; border-radius:8px; -moz-border-radius:8px; -webkit-border-radius:8px; padding: 15px 20px 20px 20px; font-family:"Anonymous Pro"; font-size: 14px !important; text-align: center; font-weight: 300; position: relative; }
	.dsh_scrpt ._txt .usmsj .inp{ display: none; }
	.dsh_scrpt ._txt .usmsj .bx{ width: auto; display: inline-block; }
	
	.dsh_scrpt ._txt .usmsj .bx strong,
	.dsh_scrpt ._txt .usmsj .bx b{ color:var(--second-bg-color); }
	
	.dsh_scrpt ._txt .usmsj p{ padding: 0 !important; margin: 0 !important; font-size: inherit; }
	.dsh_scrpt ._txt .usmsj input[type=text]{ font-family:"Anonymous Pro"; width: 50%; margin-left: auto; margin-right: auto; background-color: rgba(255, 255, 255, 0.76); margin-top: 20px; text-align: center; }
	
	.dsh_scrpt ._txt .usmsj .fll{ display: none; }
	.dsh_scrpt ._txt .usmsj .fll ._yesno{ width: 50%; margin-left: auto; margin-right: auto; }
	.dsh_scrpt ._txt .usmsj .fll ._yesno ul{ padding: 0; margin: 0; list-style-type: none; width: 100%; }
	.dsh_scrpt ._txt .usmsj .fll ._yesno ul li{ display: inline-block; vertical-align: top; }
	.dsh_scrpt ._txt .usmsj .fll ._yesno button{ border-radius:8px; -moz-border-radius:8px; -webkit-border-radius:8px; font-family:"Anonymous Pro"; text-align: center; color:white; border: none; padding: 5px 10px; margin-left: 3px; margin-right: 3px; }
	.dsh_scrpt ._txt .usmsj .fll ._yesno button:hover{ opacity: 0.6; }
	.dsh_scrpt ._txt .usmsj .fll ._yesno button._yes{ background-color: #4880b3;  }
	.dsh_scrpt ._txt .usmsj .fll ._yesno button._no{ background-color: #c66464; }
	
	.dsh_scrpt ._txt .usmsj button.nxt{ display: none; }
	
	
	.dsh_scrpt ._txt .usmsj button.nxt{ position: absolute; right:0; bottom: 0; border-radius:8px; -moz-border-radius:8px; -webkit-border-radius:8px; font-family:"Anonymous Pro"; width:30px; background-color: var(--second-bg-color); text-align: center; color:white; border: none; padding: 5px 10px; }


	.dsh_scrpt ._txt .usmsj._rdy:not(._chk) .fll{ display: block; }
	.dsh_scrpt ._txt .usmsj._rdy:not(._chk) button.nxt{ display: block; }
	
	
	.dsh_scrpt ._txt .usrsp{ background-color: #fff; border: 1px solid rgba(206, 211, 211, 1); border-radius:8px; -moz-border-radius:8px; -webkit-border-radius:8px; padding: 15px 20px 20px 20px; font-family:"Anonymous Pro"; font-size: 14px !important; text-align: center; font-weight: 300; position: relative; margin-top: 15px; margin-bottom: 15px; }
	.dsh_scrpt ._txt .usrsp .bx{ width: 100%; }
	.dsh_scrpt ._txt .usrsp:after{ width:1px; background-color: #d9d5d5; height: 15px; display: block; position: absolute; left: 50%; top: -15px; }
	.dsh_scrpt ._txt .usrsp:before{ width:1px; background-color: #d9d5d5; height: 15px; display: block; position: absolute; left: 50%; bottom: -15px; }
	
	
	.dsh_scrpt._ld figure{ -webkit-filter: grayscale(100%); filter: grayscale(100%); }
	.dsh_scrpt._ld figure:before{ width: 50px; height: 50px; position: absolute; left: 50%; top: 50%; margin-left: -25px; margin-top: -25px; background-color:white; background-image: url(<?php echo _iEtg(DMN_IMG_ESTR_SVG.'loader_black.svg') ?>); background-repeat: no-repeat; background-position: center center; background-size: 30px 30px; border-radius:200px; -moz-border-radius:200px; -webkit-border-radius:200px; }

</style>