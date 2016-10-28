<?php
/*
Module Joomla! 3.x Native Component
@version: 1.0.0
@author: Tadele Meshesha 
@link:http://he-il.joomla.com/jewishcalendar
@license GPL2
//////////////////////////////////////////////////////////
This code was built using the web site:
http://www.david-greve.de/luach-code/jewish-php.html
Source code Copyright © by Ulrich and David Greve (2005)
*/
///////////////////////////////////////////////////////////////
defined( '_JEXEC' ) or die;
class getTorah
{
	private static $ID_BERESHITH                   = 0;
	private static $ID_NOAH                        = 1;
	private static $ID_LEHLEHA                     = 2;
	private static $ID_VAYERA                      = 3;
	private static $ID_HAYESARAH                   = 4;
	private static $ID_TOLEDOTH                    = 5;
	private static $ID_VAYETSE                     = 6;
	private static $ID_VAYISHLAH                   = 7;
	private static $ID_VAYESHEB                    = 8;
	private static $ID_MIKKETS                     = 9;
	private static $ID_VAYIGGASH                  = 10;
	private static $ID_VAYHEE                     = 11;
	private static $ID_SHEMOTH                    = 12;
	private static $ID_VAERA                      = 13;
	private static $ID_BO                         = 14;
	private static $ID_BESHALLAH                  = 15;
	private static $ID_YITHRO                     = 16;
	private static $ID_MISHPATIM                  = 17;
	private static $ID_TERUMAH                    = 18;
	private static $ID_TETSAVVEH                  = 19;
	private static $ID_KITISSA                    = 20;
	private static $ID_VAYAKHEL                   = 21;
	private static $ID_PEKUDE                     = 22;
	private static $ID_VAYIKRA                    = 23;
	private static $ID_TSAV                       = 24;
	private static $ID_SHEMINI                    = 25;
	private static $ID_TAZRIANG                   = 26;
	private static $ID_METSORANG                  = 27;
	private static $ID_AHAREMOTH                  = 28;
	private static $ID_KEDOSHIM                   = 29;
	private static $ID_EMOR                       = 30;
	private static $ID_BEHAR                      = 31;
	private static $ID_BEHUKKOTHAI                = 32;
	private static $ID_BEMIDBAR                   = 33;
	private static $ID_NASO                       = 34;
	private static $ID_BEHAALOTEHA                = 35;
	private static $ID_SHELAHLEHA                 = 36;
	private static $ID_KORAH                      = 37;
	private static $ID_HUKATH                     = 38;
	private static $ID_BALAK                      = 39;
	private static $ID_PINHAS                     = 40;
	private static $ID_MATOTH                     = 41;
	private static $ID_MASEH                      = 42;
	private static $ID_DEBARIM                    = 43;
	private static $ID_VAETHANAN                  = 44;
	private static $ID_EKEB                       = 45;
	private static $ID_REEH                       = 46;
	private static $ID_SHOFETIM                   = 47;
	private static $ID_KITETSE                    = 48;
	private static $ID_KITABO                     = 49;
	private static $ID_NITSABIM                   = 50;
	private static $ID_VAYELEH                    = 51;
	private static $ID_HAAZINU                    = 52;

	private static $ID_SIMHATHTORAH               = 53;
	private static $ID_SIMHATHTORAH_2             = 54;
	private static $ID_SIMHATHTORAH_3             = 55;

	private static $ID_ROSH_HODESH_SHABBAT        = 60;
	private static $ID_SHEKALIM                   = 61;
	private static $ID_ZAHOR                      = 62;
	private static $ID_PARAH                      = 63;
	private static $ID_HAHODESH                   = 64;
	private static $ID_HAGGADOL                   = 65;
	private static $ID_SHUVA                      = 66;

	private static $ID_ROSH_HASHANAH_I            = 70;
	private static $ID_ROSH_HASHANAH_II           = 71;
	private static $ID_FAST_OF_GEDALIAH           = 72;
	private static $ID_YOM_KIPPUR                 = 73;
	private static $ID_SUCCOTH_I                  = 74;
	private static $ID_SUCCOTH_II                 = 75;
	private static $ID_SUCCOTH_III_NO_SHABBAT     = 76;
	private static $ID_SUCCOTH_III                = 77;
	private static $ID_SUCCOTH_IV                 = 78;
	private static $ID_SUCCOTH_V_NO_SHABBAT       = 79;
	private static $ID_SUCCOTH_V                  = 80;
	private static $ID_SUCCOTH_VI_NO_SHABBAT      = 81;
	private static $ID_SUCCOTH_VI                 = 82;
	private static $ID_HOSHANAH_RABBAH            = 83;
	private static $ID_HOL_HAMOED_SUCCOTH         = 84;
	private static $ID_SHEMINI_AZERETH_1          = 85;
	private static $ID_FAST_OF_ESTHER             = 86;
	private static $ID_PURIM                      = 87;
	private static $ID_FAST_OF_TEVET_10           = 88;
	private static $ID_PESAH_I                    = 89;
	private static $ID_HOL_HAMOED_PESAH           = 90;
	private static $ID_PESAH_VII                  = 91;
	private static $ID_PESAH_VIII                 = 92;
	private static $ID_PESAH_VIII_NO_SHABBAT      = 93;
	private static $ID_SHAVUOTH_I                 = 94;
	private static $ID_SHAVUOTH_II_NO_SHABBAT     = 95; 
	private static $ID_SHAVUOTH_II                = 96;
	private static $ID_YOM_HAATZMAUT              = 97;
	private static $ID_FAST_OF_TAMMUZ_17          = 98;
	private static $ID_FAST_OF_TISHA_BAV          = 99;
	private static $ID_CHANUKKAH_I               = 100;
	private static $ID_CHANUKKAH_II              = 101;
	private static $ID_CHANUKKAH_III             = 102;
	private static $ID_CHANUKKAH_IV              = 103;
	private static $ID_CHANUKKAH_V               = 104;
	private static $ID_CHANUKKAH_VI              = 105;
	private static $ID_CHANUKKAH_VI_ROSH_HODESH  = 106;
	private static $ID_CHANUKKAH_VII             = 107;
	private static $ID_CHANUKKAH_VII_ROSH_HODESH = 108;
	private static $ID_CHANUKKAH_VIII            = 109;
	private static $ID_SECOND_SHABBAT_CHANUKKAH  = 110;
	private static $ID_ROSH_HODESH               = 111;
	private static $ID_PESAH_II                  = 112;
	private static $ID_PESAH_III                 = 113;
	private static $ID_PESAH_IV                  = 114;
	private static $ID_PESAH_IV_NOT_SUNDAY       = 115;
	private static $ID_PESAH_IV_SUNDAY           = 116;
	private static $ID_PESAH_V                   = 117;
	private static $ID_PESAH_V_NOT_MONDAY        = 118;
	private static $ID_PESAH_V_MONDAY            = 119;
	private static $ID_PESAH_VI                  = 120;

