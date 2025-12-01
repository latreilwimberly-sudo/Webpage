def min_max_numbers(numbers):
    # This function takes the list and prints the min and max
    print(f"The minimum number is {min(numbers)}: ")
    print(f"The maximum number is {max(numbers)}: ")


def num_read(path="numbers.txt"):
    numbers = []
    try:
        with open(path, 'r', encoding='utf-8') as f:
            for line in f:
                w = line.strip()
                numbers.append(int(w))
    except FileNotFoundError:
        print(f"{path} does not exist")

    return numbers

if __name__ == '__main__':
    while True:
        count = input("\nHow many numbers will you input? or type q to quit: ")
        if count.lower() == 'q':
            print("\nExiting the program")
            break
        try:
            count = num_read("numbers.txt")
            #count = int(count)
            if count == 0:
                #print("Please enter a number greater than zero.")
                continue

            #Takes in user desired amount of numbers and inserts the numbers into a list
           # num_list = []
            #for i in range(1, count + 1):
                #while True:
                  #  try:
                    #    num_request = float(input(f"Enter number {i}: "))
                      #  num_list.append(num_request)
                      #  break
                   # except ValueError:
                     #   print("Invalid input. Please enter a valid number.")

            min_max_numbers(count)
            for num in count:
                print(count)

        except ValueError:
            print("Invalid input. Please enter a number greater than zero or q to quit")
