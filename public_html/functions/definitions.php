<?
$upload_url = "uploads/";

$cdate = getdate();
$cyear = $cdate['year'];
$cmonth = $cdate['mon'];
$cday = $cdate['mday'];

$weekdays = array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");
$months = array(array("January",31),  array("February",28), array("March",31), array("April",30), array("May",31), array("June",30), array("July",31), array("August",31), array("September",30), array("October",31), array("November",30), array("December",31));

$user_types = array(
  "5" => "Resource Library Registration",
  "50" => "Licensee",
  "100" => "Administrator"
);
$RESOURCE_LIBRARY_UTID = "5";
$LICENSEE_UTID = "50";
$SITEADMIN_UTID = "100";

$user_status = array(
  "1" => "Active",
  "2" => "Suspended"
);
$STATUS_ACTIVE = 1;
$STATUS_SUSPENDED = 2;

//list of all available countries
$COUNTRIES = array(
  "AF"=>"Afghanistan",
  "AL"=>"Albania",
  "DZ"=>"Algeria",
  "AS"=>"American Samoa",
  "AD"=>"Andorra",
  "AO"=>"Angola",
  "AI"=>"Anguilla",
  "AQ"=>"Antarctica",
  "AG"=>"Antigua And Barbuda",
  "AR"=>"Argentina",
  "AM"=>"Armenia",
  "AW"=>"Aruba",
  "AU"=>"Australia",
  "AT"=>"Austria",
  "AZ"=>"Azerbaijan",
  "BS"=>"Bahamas",
  "BH"=>"Bahrain",
  "BD"=>"Bangladesh",
  "BB"=>"Barbados",
  "BY"=>"Belarus",
  "BE"=>"Belgium",
  "BZ"=>"Belize",
  "BJ"=>"Benin",
  "BM"=>"Bermuda",
  "BT"=>"Bhutan",
  "BO"=>"Bolivia",
  "BA"=>"Bosnia And Herzegovina",
  "BW"=>"Botswana",
  "BV"=>"Bouvet Island",
  "BR"=>"Brazil",
  "IO"=>"British Indian Ocean Territory",
  "BN"=>"Brunei Darussalam",
  "BG"=>"Bulgaria",
  "BF"=>"Burkina Faso",
  "BI"=>"Burundi",
  "KH"=>"Cambodia",
  "CM"=>"Cameroon",
  "CA"=>"Canada",
  "CV"=>"Cape Verde",
  "KY"=>"Cayman Islands",
  "CF"=>"Central African Republic",
  "TD"=>"Chad",
  "CL"=>"Chile",
  "CN"=>"China",
  "CX"=>"Christmas Island",
  "CC"=>"Cocos (keeling) Islands",
  "CO"=>"Colombia",
  "KM"=>"Comoros",
  "CG"=>"Congo",
  "CD"=>"Congo, The Democratic Republic Of The",
  "CK"=>"Cook Islands",
  "CR"=>"Costa Rica",
  "CI"=>"Cote D'ivoire",
  "HR"=>"Croatia",
  "CU"=>"Cuba",
  "CY"=>"Cyprus",
  "CZ"=>"Czech Republic",
  "DK"=>"Denmark",
  "DJ"=>"Djibouti",
  "DM"=>"Dominica",
  "DO"=>"Dominican Republic",
  "EC"=>"Ecuador",
  "EG"=>"Egypt",
  "SV"=>"El Salvador",
  "GQ"=>"Equatorial Guinea",
  "ER"=>"Eritrea",
  "EE"=>"Estonia",
  "ET"=>"Ethiopia",
  "FK"=>"Falkland Islands (malvinas)",
  "FO"=>"Faroe Islands",
  "FJ"=>"Fiji",
  "FI"=>"Finland",
  "FR"=>"France",
  "GF"=>"French Guiana",
  "PF"=>"French Polynesia",
  "TF"=>"French Southern Territories",
  "GA"=>"Gabon",
  "GM"=>"Gambia",
  "GE"=>"Georgia",
  "DE"=>"Germany",
  "GH"=>"Ghana",
  "GI"=>"Gibraltar",
  "GR"=>"Greece",
  "GL"=>"Greenland",
  "GD"=>"Grenada",
  "GP"=>"Guadeloupe",
  "GU"=>"Guam",
  "GT"=>"Guatemala",
  "GG"=>"Guernsey",
  "GN"=>"Guinea",
  "GW"=>"Guinea-bissau",
  "GY"=>"Guyana",
  "HT"=>"Haiti",
  "HM"=>"Heard Island And Mcdonald Islands",
  "VA"=>"Holy See (vatican City State)",
  "HN"=>"Honduras",
  "HK"=>"Hong Kong",
  "HU"=>"Hungary",
  "IS"=>"Iceland",
  "IN"=>"India",
  "ID"=>"Indonesia",
  "IR"=>"Iran, Islamic Republic Of",
  "IQ"=>"Iraq",
  "IE"=>"Ireland",
  "IM"=>"Isle Of Man",
  "IL"=>"Israel",
  "IT"=>"Italy",
  "JM"=>"Jamaica",
  "JP"=>"Japan",
  "JE"=>"Jersey",
  "JO"=>"Jordan",
  "KZ"=>"Kazakhstan",
  "KE"=>"Kenya",
  "KI"=>"Kiribati",
  "KP"=>"Korea, Democratic People's Republic Of",
  "KR"=>"Korea, Republic Of",
  "KW"=>"Kuwait",
  "KG"=>"Kyrgyzstan",
  "LA"=>"Lao People's Democratic Republic",
  "LV"=>"Latvia",
  "LB"=>"Lebanon",
  "LS"=>"Lesotho",
  "LR"=>"Liberia",
  "LY"=>"Libyan Arab Jamahiriya",
  "LI"=>"Liechtenstein",
  "LT"=>"Lithuania",
  "LU"=>"Luxembourg",
  "MO"=>"Macao",
  "MK"=>"Macedonia, The Former Yugoslav Republic Of",
  "MG"=>"Madagascar",
  "MW"=>"Malawi",
  "MY"=>"Malaysia",
  "MV"=>"Maldives",
  "ML"=>"Mali",
  "MT"=>"Malta",
  "MH"=>"Marshall Islands",
  "MQ"=>"Martinique",
  "MR"=>"Mauritania",
  "MU"=>"Mauritius",
  "YT"=>"Mayotte",
  "MX"=>"Mexico",
  "FM"=>"Micronesia, Federated States Of",
  "MD"=>"Moldova, Republic Of",
  "MC"=>"Monaco",
  "MN"=>"Mongolia",
  "MS"=>"Montserrat",
  "MA"=>"Morocco",
  "MZ"=>"Mozambique",
  "MM"=>"Myanmar",
  "NA"=>"Namibia",
  "NR"=>"Nauru",
  "NP"=>"Nepal",
  "NL"=>"Netherlands",
  "AN"=>"Netherlands Antilles",
  "NC"=>"New Caledonia",
  "NZ"=>"New Zealand",
  "NI"=>"Nicaragua",
  "NE"=>"Niger",
  "NG"=>"Nigeria",
  "NU"=>"Niue",
  "NF"=>"Norfolk Island",
  "MP"=>"Northern Mariana Islands",
  "NO"=>"Norway",
  "OM"=>"Oman",
  "PK"=>"Pakistan",
  "PW"=>"Palau",
  "PS"=>"Palestinian Territory, Occupied",
  "PA"=>"Panama",
  "PG"=>"Papua New Guinea",
  "PY"=>"Paraguay",
  "PE"=>"Peru",
  "PH"=>"Philippines",
  "PN"=>"Pitcairn",
  "PL"=>"Poland",
  "PT"=>"Portugal",
  "PR"=>"Puerto Rico",
  "QA"=>"Qatar",
  "RE"=>"Reunion",
  "RO"=>"Romania",
  "RU"=>"Russian Federation",
  "RW"=>"Rwanda",
  "SH"=>"Saint Helena",
  "KN"=>"Saint Kitts And Nevis",
  "LC"=>"Saint Lucia",
  "PM"=>"Saint Pierre And Miquelon",
  "VC"=>"Saint Vincent And The Grenadines",
  "WS"=>"Samoa",
  "SM"=>"San Marino",
  "ST"=>"Sao Tome And Principe",
  "SA"=>"Saudi Arabia",
  "SN"=>"Senegal",
  "CS"=>"Serbia And Montenegro",
  "SC"=>"Seychelles",
  "SL"=>"Sierra Leone",
  "SG"=>"Singapore",
  "SK"=>"Slovakia",
  "SI"=>"Slovenia",
  "SB"=>"Solomon Islands",
  "SO"=>"Somalia",
  "ZA"=>"South Africa",
  "GS"=>"South Georgia And The South Sandwich Islands",
  "ES"=>"Spain",
  "LK"=>"Sri Lanka",
  "SD"=>"Sudan",
  "SR"=>"Suriname",
  "SJ"=>"Svalbard And Jan Mayen",
  "SZ"=>"Swaziland",
  "SE"=>"Sweden",
  "CH"=>"Switzerland",
  "SY"=>"Syrian Arab Republic",
  "TW"=>"Taiwan, Province Of China",
  "TJ"=>"Tajikistan",
  "TZ"=>"Tanzania, United Republic Of",
  "TH"=>"Thailand",
  "TL"=>"Timor-leste",
  "TG"=>"Togo",
  "TK"=>"Tokelau",
  "TO"=>"Tonga",
  "TT"=>"Trinidad And Tobago",
  "TN"=>"Tunisia",
  "TR"=>"Turkey",
  "TM"=>"Turkmenistan",
  "TC"=>"Turks And Caicos Islands",
  "TV"=>"Tuvalu",
  "UG"=>"Uganda",
  "UA"=>"Ukraine",
  "AE"=>"United Arab Emirates",
  "GB"=>"United Kingdom",
  "US"=>"United States",
  "UM"=>"United States Minor Outlying Islands",  
  "UY"=>"Uruguay",
  "UZ"=>"Uzbekistan",
  "VU"=>"Vanuatu",
  "VE"=>"Venezuela",
  "VN"=>"Viet Nam",
  "VG"=>"Virgin Islands, British",
  "VI"=>"Virgin Islands, U.s.",
  "WF"=>"Wallis And Futuna",
  "EH"=>"Western Sahara",
  "YE"=>"Yemen",
  "ZM"=>"Zambia",
  "ZW"=>"Zimbabwe"
);

