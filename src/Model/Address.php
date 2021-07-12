<?php declare(strict_types=1);

namespace Wouterh\GroepsadminClient\Model;

class Address
{
    use LoadFromApiTrait;

    protected ?string $id = null;
    protected ?string $country = null;
    protected ?string $zipcode = null;
    protected ?string $city = null;
    protected ?string $street = null;
    protected ?string $number = null;
    protected ?string $bus = null;
    protected ?PhoneNumber $phone = null;

    /**
     * Returns the address id.
     * @return string|null
     */ 
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * Sets the address ID
     * @param string $id
     */ 
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * Returns the country of the address
     * @return string|null
     */
    public function getCountry(): ?string 
    {
        return $this->country;
    }

    /**
     * Sets the 2 letter country code of the address
     * @param string $country
     */
    public function setCountry(string $country): void
    {
        $this->country = $country;
    }

    /**
     * Returns the zipcode of the address
     * @return string|null
     */
    public function getZipcode(): ?string
    {
        return $this->zipcode;
    }

    /**
     * Sets the zipcode of the address
     * @param string $zipcode
     */
    public function setZipcode(string $zipcode): void
    {
        $this->zipcode = $zipcode;
    }

    /**
     * Returns the city of the address
     * @return string|null
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * Sets the city of the address
     * @param string $city
     */
    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    /**
     * Returns the street name of the address.
     * @return string|null
     */
    public function getStreet(): ?string
    {
        return $this->street;
    }

    /** 
     * Sets the street name of the address
     * @param string $street
     */
    public function setStreet(string $street): void
    {
        $this->street = $street;
    }

    /**
     * Returns the house number of the address
     * @return string|null
     */
    public function getNumber(): ?string
    {
        return $this->number;
    }

    /**
     * Sets the house number of the address.
     * @param string $number
     */
    public function setNumber(string $number): void
    {
        $this->number = $number;
    }

    /**
     * Returns the bus number of the address.
     * @return string|null
     */
    public function getBus(): ?string
    {
        return $this->bus;
    }

    /**
     * Sets number of the bus
     * @param string $bus
     */
    public function setBus(string $bus): void
    {
        $this->bus = $bus;
    }

    /**
     * Returns the phone number of the address.
     * @return PhoneNumber|null
     */
    public function getPhoneNumber(): ?PhoneNumber
    {
        return $this->phone;
    }

    /**
     * Sets the phone number of the address.
     * @param PhoneNumber|string
     */
    public function setPhoneNumber(string|PhoneNumber $number): void
    {
        $this->phone = $number instanceof PhoneNumber
            ? $number
            : new PhoneNumber($number);
    }

    /**
     * A factory method that returns a new Address object based on the content of an API call.
     * @param array $content
     */
    public static function fromApi(array $content): Address
    {
        return self::loadFromApi(
            new Address,
            [
                'id' => 'setId',
                'land' => 'setCountry',
                'postcode' => 'setZipcode',
                'gemeente' => 'setCity',
                'straat' => 'setStreet',
                'nummer' => 'setNumber',
                'bus' => 'setBus',
                'telefoon' => 'setPhoneNumber',
            ],
            $content
        );
    }
}
