<?php
/**
 * Main Ocim Formatting API.
 */
function reset_mbstring_encoding() {
    mbstring_binary_safe_encoding( true );
}
function mbstring_binary_safe_encoding( $reset = false ) {
    static $encodings = array();
    static $overloaded = null;
 
    if ( is_null( $overloaded ) )
        $overloaded = function_exists( 'mb_internal_encoding' ) && ( ini_get( 'mbstring.func_overload' ) & 2 );
 
    if ( false === $overloaded )
        return;
 
    if ( ! $reset ) {
        $encoding = mb_internal_encoding();
        array_push( $encodings, $encoding );
        mb_internal_encoding( 'ISO-8859-1' );
    }
 
    if ( $reset && $encodings ) {
        $encoding = array_pop( $encodings );
        mb_internal_encoding( $encoding );
    }
}
function seems_utf8( $str ) {
        mbstring_binary_safe_encoding();
        $length = strlen($str);
        reset_mbstring_encoding();
        for ($i=0; $i < $length; $i++) {
                $c = ord($str[$i]);
                if ($c < 0x80) $n = 0; // 0bbbbbbb
                elseif (($c & 0xE0) == 0xC0) $n=1; // 110bbbbb
                elseif (($c & 0xF0) == 0xE0) $n=2; // 1110bbbb
                elseif (($c & 0xF8) == 0xF0) $n=3; // 11110bbb
                elseif (($c & 0xFC) == 0xF8) $n=4; // 111110bb
                elseif (($c & 0xFE) == 0xFC) $n=5; // 1111110b
                else return false; // Does not match any model
                for ($j=0; $j<$n; $j++) { // n bytes matching 10bbbbbb follow ?
                        if ((++$i == $length) || ((ord($str[$i]) & 0xC0) != 0x80))
                                return false;
                }
        }
        return true;
}
function sanitize_title( $title, $fallback_title = '', $context = 'save' ) {
        $raw_title = $title;
        if ( 'save' == $context )
                $title = remove_accents($title);
        /**
         * Filter a sanitized title string.
         *
         * @since 1.0.0
         *
         * @param string $title     Sanitized title.
         * @param string $raw_title The title prior to sanitization.
         * @param string $context   The context for which the title is being sanitized.
         */
        if ( '' === $title || false === $title )
                $title = $fallback_title;
        return $title;
}
function sanitize_title_with_dashes( $title, $raw_title = '-', $context = 'display' ) {
        $title = strip_tags($title);
        // Preserve escaped octets.
        $title = preg_replace('|%([a-fA-F0-9][a-fA-F0-9])|', '---$1---', $title);
        // Remove percent signs that are not part of an octet.
        $title = str_replace('%', '', $title);
        // Restore octets.
        $title = preg_replace('|---([a-fA-F0-9][a-fA-F0-9])---|', '%$1', $title);
        if (seems_utf8($title)) {
                if (function_exists('mb_strtolower')) {
                        $title = mb_strtolower($title, 'UTF-8');
                }
                $title = utf8_uri_encode($title, 200);
        }
        $title = strtolower($title);
        $title = preg_replace('/&.+?;/', '', $title); // kill entities
        $title = str_replace('.', '-', $title);
        if ( 'save' == $context ) {
                // Convert nbsp, ndash and mdash to hyphens
                $title = str_replace( array( '%c2%a0', '%e2%80%93', '%e2%80%94' ), '-', $title );
                // Strip these characters entirely
                $title = str_replace( array(
                        // iexcl and iquest
                        '%c2%a1', '%c2%bf',
                        // angle quotes
                        '%c2%ab', '%c2%bb', '%e2%80%b9', '%e2%80%ba',
                        // curly quotes
                        '%e2%80%98', '%e2%80%99', '%e2%80%9c', '%e2%80%9d',
                        '%e2%80%9a', '%e2%80%9b', '%e2%80%9e', '%e2%80%9f',
                        // copy, reg, deg, hellip and trade
                        '%c2%a9', '%c2%ae', '%c2%b0', '%e2%80%a6', '%e2%84%a2',
                        // acute accents
                        '%c2%b4', '%cb%8a', '%cc%81', '%cd%81',
                        // grave accent, macron, caron
                        '%cc%80', '%cc%84', '%cc%8c',
                ), '', $title );
                // Convert times to x
                $title = str_replace( '%c3%97', 'x', $title );
        }
        $title = preg_replace('/[^%a-z0-9 _-]/', '', $title);
        $title = preg_replace('/\s+/', $raw_title, $title);
        $title = preg_replace('|-+|', $raw_title, $title);
        $title = trim($title, $raw_title);
        return $title;
}
/**
 * Escaping for textarea values.
 *
 * @since 1.0.0
 *
 * @param string $text
 * @return string
 */
