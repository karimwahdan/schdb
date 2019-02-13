<?php
class Database
{
	/* 
	 * Create variables for credentials to MySQL database
	 * The variables have been declared as private. This
	 * means that they will only be available with the 
	 * Database class
	 */
	private $db_host = "den1.mysql6.gear.host";  // Change as required
	private $db_user = "schdbase";  // Change as required
	private $db_pass = "123_123";  // Change as required
	private $db_name = "schdbase";	// Change as required
     /*
	 * Extra variables that are required by other function such as boolean con variable
	 */
	private $con = false; // Check to see if the connection is active
    private $myconn = ""; // This will be our mysqli object
	private $result = array(); // Any results from a query will be stored here
	private $result2 = array(); // Any results from a query will be stored here
    private $myQuery = "";// used for debugging process with SQL return
    private $numResults = "";// used for returning the number of rows
    /** TRUE if static variables have been initialized. FALSE otherwise
    */
    // Function to make connection to database
	public function connect(){
		if(!$this->con){
			$this->myconn = new mysqli($this->db_host,$this->db_user,$this->db_pass,$this->db_name);  // mysql_connect() with variables defined at the start of Database class
			mysqli_set_charset($this->myconn,"utf8");
            if($this->myconn->connect_errno > 0){
                array_push($this->result,$this->myconn->connect_error);
                return false; // Problem selecting database return FALSE
            }else{
                $this->con = true;
                return true; // Connection has been made return TRUE
            } 
        }else{  
            return true; // Connection has already been made return TRUE 
        }  	
	}
	// Function to disconnect from the database
    public function disconnect()
	{
    	// If there is a connection to the database
    	if($this->con){
    		// We have found a connection, try to close it
    		if($this->myconn->close()){
    			// We have successfully closed the connection, set the connection variable to false
    			$this->con = false;
				// Return true tjat we have closed the connection
				return true;
			}else{
				// We could not close the connection, return false
				return false;
			}
		}

    }
	public function sql($sql){
		$query = $this->myconn->query($sql);
		
        $this->myQuery = $sql; // Pass back the SQL
		if($query){
			// If the query returns >= 1 assign the number of rows to numResults
			$this->numResults=0;
			if (isset($query->num_rows) && ( $query->num_rows > 0)) {
				$this->numResults = $query->num_rows;
			}
			// Loop through the query results by the number of rows returned
			for($i = 0; $i < $this->numResults; $i++){
				$r = $query->fetch_array();
               	$key = array_keys($r);
               	for($x = 0; $x < count($key); $x++){
               		// Sanitizes keys so only alphavalues are allowed
                   	if(!is_int($key[$x])){
                   		if($query->num_rows >= 1){
                   			$this->result[$i][$key[$x]] = $r[$key[$x]];
						}else{
							$this->result = null;
						}
					}
				}
			}
			return true; // Query was successful
		}else{
			array_push($this->result,$this->myconn->error);
			return false; // No rows where returned
		}
	}
	
  // Public function to return the data to the user
    public function getResult(){
        $val = $this->result;
        $this->result = array();
        return $val;
    }
  
}

	
?>
