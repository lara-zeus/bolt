<?php

namespace LaraZeus\Bolt\Contracts;

interface HtmlSanitizer
{
    /**
     * Strip dangerous markup from a value that is intentionally rendered as HTML.
     *
     * Implementations receive untrusted input and must return markup that is safe
     * to print unescaped, while preserving the formatting authors expect to keep.
     */
    public function sanitize(string $html): string;
}