function esc_textarea( $text ) {
        $safe_text = htmlspecialchars( $text, ENT_QUOTES, 'utf-8' );
        /**
         * Filter a string cleaned and escaped for output in a textarea element.
         *
         * @since 3.1.0
         *
         * @param string $safe_text The text after it has been escaped.
         * @param string $text      The text prior to being escaped.
         */
        return $safe_text;
}
function utf8_uri_encode( $utf8_string, $length = 0 ) {
        $unicode = '';
        $values = array();
        $num_octets = 1;
        $unicode_length = 0;
        mbstring_binary_safe_encoding();
        $string_length = strlen( $utf8_string );
        reset_mbstring_encoding();
        for ($i = 0; $i < $string_length; $i++ ) {
                $value = ord( $utf8_string[ $i ] );
                if ( $value < 128 ) {
                        if ( $length && ( $unicode_length >= $length ) )
                                break;
                        $unicode .= chr($value);
                        $unicode_length++;
                } else {
                        if ( count( $values ) == 0 ) {
                                if ( $value < 224 ) {
                                        $num_octets = 2;
                                } elseif ( $value < 240 ) {
                                        $num_octets = 3;
                                } else {
                                        $num_octets = 4;
                                }
                        }
                        $values[] = $value;
                        if ( $length && ( $unicode_length + ($num_octets * 3) ) > $length )
                                break;
                        if ( count( $values ) == $num_octets ) {
                                for ( $j = 0; $j < $num_octets; $j++ ) {
                                        $unicode .= '%' . dechex( $values[ $j ] );
                                }
                                $unicode_length += $num_octets * 3;
                                $values = array();
                                $num_octets = 1;
                        }
                }
        }
        return $unicode;
}
/**
 * Converts all accent characters to ASCII characters.
 *
 * If there are no accent characters, then the string given is just returned.
 *
 * @since 1.0.0
 *
 * @param string $string Text that might have accent characters
 * @return string Filtered string with replaced "nice" characters.
 */
