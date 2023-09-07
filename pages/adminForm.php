<?php
include('../routes/connect.php');
?>

 <link rel="stylesheet" href="../public/css/style.css">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<div class="container py-5">
    <!-- For demo purpose -->
    <div class="row mb-4">
        <div class="col-lg-8 mx-auto text-center">
            <h1 class="display-6" style="font-family:mountains">Admin Panel</h1>
        </div>
    </div> <!-- End -->
    <div class="row">
        <div class="col-lg-6 mx-auto">
            <div class="card ">
                <div class="card-header">
                    <div class="bg-white shadow-sm pt-4 pl-2 pr-2 pb-2">
                        <!-- Credit card form tabs -->
                        <ul role="tablist" style="font-family:mountains" class="nav bg-light nav-pills rounded nav-fill mb-3">
                            <li class="nav-item" > <a data-toggle="pill" href="#add-event" class="nav-link active"> <i
                                        class="fas fa-credit-card mr-2"></i> Add Event </a> </li>
                            <li class="nav-item"> <a data-toggle="pill" href="#edit-event" class="nav-link"> <i
                                        class="fab fa-paypal mr-2"></i> Edit Event </a> </li>
                            <li class="nav-item"> <a data-toggle="pill" href="#assign-cordinator" class="nav-link"> <i
                                        class="fab fa-paypal mr-2"></i> Assign Cordinator </a> </li>
                            <li class="nav-item"> <a data-toggle="pill" href="#edit-cordinator" class="nav-link"> <i
                                        class="fab fa-paypal mr-2"></i> Edit Cordinator </a> </li>
                            <li class="nav-item"> <a data-toggle="pill" href="#assign-house" class="nav-link"> <i
                                        class="fab fa-paypal mr-2"></i> Assign House Lead </a> </li>
                            <li class="nav-item"> <a data-toggle="pill" href="#edit-house" class="nav-link"> <i
                                        class="fab fa-paypal mr-2"></i> Edit House Lead </a> </li>
                        </ul>
                    </div> <!-- End -->
                    <!-- Credit card form content -->
                    <div class="tab-content">
                        <!-- credit card info-->
                        <div id="add-event" class="tab-pane fade show active pt-3">
                            <form role="form" action="../routes/admin/eventPost.php" method="post" enctype="multipart/form-data">
                                <div class="form-group"> <label for="event_name">
                                        <h6>Event Name</h6>
                                    </label> <input type="text" name="event_name" placeholder="Enter Event Name"
                                        required class="form-control ">
                                </div>
                                <div class="form-group"> <label for="event_id">
                                        <h6>Event ID</h6>
                                    </label> <input type="text" name="event_id" placeholder="Enter Event ID" required
                                        class="form-control ">
                                </div>

                                <div class="row">
                                    <div class="col-md-6 form-group"> <label for="event_date">
                                            <h6>Event Date</h6>
                                        </label>
                                        <div class="input-group"> <input type="text" name="event_date"
                                                placeholder="Enter Event Date" class="form-control " required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 form-group"> <label for="event_time">
                                            <h6>Event Time</h6>
                                        </label>
                                        <div class="input-group"> <input type="text" name="event_time"
                                                placeholder="Enter Event Timing" class="form-control " required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group"> <label for="event_venue">
                                        <h6>Event Venue</h6>
                                    </label>
                                    <div class="input-group"> <input type="text" name="event_venue"
                                            placeholder="Enter Venue" class="form-control " required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 form-group"> <label for="max_participants">
                                            <h6>Participant</h6>
                                        </label>
                                        <div class="input-group"> <input type="number" name="max_participants"
                                                placeholder="Max No of Participant" class="form-control " required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 form-group"> <label for="is_group">
                                            <h6>Is Group</h6>
                                        </label>
                                        <div class="input-group"> <input type="number" name="is_group"
                                                placeholder="Is group (0 or 1)" class="form-control " required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 form-group"> <label for="group_counts">
                                            <h6>Group Count</h6>
                                        </label>
                                        <div class="input-group"> <input type="number" name="group_counts"
                                                placeholder="No of Group" class="form-control " required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 form-group"> <label for="group_participants">
                                            <h6>Group Participant</h6>
                                        </label>
                                        <div class="input-group"> <input type="number" name="group_participants"
                                                placeholder="Group Participant Count" class="form-control " required>
                                        </div>
                                    </div>
                                
                                    <div class="col-md-6 form-group"> <label for="gender">
                                            <h6>Gender</h6>
                                        </label>
                                        <div class="input-group"> <select name="gender" id=""
                                                placeholder="Select Gender" class="form-control" required>
                                                <option value="" hidden></option>
                                                <option value="BOYS">BOYS</option>
                                                <option value="GIRLS">GIRLS</option>
                                                <option value="COMMON">COMMON</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 form-group"> <label for="event_type">
                                            <h6>Event Type</h6>
                                        </label>
                                        <div class="input-group"> <select name="event_type" id=""
                                                placeholder="Select Gender" class="form-control" required>
                                                <option value="" hidden></option>
                                                <option value="On Stage">On Stage</option>
                                                <option value="Off Stage">Off Stage</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12 form-group"> <label for="allowance">
                                            <h6>Allowance</h6>
                                        </label>
                                        <div class="input-group"> <input type="text" name="allowance"
                                                placeholder="Allowance" class="form-control " required>
                                        </div>
                                    </div>
                                    <div class="col-md-12 form-group"> <label for="file">
                                            <h6>Upload Image</h6>
                                        </label>
                                        <div class="input-group"> <input type="file" name="image"
                                                placeholder="Select Image" class="form-control " required>
                                        </div>
                                    </div>
                                    <div class="col-md-12 form-group"> <label for="event_rules">
                                            <h6>Event Rules</h6>
                                        </label>
                                        <div class="input-group"> <textarea type="text" name="event_rules"
                                                placeholder="Event Rules" class="form-control " required></textarea>
                                        </div>
                                    </div>
                                </div>


                                <div class="card-footer"> <button type="submit" name='submit'
                                        class="subscribe btn btn-primary btn-block shadow-sm"> Add Event </button>
                            </form>
                        </div>
                    </div> <!-- End -->

                    <div id="assign-cordinator" class="tab-pane fade pt-3">
                        <form role="form" action="../routes/admin/assignCordinator.php" method="post">
                            <div class="form-group"> <label for="event_name">
                                    <h6>Event Name</h6>
                                </label> <input type="text" list="listName" name="event_name"
                                    placeholder="Enter Event Name" required class="form-control ">
                                <datalist id="listName">
                                    <?php
                                    $events = mysqli_query($conn, "SELECT * FROM `eventdb`");
                                    while ($event = mysqli_fetch_array($events)) {
                                        ?>
                                        <option value="<?php echo $event['event_name'] ?>">
                                            <?php echo $event['event_name'] ?>
                                        </option>

                                        <?php
                                    }
                                    ?>
                                </datalist>
                            </div>

                            <div class="row">
                                <div class="col-md-6 form-group"> <label for="cordinator_name">
                                        <h6>Cordinator Name</h6>
                                    </label>
                                    <div class="input-group"> <input type="text" name="cordinator_name"
                                            placeholder="Cordinator Name" class="form-control " required>
                                    </div>
                                </div>
                                <div class="col-md-6 form-group"> <label for="cordinator_reg_no">
                                        <h6>Cordinator Number</h6>
                                    </label>
                                    <div class="input-group"> <input type="text" name="cordinator_reg_no"
                                            placeholder="Enter Cordinator Number" class="form-control " required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 form-group"> <label for="role">
                                        <h6>Role</h6>
                                    </label>
                                    <div class="input-group"> <select name="role" id=""
                                                placeholder="Select Role" class="form-control" required>
                                                <option value="Event Cordinator" selected>Event Cordinator</option>
                                            </select>
                                        </div>
                                </div>
                                <div class="col-md-6 form-group"> <label for="dept">
                                        <h6>Department</h6>
                                    </label>
                                    <div class="input-group"> <select name="dept" id=""
                                                placeholder="Select Role" class="form-control" required>
                                                <option value="" hidden>Select Department</option>
                                                <option value="CSE">CSE</option>
                                                <option value="ECE">ECE</option>
                                                <option value="MECH">MECH</option>
                                                <option value="CIVIL">CIVIL</option>
                                                <option value="EEE">EEE</option>
                                                <option value="IT">IT</option>
                                                <option value="AIDS">AI & DS</option>

                                            </select>
                                        </div>
                                </div>
                            </div>
                            <div class="col-md-12 form-group"> <label for="password">
                                        <h6>Password</h6>
                                    </label>
                                    <div class="input-group"> <input type="text" name="password"
                                            placeholder="New Password" class="form-control " required>
                                    </div>
                                </div>
                            <div class="card-footer"> <button type="submit" name='submit'
                                    class="subscribe btn btn-primary btn-block shadow-sm"> Assign Cordinator </button>
                        </form>
                    </div> <!-- End -->

                    <!-- End -->
                </div>

                <div id="edit-cordinator" class="tab-pane fade pt-3">
                        <form role="form" action="../routes/admin/cordinatorEdit.php" method="post">
                            
                            <div class="row">
                                <div class="col-md-12 form-group"> <label for="cordinator_number">
                                        <h6>Cordinator Number</h6>
                                    </label>
                                    <div class="input-group"> <input type="text" name="cordinator_number"
                                            placeholder="Enter Cordinator Number" class="form-control " required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 form-group"> <label for="update_password">
                                        <h6>Update Password</h6>
                                    </label>
                                    <div class="input-group"> <input type="text" name="update_password"
                                            placeholder="New Password" class="form-control " required>
                                    </div>
                                </div>
                            <div class="card-footer"> <button type="submit" name='submit'
                                    class="subscribe btn btn-primary btn-block shadow-sm"> Edit Cordinator </button>
                        </form>
                    </div> <!-- End -->

                    <!-- End -->
                </div>

                <div id="edit-house" class="tab-pane fade pt-3">
                        <form role="form" action="../routes/admin/cordinatorEdit.php" method="post">
                            
                            <div class="row">
                                <div class="col-md-12 form-group"> <label for="captain_number">
                                        <h6>Captain Number</h6>
                                    </label>
                                    <div class="input-group"> <input type="text" name="cordinator_number"
                                            placeholder="Enter Cordinator Number" class="form-control " required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 form-group"> <label for="password">
                                        <h6>Update Password</h6>
                                    </label>
                                    <div class="input-group"> <input type="text" name="password"
                                            placeholder="New Password" class="form-control " required>
                                    </div>
                                </div>
                            <div class="card-footer"> <button type="submit" name='submit'
                                    class="subscribe btn btn-primary btn-block shadow-sm"> Edit Cordinator </button>
                        </form>
                    </div> <!-- End -->

                    <!-- End -->
                </div>

                <div id="assign-house" class="tab-pane fade pt-3">
                        <form role="form" action="../routes/admin/cordinatorEdit.php" method="post">
                            <div class="form-group"> <label for="name">
                                    <h6>House Name</h6>
                                </label> <input type="text" list="houseName" name="name"
                                    placeholder="Enter Event Name" required class="form-control ">
                                <datalist id="houseName">
                                    <?php
                                    $events = mysqli_query($conn, "SELECT * FROM `housedb`");
                                    while ($event = mysqli_fetch_array($events)) {
                                        ?>
                                        <option value="<?php echo $event['name'] ?>">
                                            <?php echo $event['name'] ?>
                                        </option>

                                        <?php
                                    }
                                    ?>
                                </datalist>
                            </div>

                            <div class="row">
                                <div class="col-md-6 form-group"> <label for="captain_name">
                                        <h6>Captain Name</h6>
                                    </label>
                                    <div class="input-group"> <input type="text" name="captain_name"
                                            placeholder="Cordinator Name" class="form-control " required>
                                    </div>
                                </div>
                                <div class="col-md-6 form-group"> <label for="captain_number">
                                        <h6>Captain Number</h6>
                                    </label>
                                    <div class="input-group"> <input type="text" name="captain_number"
                                            placeholder="Enter Cordinator Number" class="form-control " required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 form-group"> <label for="role">
                                        <h6>Role</h6>
                                    </label>
                                    <div class="input-group"> <select name="role" id=""
                                                placeholder="Select Role" class="form-control" required>
                                                <option value="" hidden></option>
                                                <option value="Captain">Captain</option>
                                                <option value="Vice-Captain">Vice-Captain</option>
                                            </select>
                                        </div>
                                </div>
                                <div class="col-md-6 form-group"> <label for="dept">
                                        <h6>Department</h6>
                                    </label>
                                    <div class="input-group"> <select name="dept" id=""
                                                placeholder="Select Role" class="form-control" required>
                                                <option value="" hidden>Select Department</option>
                                                <option value="CSE">CSE</option>
                                                <option value="ECE">ECE</option>
                                                <option value="MECH">MECH</option>
                                                <option value="CIVIL">CIVIL</option>
                                                <option value="EEE">EEE</option>
                                                <option value="IT">IT</option>
                                                <option value="AIDS">AI & DS</option>

                                            </select>
                                        </div>
                                </div>
                            </div>
                            <div class="col-md-12 form-group"> <label for="password">
                                        <h6>New Password</h6>
                                    </label>
                                    <div class="input-group"> <input type="text" name="password"
                                            placeholder="New Password" class="form-control " required>
                                    </div>
                                </div>
                            <div class="card-footer"> <button type="submit" name='submit'
                                    class="subscribe btn btn-primary btn-block shadow-sm"> Edit Cordinator </button>
                        </form>
                    </div> <!-- End -->

                    <!-- End -->
                </div>

                <div id="edit-event" class="tab-pane fade pt-3">
                        <form role="form" action="../routes/admin/eventEdit.php" method="post">
                            <div class="form-group"> <label for="event_name">
                                    <h6>Event Name</h6>
                                </label> <input type="text" list="listName" name="event_name"
                                    placeholder="Enter Event Name" required class="form-control ">
                                <datalist id="listName">
                                    <?php
                                    $events = mysqli_query($conn, "SELECT * FROM `eventdb`");
                                    while ($event = mysqli_fetch_array($events)) {
                                        ?>
                                        <option value="<?php echo $event['event_name'] ?>">
                                            <?php echo $event['event_name'] ?>
                                        </option>

                                        <?php
                                    }
                                    ?>
                                </datalist>
                            </div>

                            <div class="row">
                                <div class="col-md-6 form-group"> <label for="event_date">
                                        <h6>Event Date</h6>
                                    </label>
                                    <div class="input-group"> <input type="text" name="event_date"
                                            placeholder="Enter Event Date" class="form-control " required>
                                    </div>
                                </div>
                                <div class="col-md-6 form-group"> <label for="event_time">
                                        <h6>Event Time</h6>
                                    </label>
                                    <div class="input-group"> <input type="text" name="event_time"
                                            placeholder="Enter Event Timing" class="form-control " required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group"> <label for="event_venue">
                                    <h6>Event Venue</h6>
                                </label>
                                <div class="input-group"> <input type="text" name="event_venue"
                                        placeholder="Enter Venue" class="form-control " required>
                                </div>
                            </div>
                            <div class="form-group"> <label for="event_rules">
                                    <h6>Event Rules</h6>
                                </label>
                                <div class="input-group"> <textarea type="text" name="event_rules"
                                        placeholder="Event Rules" class="form-control " required></textarea>
                                </div>
                            </div>
                            <div class="card-footer"> <button type="submit" name='submit'
                                    class="subscribe btn btn-primary btn-block shadow-sm"> Edit Event </button>
                        </form>
                    </div> <!-- End -->

                    <!-- End -->
                </div>

                
            </div>
        </div>
    </div>

    <script type="text/javascript" src="../public/js/jquery.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tsparticles-confetti@2.12.0/tsparticles.confetti.bundle.min.js"></script>
    <script>
    const duration = 30 * 1000,
        animationEnd = Date.now() + duration,
        defaults = {
            startVelocity: 30,
            spread: 360,
            ticks: 60,
            zIndex: 0
        };

    function randomInRange(min, max) {
        return Math.random() * (max - min) + min;
    }

    const interval = setInterval(function() {
        const timeLeft = animationEnd - Date.now();

        if (timeLeft <= 0) {
            return clearInterval(interval);
        }

        const particleCount = 10 * (timeLeft / duration);

        // since particles fall down, start a bit higher than random
        confetti(
            Object.assign({}, defaults, {
                particleCount,
                origin: {
                    x: randomInRange(0.1, 0.3),
                    y: Math.random() - 0.2
                },
            })
        );
        confetti(
            Object.assign({}, defaults, {
                particleCount,
                origin: {
                    x: randomInRange(0.7, 0.9),
                    y: Math.random() - 0.2
                },
            })
        );
    }, 250);
    </script>
    <script>
    function clickEffect(e) {
        var d = document.createElement("div");
        d.className = "clickEffect";
        d.style.top = e.clientY + "px";
        d.style.left = e.clientX + "px";
        document.body.appendChild(d);
        d.addEventListener('animationend', function() {
            d.parentElement.removeChild(d);
        }.bind(this));
    }
    document.addEventListener('click', clickEffect);
    </script>