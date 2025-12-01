import random

BLUE = '\033[94m'
GREEN = '\033[92m'
YELLOW = '\033[93m'
RED = '\033[91m'
BOLD = '\033[1m'
END = '\033[0m'

mark = '='
print(BLUE + mark*50 + END)
print(BOLD + "      Welcome to a round of Guess that Word" + END)
print(GREEN + mark*50 + END)

def progress_bar(left:int, total: int) -> str:
    left = max(0, min(left, total))
    return f"[{'=' * left}{'-' * (total - left)}]"


# Pick a word from a text file
def word_picker(path="words.txt"):
    list_of_words = []
    try:
        with open(path, "r", encoding="utf-8") as f:
            for line in f:
                w = line.strip()
                if w and w.isalpha():
                    list_of_words.append(w.lower())
    except FileNotFoundError:
        print(f"{path} doesn't exist")
        list_of_words = ["blanket", "stingy", "apocalypse", "laughter", "sandwich"]
    if not list_of_words:
        list_of_words = ["blanket"]
    return list_of_words


# Function to update dashes as user enters their guess
def update_dashes(hidden, current_dashes, current_letter):
    locate = []
    for i in range (len(hidden)):
        if hidden[i] == current_letter:
            locate.append(current_letter)
        else:
            locate.append(current_dashes[i])
    return "".join(locate)


#gets user's guess
def get_guess(current_dashes, attempts_left, total_attempts):
    bar = progress_bar(attempts_left, total_attempts)

    print(BOLD + f"\nTry to find the secret word: {current_dashes}" + END)
    print(YELLOW + f"{bar} {attempts_left} guesses remaining" + END)
    while True:
        guess_letter = input("Guess the word: ")
        if len(guess_letter) != 1:
            print("Please enter a single letter")
            continue

        if not (guess_letter.islower() and guess_letter.isalpha()):
            print("Your guess must be a lowercase letter")
            continue
        return guess_letter

def start_game(words, attempts=10):
    #Starts the game
    secret_word = random.choice(words)
    dashes = '-' * len(secret_word)
    guesses_left = attempts
    duplicate = set()

    while dashes != secret_word and guesses_left > 0:
        letter = get_guess(dashes, guesses_left, attempts)

        if letter in duplicate:
            print(f"{letter} was already guessed")
            continue
        duplicate.add(letter)

        # classifying if the letter is in the secret word or not
        if letter in secret_word:
            print(GREEN + f"{letter} is in the word" + END)
            dashes = update_dashes(secret_word, dashes, letter)
        else:
            print(RED + f"{letter} is not in the word" + END)
            guesses_left -= 1


    if dashes == secret_word:
        print(BOLD + GREEN + "\nCongrats! You have revealed the secret word:" + END, GREEN + secret_word + END)
        return True
    else:
        print(BOLD + RED + "\nYou lose. The secret word was:" + END, RED + secret_word + END)
        return False

def play_again():
    #Asking user if they would like to play again
    while True:
        play = input(BOLD + "Would you like to play again? (y/n): " + END)
        if play in ("y", "yes"):
            return True
        elif play in ("n" or "no"):
            return False
        print(YELLOW + "Please enter y or n" + END)

def main():
    words = word_picker(path="words.txt")
    while True:
        start_game(words, attempts=10)
        if not play_again():
            print(BOLD + BLUE + "\nThank you for playing!" + END)
            break

if __name__ == "__main__":
    main()

