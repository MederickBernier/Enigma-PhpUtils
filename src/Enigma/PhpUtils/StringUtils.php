<?php

declare(strict_types=1);

namespace Enigma\PhpUtils;

/**
 * A final utility class that provides various string-related helper methods.
 * 
 * This class is part of the Enigma PHP Utilities library and is designed
 * to offer static methods for common string operations. Being declared as
 * final, it cannot be extended.
 * 
 * @package Enigma\PhpUtils
 */
final class StringUtils
{
    /**
     * Private constructor to prevent instantiation of the class.
     * This class is intended to be used statically.
     */
    private function __construct() {}

    /**
     * Converts a given string into a URL-friendly "slug".
     *
     * This method performs the following transformations:
     * - Replaces non-alphanumeric characters with hyphens.
     * - Transliterates characters to ASCII.
     * - Removes any remaining non-alphanumeric characters except hyphens.
     * - Converts the string to lowercase and trims trailing or leading hyphens.
     *
     * @param string $text The input string to be slugified.
     * @return string The slugified version of the input string.
     */
    public static function slugify(string $text): string
    {
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        return strtolower(trim($text, '-'));
    }

    /**
     * Converts a given string to camelCase format.
     *
     * This method replaces hyphens and underscores with spaces, converts the string
     * to lowercase, capitalizes the first letter of each word (except the first word),
     * and removes spaces to produce a camelCase string.
     *
     * @param string $string The input string to be converted.
     * @return string The camelCase formatted string.
     */
    public static function toCamelCase(string $string): string
    {
        $string = str_replace(['-', '_'], ' ', strtolower($string));
        $string = ucwords($string);
        return lcfirst(str_replace(' ', '', $string));
    }

    /**
     * Truncates a string to a specified length and appends a suffix if necessary.
     *
     * @param string $string The input string to be truncated.
     * @param int $length The maximum length of the truncated string (default is 100).
     * @param string $suffix The string to append to the truncated string (default is '...').
     * @return string The truncated string with the suffix appended if truncation occurred.
     */
    public static function truncate(string $string, int $length = 100, string $suffix = '...'): string
    {
        return strlen($string) > $length ? substr($string, 0, $length) . $suffix : $string;
    }

    /**
     * Generates a cryptographically secure random string of the specified length.
     *
     * This method uses `random_bytes` to generate a random binary string and
     * converts it to a hexadecimal representation using `bin2hex`.
     *
     * @param int $length The desired length of the random string. Must be an even number
     *                    to ensure proper conversion to hexadecimal. Defaults to 16.
     * @return string A random hexadecimal string of the specified length.
     * @throws Exception If it was not possible to gather sufficient entropy.
     */
    public static function randomString(int $length = 16): string
    {
        return bin2hex(random_bytes($length / 2));
    }

    /**
     * Reverses the given string.
     *
     * This method takes a string as input and returns the reversed version of it.
     *
     * @param string $string The string to be reversed.
     * @return string The reversed string.
     */
    public static function reverse(string $string): string
    {
        return strrev($string);
    }

    /**
     * Converts a given string to snake_case format.
     *
     * This method transforms a string by replacing uppercase letters with an 
     * underscore followed by the lowercase equivalent, and ensures that any 
     * non-alphanumeric characters (except underscores) are replaced with underscores.
     *
     * Example:
     * - Input: "HelloWorld"
     * - Output: "hello_world"
     *
     * @param string $string The input string to be converted to snake_case.
     * @return string The converted string in snake_case format.
     */
    public function toSnakeCase(string $string): string
    {
        $string = strtolower(preg_replace('/[A-Z]/', '_$0', lcfirst($string)));
        return preg_replace('/[^a-z0-9_]/', '_', $string);
    }

    /**
     * Checks if a given string starts with a specified substring.
     *
     * @param string $string The string to check.
     * @param string $startString The substring to look for at the start of the string.
     * @return bool Returns true if the string starts with the specified substring, false otherwise.
     */
    public static function startsWith(string $string, string $startString): bool
    {
        return strncmp($string, $startString, strlen($startString)) === 0;
    }

    /**
     * Checks if a given string ends with the specified substring.
     *
     * @param string $string The string to check.
     * @param string $endString The substring to check for at the end of the string.
     * @return bool Returns true if the string ends with the specified substring, false otherwise.
     */
    public static function endsWith(string $string, string $endString): bool
    {
        return $endString === '' || substr($string, -strlen($endString)) === $endString;
    }

    /**
     * Checks if a given substring exists within a string.
     *
     * @param string $string The string to search within.
     * @param string $subString The substring to search for.
     * @return bool Returns true if the substring is found, otherwise false.
     */
    public static function contains(string $string, string $subString): bool
    {
        return strpos($string, $subString) !== false;
    }

