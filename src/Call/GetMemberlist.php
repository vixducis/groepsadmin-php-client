<?php declare(strict_types=1);

namespace Wouterh\GroepsadminClient\Call;

use Wouterh\GroepsadminClient\Model\Member;

class GetMemberlist extends CallBase
{
    use OffsetTrait;

    private const API_TRANSLATION_FUNCTIONS = [
        'id' => 'setId',
        'waarden' => [
            'gsm' => 'setMobilePhone',
            'geboortedatum' => 'setBirthDate',
            'email' => 'setMail',
            'achternaam' => 'setLastName',
            'telefoon' => 'setPhone',
            'voornaam' => 'setFirstName',
            'lidnummer' => 'setMemberNumber'
        ]
    ];

    /**
     * Retrieves the list with all members and returns it.
     * Please note that only a limited number of members will be fetched.
     * Multiple calls might be required to get all members.
     * The getNextOffset() function can be used to handle this scenario.
     * @param int $offset (optional)
     * @return Member[]
     */
    public function perform(int $offset = 0): array
    {
        $content = json_decode(
            $this->performCall(
                endpoint: 'ledenlijst', 
                queryParams: ['offset' => $offset]
            )->getBody()->getContents(), 
            true
        );
        $output = [];
        foreach ($content['leden'] as $memberContent) {
            $output[] = Member::fromApi($memberContent, self::API_TRANSLATION_FUNCTIONS);
        }

        $this->increaseOffset(count($content['leden']));
        return $output;
    }
}