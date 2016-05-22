<?php

namespace AppBundle\Service;

class MarkdownTransformer
{
    public function parse($str)
    {
        return $this->get('markdown.parser')
            ->transform($str);
    }
}
