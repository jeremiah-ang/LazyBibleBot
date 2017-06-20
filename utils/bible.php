<?php 
require_once ("http.php");
require_once ("Verse.php");

/* ============================
	
		   Bible API

============================ */

class Bible {

	static $BOOK_TITLES = [
    '1 Chronicles', '1 Corinthians',   '1 John',          '1 Kings',
    '1 Peter',      '1 Samuel',        '1 Thessalonians', '1 Timothy',
    '2 Chronicles', '2 Corinthians',   '2 John',          '2 Kings',
    '2 Peter',      '2 Samuel',        '2 Thessalonians', '2 Timothy',
    '3 John',       'Acts',            'Amos',            'Colossians',   
    'Daniel',
    'Deuteronomy',  'Ecclesiastes',    'Ephesians',       'Esther',
    'Exodus',       'Ezekiel',         'Ezra',            'Galatians', 
    'Genesis',      'Habakkuk',        'Haggai',          'Hebrews',
    'Hosea',        'Isaiah',          'James',           'Jeremiah',
    'Job',          'Joel',            'John',            'Jonah',
    'Joshua',       'Jude',            'Judges',          'Lamentations',
    'Leviticus',    'Luke',            'Malachi',         'Mark',
    'Matthew',      'Micah',           'Nahum',           'Nehemiah',
    'Numbers',      'Obadiah',         'Philemon',        'Philippians',
    'Proverbs',     'Psalm',           'Revelation',      'Romans',
    'Ruth',         'Song of Solomon', 'Titus',           'Zechariah',    
    'Zephaniah' ];

	function getVerse ($passage) {
		$votdUrl = "http://labs.bible.org/api/?passage=".$passage;
		return new Verse(getRequest ($votdUrl));
	}

	function is_valid_book ($book) {
		return count($this->get_books($book)) == 1;
	}

	function get_books ($book) {
		return $this->find_prefix($book, Bible::$BOOK_TITLES);
		//return $this->find_prefix($book, ["aaa", "aab", "cab", "bba", "bca", "dasd"]);
	}

	private function preprocess ($arr) {
		if (is_string($arr)) {
			return strtolower(preg_replace ("/\s+/", "+", $arr));
		}
		foreach ($arr as $key => $val) {
			$arr[$key] = $this->preprocess($val);
		}
		return $arr;
	}

	private function postprocess ($arr) {
		if (is_string($arr)) {
			return ucwords(preg_replace("/\++/"," ",$arr));
		}
		foreach ($arr as $key => $val) {
			$arr[$key] = $this->postprocess($val);
		}
		return $arr;
	}

	private function make_radix_tree ($arr, $prefix="") {
		if (!is_array($arr)) {
			return $arr;
		}

		$trix = [];
		foreach ($arr as $i=>$value) {

			$str = $arr[$i];
			$key = substr($str, 0, 1);

			if (strlen($str) > 1) {
				$str = substr($str, 1);
				if (!is_array($trix[$key]))
					$trix[$key] = [];

				$trix[$key][] = $str;
			} else {
				$trix[$key] = $prefix .	 $str;
			}
			
		}

		foreach ($trix as $j=>$val) {
			$trix[$j] = $this->make_radix_tree($val, $prefix . $j);
		}

		return $trix;
	}

	private function compress_radix_tree ($trix) {
		if (is_string($trix)) {
			return [$trix];
		}

		$compressed = [];
		foreach ($trix as $key=>$val) {
			$compressed = array_merge($compressed, ($this->compress_radix_tree($val)));
		}

		return $compressed;
	}

	private function find_prefix ($prefix, $arr) {
		$arr = $this->preprocess($arr);
		$prefix = $this->preprocess($prefix);

		$trix = $this->make_radix_tree($arr);
		$subtrix;
		for ($i = 0; $i < strlen($prefix); $i++) {
			$subtrix = $trix[$prefix{$i}];
			if (is_null($subtrix)) {
				// no such prefix 
				// return best matches 
				return $this->postprocess($this->compress_radix_tree($trix));
			} 
			$trix = $subtrix;
		}

		return $this->postprocess($this->compress_radix_tree($trix));
	}

	private function is_multi_array ($arr) {
		foreach ($arr as $a) {
			if (is_array($a)) return true;
		}
		return false;
	}

	static function split_verse ($verse) {
		preg_match("/([0-9]*\s*[a-zA-Z]+)\s*([0-9]+)\s*:\s*([0-9]+)(\s*-\s*([0-9]+))?/", $verse, $matches);
		return $matches;
	}
}
?>