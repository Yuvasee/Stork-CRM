<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use Session;

class Helpers
{
    // Проверяем параметры на наличие обратного пути
    // Если он есть - формируем его (с хешем, если есть), возвращаем и пишем в сессию
    // Если нет - возвращаем значение по-умолчанию
    public static function getBackUrl($defUrl)
    {
        $request = Request::capture();

        // Проверяем наличие обратного пути в запросе
        if($request->input('back_to_url'))
        {
            $back_to_url = '/' . $request->input('back_to_url');
            if($request->input('hash'))
            {
                $back_to_url .= '#' . $request->input('hash');
            }
        }

        // Проверяем наличие обратного пути в сессии на случай цепочки страниц > 1
        elseif(session('back_to_url'))
        {
            $back_to_url = session('back_to_url');
        }
        else
        {
            $back_to_url = $defUrl;
        }

        // Делаем flash в сессию
        if($back_to_url != $defUrl)
        {
            Session::flash('back_to_url', $back_to_url);
        }

        return $back_to_url;
    }
}