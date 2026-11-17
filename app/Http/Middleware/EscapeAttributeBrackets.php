<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Writes ">" inside quoted attribute values as "&gt;" (browsers read them the same).
 * Alpine attributes contain arrow functions and comparisons; simple regex text extractors
 * treat the first ">" as the end of the tag and leak the rest of the code into the page text.
 */
class EscapeAttributeBrackets
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (! str_contains((string) $response->headers->get('Content-Type'), 'text/html')) {
            return $response;
        }

        $tag = '/<[a-zA-Z][a-zA-Z0-9-]*(?:\s+[^\s"\'>=\/]+(?:\s*=\s*(?:"[^"]*"|\'[^\']*\'|[^\s"\'>]+))?)*\s*\/?>/';

        $html = preg_replace_callback($tag, fn (array $m): string => preg_replace_callback(
            '/"[^"]*"|\'[^\']*\'/',
            fn (array $v): string => str_replace('>', '&gt;', $v[0]),
            $m[0],
        ), (string) $response->getContent());

        if ($html !== null) {
            $response->setContent($html);
        }

        return $response;
    }
}