//states/provinces list for US.
//the format is:  "<value in database>"=>"<value user sees on website>"
$STATES = array(
  "AL"=>"Alabama",
  "AZ"=>"Arizona ",
  "AR"=>"Arkansas",
  "CA"=>"California ",
  "CO"=>"Colorado ",
  "CT"=>"Connecticut",
  "DE"=>"Delaware",
  "DC"=>"District Of Columbia",
  "FL"=>"Florida",
  "GA"=>"Georgia",
  "ID"=>"Idaho",
  "IL"=>"Illinois",
  "IN"=>"Indiana",
  "IA"=>"Iowa",
  "KS"=>"Kansas",
  "KY"=>"Kentucky",
  "LA"=>"Louisiana",
  "ME"=>"Maine",
  "MD"=>"Maryland",
  "MA"=>"Massachusetts",
  "MI"=>"Michigan",
  "MN"=>"Minnesota",
  "MS"=>"Mississippi",
  "MO"=>"Missouri",
  "MT"=>"Montana",
  "NE"=>"Nebraska",
  "NV"=>"Nevada",
  "NH"=>"New Hampshire",
  "NJ"=>"New Jersey",
  "NM"=>"New Mexico",
  "NY"=>"New York",
  "NC"=>"North Carolina",
  "ND"=>"North Dakota",
  "OH"=>"Ohio",
  "OK"=>"Oklahoma",
  "OR"=>"Oregon",
  "PA"=>"Pennsylvania",
  "RI"=>"Rhode Island",
  "SC"=>"South Carolina",
  "SD"=>"South Dakota",
  "TN"=>"Tennessee",
  "TX"=>"Texas",
  "UT"=>"Utah",
  "VT"=>"Vermont",
  "VA"=>"Virginia ",
  "WA"=>"Washington",
  "WV"=>"West Virginia",
  "WI"=>"Wisconsin",
  "WY"=>"Wyoming",
  "AA"=>"Armed Forces Americas",
  "AP"=>"Armed Forces Pacific",
  "AE"=>"Armed Forces"
);


