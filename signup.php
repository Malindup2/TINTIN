<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    /**
     * User Registration Page
     * Sign up form for new user account creation
     */
    ?>
    <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css" />
    <link href="https://fonts.googleapis.com/css?family=Amaranth&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Alata&display=swap" rel="stylesheet">
    <script src="js/jquery-2.1.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/login.css">
 
</head>
<body>
    <!-- Back to Home Button -->
    <a href="index.php" class="back-home">
        <i class="fa fa-arrow-left"></i> Back to Home
    </a>

    <div class="cont">
        <form method="POST" action="login_process.php">
            <div class="form sign-in">
                <h2>Welcome back,</h2>
                <label>
                    <span>Email</span>
                    <input name="email" type="email" required />
                </label>
                <label>
                    <span>Password</span>
                    <input name="password" type="password" required autocomplete="off" />
                </label>
                <button type="submit" class="submit">Sign In</button>
                <button type="button" class="fb-btn"><a href="staff_login.php">Staff Login</a></button>
            </div>
        </form>

        <div class="sub-cont">
            <div class="img">
                <div class="img__text m--up">
                    <h2>New here?</h2>
                    <p>Sign up and discover the best deals there are!</p>
                </div>
                <div class="img__text m--in">
                    <h2>One of us?</h2>
                    <p>If you already have an account, just sign in. We've missed you!</p>
                </div>
                <div class="img__btn">
                    <span class="m--up">Sign Up</span>
                    <span class="m--in">Sign In</span>
                </div>
            </div>

            <form method="POST" action="signup_process.php">
                <div class="form sign-up">
                    <h2>Join With Us</h2>
                    <label>
                        <span>Name</span>
                        <input name="username" type="text" pattern="[A-Za-z\s]+"  />
                    </label>
                    <label>
                        <span>Email</span>
                        <input name="email" type="email" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}" title="Please enter a valid email address (e.g., name@example.com)"  required />
                    </label>
                    <label>
                        <span>Password</span>
                        <input name="password" type="password" />
                    </label>
                    <button type="submit" class="submit">Sign Up</button>
                    
                </div>
            </form>
        </div>
    </div>

    <script>
      document.addEventListener('DOMContentLoaded', () => {
            const spanToClick = document.querySelector('.img__btn .m--up');
            if (spanToClick) {
                spanToClick.click(); 
            }
        });
        document.querySelector('.img__btn').addEventListener('click', function () {
            document.querySelector('.cont').classList.toggle('s--signup');
        });
    </script>
</body>
</html>
