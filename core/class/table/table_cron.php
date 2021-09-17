<?php
/*
 * @copyright   QiaoQiaoShiDai Internet Technology(Shanghai)Co.,Ltd
 * @license     https://www.oaooa.com/licenses/
 * 
 * @link        https://www.oaooa.com
 * @author      zyx(zyx@oaooa.com)
 */

if(!defined('IN_OAOOA')) {
	exit('Access Denied');
}

class table_cron extends dzz_table
{
	public function __construct() {

		$this->_table = 'cron';
		$this->_pk    = 'cronid';

		parent::__construct();
	}

	public function fetch_nextrun($timestamp) {
		$timestamp = intval($timestamp);
		return DB::fetch_first('SELECT * FROM '.DB::table($this->_table)." WHERE available>'0' AND nextrun<='$timestamp' ORDER BY nextrun LIMIT 1");
	}

	public function fetch_all_nextruncronid($timestamp){
        $timestamp = intval($timestamp);
        $cronid = array();
        foreach(DB::fetch_all ('SELECT cronid FROM '.DB::table($this->_table)." WHERE available>'0' AND nextrun<='$timestamp' ORDER BY nextrun") as $v){
            $cronid[] = $v['cronid'];
		}
		return $cronid;
	}

	public function fetch_nextcron() {
		return DB::fetch_first('SELECT * FROM '.DB::table($this->_table)." WHERE available>'0' ORDER BY nextrun LIMIT 1");
	}

	public function get_cronid_by_filename($filename) {
		return DB::result_first('SELECT cronid FROM '.DB::table($this->_table)." WHERE filename='$filename'");
	}

}

?>
