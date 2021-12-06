#   Web application for selling bus tickets online
*   Ability to register and log in with four levels of access for admin, regular user, super user and companies
*   Login and registration with laravel passport package implemented
*   Companies have a user panel with the following features:
    *   Create a vehicle in the system and record its specifications
    *   Record and edit the date and time of trips of a specific vehicle along with the origin and destination
    *   Edit vehicle specifications
    *   Archiving the vehicle
*   Landing page
    *   Return site introduction text
    *   Return the company's comments randomly
    *   Return information of a number of contracting passenger companies
*   Ticket reservation operation
    *   View the list of buses with the origin and destination of the user on the day selected by the user
    *   Show full and empty seats according to the gender of the passenger by clicking on each of the buses
    *   In the voice where the user is a member of the site and is logged in, the selected seats are temporarily reserved for him for 15 minutes.
    *   Payment receipts are displayed to the user based on the number of passengers and the cost of the tickets
    *   After confirming the receipt, it is transferred to the payment portal and returns to the website after payment
    *   The travel ticket is displayed to the user after completing the transaction
    *   The ticket is emailed to the user
