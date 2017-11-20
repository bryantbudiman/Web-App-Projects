Feature: Add Button
	In order to prove that the add button works
	on the cloud page, we need to test that each of its
	pieces work as intentended. 

	Scenario: REQ-1: The Add Button is clickable if and only if the Artist Search Bar has a state of YES-SELECTION.
		Given I am on the WordCloudPage
		When I type "Taylor Swift" in the textbox
		And the search bar should have a state of no selection
		And I press "addToCloudButton"
		Then the word cloud state does not change

	Scenario: REQ-2: Upon clicking the Add Button, the artist selected in the Artist Search Bar is added to the Word Cloud Title.
		Given I am on the WordCloudPage
		And the header should contain “Taylor Swift”
		When I type "Justin Bieber" in the textbox
		And I press "addToCloudButton"
		Then the header should contain “Taylor Swift Justin Bieber”

	Scenario: REQ-3: Upon clicking the Add Button, the artist selected in the Artist Search Bar is added to the Word Cloud.
		Given I am on the WordCloudPage
		When I type "Justin Bieber" in the textbox
		And I press "addToCloudButton"
		Then the lyrics of the artist should be added to the Word Cloud 