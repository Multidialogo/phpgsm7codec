<?php

namespace multidialogo\phpgsm7codec\component;

class CharsetAnalyzer
{
    public static function isValidGSM7String(string $input): bool
    {
        return 0 === static::countExtraCodecChars($input);
    }

    public static function countExtraCodecChars(string $input): int
    {
        $valid_gsm0338_chars = array(
            '@','Δ',' ','0','¡','P','¿','p',
            '£','_','!','1','A','Q','a','q',
            '$','Φ','"','2','B','R','b','r',
            '¥','Γ','#','3','C','S','c','s',
            'è','Λ','¤','4','D','T','d','t',
            'é','Ω','%','5','E','U','e','u',
            'ù','Π','&','6','F','V','f','v',
            'ì','Ψ','\'','7','G','W','g','w',
            'ò','Σ','(','8','H','X','h','x',
            'Ç','Θ',')','9','I','Y','i','y',
            "\n",'Ξ','*',':','J','Z','j','z',
            'Ø',"\x1B",'+',';','K','Ä','k','ä',
            'ø','Æ',',','<','L','Ö','l','ö',
            "\r",'æ','-','=','M','Ñ','m','ñ',
            'Å','ß','.','>','N','Ü','n','ü',
            'å','É','/','?','O','§','o','à'
        );

        $len = mb_strlen( $input, 'UTF-8');
        $count = 0;

        for( $i=0; $i < $len; $i++) {
            if (!in_array(mb_substr($input,$i,1,'UTF-8'), $valid_gsm0338_chars)) {
                $count++;
            }
        }

        return $count;
    }
}