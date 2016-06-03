import random
import time

def min_conflicts(n):
    start = time.time()
    iterations = 0
    while True:
        iterations += 1
        #save only position of the queen
        board = create_random_board(n)
        max_steps = n * 10
        last_boards = [board]
        for i in range(max_steps):
            #find colums in which queens are under attack
            conflict_rows = find_conflicts(board)
            if len(conflict_rows) == 0:
                print_board(board)
                return
                
            #select random conflict row
            row = random.choice(conflict_rows)
            
            #generate conflicts
            conflicts = [number_of_conflicts(board, row, col) for col in range(n)]
            
            #select the mininal number of conflicts
            least_conflicts = min(conflicts)
            
            #move the queen a space with least conflicts
            if conflicts[board[row]] > least_conflicts:
                board[row] = random.choice([i for i in range(n) if conflicts[i]
                                            == least_conflicts])



def create_random_board(n):
    board = list(range(n))
    random.shuffle(board)
    return board


def number_of_conflicts(board, row, col):
    conflicts = 0
    for r in range(len(board)):
        if (r != row and (board[r] == col or abs(r - row) == abs(board[r] - col))):
            conflicts += 1
    return conflicts


def find_conflicts(board):
    return [row for row in range(len(board)) if number_of_conflicts(board, row, board[row]) > 0]


def print_board(board):
    n = len(board)
    for row in board:
        print("_" * row, end="")
        print("Q", end="")
        print("_"* (n - row - 1))
