<?php

    include 'dbConnection.php';

    $sql1 = "SELECT itemName, description, price FROM ws_items WHERE itemID = '1'";
    $result1 = mysqli_query($dbConnection, $sql1);
    $row1 = mysqli_fetch_object($result1);

    $sql2 = "SELECT itemName, description, price FROM ws_items WHERE itemID = '2'";
    $result2 = mysqli_query($dbConnection, $sql2);
    $row2 = mysqli_fetch_object($result2);

    $sql3 = "SELECT itemName, description, price FROM ws_items WHERE itemID = '3'";
    $result3 = mysqli_query($dbConnection, $sql3);
    $row3 = mysqli_fetch_object($result3);

    $sql4 = "SELECT itemName, description, price FROM ws_items WHERE itemID = '4'";
    $result4 = mysqli_query($dbConnection, $sql4);
    $row4 = mysqli_fetch_object($result4);

    $sql5 = "SELECT itemName, description, price FROM ws_items WHERE itemID = '5'";
    $result5 = mysqli_query($dbConnection, $sql5);
    $row5 = mysqli_fetch_object($result5);

    $sql6 = "SELECT itemName, description, price FROM ws_items WHERE itemID = '6'";
    $result6 = mysqli_query($dbConnection, $sql6);
    $row6 = mysqli_fetch_object($result6);

    $sql7 = "SELECT itemName, description, price FROM ws_items WHERE itemID = '7'";
    $result7 = mysqli_query($dbConnection, $sql7);
    $row7 = mysqli_fetch_object($result7);

    $sql8 = "SELECT itemName, description, price FROM ws_items WHERE itemID = '8'";
    $result8 = mysqli_query($dbConnection, $sql8);
    $row8 = mysqli_fetch_object($result8);

?>