function remove_accents( $string ) {
        if ( !preg_match('/[\x80-\xff]/', $string) )
                return $string;
        if (seems_utf8($string)) {
                $chars = array(
                // Decompositions for Latin-1 Supplement
                chr(194).chr(170) => 'a', chr(194).chr(186) => 'o',
                chr(195).chr(128) => 'A', chr(195).chr(129) => 'A',
                chr(195).chr(130) => 'A', chr(195).chr(131) => 'A',
                chr(195).chr(132) => 'A', chr(195).chr(133) => 'A',
                chr(195).chr(134) => 'AE',chr(195).chr(135) => 'C',
                chr(195).chr(136) => 'E', chr(195).chr(137) => 'E',
                chr(195).chr(138) => 'E', chr(195).chr(139) => 'E',
                chr(195).chr(140) => 'I', chr(195).chr(141) => 'I',
                chr(195).chr(142) => 'I', chr(195).chr(143) => 'I',
                chr(195).chr(144) => 'D', chr(195).chr(145) => 'N',
                chr(195).chr(146) => 'O', chr(195).chr(147) => 'O',
                chr(195).chr(148) => 'O', chr(195).chr(149) => 'O',
                chr(195).chr(150) => 'O', chr(195).chr(153) => 'U',
                chr(195).chr(154) => 'U', chr(195).chr(155) => 'U',
                chr(195).chr(156) => 'U', chr(195).chr(157) => 'Y',
                chr(195).chr(158) => 'TH',chr(195).chr(159) => 's',
                chr(195).chr(160) => 'a', chr(195).chr(161) => 'a',
                chr(195).chr(162) => 'a', chr(195).chr(163) => 'a',
                chr(195).chr(164) => 'a', chr(195).chr(165) => 'a',
                chr(195).chr(166) => 'ae',chr(195).chr(167) => 'c',
                chr(195).chr(168) => 'e', chr(195).chr(169) => 'e',
                chr(195).chr(170) => 'e', chr(195).chr(171) => 'e',
                chr(195).chr(172) => 'i', chr(195).chr(173) => 'i',
                chr(195).chr(174) => 'i', chr(195).chr(175) => 'i',
                chr(195).chr(176) => 'd', chr(195).chr(177) => 'n',
                chr(195).chr(178) => 'o', chr(195).chr(179) => 'o',
                chr(195).chr(180) => 'o', chr(195).chr(181) => 'o',
                chr(195).chr(182) => 'o', chr(195).chr(184) => 'o',
                chr(195).chr(185) => 'u', chr(195).chr(186) => 'u',
                chr(195).chr(187) => 'u', chr(195).chr(188) => 'u',
                chr(195).chr(189) => 'y', chr(195).chr(190) => 'th',
                chr(195).chr(191) => 'y', chr(195).chr(152) => 'O',
                // Decompositions for Latin Extended-A
                chr(196).chr(128) => 'A', chr(196).chr(129) => 'a',
                chr(196).chr(130) => 'A', chr(196).chr(131) => 'a',
                chr(196).chr(132) => 'A', chr(196).chr(133) => 'a',
                chr(196).chr(134) => 'C', chr(196).chr(135) => 'c',
                chr(196).chr(136) => 'C', chr(196).chr(137) => 'c',
                chr(196).chr(138) => 'C', chr(196).chr(139) => 'c',
                chr(196).chr(140) => 'C', chr(196).chr(141) => 'c',
                chr(196).chr(142) => 'D', chr(196).chr(143) => 'd',
                chr(196).chr(144) => 'D', chr(196).chr(145) => 'd',
                chr(196).chr(146) => 'E', chr(196).chr(147) => 'e',
                chr(196).chr(148) => 'E', chr(196).chr(149) => 'e',
                chr(196).chr(150) => 'E', chr(196).chr(151) => 'e',
                chr(196).chr(152) => 'E', chr(196).chr(153) => 'e',
                chr(196).chr(154) => 'E', chr(196).chr(155) => 'e',
                chr(196).chr(156) => 'G', chr(196).chr(157) => 'g',
                chr(196).chr(158) => 'G', chr(196).chr(159) => 'g',
                chr(196).chr(160) => 'G', chr(196).chr(161) => 'g',
                chr(196).chr(162) => 'G', chr(196).chr(163) => 'g',
                chr(196).chr(164) => 'H', chr(196).chr(165) => 'h',
                chr(196).chr(166) => 'H', chr(196).chr(167) => 'h',
                chr(196).chr(168) => 'I', chr(196).chr(169) => 'i',
                chr(196).chr(170) => 'I', chr(196).chr(171) => 'i',
                chr(196).chr(172) => 'I', chr(196).chr(173) => 'i',
                chr(196).chr(174) => 'I', chr(196).chr(175) => 'i',
                chr(196).chr(176) => 'I', chr(196).chr(177) => 'i',
                chr(196).chr(178) => 'IJ',chr(196).chr(179) => 'ij',
                chr(196).chr(180) => 'J', chr(196).chr(181) => 'j',
                chr(196).chr(182) => 'K', chr(196).chr(183) => 'k',
                chr(196).chr(184) => 'k', chr(196).chr(185) => 'L',
                chr(196).chr(186) => 'l', chr(196).chr(187) => 'L',
                chr(196).chr(188) => 'l', chr(196).chr(189) => 'L',
                chr(196).chr(190) => 'l', chr(196).chr(191) => 'L',
                chr(197).chr(128) => 'l', chr(197).chr(129) => 'L',
                chr(197).chr(130) => 'l', chr(197).chr(131) => 'N',
                chr(197).chr(132) => 'n', chr(197).chr(133) => 'N',
                chr(197).chr(134) => 'n', chr(197).chr(135) => 'N',
                chr(197).chr(136) => 'n', chr(197).chr(137) => 'N',
                chr(197).chr(138) => 'n', chr(197).chr(139) => 'N',
                chr(197).chr(140) => 'O', chr(197).chr(141) => 'o',
                chr(197).chr(142) => 'O', chr(197).chr(143) => 'o',
                chr(197).chr(144) => 'O', chr(197).chr(145) => 'o',
                chr(197).chr(146) => 'OE',chr(197).chr(147) => 'oe',
                chr(197).chr(148) => 'R',chr(197).chr(149) => 'r',
                chr(197).chr(150) => 'R',chr(197).chr(151) => 'r',
                chr(197).chr(152) => 'R',chr(197).chr(153) => 'r',
                chr(197).chr(154) => 'S',chr(197).chr(155) => 's',
                chr(197).chr(156) => 'S',chr(197).chr(157) => 's',
                chr(197).chr(158) => 'S',chr(197).chr(159) => 's',
                chr(197).chr(160) => 'S', chr(197).chr(161) => 's',
                chr(197).chr(162) => 'T', chr(197).chr(163) => 't',
                chr(197).chr(164) => 'T', chr(197).chr(165) => 't',
                chr(197).chr(166) => 'T', chr(197).chr(167) => 't',
                chr(197).chr(168) => 'U', chr(197).chr(169) => 'u',
                chr(197).chr(170) => 'U', chr(197).chr(171) => 'u',
                chr(197).chr(172) => 'U', chr(197).chr(173) => 'u',
                chr(197).chr(174) => 'U', chr(197).chr(175) => 'u',
                chr(197).chr(176) => 'U', chr(197).chr(177) => 'u',
                chr(197).chr(178) => 'U', chr(197).chr(179) => 'u',
                chr(197).chr(180) => 'W', chr(197).chr(181) => 'w',
                chr(197).chr(182) => 'Y', chr(197).chr(183) => 'y',
                chr(197).chr(184) => 'Y', chr(197).chr(185) => 'Z',
                chr(197).chr(186) => 'z', chr(197).chr(187) => 'Z',
                chr(197).chr(188) => 'z', chr(197).chr(189) => 'Z',
                chr(197).chr(190) => 'z', chr(197).chr(191) => 's',
                // Decompositions for Latin Extended-B
                chr(200).chr(152) => 'S', chr(200).chr(153) => 's',
                chr(200).chr(154) => 'T', chr(200).chr(155) => 't',
                // Euro Sign
                chr(226).chr(130).chr(172) => 'E',
                // GBP (Pound) Sign
                chr(194).chr(163) => '',
                // Vowels with diacritic (Vietnamese)
                // unmarked
                chr(198).chr(160) => 'O', chr(198).chr(161) => 'o',
                chr(198).chr(175) => 'U', chr(198).chr(176) => 'u',
                // grave accent
                chr(225).chr(186).chr(166) => 'A', chr(225).chr(186).chr(167) => 'a',
                chr(225).chr(186).chr(176) => 'A', chr(225).chr(186).chr(177) => 'a',
                chr(225).chr(187).chr(128) => 'E', chr(225).chr(187).chr(129) => 'e',
                chr(225).chr(187).chr(146) => 'O', chr(225).chr(187).chr(147) => 'o',
                chr(225).chr(187).chr(156) => 'O', chr(225).chr(187).chr(157) => 'o',
                chr(225).chr(187).chr(170) => 'U', chr(225).chr(187).chr(171) => 'u',
                chr(225).chr(187).chr(178) => 'Y', chr(225).chr(187).chr(179) => 'y',
                // hook
                chr(225).chr(186).chr(162) => 'A', chr(225).chr(186).chr(163) => 'a',
                chr(225).chr(186).chr(168) => 'A', chr(225).chr(186).chr(169) => 'a',
                chr(225).chr(186).chr(178) => 'A', chr(225).chr(186).chr(179) => 'a',
                chr(225).chr(186).chr(186) => 'E', chr(225).chr(186).chr(187) => 'e',
                chr(225).chr(187).chr(130) => 'E', chr(225).chr(187).chr(131) => 'e',
                chr(225).chr(187).chr(136) => 'I', chr(225).chr(187).chr(137) => 'i',
                chr(225).chr(187).chr(142) => 'O', chr(225).chr(187).chr(143) => 'o',
                chr(225).chr(187).chr(148) => 'O', chr(225).chr(187).chr(149) => 'o',
                chr(225).chr(187).chr(158) => 'O', chr(225).chr(187).chr(159) => 'o',
                chr(225).chr(187).chr(166) => 'U', chr(225).chr(187).chr(167) => 'u',
                chr(225).chr(187).chr(172) => 'U', chr(225).chr(187).chr(173) => 'u',
                chr(225).chr(187).chr(182) => 'Y', chr(225).chr(187).chr(183) => 'y',
                // tilde
                chr(225).chr(186).chr(170) => 'A', chr(225).chr(186).chr(171) => 'a',
                chr(225).chr(186).chr(180) => 'A', chr(225).chr(186).chr(181) => 'a',
                chr(225).chr(186).chr(188) => 'E', chr(225).chr(186).chr(189) => 'e',
                chr(225).chr(187).chr(132) => 'E', chr(225).chr(187).chr(133) => 'e',
                chr(225).chr(187).chr(150) => 'O', chr(225).chr(187).chr(151) => 'o',
                chr(225).chr(187).chr(160) => 'O', chr(225).chr(187).chr(161) => 'o',
                chr(225).chr(187).chr(174) => 'U', chr(225).chr(187).chr(175) => 'u',
                chr(225).chr(187).chr(184) => 'Y', chr(225).chr(187).chr(185) => 'y',
                // acute accent
                chr(225).chr(186).chr(164) => 'A', chr(225).chr(186).chr(165) => 'a',
                chr(225).chr(186).chr(174) => 'A', chr(225).chr(186).chr(175) => 'a',
                chr(225).chr(186).chr(190) => 'E', chr(225).chr(186).chr(191) => 'e',
                chr(225).chr(187).chr(144) => 'O', chr(225).chr(187).chr(145) => 'o',
                chr(225).chr(187).chr(154) => 'O', chr(225).chr(187).chr(155) => 'o',
                chr(225).chr(187).chr(168) => 'U', chr(225).chr(187).chr(169) => 'u',
                // dot below
                chr(225).chr(186).chr(160) => 'A', chr(225).chr(186).chr(161) => 'a',
                chr(225).chr(186).chr(172) => 'A', chr(225).chr(186).chr(173) => 'a',
                chr(225).chr(186).chr(182) => 'A', chr(225).chr(186).chr(183) => 'a',
                chr(225).chr(186).chr(184) => 'E', chr(225).chr(186).chr(185) => 'e',
                chr(225).chr(187).chr(134) => 'E', chr(225).chr(187).chr(135) => 'e',
                chr(225).chr(187).chr(138) => 'I', chr(225).chr(187).chr(139) => 'i',
                chr(225).chr(187).chr(140) => 'O', chr(225).chr(187).chr(141) => 'o',
                chr(225).chr(187).chr(152) => 'O', chr(225).chr(187).chr(153) => 'o',
                chr(225).chr(187).chr(162) => 'O', chr(225).chr(187).chr(163) => 'o',
                chr(225).chr(187).chr(164) => 'U', chr(225).chr(187).chr(165) => 'u',
                chr(225).chr(187).chr(176) => 'U', chr(225).chr(187).chr(177) => 'u',
                chr(225).chr(187).chr(180) => 'Y', chr(225).chr(187).chr(181) => 'y',
                // Vowels with diacritic (Chinese, Hanyu Pinyin)
                chr(201).chr(145) => 'a',
                // macron
                chr(199).chr(149) => 'U', chr(199).chr(150) => 'u',
                // acute accent
                chr(199).chr(151) => 'U', chr(199).chr(152) => 'u',
                // caron
                chr(199).chr(141) => 'A', chr(199).chr(142) => 'a',
                chr(199).chr(143) => 'I', chr(199).chr(144) => 'i',
                chr(199).chr(145) => 'O', chr(199).chr(146) => 'o',
                chr(199).chr(147) => 'U', chr(199).chr(148) => 'u',
                chr(199).chr(153) => 'U', chr(199).chr(154) => 'u',
                // grave accent
                chr(199).chr(155) => 'U', chr(199).chr(156) => 'u',
                );

                $string = strtr($string, $chars);
        } else {
                $chars = array();
                // Assume ISO-8859-1 if not UTF-8
                $chars['in'] = chr(128).chr(131).chr(138).chr(142).chr(154).chr(158)
                        .chr(159).chr(162).chr(165).chr(181).chr(192).chr(193).chr(194)
                        .chr(195).chr(196).chr(197).chr(199).chr(200).chr(201).chr(202)
                        .chr(203).chr(204).chr(205).chr(206).chr(207).chr(209).chr(210)
                        .chr(211).chr(212).chr(213).chr(214).chr(216).chr(217).chr(218)
                        .chr(219).chr(220).chr(221).chr(224).chr(225).chr(226).chr(227)
                        .chr(228).chr(229).chr(231).chr(232).chr(233).chr(234).chr(235)
                        .chr(236).chr(237).chr(238).chr(239).chr(241).chr(242).chr(243)
                        .chr(244).chr(245).chr(246).chr(248).chr(249).chr(250).chr(251)
                        .chr(252).chr(253).chr(255);
                $chars['out'] = "EfSZszYcYuAAAAAACEEEEIIIINOOOOOOUUUUYaaaaaaceeeeiiiinoooooouuuuyy";
                $string = strtr($string, $chars['in'], $chars['out']);
                $double_chars = array();
                $double_chars['in'] = array(chr(140), chr(156), chr(198), chr(208), chr(222), chr(223), chr(230), chr(240), chr(254));
                $double_chars['out'] = array('OE', 'oe', 'AE', 'DH', 'TH', 'ss', 'ae', 'dh', 'th');
                $string = str_replace($double_chars['in'], $double_chars['out'], $string);
        }
        return $string;
}
function oc_check_invalid_utf8( $string, $strip = false ) {
        $string = (string) $string;
        if ( 0 === strlen( $string ) ) {
                return '';
        }
        // Store the site charset as a static to avoid multiple calls to get_option()
        static $is_utf8;
        if ( !isset( $is_utf8 ) ) {
                $is_utf8 = in_array( 'utf8', array( 'utf8', 'utf-8', 'UTF8', 'UTF-8' ) );
        }
        if ( !$is_utf8 ) {
                return $string;
        }
        // Check for support for utf8 in the installed PCRE library once and store the result in a static
        static $utf8_pcre;
        if ( !isset( $utf8_pcre ) ) {
                $utf8_pcre = @preg_match( '/^./u', 'a' );
        }
        // We can't demand utf8 in the PCRE installation, so just return the string in those cases
        if ( !$utf8_pcre ) {
                return $string;
        }
        // preg_match fails when it encounters invalid UTF8 in $string
        if ( 1 === @preg_match( '/^./us', $string ) ) {
                return $string;
        }
        // Attempt to strip the bad chars if requested (not recommended)
        if ( $strip && function_exists( 'iconv' ) ) {
                return iconv( 'utf-8', 'utf-8', $string );
        }
        return '';
}

