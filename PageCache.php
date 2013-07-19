<?php

class PageCache {

	function __construct($key) {
		$this->setKey($key);
    }

	private $cacheDir = 'cache'; 
	private $expiryInterval = 900;
	private $cacheFileName;
	private $cacheFileNameInfo;
	private $cacheFileEnding = '.cache';

	public function setKey($key) { $this->key = $key; }
    public function setCacheDir($val) {  $this->cacheDir = $val; }
    public function setExpiryInterval($val) {  $this->expiryInterval = $val; }

    private function setCacheFileName() {
    	$this->cacheFileName = $this->cacheDir.'/'.$this->key.$this->cacheFileEnding;
    }

    private function setCacheFileNameInfo() {
    	$this->cacheFileNameInfo = $this->cacheDir.'/'.$this->key.'.info';
    }

    public function getCacheFileName() {
    	return $this->cacheFileName;
    }

    public function getCacheFileNameInfo() {
		return $this->cacheFileNameInfo;
    }

	public function put($content) {
		if (!file_exists($this->cacheDir)){
			mkdir($this->cacheDir);
		}
		$this->setCacheFileName();
		$this->setCacheFileNameInfo();
		file_put_contents ($this->getCacheFileName(),  $content);
		file_put_contents ($this->getCacheFileNameInfo(), time());
	}

	public function get() {
		$exitst = $this->exists();
		if ($exitst) {
			return file_get_contents($this->getCacheFileName());
		} else {
			return false;
		}
	}

	public function exists() {
		$this->setCacheFileName();
		$this->setCacheFileNameInfo();
		if (file_exists($this->getCacheFileName()) && file_exists($this->getCacheFileNameInfo())) {
			$cache_time = file_get_contents ($this->getCacheFileNameInfo()) + (int)$this->expiryInterval;
			$expiry_time = time();

			if ((int)$cache_time >= (int)$expiry_time) {
				return true;
			} else  {
				return false;
			}
		}
		return false;
	}

}

?>