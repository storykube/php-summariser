<?php

use PHPUnit\Framework\TestCase;
use StorykubeLibrary\Summariser\TextRankFacade;
use StorykubeLibrary\Summariser\Tool\StopWords\English;

final class TextRankFacadeTest extends TestCase
{
    public function testFlow()
    {

        $text = "Georgia (SK) — Joe Biden narrowly defeated President Trump in Georgia's southern battleground state, becoming the first Democratic presidential candidate to secure this traditionally conservative stronghold since 1992. Major TV networks declared Biden the winner Friday in Georgia and President Trump, the winner in North Carolina. With just 14,000 votes separating Biden and Trump, Georgia election officials began the laborious process of a statewide audit Friday. “This proves what we've been saying all along.. that we have the voters here to flip the state blue”, said Nikema Williams, the chair of the Georgia Democratic Party. The vote capped a decade of Democratic efforts to capitalize on changes in Georgia over the last decade. The state's population has surged from 9.6 million to 10.6 million. Two years later, then-Secretary of State Brian Kemp, the Republican candidate, won the governorship over Democrat Stacey Abrams by just 1.4 percentage points. “Georgia will be a big presidential win, as it was the night of the Election!” He tweeted. Republicans knew that Georgia would be tight. Some Democrats say the party needs to go beyond focusing on turning out voters. They say it needs to think about how to reach a broader group of voters. Michael Thurmond is the chief executive of DeKalb County, a predominantly Black county that voted 83% for Biden. Thurmond said Biden's campaign made headway in Georgia. Biden said he hoped to see the Democratic Party continue to build a Democratic coalition of black and white voters. Williams said she was not worried about Democrats' chances of winning a state election in which President Trump's name was not on the ballot. “It certainly looks like there's a high degree of likelihood that Joe Biden will be the next president... With Nancy Pelosi in charge of the House, with Joe Biden and Kamala Harris running the executive branch of government, the thought of Chuck Schumer being the [Senate] majority leader is a big motivator to get them”.";
        $api = new TextRankFacade();
        $stopWords = new English();
        $api->setStopWords($stopWords);
        $api->setSentencesLimit(5);

        $sentences = $api->summarizeTextBasic($text);

        $this->assertIsArray($sentences);
        $this->assertCount(5, $sentences);

        $sentences = $api->summarizeTextCompound($text);
        $this->assertIsArray($sentences);
        $this->assertCount(5, $sentences);

        $api->setSentencesLimit(8);
        $sentences = $api->summarizeTextBasic($text);
        $this->assertIsArray($sentences);
        $this->assertCount(8, $sentences);

        $summary = implode(" ", $sentences);
        $this->assertStringContainsString('”', $summary);
        $this->assertStringContainsString('“', $summary);
        $this->assertStringNotContainsString('"', $summary);

        echo $summary;

    }
}
