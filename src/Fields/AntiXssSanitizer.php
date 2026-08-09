<?php

namespace LaraZeus\Bolt\Fields;

use LaraZeus\Bolt\Contracts\HtmlSanitizer;
use voku\helper\AntiXSS;

/**
 * The default sanitizer, backed by voku/anti-xss.
 *
 * Used for field types that intentionally store HTML, where escaping the value
 * would render the markup as literal text. Swap it out with the
 * `zeus-bolt.html_sanitizer` config key.
 */
class AntiXssSanitizer implements HtmlSanitizer
{
    public function sanitize(string $html): string
    {
        return (new AntiXSS)->xss_clean($html);
    }
}
