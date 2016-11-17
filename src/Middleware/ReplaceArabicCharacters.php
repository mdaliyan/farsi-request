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
            chr(0xD9) . chr(0xA0) => chr(0xDB) . chr(0xB0),
            chr(0xD9) . chr(0xA1) => chr(0xDB) . chr(0xB1),
            chr(0xD9) . chr(0xA2) => chr(0xDB) . chr(0xB2),
            chr(0xD9) . chr(0xA3) => chr(0xDB) . chr(0xB3),
            chr(0xD9) . chr(0xA4) => chr(0xDB) . chr(0xB4),
            chr(0xD9) . chr(0xA5) => chr(0xDB) . chr(0xB5),
            chr(0xD9) . chr(0xA6) => chr(0xDB) . chr(0xB6),
            chr(0xD9) . chr(0xA7) => chr(0xDB) . chr(0xB7),
            chr(0xD9) . chr(0xA8) => chr(0xDB) . chr(0xB8),
            chr(0xD9) . chr(0xA9) => chr(0xDB) . chr(0xB9),
            chr(0xD9) . chr(0x83) => chr(0xDA) . chr(0xA9),
            chr(0xD9) . chr(0x89) => chr(0xDB) . chr(0x8C),
            chr(0xD9) . chr(0x8A) => chr(0xDB) . chr(0x8C),
            chr(0xDB) . chr(0x80) => chr(0xD9) . chr(0x87) . chr(0xD9) . chr(0x94),
        ];

        return strtr($text, $replace_Pairs);
    }
}
