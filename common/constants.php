<?php
// constants for server stats page by Ty_ger07 at http://open-web-community.com/

// DON'T EDIT ANYTHING BELOW UNLESS YOU KNOW WHAT YOU ARE DOING

// make an array of game modes
$mode_array = array(
	'Air Superiority'	=>	'AirSuperiority0',
	'Capture The Flag'	=>	'CaptureTheFlag0',
	'Team Deathmatch'	=>	'TeamDeathMatch0',
	'Domination'		=>	'Domination0',
	'Defuse'			=>	'Elimination0',
	'Obliteration'		=>	'Obliteration',
	'Tank Superiority'	=>	'TankSuperiority0',
	'Rush'				=>	'RushLarge0',
	'Conquest Large'	=>	'ConquestLarge0',
	'Conquest Small'	=>	'ConquestSmall0',
	'Squad Deathmatch'	=>	'SquadDeathMatch0'
	// note comma between each line but no comma at the end
);

// make an array of map names
$map_array = array(
	'Zavod 311'				=>	'MP_Abandoned',
	'Lancang Dam'			=>	'MP_Damage',
	'Flood Zone'			=>	'MP_Flooded',
	'Golmud Railway'		=>	'MP_Journey',
	'Paracel Storm'			=>	'MP_Naval',
	'Operation Locker'		=>	'MP_Prison',
	'Hainan Resort'			=>	'MP_Resort',
	'Siege of Shanghai'		=>	'MP_Siege',
	'Rogue Transmission'	=>	'MP_TheDish',
	'Dawnbreaker'			=>	'MP_Tremors',
	'Silk Road'				=>	'XP1_001',
	'Altai Range'			=>	'XP1_002',
	'Guilin Peaks'			=>	'XP1_003',
	'Dragon Pass'			=>	'XP1_004',
	'Caspian Border'		=>	'XP0_Caspian',
	'Firestorm'				=>	'XP0_Firestorm',
	'Operation Metro'		=>	'XP0_Metro',
	'Gulf Of Oman'			=>	'XP0_Oman'
	// note comma between each line but no comma at the end
);

// make an array of squad names
// i am not going to separate these into lines since these shouldn't change and don't need to be legible
// this is just the phonetic alphabet
$squad_array = array('None'=>'0','Alpha'=>'1','Bravo'=>'2','Charlie'=>'3','Delta'=>'4','Echo'=>'5','Foxtrot'=>'6','Golf'=>'7','Hotel'=>'8','India'=>'9','Juliet'=>'10','Kilo'=>'11','Lima'=>'12','Mike'=>'13','November'=>'14','Oscar'=>'15','Papa'=>'16','Quebec'=>'17','Romeo'=>'18','Sierra'=>'19','Tango'=>'20','Uniform'=>'21','Victor'=>'22','Whiskey'=>'23','X-Ray'=>'24','Yankee'=>'25','Zulu'=>'26');

