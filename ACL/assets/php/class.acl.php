<?php

	class ACL{
		var $perms = array();		//Array : Stores the permissions for the user
		var $userID = 0;			//Integer : Stores the ID of the current user
		var $userRoles = array();	//Array : Stores the roles of the current user
//        private  $db;

        public function __construct($userID = ''){

//            $this->db = ConexionDB::conexion();
            if ($userID != '')
			{
				$this->userID = floatval($userID);
			} else {
				$this->userID = floatval($_SESSION['userID']);
			}
			$this->userRoles = $this->getUserRoles('ids');
			$this->buildACL();
		}

//		public function ACL($userID = '')
//		{
//			 self::__constructor($userID);
//
//		}

		function buildACL()
		{
			//first, get the rules for the user's role
			if (count($this->userRoles) > 0)
			{
				$this->perms = array_merge($this->perms,$this->getRolePerms($this->userRoles));
			}
			//then, get the individual user permissions
			$this->perms = array_merge($this->perms,$this->getUserPerms($this->userID));
		}
		
		function getPermKeyFromID($permID){
            $this->db = ConexionDB::conexion();
            $strSQL = "SELECT permKey FROM permissions WHERE ID = " . floatval($permID) . " LIMIT 1";
			$data = $this->db->query($strSQL);
			$row = $data->fetch();
			return $row[0];
		}
		
		function getPermNameFromID($permID){
            $this->db = ConexionDB::conexion();
            $strSQL = "SELECT permName FROM permissions WHERE ID = " . floatval($permID) . " LIMIT 1";
			$data = $this->db->query($strSQL);
			$row = $data->fetch();
			return $row[0];
		}
		
		function getRoleNameFromID($roleID)
		{
			$strSQL = "SELECT roleName FROM roles WHERE ID = " . floatval($roleID) . " LIMIT 1";
			$data = $this->db->query($strSQL);
			$row = $data->fetch();
			return $row[0];
		}
		
		function getUserRoles(){
		    $this->db = ConexionDB::conexion();
			$strSQL = "SELECT * FROM user_roles WHERE userID = " . floatval($this->userID) . " ORDER BY addDate ASC";
            $data = $this->db->query($strSQL);
			$resp = array();
			while($row = $data->fetch(PDO::FETCH_ASSOC))
			{
				$resp[] = $row['roleID'];
			}
			return $resp;
		}
		
		function getAllRoles($format='ids'){
            $this->db = ConexionDB::conexion();
            $format = strtolower($format);
			$strSQL = "SELECT * FROM roles ORDER BY roleName ASC";
			$data = $this->db->query($strSQL);
			$resp = array();
			while($row = $data->fetch(PDO::FETCH_ASSOC))
			{
				if ($format == 'full')
				{
					$resp[] = array("ID" => $row['ID'],"Name" => $row['roleName']);
				} else {
					$resp[] = $row['ID'];
				}
			}
			return $resp;
		}
		
		function getAllPerms($format='ids')
		{
            $this->db = ConexionDB::conexion();
            $format = strtolower($format);
			$strSQL = "SELECT * FROM permissions ORDER BY permName ASC";
			$data = $this->db->query($strSQL);
			$resp = array();
			while($row = $data->fetch(PDO::FETCH_ASSOC))
			{
				if ($format == 'full')
				{
					$resp[$row['permKey']] = array('ID' => $row['ID'], 'Name' => $row['permName'], 'Key' => $row['permKey']);
				} else {
					$resp[] = $row['ID'];
				}
			}
			return $resp;
		}

		function getRolePerms($role){
            $this->db = ConexionDB::conexion();
            if (is_array($role))
			{
				$roleSQL = "SELECT * FROM role_perms WHERE roleID IN (" . implode(",",$role) . ") ORDER BY ID ASC";
			} else {
				$roleSQL = "SELECT * FROM role_perms WHERE roleID = " . floatval($role) . " ORDER BY ID ASC";
			}
			$data = $this->db->query($roleSQL);
			$perms = array();
			while($row = $data->fetch(PDO::FETCH_ASSOC)){
				$pK = strtolower($this->getPermKeyFromID($row['permID']));
				if ($pK == '') { continue; }
				if ($row['value'] === '1') {
					$hP = true;
				} else {
					$hP = false;
				}
				$perms[$pK] = array('perm' => $pK,'inheritted' => true,'value' => $hP,'Name' => $this->getPermNameFromID($row['permID']),'ID' => $row['permID']);
			}
			return $perms;
		}
		
		function getUserPerms($userID){
            $this->db = ConexionDB::conexion();
            $strSQL = "SELECT * FROM user_perms WHERE userID = " . floatval($userID) . " ORDER BY addDate ASC";
			$data = $this->db->query($strSQL);
			$perms = array();
			while($row = $data->fetch(PDO::FETCH_ASSOC))
			{
				$pK = strtolower($this->getPermKeyFromID($row['permID']));
				if ($pK == '') { continue; }
				if ($row['value'] == '1') {
					$hP = true;
				} else {
					$hP = false;
				}
				$perms[$pK] = array('perm' => $pK,'inheritted' => false,'value' => $hP,'Name' => $this->getPermNameFromID($row['permID']),'ID' => $row['permID']);
			}
			return $perms;
		}
		
		function userHasRole($roleID)
		{
			foreach($this->userRoles as $k => $v)
			{
				if (floatval($v) === floatval($roleID))
				{
					return true;
				}
			}
			return false;
		}
		
		function hasPermission($permKey)
		{
			$permKey = strtolower($permKey);
			if (array_key_exists($permKey,$this->perms))
			{
				if ($this->perms[$permKey]['value'] === '1' || $this->perms[$permKey]['value'] === true)
				{
					return true;
				} else {
					return false;
				}
			} else {
				return false;
			}
		}
		
		function getUsername($userID){
            $this->db = ConexionDB::conexion();
            $strSQL = "SELECT username FROM users WHERE ID = " . floatval($userID) . " LIMIT 1";
			$data = $this->db->query($strSQL);
			$row = $data->fetch();
			return $row[0];
		}

		function changeUser(){
            $this->db = ConexionDB::conexion();
            $strSQL = "SELECT * FROM users ORDER BY Username ASC";
            $data = $this->db->query($strSQL);
            while ($row = $data->fetch(PDO::FETCH_ASSOC)) {
                echo "<a href='?userID=" . $row['ID'] . "'>" . $row['username'] . "</a><br />";
            }
        }

        function selectUser(){
            $this->db = ConexionDB::conexion();
            $strSQL = "SELECT * FROM users ORDER BY Username ASC";
            $data = $this->db->query($strSQL);
            while ($row = $data->fetch(PDO::FETCH_ASSOC)) {
                echo "<a href='?action=user&userID=" . $row['ID'] . "'>" . $row['username'] . "</a><br />";
            }
        }

        function savePerm(){
            $this->db = ConexionDB::conexion();
            $strSQL = sprintf("REPLACE INTO permissions SET ID = '%u', permName = '%s', permKey = '%s'",$_POST['permID'],$_POST['permName'],$_POST['permKey']);
            $this->db->query($strSQL);
        }

        function delPerm(){
            $this->db = ConexionDB::conexion();
            $strSQL = sprintf("DELETE FROM permissions WHERE ID = :permID");
            $resultado = $this->db->prepare($strSQL);
            $permID = $_POST['permID'];
            $resultado->bindValue(":permID", $permID);
            $resultado->execute();
        }

        function saveRoles(){
            $this->db = ConexionDB::conexion();
            foreach ($_POST as $k => $v)
            {
                if (substr($k,0,5) == "role_")
                {
                    $roleID = str_replace("role_","",$k);
                    if ($v == '0' || $v == 'x') {
                        $strSQL = sprintf("DELETE FROM user_roles WHERE userID = %u AND roleID = %u",$_POST['userID'],$roleID);
                    } else {
                        $strSQL = sprintf("REPLACE INTO user_roles SET userID = %u, roleID = %u, addDate = '%s'",$_POST['userID'],$roleID,date ("Y-m-d H:i:s"));
                    }
                    $this->db->query($strSQL);
                }
            }
        }

        function savePerms(){
            $this->db = ConexionDB::conexion();
            foreach ($_POST as $k => $v)
            {
                if (substr($k,0,5) == "perm_")
                {
                    $permID = str_replace("perm_","",$k);
                    if ($v == 'x')
                    {
                        $strSQL = sprintf("DELETE FROM user_perms WHERE userID = %u AND permID = %u",$_POST['userID'],$permID);
                    } else {
                        $strSQL = sprintf("REPLACE INTO user_perms SET userID = %u, permID = %u, value = %u, addDate = '%s'",$_POST['userID'],$permID,$v,date ("Y-m-d H:i:s"));
                    }
                    $this->db->query($strSQL);
                }
            }
        }

        function saveRole(){
            $this->db = ConexionDB::conexion();
            $strSQL = sprintf("REPLACE INTO roles SET ID = %u, roleName = '%s'",$_POST['roleID'],$_POST['roleName']);
            $consulta = $this->db->query($strSQL);
            if ($consulta->rowCount() > 1)
            {
                $roleID = $_POST['roleID'];
            } else {
                $roleID = mysqli_insert_id();
            }
            foreach ($_POST as $k => $v)
            {
                if (substr($k,0,5) == "perm_")
                {
                    $permID = str_replace("perm_","",$k);
                    if ($v == 'X')
                    {
                        $strSQL = sprintf("DELETE FROM role_perms WHERE roleID = %u AND permID = %u",$roleID,$permID);
                        $this->db->query($strSQL);
                        continue;
                    }
//					this->db->query($strSQL)
                    $strSQL = sprintf("REPLACE INTO role_perms SET roleID = %u, permID = %u, value = %u, addDate = '%s'",$roleID,$permID,$v,date ("Y-m-d H:i:s"));
                    $this->db->query($strSQL);
                }
            }
        }

        function delRole(){
            $this->db = ConexionDB::conexion();
            $strSQL = sprintf("DELETE FROM roles WHERE ID = %u LIMIT 1",$_POST['roleID']);
            $this->db->query($strSQL);
            $strSQL = sprintf("DELETE FROM user_roles WHERE roleID = %u",$_POST['roleID']);
            $this->db->query($strSQL);
            $strSQL = sprintf("DELETE FROM role_perms WHERE roleID = %u",$_POST['roleID']);
            $this->db->query($strSQL);
        }

        function parse_mysql_dump($url){
            $this->db = ConexionDB::conexion();
            $file_content = file($url);
            foreach($file_content as $sql_line){
                if(trim($sql_line) != "" && strpos($sql_line, "--") === false){
                    //echo $sql_line . '<br>';
                    $this->db->query($sql_line);
                }
            }

        }
	}

?>