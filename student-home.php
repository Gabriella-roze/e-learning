<?php
// Connect to db
require_once(__DIR__.'/db/db.php');

// Get user resources from db
try {
  $all_love_recieved = 0;
  $q = $db->prepare('SELECT * FROM exam.resources WHERE user_id=1 ORDER BY votes DESC;');
    $q->execute();
    $user_resources = $q->fetchAll();

    foreach($user_resources  as $resource){
      $all_love_recieved += $resource['votes'];
      }

  } catch(PDOException $ex) {
  echo $ex->getMessage();
  exit();
  }

// Get the resource that has most votes
  // try {
  //   $all_love_recieved = 0;
  //   $q = $db->prepare('SELECT * FROM exam.resources ORDER BY votes DESC LIMIT 1;');
  //     $q->execute();
  //     $best_resource = $q->fetchAll()[0];

  //     print_r($best_resource);
  
  //   } catch(PDOException $ex) {
  //   echo $ex->getMessage();
  //   exit();
  //   }


// Get topics from db
try {
$q = $db->prepare('SELECT * FROM exam.topic;');
  $q->execute();
  $topics = $q->fetchAll();
// print_r($topics);

  foreach($topics  as $topic){
    // $topic['votes'];
    }

} catch(PDOException $ex) {
echo $ex->getMessage();
exit();
}

// Get user passed quizzes from db
try {
  $q = $db->prepare('SELECT count(*) FROM exam.user_topic_log WHERE user_id=1 AND quiz_passed=true;');
    $q->execute();
    $passed_topics_count = $q->fetchAll();
  } catch(PDOException $ex) {
  echo $ex->getMessage();
  exit();
  }

  // Get best resource (resources are sorted by votes in db)
  try {
  $q = $db->prepare('SELECT * FROM exam.resources_view LIMIT 1;');
  $q->execute();
  $best_resource = $q->fetchAll()[0];
  print_r($best_resources);

} catch(PDOException $ex) {
echo $ex->getMessage();
exit();
}

