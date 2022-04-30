
Stoneacre - Used Car Import/Export - Technical Test 
This test assumes some familiarity with the concepts of the Laravel framework and that you are able to set up a basic installation and database of your choosing in order develop the solution necessary for this technical test. There are two main tasks within this technical test along with a number of optional tasks. You may choose to do any number of the optional tasks in order to showcase your ability, but the main two tasks must be completed. 
Before you get started you should set up a basic Laravel installation of Laravel 7 or higher. Once you have completed the test, please submit either a git repository link (somewhere such as github showing commit history) or zip the files up (not including the Vendor folder) and email to the recruiter who will forward them to us. 
Please also include any instructions you feel necessary in order to set up the project (such as in a read.me or readme.md file). 

Task 1 - Used Car Import Along with this Technical Test document you should have also received a stock data CSV file. Within it contains 500 vehicles that we want to import into our website's database. Start by taking some time to look through the data in the CSV file and understand its structure. 
1) Develop a set of Eloquent Models and Migrations that you feel best cater for the data provided. You do not have to fully normalise the data but you should be able to explain your reasoning. (For example each make should only be in the database once with a reference to that make.) 
2) Create a command that imports the CSV file into the database. Each row in the csv should be validated using the following criteria: 
	A Vehicle must have a Registration 
	A Vehicle must have at least 3 images 
	A Vehicle must have a price greater than zero 
3) Add an additional column to your stock data table that indicates if the car is available or not. If the DATE_ON_FORECOURT column is in the future or set to 0000-00-00 then the active column should be set to false. 
4) Generate an email report to show how many vehicles there were in the feed, how many imported successfully and how many failed. 

Task 2 - Ford Export A requirement has been made for an export of Ford Cars to one of our suppliers. Using the data imported in the first task create a separate command that will create a CSV file with the following columns: 
Registration Car Title - This should be a combined list of Make, Model and Derivative 
The price of the vehicle excluding VAT (set at 20%) 
The amount of VAT on the vehicle 
A single image for that vehicle The file should be saved as a date/time stamped file and then 
should be setup to FTP to a location specified in a configuration file (the credentials for which should be stored in the .env file).  

Additional Tasks 
	Enrich the report in Task 1 to add the reason(s) that a car failed to import. 
	Alter the import in Task 1 so that each line is placed in a queued job to import (so that potential jobs like image manipulation could be added to it). 
	Create Scopes on the Laravel models that make it easier to write queries (e.g. Active/Inactive stock, filtering by a vehicle type) 
	Write Unit Tests for the code you have produced in one or both of the two tasks.
