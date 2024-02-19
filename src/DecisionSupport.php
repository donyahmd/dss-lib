<?php

namespace Donyahmd\DssLib;

final class DecisionSupport
{
    public static function criteriaTransform($data)
    {
        $data = json_decode($data, true);

        $result = [];
        foreach ($data as $item) {
            $crips = [];
            foreach ($item['sub'] as $subItem) {
                $crip = [
                    'nilai' => $subItem['name'],
                    'nilai_min' => $subItem['value_min'],
                    'nilai_max' => $subItem['value_max'],
                    'bobot' => $subItem['weight']
                ];
                $crips[] = $crip;
            }

            $result[] = [
                'kode' => $item['code'],
                'nama' => $item['name'],
                'atribut' => $item['attribute'],
                'bobot' => $item['weight'],
                'is_range' => $item['is_range'],
                'crips' => $crips
            ];
        }

        return json_encode($result, JSON_PRETTY_PRINT);
    }
}
