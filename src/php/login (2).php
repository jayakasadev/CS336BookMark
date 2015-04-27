<html>
<body>
<?php session_destroy();  ?>
login
<form method="POST" action="home.php">
<input type="text" name="user"/>
<input type="password" name="pass"/>
<input type="submit" value="login" />



</form>
register
<form method="POST" action="register.php">
<br>
Username<input type="text" name="user"/><br>
Password <input type="password" name="pass"/><br>
First name<input type="text" name="first"/><br>
Last name <input type="text" name="last"/><br>
Email<input type="text" name="email"/><br>
University<input type="text" name="universityname"/><br>

<input type="submit" value="register" />



</form>
</body>
</html>

