WINING_BLOCKS = [set([0,1,2]), set([3,4,5]), set([6,7,8]), set([0,3,6]), set([1,4,7]), set([2,5,8]), set([0,4,8]), set([2,4,6])]

class Board:
    
    def __init__(self):
        self.tiles = ["_" for i in range(9)]

    def _computer_tiles(self):
        return [index for index, value in enumerate(self.tiles) if value == "O"]

    def _player_tiles(self):
        return [index for index, value in enumerate(self.tiles) if value == "X"]

    def moves(self):
        return [index for index, value in enumerate(self.tiles) if value == "_"]

    def done(self):
        return len(self.moves()) == 0 or not self.winner() is None

    def winner(self):
        player_tiles = set(self._player_tiles())
        for blocks in WINING_BLOCKS:
            if blocks.issubset(player_tiles):
                return -1
        computer_tiles = set(self._computer_tiles())
        for blocks in WINING_BLOCKS:
            if blocks.issubset(computer_tiles):
                return 1
        if len(player_tiles) + len(computer_tiles) == 9:
            return 0
        return None

    def change_tile(self, index, value):
        self.tiles[index] = value

    def show(self):
                print(self.tiles[0], end="")
                print(self.tiles[1], end="")
                print(self.tiles[2])
                print(self.tiles[3], end="")
                print(self.tiles[4], end="")
                print(self.tiles[5])
                print(self.tiles[6], end="")
                print(self.tiles[7], end="")
                print(self.tiles[8])
                print()

 
def opposite(player):
    if player == "O":
        return "X"
    else:
        return "O"


def minmax(board, player, alfa, beta):
    score = -2
    if (board.done()):
        score = board.winner()
        return score

    for move in board.moves():
        board.change_tile(move, player)
        score = minmax(board, opposite(player), alfa, beta)
        board.change_tile(move, "_")
        if player == "O":
            if score > alfa:
                alfa = score
            if alfa >= beta:
                return alfa
        else:
            if score < beta:
                beta = score
            if alfa >= beta:
                return beta
    if player == "O":
        return alfa
    else:
        return beta

def make_best_move(board):
    best_moves = []
    best_score = -2
    for move in board.moves():
        board.change_tile(move, "O")
        value = minmax(board, "X", -2, 2)
        board.change_tile(move, "_")
        if value == best_score:
            best_moves.append(move)
        elif value > best_score:
            best_moves = [move]
            best_score = value
    return best_moves[0]

def game():
    board = Board()
    while(not board.done()):
        move = int(input("Select index(0-8)"))
        board.change_tile(move, "X")
        board.show()
        if not board.done():
            board.change_tile(make_best_move(board),"O")
            board.show()
    if (board.winner() == -1):
        print("Congratulations! You won.")
    elif (board.winner() == 0):
        print("You are tied. ")
    else:
        print("You lost.")
