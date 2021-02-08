<?php 	

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'aws_mtrc' ]);

if( $_g_alw->est == 'ok' ){

	echo $this->h1('Metricas');

	if(class_exists('CRM_Cnx')){
		
		$AwsMtrcQry = "	SELECT id_awsrsrc, awsrsrc_tp, awsrsrc_nm, awsrsrc_id
						FROM "._BdStr(DBT).TB_AWS_RSRC."
							INNER JOIN "._BdStr(DBT).TB_AWS_ACC." ON awsrsrc_awsacc = id_awsacc";
		
		$AwsMtrc = $__cnx->_qry($AwsMtrcQry);
		
		if($AwsMtrc){
			
			$RwAwsMtrc = $AwsMtrc->fetch_assoc();
			$TotAwsMtrc = $AwsMtrc->num_rows;
			
			
			if($TotAwsMtrc > 0){
				
				echo $this->h2('Total:'.$TotAwsMtrc);
				
				do{
				
				
					if($RwAwsMtrc['awsrsrc_tp'] == 'ec2'){ 
						
						$__prm = [
							'instance_id'=>$RwAwsMtrc['awsrsrc_id']
						];
						
					}elseif($RwAwsMtrc['awsrsrc_tp'] == 'ec2-ebl'){
						
						$__prm = [
							'autoscaling_name'=>$RwAwsMtrc['awsrsrc_id']
						];
						
					}
					
					$__prm['t'] = $RwAwsMtrc['awsrsrc_tp'];
					
					$__aws_d = $this->_aws->_cwtch_mtrcs_any($__prm);
					
					$__date = date("Y-m-d H:i:s", strtotime($__aws_d->d->Timestamp) );
					$__value = $__aws_d->d->Average;
					
					
					$__in = $this->_AwsSta_In([ 
								'accrsrc'=>$RwAwsMtrc['id_awsrsrc'],
								'type'=>'average', 
								'date'=>$__date,
								'value'=>$__value
							]); 
					
					
					echo $this->h2( $RwAwsMtrc['awsrsrc_nm'].' '.$RwAwsMtrc['awsrsrc_tp'].' '.$RwAwsMtrc['awsrsrc_id'].' -> '.$__value );
					
					
		
				}while($RwAwsMtrc = $AwsMtrc->fetch_assoc());
		
			}
			
		} else{
			
			echo $this->err($__cnx->c_r->error);
			
		}
		
		$__cnx->_clsr($AwsMtrc);
		
							
	}

}else{

	echo $this->nallw('Global AWS Off');

}	

	
?>