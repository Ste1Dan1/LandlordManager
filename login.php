<html>
    <head>
        <meta charset="utf-8">
        <title>Welcome</title>
        <link href="./CSS/login.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
       
    </head>
    <body>
        <div class="login">

            <img src="images/Logo_Landlord_Manager.png" alt="LogoLLM">
            <h1>Login</h1>
            <form action="authenticate.php" method="post">
                <label for="username">
                    <i class="fas fa-user"></i>
                </label>
                <input type="text" name="username" placeholder="Username" id="username" required>
                <label for="password">
                    <i class="fas fa-lock"></i>
                </label>
                <input type="password" name="password" placeholder="Password" id="password" required>
                
                <input type="submit" value="Login">

                <a href="register.php">Registrieren</a>
                
                
            </form>
        </div>
    </body>
</html>