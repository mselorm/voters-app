<?php



/*********************
 * login function
/*********************/
function login_user(){
include 'db.php';


    extract($_POST);
    if(!empty($phone)){

                    $this_phone = mysqli_real_escape_string($con, $phone);
                    $verify_num =  rand();
                    $verify_num = substr($verify_num, 0, 4);
                 
                    try {
              
                $results = mysqli_query($con, "SELECT * FROM  voters WHERE phone = $this_phone");
                if(!mysqli_num_rows( $results)){
                    $output = array(
                        "phone" =>  -1,
                        "success" => "not registered"
                        );
                 
                 echo $output = json_encode($output);
            
                } else{
                   
                    while($row = mysqli_fetch_array($results)){
                        extract($row);
                        if ($phone == $this_phone){
                             $_SESSION['user_in'] = true;
                                    /************* */
                                        //send otp 
                                    /************* */
                                   
                                         $result =  mysqli_query($con, "UPDATE voters SET pin = '".$verify_num."' WHERE  phone = '".$this_phone."' ");
                             
                                         if(!$result){
                                             throw new Exception( "failed to update pin" .mysqli_error($con));
                                         } else{
                                            $output = array(
                                                "phone" =>  $this_phone,
                                                "pin" =>  $verify_num,
                                                "success" => "yes"
                                                );
                                         }
                                         echo $output = json_encode($output);


                        } else{
                            $output = array(
                                "phone" =>  -1,
                                "success" => "no"
                                );
                                echo $output = json_encode($output);
 
                        }
                    }
                }
        

            } catch (Exception $th) {
                // echo $th->getMessage();
            }

     

    } else {
        $output = array(
            "phone" =>  -4,
            "success" => "no_phone"
            );
            echo $output = json_encode($output);
    }
    



}


/******************** */
    //Register
/******************** */

function register(){

    require 'db.php';

    extract($_POST);


    
    if(isset($phone)){


       if ( strlen($phone)  > 9 && strlen($phone) < 11 ) {

        /*********************/
            //insert phone
        /**********************/
        try {

            $verify_num =  rand();

            $verify_num = substr($verify_num, 0, 4);
        

           $r = mysqli_query($con,  "SELECT * FROM voters WHERE phone = '$phone' ");
           if(mysqli_num_rows($r) > 0 ) {

                    while ($row = mysqli_fetch_array($r))
                        $output = array(
                            "phone" =>  -1,
                            "data_received" => "user already register name is  " . $row['firstname'],
                             "new_user" => -1
                              );             
                              echo $output = json_encode($output);
                    
           
                
                      } else {
                   $result = mysqli_query($con, "INSERT INTO voters (firstname, phone, pin) Values ('$name', '$phone', '$verify_num')");
                  if(!$result){
                      throw new Exception("failed to insert new user" . mysqli_error($con));
                      } else {
                                    #set session user_in to true
                            $_SESSION['user_in'] = true;

                            $output = array(
                            "phone" =>  $phone,
                            "pin" =>  $verify_num,
                            "data_received" => "yes",
                            "new_user" => 1
                            );
          
                         echo $output = json_encode($output);
                    }

                }
                 
            } catch (Exception $th) {
               // echo $th->getMessage();
            }

                
     } else {
             $output = array(
            "phone" =>  -4,
            "data_received" => "no phone sent",
             "new_user" => -1
              );  

              echo $output = json_encode($output);
            }
        }

    }




                /***************** *
                    verify phone
                /***************** */

            function verify_phone_(){
                include 'db.php';
                extract($_POST);
                $_SESSION['verify'] = false;

                $this_phone = $_SESSION['phone'];
          
                if(!empty($fourth_box)){

                  $verify_num = $first_box . $second_box . $third_box . $fourth_box;
              
               $result = mysqli_query($con, "SELECT * FROM voters WHERE phone = $this_phone ");
                if(!$result) {  
                exit("this phone doesn't exit");
                } else { 
                    while($r = mysqli_fetch_array($result)){
                        if($verify_num == $r['pin']){
                        $_SESSION['verify'] = true;
                        exit("successful");
                    } exit( "wrong pin, not found..!");
                    }
     
              }

              }  else echo "no pin number sent ";
              
              }


              function vote(){
                  include 'db.php';

                  extract($_POST);
                  echo "positon" .$postion;
                  echo  "candidate". $candidate;

                  if(isset($candidate)){
                    if($postion == "president"){

                        
                        switch ($candidate) {
                            case "adjoa":
                                $current_value;
                            $select = mysqli_query($con, "SELECT * FROM president WHERE user_id = 1");
                            if(!$select){
                                echo "failed to get current results from president" . mysqli_error($con);
                             } else {
                                $current_value += 1;
                            
                            $result = mysqli_query($con, "UPDATE president set adjoa = $current_value");
                            if(!$result){
                                echo "failed to update adjoa's vote" . mysqli_error($con);
                             }
                             }
                            break;
                            case "kofi":
                                $current_value;
                                $select = mysqli_query($con, "SELECT * FROM president WHERE user_id = 1");
                                if(!$select){
                                    echo "failed to get current results from president" . mysqli_error($con);
                                 } else {
                                    $current_value + 1;
                                
                                $result = mysqli_query($con, "UPDATE president set kofi = $current_value");
                                if(!$result){
                                    echo "failed to update adjoa's vote" . mysqli_error($con);
                                 }
                                 }
                            break;
                            case "yaw":
                                $current_value;
                                $select = mysqli_query($con, "SELECT * FROM president WHERE user_id = 1");
                                if(!$select){
                                    echo "failed to get current results from president" . mysqli_error($con);
                                 } else {
                                    $current_value + 1;
                                
                                $result = mysqli_query($con, "UPDATE president set adjoa = $current_value");
                                if(!$result){
                                    echo "failed to update adjoa's vote" . mysqli_error($con);
                                 }
                                 }
                            break;
                            case "afia";
                            $current_value;
                            $select = mysqli_query($con, "SELECT * FROM president WHERE user_id = 1");
                            if(!$select){
                                echo "failed to get current results from president" . mysqli_error($con);
                             } else {
                                $current_value + 1;
                            
                            $result = mysqli_query($con, "UPDATE president set adjoa = $current_value");
                            if(!$result){
                                echo "failed to update adjoa's vote" . mysqli_error($con);
                             }
                             }
                             break;
                            default:
                            echo "no vote was cast";
                        }

                    }


                  }else {
                      echo "no candidate selected..!";
                  }
              }


              function test_unit(){
                  echo "route is working fine";
              }