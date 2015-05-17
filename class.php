<?php

namespace Local\Components\CsvParser;

use Bitrix\Main\Context;
use Bitrix\Main\HttpRequest;
use CBitrixComponent;
use CFile;
use Exception;

require __DIR__ . '/lib/CsvParser.php';
require __DIR__ . '/lib/Response.php';

class Component extends CBitrixComponent {
    /**
     * @throws Exception
     */
    public function executeComponent() {
        $request = Context::getCurrent()->getRequest();

        try {
            $response = $this->processRequest($request);
        } catch (Exception $e) {
            $response = new Response('error', array(
                'EXCEPTION' => $e
            ));
        }

        $this->arResult = $response->getData();
        $this->includeComponentTemplate();
    }

    /**
     * @param HttpRequest $request
     * @return Response
     * @throws Exception
     */
    public function processRequest(HttpRequest $request) {
        $action = $request->getPost('ACTION') . "Action";

        if (!$request->isPost()) {
            return $this->formAction();
        }

        if (!method_exists($this, $action)) {
            throw new Exception('not allowed action');
        }

        return call_user_func(array($this, $action), $request);
    }

    /**
     * @param HttpRequest $request
     * @return Response
     * @throws Exception
     */
    public function uploadAction(HttpRequest $request) {
        $file = $request->getFile('FILE');

        if (!$fileId = CFile::SaveFile($file, 'csv-parser')) {
            throw new Exception('Can not save file');
        }

        return new Response('upload', array(
            'FILE_ID' => $fileId
        ));
    }

    /**
     * @param HttpRequest $request
     * @return Response
     */
    public function parseAction(HttpRequest $request) {
        $iteration = $request->getPost('ITERATION') ?: 0;
        $iteration += 1;

        $fileId = $request->getPost('FILE_ID');
        $file = CFile::GetFileArray($fileId);

        $parser = new CsvParser($_SERVER['DOCUMENT_ROOT'] . $file['SRC']);
        $parser->setStepsByIteration(100);

        while ($data = $parser->parse()) {
            // process data
        }

        if ($parser->endOfParse()) {
            CFile::Delete($fileId);

            return new Response('end');
        }

        return new Response('parse', array(
            'ITERATION' => $iteration,
            'FILE_ID' => $fileId
        ));
    }

    /**
     * @return Response
     */
    private function formAction() {
        return new Response('form');
    }
}
