<?php
if (!defined('e107_INIT')) {echo "No E107"; exit; }
global $pref;
//We need to connect to the eq database to see if there is an API link.
$eqUser = $pref['EQLink']['db::user'];
$eqPass = $pref['EQLink']['db::pass'];
$eqDB = $pref['EQLink']['db::db'];
$eqHost = $pref['EQLink']['db::host'];
$eqSql = new eqdb;

$merror=$eqSql->eqdb_Connect($eqHost, $eqUser, $eqPass, $eqDB);
if ($merror == "e1") {
	message_handler("CRITICAL_ERROR", 6, ": generic, ", "EQDb.php");
	exit;
}
else if ($merror == "e2") {
	message_handler("CRITICAL_ERROR", 7, ": generic, ", "EQDb.php");
	exit;
}

function connect(){

global $pref;
//We need to connect to the eq database to see if there is an API link.
$eqUser = $pref['EQLink']['db::user'];
$eqPass = $pref['EQLink']['db::pass'];
$eqDB = $pref['EQLink']['db::db'];
$eqHost = $pref['EQLink']['db::host'];
$eqSql = new eqdb;
$merror=$eqSql->eqdb_Connect($eqHost, $eqUser, $eqPass, $eqDB);
if ($merror == "e1") {
	message_handler("CRITICAL_ERROR", 6, ": generic, ", "EQDb.php");
	exit;
}
else if ($merror == "e2") {
	message_handler("CRITICAL_ERROR", 7, ": generic, ", "EQDb.php");
	exit;
}
return $eqSql;
}

class eqdb{
    var $EQDBserver;
    var $EQDBuser;
    var $EQDBpassword;
    var $EQDBdefaultdb;
    var $EQDBaccess;
    var $EQDBresult;
    var $EQDBrows;
    var $EQDBerror;
    var $EQDBcurTable;
    var $EQDBlanguage;
    var $EQDBinfo;
    var $EQDBcharset;
    
    function EQDB(){
        if (!isset($_SESSION['e_language']))
		{
			return;
		}
		
		$this->EQDBlanguage = ($_SESSION['e_language'] != $pref['sitelanguage']) ? $_SESSION['e_language'] : '';
    }
    
    function eqdb_Connect($EQDBserver, $EQDBuser, $EQDBpassword, $EQDBdefaultdb){
        $eqdb_ConnectionID = null;
        $this->EQDBserver = $EQDBserver;
	$this->EQDBuser = $EQDBuser;
    	$this->EQDBpassword = $EQDBpassword;
        $this->EQDBdefaultdb = $EQDBdefaultdb;

        $temp = $this->EQDBerror;
        $this->EQDBerror = FALSE;
        
        if(defined("USE_PERSISTANT_DB") && USE_PERSISTANT_DB == TRUE){ // create a persistant connection
            if ( ! $this->EQDBaccess = @mysql_pconnect($this->EQDBserver, $this->EQDBuser, $this->EQDBpassword)){
		return 'e1';
	    }else{
                if ( ! @mysql_select_db($this->EQDBdefaultdb, $this->EQDBaccess)){
                    return 'e2';
		}else{
                    $this->EQDBError('dbConnect/SelectDB');
		}
            }
        }else{ // create an on demand connection
            if(! $this->EQDBaccess = @mysql_connect($this->EQDBserver, $this->EQDBuser, $this->EQDBpassword)){
                return 'e1';
            }else{
                if(! @mysql_select_db($this->EQDBdefaultdb,$this->EQDBaccess)){
                    return 'e2';
                }
            }
        }
        
        //should be connected to the db now.
        $this->eqdb_Set_Charset();
        
        if ($eqdb_ConnectionID == NULL){
	    $eqdb_ConnectionID = $this->EQDBaccess;
	}
    }
    
    function eqdb_Query($query,$qry_from,$debug = false){
        if(!$this->EQDBaccess)
		{
			global $eqdb_ConnectionID;
        	$this->EQDBaccess = $eqdb_ConnectionID;
		}
        if ($debug == 'now') {
		echo "** $query";
	}
	if ($debug !== FALSE || strstr(e_QUERY, 'showsql'))
	{
		$queryinfo[] = "<b>{$qry_from}</b>: $query";
	}
        
        $eqQryRes = @mysql_query($query,$this->EQDBaccess);
        //echo "<pre>".print_r($eqQryRes)."</pre>";
        $this->EQDBresult = $eqQryRes;
        return $eqQryRes;
    }
    
    function eqdb_Select($table, $fields = '*', $arg = '1', $debug = false){
        
        if ($this->EQDBresult = $this->eqdb_Query('SELECT '.$fields.' FROM '.$table.' WHERE '.$arg, 'eqdb_Select', $debug)) {
	    //$this->dbError('dbQuery');
	    return $this->eqdb_Rows();
	} else {
	    $this->dbError("db_Select (SELECT $fields FROM {$table} WHERE {$arg})");
            return FALSE;
        }
    }
    
