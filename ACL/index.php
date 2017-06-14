<?php 
include_once("assets/php/database.php");
include_once("assets/php/class.acl.php");

if (isset($_GET['userID']))
    $userID = $_GET['userID'];
else
    $userID = '';

$_SESSION['userID'] = 1;

$myACL = new ACL();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ACL Test</title>
<link href="assets/css/styles.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="header"></div>
<div id="adminButton"><a href="admin">Admin Screen</a></div>
<div id="page">
	<h2>Permissions for <?php echo $myACL->getUsername($userID); ?>:</h2>
	<?php
		$userACL = new ACL($userID);
		$aPerms = $userACL->getAllPerms('full');
		foreach ($aPerms as $k => $v)
		{
			echo "<strong>" . $v['Name'] . ": </strong>";
			echo "<img src=\"assets/img/";
			if ($userACL->hasPermission($v['Key']) === true)
			{
				echo "allow.png";
				$pVal = "Allow";
			} else {
				echo "deny.png";
				$pVal = "Deny";
			}
			echo "\" width=\"16\" height=\"16\" alt=\"$pVal\" /><br />";
		}
	?>
    <h3>Change User:</h3>
    <?php
        $myACL->changeUser();
//        $this->db = ConexionDB::conexion();
//		$strSQL = "SELECT * FROM users ORDER BY Username ASC";
//        $data = $this->db->query($strSQL);
//		while ($row = $data->fetch(PDO::FETCH_ASSOC)) {
//			echo "<a href='?userID=" . $row['ID'] . "'>" . $row['username'] . "</a><br />";
//		}
    ?>
</div>
</body>
</html>