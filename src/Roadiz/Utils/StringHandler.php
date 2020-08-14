<?php
declare(strict_types=1);

namespace RZ\Roadiz\Utils;

/**
 * String handling methods.
 */
class StringHandler
{
    /**
     * Remove diacritics characters and replace them with their basic alpha letter.
     *
     * @param string|null $string
     * @return string
     */
    public static function removeDiacritics(?string $string)
    {
        if (null === $string) {
            return '';
        }
        $string = htmlentities($string, ENT_NOQUOTES, 'utf-8');
        $string = preg_replace('#([\'])#', ' ', $string);
        $string = preg_replace('#&([A-Za-z])(?:uml|circ|tilde|acute|grave|cedil|ring);#', '\1', (string) $string);
        $string = preg_replace('#&([A-Za-z]{2})(?:lig);#', '\1', (string) $string);
        $string = preg_replace('#&[^;]+;#', ' ', (string) $string);

        return (string) $string;
    }

    /**
     * Transform to lowercase and replace every non-alpha character with a dash.
     *
     * @param string|null $string
     * @return string Slugified string
     */
    public static function slugify(?string $string)
    {
        if (null === $string) {
            return '';
        }
        $string = static::removeDiacritics($string);
        $string = trim(mb_strtolower($string));
        $string = preg_replace('#([^a-zA-Z0-9\p{Han}\p{Hiragana}\p{Katakana}\p{Arabic}\p{Cyrillic}\{Hebrew}]+)#u', '-', $string);
        $string = str_replace(['{','}'], '-', (string) $string);
        $string = trim($string, "-");

        return $string;
    }
    /**
     * Transform a string for use as a classname.
     *
     * @param string|null $string
     *
     * @return string Classified string
     */
    public static function classify(?string $string)
    {
        if (null === $string) {
            return '';
        }
        $string = static::removeDiacritics($string);
        $string = trim((string) preg_replace('#([^a-zA-Z])#', '', ucwords($string)));

        return $string;
    }
    /**
     * Transform to lowercase and replace every non-alpha character with an underscore.
     *
     * @param string|null $string
     *
     * @return string
     */
    public static function cleanForFilename(?string $string)
    {
        if (null === $string) {
            return '';
        }
        $string = static::removeDiacritics(trim($string));
        $string = preg_replace('#([^a-zA-Z0-9\.]+)#', '_', $string);
        $string = trim((string) $string, "_");
        $string = mb_strtolower($string);

        return $string;
    }

    /**
     * Transform to lowercase and replace every non-alpha character with an underscore.
     *
     * @param string|null $string
     *
     * @return string
     */
    public static function variablize(?string $string)
    {
        if (null === $string) {
            return '';
        }
        $string = static::removeDiacritics($string);
        $string = preg_replace('#([^a-zA-Z0-9]+)#', '_', $string);
        $string = mb_strtolower((string) $string);
        $string = trim($string);

        return $string;
    }

    /**
     * Transform to camelcase.
     *
     * @param string|null $string
     *
     * @return string
     */
    public static function camelCase(?string $string)
    {
        if (null === $string) {
            return '';
        }
        $string = static::removeDiacritics($string);
        $string = preg_replace('#([-_=\.,;:]+)#', ' ', $string);
        $string = preg_replace('#([^a-zA-Z0-9]+)#', '', ucwords((string) $string));
        $string = trim((string) $string);
        $string[0] = mb_strtolower($string[0]);

        return $string;
    }


    /**
     * Encode a string using website security secret.
     *
     * @param string|null $value String to encode
     * @param string|null $secret Secret salt
     *
     * @return string
     * @throws \InvalidArgumentException
     */
    public static function encodeWithSecret(?string $value, ?string $secret)
    {
        $secret = trim($secret ?? '');

        if (!empty($secret)) {
            $secret = crypt($secret, $secret);
            return base64_encode($secret . base64_encode(strip_tags($value ?? '')));
        } else {
            throw new \InvalidArgumentException("You cannot encode with an empty salt. Did you enter a secret security phrase in your conf/config.json file?", 1);
        }
    }

    /**
     * Decode a string using website security secret.
     *
     * @param string|null $value Salted base64 string
     * @param string|null $secret Secret salt
     *
     * @return string
     * @throws \InvalidArgumentException
     */
    public static function decodeWithSecret(?string $value, ?string $secret)
    {
        $secret = trim($secret ?? '');

        if (!empty($secret)) {
            $secret = crypt($secret, $secret);
            $salted = base64_decode($value ?? '');

            $nonSalted = str_replace($secret, "", $salted);

            return base64_decode($nonSalted);
        } else {
            throw new \InvalidArgumentException("You cannot encode with an empty salt. Did you enter a secret security phrase in your conf/config.json file?", 1);
        }
    }

    /**
     * @param string $haystack
     * @param string $needle
     * @return bool
     */
    public static function endsWith(string $haystack, string $needle)
    {
        if (strlen($needle) > strlen($haystack)) {
            return false;
        }
        // search forward starting from end minus needle length characters
        return $needle === "" || strpos($haystack, $needle, strlen($haystack) - strlen($needle)) !== false;
    }

    /**
     * @param string $search
     * @param string $replace
     * @param string $subject
     * @return string
     */
    public static function replaceLast(string $search, string $replace, string $subject)
    {
        $pos = strrpos($subject, $search);

        if ($pos !== false) {
            $subject = substr_replace($subject, $replace, $pos, strlen($search));
        }

        return $subject;
    }
}
