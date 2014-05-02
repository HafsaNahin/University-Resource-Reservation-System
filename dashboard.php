<?php
#including our init.php
require 'core/init.php';
$obj_general->logged_out_protect();

$arr_user = $obj_users->userdata($_SESSION['id']);
$bln_is_admin = $obj_general->is_admin($arr_user);
$bln_is_moderator = $obj_general->is_moderator($arr_user);
$bln_is_resource = $obj_general->is_resource($arr_user);

if ($bln_is_admin) {
    header('Location: admin.php');
}


$str_full_name = $arr_user['first_name'] . ' ' . $arr_user['last_name'];

$str_page = 'dashboard';

# Get approved bookings list.
$str_booking_time_category = (isset($_GET['bookings'])) ? $_GET['bookings'] : 'today';
$arr_bookings = $obj_bookings->get_user_booking($_SESSION['id'], 'approved', $str_booking_time_category);

if($bln_is_resource) {
    $arr_appointments = $arr_bookings = $obj_bookings->get_user_appointments($arr_user['resource_id'], 'pending');

}

?>

<?php include 'partials/header.php'; ?>
<?php include 'partials/navbar.php' ?>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default dashboard-summary-panel">
                <div class="panel-heading">
                    <h4><?php echo $str_full_name; ?>'s Bookings</h4>
                </div>
                <div class="panel-body no-hr-padding">
                    <div id="day_view">
                        <div class="col-md-12 text-center">
                            <div class="btn-group btn-group-lg">
                                <a class="btn btn-default <?php if ($str_booking_time_category == 'previous') echo 'active'; ?>"
                                   href="?bookings=previous">Previous</a>
                                <a class="btn btn-default <?php if ($str_booking_time_category == 'today') echo 'active'; ?>"
                                   href="?bookings=today"><?php echo date('D, d M Y') ?></a>
                                <a class="btn btn-default <?php if ($str_booking_time_category == 'upcoming') echo 'active'; ?>"
                                   href="?bookings=upcoming">Upcoming</a>
                            </div>
                        </div>
                        <div class="col-md-12 mt50">
                            <?php include 'partials/user_booking_list.php' ?>
                        </div>
                    </div>
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
