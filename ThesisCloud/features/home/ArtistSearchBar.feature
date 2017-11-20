Feature: Artist Search Bar
	In order to prove that the artist search bar works
	on the home page, we need to test that each of its
	features work as intentended. 

	Scenario: Navigate to homepage
		Given I am on the homepage
		Then I should see "SongCloud"
		And I should see an "input" element
		And I should see an "search" button

	Scenario: Autocomplete suggestions are not selected
		Given I am on the homepage
		Then the "input" element should contain ""
		And the search bar should have a state of no selection

	Scenario: Search box is editable
		Given I am on the homepage
		When I type "taylor" in the textbox
		Then I should see "taylor" in the search box

	Scenario: Editing the search box should reset to no selection state
		Given I am on the homepage
		When I type "taylor" in the textbox
		And the search bar should have a state of no selection

	Scenario: Typing in 3 characters should generate a list of autocomplete suggestions
		Given I am on the homepage
		And the search bar should have a state of no selection
		And there are more than 3 characters in the textbox
		Then I should see a drop down list

	Scenario: If the user clicks on an artist from the suggestions drop-down, the textbox should be updated to contain the exact name of the selected artist, and the Artist Search Bar should adopt a state of YES-SELECTION
		Given I am on the homepage
		When I type "taylor" in the textbox
		Then I should see a drop down list
		When I click "Taylor Swift"
		Then I should see "Taylor Swift" in the search box
		And the search bar should have a state of yes selection

	Scenario: REQ-5: The suggestions drop-down menu should contain at least 3 artists whose names are approximate matches for the text in the textbox.
		Given I am on the homepage
		When I type "taylor" in the textbox
		Then I should see a drop down list
		And the drop down suggestions should contain at least 3 artist names
		And the artist names should be similar to the text in the textbox

	Scenario: REQ-6: For each artist in the suggestions drop-down, a name and image should be displayed.
		Given I am on the homepage
		When I type "taylor" in the textbox
		Then I should see a drop down list
		And each entry should contain a name and an image
