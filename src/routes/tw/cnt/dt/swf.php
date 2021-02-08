<?php 
	
	
	$__v = Php_Ls_Cln($_GET['_vr']);


	if($_fhdr != ''){
		$__fldr_anm = $_fhdr;
	}else{
		$__fldr_anm = '_v';
	}
	
	if($__v!=''){ $__mre_fld='v'.$__v.'/'; }
	
	
?>
	<iframe src="https://tw.uexternado.co/img/anm/<?php echo $__fldr_anm; ?>/enchsh_<?php echo $_dttw->id ?>/<?php echo $__mre_fld; ?>src.html?Rnd=<?php echo Gn_Rnd(20) ?>" style=" position: absolute; background-color:transparent; " frameborder="0" border="0" width="100%" height="100%"></iframe>
