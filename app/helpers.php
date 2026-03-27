<?php

use App\Models\Menu;

if (!function_exists('getHeaderMenus')) {
    function getHeaderMenus()
    {
        return Menu::where('type', 'header')->orderBy('id', 'asc')->get();
    }
}

if (!function_exists('getFooterMenus')) {
    function getFooterMenus()
    {
        return Menu::where('type', 'footer')->orderBy('id', 'asc')->get();
    }
}

