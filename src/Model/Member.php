<?php declare(strict_types=1);

namespace Wouterh\GroepsadminClient\Model;

use DateTime;

class Member
{
    private ?string $id = null;
    private ?string $firstname = null;
    private ?string $lastname = null;
    private ?string $mail = null;
    private ?PhoneNumber $mobile = null;
    private ?PhoneNumber $phone = null;
    private ?DateTime $birthDate = null;
    private ?string $AddressLine1 = null;
    private ?string $memberNumber = null;

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
            $this->birthDate = new DateTime();
            $dateComponents = explode('/', $date);
            $this->birthDate->setDate(
                (int)$dateComponents[2],
                (int)$dateComponents[1],
                (int)$dateComponents[0],
            );
            $this->birthDate->setTime(12, 0);
        }
    }

    /**
     * Returns the first line of the member's home address.
     * @return string|null
     */
    public function getAddressLine1(): ?string
    {
        return $this->AddressLine1;
    }

    /**
     * Sets the first line of the member's home address.
     * @param string $address
     */
    public function setAddressLine1(string $address): void
    {
        $this->AddressLine1 = $address;
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
     * Factory method that creates a new member from the content of an API call.
     * @param array $content
     * @return Member
     */
    public static function fromApi(array $content): Member
    {
        $member = new Member;
        $member->setId($content['id']);

        if (array_key_exists('waarden', $content)) {
            // map the values in the api content to setters
            $translationFunctions = [
                'gsm' => 'setMobilePhone',
                'geboortedatum' => 'setBirthDate',
                'email' => 'setMail',
                'achternaam' => 'setLastName',
                'telefoon' => 'setPhone',
                'voornaam' => 'setFirstName',
                'straat' => 'setAddressLine1',
                'lidnummer' => 'setMemberNumber',
            ];

            foreach($content['waarden'] as $key => $value) {
                $keyParts = explode('.', $key);
                $key = array_pop($keyParts);
                $key = strtolower(preg_replace('/Column$/', '', $key));
                if (array_key_exists($key, $translationFunctions)) {
                    $function = $translationFunctions[$key];
                    $member->$function($value);
                }
            }
        }

        return $member;
    }
}
