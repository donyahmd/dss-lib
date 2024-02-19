<?php

namespace Donyahmd\DssLib;

final class DecisionSupport
{
    public static function criteriaTransform($data)
    {
        $data = json_decode($data, true);

        $result = [];
        foreach ($data as $item) {
            $crips = array_map(function ($subItem) {
                return [
                    'nilai' => $subItem['name'],
                    'nilai_min' => $subItem['value_min'],
                    'nilai_max' => $subItem['value_max'],
                    'bobot' => $subItem['weight']
                ];
            }, $item['sub']);

            $result[] = [
                'kode' => $item['code'],
                'nama' => $item['name'],
                'atribut' => $item['attribute'],
                'bobot' => $item['weight'],
                'is_range' => $item['is_range'],
                'crips' => $crips
            ];
        }

        return $result;
    }

}
