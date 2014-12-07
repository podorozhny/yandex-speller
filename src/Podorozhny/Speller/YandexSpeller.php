<?php

namespace Podorozhny\Speller;

use Guzzle\Http\ClientInterface;
use Guzzle\Http\Client;

/**
 * Yandex speller api wrapper
 * http://api.yandex.ru/speller/doc/dg/concepts/api-overview.xml
 *
 * @class
 */
class YandexSpeller
    implements YandexSpellerInterface
{
    /**
     * @var Client
     */
    protected $adapter;

    public function __construct()
    {
        $this->setDefaultAdapter();
    }

    /**
     * {@inheritdoc}
     */
    public function check($texts, $options = [])
    {
        if (is_array($texts)) {
            return $this->checkTexts($texts);
        }

        return $this->checkText($texts, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function checkText($text, array $options = [])
    {
        $url =
            static::API_ENDPOINT . static::METHOD_CHECK_TEXT . '?text=' . $text;

        return $this->adapter->get($url)
            ->send()
            ->json();
    }

    /**
     * {@inheritdoc}
     */
    public function checkTexts(array $texts, array $options = [])
    {
        $texts = implode('&text=', $texts);
        $url   =
            static::API_ENDPOINT
            . static::METHOD_CHECK_TEXTS
            . '?text='
            . $texts;

        return $this->adapter->get($url)
            ->send()
            ->json();
    }

    /**
     * {@inheritdoc}
     */
    public function setAdapter(ClientInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultAdapter()
    {
        $this->setAdapter(new Client());
    }

    /**
     * {@inheritdoc}
     */
    public function correctText($text)
    {
        $words = explode(' ', $text);

        $mistakes = $this->check($text);

        foreach ($mistakes as $mistake) {
            $key = array_search($mistake['word'], $words);
            if (false !== $key && !empty($mistake['s'][0])) {
                $words[$key] = $mistake['s'][0];
            }
        }

        $text = implode(' ', $words);

        return $text;
    }
}
