<?php

namespace StorykubeLibrary\Summariser;

class Summary
{
    /**
     * @var string
     */
    private $text;

    /**
     * Summary constructor.
     * @param string $text
     */
    public function __construct(string $text) {

        $this->text = $text;
    }

}