    /**
     * Converts the first character of each word in a string to uppercase.
     * Words are determined by splitting the string using the specified delimiter.
     *
     * @param string $string The input string to be processed.
     * @param string $delimiter The delimiter used to split the string into words. Default is a space (' ').
     * @return string The processed string with the first character of each word converted to uppercase.
     */
    public static function ucwordsCustom(string $string, string $delimiter = ' '): string
    {
        return implode($delimiter, array_map('ucfirst', explode($delimiter, $string)));
    }

    /**
     * Replaces the first occurrence of a search string with a replacement string in the given subject.
     *
     * @param string $search  The substring to search for.
     * @param string $replace The string to replace the first occurrence of the search string with.
     * @param string $subject The string in which the replacement will be performed.
     * 
     * @return string The resulting string after the first occurrence of the search string is replaced.
     */
    public static function replaceFirst(string $search, string $replace, string $subject): string
    {
        $pos = strpos($subject, $search);
        if ($pos !== false) {
            return substr_replace($subject, $replace, $pos, strlen($search));
        }
        return $subject;
    }

    /**
     * Converts a given string to kebab-case.
     *
     * This method transforms the input string into a lowercase, hyphen-separated format,
     * commonly referred to as "kebab-case". It trims any leading or trailing whitespace
     * and replaces sequences of alphanumeric characters with hyphens.
     *
     * @param string $string The input string to be converted.
     * @return string The converted string in kebab-case format.
     */
    public static function toKebabCase(string $string): string
    {
        return strtolower(preg_replace('/[â-z0-9]+/', '-', trim($string)));
    }

    /**
     * Pads a string to a specified length with another string.
     *
     * This method uses the `str_pad` function to pad the input string to the desired length
     * using the specified padding string and padding type.
     *
     * @param string $string The input string to be padded.
     * @param int $length The desired length of the resulting string after padding.
     * @param string $padString The string to use for padding. Defaults to a single space (' ').
     * @param int $padType The padding type. Can be STR_PAD_RIGHT, STR_PAD_LEFT, or STR_PAD_BOTH.
     *                     Defaults to STR_PAD_RIGHT.
     * 
     * @return string The padded string.
     */
    public static function padString(string $string, int $length, string $padString = ' ', int $padType = STR_PAD_RIGHT): string
    {
        return str_pad($string, $length, $padString, $padType);
    }

    /**
     * Capitalizes the first letter of each word in a given string.
     *
     * This method uses the `ucwords` function to transform the input string
     * so that the first character of each word is converted to uppercase.
     *
     * @param string $string The input string to be transformed.
     * @return string The transformed string with each word capitalized.
     */
    public static function capitalizeWords(string $string): string
    {
        return ucwords($string);
    }

    /**
     * Checks if a given string is a palindrome.
     *
     * A palindrome is a word, phrase, number, or other sequence of characters
     * that reads the same forward and backward, ignoring case and non-alphanumeric characters.
     *
     * @param string $string The input string to check.
     * @return bool Returns true if the input string is a palindrome, false otherwise.
     */
    public static function isPalindrome(string $string): bool
    {
        $string = preg_replace('/[^A-Za-z0-9]/', '', $string);
        $string = strtolower($string);
        return $string === strrev($string);
    }

    /**
     * Determines if two strings are anagrams of each other.
     *
     * An anagram is a word or phrase formed by rearranging the letters of a 
     * different word or phrase, typically using all the original letters exactly once.
     * This method ignores non-alphanumeric characters and is case-insensitive.
     *
     * @param string $string1 The first string to compare.
     * @param string $string2 The second string to compare.
     * @return bool Returns true if the two strings are anagrams, false otherwise.
     */
    public static function isAnagram(string $string1, string $string2): bool
    {
        $string1 = preg_replace('/[^A-Za-z0-9]/', '', $string1);
        $string2 = preg_replace('/[^A-Za-z0-9]/', '', $string2);
        return count_chars($string1, 1) === count_chars($string2, 1);
    }

    /**
     * Checks if the given string is empty or consists only of whitespace characters.
     *
     * This method trims the input string and determines if it is empty after removing
     * any leading or trailing whitespace.
     *
     * @param string $string The string to check.
     * @return bool Returns true if the string is empty or contains only whitespace; otherwise, false.
     */
    public static function isEmpty(string $string): bool
    {
        return trim($string) === '';
    }

