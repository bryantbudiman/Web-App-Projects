Feature: Search Button
	In order to prove that the search button works
	on the home page, we need to test that each of its
	features work as intentended. 

Scenario: REQ-1 Click the search button when Artist Search Bar has a state of NO-SELECTION
	Given I am on the homepage
	When I fill in "artist_name" with "taylor"
	Then the search bar should have a state of no selection
	When I press "Search"
	Then the search button is not clickable

Scenario: REQ-1 and REQ-2: The button is clickable if and only if the Artist Search Bar has a state of YES-SELECTION
	Given I am on the homepage
	When I fill in "artist_name" with "Taylor Swift"
	Then the search bar should have a state of yes selection
	Then the search button is clickable

Scenario: REQ-3: On the Word Cloud Page which is navigated to, the Word Cloud Title and Word Cloud are initialized with Rebecca Black as described in those features requirements
	Given I am on the homepage
	When I fill in "artist_name" with "Rebecca Black"
	And the search bar should have a state of yes selection
	When I press "Search"
	Then the word cloud shows "250" most frequent words used by "Rebecca Black"

Scenario: REQ-3: On the Word Cloud Page which is navigated to, the Word Cloud Title and Word Cloud are initialized with the Swedish House Mafia as described in those features requirements
	Given I am on the homepage
	When I fill in "artist_name" with "Swedish House Mafia"
	And the search bar should have a state of yes selection
	When I press "Search"
	Then the word cloud shows "250" most frequent words used by "Swedish House Mafia"	