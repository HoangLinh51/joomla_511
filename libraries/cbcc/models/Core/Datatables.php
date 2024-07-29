<?php
class Core_Model_Datatables {
	private $_index_start = 0;
	/**
	 * Create the data output array for the DataTables rows
	 *
	 *  @param  array $columns Column information array
	 *  @param  array $data    Data from the SQL get
	 *  @return array          Formatted data in a row based format
	 */
	public function data_output ( $columns, $data )
	{
		$out = array();		
		for ( $i=0, $ien=count($data) ; $i<$ien ; $i++ ) {
			$row = array();
			$this->_index_start = $this->_index_start + 1;
			for ( $j=0, $jen=count($columns) ; $j<$jen ; $j++ ) {
				$column = $columns[$j];
				//$columns[$j]['db'] = end(explode('.',$columns[$j]['db']));
				//var_dump(end(explode('.',$column['db'])));
				// Is there a formatter?
				if ( isset( $column['formatter'] ) ) {
					//var_dump($column['index']);
					if ($column['formatter'] === 'index') {
						$row[ $column['dt'] ] = $this->_index_start;
					}elseif (isset( $column['alias'] ) ) {
						$row[ $column['dt'] ] = $column['formatter']( $data[$i][$column['alias']], $data[$i] );
					}else{
						$row[ $column['dt'] ] = $column['formatter']( $data[$i][end(explode('.',$column['db'] ))], $data[$i] );
					}
					//$row[ $column['dt'] ] = $column['formatter']( $data[$i][ $column['db'] ], $data[$i] );
				}elseif (isset( $column['alias'] ) ) {
					$row[ $column['dt'] ] = $data[$i][ $columns[$j]['alias'] ];
				}
				else {
					$row[ $column['dt'] ] = $data[$i][ end(explode('.',$column['db'] ))];
					//$row[ $column['dt'] ] = $data[$i][ $columns[$j]['db'] ];
					//var_dump($data[$i][ $columns[$j]['db'] ]);
				}
			}
			//var_dump($row);exit;
			$out[] = $row;
		}

		return $out;
	}


	/**
	 * Paging
	 *
	 * Construct the LIMIT clause for server-side processing SQL query
	 *
	 *  @param  array $request Data sent to server by DataTables
	 *  @param  array $columns Column information array
	 *  @return string SQL limit clause
	 */
	public function limit ( $request, $columns )
	{
		$limit = '';

		if ( isset($request['start']) && $request['length'] != -1 ) {
			$limit = "LIMIT ".intval($request['start']).", ".intval($request['length']);
			$this->_index_start = $request['start'];
		}

		return $limit;
	}


	/**
	 * Ordering
	 *
	 * Construct the ORDER BY clause for server-side processing SQL query
	 *
	 *  @param  array $request Data sent to server by DataTables
	 *  @param  array $columns Column information array
	 *  @return string SQL order by clause
	 */
	public function order ( $request, $columns )
	{
		$order = '';
		//var_dump($request['order']);
		if ( isset($request['order']) && count($request['order']) ) {
			$orderBy = array();
			$dtColumns = $this->pluck( $columns, 'dt' );

			for ( $i=0, $ien=count($request['order']) ; $i<$ien ; $i++ ) {
				// Convert the column index into the column data property
				$columnIdx = intval($request['order'][$i]['column']);
				$requestColumn = $request['columns'][$columnIdx];

				$columnIdx = array_search( $requestColumn['data'], $dtColumns );
				$column = $columns[ $columnIdx ];
				//var_dump($requestColumn['orderable']);
				if ( $requestColumn['orderable'] == 'true' ) {
					$dir = $request['order'][$i]['dir'] === 'asc' ?
					'ASC' :
					'DESC';

					$orderBy[] = ''.$column['db'].' '.$dir;
				}
			}
			//var_dump($orderBy);exit;
			if (count($orderBy) > 0 ) {
				$order = 'ORDER BY '.implode(', ', $orderBy);
			}
			
		}

		return $order;
	}
	public function join ( $join )
	{		
		return " $join ";
	}
	

