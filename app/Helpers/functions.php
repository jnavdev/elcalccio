<?php

if (! function_exists('getVideoIdYoutube')) {
    function getVideoIdYoutube($url) {
        parse_str(parse_url($url, PHP_URL_QUERY), $my_array_of_vars);

        return $my_array_of_vars['v'];
    }
}

if (! function_exists('chileanPeso')) {
    function chileanPeso($money) {
        return number_format($money, 0, '', '.');
    }
}

if (! function_exists('getMonthName')) {
    function getMonthName($month) {
        $translatedMonth = '';
        switch ($month) {
            case 'January':
                $translatedMonth = 'Enero';
                break;
            case 'February':
                $translatedMonth = 'Febrero';
                break;
            case 'March':
                $translatedMonth = 'Marzo';
                break;
            case 'April':
                $translatedMonth = 'Abril';
                break;
            case 'May':
                $translatedMonth = 'Mayo';
                break;
            case 'June':
                $translatedMonth = 'Junio';
                break;
            case 'July':
                $translatedMonth = 'Julio';
                break;
            case 'August':
                $translatedMonth = 'Agosto';
                break;
            case 'September':
                $translatedMonth = 'Septiembre';
                break;
            case 'October':
                $translatedMonth = 'Octubre';
                break;
            case 'November':
                $translatedMonth = 'Noviembre';
                break;
            case 'December':
                $translatedMonth = 'Diciembre';
                break;
        }

        return $translatedMonth;
    }
}
