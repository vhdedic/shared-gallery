<?php
/**
 *
 */
class Validation
{
    public static $errors = array();

    public static function validate($fields = array())
    {
        foreach($fields as $field => $rules) {

            $field = htmlentities($field, ENT_QUOTES, 'UTF-8');
            $value = trim($_POST[$field]);

            foreach($rules as $rule => $rule_value) {

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

        if(empty(Self::$errors)) {
            $valid = true;
        } else {
            $valid = false;
        }

        return $valid;
    }

    public static function notifications()
    {
        $notifications = Self::$errors;
        return $notifications;
    }
}
