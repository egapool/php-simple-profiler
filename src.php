<?php
ini_set('date.timezone','Asia/Tokyo');

class SimpleProfiler
{
  public $log         = [];
  public $fp          = null;
  public $init_time   = null;
  public $opens       = [];
  public $indent      = 0;

	public function __construct($log_file)
	{
		$this->fp = fopen($log_file,'a');
		$this->init_time = ceil(microtime(true)*1000);

		$txt = "\n----START------( ".(date('Y-m-d H:i:s',$this->init_time))." )------\n";
		$txt .= "label  : S-E間のms / Initからのms (unixtimestamp)\n";
		fwrite($this->fp,$txt);
	}

	
	public function __destruct()
	{
		fwrite($this->fp,"----END------( ".(date('Y-m-d H:i:s'))." )------\n\n");
		$aggregate = [];
		foreach ( $this->log as $l ) {
			if ( $l[2] == 0 ) continue;
			if ( !isset($aggregate[$l[0]])) {
				$aggregate[$l[0]] = [
					'count' => 0,
					'time' => 0
				];
			}
			$aggregate[$l[0]]['count']++;
			$aggregate[$l[0]]['time'] += $l[2];
		}
		foreach ( $aggregate as $sig => $a ) {
			fwrite($this->fp,"{$sig} : {$a['count']}回 / 合計 {$a['time']}ms \n");
		}
		var_dump($aggregate);die;
	}

	private function setLog($sig,$time,$fromStart = 0)
	{
		$fromInit = ceil(microtime(true)*1000) - $this->init_time;
		$this->log[] = [$sig,$time,$fromStart,$fromInit,$this->renderIndent()];
		$format = ($fromStart==0?'[S]':'[E]').$this->renderIndent().$sig." : ".$fromStart." / ".$fromInit. " (".$time.")\n";
		fwrite($this->fp,$format);
	}

	public function start ($sig)
	{
		$this->opens[$sig] = $time = ceil(microtime(true)*1000);
		$this->indent++;
		$this->setLog($sig, $time);

	}

	public function end ($sig)
	{
		$fromStart = ceil(microtime(true)*1000) - $this->opens[$sig];
		unset($this->opens[$sig]);

		$this->setLog($sig,ceil(microtime(true)*1000),$fromStart);
		$this->indent--;
	}

	private function renderIndent()
	{
		$ind = '';
		for ($i = 0; $i < $this->indent; $i++) {
			$ind .= ' ';
		}
		return $ind;
	}
}






