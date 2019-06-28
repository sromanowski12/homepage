<?php
//    Name:       Seth Romanowski
//    Course:     Web Programming
//    Assignment: Assignment #5 - Process Form

    include_once("home_club_membership_class.php");

    $temp = $_POST['email'];
    $temp2 = $_POST['fname'];
    $temp3= $_POST['lname'];
    $temp4 = $_POST['sex'];

    $myClub = new Club("localhost", "A340User", "Pass123Word", "info_club");

    $myClub->ProcessRegistrationForm();

    echo("<a href='https://sethi.sgedu.site/resources/home.php>Go Back</a>");
?>