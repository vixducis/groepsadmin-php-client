<?php declare(strict_types=1);

namespace Wouterh\GroepsadminClient\Call;

use Wouterh\GroepsadminClient\Model\Member;

class getMember extends CallBase
{
    /**
     * Fetches a member with it's groepsadmin ID.
     * @param string $id
     * @return Member
     */
    public function perform(string $id): Member
    {
        $content = json_decode($this->performCall("/lid/$id")->getBody()->getContents(), true);
        return Member::fromApi($content);
    }
}