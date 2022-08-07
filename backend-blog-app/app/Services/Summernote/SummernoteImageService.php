<?php

namespace App\Services\Summernote;

use DOMDocument;

class SummernoteImageService {
    public function dom_document($content) {
        $dom = new DomDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML('<?xml encoding="utf-8" ?>' . "<div>$content</div>");

        $container = $dom->getElementsByTagName('div')->item(0);
        $container = $container->parentNode->removeChild($container);

        while ($dom->firstChild) {
            $dom->removeChild($dom->firstChild);
        }

        while ($container->firstChild) {
            $dom->appendChild($container->firstChild);
        }
        try {
            $images = $dom->getElementsByTagName('img');

            foreach($images as $k => $img){
                $data = $img->getAttribute('src');

                list($type, $data) = explode(';', $data);
                list(, $data)      = explode(',', $data);
                $data = base64_decode($data);
                $upload_directory = public_path() ."/editor_uploads/";
                !file_exists($upload_directory) && mkdir($upload_directory, 0777, true);
                $image_name= "/editor_uploads/" . time().$k.'.png';
                $path = public_path() . $image_name;

                file_put_contents($path, $data);

                $img->removeAttribute('src');
                $img->setAttribute('src', $image_name);
            }
        } catch (\Exception $e) {}

        return $dom->saveHTML();
    }
}
