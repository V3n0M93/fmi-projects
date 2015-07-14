def fibonacci():
    a = 1
    b = 1
    while True:
        yield a
        a, b = b, a + b


def primes():
    def is_prime(number):
        for _ in range(2, number):
            if number % _ == 0:
                return False
        return True

    current = 2
    while True:
        if is_prime(current):
            yield current
        current = current + 1


def alphabet(code=None, letters=None):
    if letters is None:
        if code == 'lat':
            letters = "abcdefghijklmnopqrstuvwxyz"
        else:
            letters = "абвгдежзийклмнопрстуфхцчшщъьюя"
    for letter in letters:
        yield letter
