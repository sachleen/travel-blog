Title: Truncating HTML strings by paragraphs in PHP
Date: 2017-12-20 11:05 am
Tags: cool, blog
Template: post
===
I came across a need to take HTML and limit it to one or two paragraphs to show as a summary. This is useful when you have a blog post but only want to show a little of it on the main page with a link to read more. I didn't want to put any sort of break in the actual HTML string to indicate where the break should happen so I decided to limit it to two paragraphs.

There are [multiple][1] [options][2] to truncate a string while preserving HTML tags, but I felt those to be unnecessarily complex and truncating by number of characters seemed unreasonable for my use case.

So I came up with this simple solution using the DOMDocument class:

    public function TruncatePFilter($text, $pLen = 2, $endStr = '')
    {
        $dom = new \DOMDocument();
        $dom->loadHTML((mb_convert_encoding($text, 'HTML-ENTITIES', 'UTF-8')));
        $paragraphs = $dom->getElementsByTagName('p');
        
        $count = min($pLen, $paragraphs->length);
        $retStr = "";
        for ($i = 0; $i < $count; $i++) {
            
            $retStr .= $dom->saveXML($paragraphs->item($i));
        }
        
        return $retStr . $endStr;
    }

This function takes the HTML string, number of p tags, and a string to add to the end ("Continue Reading...", for example) and returns the truncated string. It preserves all HTML within the `p` tags, including images.

I am using this as part of my new static site generator, [Steady][3]. Since I use Twig for templates, I decided to make it into a Twig extension for ease of use in the template files. Check out the full source on my GitHub [Twig-TruncateP][4] and get the package at [packagist][5].


  [1]: https://stackoverflow.com/a/16583897/219118
  [2]: https://gist.github.com/antonzaytsev/1260890
  [3]: https://github.com/sachleen/Steady/
  [4]: https://github.com/sachleen/Twig-TruncateP
  [5]: https://packagist.org/packages/sachleen/twig-truncatep