<?php
/**
 * @author Smotrov Dmitriy <smotrov@worksolutions.ru>
 */

namespace Local\Components\CsvParser;

use SplFileObject;

class CsvParser {

    private $stepsByIteration = 100;
    private $stepCount = 0;
    private $endOfIteration;
    private $file;
    private $endOfParse;
    private $headers;
    private $escape;
    private $enclosure;
    private $delimiter;

    /**
     * @param $file
     * @param string $delimiter
     * @param string $enclosure
     * @param string $escape
     */
    public function __construct($file, $delimiter = ";", $enclosure = "\"", $escape = "\\") {
        if (!$file instanceof SplFileObject) {
            $file = new SplFileObject($file, 'c+');
        }

        $this->file = $file;
        $this->delimiter = $delimiter;
        $this->enclosure = $enclosure;
        $this->escape = $escape;
        $this->headers = $this->file->fgetcsv(
            $this->delimiter,
            $this->enclosure,
            $this->escape
        );
    }

    /**
     * @param $count
     * @return $this
     */
    public function setStepsByIteration($count) {
        $this->stepsByIteration = $count;

        return $this;
    }

    /**
     * @return bool
     */
    public function parse() {
        $this->stepCount += 1;

        if ($this->stepsByIteration && $this->stepCount > $this->stepsByIteration) {
            $this->fireEndOfIteration();
            return false;
        }

        if ($this->file->eof()) {
            $this->fireEndOfParse();
            return false;
        }

        $columns = $this->file->fgetcsv($this->delimiter, $this->enclosure, $this->escape);

        // is empty string – follow to next string
        if ($columns[0] === null) {
            return $this->parse();
        }

        $data = array();
        foreach ($columns as $index => $value ) {
            $data[$this->headers[$index]] = $value;
        }

        return $data;
    }

    private function fireEndOfIteration() {
        if ($this->endOfIteration) {
            return;
        }

        $this->endOfIteration = true;

        $this->truncateFile();
    }

    private function truncateFile() {
        $temp = tmpfile();
        $file = $this->file;

        fputcsv($temp, $this->headers, $this->delimiter, $this->enclosure);

        while (!$file->eof() && $string = $file->fgets()) {
            fwrite($temp, $string);
        }

        fseek($temp, 0);

        $file->seek(0);
        $file->ftruncate(0);

        while ($string = fgets($temp)) {
            $file->fwrite($string);
        }

        fclose($temp);
    }

    public function endOfParse() {
        return $this->endOfParse;
    }

    private function fireEndOfParse() {
        if ($this->endOfParse) {
            return;
        }

        $this->endOfParse = true;
    }
}
