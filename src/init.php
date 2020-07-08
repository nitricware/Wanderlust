<?php
	namespace NitricWare;
	
	function loadSystemFiles($dir) {
		$d = scandir($dir);
		foreach ($d as $f) {
			$p = pathinfo($f)['extension'];
			if (isset($p) && $p == "php" && $f != "init.php") {
				include $dir . "/" . $f;
			}
		}
	}
	
	/*
	 * Settings
	 */
	
	const LANGUAGE = "DE";
	const __BASEDIR__ = __DIR__;
	
	
	require __BASEDIR__."/vendor/autoload.php";
	
	loadSystemFiles(__BASEDIR__ . "/classes");
	loadSystemFiles(__BASEDIR__ . "/structs");
	loadSystemFiles(__BASEDIR__ . "/exceptions");
