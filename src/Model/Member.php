<?php declare(strict_types=1);

namespace Wouterh\GroepsadminClient\Model;

use DateTime;

class Member
{
    use LoadFromApiTrait;

    protected ?string $id = null;
    protected ?string $firstname = null;
    protected ?string $lastname = null;
    protected ?string $mail = null;
    protected ?PhoneNumber $mobile = null;
    protected ?PhoneNumber $phone = null;
    protected ?DateTime $birthDate = null;
    protected ?string $memberNumber = null;
    protected array $addresses = []; 
    protected array $contacts = [];

    /**
     * Returns the member's groepsadmin ID
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Sets the member's groepsadmin ID
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * Returns the first name of the member.
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->firstname;
    }

    /**
     * Sets the first name of the member.
     * @param string $name
     */
    public function setFirstName(string $name): void 
    {
        $this->firstname = $name;
    }

    /**
     * Returns the last name of the member
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->lastname;
    }

    /**
     * Sets the last name of the member.
     * @param string $name
     */
    public function setLastName(string $name): void
    {
        $this->lastname = $name;
    }

    /** 
     * Returns the member's email address.
     * @return string|null
     */
    public function getMail(): ?string
    {
        return $this->mail;
    }

    /**
     * Sets the member's email address
     * @param string $mail
     */
    public function setMail(string $mail): void
    {
        $this->mail = $mail;
    }

    /**
     * Returns the member's mobile phone number.
     * @return PhoneNumber|null
     */
    public function getMobilePhone(): ?PhoneNumber
    {
        return $this->mobile;
    }

    /**
     * Sets the member's mobile phone number
     * @param string|PhoneNumber $number
     */
    public function setMobilePhone(string|PhoneNumber $number): void
    {
        $this->mobile = $number instanceof PhoneNumber
            ? $number
            : new PhoneNumber($number);
    }

    /**
     * Returns the member's landline number.
     * @return PhoneNumber|null
     */
    public function getPhone(): ?PhoneNumber
    {
        return $this->phone;
    }

    /**
     * Sets the member's landline number
     * @param string|PhoneNumber $number
     */
    public function setPhone(string|PhoneNumber $number): void
    {
        $this->phone = $number instanceof PhoneNumber
            ? $number
            : new PhoneNumber($number);
    }

    /**
     * Returns the member's birth date.
     * @return DateTime|null 
     */
    public function getBirthDate(): ?DateTime
    {
        return $this->birthDate;
    }
    
    /**
     * Sets the member's birth date.
     * @param string|DateTime $date
     */
    public function setBirthDate(string|DateTime $date): void
    {
        if ($date instanceof DateTime) {
            $this->birthDate = $date;
        } else {
            $this->birthDate = new DateTime($date);
            /*
            $dateComponents = explode('/', $date);
            $this->birthDate->setDate(
                (int)$dateComponents[2],
                (int)$dateComponents[1],
                (int)$dateComponents[0],
            );
            */
            $this->birthDate->setTime(12, 0);
        }
    }

    /**
     * Returns the member number.
     * @return string|null
     */
    public function getMemberNumber(): ?string
    {
        return $this->memberNumber;
    }

    /**
     * Sets the member number of the member.
     * @param string $number
     */
    public function setMemberNumber(string $number): void
    {
        $this->memberNumber = $number;
    }

    /**
     * Returns the addresses for the member
     * @return Address[]
     */
    public function getAddresses(): array
    {
        return $this->addresses;
    }

    /**
     * Sets the addresses of the member
     * @param Address[]|array $addresses
     */
    public function setAddresses(array $addresses): void
    {
        $this->addresses = [];
        foreach ($addresses as $address) {
            if (!$address instanceof Address) {
                $address = Address::fromApi($address);
            }
            $this->addresses[] = $address;
        }
    }

    /**
     * Sets the contacts of the member
     * @param Contact[]|array $contacts
     */
    public function setContacts(array $contacts): void
    {
        $this->contacts = [];
        foreach ($contacts as $contact) {
            if (!$contact instanceof Contact) {
                $contact = Contact::fromApi($contact, $this->getAddresses());
            }
            $this->contacts[] = $contact;
        }
    }

    /**
     * Factory method that creates a new member from an API call
     * @param array $content The content of the API call
     * @param array $format An array that mimics the layout of the API response where the values are the names of the setter functions. Indexes should not contain any prefixes (like vvksm.) or the 'Column' postfix. Matching is done case-insensitive.
     * @return Member
     */
    public static function fromApi(array $content, array $format): Member
    {
        return self::loadFromApi(new Member, $format, $content);
    }
}