    function eqdb_Insert($table, $arg, $debug = FALSE) {
                if(is_array($arg))
		{
			$keyList= "`".implode("`,`", array_keys($arg))."`";
			$valList= "'".implode("','", $arg)."'";
			$valList = str_replace(",'NULL'",",NULL",$valList); // Handle NULL correctly. 
			$query = "INSERT INTO `{$table}` ({$keyList}) VALUES ({$valList})";
		}
		else
		{
			$query = "INSERT INTO {$table} VALUES ({$arg})";
		}
                
		if(!$this->EQDBaccess)
		{
			global $eqdb_ConnectionID;
        	$this->EQDBaccess = $eqdb_ConnectionID;
		}


		if ($result = $this->EQDBresult = $this->eqdb_Query($query, 'eqdb_Insert', $debug )) {
			$tmp = mysql_insert_id($this->EQDBaccess);
			return ($tmp) ? $tmp : TRUE; // return true even if table doesn't have auto-increment.
		} else {
			$this->dbError("db_Insert ($query)");
			return FALSE;
		}
	}
        
    function eqdb_Update($table, $arg, $debug = FALSE ) {
		if(!$this->EQDBaccess)
		{
			global $eqdb_ConnectionID;
        	$this->EQDBaccess = $eqdb_ConnectionID;
		}

		if ($result = $this->EQDBresult = $this->eqdb_Query('UPDATE '.$table.' SET '.$arg, 'eqdb_Update', $debug )) {
			$result = mysql_affected_rows($this->EQDBaccess);
			if ($result == -1) return FALSE;	// Error return from mysql_affected_rows
			return $result;
		} else {
			$this->dbError("db_Update ($query)");
			return FALSE;
		}
	}

    function eqdb_Fetch($type = MYSQL_BOTH) {
		if (!(is_int($type))) {
			$type=MYSQL_BOTH;
		}
                $row = @mysql_fetch_array($this->EQDBresult,$type);
		if ($row) {
			return $row;
		} else {
			$this->dbError('db_Fetch');
			return FALSE;
		}
	}
        
    function eqdb_Close() {
		if(!$this->EQDBaccess)
		{
			global $eqdb_ConnectionID;
        	$this->EQDBaccess = $eqdb_ConnectionID;
		}
                mysql_close($this->EQDBaccess);
		$this->EQDBaccess = NULL; // correct way to do it when using shared links.
	}
    
    function eqdb_Delete($table, $arg = '1', $debug = FALSE) {
		if(!$this->EQDBaccess)
		{
			global $eqdb_ConnectionID;
        	$this->EQDBaccess = $eqdb_ConnectionID;
		}


		
                if ($result = $this->EQDBresult = $this->eqdb_Query('DELETE FROM '.$table.' WHERE '.$arg, 'db_Delete', $debug)) {
                        $tmp = mysql_affected_rows($this->EQDBaccess);
                        return $tmp;
                } else {
                        $this->dbError('db_Delete ('.$arg.')');
                        return FALSE;
                }
		
	}
        
    function eqdb_Rows() {
		$rows = $this->EQDBrows = @mysql_num_rows($this->EQDBresult);
		$this->dbError('db_Rows');
		return $rows;
	}
        
    function dbError($from) {
		if ($error_message = @mysql_error()) {
			if ($this->EQDBerror == TRUE) {
				message_handler('ADMIN_MESSAGE', '<b>mySQL Error!</b> Function: '.$from.'. ['.@mysql_errno().' - '.$error_message.']', __LINE__, __FILE__);
				return $error_message;
			}
		}
	}
    function eqdb_Set_Charset($charset = '', $debug = FALSE)
	{
		// Get the default user choice
		global $mySQLcharset;
		if (varset($mySQLcharset) != 'utf8')
		{
			// Only utf8 is accepted
			$mySQLcharset = '';
		}
		$charset = ($charset ? $charset : $mySQLcharset);
		$message = (( ! $charset && $debug) ? 'Empty charset!' : '');
		if($charset)
		{
			if ( ! $debug)
			{
			    @mysql_query("SET NAMES `$charset`");
			}
			else
			{
				// Check if MySQL version is utf8 compatible
				preg_match('/^(.*?)($|-)/', mysql_get_server_info(), $mysql_version);
				if (version_compare($mysql_version[1], '4.1.2', '<'))
				{
					// reset utf8
					//@TODO reset globally? $mySQLcharset = '';
					$charset      = '';
					$message      = 'MySQL version is not utf8 compatible!';
				}
				else
				{
					// Use db_Query() debug handler
					$this->eqdb_Query("SET NAMES `$charset`", NULL, '', $debug);
				}
			}
		}

		// Save mySQLcharset for further uses within this connection
		$this->EQDBcharset = $charset;
		return $message;
	}
}
?>