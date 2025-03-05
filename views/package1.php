<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}

require_once '../config/database.php';
include("../includes/header.html");
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Load Bootstrap CSS first -->
        <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="../assets/css/bootstrap-slider.css">
        <link rel="stylesheet" href="../assets/css/jquery-ui.css">
        <link rel="stylesheet" href="../assets/css/layerslider.css">
        <link rel="stylesheet" href="../assets/css/color.css" id="color-change">
        <link rel="stylesheet" href="../assets/css/owl.carousel.min.css">
        <link rel="stylesheet" href="../assets/fonts/flaticon/flaticon.css">
        
        <!-- Load your custom CSS after Bootstrap -->
        <link rel="stylesheet" href="../assets/css/package.css">
        
        <!-- Other external CSS -->
        <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        
        <title>Package 1</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="description" content="Real Estate PHP">
        <meta name="keywords" content="">
        <meta name="author" content="Unicoder">
        <link rel="shortcut icon" href="images/favicon.ico">
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Muli:400,400i,500,600,700&amp;display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Comfortaa:400,700" rel="stylesheet">
    </head>
<body style="background-color: var(--secondary-color);">
    <div id="page-wrapper">
        <div class="row"> 


            <div class="banner-full-row page-banner" style="background-image:url('../assets/img/full_day_city.webp'); background-repeat: no-repeat; background-size: cover; filter: brightness(0.7);">
                <div class="container">
                    <div class="row">
                        <div class="col-md-10">
                            <h2 class="page-name float-left text-white text-uppercase mt-2 mb-0" style="color: white;"><b></b>Full Day Mumbai City Private Sightseeing Tour</h2>
                        </div>
                        <div class="col-md-6">
                        </div>
                    </div>
                </div>
            </div>