	private static $ID_SPECIAL_1                  = 150;
	private static $ID_SPECIAL_2                  = 151;
	private static $ID_SPECIAL_3                  = 152;
	private static $ID_SPECIAL_4                  = 153;
	private static $ID_SPECIAL_5                  = 154;
	private static $ID_SPECIAL_6                  = 155;
	private static $ID_SPECIAL_7                  = 156;
	private static $ID_SPECIAL_8                  = 157;
	private static $ID_SPECIAL_8A                 = 158;
	private static $ID_SPECIAL_9                  = 159;
	private static $ID_SPECIAL_10                 = 161;
	private static $ID_SPECIAL_11                 = 162;
	private static $ID_SPECIAL_12                 = 163;

	private static $ID_SHEMINI_AZERETH_2          = 170;
	private static $ID_SHEMINI_AZERETH_3          = 171;
	private static $ID_SHEMINI_AZERETH            = 172;

	private static $ID_MAX                        = 256;

	private static $ID_NULL                       = 1000;

	private static $torahSectionsA=array
		(0,1000,1000,
		1,1000,1000,
		2,1000,1000,
		3,1000,1000,
		4,1000,1000,
		5,1000,1000,
		6,1000,1000,
		7,1000,1000,
		8,1000,1000,
		9,1000,1000,
		10,1000,1000,
		11,1000,1000,
		12,1000,1000,
		13,1000,1000,
		14,1000,1000,
		15,1000,1000,
		16,1000,1000,
		17,61,1000,
		18,1000,1000,
		19,62,1000,
		20,63,1000,
		21,22,64,
		23,1000,1000,
		24,65,1000,
		90,1000,1000,
		25,1000,1000,
		26,27,1000,
		28,29,1000,
		30,1000,1000,
		31,32,1000,
		33,1000,1000,
		34,1000,1000,
		35,1000,1000,
		36,1000,1000,
		37,1000,1000,
		38,1000,1000,
		39,1000,1000,
		40,1000,1000,
		41,42,1000,
		43,1000,1000,
		44,1000,1000,
		45,1000,1000,
		46,1000,1000,
		47,1000,1000,
		48,1000,1000,
		49,1000,1000,
		50,51,1000,
		52,1000,1000,
		73,1000,1000,
		84,1000,1000);
	private static $torahSectionsB=array
		(0,1000,1000,
		1,1000,1000,
		2,1000,1000,
		3,1000,1000,
		4,1000,1000,
		5,1000,1000,
		6,1000,1000,
		7,1000,1000,
		8,1000,1000,
		9,1000,1000,
		10,1000,1000,
		11,1000,1000,
		12,1000,1000,
		13,1000,1000,
		14,1000,1000,
		15,1000,1000,
		16,1000,1000,
		17,61,1000,
		18,62,1000,
		19,1000,1000,
		20,63,1000,
		21,22,64,
		23,1000,1000,
		24,65,1000,
		91,1000,1000,
		25,1000,1000,
		26,27,1000,
		28,29,1000,
		30,1000,1000,
		31,32,1000,
		33,1000,1000,
		34,1000,1000,
		35,1000,1000,
		36,1000,1000,
		37,1000,1000,
		38,1000,1000,
		39,1000,1000,
		40,1000,1000,
		41,42,1000,
		43,1000,1000,
		44,1000,1000,
		45,1000,1000,
		46,1000,1000,
		47,1000,1000,
		48,1000,1000,
		49,1000,1000,
		50,1000,1000,
		51,1000,1000,
		52,1000,1000,
		84,1000,1000);
	private static $torahSectionsCDiaspora=array
		(0,1000,1000,
		1,1000,1000,
		2,1000,1000,
		3,1000,1000,
		4,1000,1000,
		5,1000,1000,
		6,1000,1000,
		7,1000,1000,
		8,1000,1000,
		9,1000,1000,
		10,1000,1000,
		11,1000,1000,
		12,1000,1000,
		13,1000,1000,
		14,1000,1000,
		15,1000,1000,
		16,1000,1000,
		17,61,1000,
		18,1000,1000,
		19,62,1000,
		20,63,1000,
		21,22,64,
		23,1000,1000,
		24,65,1000,
		90,1000,1000,
		25,1000,1000,
		26,27,1000,
		28,29,1000,
		30,1000,1000,
		31,32,1000,
		33,1000,1000,
		96,1000,1000,
		34,1000,1000,
		35,1000,1000,
		36,1000,1000,
		37,1000,1000,
		38,39,1000,
		40,1000,1000,
		41,42,1000,
		43,1000,1000,
		44,1000,1000,
		45,1000,1000,
		46,1000,1000,
		47,1000,1000,
		48,1000,1000,
		49,1000,1000,
		50,51,1000,
		70,1000,1000,
		52,1000,1000,
		74,1000,1000,
		172,1000,1000);
	private static $torahSectionsCIsrael=array
		(0,1000,1000,
		1,1000,1000,
		2,1000,1000,
		3,1000,1000,
		4,1000,1000,
		5,1000,1000,
		6,1000,1000,
		7,1000,1000,
		8,1000,1000,
		9,1000,1000,
		10,1000,1000,
		11,1000,1000,
		12,1000,1000,
		13,1000,1000,
		14,1000,1000,
		15,1000,1000,
		16,1000,1000,
		17,61,1000,
		18,1000,1000,
		19,62,1000,
		20,63,1000,
		21,22,64,
		23,1000,1000,
		24,65,1000,
		90,1000,1000,
		25,1000,1000,
		26,27,1000,
		28,29,1000,
		30,1000,1000,
		31,32,1000,
		33,1000,1000,
		34,1000,1000,
		35,1000,1000,
		36,1000,1000,
		37,1000,1000,
		38,1000,1000,
		39,1000,1000,
		40,1000,1000,
		41,42,1000,
		43,1000,1000,
		44,1000,1000,
		45,1000,1000,
		46,1000,1000,
		47,1000,1000,
		48,1000,1000,
		49,1000,1000,
		50,51,1000,
		70,1000,1000,
		52,1000,1000,
		74,1000,1000,
		172,1000,1000);
	private static $torahSectionsDDiaspora=array
		(0,1000,1000,
		1,1000,1000,
		2,1000,1000,
		3,1000,1000,
		4,1000,1000,
		5,1000,1000,
		6,1000,1000,
		7,1000,1000,
		8,1000,1000,
		9,1000,1000,
		10,1000,1000,
		11,1000,1000,
		12,1000,1000,
		13,1000,1000,
		14,1000,1000,
		15,1000,1000,
		16,1000,1000,
		17,61,1000,
		18,1000,1000,
		19,62,1000,
		20,1000,1000,
		21,22,63,
		23,64,1000,
		24,65,1000,
		89,1000,1000,
		92,1000,1000,
		25,1000,1000,
		26,27,1000,
		28,29,1000,
		30,1000,1000,
		31,32,1000,
		33,1000,1000,
		34,1000,1000,
		35,1000,1000,
		36,1000,1000,
		37,1000,1000,
		38,1000,1000,
		39,1000,1000,
		40,1000,1000,
		41,42,1000,
		43,1000,1000,
		44,1000,1000,
		45,1000,1000,
		46,1000,1000,
		47,1000,1000,
		48,1000,1000,
		49,1000,1000,
		50,1000,1000,
		51,1000,1000,
		52,1000,1000,
		84,1000,1000);
	private static $torahSectionsDIsrael=array
		(0,1000,1000,
		1,1000,1000,
		2,1000,1000,
		3,1000,1000,
		4,1000,1000,
		5,1000,1000,
		6,1000,1000,
		7,1000,1000,
		8,1000,1000,
		9,1000,1000,
		10,1000,1000,
		11,1000,1000,
		12,1000,1000,
		13,1000,1000,
		14,1000,1000,
		15,1000,1000,
		16,1000,1000,
		17,61,1000,
		18,1000,1000,
		19,62,1000,
		20,1000,1000,
		21,22,63,
		23,64,1000,
		24,65,1000,
		89,1000,1000,
		25,1000,1000,
		26,27,1000,
		28,29,1000,
		30,1000,1000,
		31,1000,1000,
		32,1000,1000,
		33,1000,1000,
		34,1000,1000,
		35,1000,1000,
		36,1000,1000,
		37,1000,1000,
		38,1000,1000,
		39,1000,1000,
		40,1000,1000,
		41,42,1000,
		43,1000,1000,
		44,1000,1000,
		45,1000,1000,
		46,1000,1000,
		47,1000,1000,
		48,1000,1000,
		49,1000,1000,
		50,1000,1000,
		51,1000,1000,
		52,1000,1000,
		84,1000,1000);
	private static $torahSectionsEDiaspora=array
		(0,1000,1000,
		1,1000,1000,
		2,1000,1000,
		3,1000,1000,
		4,1000,1000,
		5,1000,1000,
		6,1000,1000,
		7,1000,1000,
		8,1000,1000,
		9,1000,1000,
		10,1000,1000,
		11,1000,1000,
		12,1000,1000,
		13,1000,1000,
		14,1000,1000,
		15,1000,1000,
		16,1000,1000,
		17,61,1000,
		18,1000,1000,
		19,62,1000,
		20,63,1000,
		21,22,64,
		23,1000,1000,
		24,65,1000,
		90,1000,1000,
		25,1000,1000,
		26,27,1000,
		28,29,1000,
		30,1000,1000,
		31,32,1000,
		33,1000,1000,
		96,1000,1000,
		34,1000,1000,
		35,1000,1000,
		36,1000,1000,
		37,1000,1000,
		38,39,1000,
		40,1000,1000,
		41,42,1000,
		43,1000,1000,
		44,1000,1000,
		45,1000,1000,
		46,1000,1000,
		47,1000,1000,
		48,1000,1000,
		49,1000,1000,
		50,51,1000,
		70,1000,1000,
		52,1000,1000,
		74,1000,1000,
		172,1000,1000);
	private static $torahSectionsEIsrael=array
		(0,1000,1000,
		1,1000,1000,
		2,1000,1000,
		3,1000,1000,
		4,1000,1000,
		5,1000,1000,
		6,1000,1000,
		7,1000,1000,
		8,1000,1000,
		9,1000,1000,
		10,1000,1000,
		11,1000,1000,
		12,1000,1000,
		13,1000,1000,
		14,1000,1000,
		15,1000,1000,
		16,1000,1000,
		17,61,1000,
		18,1000,1000,
		19,62,1000,
		20,63,1000,
		21,22,64,
		23,1000,1000,
		24,65,1000,
		90,1000,1000,
		25,1000,1000,
		26,27,1000,
		28,29,1000,
		30,1000,1000,
		31,32,1000,
		33,1000,1000,
		96,1000,1000,
		34,1000,1000,
		35,1000,1000,
		36,1000,1000,
		37,1000,1000,
		38,39,1000,
		40,1000,1000,
		41,42,1000,
		43,1000,1000,
		44,1000,1000,
		45,1000,1000,
		46,1000,1000,
		47,1000,1000,
		48,1000,1000,
		49,1000,1000,
		50,51,1000,
		70,1000,1000,
		52,1000,1000,
		74,1000,1000,
		172,1000,1000);
	private static $torahSectionsF=array
		(0,1000,1000,
		1,1000,1000,
		2,1000,1000,
		3,1000,1000,
		4,1000,1000,
		5,1000,1000,
		6,1000,1000,
		7,1000,1000,
		8,1000,1000,
		9,1000,1000,
		10,1000,1000,
		11,1000,1000,
		12,1000,1000,
		13,1000,1000,
		14,1000,1000,
		15,1000,1000,
		16,1000,1000,
		17,1000,1000,
		18,61,1000,
		19,62,1000,
		20,1000,1000,
		21,63,1000,
		22,64,1000,
		23,1000,1000,
		24,65,1000,
		91,1000,1000,
		25,1000,1000,
		26,27,1000,
		28,29,1000,
		30,1000,1000,
		31,32,1000,
		33,1000,1000,
		34,1000,1000,
		35,1000,1000,
		36,1000,1000,
		37,1000,1000,
		38,1000,1000,
		39,1000,1000,
		40,1000,1000,
		41,42,1000,
		43,1000,1000,
		44,1000,1000,
		45,1000,1000,
		46,1000,1000,
		47,1000,1000,
		48,1000,1000,
		49,1000,1000,
		50,1000,1000,
		51,1000,1000,
		52,1000,1000,
		84,1000,1000);
	private static $torahSectionsG=array
		(0,1000,1000,
		1,1000,1000,
		2,1000,1000,
		3,1000,1000,
		4,1000,1000,
		5,1000,1000,
		6,1000,1000,
		7,1000,1000,
		8,1000,1000,
		9,1000,1000,
		10,1000,1000,
		11,1000,1000,
		12,1000,1000,
		13,1000,1000,
		14,1000,1000,
		15,1000,1000,
		16,1000,1000,
		17,61,1000,
		18,1000,1000,
		19,62,1000,
		20,63,1000,
		21,22,64,
		23,1000,1000,
		24,65,1000,
		90,1000,1000,
		25,1000,1000,
		26,27,1000,
		28,29,1000,
		30,1000,1000,
		31,32,1000,
		33,1000,1000,
		34,1000,1000,
		35,1000,1000,
		36,1000,1000,
		37,1000,1000,
		38,1000,1000,
		39,1000,1000,
		40,1000,1000,
		41,42,1000,
		43,1000,1000,
		44,1000,1000,
		45,1000,1000,
		46,1000,1000,
		47,1000,1000,
		48,1000,1000,
		49,1000,1000,
		50,51,1000,
		52,1000,1000,
		73,1000,1000,
		84,1000,1000);
	private static $torahSectionsHDiaspora=array
		(0,1000,1000,
		1,1000,1000,
		2,1000,1000,
		3,1000,1000,
		4,1000,1000,
		5,1000,1000,
		6,1000,1000,
		7,1000,1000,
		8,1000,1000,
		9,1000,1000,
		10,1000,1000,
		11,1000,1000,
		12,1000,1000,
		13,1000,1000,
		14,1000,1000,
		15,1000,1000,
		16,1000,1000,
		17,1000,1000,
		18,1000,1000,
		19,1000,1000,
		20,1000,1000,
		21,61,1000,
		22,1000,1000,
		23,62,1000,
		24,63,1000,
		25,64,1000,
		26,1000,1000,
		27,65,1000,
		90,1000,1000,
		28,1000,1000,
		29,1000,1000,
		30,1000,1000,
		31,1000,1000,
		32,1000,1000,
		33,1000,1000,
		96,1000,1000,
		34,1000,1000,
		35,1000,1000,
		36,1000,1000,
		37,1000,1000,
		38,39,1000,
		40,1000,1000,
		41,42,1000,
		43,1000,1000,
		44,1000,1000,
		45,1000,1000,
		46,1000,1000,
		47,1000,1000,
		48,1000,1000,
		49,1000,1000,
		50,51,1000,
		70,1000,1000,
		52,1000,1000,
		74,1000,1000,
		172,1000,1000);
	private static $torahSectionsHIsrael=array
		(0,1000,1000,
		1,1000,1000,
		2,1000,1000,
		3,1000,1000,
		4,1000,1000,
		5,1000,1000,
		6,1000,1000,
		7,1000,1000,
		8,1000,1000,
		9,1000,1000,
		10,1000,1000,
		11,1000,1000,
		12,1000,1000,
		13,1000,1000,
		14,1000,1000,
		15,1000,1000,
		16,1000,1000,
		17,1000,1000,
		18,1000,1000,
		19,1000,1000,
		20,1000,1000,
		21,61,1000,
		22,1000,1000,
		23,62,1000,
		24,63,1000,
		25,64,1000,
		26,1000,1000,
		27,65,1000,
		90,1000,1000,
		28,1000,1000,
		29,1000,1000,
		30,1000,1000,
		31,1000,1000,
		32,1000,1000,
		33,1000,1000,
		34,1000,1000,
		35,1000,1000,
		36,1000,1000,
		37,1000,1000,
		38,1000,1000,
		39,1000,1000,
		40,1000,1000,
		41,42,1000,
		43,1000,1000,
		44,1000,1000,
		45,1000,1000,
		46,1000,1000,
		47,1000,1000,
		48,1000,1000,
		49,1000,1000,
		50,51,1000,
		70,1000,1000,
		52,1000,1000,
		74,1000,1000,
		172,1000,1000);
	private static $torahSectionsI=array
		(0,1000,1000,
		1,1000,1000,
		2,1000,1000,
		3,1000,1000,
		4,1000,1000,
		5,1000,1000,
		6,1000,1000,
		7,1000,1000,
		8,1000,1000,
		9,1000,1000,
		10,1000,1000,
		11,1000,1000,
		12,1000,1000,
		13,1000,1000,
		14,1000,1000,
		15,1000,1000,
		16,1000,1000,
		17,1000,1000,
		18,1000,1000,
		19,1000,1000,
		20,1000,1000,
		21,1000,1000,
		22,61,1000,
		23,62,1000,
		24,1000,1000,
		25,63,1000,
		26,64,1000,
		27,1000,1000,
		28,65,1000,
		91,1000,1000,
		29,1000,1000,
		30,1000,1000,
		31,1000,1000,
		32,1000,1000,
		33,1000,1000,
		34,1000,1000,
		35,1000,1000,
		36,1000,1000,
		37,1000,1000,
		38,1000,1000,
		39,1000,1000,
		40,1000,1000,
		41,1000,1000,
		42,1000,1000,
		43,1000,1000,
		44,1000,1000,
		45,1000,1000,
		46,1000,1000,
		47,1000,1000,
		48,1000,1000,
		49,1000,1000,
		50,1000,1000,
		51,1000,1000,
		52,1000,1000,
		84,1000,1000);
	private static $torahSectionsJ=array
		(0,1000,1000,
		1,1000,1000,
		2,1000,1000,
		3,1000,1000,
		4,1000,1000,
		5,1000,1000,
		6,1000,1000,
		7,1000,1000,
		8,1000,1000,
		9,1000,1000,
		10,1000,1000,
		11,1000,1000,
		12,1000,1000,
		13,1000,1000,
		14,1000,1000,
		15,1000,1000,
		16,1000,1000,
		17,1000,1000,
		18,1000,1000,
		19,1000,1000,
		20,1000,1000,
		21,61,1000,
		22,1000,1000,
		23,62,1000,
		24,63,1000,
		25,64,1000,
		26,1000,1000,
		27,65,1000,
		90,1000,1000,
		28,1000,1000,
		29,1000,1000,
		30,1000,1000,
		31,1000,1000,
		32,1000,1000,
		33,1000,1000,
		34,1000,1000,
		35,1000,1000,
		36,1000,1000,
		37,1000,1000,
		38,1000,1000,
		39,1000,1000,
		40,1000,1000,
		41,42,1000,
		43,1000,1000,
		44,1000,1000,
		45,1000,1000,
		46,1000,1000,
		47,1000,1000,
		48,1000,1000,
		49,1000,1000,
		50,51,1000,
		52,1000,1000,
		73,1000,1000,
		84,1000,1000);
	private static $torahSectionsKDiaspora=array
		(0,1000,1000,
		1,1000,1000,
		2,1000,1000,
		3,1000,1000,
		4,1000,1000,
		5,1000,1000,
		6,1000,1000,
		7,1000,1000,
		8,1000,1000,
		9,1000,1000,
		10,1000,1000,
		11,1000,1000,
		12,1000,1000,
		13,1000,1000,
		14,1000,1000,
		15,1000,1000,
		16,1000,1000,
		17,1000,1000,
		18,1000,1000,
		19,1000,1000,
		20,1000,1000,
		21,61,1000,
		22,1000,1000,
		23,62,1000,
		24,1000,1000,
		25,63,1000,
		26,64,1000,
		27,65,1000,
		89,1000,1000,
		92,1000,1000,
		28,1000,1000,
		29,1000,1000,
		30,1000,1000,
		31,1000,1000,
		32,1000,1000,
		33,1000,1000,
		34,1000,1000,
		35,1000,1000,
		36,1000,1000,
		37,1000,1000,
		38,1000,1000,
		39,1000,1000,
		40,1000,1000,
		41,42,1000,
		43,1000,1000,
		44,1000,1000,
		45,1000,1000,
		46,1000,1000,
		47,1000,1000,
		48,1000,1000,
		49,1000,1000,
		50,1000,1000,
		51,1000,1000,
		52,1000,1000,
		84,1000,1000);
	private static $torahSectionsKIsrael=array
		(0,1000,1000,
		1,1000,1000,
		2,1000,1000,
		3,1000,1000,
		4,1000,1000,
		5,1000,1000,
		6,1000,1000,
		7,1000,1000,
		8,1000,1000,
		9,1000,1000,
		10,1000,1000,
		11,1000,1000,
		12,1000,1000,
		13,1000,1000,
		14,1000,1000,
		15,1000,1000,
		16,1000,1000,
		17,1000,1000,
		18,1000,1000,
		19,1000,1000,
		20,1000,1000,
		21,61,1000,
		22,1000,1000,
		23,62,1000,
		24,1000,1000,
		25,63,1000,
		26,64,1000,
		27,65,1000,
		89,1000,1000,
		28,1000,1000,
		29,1000,1000,
		30,1000,1000,
		31,1000,1000,
		32,1000,1000,
		33,1000,1000,
		34,1000,1000,
		35,1000,1000,
		36,1000,1000,
		37,1000,1000,
		38,1000,1000,
		39,1000,1000,
		40,1000,1000,
		41,1000,1000,
		42,1000,1000,
		43,1000,1000,
		44,1000,1000,
		45,1000,1000,
		46,1000,1000,
		47,1000,1000,
		48,1000,1000,
		49,1000,1000,
		50,1000,1000,
		51,1000,1000,
		52,1000,1000,
		84,1000,1000);
	private static $torahSectionsLDiaspora=array
		(0,1000,1000,
		1,1000,1000,
		2,1000,1000,
		3,1000,1000,
		4,1000,1000,
		5,1000,1000,
		6,1000,1000,
		7,1000,1000,
		8,1000,1000,
		9,1000,1000,
		10,1000,1000,
		11,1000,1000,
		12,1000,1000,
		13,1000,1000,
		14,1000,1000,
		15,1000,1000,
		16,1000,1000,
		17,1000,1000,
		18,1000,1000,
		19,1000,1000,
		20,1000,1000,
		21,61,1000,
		22,1000,1000,
		23,62,1000,
		24,1000,1000,
		25,63,1000,
		26,64,1000,
		27,65,1000,
		89,1000,1000,
		92,1000,1000,
		28,1000,1000,
		29,1000,1000,
		30,1000,1000,
		31,1000,1000,
		32,1000,1000,
		33,1000,1000,
		34,1000,1000,
		35,1000,1000,
		36,1000,1000,
		37,1000,1000,
		38,1000,1000,
		39,1000,1000,
		40,1000,1000,
		41,42,1000,
		43,1000,1000,
		44,1000,1000,
		45,1000,1000,
		46,1000,1000,
		47,1000,1000,
		48,1000,1000,
		49,1000,1000,
		50,1000,1000,
		51,1000,1000,
		52,1000,1000,
		84,1000,1000);
	private static $torahSectionsLIsrael=array
		(0,1000,1000,
		1,1000,1000,
		2,1000,1000,
		3,1000,1000,
		4,1000,1000,
		5,1000,1000,
		6,1000,1000,
		7,1000,1000,
		8,1000,1000,
		9,1000,1000,
		10,1000,1000,
		11,1000,1000,
		12,1000,1000,
		13,1000,1000,
		14,1000,1000,
		15,1000,1000,
		16,1000,1000,
		17,1000,1000,
		18,1000,1000,
		19,1000,1000,
		20,1000,1000,
		21,61,1000,
		22,1000,1000,
		23,62,1000,
		24,1000,1000,
		25,63,1000,
		26,64,1000,
		27,65,1000,
		89,1000,1000,
		28,1000,1000,
		29,1000,1000,
		30,1000,1000,
		31,1000,1000,
		32,1000,1000,
		33,1000,1000,
		34,1000,1000,
		35,1000,1000,
		36,1000,1000,
		37,1000,1000,
		38,1000,1000,
		39,1000,1000,
		40,1000,1000,
		41,1000,1000,
		42,1000,1000,
		43,1000,1000,
		44,1000,1000,
		45,1000,1000,
		46,1000,1000,
		47,1000,1000,
		48,1000,1000,
		49,1000,1000,
		50,1000,1000,
		51,1000,1000,
		52,1000,1000,
		84,1000,1000);
	private static $torahSectionsM=array
		(0,1000,1000,
		1,1000,1000,
		2,1000,1000,
		3,1000,1000,
		4,1000,1000,
		5,1000,1000,
		6,1000,1000,
		7,1000,1000,
		8,1000,1000,
		9,1000,1000,
		10,1000,1000,
		11,1000,1000,
		12,1000,1000,
		13,1000,1000,
		14,1000,1000,
		15,1000,1000,
		16,1000,1000,
		17,1000,1000,
		18,1000,1000,
		19,1000,1000,
		20,1000,1000,
		21,1000,1000,
		22,61,1000,
		23,1000,1000,
		24,62,1000,
		25,63,1000,
		26,64,1000,
		27,1000,1000,
		28,65,1000,
		90,1000,1000,
		29,1000,1000,
		30,1000,1000,
		31,1000,1000,
		32,1000,1000,
		33,1000,1000,
		34,1000,1000,
		35,1000,1000,
		36,1000,1000,
		37,1000,1000,
		38,1000,1000,
		39,1000,1000,
		40,1000,1000,
		41,1000,1000,
		42,1000,1000,
		43,1000,1000,
		44,1000,1000,
		45,1000,1000,
		46,1000,1000,
		47,1000,1000,
		48,1000,1000,
		49,1000,1000,
		50,51,1000,
		52,1000,1000,
		73,1000,1000,
		84,1000,1000);
	private static $torahSectionsNDiaspora=array
		(0,1000,1000,
		1,1000,1000,
		2,1000,1000,
		3,1000,1000,
		4,1000,1000,
		5,1000,1000,
		6,1000,1000,
		7,1000,1000,
		8,1000,1000,
		9,1000,1000,
		10,1000,1000,
		11,1000,1000,
		12,1000,1000,
		13,1000,1000,
		14,1000,1000,
		15,1000,1000,
		16,1000,1000,
		17,1000,1000,
		18,1000,1000,
		19,1000,1000,
		20,1000,1000,
		21,61,1000,
		22,1000,1000,
		23,62,1000,
		24,63,1000,
		25,64,1000,
		26,1000,1000,
		27,65,1000,
		90,1000,1000,
		28,1000,1000,
		29,1000,1000,
		30,1000,1000,
		31,1000,1000,
		32,1000,1000,
		33,1000,1000,
		96,1000,1000,
		34,1000,1000,
		35,1000,1000,
		36,1000,1000,
		37,1000,1000,
		38,39,1000,
		40,1000,1000,
		41,42,1000,
		43,1000,1000,
		44,1000,1000,
		45,1000,1000,
		46,1000,1000,
		47,1000,1000,
		48,1000,1000,
		49,1000,1000,
		50,51,1000,
		70,1000,1000,
		52,1000,1000,
		74,1000,1000,
		172,1000,1000);
	private static $torahSectionsNIsrael=array
		(0,1000,1000,
		1,1000,1000,
		2,1000,1000,
		3,1000,1000,
		4,1000,1000,
		5,1000,1000,
		6,1000,1000,
		7,1000,1000,
		8,1000,1000,
		9,1000,1000,
		10,1000,1000,
		11,1000,1000,
		12,1000,1000,
		13,1000,1000,
		14,1000,1000,
		15,1000,1000,
		16,1000,1000,
		17,1000,1000,
		18,1000,1000,
		19,1000,1000,
		20,1000,1000,
		21,61,1000,
		22,1000,1000,
		23,62,1000,
		24,63,1000,
		25,64,1000,
		26,1000,1000,
		27,65,1000,
		90,1000,1000,
		28,1000,1000,
		29,1000,1000,
		30,1000,1000,
		31,1000,1000,
		32,1000,1000,
		33,1000,1000,
		34,1000,1000,
		35,1000,1000,
		36,1000,1000,
		37,1000,1000,
		38,1000,1000,
		39,1000,1000,
		40,1000,1000,
		41,42,1000,
		43,1000,1000,
		44,1000,1000,
		45,1000,1000,
		46,1000,1000,
		47,1000,1000,
		48,1000,1000,
		49,1000,1000,
		50,51,1000,
		70,1000,1000,
		52,1000,1000,
		74,1000,1000,
		172,1000,1000);	

