<?php
	
	namespace NitricWare;
	require __DIR__ . "/init.php";
	$templates = new \Tonic\Tonic(\NitricWare\__BASEDIR__ . "/html/index.html");
	
	$stadtwanderwegeInfos = scandir(\NitricWare\__BASEDIR__ . "/routes/stadtwanderwege/");
	
	foreach ($stadtwanderwegeInfos as $i) {
		if ($i != ".." && $i != ".") {
			$swa[] = json_decode(file_get_contents(__BASEDIR__ . "/routes/stadtwanderwege/".$i));
			$templates->assign("stadtwanderwege", $swa);
		}
	}
	
	echo($templates->render());
