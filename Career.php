
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title></title>
    <link href="css/style.css" rel="stylesheet" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="favicon.ico" type="image/x-icon" />
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" /> 
    <link rel="stylesheet" href="css/animate.css">
    <link href="css/basic.css" rel="stylesheet" />
    <link href="css/dropzone.css" rel="stylesheet" />

    <script src="js/jquery.min.js"></script>
    <script src="js/custom.js"></script>
    <script src="js/dropzone.js"></script>
    <script src="js/wow.min.js"></script>
    <script type="text/javascript">
        new WOW().init();
        $(window).on("scroll", function () {
            if ($(window).scrollTop() > 50) {
                $("header").addClass("nav1");
            } else {
                $("header").removeClass("nav1");
            }
        });
        $(function() {
          $('a[href*="#"]:not([href="#"])').click(function() {
            if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
              var target = $(this.hash);
              target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
              if (target.length) {
                $('html, body').animate({
                  scrollTop: target.offset().top
                }, 1000);
                return false;
              }
            }
          });
        });

    </script>
  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.6.2/html5shiv.js"></script>
    <script type="text/javascript">
        function setCookie(key, value) {
            document.cookie = key + '=' + value;
        }

        function getCookie(key) {
            var keyValue = document.cookie.match('(^|;) ?' + key + '=([^;]*)(;|$)');
            return keyValue ? keyValue[2] : null;
        }
    </script>
</head>
<body>
    
    <header role="banner">
        <div class="hdr_cntnr">
            <div class=""><a onClick="location.href='index.html'" class="logo">Suvrat <span>Consulting</span></a></div>
            <span class="hamburg_menu"></span>
            <nav>
                <ul class="primry_menu" id="top-menu">
                    <li><a onClick="location.href='index.html#work'">About Us</a>
                    </li>
                    <li><a onClick="location.href='index.html#aboutus'">What We Do</a>
                    </li>
                    <li><a onClick="location.href='#'" class="active">Careers</a>
                    </li>
                    <li><a onClick="location.href='index.html#contact'">Contact</a>
                    </li>
                </ul>
            </nav>
            <div class="clearfix"></div>
        </div>
    </header>
    <section class="deliver" id="services">
        <div class="blackoverlay"></div>
        <h1 class="bannercaption wow fadeIn"> Careers at Suvrat Consulting</h1>
        <div class="scroll-down wow fadeInDown">
          <a rel="scrolling" class="btn-oval" href="#hiring"><i class="fa fa-angle-down"></i>
          </a>
        </div>
    </section>

    <section class="career" id="hiring">
        <div class="career-wrap">
            <h1 class="wow fadeInUp">WE'RE HIRING</h1>
            <h3 class="thrdcontnt wow fadeInUp">
            We are always on a look out for talented individuals to join our team
            </h3>
            <h3 class="thrdcontnt wow fadeInUp">If you have a passion to work in the Software Industry,<br> drop your resume in the space below and we will get in touch.</h3>
            <div class="formtouch wow fadeInUp">
                    <!--<p>Get in touch</p>-->
                    
                </div>
                <form enctype="multipart/form-data" action="mail.php" method="POST">
                    <div class="fileUpload btn btn-primary">
                        <span>Upload</span>
                        <input type="file" class="upload" />
                    </div>
                </form>

 

                <div class="carrerwrapper">
                    <form id="careersForm" action="uploadnow.php" class="dropzone" value="Computer">
                        <div id="loadingDiv"><i class="loadinggif"></i></div>
			            <p id="successMsg" style="display:none">Thank You for submitting your resume.We will review it and get in touch with you shortly in case we find it matching our requirements<p>
			            <p id="errorMsg" style="display:none">An error occured while submitting your resume.Please try again later<p>
                    </form>

                </div>

        </div>

    </section>

    <script type="text/javascript">
    $(document).ready(function(){
        var $loading = $('#loadingDiv');
        $loading.hide();
        // $loading.ajaxStart(function() {
        //     $(this).show();
        // }).ajaxComplete(function() {
        //     $(this).hide();
        // });
    });
    
        Dropzone.options.careersForm = {
            paramName: 'file',
            maxFilesize: 1, // MB
            maxFiles: 1,
            init: function() {
                this.on('addedfile', function(){
                    $('#loadingDiv').show();
                }),
                this.on('success', function( file, resp ){
                    console.log(resp);
                    if(resp.localeCompare("success"))
                    {
                        $('#successMsg').show();
                        console.log('form submitted.');
                    }
                    else
                    {
                        $('#errorMsg').show();
                        console.log('Error occured.');
                    }
                    $('#loadingDiv').hide();

                });
                this.on('error',function(file,errorMessage){
                    alert(errorMessage);
                    this.removeFile(file);
                    $('#loadingDiv').hide();
                });
                this.on("maxfilesexceeded", function(file){
                    this.removeFile(file);
                    alert("You cannot upload more than one files!!");
                    $('#loadingDiv').hide();
                });
                this.on('sending', function(file, xhr, formData){
                    formData.append('position', getCookie('position'));
                });
            }
        };
    </script>

    <section class="career position">
       
        <div class="career-wrap" id="carrreeerrr">

        <h1 class=" wow fadeInUp">OPEN POSITIONS</h1>
        <div class="vacancy">
                <!-- <div class="backend commonclass wow fadeInLeft">
                    <form action="action_page.php" oninput="x.value=parseInt(a.value)+parseInt(b.value)">
                        <div class="jobtitle">
                            <span>Backend developer</span>
                            <button type="submit" class="apply">Apply</button>
                        </div>
                        <div class="clearboth"></div>
                        <div class="jobdesc commonclass">
                            <ul>
                                <li>Must have X</li>
                                <li>Must have Y</li>
                                <li>Must have Z</li>
                            </ul>
                        </div>
                    </form>

                </div> -->
                <div class="frontend commonclass wow fadeInUp">
                    <div class="jobtitle">
                       <span>Frontend developer</span>
                    <a id="fd" href="#hiring" class="hiringgg">Apply</a>
                    </div>
                    <div class="clearboth"></div>
                    <div class="jobdesc">
                        <ul>
                     
                            <li>Excellent CSS and HTML Skills</li>
                            <li>Ability to convert Photoshop designs to HTML and CSS pages</li>
                            <li>Ability to build cross-browser and cross-device web pages</li>
                            <li>Ability to buid web pages for varying screen sizes</li>
                            <li>Experience with jQuery and javascript</li>
                            <li>Experience with Responsive Design</li>
                            <li>Experience with CSS frameworks like Bootstrap and Zurb</li>
                            <li>Experience with CSS preprocessors like SASS , LESS , Stylus etc.</li>
                            <li>Experience with cross browser issues</li>
                            <li>Very high attention to detail</li>
                            <li>Excellent communications skills</li>
                            <li>Experience with Illustration tools like Adobe CS</li>
                            <li>Experience with source code management tools like git</li>
                            <li>Should have a good design sense also</li>
                            <li>(Optional) Experience with Javascript frameworks like Angular, backbone etc</li>
                            <li>(Optional) Experience with visual and interaction design</li>
                        </ul>
                    </div>
                </div>
            </div><div class="clearboth"></div>
        </div>
    </section>

    <script>
        $( "#fd" ).click(function() {
            setCookie('position','Frontend developer');
        });
    </script>
    <footer>
        Copyright©2016
    </footer>
    
   
</body>
</html>
