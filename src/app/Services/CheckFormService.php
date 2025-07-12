<?php

namespace App\Services;

class CheckFormService 
{
    public static function checkGender(int $data){
        if($data === 1){$gender = '男性';}
        if($data === 2){$gender = '女性';}
        if($data === 3){$gender = 'その他';}
        return $gender;
    }

    public static function makeFullName(string $firstName, string $lastName){
        return $lastName. '　'. $firstName;
    }
}