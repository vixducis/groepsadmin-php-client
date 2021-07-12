<?php declare(strict_types=1);

namespace Wouterh\GroepsadminClient\Model;

trait LoadFromApiTrait
{
    /**
     * Generates a new object from an API response.
     * @param mixed $object The object you want to load into.
     * @param array $translations An array that mimics the layout of the API response where the values are the names of the setter functions. Indexes should not contain any prefixes (like vvksm.) or the 'Column' postfix. Matching is done case-insensitive.
     * @param array $apiResponse The response from the API you want to load into an object.
     */
    protected static function loadFromApi(
        mixed $object,
        array $translations,
        array $apiResponse
    ): mixed {
        // make all keys in the translation array lowercase
        array_change_key_case($translations, CASE_LOWER);
        foreach ($apiResponse as $key => $value) {
            // determine the position of the last dot in the key and only use everything after it
            $dotPosition = strrpos($key, '.');
            $key = $dotPosition === false ? $key : substr($key, $dotPosition + 1);

            // remove 'Column' from the end of the string and make it lowercase
            $key = strtolower(preg_replace('/Column$/', '', $key));

            if (array_key_exists($key, $translations)) {
                if (is_array($value)) {
                    $object = self::loadFromApi($object, $translations[$key], $value);
                } else {
                    $method = $translations[$key];
                    if (method_exists($object, $method)) {
                        $object->$method($value);
                    }
                }
            }
        }

        return $object;
    }
}