function _oc_specialchars( $string, $quote_style = ENT_NOQUOTES, $charset = false, $double_encode = false ) {
        $string = (string) $string;
        if ( 0 === strlen( $string ) )
                return '';
        // Don't bother if there are no specialchars - saves some processing
        if ( ! preg_match( '/[&<>"\']/', $string ) )
                return $string;
        // Account for the previous behaviour of the function when the $quote_style is not an accepted value
        if ( empty( $quote_style ) )
                $quote_style = ENT_NOQUOTES;
        elseif ( ! in_array( $quote_style, array( 0, 2, 3, 'single', 'double' ), true ) )
                $quote_style = ENT_QUOTES;
        if ( ! $charset ) {
                static $_charset;
                if ( ! isset( $_charset ) ) {
                        $alloptions = 'utf8';
                        $_charset = isset( $alloptions ) ? $alloptions : '';
                }
                $charset = $_charset;
        }
        if ( in_array( $charset, array( 'utf8', 'utf-8', 'UTF8' ) ) )
                $charset = 'UTF-8';
        $_quote_style = $quote_style;
        if ( $quote_style === 'double' ) {
                $quote_style = ENT_COMPAT;
                $_quote_style = ENT_COMPAT;
        } elseif ( $quote_style === 'single' ) {
                $quote_style = ENT_NOQUOTES;
        }
        // Handle double encoding ourselves
        if ( $double_encode ) {
                $string = @htmlspecialchars( $string, $quote_style, $charset );
        } else {
                // Decode &amp; into &
                $string = oc_specialchars_decode( $string, $_quote_style );
                // Guarantee every &entity; is valid or re-encode the &
                $string = oc_kses_normalize_entities( $string );
                // Now re-encode everything except &entity;
                $string = preg_split( '/(&#?x?[0-9a-z]+;)/i', $string, -1, PREG_SPLIT_DELIM_CAPTURE );
                for ( $i = 0; $i < count( $string ); $i += 2 )
                        $string[$i] = @htmlspecialchars( $string[$i], $quote_style, $charset );
                $string = implode( '', $string );
        }
        // Backwards compatibility
        if ( 'single' === $_quote_style )
                $string = str_replace( "'", '&#039;', $string );
        return $string;
}
function oc_specialchars_decode( $string, $quote_style = ENT_NOQUOTES ) {
        $string = (string) $string;
        if ( 0 === strlen( $string ) ) {
                return '';
        }
        if ( strpos( $string, '&' ) === false ) {
                return $string;
        }
        if ( empty( $quote_style ) ) {
                $quote_style = ENT_NOQUOTES;
        } elseif ( !in_array( $quote_style, array( 0, 2, 3, 'single', 'double' ), true ) ) {
                $quote_style = ENT_QUOTES;
        }
        $single = array( '&#039;'  => '\'', '&#x27;' => '\'' );
        $single_preg = array( '/&#0*39;/'  => '&#039;', '/&#x0*27;/i' => '&#x27;' );
        $double = array( '&quot;' => '"', '&#034;'  => '"', '&#x22;' => '"' );
        $double_preg = array( '/&#0*34;/'  => '&#034;', '/&#x0*22;/i' => '&#x22;' );
        $others = array( '&lt;'   => '<', '&#060;'  => '<', '&gt;'   => '>', '&#062;'  => '>', '&amp;'  => '&', '&#038;'  => '&', '&#x26;' => '&' );
        $others_preg = array( '/&#0*60;/'  => '&#060;', '/&#0*62;/'  => '&#062;', '/&#0*38;/'  => '&#038;', '/&#x0*26;/i' => '&#x26;' );
        if ( $quote_style === ENT_QUOTES ) {
                $translation = array_merge( $single, $double, $others );
                $translation_preg = array_merge( $single_preg, $double_preg, $others_preg );
        } elseif ( $quote_style === ENT_COMPAT || $quote_style === 'double' ) {
                $translation = array_merge( $double, $others );
                $translation_preg = array_merge( $double_preg, $others_preg );
        } elseif ( $quote_style === 'single' ) {
                $translation = array_merge( $single, $others );
                $translation_preg = array_merge( $single_preg, $others_preg );
        } elseif ( $quote_style === ENT_NOQUOTES ) {
                $translation = $others;
                $translation_preg = $others_preg;
        }
        $string = preg_replace( array_keys( $translation_preg ), array_values( $translation_preg ), $string );
        return strtr( $string, $translation );
}
function oc_kses_normalize_entities($string) {
        $string = str_replace('&', '&amp;', $string);
        $string = preg_replace_callback('/&amp;([A-Za-z]{2,8}[0-9]{0,2});/', 'oc_kses_named_entities', $string);
        $string = preg_replace_callback('/&amp;#(0*[0-9]{1,7});/', 'oc_kses_normalize_entities2', $string);
        $string = preg_replace_callback('/&amp;#[Xx](0*[0-9A-Fa-f]{1,6});/', 'oc_kses_normalize_entities3', $string);
        return $string;
}
function oc_kses_named_entities($matches) {
        global $allowedentitynames;
        if ( empty($matches[1]) )
                return '';
        $i = $matches[1];
        $allowedentitynames = array();
        return ( ( ! in_array($i, $allowedentitynames) ) ? "&amp;$i;" : "&$i;" );
}
function oc_kses_normalize_entities2($matches) {
        if ( empty($matches[1]) )
                return '';
        $i = $matches[1];
        if (valid_unicode($i)) {
                $i = str_pad(ltrim($i,'0'), 3, '0', STR_PAD_LEFT);
                $i = "&#$i;";
        } else {
                $i = "&amp;#$i;";
        }
        return $i;
}
function oc_kses_normalize_entities3($matches) {
        if ( empty($matches[1]) )
                return '';
        $hexchars = $matches[1];
        return ( ( ! valid_unicode(hexdec($hexchars)) ) ? "&amp;#x$hexchars;" : '&#x'.ltrim($hexchars,'0').';' );
}
function valid_unicode($i) {
        return ( $i == 0x9 || $i == 0xa || $i == 0xd ||
                        ($i >= 0x20 && $i <= 0xd7ff) ||
                        ($i >= 0xe000 && $i <= 0xfffd) ||
                        ($i >= 0x10000 && $i <= 0x10ffff) );
}
function esc_attr( $text ) {
        $safe_text = oc_check_invalid_utf8( $text );
        $safe_text = _oc_specialchars( $safe_text, ENT_QUOTES );
        return $safe_text;
}