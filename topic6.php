<?php
  // Connect to db
  require_once(__DIR__.'/db/db.php');

  // Get quizz data
  try {
    $q = $db->prepare('SELECT * FROM exam.quiz(3,6)');
    $q->execute();
    $quiz = $q->fetchAll();
  } catch(PDOException $ex) {
  echo $ex->getMessage();
  exit();
  }

  // Get topic from db
  try {
    $q = $db->prepare('SELECT * FROM exam.topic_view WHERE topic_id = 6');
    $q->execute();
    $topic = $q->fetchAll()[0];  
  } catch(PDOException $ex) {
  echo $ex->getMessage();
  exit();
  }

  // Get the most loved resource (resources are sorted by votes in db)
  try {
    $q = $db->prepare('SELECT * FROM exam.resources_view WHERE topic_id = 6 ORDER BY creation_date::DATE DESC');
    $q->execute();
    $topic_resource = $q->fetchAll();
  } catch(PDOException $ex) {
  echo $ex->getMessage();
  exit();
  }

// Get quizz data
$key = 'Topic1';
try {
    $redis = new Redis();
    $redis->connect('127.0.0.1', 6379);

    if (!$redis->get($key)) {
      $q = $db->prepare('SELECT * FROM exam.quiz(3,1)');
      $q->execute();
      $quiz = $q->fetchAll();
        $redis->set($key, serialize($quiz));
        $redis->expire($key, 10);
        // $source = 'Postgresql Server';
    } else {
        //  $source = 'Redis Server';
         $quiz = unserialize($redis->get($key));
    }
    // echo $source . ': <br>';
    
} catch (Exception $ex) {
    echo $ex->getMessage();
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
        <title>E-learning | Topic</title>
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
                            <a class="nav-link" href="student-home.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard
                            </a>
                            <div class="sb-sidenav-menu-heading">Topics</div>
                            <a class="nav-link" href="topic1.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Topic 1
                            </a>
                            <a class="nav-link" href="topic2.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Topic 2
                            </a>
                            <a class="nav-link" href="topic3.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Topic 3
                            </a>
                            <a class="nav-link" href="topic4.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Topic 4
                            </a>
                            <a class="nav-link" href="topic5.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Topic 5
                            </a>
                            <a class="nav-link" href="topic6.php">
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
                        <!-- TRIGGER QUIZ MODAL 1 -->
                        <div class="d-flex justify-content-end align-items-center">
                          <p class="mb-0 me-3 text-warning">
                            You have not completed a quiz of this topic: 
                          </p>
                          <button type="button" class="btn btn-primary text-white my-3 align-end" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                            Take a quiz
                          </button>
                        </div>
                        <!-- QUIZ MODAL -->
                        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title">Quiz of topic 1</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body form">
                                <?php foreach($quiz as $question){
                                ?>
                                <div class="m-3">
                                <h6><?=$question['question_text']?></h6>
                                <div class=" mb-3">
                                  <div class="form-check">
                                    <input class="form-check-input" type="radio" name="question<?=$question['question_id']?>"> 
                                    <label class="form-check-label" for="question1">
                                    <?=$question['option_one']?>
                                    </label>
                                  </div>
                                  <div class="form-check">
                                    <input class="form-check-input" type="radio" name="question<?=$question['question_id']?>" >
                                    <label class="form-check-label" for="question1">
                                    <?=$question['option_two']?>
                                    </label>
                                  </div>
                                  <div class="form-check mb-3">
                                    <input class="form-check-input" type="radio" name="question<?=$question['question_id']?>" >
                                    <label class="form-check-label" for="question1">
                                    <?=$question['option_three']?>
                                    </label>
                                  </div>
                                </div>
                              </div>
                              <?php
                            } ?>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-primary">Submit</button>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="card mb-4">
                          <h1 class="card-title pt-5 ps-5"><?= $topic['name']?></h1>
                          <h5 class="card-subtitle pb-4 ps-5">Last resource uloaded: <?= substr($topic_resource[0]['creation_date'], 0, 16) ?></h5>
                          <img class="img-fluid" src="<?= $topic['src_desktop']?>" alt="">
                          <div class="card-body p-5">
                            <p><?= $topic['body']?></p>
                          </div>
                         
                          <!-- TRIGGER QUIZ MODAL 1 -->
                          <div class="card-footer d-flex align-items-center justify-content-center">
                            <p class="mb-0 me-3 text-warning">
                              You have not completed a quiz of this topic: 
                            </p>
                            <button type="button" class="btn btn-primary text-white align-end" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                              Take a quiz
                            </button>
                          </div>
                        </div>

                    <!-- PRESOURCES -->
                    <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-grin-hearts me-1"></i>
                                Resources
                            </div>
                            <div class="card-body">
                              <form action="" method="POST">
                                <div class="mb-2">
                                  <h4>Post a resource</h4>
                                  <label for="resource_text">Got a resource worth sharing? Sharing is caring, post it in the box below!</label>
                                  <textarea class="form-control" id="resource_text" rows="3"></textarea>
                                  <input class="form-control mt-2" type="url" name="resource_link" id="resource_link" placeholder="Paste a link to the resource here">
                                </div>
                                <button type="button" class="btn btn-primary mb-5">Share</button>
                              </form>
                              <?php foreach($topic_resource as $single_resource){
                                ?>
                                    <div class="card mb-4">
                                  <div class="card-header text-success">
                                    <?= $single_resource['votes']?> <i class="fas fa-grin-hearts me-1"></i>
                                  </div>
                                  <div class="card-body row">                                   
                                    <div class="col-1">
                                      <img style="height: 50px; width: 50px; border-radius: 25px;" src="https://images.unsplash.com/photo-1522075469751-3a6694fb2f61?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1000&q=80" alt="USer image">
                                    </div>
                                    <div class="col-11">
                                      <h4><?= $single_resource['user_name']?> <?=$single_resource['user_last_name']?></h4>
                                      <p class="text-muted mb-0"><?= substr($single_resource['creation_date'], 0, 16) ?></p>
                                      <p class="mb-0"><?= $single_resource['body']?></p>
                                      <a class="btn btn-link m-0 p-0 text-start" target="_blank" href="<?= $single_resource['link']?>"><?= $single_resource['link']?></a>
                                    </div>
                                  </div>
                                  <div class="card-footer">
                                    <button class="btn btn-sm btn-outline-warning text-center"><i class="fas fa-grin-hearts"></i></button>
                                    <button class=" btn btn-sm btn-outline-primary text-center disabled">Reply</button>
                                  </div>
                                </div>
                                <?php
                            } ?>
                            </div>
                    </div>
                </main>
 
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
 

    </body>
</html>
