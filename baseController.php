<?php

class baseController {

	public function __construct(){
		$config = include('/var/www/config.php');
		foreach( $config as $key => $value ){
			$this->$key = $value;
		}
	}

	public function connect(){
		$mysqli = new mysqli($this->host, $this->username, $this->password, $this->database);
		if ($mysqli->connect_errno) {
			return;
		}
		return $mysqli;
	}

    public function query($query, $filter=false){
        if( ! $mysqli = $this->connect() ){
			return;
		}
        if( ! $result = $mysqli->query($query) ){
			return;
		}
		$output = array();
		while( $row = $result->fetch_assoc() ){
			if( $filter ){
				// for desc and show tables, otherwise use where
				$row = $row[$filter];
			}
			array_push($output, $row);
		}
		$result->close();
        return $output;
    }

	public function create_dropdown($options, $name, $pretty=false){
		$dropdown = '<select name="' . $name  . '" required><option value=""></option>';
        foreach( $options as $option ){
            // optionally specify a label that differs from the value
            if( is_array($option) ){
                $value = $option[0];
                $label = $option[1];
            }else{
                $value = $label = $option;
            }
            $dropdown .= '<option value="' . $value . '">';
			if( $pretty ){
	            // capitalize each word and replace "_" with " "
    	        $dropdown .= ucwords( implode(" ", explode("_", $label) ) );
			}else{
				$dropdown .= $label;
			}
            $dropdown .= '</option>';
        }
        $dropdown .= '</select>';
		return $dropdown;
	}

	public function get_table_dropdown(){
        $query = "show tables;";
		if( ! $tables = $this->query($query,"Tables_in_sakila") ){
			return;
		}
		$dropdown = '<form action="/table.php" method="get" id="table">';
		$dropdown .= $this->create_dropdown($tables, "table", true);
		$dropdown .= '</br><input type="submit" value="Submit"></input></form>';
		return $dropdown;
	}

	public function get_filter_dropdown($table){

		$query = "desc " . $table;
		if( ! $fields = $this->query($query,"Field") ){
			return;
		}
		$operators = array(
			array("equals", "Equals"),
			array("less", "Is Less Than"),
			array("greater","Is Greater Than"),
			array("contains", "Contains"),
			array("begins","Begins With"),
			array("ends","Ends With")
		);
		$dropdown = '<form action="/table.php" method="get" id="field">';
		$dropdown .= '<input type="hidden" name="table" value="' . $table . '">Where: ';
		$dropdown .= $this->create_dropdown($fields, "field", true) . "\t";
		$dropdown .= $this->create_dropdown($operators, "operator") . "\t";
		$dropdown .= '<input type="text" name="value">';
		$dropdown .= '</br><input type="submit" value="Submit"></input></form>';
		return $dropdown;
    }

	public function get_table($values, $pretty=false){
		$output = '<table><tr>';
		foreach( $values as $row ){
			if( ! @$header ){
				$header = array_keys($row);
				foreach( $header as $field ){
					if( $pretty ){
						$output .= '<th>' . ucwords( implode(' ', explode('_', $field) ) ) . '</th>';
					}else{
						$output .= '<th>' . $field . '</th>';
					}
				}
				$output .= '</tr>';
			}
			$output .= '<tr>';
			foreach( $header as $field ){
				$output .= '<td>' . $row[$field] . '</td>';
			}
			$output .= '</tr>';
		}
		$output .= '</table>';
		return $output;
	}

	public function field_type($table, $field){
		$query =
			"SELECT DATA_TYPE 
			FROM INFORMATION_SCHEMA.COLUMNS
			WHERE 
			TABLE_NAME = '" . $table . "' AND 
			COLUMN_NAME = '" . $field . "';";
		if( ! $type = $this->query($query) ){
			return;
		}
		return $type[0];
	}

	public function build_select($args){
		if( ! $table = $args['table'] ){
			return;
		}
		if( ! $fields = @$args['fields'] ){
			$fields = '*';
		}
		$output = array( "SELECT", $fields, "FROM", $table);
		if( $joins = @$args['joins'] ){
			foreach( $joins as $table => $fields ){
				array_push($output, "INNER JOIN " . $table);
				array_push($output, "ON " . $fields[0] . " = " . $fields[1]);
			}
		}
		if( $where ){
			// do something
		}
		if( $limits ){
			// do something
		}
		return implode("\n", $output);
	} 

}
