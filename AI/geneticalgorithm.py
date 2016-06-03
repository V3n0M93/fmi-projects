import numpy

ITEMS = [("map", 90, 150), ("compass", 130, 35), ("water", 1530, 200), 
("sandwich", 500, 160), ("glucose", 150, 60), ("tin", 680, 45), 
("banana",270, 60), ("apple", 390, 40), ("cheese", 230, 30), 
("beer", 520, 10), ("suntan cream", 110, 70), ("camera", 320, 30), 
("T-shirt", 240, 15), ("trousers", 480, 10), ("umbrella", 730, 40), 
("waterproof trousers", 420, 70), ("waterproof overclothes", 430, 75), 
("note-case", 220, 80), ("sunglasses", 70, 20), ("towel", 180, 12), ("socks", 40, 50), 
("book", 300, 10), ("notebook", 900, 1), ("tent", 2000, 150)]

MAX_WEIGHT = 5000

def hypotheses_value(h):
    weight = 0
    value = 0
    for index, item in enumerate(h):
        if item == 1:
            weight += ITEMS[index][1]
            value += ITEMS[index][2]
    if weight > MAX_WEIGHT:
        value = 0
    return value


def genetic_algorithm(generations, population_size, replaced, speed):
    #create a random population
    current_population = generate_population(population_size)
        
    #create generations
    for i in range(generations):
        #calculate the values of each hipotheses and the probability of it being picked
        hypotheses_values = list(map(hypotheses_value, current_population))
        sum_of_values = sum(hypotheses_values)
        if sum_of_values > 0:
            hypotheses_probabilities = list(map(lambda x: x / sum_of_values, hypotheses_values))
        else:
            hypotheses_probabilities = [0] * len(current_population)
            
        #select some of the hypotheses and add them to the new generation
        new_generation_indexes = list(numpy.random.choice(range(len(current_population)), int((1 - replaced)*population_size), p=hypotheses_probabilities))
        new_generation = [current_population[i] for i in new_generation_indexes]
        #add gnetic change
        for i in range(int((replaced * population_size) / 2)):
            pair_indexes = list(numpy.random.choice(len(current_population), 2, p=hypotheses_probabilities))
            pair = [current_population[i] for i in pair_indexes]
            children = create_children(pair)
            new_generation = new_generation + children
        #mutation
        number_of_mutations = speed * len(new_generation) / 100
        indexes_of_mutations = list(numpy.random.choice(len(new_generation) - 1, number_of_mutations))
        for index in indexes_of_mutations:
            new_generation[index] = mutate(new_generation[index])
        #replace generations
        current_population = new_generation
    #return best result
    result = max(current_population, key=hypotheses_value)
    print_result(result)
    return result
    
def generate_population(size):
    size_of_hypotheses = len(ITEMS)
    population = []
    while len(population) < size:
        new_hypotheses = list(numpy.random.randint(2, size=size_of_hypotheses))
        if len(population) == 0 or not new_hypotheses in population:
            population.append(new_hypotheses)
    return population
    
def create_children(pair):
    mother = pair[0]
    father = pair[1]
    split = numpy.random.randint(1, len(mother))
    first_child = mother[:split] + father[split:]
    second_child = father[:split] + mother[split:]
    return [first_child, second_child]
    
def mutate(hypotheses):
    index = numpy.random.randint(len(hypotheses))
    hypotheses[index] = (hypotheses[index] + 1) % 2
    return hypotheses

def print_result(result):
    value = 0
    weight = 0
    for index, item in enumerate(result):
        if item == 1:
            weight += ITEMS[index][1]
            value += ITEMS[index][2]
            print(ITEMS[index])
    print(value)
    print(weight)
            
        
        
