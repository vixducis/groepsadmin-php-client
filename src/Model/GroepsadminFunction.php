<?php declare(strict_types=1);

namespace Wouterh\GroepsadminClient\Model;

use DateTime;

class GroepsadminFunction
{
    use LoadFromApiTrait;

    protected ?string $id = null;
    protected ?string $description = null;
    protected ?string $type = null;
    protected ?array $groups = null;
    protected ?DateTime $changed = null;

    /**
     * Returns the function's groepsadmin ID
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Sets the function's groepsadmin ID
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * Returns the function's description
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Sets the description of the function()
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * Returns the type of the function
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * Sets the type of the function
     * @param string $type
     */
    public function setType(string $type): void 
    {
        $this->type = $type;
    }

    /**
     * Returns the groups to which this function applies to.
     * @return null|string[]
     */
    public function getGroups(): ?array
    {
        return $this->groups;
    }

    /**
     * Sets the groups to which this function applies.
     * @param string[] $groups
     */
    public function setGroups(array $groups): void
    {
        $this->groups = $groups;
    }

    /**
     * Returns the date when the function was last altered.
     * @return null|DateTime
     */
    public function getChanged(): ?DateTime
    {
        return $this->changed;
    }

    /**
     * Sets the date when the function was last altered
     * @param DateTime|string $date
     */
    public function setChanged(DateTime|string $date): void
    {
        $this->changed = is_string($date) ? new DateTime($date) : $date;
    }

    /**
     * A factory method that returns a new Contact object based on the content of an API call.
     * @param array $content
     * @return GroepsadminFunction
     */
    public static function fromApi(array $content): GroepsadminFunction
    {
        return self::loadFromApi(
            new GroepsadminFunction,
            [
                'id' => 'setId',
                'beschrijving' => 'setDescription',
                'type' => 'setType',
                'groepen' => 'setGroups',
                'aangepast' => 'setChanged'
            ],
            $content
        );
    }
}