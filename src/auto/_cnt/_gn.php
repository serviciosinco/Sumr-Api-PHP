<?php

	if($this->g__t == 'rmte_try'){

		$this->_Auto_Inc(DIR_CNT.'remote.php');

	}elseif($this->g__t == 'sis'){

		$this->_Auto_Inc(DIR_CNT.'sis/_gn.php');

	}elseif($this->g__t == 'sis_cns'){

		$this->_Auto_Inc(GL_CNS.'_gn.php');

	}elseif($this->WrkrOn()){

		echo $this->h1('THIRD PARTY - '.$this->g__t.' - (Auto? '.SYS_AUTO.') Max Execution Time:'.$this->___getmxexc);

		if($this->cExc()){

			if($this->g__t == 'sis_third'){

				if(!isN($this->g__s)){

					$this->_Auto_Inc(DIR_CNT.$this->g__s.'/_gn.php');

				}else{

					$this->_Auto_Inc(DIR_CNT.'scl/_gn.php');
					$this->_Auto_Inc(DIR_CNT.'eml/_gn.php');
					$this->_Auto_Inc(DIR_CNT.'fll/_gn.php');
					$this->_Auto_Inc(DIR_CNT.'whtsp/_gn.php');

				}

			}elseif($this->g__t == 'aws'){

				$this->_Auto_Inc(DIR_CNT.'aws/_gn.php');

			}elseif($this->g__t == 'up'){

				$this->_Auto_Inc(DIR_CNT.'up/_gn.php');

			}elseif($this->g__t == 'dwn'){

				$this->_Auto_Inc(DIR_CNT.'dwn/_gn.php');

			}elseif($this->g__t == 'wbhk'){

				$this->_Auto_Inc(DIR_CNT.'wbhk/_gn.php');

			}elseif($this->g__t == 'bco'){

				$this->_Auto_Inc(DIR_CNT.'bco/_gn.php');

			}elseif($this->g__t == 'cnt'){

				$this->_Auto_Inc(DIR_CNT.'cnt/_gn.php');

			}elseif($this->g__t == 'kill'){

				$this->_Auto_Inc(DIR_CNT.'kill/sleep.php');
				$this->_Auto_Inc(DIR_CNT.'kill/tmp.php');

			}elseif($this->g__t == 'cl'){

				$this->_Auto_Inc(DIR_CNT.'cl/_gn.php');

			}elseif($this->g__t == 'snd'){

				$this->_Auto_Inc(DIR_CNT.'snd/_gn.php');

			}elseif($this->g__t == 'atmt'){

				$this->_Auto_Inc(GL_ATMT.'atmt.php');

			}elseif($this->g__t == 'call'){

				$this->_Auto_Inc(GL_CALL.'call.php');

			}elseif($this->g__t == 'chat'){

				$this->_Auto_Inc(DIR_CNT.'chat/_gn.php');

			}elseif($this->g__t == 'whtsp'){

				$this->_Auto_Inc(DIR_CNT.'whtsp/_gn.php');

			}elseif($this->g__t == 'ec'){

				$this->_Auto_Inc(DIR_CNT.'ec/_gn.php');

			}elseif($this->g__t == 'lck'){

				$this->_Auto_Inc(DIR_CNT.'lck/_gn.php');

			}elseif($this->g__t == 'tot'){

				$this->_Auto_Inc(DIR_CNT.'tot/_gn.php');

			}elseif($this->g__t == 'vtex'){

				$this->_Auto_Inc(DIR_CNT.'vtex/_gn.php');

			}elseif($this->g__t == 'us'){

				$this->_Auto_Inc(DIR_CNT.'us/_gn.php');

			}elseif($this->g__t == 'gtwy'){

				$this->_Auto_Inc(DIR_CNT.'gtwy/_gn.php');

			}elseif($this->g__t == 'mdl'){

				$this->_Auto_Inc(DIR_CNT.'mdl/_gn.php');

			}elseif($this->g__t == 'act'){

				$this->_Auto_Inc(DIR_CNT.'act/_gn.php');

			}elseif($this->g__t == 'tra'){

				$this->_Auto_Inc(DIR_CNT.'tra/_gn.php');

			}elseif($this->g__t == 'tmp'){

				$this->_Auto_Inc(DIR_CNT.'tmp/_gn.php');

			}elseif($this->g__t == 'rd'){

				$this->_Auto_Inc(DIR_CNT.'rd/_gn.php');

			}

		}else{

			$this->print_html = $this->print_json['w'] = 'CronJobs not allowed on this server';

		}

	}else{

		$this->print_html = $this->print_json['w'] = 'KEYUNQ: No Get Key Unique '.$this->g__e.' == '.encAd(SIS_ENCI);

	}

?>