<?php

namespace Core;

use \Core\DB;

class App {
	
	private $db, $uniqWords = [], $watchListMatchedWords = [];
	const CONFIG_PATH = __DIR__ . DIRECTORY_SEPARATOR . "config.ini";
	
	public function __construct() {
		
		$config = parse_ini_file( self::CONFIG_PATH );
		$this->db = DB::getInstance( $config['host'], $config['db'], $config['user'], $config['password'] );
	}
	
	public function processFile( $fileUrl ) {
		
		try {
			if( !file_exists( $fileUrl ) ) {
				throw new \Exception( "File doesn't exist" );
			}
			$fileStr = file_get_contents( $fileUrl );
			$this->uniqWords = array_unique(str_word_count($fileStr, 1));
			$this->matchWordList();
		}
		catch( \Exception $e ) {
			echo "ERROR: " . $e->getMessage() . "\n";
		}
	}
	
	private function matchWordList() {
		
		$watchListWordsArr = $this->db->query( "SELECT `word` FROM `watchlist`;" );
	
		$watchListWords = [];
		foreach($watchListWordsArr as $wordArr) {
			$watchListWords[] = current($wordArr);        
		}
	
		$this->watchListMatchedWords = array_intersect( $this->uniqWords, $watchListWords );
	}
	
	public function getUniqWords() {
		return $this->uniqWords;
	}
	
	public function getWatchListMatchedWords() {
		return $this->watchListMatchedWords;
	}
	
	
	
	
}