<?php


namespace App\Helpers;


use Illuminate\Support\Str;

class ArrayHelper
{
    public function snakeCaseKey(array $array): array
    {
        return array_map(
            function($item) {
                if (is_array($item)) {
                    $item = $this->snakeCaseKey($item);
                }

                return $item;
            },
            $this->_doSnakeCaseKey($array)
        );
    }

    private function _doSnakeCaseKey(array $array): array
    {
        $result = [];

        foreach ($array as $key => $value) {
            $key = Str::snake($key);

            $result[$key] = $value;
        }

        return $result;
    }
}