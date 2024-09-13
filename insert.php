<?php
    include "db/config.php";
    class db{
        public $conn;

        public function dbconnect(){
            return $conn;
        } 
        public function encode_decode($action, $string) {
            $output = "";
            //encode
            if($action == 'encrypt') {
                $output = base64_encode($string);
                $output =  bin2hex($output);
            }			
            //decode
            if($action == 'decrypt') {
                $output = hex2bin($string);
                $output = base64_decode($output);
            }
            return $output;
        }
        
        public function InsertTable($table, $columns, $values) {
            $con = $this->connect(); $last_insert_id = "";
            
            if(!empty($columns) && !empty($values)) {
                if(count($columns) == count($values)) {					
                    $columns = implode(",", $columns);
                    $values = implode(",", $values);
                    
                    $result = "";
                    $insert_query = "INSERT INTO ".$table." (".$columns.") VALUES (".$values.")";
                    $result = $con->prepare($insert_query);
                    if($result->execute() === TRUE) {
                        $last_insert_id = $con->lastInsertId();
                        $last_query_insert_id = "";
                    }
                    else {
                        $last_insert_id = "Unable to insert the data";
                    }
                }
                else {
                    $last_insert_id = "Columns are not match";
                }
            }			
                    
            return $last_insert_id;
        }

        public function UpdateTable($table, $update_id, $columns, $values) {
            $con = $this->connect(); $updated_data = ''; $msg = "";
            
            if(!empty($columns) && !empty($values)) {
            
                if(count($columns) == count($values)) {					
                    for($r = 0; $r < count($columns); $r++) {
                        $updated_data = $updated_data.$columns[$r]." = ".$values[$r]."";
                        if(!empty($columns[$r+1])) {
                            $updated_data = $updated_data.', ';
                        }	
                    }
                    if(!empty($updated_data)) {
                        $updated_data = trim($updated_data);
                        $update_query = "UPDATE ".$table." SET ".$updated_data." WHERE id='".$update_id."'";
                        $result = $con->prepare($update_query);
                        if($result->execute() === TRUE) {
                            $msg = 1;							
                        }
                        else {
                            $msg = "Unable to update the data";
                        }
                    }
                    else {
                        $msg = "Unable to update the data";
                    }
                }
                else {
                    $msg = "Columns are not match";
                }
            }
                    
            return $msg;	
        }


        public function getTableRecords($table, $column, $value) {
            $con = $this->connect();
            $result = ""; $select_query = "";
            if(!empty($table)) {
                if(!empty($column) && !empty($value)) {
                    $select_query = "SELECT * FROM ".$table." WHERE ".$column." = '".$value."'  ORDER BY id DESC";	
                }
                else if(empty($column) && empty($value)) {		
                    $select_query = "SELECT * FROM ".$table." ORDER BY id DESC";	
                }
            }		
            //echo $select_query;
            if(!empty($select_query)) {
                $result = $this->getQueryRecords($table, $select_query);
            }
            return $result;
        }

        public function getQueryRecords($table, $select_query) {
            $con = $this->connect(); $list = array();
            if(!empty($select_query)) {
                $result = 0; $pdo = "";			
                $pdo = $con->prepare($select_query);
                $pdo->execute();	
                $result = $pdo->setFetchMode(PDO::FETCH_ASSOC);
                if(!empty($result)) {
                    foreach($pdo->fetchAll() as $row) {
                        $list[] = $row;
                    }
                }
            }
            return $list;
        }
    }

?>