	public function torahGetWeekday($absDate) {
		return jddayofweek($absDate, 0);
	}

	public function torahHebrewLeapYear($year) {
		if (((($year*7)+1) % 19) < 7)
			return true;
		else
			return false;
	}
	
	//public function torahLastMonthOfHebrewYear($year) {
	//  if (self::torahHebrewLeapYear($year))
	//	return 13;
	//  else
	//	return 12;
	//}
	
	public function getYearType($year) {
		$rhWeekday = self::torahGetWeekday(jewishtojd(1, 1, $year));
		$lengthOfYear = jewishtojd(1, 1, $year+1) - jewishtojd(1, 1, $year);
		$pesWeekday = self::torahGetWeekday(jewishtojd(8, 15, $year));

		if (($rhWeekday == 1) && ($lengthOfYear == 353) && ($pesWeekday == 2)) return 1;
		if (($rhWeekday == 6) && ($lengthOfYear == 353) && ($pesWeekday == 0)) return 2;
		if (($rhWeekday == 2) && ($lengthOfYear == 354) && ($pesWeekday == 4)) return 3;
		if (($rhWeekday == 4) && ($lengthOfYear == 354) && ($pesWeekday == 6)) return 4;
		if (($rhWeekday == 1) && ($lengthOfYear == 355) && ($pesWeekday == 4)) return 5;
		if (($rhWeekday == 4) && ($lengthOfYear == 355) && ($pesWeekday == 0)) return 6;
		if (($rhWeekday == 6) && ($lengthOfYear == 355) && ($pesWeekday == 2)) return 7;

		if (($rhWeekday == 1) && ($lengthOfYear == 383) && ($pesWeekday == 4)) return 8;
		if (($rhWeekday == 4) && ($lengthOfYear == 383) && ($pesWeekday == 0)) return 9;
		if (($rhWeekday == 6) && ($lengthOfYear == 383) && ($pesWeekday == 2)) return 10;
		if (($rhWeekday == 2) && ($lengthOfYear == 384) && ($pesWeekday == 6)) return 11;
		if (($rhWeekday == 1) && ($lengthOfYear == 385) && ($pesWeekday == 6)) return 12;
		if (($rhWeekday == 4) && ($lengthOfYear == 385) && ($pesWeekday == 2)) return 13;
		if (($rhWeekday == 6) && ($lengthOfYear == 385) && ($pesWeekday == 4)) return 14;

		return 0;
	}

