<?php
session_start();
if (!isset($_SESSION['ispin_admin_logged_in']) || $_SESSION['ispin_admin_logged_in'] !== true) {
    header("Location: ../ispin/");
    exit();
}
include('../routes/connect.php');
?>
<style>
    :root {
        --primary-color: #e22361;
        --primary-dark: #b8174c;
        --primary-gradient: linear-gradient(135deg, #e22361 0%, #9b1747 100%);
    }
    body {
        padding: 40px 0 80px;
        min-height: 100vh;
        background: radial-gradient(circle at 10% 15%, rgba(226,35,97,0.2) 0%, transparent 40%),
                    radial-gradient(circle at 90% 85%, rgba(103,58,183,0.25) 0%, transparent 45%),
                    url("../public/images/cover.jpg") no-repeat center center fixed;
        background-size: cover !important;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
    }
    .admin-header-box {
        background: rgba(18, 22, 38, 0.78);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.15);
        border-radius: 20px;
        padding: 22px 30px;
        box-shadow: 0 20px 45px rgba(0, 0, 0, 0.4);
    }
    .main-admin-card {
        background: #ffffff;
        border-radius: 22px;
        border: 1px solid rgba(255, 255, 255, 0.35);
        box-shadow: 0 25px 65px rgba(0, 0, 0, 0.45);
        overflow: hidden;
    }
    .nav-tabs-wrapper {
        background: #f8fafc;
        border-bottom: 2px solid #e2e8f0;
        padding: 16px 20px;
    }
    .custom-admin-pills {
        gap: 8px;
        display: flex;
        flex-wrap: wrap;
    }
    .custom-admin-pills .nav-item {
        flex: 1 1 calc(25% - 8px);
        min-width: 140px;
        text-align: center;
    }
    .custom-admin-pills .nav-link {
        color: #475569;
        font-weight: 600;
        font-size: 13px;
        padding: 11px 12px;
        border-radius: 12px;
        transition: all 0.25s ease;
        border: 1.5px solid #e2e8f0;
        background: #ffffff;
        white-space: nowrap;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .custom-admin-pills .nav-link:hover {
        background: rgba(226, 35, 97, 0.08);
        color: #e22361;
        border-color: rgba(226, 35, 97, 0.3);
    }
    .custom-admin-pills .nav-link.active {
        background: var(--primary-gradient) !important;
        color: #ffffff !important;
        border-color: transparent;
        box-shadow: 0 6px 18px rgba(226, 35, 97, 0.4);
    }
    .form-control {
        border-radius: 10px;
        border: 1.5px solid #cbd5e1;
        padding: 9px 14px;
        font-size: 14px;
        transition: all 0.2s ease-in-out;
        color: #1e293b;
    }
    .form-control:focus {
        border-color: #e22361;
        box-shadow: 0 0 0 3.5px rgba(226, 35, 97, 0.18);
    }
    .form-group label h6, .form-group label {
        font-weight: 600;
        color: #334155;
        font-size: 13.5px;
        margin-bottom: 6px;
    }
    .subscribe.btn {
        background: var(--primary-gradient);
        color: white;
        font-weight: 700;
        font-size: 15px;
        padding: 13px 20px;
        border-radius: 12px;
        border: none;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
        box-shadow: 0 8px 22px rgba(226, 35, 97, 0.32);
    }
    .subscribe.btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 28px rgba(226, 35, 97, 0.48);
        color: white;
    }
    .student-filter-card {
        background: #f8fafc;
        border: 1.5px solid #e2e8f0;
        border-radius: 14px;
        padding: 18px;
        margin-bottom: 20px;
        transition: all 0.25s ease;
    }
    .student-filter-card:hover {
        border-color: #cbd5e1;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
    }
    .badge-accent {
        background: linear-gradient(135deg, #e22361 0%, #9b1747 100%);
        color: white;
        font-size: 12.5px;
        padding: 6px 14px;
        border-radius: 20px;
        font-weight: 600;
        letter-spacing: 0.3px;
    }
</style>
<link rel="stylesheet" href="../public/css/style.css">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<div class="container-fluid py-4 px-md-5">

    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-xl-10 col-lg-11 mx-auto">
            <div class="admin-header-box d-flex flex-column flex-md-row justify-content-between align-items-center text-center text-md-left">
                <div class="d-flex align-items-center justify-content-center mb-3 mb-md-0">
                    <img src="../public/images/logos/ispin-logo.png" height="52" class="mr-3" alt="iSpin">
                    <img src="../public/images/logos/clg-logo.png" height="56" class="mr-3" alt="NSCET">
                    <img src="../public/images/logos/waves-logo.png" height="52" alt="Waves">
                </div>
                <div>
                    <h2 class="font-weight-bold text-white mb-1" style="font-family:'Shantell Sans', cursive, sans-serif; font-size: 26px;">
                        <span style="color: #ff477e;">WAVES '25</span> ADMIN CONSOLE
                    </h2>
                    <span class="badge badge-light px-3 py-1 font-weight-normal text-muted" style="font-size: 12px;">
                        <i class="fas fa-shield-alt mr-1 text-danger"></i> Fest Coordination & Event Control Center
                    </span>
                </div>
                <div class="mt-3 mt-md-0 d-flex gap-2">
                    <a href="../index.php" class="btn btn-sm btn-outline-light font-weight-bold px-3 py-2 mr-2" style="border-radius: 10px; font-size: 13px;">
                        <i class="fas fa-home mr-1"></i> Live Site
                    </a>
                    <a href="../ispin/logout.php" class="btn btn-sm btn-danger font-weight-bold px-3 py-2" style="border-radius: 10px; font-size: 13px; background: #e22361; border: none;">
                        <i class="fas fa-sign-out-alt mr-1"></i> Logout
                    </a>
                </div>
            </div>
        </div>
    </div>

    <?php if (isset($_GET['success'])): ?>
        <div class="row">
            <div class="col-xl-10 col-lg-11 mx-auto mb-3">
                <?php if ($_GET['success'] === 'house_added'): ?>
                    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                        <strong><i class="fas fa-check-circle mr-2"></i>Success!</strong> New house team and logo were added successfully. It is now live in the homepage team carousel.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php elseif ($_GET['success'] === 'students_imported'): ?>
                    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                        <strong><i class="fas fa-check-circle mr-2"></i>Success!</strong> Students data was successfully imported house-wise into the database.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php elseif ($_GET['success'] === 'event_added'): ?>
                    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                        <strong><i class="fas fa-check-circle mr-2"></i>Success!</strong> New event has been added successfully.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php elseif ($_GET['success'] === 'event_deleted'): ?>
                    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                        <strong><i class="fas fa-check-circle mr-2"></i>Success!</strong> Event has been deleted successfully.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php elseif ($_GET['success'] === 'event_updated'): ?>
                    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                        <strong><i class="fas fa-check-circle mr-2"></i>Success!</strong> Event details have been updated successfully.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php elseif ($_GET['success'] === 'coordinator_updated'): ?>
                    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                        <strong><i class="fas fa-check-circle mr-2"></i>Success!</strong> Event student coordinators have been updated successfully.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php elseif ($_GET['success'] === 'house_leads_updated'): ?>
                    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                        <strong><i class="fas fa-check-circle mr-2"></i>Success!</strong> House captains have been updated successfully.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php elseif ($_GET['success'] === 'coordinator_assigned'): ?>
                    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                        <strong><i class="fas fa-check-circle mr-2"></i>Success!</strong> Student coordinators were successfully assigned to the event.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php elseif ($_GET['success'] === 'house_leads_assigned'): ?>
                    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                        <strong><i class="fas fa-check-circle mr-2"></i>Success!</strong> House captains were successfully assigned.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['error'])): ?>
        <div class="row">
            <div class="col-xl-10 col-lg-11 mx-auto mb-3">
                <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                    <strong><i class="fas fa-exclamation-triangle mr-2"></i>Error!</strong> <?php echo htmlspecialchars(urldecode($_GET['error'])); ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-xl-10 col-lg-11 mx-auto">
            <div class="card main-admin-card">
                <div class="card-header p-0 border-0">
                    <div class="nav-tabs-wrapper">
                        <!-- Navigation Tabs -->
                        <ul role="tablist" class="nav custom-admin-pills mb-0">
                            <li class="nav-item"> <a data-toggle="pill" href="#add-event" class="nav-link active"> <i class="fas fa-calendar-plus mr-1"></i> Add Event </a> </li>
                            <li class="nav-item"> <a data-toggle="pill" href="#edit-event" class="nav-link"> <i class="fas fa-edit mr-1"></i> Edit Event </a> </li>
                            <li class="nav-item"> <a data-toggle="pill" href="#assign-coordinator" class="nav-link"> <i class="fas fa-user-graduate mr-1"></i> Assign Coordinators </a> </li>
                            <li class="nav-item"> <a data-toggle="pill" href="#edit-coordinator" class="nav-link"> <i class="fas fa-user-edit mr-1"></i> Edit Coordinators </a> </li>
                            <li class="nav-item"> <a data-toggle="pill" href="#assign-house" class="nav-link"> <i class="fas fa-flag mr-1"></i> Assign House Leads </a> </li>
                            <li class="nav-item"> <a data-toggle="pill" href="#edit-house" class="nav-link"> <i class="fas fa-shield-alt mr-1"></i> Edit House Leads </a> </li>
                            <li class="nav-item"> <a data-toggle="pill" href="#add-house" class="nav-link"> <i class="fas fa-house-user mr-1"></i> Add House </a> </li>
                            <li class="nav-item"> <a data-toggle="pill" href="#add-student" class="nav-link"> <i class="fas fa-file-csv mr-1"></i> Add Students Data </a> </li>
                        </ul>
                    </div>
                </div>

                <div class="card-body p-4 p-md-5">
                    <div class="tab-content">
                        <!-- credit card info-->
                        <div id="add-event" class="tab-pane fade show active pt-3">
                            <form role="form" action="../routes/admin/eventPost.php" method="post"
                                enctype="multipart/form-data">
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
                                        <div class="input-group"> <input type="text" name="event_date" placeholder="Enter Event Date" class="form-control ">
                                        </div>
                                    </div>
                                    <div class="col-md-6 form-group"> <label for="event_time">
                                            <h6>Event Time</h6>
                                        </label>
                                        <div class="input-group"> <input type="text" name="event_time" placeholder="Enter Event Timing" class="form-control ">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group"> <label for="event_venue">
                                        <h6>Event Venue</h6>
                                    </label>
                                    <div class="input-group"> <input type="text" name="event_venue" placeholder="Enter Venue Name" class="form-control ">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 form-group"> <label for="max_participants">
                                            <h6>Max Participants Count</h6>
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
                                            <h6>Group Participants Count</h6>
                                        </label>
                                        <div class="input-group"> <input type="number" name="group_participants"
                                                placeholder="No of Group Participants" class="form-control " required>
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
                                                placeholder="Select Event Type" class="form-control" required>
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
                                                placeholder="Enter Allowance" class="form-control " required>
                                        </div>
                                    </div>
                                    <div class="col-md-12 form-group"> <label for="file">
                                            <h6>Upload Image</h6>
                                        </label>
                                        <div class="input-group"> <input type="file" name="image" accept="image/jpeg,image/png,image/gif,image/webp"
                                                placeholder="Upload Image" class="form-control " required>
                                        <small class="form-text text-muted w-100">Max 5MB. Formats: JPG, PNG, GIF, WEBP</small>
                                        </div>
                                    </div>
                                    <div class="col-md-12 form-group"> <label for="event_rules">
                                            <h6>Event Rules</h6>
                                        </label>
                                        <div class="input-group"> <textarea type="text" name="event_rules"
                                                placeholder="Enter Event Rules" class="form-control "
                                                required></textarea>
                                        </div>
                                    </div>
                                </div>


                                <div class="card-footer"> <button type="submit" name='submit'
                                        class="subscribe btn btn-block shadow-sm"> Add Event </button>
                            </form>
                        </div>
                    <!-- Edit Event Tab -->
                    <div id="edit-event" class="tab-pane fade pt-3">
                        <div class="alert alert-info py-2 px-3 small mb-3">
                            <i class="fas fa-info-circle mr-1"></i> Choose an event to automatically fetch and edit its existing details.
                        </div>
                        <form role="form" action="../routes/admin/eventEdit.php" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="edit_event_name">
                                    <h6>Select Event to Edit <span class="text-danger">*</span></h6>
                                </label>
                                <select id="edit_event_name" name="event_name" class="form-control" required onchange="fetchEventData(this.value)">
                                    <option value="" disabled selected>-- Choose Event --</option>
                                    <?php
                                    $events_q = mysqli_query($conn, "SELECT event_name, gender FROM `eventdb` ORDER BY `event_name` ASC");
                                    while ($ev = mysqli_fetch_array($events_q)) {
                                        $ev_n = htmlspecialchars($ev['event_name']);
                                        $ev_g = htmlspecialchars($ev['gender']);
                                        echo "<option value=\"{$ev_n}\">{$ev_n} ({$ev_g})</option>";
                                    }
                                    ?>
                                </select>
                                <small id="edit_event_status" class="form-text text-muted mt-1"></small>
                            </div>

                            <div class="form-group">
                                <label for="event_id">
                                    <h6>Event ID</h6>
                                </label>
                                <input type="text" name="event_id" placeholder="Event ID" readonly class="form-control bg-light">
                            </div>

                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label for="event_date">
                                        <h6>Event Date</h6>
                                    </label>
                                    <input type="text" name="event_date" placeholder="Enter Event Date" class="form-control">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="event_time">
                                        <h6>Event Time</h6>
                                    </label>
                                    <input type="text" name="event_time" placeholder="Enter Event Timing" class="form-control">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="event_venue">
                                    <h6>Event Venue</h6>
                                </label>
                                <input type="text" name="event_venue" placeholder="Enter Venue Name" class="form-control">
                            </div>

                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label for="max_participants">
                                        <h6>Max Participants Count</h6>
                                    </label>
                                    <input type="number" name="max_participants" placeholder="Max No of Participant" class="form-control" required>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="is_group">
                                        <h6>Is Group (0 or 1)</h6>
                                    </label>
                                    <input type="number" name="is_group" placeholder="Is group (0 or 1)" class="form-control" required>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="group_counts">
                                        <h6>Group Count</h6>
                                    </label>
                                    <input type="number" name="group_counts" placeholder="No of Group" class="form-control" required>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="group_participants">
                                        <h6>Group Participants Count</h6>
                                    </label>
                                    <input type="number" name="group_participants" placeholder="No of Group Participants" class="form-control" required>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="gender">
                                        <h6>Gender</h6>
                                    </label>
                                    <select name="gender" class="form-control" required>
                                        <option value="BOYS">BOYS</option>
                                        <option value="GIRLS">GIRLS</option>
                                        <option value="COMMON">COMMON</option>
                                    </select>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="event_type">
                                        <h6>Event Type</h6>
                                    </label>
                                    <select name="event_type" class="form-control" required>
                                        <option value="On Stage">On Stage</option>
                                        <option value="Off Stage">Off Stage</option>
                                    </select>
                                </div>
                                <div class="col-md-12 form-group">
                                    <label for="allowance">
                                        <h6>Allowance</h6>
                                    </label>
                                    <input type="text" name="allowance" placeholder="Enter Allowance" class="form-control" required>
                                </div>
                                <div class="col-md-12 form-group">
                                    <label for="image">
                                        <h6>Event Image <small class="text-muted">(Optional - upload to replace current image)</small></h6>
                                    </label>
                                    <div id="edit_event_image_box" class="mb-2" style="display: none;">
                                        <img id="edit_event_image_preview" src="" alt="Current Event Image" class="img-thumbnail" style="max-height: 100px;">
                                        <small class="d-block text-muted">Current image preview</small>
                                    </div>
                                    <input type="file" name="image" class="form-control">
                                </div>
                                <div class="col-md-12 form-group">
                                    <label for="event_rules">
                                        <h6>Event Rules</h6>
                                    </label>
                                    <textarea name="event_rules" rows="4" placeholder="Enter Event Rules" class="form-control" required></textarea>
                                </div>
                            </div>

                            <div class="card-footer px-0 pb-0 d-flex gap-2">
                                <button type="submit" name="submit" class="subscribe btn flex-grow-1 shadow-sm m-0">
                                    <i class="fas fa-save mr-2"></i> Update Event Details
                                </button>
                                <button type="submit" name="delete_event" class="btn btn-danger shadow-sm m-0 px-4" onclick="return confirm('Are you sure you want to delete this event? This action cannot be undone.');">
                                    <i class="fas fa-trash-alt mr-2"></i> Delete
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Assign Coordinators Tab -->
                    <div id="assign-coordinator" class="tab-pane fade pt-3">
                        <form role="form" action="../routes/admin/assignCoordinator.php" method="post">
                            <div class="form-group mb-4">
                                <label for="event_name">
                                    <h6>Select Event to Assign Coordinators <span class="text-danger">*</span></h6>
                                </label>
                                <select id="assign_coord_event" name="event_name" class="form-control" required onchange="checkExistingCoordinator(this.value)">
                                    <option value="" disabled selected>-- Choose Event --</option>
                                    <?php
                                    $events_c = mysqli_query($conn, "SELECT event_name, gender FROM `eventdb` ORDER BY `event_name` ASC");
                                    while ($ev = mysqli_fetch_array($events_c)) {
                                        $ev_n = htmlspecialchars($ev['event_name']);
                                        $ev_g = htmlspecialchars($ev['gender']);
                                        echo "<option value=\"{$ev_n}\">{$ev_n} ({$ev_g})</option>";
                                    }
                                    ?>
                                </select>
                                <div id="assign_coord_notice" class="alert alert-info py-2 px-3 small mt-2" style="display: none;"></div>
                            </div>

                            <!-- Student Coordinator 1 Card -->
                            <div class="student-filter-card shadow-sm">
                                <div class="d-flex flex-wrap align-items-center justify-content-between mb-3">
                                    <span class="badge badge-accent mb-2 mb-md-0">
                                        <i class="fas fa-user-graduate mr-1"></i> Student Event Coordinator 1
                                    </span>
                                    <span class="small text-muted"><i class="fas fa-filter mr-1"></i> Filter by Year & Dept or enter manually</span>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-3 form-group mb-2">
                                        <label class="small font-weight-bold text-muted mb-1"><i class="fas fa-calendar-alt mr-1"></i> Year Filter</label>
                                        <select id="assign_c1_year" class="form-control form-control-sm" onchange="filterStudents('assign_c1')">
                                            <option value="">All Years</option>
                                            <option value="I">Year I</option>
                                            <option value="II">Year II</option>
                                            <option value="III">Year III</option>
                                            <option value="IV">Year IV</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 form-group mb-2">
                                        <label class="small font-weight-bold text-muted mb-1"><i class="fas fa-building mr-1"></i> Dept Filter</label>
                                        <select id="assign_c1_dept" class="form-control form-control-sm" onchange="filterStudents('assign_c1')">
                                            <option value="">All Departments</option>
                                            <option value="CSE">CSE</option>
                                            <option value="ECE">ECE</option>
                                            <option value="MECH">MECH</option>
                                            <option value="CIVIL">CIVIL</option>
                                            <option value="EEE">EEE</option>
                                            <option value="IT">IT</option>
                                            <option value="AIDS">AI & DS</option>
                                            <option value="SH">S&H</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 form-group mb-2">
                                        <label class="small font-weight-bold text-muted mb-1"><i class="fas fa-search mr-1"></i> Select Student (Auto-fills below)</label>
                                        <select id="assign_c1_student_select" class="form-control form-control-sm" onchange="onStudentPicked('assign_c1', this)">
                                            <option value="">-- Choose Student --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5 form-group mb-md-0">
                                        <label class="small font-weight-bold">Student Name <span class="text-danger">*</span></label>
                                        <input type="text" id="assign_c1_name" name="coordinator_name_1" placeholder="Student Full Name" class="form-control" required>
                                    </div>
                                    <div class="col-md-4 form-group mb-md-0">
                                        <label class="small font-weight-bold">Register Number</label>
                                        <input type="text" id="assign_c1_reg" name="coordinator_reg_no_1" placeholder="Register Number" class="form-control">
                                    </div>
                                    <div class="col-md-3 form-group mb-0">
                                        <label class="small font-weight-bold">Department <span class="text-danger">*</span></label>
                                        <select id="assign_c1_dept_select" name="staff_dept_1" class="form-control" required>
                                            <option value="" disabled selected>Select Dept</option>
                                            <option value="SH">S&H</option>
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

                            <!-- Student Coordinator 2 Card -->
                            <div class="student-filter-card shadow-sm">
                                <div class="d-flex flex-wrap align-items-center justify-content-between mb-3">
                                    <span class="badge badge-accent mb-2 mb-md-0">
                                        <i class="fas fa-user-graduate mr-1"></i> Student Event Coordinator 2
                                    </span>
                                    <span class="small text-muted"><i class="fas fa-filter mr-1"></i> Filter by Year & Dept or enter manually</span>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-3 form-group mb-2">
                                        <label class="small font-weight-bold text-muted mb-1"><i class="fas fa-calendar-alt mr-1"></i> Year Filter</label>
                                        <select id="assign_c2_year" class="form-control form-control-sm" onchange="filterStudents('assign_c2')">
                                            <option value="">All Years</option>
                                            <option value="I">Year I</option>
                                            <option value="II">Year II</option>
                                            <option value="III">Year III</option>
                                            <option value="IV">Year IV</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 form-group mb-2">
                                        <label class="small font-weight-bold text-muted mb-1"><i class="fas fa-building mr-1"></i> Dept Filter</label>
                                        <select id="assign_c2_dept" class="form-control form-control-sm" onchange="filterStudents('assign_c2')">
                                            <option value="">All Departments</option>
                                            <option value="CSE">CSE</option>
                                            <option value="ECE">ECE</option>
                                            <option value="MECH">MECH</option>
                                            <option value="CIVIL">CIVIL</option>
                                            <option value="EEE">EEE</option>
                                            <option value="IT">IT</option>
                                            <option value="AIDS">AI & DS</option>
                                            <option value="SH">S&H</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 form-group mb-2">
                                        <label class="small font-weight-bold text-muted mb-1"><i class="fas fa-search mr-1"></i> Select Student (Auto-fills below)</label>
                                        <select id="assign_c2_student_select" class="form-control form-control-sm" onchange="onStudentPicked('assign_c2', this)">
                                            <option value="">-- Choose Student --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5 form-group mb-md-0">
                                        <label class="small font-weight-bold">Student Name <span class="text-danger">*</span></label>
                                        <input type="text" id="assign_c2_name" name="coordinator_name_2" placeholder="Student Full Name" class="form-control" required>
                                    </div>
                                    <div class="col-md-4 form-group mb-md-0">
                                        <label class="small font-weight-bold">Register Number</label>
                                        <input type="text" id="assign_c2_reg" name="coordinator_reg_no_2" placeholder="Register Number" class="form-control">
                                    </div>
                                    <div class="col-md-3 form-group mb-0">
                                        <label class="small font-weight-bold">Department <span class="text-danger">*</span></label>
                                        <select id="assign_c2_dept_select" name="staff_dept_2" class="form-control" required>
                                            <option value="" disabled selected>Select Dept</option>
                                            <option value="SH">S&H</option>
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

                            <div class="form-group">
                                <label for="password">
                                    <h6>Common Coordinator Password <span class="text-danger">*</span></h6>
                                </label>
                                <input type="password" name="password" placeholder="Enter Common Login Password" class="form-control" autocomplete="new-password" required>
                            </div>

                            <div class="card-footer px-0 pb-0">
                                <button type="submit" name="submit" class="subscribe btn btn-block shadow-sm">
                                    <i class="fas fa-user-plus mr-2"></i> Assign Student Coordinators
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Edit Coordinators Tab -->
                    <div id="edit-coordinator" class="tab-pane fade pt-3">
                        <div class="alert alert-info py-2 px-3 small mb-3">
                            <i class="fas fa-info-circle mr-1"></i> Choose an event to fetch its assigned student coordinators. You can update their details or re-assign using the student filters below.
                        </div>
                        <form role="form" action="../routes/admin/coordinatorEdit.php" method="post">
                            <div class="form-group mb-4">
                                <label for="event_name">
                                    <h6>Select Event to Edit Coordinators <span class="text-danger">*</span></h6>
                                </label>
                                <select id="edit_coord_event" name="event_name" class="form-control" required onchange="fetchCoordinatorData(this.value)">
                                    <option value="" disabled selected>-- Choose Event --</option>
                                    <?php
                                    $events_ec = mysqli_query($conn, "SELECT event_name, gender FROM `eventdb` ORDER BY `event_name` ASC");
                                    while ($ev = mysqli_fetch_array($events_ec)) {
                                        $ev_n = htmlspecialchars($ev['event_name']);
                                        $ev_g = htmlspecialchars($ev['gender']);
                                        echo "<option value=\"{$ev_n}\">{$ev_n} ({$ev_g})</option>";
                                    }
                                    ?>
                                </select>
                                <small id="edit_coord_status" class="form-text text-muted mt-1"></small>
                            </div>

                            <!-- Edit Coordinator 1 -->
                            <div class="student-filter-card shadow-sm">
                                <div class="d-flex flex-wrap align-items-center justify-content-between mb-3">
                                    <span class="badge badge-accent mb-2 mb-md-0">
                                        <i class="fas fa-user-graduate mr-1"></i> Student Event Coordinator 1
                                    </span>
                                    <span class="small text-muted"><i class="fas fa-filter mr-1"></i> Pick from Database to replace</span>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-3 form-group mb-2">
                                        <label class="small font-weight-bold text-muted mb-1"><i class="fas fa-calendar-alt mr-1"></i> Filter Year</label>
                                        <select id="edit_c1_year" class="form-control form-control-sm" onchange="filterStudents('edit_c1')">
                                            <option value="">All Years</option>
                                            <option value="I">Year I</option>
                                            <option value="II">Year II</option>
                                            <option value="III">Year III</option>
                                            <option value="IV">Year IV</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 form-group mb-2">
                                        <label class="small font-weight-bold text-muted mb-1"><i class="fas fa-building mr-1"></i> Filter Dept</label>
                                        <select id="edit_c1_dept" class="form-control form-control-sm" onchange="filterStudents('edit_c1')">
                                            <option value="">All Departments</option>
                                            <option value="CSE">CSE</option>
                                            <option value="ECE">ECE</option>
                                            <option value="MECH">MECH</option>
                                            <option value="CIVIL">CIVIL</option>
                                            <option value="EEE">EEE</option>
                                            <option value="IT">IT</option>
                                            <option value="AIDS">AI & DS</option>
                                            <option value="SH">S&H</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 form-group mb-2">
                                        <label class="small font-weight-bold text-muted mb-1"><i class="fas fa-search mr-1"></i> Replace with Student</label>
                                        <select id="edit_c1_student_select" class="form-control form-control-sm" onchange="onStudentPicked('edit_c1', this)">
                                            <option value="">-- Choose Student --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5 form-group mb-md-0">
                                        <label class="small font-weight-bold">Student Name <span class="text-danger">*</span></label>
                                        <input type="text" id="edit_c1_name" name="coordinator_name_1" placeholder="Student Full Name" class="form-control" required>
                                    </div>
                                    <div class="col-md-4 form-group mb-md-0">
                                        <label class="small font-weight-bold">Register Number</label>
                                        <input type="text" id="edit_c1_reg" name="coordinator_reg_no_1" placeholder="Register Number" class="form-control">
                                    </div>
                                    <div class="col-md-3 form-group mb-0">
                                        <label class="small font-weight-bold">Department <span class="text-danger">*</span></label>
                                        <select id="edit_c1_dept_select" name="staff_dept_1" class="form-control" required>
                                            <option value="" disabled selected>Select Dept</option>
                                            <option value="SH">S&H</option>
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

                            <!-- Edit Coordinator 2 -->
                            <div class="student-filter-card shadow-sm">
                                <div class="d-flex flex-wrap align-items-center justify-content-between mb-3">
                                    <span class="badge badge-accent mb-2 mb-md-0">
                                        <i class="fas fa-user-graduate mr-1"></i> Student Event Coordinator 2
                                    </span>
                                    <span class="small text-muted"><i class="fas fa-filter mr-1"></i> Pick from Database to replace</span>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-3 form-group mb-2">
                                        <label class="small font-weight-bold text-muted mb-1"><i class="fas fa-calendar-alt mr-1"></i> Filter Year</label>
                                        <select id="edit_c2_year" class="form-control form-control-sm" onchange="filterStudents('edit_c2')">
                                            <option value="">All Years</option>
                                            <option value="I">Year I</option>
                                            <option value="II">Year II</option>
                                            <option value="III">Year III</option>
                                            <option value="IV">Year IV</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 form-group mb-2">
                                        <label class="small font-weight-bold text-muted mb-1"><i class="fas fa-building mr-1"></i> Filter Dept</label>
                                        <select id="edit_c2_dept" class="form-control form-control-sm" onchange="filterStudents('edit_c2')">
                                            <option value="">All Departments</option>
                                            <option value="CSE">CSE</option>
                                            <option value="ECE">ECE</option>
                                            <option value="MECH">MECH</option>
                                            <option value="CIVIL">CIVIL</option>
                                            <option value="EEE">EEE</option>
                                            <option value="IT">IT</option>
                                            <option value="AIDS">AI & DS</option>
                                            <option value="SH">S&H</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 form-group mb-2">
                                        <label class="small font-weight-bold text-muted mb-1"><i class="fas fa-search mr-1"></i> Replace with Student</label>
                                        <select id="edit_c2_student_select" class="form-control form-control-sm" onchange="onStudentPicked('edit_c2', this)">
                                            <option value="">-- Choose Student --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5 form-group mb-md-0">
                                        <label class="small font-weight-bold">Student Name <span class="text-danger">*</span></label>
                                        <input type="text" id="edit_c2_name" name="coordinator_name_2" placeholder="Student Full Name" class="form-control" required>
                                    </div>
                                    <div class="col-md-4 form-group mb-md-0">
                                        <label class="small font-weight-bold">Register Number</label>
                                        <input type="text" id="edit_c2_reg" name="coordinator_reg_no_2" placeholder="Register Number" class="form-control">
                                    </div>
                                    <div class="col-md-3 form-group mb-0">
                                        <label class="small font-weight-bold">Department <span class="text-danger">*</span></label>
                                        <select id="edit_c2_dept_select" name="staff_dept_2" class="form-control" required>
                                            <option value="" disabled selected>Select Dept</option>
                                            <option value="SH">S&H</option>
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

                            <div class="form-group">
                                <label for="update_password">
                                    <h6>Update Password <small class="text-muted">(Leave blank to keep current password)</small></h6>
                                </label>
                                <input type="password" name="update_password" placeholder="Enter New Password (Optional)" class="form-control" autocomplete="new-password">
                            </div>

                            <div class="card-footer px-0 pb-0">
                                <button type="submit" name="submit" class="subscribe btn btn-block shadow-sm">
                                    <i class="fas fa-user-edit mr-2"></i> Update Coordinators
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Assign House Leads Tab -->
                    <div id="assign-house" class="tab-pane fade pt-3">
                        <form role="form" action="../routes/admin/assignCaptain.php" method="post">
                            <div class="form-group">
                                <label for="house_name">
                                    <h6>Select House Team <span class="text-danger">*</span></h6>
                                </label>
                                <select id="assign_house_select" name="house_name" class="form-control" required onchange="checkExistingHouseLeads(this.value)">
                                    <option value="" disabled selected>-- Choose House Team --</option>
                                    <?php
                                    $h_query1 = mysqli_query($conn, "SELECT name, gender FROM `housedb` ORDER BY `name` ASC");
                                    while ($h = mysqli_fetch_array($h_query1)) {
                                        $h_n = htmlspecialchars($h['name']);
                                        $h_g = htmlspecialchars($h['gender']);
                                        echo "<option value=\"{$h_n}\">{$h_n} ({$h_g})</option>";
                                    }
                                    ?>
                                </select>
                                <div id="assign_house_notice" class="alert alert-info py-2 px-3 small mt-2" style="display: none;"></div>
                            </div>

                            <h6 class="text-primary mt-3 mb-2"><i class="fas fa-users mr-1"></i> Student House Captains</h6>
                            <div class="row">
                                <div class="col-md-4 form-group">
                                    <label>Captain Name</label>
                                    <input type="text" name="captain_name" placeholder="Enter Captain Name" class="form-control" required>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label>Captain Register No</label>
                                    <input type="text" name="captain_reg_no" placeholder="Enter Captain Reg No" class="form-control" required>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label>Captain Dept</label>
                                    <select name="cap_dept" class="form-control" required>
                                        <option value="" disabled selected>Select Dept</option>
                                        <option value="CSE">CSE</option>
                                        <option value="ECE">ECE</option>
                                        <option value="MECH">MECH</option>
                                        <option value="CIVIL">CIVIL</option>
                                        <option value="EEE">EEE</option>
                                        <option value="IT">IT</option>
                                        <option value="AIDS">AI & DS</option>
                                    </select>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label>Vice Captain Name</label>
                                    <input type="text" name="vice_captain_name" placeholder="Enter Vice Captain Name" class="form-control" required>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label>Vice Captain Register No</label>
                                    <input type="text" name="vice_captain_reg_no" placeholder="Enter Vice Captain Reg No" class="form-control" required>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label>Vice Captain Dept</label>
                                    <select name="vice_cap_dept" class="form-control" required>
                                        <option value="" disabled selected>Select Dept</option>
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

                            <div class="form-group">
                                <label for="password">
                                    <h6>Common Password</h6>
                                </label>
                                <input type="password" name="password" placeholder="Enter Common Password" class="form-control" autocomplete="new-password" required>
                            </div>

                            <div class="card-footer px-0 pb-0">
                                <button type="submit" name="submit" class="subscribe btn btn-block shadow-sm">
                                    <i class="fas fa-flag mr-2"></i> Assign House Leads
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Edit House Leads Tab -->
                    <div id="edit-house" class="tab-pane fade pt-3">
                        <div class="alert alert-info py-2 px-3 small mb-3">
                            <i class="fas fa-info-circle mr-1"></i> Choose a house team to load and edit its assigned student captains.
                        </div>
                        <form role="form" action="../routes/admin/captainEdit.php" method="post">
                            <div class="form-group">
                                <label for="house_name">
                                    <h6>Select House Team <span class="text-danger">*</span></h6>
                                </label>
                                <select id="edit_house_name" name="house_name" class="form-control" required onchange="fetchHouseLeadsData(this.value)">
                                    <option value="" disabled selected>-- Choose House Team --</option>
                                    <?php
                                    $h_query2 = mysqli_query($conn, "SELECT name, gender FROM `housedb` ORDER BY `name` ASC");
                                    while ($h = mysqli_fetch_array($h_query2)) {
                                        $h_n = htmlspecialchars($h['name']);
                                        $h_g = htmlspecialchars($h['gender']);
                                        echo "<option value=\"{$h_n}\">{$h_n} ({$h_g})</option>";
                                    }
                                    ?>
                                </select>
                                <small id="edit_house_status" class="form-text text-muted mt-1"></small>
                            </div>

                            <h6 class="text-primary mt-3 mb-2"><i class="fas fa-users mr-1"></i> Student House Captains</h6>
                            <div class="row">
                                <div class="col-md-4 form-group">
                                    <label>Captain Name</label>
                                    <input type="text" name="captain_name" placeholder="Captain Name" class="form-control">
                                </div>
                                <div class="col-md-4 form-group">
                                    <label>Captain Reg No</label>
                                    <input type="text" name="captain_reg_no" placeholder="Reg No" class="form-control">
                                </div>
                                <div class="col-md-4 form-group">
                                    <label>Captain Dept</label>
                                    <select name="cap_dept" class="form-control">
                                        <option value="" selected>Select Dept</option>
                                        <option value="CSE">CSE</option>
                                        <option value="ECE">ECE</option>
                                        <option value="MECH">MECH</option>
                                        <option value="CIVIL">CIVIL</option>
                                        <option value="EEE">EEE</option>
                                        <option value="IT">IT</option>
                                        <option value="AIDS">AI & DS</option>
                                    </select>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label>Vice Captain Name</label>
                                    <input type="text" name="vice_captain_name" placeholder="Vice Captain Name" class="form-control">
                                </div>
                                <div class="col-md-4 form-group">
                                    <label>Vice Captain Reg No</label>
                                    <input type="text" name="vice_captain_reg_no" placeholder="Reg No" class="form-control">
                                </div>
                                <div class="col-md-4 form-group">
                                    <label>Vice Captain Dept</label>
                                    <select name="vice_cap_dept" class="form-control">
                                        <option value="" selected>Select Dept</option>
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

                            <div class="form-group">
                                <label for="update_password">
                                    <h6>Update Password <small class="text-muted">(Leave blank to keep current password)</small></h6>
                                </label>
                                <input type="password" name="update_password" placeholder="Enter New Password (Optional)" class="form-control" autocomplete="new-password">
                            </div>

                            <div class="card-footer px-0 pb-0">
                                <button type="submit" name="submit" class="subscribe btn btn-block shadow-sm">
                                    <i class="fas fa-shield-alt mr-2"></i> Update House Leads
                                </button>
                            </div>
                        </form>
                    </div>
                        <!-- Add House Tab -->
                        <div id="add-house" class="tab-pane fade pt-3">
                            <form role="form" action="../routes/admin/addHouse.php" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="house_name">
                                        <h6>House / Team Name <span class="text-danger">*</span></h6>
                                    </label>
                                    <input type="text" name="house_name" placeholder="e.g. TITAN KNIGHTS" required class="form-control">
                                </div>

                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label for="house_id">
                                            <h6>House ID <small class="text-muted">(Optional)</small></h6>
                                        </label>
                                        <input type="number" name="house_id" placeholder="Leave empty to auto-generate" class="form-control">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="gender">
                                            <h6>Category / Gender <span class="text-danger">*</span></h6>
                                        </label>
                                        <select name="gender" class="form-control" required>
                                            <option value="COMMON">COMMON</option>
                                            <option value="BOYS">BOYS</option>
                                            <option value="GIRLS">GIRLS</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label for="score">
                                            <h6>Initial Score</h6>
                                        </label>
                                        <input type="number" name="score" value="0" placeholder="0" class="form-control" required>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="house_logo">
                                            <h6>Team Logo <span class="text-danger">*</span></h6>
                                        </label>
                                        <input type="file" name="house_logo" accept="image/png,image/jpeg,image/webp,image/svg+xml" class="form-control" required>
                                        <small class="form-text text-muted">Uploaded logo automatically reflects in the homepage 3D rotating showcase.</small>
                                    </div>
                                </div>

                                <div class="card-footer px-0 pb-0">
                                    <button type="submit" class="subscribe btn btn-block shadow-sm">
                                        <i class="fas fa-plus-circle mr-2"></i> Add House Team
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Add Students Data Tab -->
                        <div id="add-student" class="tab-pane fade pt-3">
                            <!-- CSV Format Guide & Download -->
                            <div class="card bg-light border-info mb-3">
                                <div class="card-header bg-info text-white py-2 d-flex justify-content-between align-items-center">
                                    <span><i class="fas fa-info-circle mr-2"></i>CSV File Format Guide</span>
                                    <button type="button" class="btn btn-sm btn-light font-weight-bold text-info" onclick="downloadSampleCSV()">
                                        <i class="fas fa-download mr-1"></i> Download Sample CSV
                                    </button>
                                </div>
                                <div class="card-body py-2 px-3">
                                    <p class="small text-muted mb-2">Ensure your CSV file matches the following structure before uploading:</p>
                                    <div class="table-responsive">
                                        <table class="table table-sm table-bordered bg-white mb-1" style="font-size: 13px;">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>Column Header</th>
                                                    <th>Required</th>
                                                    <th>Description & Examples</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><code>name</code></td>
                                                    <td><span class="badge badge-danger">Required</span></td>
                                                    <td>Student full name (e.g., <em>John Doe</em>)</td>
                                                </tr>
                                                <tr>
                                                    <td><code>reg_no</code></td>
                                                    <td><span class="badge badge-danger">Required</span></td>
                                                    <td>Register / Admission number (e.g., <em>952221104001</em>)</td>
                                                </tr>
                                                <tr>
                                                    <td><code>dept</code></td>
                                                    <td><span class="badge badge-secondary">Optional</span></td>
                                                    <td>Department / Branch (e.g., <em>CSE, ECE, MECH, CIVIL, AI&DS</em>)</td>
                                                </tr>
                                                <tr>
                                                    <td><code>year</code></td>
                                                    <td><span class="badge badge-secondary">Optional</span></td>
                                                    <td>Batch year or class (e.g., <em>2022, 2023, 2024, 2025</em> or <em>I, II, III, IV</em>)</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <form role="form" action="../routes/admin/insertStudentDetails.php" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="house_name">
                                        <h6>House Name <span class="text-danger">*</span></h6>
                                    </label>
                                    <select name="house_name" class="form-control" required>
                                        <option value="" disabled selected>-- Select House Team --</option>
                                        <?php
                                        $house_details = mysqli_query($conn, "SELECT * FROM `housedb` ORDER BY `name` ASC");
                                        while ($house_detail = mysqli_fetch_array($house_details)) {
                                            $h_name = htmlspecialchars($house_detail['name']);
                                            $h_gender = htmlspecialchars($house_detail['gender']);
                                            echo "<option value=\"{$h_name}\">{$h_name} ({$h_gender})</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="gender">
                                        <h6>Category / Gender <span class="text-danger">*</span></h6>
                                    </label>
                                    <select name="gender" class="form-control" required>
                                        <option value="BOYS">BOYS</option>
                                        <option value="GIRLS">GIRLS</option>
                                        <option value="COMMON">COMMON</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="csvFile">
                                        <h6>Upload CSV File <span class="text-danger">*</span></h6>
                                    </label>
                                    <div class="custom-file">
                                        <input type="file" name="csvFile" id="csvFile" accept=".csv" class="form-control" required>
                                    </div>
                                    <small class="form-text text-muted">Upload a .csv file structured with the columns specified in the guide above.</small>
                                </div>

                                <div class="card-footer px-0 pb-0">
                                    <button type="submit" name="importExcelFile" class="subscribe btn btn-block shadow-sm">
                                        <i class="fas fa-cloud-upload-alt mr-2"></i> Import Student Data House-Wise
                                    </button>
                                </div>
                            </form>

                            <hr class="my-4">
                            <h5 class="mb-3"><i class="fas fa-users-cog mr-2"></i>Manage Students</h5>
                            <div class="card shadow-sm">
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="manage_house_select"><strong>Select House</strong></label>
                                            <select id="manage_house_select" class="form-control" onchange="loadStudentsForHouse()">
                                                <option value="">-- Select House --</option>
                                                <?php
                                                $q = mysqli_query($conn, "SELECT name FROM housedb ORDER BY name ASC");
                                                while ($h = mysqli_fetch_assoc($q)) {
                                                    echo '<option value="' . htmlspecialchars($h['name']) . '">' . htmlspecialchars($h['name']) . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="table-responsive" id="manage_students_table_container" style="display: none; max-height: 400px; overflow-y: auto;">
                                        <table class="table table-bordered table-hover table-sm" style="font-size: 13px;">
                                            <thead class="thead-light" style="position: sticky; top: 0; z-index: 1;">
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Reg No</th>
                                                    <th>Dept</th>
                                                    <th>Year</th>
                                                    <th>Gender</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="manage_students_tbody">
                                                <!-- Students loaded via AJAX -->
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="mt-3 d-flex justify-content-between align-items-center">
                                        <div id="manage_students_status" class="text-muted small"></div>
                                        <button type="button" id="delete_all_students_btn" class="btn btn-sm btn-danger shadow-sm" style="display: none;" onclick="deleteAllStudentsInHouse()">
                                            <i class="fas fa-trash-alt mr-1"></i> Delete All in House
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- End tab-content -->



<!-- Edit Student Modal -->
<div class="modal fade" id="editStudentModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title"><i class="fas fa-user-edit mr-2"></i>Edit Student</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editStudentForm">
                    <input type="hidden" name="id" id="edit_stu_id">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" id="edit_stu_name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Register No</label>
                        <input type="text" name="reg_no" id="edit_stu_reg_no" class="form-control" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Department</label>
                            <input type="text" name="dept" id="edit_stu_dept" class="form-control">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Year</label>
                            <input type="text" name="year" id="edit_stu_year" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>House</label>
                            <input type="text" name="house" id="edit_stu_house" class="form-control" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Gender</label>
                            <select name="gender" id="edit_stu_gender" class="form-control" required>
                                <option value="BOYS">BOYS</option>
                                <option value="GIRLS">GIRLS</option>
                            </select>
                        </div>
                    </div>
                </form>
                <div id="edit_stu_status"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-info" onclick="saveStudentEdit()"><i class="fas fa-save mr-1"></i> Save Changes</button>
            </div>
        </div>
    </div>
</div>

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

    const interval = setInterval(function () {
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
        d.addEventListener('animationend', function () {
            d.parentElement.removeChild(d);
        }.bind(this));
    }
    document.addEventListener('click', clickEffect);

    function downloadSampleCSV() {
        const csvContent = "name,reg_no,dept,year\nJohn Doe,952221104001,CSE,2022\nJane Smith,952221104002,ECE,2023\nRobert Brown,952221104003,MECH,2024\nAlice White,952221104004,AI&DS,2025\n";
        const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
        const link = document.createElement("a");
        const url = URL.createObjectURL(blob);
        link.setAttribute("href", url);
        link.setAttribute("download", "students_template.csv");
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        URL.revokeObjectURL(url);
    }

    // Tab Activation helper
    function activateTab(tabId) {
        $('ul.nav-pills a[href="#' + tabId + '"]').tab('show');
    }

    function setSelectValueSafely(selectEl, value) {
        if (!selectEl || value === undefined || value === null) return;
        var raw = String(value).trim();
        if (!raw || raw === '-') {
            selectEl.selectedIndex = 0;
            return;
        }
        
        // Exact match
        for (var i = 0; i < selectEl.options.length; i++) {
            if (selectEl.options[i].value === raw) {
                selectEl.selectedIndex = i;
                return;
            }
        }

        // Normalized match
        var cleanVal = raw.toUpperCase().replace(/[^A-Z0-9]/g, '');
        for (var j = 0; j < selectEl.options.length; j++) {
            var opt = selectEl.options[j];
            var optVal = opt.value.toUpperCase().replace(/[^A-Z0-9]/g, '');
            var optText = opt.text.toUpperCase().replace(/[^A-Z0-9]/g, '');
            if (optVal === cleanVal || optText === cleanVal) {
                selectEl.selectedIndex = j;
                return;
            }
        }
    }

    // Fetch and populate Event details
    function fetchEventData(eventName) {
        if (!eventName) return;
        var statusEl = document.getElementById('edit_event_status');
        if (statusEl) {
            statusEl.innerHTML = '<span class="text-info"><i class="fas fa-spinner fa-spin mr-1"></i> Loading event data...</span>';
        }

        fetch('../routes/admin/getFormData.php?action=get_event&name=' + encodeURIComponent(eventName))
            .then(function(res) { return res.json(); })
            .then(function(resp) {
                if (resp.status === 'success' && resp.data) {
                    var d = resp.data;
                    var form = document.querySelector('#edit-event form');
                    if (!form) return;

                    form.querySelector('[name="event_id"]').value = d.event_id || '';
                    form.querySelector('[name="event_date"]').value = d.event_date || '';
                    form.querySelector('[name="event_time"]').value = d.event_time || '';
                    form.querySelector('[name="event_venue"]').value = d.event_venue || '';
                    form.querySelector('[name="max_participants"]').value = d.max_participants || '';
                    form.querySelector('[name="is_group"]').value = d.is_group !== undefined ? d.is_group : '';
                    form.querySelector('[name="group_counts"]').value = d.group_counts || 0;
                    form.querySelector('[name="group_participants"]').value = d.group_participants || 0;
                    form.querySelector('[name="allowance"]').value = d.allowance || '';
                    form.querySelector('[name="event_rules"]').value = d.event_rules || '';

                    var genderSelect = form.querySelector('[name="gender"]');
                    if (genderSelect && d.gender) {
                        genderSelect.value = d.gender;
                    }
                    var eventTypeSelect = form.querySelector('[name="event_type"]');
                    if (eventTypeSelect && d.event_type) {
                        eventTypeSelect.value = d.event_type;
                    }

                    var imgBox = document.getElementById('edit_event_image_box');
                    var imgPrev = document.getElementById('edit_event_image_preview');
                    if (d.image && imgBox && imgPrev) {
                        imgPrev.src = '../public/event_images/' + d.image;
                        imgBox.style.display = 'block';
                    } else if (imgBox) {
                        imgBox.style.display = 'none';
                    }

                    if (statusEl) {
                        statusEl.innerHTML = '<span class="text-success"><i class="fas fa-check-circle mr-1"></i> Loaded details for <strong>' + eventName + '</strong></span>';
                    }
                } else {
                    if (statusEl) {
                        statusEl.innerHTML = '<span class="text-danger"><i class="fas fa-exclamation-triangle mr-1"></i> ' + (resp.message || 'Failed to load details') + '</span>';
                    }
                }
            })
            .catch(function(err) {
                console.error(err);
                if (statusEl) {
                    statusEl.innerHTML = '<span class="text-danger"><i class="fas fa-exclamation-triangle mr-1"></i> Communication error</span>';
                }
            });
    }

    // Safe JSON parser to handle free hosting HTML injections
    const originalJson = Response.prototype.json;
    Response.prototype.json = function() {
        return this.text().then(text => {
            try {
                return JSON.parse(text);
            } catch (e) {
                const match = text.match(/(\{[\s\S]*\}|\[[\s\S]*\])/);
                if (match) {
                    try {
                        return JSON.parse(match[0]);
                    } catch (err) {
                        console.error("Failed to parse extracted JSON:", err);
                        throw e;
                    }
                }
                console.error("Invalid JSON response:", text);
                throw e;
            }
        });
    };

    // Check existing coordinators on Assign Coordinator tab
    function checkExistingCoordinator(eventName) {
        if (!eventName) return;
        var noticeEl = document.getElementById('assign_coord_notice');
        if (!noticeEl) return;

        fetch('../routes/admin/getFormData.php?action=get_coordinator&event=' + encodeURIComponent(eventName))
            .then(function(res) { return res.json(); })
            .then(function(resp) {
                if (resp.status === 'success' && (resp.coordinator_1 || resp.coordinator_2)) {
                    var names = [];
                    if (resp.coordinator_1 && resp.coordinator_1.name) names.push(resp.coordinator_1.name);
                    if (resp.coordinator_2 && resp.coordinator_2.name) names.push(resp.coordinator_2.name);
                    
                    noticeEl.innerHTML = '<i class="fas fa-exclamation-circle mr-1"></i> Notice: Coordinators (' + (names.join(' & ') || 'Assigned') + ') already exist for this event. You can edit them in the <a href="#edit-coordinator" onclick="activateTab(\'edit-coordinator\')" class="alert-link font-weight-bold">Edit Coordinators</a> tab.';
                    noticeEl.style.display = 'block';
                } else {
                    noticeEl.style.display = 'none';
                }
            })
            .catch(function() {
                noticeEl.style.display = 'none';
            });
    }

    // Filter and populate students dropdown dynamically based on Year and Dept
    function filterStudents(prefix) {
        var yearEl = document.getElementById(prefix + '_year');
        var deptEl = document.getElementById(prefix + '_dept');
        var selectEl = document.getElementById(prefix + '_student_select');

        if (!selectEl) return;

        var year = yearEl ? yearEl.value : '';
        var dept = deptEl ? deptEl.value : '';

        selectEl.innerHTML = '<option value="">Loading students...</option>';

        var url = '../routes/admin/getFormData.php?action=filter_students&year=' + encodeURIComponent(year) + '&dept=' + encodeURIComponent(dept);

        fetch(url)
            .then(function(res) { return res.json(); })
            .then(function(resp) {
                if (resp.status === 'success' && Array.isArray(resp.students)) {
                    var html = '<option value="">-- Choose Student (' + resp.students.length + ' available) --</option>';
                    resp.students.forEach(function(stu) {
                        var safeName = (stu.name || '').replace(/"/g, '&quot;');
                        var safeReg = (stu.reg_no || '').replace(/"/g, '&quot;');
                        var safeDept = (stu.dept || '').replace(/"/g, '&quot;');
                        var safeYear = stu.year || '';
                        var label = stu.name + ' (' + stu.reg_no + ' - ' + stu.dept + ' Yr ' + safeYear + ')';
                        html += '<option value="' + safeReg + '" data-name="' + safeName + '" data-reg="' + safeReg + '" data-dept="' + safeDept + '">' + label + '</option>';
                    });
                    selectEl.innerHTML = html;
                } else {
                    selectEl.innerHTML = '<option value="">No students found</option>';
                }
            })
            .catch(function(err) {
                console.error(err);
                selectEl.innerHTML = '<option value="">Error loading students</option>';
            });
    }

    // Auto-fill student coordinator fields when selected from dropdown
    function onStudentPicked(prefix, selectEl) {
        if (!selectEl || !selectEl.selectedIndex) return;
        var opt = selectEl.options[selectEl.selectedIndex];
        if (!opt || !opt.value) return;

        var name = opt.getAttribute('data-name') || '';
        var reg = opt.getAttribute('data-reg') || '';
        var dept = opt.getAttribute('data-dept') || '';

        var nameInput = document.getElementById(prefix + '_name');
        var regInput = document.getElementById(prefix + '_reg');
        var deptSelect = document.getElementById(prefix + '_dept_select');

        if (nameInput) nameInput.value = name;
        if (regInput) regInput.value = reg;
        if (deptSelect) setSelectValueSafely(deptSelect, dept);
    }

    // Auto-activate tab based on URL hash and initialize student filters
    jQuery(document).ready(function($) {
        if (window.location.hash) {
            var hashTab = window.location.hash;
            var tabLink = $('ul.nav-pills a[href="' + hashTab + '"]');
            if (tabLink.length) {
                tabLink.tab('show');
            }
        }

        // Initialize student filters on coordinator forms
        filterStudents('assign_c1');
        filterStudents('assign_c2');
        filterStudents('edit_c1');
        filterStudents('edit_c2');
    });

    // Fetch coordinator data on Edit Coordinator tab
    function fetchCoordinatorData(eventName) {
        if (!eventName) return;
        var form = document.querySelector('#edit-coordinator form');
        if (!form) return;
        var statusEl = document.getElementById('edit_coord_status');
        if (statusEl) {
            statusEl.innerHTML = '<span class="text-info"><i class="fas fa-spinner fa-spin mr-1"></i> Loading coordinator details...</span>';
        }

        fetch('../routes/admin/getFormData.php?action=get_coordinator&event=' + encodeURIComponent(eventName))
            .then(function(res) { return res.json(); })
            .then(function(resp) {
                if (resp.status === 'success') {
                    var c1 = resp.coordinator_1 || {};
                    var c2 = resp.coordinator_2 || {};

                    var c1Name = document.getElementById('edit_c1_name');
                    var c1Reg = document.getElementById('edit_c1_reg');
                    var c1Dept = document.getElementById('edit_c1_dept_select');

                    var c2Name = document.getElementById('edit_c2_name');
                    var c2Reg = document.getElementById('edit_c2_reg');
                    var c2Dept = document.getElementById('edit_c2_dept_select');

                    if (c1Name) c1Name.value = c1.name || '';
                    if (c1Reg) c1Reg.value = (c1.reg_no && c1.reg_no !== '-') ? c1.reg_no : '';
                    if (c1Dept) setSelectValueSafely(c1Dept, c1.dept);

                    if (c2Name) c2Name.value = c2.name || '';
                    if (c2Reg) c2Reg.value = (c2.reg_no && c2.reg_no !== '-') ? c2.reg_no : '';
                    if (c2Dept) setSelectValueSafely(c2Dept, c2.dept);

                    if (statusEl) {
                        if (c1.name || c2.name) {
                            var details = [];
                            if (c1.name) details.push('<strong>' + c1.name + '</strong> (' + (c1.dept || 'N/A') + ')');
                            if (c2.name) details.push('<strong>' + c2.name + '</strong> (' + (c2.dept || 'N/A') + ')');
                            statusEl.innerHTML = '<span class="text-success"><i class="fas fa-check-circle mr-1"></i> Loaded coordinators: ' + details.join(' and ') + '</span>';
                        } else {
                            statusEl.innerHTML = '<span class="text-warning"><i class="fas fa-info-circle mr-1"></i> No coordinators currently assigned for <strong>' + eventName + '</strong>. Enter or select students below to save them.</span>';
                        }
                    }
                } else {
                    if (statusEl) {
                        statusEl.innerHTML = '<span class="text-danger"><i class="fas fa-exclamation-triangle mr-1"></i> ' + (resp.message || 'Error fetching coordinator') + '</span>';
                    }
                }
            })
            .catch(function(err) {
                console.error(err);
                if (statusEl) {
                    statusEl.innerHTML = '<span class="text-danger"><i class="fas fa-exclamation-triangle mr-1"></i> Connection error loading coordinators</span>';
                }
            });
    }

    // Check existing house leads on Assign House Leads tab
    function checkExistingHouseLeads(houseName) {
        if (!houseName) return;
        var noticeEl = document.getElementById('assign_house_notice');
        if (!noticeEl) return;

        fetch('../routes/admin/getFormData.php?action=get_house_leads&house=' + encodeURIComponent(houseName))
            .then(function(res) { return res.json(); })
            .then(function(resp) {
                if (resp.status === 'success' && (resp.captain || resp.vice_captain)) {
                    noticeEl.innerHTML = '<i class="fas fa-exclamation-circle mr-1"></i> Notice: Student Captains are already registered for <strong>' + houseName + '</strong>. You can view and update them in the <a href="#edit-house" onclick="activateTab(\'edit-house\')" class="alert-link font-weight-bold">Edit House Leads</a> tab.';
                    noticeEl.style.display = 'block';
                } else {
                    noticeEl.style.display = 'none';
                }
            })
            .catch(function() {
                noticeEl.style.display = 'none';
            });
    }

    // Fetch house leads on Edit House Leads tab
    function fetchHouseLeadsData(houseName) {
        if (!houseName) return;
        var form = document.querySelector('#edit-house form');
        if (!form) return;
        var statusEl = document.getElementById('edit_house_status');
        if (statusEl) {
            statusEl.innerHTML = '<span class="text-info"><i class="fas fa-spinner fa-spin mr-1"></i> Loading house captains details...</span>';
        }

        fetch('../routes/admin/getFormData.php?action=get_house_leads&house=' + encodeURIComponent(houseName))
            .then(function(res) { return res.json(); })
            .then(function(resp) {
                if (resp.status === 'success') {
                    var cap = resp.captain || {};
                    var vcap = resp.vice_captain || {};

                    var capName = form.querySelector('[name="captain_name"]');
                    var capReg = form.querySelector('[name="captain_reg_no"]');
                    var capDept = form.querySelector('[name="cap_dept"]');
                    var vcapName = form.querySelector('[name="vice_captain_name"]');
                    var vcapReg = form.querySelector('[name="vice_captain_reg_no"]');
                    var vcapDept = form.querySelector('[name="vice_cap_dept"]');

                    if (capName) capName.value = cap.name || '';
                    if (capReg) capReg.value = (cap.reg_no && cap.reg_no !== '-') ? cap.reg_no : '';
                    setSelectValueSafely(capDept, cap.dept);

                    if (vcapName) vcapName.value = vcap.name || '';
                    if (vcapReg) vcapReg.value = (vcap.reg_no && vcap.reg_no !== '-') ? vcap.reg_no : '';
                    setSelectValueSafely(vcapDept, vcap.dept);

                    if (statusEl) {
                        if (cap.name || vcap.name) {
                            statusEl.innerHTML = '<span class="text-success"><i class="fas fa-check-circle mr-1"></i> Loaded student captains for <strong>' + houseName + '</strong></span>';
                        } else {
                            statusEl.innerHTML = '<span class="text-warning"><i class="fas fa-info-circle mr-1"></i> No captains currently assigned for <strong>' + houseName + '</strong>. Enter details below to assign them.</span>';
                        }
                    }
                } else {
                    if (statusEl) {
                        statusEl.innerHTML = '<span class="text-danger"><i class="fas fa-exclamation-triangle mr-1"></i> ' + (resp.message || 'Error fetching house leads') + '</span>';
                    }
                }
            })
            .catch(function(err) {
                console.error(err);
                if (statusEl) {
                    statusEl.innerHTML = '<span class="text-danger"><i class="fas fa-exclamation-triangle mr-1"></i> Connection error loading house leads</span>';
                }
            });
    }
</script>










<script>
    // Load students for manage tab
    function loadStudentsForHouse() {
        var house = document.getElementById("manage_house_select").value;
        var tbody = document.getElementById("manage_students_tbody");
        var container = document.getElementById("manage_students_table_container");
        var status = document.getElementById("manage_students_status");
        var btnDeleteAll = document.getElementById("delete_all_students_btn");
        
        if (!house) {
            container.style.display = "none";
            if (btnDeleteAll) btnDeleteAll.style.display = "none";
            return;
        }
        
        status.innerHTML = "<i class='fas fa-spinner fa-spin mr-1'></i> Loading...";
        tbody.innerHTML = "";
        if (btnDeleteAll) btnDeleteAll.style.display = "none";
        
        fetch("../routes/admin/getFormData.php?action=filter_students&house=" + encodeURIComponent(house))
            .then(res => res.json())
            .then(resp => {
                if (resp.status === "success" && resp.students.length > 0) {
                    var html = "";
                    resp.students.forEach(s => {
                        var safeJson = JSON.stringify(s).replace(/"/g, "&quot;");
                        html += "<tr>" +
                            "<td>" + (s.name || "") + "</td>" +
                            "<td>" + (s.reg_no || "") + "</td>" +
                            "<td>" + (s.dept || "") + "</td>" +
                            "<td>" + (s.year || "") + "</td>" +
                            "<td>" + (s.gender || "") + "</td>" +
                            "<td>" + 
                                "<button type='button' class='btn btn-sm btn-outline-info py-0 px-2 mr-1' onclick='openEditStudentModal(" + safeJson + ")'><i class='fas fa-edit'></i> Edit</button>" +
                                "<button type='button' class='btn btn-sm btn-outline-danger py-0 px-2' onclick='deleteStudent(" + s.id + ")'><i class='fas fa-trash-alt'></i> Delete</button>" +
                            "</td>" +
                            "</tr>";
                    });
                    tbody.innerHTML = html;
                    container.style.display = "block";
                    status.innerHTML = "Found " + resp.students.length + " students.";
                    if (btnDeleteAll) btnDeleteAll.style.display = "inline-block";
                } else {
                    container.style.display = "block";
                    tbody.innerHTML = "<tr><td colspan='6' class='text-center text-muted'>No students found for this house.</td></tr>";
                    status.innerHTML = "";
                    if (btnDeleteAll) btnDeleteAll.style.display = "none";
                }
            })
            .catch(err => {
                console.error(err);
                status.innerHTML = "<span class='text-danger'>Error loading students.</span>";
            });
    }

    // Open edit student modal
    function openEditStudentModal(student) {
        document.getElementById("edit_stu_id").value = student.id || "";
        document.getElementById("edit_stu_name").value = student.name || "";
        document.getElementById("edit_stu_reg_no").value = student.reg_no || "";
        document.getElementById("edit_stu_dept").value = student.dept || "";
        document.getElementById("edit_stu_year").value = student.year || "";
        document.getElementById("edit_stu_house").value = student.house || "";
        document.getElementById("edit_stu_gender").value = student.gender || "Male";
        document.getElementById("edit_stu_status").innerHTML = "";
        
        jQuery("#editStudentModal").modal("show");
    }

    // Save student edit
    function saveStudentEdit() {
        var form = document.getElementById("editStudentForm");
        if (!form.reportValidity()) return;
        
        var fd = new FormData(form);
        var btn = document.querySelector("#editStudentModal .btn-info");
        var status = document.getElementById("edit_stu_status");
        
        btn.disabled = true;
        btn.innerHTML = "<i class='fas fa-spinner fa-spin mr-1'></i> Saving...";
        
        fetch("../routes/admin/updateStudent.php", {
            method: "POST",
            body: fd
        })
        .then(res => res.json())
        .then(resp => {
            if (resp.status === "success") {
                status.innerHTML = "<div class='alert alert-success py-1 mb-0'>" + resp.message + "</div>";
                setTimeout(() => {
                    jQuery("#editStudentModal").modal("hide");
                    loadStudentsForHouse(); // reload table
                }, 1000);
            } else {
                status.innerHTML = "<div class='alert alert-danger py-1 mb-0'>" + (resp.message || "Error saving") + "</div>";
            }
        })
        .catch(err => {
            console.error(err);
            status.innerHTML = "<div class='alert alert-danger py-1 mb-0'>Communication error</div>";
        })
        .finally(() => {
            btn.disabled = false;
            btn.innerHTML = "<i class='fas fa-save mr-1'></i> Save Changes";
        });
    }

    // Delete student
    function deleteStudent(id) {
        if (!confirm("Are you sure you want to delete this student?")) return;
        fetch("../routes/admin/deleteStudent.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: "action=delete&id=" + encodeURIComponent(id)
        })
        .then(res => res.json())
        .then(resp => {
            if (resp.status === "success") {
                loadStudentsForHouse();
            } else {
                alert(resp.message || "Failed to delete student");
            }
        })
        .catch(err => {
            console.error(err);
            alert("Error deleting student");
        });
    }

    // Delete all students in a house
    function deleteAllStudentsInHouse() {
        var house = document.getElementById("manage_house_select").value;
        if (!house) return;
        if (!confirm("Are you sure you want to delete ALL students in " + house + "? This action CANNOT be undone!")) return;
        
        var btn = document.getElementById("delete_all_students_btn");
        btn.disabled = true;
        btn.innerHTML = "<i class='fas fa-spinner fa-spin mr-1'></i> Deleting...";
        
        fetch("../routes/admin/deleteStudent.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: "action=delete_all_in_house&house=" + encodeURIComponent(house)
        })
        .then(res => res.json())
        .then(resp => {
            if (resp.status === "success") {
                alert("All students in " + house + " have been deleted.");
                loadStudentsForHouse();
            } else {
                alert(resp.message || "Failed to delete students");
            }
        })
        .catch(err => {
            console.error(err);
            alert("Error deleting students");
        })
        .finally(() => {
            btn.disabled = false;
            btn.innerHTML = "<i class='fas fa-trash-alt mr-1'></i> Delete All in House";
        });
    }
</script>



<script>
    // Client-side image size validation for Add Event form
    document.addEventListener('DOMContentLoaded', function() {
        var addEventForm = document.querySelector('#add-event form');
        if (addEventForm) {
            addEventForm.addEventListener('submit', function(e) {
                var fileInput = addEventForm.querySelector('input[name="image"]');
                if (fileInput && fileInput.files.length > 0) {
                    var file = fileInput.files[0];
                    var maxSize = 5 * 1024 * 1024; // 5MB
                    var allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

                    if (!allowedTypes.includes(file.type)) {
                        e.preventDefault();
                        alert('Invalid image format! Allowed formats: JPG, PNG, GIF, WEBP.\n\nYou selected: ' + file.type);
                        return false;
                    }

                    if (file.size > maxSize) {
                        e.preventDefault();
                        var sizeMB = (file.size / (1024 * 1024)).toFixed(2);
                        alert('Image too large!\n\nYour file: ' + sizeMB + ' MB\nMaximum allowed: 5 MB\n\nPlease compress or resize your image before uploading.');
                        return false;
                    }
                }
            });
        }

        // Show error as popup if redirected with ?error=
        var urlParams = new URLSearchParams(window.location.search);
        var errorMsg = urlParams.get('error');
        if (errorMsg) {
            alert('Error: ' + decodeURIComponent(errorMsg));
        }
    });
</script>


