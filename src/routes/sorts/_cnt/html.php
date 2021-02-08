<?php

	ob_start("compress_code");
	Hdr_HTML();

	$__main_path = DMN_FLE.'sort/';
	$__main_path_sort = $__main_path.$__dt_sort->enc.'/';

	$__a_sch = ['[SBD]', '[PATH]', '[ID]'];
	$__a_rplc = [$__main_path, $__main_path_sort, $__dt_sort->enc];

	echo str_replace($__a_sch,$__a_rplc,$__dt_sort->html);



	ob_end_flush();
?>