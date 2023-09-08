<?php
// session_start();

// if (!isset($_SESSION['role']) && !isset($_SESSION['name']) && !isset($_SESSION['reg_no'])) {
//     header('Location: /'); 
//     exit();
// }

include('../routes/connect.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>House | Dashboard</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="../public/css/houseDashboardStyles.css">
</head>

<body>
    <div class="card dark">
        <img src="https://codingyaar.com/wp-content/uploads/chair-image.jpg" class="card-img-top" alt="...">
        <div class="card-body">
            <div class="text-section">
                <h1 class='card-title'>Team Name !</h1>
                <h5 class="card-text">Team Captain</h5>
                <h5 class="card-text">vice captain</h5>
                <h5 class="card-text">total members</h5>
                <h5 class="card-text">participents count</h5>
            </div>
            <div class="cta-section">
                <div>Score: 0</div>
                <!-- <a href="#" class="btn btn-light">Buy Now</a> -->
            </div>
        </div>
    </div>

    <!-- table -->

    <div class="container">
        <div class="row">
            <div class="col-md-offset-1 col-md-12">
                <div class="panel">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col col-sm-3 col-xs-12">
                                <h4 class="title">Event <span>Details</span></h4>
                            </div>
                            <!-- <div class="col-sm-9 col-xs-12 text-right">
                                <div class="btn_group">
                                    <input type="text" class="form-control" placeholder="Search">
                                    <button class="btn btn-default" title="Reload"><i
                                            class="fa fa-sync-alt"></i></button>
                                    <button class="btn btn-default" title="Pdf"><i class="fa fa-file-pdf"></i></button>
                                    <button class="btn btn-default" title="Excel"><i
                                            class="fas fa-file-excel"></i></button>
                                </div>
                            </div> -->
                        </div>
                    </div>
                    <div class="panel-body table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th> </th>
                                    <th>Event Name</th>
                                    <th>Event Coordinator</th>
                                    <th>Max Participants</th>
                                    <th>Registered Participants</th>
                                    <th>Group</th>
                                    <th>Group Count</th>
                                    <th>Update</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Vincent Williamson</td>
                                    <td>31</td>
                                    <td>iOS Developer</td>
                                    <td>Sinaai-Waas</td>
                                    <td>Sinaai-Waas</td>
                                    <td>Sinaai-Waas</td>

                                    <td>
                                        <ul class="action-list">
                                            <li><a href="#" data-tip="edit"><i class="fa fa-edit"></i></a></li>
                                            <li><a href="#" data-tip="delete"><i class="fa fa-trash"></i></a></li>
                                        </ul>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="../public/js/jquery.js"></script>
    <script src="https://kit.fontawesome.com/6a9b11d703.js" crossorigin="anonymous"></script>
</body>

</html>