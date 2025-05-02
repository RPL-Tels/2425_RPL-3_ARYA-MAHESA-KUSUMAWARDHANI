<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,
    initial-scale=1.0">
    <title>admin</title>
    <style>*{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    text-decoration: none;
    border: none;
    outline: none;
    scroll-behavior: smooth;
    font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif
}

:root {
  --bg-color: #FAF3E0;       /* Warm Beige */
  --primary-color: #C8B6A6;  /* Muted Brown */
  --accent-color: #A98467;   /* Earthy Taupe */
  --text-color: #3E3E3E;     /* Dark Charcoal */
  --light-text: #FFFFFF;     /* White for contrast */
  --input-bg: #EEEEEE;       /* Light gray for input backgrounds */
  --shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  text-decoration: none;
  border: none;
  outline: none;
  scroll-behavior: smooth;
  font-family: 'Montserrat', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
}

body {
  background-color: var(--bg-color);
  color: var(--text-color);
}

.login {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  padding: 20px;
}

.login-box {
  background-color: var(--light-text);
  padding: 40px;
  border-radius: 20px;
  box-shadow: var(--shadow);
  width: 100%;
  max-width: 500px;
  border: 1px solid var(--primary-color);
}

.login-box h1 {
  font: 700 48px/1.23 Montserrat, Helvetica, Arial, serif;
  text-align: center;
  padding-bottom: 30px;
  color: var(--text-color);
  text-shadow: var(--shadow);
}

.login-box input {
  width: 100%;
  height: 50px;
  padding: 0 20px;
  margin-bottom: 20px;
  border-radius: 10px;
  border: 1px solid var(--primary-color);
  background-color: var(--input-bg);
  color: var(--text-color);
  font-size: 16px;
  transition: all 0.3s ease;
}

.login-box input::placeholder {
  color: rgba(62, 62, 62, 0.5);
}

.login-box input:focus {
  border: 2px solid var(--accent-color);
  box-shadow: 0 0 10px rgba(169, 132, 103, 0.3);
}

.login-box button {
  width: 100%;
  padding: 15px;
  background-color: var(--accent-color);
  font: 800 18px/1.2 Montserrat, Helvetica, Arial, serif;
  border-radius: 25px;
  color: var(--light-text);
  text-transform: uppercase;
  cursor: pointer;
  transition: all 0.3s ease;
  margin-top: 10px;
  border: none;
}

.login-box button:hover {
  transform: scale(1.05);
  box-shadow: 0 0 20px rgba(169, 132, 103, 0.4);
}

.h3 {
  text-align: center;
  margin-top: 20px;
  font-size: 16px;
  color: var(--text-color);
}

.login b {
  margin-right: 15px;
  color: var(--text-color);
}

/* Responsive adjustments */
@media (max-width: 768px) {
  .login-box {
    padding: 30px 20px;
  }
  
  .login-box h1 {
    font-size: 36px;
  }
}

@media (max-width: 480px) {
  .login-box {
    padding: 25px 15px;
    border-radius: 15px;
  }
  
  .login-box h1 {
    font-size: 28px;
  }
  
  .login-box input {
    height: 45px;
    font-size: 14px;
  }
  
  .login-box button {
    padding: 12px;
    font-size: 16px;
  }
}
</style>

</head>
<body>
<form action="proses-login.php" method="POST">
    <div class ="login">
        <div class="login-box">
            <h1>LOGIN</h1>
            <form>

                <label for="admin"><b>username</b></label>
                <input type="text" placeholder="Name/Nickname. . ." name="nama" required>

                <div class="password">
                <label for="pass"><b>Password</b></label>
                <input type="password" placeholder="Enter Password" name="pass" required>
                <button type="submit" name="submit">login</button>
            </form>
        </div>
    </div>
</form>
</body>