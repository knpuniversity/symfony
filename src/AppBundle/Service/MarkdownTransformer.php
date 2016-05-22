<?php

namespace AppBundle\Service;

class MarkdownTransformer
{
    public function parse($str)
    {
        return strtoupper($str);
    }
}