// make an array of country names
// i am not going to separate these into lines since these shouldn't change and don't need to be legible
// this is just a (long!) list of country codes
// this took a long time to type out!
$country_array = array('Null'=>'','Unknown'=>'--','Afghanistan'=>'AF','Albania'=>'AL','Algeria'=>'DZ','American Samoa'=>'AS','Andorra'=>'AD','Angola'=>'AO','Anguilla'=>'AI','Antarctica'=>'AQ','Antigua'=>'AG','Argentina'=>'AR','Armenia'=>'AM','Aruba'=>'AW','Australia'=>'AU','Austria'=>'AT','Azerbaijan'=>'AZ','Bahamas'=>'BS','Bahrain'=>'BH','Bangladesh'=>'BD','Barbados'=>'BB','Belarus'=>'BY','Belgium'=>'BE','Belize'=>'BZ','Benin'=>'BJ','Bermuda'=>'BM','Bhutan'=>'BT','Bolivia'=>'BO','Bosnia'=>'BA','Botswana'=>'BW','Bouvet Island'=>'BV','Brazil'=>'BR','Indian Ocean'=>'IO','Brunei Darussalum'=>'BN','Bulgaria'=>'BG','Burkina Faso'=>'BF','Burundi'=>'BI','Cambodia'=>'KH','Cameroon'=>'CM','Canada'=>'CA','Cape Verde'=>'CV','Cayman Islands'=>'KY','Central Africa'=>'CF','Chad'=>'TD','Chile'=>'CL','China'=>'CN','Christmas Island'=>'CX','Cocos Islands'=>'CC','Columbia'=>'CO','Comoros'=>'KM','Congo'=>'CG','Republic of Congo'=>'CD','Cook Islands'=>'CK','Costa Rica'=>'CR','Ivory Coast'=>'CI','Croatia'=>'HR','Cuba'=>'CU','Cyprus'=>'CY','Czech Repuplic'=>'CZ','Denmark'=>'DK','Djibouti'=>'DJ','Dominica'=>'DM','Dominican Republic'=>'DO','East Timor'=>'TP','Ecuador'=>'EC','Egypt'=>'EG','El Salvador'=>'SV','Equatorial Guinea'=>'GQ','Eritrea'=>'ER','Estonia'=>'EE','Ethiopia'=>'ET','Falkland Islands'=>'FK','Faroe Islands'=>'FO','Fiji'=>'FJ','Finland'=>'FI','France'=>'FR','Metropolitan France'=>'FX','French Guiana'=>'GF','French Polynesia'=>'PF','French Territories'=>'TF','Gabon'=>'GA','Gambia'=>'GM','Georgia'=>'GE','Germany'=>'DE','Ghana'=>'GH','Gibraltar'=>'GI','Greece'=>'GR','Greenland'=>'GL','Grenada'=>'GD','Guadeloupe'=>'GP','Guam'=>'GU','Guatemala'=>'GT','Guernsey'=>'GG','Guinea'=>'GN','Guinea-Bissau'=>'GW','Guyana'=>'GY','Haiti'=>'HT','McDonald Islands'=>'HM','Vatican City'=>'VA','Honduras'=>'HN','Hong Kong'=>'HK','Hungary'=>'HU','Iceland'=>'IS','India'=>'IN','Indonesia'=>'ID','Iran'=>'IR','Iraq'=>'IQ','Ireland'=>'IE','Israel'=>'IL','Italy'=>'IT','Jamaica'=>'JM','Japan'=>'JP','Jordan'=>'JO','Kazakstan'=>'KZ','Kenya'=>'KE','Kiribati'=>'KI','North Korea'=>'KP','South Korea'=>'KR','Kuwait'=>'KW','Kyrgyzstan'=>'KG','Lao'=>'LA','Latvia'=>'LV','Lebanon'=>'LB','Lesotho'=>'LS','Liberia'=>'LR','Libya'=>'LY','Liechtenstein'=>'LI','Lithuania'=>'LT','Luxembourg'=>'LU','Macau'=>'MO','Macedonia'=>'MK','Madagascar'=>'MG','Malawi'=>'MW','Malaysia'=>'MY','Maldives'=>'MV','Mali'=>'ML','Malta'=>'MT','Marshall Islands'=>'MH','Martinique'=>'MQ','Mauritania'=>'MR','Mauritius'=>'MU','Mayotte'=>'YT','Mexico'=>'MX','Micronesia'=>'FM','Moldova'=>'MD','Monaco'=>'MC','Mongolia'=>'MN','Montserrat'=>'MS','Morocco'=>'MA','Mozambique'=>'MZ','Myanmar'=>'MM','Namibia'=>'NA','Nauru'=>'NR','Nepal'=>'NP','Netherlands'=>'NL','Netherlands Antilles'=>'AN','New Caledonia'=>'NC','New Zealand'=>'NZ','Nicaragua'=>'NI','Niger'=>'NE','Nigeria'=>'NG','Niue'=>'NU','Norfolk Island'=>'NF','Mariana Islands'=>'MP','Norway'=>'NO','Oman'=>'OM','Pakistan'=>'PK','Palau'=>'PW','Palestine'=>'PS','Panama'=>'PA','Papua New Guinea'=>'PG','Paraguay'=>'PY','Peru'=>'PE','Philippines'=>'PH','Pitcairn'=>'PN','Poland'=>'PL','Portugal'=>'PT','Puerto Rico'=>'PR','Qatar'=>'QA','Reunion'=>'RE','Romania'=>'RO','Russia'=>'RU','Rwanda'=>'RW','Saint Helena'=>'SH','Saint Kitts'=>'KN','Saint Lucia'=>'LC','Saint Pierre'=>'PM','Saint Vincent'=>'VC','Samoa'=>'WS','San Marino'=>'SM','Sao Tome'=>'ST','Saudi Arabia'=>'SA','Senegal'=>'SN','Seychelles'=>'SC','Sierra Leone'=>'SL','Singapore'=>'SG','Slovakia'=>'SK','Slovenia'=>'SI','Solomon Islands'=>'SB','Somalia'=>'SO','South Africa'=>'ZA','Sandwich Islands'=>'GS','Spain'=>'ES','Sri Lanka'=>'LK','Sudan'=>'SD','Suriname'=>'SR','Svalbard'=>'SJ','Swaziland'=>'SZ','Sweden'=>'SE','Switzerland'=>'CH','Syria'=>'SY','Taiwan'=>'TW','Tajikistan'=>'TJ','Tanzania'=>'TZ','Thailand'=>'TH','Togo'=>'TG','Tokelau'=>'TK','Tonga'=>'TO','Trinidad'=>'TT','Tunisia'=>'TN','Turkey'=>'TR','Turkmenistan'=>'TM','Turks Islands'=>'TC','Tuvalu'=>'TV','Uganda'=>'UG','Ukraine'=>'UA','United Arab Emirates'=>'AE','United Kingdom'=>'GB','United States'=>'US','US Minor Outlying Islands'=>'UM','Uruguay'=>'UY','Uzbekistan'=>'UZ','Vanuatu'=>'VU','Venezuela'=>'VE','Vietnam'=>'VN','Virgin Islands (British)'=>'VG','Virgin Islands (US)'=>'VI','Wallis and Futuna'=>'WF','Western Sahara'=>'EH','Yemen'=>'YE','Yugoslavia'=>'YU','Zambia'=>'ZM','Zimbabwe'=>'ZW');

?>