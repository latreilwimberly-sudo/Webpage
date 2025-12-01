def hurricane_cat(x):
    cat = "0"
    if 39 <= x <= 73:
        cat = "0"
        print("A tropical storm is present")
    elif 74 <= x <= 95:
        cat = "1"
        print("Category: " + cat)
        print("Very dangerous winds will produce some damage")
    elif 96 <= x <= 110:
        cat = "2"
        print("Category: " + cat)
        print("Extremely dangerous winds will cause extensive damage")
    elif 111 <= x <= 129:
        cat = "3"
        print("Category: " + cat)
        print("Devastating damage will occur")
    elif 130 <= x <= 156:
        cat = "4"
        print("Category: " + cat)
        print("Catastrophic damage will occur")
    elif x >= 157:
        cat = "5"
        print("Category: " + cat)
        print("Catastrophic damage; high devastation")
    else:
        print("Not a topical storm or hurricane")
    return cat


if __name__ == '__main__':
    print("Saffir-Simpson Hurricane Scale:")
    print("The Saffir-Simpson Hurricane Scale is a 1-5 categorization based on the sustained wind speeds of a hurricane. "
          "It estimates potential property damage and flooding.")
    print("Category	 Wind Speed (mph)	Description")
    print("1	         74 – 95	        Very dangerous winds will produce some damage")
    print("2	         96 – 110	        Extremely dangerous winds will cause extensive damage")
    print("3	         111 – 129	        Devastating damage will occur")
    print("4	         130 – 156	        Catastrophic damage will occur")
    print("5	         157 or higher	    Catastrophic damage; high devastation")
    print("Tropical Storm: 39 – 73 mph")
    print("Below 39 mph: Not a tropical storm or hurricane")

    while True:
        speed = input("\nEnter wind speed or type q to quit: ")
        if speed.lower() == "q":
            print("Exiting...")
            break
        try:
            speed = int(speed)
            if speed < 0:
                print("Error: The wind speed must be positive")
            else:
                hurricane_cat(speed)
        except ValueError:
                print("Error: Invalid input. Please try again.")