	public function determineBereshith($year) {
		$simchatTorah = jewishtojd(1, 23, $year);
		while (self::torahGetWeekday($simchatTorah) != 6) {
			$simchatTorah++;
		}
		return ($simchatTorah);
	}

	public function getTorahSectionName($section,$lang) {
		if($lang=="en"){
			$BERESHITH = "Bereshith";
			$NOAH = "Noah";
			$LEHLEHA = "Le'h Leha";
			$VAYERA = "Vayera";
			$HAYESARAH = "Haye Sarah";
			$TOLEDOTH = "Toledoth";
			$VAYETSE = "Vayetse";
			$VAYISHLAH = "Vayishlah";
			$VAYESHEB = "Vayesheb";
			$MIKKETS = "Mikkets";
			$VAYIGGASH = "Vayiggash";
			$VAYHEE = "Vayhee";
			$SHEMOTH = "Shemoth";
			$VAERA = "Vaera";
			$BO = "Bo";
			$BESHALLAH = "Beshallah, Shabbat Shirah";
			$YITHRO = "Yithro";
			$MISHPATIM = "Mishpatim";
			$TERUMAH = "Terumah";
			$TETSAVVEH = "Tetsavveh";
			$KITISSA = "Ki Tissa";
			$VAYAKHEL = "Vayakhel";
			$PEKUDE = "Pekude";
			$VAYIKRA = "Vayikra";
			$TSAV = "Tsav";
			$SHEMINI = "Shemini";
			$TAZRIANG = "Tazria";
			$METSORANG = "Metsora";
			$AHAREMOTH = "Aharemoth";
			$KEDOSHIM = "Kedoshim";
			$EMOR = "Emor";
			$BEHAR = "Behar";
			$BEHUKKOTHAI = "Behukkothai";
			$BEMIDBAR = "Bemidbar";
			$NASO = "Naso";
			$BEHAALOTEHA = "Behaaloteha";
			$SHELAHLEHA = "Shelah Leha";
			$KORAH = "Korah";
			$HUKATH = "Hukath";
			$BALAK = "Balak";
			$PINHAS = "Pinhas";
			$MATOTH = "Matoth";
			$MASEH = "Maseh";
			$DEBARIM = "Debarim, Shabbat Hazon";
			$VAETHANAN = "Vaethanan, Shabbat Nahamu";
			$EKEB = "Ekeb";
			$REEH = "Reeh";
			$SHOFETIM = "Shofetim";
			$KITETSE = "Ki Tetse";
			$KITABO = "Ki Tabo";
			$NITSABIM = "Nitsabim";
			$VAYELEH = "Vayeleh";
			$HAAZINU = "Haazinu";
			$SHEKALIM = "Shabbat Shekalim";
			$ZAHOR = "Shabbat Za'hor";
			$PARAH = "Shabbat Parah";
			$HAHODESH = "Shabbat Hahodesh";
			$SHUVA = "Shabbat Shuva";	
		}else if($lang=="he"){
			$BERESHITH = "בראשית";
			$NOAH = "נח";
			$LEHLEHA = "לך לך";
			$VAYERA = "וירא";
			$HAYESARAH = "חיי שרה";
			$TOLEDOTH = "תולדות";
			$VAYETSE = "ויצא";
			$VAYISHLAH = "וישלח";
			$VAYESHEB = "וישב";
			$MIKKETS = "מקץ";
			$VAYIGGASH = "ויגש";
			$VAYHEE = "ויחי";
			
			$SHEMOTH = "שמות";
			$VAERA = "וארא";
			$BO = "בא";
			$BESHALLAH = "בשלח, שבת שרה";
			$YITHRO = "יתרו";
			$MISHPATIM = "משפטים";
			$TERUMAH = "תרומה";
			$TETSAVVEH = "תצוה";
			$KITISSA = "כי תשא";
			$VAYAKHEL = "ויקהל";
			$PEKUDE = "פקודי";
			
			$VAYIKRA = "ויקרא";
			$TSAV = "צו";
			$SHEMINI = "שמיני";
			$TAZRIANG = "תזריע";
			$METSORANG = "מצורע";
			$AHAREMOTH = "אחרי מות";
			$KEDOSHIM = "קדושים";
			$EMOR = "אמור";
			$BEHAR = "בהר";
			$BEHUKKOTHAI = "בחוקתי";
			
			$BEMIDBAR = "במדבר";
			$NASO = "נשא";
			$BEHAALOTEHA = "בהעלותך";
			$SHELAHLEHA = "שלח לך";
			$KORAH = "קרח";
			$HUKATH = "חקת";
			$BALAK = "בלק";
			$PINHAS = "פנחס";
			$MATOTH = "מטות";
			$MASEH = "מסעי";
			
			$DEBARIM = "דברים, שבת חזון";
			$VAETHANAN = "ואתכנן, שבת נחמו";
			$EKEB = "עקב";
			$REEH = "ראה";
			$SHOFETIM = "שופטים";
			$KITETSE = "כי תצא";
			$KITABO = "כי תבוא";
			$NITSABIM = "ניצבים";
			$VAYELEH = "וילך";
			$HAAZINU = "האזינו";
			$SHEKALIM = "שבת שקלים";
			$ZAHOR = "שבת זכור";
			$PARAH = "שבת פרה";
			$HAHODESH = "שבת החודש";
			$SHUVA = "שבת שובה";	
		}
		
		if ($section == self::$ID_BERESHITH) return $BERESHITH;
		if ($section == self::$ID_NOAH) return $NOAH;
		if ($section == self::$ID_LEHLEHA) return $LEHLEHA;
		if ($section == self::$ID_VAYERA) return $VAYERA;
		if ($section == self::$ID_HAYESARAH) return $HAYESARAH;
		if ($section == self::$ID_TOLEDOTH) return $TOLEDOTH;
		if ($section == self::$ID_VAYETSE) return $VAYETSE;
		if ($section == self::$ID_VAYISHLAH) return $VAYISHLAH;
		if ($section == self::$ID_VAYESHEB) return $VAYESHEB;
		if ($section == self::$ID_MIKKETS) return $MIKKETS;
		if ($section == self::$ID_VAYIGGASH) return $VAYIGGASH;
		if ($section == self::$ID_VAYHEE) return $VAYHEE;
		if ($section == self::$ID_SHEMOTH) return $SHEMOTH;
		if ($section == self::$ID_VAERA) return $VAERA;
		if ($section == self::$ID_BO) return $BO;
		if ($section == self::$ID_BESHALLAH) return $BESHALLAH;
		if ($section == self::$ID_YITHRO) return $YITHRO;
		if ($section == self::$ID_MISHPATIM) return $MISHPATIM;
		if ($section == self::$ID_TERUMAH) return $TERUMAH;
		if ($section == self::$ID_TETSAVVEH) return $TETSAVVEH;
		if ($section == self::$ID_KITISSA) return $KITISSA;
		if ($section == self::$ID_VAYAKHEL) return $VAYAKHEL;
		if ($section == self::$ID_PEKUDE) return $PEKUDE;
		if ($section == self::$ID_VAYIKRA) return $VAYIKRA;
		if ($section == self::$ID_TSAV) return $TSAV;
		if ($section == self::$ID_SHEMINI) return $SHEMINI;
		if ($section == self::$ID_TAZRIANG) return $TAZRIANG;
		if ($section == self::$ID_METSORANG) return $METSORANG;
		if ($section == self::$ID_AHAREMOTH) return $AHAREMOTH;
		if ($section == self::$ID_KEDOSHIM) return $KEDOSHIM;
		if ($section == self::$ID_EMOR) return $EMOR;
		if ($section == self::$ID_BEHAR) return $BEHAR;
		if ($section == self::$ID_BEHUKKOTHAI) return $BEHUKKOTHAI;
		if ($section == self::$ID_BEMIDBAR) return $BEMIDBAR;
		if ($section == self::$ID_NASO) return $NASO;
		if ($section == self::$ID_BEHAALOTEHA) return $BEHAALOTEHA;
		if ($section == self::$ID_SHELAHLEHA) return $SHELAHLEHA;
		if ($section == self::$ID_KORAH) return $KORAH;
		if ($section == self::$ID_HUKATH) return $HUKATH;
		if ($section == self::$ID_BALAK) return $BALAK;
		if ($section == self::$ID_PINHAS) return $PINHAS;
		if ($section == self::$ID_MATOTH) return $MATOTH;
		if ($section == self::$ID_MASEH) return $MASEH;
		if ($section == self::$ID_DEBARIM) return $DEBARIM;
		if ($section == self::$ID_VAETHANAN) return $VAETHANAN;
		if ($section == self::$ID_EKEB) return $EKEB;
		if ($section == self::$ID_REEH) return $REEH;
		if ($section == self::$ID_SHOFETIM) return $SHOFETIM;
		if ($section == self::$ID_KITETSE) return $KITETSE;
		if ($section == self::$ID_KITABO) return $KITABO;
		if ($section == self::$ID_NITSABIM) return $NITSABIM;
		if ($section == self::$ID_VAYELEH) return $VAYELEH;
		if ($section == self::$ID_HAAZINU) return $HAAZINU;

		if ($section == self::$ID_SHEKALIM) return $SHEKALIM;
		if ($section == self::$ID_ZAHOR) return $ZAHOR;
		if ($section == self::$ID_PARAH) return $PARAH;
		if ($section == self::$ID_HAHODESH) return $HAHODESH;
		if ($section == self::$ID_SHUVA) return $SHUVA;

		return "";
	}

