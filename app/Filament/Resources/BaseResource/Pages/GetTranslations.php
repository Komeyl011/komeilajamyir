<?php

namespace App\Filament\Resources\BaseResource\Pages;

trait GetTranslations
{
    protected function mutateData(array $data): array
    {
        $inputs = [];
        $translations = [];
        $keys_to_unset = [];
        foreach ($data as $key => $value) {
            if (str_ends_with($key, '_translated_en')) {
                $input = str_replace('_translated_en', '', $key);
                $keys_to_unset[] = $key;
                $translations[$input]['en'] = $value;
                if (!in_array($input, $inputs)) {
                    $inputs[] = $input;
                }
            } elseif (str_ends_with($key, '_translated_fa')) {
                $input = str_replace('_translated_fa', '', $key);
                $keys_to_unset[] = $key;
                $translations[$input]['fa'] = $value;
                if (!in_array($input, $inputs)) {
                    $inputs[] = $input;
                }
            }
        }
        if (! empty($inputs) && ! empty($translations) && ! empty($keys_to_unset)) {
            if (count($inputs) == 1) {
                $inputs = $inputs[0];

                $data[$inputs] = json_encode($translations[$inputs]);

            } elseif (count($inputs) > 1) {
                foreach ($inputs as $key => $value) {
                    $data[$value] = json_encode($translations[$value]);
                }
            }
            $data_to_insert = array_diff_key($data, array_flip($keys_to_unset));
        } else {
            $data_to_insert = $data;
        }

//        dd($data_to_insert);

        return $data_to_insert;
    }
}
