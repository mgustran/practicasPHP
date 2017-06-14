<?php 
include("../assets/php/database.php"); 
include("../assets/php/class.acl.php");
$myACL = new ACL();
if (isset($_POST['action']))
{
	switch($_POST['action'])
	{
		case 'saveRoles':
			$redir = "?action=user&userID=" . $_POST['userID'];
			$myACL->saveRoles();

		break;
		case 'savePerms':
			$redir = "?action=user&userID=" . $_POST['userID'];
			$myACL->savePerms();
		break;
	}
	header("location: users.php" . $redir);
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
	<?php if (isset($_GET['userID']))
		$userID = $_GET['userID'];
	else
		$userID = ''; { ?>
    	<h2>Select a User to Manage:</h2>
        <?php
        $myACL->selectUser();

    } ?>
    <?php
    if (isset($_GET['action']) == 'user' ) {
		$userACL = new ACL($_GET['userID']);
	?>
    	<h2>Managing <?php echo $myACL->getUsername($_GET['userID']); ?>:</h2>
        ... Some form to edit user info ...
        <h3>Roles for user:   (<a href="users.php?action=roles&userID=<?php $_GET['userID']; ?>">Manage Roles</a>)</h3>
        <ul>
        <?php $roles = $userACL->getUserRoles();
		foreach ($roles as $k => $v)
		{
			echo "<li>" . $userACL->getRoleNameFromID($v) . "</li>";
		}
		?>
        </ul>
        <h3>Permissions for user:   (<a href="users.php?action=perms&userID=<?php $_GET['userID']; ?>">Manage Permissions</a>)</h3>
        <ul>
        <?php $perms = $userACL->perms;
		foreach ($perms as $k => $v)
		{
			if ($v['value'] === false) { continue; }
			echo "<li>" . $v['Name'];
			if ($v['inheritted']) { echo "  (inheritted)"; }
			echo "</li>";
		}
		?>
        </ul>
     <?php } ?>
     <?php if (isset($_GET['action']) == 'roles') { ?>
     <h2>Manage User Roles: (<?php echo $myACL->getUsername($_GET['userID']); ?>)</h2>
     <form action="users.php" method="post">
        <table border="0" cellpadding="5" cellspacing="0">
        <tr><th></th><th>Member</th><th>Not Member</th></tr>
        <?php
		$roleACL = new ACL($_GET['userID']);
		$roles = $roleACL->getAllRoles('full');
        foreach ($roles as $k => $v)
        {
            echo "<tr><td><label>" . $v['Name'] . "</label></td>";
            echo "<td><input type='radio' name='role_" . $v['ID'] . "' id='role_" . $v['ID'] . "_1' value='1'";
            if ($roleACL->userHasRole($v['ID'])) { echo " checked='checked'"; }
            echo " /></td>";
            echo "<td><input type='radio' name='role_" . $v['ID'] . "' id='role_" . $v['ID'] . "_0' value='0'";
            if (!$roleACL->userHasRole($v['ID'])) { echo " checked='checked'"; }
            echo " /></td>";
            echo "</tr>";
        }
    ?>
        </table>
        <input type="hidden" name="action" value="saveRoles" />
        <input type="hidden" name="userID" value="<?php echo $_GET['userID']; ?>" />
        <input type="submit" name="Submit" value="Submit" />
    </form>
    <form action="users.php" method="post">
    	<input type="button" name="Cancel" onclick="window.location='?action=user&userID=<?php $_GET['userID']; ?>'" value="Cancel" />
    </form>
     <?php } ?>
     <?php
    if (isset($_GET['action']) == 'perms' ) {
	?>
    	<h2>Manage User Permissions: (<?php echo $myACL->getUsername($_GET['userID']); ?>)</h2>
        <form action="users.php" method="post">
            <table border="0" cellpadding="5" cellspacing="0">
            <tr><th></th><th></th></tr>
            <?php
            $rPerms = $userACL->perms;
            $aPerms = $userACL->getAllPerms('full');
            foreach ($aPerms as $k => $v)
            {
                echo "<tr><td>" . $v['Name'] . "</td>";
				echo "<td><select name='perm_" . $v['ID'] . "'>";
				echo "<option value='1'";
				if ($userACL->hasPermission($v['Key']) && empty($rPerms[$v['Key']]) != true) { echo " selected='selected'"; }
				echo ">Allow</option>";
				echo "<option value='0'";
				if (empty($rPerms[$v['Key']]) === false && empty($rPerms[$v['Key']]) != true) { echo " selected='selected'"; }
				else {echo " selected='selected'";}
				echo ">Deny</option>";
				echo "<option value='x'";
				if (empty($rPerms[$v['Key']]) == true || !array_key_exists($v['Key'],$rPerms))
				{
					echo " selected='selected'";
					if (empty($rPerms[$v['Key']]) === true )
					{
						$iVal = '(Deny)';
					} else {
						$iVal = '(Allow)';
					}
				}
				else{
				    echo " selected='selected'";
                    if (empty($rPerms[$v['Key']]) === true )
                    {
                        $iVal = '(Deny)';
                    } else {
                        $iVal = '(Allow)';
                    }
				}
				echo ">Inherit $iVal</option>";
                echo "</select></td></tr>";
            }
        ?>
    	</table>
    	<input type="hidden" name="action" value="savePerms" />
        <input type="hidden" name="userID" value="<?php echo $_GET['userID']; ?>" />
    	<input type="submit" name="Submit" value="Submit" />
    </form>
    <form action="users.php" method="post">
    	<input type="button" name="Cancel" onclick="window.location='?action=user&userID=<?php echo $_GET['userID']; ?>'" value="Cancel" />
    </form>
    <?php } ?>
</div>
</body>
</html>