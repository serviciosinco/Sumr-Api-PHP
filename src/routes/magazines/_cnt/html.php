<?php
    ob_start("compress_code");
	Hdr_HTML([ 'cche'=>'ok' ]);
?>
	<!DOCTYPE html>
	<html>
		<head>
			<meta charset="UTF-8">
			<title></title>
			<base href="<?php echo DMN_DG; ?>" target="_self">
			<meta property='og:title' content=''/>
			<meta property='og:type' content='website' />
			<meta property='og:url' content='<?php echo DMN_DG.PrmLnk('rtn', 1) ?>' />
			<meta property='og:image' content=''/>
			<meta property='og:site_name' content='' />
			<meta property='og:description' content='' />
			<meta name='keywords' content=''>
			<meta name='description' content='' />
			<link rel="shortcut icon" type="image/png" href=""/>
			<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />
		</head>
		<body>
			<div id="container"></div>
		</body>
	</html>
	<script type="text/javascript">

		var SUMR_Main={slc:{ sch:''}};

		function __ld_all(){
			SUMR_Ld.f.js({
				t:'c',
				u:'sb/rd/main.js',
				c:()=>{}
			});
		}

	</script>
	<script type="text/javascript" src="<?php echo DMN_JS ?>_ld.js<?php if(Dvlpr()){ echo '?__r='.Enc_Rnd('r'); } ?>" async></script>
<?php ob_end_flush(); ?>