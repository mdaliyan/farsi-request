<?php

namespace Mdaliyan\FarsiRequest\Middleware;

use Closure;
use Illuminate\Http\Request;

class ReplaceArabicCharacters
{
    private $ignoreParameters = ['q', '_method', '_token'];

    /**
     * Handle an incoming request.
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $parameters = array_filter($request->except($this->ignoreParameters),
            function ($value) {
                return is_string($value);
            });

        $edited = [];

        array_walk($parameters, function ($value, $key) use (&$edited) {

            $edited[$key] = $this->replaceCharacters($value);
        });

        if (count($edited)) {
            $request->merge($edited);
        }

        return $next($request);
    }


    /**
     * @param $text
     * @return mixed
     * @internal param $string
     */
    private function replaceCharacters($text)
    {
        if (is_null($text)) {

            return null;
        }
        $replace_Pairs = [

            // numbers
            chr(0xD9) . chr(0xA0) => chr(0xDB) . chr(0xB0),  // ٠
            chr(0xD9) . chr(0xA1) => chr(0xDB) . chr(0xB1),  // ١
            chr(0xD9) . chr(0xA2) => chr(0xDB) . chr(0xB2),  // ٢
            chr(0xD9) . chr(0xA3) => chr(0xDB) . chr(0xB3),  // ٣
            chr(0xD9) . chr(0xA4) => chr(0xDB) . chr(0xB4),  // ٤
            chr(0xD9) . chr(0xA5) => chr(0xDB) . chr(0xB5),  // ٥
            chr(0xD9) . chr(0xA6) => chr(0xDB) . chr(0xB6),  // ٦
            chr(0xD9) . chr(0xA7) => chr(0xDB) . chr(0xB7),  // ٧
            chr(0xD9) . chr(0xA8) => chr(0xDB) . chr(0xB8),  // ٨
            chr(0xD9) . chr(0xA9) => chr(0xDB) . chr(0xB9),  // ٩

            // kaaf
            chr(0xD9) . chr(0x83) => chr(0xDA) . chr(0xA9),  // ك

            // ye
            chr(0xD9) . chr(0x89) => chr(0xDB) . chr(0x8C),  // ى
            chr(0xD9) . chr(0x8A) => chr(0xDB) . chr(0x8C),  // ي
            chr(0xD9) . chr(0x8A) => chr(0xDB) . chr(0x8C),  // ي

            // he
            chr(0xD8) . chr(0xA9) => chr(0xD9) . chr(0x87),  // ي

            // he + hamze
            chr(0xDB) . chr(0x80) => chr(0xD9) . chr(0x87) . chr(0xD9) . chr(0x94),
        ];

        return strtr($text, $replace_Pairs);
    }
}
