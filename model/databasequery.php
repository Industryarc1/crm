<?php
define('SERVER', 'localhost');
define('USERNAME', 'crmdbmain');
define('PASSWORD', '6%sUD%wnUhva@+b-3janYWUs$MvUrJLU');
define('DATABASE', 'iarc-crmdb-live');

class databaseQuery{	
	function __construct()
	{
		$this->connection = @mysqli_connect(SERVER, USERNAME, PASSWORD,DATABASE);
	}
	
	/* To Get single Row function Start */
	function getRow($query)
	{
		$res=mysqli_query($this->connection,$query);
		$values=mysqli_fetch_assoc($res);
		return $values;
	}
	/* To Get single function End */
	
	/* To Get multiple rows  function Start */
	function getAllRows($query)
	{
		$values=array();
        $res=mysqli_query($this->connection,$query);
		while($rows=@mysqli_fetch_assoc($res))
		{
			$values[]=$rows;
		}
		return $values;
	}
	/* To Get multiple rows  function End */
	
	/* To Get Select Query   function start */
	function selectQuery($tablename,$fields,$where,$order,$order_type,$start,$limit)
	{
		//if(count($fields)>1)
		//$fields=implode(",",$fields);
		//else
		$fields=$fields;
		$query="SELECT ".$fields." FROM ".$tablename;
		if($where!=""){
			$search_by=$where;
			$search_by_key="";
			foreach($search_by as $key=>$value)
			{
				$search_by_key.= $key ."='".$value."' AND ";
			}
			$search_by_key = trim($search_by_key," AND ");
		$query.=" WHERE ".$search_by_key;
		}
		if($order!="")
		$query.=" ORDER BY ".$order." ".$order_type;

		if($limit!="")
		{
		if($start=="")
		$start=0;
		$query.=" LIMIT ".$start.",".$limit;
		}
		return $query;
	}
	/* To Get Select Query   function End */
	
	/* To Get Select Query OR  function start */
	function selectQueryOR($tablename,$fields,$where,$order,$order_type,$start,$limit)
	{
		if(count($fields)>1)
		$fields=implode(",",$fields);
		else
		$fields=$fields;
		$query="SELECT ".$fields." FROM ".$tablename;
		if($where!=""){
		$query.=" WHERE ".$where;
		}
		if($order!="")
		$query.=" ORDER BY ".$order." ".$order_type;

		if($limit!="")
		{
		if($start=="")
		$start=0;
		$query.="LIMIT".$start.",".$limit;
		}
		return $query;
	}
	/* To Get Select Query or  function End */
	
	/* Insert Query function start */
	function insert($table_name,$data)
	{
		$fields = array_keys($data);
		$fields = implode(',',$fields);
		$values = array_values($data);
		$values = implode("','",$values);
		$sql ="INSERT INTO ".$table_name."(".$fields.") VALUES ('".$values."')";
		//echo $sql;exit;
		$res=mysqli_query($this->connection,$sql);
		$return=mysqli_insert_id($this->connection);
        return $return;
	}
	/* Insert Query function end */
	
	/* Update Query function start*/
	function update($table_name,$data,$update_by)
	{
		$update="";
		foreach($data as $key=>$value)
		{
			$update.= $key ."='".$value."',";
		}
		$update = trim($update,",");
		$update_by_key="";
		foreach($update_by as $key=>$value)
		{
			$update_by_key.= $key ."='".$value."' AND ";
		}
		$update_by_key = trim($update_by_key," AND ");
		$sql ="UPDATE ".$table_name." set ".$update." where ".$update_by_key."";
		//echo $sql;
	    $res=mysqli_query($this->connection,$sql);
		return $res;
	}
	/*   Update Query function end */
	
	/*   Update Query function start*/
	function delete($table_name,$delete_by)
	{
		$delete_by_key="";
		foreach($delete_by as $key=>$value)
		{
			$delete_by_key.= $key ."='".$value."' AND ";
		}
		$delete_by_key = trim($delete_by_key," AND ");
		$sql ="DELETE FROM  ".$table_name."  where ".$delete_by_key."";
		//echo $sql; exit;
                $res=mysqli_query($this->connection,$sql);
		return $res;
	}
	/*   Update Query function end */

	/*  Genrate Random String function start */
	function GenerateRandomString($length)
	{
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++)
		{
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}
	/*  Genrate Random String function end */

	/* Execute  function start */
	function execute($sql)
	{
		$res=mysqli_query($this->connection,$sql);
		return $res;
	}
	/* Execute  function End */
	
	/* Insert Query function start */
	function insertdebug($table_name,$data)
	{
		$fields = array_keys($data);
		$fields = implode(',',$fields);
		$values = array_values($data);
		$values = implode("','",$values);
		$sql ="INSERT INTO ".$table_name."(".$fields.") VALUES ('".$values."')";
		echo $sql;exit;
		$res=mysqli_query($this->connection,$sql);
		$return=mysqli_insert_id($this->connection);
        return $return;
	}
	/* Insert Query function end */
	
	function clean_sql($data)
    {
        return mysqli_real_escape_string($this->connection, $data);
    }
	
	/* To Create Destruct function Start */
	function __destruct()
	{
		mysqli_close($this->connection);// connection close
	}
	/* To Create Destruct function End */
}
?>