<?php
require_once('authorize.php');
?>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="bootstrap.css" />
    </head>


<body>
<div class="container">
<h3>Admin Page - Remove Posts</h3>
<?php
echo '<p><a href="index.php">&lt;&lt; Back to home page</a></p>';
require_once('connectvars.php');

 // Connect to the database
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  // Retrieve the post data from MySQL
  $query = "SELECT * FROM lfg_posts ORDER BY datetime_added DESC";
  $data = mysqli_query($dbc, $query);

  // Loop through the array of score data, formatting it as HTML
  echo '<table class="table">';
  while ($row = mysqli_fetch_array($data))
  {
    // Display the score data
    echo '<theader><td>Title</td><td>Date</td><td>Body</td><td></td></theader>';
    echo '<tr class=""><td><strong>' . $row['username'] . '</strong></td>';
    echo '<td>' . $row['datetime_added'] . '</td>';
    echo '<td>' . $row['activity'] . '</td>';
    echo '<td><a href="remove_post.php?ID=' . $row['ID'] . '&amp;datetime_added='
        . $row['datetime_added'] . '&amp;username=' . $row['username'] . '&amp;activity='
        . $row['activity'] . '">  Remove</a>';


        echo '</td></tr>';

  }
  echo '</table>';

  mysqli_close($dbc);

?>
</div>
</body>
</html>