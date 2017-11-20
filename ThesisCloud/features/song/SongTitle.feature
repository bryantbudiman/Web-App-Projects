Feature: Song List
	In order to prove that the song list works
	on the cloud page, we need to test that each of its
	pieces work as intentended. 

	Scenario: REQ-1: The label’s text consists of the title of the song and the artist’s name, in the format “SONG-TITLE by ARTIST-NAME”.
		Given I am on SongListPage
		And the "artist" is "Taylor Swift"
		And the "word" is "MIDNIGHT"
		And I press the song “STYLE (1)”
		Then I am on LyricsPage
		And the header should contain “Style by Taylor Swift”

	Scenario: REQ-1: The label’s text consists of the word (that was selected by the user) used to initialize the Song List Page.
		Given I am on the WordCloudPage
		And the header should contain “Taylor Swift”
		When I click word “walking” from the cloud
		Then I am on SongListPage
		And the header should contain “WALKING”