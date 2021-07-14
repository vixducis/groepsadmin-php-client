<?php declare(strict_types=1);

namespace Wouterh\GroepsadminClient\Model;

class PhoneNumber
{
    private bool $mobile = false;
    private ?string $number = null;

    private const LARGE_ZONES =	['010', '011', '012', '013', '014', '015', '016', '019', '050', '051', '052', '053', '054', '055', '056', '057', '058', '059', '060', '061', '063', '064', '065', '067', '068', '069', '071', '080', '081', '082', '083', '084', '085', '086', '087', '089'];
    private const SMALL_ZONES = ['02', '03', '04', '09'];

    public function __construct(string $number)
    {
        if (strlen($number)) {
            $number = trim($number);
        
            // if the international format is used, + or ++ can be used as a prefix
            // if only a single + is used, prepend a second
            if ($number[0] == '+' && $number[1] != '+') {
                $number = '+' . $number;
            }
        
            // replace all special characters with spaces and + signs with zeros
            $number = strtr($number, '+/-.', '0   ');
        
            // remove spaces
            $number = str_replace(' ', '', $number);
        
            // check if number starts with 0032, if so replace by 0
            if (substr($number, 0, 4) === '0032') {
                $number = '0' . substr($number, 4);
            }
        
            // check if the number is a mobile one
            if (substr($number, 0, 2) === '04') {
                $this->mobile = true;
            }
            $this->number = $number;
        }
    }

    /**
	 * Gets the number in a format to your liking.
	 * @param bool $countryCode (optional) Whether to include the country code, false by default.
	 * @param string $zoneSeparator A string that should be used to separate the zone and the rest of the number
	 * @param string $groupSeparator A string that will be used to separate the groups in the number
	 * @return string
	 */
	public function getFormatted(
        ?string $countryCode = null, 
        string $zoneSeparator = '', 
        string $groupSeparator = ''
    ): string {
		if($this->number === null || strlen($this->number) <= 0) {
			return '';
		}
		
		if ($this->mobile) {
			$zone = substr($this->number, 0, 4);
			$group1 = substr($this->number, 4, 2);
			$group2 = substr($this->number, 6, 2);
			$group3 = substr($this->number, 8, 2);
		} else {
            //if this number is in a large zone
			if(in_array(substr($this->number, 0, 2), self::SMALL_ZONES)) {
				$zone = substr($this->number, 0, 2);
				$group1 = substr($this->number, 2, 3);
			}
			else {
				$zone = substr($this->number, 0, 3);
				$group1 = substr($this->number, 3, 2);
			}
			
			$group2 = substr($this->number, 5, 2);
			$group3 = substr($this->number, 7, 2);
		}
		
		if($countryCode !== null) {
			$zone = $countryCode . substr($zone,1);
		}
		
		return $zone 
            . $zoneSeparator 
            . $group1 
            . $groupSeparator 
            . $group2 
            . $groupSeparator 
            . $group3;
	}
}