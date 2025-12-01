def min_max_calculate(filename):
    try:
        # Read numbers from a file
        with open(filename,'r') as file:
            numbers = [float(line.strip()) for line in file.readlines()]

            #check for 5 numbers
            if len(numbers) != 5:
                print("\n Error: The file must contain 5 numbers only")
                return

        #calculate min and max
        min = min()