<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include('routes/connect.php');
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Waves'23</title>
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">

    <link rel="stylesheet" href="public/css/fontawesome-all.min.css">

    <link rel="stylesheet" href="public/css/swiper.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <link rel="stylesheet" href="public/css/style.css">
    <script nonce="2af76b41-facd-47ce-9e71-e256854a4086">
    (function(w, d) {
        ! function(db, dc, dd, de) {
            db[dd] = db[dd] || {};
            db[dd].executed = [];
            db.zaraz = {
                deferred: [],
                listeners: []
            };
            db.zaraz.q = [];
            db.zaraz._f = function(df) {
                return async function() {
                    var dg = Array.prototype.slice.call(arguments);
                    db.zaraz.q.push({
                        m: df,
                        a: dg
                    })
                }
            };
            for (const dh of ["track", "set", "debug"]) db.zaraz[dh] = db.zaraz._f(dh);
            db.zaraz.init = () => {
                var di = dc.getElementsByTagName(de)[0],
                    dj = dc.createElement(de),
                    dk = dc.getElementsByTagName("title")[0];
                dk && (db[dd].t = dc.getElementsByTagName("title")[0].text);
                db[dd].x = Math.random();
                db[dd].w = db.screen.width;
                db[dd].h = db.screen.height;
                db[dd].j = db.innerHeight;
                db[dd].e = db.innerWidth;
                db[dd].l = db.location.href;
                db[dd].r = dc.referrer;
                db[dd].k = db.screen.colorDepth;
                db[dd].n = dc.characterSet;
                db[dd].o = (new Date).getTimezoneOffset();
                if (db.dataLayer)
                    for (const dp of Object.entries(Object.entries(dataLayer).reduce(((dq, dr) => ({
                            ...dq[1],
                            ...dr[1]
                        })), {}))) zaraz.set(dp[0], dp[1], {
                        scope: "page"
                    });
                db[dd].q = [];
                for (; db.zaraz.q.length;) {
                    const ds = db.zaraz.q.shift();
                    db[dd].q.push(ds)
                }
                dj.defer = !0;
                for (const dt of [localStorage, sessionStorage]) Object.keys(dt || {}).filter((dv => dv
                    .startsWith("_zaraz_"))).forEach((du => {
                    try {
                        db[dd]["z_" + du.slice(7)] = JSON.parse(dt.getItem(du))
                    } catch {
                        db[dd]["z_" + du.slice(7)] = dt.getItem(du)
                    }
                }));
                dj.referrerPolicy = "origin";
                dj.src = "/cdn-cgi/zaraz/s.js?z=" + btoa(encodeURIComponent(JSON.stringify(db[dd])));
                di.parentNode.insertBefore(dj, di)
            };
            ["complete", "interactive"].includes(dc.readyState) ? zaraz.init() : db.addEventListener(
                "DOMContentLoaded", zaraz.init)
        }(w, d, "zarazData", "script");
    })(window, document);
    </script>
</head>

<body id="body">

    <?php
    $events = mysqli_query($conn, "SELECT * FROM `eventdb`");
    while ($event = mysqli_fetch_array($events)) {
        ?>
                <!-- Modal -->
                <div class="modal fade <?php echo $event['event_id'] ?>" tabindex="-1" role="dialog"
                    aria-labelledby="<?php echo $event['event_id'] ?>" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content" style="padding: 23px;">
                            <div class="modal-header">
                                <h4 class="modal-title" id="exampleModalLabel" style="color: aqua;"><?php echo $event['event_name'] ?></h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div>
                                    <div style="margin: 12px; text-align: center;">
                                        <img src="<?php echo $event['image'] ?>" alt="" srcset="" width="270px" height="170px" style="margin: 22px;">
                                        <h4><?php echo $event['event_date'] ?></h4>
                                        <h4><?php echo $event['event_time'] ?></h4>
                                        <h4><?php echo $event['event_venue'] ?></h4>
                                    </div>
                                    <h4 style="color: aqua;">Rules</h4>
                                    <p style="font-family: 'Courier New', Courier, monospace;"><?php echo $event['event_rules'] ?></p>
                                </div>
                                
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
    }
    ?>


    <header class="site-header">
        <div class="header-bar">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-10 col-lg-4">
                        <h1 class="site-branding flex">
                            <a href="#">Waves'23</a>
                        </h1>
                    </div>
                    <div class="col-2 col-lg-8">
                        <nav class="site-navigation">
                            <div class="hamburger-menu d-lg-none">
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                            <ul>
                                <li><a href="#">HOME</a></li>
                                <li><a href="#">Waves'23</a></li>
                                <li><a href="#">ARTISTS</a></li>
                                <li><a href="#">BLOG</a></li>
                                <li><a href="#">CONTACT</a></li>
                                <li><a href="#"><i class="fas fa-search"></i></a></li>
                                <li><button type="button" class="btn btn-login btn-primary" data-toggle="modal" data-target="#exampleModal">Login</button></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Login Modal -->