    /**
     * Extracts the initials from a given string.
     *
     * This method takes a string, splits it into words, and returns a string
     * containing the uppercase initials of each word.
     *
     * @param string $string The input string from which to extract initials.
     * @return string A string containing the uppercase initials of each word in the input string.
     */
    public static function extractInitials(string $string): string
    {
        $words = explode(' ', $string);
        $initials = '';
        foreach ($words as $word) {
            $initials .= strtoupper(substr($word, 0, 1));
        }
        return $initials;
    }

    /**
     * Removes extra spaces from the given string.
     *
     * This method trims the input string and replaces multiple consecutive
     * whitespace characters with a single space.
     *
     * @param string $string The input string to process.
     * @return string The processed string with extra spaces removed.
     */
    public static function removeExtraSpaces(string $string): string
    {
        return preg_replace('/\s+/', ' ', trim($string));
    }

    /**
     * Counts the number of words in a given string.
     *
     * This method uses the `str_word_count` function to determine the
     * number of words in the provided string. Words are defined as sequences
     * of alphabetic characters, and the behavior may vary depending on the
     * locale settings.
     *
     * @param string $string The input string to analyze.
     * @return int The number of words in the input string.
     */
    public static function countWords(string $string): int
    {
        return str_word_count($string);
    }

    /**
     * Masks a portion of a string with a specified character.
     *
     * This method replaces a segment of the input string, starting at a given position
     * and spanning a specified length, with a repeated mask character.
     *
     * @param string $string The input string to be masked.
     * @param int $start The starting position (0-based index) of the segment to be masked.
     * @param int $length The number of characters to mask.
     * @param string $mask The character to use for masking. Defaults to '*'.
     * @return string The resulting string with the specified segment masked.
     */
    public static function maskString(string $string, int $start, int $length, string $mask = '*'): string
    {
        return substr($string, 0, $start) . str_repeat($mask, $length) . substr($string, $start + $length);
    }

    /**
     * Sanitizes a string for safe output in HTML contexts.
     *
     * This method converts special characters to their corresponding HTML entities,
     * ensuring that the string is safe to display in an HTML document and preventing
     * potential cross-site scripting (XSS) attacks.
     *
     * @param string $string The input string to be sanitized.
     * @return string The sanitized string with special characters converted to HTML entities.
     */
    public static function sanitizeForHTML(string $string): string
    {
        return htmlspecialchars($string, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }

    /**
     * Encodes a given string to be used in a URL.
     *
     * This method uses PHP's built-in `urlencode` function to encode the string,
     * replacing special characters with their percent-encoded equivalents.
     *
     * @param string $string The string to be URL-encoded.
     * @return string The URL-encoded string.
     */
    public static function urlEncode(string $string): string
    {
        return urlencode($string);
    }

    /**
     * Decodes a URL-encoded string.
     *
     * This method takes a URL-encoded string and decodes it back to its original form.
     *
     * @param string $string The URL-encoded string to decode.
     * @return string The decoded string.
     */
    public static function urlDecode(string $string): string
    {
        return urldecode($string);
    }

    /**
     * Removes all special characters from the given string, leaving only
     * alphanumeric characters and whitespace.
     *
     * @param string $string The input string to process.
     * @return string The sanitized string with special characters removed.
     */
    public static function removeSpecialChars(string $string): string
    {
        return preg_replace('/[^a-zA-Z0-9\s]/', '', $string);
    }

    /**
     * Normalizes accents in a given string by converting accented characters
     * to their closest ASCII equivalents.
     *
     * This method uses the `iconv` function to transliterate characters from
     * UTF-8 encoding to ASCII, ignoring characters that cannot be transliterated.
     *
     * @param string $string The input string containing accented characters.
     * @return string The normalized string with accents removed.
     */
    public static function normalizeAccents(string $string): string
    {
        return iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $string);
    }

    /**
     * Calculates the similarity percentage between two strings.
     *
     * This method uses the `similar_text` function to determine the similarity
     * between the two input strings and returns the percentage of similarity.
     *
     * @param string $a The first string to compare.
     * @param string $b The second string to compare.
     * @return float The percentage of similarity between the two strings.
     */
    public static function similarity(string $a, string $b): float
    {
        similar_text($a, $b, $percent);
        return $percent;
    }

    /**
     * Repeats a given string a specified number of times.
     *
     * @param string $string The string to be repeated.
     * @param int $times The number of times to repeat the string.
     * @return string The resulting string after repetition.
     */
    public static function repeat(string $string, int $times): string
    {
        return str_repeat($string, $times);
    }

