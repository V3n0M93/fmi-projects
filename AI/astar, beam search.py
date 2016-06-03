board = [6, 5, 3, 2, 4, 8, 7, 0, 1]
solution = [1, 2, 3, 4, 5, 6, 7, 8, 0]



def h(maze):
    cost = 0
    for index, value in enumerate(maze):
        if value != 0:
            side = abs(index%3 - (value-1)%3)
            up = abs(index//3 - (value-1)//3)
            cost += (side + up)
    return cost
    
def create_new_states(node):
    #copy-paste from last homework
    
    index = node.index(0)
    new_nodes = []
    
    #create left
    if (index % 3 != 0):
        new_board = list(node)
        value = new_board[index - 1]
        new_board[index - 1] = 0
        new_board[index] = value
        new_nodes.append(new_board)
           
    #create right
    if (index % 3 != 2):
        new_board = list(node)
        value = new_board[index + 1]
        new_board[index + 1] = 0
        new_board[index] = value
        new_nodes.append(new_board)

    #create up
    if (index > 2):
        new_board = list(node)
        value = new_board[index - 3]
        new_board[index - 3] = 0
        new_board[index] = value
        new_nodes.append(new_board)
                   
    #create down
    if (index < 6):
        new_board = list(node)
        value = new_board[index + 3]
        new_board[index + 3] = 0
        new_board[index] = value
        new_nodes.append(new_board)
            
    return new_nodes
        
    
def traverse_astar(puzzle):
    closed = []
    node = {}
    node["puzzle"] = puzzle
    node["g"] = 0
    node["h"] = h(puzzle)
    queue = [node]
    while len(queue) > 0:
        node = queue.pop()
        new_nodes = create_new_states(node["puzzle"])
        g = node["g"]
        for puzzle in new_nodes:
            new_node = {}
            new_node["puzzle"] = puzzle
            new_node["g"] = g + 1
            new_node["h"] = h(puzzle)
            if new_node["puzzle"] == solution:
                return new_node["g"]
            if not new_node["puzzle"] in closed and not new_node in queue:
                queue.append(new_node)
        closed.append(node["puzzle"])
        queue = sorted(queue, key=lambda node: node["h"])
    
def traverse_beam_search(puzzle):
    node = {}
    node["puzzle"] = puzzle
    node["g"] = 0
    node["h"] = h(puzzle)
    queue = [node]
    while len(queue) > 0:
        node = queue.pop()
        new_nodes = create_new_states(node["puzzle"])
        g = node["g"]
        for puzzle in new_nodes:
            new_node = {}
            new_node["puzzle"] = puzzle
            new_node["g"] = g + 1
            new_node["h"] = h(puzzle)
            if puzzle == solution:
                print(new_node["g"])
                print(puzzle)
                return new_node["g"]
            if not new_node in queue:
                queue.append(new_node)
        queue = sorted(queue, key=lambda node: node["h"])[0:2]
