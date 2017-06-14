<?php 
include("../assets/php/database.php"); 
include("../assets/php/class.acl.php");
$myACL = new ACL();
if (isset($_POST['action']))
{
	switch($_POST['action'])
	{
		case 'saveRole':
			$myACL->saveRole();
			header("location: roles.php");
		break;
		case 'delRole':
			$myACL->delRole();
			header("location: roles.php");
		break;
	}
}
if ($myACL->hasPermission('access_admin') != true)
{
	header("location: ../index.php");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ACL Test</title>
<link href="../assets/css/styles.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="header"></div>
<div id="adminButton"><a href="../">Main Screen</a> | <a href="index.php">Admin Home</a></div>
<div id="page">
<!--	if (isset($_GET['action']) == 'roles')-->
	<?php if (isset($_GET['action']) == '') { ?>
    	<h2>Select a Role to Manage:</h2>
        <?php
		$roles = $myACL->getAllRoles('full');
		foreach ($roles as $k => $v)
		{
			echo "<a href='?action=role&roleID=" . $v['ID'] . "'>" . $v['Name'] . "</a><br />";
		}
		if (count($roles) < 1)
		{
			echo "No roles yet.<br />";
		} ?>
        <input type="button" name="New" value="New Role" onclick="window.location='?action=role'" />
    <?php }
    if (isset($_GET['action']) == 'role') {
		if (isset($_GET['roleID']) == '') {
		?>
    	<h2>New Role:</h2>
        <?php } else { ?>
    	<h2>Manage Role: (<?php echo $myACL->getRoleNameFromID($_GET['roleID']); ?>)</h2><?php } ?>
        <form action="roles.php" method="post">
        	<label for="roleName">Name:</label><input type="text" name="roleName" id="roleName" value="<?php  $myACL->getRoleNameFromID(empty($_GET['roleID'])); ?>" />
            <table border="0" cellpadding="5" cellspacing="0">
            <tr><th></th><th>Allow</th><th>Deny</th><th>Ignore</th></tr>
            <?php
//			$userACL = new ACL($_GET['userID']);
			$rPerms = $myACL->getRolePerms(empty($_GET['roleID']));
            $aPerms = $myACL->getAllPerms('full');
            foreach ($aPerms as $k => $v)
            {
                echo "<tr><td><label>" . $v['Name'] . "</label></td>";
                echo "<td><input type='radio' name='perm_" . $v['ID'] . "' id='perm_" . $v['ID'] . "_1' value='1'";
                if (empty($rPerms[$v['Key']]) === true && $_GET['roleID'] != '') { echo " checked='checked'"; }
                echo " /></td>";
                echo "<td><input type='radio' name='perm_" . $v['ID'] . "' id='perm_" . $v['ID'] . "_0' value='0'";
                if (empty($rPerms[$v['Key']]) != true && empty($_GET['roleID']) != '') { echo " checked='checked'"; }
				else {echo " selected='selected'";}
				echo " /></td>";
				echo "<td><input type='radio' name='perm_" . $v['ID'] . "' id='perm_" . $v['ID'] . "_X' value='X'";
                if (empty($_GET['roleID']) == '' || !array_key_exists($v['Key'],$rPerms)) { echo " checked='checked'"; }
                echo " /></td>";
                echo "</tr>";
            }
        ?>
    	</table>
    	<input type="hidden" name="action" value="saveRole" />
        <input type="hidden" name="roleID" value="<?php  empty($_GET['roleID']); ?>" />
    	<input type="submit" name="Submit" value="Submit" />
    </form>
    <form action="roles.php" method="post">
         <input type="hidden" name="action" value="delRole" />
         <input type="hidden" name="roleID" value="<?php echo isset($_GET['roleID'])? $_GET['roleID'] : empty($_GET['roleID']) ; ?>" />
    	<input type="submit" name="Delete" value="Delete" />
    </form>
    <form action="roles.php" method="post">
    	<input type="submit" name="Cancel" value="Cancel" />
    </form>
    <?php } ?>
</div>
</body>
</html>