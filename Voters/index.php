<?php
require_once("inc/header.php");
require_once("inc/navigation.php");

if (isset($_GET['HomePage'])) {
    require_once("inc/homePage.php");
} elseif (isset($_GET['logoutPage'])) {
    require_once("../admin/logout.php");
}
else if (isset($_GET["viewResultsPage"])) {
    require_once("inc/viewResults.php");
}


?>



<?php
    require_once("inc/footer.php");
?>