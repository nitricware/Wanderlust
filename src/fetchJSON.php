<?php
    namespace NitricWare;
	
	require __DIR__."/init.php";
	
	ob_implicit_flush(1);
	
	$fetcher = new FetchJSON();
	
	$fetcher->stadtwanderwege();