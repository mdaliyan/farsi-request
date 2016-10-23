<?php

namespace Mdaliyan\FarsiRequest\Middleware;

use Closure;
use Illuminate\Http\Request;

class ReplaceArabicCharacters
{
    private $arabicCharacters = ['ي', 'ك', 'ة', '٤', '٥', '٦'];
    private $farsiCharacters = ['ی', 'ک', 'ه', '۴', '۵', '۶'];

    private $ignoreParameters = ['q', 'id', '_method', '_token'];


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
     * @param $string
     * @return mixed
     */
    private function replaceCharacters($string)
    {
        return str_replace($this->arabicCharacters, $this->farsiCharacters, $string);
    }

}
