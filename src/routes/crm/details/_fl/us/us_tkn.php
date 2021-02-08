<?php 
	
	$___dt = GtUsTknDt([ 'enc'=>$__i ]);
	
?>
<ul class="us_tkn_dtl">
	<li><strong>Account <span>(__a)</span></strong> <?php echo $___dt->cl->prfl; ?></li>
	<li><strong>Usuario <span>(__u)</span></strong> <?php echo $___dt->us->user; ?></li>
	<li><strong>Key <span>(__k)</span></strong> <?php echo $___dt->key; ?></li>
	<li><strong>Password <span>(__p)</span></strong> <?php echo $___dt->pass; ?></li>
</ul>

<style>

	.us_tkn_dtl{ list-style-type: none; padding: 40px 0; margin: 0; }
	.us_tkn_dtl li{ border-bottom: 1px solid dashed #9d9d9d; }
	.us_tkn_dtl li strong{ }
	.us_tkn_dtl li strong span{ color: var(--main-bg-color); }
	
</style>	