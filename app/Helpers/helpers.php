<?php
// app/Helpers/helpers.php

if (! function_exists('convertDigitsToBengali')) {
    function convertDigitsToBengali($number) {
        $englishDigits = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        $bengaliDigits = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];

        return str_replace($englishDigits, $bengaliDigits, $number);
    }
}