	/**
	 * Searching / Filtering
	 *
	 * Construct the WHERE clause for server-side processing SQL query.
	 *
	 * NOTE this does not match the built-in DataTables filtering which does it
	 * word by word on any field. It's possible to do here performance on large
	 * databases would be very poor
	 *
	 *  @param  array $request Data sent to server by DataTables
	 *  @param  array $columns Column information array
	 *  @param  array $bindings Array of values for PDO bindings, used in the
	 *    sql_exec() function
	 *  @return string SQL where clause
	 */
	public function filter ( $request, $columns, &$bindings )
	{
		$globalSearch = array();
		$columnSearch = array();
		$dtColumns = $this->pluck( $columns, 'dt' );
		//var_dump($request['search']);
		if ( isset($request['search']) && $request['search']['value'] != '' ) {
			$str = $request['search']['value'];

			for ( $i=0, $ien=count($request['columns']) ; $i<$ien ; $i++ ) {
				$requestColumn = $request['columns'][$i];
				$columnIdx = array_search( $requestColumn['data'], $dtColumns );
				$column = $columns[ $columnIdx ];

				if ( $requestColumn['searchable'] == 'true' ) {
					$binding = $this->bind( $bindings, '%'.$str.'%', PDO::PARAM_STR );					
					$globalSearch[] = "".$column['db']." LIKE ".$binding;
				}
			}
		}
		//var_dump($globalSearch);
		// Individual column filtering
		for ( $i=0, $ien=count($request['columns']) ; $i<$ien ; $i++ ) {
			$requestColumn = $request['columns'][$i];
			$columnIdx = array_search( $requestColumn['data'], $dtColumns );
			$column = $columns[ $columnIdx ];

			$str = $requestColumn['search']['value'];

			if ( $requestColumn['searchable'] == 'true' &&
			$str != '' ) {
				$binding = $this->bind( $bindings, '%'.$str.'%', PDO::PARAM_STR );
				$columnSearch[] = "".$column['db']." LIKE ".$binding;
			}
		}

		// Combine the filters into a single string
		$where = '';

		if ( count( $globalSearch ) ) {
			$where = '('.implode(' OR ', $globalSearch).')';
		}

		if ( count( $columnSearch ) ) {
			$where = $where === '' ?
			implode(' AND ', $columnSearch) :
			$where .' AND '. implode(' AND ', $columnSearch);
		}

		if ( $where !== '' ) {
			$where = 'WHERE '.$where;
		}
		//var_dump($where);
		return $where;
	}


	/**
	 * Perform the SQL queries needed for an server-side processing requested,
	 * utilising the helper functions of this class, limit(), order() and
	 * filter() among others. The returned array is ready to be encoded as JSON
	 * in response to an SSP request, or can be modified if needed before
	 * sending back to the client.
	 *
	 *  @param  array $request Data sent to server by DataTables
	 *  @param  array $sql_details SQL connection details - see sql_connect()
	 *  @param  string $table SQL table to query
	 *  @param  string $primaryKey Primary key of the table
	 *  @param  array $columns Column information array
	 *  @return array          Server-side processing response array
	 */
	public function simple ( $request, $table, $primaryKey, $columns, $join='', $strWhere = '', $opt = '')
	{
		$bindings = array();
		$db = $this->sql_connect();

		// Build the SQL query string from the request
		$limit = $this->limit( $request, $columns );
		$order = $this->order( $request, $columns );
		$join = $this->join( $join );
		$where = $this->filter( $request, $columns, $bindings);
		if ($where === '' && $strWhere != '') {
			$where = ' WHERE '.$strWhere;
		}elseif ($where !== '' && $strWhere != ''){
			$where .= ' AND '.$strWhere;
		}
// 		var_dump($bindings);exit;
		if($opt === 'excuteQuery'){
			echo "SELECT SQL_CALC_FOUND_ROWS ".implode(", ", $this->pluck($columns, 'db'))."
				FROM $table
				$join	 
				$where
				$order
				$limit";exit;
		}
		// Main query to actually get the data
		$data = $this->sql_exec( $db, $bindings,
				"SELECT SQL_CALC_FOUND_ROWS ".implode(", ", $this->pluck($columns, 'db'))."
			 FROM $table
			 $join	 
			 $where
			 $order
			 $limit"
		);
		// Data set length after filtering
		$resFilterLength = $this->sql_exec( $db,
				"SELECT FOUND_ROWS()"
		);
		$recordsFiltered = $resFilterLength[0][0];

		// Total data set length
		$resTotalLength = $this->sql_exec( $db,$bindings,
				"SELECT COUNT({$primaryKey})
			 FROM $table
			 $join	 
			 $where"
		);
		$recordsTotal = $resTotalLength[0][0];


		/*
		 * Output
		*/
		return array(
				"draw"            => intval( $request['draw'] ),
				"recordsTotal"    => intval( $recordsTotal ),
				"recordsFiltered" => intval( $recordsFiltered ),
				"data"            => $this->data_output( $columns, $data )
		);
	}


