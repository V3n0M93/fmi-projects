CHINESE_SIGN = ['monkey', 'rooster', 'dog', 'pig', 'rat', 'ox',
                'tiger', 'rabbit', 'dragon', 'snake', 'horse', 'sheep']

ZODIAC_SIGN = {
    'aries': list(range(321, 332)) + list(range(401, 421)),
    'taurus': list(range(421, 431)) + list(range(501, 521)),
    'gemini': list(range(521, 532)) + list(range(601, 621)),
    'cancer': list(range(621, 631)) + list(range(701, 723)),
    'leo': list(range(723, 732)) + list(range(801, 823)),
    'virgo': list(range(823, 832)) + list(range(901, 923)),
    'libra': list(range(923, 931)) + list(range(1001, 1023)),
    'scorpio': list(range(1023, 1032)) + list(range(1101, 1122)),
    'sagittarius': list(range(1122, 1131)) + list(range(1201, 1222)),
    'capricorn': list(range(1222, 1232)) + list(range(101, 121)),
    'aquarius': list(range(121, 132)) + list(range(201, 219)),
    'pisces': list(range(219, 230)) + list(range(301, 321))
}


def interpret_chinese_sign(year):
    return CHINESE_SIGN[year % 12 if year >= 0 else 12 - abs(year) % 12]


def interpret_western_sign(day, month):
    for key in ZODIAC_SIGN:
        if (day + 100 * month) in ZODIAC_SIGN[key]:
            return key


def interpret_both_signs(day, month, year):
    return (interpret_western_sign(day, month), interpret_chinese_sign(year))
