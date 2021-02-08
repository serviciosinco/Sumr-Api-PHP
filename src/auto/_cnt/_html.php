<?php if(!$this->isSsh()){ Hdr_HTML(); ?>
<!DOCTYPE html>
<html lang='es'>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>SUMR - Automator</title>
<base href="<?php echo DMN_AUTO ?>" />
<link href="/inc/sty/all.css?_r=<?php echo Gn_Rnd(); ?>" rel="stylesheet" type="text/css" />
</head>
<body style="background-color: #000000; ">
<?php 

	}else{

		Hdr_HTML();

	} 

	$this->_Auto_Inc(DIR_CNT.'_gn.php');
	
	echo $this->print_html;
	
	if($this->cronShow()){
		echo $this->h1('--- 👍 ----').PHP_EOL.PHP_EOL.PHP_EOL.PHP_EOL.PHP_EOL.PHP_EOL;	
		echo PHP_EOL.PHP_EOL.PHP_EOL.PHP_EOL.PHP_EOL.PHP_EOL;
	}
?>
<?php if(!$this->isSsh()){ ?>
</body>
</html>
<?php } ?>
<?php /*ob_end_flush();*/ header("HTTP/1.1 200 OK"); ?>