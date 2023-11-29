<?php
require_once("inc/header.php");
require_once("inc/navigation.php");

if (isset($_GET['HomePage'])) {
    require_once("../homePage.php");
} 
elseif (isset($_GET['logoutPage'])) {
    require_once("../admin/logout.php");
}
else if (isset($_GET["viewResults"])) {
    require_once("../viewResults.php");
}
else if (isset($_GET["CasteVote"])) {
    require_once("inc/CasteVote.php");
}

?>



<?php
    require_once("inc/footer.php");
?>