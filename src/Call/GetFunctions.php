<?php declare(strict_types=1);

namespace Wouterh\GroepsadminClient\Call;

use Wouterh\GroepsadminClient\Model\GroepsadminFunction;

class GetFunctions extends CallBase
{
    /**
     * Fetches all functions available within the given group
     * @param string $groupNumber
     * @return GroepsadminFunction[]
     */
    public function perform(string $groupNumber): array
    {
        $content = json_decode($this->performCall(
            endpoint: 'functie',
            queryParams: ['groep' => $groupNumber]
        )->getBody()->getContents(), true);

        $output = [];
        foreach ($content['functies'] as $func) {
            $output[] = GroepsadminFunction::fromApi($func);
        }
        return $output;
    }
}