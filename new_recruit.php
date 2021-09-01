<?php
include("app/classes/DB.php");
include('app/classes/Login.php');
$visitor_id = Login::isLoggedIn();
if ($visitor_id != 0) {
  $user = DB::select(['*'], ['users'], ['id' => $visitor_id])[0];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale-1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Candal&family=Lora:wght@500&family=Roboto&display=swap" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Baloo+Tammudu+2:wght@400;500&family=Nunito+Sans:wght@300;400;700&family=Nunito:wght@200;300;400&family=Roboto+Slab:wght@200;300;400&display=swap" rel="stylesheet">


  <script src="https://kit.fontawesome.com/a2de648733.js" crossorigin="anonymous"></script>


  <link rel="stylesheet" href="assets/css/newrecruit.css">

  <title>Find your collegues</title>
</head>

<body class="preload">
  <nav>
    <div class="logo">
      <h2><span>CL</span> Channel</h2>
    </div>
    <div class="menu">
      <ul>
        <li><a target=”_blank” href="index.php">HOME</a></li>
        <li><a target=”_blank” href="Pcentre.php">PROJECTS</a></li>
        <li><a target=”_blank” href="about.php">ABOUT</a></li>
      </ul>
    </div>
  </nav>

  <form id="regForm" action="">

    <!-- One "tab" for each step in the form: -->
    <div class="tab page1">
      <h1>A short title for your project</h1>
      <p><input type="text" id="projecttitle" placeholder="Project Title..." oninput="this.className = ''"></p>
      <h1>Introduction to your project</h1>
      <p><textarea id="projectintro" placeholder="Project Content..." oninput="this.className = ''"></textarea></p>
    </div>

    <div class="tab page2">
      <h1>Programming requirements for applicants</h1>
      <ul class="checkbox-grid" id="progreq">
        <li>
          <input type="checkbox" id="c" name="c" value="C">
          <label for="c">C</label><br>
        </li>
        <li>
          <input type="checkbox" id="cpp" name="cpp" value="Cpp">
          <label for="cpp">C++</label><br>
        </li>
        <li>
          <input type="checkbox" id="csharp" name="csharp" value="C#">
          <label for="csharp">C#</label><br>
        </li>
        <li>
          <input type="checkbox" id="go" name="go" value="GO">
          <label for="go">GO</label><br>
        </li>
        <li>
          <input type="checkbox" id="java" name="java" value="Java">
          <label for="java">Java</label><br>
        </li>
        <li>
          <input type="checkbox" id="javascript" name="javascript" value="JavaScript">
          <label for="javascript">JavaScript</label><br>
        </li>
        <li>
          <input type="checkbox" id="php" name="php" value="PHP">
          <label for="php">PHP</label><br>
        </li>
        <li>
          <input type="checkbox" id="python" name="python" value="Python">
          <label for="">Python</label><br>
        </li>
        <li>
          <input type="checkbox" id="r" name="r" value="R">
          <label for="r">R</label><br>
        </li>
        <li>
          <input type="checkbox" id="swift" name="swift" value="Swift">
          <label for="swift">Swift</label><br>
        </li>
      </ul>
      <h1>Technical requirements for applicants</h1>
      <ul class="checkbox-grid" id="techreq">
        <li>
          <input type="checkbox" id="Algorithm Development" name="Algorithm Development" value="Algorithm Development">
          <label for="Algorithm Development">Algorithm Development</label><br>
        </li>
        <li>
          <input type="checkbox" id="Big Data Processing" name="Big Data Processing" value="Big Data Processing">
          <label for="Big Data Processing">Big Data Processing</label><br>
        </li>
        <li>
          <input type="checkbox" id="Deep Learning" name="Deep Learning" value="Deep Learning">
          <label for="Deep Learning">Deep Learning</label><br>
        </li>
        <li>
          <input type="checkbox" id="Machine Learning" name="Machine Learning" value="Machine Learning">
          <label for="Machine Learning">Machine Learning</label><br>
        </li>
        <li>
          <input type="checkbox" id="Network Protocols" name="Network Protocols" value="Network Protocols">
          <label for="Network Protocols">Network Protocols</label><br>
        </li>
        <li>
          <input type="checkbox" id="Game Developement" name="Game Developement" value="Game Developement">
          <label for="Game Developement">Game Developement</label><br>
        </li>
        <li>
          <input type="checkbox" id="Software Development" name="Software Development" value="Software Development">
          <label for="Software Development">Software Development</label><br>
        </li>
        <li>
          <input type="checkbox" id="Web Development" name="Web Development" value="Web Development">
          <label for="Web Development">Web Development</label><br>
        </li>
      </ul>
      <h1>Additional Requirements</h1>
      <ul><textarea id="addreq" placeholder="More requirements..." oninput="this.className = ''"></textarea><ul>
    </div>
    <div class="tab">
      <h1>Jobs</h1>
      <ul class="joblist" id="joblist">
        <li class='job'>
          <div class='index'>
            <h3>Job1</h3>
          </div>
          <ul class='job-info'>
            <li>
              <div class='input-title'>Title:</div><input type="text" id="jobtitle" placeholder="Job Title" oninput="this.className = ''">
            </li>
            <li>
              <div class='input-title'>Capacity:</div><input type="text" id="jobcap" placeholder="Job Capacity" oninput="this.className = ''">
            </li>
          </ul>
        </li>
      </ul>
      <button type="button" id="addjob">Add Job</button>
    </div>


    <div style="overflow:auto;">
      <div style="float:right;margin-right: 50px">
        <button type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
        <button type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
      </div>
    </div>

    <!-- Circles which indicates the steps of the form: -->
    <div style="text-align:center;margin-top:40px;">
      <span class="step"></span>
      <span class="step"></span>
      <span class="step"></span>
    </div>

  </form>
</body>

</html>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>

<script>
  var currentTab = 0; // Current tab is set to be the first tab (0)
  showTab(currentTab); // Display the current tab

  function showTab(n) {
    // This function will display the specified tab of the form ...
    var x = document.getElementsByClassName("tab");
    x[n].style.display = "block";
    // ... and fix the Previous/Next buttons:
    if (n == 0) {
      document.getElementById("prevBtn").style.display = "none";
    } else {
      document.getElementById("prevBtn").style.display = "inline";
    }
    if (n == (x.length - 1)) {
      document.getElementById("nextBtn").innerHTML = "Submit";
    } else {
      document.getElementById("nextBtn").innerHTML = "Next";
    }
    // ... and run a function that displays the correct step indicator:
    fixStepIndicator(n)
  }

  function nextPrev(n) {
    // This function will figure out which tab to display
    var x = document.getElementsByClassName("tab");
    // Exit the function if any field in the current tab is invalid:
    if (n == 1 && !validateForm()) return false;
    // Hide the current tab:
    x[currentTab].style.display = "none";
    // Increase or decrease the current tab by 1:
    currentTab = currentTab + n;
    // if you have reached the end of the form... :
    if (currentTab >= x.length) {
      //...the form gets submitted:
      submitForm();
      return false;
    }
    // Otherwise, display the correct tab:
    showTab(currentTab);
  }

  function getCheckboxValues(checkboxID){
    var selected = [];
    $(`#${checkboxID} input:checked`).each(function() {
      selected.push($(this).attr('name'));
    });
    return selected;
  }
  function getJoblist(){
    jobs = [];
    $("#joblist .job").each(function(){
      jobs.push(`{
        "jobtitle":"${$(this).find("#jobtitle").val()}",
        "jobcap":"${$(this).find("#jobcap").val()}"
      }`)
    });
    return jobs;
  }
  function submitForm(){
    
    postinfo = JSON.stringify({
      projecttitle: $("#projecttitle").val(),
      projectintro: $("#projectintro").val(),
      progreq: getCheckboxValues("progreq"),
      techreq: getCheckboxValues("techreq"),
      addreq: $("#addreq").val(),
      joblist: getJoblist(),
      uid: <?php echo $visitor_id?>
    })
    console.log(postinfo);
    $.ajax({
            url: 'api/recruit',
            type: 'post',
            processData: false,
            contentType: 'application/json',
            success: function (data) {
                console.log(data);
            },
            beforeSend: function(){
              console.log("sending");
            },
            error: function(err){
              console.log(err);
            },
            data: postinfo
        });
  }
  function validateForm() {
    // This function deals with validation of the form fields
    var x, y, i, valid = true;
    x = document.getElementsByClassName("tab");
    y = x[currentTab].getElementsByTagName("input");
    // A loop that checks every input field in the current tab:
    for (i = 0; i < y.length; i++) {
      // If a field is empty...
      if (y[i].value == "") {
        // add an "invalid" class to the field:
        y[i].className += " invalid";
        // and set the current valid status to false:
        valid = false;
      }
    }
    // If the valid status is true, mark the step as finished and valid:
    if (valid) {
      document.getElementsByClassName("step")[currentTab].className += " finish";
    }
    return valid; // return the valid status
  }

  function fixStepIndicator(n) {
    // This function removes the "active" class of all steps...
    var i, x = document.getElementsByClassName("step");
    for (i = 0; i < x.length; i++) {
      x[i].className = x[i].className.replace(" active", "");
    }
    //... and adds the "active" class to the current step:
    x[n].className += " active";
  }
  jobnum = 1
  function addNewJob(){
    jobnum = jobnum+1;
    console.log("add new job");
    var newjob = $("<li>").html("<div class='index'>\
            <h3>Job"+jobnum+"</h3>\
          </div>\
          <ul class='job-info'>\
            <li>\
              <div class='input-title'>Title:</div><input type=\"text\" id=\"jobtitle\" placeholder=\"Job Title\" oninput=\"this.className = ''\">\
            </li>\
            <li>\
              <div class='input-title'>Capacity:</div><input type=\"text\" id=\"jobcap\" placeholder=\"Job Capacity\" oninput=\"this.className = ''\">\
            </li>\
          </ul>").addClass("job");
    $("#joblist").append(newjob);
  }
  $("#addjob").click(addNewJob);
</script>