<html>
    <head>
        <br />
        <Title>LFG Ticker</Title>
        <!-- Bootstrap Resources -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha/css/bootstrap.min.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha/js/bootstrap.min.js"></script>

    </head>

    <body>

        <div class="bs" style="margin-left:2em; margin-right:2em;">
            <h3>LFG Ticker</h3>Built by Shea Prewett using PHP
            <table class="table">
                <tr>

                    <td>
                        <div class="form-group">
                            <form id="filterform" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <select name="activity" class="form-control selectpicker">
                            <option value="any">Any Level</option>
                            <option value="Framing Frame">Framing Frame</option>
                            <option value="Vault of Glass">Vault of Glass</option>
                            <option value="Crystal Tower">Crystal Tower</option>
                            <option value="Icecrown Citadel">Icecrown Citadel</option>

                        </select>
                        <input type="submit" value="Submit" name="submit" ></input>
                        </form>
                        </div>
                    </td>

                    <td><a href="createpost.php">Create a Post!</a></td>

                </tr>
            </table>

            <table class="table">
                <?php
                 if (isset($_POST['submit']) && isset($_POST['activity']) && $_POST['activity'] != 'any') 
                 {
                    $query = "SELECT username, activity, datetime_added, message, id FROM lfg_posts WHERE activity ='" .
                    $_POST['activity'] . "' ORDER BY datetime_added DESC LIMIT 20";
                 } 
                 else 
                 {
                    $query = 'SELECT username, activity, datetime_added, message, id FROM lfg_posts ORDER BY datetime_added DESC LIMIT 20';
                 }
                    require_once('connectvars.php');
                    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

                    $result = mysqli_query($dbc, $query);

                    if (mysqli_num_rows($result) > 0) 
                    {
                        while ($row = mysqli_fetch_array($result)) 
                        {
                            $time = strtotime($row['datetime_added']);
                            echo '<thead class="thead-inverse">';
                            echo '<tr><th colspan="2">Looking For Group</th><th></th></tr>';
                            echo '</thead>';
                            echo '<tbody>';
                            echo '<tr><td>Level: ' . $row['activity'];
                            echo '</td><td>Username: <a href="http://steamcommunity.com/search/?text=' .
                            $row['username'] . '&x=0&y=0#filter=users&text=' .
                            $row['username'] .  '">' . $row['username'];
                            echo '</a></td><td>Added: ' . humanTiming($time) . ' ago' . 
                            '</td><tr>';
                            echo '<tr><td colspan="3">' . $row['message'] . '</td></tr>';
                            echo '</tbody></table><table class="table"> ';

                        }
                    }
                    else 
                    {
                        echo '<tr><td colspan="2">No Posts Found!</td><td></td></tr>';
                        echo '<tr><td>We may be experiencing technical issues.</td><tr>';
                    }
                    
                    function humanTiming ($time)
                        {
                        
                            $time = time() - $time; // to get the time since that moment
                            $time = ($time<1)? 1 : $time;
                            $tokens = array (
                                31536000 => 'year',
                                2592000 => 'month',
                                604800 => 'week',
                                86400 => 'day',
                                3600 => 'hour',
                                60 => 'minute',
                                1 => 'second'
                            );
                        
                            foreach ($tokens as $unit => $text) 
                            {
                                if ($time < $unit) continue;
                                $numberOfUnits = floor($time / $unit);
                                return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');
                            }
                        }

                    ?>

            </table>
            <a href="admin.php"><button type="button">Admin</button></a>
        </div>
    </body>

</html>