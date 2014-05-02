<?php
#including our init.php
require 'core/init.php';
$obj_general->logged_out_protect();

# Create the resource, while form submitted.
if (empty($_POST) === false) {
    $bool_resource_created = $obj_resources->add_resource($_POST);
}

# Get the resources list
$arr_resources = $obj_resources->get_resources();

$str_page = 'resources';
?>


<?php include 'partials/header.php'; ?>
<?php include 'partials/navbar.php' ?>

    <div id="page-wrapper">
    <div class="row">
    <div class="col-md-12">
    <div class="col-md-12">
    <li class="dropdown list-unstyled pull-right mt30">
        <a class="dropdown-toggle btn btn-primary" data-toggle="dropdown" href="#">
            <i class="fa fa-plus fa-fw"></i> New Resource <i class="fa fa-caret-down"></i>
        </a>
        <ul class="dropdown-menu dropdown-user">
            <li><a href="#" data-toggle="modal" data-target="#human_resource_modal">Teacher</a></li>
            <li><a href="#" data-toggle="modal" data-target="#room_modal">Room</a></li>
            <li><a href="#" data-toggle="modal" data-target="#miscellaneous_modal">Miscellaneous</a></li>
            <li><a href="#" data-toggle="modal" data-target="#vehicle_modal">Vehicle</a></li>
        </ul>
        <!-- /.dropdown-user -->
    </li>
    <!-- /.dropdown -->

    <!-- Modal for teacher  -->
    <div class="modal fade" id="human_resource_modal" tabindex="-1" role="dialog"
         aria-labelledby="human_resource_modal_label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form enctype="multipart/form-data" action="" method="post">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"
                                aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="human_resource_modal_label">New Teacher</h4>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-md-7">
                                <div class="row">
                                    <div class="col-md-4"><h5>First Name</h5></div>
                                    <div class="col-md-8"><input type="text" class="form-control"
                                                                 name="first_name"/></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4"><h5>Last Name</h5></div>
                                    <div class="col-md-8"><input type="text" class="form-control"
                                                                 name="last_name"/></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4"><h5>Job Title</h5></div>
                                    <div class="col-md-8">
                                        <select name="job_title" class="form-control">
                                            <option value="Professor">Professor</option>
                                            <option value="Assistant Professor">Assistant Professor</option>
                                            <option value="Senior Lecturer">Senior Lecturer</option>
                                            <option value="Lecturer">Lecturer</option>
                                        </select></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-8">
                                        <div class="checkbox text-left">
                                            <label>
                                                <input type="checkbox" name="invite_this_person" checked>
                                                Invite this person to join
                                            </label>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-5">
                                <div class="thumbnail">
                                    <img src="images/person-placeholder.jpg"
                                         class="img-responsive person-placeholder-image" alt=""/>
                                    <input type="file" name="photo">
                                </div>
                            </div>
                        </div>
                        <div class="row no-hr-margin">
                            <div class="col-md-4 text-right"><h5>Email</h5></div>
                            <div class="col-md-8">
                                <input type="email" class="form-control" name="email"/>
                            </div>
                        </div>
                        <div class="row no-hr-margin">
                            <div class="col-md-4 text-right"><h5>Contact Number</h5></div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="contact_number"/>
                            </div>
                        </div>
                        <div class="row no-hr-margin">
                            <div class="col-md-4 text-right"><h5>Normal Availability</h5></div>
                            <div class="col-md-8">
                                <h6>Weekly total: 40h <a href="#">show / edit</a></h6>
                            </div>
                        </div>
                        <div class="row no-hr-margin">
                            <div class="col-md-4 text-right"><p>Bookable</p></div>
                            <div class="col-md-8">
                                <input type="checkbox" name="bookable" checked/>
                            </div>
                        </div>
                        <div class="row no-hr-margin">
                            <div class="col-md-4 text-right"><h5>Notes</h5></div>
                            <div class="col-md-8">
                                <textarea name="note" class="form-control"
                                          rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <input type="hidden" name="type" value="human"/>
                        <input type="submit" class="btn btn-primary" value="Add Resource"/>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /Modal  -->

    <!-- Modal for Room  -->
    <div class="modal fade" id="room_modal" tabindex="-1" role="dialog" aria-labelledby="room_modal_label"
         aria-hidden="true">
        <div class="modal-dialog">
            <form enctype="multipart/form-data" action="" method="post">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"
                                aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="room_modal_label">New Room</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row no-hr-margin">
                            <div class="col-md-4 text-right"><h5>Name</h5></div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="name"/>
                            </div>
                        </div>
                        <div class="row no-hr-margin">
                            <div class="col-md-4 text-right"><h5>Photo</h5></div>
                            <div class="col-md-8 mt10">
                                <input type="file" name="photo">
                            </div>
                        </div>
                        <div class="row no-hr-margin">
                            <div class="col-md-4 text-right"><h5>Normal Availability</h5></div>
                            <div class="col-md-8">
                                <h6>Weekly total: 40h <a href="#">show / edit</a></h6>
                            </div>
                        </div>
                        <div class="row no-hr-margin">
                            <div class="col-md-4 text-right"><p>Bookable</p></div>
                            <div class="col-md-8">
                                <p><input type="checkbox" name="bookable" checked/></p>
                            </div>
                        </div>
                        <div class="row no-hr-margin">
                            <div class="col-md-4 text-right"><h5>Capacity</h5></div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="capacity"/>
                            </div>
                        </div>
                        <div class="row no-hr-margin">
                            <div class="col-md-4 text-right"><h5>Notes</h5></div>
                            <div class="col-md-8">
                                <textarea name="note" class="form-control" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <input type="hidden" name="type" value="room"/>
                        <input type="submit" class="btn btn-primary" value="Add Resource"/>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- /Modal  -->

    <!-- Modal for Miscellaneous  -->
    <div class="modal fade" id="miscellaneous_modal" tabindex="-1" role="dialog"
         aria-labelledby="miscellaneous_modal_label"
         aria-hidden="true">
        <div class="modal-dialog">
            <form enctype="multipart/form-data" action="" method="post">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"
                                aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="room_modal_label">Miscellaneous</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row no-hr-margin">
                            <div class="col-md-4 text-right"><h5>Name</h5></div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="name"/>
                            </div>
                        </div>
                        <div class="row no-hr-margin">
                            <div class="col-md-4 text-right"><h5>Photo</h5></div>
                            <div class="col-md-8 mt10">
                                <input type="file" name="photo">
                            </div>
                        </div>
                        <div class="row no-hr-margin">
                            <div class="col-md-4 text-right"><h5>Normal Availability</h5></div>
                            <div class="col-md-8">
                                <h6>Weekly total: 40h <a href="#">show / edit</a></h6>
                            </div>
                        </div>
                        <div class="row no-hr-margin">
                            <div class="col-md-4 text-right"><p>Bookable</p></div>
                            <div class="col-md-8">
                                <p><input type="checkbox" name="bookable" checked/></p>
                            </div>
                        </div>
                        <div class="row no-hr-margin">
                            <div class="col-md-4 text-right"><h5>Notes</h5></div>
                            <div class="col-md-8">
                                <textarea name="note" class="form-control" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <input type="hidden" name="type" value="miscellaneous"/>
                        <input type="submit" class="btn btn-primary" value="Add Resource"/>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- /Modal  -->

    <!-- Modal for Vehicle  -->
    <div class="modal fade" id="vehicle_modal" tabindex="-1" role="dialog" aria-labelledby="vehicle_modal_label"
         aria-hidden="true">
        <div class="modal-dialog">
            <form enctype="multipart/form-data" action="" method="post">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"
                                aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="room_modal_label">Vehicle</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row no-hr-margin">
                            <div class="col-md-4 text-right"><h5>Name</h5></div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="name"/>
                            </div>
                        </div>
                        <div class="row no-hr-margin">
                            <div class="col-md-4 text-right"><h5>Photo</h5></div>
                            <div class="col-md-8 mt10">
                                <input type="file" name="photo">
                            </div>
                        </div>
                        <div class="row no-hr-margin">
                            <div class="col-md-4 text-right"><h5>Normal Availability</h5></div>
                            <div class="col-md-8">
                                <h6>Weekly total: 40h <a href="#">show / edit</a></h6>
                            </div>
                        </div>
                        <div class="row no-hr-margin">
                            <div class="col-md-4 text-right"><p>Bookable</p></div>
                            <div class="col-md-8">
                                <p><input type="checkbox" name="bookable" checked/></p>
                            </div>
                        </div>
                        <div class="row no-hr-margin mb10">
                            <div class="col-md-4 text-right"><h5>Registration Number</h5></div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="registration_number"/>
                            </div>
                        </div>
                        <div class="row no-hr-margin">
                            <div class="col-md-4 text-right"><h5>Notes</h5></div>
                            <div class="col-md-8">
                                <textarea name="note" class="form-control" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <input type="hidden" name="type" value="vehicle"/>
                        <input type="submit" class="btn btn-primary" value="Add Resource"/>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- /Modal  -->


    </div>
    </div>
    <!-- /.col-md-12 -->
    </div>
    <!-- /.row -->

    <div class="row mt50">
        <div class="container">

