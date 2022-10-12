<?php

namespace KnpU\LoremIpsumBundle;

class KnpUWordProvider implements WordProviderInterface
{
    public function getWordList(): array
    {
        return [
            'adorable',
            'active',
            'admire',
            'adventurous',
        ];
    }
}
