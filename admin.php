<?php
#including our init.php
require 'core/init.php';
$obj_general->logged_out_protect();

$arr_user = $obj_users->userdata($_SESSION['id']);
$bln_is_admin = $obj_general->is_admin($arr_user);
$bln_is_moderator = $obj_general->is_moderator($arr_user);

if (!$bln_is_admin) {
    exit();
}


$str_full_name = $arr_user['first_name'] . ' ' . $arr_user['last_name'];

$str_page = 'dashboard';

# Change Booking Status
if (isset($_GET['booking_status']) && $_GET['booking_id']) {
    $bool_booking_status_changed = $obj_bookings->change_booking_status($_GET);
}

# Get all bookings list including pending, approved, rejected and canceled.
$arr_bookings = $obj_bookings->get_all_bookings('pending');

?>

<?php include 'partials/header.php'; ?>
<?php include 'partials/navbar.php' ?>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default dashboard-summary-panel">
                <div class="panel-heading">
                    <h4>Admin's Dashboard</h4>
                </div>
                <div class="panel-body">
                    <?php include 'partials/admin_booking_list.php' ?>
                </div>
            </div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>
<!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->
<?php include 'partials/footer.php' ?>
