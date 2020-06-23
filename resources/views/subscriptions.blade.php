<?php
use Stripe\Stripe;
use Stripe\Plan;

Stripe::setApiKey(env( 'STRIPE_SECRET_KEY' ) );
?>
@extends('layouts.apphome')

@section('content')

<script src="https://js.stripe.com/v3/"></script>

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
    box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
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
  .dropdown:hover .dropdown-content {
    display: block;
  }

  /* Change the background color of the dropdown button when the dropdown content is shown */
  .dropdown:hover .dropbtn {
    background-color: #ddd;
  }

  #success,
  #error {
    display: none;
  }

  .user-name-style {
    color: orange;
    font-weight: bold;
  }
</style>


<section class="home_p">
  <div class="container">
    <div class="row">
      
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="insidebox">
          <div class="box">
            <h3>54,036
              <!--<img src="/img/pros.png" height="20px" width="20px"/>-->
            </h3>
          </div>
          <div class="Working_tm_list" id="rightBox">
            <?php dd($task_list);?>
            <?php foreach ($subscriptions as $val) { 
                
                $product = Plan::retrieve( $val->stripe_plan );
                dump($product);
                ?>
              <p><strong><span class="user-name-style">{{ $val->stripe_status }}</span> {{ $val->created_at }} Min</strong> - <?php echo $val->task_name; ?></p>
            <?php } ?>
          </div>
          <!-- list ended here -->
        </div>
      </div>
    </div>
  </div>
</section>

<script>
  var mins = 0;
  var taskId = 0;
  var secondsLeft = 0;
  const userId = {{Auth::user()->id}};

  jQuery(document).ready(function() {

    
  });


  /* Used to display timer */
</script>


@endsection