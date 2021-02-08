<?php

	$Rt = '../../includes/';
	$__https_off = 'off';
	require($Rt.'inc.php');
	ob_start("compress_code");



	$__pm_1 = PrmLnk('rtn', 1, 'ok');
	$__pm_2 = PrmLnk('rtn', 2, 'ok');
	$__pm_3 = PrmLnk('rtn', 3, 'ok');
	$__pm_4 = PrmLnk('rtn', 4, 'ok');

	$__dt_cl = __Cl(['id'=>$__pm_1, 't'=>'sbd']);

	if(!isN($__dt_cl->sbd)){ _StDbCl(['sbd'=>$__dt_cl->sbd, 'enc'=>$__dt_cl->enc, 'mre'=>$__dt_cl ]); }

	_Cl_Lb(['sb'=>$__dt_cl->sbd]);

?>
<html>
<head>
    <meta charset="UTF-8">
    <title>Universidad Externado de Colombia</title>
    <base href="https://fb.uexternado.co/" target="_self">
    <link href='https://fonts.googleapis.com/css?family=Economica' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400' rel='stylesheet' type='text/css'>
	<link href="inc/sty/all.css" rel="stylesheet" type="text/css">
</head>
<body>
	<div id="cnt">
		<?php include('cnt/ec.php'); ?>
	</div>
	<script>
      window.fbAsyncInit = function() {
        FB.init({
          appId      : '263191610363010',
          xfbml      : true,
          version    : 'v2.3'
        });
      };

      (function(d, s, id){
         var js, fjs = d.getElementsByTagName(s)[0];
         if (d.getElementById(id)) {return;}
         js = d.createElement(s); js.id = id;
         js.src = "//connect.facebook.net/en_US/sdk.js";
         fjs.parentNode.insertBefore(js, fjs);
       }(document, 'script', 'facebook-jssdk'));
    </script>

    <script>(function() {
			var _fbq = window._fbq || (window._fbq = []);
			if (!_fbq.loaded) {
			var fbds = document.createElement('script');
			fbds.async = true;
			fbds.src = '//connect.facebook.net/en_US/fbds.js';
			var s = document.getElementsByTagName('script')[0];
			s.parentNode.insertBefore(fbds, s);
			_fbq.loaded = true;
			}
			_fbq.push(['addPixelId', '890238954349238']);
			})();
			window._fbq = window._fbq || [];
			window._fbq.push(['track', 'PixelInitialized', {}]);
	</script>
	<noscript><img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/tr?id=890238954349238&amp;ev=PixelInitialized" /></noscript>

</body>
</html>
<script type="text/javascript" >

	var SUMR_Main={slc:{ sch:''}};

	function __ld_all(){

		console.log('Execute load all');

		SUMR_Ld.f.js({
			u:'<?php echo DMN_JS ?>jquery.js',
			c:function(){

				SUMR_Ld.f.js({
					u:'<?php echo DMN_JS ?>jquery-ui.js',
					c:function(){

						SUMR_Ld.f.js({
							u:'inc/js/js.js',
							c:function(){

								SUMR_Ld.f.js({
									u:'<?php echo DMN_JS; ?>jquery.validate.js',
									c:function(){

										SUMR_Ld.f.js({
											u:'<?php echo DMN_JS; ?>jquery.form.js',
											c:function(){

												SUMR_Ld.f.js({
													u:'inc/js/lazy.js',
													c:function(){

														SUMR_Ld.f.js({
															u:'<?php echo DMN_JS ?>SpryCollapsiblePanel.js',
															c:function(){

																SUMR_Ld.f.js({
																	u:'<?php echo DMN_JS ?>select2.js',
																	c:function(){

																		SUMR_Ld.f.css({
																			t:'p',
																			h:'<?php echo DMN_CSS ?>select2.css'
																		});

																		$(document).ready(function() {
																			jQuery("img.lazy").lazy();
																			<?php echo $CntWb; ?>
																		});

																		$(window).on('load',function(){
																			<?php echo $_CntJQ_Ld; ?>
																		});

																	}
																});

															}
														});

													}
												});

											}
										});

									}
								});

							}
						});

					}
				});

			}
		});
	}

</script>
<script type="text/javascript" src="<?php echo DMN_JS ?>_ld.js<?php if(Dvlpr()){ echo '?__r='.Enc_Rnd('r'); } ?>"></script>
<?php ob_end_flush(); ob_end_flush(); ?>