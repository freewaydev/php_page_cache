<?php

class PageCache {
	private $cacheDir = 'cache'; 
	private $expiryInterval = 900;
	private $cacheFileName;
	private $cacheFileNameInfo;

	public function setKey($key) { $this->key = $key; }
    public function setCacheDir($val) {  $this->cacheDir = $val; }
    public function setExpiryInterval($val) {  $this->expiryInterval = $val; }

    private function setCacheFileName() {
    	$this->cacheFileName = $this->cacheDir.'/'.$this->key.'.cache';
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
			return file_get_contents($this->getCacheFileName);
		} else {
			return false;
		}
	}

	public function exists() {
		if (file_exists($this->getCacheFileName()) && file_exists($this->getCacheFileNameInfo())) {
			$cache_time = file_get_contents ($this->getCacheFileNameInfo()) + (int)$this->expiryInterval; //Last update time of the cache file
			$expiry_time = time(); //Expiry time for the cache

			if ((int)$cache_time >= (int)$expiry_time) {
				return true;
			}
		}
		return false;
	}

}

?>