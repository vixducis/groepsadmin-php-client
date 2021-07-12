<?php declare(strict_types=1);

namespace Wouterh\GroepsadminClient\Model;

class Contact
{
    use LoadFromApiTrait;

    protected ?string $id =  null;
    protected ?string $firstname = null;
    protected ?string $lastname = null;
    protected ?string $role = null;
    protected ?Address $address = null;
    protected ?PhoneNumber $mobile = null;
    protected ?string $mail = null;

    /**
     * Returns the contact's groepsadmin ID
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Sets the contact's groepsadmin ID
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * Returns the first name of the contact.
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->firstname;
    }

    /**
     * Sets the first name of the contact.
     * @param string $name
     */
    public function setFirstName(string $name): void
    {
        $this->firstname = $name;
    }

    /**
     * Returns the last name of the contact
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->lastname;
    }

    /**
     * Sets the last name of the contact.
     * @param string $name
     */
    public function setLastName(string $name): void
    {
        $this->lastname = $name;
    }

    /**
     * Returns the contact's email address.
     * @return string|null
     */
    public function getMail(): ?string
    {
        return $this->mail;
    }

    /**
     * Sets the contact's email address
     * @param string $mail
     */
    public function setMail(string $mail): void
    {
        $this->mail = $mail;
    }

    /**
     * Returns the contact's mobile phone number.
     * @return PhoneNumber|null
     */
    public function getMobilePhone(): ?PhoneNumber
    {
        return $this->mobile;
    }

    /**
     * Sets the contact's mobile phone number
     * @param string|PhoneNumber $number
     */
    public function setMobilePhone(string|PhoneNumber $number): void
    {
        $this->mobile = $number instanceof PhoneNumber
            ? $number
            : new PhoneNumber($number);
    }

    /**
     * Returns the role of the contact
     * @return string|null
     */
    public function getRole(): ?string
    {
        return $this->role;
    }

    /**
     * Sets the role of the contact
     * @param string $role
     */
    public function setRole(string $role): void
    {
        $this->role = $role;
    }

    /**
     * Sets the address of the contact.
     * @param Address $address
     */
    public function setAddress(Address $address): void
    {
        $this->address = $address;
    }

    /**
     * A factory method that returns a new Contact object based on the content of an API call.
     * @param array $content
     * @param Address[] $addresses Possible addresses to match the address id to.
     */
    public static function fromApi(array $content, array $addresses = []): Contact
    {
        $contact = self::loadFromApi(
            new Contact,
            [
                'id' => 'setId',
                'voornaam' => 'setFirstName',
                'achternaam' => 'setLastName',
                'rol' => 'setRole',
                'gsm' => 'setMobilePhone',
                'email' => 'setMail'
            ],
            $content
        );
        
        // check if the address id was present on the api response
        // if it is, loop over the addresses and set the matching one
        if (array_key_exists('adres', $content)) {
            foreach($addresses as $address) {
                if ($content['adres'] === $address->getId()) {
                    $contact->setAddress($address);
                    break;
                }
            }
        }
        return $contact;
    }
}
