<?php


namespace StorykubeLibrary\Summariser\Tool\Helper;


class QuotedTextCurator
{

    const charMumbleReplace = '~~mumble~~';
    const charDotReplace = '~~dot~~';
    const charQuestReplace = '~~quest~~';
    const charExclReplace = '~~excl~~';

    /**
     * @var string
     */
    private $text;

    /**
     * QuotedTextCurator constructor.
     * @param string $text
     */
    public function __construct(string $text = '')
    {

        $this->text = $text;
    }

    /**
     * @return $this
     */
    public function protect(): self
    {
        $this->text = $this->curvyToStraight($this->text);
        $this->text = preg_replace('/\.\.\.(?!(?:[^"]*"[^"]*")*[^"]*$)/', self::charMumbleReplace, $this->text);
        $this->text = preg_replace('/\.\.(?!(?:[^"]*"[^"]*")*[^"]*$)/', self::charMumbleReplace, $this->text);
        $this->text = preg_replace('/\.(?!(?:[^"]*"[^"]*")*[^"]*$)/', self::charDotReplace, $this->text);
        $this->text = preg_replace('/\?(?!(?:[^"]*"[^"]*")*[^"]*$)/', self::charQuestReplace, $this->text);
        $this->text = preg_replace('/\!(?!(?:[^"]*"[^"]*")*[^"]*$)/', self::charExclReplace, $this->text);
        return $this;
    }


    /**
     * @param $text
     * @return string|string[]
     */
    private function restoreAlgorithm($text)
    {
        $text = str_replace(self::charExclReplace, '!', $text);
        $text = str_replace(self::charQuestReplace, '?', $text);
        $text = str_replace(self::charDotReplace, '.', $text);
        $text = str_replace(self::charMumbleReplace, '...', $text);
        return $text;
    }

    /**
     * @return string
     */
    public function restore(): string
    {
        return $this->restoreAlgorithm($this->text);
    }

    /**
     * @param $text
     * @return string
     */
    public function restoreFromText($text): string
    {
        return $this->curvyQuotes($this->restoreAlgorithm($text));

    }

    public function getText()
    {
        return $this->text;
    }

    /**
     * Transform straight to curly (smart) quotes — and apostrophe
     * @param string $str
     * @return string|string[]
     */
    private function curvyQuotes(string $str)
    {
        $str = preg_replace('/(\s|^)\"([^\"]+)\"/', '$1“$2”', $str);
        $str = str_replace("' ", "’ " , $str);
        $str = str_replace(" '", " ‘" , $str);
        $str = str_replace("'", "’" , $str);
        return $str;

    }

    private function curvyToStraight(string $str)
    {
        $chr_map = array(
            // Windows codepage 1252
            "\xC2\x82" => "'", // U+0082⇒U+201A single low-9 quotation mark
            "\xC2\x84" => '"', // U+0084⇒U+201E double low-9 quotation mark
            "\xC2\x8B" => "'", // U+008B⇒U+2039 single left-pointing angle quotation mark
            "\xC2\x91" => "'", // U+0091⇒U+2018 left single quotation mark
            "\xC2\x92" => "'", // U+0092⇒U+2019 right single quotation mark
            "\xC2\x93" => '"', // U+0093⇒U+201C left double quotation mark
            "\xC2\x94" => '"', // U+0094⇒U+201D right double quotation mark
            "\xC2\x9B" => "'", // U+009B⇒U+203A single right-pointing angle quotation mark

            // Regular Unicode     // U+0022 quotation mark (")
            // U+0027 apostrophe     (')
            "\xC2\xAB"     => '"', // U+00AB left-pointing double angle quotation mark
            "\xC2\xBB"     => '"', // U+00BB right-pointing double angle quotation mark
            "\xE2\x80\x98" => "'", // U+2018 left single quotation mark
            "\xE2\x80\x99" => "'", // U+2019 right single quotation mark
            "\xE2\x80\x9A" => "'", // U+201A single low-9 quotation mark
            "\xE2\x80\x9B" => "'", // U+201B single high-reversed-9 quotation mark
            "\xE2\x80\x9C" => '"', // U+201C left double quotation mark
            "\xE2\x80\x9D" => '"', // U+201D right double quotation mark
            "\xE2\x80\x9E" => '"', // U+201E double low-9 quotation mark
            "\xE2\x80\x9F" => '"', // U+201F double high-reversed-9 quotation mark
            "\xE2\x80\xB9" => "'", // U+2039 single left-pointing angle quotation mark
            "\xE2\x80\xBA" => "'", // U+203A single right-pointing angle quotation mark
        );
        $chr = array_keys  ($chr_map); // but: for efficiency you should
        $rpl = array_values($chr_map); // pre-calculate these two arrays
        $str = str_replace($chr, $rpl, html_entity_decode($str, ENT_QUOTES, "UTF-8"));
        return $str;
    }
}