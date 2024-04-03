<?php
require_once("../app/model/ContactUs.php");

/**
 * ContactUsController
 * 
 * This class handles the contact us form
 * 
 * @category Controller
 * @package  ContactUsController
 * 
 */
class ContactUsController{

    /**
     * Sanitize input
     * 
     * @param string $input input to be sanitized
     * 
     * @return string sanitized input
     * 
     * @var string $input input to be sanitized
     */
    public function sanitize_input($input)
    {
        $input = trim($input);
        $input = stripslashes($input);
        $input = htmlspecialchars($input);
        return $input;
    }

    /**
     * Submit contact us form
     * 
     * @return bool
     * @var string $errorMsg error message
     * @var bool $success success status
     * @var string $fname full name
     * @var string $email email
     * @var string $description description
     * 
     */
    public function submit_us(){
        $errorMsg = "";
        $success = true;
        $fname = $this->sanitize_input($_POST["fullname"]);
        $email = $this->sanitize_input($_POST["email"]);
        $description = $this->sanitize_input($_POST["description"]);
    
        if (empty($fname) || empty($email) || empty($description)){
            $errorMsg .= "Please fill in all required fields.";
            $success = false;
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errorMsg .= "Invalid email format.<br>";
            $success = false;
        }
    
        if($success){
            $_SESSION["contactus"] = "Message successfully sent.";
            $values=[
                'name' => $fname,
                'email' => $email,
                'message' => $description
            ];
            $contactus = new ContactUs($values);
            return $contactus->add();
        } else {
            $_SESSION["contactus"] = $errorMsg;
        }
    }

}