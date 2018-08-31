<?php

namespace oauth\tests;

// here you can define custom actions
// all public methods declared in helper class will be available in $I
class RedirectHelper extends \Codeception\Module
{
    /**
     * Toggle redirections on and off.
     *
     * By default, BrowserKit will follow redirections, so to check for 30*
     * HTTP status codes and Location headers, they have to be turned off.
     *
     * @since 1.0.0
     *
     * @param bool $followRedirects Optional. Whether to follow redirects or not.
     *                              Default is true.
     */
    public function followRedirects($followRedirects = true)
    {
        $this->getModule('Yii2')->client->followRedirects($followRedirects);
    }

    public function grabHeader($header)
    {
        $response = $this->getModule('Yii2')->client->getInternalResponse();
        $responseCode = $response->getStatus();
        return $response->getHeaders()[$header];
    }

    public function seeHeaderContains($header, $text)
    {
        $this->assertContains($text, $this->grabHeader($header)[0]);
    }
}