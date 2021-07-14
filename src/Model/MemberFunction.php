<?php declare(strict_types=1);

namespace Wouterh\GroepsadminClient\Model;

use DateTime;

class MemberFunction
{
    use LoadFromApiTrait;

    private ?string $group = null;
    private ?string $functionId = null;
    private ?DateTime $start = null;
    private ?DateTime $end = null;

    /**
     * Returns the group for which the function is active.
     * @return string
     */
    public function getGroup(): string
    {
        return $this->group;
    }

    /**
     * Sets the group for which the function is active
     * @param string $group
     */
    public function setGroup(string $group): void
    {
        $this->group = $group;
    }

    /**
     * Returns the function's groepsadmin ID
     * @return string
     */
    public function getFunctionId(): string
    {
        return $this->functionId;
    }

    /**
     * Sets the function's groepsadmin ID
     * @param string $id
     */
    public function setFunctionId(string $id): void
    {
        $this->functionId = $id;
    }

    /**
     * Returns the start date of the function
     * @return DateTime|null
     */
    public function getStart(): ?DateTime
    {
        return $this->start;
    }

    /**
     * Sets the start date of the function
     * @param DateTime|string $date
     */
    public function setStart(DateTime|string $date): void
    {
        $this->start = is_string($date) ? new DateTime($date) : $date;
    }

    /**
     * Returns the end date of the function
     * @return DateTime|null
     */
    public function getEnd(): ?DateTime
    {
        return $this->end;
    }

    /**
     * Sets the end date of the function
     * @param DateTime|string $date
     */
    public function setEnd(DateTime|string $date): void
    {
        $this->end = is_string($date) ? new DateTime($date) : $date;
    }

    /**
     * A factory method that returns a new MemberFunction object based on the content of an API call.
     * @param array $content
     * @return MemberFunction
     */
    public static function fromApi(array $content): MemberFunction
    {
        return self::loadFromApi(
            new MemberFunction,
            [
                'groep' => 'setGroup',
                'functie' => 'setFunctionId',
                'begin' => 'setStart',
                'einde' => 'setEnd'
            ],
            $content
        );
    }
}