    /**
     * Converts a given string to PascalCase.
     *
     * This method transforms a string by replacing hyphens and underscores
     * with spaces, capitalizing the first letter of each word, and then
     * removing all spaces to produce a PascalCase formatted string.
     *
     * @param string $string The input string to be converted.
     * @return string The PascalCase formatted string.
     */
    public static function toPascalCase(string $string): string
    {
        return str_replace(' ', '', ucwords(str_replace(['-', '_'], ' ', $string)));
    }

    /**
     * Extracts the substring between two specified strings.
     *
     * This method searches for the first occurrence of the `$start` string
     * and the first occurrence of the `$end` string after `$start`. If both
     * are found, it returns the substring between them. If either `$start`
     * or `$end` is not found, it returns `null`.
     *
     * @param string $string The input string to search within.
     * @param string $start The starting delimiter string.
     * @param string $end The ending delimiter string.
     * @return string|null The substring between `$start` and `$end`, or `null` if not found.
     */
    public static function between(string $string, string $start, string $end): ?string
    {
        $startPos = strpos($string, $start);
        if ($startPos === false) return null;

        $startPos += strlen($start);
        $endPos = strpos($string, $end, $startPos);

        return $endPos === false ? null : substr($string, $startPos, $endPos - $startPos);
    }

    /**
     * Converts a given string to title case.
     *
     * Each word in the string will have its first character capitalized,
     * while the rest of the characters will be in lowercase.
     *
     * @param string $string The input string to be converted to title case.
     * @return string The string converted to title case.
     */
    public static function toTitleCase(string $string): string
    {
        return mb_convert_case($string, MB_CASE_TITLE, 'UTF-8');
    }

    /**
     * Splits a string into an array of smaller strings of a specified length.
     *
     * @param string $string The input string to be split.
     * @param int $length The length of each segment in the resulting array.
     *                     Must be greater than zero.
     * @return array An array of strings, each with a maximum length of $length.
     *               If the input string is empty, an empty array is returned.
     */
    public static function splitByLength(string $string, int $length): array
    {
        return str_split($string, $length);
    }

    /**
     * Splits a string into an array of tokens based on a specified delimiter.
     * Trims each token and filters out any empty values from the resulting array.
     *
     * @param string $string The input string to be tokenized.
     * @param string $delimiter The delimiter used to split the string. Defaults to a space (' ').
     * @return array An array of trimmed, non-empty tokens.
     */
    public function tokenize(string $string, string $delimiter = ' '): array
    {
        return array_filter(array_map('trim', explode($delimiter, $string)));
    }

    /**
     * Generates a hash of the given string using the specified algorithm.
     *
     * @param string $string The input string to be hashed.
     * @param string $algo   The hashing algorithm to use (default is 'sha256').
     *                       Supported algorithms are determined by the `hash()` function.
     * @return string The resulting hash of the input string.
     */
    public static function hash(string $string, string $algo = 'sha256'): string
    {
        return hash($algo, $string);
    }

    /**
     * Encodes a string into HTML entities.
     *
     * This method converts all applicable characters in the given string
     * into their corresponding HTML entities. It uses UTF-8 encoding and
     * ensures that both single and double quotes are converted.
     *
     * @param string $string The input string to be encoded.
     * @return string The encoded string with HTML entities.
     */
    public static function htmlEntityEncode(string $string): string
    {
        return htmlentities($string, ENT_QUOTES, 'UTF-8');
    }

    /**
     * Decodes all HTML entities in a given string.
     *
     * This method converts HTML entities back to their corresponding characters.
     * It uses UTF-8 encoding and decodes both double and single quotes.
     *
     * @param string $string The input string containing HTML entities to decode.
     * @return string The decoded string with HTML entities converted to their respective characters.
     */
    public static function htmlEntityDecode(string $string): string
    {
        return html_entity_decode($string, ENT_QUOTES, 'UTF-8');
    }

    /**
     * Determines if two strings are mirror images of each other.
     *
     * This method checks if the first string is equal to the reverse
     * of the second string.
     *
     * @param string $a The first string to compare.
     * @param string $b The second string to compare, which will be reversed.
     * @return bool Returns true if the first string is equal to the reversed second string, false otherwise.
     */
    public static function isMirror(string $a, string $b): bool
    {
        return $a === strrev($b);
    }

    /**
     * Calculates the frequency of each character in a given string.
     *
     * This method takes a string as input and returns an associative array
     * where the keys are the characters from the string, and the values
     * represent the number of times each character appears in the string.
     *
     * @param string $string The input string to analyze.
     * @return array An associative array with characters as keys and their
     *               respective frequencies as values.
     */
    public static function charFrequency(string $string): array
    {
        $result = [];
        foreach (str_split($string) as $char) {
            $result[$char] = ($result[$char] ?? 0) + 1;
        }
        return $result;
    }
}