$CANADA_PROVINCES = array(
	"Alberta"=>"Alberta", 
	"British Columbia"=>"British Columbia",
	"New Brunswick"=>"New Brunswick",
	"Newfoundland"=>"Newfoundland",
	"Northwest Territories"=>"Northwest Territories",
	"Nova Scotia"=>"Nova Scotia",
	"Ontario"=>"Ontario",
	"Prince Edward Island"=>"Prince Edward Island",
	"Quebec"=>"Quebec",
	"Saskatchewan"=>"Saskatchewan",
  "Yukon Territory"=>"Yukon Territory"
);

$IRISH_STATES = array(
  "1" => "Co. Carlow",
  "2" => "Co. Cavan",
  "3" => "Co. Clare",
  "4" => "Co. Cork",
  "5" => "Co. Donegal",
  "6" => "Co. Dublin",
  "7" => "Co. Galway",
  "8" => "Co. Kerry",
  "9" => "Co. Kildare",
  "10" => "Co. Kilkenny",
  "11" => "Co. Laois",
  "12" => "Co. Leitrim",
  "13" => "Co. Limerick",
  "14" => "Co. Longford",
  "15" => "Co. Louth",
  "16" => "Co. Mayo",
  "17" => "Co. Meath",
  "18" => "Co. Monaghan",
  "19" => "Co. Offaly",
  "20" => "Co. Roscommon",
  "21" => "Co. Sligo",
  "22" => "Co. Tipperary",
  "23" => "Co. Waterford",
  "24" => "Co. Westmeath",
  "25" => "Co. Wexfordt",
  "26" => "Co. Wicklow"
);

