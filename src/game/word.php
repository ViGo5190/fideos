<?php
/**
 * @author Stan Gumeniuk i@vigo.su
 */

function game_word_getAlphabet()
{
    return [
        'а',
        'б',
        'в',
        'г',
        'д',
        'е',
        'ж',
        'з',
        'и',
        'й',
        'к',
        'л',
        'м',
        'н',
        'о',
        'п',
        'р',
        'с',
        'т',
        'у',
        'ф',
        'х',
        'ц',
        'ч',
        'ш',
        'щ',
        'ъ',
        'ы',
        'э',
        'ю',
        'я',
    ];
}

function game_word_wordAdd($word)
{
    $word = trim($word);

    $mckey = 'tree|';

    $l = mb_strlen($word);

    $time = 0;

    for ($key = 0; $key < $l; $key++) {

        $letter = mb_substr($word, (int) $key, 1, 'UTF8');

        if ($key == 0) {
            $cmckeyparent = $mckey . 'root';
        } else {
            $cmckeyparent = $mckey . mb_substr($word, 0, (int) $key, 'UTF8');
        }

        $cmkeycurrent = $mckey . mb_substr($word, 0, (int) $key + 1, 'UTF8');

        $nodeCurrent = framework_memcache_get($cmkeycurrent);

        if (!$nodeCurrent) {
            $nodeCurrent = [
                'wrd'     => false,
                'letters' => [],
                'link'    => [],
            ];
        }

        if ($l == $key + 1) {
            $nodeCurrent['wrd'] = $word;
        }

        framework_memcache_set($cmkeycurrent, $nodeCurrent, $time);

//        echo $cmckeyparent. PHP_EOL;

        $nodeParent = framework_memcache_get($cmckeyparent);
        if (!$nodeParent) {
            $nodeParent = [
                'wrd'     => false,
                'letters' => [],
                'link'    => [],
            ];
        }

        if (!in_array($letter, $nodeParent['letters'])) {
            $nodeParent['letters'][] = $letter;
            $nodeParent['link'][] = $cmkeycurrent;
        }

        framework_memcache_set($cmckeyparent, $nodeParent, $time);

//        var_dump($nodeParent);
        unset($nodeParent);
        unset($nodeCurrent);
    }
}

function game_word_wordAddRevertPostFix($word)
{
    $mckey = 'treeRevertPostFixNew6|';
    $mckeyPrefixRoot = 'root';
    $word = trim($word);
    $l = mb_strlen($word);
    $termSymbol = '$';

    $firstLetter = mb_substr($word, 0, 1, 'UTF8');

    $time = 0;

    for ($key = 0; $key < $l; $key++) {

        $letter = mb_substr($word, (int) $key, 1, 'UTF8');

        $prefix = mb_substr($word, 0, (int) $key + 1, 'UTF8');

        $prefixReverted = framework_helper_mbStrRev($prefix);

        $prefixRevertedLength = mb_strlen($prefixReverted);
//        echo $prefixRevertedLength;
        for ($k = 0; $k < $prefixRevertedLength; $k++) {
            $letter2 = mb_substr($prefixReverted, (int) $k, 1, 'UTF8');
//            echo ">" . $letter2;

            $cmkeycurrent = $mckey . mb_substr($prefixReverted, 0, (int) $k + 1, 'UTF8');
//            echo "&" . $cmkeycurrent . '&';

            //////
            $nodeCurrent = framework_memcache_get($cmkeycurrent);

            if (!$nodeCurrent) {
                $nodeCurrent = [
                    'letters' => [],
                    'link'    => [],
                ];
            }
            if ($prefixRevertedLength == $k + 1) {
                //
                $cmkeycurrentEnd = $cmkeycurrent . "$";
                $nodeCurrentEnd = framework_memcache_get($cmkeycurrentEnd);

                if (!$nodeCurrentEnd) {
                    $nodeCurrentEnd = [
                        'letters' => [],
                        'link'    => [],
                    ];
                }
                framework_memcache_set($cmkeycurrentEnd, $nodeCurrentEnd, $time);
                //
                if (!in_array('$', $nodeCurrent['letters'])) {
                    $nodeCurrent['letters'][] = '$';
                    $nodeCurrent['link'][] = $cmkeycurrentEnd;
                }
            }

            framework_memcache_set($cmkeycurrent, $nodeCurrent, $time);
            ///////

            if ($k == 0) {
                $cmckeyparent = $mckey . 'root';
            } else {
                $cmckeyparent = $mckey . mb_substr($prefixReverted, 0, (int) $k, 'UTF8');
            }

            //////
            $nodeParent = framework_memcache_get($cmckeyparent);

            if (!$nodeParent) {
                $nodeParent = [
                    'letters' => [],
                    'link'    => [],
                ];
            }

            if (!in_array($letter2, $nodeParent['letters'])) {
                $nodeParent['letters'][] = $letter2;
                $nodeParent['link'][] = $cmkeycurrent;
            }

            framework_memcache_set($cmckeyparent, $nodeParent, $time);
            ///////

            unset($nodeParent);
            unset($nodeCurrent);

            if (isset($nodeCurrentEnd)) {
                unset($nodeCurrentEnd);
            }
        }
    }
}

function game_word_checkWordUser($word)
{
    $word = game_word_convertWord($word);

    $mckey = 'tree|';

    $k = $mckey . $word;

    $n = framework_memcache_get($k);

    if (!$n) {
        return false;
    }

    if ($n['wrd'] === false) {
        return false;
    }

    return true;
}

function  game_word_convertWord($word)
{
    $word = trim($word);
    $word = mb_strtolower($word);
    $word = str_replace("ё", "е",$word);
    return $word;
}