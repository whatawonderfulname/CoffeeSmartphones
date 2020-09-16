<?php
    ob_start();
    session_start();

    include "../../../../services/main.php";
    include "../../../../services/database_connection.php";

    adminCheck();

    if 
    (count($_GET) !== 1 
    || ! (isset($_GET["ban"]) || isset($_GET["unban"]))) 
    {
        goToIndex();
    }
    
    if (isset($_GET["ban"])) {
        $action = "ban";
        $color = "danger";
    } elseif (isset($_GET["unban"])) {
        $action = "unban";
        $color = "success";
    }
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <?php include "../../../../view/head.php"; ?>
</head>
<body class="d-flex flex-column justify-content-between min-vh-100">
    <div>
        <?php include "../../../../view/navbar.php"; ?>
        <main class="container my-5">
<?php
    $sql = "select * from `user`";
    $result = $connection->query($sql);
    $connection->close();
    $rows = $result->fetch_all(MYSQLI_ASSOC);
    $table = [];

    // create a table users that can be banned / unbanned
    function addToTable($boolean) {
        global $rows;
        global $table;

        for ($i = 0; $i < count($rows); $i++) {
            if ($rows[$i]["status"] == $boolean) {
                array_push($table, $rows[$i]);
            }
        }
    }

    if ($action == "ban") {
        addToTable(true);
    } elseif ($action == "unban") {
        addToTable(false);
    }

    if (empty($table)) {
?>
            <h5 class="myH5">There are no users to <?php echo $action; ?>.</h5>
<?php
    } else {
?>
            <h3 class="text-center mb-5 mb-md-4 myH3">User List</h3>
            <div class="row">
                <div class="col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-4 offset-lg-4 p-0 rounded border border-secondary">
<?php
    for ($i = 0; $i < count($table); $i++) {
        $class = "";
        if ($i == 0) {
            $class .= "firstCell ";
        }

        if ($i == count($table) - 1) {
            $class .= "lastCell";
        }
        
        echo '
                    <div class="d-flex justify-content-between p-3 border border-secondary ' . $class . '">
                        <p class="myP">' . $table[$i]["name"] . '</p>
                        <a href="ban_unban_confirm.php?' . $action . '&&id=' . $table[$i]["id"] . '" class="btn btn-' . $color . ' myP">' . ucwords($action) . '</a>
                    </div>
        ';
    }
?>
                </div>
            </div>
<?php  
    }
?>
        </main>
    </div>
    <?php include "../../../../view/footer.php"; ?>
  
    <?php echo $scripts; ?>
    <script src="../../../../ajax/navbar.js"></script>
</body>
</html>

<?php ob_end_flush(); ?>