	/**
	 * Connect to the database
	 *
	 * @param  array $sql_details SQL server connection details array, with the
	 *   properties:
	 *     * host - host name
	 *     * db   - database name
	 *     * user - user name
	 *     * pass - user password
	 * @return resource Database connection handle
	 */
	public function sql_connect ( )
	{
		$config = Core::config();
		//var_dump($config);
		try {
			$db = @new PDO(
					"mysql:host={$config->host};dbname={$config->db};charset=utf8",
					$config->user,
					$config->password,
					array( PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION )
			);
		}
		catch (PDOException $e) {
			$this->fatal(
			"An error occurred while connecting to the database. ".
			"The error reported by the server was: ".$e->getMessage()
			);
		}

		return $db;
	}


	/**
	 * Execute an SQL query on the database
	 *
	 * @param  resource $db  Database handler
	 * @param  array    $bindings Array of PDO binding values from bind() to be
	 *   used for safely escaping strings. Note that this can be given as the
	 *   SQL query string if no bindings are required.
	 * @param  string   $sql SQL query to execute.
	 * @return array         Result from the query (all rows)
	 */
	public function sql_exec ( $db, $bindings, $sql=null )
	{
		// Argument shifting
		if ( $sql === null ) {
			$sql = $bindings;
		}

		$stmt = $db->prepare( $sql );
// 		echo $sql;exit;
		//$db = JFactory::getDbo();
	
		// Bind parameters
		if ( is_array( $bindings ) ) {
			for ( $i=0, $ien=count($bindings) ; $i<$ien ; $i++ ) {
				$binding = $bindings[$i];
				$stmt->bindValue( $binding['key'], $binding['val'], $binding['type'] );
			}
		}

		// Execute
		try {
			$stmt->execute();
		}
		catch (PDOException $e) {
			$this->fatal( "An SQL error occurred: ".$sql.$e->getMessage() );
		}

		// Return all
		return $stmt->fetchAll();
	}


	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Internal methods
	*/

	/**
	 * Throw a fatal error.
	 *
	 * This writes out an error message in a JSON string which DataTables will
	 * see and show to the user in the browser.
	 *
	 * @param  string $msg Message to send to the client
	 */
	public function fatal ( $msg )
	{
		echo json_encode( array(
				"error" => $msg
		) );

		exit(0);
	}

	/**
	 * Create a PDO binding key which can be used for escaping variables safely
	 * when executing a query with sql_exec()
	 *
	 * @param  array &$a    Array of bindings
	 * @param  *      $val  Value to bind
	 * @param  int    $type PDO field type
	 * @return string       Bound key to be used in the SQL where this parameter
	 *   would be used.
	 */
	public function bind ( &$a, $val, $type )
	{
		$key = ':binding_'.count( $a );

		$a[] = array(
				'key' => $key,
				'val' => $val,
				'type' => $type
		);

		return $key;
	}


	/**
	 * Pull a particular property from each assoc. array in a numeric array,
	 * returning and array of the property values from each item.
	 *
	 *  @param  array  $a    Array to get data from
	 *  @param  string $prop Property to read
	 *  @return array        Array of property values
	 */
	public function pluck ( $a, $prop )
	{
		$out = array();

		for ( $i=0, $len=count($a) ; $i<$len ; $i++ ) {
			if (isset($a[$i]['alias']) && $prop == 'db') {
				$out[] = $a[$i][$prop].' AS '.$a[$i]['alias'];
			}else{
				$out[] = $a[$i][$prop];
			}
		}

		return $out;
	}
}