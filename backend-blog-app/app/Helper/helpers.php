<?php
function decimal2($num){
    return number_format((float)$num, 2, '.', '');
}

function make_min_2_digits($num){
    return sprintf("%02d", $num);
}

if (!function_exists('rootDir')) {
    /**
     * @return string
     */
    function rootDir()
    {
        $paths = explode(DIRECTORY_SEPARATOR, $_SERVER['DOCUMENT_ROOT']);
        array_pop($paths);
        return implode(DIRECTORY_SEPARATOR, $paths);
    }
}

// Get default image
if (!function_exists('getDefaultImage')) {
    /**
     * @return string
     */
    function getDefaultImage()
    {
        return asset('/images/default.png');
    }
}

// Get user default image
if (!function_exists('getUserDefaultImage')) {
    /**
     * @return string
     */
    function getUserDefaultImage()
    {
        return asset('/images/user_default.png');
    }
}

// Get global image
if (!function_exists('getStorageImage')) {
    /**
     * @return string
     */
    function getStorageImage($path, $name, $is_user = false)
    {
        if ($name) {
            return asset('/storage/' . $path . '/' . $name);
        }
        return $is_user ? getUserDefaultImage() : getDefaultImage();
    }
}

if (!function_exists('get_page_meta')) {

    /**
     * get_page_meta
     *
     * @param  mixed $metaName
     * @return void
     */
    function get_page_meta($metaName = "title")
    {
        if (session()->has('page_meta_' . $metaName)) {
            $title = session()->get("page_meta_" . $metaName);
            session()->forget("page_meta_" . $metaName);
            return $title;
        }
        return null;
    }
}

if (!function_exists('set_page_meta')) {
    /**
     * set_page_meta
     *
     * @param null $content
     * @param string $metaName
     *
     * @return void
     */
    function set_page_meta($content = null, $metaName = "title")
    {
        if ($content && $metaName == "title") {
            session()->put('page_meta_' . $metaName, $content . ' |');
        } else {
            session()->put('page_meta_' . $metaName, $content);
        }
    }
}


if (!function_exists('custom_datetime')) {
    /**
     * custom_datetime
     *
     * @param  mixed $datetime
     * @param  mixed $format
     * @return void
     */
    function custom_datetime($datetime, $format = null)
    {
        if ($format) return date($format, strtotime($datetime));

        return date('Y-m-d g:i A', strtotime($datetime));
    }
}


if (!function_exists('custom_date')) {
    /**
     * custom_date
     *
     * @param  mixed $datetime
     * @param  mixed $format
     * @return void
     */
    function custom_date($datetime, $format = null)
    {
        if ($format) return date($format, strtotime($datetime));

        return date('Y-m-d', strtotime($datetime));
    }
}

if (!function_exists('getAppLogo')) {

    /**
     * getAppLogo
     *
     * @return void
     */
    function getAppLogo()
    {
        return asset('images/logo.png');
    }
}


function shop_domain_generator($shop){
    if ($shop == 'SHOP_1') {
        return 'localhost:8000';
        // return 'monsterfrontend.mashpy.me';
    }
}

if (!function_exists('percentageCalculation')) {

    /**
     * getAppLogo
     *
     * @return float|int
     */
    function percentageCalculation($price, $discount)
    {
        $discountPrice = $price * ($discount / 100);
        return $price - $discountPrice;
    }
}
