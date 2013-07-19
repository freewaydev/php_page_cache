<?php
	include '../PageCache.php';
	echo "--- Start PageCache ---<br /><br /><br />";

	$cache = new PageCache("test_cache_page");
	$result = $cache->get();
	if($result){
		echo "--- Load (test_cache_page) from PageCache ---<br />";
		echo $result;
	} else  {
		echo "--- Save (test_cache_page) to PageCache ---<br />";
		$html_data = "<h1>PageCache Test</h1><P>Hello world</P>";
		echo $html_data;
		$cache->put($html_data);
		#echo $cache->get();
	}

	$cache->setKey("test_cache_page_footer");
	$result = $cache->get();
	if($result){
		echo "--- Load (test_cache_page_footer) from PageCache ---<br />";
		echo $result;
	} else  {
		echo "--- Save (test_cache_page_footer) to PageCache ---<br />";
		$html_data = "<footer><p>Posted by: me!</p></footer>";
		echo $html_data;
		$cache->put($html_data);
		#echo $cache->get();
	}

	echo "<br /><br />--- End PageCache ---<br />";
?>