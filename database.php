<?php
	// check if the DB has already been defined then exit
	if ( defined("DB") )
		return;

	define ("DB","yes");


	DEFINE("DB_USER_ID", 	"root");
	DEFINE("DB_USER_PWD", 	"");
	DEFINE("DATABASE", 		"project1");
	DEFINE("DBHOST", 		"localhost");



// 	DEFINE("DB_USER_ID", 	"theproje_technyx");
// 	DEFINE("DB_USER_PWD", 	"voS$[huaRny]");
// 	DEFINE("DATABASE", 		"theproje_gm_tool");
// 	DEFINE("DBHOST", 		"localhost");
	
	DEFINE("ER_DUP_KEY", 1022);
	DEFINE("ER_DUP_ENTRY", 1062);

	//-----------------------------//

	// Class for Connecting Database

	Class DB
	{
	// All the local class variables
		var $con;							// Holds Connection String
		var $command;						// Holds Sql Command
		var $errorNo;						// Holds Error Occored by SQLs
		var $error =  " ERROR ";			// Holds Other Runtime Errors	
		var $result;						// Holds Results from methods etc.
		var $transactionStarted = false;	// ?
		var $sql;							// Holds SQL Statements ?
		var $debug;							// Holds Debug Mode
		var $showErrors;					// Holds Error Mode ?
	

		// A constructor to make connection with the database
		function DB()
		{
			$this->GetConnection();			// Make Connection
			$this->showErrors = true;		// Set Error to show	
		}

		// Returns Database Connection 
		function GetConnection()
		{
			global $HOSTNAME,$text,$SERVER_ADDR;

			//checks if we're running the site on local host
			$this->con = @mysql_connect(DBHOST, DB_USER_ID, DB_USER_PWD );

			if (! $this->con)
			{
				$text = "<br><b><u>An error has occurred, in the database connection:</u></b><br>
						 <br><b>Detail Message: </b>". mysql_error() . "<br>";
				if ( empty($HOSTNAME) && (!defined("TESTRUN")) )
				{
					echo $text;
					ob_end_flush();
					exit();
				}
				else
				{
					ob_end_clean();

					if (! empty($HOSTNAME))
					{
						$subject = "Error in database Connection.";
						$body = $text;
						$headers = "Content-type: text/html; charset=iso-8859-1\r\n";
						$headers .= "From: " . SERVICES_EMAIL . "\r\n";
						mail (TO,$subject,$body,$headers);
					}
					$this->sendToDBSorryPage($text);
					exit();
				}
				return false;
			}
			if (!(mysql_select_db(DATABASE)))
			{
				echo "Connection is not found";
				exit;
			}
			return true;
		}

		// executes a given query and returns a reslult set
		function ExecuteQuery($query)
		{
			global $debug;

			$this->errorNo = 0;
			$this->error = "";

			if ($this->debug)
				echo "<b>SQL:</b> $query<br>";

			mysql_query('SET CHARACTER SET utf8'); //--> for adding different chars like 'arabic'
			$resHandle = mysql_query($query, $this->con);
			if ($resHandle == false)
			{
				$this->errorNo = mysql_errno();
				$this->error = mysql_error();

				if ($this->showErrors)
					$this->ShowMySqlError($query);
				
				return false;
			}

			$this->sql = $query;
			$result = new Result($this, $resHandle);		
			return $result;
		}

		// Show MySql Errors
		function ShowMySqlError($query)
		{
			echo "An error occurred: $query<br>";
			echo mysql_errno() . " -- " . mysql_error();
		}	
		
		// Primary Key Voilation Error
		function HasPKViolated()
		{
			return ($this->errorNo == ER_DUP_KEY || $this->errorNo = ER_DUP_ENTRY);
		}
		
		// close a connection from Database
		function closeConnection()
		{
			mysql_close($this->con);
		}

		// returns error
		function getError()
		{
			return mysql_errno();
		}

		function sendToDBSorryPage($error)
		{
			session_register($error);
			header("Location: ../errorpage/errors.php?err=$error");
		}
		
		function getLastInsertId()
		{
			$id = mysql_insert_id($this->con);
			return $id;
		}

		
	// ends of DB class
	}
	
	
	// This class is to execute and retrive results
	
	class Result
	{
		
		var $resHandle;	
		var $db;
		var $errorNo;
		var $error;
		var $dateIndices;		// an array of all date fields in this result (query)
		var $dateFormat;		//
		
		
		function Result($db, $resHandle)
		{
			$this->resHandle = $resHandle;
			$this->db = $db;
			//$this->dateIndices = array();
		}

		function FetchAsArray()
		{
			return mysql_fetch_array($this->resHandle, MYSQL_ASSOC);
		}
		
		function FetchRows()
		{
			$rows = array();
			while($data = $this->FetchAsArray())
				array_push($rows, $data);
			return $rows;
		}
				function FetchAsVars()
		{
			if(substr_count($this->db->sql,"distinct"))
				$pattern = "/select +distinct(.*?)\sfrom\s/is";
			else
				$pattern = "/select(.*?)\sfrom\s/is";
			
			if (preg_match($pattern, $this->db->sql, $fieldList))
			{
				//print_r($fieldList);
				//$fields = preg_split("/,/",$fieldList[1]);
				$row = $this->FetchAsArray();

				// select fields list can be simple fields or functions which are followed by a , or a space
				// they can also be aliased using as e.g. select date_format('%x',date) as dt from rfq

					preg_match_all("/(\w+\.)?(\w+)(\(.*?\))?(\s+as\s+(\w+))?[,\s]?/is", $fieldList[1], $fields);
					//print_r($fields);
					//exit();
					for($i=0; $i < count($fields[2]); $i++)
					{
						// name of the field is the alias specified
						if ( !empty($fields[4][$i]) )
						{
							$fieldName = $fields[5][$i];
						}
						else
						{
							// in case there is no alias but a function has been used then the name of the
							// field will be the name of the function prefixed with the field name
							// e.g. sum(actFab) will become sumactFab
							$fieldName = trim($fields[2][$i]);

							if ( !empty($fields[3][$i]) )
								$fieldName .= substr($fields[3][$i],1,-1);
						}


						if (empty($row))
							$row = array();

						global ${$fieldName};
						${$fieldName} = $row[$i];
				}

				return $row;
			}

//		echo "returning false $this->sql";
			return false;
		}
		
		
		
		function GetSelectedRows()
		{
			return mysql_num_rows($this->resHandle);
		}

		// returns no of tuples affected by Insert/update/delete

		// returns no of tuples in a result
		
		function GetAffectedRows()
		{
			//die($this->resHandle."<hr>");
			return mysql_affected_rows($this->resHandle);
		}
	
		function FetchAsObject()
		{
			return mysql_fetch_object($this->resHandle);
		}
		// close result set
		function CloseResultSet()
		{
			return mysql_free_result($this->resHandle);
		}

		function GoToRecord($no)
		{
			return mysql_data_seek($this->resHandle, $no);
		}

		function Close()
		{
			return mysql_free_result($this->resHandle);
		}
	
		// end 	of class result
	}
?>