<!--            <div class="col-md-12 mt30">-->
<!--                <p class="subtitle fancy"><span>B</span></p>-->
<!--            </div>-->

            <?php
            //echo '<pre>';
            //print_r($arr_resources[0]);
            echo '<ul class="resource-list list-unstyled list-inline col-md-12 mt30">';
            foreach ($arr_resources as $int_index => $arr_resource_details) {
                if($int_index % 4 == 0) {
                    echo '</ul>';
                    echo '<ul class="resource-list list-unstyled list-inline col-md-12 mt30">';
                }

                $str_name = $arr_resource_details['name'];
                $str_description = ($arr_resource_details['type'] == 'human') ? $arr_resource_details['job_title']  : $arr_resource_details['type'];
                echo '<li class="col-md-3">
                        <div class="col-md-12 single-resource">
                            <div class="col-md-3 no-hr-padding">
                                <img src="images/' . $arr_resource_details['photo'] . '" class="center-block" alt=""/>
                            </div>
                            <div class="col-md-9 hr-padding-5">
                                <h5>' . $str_name . '</h5>
                                <h6>' . $str_description . '</h6>
                            </div>
                        </div>
                      </li>';
            }
            echo '</ul>';
            ?>

        </div>
    </div>
    </div>
    <!-- /#page-wrapper -->
<?php include 'partials/footer.php' ?>