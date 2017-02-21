
<?php 
include_once 'mysqli_connect.php';
    //$id = $_GET['id']; // ID of entry you wish to view.  To use this enter "view.php?id=x" where x is the entry you wish to view. 

    $query = "SELECT content,type FROM Upload"; //Find the file, pull the filecontents and the filetype
    $result = @mysqli_query($dbc,$query);    // run the query

    if($row=mysqli_fetch_row($result)) // pull the first row of the result into an array(there will only be one)
    {
        $data = $row[0];    // First bit is the data
        $type = $row[1];    // second is the filename

        header('Content-type: application/doc');
        //Header( "Content-type: $type"); // Send the header of the approptiate file type, if it's' a image you want it to show as one :)
        print $data; // Send the data.
    }
    else // the id was invalid
    {
        echo "invalid id";
    }
?>