	public function getTorahSections($hebrewMonth, $hebrewDay, $hebrewYear, $isDiaspora, $lang) {
		$shuvahDate = jewishtojd(1, 1, $hebrewYear)+1;
		while (self::torahGetWeekday($shuvahDate) != 6) {
			$shuvahDate++;
		}
		$torahDate = jewishtojd($hebrewMonth, $hebrewDay, $hebrewYear);

		if (self::torahGetWeekday($torahDate) == 6) {
			$bereshithDate = self::determineBereshith($hebrewYear);
		
			if ($torahDate < $bereshithDate)
				$referenceYear = $hebrewYear-1;
			else
				$referenceYear = $hebrewYear;

			$yearType = self::getYearType($referenceYear);
			$bereshithDate = self::determineBereshith($referenceYear);	
			$torahWeekNo = ($torahDate-$bereshithDate)/7;
			
			$returnTorahSection = "";
			$IDTorah1 = self::$ID_NULL;
			$IDTorah2 = self::$ID_NULL;
			$IDTorah3 = self::$ID_NULL;
			

			//allgemein: A, B, F, G, I, J, M
			//Israel/Diaspora: C, D, E, H, K, L, N
					
			switch ($yearType) {
				case 1: /// A 
					$IDTorah1 = self::$torahSectionsA[$torahWeekNo * 3 + 0];
					$IDTorah2 = self::$torahSectionsA[$torahWeekNo * 3 + 1];
					$IDTorah3 = self::$torahSectionsA[$torahWeekNo * 3 + 2];
					break;
				case 2: // B 
					$IDTorah1 = self::$torahSectionsB[$torahWeekNo * 3 + 0];
					$IDTorah2 = self::$torahSectionsB[$torahWeekNo * 3 + 1];
					$IDTorah3 = self::$torahSectionsB[$torahWeekNo * 3 + 2];
					break;
				case 3: // C 
					if ($isDiaspora) {
						$IDTorah1 = self::$torahSectionsCDiaspora[$torahWeekNo * 3 + 0];
						$IDTorah2 = self::$torahSectionsCDiaspora[$torahWeekNo * 3 + 1];
						$IDTorah3 = self::$torahSectionsCDiaspora[$torahWeekNo * 3 + 2];
					} else {
						$IDTorah1 = self::$torahSectionsCIsrael[$torahWeekNo * 3 + 0];
						$IDTorah2 = self::$torahSectionsCIsrael[$torahWeekNo * 3 + 1];
						$IDTorah3 = self::$torahSectionsCIsrael[$torahWeekNo * 3 + 2];
					}
					break;
				case 4: // D 
					if ($isDiaspora) {
						$IDTorah1 = self::$torahSectionsDDiaspora[$torahWeekNo * 3 + 0];
						$IDTorah2 = self::$torahSectionsDDiaspora[$torahWeekNo * 3 + 1];
						$IDTorah3 = self::$torahSectionsDDiaspora[$torahWeekNo * 3 + 2];
					} else {
						$IDTorah1 = self::$torahSectionsDIsrael[$torahWeekNo * 3 + 0];
						$IDTorah2 = self::$torahSectionsDIsrael[$torahWeekNo * 3 + 1];
						$IDTorah3 = self::$torahSectionsDIsrael[$torahWeekNo * 3 + 2];
					}
					break;
				case 5: // E 
					if ($isDiaspora) {
						$IDTorah1 = self::$torahSectionsEDiaspora[$torahWeekNo * 3 + 0];
						$IDTorah2 = self::$torahSectionsEDiaspora[$torahWeekNo * 3 + 1];
						$IDTorah3 = self::$torahSectionsEDiaspora[$torahWeekNo * 3 + 2];
					} else {
						$IDTorah1 = self::$torahSectionsEIsrael[$torahWeekNo * 3 + 0];
						$IDTorah2 = self::$torahSectionsEIsrael[$torahWeekNo * 3 + 1];
						$IDTorah3 = self::$torahSectionsEIsrael[$torahWeekNo * 3 + 2];
					}
					break;
				case 6: // F 
					$IDTorah1 = self::$torahSectionsF[$torahWeekNo * 3 + 0];
					$IDTorah2 = self::$torahSectionsF[$torahWeekNo * 3 + 1];
					$IDTorah3 = self::$torahSectionsF[$torahWeekNo * 3 + 2];
					break;
				case 7: // G 
					$IDTorah1 = self::$torahSectionsG[$torahWeekNo * 3 + 0];
					$IDTorah2 = self::$torahSectionsG[$torahWeekNo * 3 + 1];
					$IDTorah3 = self::$torahSectionsG[$torahWeekNo * 3 + 2];
					break;
				case 8: // H 
					if ($isDiaspora) {
						$IDTorah1 = self::$torahSectionsHDiaspora[$torahWeekNo * 3 + 0];
						$IDTorah2 = self::$torahSectionsHDiaspora[$torahWeekNo * 3 + 1];
						$IDTorah3 = self::$torahSectionsHDiaspora[$torahWeekNo * 3 + 2];
					} else {
						$IDTorah1 = self::$torahSectionsHIsrael[$torahWeekNo * 3 + 0];
						$IDTorah2 = self::$torahSectionsHIsrael[$torahWeekNo * 3 + 1];
						$IDTorah3 = self::$torahSectionsHIsrael[$torahWeekNo * 3 + 2];
					}
					break;
				case 9: // I 
					$IDTorah1 = self::$torahSectionsI[$torahWeekNo * 3 + 0];
					$IDTorah2 = self::$torahSectionsI[$torahWeekNo * 3 + 1];
					$IDTorah3 = self::$torahSectionsI[$torahWeekNo * 3 + 2];
					break;
				case 10: // J 
					$IDTorah1 = self::$torahSectionsJ[$torahWeekNo * 3 + 0];
					$IDTorah2 = self::$torahSectionsJ[$torahWeekNo * 3 + 1];
					$IDTorah3 = self::$torahSectionsJ[$torahWeekNo * 3 + 2];
					break;
				case 11: // K 
					if ($isDiaspora) {
						$IDTorah1 = self::$torahSectionsKDiaspora[$torahWeekNo * 3 + 0];
						$IDTorah2 = self::$torahSectionsKDiaspora[$torahWeekNo * 3 + 1];
						$IDTorah3 = self::$torahSectionsKDiaspora[$torahWeekNo * 3 + 2];
					} else {
						$IDTorah1 = self::$torahSectionsKIsrael[$torahWeekNo * 3 + 0];
						$IDTorah2 = self::$torahSectionsKIsrael[$torahWeekNo * 3 + 1];
						$IDTorah3 = self::$torahSectionsKIsrael[$torahWeekNo * 3 + 2];
					}
					break;
				case 12: // L 
					if ($isDiaspora) {
						$IDTorah1 = self::$torahSectionsLDiaspora[$torahWeekNo * 3 + 0];
						$IDTorah2 = self::$torahSectionsLDiaspora[$torahWeekNo * 3 + 1];
						$IDTorah3 = self::$torahSectionsLDiaspora[$torahWeekNo * 3 + 2];
					} else {
						$IDTorah1 = self::$torahSectionsLIsrael[$torahWeekNo * 3 + 0];
						$IDTorah2 = self::$torahSectionsLIsrael[$torahWeekNo * 3 + 1];
						$IDTorah3 = self::$torahSectionsLIsrael[$torahWeekNo * 3 + 2];
					}
					break;
				case 13: // M 
					$IDTorah1 = self::$torahSectionsM[$torahWeekNo * 3 + 0];
					$IDTorah2 = self::$torahSectionsM[$torahWeekNo * 3 + 1];
					$IDTorah3 = self::$torahSectionsM[$torahWeekNo * 3 + 2];
					break;
				case 14: // N 
					if ($isDiaspora) {
						$IDTorah1 = self::$torahSectionsNDiaspora[$torahWeekNo * 3 + 0];
						$IDTorah2 = self::$torahSectionsNDiaspora[$torahWeekNo * 3 + 1];
						$IDTorah3 = self::$torahSectionsNDiaspora[$torahWeekNo * 3 + 2];
					} else {
						$IDTorah1 = self::$torahSectionsNIsrael[$torahWeekNo * 3 + 0];
						$IDTorah2 = self::$torahSectionsNIsrael[$torahWeekNo * 3 + 1];
						$IDTorah3 = self::$torahSectionsNIsrael[$torahWeekNo * 3 + 2];
					}
					break;
			}

			if ($IDTorah1 != self::$ID_NULL) {
				$torahSection = self::getTorahSectionName($IDTorah1,$lang);
				if ($torahSection != "") {
					if ($returnTorahSection != "")
						$returnTorahSection = $returnTorahSection . ", ";
					$returnTorahSection = $returnTorahSection . $torahSection;
				}
			}
			if ($IDTorah2 != self::$ID_NULL) {
				$torahSection = self::getTorahSectionName($IDTorah2,$lang);
				if ($torahSection != "") {
					if ($returnTorahSection != "")
						$returnTorahSection = $returnTorahSection . ", ";
					$returnTorahSection = $returnTorahSection . $torahSection;
				}
			}
			if ($IDTorah3 != self::$ID_NULL) {
				$torahSection = self::getTorahSectionName($IDTorah3,$lang);
				if ($torahSection != "") {
					if ($returnTorahSection != "")
						$returnTorahSection = $returnTorahSection . ", ";
					$returnTorahSection = $returnTorahSection . $torahSection;
				}
			}
			if ($torahDate == $shuvahDate) {
				if ($returnTorahSection != "")
					$returnTorahSection = $returnTorahSection . ", ";
				$returnTorahSection = $returnTorahSection . self::getTorahSectionName(self::$ID_SHUVA,$lang);
			}
			return ($returnTorahSection);
		} else {
			return "";
		}
	}
}
?>

