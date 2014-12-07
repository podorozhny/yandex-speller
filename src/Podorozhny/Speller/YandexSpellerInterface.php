<?php

namespace Podorozhny\Speller;

use Guzzle\Http\ClientInterface;

/**
 * YandexSpellerInterface is the interface for the yandex speller.
 */
interface YandexSpellerInterface
{
    const API_ENDPOINT = 'http://speller.yandex.net/services/spellservice.json/';

    /**
     * Available API methods
     */
    const METHOD_CHECK_TEXT  = 'checkText';
    const METHOD_CHECK_TEXTS = 'checkTexts';


    /**
     * Check text
     *
     * @param mixed $texts
     * @param array $options
     *
     * @return array
     */
    public function check($texts, $options);

    /**
     * Check single text
     *
     * @param string $text
     * @param array  $options
     *
     * @return array
     */
    public function checkText($text, array $options);

    /**
     * Check given list of texts
     *
     * @param array $texts
     * @param array $options
     *
     * @return array
     */
    public function checkTexts(array $texts, array $options);

    /**
     * Set HTTP adapter
     *
     * @param ClientInterface $adapter instance of http client
     */
    public function setAdapter(ClientInterface $adapter);

    /**
     * Set default http adapter Guzzle\Http\Client
     */
    public function setDefaultAdapter();

    /**
     * Correct text
     *
     * @param string $text
     *
     * @return array
     */
    public function correctText($text);
}
