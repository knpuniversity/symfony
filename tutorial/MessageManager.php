<?php

namespace AppBundle\Service;

class MessageManager
{
    private $encouragingMessages = array();
    private $discouragingMessages = array();

    public function __construct(array $encouragingMessages, array $discouragingMessages)
    {
        $this->encouragingMessages = $encouragingMessages;
        $this->discouragingMessages = $discouragingMessages;
    }

    public function getEncouragingMessage()
    {
        return $this->encouragingMessages[array_rand($this->encouragingMessages)];
    }

    public function getDiscouragingMessage()
    {
        return $this->discouragingMessages[array_rand($this->discouragingMessages)];
    }
}
