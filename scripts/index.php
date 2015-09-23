<html>
<head>
    <Title>Registration Form</Title>
    <style type="text/css">
    body { background-color: #fff; border-top: solid 10px #000;
        color: #333; font-size: .85em; margin: 20; padding: 20;
        font-family: "Segoe UI", Verdana, Helvetica, Sans-Serif;
    }
    h1, h2, h3,{ color: #000; margin-bottom: 0; padding-bottom: 0; }
    h1 { font-size: 2em; }
    h2 { font-size: 1.75em; }
    h3 { font-size: 1.2em; }
    table { margin-top: 0.75em; }
    th { font-size: 1.2em; text-align: left; border: none; padding-left: 0; }
    td { padding: 0.25em 2em 0.25em 0em; border: 0 none; }
    </style>
</head>
<body>
    <h1>Register here!</h1>
    <p>Fill in your name and email address, then click <strong>Submit</strong> to register.</p>
    <form method="post" action="index.php" enctype="multipart/form-data" >
        Name  <input type="text" name="sessionID" id="name"/></br>
        <input type="submit" name="submit" value="Submit" />
    </form>
    <?php
    /*
    * This function will retrieve the next song that the DJ is currently listening to and the
    * listener will hear next.
    */

    $response = array();

    if(isset($_POST['sessionID']))
    {
        $sessionID = $_POST['sessionID'];

        //Connect to db, because abstraction is for pussies.
        require_once __DIR__ . '/db_config.php';
        $db = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE, DB_PORT) or die(mysqli_error());

        $result = mysqli_query($db, "SELECT songHash FROM dj WHERE sessionID = " + $sessionID + ";");

        if (!empty($result))
        {
            // check for empty result
            if (mysqli_num_rows($result) > 0)
            {
                $result = mysqli_fetch_array($result);
                $profile = array();
                $profile["songHash"] = $result["songHash"];
                $response["next"] = array();
                array_push($response["next"], $profile);
                echo json_encode($response);
            }
        }
        mysqli_close($db);
    }
    ?>
</body>
</html>
