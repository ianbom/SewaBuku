<?php

use Carbon\Carbon;

if (!function_exists('formatResponse')) {
    function formatResponse($status, $message, $data = null, $errors = null, $httpCode = 200)
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
            'errors' => $errors
        ], is_int($httpCode) ? $httpCode : 500);
    }
}

if (!function_exists('formatToIndonesianCurrency')) {
    /**
     * Format a number to Indonesian currency.
     *
     * @param float|int $number
     * @return string
     */
    function formatToIndonesianCurrency($number)
    {
        // Ensure the number is an integer by flooring it
        $integerNumber = floor($number);
        return 'Rp ' . number_format($integerNumber, 0, ',', '.');
    }
}

if (!function_exists('formatDateIndonesian')) {
    /**
     * Format a date string (SQL format) to Indonesian date format.
     *
     * @param string|null $dateString
     * @return string
     */
    function formatDateIndonesian($dateString)
    {
        if (!$dateString) {
            return '-';
        }

        // Set the locale to Indonesian
        Carbon::setLocale('id');

        try {
            // Parse the SQL-format date and format it
            $date = Carbon::createFromFormat('Y-m-d', $dateString);
            return $date->translatedFormat('l, d F Y'); // 'l' for day name, 'd' for day, 'F' for month, 'Y' for year
        } catch (\Exception $e) {
            // Handle invalid date strings
            return '-';
        }
    }
}

if (!function_exists('formatDateIndonesianWithoutDay')) {
    /**
     * Format a date string (SQL format) to Indonesian date format.
     *
     * @param string|null $dateString
     * @return string
     */
    function formatDateIndonesianWithoutDay($dateString)
    {
        if (!$dateString) {
            return '-';
        }

        // Set the locale to Indonesian
        Carbon::setLocale('id');

        try {
            // Parse the SQL-format date and format it
            $date = Carbon::createFromFormat('Y-m-d', $dateString);
            return $date->translatedFormat('d F Y'); // 'l' for day name, 'd' for day, 'F' for month, 'Y' for year
        } catch (\Exception $e) {
            // Handle invalid date strings
            return '-';
        }
    }
}

if (!function_exists('formatMonthIndonesian')) {
    /**
     * Format a date string (SQL format) to Indonesian date format.
     *
     * @param string|null $dateString
     * @return string
     */
    function formatMonthIndonesian($dateString)
    {
        if (!$dateString) {
            return '-';
        }

        // Set the locale to Indonesian
        Carbon::setLocale('id');

        try {
            // Parse the SQL-format date and format it
            $date = Carbon::createFromFormat('Y-m-d', $dateString);
            return $date->translatedFormat('F'); // 'l' for day name, 'd' for day, 'F' for month, 'Y' for year
        } catch (\Exception $e) {
            // Handle invalid date strings
            return '-';
        }
    }
}