?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>E-learning | Tables</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <link rel="stylesheet" href="css/tables.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="index.html">DB e-learning</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                <div class="input-group">
                    <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                    <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
                </div>
            </form>
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#">Settings</a></li>
                        <li><a class="dropdown-item" href="#">Activity Log</a></li>
                        <li><hr class="dropdown-divider" /></li>
                        <li><a class="dropdown-item" href="#">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Main</div>
                            <a class="nav-link" href="student-home.html">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard
                            </a>
                            <div class="sb-sidenav-menu-heading">Topics</div>
                            <a class="nav-link" href="topic1.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Topic 1
                            </a>
                            <a class="nav-link" href="index.html">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Topic 2
                            </a>
                            <a class="nav-link" href="index.html">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Topic 3
                            </a>
                            <a class="nav-link" href="index.html">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Topic 4
                            </a>
                            <a class="nav-link" href="index.html">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Topic 5
                            </a>
                            <a class="nav-link" href="index.html">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Topic 6
                            </a>
                            <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
                                        Authentication
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <a class="nav-link" href="login.html">Login</a>
                                            <a class="nav-link" href="register.html">Register</a>
                                            <a class="nav-link" href="password.html">Forgot Password</a>
                                        </nav>
                                    </div>
                                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseError" aria-expanded="false" aria-controls="pagesCollapseError">
                                        Error
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <a class="nav-link" href="401.html">401 Page</a>
                                            <a class="nav-link" href="404.html">404 Page</a>
                                            <a class="nav-link" href="500.html">500 Page</a>
                                        </nav>
                                    </div>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        Student
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Hello!</h1>
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="main-content">
                                    <div class="header bg-gradient-primary">
                                      <div class="container-fluid">
                                        <div class="header-body">
                                          <div class="row">
                                            <div class="col-xl-3 col-lg-6">
                                              <div class="card card-stats mb-4 mb-xl-0">
                                                <div class="card-body">
                                                  <div class="row">
                                                    <div class="col">
                                                      <h5 class="card-title text-uppercase text-muted mb-0">Available Topics</h5>
                                                      <span class="h2 font-weight-bold mb-0"><?= count($topics)?></span>
                                                    </div>
                                                    <div class="col-auto">
                                                      <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                                                        <i class="fas fa-chart-bar"></i>
                                                      </div>
                                                    </div>
                                                  </div>
                                                  <p class="mt-3 mb-0 text-muted text-sm">
                                                    <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 2</span>
                                                    <span class="text-nowrap">Since last month</span>
                                                  </p>
                                                </div>
                                              </div>
                                            </div>
                                            <div class="col-xl-3 col-lg-6">
                                              <div class="card card-stats mb-4 mb-xl-0">
                                                <div class="card-body">
                                                  <div class="row">
                                                    <div class="col">
                                                      <h5 class="card-title text-uppercase text-muted mb-0">Completed Topics</h5>
                                                      <span class="h2 font-weight-bold mb-0"><?= $passed_topics_count[0]['count']?></span>
                                                    </div>
                                                    <div class="col-auto">
                                                      <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                                                        <i class="fas fa-chart-pie"></i>
                                                      </div>
                                                    </div>
                                                  </div>
                                                  <p class="mt-3 mb-0 text-muted text-sm">
                                                    <span class="text-success mr-2"><i class="fas fa-arrow-up"></i> 66.7%</span>
                                                    <span class="text-nowrap">Completed</span>
                                                  </p>
                                                </div>
                                              </div>
                                            </div>
                                            <div class="col-xl-3 col-lg-6">
                                              <div class="card card-stats mb-4 mb-xl-0">
                                                <div class="card-body">
                                                  <div class="row">
                                                    <div class="col">
                                                      <h5 class="card-title text-uppercase text-muted mb-0">Resources uploaded</h5>
                                                      <span class="h2 font-weight-bold mb-0"><?= count($user_resources) ?></span>
                                                    </div>
                                                    <div class="col-auto">
                                                      <div class="icon icon-shape bg-yellow text-white rounded-circle shadow">
                                                        <i class="fas fa-users"></i>
                                                      </div>
                                                    </div>
                                                  </div>
                                                  <p class="mt-3 mb-0 text-muted text-sm">
                                                    <span class="text-warning mr-2"><i class="fas fa-arrow-up"></i> 100%</span>
                                                    <span class="text-nowrap">Since last month</span>
                                                  </p>
                                                </div>
                                              </div>
                                            </div>
                                            <div class="col-xl-3 col-lg-6">
                                              <div class="card card-stats mb-4 mb-xl-0">
                                                <div class="card-body">
                                                  <div class="row">
                                                    <div class="col">
                                                      <h5 class="card-title text-uppercase text-muted mb-0">Your resources loved</h5>
                                                      <span class="h2 font-weight-bold mb-0"><?= $all_love_recieved?></span>
                                                    </div>
                                                    <div class="col-auto">
                                                      <div class="icon icon-shape bg-info text-white rounded-circle shadow">
                                                        <i class="fas fa-grin-hearts"></i>
                                                      </div>
                                                    </div>
                                                  </div>
                                                  <p class="mt-3 mb-0 text-muted text-sm">
                                                    <span class="text-success mr-2"><i class="fas fa-arrow-up"></i> 12%</span>
                                                    <span class="text-nowrap">Since last month</span>
                                                  </p>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- TOP 3 TOPICS -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-pepper-hot me-1"></i>
                                The Hottest Topics this month
                            </div>
                            <div class="card-body row justify-content-evenly">
                              <div class="col-3 card text-center">
                                <img src="https://download.pingcap.com/images/blog/choosing-right-database-for-your-applications.png" class="card-img-top" alt="...">
                                <div class="card-body">
                                  <h5 class="card-title">Topic 1: Title of the topic</h5>
                                  <a href="topic1.php" class="btn btn-primary btn-sm">Visit topic</a>
                                </div>
                              </div>
                              <div class="col-3 card text-center" >
                                <img src="https://download.pingcap.com/images/blog/choosing-right-database-for-your-applications.png" class="card-img-top" alt="...">
                                <div class="card-body">
                                  <h5 class="card-title">Topic 3: Title of the topic</h5>
                                  <a href="topic3.html" class="btn btn-primary btn-sm">Visit topic</a>
                                </div>
                              </div>
                              <div class="col-3 card text-center" >
                                <img src="https://download.pingcap.com/images/blog/choosing-right-database-for-your-applications.png" class="card-img-top" alt="...">
                                <div class="card-body">
                                  <h5 class="card-title">Topic 4: Title of the topic</h5>
                                  <a href="topic4.html" class="btn btn-primary btn-sm">Visit topic</a>
                                </div>
                              </div>
                        </div>
                    </div>

                    <!-- Most Loved Resources -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-grin-hearts me-1"></i>
                            The Most Loved Resource
                        </div>
                        <div class="card-body row justify-content-evenly">
                            <div class="card">
                                <div class="card-body">
                                    <h2 class="text-success"><?= $best_resource['votes']?> <i class="fas fa-grin-hearts me-1"></i></h2>
                                  <h5 class="card-title"><?= $best_resource['user_name']?> <?= $best_resource['user_last_name']?></h5>
                                  <h6 class="card-subtitle mb-2 text-muted"><?= $best_resource['topic_name']?></h6>
                                  <p class="card-text mb-0"><?= $best_resource['body']?></p>
                                  <a class="btn btn-link text-start m-0 p-0 mb-3" href="<?= $best_resource['link']?>"><?= $best_resource['link']?></a>
                                  <a href="<?= "topic{$best_resource['topic_id']}.php"?>" class="btn btn-primary btn-sm">Visit topic</a>
                                </div>
                              </div>
                    </div>
                </div>

                    <!-- PERSONAL PROGRESS -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-database me-1"></i>
                                Personal Progress
                            </div>
                            <div class="card-body">
                              <!-- HERE -->
                              <div class="card mb-3" >
                                <div class="row col-auto g-0">
                                  <div class="col-md-4" style="background: url(https://download.pingcap.com/images/blog/choosing-right-database-for-your-applications.png)  no-repeat center center / cover;">
                                  </div>
                                  <div class="col-md-8">
                                    <div class="card-body">
                                      <h4 class="card-title">Topic 1: Name of the topic</h4>
                                      <span class="badge rounded-pill bg-info mb-2">Quiz completed</span>
                                      <p class="card-text"><small class="text-muted">Last resource uploaded: 3 mins ago</small></p>
                                      <a href="topic1.php" class="btn btn-primary btn-sm">Go to topic</a>
                                    </div>
                                  </div>
                                </div>
                              </div>

                              <div class="card mb-3" >
                                <div class="row col-auto g-0">
                                  <div class="col-md-4" style="background: url(https://download.pingcap.com/images/blog/choosing-right-database-for-your-applications.png)  no-repeat center center / cover;">
                                  </div>
                                  <div class="col-md-8">
                                    <div class="card-body">
                                      <h4 class="card-title">Topic 2: Name of the topic</h4>
                                      <span class="badge rounded-pill bg-info mb-2">Quiz completed</span>
                                      <p class="card-text"><small class="text-muted">Last resource uploaded: 3 mins ago</small></p>
                                      <a href="tolic2.html" class="btn btn-primary btn-sm">Go to topic</a>
                                    </div>
                                  </div>
                                </div>
                              </div>

                              <div class="card mb-3" >
                                <div class="row col-auto g-0">
                                  <div class="col-md-4" style="background: url(https://download.pingcap.com/images/blog/choosing-right-database-for-your-applications.png)  no-repeat center center / cover;">
                                  </div>
                                  <div class="col-md-8">
                                    <div class="card-body">
                                      <h4 class="card-title">Topic 3: Name of the topic</h4>
                                      <span class="badge rounded-pill bg-info mb-2">Quiz completed</span>
                                      <p class="card-text"><small class="text-muted">Last resource uploaded: 3 mins ago</small></p>
                                      <a href="topic3.html" class="btn btn-primary btn-sm">Go to topic</a>
                                    </div>
                                  </div>
                                </div>
                              </div>

                              <div class="card mb-3" >
                                <div class="row col-auto g-0">
                                  <div class="col-md-4" style="background: url(https://download.pingcap.com/images/blog/choosing-right-database-for-your-applications.png)  no-repeat center center / cover;">
                                  </div>
                                  <div class="col-md-8">
                                    <div class="card-body">
                                      <h4 class="card-title">Topic 4: Name of the topic</h4>
                                      <span class="badge rounded-pill bg-info mb-2">Quiz completed</span>
                                      <p class="card-text"><small class="text-muted">Last resource uploaded: 3 mins ago</small></p>
                                      <a href="topic4.html" class="btn btn-primary btn-sm">Go to topic</a>
                                    </div>
                                  </div>
                                </div>
                              </div>

                              <div class="card mb-3" >
                                <div class="row col-auto g-0">
                                  <div class="col-md-4" style="background: url(https://download.pingcap.com/images/blog/choosing-right-database-for-your-applications.png)  no-repeat center center / cover;">
                                  </div>
                                  <div class="col-md-8">
                                    <div class="card-body">
                                      <h4 class="card-title">Topic 5: Name of the topic</h4>
                                      <p class="card-text"><small class="text-muted">Last resource uploaded: 3 mins ago</small></p>
                                      <a href="topic5.html" class="btn btn-primary btn-sm">Go to topic</a>
                                    </div>
                                  </div>
                                </div>
                              </div>

                              <div class="card mb-3" >
                                <div class="row col-auto g-0">
                                  <div class="col-md-4" style="background: url(https://download.pingcap.com/images/blog/choosing-right-database-for-your-applications.png)  no-repeat center center / cover;">
                                  </div>
                                  <div class="col-md-8">
                                    <div class="card-body">
                                      <h4 class="card-title">Topic 6: Name of the topic</h4>
                                      <p class="card-text"><small class="text-muted">Last resource uploaded: 3 mins ago</small></p>
                                      <a href="topic6.html" class="btn btn-primary btn-sm">Go to topic</a>
                                    </div>
                                  </div>
                                </div>
                              </div>
                        </div>
                    </div>
                </main>
 
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>
</html>