$CMS_TEMPLATES = array(
  "template1.php" => "Template 1",
  "template2.php" => "Template 2"
);

$HEAD_UNITS = array(
  1 => "Inch",
  2 => "Metric",
  3 => "DIN 933",
  4 => "Index",
  5 => "Inch & Metric"
);

$email_from = 'noreply@phillips-screw.com';
$change_reporting_to = "kbowse@phillips-screw.com,ddeziel@brandfocus.us";

$timeline = array(
  array("year"=>"1933", "image"=>"images/tl/tl1933.jpg"),
  array("year"=>"1934", "image"=>"images/tl/tl1934.jpg"),
  array("year"=>"1935", "image"=>"images/tl/tl1935.jpg"),
  array("year"=>"1936", "image"=>"images/tl/tl1936.jpg"),
  array("year"=>"1937", "image"=>"images/tl/tl1937.jpg"),
  array("year"=>"1939", "image"=>"images/tl/tl1939.jpg"),
  array("year"=>"1945", "image"=>"images/tl/tl1945.jpg"),
  array("year"=>"1949", "image"=>"images/tl/tl1949.jpg"),
  array("year"=>"1958", "image"=>"images/tl/tl1958.jpg"),
  array("year"=>"1966", "image"=>"images/tl/tl1966.jpg"),
  array("year"=>"1977", "image"=>"images/tl/tl1977.jpg"),
  array("year"=>"1978", "image"=>"images/tl/tl1978.jpg"),
  array("year"=>"1984", "image"=>"images/tl/tl1984.jpg"),
  array("year"=>"1993", "image"=>"images/tl/tl1993.jpg"),
  array("year"=>"1996", "image"=>"images/tl/tl1996.jpg"),
  array("year"=>"1997", "image"=>"images/tl/tl1997.jpg"),
  array("year"=>"1998", "image"=>"images/tl/tl1998.jpg"),
  array("year"=>"1999", "image"=>"images/tl/tl1999.jpg"),
  array("year"=>"2004", "image"=>"images/tl/tl2004.jpg"),
  array("year"=>"2010", "image"=>"images/tl/tl2010a.jpg"),
  array("year"=>"2010", "image"=>"images/tl/tl2010b.jpg"),
  array("year"=>"2011", "image"=>"images/tl/tl2011.jpg")
);

$DOCUMENT_TYPES = array(
  "R" => "Resource Library",
  "L" => "Licensees Only"
);

$DOCUMENT_LANGUAGES = array(
  "1" => "English",
  "2" => "French",
  "3" => "Deutsch",
  "4" => "Espa&#241;ol",
  "5" => "&#54620;&#44397;&#50612;&#51032;"
);

$DOCUMENT_CATEGORIES = array(
  "R" => array(
    "2" => array(
      "name" => "Head Standards",
      "title" => "PRECISE HEAD STANDARDS FOR PRECISION ENGINEERING",
      "categories" => array()
    ),
    "1" => array(
      "name" => "Brochures",
      "title" => "PHILLIPS SCREW COMPANY BROCHURES",
      "categories" => array()
    ),
    "4" => array(
      "name" => "Data Sheets",
      "title" => "PHILLIPS SCREW COMPANY DATA SHEETS",
      "categories" => array()
    ),    
    "3" => array(
      "name" => "Video Library",
      "title" => "PHILLIPS SCREW COMPANY VIDEO LIBRARY",
      "categories" => array()
    )
  ),
  "L" => array(
    "2" => array(
      "name" => "Marketing Support",
      "categories" => array(
        "1" => array(
          "name" => "Brand Guidelines"),
        "2" => array(
          "name" => "Logos",
          "categories" => array(
            "1" => array(
              "name" => "Phillips Screw Company Logos"),
            "2" => array(
              "name" => "Specify Genuine Phillips Drive Systems Logos")
          )
        ),
        "3" => array(
          "name" => "Brochures",
          "visibleAdmin" => false),
        "4" => array(
          "name" => "Data Sheets",
          "visibleAdmin" => false),
        "5" => array(
          "name" => "Drive System Images")
      )
    ),
    "1" => array(
      "name" => "Technical Manuals",
      "title" => "TECHNICAL MANUALS",
      "categories" => array()
    )
  )
);

$DOCUMENT_FORMATS = array(
  "L" => "Lo-Res PDF",
  "H" => "Hi-Res PDF",
  "E" => "Hi-Res EPS",
  "J" => "Lo-Res JPG",
  "K" => "Hi-Res JPG"
);
?>