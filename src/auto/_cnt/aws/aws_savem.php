<?php 	

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'aws_savem' ]);

if( $_g_alw->est == 'ok' ){
    
    define('AWS_EC2_DEV_FRNT_ID', 'i-077a927a74aacff7b');
    define('AWS_EC2_DEV_FRNT_LOW', 't3a.small');
    define('AWS_EC2_DEV_FRNT_NRM', 't3a.medium');

    define('AWS_EC2_DEV_NJS_ID', 'i-076d957ea3cf7e5bd');
    define('AWS_EC2_DEV_NJS_LOW', 't3a.micro');
    define('AWS_EC2_DEV_NJS_NRM', 't3a.small');

    define('AWS_RDS_DEV', 'sumr-developer');

	echo $this->h1('Turning Off '.date('H'));

    if(date('H') >= 22 || date('H') > 1 && date('H') < 7){
        
        echo $this->h2('TurnOff at Night');

        /*
        $this->_aws->_ec2_save_toff([ 'id'=>AWS_EC2_DEV_FRNT_ID ]);
        $this->_aws->_ec2_save_toff([ 'id'=>AWS_EC2_DEV_NJS_ID ]);
        $this->_aws->_rds_save_toff([ 'id'=>AWS_RDS_DEV ]);
        */
        /*
        $this->_aws->_ec2_scle([ 
            'id'=>AWS_EC2_DEV_FRNT_ID, 
            'to'=>AWS_EC2_DEV_FRNT_LOW,
            'sclr'=>[
                'e'=>$__e2_gral->sclg,
                'f'=>$__e2_gral->fa
            ]
        ]);
            
        $this->_aws->_ec2_scle([ 
            'id'=>AWS_EC2_DEV_NJS_ID, 
            'to'=>AWS_EC2_DEV_NJS_LOW,
            'sclr'=>[
                'e'=>$__e2_gral->sclg,
                'f'=>$__e2_gral->fa
            ]
        ]);*/

    }else{
/*
        echo $this->h2('Normal service');

        $_frnt = $this->_aws->_ec2_scle([
                    'id'=>AWS_EC2_DEV_FRNT_ID, 
                    'to'=>AWS_EC2_DEV_FRNT_NRM,
                    'sclr'=>[
                        'e'=>$__e2_gral->sclg,
                        'f'=>$__e2_gral->fa
                    ]
                ]); 
        
        print_r($_frnt);
        
        $_njs = $this->_aws->_ec2_scle([ 
                    'id'=>AWS_EC2_DEV_NJS_ID, 
                    'to'=>AWS_EC2_DEV_NJS_NRM,
                    'sclr'=>[
                        'e'=>$__e2_gral->sclg,
                        'f'=>$__e2_gral->fa
                    ]
                ]);
        
        print_r($_njs);*/
                
    }

}else{

	echo $this->nallw('Global AWS Save Money Off');

}	

	
?>