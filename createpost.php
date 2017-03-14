<?php
session_start();
?>
<html>
    <head>
        <Title>Create a Post</Title>
        <link rel="stylesheet" type="text/css" href="bootstrap.css" />
    </head>

    <body>
        <div class="bs" style="margin-left:2em; margin-right:2em;">
            <?php
            require_once('connectvars.php');
            // Check the CAPTCHA pass-phrase for verification
            $user_pass_phrase = sha1($_POST['verify']);
            if ($_SESSION['pass_phrase'] == $user_pass_phrase)
            {
                if (isset($_POST['submit']))
                {
                    // Connect to the database
                    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
                    $username = mysqli_real_escape_string($dbc, trim($_POST['username']));
                    $description = mysqli_real_escape_string($dbc, trim($_POST['description']));
                    $activity = mysqli_real_escape_string($dbc, trim($_POST['activity']));
                    $datetime = date('Y-m-d', strtotime($olddate));
                    //Debug echoes
                    //echo "Parameters received!<br />";
                    //echo 'Username: ' . $username . '<br />';
                    //echo 'Description: ' . $description . '<br />';
                    //echo 'Activity: ' . $activity . '<br />';
                    $query = "INSERT INTO lfg_posts (activity, username, message, datetime_added)" .
                    "VALUES ('" . $activity . "', '" . $username . "', '" . $description .
                    "', NOW())";

                    $result = mysqli_query($dbc, $query)
                    or die("Error inserting into database.");

                    // Truncate the Table to 20 entries
                    $query = 'SELECT username, activity, datetime_added, message, id FROM lfg_posts ORDER BY datetime_added ASC';
                    //echo $query;
                    $result = mysqli_query($dbc, $query) or die('this failed');
                    $rowcount =  $result->num_rows;
                    if ($rowcount > DB_MAX_SIZE)
                    {
                        while ($row = mysqli_fetch_array($result))
                        {
                            if ($rowcount > DB_MAX_SIZE)
                            {
                                $query = "DELETE FROM lfg_posts WHERE ID = '" . $row['id'] . "'";
                                mysqli_query($dbc, $query)
                                or die("Error deleting from database.");
                                $rowcount --;
                                //echo $rowcount;
                            }
                            else
                            {
                                break;
                            }
                        }

                    }

                    echo 'Post Successfully Submitted!<br />';
                    echo '<a href="index.php">Back to the Ticker</a>';
                }

                ?>

                <!--<h3>Post Successfully Submitted!</h3>
                <a href="index.php">Back to the Ticker</a>-->


                <?php

            }
            else
            {
                if (isset($_POST['submit']))
                {
                    echo '<p class="error">Please enter the verification pass-phrase exactly as shown.</p>';
                }
                ?>
            <h3>Create a Post</h3>
            <form id="newform" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <table class="bs">
                    <tr>
                        <td style="width:10em">
                            <label for="username">Username:</label>
                        </td>
                        <td style="width:225px">
                            <input type="Text" id="username" name="username" value="" /><br />
                        </td>
                    </tr>
                    <tr>
                        <td style="width:10em">
                            <label for="activity">Activity:</label>
                        </td>
                        <td style="width:15em">
                            <select id="activity" name="activity" style="width:192px">
                                <option value="Framing Frame">Framing Frame</option>
                                <option value="Vault of Glass">Vault of Glass</option>
                                <option value="Crystal Tower">Crystal Tower</option>
                                <option value="Icecrown Citadel">Icecrown Citadel</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td style="width:10em">
                            <label for="username">Message:</label>
                        </td>
                        <td style="width:15em">
                            <textarea type="Text" id="description" name="description" value=""></textarea><br />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="verify">Verification: </label>
                            </td><td>
                            <input type="text" id="verify" name="verify" value="Enter the pass-phrase" />
                            <img src="captcha.php" alt="Verification pass-phrase" />
                            <hr />
                        </td>

                    </tr>
                    <tr>
                        <td>
                            <input type="submit" value="Submit" name="submit" ></input>
                        </td>
                    </tr>

                </table>
            </form>
            <?php
            }
            ?>
        </div>
    </body>
</html>