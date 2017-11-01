<?php


function check_empty_fields($required_fields_array){
    //initialize anarray to store error messages;
    $form_errors = array();

    //loop through the required fields array and populate the form error array

    foreach ($required_fields_array as $name_of_field){
        if (!isset($_POST[$name_of_field]) || $_POST[$name_of_field] == NULL){
            $forms_errors[] = $name_of_field . " is a required field";
        }
    }

    return $form_errors;
}

function check_min_length($fields_to_check_length){
    //initialize an array to store error messages
    $form_errors = array();

    foreach ($fields_to_check_length as $name_of_field => $min_len_required){
        if (strlen(trim($_POST[$name_of_field])) < $min_len_required){
            $errors[] = $name_of_field . "is too short, Must be {$min_len_required} characters long";
        }
    }
    return $form_errors;
}

function check_email($data){
    //initialise an array to store error messages
    $errors = array();
    $key = 'email';

    //check if the key email exist in data array
    if (array_key_exists($key, $data)){
        //check if the email field has a value
        if ($_POST[$key] != null){
            //Remove all illegal chararcters from email
            $key = filter_var($key, FILTER_SANITIZE_EMAIL);

            //check if input is valid email address
            if (filter_var($_POST[$key], FILTER_VALIDATE_EMAIL) === false){
                $form_errors[] = $key . " is not a valid email address";
            }
        }
    }
    return  $form_errors;
}

function show_errors($form_errors_array){
    $errors = "<ul style='color: red'>";

    //loop through the error array and display all items
    foreach ($form_errors_array as $the_error){
        $errors .= "<li> {$the_error}</li>";
    }
    $errors .= "</ul></p>";

    return $errors;
}