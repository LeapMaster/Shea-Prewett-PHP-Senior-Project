<?php
require_once('authorize.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>LFG - Remove a Post</title>
  <link rel="stylesheet" type="text/css" href="bootstrap.css" />
</head>
<body>
    <div class="container">
  <h2>LFG - Remove a Post</h2>
  
<?php
  require_once('connectvars.php');
  if (isset($_GET['ID']) && isset($_GET['datetime_added']) && isset($_GET['username']) && isset($_GET['activity'])) 
  {
    $ID = $_GET['ID'];
    $datetime_added = $_GET['datetime_added'];
    $username = $_GET['username'];
    $activity = $_GET['activity'];
  } 
  else if (isset($_POST['ID']) && isset($_POST['datetime_added']) && isset($_POST['username']))
  {
    // Grab the score data from the POST
    $ID = $_POST['ID'];
    $username = $_POST['username'];
    $datetime_added = $_POST['datetime_added'];
  }
  else
  {
    echo '<p class = "error">Sorry, no blog post was specified for removal.</p>';
  }
  //Double-check for submission approval
  if (isset($_POST['submit'])) 
  {
    if ($_POST['confirm'] == 'Yes') 
    {
      // Connect to the database
      $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME); 

      // Delete the post data from the database
      $query = "DELETE FROM lfg_posts WHERE ID = $ID LIMIT 1";
      mysqli_query($dbc, $query);
      mysqli_close($dbc);

      // Confirm success with the user
      echo '<p>The lfg post by "<b>' . $username . '</b>" posted at ' . $datetime_added . ' was successfully removed.';
    }
    else 
    {
      echo '<p class="error">The lfg post was not removed.</p>';
    }
}
  else if (isset($ID) && isset($username) && isset($datetime_added) && isset($activity)) 
  {
    
  echo '<p>Are you sure you want to delete the following lfg post?</p>';
  echo '<p><strong>Uesrname: </strong>' . $username . '<br /><strong>Datetime: </strong>' . $datetime_added .
    '<br /><strong>Activity: </strong>' . $activity . '</p>';
  echo '<form method="post" action="remove_post.php">';
  echo '<input type="radio" name="confirm" value="Yes" /> Yes ';
  echo '<input type="radio" name="confirm" value="No" checked="checked" /> No <br />';
  echo '<input type="submit" value="Submit" name="submit" />';
  echo '<input type="hIDden" name="ID" value="' . $ID . '" />';
  echo '<input type="hIDden" name="username" value="' . $username . '" />';
  echo '<input type="hIDden" name="datetime_added" value="' . $datetime_added . '" />';
  echo '</form>';
}
  
    echo '<p><a href="admin.php">&lt;&lt; Back to admin page</a></p>';
?>    
</div>
</body> 
</html>