<div style='margin-top: 32px' class="modal fade loginModal" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="padding: 28px;">
    <div class="modal-content">
      <div class="modal-body">
        <div class="column" id="main">
          <h1 style='margin-bottom: 34px'>Login</h1>
          <form action="/routes/auth/login.php" method="post">
            <div class="form-group">
              <label for="exampleInputName">Reg Number</label>
              <input type="reg_number" name='reg_number' class="form-control" id="exampleInputName" placeholder="Register Number">
            </div>
            <div class="form-group"> <label for="role">
                                            <h6>Role</h6>
                                        </label>
                                        <div class="input-group"> <select name="role" id=""
                                                placeholder="Select Gender" class="form-control" required>
                                                <option value="" hidden></option>
                                                <option value="student">Student</option>
                                                <option value="event cordinator">Event Cordinator</option>
                                                <option value="team captain">Team Captain</option>
                                                <option value="vice captain">Vice Captain</option>
                                            </select>
                                        </div>
                                    </div>
            <div class="form-group">
              <label for="inputPassword">Password</label>
              <input type="password" name="password" class="form-control" id="inputPassword" placeholder="Password">
            </div>
            <button type="submit" name="submit" class="btn btn-login btn-primary">Login</button>
          </form>
        </div>
        <div>
          <svg width="67px" height="480px" viewBox="0 0 67 480" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
              <title>Path</title>
              <desc>Created with Sketch.</desc>
              <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                  <path d="M11.3847656,-5.68434189e-14 C-7.44726562,36.7213542 5.14322917,126.757812 49.15625,270.109375 C70.9827986,341.199016 54.8877465,443.829224 0.87109375,578 L67,578 L67,-5.68434189e-14 L11.3847656,-5.68434189e-14 Z" id="Path" fill="#0ee1e7"></path>
              </g>
          </svg>
        </div>
        <div class="column" id="secondary">
          <div class="sec-content">
            <!-- <h2>Welcome Back!</h2>
            <h3>Lorem ipsum dolor sit amet, consectetur adipiscing elit</h3> -->
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


    <div class="hero-content">
        <div class="container" style="margin:0;display:flex">
            <div class="row">
                <div class="col-md-12" style="
    align-items: center;">

                    <div class="entry-header">
                        <!-- <h2>Waves'23</h2> -->
                        <div id="stage"></div>
                        <canvas id="text" width="800" height="200"></canvas>
                        <input id="input" type="text" value="Waves'23 W" style="display: none;" />

                    </div>
                    <div class="col-md-12 countdown flex flex-wrap justify-content-between" data-date="2023/09/29">
                        <div class="col-md-12 flex-wrap" style="display:flex;justify-content:center">
                            <div class="countdown-holder">
                                <div class="dday"></div>
                                <label>Days</label>
                            </div>
                            <div class="countdown-holder">
                                <div class="dhour"></div>
                                <label>Hours</label>
                            </div>
                            <div class="countdown-holder">
                                <div class="dmin"></div>
                                <label>Minutes</label>
                            </div>
                            <div class="countdown-holder">
                                <div class="dsec"></div>
                                <label>Seconds</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="entry-footer">

                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                data-target="#exampleModal">
                                Rules and Regulation
                            </button>
                            <a href="#" class="btn current">See Events</a>
                        </div>
                    </div>

                </div>
                <div class="row">

                </div>
            </div>
        </div>
    </div>

    <div class="content-section">
        <div class="container">
            <!-- <div class="row">
        <div class="col-12">
          <div class="lineup-artists-headline">
            <div class="entry-title">
              <p>JUST THE BEST</p>
              <h2>The Lineup Artists-Headliners</h2>
            </div>
            <div class="lineup-artists">
              <div class="lineup-artists-wrap flex flex-wrap">
                <figure class="featured-image">
                  <a href="#"> <img src="public/images/black-chick.jpg" alt> </a>
                </figure>
                <div class="lineup-artists-description">
                  <div class="lineup-artists-description-container">
                    <div class="entry-title">
                      Jamila Williams
                    </div>
                    <div class="entry-content">
                      <p>Quisque at erat eu libero consequat tempus. Quisque mole stie convallis tempus. Ut semper purus metus, a euismod sapien sodales ac. Duis viverra eleifend fermentum. </p>
                    </div>
                    <div class="box-link">
                      <a href><img src="public/images/box.jpg" alt></a>
                    </div>
                  </div>
                </div>
              </div>
              <div class="lineup-artists-wrap flex flex-wrap">
                <div class="lineup-artists-description">
                  <figure class="featured-image d-md-none">
                    <a href="#"> <img src="public/images/mathew-kane.jpg" alt> </a>
                  </figure>
                  <div class="lineup-artists-description-container">
                    <div class="entry-title">
                      Sandra Superstar
                    </div>
                    <div class="entry-content">
                      <p>Quisque at erat eu libero consequat tempus. Quisque mole stie convallis tempus. Ut semper purus metus, a euismod sapien sodales ac. Duis viverra eleifend fermentum. </p>
                    </div>
                    <div class="box-link">
                      <a href="#"><img src="public/images/box.jpg" alt></a>
                    </div>
                  </div>
                </div>
                <figure class="featured-image d-none d-md-block">
                  <a href="#"> <img src="public/images/mathew-kane.jpg" alt> </a>
                </figure>
              </div>
              <div class="lineup-artists-wrap flex flex-wrap">
                <figure class="featured-image">
                  <a href="#"> <img src="public/images/eric-ward.jpg" alt> </a>
                </figure>
                <div class="lineup-artists-description">
                  <div class="lineup-artists-description-container">
                    <div class="entry-title">
                      DJ Crazyhead
                    </div>
                    <div class="entry-content">
                      <p>Quisque at erat eu libero consequat tempus. Quisque mole stie convallis tempus. Ut semper purus metus, a euismod sapien sodales ac. Duis viverra eleifend fermentum. </p>
                    </div>
                    <div class="box-link">
                      <a href="#"> <img src="public/images/box.jpg" alt></a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div> 
    </div>-->

            <div class="row">
                <div class="col-12">
                    <div class="the-complete-lineup">
                        <div class="entry-title">
                            <p>JUST THE BEST</p>
                            <h2>The Event Lineup</h2>
                        </div>
                        <div class="row the-complete-lineup-artists">
                            <?php
                            $events = mysqli_query($conn, "SELECT * FROM `eventdb` WHERE `gender`='COMMON'");
                            while ($event = mysqli_fetch_array($events)) {
                                ?>
                                        <div class="col-6 col-md-4 col-lg-3 artist-single">
                                            <figure class="featured-image">
                                                <a data-toggle="modal" data-target=".<?php echo $event['event_id'] ?>"> <img src="<?php echo $event['image'] ?>" alt> </a>
                                                <a href="#" class="box-link" type="button" class="btn btn-primary"
                                                    data-toggle="modal" data-target=".<?php echo $event['event_id'] ?>"> <img
                                                        src="public/images/box.jpg" alt> </a>
                                            </figure>
                                            <h2><?php echo $event['event_name'] ?></h2>
                                        </div>
                                        <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="the-complete-lineup">
                        <div class="entry-title">
                            <p>JUST THE BEST</p>
                            <h2>Exculsuive for Boys</h2>
                        </div>
                        <div class="row the-complete-lineup-artists">
                            <?php
                            $events = mysqli_query($conn, "SELECT * FROM `eventdb` WHERE `gender`='BOYS'");
                            while ($event = mysqli_fetch_array($events)) {
                                ?>
                                        <div class="col-6 col-md-4 col-lg-3 artist-single">
                                            <figure class="featured-image">
                                                <a href="#"> <img src="<?php echo $event['image'] ?>" alt> </a>
                                                <a href="#" class="box-link"> <img src="public/images/box.jpg" alt> </a>
                                            </figure>
                                            <h2><?php echo $event['event_name'] ?></h2>
                                        </div>
                                        <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="the-complete-lineup">
                        <div class="entry-title">
                            <p>JUST THE BEST</p>
                            <h2>Exculsuive for Girls</h2>
                        </div>
                        <div class="row the-complete-lineup-artists">
                            <?php
                            $events = mysqli_query($conn, "SELECT * FROM `eventdb` WHERE `gender`='GIRLS'");
                            while ($event = mysqli_fetch_array($events)) {
                                ?>
                                        <div class="col-6 col-md-4 col-lg-3 artist-single">
                                            <figure class="featured-image">
                                                <a href="#"> <img src="<?php echo $event['image'] ?>" alt> </a>
                                                <a href="#" class="box-link"> <img src="public/images/box.jpg" alt> </a>
                                            </figure>
                                            <h2><?php echo $event['event_name'] ?></h2>
                                        </div>
                                        <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="homepage-next-events">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="entry-title">
                            <p>JUST THE BEST</p>
                            <h2>Our Events</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="next-event-slider-wrap">
                <div class="swiper-container next-event-slider">
                    <div class="swiper-wrapper">
                        <?php
                        $events = mysqli_query($conn, "SELECT * FROM `eventdb`");
                        while ($event = mysqli_fetch_array($events)) {
                            ?>
                                    <div class="swiper-slide">
                                        <div class="next-event-content">
                                            <figure class="featured-image">
                                                <img src="<?php echo $event['image'] ?>" alt>
                                                <a href="#" data-toggle="modal" data-target=".<?php echo $event['event_id'] ?>"
                                                    class="entry-content flex flex-column justify-content-center align-items-center">
                                                    <h3>
                                                        <?php echo $event['event_name'] ?>
                                                    </h3>
                                                    <p>
                                                        <?php echo $event['event_date'] . "<br>" . $event['event_time'] . "<br>" . $event['event_venue'] ?>
                                                    </p>
                                                </a>
                                            </figure>
                                        </div>
                                    </div>
                                    <?php
                        }
                        ?>


                    </div>
                </div>
                <div class="swiper-button-next">
                    <img src="public/images/button.png" alt>
                </div>
            </div>
        </div>
        <div class="home-page-last-news">
            <div class="container">
                <div class="header">
                    <div class="entry-title">
                        <p>JUST THE BEST</p>
                        <h2>Our Last Events</h2>
                    </div>
                </div>
                <div class="home-page-last-news-wrap">
                    <!-- <div class="col-12 col-md-6">
                            <figure class="featured-image">
                                <a href="#"> <img src="public/images/news-image-1.jpg" alt="fesival+celebration"> </a>
                            </figure>
                            <div class="box-link-date">
                                <a href>03.12.18</a>
                            </div>
                            <div class="content-wrapper">
                                <div class="entry-content">
                                    <div class="entry-header">
                                        <h2><a href="#">New event calendar for this year</a></h2>
                                    </div>
                                    <div class="entry-meta">
                                        <span class="author-name"><a href="#">By James Williams</a></span>
                                        <span class="space">|</span>
                                        <span class="comments-count"><a href="#">3 comments</a></span>
                                    </div>
                                    <div class="entry-description">
                                        <p>Quisque at erat eu libero consequat tempus.
                                            Quisque mole stie convallis tempus.
                                            Ut semper purus metus, a euismod sapien sodales ac.
                                            Duis viverra eleifend fermentum.</p>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                </div>
            </div>
        </div>
    </div>
    </div>
    <footer class="site-footer">
        <div class="footer-cover-title flex justify-content-center align-items-center">
            <h2>Waves'23</h2>
        </div>
        <div class="footer-content-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="entry-title">
                            <a href="#">Waves'23</a>
                        </div>

                        <div class="copyright-info">

                            Copyright &copy;
                            <script data-cfasync="false"
                                src="public/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
                            <script>
                            document.write(new Date().getFullYear());
                            </script> Design & Developed by <i class="fa fa-heart" aria-hidden="true"></i> by <a
                                href="https://nscet.org/ispin/" target="_blank">iSPIN</a>

                        </div>
                        <div class="footer-social">
                            <!-- <ul class="flex justify-content-center align-items-center">
                                <li><a href="#"><i class="fab fa-pinterest"></i></a></li>
                                <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fab fa-dribbble"></i></a></li>
                                <li><a href="#"><i class="fab fa-behance"></i></a></li>
                                <li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
                            </ul> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </footer>
    <script type="text/javascript" src="public/js/jquery.js"></script>
    <script type="text/javascript" src="public/js/masonry.pkgd.min.js"></script>
    <script type="text/javascript" src="public/js/jquery.collapsible.min.js"></script>
    <script type="text/javascript" src="public/js/swiper.min.js"></script>
    <script type="text/javascript" src="public/js/jquery.countdown.min.js"></script>
    <script type="text/javascript" src="public/js/circle-progress.min.js"></script>
    <script type="text/javascript" src="public/js/jquery.countTo.min.js"></script>
    <script type="text/javascript" src="public/js/custom.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r71/three.min.js"></script>
    <script type="text/javascript" src="public/js/3d-text.js"></script>
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13"></script>
    <script>
    var window, dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'UA-23581568-13');
    </script>
    <script defer
        src="https://static.cloudflareinsights.com/beacon.min.js/v8b253dfea2ab4077af8c6f58422dfbfd1689876627854"
        integrity="sha512-bjgnUKX4azu3dLTVtie9u6TKqgx29RBwfj3QXYt5EKfWM/9hPSAI/4qcV5NACjwAo8UtTeWefx6Zq5PHcMm7Tg=="
        data-cf-beacon='{"rayId":"801ca2883dc3859f","token":"cd0b4b3a733644fc843ef0b185f98241","version":"2023.8.0","si":100}'
        crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/tsparticles-confetti@2.12.0/tsparticles.confetti.bundle.min.js"></script>


    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>


    <script>
    const duration = 10 * 1000,
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

        const particleCount = 20 * (timeLeft / duration);

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
</body>

</html>