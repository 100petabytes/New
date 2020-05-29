@extends('layouts.apphome')

@section('content')

<style>

body {
  font-family: 'Nunito', sans-serif;
  font-weight: 200;
  height: 100vh;
  margin: 0;
}

.dropdown {
  position: relative;
  display: inline-block;
}

/* Dropdown Content (Hidden by Default) */
.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f1f1f1;
  min-width: 160px;
  max-height: 53em;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
  overflow-y: auto;
}

/* Links inside the dropdown */
/*.dropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
  overflow-y: auto;
}*/

/* Change color of dropdown links on hover */
/*.dropdown-content a:hover {background-color: #ddd;}*/

/* Show the dropdown menu on hover */
.dropdown:hover .dropdown-content {display: block;}

/* Change the background color of the dropdown button when the dropdown content is shown */
.dropdown:hover .dropbtn {background-color: #ddd;}

#success, #error{
    display:none;
}

.user-name-style {
    color: orange;
    font-weight: bold;
}
</style>


<section class="home_p">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
        <div class="lft_side_form">

          <div class="wrapper">
            <h1> Hello, {{Auth::user()->name }}</h1>
            <p>What are we working on?</p>
          </div>
            <!-- wrapper ended here -->

          <div class="addTimer">
            <div class="timer>">
              <div class="timer__contorls">
                <p class="alert alert-success" id="success"></p>
                <p class="alert alert-warning" id="error"></p>
                <form name="customForm" id="customForm">
                      <!--<input type="text" name="Task" autocomplete="off" placeholder="Enter Task Here">-->
                    <div>
                        <input type="text" name="Task" id="Task" required autocomplete="off" placeholder="Enter Task Here" maxlength="50">
                    </div>
                    <div>
                        <input type="text" name="minutes" id="minutes" placeholder="Enter Minutes" onkeyup="validateNumber()" required maxlength="3" autocomplete="off">
                    </div>
                    <button type="submit" id="buttonTimer">Submit</button>
                </form>
              </div>
              <div class="display">
                <h1 class="display__time-left text-center"></h1>
              </div>
              <!-- timer ended here -->
            </div>
          </div>

        </div>
      </div>
      <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
        <div class="insidebox">
          <div class="box">
            <h3>54,036
                <!--<img src="/img/pros.png" height="20px" width="20px"/>-->
            </h3>
          </div>
          <div class="Working_tm_list" id="rightBox">
            <?php foreach($task_list as $val) { ?>
              <p><strong><span class="user-name-style">{{ $val->name }}</span> {{ $val->minutes }} Min</strong> - <?php echo $val->task_name; ?></p>
            <?php } ?>
          </div>
            <!-- list ended here -->
        </div>
      </div>
    </div>
  </div>
</section>
<script>
    var mins;
    jQuery(document).ready(function() {
        
        jQuery("#customForm").validate({
            rules: {
                'Task': {
                    required: true
                },
                'minutes': {
                    required: true
                }
            },
            messages: {
                'Task': {
                    required: 'Please enter task',
                    max: 'Only 50  characters are allowed'
                },
                'minutes': {
                    required: 'Please enter minutes'
                }
            },
            submitHandler: function() {
                var task = jQuery("#Task").val();
                var mins = jQuery("#minutes").val();
                jQuery.ajax({
                    type: "POST",
                    url: "create-task",
                    async: false,
                    dataType: "json",
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                      },
                    data:{
                        task: task,
                        minutes: mins,
                        userId: {{Auth::user()->id }}
                    },
                    success: function(response) {
                        if(response.status){
                            var html="<p><strong><span class='user-name-style'>"+response.data.username+"</span> "+response.data.minute+" Min</strong> - "+response.data.task_name+"</p>";
                            jQuery("#rightBox").prepend(html);
                            jQuery('#Task').val('');
                            jQuery('#minutes').val('');
                            jQuery("#success").html(response.message);
                            jQuery('#success').show();
                            setTimeout(function() {
                                jQuery('#success').hide();
                            }, 5000);
                            startTimer(mins);
                        } else {
                            jQuery("#error").html(response.message);
                            jQuery("#error").show();
                            setTimeout(function() {
                                jQuery('#error').hide();
                            }, 5000);
                        }

                    }
                });
            }
        });

        function sendRequest(){
            console.log('goo');
             jQuery.ajax({
                type: "get",
                url: "task-list",
                async: false,
                dataType: "json",
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                  },

                success: function(data) {
                    if(data.msg == "success"){
                        var html = "";
                        jQuery.each( data.res, function( key, val ) {
                            html +="<p><strong><span class='user-name-style'>"+val.name+"</span> "+val.minutes+" Min</strong> - "+val.task_name+"</p>";
                        });
                        //console.log(html);
                        jQuery("#rightBox").html(html);
                    }

                }
            });
        }

        setInterval(sendRequest, 60000);
    });
    
    /* Used to display timer */
    var countdown;
    const timerDisplay = document.querySelector('.display__time-left');

    function timer(seconds) {
        // clear any existing timerDisplay
        if(countdown) {
          clearInterval(countdown);
        }

        const now = Date.now();
        const then = now + seconds * 1000;
        displayTimeLeft(seconds);

        countdown = setInterval(() => {

            const secondsLeft = Math.round((then - Date.now()) / 1000);

            // Check if we should stop timer
            if (secondsLeft < 0) {
                clearInterval(countdown);
                return;
            }
            // Display it
            displayTimeLeft(secondsLeft);

        }, 1000);
    }

    function displayTimeLeft(seconds) {
        const minutes = Math.floor(seconds / 60);
        const remainderSeconds = seconds % 60;
        // var display = '${minutes}:${remainderSeconds < 10 ? '0 ' : ''}${remainderSeconds}';
        var display;
        // var display = minutes + ":" +  remainderSeconds;
        if(remainderSeconds < 10) {
          display = minutes + ":" + "0" + remainderSeconds;
        } else {
          display = minutes + ":" +  remainderSeconds;
        }
        document.title = display;
        timerDisplay.textContent = display;
    }

    function startTimer(mins){
        console.log(mins);
        timer(mins * 60);
    }
    /* Used to display timer */
</script>
@endsection