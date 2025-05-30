<?php

declare(strict_types=1);

namespace RZ\Roadiz\Utils;

use Symfony\Component\String\Slugger\AsciiSlugger;
use Symfony\Component\String\UnicodeString;

class StringHandler
{
    /**
     * Remove diacritics characters and replace them with their basic alpha letter.
     *
     * @deprecated Use Symfony\Component\String\UnicodeString::ascii()
     */
    public static function removeDiacritics(?string $string): string
    {
        if (null === $string) {
            return '';
        }

        return (new UnicodeString($string))
            ->ascii()
            ->toString()
        ;
    }

    /**
     * Transform to lowercase and replace every non-alpha character with a dash.
     */
    public static function slugify(?string $string): string
    {
        if (null === $string) {
            return '';
        }
        $slugger = new AsciiSlugger();

        return $slugger->slug($string)->lower()->toString();
    }

    /**
     * Transform a string for use as a classname.
     *
     * @return string Classified string
     */
    public static function classify(?string $string): string
    {
        if (null === $string) {
            return '';
        }

        return (new UnicodeString($string))
            ->ascii()
            ->camel()
            ->title()
            ->toString()
        ;
    }

    /**
     * Transform to lowercase and replace every non-alpha character with an underscore.
     */
    public static function cleanForFilename(?string $string): string
    {
        if (null === $string) {
            return '';
        }

        return (new UnicodeString($string))
            ->ascii()
            ->trim()
            ->replaceMatches('#([^a-zA-Z0-9\.]+)#', '_')
            ->lower()
            ->toString()
        ;
    }

    /**
     * Transform to lowercase and replace every non-alpha character with an underscore.
     */
    public static function variablize(?string $string): string
    {
        if (null === $string) {
            return '';
        }

        return (new UnicodeString($string))
            ->ascii()
            ->replaceMatches('#([^a-zA-Z0-9]+)#', '_')
            ->snake()
            ->lower()
            ->trim('-')
            ->trim('_')
            ->trim()
            ->toString()
        ;
    }

    /**
     * Transform to lower camelCase.
     */
    public static function camelCase(?string $string): string
    {
        if (null === $string) {
            return '';
        }

        return mb_lcfirst((new UnicodeString($string))
            ->ascii()
            ->trim('-')
            ->trim('_')
            ->trim()
            ->camel()
            ->toString());
    }

    /**
     * Encode a string using website security secret.
     *
     * @param string|null $value  String to encode
     * @param string|null $secret Secret salt
     *
     * @throws \InvalidArgumentException
     */
    public static function encodeWithSecret(?string $value, ?string $secret): string
    {
        $secret = trim($secret ?? '');

        if (!empty($secret)) {
            $secret = crypt($secret, $secret);

            return base64_encode($secret.base64_encode(strip_tags($value ?? '')));
        } else {
            throw new \InvalidArgumentException('You cannot encode with an empty salt. Did you enter a secret security phrase in your conf/config.json file?', 1);
        }
    }

    /**
     * Decode a string using website security secret.
     *
     * @param string|null $value  Salted base64 string
     * @param string|null $secret Secret salt
     *
     * @throws \InvalidArgumentException
     */
    public static function decodeWithSecret(?string $value, ?string $secret): string
    {
        $secret = trim($secret ?? '');

        if (!empty($secret)) {
            $secret = crypt($secret, $secret);
            $salted = base64_decode($value ?? '');

            $nonSalted = str_replace($secret, '', $salted);

            return base64_decode($nonSalted);
        } else {
            throw new \InvalidArgumentException('You cannot encode with an empty salt. Did you enter a secret security phrase in your conf/config.json file?', 1);
        }
    }

    /**
     * @deprecated Use UnicodeString::endsWith($needle)
     */
    public static function endsWith(string $haystack, string $needle): bool
    {
        if ('' === $needle) {
            return true;
        }

        return (new UnicodeString($haystack))
            ->endsWith($needle)
        ;
    }

    public static function replaceLast(string $search, string $replace, string $subject): string
    {
        $pos = strrpos($subject, $search);

        if (false !== $pos) {
            $subject = \substr_replace($subject, $replace, $pos, \mb_strlen($search));
        }

        return $subject;
    }
}
