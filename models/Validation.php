<?php

/**
 * Validation model
 */
class Validation
{
    /**
     * Errors array
     *
     * @var array
     */
    public static $errors = array();

    /**
     * Form Validation
     *
     * @param  array     $fields    All fields in form
     * @return bool      $valid     Validation result
     */
    public static function validate($fields = array())
    {
        // Get form field name and all rules for field
        foreach($fields as $field => $rules) {

            $field = htmlentities($field, ENT_QUOTES, 'UTF-8');
            $value = trim($_POST[$field]);

            // Get one rule and rule value for field
            foreach($rules as $rule => $rule_value) {

                // Validate field
                if ($rule === 'required' && empty($value)){
                    array_push(Self::$errors, 'Field '.$field.' is required');

                } else if (!empty($value)) {

                    switch($rule) {
                        case 'size_min':
                            if(strlen($value) < $rule_value) {
                                array_push(Self::$errors, 'Field '.$field.' must have a minimum of '. $rule_value.' characters');
                            }
                            break;
                        case 'size_max':
                            if(strlen($value) > $rule_value) {
                                array_push(Self::$errors, 'Field '.$field.'  must have a maximum of '.$rule_value.' characters');
                            }
                            break;
                        case 'email':
                            if(!filter_var($_POST[$rule_value], FILTER_VALIDATE_EMAIL)) {
                                array_push(Self::$errors, 'Field '.$field.' must be in email format');
                            }
                            break;
                        case 'confirm':
                            if($value != $_POST[$rule_value]) {
                                array_push(Self::$errors, 'Field '.$field.' must be equal to the field '. $rule_value);
                            }
                            break;
                        case 'unique':
                            $stmt = Database::getInstance()->query("SELECT COUNT($field) FROM $rule_value WHERE $field = '$value'");
                            $count = $stmt->fetchColumn();
                            if($count > 0) {
                                array_push(Self::$errors, 'Field '.$field.' is not unique');
                            }
                            break;
                    }
                }
            }
        }

        // Validation passed if $errors empty
        if(empty(Self::$errors)) {
            $valid = true;
        } else {
            $valid = false;
        }

        // Return validation result
        return $valid;
    }

    /**
     * Notifications array
     *
     * @return array    $notifications
     */
    public static function notifications()
    {
        // $errors as $notifications
        $notifications = Self::$errors;
        return $notifications;
    }
}
