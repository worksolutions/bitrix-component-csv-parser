<?php
/**
 * @author Smotrov Dmitriy <smotrov@worksolutions.ru>
 */

namespace Local\Components\CsvParser;

class Response {
    private $data;

    public function __construct($template, $data = array()) {
        $this->data = array_merge($data, array(
            'TEMPLATE' => $template
        ));
    }

    public function getData() {
        return $this->data;
    }
}
