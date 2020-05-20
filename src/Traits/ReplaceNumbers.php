<?php

namespace Mdaliyan\FarsiRequest\Traits;

Trait ReplaceNumbers
{
    /*
     *  These Variables should be added to the request class
     */
    //private $mustHaveEnglishNumbers = ['id'];
    //private $mustHaveFarsiNumbers = [];

    private $farsiNumbers = ['۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹', '۰'];
    private $englishNumbers = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '0'];

    protected function getValidatorInstance()
    {
        $this->sanitize();

        return parent::getValidatorInstance();
    }

    private function sanitize()
    {
        if (isset($this->mustHaveEnglishNumbers) && count($this->mustHaveEnglishNumbers)) {

            $this->replace_in_attributes(
                $this->farsiNumbers,
                $this->englishNumbers,
                $this->mustHaveEnglishNumbers);
        }

        if (isset($this->mustHaveFarsiNumbers) && count($this->mustHaveFarsiNumbers)) {

            $this->replace_in_attributes(
                $this->englishNumbers,
                $this->farsiNumbers,
                $this->mustHaveFarsiNumbers);
        }
    }

    private function replace_in_attributes($these, $with_these, $in_these_attributes)
    {
        $parameters = array_filter($this->only($in_these_attributes),
            function ($value) {
                return !is_null($value);
            });
        
        $edited = [];

        array_walk($parameters, function ($value, $key) use (&$edited, $these, $with_these) {

            preg_match_all('/<[\S|\/][^>]*\/?>/i', $value, $matches);

            $html_tags = $this->flatten($matches);

            if (count($html_tags)) {

                $keys = $this->replaceableKeys(count($html_tags));

                // Replace Html Tags with unique Keys
                $replaced = str_replace($html_tags, $keys, $value);

                // Do desired character replacement
                $replaced = str_replace($these, $with_these, $replaced);

                // Replace unique Keys with original html tags
                $edited[$key] = str_replace($keys, $html_tags, $replaced);

            } else {

                $edited[$key] = str_replace($these, $with_these, $value);
            }
        });

        if (count($edited)) {

            $this->request->add($edited);
            $this->merge($edited);
        }
    }

    private function replaceableKeys($count)
    {
        $return = [];
        foreach ($this->generateReplaceableKeys($count) as $value) {
            $return[] = "<%&!%" . $value . "%!%>";
        }
        
        return $return;
    }

    private function generateReplaceableKeys($count)
    {
        $Char = 'RANDOM';
        for ($i = 0; $i !== $count; $i++) {
            yield ++$Char;
        }
    }
    
    private function flatten($array, $depth = INF)
    {
        $result = [];

        foreach ($array as $item) {
            $item = $item instanceof Collection ? $item->all() : $item;

            if (! is_array($item)) {
                $result[] = $item;
            } else {
                $values = $depth === 1
                    ? array_values($item)
                    : static::flatten($item, $depth - 1);

                foreach ($values as $value) {
                    $result[] = $value;
                }
            }
        }

        return $result;
    }

}
