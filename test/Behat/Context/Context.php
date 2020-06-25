<?php

namespace Test\Behat\Context;

use Behat\MinkExtension\Context\RawMinkContext;
use Behatch\HttpCall\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class Context
 * @author Sparesotto Anaïs <a.sparesotto@icloud.com>
 */
class Context extends RawMinkContext
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var array|UploadedFile[]
     */
    private $attachments = [];

    /**
     * Context constructor.
     *
     * @param \Behatch\HttpCall\Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }


    /**
     * @When I send :method request to :url with :filename
     * @param $methode
     * @param $url
     * @param $filename
     * @return mixed
     */
    public function sendRequestWithJson($methode, $url, $filename)
    {
        return $this->request->send(
            $methode,
            $this->locatePath($url),
            [],
            $this->attachments,
            file_get_contents('test/Behat/' . $filename)
        );
    }
}