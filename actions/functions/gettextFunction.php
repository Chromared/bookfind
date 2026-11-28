<?php
$acceptedLanguage = strtolower($_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? '');
$locale = ($_SESSION['locale'] ?? null) === 'fr_FR' || str_starts_with($acceptedLanguage, 'fr')
    ? 'fr_FR'
    : 'en_US';
$GLOBALS['bookfindLocale'] = $locale;
$GLOBALS['bookfindTranslations'] = [];
$localeSet = false;

if (function_exists('bindtextdomain')) {
    bindtextdomain('bookfind', ROOT_PATH . '/locales');
    bind_textdomain_codeset('bookfind', 'UTF-8');
    textdomain('bookfind');

    if (defined('LC_MESSAGES')) {
        $localeSet = setlocale(LC_MESSAGES, $locale === 'fr_FR' ? ['fr_FR.UTF-8', 'fr_FR.utf8', 'French_France.1252'] : ['en_US.UTF-8', 'en_US.utf8', 'English_United States.1252']);
    } else {
        // Windows PHP builds commonly expose only LC_ALL rather than LC_MESSAGES.
        $localeSet = setlocale(LC_ALL, $locale === 'fr_FR' ? ['fr_FR.UTF-8', 'fr_FR.utf8', 'French_France.1252'] : ['en_US.UTF-8', 'en_US.utf8', 'English_United States.1252']);
    }
}

if ($locale === 'fr_FR' && (!function_exists('gettext') || $localeSet === false)) {
    $catalogPath = ROOT_PATH . '/locales/fr_FR/LC_MESSAGES/bookfind.mo';
    $catalog = is_file($catalogPath) ? @file_get_contents($catalogPath) : false;

    if ($catalog === false || strlen($catalog) < 28) {
        error_log('Unable to read the BookFind French gettext catalog.');
    } else {
        $littleEndian = unpack('V', substr($catalog, 0, 4))[1] === 0x950412de;
        $bigEndian = unpack('N', substr($catalog, 0, 4))[1] === 0x950412de;

        if (!$littleEndian && !$bigEndian) {
            error_log('The BookFind French gettext catalog has an invalid header.');
        } else {
            $wordFormat = $littleEndian ? 'V' : 'N';
            $readWord = static function ($offset) use ($catalog, $wordFormat) {
                $value = unpack($wordFormat, substr($catalog, $offset, 4));
                return $value[1] ?? null;
            };
            $entryCount = $readWord(8);
            $originalTable = $readWord(12);
            $translationTable = $readWord(16);
            $translations = [];

            if ($entryCount !== null && $originalTable !== null && $translationTable !== null) {
                for ($index = 0; $index < $entryCount; $index++) {
                    $originalOffset = $originalTable + $index * 8;
                    $translationOffset = $translationTable + $index * 8;
                    $originalEntry = unpack($wordFormat . 'length/' . $wordFormat . 'offset', substr($catalog, $originalOffset, 8));
                    $translationEntry = unpack($wordFormat . 'length/' . $wordFormat . 'offset', substr($catalog, $translationOffset, 8));

                    if (!$originalEntry || !$translationEntry) {
                        continue;
                    }

                    $message = explode("\0", substr($catalog, $originalEntry['offset'], $originalEntry['length']), 2)[0];
                    $translation = explode("\0", substr($catalog, $translationEntry['offset'], $translationEntry['length']), 2)[0];

                    if ($message !== '' && $translation !== '') {
                        $translations[$message] = $translation;
                    }
                }
            }

            $GLOBALS['bookfindTranslations'] = $translations;
        }
    }
}

function bookfind_translate($message)
{
    $translation = function_exists('gettext') ? gettext($message) : $message;
    if ($translation !== $message) {
        return $translation;
    }

    return $GLOBALS['bookfindTranslations'][$message] ?? $message;
}

if (!function_exists('_')) {
    function _($message)
    {
        return bookfind_translate($message);
    }
}
