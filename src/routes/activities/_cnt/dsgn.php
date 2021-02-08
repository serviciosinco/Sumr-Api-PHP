<?php 

	if(!isN($__dt_act->fnt->id)){ $_fnt = $__dt_act->fnt->id; }
	if(!isN($__dt_act->md->id)){ $_md = $__dt_act->md->id; }

?>
<header class="main-hdr">
	<img src="<?php echo $__cl->lgo->lght->big; ?>">
</header>
<div class="main-box">
	<?php //print_r( $__dt_act ); ?>

	<div class="lne1-box">
		<div class="col1-box">
			<div class="desc-box">
			</div>	
		</div>
		<div class="col2-box">
			<div class="form-box">
				<!-- Form - SUMR CRM --><iframe id='SUMR-FM-<?php echo $__dt_act->mdlgen->enc; ?>' width="100%"  border='0' style='border: none;'></iframe> <script >(function(w,d,s,l){ var f=d.getElementsByTagName(s)[0], j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:''; j.async=true; j.src= '<?php echo DMN_FORM; ?>b.js?f=<?php echo $__dt_act->mdlgen->enc; ?>&id=<?php echo $__dt_act->cl->prfl ?>&app=ok&g=ok&opaque=ok&icon=ok&w=100%25&act=<?php echo $__dt_act->enc; ?>&md=<?php echo $_md; ?>&fnt=<?php echo $_fnt; ?>'; f.parentNode.insertBefore(j,f); })(window,document,'script','dataLayer');</script>
			</div>
		</div>
	</div>

</div>