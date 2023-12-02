<?php
if (isset($_POST['upload'])) {
    include 'config.php';

    $username = trim($_POST['tusername']);
    $password = password_hash(trim($_POST['tpassword']), PASSWORD_BCRYPT);

    if (empty($username) || empty($_POST['tpassword'])) {
        $message = "Data Not Valid";
    } else {
        $query = "SELECT * FROM pengguna WHERE username=?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            $message = "There is a user with the same username";
        } else {
            mysqli_stmt_close($stmt);

            $query = "INSERT INTO pengguna(username, password) VALUES (?, ?)";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "ss", $username, $password);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            mysqli_close($conn);

            echo "Add user Administrator '$username' SUCCESS";
            exit;
        }
    }
}
?>

<html>
<head>
    <title>Menambahkan User Admin</title>
</head>
<body>
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" class="content">
    <tr>
        <td>
            <center>
                <font color="#FF0000">
                    <?php if (isset($message)) {
                        echo $message;
                    } ?>
                </font>
            </center>
        </td>
    </tr>
</table>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="uploadform" id="uploadform">
    <table width="90%" border="0" align="center" cellpadding="2" cellspacing="2" class="content">
        <tr bgcolor="#FFDFAA">
            <td colspan="3">
                <div align="center"><strong>Add User Administrator</strong></div>
            </td>
        </tr>
        <tr>
            <td width="26%"><strong>Username</strong></td>
            <td width="2%">:</td>
            <td width="72%"><input name="tusername" type="text" id="username" size="20" maxLength="20">
                <span class="style2">*</span>
            </td>
        </tr>
        <tr>
            <td width="26%"><strong>Password</strong></td>
            <td width="2%">:</td>
            <td width="72%"><input name="tpassword" type="password" id="password" size="20" maxLength="20">
                <span class="style2">*</span>
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><input name="upload" type="submit" class="box" id="upload" value="Submit"></td>
        </tr>
        <tr>
            <td><a href="index.php">Kembali ke Index</a></td>
        </tr>
    </table>
</form>
</body>
</html>
