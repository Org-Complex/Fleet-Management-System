<html>
<?php include '../partials/head.php';

use Employee\Factory\Privileged\PrivilegedEmployeeFactory;
use UI\HTMLBuilder;

session_start();
if (!isset($_SESSION['empid']) or !isset($_SESSION['position']) or $_SESSION['position'] != 'admin') {
    header("Location: login.php");
    exit();
}
require_once '../includes/autoloader.inc.php';
$uiBuilder = HTMLBuilder::getInstance();
$employee = PrivilegedEmployeeFactory::makeEmployee($_SESSION['empid']);
$_SESSION['employee'] = $employee;
$employees = $employee->getAllPriviledgedEmployees();
// $drivers = $employee->getAllDrivers();
$drivers = [];


?>

<body id="page-top">
    <?php
    $uiBuilder
        ->createMainNavBar($employee,[])
        ->createPsd(['My Requests'=>['Pending Requests', 'Ongoing Requests', 'History'], 'Awaiting Requests'=>['Assign Requests', 'Ongoing Trips', 'Scheduled History'], 'Database'=>['Vehicles', 'Drivers']])
        ->createSecondaryNavBar('AdminSecTab',['Employees', 'Drivers'])
        ->employees($employees)
        ->drivers($drivers)
        ->buildSecTabBody(['Employees', 'Drivers'])
        ->createMainNavHierachy([])
        ->show();
    ?>
    <?php
    include '../partials/footer.php';
    include '../partials/popups/admin_popup.php';
    include '../partials/popups/template.php';
    ?>
    <script>
        const employees = <?php echo json_encode($employees) ?>;
        console.log(employees);
        const drivers = <?php echo json_encode($drivers) ?>;
    </script>
    <script>
    $('.menu-toggle').click(function() {
        $(".psd").toggleClass("psd-animate");
        // $("#psd").slideUp();
        console.log("Clicked");


    });
    $('#close-button').click(function() {
        $(".psd").toggleClass("psd-animate");


    });
</script>
    <script src="../js/classes.js"></script>
    <script src="../js/redux.js"></script>
    <script src="../js/functions.js"></script>
    <script src="../js/eventlisteners/admin.js"></script>
</body>

</html>