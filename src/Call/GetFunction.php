<?php declare(strict_types=1);

namespace Wouterh\GroepsadminClient\Call;

use Wouterh\GroepsadminClient\Model\GroepsadminFunction;

class GetFunction extends CallBase
{
    /**
     * Fetches the function with the given id
     * @param string $functionId
     * @return GroepsadminFunction
     */
    public function perform(string $functionId): GroepsadminFunction
    {
        $content = json_decode($this->performCall(
            "functie/$functionId"
        )->getBody()->getContents(), true);

        return GroepsadminFunction::fromApi($content);
    }
}