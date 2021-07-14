<?php declare(strict_types=1);

namespace Wouterh\GroepsadminClient\Call;

use Wouterh\GroepsadminClient\Model\Member;

class SearchSimilarMembers extends CallBase
{
    private const API_TRANSLATION_FUNCTIONS = [
        'id' => 'setId',
        'gsm' => 'setMobilePhone',
        'geboortedatum' => 'setBirthDate',
        'email' => 'setMail',
        'achternaam' => 'setLastName',
        'telefoon' => 'setPhone',
        'voornaam' => 'setFirstName',
    ];

    /**
     * Searches for members in the groepsadmin by a first and last name.
     * Returns an array of members that match the query.
     * @param string $firstname
     * @param string $lastname
     * @return Member[]
     */
    public function perform(string $firstname, string $lastname): array
    {
        $content = json_decode(
            $this->performCall(
                endpoint: 'zoeken/gelijkaardig', 
                queryParams: ['voornaam' => $firstname, 'achternaam' => $lastname]
            )->getBody()->getContents(), 
            true
        );
        $output = [];
        foreach ($content['leden'] as $memberContent) {
            $output[] = Member::fromApi($memberContent, self::API_TRANSLATION_FUNCTIONS);
        }

        return $output;
    }
}