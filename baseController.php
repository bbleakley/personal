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
		$output = '<table class="table-striped"><thead><tr>';
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
				$output .= '</tr></thead><tbody>';
			}
			$output .= '<tr>';
			foreach( $header as $field ){
				$output .= '<td>' . $row[$field] . '</td>';
			}
			$output .= '</tr>';
		}
		$output .= '</tbody></table>';
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

	public function get_customer($id){
		$query = 
		"select
			concat(customer.first_name, ' ', customer.last_name) as full_name,
			customer.first_name,
			customer.last_name,
			count(rental_id) as rentals,
			case
				when store_id = 1
				then 'Canada'
				else 'Australia'
			end as store,
			address.phone,
			customer.email,
			address.address,
			city.city,
			country.country,
			address.postal_code
		from customer
		inner join address
			on customer.address_id = address.address_id
		inner join city
			on address.city_id = city.city_id
		inner join country
			on city.country_id = country.country_id
		left join rental
			on customer.customer_id = rental.customer_id
		where customer.customer_id = $id
		group by customer.customer_id";
		$data = $this->query($query);
		return $data[0];
	}

	public function get_film($id){
		$query =
		"select
			film.title as title,
			category.name as category,
			film.rating as rating,
			film.description as description,
			film.special_features as special_features,
			film.release_year as release_year,
			film.length as length,
			film.rental_duration as rental_duration,
			film.rental_rate as rental_rate,
			film.replacement_cost as replacement_cost
		from film
		inner join film_category
			on film.film_id = film_category.film_id
		inner join category
			on film_category.category_id = category.category_id
		left join(
			select
				film_id,
				count(inventory_id) as count
			from inventory i
			where store_id = 1
			group by film_id
		) as fi
			on film.film_id = fi.film_id
		left join(
			select 
				film_id,
				count(inventory_id) as count
			from inventory i
			where store_id = 2
			group by film_id
		) as si
			on film.film_id = si.film_id
		where film.film_id = $id;";
		$data = $this->query($query);
		return $data[0];
	}

	public function get_customer_rentals($customer_id){
		$query = 
		"select
			film.film_id,
			film.title,
			category.name as category,
			film.rating,
			rental.rental_date,
			rental.return_date,
			DATEDIFF(ifnull(rental.return_date,CURRENT_DATE()), rental.rental_date) as days_before_return,
			film.rental_duration as days_allowed,
			CASE
				WHEN 
					DATEDIFF(ifnull(rental.return_date,CURRENT_DATE()), rental.rental_date) > film.rental_duration
				THEN
					'LATE'
				ELSE
					''
			END as return_status
		from customer
		inner join rental
			on customer.customer_id = rental.customer_id
		inner join inventory
			on rental.inventory_id = inventory.inventory_id
		inner join film
			on film.film_id = inventory.film_id
		inner join film_category
			on film.film_id = film_category.film_id
		inner join category
			on film_category.category_id = category.category_id
		where customer.customer_id = $customer_id
		order by rental_date;";
		return $this->query($query);
	}

	public function get_film_rentals($film_id){
		$query = 
		"select
			c.customer_id,
			concat(c.first_name,' ', c.last_name) as customer,
			r.rental_date,
			r.return_date,
			DATEDIFF(r.return_date, r.rental_date) as days_to_return,
			case
				when DATEDIFF(r.return_date, r.rental_date) > f.rental_duration
				then 'LATE'
				else ''
			end as return_status
		from film f
		inner join inventory i
			on f.film_id = i.film_id
		inner join rental r
			on i.inventory_id = r.inventory_id
		inner join customer c
			on r.customer_id = c.customer_id
		where f.film_id = 1
		order by c.last_name;";
		return $this->query($query);
	}

	public function get_customer_categories($customer_id){
		$query = 
		"select
			ca.name,
			count(r.rental_id) as count
		from customer c
		inner join rental r
			on c.customer_id = r.customer_id
		inner join inventory i
			on r.inventory_id = i.inventory_id
		inner join film f
			on i.film_id = f.film_id
		inner join film_category fc
			on f.film_id = fc.film_id
		inner join category ca
			on fc.category_id = ca.category_id
		where c.customer_id = $customer_id
		group by c.customer_id, ca.category_id
		order by count(rental_id) desc";
		$data = $this->query($query);
		
		foreach( $data as $row ){
			if( ! @$header ){
				$output = "[['Category', 'Count']"; 
				$header = true;
			}
			$category = $row['name'];
			$count = $row['count'];
			$output .= ", ['$category', $count]";
		}
		return $output ."]";
		
	}

	public function get_customer_actor($customer_id){
		$query = 
		"select
			a.actor_id,
			concat(a.first_name, ' ', a.last_name) as name,
			count(r.rental_id) as count
		from customer c
		inner join rental r
			on c.customer_id = r.customer_id
		inner join inventory i
			on r.inventory_id = i.inventory_id
		inner join film f
			on i.film_id = f.film_id
		inner join film_actor fa
			on f.film_id = fa.film_id
		inner join actor a
			on fa.actor_id = a.actor_id
		where c.customer_id = $customer_id
		group by c.customer_id, a.actor_id
		order by count(r.rental_id) desc
		limit 5;";
		$data = $this->query($query);
		foreach( $data as $row ){
			if( ! @$header ){
				$output = "[['Actor', 'Rentals of Films Starring this Actor']"; 
				$header = true;
			}
			$name = ucwords(strtolower($row['name']));
			$count = $row['count'];
			$output .= ", ['$name', $count]";
		}
		return $output ."]";
	}

	public function get_film_actor($film_id){

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
