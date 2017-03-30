<?php
$dbhost = "localhost";
$dbuser = "root";
$dbpassword = "";
$dbname = "mathprobdb";

$con = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname);

if (!$con) {
    die('Could not connect: ' . mysqli_error($con));
}

$probIdArr = array();
$probContArr = array();
$catIdArr = array();
$catNameArr = array();

if(isset($_POST['problem'])) {
    $prob = $_POST['problem'];
    if($prob != "" || $prob != null) {
        $query = "INSERT INTO problem VALUES (DEFAULT, '$prob')";
        if (mysqli_query($con, $query)) {
            echo "New problem created successfully";
        } else {
            echo "Error: " . $query . "<br>" . mysqli_error($con);
        }
    }
    else
        echo "Please enter a problem to add.";
}

if(isset($_POST['categoryVal'])) {
    $cat = $_POST['categoryVal'];
    $query = "INSERT INTO category VALUES (DEFAULT, '$cat')";
    mysqli_query($con, $query);
}

if(isset($_POST['idProblem'])) {
    $r = $_POST['idProblem'];
    $newProb = addslashes($_POST['prob']);
    $query = "UPDATE problem SET content='$newProb' WHERE pid='$r'";
    if (mysqli_query($con, $query)) {
        echo "Problem #" . $r . " successfully updated.";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($con);
    }
}

if(isset($_POST['dropCatId'])) {
    $catNum = $_POST['dropCatId'];
    $probNum = $_POST['dropProbId'];
    if($catNum != "" || $catNum != 0)  {
        $query = "SELECT * FROM prob_cat_mapping WHERE problem_id='$probNum' AND category_id='$catNum'";
        $maps = mysqli_query($con, $query);
        if(mysqli_num_rows($maps)==0){
            $query = "INSERT INTO prob_cat_mapping VALUES (DEFAULT, '$probNum', '$catNum')";
            if(mysqli_query($con, $query))  {
                echo "The category was successfully added to problem #" . $probNum . ".";
            } else  {
                echo "Error: " . $query . "<br>" . mysqli_error($con);
            }
        } else  {
            echo "Problem #" . $probNum . " already belongs to the selected category.";
        }
    } else  {
        echo "Please select a valid category.";
    }
}

if(isset($_POST['idCategory'])) {
    $r = $_POST['idCategory'];
    if(isset($_POST['sort'])) {
        $query = "SELECT pid, content FROM problem,
                  (SELECT * FROM prob_cat_mapping WHERE category_id='$r') AS C
                  WHERE pid=problem_id ORDER BY pid DESC";
        $result = mysqli_query($con, $query);

        while ($row = mysqli_fetch_assoc($result)) {
            $probIdArr[] = $row['pid'];
            $probContArr[] = $row['content'];
        }
    } else  {
        $newCat = $_POST['cat'];
        $query = "UPDATE category SET name='$newCat' WHERE cid='$r'";
        if (mysqli_query($con, $query)) {
            echo "Category successfully updated.";
        } else {
            echo "Error: " . $query . "<br>" . mysqli_error($con);
        }
        $query = "SELECT pid, content FROM problem ORDER BY pid DESC";

        $result = mysqli_query($con, $query);

        while ($row = mysqli_fetch_assoc($result)) {
            $probIdArr[] = $row['pid'];
            $probContArr[] = $row['content'];
        }
    }
}   else    {
    $query = "SELECT pid, content FROM problem ORDER BY pid DESC";

    $result = mysqli_query($con, $query);

    while ($row = mysqli_fetch_assoc($result)) {
        $probIdArr[] = $row['pid'];
        $probContArr[] = $row['content'];
    }
}

$query = "SELECT cid, name FROM category ORDER BY cid DESC";

$result = mysqli_query($con, $query);

if($result != null) {
    while ($row = mysqli_fetch_assoc($result)) {
        $catIdArr[] = $row['cid'];
        $catNameArr[] = $row['name'];
    }
}
?>
