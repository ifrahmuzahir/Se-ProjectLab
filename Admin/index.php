<?php
    require_once("inc/header.php");
    require_once("inc/navigation.php");

    if(isset($_GET['addElectionPage']))
    {
        require_once("inc\addElection.php");
    }
    elseif(isset($_GET['addCandidatePage']))
    {
        require_once("inc\addCandidate.php");
    }
    elseif(isset($_GET['addPartyPage']))
    {
        require_once("inc\addParty.php");
    }
    elseif(isset($_GET['addHomePage']))
    {
        require_once("inc\homePage.php");
    }
    elseif(isset($_GET['logoutPage']))
    {
        require_once("logout.php");
    }
?>

<?php
    require_once("inc/footer.php");
?>