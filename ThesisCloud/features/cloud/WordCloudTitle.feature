Feature: Word cloud title 
	Users should be able to
	see the artist names that
	are initialized to the word cloud

	Scenario: REQ-1: Upon initialization, the label's text lists the name(s) of the artist(s) of the Word Cloud Title is initialized for, delimited by commas
		Given I am on the homepage
		When I select "Rebecca Black"
		And I press "Search"
		Then I am on the WordCloudPage
		And the header should contain “Rebecca Black"

	Scenario: REQ-1 (two artists): Upon initialization, the label's text lists the name(s) of the artist(s) of the Word Cloud Title is initialized for, delimited by commas
		Given I am on the WordCloudPage
		And the artists are: "Rebecca Black" and "Swedish House Mafia"
		And I press "Search"
		Then I am on the WordCloudPage
		And the header should contain “Rebecca Black, Swedish House Mafia”