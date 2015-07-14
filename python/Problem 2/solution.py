def extract_type(tupples, type_to_extract):
    return_value = ""
    for symbol, iterations in tupples:
        if type(symbol) == type_to_extract:
            return_value += str(symbol) * iterations
    return return_value


def reversed_dict(hash_to_be_reversed):
    return {key: value for value, key in hash_to_be_reversed.items()}


def reps(elements):
    return tuple(x for x in elements if elements.count(x) > 1)


def flatten_dict(dictionary, level = ""):
    result = {}
    for key, value in dictionary.items():
        current_key = level + key
        if type(value) is dict:
            result.update(flatten_dict(value, current_key + "."))
        else:
            result[current_key] = value
    return result


def unflatten_dict(dictionary):
    result = {}
    for key, value in dictionary.items():
        if "." in key:
            levels = key.split(".")
            iter_dict = result
            for level in levels[:-1]:
                if level not in iter_dict:
                    iter_dict[level] = {}
                iter_dict = iter_dict[level]
            iter_dict[levels[-1]] = value
        else:
            result[key] = value
    return result
