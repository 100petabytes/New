@extends('layouts.apphome')

@section('content')
<style>

body {
  font-family: 'Nunito', sans-serif;
  font-weight: 200;
  height: 100vh;
  margin: 0;
}

.addTimer{
  position: fixed;
left: 12em;
right: 1.25em;
top: 20em;
}

.box {
  background-color: #e1e9f5;
  width: 28em;
  max-height: 49em;
  float: right;
  border-radius: 15px;
  margin: 0.5em;
   opacity: 0.5;
   overflow-y: auto;
}

.insidebox h3 {
  font-family: 'Quicksand', sans-serif;
  color: black;
  position: fixed;
  right: 5.5em;
    max-height: 49em;
    overflow-y: auto;
}
/*
.wrapper p {
  font-size: 15px;
  color: white;
  left: 28em;
  right: 6.25em;
  top: 28.25em;
}

.wrapper h2 {
  left: 5em;
  right: 1.25em;
  top: 10em; */

/* Dropdown Button
 .dropbtn {
  background-color: #ddd;
  color: white;
  padding: 16px;
  font-size: 16px;
  border: none;
} */

/* The container <div> - needed to position the dropdown content */
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
.dropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
  overflow-y: auto;
}

.wrapper {
  position: fixed;
left: 12em;
right: 1.25em;
top: 10em;
}

/* Change color of dropdown links on hover */
.dropdown-content a:hover {background-color: #ddd;}

/* Show the dropdown menu on hover */
.dropdown:hover .dropdown-content {display: block;}

/* Change the background color of the dropdown button when the dropdown content is shown */
.dropdown:hover .dropbtn {background-color: #ddd;}

</style>

<div>
  <div class="insidebox">

  <div class="box">
    <h3>54,036<img src="/img/pros.png" height="20px" width="20px"/> </h3>
    <br />
    <br />
    <br />
    <br />
    <br />
    <br />
    <p><strong>Milan 25min</strong> - Working on some biologyWorking on some biology</p>
    <br />
      <p><strong>Milan 25min</strong> - Working on some biology</p>
      <br />
        <p><strong>Milan 25min</strong> - Working on some biology</p>
        <br />
        <p><strong>Milan 25min</strong> - Working on some biology</p>
        <br />
          <p><strong>Milan 25min</strong> - Working on some biology</p>
          <br />
            <p><strong>Milan 25min</strong> - Working on some biology</p>
            <br />
            <p><strong>Milan 25min</strong> - Working on some biology</p>
            <br />
              <p><strong>Milan 25min</strong> - Working on some biology</p>
              <br />
                <p><strong>Milan 25min</strong> - Working on some biology</p>
                <br />
                <p><strong>Milan 25min</strong> - Working on some biology</p>
                <br />
                  <p><strong>Milan 25min</strong> - Working on some biology</p>
                  <br />
                    <p><strong>Milan 25min</strong> - Working on some biology</p><br />
                    <p><strong>Milan 25min</strong> - Working on some biology</p>
                    <br />
                      <p><strong>Milann 25min</strong> - Working on some biology</p>
                      <br />
                        <p><strong>Mila 25min</strong> - Working on some biology</p>
                        <br />
                        <p><strong>Milan 25min</strong> - Working on some biology</p>
                        <br />
                          <p><strong>Milan 25min</strong> - Working on some biology</p>
                          <br />
                            <p><strong>Milan 25min</strong> - Working on some biology</p>
    </div>
  </div>

</div>

<div class="wrapper">

<h1> Hello, {{Auth::user()->name }}</h1>
<p>
  What are we working on?
</p>
</div>


<div class="addTimer">

  <div class="timer>">
    <div class="timer__contorls">
      <div>
        <input type="text" name="Task" autocomplete="off" placeholder="Enter Task Here">
        @error('task')<p style="color:red;">{{$message}}</p> @enderror
      </div>


      <form>
      <!-- <div>
        <label><strong> How long are we talkin here?</strong></lable>
<div>
  <button  data-time="5">5 minutes </button>
  <button  data-time="10">10 minutes </button>
  <button  data-time="15">15 minutes </button>
  <button  data-time="25">25 minutes </button>
  <button  data-time="45">45 minutes </button>
  <button  data-time="60">1 hour </button>
  <button  data-time="120">2 hours </button>
</div>



      </div> -->







      <form name="customForm" id="custom">


        <input type="text" id="minutes" placeholder="Enter Minutes">
       @error('numeric')<p style="color:red;">{{$message}}</p> @enderror
        </form>
        <button type="button" id="buttonTimer">Submit</button>
      </div>
      <div class="display">
        <h1 class="display__time-left"></h1>
        </div>
    </div>

</div>


</div>






    <script src="/app.js"></script>


@endsection
