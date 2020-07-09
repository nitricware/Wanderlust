<?php
	
	
	namespace NitricWare;
	
	
	class FetchJSON {
		public JSONLocations $locations;
		public \geoPHP $geo;
		
		public array $paths = [
			"stadtwanderwege" => [
				"tmp" => __BASEDIR__."/tmp/stadtwanderwege.json",
				"routes" => __BASEDIR__."/routes/stadtwanderwege/files/",
				"info" => __BASEDIR__."/routes/stadtwanderwege/"
			]
		];
		
		public function __construct () {
			$this->locations = new JSONLocations();
			$this->geo = new \geoPHP();
			
			if (!file_exists($this->paths["stadtwanderwege"]["routes"])) {
				mkdir($this->paths["stadtwanderwege"]["routes"], 0777, true);
			}
		}
		
		/**
		 * @param $filename
		 * @param $url
		 *
		 * @return false|int
		 */
		private function fetch($type, $url) {
			return file_put_contents($this->paths[$type]["tmp"], file_get_contents($url));
		}
		
		/**
		 * @param $type
		 */
		private function archive($type) {
			$dir = $this->paths[$type]["routes"];
			
			$jsonArchive = new \PharData($dir."stadtwanderwege_json.tar");
			$gpxArchive = new \PharData($dir."stadtwanderwege_gpx.tar");
			
			foreach (scandir($dir) as $file) {
				$p = pathinfo($dir.$file)["extension"];
				
				if ($p == "json") {
					$jsonArchive->addFile($dir.$file);
				} elseif ($p == "gpx") {
					$gpxArchive->addFile($dir.$file);
				}
			}
			
			// TODO: compress
			// TODO: delete before new archive
		}
		
		/**
		 * @throws WanderlustException
		 */
		public function stadtwanderwege(): void {
			if ($this->fetch("stadtwanderwege", $this->locations->stadtwanderwege) > 0) {
				$stadtwanderwege = json_decode(file_get_contents($this->paths["stadtwanderwege"]["tmp"]));
				foreach ($stadtwanderwege->features as $wanderweg) {
					if (file_put_contents($this->paths["stadtwanderwege"]["routes"].$wanderweg->id.".json", json_encode($wanderweg))) {
						try {
							$geoObject = $this->geo->load(json_encode($wanderweg), "json");
							$geoGPX = $geoObject->out("gpx");
						} catch (\Exception $e) {
							throw new WanderlustException("Couldn't parse JSON for ".$wanderweg->id);
						}
						
						if (!file_put_contents($this->paths["stadtwanderwege"]["routes"].$wanderweg->id.".gpx", $geoGPX)) {
							throw new WanderlustException("Couldn't write route GPX for ".$wanderweg->id);
						}
						
						unset($wanderweg->geometry);
						if (!file_put_contents($this->paths["stadtwanderwege"]["info"].$wanderweg->id.".json", json_encode($wanderweg))) {
							throw new WanderlustException("Couldn't write info JSON for " . $wanderweg->id);
						}
					} else {
						throw new WanderlustException("Couldn't write route JSON for ".$wanderweg->id);
					}
				}
				
				$this->archive("stadtwanderwege");
			} else {
				throw new WanderlustException("Couldn't write tmp JSON for >>stadtwanderwege<<");
			}
		}
	}