<div class="full-row" style="background-color: var(--dashback-color);">
            <div class="container">
                <div class="row">
                        <div class="row">									
                            <div class="col-md-4">
                                <div class="featured-thumb hover-zoomer mb-4">
                                    <div class="overlay-black overflow-hidden position-relative"> <img src="../assets/img/full_day_city.webp" alt="pimage" class="packageWali">
                                    </div><!-- FOR MORE PROJECTS visit: codeastro.com -->
                                    <div class="featured-thumb-data shadow-one">
                                        <div class="p-4" style="background-color: #FBF8EF;">
                                            <h5 class="text-secondary hover-text-success mb-2 text-capitalize"><a href="https://www.lindatours.in/full-day-mumbai-private-sightseeing-tour.php">Full Day Mumbai City Private Sightseeing Tour</a></h5>
                                            <span class="location text-capitalize"><i class='fas fa-rupee-sign text-success mr-1'></i>7,290/-</span> </div>
                                        </div>
                                    </div>
                                </div>
    							
                                <div class="col-md-4">
                                    <div class="featured-thumb hover-zoomer mb-4">
                                        <div class="overlay-black overflow-hidden position-relative"> <img src="../assets/img/Elephanta_Caves__Island_Guided_Private_Tour.webp" alt="pimage" class="packageWali">
                                        </div><!-- FOR MORE PROJECTS visit: codeastro.com -->
                                        <div class="featured-thumb-data shadow-one">
                                            <div class="p-4" style="background-color: #FBF8EF;">
                                                <h5 class="text-secondary hover-text-success mb-2 text-capitalize  h5-primary-color"><a href="https://www.lindatours.in/elephanta-caves-island-guided-private-tour.php">Elephanta Caves & Island Guided Private Tour</a></h5>
                                                <span class="location text-capitalize"><i class='fas fa-rupee-sign text-success mr-1'></i>9,910/-</span> </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                        <div class="featured-thumb hover-zoomer mb-4">
                                            <div class="overlay-black overflow-hidden position-relative"> <img src="../assets/img/Dharavi_Slum_Cover.webp" alt="pimage" class="packageWali">
                                            </div><!-- FOR MORE PROJECTS visit: codeastro.com -->
                                            <div class="featured-thumb-data shadow-one">
                                                <div class="p-4" style="background-color: #FBF8EF;">
                                                    <h5 class="text-secondary hover-text-success mb-2 text-capitalize  h5-primary-color"><a href="https://www.lindatours.in/dharavi-slum-tour.php">Tour of Dharavi Slum</a></h5>
                                                    <span class="location text-capitalize"><i class='fas fa-rupee-sign text-success mr-1'></i>4,120/-</span> </div>
                                            </div>
                                        </div>
                                    </div>
						
                                        <div class="col-md-4">
                                            <div class="featured-thumb hover-zoomer mb-4">
                                                <div class="overlay-black overflow-hidden position-relative"> <img src="../assets/img/Half_Day_Mumbai_City_Private_Sightseeing_Tour.webp" alt="pimage" class="packageWali">
                                                </div><!-- FOR MORE PROJECTS visit: codeastro.com -->
                                                <div class="featured-thumb-data shadow-one">
                                                    <div class="p-4" style="background-color: #FBF8EF;">
                                                        <h5 class="text-secondary hover-text-success mb-2 text-capitalize  h5-primary-color"><a href="https://www.lindatours.in/half-day-mumbai-city-private-sightseeing-tour.php">Half Day Mumbai City Private Sightseeing Tour</a></h5>
                                                        <span class="location text-capitalize"><i class='fas fa-rupee-sign text-success mr-1'></i>6,500/-</span> </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="featured-thumb hover-zoomer mb-4">
                                                <div class="overlay-black overflow-hidden position-relative"> <img src="../assets/img/night_cover.webp" alt="pimage" class="packageWali">
                                                </div><!-- FOR MORE PROJECTS visit: codeastro.com -->
                                                <div class="featured-thumb-data shadow-one">
                                                    <div class="p-4" style="background-color: #FBF8EF;">
                                                        <h5 class="text-secondary hover-text-success mb-2 text-capitalize  h5-primary-color"><a href="https://www.lindatours.in/mumbai-by-night-lights-and-luminance.php">Mumbai By Night: Lights & Luminance</a></h5>
                                                        <span class="location text-capitalize"><i class='fas fa-rupee-sign text-success mr-1'></i>4,810/-</span> </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="featured-thumb hover-zoomer mb-4">
                                                <div class="overlay-black overflow-hidden position-relative"> <img src="../assets/img/Elephant-Caves-Island-Guided-Private-Tour-with-Speed-Boat.webp" alt="pimage" class="packageWali">
                                                </div><!-- FOR MORE PROJECTS visit: codeastro.com -->
                                                <div class="featured-thumb-data shadow-one">
                                                    <div class="p-4" style="background-color: #FBF8EF;">
                                                        <h5 class="text-secondary hover-text-success mb-2 text-capitalize  h5-primary-color"><a href="https://www.lindatours.in/mumbai-by-night-lights-and-luminance.php">Elephanta Caves & Island Guided Private Tour with Speed Boat</a></h5>
                                                        <span class="location text-capitalize"><i class='fas fa-rupee-sign text-success mr-1'></i>31,000/-</span> </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="featured-thumb hover-zoomer mb-4">
                                                <div class="overlay-black overflow-hidden position-relative"> <img src="../assets/img/Mumbai_City_sightseeing_with_Elephanta_caves_Tour.webp" alt="pimage" class="packageWali">
                                                </div><!-- FOR MORE PROJECTS visit: codeastro.com -->
                                                <div class="featured-thumb-data shadow-one">
                                                    <div class="p-4" style="background-color: #FBF8EF;">
                                                        <h5 class="text-secondary hover-text-success mb-2 text-capitalize  h5-primary-color"><a href="https://www.lindatours.in/mumbai-city-sightseeing-with-elephanta-caves-tour.php">Mumbai City sightseeing with Elephanta caves Tour</a></h5>
                                                        <span class="location text-capitalize"><i class='fas fa-rupee-sign text-success mr-1'></i>11,450/-</span> </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="featured-thumb hover-zoomer mb-4">
                                                <div class="overlay-black overflow-hidden position-relative"> <img src="../assets/img/Elephanta_caves_and_island_with_Dharavi_Slum_Tour.webp" alt="pimage" class="packageWali">
                                                </div><!-- FOR MORE PROJECTS visit: codeastro.com -->
                                                <div class="featured-thumb-data shadow-one">
                                                    <div class="p-4" style="background-color: #FBF8EF;">
                                                        <h5 class="text-secondary hover-text-success mb-2 text-capitalize  h5-primary-color"><a href="https://www.lindatours.in/elephanta-caves-and-island-with-dharavi-slum-tour.php">Elephanta caves and island with Dharavi Slum Tour</a></h5>
                                                        <span class="location text-capitalize"><i class='fas fa-rupee-sign text-success mr-1'></i>11,110/-</span> </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="featured-thumb hover-zoomer mb-4">
                                                <div class="overlay-black overflow-hidden position-relative"> <img src="../assets/img/Private_City_Sightseeing_with_Dharavi_Slum_Tour.webp" alt="pimage" class="packageWali">
                                                </div><!-- FOR MORE PROJECTS visit: codeastro.com -->
                                                <div class="featured-thumb-data shadow-one">
                                                    <div class="p-4" style="background-color: #FBF8EF;">
                                                        <h5 class="text-secondary hover-text-success mb-2 text-capitalize  h5-primary-color"><a href="https://www.lindatours.in/private-city-with-dharavi-slum-sightseeing-tour.php">Private City Sightseeing with Dharavi Slum Tour</a></h5>
                                                        <span class="location text-capitalize"><i class='fas fa-rupee-sign text-success mr-1'></i>10,500/-</span> </div>
                                                </div>
                                            </div>
                                        </div>

                           <div class="col-md-12">
                                <nav aria-label="Page navigation">
                                    <ul class="pagination justify-content-center mt-4">
                                        <li class="page-item disabled"> <span class="page-link">Previous</span> </li>
                                        <li class="page-item active" aria-current="page"> <span class="page-link"> 1 <span class="sr-only">(current)</span> </span> </li>
                                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                                        <li class="page-item">...</li>
                                        <li class="page-item"><a class="page-link" href="#">5</a></li>
                                        <li class="page-item"> <a class="page-link" href="#">Next</a> </li>
                                    </ul>
                                </nav>
                            </div> 
                        </div>
                    </div>
                    </div>
                    
                </div>
            </div>
        </div>

    </div>
</div>
        <script src="../assets/js/jquery.min.js"></script> 
<script src="../assets/js/greensock.js"></script> 
<script src="../assets/js/layerslider.transitions.js"></script> 
<script src="../assets/js/layerslider.kreaturamedia.jquery.js"></script> 
<script src="../assets/js/popper.min.js"></script> 
<script src="../assets/js/bootstrap.min.js"></script> 
<script src="../assets/js/owl.carousel.min.js"></script> 
<script src="../assets/js/tmpl.js"></script> 
<script src="../assets/js/jquery.dependClass-0.1.js"></script> 
<script src="../assets/js/draggable-0.1.js"></script> 
<script src="../assets/js/jquery.slider.js"></script> 
<script src="../assets/js/wow.js"></script> 

<script src="../assets/js/custom.js"></script>
</body>
</html>